<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Actions\TestsActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\TestExtras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

// use App\Repository\prod\TestsRepository;


class TestController extends Controller
{

    private $TestsRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\TestsRepository $TestsRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {


    }

    public function agGridData(Request $request)
    {
        $newFilter = $request->get('filterModel', []);
        $extras = $request->get('__extras__', []);
        if (!empty($extras['baseFilter']) && is_array($extras['baseFilter'])) {
            $oldFilter = $request->get('filterModel', []);
            $newFilter = array_merge($oldFilter, $extras['baseFilter']);
        }
        $request->merge(['filterModel' => $newFilter]);
        $query = Test::query();
        if (!empty($extras['filterFields']) && is_array($extras['filterFields']) && !empty($extras['globalSearch'])) {
            $query->where(function ($q1) use ($extras) {

                foreach ($extras['filterFields'] as $key => $ex) {
                    $value = "%" . $extras['globalSearch'] . "%";
                    if ($key == 0) {

                        $q1->where($ex, "LIKE", $value);
                    } else {
                        $q1->orWhere($ex, "LIKE", $value);
                    }

                }

            });


        }
        if (
            class_exists('\App\Http\Extras\TestExtras') &&
            method_exists('\App\Http\Extras\TestExtras', 'filterAgGridQuery')
        ) {
            TestExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('tests', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\TestExtras') &&
            method_exists('\App\Http\Extras\TestExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = TestExtras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
            $data['rowData'] = $_d;
            $data['rowData'] = $_d;
            if ($_d->count() > $data['rowCount']) {

                if ($_d->count() > $data['rowCount']) {
                    $data['rowCount'] = $_d->count();
                }
            }
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function data(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
        $old = $request->all();
        $filter = [];
        if (array_key_exists('filter', $old)) {
            $filter = $old['filter'];

        }
        $filter[$key] = $val;
        $request->merge(['filter' => $filter]);

        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json(Test::count());
        }
        $data = QueryBuilder::for(Test::class)
            ->allowedFilters([
                AllowedFilter::exact('transactions_totals'),


                AllowedFilter::exact('transactions_heures'),


                AllowedFilter::exact('transactions_id'),


                AllowedFilter::exact('matricule'),


                AllowedFilter::exact('date'),


                AllowedFilter::callback('not_null', function (Builder $query, $value) {
//                    dump($value);

                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }
                    foreach ($value as $val) {
                        $query->whereNotNull($val);

                    }


                    return $query;
                }),
                AllowedFilter::callback('null', function (Builder $query, $value) {
//                    dump($value);
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }


                    foreach ($value as $val) {
                        $query->whereNull($val);

                    }


                    return $query;
                }),
                AllowedFilter::callback('date', function (Builder $query, $value) {
//                    dd($value);


                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }
                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 3) {
                            if ($dat[1] != 'like') {
                                $query->where($dat[0], $dat[1], Carbon::parse($dat[2]));

                            } else {

                                $query->where($dat[0], "LIKE", "%" . $dat[2] . "%");
                            }
//                                dd($dat,$dat[0],Carbon::parse($dat[2]));

                        }

                    }


                    return $query;
                }),

                AllowedFilter::callback('like', function (Builder $query, $value) {
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }

                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 2) {
                            $query->where($dat[0], "LIKE", "%" . $dat[1] . "%");

                        }

                    }


