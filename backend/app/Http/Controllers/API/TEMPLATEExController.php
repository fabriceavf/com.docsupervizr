<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\TEMPLATEExActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\TEMPLATEExExtras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\TEMPLATEEx;
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

// use App\Repository\prod\TEMPLATEExRepository;


class TEMPLATEExController extends Controller
{

    private $TEMPLATEExRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\TEMPLATEExRepository $TEMPLATEExRepository
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
        $query = TEMPLATEEx::query();
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
            class_exists('\App\Http\Extras\TEMPLATEExExtras') &&
            method_exists('\App\Http\Extras\TEMPLATEExExtras', 'filterAgGridQuery')
        ) {
            TEMPLATEExExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('TEMPLATEEx', $query);
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
            return response()->json(TEMPLATEEx::count());
        }
        $data = QueryBuilder::for(TEMPLATEEx::class)
            ->allowedFilters([
                AllowedFilter::exact('TEMPLATEID'),


                AllowedFilter::exact('USERID'),


                AllowedFilter::exact('FINGERID'),


                AllowedFilter::exact('TEMPLATE'),


                AllowedFilter::exact('TEMPLATE2'),


                AllowedFilter::exact('BITMAPPICTURE'),


                AllowedFilter::exact('BITMAPPICTURE2'),


                AllowedFilter::exact('BITMAPPICTURE3'),


                AllowedFilter::exact('BITMAPPICTURE4'),


                AllowedFilter::exact('USETYPE'),


                AllowedFilter::exact('EMACHINENUM'),


                AllowedFilter::exact('TEMPLATE1'),


                AllowedFilter::exact('Flag'),


                AllowedFilter::exact('DivisionFP'),


                AllowedFilter::exact('TEMPLATE4'),


                AllowedFilter::exact('TEMPLATE3'),


                AllowedFilter::exact('change_operator'),


                AllowedFilter::exact('change_time'),


                AllowedFilter::exact('create_operator'),


                AllowedFilter::exact('create_time'),


                AllowedFilter::exact('delete_operator'),


                AllowedFilter::exact('delete_time'),


                AllowedFilter::exact('status'),


                AllowedFilter::exact('Valid'),


                AllowedFilter::exact('Fpversion'),


                AllowedFilter::exact('bio_type'),


                AllowedFilter::exact('SN'),


                AllowedFilter::exact('UTime'),


                AllowedFilter::exact('FP10SIZE'),


                AllowedFilter::exact('DuressFlag'),


                AllowedFilter::exact('TEMPLATESIZE'),


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


                AllowedSort::field('USERID'),


                AllowedSort::field('FINGERID'),


                AllowedSort::field('TEMPLATE'),


                AllowedSort::field('TEMPLATE2'),


                AllowedSort::field('BITMAPPICTURE'),


                AllowedSort::field('BITMAPPICTURE2'),


                AllowedSort::field('BITMAPPICTURE3'),


                AllowedSort::field('BITMAPPICTURE4'),


                AllowedSort::field('USETYPE'),


                AllowedSort::field('EMACHINENUM'),


                AllowedSort::field('TEMPLATE1'),


                AllowedSort::field('Flag'),


                AllowedSort::field('DivisionFP'),


                AllowedSort::field('TEMPLATE4'),


                AllowedSort::field('TEMPLATE3'),


                AllowedSort::field('change_operator'),


                AllowedSort::field('change_time'),


                AllowedSort::field('create_operator'),


                AllowedSort::field('create_time'),


                AllowedSort::field('delete_operator'),


                AllowedSort::field('delete_time'),


                AllowedSort::field('status'),


                AllowedSort::field('Valid'),


                AllowedSort::field('Fpversion'),


                AllowedSort::field('bio_type'),


                AllowedSort::field('SN'),


                AllowedSort::field('UTime'),


                AllowedSort::field('FP10SIZE'),


                AllowedSort::field('DuressFlag'),


                AllowedSort::field('TEMPLATESIZE'),


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


        $data = QueryBuilder::for(TEMPLATEEx::class)
            ->allowedFilters([
                AllowedFilter::exact('TEMPLATEID'),


                AllowedFilter::exact('USERID'),


                AllowedFilter::exact('FINGERID'),


                AllowedFilter::exact('TEMPLATE'),


                AllowedFilter::exact('TEMPLATE2'),


                AllowedFilter::exact('BITMAPPICTURE'),


                AllowedFilter::exact('BITMAPPICTURE2'),


                AllowedFilter::exact('BITMAPPICTURE3'),


                AllowedFilter::exact('BITMAPPICTURE4'),


                AllowedFilter::exact('USETYPE'),


                AllowedFilter::exact('EMACHINENUM'),


                AllowedFilter::exact('TEMPLATE1'),


                AllowedFilter::exact('Flag'),


                AllowedFilter::exact('DivisionFP'),


                AllowedFilter::exact('TEMPLATE4'),


                AllowedFilter::exact('TEMPLATE3'),


                AllowedFilter::exact('change_operator'),


                AllowedFilter::exact('change_time'),


                AllowedFilter::exact('create_operator'),


                AllowedFilter::exact('create_time'),


                AllowedFilter::exact('delete_operator'),


                AllowedFilter::exact('delete_time'),


                AllowedFilter::exact('status'),


                AllowedFilter::exact('Valid'),


                AllowedFilter::exact('Fpversion'),


                AllowedFilter::exact('bio_type'),


                AllowedFilter::exact('SN'),


                AllowedFilter::exact('UTime'),


                AllowedFilter::exact('FP10SIZE'),


                AllowedFilter::exact('DuressFlag'),


                AllowedFilter::exact('TEMPLATESIZE'),


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


                AllowedSort::field('USERID'),


                AllowedSort::field('FINGERID'),


                AllowedSort::field('TEMPLATE'),


                AllowedSort::field('TEMPLATE2'),


                AllowedSort::field('BITMAPPICTURE'),


                AllowedSort::field('BITMAPPICTURE2'),


                AllowedSort::field('BITMAPPICTURE3'),


                AllowedSort::field('BITMAPPICTURE4'),


                AllowedSort::field('USETYPE'),


                AllowedSort::field('EMACHINENUM'),


                AllowedSort::field('TEMPLATE1'),


                AllowedSort::field('Flag'),


                AllowedSort::field('DivisionFP'),


                AllowedSort::field('TEMPLATE4'),


                AllowedSort::field('TEMPLATE3'),


                AllowedSort::field('change_operator'),


                AllowedSort::field('change_time'),


                AllowedSort::field('create_operator'),


                AllowedSort::field('create_time'),


                AllowedSort::field('delete_operator'),


                AllowedSort::field('delete_time'),


                AllowedSort::field('status'),


                AllowedSort::field('Valid'),


                AllowedSort::field('Fpversion'),


                AllowedSort::field('bio_type'),


                AllowedSort::field('SN'),


                AllowedSort::field('UTime'),


                AllowedSort::field('FP10SIZE'),


                AllowedSort::field('DuressFlag'),


                AllowedSort::field('TEMPLATESIZE'),


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


    public function create(Request $request, TEMPLATEEx $TEMPLATEEx)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "TEMPLATEEx" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'TEMPLATEID',
            'USERID',
            'FINGERID',
            'TEMPLATE',
            'TEMPLATE2',
            'BITMAPPICTURE',
            'BITMAPPICTURE2',
            'BITMAPPICTURE3',
            'BITMAPPICTURE4',
            'USETYPE',
            'EMACHINENUM',
            'TEMPLATE1',
            'Flag',
            'DivisionFP',
            'TEMPLATE4',
            'TEMPLATE3',
            'change_operator',
            'change_time',
            'create_operator',
            'create_time',
            'delete_operator',
            'delete_time',
            'status',
            'Valid',
            'Fpversion',
            'bio_type',
            'SN',
            'UTime',
            'FP10SIZE',
            'DuressFlag',
            'TEMPLATESIZE',
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


            'USERID' => [
                //'required'
            ],


            'FINGERID' => [
                //'required'
            ],


            'TEMPLATE' => [
                //'required'
            ],


            'TEMPLATE2' => [
                //'required'
            ],


            'BITMAPPICTURE' => [
                //'required'
            ],


            'BITMAPPICTURE2' => [
                //'required'
            ],


            'BITMAPPICTURE3' => [
                //'required'
            ],


            'BITMAPPICTURE4' => [
                //'required'
            ],


            'USETYPE' => [
                //'required'
            ],


            'EMACHINENUM' => [
                //'required'
            ],


            'TEMPLATE1' => [
                //'required'
            ],


            'Flag' => [
                //'required'
            ],


            'DivisionFP' => [
                //'required'
            ],


            'TEMPLATE4' => [
                //'required'
            ],


            'TEMPLATE3' => [
                //'required'
            ],


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


            'Valid' => [
                //'required'
            ],


            'Fpversion' => [
                //'required'
            ],


            'bio_type' => [
                //'required'
            ],


            'SN' => [
                //'required'
            ],


            'UTime' => [
                //'required'
            ],


            'FP10SIZE' => [
                //'required'
            ],


            'DuressFlag' => [
                //'required'
            ],


            'TEMPLATESIZE' => [
                //'required'
            ],


            'StateMigrationFlag' => [
                //'required'
            ],


        ], $messages = [


            'TEMPLATEID' => ['cette donnee est obligatoire'],


            'USERID' => ['cette donnee est obligatoire'],


            'FINGERID' => ['cette donnee est obligatoire'],


            'TEMPLATE' => ['cette donnee est obligatoire'],


            'TEMPLATE2' => ['cette donnee est obligatoire'],


            'BITMAPPICTURE' => ['cette donnee est obligatoire'],


            'BITMAPPICTURE2' => ['cette donnee est obligatoire'],


            'BITMAPPICTURE3' => ['cette donnee est obligatoire'],


            'BITMAPPICTURE4' => ['cette donnee est obligatoire'],


            'USETYPE' => ['cette donnee est obligatoire'],


            'EMACHINENUM' => ['cette donnee est obligatoire'],


            'TEMPLATE1' => ['cette donnee est obligatoire'],


            'Flag' => ['cette donnee est obligatoire'],


            'DivisionFP' => ['cette donnee est obligatoire'],


            'TEMPLATE4' => ['cette donnee est obligatoire'],


            'TEMPLATE3' => ['cette donnee est obligatoire'],


            'change_operator' => ['cette donnee est obligatoire'],


            'change_time' => ['cette donnee est obligatoire'],


            'create_operator' => ['cette donnee est obligatoire'],


            'create_time' => ['cette donnee est obligatoire'],


            'delete_operator' => ['cette donnee est obligatoire'],


            'delete_time' => ['cette donnee est obligatoire'],


            'status' => ['cette donnee est obligatoire'],


            'Valid' => ['cette donnee est obligatoire'],


            'Fpversion' => ['cette donnee est obligatoire'],


            'bio_type' => ['cette donnee est obligatoire'],


            'SN' => ['cette donnee est obligatoire'],


            'UTime' => ['cette donnee est obligatoire'],


            'FP10SIZE' => ['cette donnee est obligatoire'],


            'DuressFlag' => ['cette donnee est obligatoire'],


            'TEMPLATESIZE' => ['cette donnee est obligatoire'],


            'StateMigrationFlag' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['TEMPLATEID'])) {

            $TEMPLATEEx->TEMPLATEID = $data['TEMPLATEID'];

        }


        if (!empty($data['USERID'])) {

            $TEMPLATEEx->USERID = $data['USERID'];

        }


        if (!empty($data['FINGERID'])) {

            $TEMPLATEEx->FINGERID = $data['FINGERID'];

        }


        if (!empty($data['TEMPLATE'])) {

            $TEMPLATEEx->TEMPLATE = $data['TEMPLATE'];

        }


        if (!empty($data['TEMPLATE2'])) {

            $TEMPLATEEx->TEMPLATE2 = $data['TEMPLATE2'];

        }


        if (!empty($data['BITMAPPICTURE'])) {

            $TEMPLATEEx->BITMAPPICTURE = $data['BITMAPPICTURE'];

        }


        if (!empty($data['BITMAPPICTURE2'])) {

            $TEMPLATEEx->BITMAPPICTURE2 = $data['BITMAPPICTURE2'];

        }


        if (!empty($data['BITMAPPICTURE3'])) {

            $TEMPLATEEx->BITMAPPICTURE3 = $data['BITMAPPICTURE3'];

        }


        if (!empty($data['BITMAPPICTURE4'])) {

            $TEMPLATEEx->BITMAPPICTURE4 = $data['BITMAPPICTURE4'];

        }


        if (!empty($data['USETYPE'])) {

            $TEMPLATEEx->USETYPE = $data['USETYPE'];

        }


        if (!empty($data['EMACHINENUM'])) {

            $TEMPLATEEx->EMACHINENUM = $data['EMACHINENUM'];

        }


        if (!empty($data['TEMPLATE1'])) {

            $TEMPLATEEx->TEMPLATE1 = $data['TEMPLATE1'];

        }


        if (!empty($data['Flag'])) {

            $TEMPLATEEx->Flag = $data['Flag'];

        }


        if (!empty($data['DivisionFP'])) {

            $TEMPLATEEx->DivisionFP = $data['DivisionFP'];

        }


        if (!empty($data['TEMPLATE4'])) {

            $TEMPLATEEx->TEMPLATE4 = $data['TEMPLATE4'];

        }


        if (!empty($data['TEMPLATE3'])) {

            $TEMPLATEEx->TEMPLATE3 = $data['TEMPLATE3'];

        }


        if (!empty($data['change_operator'])) {

            $TEMPLATEEx->change_operator = $data['change_operator'];

        }


        if (!empty($data['change_time'])) {

            $TEMPLATEEx->change_time = $data['change_time'];

        }


        if (!empty($data['create_operator'])) {

            $TEMPLATEEx->create_operator = $data['create_operator'];

        }


        if (!empty($data['create_time'])) {

            $TEMPLATEEx->create_time = $data['create_time'];

        }


        if (!empty($data['delete_operator'])) {

            $TEMPLATEEx->delete_operator = $data['delete_operator'];

        }


        if (!empty($data['delete_time'])) {

            $TEMPLATEEx->delete_time = $data['delete_time'];

        }


        if (!empty($data['status'])) {

            $TEMPLATEEx->status = $data['status'];

        }


        if (!empty($data['Valid'])) {

            $TEMPLATEEx->Valid = $data['Valid'];

        }


        if (!empty($data['Fpversion'])) {

            $TEMPLATEEx->Fpversion = $data['Fpversion'];

        }


        if (!empty($data['bio_type'])) {

            $TEMPLATEEx->bio_type = $data['bio_type'];

        }


        if (!empty($data['SN'])) {

            $TEMPLATEEx->SN = $data['SN'];

        }


        if (!empty($data['UTime'])) {

            $TEMPLATEEx->UTime = $data['UTime'];

        }


        if (!empty($data['FP10SIZE'])) {

            $TEMPLATEEx->FP10SIZE = $data['FP10SIZE'];

        }


        if (!empty($data['DuressFlag'])) {

            $TEMPLATEEx->DuressFlag = $data['DuressFlag'];

        }


        if (!empty($data['TEMPLATESIZE'])) {

            $TEMPLATEEx->TEMPLATESIZE = $data['TEMPLATESIZE'];

        }


        if (!empty($data['StateMigrationFlag'])) {

            $TEMPLATEEx->StateMigrationFlag = $data['StateMigrationFlag'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $TEMPLATEEx->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\TEMPLATEExExtras') &&
            method_exists('\App\Http\Extras\TEMPLATEExExtras', 'beforeSaveCreate')
        ) {
            TEMPLATEExExtras::beforeSaveCreate($request, $TEMPLATEEx);
        }


        $TEMPLATEEx->save();
        $TEMPLATEEx = TEMPLATEEx::find($TEMPLATEEx->id);
        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $TEMPLATEEx->TEMPLATEID;
        $newCrudData['USERID'] = $TEMPLATEEx->USERID;
        $newCrudData['FINGERID'] = $TEMPLATEEx->FINGERID;
        $newCrudData['TEMPLATE'] = $TEMPLATEEx->TEMPLATE;
        $newCrudData['TEMPLATE2'] = $TEMPLATEEx->TEMPLATE2;
        $newCrudData['BITMAPPICTURE'] = $TEMPLATEEx->BITMAPPICTURE;
        $newCrudData['BITMAPPICTURE2'] = $TEMPLATEEx->BITMAPPICTURE2;
        $newCrudData['BITMAPPICTURE3'] = $TEMPLATEEx->BITMAPPICTURE3;
        $newCrudData['BITMAPPICTURE4'] = $TEMPLATEEx->BITMAPPICTURE4;
        $newCrudData['USETYPE'] = $TEMPLATEEx->USETYPE;
        $newCrudData['EMACHINENUM'] = $TEMPLATEEx->EMACHINENUM;
        $newCrudData['TEMPLATE1'] = $TEMPLATEEx->TEMPLATE1;
        $newCrudData['Flag'] = $TEMPLATEEx->Flag;
        $newCrudData['DivisionFP'] = $TEMPLATEEx->DivisionFP;
        $newCrudData['TEMPLATE4'] = $TEMPLATEEx->TEMPLATE4;
        $newCrudData['TEMPLATE3'] = $TEMPLATEEx->TEMPLATE3;
        $newCrudData['change_operator'] = $TEMPLATEEx->change_operator;
        $newCrudData['change_time'] = $TEMPLATEEx->change_time;
        $newCrudData['create_operator'] = $TEMPLATEEx->create_operator;
        $newCrudData['create_time'] = $TEMPLATEEx->create_time;
        $newCrudData['delete_operator'] = $TEMPLATEEx->delete_operator;
        $newCrudData['delete_time'] = $TEMPLATEEx->delete_time;
        $newCrudData['status'] = $TEMPLATEEx->status;
        $newCrudData['Valid'] = $TEMPLATEEx->Valid;
        $newCrudData['Fpversion'] = $TEMPLATEEx->Fpversion;
        $newCrudData['bio_type'] = $TEMPLATEEx->bio_type;
        $newCrudData['SN'] = $TEMPLATEEx->SN;
        $newCrudData['UTime'] = $TEMPLATEEx->UTime;
        $newCrudData['FP10SIZE'] = $TEMPLATEEx->FP10SIZE;
        $newCrudData['DuressFlag'] = $TEMPLATEEx->DuressFlag;
        $newCrudData['TEMPLATESIZE'] = $TEMPLATEEx->TEMPLATESIZE;
        $newCrudData['StateMigrationFlag'] = $TEMPLATEEx->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'TEMPLATEEx', 'entite_cle' => $TEMPLATEEx->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $TEMPLATEEx->toArray();


        try {

            foreach ($TEMPLATEEx->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, TEMPLATEEx $TEMPLATEEx)
    {


        $oldCrudData = [];

        $oldCrudData['TEMPLATEID'] = $TEMPLATEEx->TEMPLATEID;
        $oldCrudData['USERID'] = $TEMPLATEEx->USERID;
        $oldCrudData['FINGERID'] = $TEMPLATEEx->FINGERID;
        $oldCrudData['TEMPLATE'] = $TEMPLATEEx->TEMPLATE;
        $oldCrudData['TEMPLATE2'] = $TEMPLATEEx->TEMPLATE2;
        $oldCrudData['BITMAPPICTURE'] = $TEMPLATEEx->BITMAPPICTURE;
        $oldCrudData['BITMAPPICTURE2'] = $TEMPLATEEx->BITMAPPICTURE2;
        $oldCrudData['BITMAPPICTURE3'] = $TEMPLATEEx->BITMAPPICTURE3;
        $oldCrudData['BITMAPPICTURE4'] = $TEMPLATEEx->BITMAPPICTURE4;
        $oldCrudData['USETYPE'] = $TEMPLATEEx->USETYPE;
        $oldCrudData['EMACHINENUM'] = $TEMPLATEEx->EMACHINENUM;
        $oldCrudData['TEMPLATE1'] = $TEMPLATEEx->TEMPLATE1;
        $oldCrudData['Flag'] = $TEMPLATEEx->Flag;
        $oldCrudData['DivisionFP'] = $TEMPLATEEx->DivisionFP;
        $oldCrudData['TEMPLATE4'] = $TEMPLATEEx->TEMPLATE4;
        $oldCrudData['TEMPLATE3'] = $TEMPLATEEx->TEMPLATE3;
        $oldCrudData['change_operator'] = $TEMPLATEEx->change_operator;
        $oldCrudData['change_time'] = $TEMPLATEEx->change_time;
        $oldCrudData['create_operator'] = $TEMPLATEEx->create_operator;
        $oldCrudData['create_time'] = $TEMPLATEEx->create_time;
        $oldCrudData['delete_operator'] = $TEMPLATEEx->delete_operator;
        $oldCrudData['delete_time'] = $TEMPLATEEx->delete_time;
        $oldCrudData['status'] = $TEMPLATEEx->status;
        $oldCrudData['Valid'] = $TEMPLATEEx->Valid;
        $oldCrudData['Fpversion'] = $TEMPLATEEx->Fpversion;
        $oldCrudData['bio_type'] = $TEMPLATEEx->bio_type;
        $oldCrudData['SN'] = $TEMPLATEEx->SN;
        $oldCrudData['UTime'] = $TEMPLATEEx->UTime;
        $oldCrudData['FP10SIZE'] = $TEMPLATEEx->FP10SIZE;
        $oldCrudData['DuressFlag'] = $TEMPLATEEx->DuressFlag;
        $oldCrudData['TEMPLATESIZE'] = $TEMPLATEEx->TEMPLATESIZE;
        $oldCrudData['StateMigrationFlag'] = $TEMPLATEEx->StateMigrationFlag;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "TEMPLATEEx" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'TEMPLATEID',
            'USERID',
            'FINGERID',
            'TEMPLATE',
            'TEMPLATE2',
            'BITMAPPICTURE',
            'BITMAPPICTURE2',
            'BITMAPPICTURE3',
            'BITMAPPICTURE4',
            'USETYPE',
            'EMACHINENUM',
            'TEMPLATE1',
            'Flag',
            'DivisionFP',
            'TEMPLATE4',
            'TEMPLATE3',
            'change_operator',
            'change_time',
            'create_operator',
            'create_time',
            'delete_operator',
            'delete_time',
            'status',
            'Valid',
            'Fpversion',
            'bio_type',
            'SN',
            'UTime',
            'FP10SIZE',
            'DuressFlag',
            'TEMPLATESIZE',
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


            'USERID' => [
                //'required'
            ],


            'FINGERID' => [
                //'required'
            ],


            'TEMPLATE' => [
                //'required'
            ],


            'TEMPLATE2' => [
                //'required'
            ],


            'BITMAPPICTURE' => [
                //'required'
            ],


            'BITMAPPICTURE2' => [
                //'required'
            ],


            'BITMAPPICTURE3' => [
                //'required'
            ],


            'BITMAPPICTURE4' => [
                //'required'
            ],


            'USETYPE' => [
                //'required'
            ],


            'EMACHINENUM' => [
                //'required'
            ],


            'TEMPLATE1' => [
                //'required'
            ],


            'Flag' => [
                //'required'
            ],


            'DivisionFP' => [
                //'required'
            ],


            'TEMPLATE4' => [
                //'required'
            ],


            'TEMPLATE3' => [
                //'required'
            ],


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


            'Valid' => [
                //'required'
            ],


            'Fpversion' => [
                //'required'
            ],


            'bio_type' => [
                //'required'
            ],


            'SN' => [
                //'required'
            ],


            'UTime' => [
                //'required'
            ],


            'FP10SIZE' => [
                //'required'
            ],


            'DuressFlag' => [
                //'required'
            ],


            'TEMPLATESIZE' => [
                //'required'
            ],


            'StateMigrationFlag' => [
                //'required'
            ],


        ], $messages = [


            'TEMPLATEID' => ['cette donnee est obligatoire'],


            'USERID' => ['cette donnee est obligatoire'],


            'FINGERID' => ['cette donnee est obligatoire'],


            'TEMPLATE' => ['cette donnee est obligatoire'],


            'TEMPLATE2' => ['cette donnee est obligatoire'],


            'BITMAPPICTURE' => ['cette donnee est obligatoire'],


            'BITMAPPICTURE2' => ['cette donnee est obligatoire'],


            'BITMAPPICTURE3' => ['cette donnee est obligatoire'],


            'BITMAPPICTURE4' => ['cette donnee est obligatoire'],


            'USETYPE' => ['cette donnee est obligatoire'],


            'EMACHINENUM' => ['cette donnee est obligatoire'],


            'TEMPLATE1' => ['cette donnee est obligatoire'],


            'Flag' => ['cette donnee est obligatoire'],


            'DivisionFP' => ['cette donnee est obligatoire'],


            'TEMPLATE4' => ['cette donnee est obligatoire'],


            'TEMPLATE3' => ['cette donnee est obligatoire'],


            'change_operator' => ['cette donnee est obligatoire'],


            'change_time' => ['cette donnee est obligatoire'],


            'create_operator' => ['cette donnee est obligatoire'],


            'create_time' => ['cette donnee est obligatoire'],


            'delete_operator' => ['cette donnee est obligatoire'],


            'delete_time' => ['cette donnee est obligatoire'],


            'status' => ['cette donnee est obligatoire'],


            'Valid' => ['cette donnee est obligatoire'],


            'Fpversion' => ['cette donnee est obligatoire'],


            'bio_type' => ['cette donnee est obligatoire'],


            'SN' => ['cette donnee est obligatoire'],


            'UTime' => ['cette donnee est obligatoire'],


            'FP10SIZE' => ['cette donnee est obligatoire'],


            'DuressFlag' => ['cette donnee est obligatoire'],


            'TEMPLATESIZE' => ['cette donnee est obligatoire'],


            'StateMigrationFlag' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("TEMPLATEID", $data)) {


            if (!empty($data['TEMPLATEID'])) {

                $TEMPLATEEx->TEMPLATEID = $data['TEMPLATEID'];

            }

        }


        if (array_key_exists("USERID", $data)) {


            if (!empty($data['USERID'])) {

                $TEMPLATEEx->USERID = $data['USERID'];

            }

        }


        if (array_key_exists("FINGERID", $data)) {


            if (!empty($data['FINGERID'])) {

                $TEMPLATEEx->FINGERID = $data['FINGERID'];

            }

        }


        if (array_key_exists("TEMPLATE", $data)) {


            if (!empty($data['TEMPLATE'])) {

                $TEMPLATEEx->TEMPLATE = $data['TEMPLATE'];

            }

        }


        if (array_key_exists("TEMPLATE2", $data)) {


            if (!empty($data['TEMPLATE2'])) {

                $TEMPLATEEx->TEMPLATE2 = $data['TEMPLATE2'];

            }

        }


        if (array_key_exists("BITMAPPICTURE", $data)) {


            if (!empty($data['BITMAPPICTURE'])) {

                $TEMPLATEEx->BITMAPPICTURE = $data['BITMAPPICTURE'];

            }

        }


        if (array_key_exists("BITMAPPICTURE2", $data)) {


            if (!empty($data['BITMAPPICTURE2'])) {

                $TEMPLATEEx->BITMAPPICTURE2 = $data['BITMAPPICTURE2'];

            }

        }


        if (array_key_exists("BITMAPPICTURE3", $data)) {


            if (!empty($data['BITMAPPICTURE3'])) {

                $TEMPLATEEx->BITMAPPICTURE3 = $data['BITMAPPICTURE3'];

            }

        }


        if (array_key_exists("BITMAPPICTURE4", $data)) {


            if (!empty($data['BITMAPPICTURE4'])) {

                $TEMPLATEEx->BITMAPPICTURE4 = $data['BITMAPPICTURE4'];

            }

        }


        if (array_key_exists("USETYPE", $data)) {


            if (!empty($data['USETYPE'])) {

                $TEMPLATEEx->USETYPE = $data['USETYPE'];

            }

        }


        if (array_key_exists("EMACHINENUM", $data)) {


            if (!empty($data['EMACHINENUM'])) {

                $TEMPLATEEx->EMACHINENUM = $data['EMACHINENUM'];

            }

        }


        if (array_key_exists("TEMPLATE1", $data)) {


            if (!empty($data['TEMPLATE1'])) {

                $TEMPLATEEx->TEMPLATE1 = $data['TEMPLATE1'];

            }

        }


        if (array_key_exists("Flag", $data)) {


            if (!empty($data['Flag'])) {

                $TEMPLATEEx->Flag = $data['Flag'];

            }

        }


        if (array_key_exists("DivisionFP", $data)) {


            if (!empty($data['DivisionFP'])) {

                $TEMPLATEEx->DivisionFP = $data['DivisionFP'];

            }

        }


        if (array_key_exists("TEMPLATE4", $data)) {


            if (!empty($data['TEMPLATE4'])) {

                $TEMPLATEEx->TEMPLATE4 = $data['TEMPLATE4'];

            }

        }


        if (array_key_exists("TEMPLATE3", $data)) {


            if (!empty($data['TEMPLATE3'])) {

                $TEMPLATEEx->TEMPLATE3 = $data['TEMPLATE3'];

            }

        }


        if (array_key_exists("change_operator", $data)) {


            if (!empty($data['change_operator'])) {

                $TEMPLATEEx->change_operator = $data['change_operator'];

            }

        }


        if (array_key_exists("change_time", $data)) {


            if (!empty($data['change_time'])) {

                $TEMPLATEEx->change_time = $data['change_time'];

            }

        }


        if (array_key_exists("create_operator", $data)) {


            if (!empty($data['create_operator'])) {

                $TEMPLATEEx->create_operator = $data['create_operator'];

            }

        }


        if (array_key_exists("create_time", $data)) {


            if (!empty($data['create_time'])) {

                $TEMPLATEEx->create_time = $data['create_time'];

            }

        }


        if (array_key_exists("delete_operator", $data)) {


            if (!empty($data['delete_operator'])) {

                $TEMPLATEEx->delete_operator = $data['delete_operator'];

            }

        }


        if (array_key_exists("delete_time", $data)) {


            if (!empty($data['delete_time'])) {

                $TEMPLATEEx->delete_time = $data['delete_time'];

            }

        }


        if (array_key_exists("status", $data)) {


            if (!empty($data['status'])) {

                $TEMPLATEEx->status = $data['status'];

            }

        }


        if (array_key_exists("Valid", $data)) {


            if (!empty($data['Valid'])) {

                $TEMPLATEEx->Valid = $data['Valid'];

            }

        }


        if (array_key_exists("Fpversion", $data)) {


            if (!empty($data['Fpversion'])) {

                $TEMPLATEEx->Fpversion = $data['Fpversion'];

            }

        }


        if (array_key_exists("bio_type", $data)) {


            if (!empty($data['bio_type'])) {

                $TEMPLATEEx->bio_type = $data['bio_type'];

            }

        }


        if (array_key_exists("SN", $data)) {


            if (!empty($data['SN'])) {

                $TEMPLATEEx->SN = $data['SN'];

            }

        }


        if (array_key_exists("UTime", $data)) {


            if (!empty($data['UTime'])) {

                $TEMPLATEEx->UTime = $data['UTime'];

            }

        }


        if (array_key_exists("FP10SIZE", $data)) {


            if (!empty($data['FP10SIZE'])) {

                $TEMPLATEEx->FP10SIZE = $data['FP10SIZE'];

            }

        }


        if (array_key_exists("DuressFlag", $data)) {


            if (!empty($data['DuressFlag'])) {

                $TEMPLATEEx->DuressFlag = $data['DuressFlag'];

            }

        }


        if (array_key_exists("TEMPLATESIZE", $data)) {


            if (!empty($data['TEMPLATESIZE'])) {

                $TEMPLATEEx->TEMPLATESIZE = $data['TEMPLATESIZE'];

            }

        }


        if (array_key_exists("StateMigrationFlag", $data)) {


            if (!empty($data['StateMigrationFlag'])) {

                $TEMPLATEEx->StateMigrationFlag = $data['StateMigrationFlag'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $TEMPLATEEx->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\TEMPLATEExExtras') &&
            method_exists('\App\Http\Extras\TEMPLATEExExtras', 'beforeSaveUpdate')
        ) {
            TEMPLATEExExtras::beforeSaveUpdate($request, $TEMPLATEEx);
        }

        $TEMPLATEEx->save();
        $TEMPLATEEx = TEMPLATEEx::find($TEMPLATEEx->id);


        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $TEMPLATEEx->TEMPLATEID;
        $newCrudData['USERID'] = $TEMPLATEEx->USERID;
        $newCrudData['FINGERID'] = $TEMPLATEEx->FINGERID;
        $newCrudData['TEMPLATE'] = $TEMPLATEEx->TEMPLATE;
        $newCrudData['TEMPLATE2'] = $TEMPLATEEx->TEMPLATE2;
        $newCrudData['BITMAPPICTURE'] = $TEMPLATEEx->BITMAPPICTURE;
        $newCrudData['BITMAPPICTURE2'] = $TEMPLATEEx->BITMAPPICTURE2;
        $newCrudData['BITMAPPICTURE3'] = $TEMPLATEEx->BITMAPPICTURE3;
        $newCrudData['BITMAPPICTURE4'] = $TEMPLATEEx->BITMAPPICTURE4;
        $newCrudData['USETYPE'] = $TEMPLATEEx->USETYPE;
        $newCrudData['EMACHINENUM'] = $TEMPLATEEx->EMACHINENUM;
        $newCrudData['TEMPLATE1'] = $TEMPLATEEx->TEMPLATE1;
        $newCrudData['Flag'] = $TEMPLATEEx->Flag;
        $newCrudData['DivisionFP'] = $TEMPLATEEx->DivisionFP;
        $newCrudData['TEMPLATE4'] = $TEMPLATEEx->TEMPLATE4;
        $newCrudData['TEMPLATE3'] = $TEMPLATEEx->TEMPLATE3;
        $newCrudData['change_operator'] = $TEMPLATEEx->change_operator;
        $newCrudData['change_time'] = $TEMPLATEEx->change_time;
        $newCrudData['create_operator'] = $TEMPLATEEx->create_operator;
        $newCrudData['create_time'] = $TEMPLATEEx->create_time;
        $newCrudData['delete_operator'] = $TEMPLATEEx->delete_operator;
        $newCrudData['delete_time'] = $TEMPLATEEx->delete_time;
        $newCrudData['status'] = $TEMPLATEEx->status;
        $newCrudData['Valid'] = $TEMPLATEEx->Valid;
        $newCrudData['Fpversion'] = $TEMPLATEEx->Fpversion;
        $newCrudData['bio_type'] = $TEMPLATEEx->bio_type;
        $newCrudData['SN'] = $TEMPLATEEx->SN;
        $newCrudData['UTime'] = $TEMPLATEEx->UTime;
        $newCrudData['FP10SIZE'] = $TEMPLATEEx->FP10SIZE;
        $newCrudData['DuressFlag'] = $TEMPLATEEx->DuressFlag;
        $newCrudData['TEMPLATESIZE'] = $TEMPLATEEx->TEMPLATESIZE;
        $newCrudData['StateMigrationFlag'] = $TEMPLATEEx->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'TEMPLATEEx', 'entite_cle' => $TEMPLATEEx->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $TEMPLATEEx->toArray();


        try {

            foreach ($TEMPLATEEx->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, TEMPLATEEx $TEMPLATEEx)
    {


        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $TEMPLATEEx->TEMPLATEID;
        $newCrudData['USERID'] = $TEMPLATEEx->USERID;
        $newCrudData['FINGERID'] = $TEMPLATEEx->FINGERID;
        $newCrudData['TEMPLATE'] = $TEMPLATEEx->TEMPLATE;
        $newCrudData['TEMPLATE2'] = $TEMPLATEEx->TEMPLATE2;
        $newCrudData['BITMAPPICTURE'] = $TEMPLATEEx->BITMAPPICTURE;
        $newCrudData['BITMAPPICTURE2'] = $TEMPLATEEx->BITMAPPICTURE2;
        $newCrudData['BITMAPPICTURE3'] = $TEMPLATEEx->BITMAPPICTURE3;
        $newCrudData['BITMAPPICTURE4'] = $TEMPLATEEx->BITMAPPICTURE4;
        $newCrudData['USETYPE'] = $TEMPLATEEx->USETYPE;
        $newCrudData['EMACHINENUM'] = $TEMPLATEEx->EMACHINENUM;
        $newCrudData['TEMPLATE1'] = $TEMPLATEEx->TEMPLATE1;
        $newCrudData['Flag'] = $TEMPLATEEx->Flag;
        $newCrudData['DivisionFP'] = $TEMPLATEEx->DivisionFP;
        $newCrudData['TEMPLATE4'] = $TEMPLATEEx->TEMPLATE4;
        $newCrudData['TEMPLATE3'] = $TEMPLATEEx->TEMPLATE3;
        $newCrudData['change_operator'] = $TEMPLATEEx->change_operator;
        $newCrudData['change_time'] = $TEMPLATEEx->change_time;
        $newCrudData['create_operator'] = $TEMPLATEEx->create_operator;
        $newCrudData['create_time'] = $TEMPLATEEx->create_time;
        $newCrudData['delete_operator'] = $TEMPLATEEx->delete_operator;
        $newCrudData['delete_time'] = $TEMPLATEEx->delete_time;
        $newCrudData['status'] = $TEMPLATEEx->status;
        $newCrudData['Valid'] = $TEMPLATEEx->Valid;
        $newCrudData['Fpversion'] = $TEMPLATEEx->Fpversion;
        $newCrudData['bio_type'] = $TEMPLATEEx->bio_type;
        $newCrudData['SN'] = $TEMPLATEEx->SN;
        $newCrudData['UTime'] = $TEMPLATEEx->UTime;
        $newCrudData['FP10SIZE'] = $TEMPLATEEx->FP10SIZE;
        $newCrudData['DuressFlag'] = $TEMPLATEEx->DuressFlag;
        $newCrudData['TEMPLATESIZE'] = $TEMPLATEEx->TEMPLATESIZE;
        $newCrudData['StateMigrationFlag'] = $TEMPLATEEx->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'TEMPLATEEx', 'entite_cle' => $TEMPLATEEx->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $TEMPLATEEx->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new TEMPLATEExActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
