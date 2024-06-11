<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Actions\ListingspostesActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\ListingsposteExtras;
use App\Models\Groupe;
use App\Models\Listingsposte;
use App\Models\ser;
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

// use App\Repository\prod\ListingspostesRepository;


class ListingsposteController extends Controller
{

    private $ListingspostesRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\ListingspostesRepository $ListingspostesRepository
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
        $query = Listingsposte::query();
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
            class_exists('\App\Http\Extras\ListingsposteExtras') &&
            method_exists('\App\Http\Extras\ListingsposteExtras', 'filterAgGridQuery')
        ) {
            ListingsposteExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('listingspostes', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\ListingsposteExtras') &&
            method_exists('\App\Http\Extras\ListingsposteExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = ListingsposteExtras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
            $data['rowData'] = $_d;

            if ($_d->count() > $data['rowCount']) {
                $data['rowCount'] = $_d->count();
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
            return response()->json(Listingsposte::count());
        }
        $data = QueryBuilder::for(Listingsposte::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('modelslisting_id'),


                AllowedFilter::exact('poste_id'),


                AllowedFilter::exact('etats'),


                AllowedFilter::exact('identifiants_sadge'),


                AllowedFilter::exact('creat_by'),


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
                AllowedSort::field('id'),


                AllowedSort::field('modelslisting_id'),


                AllowedSort::field('poste_id'),


                AllowedSort::field('etats'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([

                'modelslisting',


                'poste',


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


        $data = QueryBuilder::for(Listingsposte::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('modelslisting_id'),


                AllowedFilter::exact('poste_id'),


                AllowedFilter::exact('etats'),


                AllowedFilter::exact('identifiants_sadge'),


                AllowedFilter::exact('creat_by'),


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
                AllowedSort::field('id'),


                AllowedSort::field('modelslisting_id'),


                AllowedSort::field('poste_id'),


                AllowedSort::field('etats'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([
                'modelslisting',


                'poste',


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


    public function create(Request $request, Listingsposte $Listingspostes)
    {


        try {
            $can = Helpers::can('Creer des listingspostes');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "listingspostes" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'modelslisting_id',
            'poste_id',
            'etats',
            'created_at',
            'updated_at',
            'extra_attributes',
            'deleted_at',
            'identifiants_sadge',
            'creat_by',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'modelslisting_id' => [
                //'required'
            ],


            'poste_id' => [
                //'required'
            ],


            'etats' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'modelslisting_id' => ['cette donnee est obligatoire'],


            'poste_id' => ['cette donnee est obligatoire'],


            'etats' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['modelslisting_id'])) {

            $Listingspostes->modelslisting_id = $data['modelslisting_id'];

        }


        if (!empty($data['poste_id'])) {

            $Listingspostes->poste_id = $data['poste_id'];

        }


        if (!empty($data['etats'])) {

            $Listingspostes->etats = $data['etats'];

        }


        if (!empty($data['identifiants_sadge'])) {

            $Listingspostes->identifiants_sadge = $data['identifiants_sadge'];

        }


        if (!empty($data['creat_by'])) {

            $Listingspostes->creat_by = $data['creat_by'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Listingspostes->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\ListingsposteExtras') &&
            method_exists('\App\Http\Extras\ListingsposteExtras', 'beforeSaveCreate')
        ) {
            ListingsposteExtras::beforeSaveCreate($request, $Listingspostes);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ListingsposteExtras') &&
            method_exists('\App\Http\Extras\ListingsposteExtras', 'canCreate')
        ) {
            try {
                $canSave = ListingsposteExtras::canCreate($request, $Listingspostes);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Listingspostes->save();
        } else {
            return response()->json($Listingspostes, 200);
        }

        $Listingspostes = Listingsposte::find($Listingspostes->id);
        $newCrudData = [];

        $newCrudData['modelslisting_id'] = $Listingspostes->modelslisting_id;
        $newCrudData['poste_id'] = $Listingspostes->poste_id;
        $newCrudData['etats'] = $Listingspostes->etats;
        $newCrudData['identifiants_sadge'] = $Listingspostes->identifiants_sadge;
        $newCrudData['creat_by'] = $Listingspostes->creat_by;

        try {
            $newCrudData['modelslisting'] = $Listingspostes->modelslisting->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Listingspostes->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Listingspostes', 'entite_cle' => $Listingspostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Listingspostes->toArray();


        try {

            foreach ($Listingspostes->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Listingsposte $Listingspostes)
    {
        try {
            $can = Helpers::can('Editer des listingspostes');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['modelslisting_id'] = $Listingspostes->modelslisting_id;
        $oldCrudData['poste_id'] = $Listingspostes->poste_id;
        $oldCrudData['etats'] = $Listingspostes->etats;
        $oldCrudData['identifiants_sadge'] = $Listingspostes->identifiants_sadge;
        $oldCrudData['creat_by'] = $Listingspostes->creat_by;

        try {
            $oldCrudData['modelslisting'] = $Listingspostes->modelslisting->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['poste'] = $Listingspostes->poste->Selectlabel;
        } catch (Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "listingspostes" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'modelslisting_id',
            'poste_id',
            'etats',
            'created_at',
            'updated_at',
            'extra_attributes',
            'deleted_at',
            'identifiants_sadge',
            'creat_by',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'modelslisting_id' => [
                //'required'
            ],


            'poste_id' => [
                //'required'
            ],


            'etats' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'modelslisting_id' => ['cette donnee est obligatoire'],


            'poste_id' => ['cette donnee est obligatoire'],


            'etats' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("modelslisting_id", $data)) {


            if (!empty($data['modelslisting_id'])) {

                $Listingspostes->modelslisting_id = $data['modelslisting_id'];

            }

        }


        if (array_key_exists("poste_id", $data)) {


            if (!empty($data['poste_id'])) {

                $Listingspostes->poste_id = $data['poste_id'];

            }

        }


        if (array_key_exists("etats", $data)) {


            if (!empty($data['etats'])) {

                $Listingspostes->etats = $data['etats'];

            }

        }


        if (array_key_exists("identifiants_sadge", $data)) {


            if (!empty($data['identifiants_sadge'])) {

                $Listingspostes->identifiants_sadge = $data['identifiants_sadge'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Listingspostes->creat_by = $data['creat_by'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Listingspostes->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\ListingsposteExtras') &&
            method_exists('\App\Http\Extras\ListingsposteExtras', 'beforeSaveUpdate')
        ) {
            ListingsposteExtras::beforeSaveUpdate($request, $Listingspostes);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ListingsposteExtras') &&
            method_exists('\App\Http\Extras\ListingsposteExtras', 'canUpdate')
        ) {
            try {
                $canSave = ListingsposteExtras::canUpdate($request, $Listingspostes);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Listingspostes->save();
        } else {
            return response()->json($Listingspostes, 200);

        }


        $Listingspostes = Listingsposte::find($Listingspostes->id);


        $newCrudData = [];

        $newCrudData['modelslisting_id'] = $Listingspostes->modelslisting_id;
        $newCrudData['poste_id'] = $Listingspostes->poste_id;
        $newCrudData['etats'] = $Listingspostes->etats;
        $newCrudData['identifiants_sadge'] = $Listingspostes->identifiants_sadge;
        $newCrudData['creat_by'] = $Listingspostes->creat_by;

        try {
            $newCrudData['modelslisting'] = $Listingspostes->modelslisting->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Listingspostes->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Listingspostes', 'entite_cle' => $Listingspostes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Listingspostes->toArray();


        try {

            foreach ($Listingspostes->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Listingsposte $Listingspostes)
    {
        try {
            $can = Helpers::can('Supprimer des listingspostes');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['modelslisting_id'] = $Listingspostes->modelslisting_id;
        $newCrudData['poste_id'] = $Listingspostes->poste_id;
        $newCrudData['etats'] = $Listingspostes->etats;
        $newCrudData['identifiants_sadge'] = $Listingspostes->identifiants_sadge;
        $newCrudData['creat_by'] = $Listingspostes->creat_by;

        try {
            $newCrudData['modelslisting'] = $Listingspostes->modelslisting->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Listingspostes->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Listingspostes', 'entite_cle' => $Listingspostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ListingsposteExtras') &&
            method_exists('\App\Http\Extras\ListingsposteExtras', 'canDelete')
        ) {
            try {
                $canSave = ListingsposteExtras::canDelete($request, $Listingspostes);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Listingspostes->delete();
        } else {
            return response()->json($Listingspostes, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new ListingspostesActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
