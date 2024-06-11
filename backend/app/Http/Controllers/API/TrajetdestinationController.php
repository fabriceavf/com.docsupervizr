<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\TrajetdestinationsActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\TrajetdestinationExtras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\Trajetdestination;
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

// use App\Repository\prod\TrajetdestinationsRepository;


class TrajetdestinationController extends Controller
{

    private $TrajetdestinationsRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\TrajetdestinationsRepository $TrajetdestinationsRepository
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
        $query = Trajetdestination::query();
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
            class_exists('\App\Http\Extras\TrajetdestinationExtras') &&
            method_exists('\App\Http\Extras\TrajetdestinationExtras', 'filterAgGridQuery')
        ) {
            TrajetdestinationExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('trajetdestinations', $query);
        $data = $agGrid->getData($request);
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
            return response()->json(Trajetdestination::count());
        }
        $data = QueryBuilder::for(Trajetdestination::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('libelle'),


                AllowedFilter::exact('direction'),


                AllowedFilter::exact('type'),


                AllowedFilter::exact('trajetstep_id'),


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


                AllowedSort::field('libelle'),


                AllowedSort::field('direction'),


                AllowedSort::field('type'),


                AllowedSort::field('trajetstep_id'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([

                'trajetstep',


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


        $data = QueryBuilder::for(Trajetdestination::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('libelle'),


                AllowedFilter::exact('direction'),


                AllowedFilter::exact('type'),


                AllowedFilter::exact('trajetstep_id'),


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


                AllowedSort::field('libelle'),


                AllowedSort::field('direction'),


                AllowedSort::field('type'),


                AllowedSort::field('trajetstep_id'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([
                'trajetstep',


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


    public function create(Request $request, Trajetdestination $Trajetdestinations)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "trajetdestinations" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'libelle',
            'direction',
            'type',
            'trajetstep_id',
            'extra_attributes',
            'creat_by',
            'deleted_at',
            'created_at',
            'updated_at',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'libelle' => [
                //'required'
            ],


            'direction' => [
                //'required'
            ],


            'type' => [
                //'required'
            ],


            'trajetstep_id' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'libelle' => ['cette donnee est obligatoire'],


            'direction' => ['cette donnee est obligatoire'],


            'type' => ['cette donnee est obligatoire'],


            'trajetstep_id' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['libelle'])) {

            $Trajetdestinations->libelle = $data['libelle'];

        }


        if (!empty($data['direction'])) {

            $Trajetdestinations->direction = $data['direction'];

        }


        if (!empty($data['type'])) {

            $Trajetdestinations->type = $data['type'];

        }


        if (!empty($data['trajetstep_id'])) {

            $Trajetdestinations->trajetstep_id = $data['trajetstep_id'];

        }


        if (!empty($data['creat_by'])) {

            $Trajetdestinations->creat_by = $data['creat_by'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Trajetdestinations->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\TrajetdestinationExtras') &&
            method_exists('\App\Http\Extras\TrajetdestinationExtras', 'beforeSaveCreate')
        ) {
            TrajetdestinationExtras::beforeSaveCreate($request, $Trajetdestinations);
        }


        $Trajetdestinations->save();
        $Trajetdestinations = Trajetdestination::find($Trajetdestinations->id);
        $newCrudData = [];

        $newCrudData['libelle'] = $Trajetdestinations->libelle;
        $newCrudData['direction'] = $Trajetdestinations->direction;
        $newCrudData['type'] = $Trajetdestinations->type;
        $newCrudData['creat_by'] = $Trajetdestinations->creat_by;

        try {
            $newCrudData['trajetstep'] = $Trajetdestinations->trajetstep->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Trajetdestinations', 'entite_cle' => $Trajetdestinations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Trajetdestinations->toArray();


        try {

            foreach ($Trajetdestinations->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Trajetdestination $Trajetdestinations)
    {


        $oldCrudData = [];

        $oldCrudData['libelle'] = $Trajetdestinations->libelle;
        $oldCrudData['direction'] = $Trajetdestinations->direction;
        $oldCrudData['type'] = $Trajetdestinations->type;
        $oldCrudData['creat_by'] = $Trajetdestinations->creat_by;

        try {
            $oldCrudData['trajetstep'] = $Trajetdestinations->trajetstep->Selectlabel;
        } catch (Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "trajetdestinations" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'libelle',
            'direction',
            'type',
            'trajetstep_id',
            'extra_attributes',
            'creat_by',
            'deleted_at',
            'created_at',
            'updated_at',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'libelle' => [
                //'required'
            ],


            'direction' => [
                //'required'
            ],


            'type' => [
                //'required'
            ],


            'trajetstep_id' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'libelle' => ['cette donnee est obligatoire'],


            'direction' => ['cette donnee est obligatoire'],


            'type' => ['cette donnee est obligatoire'],


            'trajetstep_id' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("libelle", $data)) {


            if (!empty($data['libelle'])) {

                $Trajetdestinations->libelle = $data['libelle'];

            }

        }


        if (array_key_exists("direction", $data)) {


            if (!empty($data['direction'])) {

                $Trajetdestinations->direction = $data['direction'];

            }

        }


        if (array_key_exists("type", $data)) {


            if (!empty($data['type'])) {

                $Trajetdestinations->type = $data['type'];

            }

        }


        if (array_key_exists("trajetstep_id", $data)) {


            if (!empty($data['trajetstep_id'])) {

                $Trajetdestinations->trajetstep_id = $data['trajetstep_id'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Trajetdestinations->creat_by = $data['creat_by'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Trajetdestinations->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\TrajetdestinationExtras') &&
            method_exists('\App\Http\Extras\TrajetdestinationExtras', 'beforeSaveUpdate')
        ) {
            TrajetdestinationExtras::beforeSaveUpdate($request, $Trajetdestinations);
        }

        $Trajetdestinations->save();
        $Trajetdestinations = Trajetdestination::find($Trajetdestinations->id);


        $newCrudData = [];

        $newCrudData['libelle'] = $Trajetdestinations->libelle;
        $newCrudData['direction'] = $Trajetdestinations->direction;
        $newCrudData['type'] = $Trajetdestinations->type;
        $newCrudData['creat_by'] = $Trajetdestinations->creat_by;

        try {
            $newCrudData['trajetstep'] = $Trajetdestinations->trajetstep->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Trajetdestinations', 'entite_cle' => $Trajetdestinations->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Trajetdestinations->toArray();


        try {

            foreach ($Trajetdestinations->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Trajetdestination $Trajetdestinations)
    {


        $newCrudData = [];

        $newCrudData['libelle'] = $Trajetdestinations->libelle;
        $newCrudData['direction'] = $Trajetdestinations->direction;
        $newCrudData['type'] = $Trajetdestinations->type;
        $newCrudData['creat_by'] = $Trajetdestinations->creat_by;

        try {
            $newCrudData['trajetstep'] = $Trajetdestinations->trajetstep->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Trajetdestinations', 'entite_cle' => $Trajetdestinations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $Trajetdestinations->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new TrajetdestinationsActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