                    return $query;
                }),
                AllowedFilter::callback('where', function (Builder $query, $value) {
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }

                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 3) {
                            $query->where($dat[0], $dat[1], $dat[2]);

                        }

                    }


                    return $query;
                }),
            ])
            ->allowedSorts([
                AllowedSort::field('transactions_totals'),


                AllowedSort::field('transactions_heures'),


                AllowedSort::field('transactions_id'),


                AllowedSort::field('matricule'),


                AllowedSort::field('date'),


            ])
            ->allowedIncludes([

            ]);

        if (!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"] == 1) {
            $data = $data->paginate(isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20);
        } else {
            $data = $data->get();
        }
        $donnees = $data->toArray();


        if (!empty($donnees['data']) && is_array($donnees['data'])) {
            $new = [];
            foreach ($donnees['data'] as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
                $new[] = $response;
            }
            $donnees['data'] = $new;
        } else {

            foreach ($donnees as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
            }
        }


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function data1(Request $request)
    {


        $data = QueryBuilder::for(Test::class)
            ->allowedFilters([
                AllowedFilter::exact('transactions_totals'),


                AllowedFilter::exact('transactions_heures'),


                AllowedFilter::exact('transactions_id'),


                AllowedFilter::exact('matricule'),


                AllowedFilter::exact('date'),


                AllowedFilter::callback('not_null', function (Builder $query, $value) {
//                    dump($value);

                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }
                    foreach ($value as $val) {
                        $query->whereNotNull($val);

                    }


                    return $query;
                }),
                AllowedFilter::callback('null', function (Builder $query, $value) {
//                    dump($value);
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }


                    foreach ($value as $val) {
                        $query->whereNull($val);

                    }


                    return $query;
                }),
                AllowedFilter::callback('date', function (Builder $query, $value) {
//                    dd($value);


                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }
                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 3) {
                            if ($dat[1] != 'like') {
                                $query->where($dat[0], $dat[1], Carbon::parse($dat[2]));

                            } else {

                                $query->where($dat[0], "LIKE", "%" . $dat[2] . "%");
                            }
//                                dd($dat,$dat[0],Carbon::parse($dat[2]));

                        }

                    }


                    return $query;
                }),

                AllowedFilter::callback('like', function (Builder $query, $value) {
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }

                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 2) {
                            $query->where($dat[0], "LIKE", "%" . $dat[1] . "%");

                        }

                    }


                    return $query;
                }),
                AllowedFilter::callback('where', function (Builder $query, $value) {
                    if (!is_array($value)) {
                        $value = explode(',', $value);
                    }

                    foreach ($value as $val) {
                        $dat = explode('/', $val);
                        if (count($dat) == 3) {
                            $query->where($dat[0], $dat[1], $dat[2]);

                        }

                    }


                    return $query;
                }),
            ])
            ->allowedSorts([
                AllowedSort::field('transactions_totals'),


                AllowedSort::field('transactions_heures'),


                AllowedSort::field('transactions_id'),


                AllowedSort::field('matricule'),


                AllowedSort::field('date'),


            ])
            ->allowedIncludes([
            ]);

        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json($data->count());
        }

        if (!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"] == 1) {
            $data = $data->paginate(isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20);
        } else {
            $data = $data->get();
        }
        $donnees = $data->toArray();


        if (!empty($donnees['data']) && is_array($donnees['data'])) {
            $new = [];
            foreach ($donnees['data'] as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
                $new[] = $response;
            }
            $donnees['data'] = $new;
        } else {

            foreach ($donnees as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
            }
        }


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


    public function create(Request $request, Test $Tests)
    {


        try {
            $can = Helpers::can('Creer des tests');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "tests" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'transactions_totals',
            'transactions_heures',
            'transactions_id',
            'matricule',
            'date',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'transactions_totals' => [
                //'required'
            ],


            'transactions_heures' => [
                //'required'
            ],


            'transactions_id' => [
                //'required'
            ],


            'matricule' => [
                //'required'
            ],


            'date' => [
                //'required'
            ],


        ], $messages = [


            'transactions_totals' => ['cette donnee est obligatoire'],


            'transactions_heures' => ['cette donnee est obligatoire'],


            'transactions_id' => ['cette donnee est obligatoire'],


            'matricule' => ['cette donnee est obligatoire'],


            'date' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['transactions_totals'])) {

            $Tests->transactions_totals = $data['transactions_totals'];

        }


        if (!empty($data['transactions_heures'])) {

            $Tests->transactions_heures = $data['transactions_heures'];

        }


        if (!empty($data['transactions_id'])) {

            $Tests->transactions_id = $data['transactions_id'];

        }


        if (!empty($data['matricule'])) {

            $Tests->matricule = $data['matricule'];

        }


        if (!empty($data['date'])) {

            $Tests->date = $data['date'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Tests->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\TestExtras') &&
            method_exists('\App\Http\Extras\TestExtras', 'beforeSaveCreate')
        ) {
            TestExtras::beforeSaveCreate($request, $Tests);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\TestExtras') &&
            method_exists('\App\Http\Extras\TestExtras', 'canCreate')
        ) {
            try {
                $canSave = TestExtras::canCreate($request, $Tests);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Tests->save();
        } else {
            return response()->json($Tests, 200);
        }

        $Tests = Test::find($Tests->id);
        $newCrudData = [];

        $newCrudData['transactions_totals'] = $Tests->transactions_totals;
        $newCrudData['transactions_heures'] = $Tests->transactions_heures;
        $newCrudData['transactions_id'] = $Tests->transactions_id;
        $newCrudData['matricule'] = $Tests->matricule;
        $newCrudData['date'] = $Tests->date;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Tests', 'entite_cle' => $Tests->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Tests->toArray();


        try {

            foreach ($Tests->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (Throwable $e) {
        }


        return response()->json($response, 200);


    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */


    public function update(Request $request, Test $Tests)
    {
        try {
            $can = Helpers::can('Editer des tests');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['transactions_totals'] = $Tests->transactions_totals;
        $oldCrudData['transactions_heures'] = $Tests->transactions_heures;
        $oldCrudData['transactions_id'] = $Tests->transactions_id;
        $oldCrudData['matricule'] = $Tests->matricule;
        $oldCrudData['date'] = $Tests->date;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "tests" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'transactions_totals',
            'transactions_heures',
            'transactions_id',
            'matricule',
            'date',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'transactions_totals' => [
                //'required'
            ],


            'transactions_heures' => [
                //'required'
            ],


            'transactions_id' => [
                //'required'
            ],


            'matricule' => [
                //'required'
            ],


            'date' => [
                //'required'
            ],


        ], $messages = [


            'transactions_totals' => ['cette donnee est obligatoire'],


            'transactions_heures' => ['cette donnee est obligatoire'],


            'transactions_id' => ['cette donnee est obligatoire'],


            'matricule' => ['cette donnee est obligatoire'],


            'date' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("transactions_totals", $data)) {


            if (!empty($data['transactions_totals'])) {

                $Tests->transactions_totals = $data['transactions_totals'];

            }

        }


        if (array_key_exists("transactions_heures", $data)) {


            if (!empty($data['transactions_heures'])) {

                $Tests->transactions_heures = $data['transactions_heures'];

            }

        }


        if (array_key_exists("transactions_id", $data)) {


            if (!empty($data['transactions_id'])) {

                $Tests->transactions_id = $data['transactions_id'];

            }

        }


        if (array_key_exists("matricule", $data)) {


            if (!empty($data['matricule'])) {

                $Tests->matricule = $data['matricule'];

            }

        }


        if (array_key_exists("date", $data)) {


            if (!empty($data['date'])) {

                $Tests->date = $data['date'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Tests->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\TestExtras') &&
            method_exists('\App\Http\Extras\TestExtras', 'beforeSaveUpdate')
        ) {
            TestExtras::beforeSaveUpdate($request, $Tests);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\TestExtras') &&
            method_exists('\App\Http\Extras\TestExtras', 'canUpdate')
        ) {
            try {
                $canSave = TestExtras::canUpdate($request, $Tests);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Tests->save();
        } else {
            return response()->json($Tests, 200);

        }


        $Tests = Test::find($Tests->id);


        $newCrudData = [];

        $newCrudData['transactions_totals'] = $Tests->transactions_totals;
        $newCrudData['transactions_heures'] = $Tests->transactions_heures;
        $newCrudData['transactions_id'] = $Tests->transactions_id;
        $newCrudData['matricule'] = $Tests->matricule;
        $newCrudData['date'] = $Tests->date;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Tests', 'entite_cle' => $Tests->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Tests->toArray();


        try {

            foreach ($Tests->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (Throwable $e) {
        }


        return response()->json($response, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, Test $Tests)
    {
        try {
            $can = Helpers::can('Supprimer des tests');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['transactions_totals'] = $Tests->transactions_totals;
        $newCrudData['transactions_heures'] = $Tests->transactions_heures;
        $newCrudData['transactions_id'] = $Tests->transactions_id;
        $newCrudData['matricule'] = $Tests->matricule;
        $newCrudData['date'] = $Tests->date;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Tests', 'entite_cle' => $Tests->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\TestExtras') &&
            method_exists('\App\Http\Extras\TestExtras', 'canDelete')
        ) {
            try {
                $canSave = TestExtras::canDelete($request, $Tests);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Tests->delete();
        } else {
            return response()->json($Tests, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new TestsActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
