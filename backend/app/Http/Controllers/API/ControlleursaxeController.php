<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Models\Controlleursaxe;
use App\Models\Groupe;
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

// use App\Repository\prod\ControlleursaxesRepository;


class ControlleursaxeController extends Controller
{

    private $ControlleursaxesRepository;
    private $menu;


    /**
     * Return .
     * @param \Illuminate\Http\Request $request
     * @param App\Repository\prod\ControlleursaxesRepository $ControlleursaxesRepository
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
            class_exists('\App\Http\Extras\ControlleursaxeExtras') &&
            method_exists('\App\Http\Extras\ControlleursaxeExtras', 'getRelationsApplyWhenUserCallMultipleData')
        ) {
            try {
                $relationsWhenDataIsMutlipleHide = \App\Http\Extras\ControlleursaxeExtras::getRelationsApplyWhenUserCallMultipleData($request);
            } catch (\Throwable) {
                $relationsWhenDataIsMutlipleHide = [];
            }
        }
        $query = Controlleursaxe::withoutGlobalScope(SoftDeletingScope::class);

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
            class_exists('\App\Http\Extras\ControlleursaxeExtras') &&
            method_exists('\App\Http\Extras\ControlleursaxeExtras', 'filterAgGridQuery')
        ) {
            \App\Http\Extras\ControlleursaxeExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('controlleursaxes', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\ControlleursaxeExtras') &&
            method_exists('\App\Http\Extras\ControlleursaxeExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = \App\Http\Extras\ControlleursaxeExtras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
            $data['rowData'] = $_d;

            if ($_d->count() > $data['rowCount']) {
                $data['rowCount'] = $_d->count();
            }
        }
        try {
            \Illuminate\Support\Facades\DB::table('surveillances')->insert([
                'user_id' => Auth::id(),
                'action' => 'Lectures des donnees api de  controlleursaxes reussi',
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
            return response()->json(Controlleursaxe::count());
        }
        $data = QueryBuilder::for(Controlleursaxe::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('pointeuse_id'),


                AllowedFilter::exact('ligne_id'),


                AllowedFilter::exact('moyenstransport_id'),


                AllowedFilter::exact('site_id'),


                AllowedFilter::exact('date_debut'),


                AllowedFilter::exact('date_fin'),


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


                AllowedSort::field('pointeuse_id'),


                AllowedSort::field('ligne_id'),


                AllowedSort::field('moyenstransport_id'),


                AllowedSort::field('site_id'),


                AllowedSort::field('date_debut'),


                AllowedSort::field('date_fin'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([
                'transactions',


                'ligne',


                'moyenstransport',


                'pointeuse',


                'site',


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


        $data = QueryBuilder::for(Controlleursaxe::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('pointeuse_id'),


                AllowedFilter::exact('ligne_id'),


                AllowedFilter::exact('moyenstransport_id'),


                AllowedFilter::exact('site_id'),


                AllowedFilter::exact('date_debut'),


                AllowedFilter::exact('date_fin'),


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


                AllowedSort::field('pointeuse_id'),


                AllowedSort::field('ligne_id'),


                AllowedSort::field('moyenstransport_id'),


                AllowedSort::field('site_id'),


                AllowedSort::field('date_debut'),


                AllowedSort::field('date_fin'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([
                'transactions',


                'ligne',


                'moyenstransport',


                'pointeuse',


                'site',


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


    public function create(Request $request, Controlleursaxe $Controlleursaxes)
    {


        try {
            $can = \App\Helpers\Helpers::can('Creer des controlleursaxes');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "controlleursaxes" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'pointeuse_id',
            'ligne_id',
            'moyenstransport_id',
            'site_id',
            'date_debut',
            'date_fin',
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


            'pointeuse_id' => [
                //'required'
            ],


            'ligne_id' => [
                //'required'
            ],


            'moyenstransport_id' => [
                //'required'
            ],


            'site_id' => [
                //'required'
            ],


            'date_debut' => [
                //'required'
            ],


            'date_fin' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'pointeuse_id' => ['cette donnee est obligatoire'],


            'ligne_id' => ['cette donnee est obligatoire'],


            'moyenstransport_id' => ['cette donnee est obligatoire'],


            'site_id' => ['cette donnee est obligatoire'],


            'date_debut' => ['cette donnee est obligatoire'],


            'date_fin' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['pointeuse_id'])) {

            $Controlleursaxes->pointeuse_id = $data['pointeuse_id'];

        }


        if (!empty($data['ligne_id'])) {

            $Controlleursaxes->ligne_id = $data['ligne_id'];

        }


        if (!empty($data['moyenstransport_id'])) {

            $Controlleursaxes->moyenstransport_id = $data['moyenstransport_id'];

        }


        if (!empty($data['site_id'])) {

            $Controlleursaxes->site_id = $data['site_id'];

        }


        if (!empty($data['date_debut'])) {

            $Controlleursaxes->date_debut = $data['date_debut'];

        }


        if (!empty($data['date_fin'])) {

            $Controlleursaxes->date_fin = $data['date_fin'];

        }


        if (!empty($data['creat_by'])) {

            $Controlleursaxes->creat_by = $data['creat_by'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Controlleursaxes->extra_attributes["extra-data"] = $dat;


        } catch (\Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\ControlleursaxeExtras') &&
            method_exists('\App\Http\Extras\ControlleursaxeExtras', 'beforeSaveCreate')
        ) {
            \App\Http\Extras\ControlleursaxeExtras::beforeSaveCreate($request, $Controlleursaxes);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ControlleursaxeExtras') &&
            method_exists('\App\Http\Extras\ControlleursaxeExtras', 'canCreate')
        ) {
            try {
                $canSave = \App\Http\Extras\ControlleursaxeExtras::canCreate($request, $Controlleursaxes);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $Controlleursaxes->save();
        } else {
            return response()->json($Controlleursaxes, 200);
        }

        $Controlleursaxes = Controlleursaxe::find($Controlleursaxes->id);
        $newCrudData = [];

        $newCrudData['pointeuse_id'] = $Controlleursaxes->pointeuse_id;
        $newCrudData['ligne_id'] = $Controlleursaxes->ligne_id;
        $newCrudData['moyenstransport_id'] = $Controlleursaxes->moyenstransport_id;
        $newCrudData['site_id'] = $Controlleursaxes->site_id;
        $newCrudData['date_debut'] = $Controlleursaxes->date_debut;
        $newCrudData['date_fin'] = $Controlleursaxes->date_fin;
        $newCrudData['creat_by'] = $Controlleursaxes->creat_by;

        try {
            $newCrudData['ligne'] = $Controlleursaxes->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['moyenstransport'] = $Controlleursaxes->moyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $Controlleursaxes->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Controlleursaxes->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('surveillances')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Controlleursaxes', 'entite_cle' => $Controlleursaxes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Controlleursaxes->toArray();


        try {

            foreach ($Controlleursaxes->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Controlleursaxe $Controlleursaxes)
    {
        try {
            $can = \App\Helpers\Helpers::can('Editer des controlleursaxes');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['pointeuse_id'] = $Controlleursaxes->pointeuse_id;
        $oldCrudData['ligne_id'] = $Controlleursaxes->ligne_id;
        $oldCrudData['moyenstransport_id'] = $Controlleursaxes->moyenstransport_id;
        $oldCrudData['site_id'] = $Controlleursaxes->site_id;
        $oldCrudData['date_debut'] = $Controlleursaxes->date_debut;
        $oldCrudData['date_fin'] = $Controlleursaxes->date_fin;
        $oldCrudData['creat_by'] = $Controlleursaxes->creat_by;

        try {
            $oldCrudData['ligne'] = $Controlleursaxes->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['moyenstransport'] = $Controlleursaxes->moyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['pointeuse'] = $Controlleursaxes->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['site'] = $Controlleursaxes->site->Selectlabel;
        } catch (\Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "controlleursaxes" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'pointeuse_id',
            'ligne_id',
            'moyenstransport_id',
            'site_id',
            'date_debut',
            'date_fin',
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


            'pointeuse_id' => [
                //'required'
            ],


            'ligne_id' => [
                //'required'
            ],


            'moyenstransport_id' => [
                //'required'
            ],


            'site_id' => [
                //'required'
            ],


            'date_debut' => [
                //'required'
            ],


            'date_fin' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'pointeuse_id' => ['cette donnee est obligatoire'],


            'ligne_id' => ['cette donnee est obligatoire'],


            'moyenstransport_id' => ['cette donnee est obligatoire'],


            'site_id' => ['cette donnee est obligatoire'],


            'date_debut' => ['cette donnee est obligatoire'],


            'date_fin' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("pointeuse_id", $data)) {


            if (!empty($data['pointeuse_id'])) {

                $Controlleursaxes->pointeuse_id = $data['pointeuse_id'];

            }

        }


        if (array_key_exists("ligne_id", $data)) {


            if (!empty($data['ligne_id'])) {

                $Controlleursaxes->ligne_id = $data['ligne_id'];

            }

        }


        if (array_key_exists("moyenstransport_id", $data)) {


            if (!empty($data['moyenstransport_id'])) {

                $Controlleursaxes->moyenstransport_id = $data['moyenstransport_id'];

            }

        }


        if (array_key_exists("site_id", $data)) {


            if (!empty($data['site_id'])) {

                $Controlleursaxes->site_id = $data['site_id'];

            }

        }


        if (array_key_exists("date_debut", $data)) {


            if (!empty($data['date_debut'])) {

                $Controlleursaxes->date_debut = $data['date_debut'];

            }

        }


        if (array_key_exists("date_fin", $data)) {


            if (!empty($data['date_fin'])) {

                $Controlleursaxes->date_fin = $data['date_fin'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Controlleursaxes->creat_by = $data['creat_by'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Controlleursaxes->extra_attributes["extra-data"] = $dat;


        } catch (\Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\ControlleursaxeExtras') &&
            method_exists('\App\Http\Extras\ControlleursaxeExtras', 'beforeSaveUpdate')
        ) {
            \App\Http\Extras\ControlleursaxeExtras::beforeSaveUpdate($request, $Controlleursaxes);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ControlleursaxeExtras') &&
            method_exists('\App\Http\Extras\ControlleursaxeExtras', 'canUpdate')
        ) {
            try {
                $canSave = \App\Http\Extras\ControlleursaxeExtras::canUpdate($request, $Controlleursaxes);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $Controlleursaxes->save();
        } else {
            return response()->json($Controlleursaxes, 200);

        }


        $Controlleursaxes = Controlleursaxe::find($Controlleursaxes->id);


        $newCrudData = [];

        $newCrudData['pointeuse_id'] = $Controlleursaxes->pointeuse_id;
        $newCrudData['ligne_id'] = $Controlleursaxes->ligne_id;
        $newCrudData['moyenstransport_id'] = $Controlleursaxes->moyenstransport_id;
        $newCrudData['site_id'] = $Controlleursaxes->site_id;
        $newCrudData['date_debut'] = $Controlleursaxes->date_debut;
        $newCrudData['date_fin'] = $Controlleursaxes->date_fin;
        $newCrudData['creat_by'] = $Controlleursaxes->creat_by;

        try {
            $newCrudData['ligne'] = $Controlleursaxes->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['moyenstransport'] = $Controlleursaxes->moyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $Controlleursaxes->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Controlleursaxes->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('surveillances')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Controlleursaxes', 'entite_cle' => $Controlleursaxes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Controlleursaxes->toArray();


        try {

            foreach ($Controlleursaxes->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Controlleursaxe $Controlleursaxes)
    {
        try {
            $can = \App\Helpers\Helpers::can('Supprimer des controlleursaxes');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['pointeuse_id'] = $Controlleursaxes->pointeuse_id;
        $newCrudData['ligne_id'] = $Controlleursaxes->ligne_id;
        $newCrudData['moyenstransport_id'] = $Controlleursaxes->moyenstransport_id;
        $newCrudData['site_id'] = $Controlleursaxes->site_id;
        $newCrudData['date_debut'] = $Controlleursaxes->date_debut;
        $newCrudData['date_fin'] = $Controlleursaxes->date_fin;
        $newCrudData['creat_by'] = $Controlleursaxes->creat_by;

        try {
            $newCrudData['ligne'] = $Controlleursaxes->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['moyenstransport'] = $Controlleursaxes->moyenstransport->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $Controlleursaxes->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Controlleursaxes->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('surveillances')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Controlleursaxes', 'entite_cle' => $Controlleursaxes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ControlleursaxeExtras') &&
            method_exists('\App\Http\Extras\ControlleursaxeExtras', 'canDelete')
        ) {
            try {
                $canSave = \App\Http\Extras\ControlleursaxeExtras::canDelete($request, $Controlleursaxes);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $Controlleursaxes->delete();
        } else {
            return response()->json($Controlleursaxes, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new \App\Http\Actions\ControlleursaxesActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
