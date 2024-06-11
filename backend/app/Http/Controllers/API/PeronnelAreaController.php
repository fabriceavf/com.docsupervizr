<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\Personnel_areaActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\Peronnel_areaExtras;
use App\Models\Groupe;
use App\Models\PeronnelArea;
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

// use App\Repository\prod\Personnel_areaRepository;


class PeronnelAreaController extends Controller
{

    private $Personnel_areaRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\Personnel_areaRepository $Personnel_areaRepository
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
        $query = PeronnelArea::query();
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
            class_exists('\App\Http\Extras\Peronnel_areaExtras') &&
            method_exists('\App\Http\Extras\Peronnel_areaExtras', 'filterAgGridQuery')
        ) {
            Peronnel_areaExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('personnel_area', $query);
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
            return response()->json(PeronnelArea::count());
        }
        $data = QueryBuilder::for(PeronnelArea::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('change_operator'),


                AllowedFilter::exact('change_time'),


                AllowedFilter::exact('create_operator'),


                AllowedFilter::exact('create_time'),


                AllowedFilter::exact('delete_operator'),


                AllowedFilter::exact('delete_time'),


                AllowedFilter::exact('status'),


                AllowedFilter::exact('areaid'),


                AllowedFilter::exact('areaname'),


                AllowedFilter::exact('parent_id'),


                AllowedFilter::exact('remark'),


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


                AllowedSort::field('change_operator'),


                AllowedSort::field('change_time'),


                AllowedSort::field('create_operator'),


                AllowedSort::field('create_time'),


                AllowedSort::field('delete_operator'),


                AllowedSort::field('delete_time'),


                AllowedSort::field('status'),


                AllowedSort::field('areaid'),


                AllowedSort::field('areaname'),


                AllowedSort::field('parent_id'),


                AllowedSort::field('remark'),


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


        $data = QueryBuilder::for(PeronnelArea::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('change_operator'),


                AllowedFilter::exact('change_time'),


                AllowedFilter::exact('create_operator'),


                AllowedFilter::exact('create_time'),


                AllowedFilter::exact('delete_operator'),


                AllowedFilter::exact('delete_time'),


                AllowedFilter::exact('status'),


                AllowedFilter::exact('areaid'),


                AllowedFilter::exact('areaname'),


                AllowedFilter::exact('parent_id'),


                AllowedFilter::exact('remark'),


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


                AllowedSort::field('change_operator'),


                AllowedSort::field('change_time'),


                AllowedSort::field('create_operator'),


                AllowedSort::field('create_time'),


                AllowedSort::field('delete_operator'),


                AllowedSort::field('delete_time'),


                AllowedSort::field('status'),


                AllowedSort::field('areaid'),


                AllowedSort::field('areaname'),


                AllowedSort::field('parent_id'),


                AllowedSort::field('remark'),


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


    public function create(Request $request, PeronnelArea $Personnel_area)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "personnel_area" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'change_operator',
            'change_time',
            'create_operator',
            'create_time',
            'delete_operator',
            'delete_time',
            'status',
            'areaid',
            'areaname',
            'parent_id',
            'remark',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'change_operator' => [
                //'required'
            ],


            'change_time' => [
                //'required'
            ],


            'create_operator' => [
                //'required'
            ],


            'create_time' => [
                //'required'
            ],


            'delete_operator' => [
                //'required'
            ],


            'delete_time' => [
                //'required'
            ],


            'status' => [
                //'required'
            ],


            'areaid' => [
                //'required'
            ],


            'areaname' => [
                //'required'
            ],


            'parent_id' => [
                //'required'
            ],


            'remark' => [
                //'required'
            ],


        ], $messages = [


            'change_operator' => ['cette donnee est obligatoire'],


            'change_time' => ['cette donnee est obligatoire'],


            'create_operator' => ['cette donnee est obligatoire'],


            'create_time' => ['cette donnee est obligatoire'],


            'delete_operator' => ['cette donnee est obligatoire'],


            'delete_time' => ['cette donnee est obligatoire'],


            'status' => ['cette donnee est obligatoire'],


            'areaid' => ['cette donnee est obligatoire'],


            'areaname' => ['cette donnee est obligatoire'],


            'parent_id' => ['cette donnee est obligatoire'],


            'remark' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['change_operator'])) {

            $Personnel_area->change_operator = $data['change_operator'];

        }


        if (!empty($data['change_time'])) {

            $Personnel_area->change_time = $data['change_time'];

        }


        if (!empty($data['create_operator'])) {

            $Personnel_area->create_operator = $data['create_operator'];

        }


        if (!empty($data['create_time'])) {

            $Personnel_area->create_time = $data['create_time'];

        }


        if (!empty($data['delete_operator'])) {

            $Personnel_area->delete_operator = $data['delete_operator'];

        }


        if (!empty($data['delete_time'])) {

            $Personnel_area->delete_time = $data['delete_time'];

        }


        if (!empty($data['status'])) {

            $Personnel_area->status = $data['status'];

        }


        if (!empty($data['areaid'])) {

            $Personnel_area->areaid = $data['areaid'];

        }


        if (!empty($data['areaname'])) {

            $Personnel_area->areaname = $data['areaname'];

        }


        if (!empty($data['parent_id'])) {

            $Personnel_area->parent_id = $data['parent_id'];

        }


        if (!empty($data['remark'])) {

            $Personnel_area->remark = $data['remark'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Personnel_area->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\Peronnel_areaExtras') &&
            method_exists('\App\Http\Extras\Peronnel_areaExtras', 'beforeSaveCreate')
        ) {
            Peronnel_areaExtras::beforeSaveCreate($request, $Personnel_area);
        }


        $Personnel_area->save();
        $Personnel_area = PeronnelArea::find($Personnel_area->id);
        $newCrudData = [];

        $newCrudData['change_operator'] = $Personnel_area->change_operator;
        $newCrudData['change_time'] = $Personnel_area->change_time;
        $newCrudData['create_operator'] = $Personnel_area->create_operator;
        $newCrudData['create_time'] = $Personnel_area->create_time;
        $newCrudData['delete_operator'] = $Personnel_area->delete_operator;
        $newCrudData['delete_time'] = $Personnel_area->delete_time;
        $newCrudData['status'] = $Personnel_area->status;
        $newCrudData['areaid'] = $Personnel_area->areaid;
        $newCrudData['areaname'] = $Personnel_area->areaname;
        $newCrudData['remark'] = $Personnel_area->remark;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Personnel_area', 'entite_cle' => $Personnel_area->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Personnel_area->toArray();


        try {

            foreach ($Personnel_area->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, PeronnelArea $Personnel_area)
    {


        $oldCrudData = [];

        $oldCrudData['change_operator'] = $Personnel_area->change_operator;
        $oldCrudData['change_time'] = $Personnel_area->change_time;
        $oldCrudData['create_operator'] = $Personnel_area->create_operator;
        $oldCrudData['create_time'] = $Personnel_area->create_time;
        $oldCrudData['delete_operator'] = $Personnel_area->delete_operator;
        $oldCrudData['delete_time'] = $Personnel_area->delete_time;
        $oldCrudData['status'] = $Personnel_area->status;
        $oldCrudData['areaid'] = $Personnel_area->areaid;
        $oldCrudData['areaname'] = $Personnel_area->areaname;
        $oldCrudData['remark'] = $Personnel_area->remark;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "personnel_area" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'change_operator',
            'change_time',
            'create_operator',
            'create_time',
            'delete_operator',
            'delete_time',
            'status',
            'areaid',
            'areaname',
            'parent_id',
            'remark',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'change_operator' => [
                //'required'
            ],


            'change_time' => [
                //'required'
            ],


            'create_operator' => [
                //'required'
            ],


            'create_time' => [
                //'required'
            ],


            'delete_operator' => [
                //'required'
            ],


            'delete_time' => [
                //'required'
            ],


            'status' => [
                //'required'
            ],


            'areaid' => [
                //'required'
            ],


            'areaname' => [
                //'required'
            ],


            'parent_id' => [
                //'required'
            ],


            'remark' => [
                //'required'
            ],


        ], $messages = [


            'change_operator' => ['cette donnee est obligatoire'],


            'change_time' => ['cette donnee est obligatoire'],


            'create_operator' => ['cette donnee est obligatoire'],


            'create_time' => ['cette donnee est obligatoire'],


            'delete_operator' => ['cette donnee est obligatoire'],


            'delete_time' => ['cette donnee est obligatoire'],


            'status' => ['cette donnee est obligatoire'],


            'areaid' => ['cette donnee est obligatoire'],


            'areaname' => ['cette donnee est obligatoire'],


            'parent_id' => ['cette donnee est obligatoire'],


            'remark' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("change_operator", $data)) {


            if (!empty($data['change_operator'])) {

                $Personnel_area->change_operator = $data['change_operator'];

            }

        }


        if (array_key_exists("change_time", $data)) {


            if (!empty($data['change_time'])) {

                $Personnel_area->change_time = $data['change_time'];

            }

        }


        if (array_key_exists("create_operator", $data)) {


            if (!empty($data['create_operator'])) {

                $Personnel_area->create_operator = $data['create_operator'];

            }

        }


        if (array_key_exists("create_time", $data)) {


            if (!empty($data['create_time'])) {

                $Personnel_area->create_time = $data['create_time'];

            }

        }


        if (array_key_exists("delete_operator", $data)) {


            if (!empty($data['delete_operator'])) {

                $Personnel_area->delete_operator = $data['delete_operator'];

            }

        }


        if (array_key_exists("delete_time", $data)) {


            if (!empty($data['delete_time'])) {

                $Personnel_area->delete_time = $data['delete_time'];

            }

        }


        if (array_key_exists("status", $data)) {


            if (!empty($data['status'])) {

                $Personnel_area->status = $data['status'];

            }

        }


        if (array_key_exists("areaid", $data)) {


            if (!empty($data['areaid'])) {

                $Personnel_area->areaid = $data['areaid'];

            }

        }


        if (array_key_exists("areaname", $data)) {


            if (!empty($data['areaname'])) {

                $Personnel_area->areaname = $data['areaname'];

            }

        }


        if (array_key_exists("parent_id", $data)) {


            if (!empty($data['parent_id'])) {

                $Personnel_area->parent_id = $data['parent_id'];

            }

        }


        if (array_key_exists("remark", $data)) {


            if (!empty($data['remark'])) {

                $Personnel_area->remark = $data['remark'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Personnel_area->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\Peronnel_areaExtras') &&
            method_exists('\App\Http\Extras\Peronnel_areaExtras', 'beforeSaveUpdate')
        ) {
            Peronnel_areaExtras::beforeSaveUpdate($request, $Personnel_area);
        }

        $Personnel_area->save();
        $Personnel_area = PeronnelArea::find($Personnel_area->id);


        $newCrudData = [];

        $newCrudData['change_operator'] = $Personnel_area->change_operator;
        $newCrudData['change_time'] = $Personnel_area->change_time;
        $newCrudData['create_operator'] = $Personnel_area->create_operator;
        $newCrudData['create_time'] = $Personnel_area->create_time;
        $newCrudData['delete_operator'] = $Personnel_area->delete_operator;
        $newCrudData['delete_time'] = $Personnel_area->delete_time;
        $newCrudData['status'] = $Personnel_area->status;
        $newCrudData['areaid'] = $Personnel_area->areaid;
        $newCrudData['areaname'] = $Personnel_area->areaname;
        $newCrudData['remark'] = $Personnel_area->remark;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Personnel_area', 'entite_cle' => $Personnel_area->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Personnel_area->toArray();


        try {

            foreach ($Personnel_area->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, PeronnelArea $Personnel_area)
    {


        $newCrudData = [];

        $newCrudData['change_operator'] = $Personnel_area->change_operator;
        $newCrudData['change_time'] = $Personnel_area->change_time;
        $newCrudData['create_operator'] = $Personnel_area->create_operator;
        $newCrudData['create_time'] = $Personnel_area->create_time;
        $newCrudData['delete_operator'] = $Personnel_area->delete_operator;
        $newCrudData['delete_time'] = $Personnel_area->delete_time;
        $newCrudData['status'] = $Personnel_area->status;
        $newCrudData['areaid'] = $Personnel_area->areaid;
        $newCrudData['areaname'] = $Personnel_area->areaname;
        $newCrudData['remark'] = $Personnel_area->remark;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Personnel_area', 'entite_cle' => $Personnel_area->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $Personnel_area->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new Personnel_areaActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
