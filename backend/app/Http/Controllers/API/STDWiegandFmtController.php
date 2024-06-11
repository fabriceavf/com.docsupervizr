<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\STD_WiegandFmtActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\STD_WiegandFmtExtras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\STDWiegandFmt;
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

// use App\Repository\prod\STD_WiegandFmtRepository;


class STDWiegandFmtController extends Controller
{

    private $STD_WiegandFmtRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\STD_WiegandFmtRepository $STD_WiegandFmtRepository
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
        $query = STDWiegandFmt::query();
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
            class_exists('\App\Http\Extras\STD_WiegandFmtExtras') &&
            method_exists('\App\Http\Extras\STD_WiegandFmtExtras', 'filterAgGridQuery')
        ) {
            STD_WiegandFmtExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('STD_WiegandFmt', $query);
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
            return response()->json(STDWiegandFmt::count());
        }
        $data = QueryBuilder::for(STDWiegandFmt::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('DoorId'),


                AllowedFilter::exact('OutWiegandFmt'),


                AllowedFilter::exact('OutFailureId'),


                AllowedFilter::exact('OutAreaCode'),


                AllowedFilter::exact('OutPulseWidth'),


                AllowedFilter::exact('OutPulseInterval'),


                AllowedFilter::exact('OutContent'),


                AllowedFilter::exact('InWiegandFmt'),


                AllowedFilter::exact('InBitCount'),


                AllowedFilter::exact('InPulseWidth'),


                AllowedFilter::exact('InPulseInterval'),


                AllowedFilter::exact('InContent'),


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


                AllowedSort::field('DoorId'),


                AllowedSort::field('OutWiegandFmt'),


                AllowedSort::field('OutFailureId'),


                AllowedSort::field('OutAreaCode'),


                AllowedSort::field('OutPulseWidth'),


                AllowedSort::field('OutPulseInterval'),


                AllowedSort::field('OutContent'),


                AllowedSort::field('InWiegandFmt'),


                AllowedSort::field('InBitCount'),


                AllowedSort::field('InPulseWidth'),


                AllowedSort::field('InPulseInterval'),


                AllowedSort::field('InContent'),


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


        $data = QueryBuilder::for(STDWiegandFmt::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('DoorId'),


                AllowedFilter::exact('OutWiegandFmt'),


                AllowedFilter::exact('OutFailureId'),


                AllowedFilter::exact('OutAreaCode'),


                AllowedFilter::exact('OutPulseWidth'),


                AllowedFilter::exact('OutPulseInterval'),


                AllowedFilter::exact('OutContent'),


                AllowedFilter::exact('InWiegandFmt'),


                AllowedFilter::exact('InBitCount'),


                AllowedFilter::exact('InPulseWidth'),


                AllowedFilter::exact('InPulseInterval'),


                AllowedFilter::exact('InContent'),


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


                AllowedSort::field('DoorId'),


                AllowedSort::field('OutWiegandFmt'),


                AllowedSort::field('OutFailureId'),


                AllowedSort::field('OutAreaCode'),


                AllowedSort::field('OutPulseWidth'),


                AllowedSort::field('OutPulseInterval'),


                AllowedSort::field('OutContent'),


                AllowedSort::field('InWiegandFmt'),


                AllowedSort::field('InBitCount'),


                AllowedSort::field('InPulseWidth'),


                AllowedSort::field('InPulseInterval'),


                AllowedSort::field('InContent'),


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


    public function create(Request $request, STDWiegandFmt $STD_WiegandFmt)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "STD_WiegandFmt" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'DoorId',
            'OutWiegandFmt',
            'OutFailureId',
            'OutAreaCode',
            'OutPulseWidth',
            'OutPulseInterval',
            'OutContent',
            'InWiegandFmt',
            'InBitCount',
            'InPulseWidth',
            'InPulseInterval',
            'InContent',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'DoorId' => [
                //'required'
            ],


            'OutWiegandFmt' => [
                //'required'
            ],


            'OutFailureId' => [
                //'required'
            ],


            'OutAreaCode' => [
                //'required'
            ],


            'OutPulseWidth' => [
                //'required'
            ],


            'OutPulseInterval' => [
                //'required'
            ],


            'OutContent' => [
                //'required'
            ],


            'InWiegandFmt' => [
                //'required'
            ],


            'InBitCount' => [
                //'required'
            ],


            'InPulseWidth' => [
                //'required'
            ],


            'InPulseInterval' => [
                //'required'
            ],


            'InContent' => [
                //'required'
            ],


        ], $messages = [


            'DoorId' => ['cette donnee est obligatoire'],


            'OutWiegandFmt' => ['cette donnee est obligatoire'],


            'OutFailureId' => ['cette donnee est obligatoire'],


            'OutAreaCode' => ['cette donnee est obligatoire'],


            'OutPulseWidth' => ['cette donnee est obligatoire'],


            'OutPulseInterval' => ['cette donnee est obligatoire'],


            'OutContent' => ['cette donnee est obligatoire'],


            'InWiegandFmt' => ['cette donnee est obligatoire'],


            'InBitCount' => ['cette donnee est obligatoire'],


            'InPulseWidth' => ['cette donnee est obligatoire'],


            'InPulseInterval' => ['cette donnee est obligatoire'],


            'InContent' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['DoorId'])) {

            $STD_WiegandFmt->DoorId = $data['DoorId'];

        }


        if (!empty($data['OutWiegandFmt'])) {

            $STD_WiegandFmt->OutWiegandFmt = $data['OutWiegandFmt'];

        }


        if (!empty($data['OutFailureId'])) {

            $STD_WiegandFmt->OutFailureId = $data['OutFailureId'];

        }


        if (!empty($data['OutAreaCode'])) {

            $STD_WiegandFmt->OutAreaCode = $data['OutAreaCode'];

        }


        if (!empty($data['OutPulseWidth'])) {

            $STD_WiegandFmt->OutPulseWidth = $data['OutPulseWidth'];

        }


        if (!empty($data['OutPulseInterval'])) {

            $STD_WiegandFmt->OutPulseInterval = $data['OutPulseInterval'];

        }


        if (!empty($data['OutContent'])) {

            $STD_WiegandFmt->OutContent = $data['OutContent'];

        }


        if (!empty($data['InWiegandFmt'])) {

            $STD_WiegandFmt->InWiegandFmt = $data['InWiegandFmt'];

        }


        if (!empty($data['InBitCount'])) {

            $STD_WiegandFmt->InBitCount = $data['InBitCount'];

        }


        if (!empty($data['InPulseWidth'])) {

            $STD_WiegandFmt->InPulseWidth = $data['InPulseWidth'];

        }


        if (!empty($data['InPulseInterval'])) {

            $STD_WiegandFmt->InPulseInterval = $data['InPulseInterval'];

        }


        if (!empty($data['InContent'])) {

            $STD_WiegandFmt->InContent = $data['InContent'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $STD_WiegandFmt->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\STD_WiegandFmtExtras') &&
            method_exists('\App\Http\Extras\STD_WiegandFmtExtras', 'beforeSaveCreate')
        ) {
            STD_WiegandFmtExtras::beforeSaveCreate($request, $STD_WiegandFmt);
        }


        $STD_WiegandFmt->save();
        $STD_WiegandFmt = STDWiegandFmt::find($STD_WiegandFmt->id);
        $newCrudData = [];

        $newCrudData['DoorId'] = $STD_WiegandFmt->DoorId;
        $newCrudData['OutWiegandFmt'] = $STD_WiegandFmt->OutWiegandFmt;
        $newCrudData['OutFailureId'] = $STD_WiegandFmt->OutFailureId;
        $newCrudData['OutAreaCode'] = $STD_WiegandFmt->OutAreaCode;
        $newCrudData['OutPulseWidth'] = $STD_WiegandFmt->OutPulseWidth;
        $newCrudData['OutPulseInterval'] = $STD_WiegandFmt->OutPulseInterval;
        $newCrudData['OutContent'] = $STD_WiegandFmt->OutContent;
        $newCrudData['InWiegandFmt'] = $STD_WiegandFmt->InWiegandFmt;
        $newCrudData['InBitCount'] = $STD_WiegandFmt->InBitCount;
        $newCrudData['InPulseWidth'] = $STD_WiegandFmt->InPulseWidth;
        $newCrudData['InPulseInterval'] = $STD_WiegandFmt->InPulseInterval;
        $newCrudData['InContent'] = $STD_WiegandFmt->InContent;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'STD_WiegandFmt', 'entite_cle' => $STD_WiegandFmt->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $STD_WiegandFmt->toArray();


        try {

            foreach ($STD_WiegandFmt->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, STDWiegandFmt $STD_WiegandFmt)
    {


        $oldCrudData = [];

        $oldCrudData['DoorId'] = $STD_WiegandFmt->DoorId;
        $oldCrudData['OutWiegandFmt'] = $STD_WiegandFmt->OutWiegandFmt;
        $oldCrudData['OutFailureId'] = $STD_WiegandFmt->OutFailureId;
        $oldCrudData['OutAreaCode'] = $STD_WiegandFmt->OutAreaCode;
        $oldCrudData['OutPulseWidth'] = $STD_WiegandFmt->OutPulseWidth;
        $oldCrudData['OutPulseInterval'] = $STD_WiegandFmt->OutPulseInterval;
        $oldCrudData['OutContent'] = $STD_WiegandFmt->OutContent;
        $oldCrudData['InWiegandFmt'] = $STD_WiegandFmt->InWiegandFmt;
        $oldCrudData['InBitCount'] = $STD_WiegandFmt->InBitCount;
        $oldCrudData['InPulseWidth'] = $STD_WiegandFmt->InPulseWidth;
        $oldCrudData['InPulseInterval'] = $STD_WiegandFmt->InPulseInterval;
        $oldCrudData['InContent'] = $STD_WiegandFmt->InContent;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "STD_WiegandFmt" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'DoorId',
            'OutWiegandFmt',
            'OutFailureId',
            'OutAreaCode',
            'OutPulseWidth',
            'OutPulseInterval',
            'OutContent',
            'InWiegandFmt',
            'InBitCount',
            'InPulseWidth',
            'InPulseInterval',
            'InContent',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'DoorId' => [
                //'required'
            ],


            'OutWiegandFmt' => [
                //'required'
            ],


            'OutFailureId' => [
                //'required'
            ],


            'OutAreaCode' => [
                //'required'
            ],


            'OutPulseWidth' => [
                //'required'
            ],


            'OutPulseInterval' => [
                //'required'
            ],


            'OutContent' => [
                //'required'
            ],


            'InWiegandFmt' => [
                //'required'
            ],


            'InBitCount' => [
                //'required'
            ],


            'InPulseWidth' => [
                //'required'
            ],


            'InPulseInterval' => [
                //'required'
            ],


            'InContent' => [
                //'required'
            ],


        ], $messages = [


            'DoorId' => ['cette donnee est obligatoire'],


            'OutWiegandFmt' => ['cette donnee est obligatoire'],


            'OutFailureId' => ['cette donnee est obligatoire'],


            'OutAreaCode' => ['cette donnee est obligatoire'],


            'OutPulseWidth' => ['cette donnee est obligatoire'],


            'OutPulseInterval' => ['cette donnee est obligatoire'],


            'OutContent' => ['cette donnee est obligatoire'],


            'InWiegandFmt' => ['cette donnee est obligatoire'],


            'InBitCount' => ['cette donnee est obligatoire'],


            'InPulseWidth' => ['cette donnee est obligatoire'],


            'InPulseInterval' => ['cette donnee est obligatoire'],


            'InContent' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("DoorId", $data)) {


            if (!empty($data['DoorId'])) {

                $STD_WiegandFmt->DoorId = $data['DoorId'];

            }

        }


        if (array_key_exists("OutWiegandFmt", $data)) {


            if (!empty($data['OutWiegandFmt'])) {

                $STD_WiegandFmt->OutWiegandFmt = $data['OutWiegandFmt'];

            }

        }


        if (array_key_exists("OutFailureId", $data)) {


            if (!empty($data['OutFailureId'])) {

                $STD_WiegandFmt->OutFailureId = $data['OutFailureId'];

            }

        }


        if (array_key_exists("OutAreaCode", $data)) {


            if (!empty($data['OutAreaCode'])) {

                $STD_WiegandFmt->OutAreaCode = $data['OutAreaCode'];

            }

        }


        if (array_key_exists("OutPulseWidth", $data)) {


            if (!empty($data['OutPulseWidth'])) {

                $STD_WiegandFmt->OutPulseWidth = $data['OutPulseWidth'];

            }

        }


        if (array_key_exists("OutPulseInterval", $data)) {


            if (!empty($data['OutPulseInterval'])) {

                $STD_WiegandFmt->OutPulseInterval = $data['OutPulseInterval'];

            }

        }


        if (array_key_exists("OutContent", $data)) {


            if (!empty($data['OutContent'])) {

                $STD_WiegandFmt->OutContent = $data['OutContent'];

            }

        }


        if (array_key_exists("InWiegandFmt", $data)) {


            if (!empty($data['InWiegandFmt'])) {

                $STD_WiegandFmt->InWiegandFmt = $data['InWiegandFmt'];

            }

        }


        if (array_key_exists("InBitCount", $data)) {


            if (!empty($data['InBitCount'])) {

                $STD_WiegandFmt->InBitCount = $data['InBitCount'];

            }

        }


        if (array_key_exists("InPulseWidth", $data)) {


            if (!empty($data['InPulseWidth'])) {

                $STD_WiegandFmt->InPulseWidth = $data['InPulseWidth'];

            }

        }


        if (array_key_exists("InPulseInterval", $data)) {


            if (!empty($data['InPulseInterval'])) {

                $STD_WiegandFmt->InPulseInterval = $data['InPulseInterval'];

            }

        }


        if (array_key_exists("InContent", $data)) {


            if (!empty($data['InContent'])) {

                $STD_WiegandFmt->InContent = $data['InContent'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $STD_WiegandFmt->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\STD_WiegandFmtExtras') &&
            method_exists('\App\Http\Extras\STD_WiegandFmtExtras', 'beforeSaveUpdate')
        ) {
            STD_WiegandFmtExtras::beforeSaveUpdate($request, $STD_WiegandFmt);
        }

        $STD_WiegandFmt->save();
        $STD_WiegandFmt = STDWiegandFmt::find($STD_WiegandFmt->id);


        $newCrudData = [];

        $newCrudData['DoorId'] = $STD_WiegandFmt->DoorId;
        $newCrudData['OutWiegandFmt'] = $STD_WiegandFmt->OutWiegandFmt;
        $newCrudData['OutFailureId'] = $STD_WiegandFmt->OutFailureId;
        $newCrudData['OutAreaCode'] = $STD_WiegandFmt->OutAreaCode;
        $newCrudData['OutPulseWidth'] = $STD_WiegandFmt->OutPulseWidth;
        $newCrudData['OutPulseInterval'] = $STD_WiegandFmt->OutPulseInterval;
        $newCrudData['OutContent'] = $STD_WiegandFmt->OutContent;
        $newCrudData['InWiegandFmt'] = $STD_WiegandFmt->InWiegandFmt;
        $newCrudData['InBitCount'] = $STD_WiegandFmt->InBitCount;
        $newCrudData['InPulseWidth'] = $STD_WiegandFmt->InPulseWidth;
        $newCrudData['InPulseInterval'] = $STD_WiegandFmt->InPulseInterval;
        $newCrudData['InContent'] = $STD_WiegandFmt->InContent;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'STD_WiegandFmt', 'entite_cle' => $STD_WiegandFmt->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $STD_WiegandFmt->toArray();


        try {

            foreach ($STD_WiegandFmt->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, STDWiegandFmt $STD_WiegandFmt)
    {


        $newCrudData = [];

        $newCrudData['DoorId'] = $STD_WiegandFmt->DoorId;
        $newCrudData['OutWiegandFmt'] = $STD_WiegandFmt->OutWiegandFmt;
        $newCrudData['OutFailureId'] = $STD_WiegandFmt->OutFailureId;
        $newCrudData['OutAreaCode'] = $STD_WiegandFmt->OutAreaCode;
        $newCrudData['OutPulseWidth'] = $STD_WiegandFmt->OutPulseWidth;
        $newCrudData['OutPulseInterval'] = $STD_WiegandFmt->OutPulseInterval;
        $newCrudData['OutContent'] = $STD_WiegandFmt->OutContent;
        $newCrudData['InWiegandFmt'] = $STD_WiegandFmt->InWiegandFmt;
        $newCrudData['InBitCount'] = $STD_WiegandFmt->InBitCount;
        $newCrudData['InPulseWidth'] = $STD_WiegandFmt->InPulseWidth;
        $newCrudData['InPulseInterval'] = $STD_WiegandFmt->InPulseInterval;
        $newCrudData['InContent'] = $STD_WiegandFmt->InContent;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'STD_WiegandFmt', 'entite_cle' => $STD_WiegandFmt->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $STD_WiegandFmt->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new STD_WiegandFmtActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
