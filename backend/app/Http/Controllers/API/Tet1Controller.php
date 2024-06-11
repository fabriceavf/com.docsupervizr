<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Actions\Test1Actions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\Tet1Extras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\Tet1;
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

// use App\Repository\prod\Test1Repository;


class Tet1Controller extends Controller
{

    private $Test1Repository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\Test1Repository $Test1Repository
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
        $query = Tet1::query();
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
            class_exists('\App\Http\Extras\Tet1Extras') &&
            method_exists('\App\Http\Extras\Tet1Extras', 'filterAgGridQuery')
        ) {
            Tet1Extras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('test1', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\Tet1Extras') &&
            method_exists('\App\Http\Extras\Tet1Extras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = Tet1Extras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
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
            return response()->json(Tet1::count());
        }
        $data = QueryBuilder::for(Tet1::class)
            ->allowedFilters([
                AllowedFilter::exact('pointage'),


                AllowedFilter::exact('debut_prevu'),


                AllowedFilter::exact('fin_revu'),


                AllowedFilter::exact('programme_id'),


                AllowedFilter::exact('user_id'),


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
                AllowedSort::field('pointage'),


                AllowedSort::field('debut_prevu'),


                AllowedSort::field('fin_revu'),


                AllowedSort::field('programme_id'),


                AllowedSort::field('user_id'),


            ])
            ->allowedIncludes([

                'programme',


                'user',


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


        $data = QueryBuilder::for(Tet1::class)
            ->allowedFilters([
                AllowedFilter::exact('pointage'),


                AllowedFilter::exact('debut_prevu'),


                AllowedFilter::exact('fin_revu'),


                AllowedFilter::exact('programme_id'),


                AllowedFilter::exact('user_id'),


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
                AllowedSort::field('pointage'),


                AllowedSort::field('debut_prevu'),


                AllowedSort::field('fin_revu'),


                AllowedSort::field('programme_id'),


                AllowedSort::field('user_id'),


            ])
            ->allowedIncludes([
                'programme',


                'user',


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


    public function create(Request $request, Tet1 $Test1)
    {


        try {
            $can = Helpers::can('Creer des test1');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "test1" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'pointage',
            'debut_prevu',
            'fin_revu',
            'programme_id',
            'user_id',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'pointage' => [
                //'required'
            ],


            'debut_prevu' => [
                //'required'
            ],


            'fin_revu' => [
                //'required'
            ],


            'programme_id' => [
                //'required'
            ],


        ], $messages = [


            'pointage' => ['cette donnee est obligatoire'],


            'debut_prevu' => ['cette donnee est obligatoire'],


            'fin_revu' => ['cette donnee est obligatoire'],


            'programme_id' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['pointage'])) {

            $Test1->pointage = $data['pointage'];

        }


        if (!empty($data['debut_prevu'])) {

            $Test1->debut_prevu = $data['debut_prevu'];

        }


        if (!empty($data['fin_revu'])) {

            $Test1->fin_revu = $data['fin_revu'];

        }


        if (!empty($data['programme_id'])) {

            $Test1->programme_id = $data['programme_id'];

        }


        if (!empty($data['user_id'])) {

            $Test1->user_id = $data['user_id'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Test1->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\Tet1Extras') &&
            method_exists('\App\Http\Extras\Tet1Extras', 'beforeSaveCreate')
        ) {
            Tet1Extras::beforeSaveCreate($request, $Test1);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tet1Extras') &&
            method_exists('\App\Http\Extras\Tet1Extras', 'canCreate')
        ) {
            try {
                $canSave = Tet1Extras::canCreate($request, $Test1);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Test1->save();
        } else {
            return response()->json($Test1, 200);
        }

        $Test1 = Tet1::find($Test1->id);
        $newCrudData = [];

        $newCrudData['pointage'] = $Test1->pointage;
        $newCrudData['debut_prevu'] = $Test1->debut_prevu;
        $newCrudData['fin_revu'] = $Test1->fin_revu;
        $newCrudData['programme_id'] = $Test1->programme_id;
        $newCrudData['user_id'] = $Test1->user_id;

        try {
            $newCrudData['programme'] = $Test1->programme->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Test1->user->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Test1', 'entite_cle' => $Test1->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Test1->toArray();


        try {

            foreach ($Test1->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Tet1 $Test1)
    {
        try {
            $can = Helpers::can('Editer des test1');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['pointage'] = $Test1->pointage;
        $oldCrudData['debut_prevu'] = $Test1->debut_prevu;
        $oldCrudData['fin_revu'] = $Test1->fin_revu;
        $oldCrudData['programme_id'] = $Test1->programme_id;
        $oldCrudData['user_id'] = $Test1->user_id;

        try {
            $oldCrudData['programme'] = $Test1->programme->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $Test1->user->Selectlabel;
        } catch (Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "test1" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'pointage',
            'debut_prevu',
            'fin_revu',
            'programme_id',
            'user_id',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'pointage' => [
                //'required'
            ],


            'debut_prevu' => [
                //'required'
            ],


            'fin_revu' => [
                //'required'
            ],


            'programme_id' => [
                //'required'
            ],


        ], $messages = [


            'pointage' => ['cette donnee est obligatoire'],


            'debut_prevu' => ['cette donnee est obligatoire'],


            'fin_revu' => ['cette donnee est obligatoire'],


            'programme_id' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("pointage", $data)) {


            if (!empty($data['pointage'])) {

                $Test1->pointage = $data['pointage'];

            }

        }


        if (array_key_exists("debut_prevu", $data)) {


            if (!empty($data['debut_prevu'])) {

                $Test1->debut_prevu = $data['debut_prevu'];

            }

        }


        if (array_key_exists("fin_revu", $data)) {


            if (!empty($data['fin_revu'])) {

                $Test1->fin_revu = $data['fin_revu'];

            }

        }


        if (array_key_exists("programme_id", $data)) {


            if (!empty($data['programme_id'])) {

                $Test1->programme_id = $data['programme_id'];

            }

        }


        if (array_key_exists("user_id", $data)) {


            if (!empty($data['user_id'])) {

                $Test1->user_id = $data['user_id'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Test1->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\Tet1Extras') &&
            method_exists('\App\Http\Extras\Tet1Extras', 'beforeSaveUpdate')
        ) {
            Tet1Extras::beforeSaveUpdate($request, $Test1);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tet1Extras') &&
            method_exists('\App\Http\Extras\Tet1Extras', 'canUpdate')
        ) {
            try {
                $canSave = Tet1Extras::canUpdate($request, $Test1);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Test1->save();
        } else {
            return response()->json($Test1, 200);

        }


        $Test1 = Tet1::find($Test1->id);


        $newCrudData = [];

        $newCrudData['pointage'] = $Test1->pointage;
        $newCrudData['debut_prevu'] = $Test1->debut_prevu;
        $newCrudData['fin_revu'] = $Test1->fin_revu;
        $newCrudData['programme_id'] = $Test1->programme_id;
        $newCrudData['user_id'] = $Test1->user_id;

        try {
            $newCrudData['programme'] = $Test1->programme->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Test1->user->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Test1', 'entite_cle' => $Test1->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Test1->toArray();


        try {

            foreach ($Test1->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Tet1 $Test1)
    {
        try {
            $can = Helpers::can('Supprimer des test1');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['pointage'] = $Test1->pointage;
        $newCrudData['debut_prevu'] = $Test1->debut_prevu;
        $newCrudData['fin_revu'] = $Test1->fin_revu;
        $newCrudData['programme_id'] = $Test1->programme_id;
        $newCrudData['user_id'] = $Test1->user_id;

        try {
            $newCrudData['programme'] = $Test1->programme->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Test1->user->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Test1', 'entite_cle' => $Test1->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tet1Extras') &&
            method_exists('\App\Http\Extras\Tet1Extras', 'canDelete')
        ) {
            try {
                $canSave = Tet1Extras::canDelete($request, $Test1);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Test1->delete();
        } else {
            return response()->json($Test1, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new Test1Actions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
