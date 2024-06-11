<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Models\Groupe;
use App\Models\Identificateur;
use App\Models\ser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

// use App\Repository\prod\IdentificateursRepository;


class IdentificateurController extends Controller
{

    private $IdentificateursRepository;
    private $menu;


    /**
     * Return .
     * @param \Illuminate\Http\Request $request
     * @param App\Repository\prod\IdentificateursRepository $IdentificateursRepository
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
        $relationsWhenDataIsMutlipleHide = [];
        if (
            class_exists('\App\Http\Extras\IdentificateurExtras') &&
            method_exists('\App\Http\Extras\IdentificateurExtras', 'getRelationsApplyWhenUserCallMultipleData')
        ) {
            try {
                $relationsWhenDataIsMutlipleHide = \App\Http\Extras\IdentificateurExtras::getRelationsApplyWhenUserCallMultipleData($request);
            } catch (\Throwable) {
                $relationsWhenDataIsMutlipleHide = [];
            }
        }
        $query = Identificateur::withoutGlobalScope(SoftDeletingScope::class);

        if (count($relationsWhenDataIsMutlipleHide) > 0) {
            $query = $query->with($relationsWhenDataIsMutlipleHide);
        }

        if (!empty($extras['filterFields']) && is_array($extras['filterFields']) && !empty($extras['globalSearch'])) {
            $query->where(function ($q1) use ($extras) {

                foreach ($extras['filterFields'] as $key => $ex) {
                    $value = "%" . $extras['globalSearch'] . "%";
                    if ($key == 0) {

                        $q1->where($ex, "LIKE", $value);
                    } else {
                        $q1->orWhere($ex, "LIKE", $value);
                    }

                };

            });


        }
        if (
            class_exists('\App\Http\Extras\IdentificateurExtras') &&
            method_exists('\App\Http\Extras\IdentificateurExtras', 'filterAgGridQuery')
        ) {
            \App\Http\Extras\IdentificateurExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('identificateurs', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\IdentificateurExtras') &&
            method_exists('\App\Http\Extras\IdentificateurExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = \App\Http\Extras\IdentificateurExtras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
            $data['rowData'] = $_d;

            if ($_d->count() > $data['rowCount']) {
                $data['rowCount'] = $_d->count();
            }
        }
        try {
            \Illuminate\Support\Facades\DB::table('surveillances')->insert([
                'user_id' => Auth::id(),
                'action' => 'Lectures des donnees api de  identificateurs reussi',
                'ip' => 'Non defini',
                'pays' => 'Non defini',
                'ville' => 'Non defini',
                'navigateur' => $request->header('User-Agent'),
                'created_at' => now(),
            ]);

        } catch (\Throwable) {

        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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
            return response()->json(Identificateur::count());
        }
        $data = QueryBuilder::for(Identificateur::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('carte_id'),


                AllowedFilter::exact('date_debut'),


                AllowedFilter::exact('date_fin'),


                AllowedFilter::exact('statuts'),


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


                AllowedSort::field('user_id'),


                AllowedSort::field('carte_id'),


                AllowedSort::field('date_debut'),


                AllowedSort::field('date_fin'),


                AllowedSort::field('statuts'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([
                'transactions',


                'carte',


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
                } catch (\Throwable $e) {

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
                } catch (\Throwable $e) {

                }
            }
        }


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function data1(Request $request)
    {


        $data = QueryBuilder::for(Identificateur::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('carte_id'),


                AllowedFilter::exact('date_debut'),


                AllowedFilter::exact('date_fin'),


                AllowedFilter::exact('statuts'),


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


                AllowedSort::field('user_id'),


                AllowedSort::field('carte_id'),


                AllowedSort::field('date_debut'),


                AllowedSort::field('date_fin'),


                AllowedSort::field('statuts'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([
                'transactions',


                'carte',


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
                } catch (\Throwable $e) {

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
                } catch (\Throwable $e) {

                }
            }
        }


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


    public function create(Request $request, Identificateur $Identificateurs)
    {


        try {
            $can = \App\Helpers\Helpers::can('Creer des identificateurs');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "identificateurs" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'user_id',
            'carte_id',
            'date_debut',
            'date_fin',
            'statuts',
            'creat_by',
            'extra_attributes',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'carte_id' => [
                //'required'
            ],


            'date_debut' => [
                //'required'
            ],


            'date_fin' => [
                //'required'
            ],


            'statuts' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'carte_id' => ['cette donnee est obligatoire'],


            'date_debut' => ['cette donnee est obligatoire'],


            'date_fin' => ['cette donnee est obligatoire'],


            'statuts' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['user_id'])) {

            $Identificateurs->user_id = $data['user_id'];

        }


        if (!empty($data['carte_id'])) {

            $Identificateurs->carte_id = $data['carte_id'];

        }


        if (!empty($data['date_debut'])) {

            $Identificateurs->date_debut = $data['date_debut'];

        }


        if (!empty($data['date_fin'])) {

            $Identificateurs->date_fin = $data['date_fin'];

        }


        if (!empty($data['statuts'])) {

            $Identificateurs->statuts = $data['statuts'];

        }


        if (!empty($data['creat_by'])) {

            $Identificateurs->creat_by = $data['creat_by'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Identificateurs->extra_attributes["extra-data"] = $dat;


        } catch (\Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\IdentificateurExtras') &&
            method_exists('\App\Http\Extras\IdentificateurExtras', 'beforeSaveCreate')
        ) {
            \App\Http\Extras\IdentificateurExtras::beforeSaveCreate($request, $Identificateurs);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\IdentificateurExtras') &&
            method_exists('\App\Http\Extras\IdentificateurExtras', 'canCreate')
        ) {
            try {
                $canSave = \App\Http\Extras\IdentificateurExtras::canCreate($request, $Identificateurs);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $Identificateurs->save();
        } else {
            return response()->json($Identificateurs, 200);
        }

        $Identificateurs = Identificateur::find($Identificateurs->id);
        $newCrudData = [];

        $newCrudData['user_id'] = $Identificateurs->user_id;
        $newCrudData['carte_id'] = $Identificateurs->carte_id;
        $newCrudData['date_debut'] = $Identificateurs->date_debut;
        $newCrudData['date_fin'] = $Identificateurs->date_fin;
        $newCrudData['statuts'] = $Identificateurs->statuts;
        $newCrudData['creat_by'] = $Identificateurs->creat_by;

        try {
            $newCrudData['carte'] = $Identificateurs->carte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Identificateurs->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('surveillances')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Identificateurs', 'entite_cle' => $Identificateurs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Identificateurs->toArray();


        try {

            foreach ($Identificateurs->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (\Throwable $e) {
        }


        return response()->json($response, 200);


    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, Identificateur $Identificateurs)
    {
        try {
            $can = \App\Helpers\Helpers::can('Editer des identificateurs');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['user_id'] = $Identificateurs->user_id;
        $oldCrudData['carte_id'] = $Identificateurs->carte_id;
        $oldCrudData['date_debut'] = $Identificateurs->date_debut;
        $oldCrudData['date_fin'] = $Identificateurs->date_fin;
        $oldCrudData['statuts'] = $Identificateurs->statuts;
        $oldCrudData['creat_by'] = $Identificateurs->creat_by;

        try {
            $oldCrudData['carte'] = $Identificateurs->carte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $Identificateurs->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "identificateurs" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'user_id',
            'carte_id',
            'date_debut',
            'date_fin',
            'statuts',
            'creat_by',
            'extra_attributes',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'carte_id' => [
                //'required'
            ],


            'date_debut' => [
                //'required'
            ],


            'date_fin' => [
                //'required'
            ],


            'statuts' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'carte_id' => ['cette donnee est obligatoire'],


            'date_debut' => ['cette donnee est obligatoire'],


            'date_fin' => ['cette donnee est obligatoire'],


            'statuts' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("user_id", $data)) {


            if (!empty($data['user_id'])) {

                $Identificateurs->user_id = $data['user_id'];

            }

        }


        if (array_key_exists("carte_id", $data)) {


            if (!empty($data['carte_id'])) {

                $Identificateurs->carte_id = $data['carte_id'];

            }

        }


        if (array_key_exists("date_debut", $data)) {


            if (!empty($data['date_debut'])) {

                $Identificateurs->date_debut = $data['date_debut'];

            }

        }


        if (array_key_exists("date_fin", $data)) {


            if (!empty($data['date_fin'])) {

                $Identificateurs->date_fin = $data['date_fin'];

            }

        }


        if (array_key_exists("statuts", $data)) {


            if (!empty($data['statuts'])) {

                $Identificateurs->statuts = $data['statuts'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Identificateurs->creat_by = $data['creat_by'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Identificateurs->extra_attributes["extra-data"] = $dat;


        } catch (\Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\IdentificateurExtras') &&
            method_exists('\App\Http\Extras\IdentificateurExtras', 'beforeSaveUpdate')
        ) {
            \App\Http\Extras\IdentificateurExtras::beforeSaveUpdate($request, $Identificateurs);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\IdentificateurExtras') &&
            method_exists('\App\Http\Extras\IdentificateurExtras', 'canUpdate')
        ) {
            try {
                $canSave = \App\Http\Extras\IdentificateurExtras::canUpdate($request, $Identificateurs);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $Identificateurs->save();
        } else {
            return response()->json($Identificateurs, 200);

        }


        $Identificateurs = Identificateur::find($Identificateurs->id);


        $newCrudData = [];

        $newCrudData['user_id'] = $Identificateurs->user_id;
        $newCrudData['carte_id'] = $Identificateurs->carte_id;
        $newCrudData['date_debut'] = $Identificateurs->date_debut;
        $newCrudData['date_fin'] = $Identificateurs->date_fin;
        $newCrudData['statuts'] = $Identificateurs->statuts;
        $newCrudData['creat_by'] = $Identificateurs->creat_by;

        try {
            $newCrudData['carte'] = $Identificateurs->carte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Identificateurs->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('surveillances')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Identificateurs', 'entite_cle' => $Identificateurs->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Identificateurs->toArray();


        try {

            foreach ($Identificateurs->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (\Throwable $e) {
        }


        return response()->json($response, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, Identificateur $Identificateurs)
    {
        try {
            $can = \App\Helpers\Helpers::can('Supprimer des identificateurs');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['user_id'] = $Identificateurs->user_id;
        $newCrudData['carte_id'] = $Identificateurs->carte_id;
        $newCrudData['date_debut'] = $Identificateurs->date_debut;
        $newCrudData['date_fin'] = $Identificateurs->date_fin;
        $newCrudData['statuts'] = $Identificateurs->statuts;
        $newCrudData['creat_by'] = $Identificateurs->creat_by;

        try {
            $newCrudData['carte'] = $Identificateurs->carte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Identificateurs->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('surveillances')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Identificateurs', 'entite_cle' => $Identificateurs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\IdentificateurExtras') &&
            method_exists('\App\Http\Extras\IdentificateurExtras', 'canDelete')
        ) {
            try {
                $canSave = \App\Http\Extras\IdentificateurExtras::canDelete($request, $Identificateurs);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $Identificateurs->delete();
        } else {
            return response()->json($Identificateurs, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new \App\Http\Actions\IdentificateursActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
