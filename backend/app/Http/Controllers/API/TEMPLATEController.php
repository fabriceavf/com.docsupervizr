<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\TEMPLATEActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\TEMPLATEExtras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\TEMPLATE;
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

// use App\Repository\prod\TEMPLATERepository;


class TEMPLATEController extends Controller
{

    private $TEMPLATERepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\TEMPLATERepository $TEMPLATERepository
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
        $query = TEMPLATE::query();
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
            class_exists('\App\Http\Extras\TEMPLATEExtras') &&
            method_exists('\App\Http\Extras\TEMPLATEExtras', 'filterAgGridQuery')
        ) {
            TEMPLATEExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('TEMPLATE', $query);
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
            return response()->json(TEMPLATE::count());
        }
        $data = QueryBuilder::for(TEMPLATE::class)
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


        $data = QueryBuilder::for(TEMPLATE::class)
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


    public function create(Request $request, TEMPLATE $TEMPLATE)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "TEMPLATE" . "-" . $key . "_" . time() . "." . $file->extension()
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

            $TEMPLATE->TEMPLATEID = $data['TEMPLATEID'];

        }


        if (!empty($data['USERID'])) {

            $TEMPLATE->USERID = $data['USERID'];

        }


        if (!empty($data['FINGERID'])) {

            $TEMPLATE->FINGERID = $data['FINGERID'];

        }


        if (!empty($data['TEMPLATE'])) {

            $TEMPLATE->TEMPLATE = $data['TEMPLATE'];

        }


        if (!empty($data['TEMPLATE2'])) {

            $TEMPLATE->TEMPLATE2 = $data['TEMPLATE2'];

        }


        if (!empty($data['BITMAPPICTURE'])) {

            $TEMPLATE->BITMAPPICTURE = $data['BITMAPPICTURE'];

        }


        if (!empty($data['BITMAPPICTURE2'])) {

            $TEMPLATE->BITMAPPICTURE2 = $data['BITMAPPICTURE2'];

        }


        if (!empty($data['BITMAPPICTURE3'])) {

            $TEMPLATE->BITMAPPICTURE3 = $data['BITMAPPICTURE3'];

        }


        if (!empty($data['BITMAPPICTURE4'])) {

            $TEMPLATE->BITMAPPICTURE4 = $data['BITMAPPICTURE4'];

        }


        if (!empty($data['USETYPE'])) {

            $TEMPLATE->USETYPE = $data['USETYPE'];

        }


        if (!empty($data['EMACHINENUM'])) {

            $TEMPLATE->EMACHINENUM = $data['EMACHINENUM'];

        }


        if (!empty($data['TEMPLATE1'])) {

            $TEMPLATE->TEMPLATE1 = $data['TEMPLATE1'];

        }


        if (!empty($data['Flag'])) {

            $TEMPLATE->Flag = $data['Flag'];

        }


        if (!empty($data['DivisionFP'])) {

            $TEMPLATE->DivisionFP = $data['DivisionFP'];

        }


        if (!empty($data['TEMPLATE4'])) {

            $TEMPLATE->TEMPLATE4 = $data['TEMPLATE4'];

        }


        if (!empty($data['TEMPLATE3'])) {

            $TEMPLATE->TEMPLATE3 = $data['TEMPLATE3'];

        }


        if (!empty($data['change_operator'])) {

            $TEMPLATE->change_operator = $data['change_operator'];

        }


        if (!empty($data['change_time'])) {

            $TEMPLATE->change_time = $data['change_time'];

        }


        if (!empty($data['create_operator'])) {

            $TEMPLATE->create_operator = $data['create_operator'];

        }


        if (!empty($data['create_time'])) {

            $TEMPLATE->create_time = $data['create_time'];

        }


        if (!empty($data['delete_operator'])) {

            $TEMPLATE->delete_operator = $data['delete_operator'];

        }


        if (!empty($data['delete_time'])) {

            $TEMPLATE->delete_time = $data['delete_time'];

        }


        if (!empty($data['status'])) {

            $TEMPLATE->status = $data['status'];

        }


        if (!empty($data['Valid'])) {

            $TEMPLATE->Valid = $data['Valid'];

        }


        if (!empty($data['Fpversion'])) {

            $TEMPLATE->Fpversion = $data['Fpversion'];

        }


        if (!empty($data['bio_type'])) {

            $TEMPLATE->bio_type = $data['bio_type'];

        }


        if (!empty($data['SN'])) {

            $TEMPLATE->SN = $data['SN'];

        }


        if (!empty($data['UTime'])) {

            $TEMPLATE->UTime = $data['UTime'];

        }


        if (!empty($data['FP10SIZE'])) {

            $TEMPLATE->FP10SIZE = $data['FP10SIZE'];

        }


        if (!empty($data['DuressFlag'])) {

            $TEMPLATE->DuressFlag = $data['DuressFlag'];

        }


        if (!empty($data['TEMPLATESIZE'])) {

            $TEMPLATE->TEMPLATESIZE = $data['TEMPLATESIZE'];

        }


        if (!empty($data['StateMigrationFlag'])) {

            $TEMPLATE->StateMigrationFlag = $data['StateMigrationFlag'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $TEMPLATE->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\TEMPLATEExtras') &&
            method_exists('\App\Http\Extras\TEMPLATEExtras', 'beforeSaveCreate')
        ) {
            TEMPLATEExtras::beforeSaveCreate($request, $TEMPLATE);
        }


        $TEMPLATE->save();
        $TEMPLATE = TEMPLATE::find($TEMPLATE->id);
        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $TEMPLATE->TEMPLATEID;
        $newCrudData['USERID'] = $TEMPLATE->USERID;
        $newCrudData['FINGERID'] = $TEMPLATE->FINGERID;
        $newCrudData['TEMPLATE'] = $TEMPLATE->TEMPLATE;
        $newCrudData['TEMPLATE2'] = $TEMPLATE->TEMPLATE2;
        $newCrudData['BITMAPPICTURE'] = $TEMPLATE->BITMAPPICTURE;
        $newCrudData['BITMAPPICTURE2'] = $TEMPLATE->BITMAPPICTURE2;
        $newCrudData['BITMAPPICTURE3'] = $TEMPLATE->BITMAPPICTURE3;
        $newCrudData['BITMAPPICTURE4'] = $TEMPLATE->BITMAPPICTURE4;
        $newCrudData['USETYPE'] = $TEMPLATE->USETYPE;
        $newCrudData['EMACHINENUM'] = $TEMPLATE->EMACHINENUM;
        $newCrudData['TEMPLATE1'] = $TEMPLATE->TEMPLATE1;
        $newCrudData['Flag'] = $TEMPLATE->Flag;
        $newCrudData['DivisionFP'] = $TEMPLATE->DivisionFP;
        $newCrudData['TEMPLATE4'] = $TEMPLATE->TEMPLATE4;
        $newCrudData['TEMPLATE3'] = $TEMPLATE->TEMPLATE3;
        $newCrudData['change_operator'] = $TEMPLATE->change_operator;
        $newCrudData['change_time'] = $TEMPLATE->change_time;
        $newCrudData['create_operator'] = $TEMPLATE->create_operator;
        $newCrudData['create_time'] = $TEMPLATE->create_time;
        $newCrudData['delete_operator'] = $TEMPLATE->delete_operator;
        $newCrudData['delete_time'] = $TEMPLATE->delete_time;
        $newCrudData['status'] = $TEMPLATE->status;
        $newCrudData['Valid'] = $TEMPLATE->Valid;
        $newCrudData['Fpversion'] = $TEMPLATE->Fpversion;
        $newCrudData['bio_type'] = $TEMPLATE->bio_type;
        $newCrudData['SN'] = $TEMPLATE->SN;
        $newCrudData['UTime'] = $TEMPLATE->UTime;
        $newCrudData['FP10SIZE'] = $TEMPLATE->FP10SIZE;
        $newCrudData['DuressFlag'] = $TEMPLATE->DuressFlag;
        $newCrudData['TEMPLATESIZE'] = $TEMPLATE->TEMPLATESIZE;
        $newCrudData['StateMigrationFlag'] = $TEMPLATE->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'TEMPLATE', 'entite_cle' => $TEMPLATE->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $TEMPLATE->toArray();


        try {

            foreach ($TEMPLATE->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, TEMPLATE $TEMPLATE)
    {


        $oldCrudData = [];

        $oldCrudData['TEMPLATEID'] = $TEMPLATE->TEMPLATEID;
        $oldCrudData['USERID'] = $TEMPLATE->USERID;
        $oldCrudData['FINGERID'] = $TEMPLATE->FINGERID;
        $oldCrudData['TEMPLATE'] = $TEMPLATE->TEMPLATE;
        $oldCrudData['TEMPLATE2'] = $TEMPLATE->TEMPLATE2;
        $oldCrudData['BITMAPPICTURE'] = $TEMPLATE->BITMAPPICTURE;
        $oldCrudData['BITMAPPICTURE2'] = $TEMPLATE->BITMAPPICTURE2;
        $oldCrudData['BITMAPPICTURE3'] = $TEMPLATE->BITMAPPICTURE3;
        $oldCrudData['BITMAPPICTURE4'] = $TEMPLATE->BITMAPPICTURE4;
        $oldCrudData['USETYPE'] = $TEMPLATE->USETYPE;
        $oldCrudData['EMACHINENUM'] = $TEMPLATE->EMACHINENUM;
        $oldCrudData['TEMPLATE1'] = $TEMPLATE->TEMPLATE1;
        $oldCrudData['Flag'] = $TEMPLATE->Flag;
        $oldCrudData['DivisionFP'] = $TEMPLATE->DivisionFP;
        $oldCrudData['TEMPLATE4'] = $TEMPLATE->TEMPLATE4;
        $oldCrudData['TEMPLATE3'] = $TEMPLATE->TEMPLATE3;
        $oldCrudData['change_operator'] = $TEMPLATE->change_operator;
        $oldCrudData['change_time'] = $TEMPLATE->change_time;
        $oldCrudData['create_operator'] = $TEMPLATE->create_operator;
        $oldCrudData['create_time'] = $TEMPLATE->create_time;
        $oldCrudData['delete_operator'] = $TEMPLATE->delete_operator;
        $oldCrudData['delete_time'] = $TEMPLATE->delete_time;
        $oldCrudData['status'] = $TEMPLATE->status;
        $oldCrudData['Valid'] = $TEMPLATE->Valid;
        $oldCrudData['Fpversion'] = $TEMPLATE->Fpversion;
        $oldCrudData['bio_type'] = $TEMPLATE->bio_type;
        $oldCrudData['SN'] = $TEMPLATE->SN;
        $oldCrudData['UTime'] = $TEMPLATE->UTime;
        $oldCrudData['FP10SIZE'] = $TEMPLATE->FP10SIZE;
        $oldCrudData['DuressFlag'] = $TEMPLATE->DuressFlag;
        $oldCrudData['TEMPLATESIZE'] = $TEMPLATE->TEMPLATESIZE;
        $oldCrudData['StateMigrationFlag'] = $TEMPLATE->StateMigrationFlag;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "TEMPLATE" . "-" . $key . "_" . time() . "." . $file->extension()
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

                $TEMPLATE->TEMPLATEID = $data['TEMPLATEID'];

            }

        }


        if (array_key_exists("USERID", $data)) {


            if (!empty($data['USERID'])) {

                $TEMPLATE->USERID = $data['USERID'];

            }

        }


        if (array_key_exists("FINGERID", $data)) {


            if (!empty($data['FINGERID'])) {

                $TEMPLATE->FINGERID = $data['FINGERID'];

            }

        }


        if (array_key_exists("TEMPLATE", $data)) {


            if (!empty($data['TEMPLATE'])) {

                $TEMPLATE->TEMPLATE = $data['TEMPLATE'];

            }

        }


        if (array_key_exists("TEMPLATE2", $data)) {


            if (!empty($data['TEMPLATE2'])) {

                $TEMPLATE->TEMPLATE2 = $data['TEMPLATE2'];

            }

        }


        if (array_key_exists("BITMAPPICTURE", $data)) {


            if (!empty($data['BITMAPPICTURE'])) {

                $TEMPLATE->BITMAPPICTURE = $data['BITMAPPICTURE'];

            }

        }


        if (array_key_exists("BITMAPPICTURE2", $data)) {


            if (!empty($data['BITMAPPICTURE2'])) {

                $TEMPLATE->BITMAPPICTURE2 = $data['BITMAPPICTURE2'];

            }

        }


        if (array_key_exists("BITMAPPICTURE3", $data)) {


            if (!empty($data['BITMAPPICTURE3'])) {

                $TEMPLATE->BITMAPPICTURE3 = $data['BITMAPPICTURE3'];

            }

        }


        if (array_key_exists("BITMAPPICTURE4", $data)) {


            if (!empty($data['BITMAPPICTURE4'])) {

                $TEMPLATE->BITMAPPICTURE4 = $data['BITMAPPICTURE4'];

            }

        }


        if (array_key_exists("USETYPE", $data)) {


            if (!empty($data['USETYPE'])) {

                $TEMPLATE->USETYPE = $data['USETYPE'];

            }

        }


        if (array_key_exists("EMACHINENUM", $data)) {


            if (!empty($data['EMACHINENUM'])) {

                $TEMPLATE->EMACHINENUM = $data['EMACHINENUM'];

            }

        }


        if (array_key_exists("TEMPLATE1", $data)) {


            if (!empty($data['TEMPLATE1'])) {

                $TEMPLATE->TEMPLATE1 = $data['TEMPLATE1'];

            }

        }


        if (array_key_exists("Flag", $data)) {


            if (!empty($data['Flag'])) {

                $TEMPLATE->Flag = $data['Flag'];

            }

        }


        if (array_key_exists("DivisionFP", $data)) {


            if (!empty($data['DivisionFP'])) {

                $TEMPLATE->DivisionFP = $data['DivisionFP'];

            }

        }


        if (array_key_exists("TEMPLATE4", $data)) {


            if (!empty($data['TEMPLATE4'])) {

                $TEMPLATE->TEMPLATE4 = $data['TEMPLATE4'];

            }

        }


        if (array_key_exists("TEMPLATE3", $data)) {


            if (!empty($data['TEMPLATE3'])) {

                $TEMPLATE->TEMPLATE3 = $data['TEMPLATE3'];

            }

        }


        if (array_key_exists("change_operator", $data)) {


            if (!empty($data['change_operator'])) {

                $TEMPLATE->change_operator = $data['change_operator'];

            }

        }


        if (array_key_exists("change_time", $data)) {


            if (!empty($data['change_time'])) {

                $TEMPLATE->change_time = $data['change_time'];

            }

        }


        if (array_key_exists("create_operator", $data)) {


            if (!empty($data['create_operator'])) {

                $TEMPLATE->create_operator = $data['create_operator'];

            }

        }


        if (array_key_exists("create_time", $data)) {


            if (!empty($data['create_time'])) {

                $TEMPLATE->create_time = $data['create_time'];

            }

        }


        if (array_key_exists("delete_operator", $data)) {


            if (!empty($data['delete_operator'])) {

                $TEMPLATE->delete_operator = $data['delete_operator'];

            }

        }


        if (array_key_exists("delete_time", $data)) {


            if (!empty($data['delete_time'])) {

                $TEMPLATE->delete_time = $data['delete_time'];

            }

        }


        if (array_key_exists("status", $data)) {


            if (!empty($data['status'])) {

                $TEMPLATE->status = $data['status'];

            }

        }


        if (array_key_exists("Valid", $data)) {


            if (!empty($data['Valid'])) {

                $TEMPLATE->Valid = $data['Valid'];

            }

        }


        if (array_key_exists("Fpversion", $data)) {


            if (!empty($data['Fpversion'])) {

                $TEMPLATE->Fpversion = $data['Fpversion'];

            }

        }


        if (array_key_exists("bio_type", $data)) {


            if (!empty($data['bio_type'])) {

                $TEMPLATE->bio_type = $data['bio_type'];

            }

        }


        if (array_key_exists("SN", $data)) {


            if (!empty($data['SN'])) {

                $TEMPLATE->SN = $data['SN'];

            }

        }


        if (array_key_exists("UTime", $data)) {


            if (!empty($data['UTime'])) {

                $TEMPLATE->UTime = $data['UTime'];

            }

        }


        if (array_key_exists("FP10SIZE", $data)) {


            if (!empty($data['FP10SIZE'])) {

                $TEMPLATE->FP10SIZE = $data['FP10SIZE'];

            }

        }


        if (array_key_exists("DuressFlag", $data)) {


            if (!empty($data['DuressFlag'])) {

                $TEMPLATE->DuressFlag = $data['DuressFlag'];

            }

        }


        if (array_key_exists("TEMPLATESIZE", $data)) {


            if (!empty($data['TEMPLATESIZE'])) {

                $TEMPLATE->TEMPLATESIZE = $data['TEMPLATESIZE'];

            }

        }


        if (array_key_exists("StateMigrationFlag", $data)) {


            if (!empty($data['StateMigrationFlag'])) {

                $TEMPLATE->StateMigrationFlag = $data['StateMigrationFlag'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $TEMPLATE->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\TEMPLATEExtras') &&
            method_exists('\App\Http\Extras\TEMPLATEExtras', 'beforeSaveUpdate')
        ) {
            TEMPLATEExtras::beforeSaveUpdate($request, $TEMPLATE);
        }

        $TEMPLATE->save();
        $TEMPLATE = TEMPLATE::find($TEMPLATE->id);


        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $TEMPLATE->TEMPLATEID;
        $newCrudData['USERID'] = $TEMPLATE->USERID;
        $newCrudData['FINGERID'] = $TEMPLATE->FINGERID;
        $newCrudData['TEMPLATE'] = $TEMPLATE->TEMPLATE;
        $newCrudData['TEMPLATE2'] = $TEMPLATE->TEMPLATE2;
        $newCrudData['BITMAPPICTURE'] = $TEMPLATE->BITMAPPICTURE;
        $newCrudData['BITMAPPICTURE2'] = $TEMPLATE->BITMAPPICTURE2;
        $newCrudData['BITMAPPICTURE3'] = $TEMPLATE->BITMAPPICTURE3;
        $newCrudData['BITMAPPICTURE4'] = $TEMPLATE->BITMAPPICTURE4;
        $newCrudData['USETYPE'] = $TEMPLATE->USETYPE;
        $newCrudData['EMACHINENUM'] = $TEMPLATE->EMACHINENUM;
        $newCrudData['TEMPLATE1'] = $TEMPLATE->TEMPLATE1;
        $newCrudData['Flag'] = $TEMPLATE->Flag;
        $newCrudData['DivisionFP'] = $TEMPLATE->DivisionFP;
        $newCrudData['TEMPLATE4'] = $TEMPLATE->TEMPLATE4;
        $newCrudData['TEMPLATE3'] = $TEMPLATE->TEMPLATE3;
        $newCrudData['change_operator'] = $TEMPLATE->change_operator;
        $newCrudData['change_time'] = $TEMPLATE->change_time;
        $newCrudData['create_operator'] = $TEMPLATE->create_operator;
        $newCrudData['create_time'] = $TEMPLATE->create_time;
        $newCrudData['delete_operator'] = $TEMPLATE->delete_operator;
        $newCrudData['delete_time'] = $TEMPLATE->delete_time;
        $newCrudData['status'] = $TEMPLATE->status;
        $newCrudData['Valid'] = $TEMPLATE->Valid;
        $newCrudData['Fpversion'] = $TEMPLATE->Fpversion;
        $newCrudData['bio_type'] = $TEMPLATE->bio_type;
        $newCrudData['SN'] = $TEMPLATE->SN;
        $newCrudData['UTime'] = $TEMPLATE->UTime;
        $newCrudData['FP10SIZE'] = $TEMPLATE->FP10SIZE;
        $newCrudData['DuressFlag'] = $TEMPLATE->DuressFlag;
        $newCrudData['TEMPLATESIZE'] = $TEMPLATE->TEMPLATESIZE;
        $newCrudData['StateMigrationFlag'] = $TEMPLATE->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'TEMPLATE', 'entite_cle' => $TEMPLATE->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $TEMPLATE->toArray();


        try {

            foreach ($TEMPLATE->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, TEMPLATE $TEMPLATE)
    {


        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $TEMPLATE->TEMPLATEID;
        $newCrudData['USERID'] = $TEMPLATE->USERID;
        $newCrudData['FINGERID'] = $TEMPLATE->FINGERID;
        $newCrudData['TEMPLATE'] = $TEMPLATE->TEMPLATE;
        $newCrudData['TEMPLATE2'] = $TEMPLATE->TEMPLATE2;
        $newCrudData['BITMAPPICTURE'] = $TEMPLATE->BITMAPPICTURE;
        $newCrudData['BITMAPPICTURE2'] = $TEMPLATE->BITMAPPICTURE2;
        $newCrudData['BITMAPPICTURE3'] = $TEMPLATE->BITMAPPICTURE3;
        $newCrudData['BITMAPPICTURE4'] = $TEMPLATE->BITMAPPICTURE4;
        $newCrudData['USETYPE'] = $TEMPLATE->USETYPE;
        $newCrudData['EMACHINENUM'] = $TEMPLATE->EMACHINENUM;
        $newCrudData['TEMPLATE1'] = $TEMPLATE->TEMPLATE1;
        $newCrudData['Flag'] = $TEMPLATE->Flag;
        $newCrudData['DivisionFP'] = $TEMPLATE->DivisionFP;
        $newCrudData['TEMPLATE4'] = $TEMPLATE->TEMPLATE4;
        $newCrudData['TEMPLATE3'] = $TEMPLATE->TEMPLATE3;
        $newCrudData['change_operator'] = $TEMPLATE->change_operator;
        $newCrudData['change_time'] = $TEMPLATE->change_time;
        $newCrudData['create_operator'] = $TEMPLATE->create_operator;
        $newCrudData['create_time'] = $TEMPLATE->create_time;
        $newCrudData['delete_operator'] = $TEMPLATE->delete_operator;
        $newCrudData['delete_time'] = $TEMPLATE->delete_time;
        $newCrudData['status'] = $TEMPLATE->status;
        $newCrudData['Valid'] = $TEMPLATE->Valid;
        $newCrudData['Fpversion'] = $TEMPLATE->Fpversion;
        $newCrudData['bio_type'] = $TEMPLATE->bio_type;
        $newCrudData['SN'] = $TEMPLATE->SN;
        $newCrudData['UTime'] = $TEMPLATE->UTime;
        $newCrudData['FP10SIZE'] = $TEMPLATE->FP10SIZE;
        $newCrudData['DuressFlag'] = $TEMPLATE->DuressFlag;
        $newCrudData['TEMPLATESIZE'] = $TEMPLATE->TEMPLATESIZE;
        $newCrudData['StateMigrationFlag'] = $TEMPLATE->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'TEMPLATE', 'entite_cle' => $TEMPLATE->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $TEMPLATE->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new TEMPLATEActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
