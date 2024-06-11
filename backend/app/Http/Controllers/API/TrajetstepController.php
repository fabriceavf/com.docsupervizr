<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\TrajetstepsActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\TrajetstepExtras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\Trajetstep;
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

// use App\Repository\prod\TrajetstepsRepository;


class TrajetstepController extends Controller
{

    private $TrajetstepsRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\TrajetstepsRepository $TrajetstepsRepository
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
        $query = Trajetstep::query();
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
            class_exists('\App\Http\Extras\TrajetstepExtras') &&
            method_exists('\App\Http\Extras\TrajetstepExtras', 'filterAgGridQuery')
        ) {
            TrajetstepExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('trajetsteps', $query);
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
            return response()->json(Trajetstep::count());
        }
        $data = QueryBuilder::for(Trajetstep::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('deplacement_type'),


                AllowedFilter::exact('type_deplacement'),


                AllowedFilter::exact('left'),


                AllowedFilter::exact('right'),


                AllowedFilter::exact('front'),


                AllowedFilter::exact('trajet_id'),


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


                AllowedSort::field('deplacement_type'),


                AllowedSort::field('type_deplacement'),


                AllowedSort::field('left'),


                AllowedSort::field('right'),


                AllowedSort::field('front'),


                AllowedSort::field('trajet_id'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([
                'trajetdestinations',


                'trajet',


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


        $data = QueryBuilder::for(Trajetstep::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('deplacement_type'),


                AllowedFilter::exact('type_deplacement'),


                AllowedFilter::exact('left'),


                AllowedFilter::exact('right'),


                AllowedFilter::exact('front'),


                AllowedFilter::exact('trajet_id'),


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


                AllowedSort::field('deplacement_type'),


                AllowedSort::field('type_deplacement'),


                AllowedSort::field('left'),


                AllowedSort::field('right'),


                AllowedSort::field('front'),


                AllowedSort::field('trajet_id'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([
                'trajetdestinations',


                'trajet',


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


    public function create(Request $request, Trajetstep $Trajetsteps)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "trajetsteps" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'deplacement_type',
            'type_deplacement',
            'left',
            'right',
            'front',
            'trajet_id',
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


            'deplacement_type' => [
                //'required'
            ],


            'type_deplacement' => [
                //'required'
            ],


            'left' => [
                //'required'
            ],


            'right' => [
                //'required'
            ],


            'front' => [
                //'required'
            ],


            'trajet_id' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'deplacement_type' => ['cette donnee est obligatoire'],


            'type_deplacement' => ['cette donnee est obligatoire'],


            'left' => ['cette donnee est obligatoire'],


            'right' => ['cette donnee est obligatoire'],


            'front' => ['cette donnee est obligatoire'],


            'trajet_id' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['deplacement_type'])) {

            $Trajetsteps->deplacement_type = $data['deplacement_type'];

        }


        if (!empty($data['type_deplacement'])) {

            $Trajetsteps->type_deplacement = $data['type_deplacement'];

        }


        if (!empty($data['left'])) {

            $Trajetsteps->left = $data['left'];

        }


        if (!empty($data['right'])) {

            $Trajetsteps->right = $data['right'];

        }


        if (!empty($data['front'])) {

            $Trajetsteps->front = $data['front'];

        }


        if (!empty($data['trajet_id'])) {

            $Trajetsteps->trajet_id = $data['trajet_id'];

        }


        if (!empty($data['creat_by'])) {

            $Trajetsteps->creat_by = $data['creat_by'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Trajetsteps->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\TrajetstepExtras') &&
            method_exists('\App\Http\Extras\TrajetstepExtras', 'beforeSaveCreate')
        ) {
            TrajetstepExtras::beforeSaveCreate($request, $Trajetsteps);
        }


        $Trajetsteps->save();
        $Trajetsteps = Trajetstep::find($Trajetsteps->id);
        $newCrudData = [];

        $newCrudData['deplacement_type'] = $Trajetsteps->deplacement_type;
        $newCrudData['type_deplacement'] = $Trajetsteps->type_deplacement;
        $newCrudData['left'] = $Trajetsteps->left;
        $newCrudData['right'] = $Trajetsteps->right;
        $newCrudData['front'] = $Trajetsteps->front;
        $newCrudData['creat_by'] = $Trajetsteps->creat_by;

        try {
            $newCrudData['trajet'] = $Trajetsteps->trajet->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Trajetsteps', 'entite_cle' => $Trajetsteps->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Trajetsteps->toArray();


        try {

            foreach ($Trajetsteps->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Trajetstep $Trajetsteps)
    {


        $oldCrudData = [];

        $oldCrudData['deplacement_type'] = $Trajetsteps->deplacement_type;
        $oldCrudData['type_deplacement'] = $Trajetsteps->type_deplacement;
        $oldCrudData['left'] = $Trajetsteps->left;
        $oldCrudData['right'] = $Trajetsteps->right;
        $oldCrudData['front'] = $Trajetsteps->front;
        $oldCrudData['creat_by'] = $Trajetsteps->creat_by;

        try {
            $oldCrudData['trajet'] = $Trajetsteps->trajet->Selectlabel;
        } catch (Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "trajetsteps" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'deplacement_type',
            'type_deplacement',
            'left',
            'right',
            'front',
            'trajet_id',
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


            'deplacement_type' => [
                //'required'
            ],


            'type_deplacement' => [
                //'required'
            ],


            'left' => [
                //'required'
            ],


            'right' => [
                //'required'
            ],


            'front' => [
                //'required'
            ],


            'trajet_id' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'deplacement_type' => ['cette donnee est obligatoire'],


            'type_deplacement' => ['cette donnee est obligatoire'],


            'left' => ['cette donnee est obligatoire'],


            'right' => ['cette donnee est obligatoire'],


            'front' => ['cette donnee est obligatoire'],


            'trajet_id' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("deplacement_type", $data)) {


            if (!empty($data['deplacement_type'])) {

                $Trajetsteps->deplacement_type = $data['deplacement_type'];

            }

        }


        if (array_key_exists("type_deplacement", $data)) {


            if (!empty($data['type_deplacement'])) {

                $Trajetsteps->type_deplacement = $data['type_deplacement'];

            }

        }


        if (array_key_exists("left", $data)) {


            if (!empty($data['left'])) {

                $Trajetsteps->left = $data['left'];

            }

        }


        if (array_key_exists("right", $data)) {


            if (!empty($data['right'])) {

                $Trajetsteps->right = $data['right'];

            }

        }


        if (array_key_exists("front", $data)) {


            if (!empty($data['front'])) {

                $Trajetsteps->front = $data['front'];

            }

        }


        if (array_key_exists("trajet_id", $data)) {


            if (!empty($data['trajet_id'])) {

                $Trajetsteps->trajet_id = $data['trajet_id'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Trajetsteps->creat_by = $data['creat_by'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Trajetsteps->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\TrajetstepExtras') &&
            method_exists('\App\Http\Extras\TrajetstepExtras', 'beforeSaveUpdate')
        ) {
            TrajetstepExtras::beforeSaveUpdate($request, $Trajetsteps);
        }

        $Trajetsteps->save();
        $Trajetsteps = Trajetstep::find($Trajetsteps->id);


        $newCrudData = [];

        $newCrudData['deplacement_type'] = $Trajetsteps->deplacement_type;
        $newCrudData['type_deplacement'] = $Trajetsteps->type_deplacement;
        $newCrudData['left'] = $Trajetsteps->left;
        $newCrudData['right'] = $Trajetsteps->right;
        $newCrudData['front'] = $Trajetsteps->front;
        $newCrudData['creat_by'] = $Trajetsteps->creat_by;

        try {
            $newCrudData['trajet'] = $Trajetsteps->trajet->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Trajetsteps', 'entite_cle' => $Trajetsteps->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Trajetsteps->toArray();


        try {

            foreach ($Trajetsteps->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Trajetstep $Trajetsteps)
    {


        $newCrudData = [];

        $newCrudData['deplacement_type'] = $Trajetsteps->deplacement_type;
        $newCrudData['type_deplacement'] = $Trajetsteps->type_deplacement;
        $newCrudData['left'] = $Trajetsteps->left;
        $newCrudData['right'] = $Trajetsteps->right;
        $newCrudData['front'] = $Trajetsteps->front;
        $newCrudData['creat_by'] = $Trajetsteps->creat_by;

        try {
            $newCrudData['trajet'] = $Trajetsteps->trajet->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Trajetsteps', 'entite_cle' => $Trajetsteps->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $Trajetsteps->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new TrajetstepsActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
