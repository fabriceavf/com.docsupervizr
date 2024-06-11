<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\FaceTempExActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\FaceTempExExtras;
use App\Models\FaceTempEx;
use App\Models\Groupe;
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

// use App\Repository\prod\FaceTempExRepository;


class FaceTempExController extends Controller
{

    private $FaceTempExRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\FaceTempExRepository $FaceTempExRepository
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
        $query = FaceTempEx::query();
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
            class_exists('\App\Http\Extras\FaceTempExExtras') &&
            method_exists('\App\Http\Extras\FaceTempExExtras', 'filterAgGridQuery')
        ) {
            FaceTempExExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('FaceTempEx', $query);
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
            return response()->json(FaceTempEx::count());
        }
        $data = QueryBuilder::for(FaceTempEx::class)
            ->allowedFilters([
                AllowedFilter::exact('TEMPLATEID'),


                AllowedFilter::exact('USERNO'),


                AllowedFilter::exact('SIZE'),


                AllowedFilter::exact('pin'),


                AllowedFilter::exact('FACEID'),


                AllowedFilter::exact('VALID'),


                AllowedFilter::exact('RESERVE'),


                AllowedFilter::exact('ACTIVETIME'),


                AllowedFilter::exact('VFCOUNT'),


                AllowedFilter::exact('TEMPLATE'),


                AllowedFilter::exact('FaceType'),


                AllowedFilter::exact('StateMigrationFlag'),


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
                AllowedSort::field('TEMPLATEID'),


                AllowedSort::field('USERNO'),


                AllowedSort::field('SIZE'),


                AllowedSort::field('pin'),


                AllowedSort::field('FACEID'),


                AllowedSort::field('VALID'),


                AllowedSort::field('RESERVE'),


                AllowedSort::field('ACTIVETIME'),


                AllowedSort::field('VFCOUNT'),


                AllowedSort::field('TEMPLATE'),


                AllowedSort::field('FaceType'),


                AllowedSort::field('StateMigrationFlag'),


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


        $data = QueryBuilder::for(FaceTempEx::class)
            ->allowedFilters([
                AllowedFilter::exact('TEMPLATEID'),


                AllowedFilter::exact('USERNO'),


                AllowedFilter::exact('SIZE'),


                AllowedFilter::exact('pin'),


                AllowedFilter::exact('FACEID'),


                AllowedFilter::exact('VALID'),


                AllowedFilter::exact('RESERVE'),


                AllowedFilter::exact('ACTIVETIME'),


                AllowedFilter::exact('VFCOUNT'),


                AllowedFilter::exact('TEMPLATE'),


                AllowedFilter::exact('FaceType'),


                AllowedFilter::exact('StateMigrationFlag'),


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
                AllowedSort::field('TEMPLATEID'),


                AllowedSort::field('USERNO'),


                AllowedSort::field('SIZE'),


                AllowedSort::field('pin'),


                AllowedSort::field('FACEID'),


                AllowedSort::field('VALID'),


                AllowedSort::field('RESERVE'),


                AllowedSort::field('ACTIVETIME'),


                AllowedSort::field('VFCOUNT'),


                AllowedSort::field('TEMPLATE'),


                AllowedSort::field('FaceType'),


                AllowedSort::field('StateMigrationFlag'),


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


    public function create(Request $request, FaceTempEx $FaceTempEx)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "FaceTempEx" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'TEMPLATEID',
            'USERNO',
            'SIZE',
            'pin',
            'FACEID',
            'VALID',
            'RESERVE',
            'ACTIVETIME',
            'VFCOUNT',
            'TEMPLATE',
            'FaceType',
            'StateMigrationFlag',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'TEMPLATEID' => [
                //'required'
            ],


            'USERNO' => [
                //'required'
            ],


            'SIZE' => [
                //'required'
            ],


            'pin' => [
                //'required'
            ],


            'FACEID' => [
                //'required'
            ],


            'VALID' => [
                //'required'
            ],


            'RESERVE' => [
                //'required'
            ],


            'ACTIVETIME' => [
                //'required'
            ],


            'VFCOUNT' => [
                //'required'
            ],


            'TEMPLATE' => [
                //'required'
            ],


            'FaceType' => [
                //'required'
            ],


            'StateMigrationFlag' => [
                //'required'
            ],


        ], $messages = [


            'TEMPLATEID' => ['cette donnee est obligatoire'],


            'USERNO' => ['cette donnee est obligatoire'],


            'SIZE' => ['cette donnee est obligatoire'],


            'pin' => ['cette donnee est obligatoire'],


            'FACEID' => ['cette donnee est obligatoire'],


            'VALID' => ['cette donnee est obligatoire'],


            'RESERVE' => ['cette donnee est obligatoire'],


            'ACTIVETIME' => ['cette donnee est obligatoire'],


            'VFCOUNT' => ['cette donnee est obligatoire'],


            'TEMPLATE' => ['cette donnee est obligatoire'],


            'FaceType' => ['cette donnee est obligatoire'],


            'StateMigrationFlag' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['TEMPLATEID'])) {

            $FaceTempEx->TEMPLATEID = $data['TEMPLATEID'];

        }


        if (!empty($data['USERNO'])) {

            $FaceTempEx->USERNO = $data['USERNO'];

        }


        if (!empty($data['SIZE'])) {

            $FaceTempEx->SIZE = $data['SIZE'];

        }


        if (!empty($data['pin'])) {

            $FaceTempEx->pin = $data['pin'];

        }


        if (!empty($data['FACEID'])) {

            $FaceTempEx->FACEID = $data['FACEID'];

        }


        if (!empty($data['VALID'])) {

            $FaceTempEx->VALID = $data['VALID'];

        }


        if (!empty($data['RESERVE'])) {

            $FaceTempEx->RESERVE = $data['RESERVE'];

        }


        if (!empty($data['ACTIVETIME'])) {

            $FaceTempEx->ACTIVETIME = $data['ACTIVETIME'];

        }


        if (!empty($data['VFCOUNT'])) {

            $FaceTempEx->VFCOUNT = $data['VFCOUNT'];

        }


        if (!empty($data['TEMPLATE'])) {

            $FaceTempEx->TEMPLATE = $data['TEMPLATE'];

        }


        if (!empty($data['FaceType'])) {

            $FaceTempEx->FaceType = $data['FaceType'];

        }


        if (!empty($data['StateMigrationFlag'])) {

            $FaceTempEx->StateMigrationFlag = $data['StateMigrationFlag'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $FaceTempEx->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\FaceTempExExtras') &&
            method_exists('\App\Http\Extras\FaceTempExExtras', 'beforeSaveCreate')
        ) {
            FaceTempExExtras::beforeSaveCreate($request, $FaceTempEx);
        }


        $FaceTempEx->save();
        $FaceTempEx = FaceTempEx::find($FaceTempEx->id);
        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $FaceTempEx->TEMPLATEID;
        $newCrudData['USERNO'] = $FaceTempEx->USERNO;
        $newCrudData['SIZE'] = $FaceTempEx->SIZE;
        $newCrudData['pin'] = $FaceTempEx->pin;
        $newCrudData['FACEID'] = $FaceTempEx->FACEID;
        $newCrudData['VALID'] = $FaceTempEx->VALID;
        $newCrudData['RESERVE'] = $FaceTempEx->RESERVE;
        $newCrudData['ACTIVETIME'] = $FaceTempEx->ACTIVETIME;
        $newCrudData['VFCOUNT'] = $FaceTempEx->VFCOUNT;
        $newCrudData['TEMPLATE'] = $FaceTempEx->TEMPLATE;
        $newCrudData['FaceType'] = $FaceTempEx->FaceType;
        $newCrudData['StateMigrationFlag'] = $FaceTempEx->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'FaceTempEx', 'entite_cle' => $FaceTempEx->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $FaceTempEx->toArray();


        try {

            foreach ($FaceTempEx->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, FaceTempEx $FaceTempEx)
    {


        $oldCrudData = [];

        $oldCrudData['TEMPLATEID'] = $FaceTempEx->TEMPLATEID;
        $oldCrudData['USERNO'] = $FaceTempEx->USERNO;
        $oldCrudData['SIZE'] = $FaceTempEx->SIZE;
        $oldCrudData['pin'] = $FaceTempEx->pin;
        $oldCrudData['FACEID'] = $FaceTempEx->FACEID;
        $oldCrudData['VALID'] = $FaceTempEx->VALID;
        $oldCrudData['RESERVE'] = $FaceTempEx->RESERVE;
        $oldCrudData['ACTIVETIME'] = $FaceTempEx->ACTIVETIME;
        $oldCrudData['VFCOUNT'] = $FaceTempEx->VFCOUNT;
        $oldCrudData['TEMPLATE'] = $FaceTempEx->TEMPLATE;
        $oldCrudData['FaceType'] = $FaceTempEx->FaceType;
        $oldCrudData['StateMigrationFlag'] = $FaceTempEx->StateMigrationFlag;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "FaceTempEx" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'TEMPLATEID',
            'USERNO',
            'SIZE',
            'pin',
            'FACEID',
            'VALID',
            'RESERVE',
            'ACTIVETIME',
            'VFCOUNT',
            'TEMPLATE',
            'FaceType',
            'StateMigrationFlag',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'TEMPLATEID' => [
                //'required'
            ],


            'USERNO' => [
                //'required'
            ],


            'SIZE' => [
                //'required'
            ],


            'pin' => [
                //'required'
            ],


            'FACEID' => [
                //'required'
            ],


            'VALID' => [
                //'required'
            ],


            'RESERVE' => [
                //'required'
            ],


            'ACTIVETIME' => [
                //'required'
            ],


            'VFCOUNT' => [
                //'required'
            ],


            'TEMPLATE' => [
                //'required'
            ],


            'FaceType' => [
                //'required'
            ],


            'StateMigrationFlag' => [
                //'required'
            ],


        ], $messages = [


            'TEMPLATEID' => ['cette donnee est obligatoire'],


            'USERNO' => ['cette donnee est obligatoire'],


            'SIZE' => ['cette donnee est obligatoire'],


            'pin' => ['cette donnee est obligatoire'],


            'FACEID' => ['cette donnee est obligatoire'],


            'VALID' => ['cette donnee est obligatoire'],


            'RESERVE' => ['cette donnee est obligatoire'],


            'ACTIVETIME' => ['cette donnee est obligatoire'],


            'VFCOUNT' => ['cette donnee est obligatoire'],


            'TEMPLATE' => ['cette donnee est obligatoire'],


            'FaceType' => ['cette donnee est obligatoire'],


            'StateMigrationFlag' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("TEMPLATEID", $data)) {


            if (!empty($data['TEMPLATEID'])) {

                $FaceTempEx->TEMPLATEID = $data['TEMPLATEID'];

            }

        }


        if (array_key_exists("USERNO", $data)) {


            if (!empty($data['USERNO'])) {

                $FaceTempEx->USERNO = $data['USERNO'];

            }

        }


        if (array_key_exists("SIZE", $data)) {


            if (!empty($data['SIZE'])) {

                $FaceTempEx->SIZE = $data['SIZE'];

            }

        }


        if (array_key_exists("pin", $data)) {


            if (!empty($data['pin'])) {

                $FaceTempEx->pin = $data['pin'];

            }

        }


        if (array_key_exists("FACEID", $data)) {


            if (!empty($data['FACEID'])) {

                $FaceTempEx->FACEID = $data['FACEID'];

            }

        }


        if (array_key_exists("VALID", $data)) {


            if (!empty($data['VALID'])) {

                $FaceTempEx->VALID = $data['VALID'];

            }

        }


        if (array_key_exists("RESERVE", $data)) {


            if (!empty($data['RESERVE'])) {

                $FaceTempEx->RESERVE = $data['RESERVE'];

            }

        }


        if (array_key_exists("ACTIVETIME", $data)) {


            if (!empty($data['ACTIVETIME'])) {

                $FaceTempEx->ACTIVETIME = $data['ACTIVETIME'];

            }

        }


        if (array_key_exists("VFCOUNT", $data)) {


            if (!empty($data['VFCOUNT'])) {

                $FaceTempEx->VFCOUNT = $data['VFCOUNT'];

            }

        }


        if (array_key_exists("TEMPLATE", $data)) {


            if (!empty($data['TEMPLATE'])) {

                $FaceTempEx->TEMPLATE = $data['TEMPLATE'];

            }

        }


        if (array_key_exists("FaceType", $data)) {


            if (!empty($data['FaceType'])) {

                $FaceTempEx->FaceType = $data['FaceType'];

            }

        }


        if (array_key_exists("StateMigrationFlag", $data)) {


            if (!empty($data['StateMigrationFlag'])) {

                $FaceTempEx->StateMigrationFlag = $data['StateMigrationFlag'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $FaceTempEx->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\FaceTempExExtras') &&
            method_exists('\App\Http\Extras\FaceTempExExtras', 'beforeSaveUpdate')
        ) {
            FaceTempExExtras::beforeSaveUpdate($request, $FaceTempEx);
        }

        $FaceTempEx->save();
        $FaceTempEx = FaceTempEx::find($FaceTempEx->id);


        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $FaceTempEx->TEMPLATEID;
        $newCrudData['USERNO'] = $FaceTempEx->USERNO;
        $newCrudData['SIZE'] = $FaceTempEx->SIZE;
        $newCrudData['pin'] = $FaceTempEx->pin;
        $newCrudData['FACEID'] = $FaceTempEx->FACEID;
        $newCrudData['VALID'] = $FaceTempEx->VALID;
        $newCrudData['RESERVE'] = $FaceTempEx->RESERVE;
        $newCrudData['ACTIVETIME'] = $FaceTempEx->ACTIVETIME;
        $newCrudData['VFCOUNT'] = $FaceTempEx->VFCOUNT;
        $newCrudData['TEMPLATE'] = $FaceTempEx->TEMPLATE;
        $newCrudData['FaceType'] = $FaceTempEx->FaceType;
        $newCrudData['StateMigrationFlag'] = $FaceTempEx->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'FaceTempEx', 'entite_cle' => $FaceTempEx->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $FaceTempEx->toArray();


        try {

            foreach ($FaceTempEx->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, FaceTempEx $FaceTempEx)
    {


        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $FaceTempEx->TEMPLATEID;
        $newCrudData['USERNO'] = $FaceTempEx->USERNO;
        $newCrudData['SIZE'] = $FaceTempEx->SIZE;
        $newCrudData['pin'] = $FaceTempEx->pin;
        $newCrudData['FACEID'] = $FaceTempEx->FACEID;
        $newCrudData['VALID'] = $FaceTempEx->VALID;
        $newCrudData['RESERVE'] = $FaceTempEx->RESERVE;
        $newCrudData['ACTIVETIME'] = $FaceTempEx->ACTIVETIME;
        $newCrudData['VFCOUNT'] = $FaceTempEx->VFCOUNT;
        $newCrudData['TEMPLATE'] = $FaceTempEx->TEMPLATE;
        $newCrudData['FaceType'] = $FaceTempEx->FaceType;
        $newCrudData['StateMigrationFlag'] = $FaceTempEx->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'FaceTempEx', 'entite_cle' => $FaceTempEx->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $FaceTempEx->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new FaceTempExActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
