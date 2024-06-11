<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\USERINFOActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\USERINFOExtras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\USERINFO;
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

// use App\Repository\prod\USERINFORepository;


class USERINFOController extends Controller
{

    private $USERINFORepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\USERINFORepository $USERINFORepository
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
        $query = USERINFO::query();
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
            class_exists('\App\Http\Extras\USERINFOExtras') &&
            method_exists('\App\Http\Extras\USERINFOExtras', 'filterAgGridQuery')
        ) {
            USERINFOExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('USERINFO', $query);
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
            return response()->json(USERINFO::count());
        }
        $data = QueryBuilder::for(USERINFO::class)
            ->allowedFilters([
                AllowedFilter::exact('USERID'),


                AllowedFilter::exact('Badgenumber'),


                AllowedFilter::exact('SSN'),


                AllowedFilter::exact('name'),


                AllowedFilter::exact('Gender'),


                AllowedFilter::exact('TITLE'),


                AllowedFilter::exact('PAGER'),


                AllowedFilter::exact('BIRTHDAY'),


                AllowedFilter::exact('HIREDDAY'),


                AllowedFilter::exact('street'),


                AllowedFilter::exact('CITY'),


                AllowedFilter::exact('STATE'),


                AllowedFilter::exact('ZIP'),


                AllowedFilter::exact('OPHONE'),


                AllowedFilter::exact('FPHONE'),


                AllowedFilter::exact('VERIFICATIONMETHOD'),


                AllowedFilter::exact('DEFAULTDEPTID'),


                AllowedFilter::exact('SECURITYFLAGS'),


                AllowedFilter::exact('ATT'),


                AllowedFilter::exact('INLATE'),


                AllowedFilter::exact('OUTEARLY'),


                AllowedFilter::exact('OVERTIME'),


                AllowedFilter::exact('SEP'),


                AllowedFilter::exact('HOLIDAY'),


                AllowedFilter::exact('MINZU'),


                AllowedFilter::exact('PASSWORD'),


                AllowedFilter::exact('LUNCHDURATION'),


                AllowedFilter::exact('PHOTO'),


                AllowedFilter::exact('mverifypass'),


                AllowedFilter::exact('Notes'),


                AllowedFilter::exact('privilege'),


                AllowedFilter::exact('InheritDeptSch'),


                AllowedFilter::exact('InheritDeptSchClass'),


                AllowedFilter::exact('AutoSchPlan'),


                AllowedFilter::exact('MinAutoSchInterval'),


                AllowedFilter::exact('RegisterOT'),


                AllowedFilter::exact('InheritDeptRule'),


                AllowedFilter::exact('EMPRIVILEGE'),


                AllowedFilter::exact('CardNo'),


                AllowedFilter::exact('change_operator'),


                AllowedFilter::exact('change_time'),


                AllowedFilter::exact('create_operator'),


                AllowedFilter::exact('create_time'),


                AllowedFilter::exact('delete_operator'),


                AllowedFilter::exact('delete_time'),


                AllowedFilter::exact('status'),


                AllowedFilter::exact('lastname'),


                AllowedFilter::exact('AccGroup'),


                AllowedFilter::exact('TimeZones'),


                AllowedFilter::exact('identitycard'),


                AllowedFilter::exact('UTime'),


                AllowedFilter::exact('Education'),


                AllowedFilter::exact('OffDuty'),


                AllowedFilter::exact('DelTag'),


                AllowedFilter::exact('morecard_group_id'),


                AllowedFilter::exact('set_valid_time'),


                AllowedFilter::exact('acc_startdate'),


                AllowedFilter::exact('acc_enddate'),


                AllowedFilter::exact('birthplace'),


                AllowedFilter::exact('Political'),


                AllowedFilter::exact('contry'),


                AllowedFilter::exact('hiretype'),


                AllowedFilter::exact('email'),


                AllowedFilter::exact('firedate'),


                AllowedFilter::exact('isatt'),


                AllowedFilter::exact('homeaddress'),


                AllowedFilter::exact('emptype'),


                AllowedFilter::exact('bankcode1'),


                AllowedFilter::exact('bankcode2'),


                AllowedFilter::exact('isblacklist'),


                AllowedFilter::exact('Iuser1'),


                AllowedFilter::exact('Iuser2'),


                AllowedFilter::exact('Iuser3'),


                AllowedFilter::exact('Iuser4'),


                AllowedFilter::exact('Iuser5'),


                AllowedFilter::exact('Cuser1'),


                AllowedFilter::exact('Cuser2'),


                AllowedFilter::exact('Cuser3'),


                AllowedFilter::exact('Cuser4'),


                AllowedFilter::exact('Cuser5'),


                AllowedFilter::exact('Duser1'),


                AllowedFilter::exact('Duser2'),


                AllowedFilter::exact('Duser3'),


                AllowedFilter::exact('Duser4'),


                AllowedFilter::exact('Duser5'),


                AllowedFilter::exact('reserve'),


                AllowedFilter::exact('carNo'),


                AllowedFilter::exact('carType'),


                AllowedFilter::exact('carBrand'),


                AllowedFilter::exact('carColor'),


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
                AllowedSort::field('USERID'),


                AllowedSort::field('Badgenumber'),


                AllowedSort::field('SSN'),


                AllowedSort::field('name'),


                AllowedSort::field('Gender'),


                AllowedSort::field('TITLE'),


                AllowedSort::field('PAGER'),


                AllowedSort::field('BIRTHDAY'),


                AllowedSort::field('HIREDDAY'),


                AllowedSort::field('street'),


                AllowedSort::field('CITY'),


                AllowedSort::field('STATE'),


                AllowedSort::field('ZIP'),


                AllowedSort::field('OPHONE'),


                AllowedSort::field('FPHONE'),


                AllowedSort::field('VERIFICATIONMETHOD'),


                AllowedSort::field('DEFAULTDEPTID'),


                AllowedSort::field('SECURITYFLAGS'),


                AllowedSort::field('ATT'),


                AllowedSort::field('INLATE'),


                AllowedSort::field('OUTEARLY'),


                AllowedSort::field('OVERTIME'),


                AllowedSort::field('SEP'),


                AllowedSort::field('HOLIDAY'),


                AllowedSort::field('MINZU'),


                AllowedSort::field('PASSWORD'),


                AllowedSort::field('LUNCHDURATION'),


                AllowedSort::field('PHOTO'),


                AllowedSort::field('mverifypass'),


                AllowedSort::field('Notes'),


                AllowedSort::field('privilege'),


                AllowedSort::field('InheritDeptSch'),


                AllowedSort::field('InheritDeptSchClass'),


                AllowedSort::field('AutoSchPlan'),


                AllowedSort::field('MinAutoSchInterval'),


                AllowedSort::field('RegisterOT'),


                AllowedSort::field('InheritDeptRule'),


                AllowedSort::field('EMPRIVILEGE'),


                AllowedSort::field('CardNo'),


                AllowedSort::field('change_operator'),


                AllowedSort::field('change_time'),


                AllowedSort::field('create_operator'),


                AllowedSort::field('create_time'),


                AllowedSort::field('delete_operator'),


                AllowedSort::field('delete_time'),


                AllowedSort::field('status'),


                AllowedSort::field('lastname'),


                AllowedSort::field('AccGroup'),


                AllowedSort::field('TimeZones'),


                AllowedSort::field('identitycard'),


                AllowedSort::field('UTime'),


                AllowedSort::field('Education'),


                AllowedSort::field('OffDuty'),


                AllowedSort::field('DelTag'),


                AllowedSort::field('morecard_group_id'),


                AllowedSort::field('set_valid_time'),


                AllowedSort::field('acc_startdate'),


                AllowedSort::field('acc_enddate'),


                AllowedSort::field('birthplace'),


                AllowedSort::field('Political'),


                AllowedSort::field('contry'),


                AllowedSort::field('hiretype'),


                AllowedSort::field('email'),


                AllowedSort::field('firedate'),


                AllowedSort::field('isatt'),


                AllowedSort::field('homeaddress'),


                AllowedSort::field('emptype'),


                AllowedSort::field('bankcode1'),


                AllowedSort::field('bankcode2'),


                AllowedSort::field('isblacklist'),


                AllowedSort::field('Iuser1'),


                AllowedSort::field('Iuser2'),


                AllowedSort::field('Iuser3'),


                AllowedSort::field('Iuser4'),


                AllowedSort::field('Iuser5'),


                AllowedSort::field('Cuser1'),


                AllowedSort::field('Cuser2'),


                AllowedSort::field('Cuser3'),


                AllowedSort::field('Cuser4'),


                AllowedSort::field('Cuser5'),


                AllowedSort::field('Duser1'),


                AllowedSort::field('Duser2'),


                AllowedSort::field('Duser3'),


                AllowedSort::field('Duser4'),


                AllowedSort::field('Duser5'),


                AllowedSort::field('reserve'),


                AllowedSort::field('carNo'),


                AllowedSort::field('carType'),


                AllowedSort::field('carBrand'),


                AllowedSort::field('carColor'),


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


        $data = QueryBuilder::for(USERINFO::class)
            ->allowedFilters([
                AllowedFilter::exact('USERID'),


                AllowedFilter::exact('Badgenumber'),


                AllowedFilter::exact('SSN'),


                AllowedFilter::exact('name'),


                AllowedFilter::exact('Gender'),


                AllowedFilter::exact('TITLE'),


                AllowedFilter::exact('PAGER'),


                AllowedFilter::exact('BIRTHDAY'),


                AllowedFilter::exact('HIREDDAY'),


                AllowedFilter::exact('street'),


                AllowedFilter::exact('CITY'),


                AllowedFilter::exact('STATE'),


                AllowedFilter::exact('ZIP'),


                AllowedFilter::exact('OPHONE'),


                AllowedFilter::exact('FPHONE'),


                AllowedFilter::exact('VERIFICATIONMETHOD'),


                AllowedFilter::exact('DEFAULTDEPTID'),


                AllowedFilter::exact('SECURITYFLAGS'),


                AllowedFilter::exact('ATT'),


                AllowedFilter::exact('INLATE'),


                AllowedFilter::exact('OUTEARLY'),


                AllowedFilter::exact('OVERTIME'),


                AllowedFilter::exact('SEP'),


                AllowedFilter::exact('HOLIDAY'),


                AllowedFilter::exact('MINZU'),


                AllowedFilter::exact('PASSWORD'),


                AllowedFilter::exact('LUNCHDURATION'),


                AllowedFilter::exact('PHOTO'),


                AllowedFilter::exact('mverifypass'),


                AllowedFilter::exact('Notes'),


                AllowedFilter::exact('privilege'),


                AllowedFilter::exact('InheritDeptSch'),


                AllowedFilter::exact('InheritDeptSchClass'),


                AllowedFilter::exact('AutoSchPlan'),


                AllowedFilter::exact('MinAutoSchInterval'),


                AllowedFilter::exact('RegisterOT'),


                AllowedFilter::exact('InheritDeptRule'),


                AllowedFilter::exact('EMPRIVILEGE'),


                AllowedFilter::exact('CardNo'),


                AllowedFilter::exact('change_operator'),


                AllowedFilter::exact('change_time'),


                AllowedFilter::exact('create_operator'),


                AllowedFilter::exact('create_time'),


                AllowedFilter::exact('delete_operator'),


                AllowedFilter::exact('delete_time'),


                AllowedFilter::exact('status'),


                AllowedFilter::exact('lastname'),


                AllowedFilter::exact('AccGroup'),


                AllowedFilter::exact('TimeZones'),


                AllowedFilter::exact('identitycard'),


                AllowedFilter::exact('UTime'),


                AllowedFilter::exact('Education'),


                AllowedFilter::exact('OffDuty'),


                AllowedFilter::exact('DelTag'),


                AllowedFilter::exact('morecard_group_id'),


                AllowedFilter::exact('set_valid_time'),


                AllowedFilter::exact('acc_startdate'),


                AllowedFilter::exact('acc_enddate'),


                AllowedFilter::exact('birthplace'),


                AllowedFilter::exact('Political'),


                AllowedFilter::exact('contry'),


                AllowedFilter::exact('hiretype'),


                AllowedFilter::exact('email'),


                AllowedFilter::exact('firedate'),


                AllowedFilter::exact('isatt'),


                AllowedFilter::exact('homeaddress'),


                AllowedFilter::exact('emptype'),


                AllowedFilter::exact('bankcode1'),


                AllowedFilter::exact('bankcode2'),


                AllowedFilter::exact('isblacklist'),


                AllowedFilter::exact('Iuser1'),


                AllowedFilter::exact('Iuser2'),


                AllowedFilter::exact('Iuser3'),


                AllowedFilter::exact('Iuser4'),


                AllowedFilter::exact('Iuser5'),


                AllowedFilter::exact('Cuser1'),


                AllowedFilter::exact('Cuser2'),


                AllowedFilter::exact('Cuser3'),


                AllowedFilter::exact('Cuser4'),


                AllowedFilter::exact('Cuser5'),


                AllowedFilter::exact('Duser1'),


                AllowedFilter::exact('Duser2'),


                AllowedFilter::exact('Duser3'),


                AllowedFilter::exact('Duser4'),


                AllowedFilter::exact('Duser5'),


                AllowedFilter::exact('reserve'),


                AllowedFilter::exact('carNo'),


                AllowedFilter::exact('carType'),


                AllowedFilter::exact('carBrand'),


                AllowedFilter::exact('carColor'),


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
                AllowedSort::field('USERID'),


                AllowedSort::field('Badgenumber'),


                AllowedSort::field('SSN'),


                AllowedSort::field('name'),


                AllowedSort::field('Gender'),


                AllowedSort::field('TITLE'),


                AllowedSort::field('PAGER'),


                AllowedSort::field('BIRTHDAY'),


                AllowedSort::field('HIREDDAY'),


                AllowedSort::field('street'),


                AllowedSort::field('CITY'),


                AllowedSort::field('STATE'),


                AllowedSort::field('ZIP'),


                AllowedSort::field('OPHONE'),


                AllowedSort::field('FPHONE'),


                AllowedSort::field('VERIFICATIONMETHOD'),


                AllowedSort::field('DEFAULTDEPTID'),


                AllowedSort::field('SECURITYFLAGS'),


                AllowedSort::field('ATT'),


                AllowedSort::field('INLATE'),


                AllowedSort::field('OUTEARLY'),


                AllowedSort::field('OVERTIME'),


                AllowedSort::field('SEP'),


                AllowedSort::field('HOLIDAY'),


                AllowedSort::field('MINZU'),


                AllowedSort::field('PASSWORD'),


                AllowedSort::field('LUNCHDURATION'),


                AllowedSort::field('PHOTO'),


                AllowedSort::field('mverifypass'),


                AllowedSort::field('Notes'),


                AllowedSort::field('privilege'),


                AllowedSort::field('InheritDeptSch'),


                AllowedSort::field('InheritDeptSchClass'),


                AllowedSort::field('AutoSchPlan'),


                AllowedSort::field('MinAutoSchInterval'),


                AllowedSort::field('RegisterOT'),


                AllowedSort::field('InheritDeptRule'),


                AllowedSort::field('EMPRIVILEGE'),


                AllowedSort::field('CardNo'),


                AllowedSort::field('change_operator'),


                AllowedSort::field('change_time'),


                AllowedSort::field('create_operator'),


                AllowedSort::field('create_time'),


                AllowedSort::field('delete_operator'),


                AllowedSort::field('delete_time'),


                AllowedSort::field('status'),


                AllowedSort::field('lastname'),


                AllowedSort::field('AccGroup'),


                AllowedSort::field('TimeZones'),


                AllowedSort::field('identitycard'),


                AllowedSort::field('UTime'),


                AllowedSort::field('Education'),


                AllowedSort::field('OffDuty'),


                AllowedSort::field('DelTag'),


                AllowedSort::field('morecard_group_id'),


                AllowedSort::field('set_valid_time'),


                AllowedSort::field('acc_startdate'),


                AllowedSort::field('acc_enddate'),


                AllowedSort::field('birthplace'),


                AllowedSort::field('Political'),


                AllowedSort::field('contry'),


                AllowedSort::field('hiretype'),


                AllowedSort::field('email'),


                AllowedSort::field('firedate'),


                AllowedSort::field('isatt'),


                AllowedSort::field('homeaddress'),


                AllowedSort::field('emptype'),


                AllowedSort::field('bankcode1'),


                AllowedSort::field('bankcode2'),


                AllowedSort::field('isblacklist'),


                AllowedSort::field('Iuser1'),


                AllowedSort::field('Iuser2'),


                AllowedSort::field('Iuser3'),


                AllowedSort::field('Iuser4'),


                AllowedSort::field('Iuser5'),


                AllowedSort::field('Cuser1'),


                AllowedSort::field('Cuser2'),


                AllowedSort::field('Cuser3'),


                AllowedSort::field('Cuser4'),


                AllowedSort::field('Cuser5'),


                AllowedSort::field('Duser1'),


                AllowedSort::field('Duser2'),


                AllowedSort::field('Duser3'),


                AllowedSort::field('Duser4'),


                AllowedSort::field('Duser5'),


                AllowedSort::field('reserve'),


                AllowedSort::field('carNo'),


                AllowedSort::field('carType'),


                AllowedSort::field('carBrand'),


                AllowedSort::field('carColor'),


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


    public function create(Request $request, USERINFO $USERINFO)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "USERINFO" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'USERID',
            'Badgenumber',
            'SSN',
            'name',
            'Gender',
            'TITLE',
            'PAGER',
            'BIRTHDAY',
            'HIREDDAY',
            'street',
            'CITY',
            'STATE',
            'ZIP',
            'OPHONE',
            'FPHONE',
            'VERIFICATIONMETHOD',
            'DEFAULTDEPTID',
            'SECURITYFLAGS',
            'ATT',
            'INLATE',
            'OUTEARLY',
            'OVERTIME',
            'SEP',
            'HOLIDAY',
            'MINZU',
            'PASSWORD',
            'LUNCHDURATION',
            'PHOTO',
            'mverifypass',
            'Notes',
            'privilege',
            'InheritDeptSch',
            'InheritDeptSchClass',
            'AutoSchPlan',
            'MinAutoSchInterval',
            'RegisterOT',
            'InheritDeptRule',
            'EMPRIVILEGE',
            'CardNo',
            'change_operator',
            'change_time',
            'create_operator',
            'create_time',
            'delete_operator',
            'delete_time',
            'status',
            'lastname',
            'AccGroup',
            'TimeZones',
            'identitycard',
            'UTime',
            'Education',
            'OffDuty',
            'DelTag',
            'morecard_group_id',
            'set_valid_time',
            'acc_startdate',
            'acc_enddate',
            'birthplace',
            'Political',
            'contry',
            'hiretype',
            'email',
            'firedate',
            'isatt',
            'homeaddress',
            'emptype',
            'bankcode1',
            'bankcode2',
            'isblacklist',
            'Iuser1',
            'Iuser2',
            'Iuser3',
            'Iuser4',
            'Iuser5',
            'Cuser1',
            'Cuser2',
            'Cuser3',
            'Cuser4',
            'Cuser5',
            'Duser1',
            'Duser2',
            'Duser3',
            'Duser4',
            'Duser5',
            'reserve',
            'carNo',
            'carType',
            'carBrand',
            'carColor',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'USERID' => [
                //'required'
            ],


            'Badgenumber' => [
                //'required'
            ],


            'SSN' => [
                //'required'
            ],


            'name' => [
                //'required'
            ],


            'Gender' => [
                //'required'
            ],


            'TITLE' => [
                //'required'
            ],


            'PAGER' => [
                //'required'
            ],


            'BIRTHDAY' => [
                //'required'
            ],


            'HIREDDAY' => [
                //'required'
            ],


            'street' => [
                //'required'
            ],


            'CITY' => [
                //'required'
            ],


            'STATE' => [
                //'required'
            ],


            'ZIP' => [
                //'required'
            ],


            'OPHONE' => [
                //'required'
            ],


            'FPHONE' => [
                //'required'
            ],


            'VERIFICATIONMETHOD' => [
                //'required'
            ],


            'DEFAULTDEPTID' => [
                //'required'
            ],


            'SECURITYFLAGS' => [
                //'required'
            ],


            'ATT' => [
                //'required'
            ],


            'INLATE' => [
                //'required'
            ],


            'OUTEARLY' => [
                //'required'
            ],


            'OVERTIME' => [
                //'required'
            ],


            'SEP' => [
                //'required'
            ],


            'HOLIDAY' => [
                //'required'
            ],


            'MINZU' => [
                //'required'
            ],


            'PASSWORD' => [
                //'required'
            ],


            'LUNCHDURATION' => [
                //'required'
            ],


            'PHOTO' => [
                //'required'
            ],


            'mverifypass' => [
                //'required'
            ],


            'Notes' => [
                //'required'
            ],


            'privilege' => [
                //'required'
            ],


            'InheritDeptSch' => [
                //'required'
            ],


            'InheritDeptSchClass' => [
                //'required'
            ],


            'AutoSchPlan' => [
                //'required'
            ],


            'MinAutoSchInterval' => [
                //'required'
            ],


            'RegisterOT' => [
                //'required'
            ],


            'InheritDeptRule' => [
                //'required'
            ],


            'EMPRIVILEGE' => [
                //'required'
            ],


            'CardNo' => [
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


            'lastname' => [
                //'required'
            ],


            'AccGroup' => [
                //'required'
            ],


            'TimeZones' => [
                //'required'
            ],


            'identitycard' => [
                //'required'
            ],


            'UTime' => [
                //'required'
            ],


            'Education' => [
                //'required'
            ],


            'OffDuty' => [
                //'required'
            ],


            'DelTag' => [
                //'required'
            ],


            'morecard_group_id' => [
                //'required'
            ],


            'set_valid_time' => [
                //'required'
            ],


            'acc_startdate' => [
                //'required'
            ],


            'acc_enddate' => [
                //'required'
            ],


            'birthplace' => [
                //'required'
            ],


            'Political' => [
                //'required'
            ],


            'contry' => [
                //'required'
            ],


            'hiretype' => [
                //'required'
            ],


            'email' => [
                //'required'
            ],


            'firedate' => [
                //'required'
            ],


            'isatt' => [
                //'required'
            ],


            'homeaddress' => [
                //'required'
            ],


            'emptype' => [
                //'required'
            ],


            'bankcode1' => [
                //'required'
            ],


            'bankcode2' => [
                //'required'
            ],


            'isblacklist' => [
                //'required'
            ],


            'Iuser1' => [
                //'required'
            ],


            'Iuser2' => [
                //'required'
            ],


            'Iuser3' => [
                //'required'
            ],


            'Iuser4' => [
                //'required'
            ],


            'Iuser5' => [
                //'required'
            ],


            'Cuser1' => [
                //'required'
            ],


            'Cuser2' => [
                //'required'
            ],


            'Cuser3' => [
                //'required'
            ],


            'Cuser4' => [
                //'required'
            ],


            'Cuser5' => [
                //'required'
            ],


            'Duser1' => [
                //'required'
            ],


            'Duser2' => [
                //'required'
            ],


            'Duser3' => [
                //'required'
            ],


            'Duser4' => [
                //'required'
            ],


            'Duser5' => [
                //'required'
            ],


            'reserve' => [
                //'required'
            ],


            'carNo' => [
                //'required'
            ],


            'carType' => [
                //'required'
            ],


            'carBrand' => [
                //'required'
            ],


            'carColor' => [
                //'required'
            ],


        ], $messages = [


            'USERID' => ['cette donnee est obligatoire'],


            'Badgenumber' => ['cette donnee est obligatoire'],


            'SSN' => ['cette donnee est obligatoire'],


            'name' => ['cette donnee est obligatoire'],


            'Gender' => ['cette donnee est obligatoire'],


            'TITLE' => ['cette donnee est obligatoire'],


            'PAGER' => ['cette donnee est obligatoire'],


            'BIRTHDAY' => ['cette donnee est obligatoire'],


            'HIREDDAY' => ['cette donnee est obligatoire'],


            'street' => ['cette donnee est obligatoire'],


            'CITY' => ['cette donnee est obligatoire'],


            'STATE' => ['cette donnee est obligatoire'],


            'ZIP' => ['cette donnee est obligatoire'],


            'OPHONE' => ['cette donnee est obligatoire'],


            'FPHONE' => ['cette donnee est obligatoire'],


            'VERIFICATIONMETHOD' => ['cette donnee est obligatoire'],


            'DEFAULTDEPTID' => ['cette donnee est obligatoire'],


            'SECURITYFLAGS' => ['cette donnee est obligatoire'],


            'ATT' => ['cette donnee est obligatoire'],


            'INLATE' => ['cette donnee est obligatoire'],


            'OUTEARLY' => ['cette donnee est obligatoire'],


            'OVERTIME' => ['cette donnee est obligatoire'],


            'SEP' => ['cette donnee est obligatoire'],


            'HOLIDAY' => ['cette donnee est obligatoire'],


            'MINZU' => ['cette donnee est obligatoire'],


            'PASSWORD' => ['cette donnee est obligatoire'],


            'LUNCHDURATION' => ['cette donnee est obligatoire'],


            'PHOTO' => ['cette donnee est obligatoire'],


            'mverifypass' => ['cette donnee est obligatoire'],


            'Notes' => ['cette donnee est obligatoire'],


            'privilege' => ['cette donnee est obligatoire'],


            'InheritDeptSch' => ['cette donnee est obligatoire'],


            'InheritDeptSchClass' => ['cette donnee est obligatoire'],


            'AutoSchPlan' => ['cette donnee est obligatoire'],


            'MinAutoSchInterval' => ['cette donnee est obligatoire'],


            'RegisterOT' => ['cette donnee est obligatoire'],


            'InheritDeptRule' => ['cette donnee est obligatoire'],


            'EMPRIVILEGE' => ['cette donnee est obligatoire'],


            'CardNo' => ['cette donnee est obligatoire'],


            'change_operator' => ['cette donnee est obligatoire'],


            'change_time' => ['cette donnee est obligatoire'],


            'create_operator' => ['cette donnee est obligatoire'],


            'create_time' => ['cette donnee est obligatoire'],


            'delete_operator' => ['cette donnee est obligatoire'],


            'delete_time' => ['cette donnee est obligatoire'],


            'status' => ['cette donnee est obligatoire'],


            'lastname' => ['cette donnee est obligatoire'],


            'AccGroup' => ['cette donnee est obligatoire'],


            'TimeZones' => ['cette donnee est obligatoire'],


            'identitycard' => ['cette donnee est obligatoire'],


            'UTime' => ['cette donnee est obligatoire'],


            'Education' => ['cette donnee est obligatoire'],


            'OffDuty' => ['cette donnee est obligatoire'],


            'DelTag' => ['cette donnee est obligatoire'],


            'morecard_group_id' => ['cette donnee est obligatoire'],


            'set_valid_time' => ['cette donnee est obligatoire'],


            'acc_startdate' => ['cette donnee est obligatoire'],


            'acc_enddate' => ['cette donnee est obligatoire'],


            'birthplace' => ['cette donnee est obligatoire'],


            'Political' => ['cette donnee est obligatoire'],


            'contry' => ['cette donnee est obligatoire'],


            'hiretype' => ['cette donnee est obligatoire'],


            'email' => ['cette donnee est obligatoire'],


            'firedate' => ['cette donnee est obligatoire'],


            'isatt' => ['cette donnee est obligatoire'],


            'homeaddress' => ['cette donnee est obligatoire'],


            'emptype' => ['cette donnee est obligatoire'],


            'bankcode1' => ['cette donnee est obligatoire'],


            'bankcode2' => ['cette donnee est obligatoire'],


            'isblacklist' => ['cette donnee est obligatoire'],


            'Iuser1' => ['cette donnee est obligatoire'],


            'Iuser2' => ['cette donnee est obligatoire'],


            'Iuser3' => ['cette donnee est obligatoire'],


            'Iuser4' => ['cette donnee est obligatoire'],


            'Iuser5' => ['cette donnee est obligatoire'],


            'Cuser1' => ['cette donnee est obligatoire'],


            'Cuser2' => ['cette donnee est obligatoire'],


            'Cuser3' => ['cette donnee est obligatoire'],


            'Cuser4' => ['cette donnee est obligatoire'],


            'Cuser5' => ['cette donnee est obligatoire'],


            'Duser1' => ['cette donnee est obligatoire'],


            'Duser2' => ['cette donnee est obligatoire'],


            'Duser3' => ['cette donnee est obligatoire'],


            'Duser4' => ['cette donnee est obligatoire'],


            'Duser5' => ['cette donnee est obligatoire'],


            'reserve' => ['cette donnee est obligatoire'],


            'carNo' => ['cette donnee est obligatoire'],


            'carType' => ['cette donnee est obligatoire'],


            'carBrand' => ['cette donnee est obligatoire'],


            'carColor' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['USERID'])) {

            $USERINFO->USERID = $data['USERID'];

        }


        if (!empty($data['Badgenumber'])) {

            $USERINFO->Badgenumber = $data['Badgenumber'];

        }


        if (!empty($data['SSN'])) {

            $USERINFO->SSN = $data['SSN'];

        }


        if (!empty($data['name'])) {

            $USERINFO->name = $data['name'];

        }


        if (!empty($data['Gender'])) {

            $USERINFO->Gender = $data['Gender'];

        }


        if (!empty($data['TITLE'])) {

            $USERINFO->TITLE = $data['TITLE'];

        }


        if (!empty($data['PAGER'])) {

            $USERINFO->PAGER = $data['PAGER'];

        }


        if (!empty($data['BIRTHDAY'])) {

            $USERINFO->BIRTHDAY = $data['BIRTHDAY'];

        }


        if (!empty($data['HIREDDAY'])) {

            $USERINFO->HIREDDAY = $data['HIREDDAY'];

        }


        if (!empty($data['street'])) {

            $USERINFO->street = $data['street'];

        }


        if (!empty($data['CITY'])) {

            $USERINFO->CITY = $data['CITY'];

        }


        if (!empty($data['STATE'])) {

            $USERINFO->STATE = $data['STATE'];

        }


        if (!empty($data['ZIP'])) {

            $USERINFO->ZIP = $data['ZIP'];

        }


        if (!empty($data['OPHONE'])) {

            $USERINFO->OPHONE = $data['OPHONE'];

        }


        if (!empty($data['FPHONE'])) {

            $USERINFO->FPHONE = $data['FPHONE'];

        }


        if (!empty($data['VERIFICATIONMETHOD'])) {

            $USERINFO->VERIFICATIONMETHOD = $data['VERIFICATIONMETHOD'];

        }


        if (!empty($data['DEFAULTDEPTID'])) {

            $USERINFO->DEFAULTDEPTID = $data['DEFAULTDEPTID'];

        }


        if (!empty($data['SECURITYFLAGS'])) {

            $USERINFO->SECURITYFLAGS = $data['SECURITYFLAGS'];

        }


        if (!empty($data['ATT'])) {

            $USERINFO->ATT = $data['ATT'];

        }


        if (!empty($data['INLATE'])) {

            $USERINFO->INLATE = $data['INLATE'];

        }


        if (!empty($data['OUTEARLY'])) {

            $USERINFO->OUTEARLY = $data['OUTEARLY'];

        }


        if (!empty($data['OVERTIME'])) {

            $USERINFO->OVERTIME = $data['OVERTIME'];

        }


        if (!empty($data['SEP'])) {

            $USERINFO->SEP = $data['SEP'];

        }


        if (!empty($data['HOLIDAY'])) {

            $USERINFO->HOLIDAY = $data['HOLIDAY'];

        }


        if (!empty($data['MINZU'])) {

            $USERINFO->MINZU = $data['MINZU'];

        }


        if (!empty($data['PASSWORD'])) {

            $USERINFO->PASSWORD = $data['PASSWORD'];

        }


        if (!empty($data['LUNCHDURATION'])) {

            $USERINFO->LUNCHDURATION = $data['LUNCHDURATION'];

        }


        if (!empty($data['PHOTO'])) {

            $USERINFO->PHOTO = $data['PHOTO'];

        }


        if (!empty($data['mverifypass'])) {

            $USERINFO->mverifypass = $data['mverifypass'];

        }


        if (!empty($data['Notes'])) {

            $USERINFO->Notes = $data['Notes'];

        }


        if (!empty($data['privilege'])) {

            $USERINFO->privilege = $data['privilege'];

        }


        if (!empty($data['InheritDeptSch'])) {

            $USERINFO->InheritDeptSch = $data['InheritDeptSch'];

        }


        if (!empty($data['InheritDeptSchClass'])) {

            $USERINFO->InheritDeptSchClass = $data['InheritDeptSchClass'];

        }


        if (!empty($data['AutoSchPlan'])) {

            $USERINFO->AutoSchPlan = $data['AutoSchPlan'];

        }


        if (!empty($data['MinAutoSchInterval'])) {

            $USERINFO->MinAutoSchInterval = $data['MinAutoSchInterval'];

        }


        if (!empty($data['RegisterOT'])) {

            $USERINFO->RegisterOT = $data['RegisterOT'];

        }


        if (!empty($data['InheritDeptRule'])) {

            $USERINFO->InheritDeptRule = $data['InheritDeptRule'];

        }


        if (!empty($data['EMPRIVILEGE'])) {

            $USERINFO->EMPRIVILEGE = $data['EMPRIVILEGE'];

        }


        if (!empty($data['CardNo'])) {

            $USERINFO->CardNo = $data['CardNo'];

        }


        if (!empty($data['change_operator'])) {

            $USERINFO->change_operator = $data['change_operator'];

        }


        if (!empty($data['change_time'])) {

            $USERINFO->change_time = $data['change_time'];

        }


        if (!empty($data['create_operator'])) {

            $USERINFO->create_operator = $data['create_operator'];

        }


        if (!empty($data['create_time'])) {

            $USERINFO->create_time = $data['create_time'];

        }


        if (!empty($data['delete_operator'])) {

            $USERINFO->delete_operator = $data['delete_operator'];

        }


        if (!empty($data['delete_time'])) {

            $USERINFO->delete_time = $data['delete_time'];

        }


        if (!empty($data['status'])) {

            $USERINFO->status = $data['status'];

        }


        if (!empty($data['lastname'])) {

            $USERINFO->lastname = $data['lastname'];

        }


        if (!empty($data['AccGroup'])) {

            $USERINFO->AccGroup = $data['AccGroup'];

        }


        if (!empty($data['TimeZones'])) {

            $USERINFO->TimeZones = $data['TimeZones'];

        }


        if (!empty($data['identitycard'])) {

            $USERINFO->identitycard = $data['identitycard'];

        }


        if (!empty($data['UTime'])) {

            $USERINFO->UTime = $data['UTime'];

        }


        if (!empty($data['Education'])) {

            $USERINFO->Education = $data['Education'];

        }


        if (!empty($data['OffDuty'])) {

            $USERINFO->OffDuty = $data['OffDuty'];

        }


        if (!empty($data['DelTag'])) {

            $USERINFO->DelTag = $data['DelTag'];

        }


        if (!empty($data['morecard_group_id'])) {

            $USERINFO->morecard_group_id = $data['morecard_group_id'];

        }


        if (!empty($data['set_valid_time'])) {

            $USERINFO->set_valid_time = $data['set_valid_time'];

        }


        if (!empty($data['acc_startdate'])) {

            $USERINFO->acc_startdate = $data['acc_startdate'];

        }


        if (!empty($data['acc_enddate'])) {

            $USERINFO->acc_enddate = $data['acc_enddate'];

        }


        if (!empty($data['birthplace'])) {

            $USERINFO->birthplace = $data['birthplace'];

        }


        if (!empty($data['Political'])) {

            $USERINFO->Political = $data['Political'];

        }


        if (!empty($data['contry'])) {

            $USERINFO->contry = $data['contry'];

        }


        if (!empty($data['hiretype'])) {

            $USERINFO->hiretype = $data['hiretype'];

        }


        if (!empty($data['email'])) {

            $USERINFO->email = $data['email'];

        }


        if (!empty($data['firedate'])) {

            $USERINFO->firedate = $data['firedate'];

        }


        if (!empty($data['isatt'])) {

            $USERINFO->isatt = $data['isatt'];

        }


        if (!empty($data['homeaddress'])) {

            $USERINFO->homeaddress = $data['homeaddress'];

        }


        if (!empty($data['emptype'])) {

            $USERINFO->emptype = $data['emptype'];

        }


        if (!empty($data['bankcode1'])) {

            $USERINFO->bankcode1 = $data['bankcode1'];

        }


        if (!empty($data['bankcode2'])) {

            $USERINFO->bankcode2 = $data['bankcode2'];

        }


        if (!empty($data['isblacklist'])) {

            $USERINFO->isblacklist = $data['isblacklist'];

        }


        if (!empty($data['Iuser1'])) {

            $USERINFO->Iuser1 = $data['Iuser1'];

        }


        if (!empty($data['Iuser2'])) {

            $USERINFO->Iuser2 = $data['Iuser2'];

        }


        if (!empty($data['Iuser3'])) {

            $USERINFO->Iuser3 = $data['Iuser3'];

        }


        if (!empty($data['Iuser4'])) {

            $USERINFO->Iuser4 = $data['Iuser4'];

        }


        if (!empty($data['Iuser5'])) {

            $USERINFO->Iuser5 = $data['Iuser5'];

        }


        if (!empty($data['Cuser1'])) {

            $USERINFO->Cuser1 = $data['Cuser1'];

        }


        if (!empty($data['Cuser2'])) {

            $USERINFO->Cuser2 = $data['Cuser2'];

        }


        if (!empty($data['Cuser3'])) {

            $USERINFO->Cuser3 = $data['Cuser3'];

        }


        if (!empty($data['Cuser4'])) {

            $USERINFO->Cuser4 = $data['Cuser4'];

        }


        if (!empty($data['Cuser5'])) {

            $USERINFO->Cuser5 = $data['Cuser5'];

        }


        if (!empty($data['Duser1'])) {

            $USERINFO->Duser1 = $data['Duser1'];

        }


        if (!empty($data['Duser2'])) {

            $USERINFO->Duser2 = $data['Duser2'];

        }


        if (!empty($data['Duser3'])) {

            $USERINFO->Duser3 = $data['Duser3'];

        }


        if (!empty($data['Duser4'])) {

            $USERINFO->Duser4 = $data['Duser4'];

        }


        if (!empty($data['Duser5'])) {

            $USERINFO->Duser5 = $data['Duser5'];

        }


        if (!empty($data['reserve'])) {

            $USERINFO->reserve = $data['reserve'];

        }


        if (!empty($data['carNo'])) {

            $USERINFO->carNo = $data['carNo'];

        }


        if (!empty($data['carType'])) {

            $USERINFO->carType = $data['carType'];

        }


        if (!empty($data['carBrand'])) {

            $USERINFO->carBrand = $data['carBrand'];

        }


        if (!empty($data['carColor'])) {

            $USERINFO->carColor = $data['carColor'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $USERINFO->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\USERINFOExtras') &&
            method_exists('\App\Http\Extras\USERINFOExtras', 'beforeSaveCreate')
        ) {
            USERINFOExtras::beforeSaveCreate($request, $USERINFO);
        }


        $USERINFO->save();
        $USERINFO = USERINFO::find($USERINFO->id);
        $newCrudData = [];

        $newCrudData['USERID'] = $USERINFO->USERID;
        $newCrudData['Badgenumber'] = $USERINFO->Badgenumber;
        $newCrudData['SSN'] = $USERINFO->SSN;
        $newCrudData['name'] = $USERINFO->name;
        $newCrudData['Gender'] = $USERINFO->Gender;
        $newCrudData['TITLE'] = $USERINFO->TITLE;
        $newCrudData['PAGER'] = $USERINFO->PAGER;
        $newCrudData['BIRTHDAY'] = $USERINFO->BIRTHDAY;
        $newCrudData['HIREDDAY'] = $USERINFO->HIREDDAY;
        $newCrudData['street'] = $USERINFO->street;
        $newCrudData['CITY'] = $USERINFO->CITY;
        $newCrudData['STATE'] = $USERINFO->STATE;
        $newCrudData['ZIP'] = $USERINFO->ZIP;
        $newCrudData['OPHONE'] = $USERINFO->OPHONE;
        $newCrudData['FPHONE'] = $USERINFO->FPHONE;
        $newCrudData['VERIFICATIONMETHOD'] = $USERINFO->VERIFICATIONMETHOD;
        $newCrudData['DEFAULTDEPTID'] = $USERINFO->DEFAULTDEPTID;
        $newCrudData['SECURITYFLAGS'] = $USERINFO->SECURITYFLAGS;
        $newCrudData['ATT'] = $USERINFO->ATT;
        $newCrudData['INLATE'] = $USERINFO->INLATE;
        $newCrudData['OUTEARLY'] = $USERINFO->OUTEARLY;
        $newCrudData['OVERTIME'] = $USERINFO->OVERTIME;
        $newCrudData['SEP'] = $USERINFO->SEP;
        $newCrudData['HOLIDAY'] = $USERINFO->HOLIDAY;
        $newCrudData['MINZU'] = $USERINFO->MINZU;
        $newCrudData['PASSWORD'] = $USERINFO->PASSWORD;
        $newCrudData['LUNCHDURATION'] = $USERINFO->LUNCHDURATION;
        $newCrudData['PHOTO'] = $USERINFO->PHOTO;
        $newCrudData['mverifypass'] = $USERINFO->mverifypass;
        $newCrudData['Notes'] = $USERINFO->Notes;
        $newCrudData['privilege'] = $USERINFO->privilege;
        $newCrudData['InheritDeptSch'] = $USERINFO->InheritDeptSch;
        $newCrudData['InheritDeptSchClass'] = $USERINFO->InheritDeptSchClass;
        $newCrudData['AutoSchPlan'] = $USERINFO->AutoSchPlan;
        $newCrudData['MinAutoSchInterval'] = $USERINFO->MinAutoSchInterval;
        $newCrudData['RegisterOT'] = $USERINFO->RegisterOT;
        $newCrudData['InheritDeptRule'] = $USERINFO->InheritDeptRule;
        $newCrudData['EMPRIVILEGE'] = $USERINFO->EMPRIVILEGE;
        $newCrudData['CardNo'] = $USERINFO->CardNo;
        $newCrudData['change_operator'] = $USERINFO->change_operator;
        $newCrudData['change_time'] = $USERINFO->change_time;
        $newCrudData['create_operator'] = $USERINFO->create_operator;
        $newCrudData['create_time'] = $USERINFO->create_time;
        $newCrudData['delete_operator'] = $USERINFO->delete_operator;
        $newCrudData['delete_time'] = $USERINFO->delete_time;
        $newCrudData['status'] = $USERINFO->status;
        $newCrudData['lastname'] = $USERINFO->lastname;
        $newCrudData['AccGroup'] = $USERINFO->AccGroup;
        $newCrudData['TimeZones'] = $USERINFO->TimeZones;
        $newCrudData['identitycard'] = $USERINFO->identitycard;
        $newCrudData['UTime'] = $USERINFO->UTime;
        $newCrudData['Education'] = $USERINFO->Education;
        $newCrudData['OffDuty'] = $USERINFO->OffDuty;
        $newCrudData['DelTag'] = $USERINFO->DelTag;
        $newCrudData['set_valid_time'] = $USERINFO->set_valid_time;
        $newCrudData['acc_startdate'] = $USERINFO->acc_startdate;
        $newCrudData['acc_enddate'] = $USERINFO->acc_enddate;
        $newCrudData['birthplace'] = $USERINFO->birthplace;
        $newCrudData['Political'] = $USERINFO->Political;
        $newCrudData['contry'] = $USERINFO->contry;
        $newCrudData['hiretype'] = $USERINFO->hiretype;
        $newCrudData['email'] = $USERINFO->email;
        $newCrudData['firedate'] = $USERINFO->firedate;
        $newCrudData['isatt'] = $USERINFO->isatt;
        $newCrudData['homeaddress'] = $USERINFO->homeaddress;
        $newCrudData['emptype'] = $USERINFO->emptype;
        $newCrudData['bankcode1'] = $USERINFO->bankcode1;
        $newCrudData['bankcode2'] = $USERINFO->bankcode2;
        $newCrudData['isblacklist'] = $USERINFO->isblacklist;
        $newCrudData['Iuser1'] = $USERINFO->Iuser1;
        $newCrudData['Iuser2'] = $USERINFO->Iuser2;
        $newCrudData['Iuser3'] = $USERINFO->Iuser3;
        $newCrudData['Iuser4'] = $USERINFO->Iuser4;
        $newCrudData['Iuser5'] = $USERINFO->Iuser5;
        $newCrudData['Cuser1'] = $USERINFO->Cuser1;
        $newCrudData['Cuser2'] = $USERINFO->Cuser2;
        $newCrudData['Cuser3'] = $USERINFO->Cuser3;
        $newCrudData['Cuser4'] = $USERINFO->Cuser4;
        $newCrudData['Cuser5'] = $USERINFO->Cuser5;
        $newCrudData['Duser1'] = $USERINFO->Duser1;
        $newCrudData['Duser2'] = $USERINFO->Duser2;
        $newCrudData['Duser3'] = $USERINFO->Duser3;
        $newCrudData['Duser4'] = $USERINFO->Duser4;
        $newCrudData['Duser5'] = $USERINFO->Duser5;
        $newCrudData['reserve'] = $USERINFO->reserve;
        $newCrudData['carNo'] = $USERINFO->carNo;
        $newCrudData['carType'] = $USERINFO->carType;
        $newCrudData['carBrand'] = $USERINFO->carBrand;
        $newCrudData['carColor'] = $USERINFO->carColor;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'USERINFO', 'entite_cle' => $USERINFO->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $USERINFO->toArray();


        try {

            foreach ($USERINFO->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, USERINFO $USERINFO)
    {


        $oldCrudData = [];

        $oldCrudData['USERID'] = $USERINFO->USERID;
        $oldCrudData['Badgenumber'] = $USERINFO->Badgenumber;
        $oldCrudData['SSN'] = $USERINFO->SSN;
        $oldCrudData['name'] = $USERINFO->name;
        $oldCrudData['Gender'] = $USERINFO->Gender;
        $oldCrudData['TITLE'] = $USERINFO->TITLE;
        $oldCrudData['PAGER'] = $USERINFO->PAGER;
        $oldCrudData['BIRTHDAY'] = $USERINFO->BIRTHDAY;
        $oldCrudData['HIREDDAY'] = $USERINFO->HIREDDAY;
        $oldCrudData['street'] = $USERINFO->street;
        $oldCrudData['CITY'] = $USERINFO->CITY;
        $oldCrudData['STATE'] = $USERINFO->STATE;
        $oldCrudData['ZIP'] = $USERINFO->ZIP;
        $oldCrudData['OPHONE'] = $USERINFO->OPHONE;
        $oldCrudData['FPHONE'] = $USERINFO->FPHONE;
        $oldCrudData['VERIFICATIONMETHOD'] = $USERINFO->VERIFICATIONMETHOD;
        $oldCrudData['DEFAULTDEPTID'] = $USERINFO->DEFAULTDEPTID;
        $oldCrudData['SECURITYFLAGS'] = $USERINFO->SECURITYFLAGS;
        $oldCrudData['ATT'] = $USERINFO->ATT;
        $oldCrudData['INLATE'] = $USERINFO->INLATE;
        $oldCrudData['OUTEARLY'] = $USERINFO->OUTEARLY;
        $oldCrudData['OVERTIME'] = $USERINFO->OVERTIME;
        $oldCrudData['SEP'] = $USERINFO->SEP;
        $oldCrudData['HOLIDAY'] = $USERINFO->HOLIDAY;
        $oldCrudData['MINZU'] = $USERINFO->MINZU;
        $oldCrudData['PASSWORD'] = $USERINFO->PASSWORD;
        $oldCrudData['LUNCHDURATION'] = $USERINFO->LUNCHDURATION;
        $oldCrudData['PHOTO'] = $USERINFO->PHOTO;
        $oldCrudData['mverifypass'] = $USERINFO->mverifypass;
        $oldCrudData['Notes'] = $USERINFO->Notes;
        $oldCrudData['privilege'] = $USERINFO->privilege;
        $oldCrudData['InheritDeptSch'] = $USERINFO->InheritDeptSch;
        $oldCrudData['InheritDeptSchClass'] = $USERINFO->InheritDeptSchClass;
        $oldCrudData['AutoSchPlan'] = $USERINFO->AutoSchPlan;
        $oldCrudData['MinAutoSchInterval'] = $USERINFO->MinAutoSchInterval;
        $oldCrudData['RegisterOT'] = $USERINFO->RegisterOT;
        $oldCrudData['InheritDeptRule'] = $USERINFO->InheritDeptRule;
        $oldCrudData['EMPRIVILEGE'] = $USERINFO->EMPRIVILEGE;
        $oldCrudData['CardNo'] = $USERINFO->CardNo;
        $oldCrudData['change_operator'] = $USERINFO->change_operator;
        $oldCrudData['change_time'] = $USERINFO->change_time;
        $oldCrudData['create_operator'] = $USERINFO->create_operator;
        $oldCrudData['create_time'] = $USERINFO->create_time;
        $oldCrudData['delete_operator'] = $USERINFO->delete_operator;
        $oldCrudData['delete_time'] = $USERINFO->delete_time;
        $oldCrudData['status'] = $USERINFO->status;
        $oldCrudData['lastname'] = $USERINFO->lastname;
        $oldCrudData['AccGroup'] = $USERINFO->AccGroup;
        $oldCrudData['TimeZones'] = $USERINFO->TimeZones;
        $oldCrudData['identitycard'] = $USERINFO->identitycard;
        $oldCrudData['UTime'] = $USERINFO->UTime;
        $oldCrudData['Education'] = $USERINFO->Education;
        $oldCrudData['OffDuty'] = $USERINFO->OffDuty;
        $oldCrudData['DelTag'] = $USERINFO->DelTag;
        $oldCrudData['set_valid_time'] = $USERINFO->set_valid_time;
        $oldCrudData['acc_startdate'] = $USERINFO->acc_startdate;
        $oldCrudData['acc_enddate'] = $USERINFO->acc_enddate;
        $oldCrudData['birthplace'] = $USERINFO->birthplace;
        $oldCrudData['Political'] = $USERINFO->Political;
        $oldCrudData['contry'] = $USERINFO->contry;
        $oldCrudData['hiretype'] = $USERINFO->hiretype;
        $oldCrudData['email'] = $USERINFO->email;
        $oldCrudData['firedate'] = $USERINFO->firedate;
        $oldCrudData['isatt'] = $USERINFO->isatt;
        $oldCrudData['homeaddress'] = $USERINFO->homeaddress;
        $oldCrudData['emptype'] = $USERINFO->emptype;
        $oldCrudData['bankcode1'] = $USERINFO->bankcode1;
        $oldCrudData['bankcode2'] = $USERINFO->bankcode2;
        $oldCrudData['isblacklist'] = $USERINFO->isblacklist;
        $oldCrudData['Iuser1'] = $USERINFO->Iuser1;
        $oldCrudData['Iuser2'] = $USERINFO->Iuser2;
        $oldCrudData['Iuser3'] = $USERINFO->Iuser3;
        $oldCrudData['Iuser4'] = $USERINFO->Iuser4;
        $oldCrudData['Iuser5'] = $USERINFO->Iuser5;
        $oldCrudData['Cuser1'] = $USERINFO->Cuser1;
        $oldCrudData['Cuser2'] = $USERINFO->Cuser2;
        $oldCrudData['Cuser3'] = $USERINFO->Cuser3;
        $oldCrudData['Cuser4'] = $USERINFO->Cuser4;
        $oldCrudData['Cuser5'] = $USERINFO->Cuser5;
        $oldCrudData['Duser1'] = $USERINFO->Duser1;
        $oldCrudData['Duser2'] = $USERINFO->Duser2;
        $oldCrudData['Duser3'] = $USERINFO->Duser3;
        $oldCrudData['Duser4'] = $USERINFO->Duser4;
        $oldCrudData['Duser5'] = $USERINFO->Duser5;
        $oldCrudData['reserve'] = $USERINFO->reserve;
        $oldCrudData['carNo'] = $USERINFO->carNo;
        $oldCrudData['carType'] = $USERINFO->carType;
        $oldCrudData['carBrand'] = $USERINFO->carBrand;
        $oldCrudData['carColor'] = $USERINFO->carColor;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "USERINFO" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'USERID',
            'Badgenumber',
            'SSN',
            'name',
            'Gender',
            'TITLE',
            'PAGER',
            'BIRTHDAY',
            'HIREDDAY',
            'street',
            'CITY',
            'STATE',
            'ZIP',
            'OPHONE',
            'FPHONE',
            'VERIFICATIONMETHOD',
            'DEFAULTDEPTID',
            'SECURITYFLAGS',
            'ATT',
            'INLATE',
            'OUTEARLY',
            'OVERTIME',
            'SEP',
            'HOLIDAY',
            'MINZU',
            'PASSWORD',
            'LUNCHDURATION',
            'PHOTO',
            'mverifypass',
            'Notes',
            'privilege',
            'InheritDeptSch',
            'InheritDeptSchClass',
            'AutoSchPlan',
            'MinAutoSchInterval',
            'RegisterOT',
            'InheritDeptRule',
            'EMPRIVILEGE',
            'CardNo',
            'change_operator',
            'change_time',
            'create_operator',
            'create_time',
            'delete_operator',
            'delete_time',
            'status',
            'lastname',
            'AccGroup',
            'TimeZones',
            'identitycard',
            'UTime',
            'Education',
            'OffDuty',
            'DelTag',
            'morecard_group_id',
            'set_valid_time',
            'acc_startdate',
            'acc_enddate',
            'birthplace',
            'Political',
            'contry',
            'hiretype',
            'email',
            'firedate',
            'isatt',
            'homeaddress',
            'emptype',
            'bankcode1',
            'bankcode2',
            'isblacklist',
            'Iuser1',
            'Iuser2',
            'Iuser3',
            'Iuser4',
            'Iuser5',
            'Cuser1',
            'Cuser2',
            'Cuser3',
            'Cuser4',
            'Cuser5',
            'Duser1',
            'Duser2',
            'Duser3',
            'Duser4',
            'Duser5',
            'reserve',
            'carNo',
            'carType',
            'carBrand',
            'carColor',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'USERID' => [
                //'required'
            ],


            'Badgenumber' => [
                //'required'
            ],


            'SSN' => [
                //'required'
            ],


            'name' => [
                //'required'
            ],


            'Gender' => [
                //'required'
            ],


            'TITLE' => [
                //'required'
            ],


            'PAGER' => [
                //'required'
            ],


            'BIRTHDAY' => [
                //'required'
            ],


            'HIREDDAY' => [
                //'required'
            ],


            'street' => [
                //'required'
            ],


            'CITY' => [
                //'required'
            ],


            'STATE' => [
                //'required'
            ],


            'ZIP' => [
                //'required'
            ],


            'OPHONE' => [
                //'required'
            ],


            'FPHONE' => [
                //'required'
            ],


            'VERIFICATIONMETHOD' => [
                //'required'
            ],


            'DEFAULTDEPTID' => [
                //'required'
            ],


            'SECURITYFLAGS' => [
                //'required'
            ],


            'ATT' => [
                //'required'
            ],


            'INLATE' => [
                //'required'
            ],


            'OUTEARLY' => [
                //'required'
            ],


            'OVERTIME' => [
                //'required'
            ],


            'SEP' => [
                //'required'
            ],


            'HOLIDAY' => [
                //'required'
            ],


            'MINZU' => [
                //'required'
            ],


            'PASSWORD' => [
                //'required'
            ],


            'LUNCHDURATION' => [
                //'required'
            ],


            'PHOTO' => [
                //'required'
            ],


            'mverifypass' => [
                //'required'
            ],


            'Notes' => [
                //'required'
            ],


            'privilege' => [
                //'required'
            ],


            'InheritDeptSch' => [
                //'required'
            ],


            'InheritDeptSchClass' => [
                //'required'
            ],


            'AutoSchPlan' => [
                //'required'
            ],


            'MinAutoSchInterval' => [
                //'required'
            ],


            'RegisterOT' => [
                //'required'
            ],


            'InheritDeptRule' => [
                //'required'
            ],


            'EMPRIVILEGE' => [
                //'required'
            ],


            'CardNo' => [
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


            'lastname' => [
                //'required'
            ],


            'AccGroup' => [
                //'required'
            ],


            'TimeZones' => [
                //'required'
            ],


            'identitycard' => [
                //'required'
            ],


            'UTime' => [
                //'required'
            ],


            'Education' => [
                //'required'
            ],


            'OffDuty' => [
                //'required'
            ],


            'DelTag' => [
                //'required'
            ],


            'morecard_group_id' => [
                //'required'
            ],


            'set_valid_time' => [
                //'required'
            ],


            'acc_startdate' => [
                //'required'
            ],


            'acc_enddate' => [
                //'required'
            ],


            'birthplace' => [
                //'required'
            ],


            'Political' => [
                //'required'
            ],


            'contry' => [
                //'required'
            ],


            'hiretype' => [
                //'required'
            ],


            'email' => [
                //'required'
            ],


            'firedate' => [
                //'required'
            ],


            'isatt' => [
                //'required'
            ],


            'homeaddress' => [
                //'required'
            ],


            'emptype' => [
                //'required'
            ],


            'bankcode1' => [
                //'required'
            ],


            'bankcode2' => [
                //'required'
            ],


            'isblacklist' => [
                //'required'
            ],


            'Iuser1' => [
                //'required'
            ],


            'Iuser2' => [
                //'required'
            ],


            'Iuser3' => [
                //'required'
            ],


            'Iuser4' => [
                //'required'
            ],


            'Iuser5' => [
                //'required'
            ],


            'Cuser1' => [
                //'required'
            ],


            'Cuser2' => [
                //'required'
            ],


            'Cuser3' => [
                //'required'
            ],


            'Cuser4' => [
                //'required'
            ],


            'Cuser5' => [
                //'required'
            ],


            'Duser1' => [
                //'required'
            ],


            'Duser2' => [
                //'required'
            ],


            'Duser3' => [
                //'required'
            ],


            'Duser4' => [
                //'required'
            ],


            'Duser5' => [
                //'required'
            ],


            'reserve' => [
                //'required'
            ],


            'carNo' => [
                //'required'
            ],


            'carType' => [
                //'required'
            ],


            'carBrand' => [
                //'required'
            ],


            'carColor' => [
                //'required'
            ],


        ], $messages = [


            'USERID' => ['cette donnee est obligatoire'],


            'Badgenumber' => ['cette donnee est obligatoire'],


            'SSN' => ['cette donnee est obligatoire'],


            'name' => ['cette donnee est obligatoire'],


            'Gender' => ['cette donnee est obligatoire'],


            'TITLE' => ['cette donnee est obligatoire'],


            'PAGER' => ['cette donnee est obligatoire'],


            'BIRTHDAY' => ['cette donnee est obligatoire'],


            'HIREDDAY' => ['cette donnee est obligatoire'],


            'street' => ['cette donnee est obligatoire'],


            'CITY' => ['cette donnee est obligatoire'],


            'STATE' => ['cette donnee est obligatoire'],


            'ZIP' => ['cette donnee est obligatoire'],


            'OPHONE' => ['cette donnee est obligatoire'],


            'FPHONE' => ['cette donnee est obligatoire'],


            'VERIFICATIONMETHOD' => ['cette donnee est obligatoire'],


            'DEFAULTDEPTID' => ['cette donnee est obligatoire'],


            'SECURITYFLAGS' => ['cette donnee est obligatoire'],


            'ATT' => ['cette donnee est obligatoire'],


            'INLATE' => ['cette donnee est obligatoire'],


            'OUTEARLY' => ['cette donnee est obligatoire'],


            'OVERTIME' => ['cette donnee est obligatoire'],


            'SEP' => ['cette donnee est obligatoire'],


            'HOLIDAY' => ['cette donnee est obligatoire'],


            'MINZU' => ['cette donnee est obligatoire'],


            'PASSWORD' => ['cette donnee est obligatoire'],


            'LUNCHDURATION' => ['cette donnee est obligatoire'],


            'PHOTO' => ['cette donnee est obligatoire'],


            'mverifypass' => ['cette donnee est obligatoire'],


            'Notes' => ['cette donnee est obligatoire'],


            'privilege' => ['cette donnee est obligatoire'],


            'InheritDeptSch' => ['cette donnee est obligatoire'],


            'InheritDeptSchClass' => ['cette donnee est obligatoire'],


            'AutoSchPlan' => ['cette donnee est obligatoire'],


            'MinAutoSchInterval' => ['cette donnee est obligatoire'],


            'RegisterOT' => ['cette donnee est obligatoire'],


            'InheritDeptRule' => ['cette donnee est obligatoire'],


            'EMPRIVILEGE' => ['cette donnee est obligatoire'],


            'CardNo' => ['cette donnee est obligatoire'],


            'change_operator' => ['cette donnee est obligatoire'],


            'change_time' => ['cette donnee est obligatoire'],


            'create_operator' => ['cette donnee est obligatoire'],


            'create_time' => ['cette donnee est obligatoire'],


            'delete_operator' => ['cette donnee est obligatoire'],


            'delete_time' => ['cette donnee est obligatoire'],


            'status' => ['cette donnee est obligatoire'],


            'lastname' => ['cette donnee est obligatoire'],


            'AccGroup' => ['cette donnee est obligatoire'],


            'TimeZones' => ['cette donnee est obligatoire'],


            'identitycard' => ['cette donnee est obligatoire'],


            'UTime' => ['cette donnee est obligatoire'],


            'Education' => ['cette donnee est obligatoire'],


            'OffDuty' => ['cette donnee est obligatoire'],


            'DelTag' => ['cette donnee est obligatoire'],


            'morecard_group_id' => ['cette donnee est obligatoire'],


            'set_valid_time' => ['cette donnee est obligatoire'],


            'acc_startdate' => ['cette donnee est obligatoire'],


            'acc_enddate' => ['cette donnee est obligatoire'],


            'birthplace' => ['cette donnee est obligatoire'],


            'Political' => ['cette donnee est obligatoire'],


            'contry' => ['cette donnee est obligatoire'],


            'hiretype' => ['cette donnee est obligatoire'],


            'email' => ['cette donnee est obligatoire'],


            'firedate' => ['cette donnee est obligatoire'],


            'isatt' => ['cette donnee est obligatoire'],


            'homeaddress' => ['cette donnee est obligatoire'],


            'emptype' => ['cette donnee est obligatoire'],


            'bankcode1' => ['cette donnee est obligatoire'],


            'bankcode2' => ['cette donnee est obligatoire'],


            'isblacklist' => ['cette donnee est obligatoire'],


            'Iuser1' => ['cette donnee est obligatoire'],


            'Iuser2' => ['cette donnee est obligatoire'],


            'Iuser3' => ['cette donnee est obligatoire'],


            'Iuser4' => ['cette donnee est obligatoire'],


            'Iuser5' => ['cette donnee est obligatoire'],


            'Cuser1' => ['cette donnee est obligatoire'],


            'Cuser2' => ['cette donnee est obligatoire'],


            'Cuser3' => ['cette donnee est obligatoire'],


            'Cuser4' => ['cette donnee est obligatoire'],


            'Cuser5' => ['cette donnee est obligatoire'],


            'Duser1' => ['cette donnee est obligatoire'],


            'Duser2' => ['cette donnee est obligatoire'],


            'Duser3' => ['cette donnee est obligatoire'],


            'Duser4' => ['cette donnee est obligatoire'],


            'Duser5' => ['cette donnee est obligatoire'],


            'reserve' => ['cette donnee est obligatoire'],


            'carNo' => ['cette donnee est obligatoire'],


            'carType' => ['cette donnee est obligatoire'],


            'carBrand' => ['cette donnee est obligatoire'],


            'carColor' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("USERID", $data)) {


            if (!empty($data['USERID'])) {

                $USERINFO->USERID = $data['USERID'];

            }

        }


        if (array_key_exists("Badgenumber", $data)) {


            if (!empty($data['Badgenumber'])) {

                $USERINFO->Badgenumber = $data['Badgenumber'];

            }

        }


        if (array_key_exists("SSN", $data)) {


            if (!empty($data['SSN'])) {

                $USERINFO->SSN = $data['SSN'];

            }

        }


        if (array_key_exists("name", $data)) {


            if (!empty($data['name'])) {

                $USERINFO->name = $data['name'];

            }

        }


        if (array_key_exists("Gender", $data)) {


            if (!empty($data['Gender'])) {

                $USERINFO->Gender = $data['Gender'];

            }

        }


        if (array_key_exists("TITLE", $data)) {


            if (!empty($data['TITLE'])) {

                $USERINFO->TITLE = $data['TITLE'];

            }

        }


        if (array_key_exists("PAGER", $data)) {


            if (!empty($data['PAGER'])) {

                $USERINFO->PAGER = $data['PAGER'];

            }

        }


        if (array_key_exists("BIRTHDAY", $data)) {


            if (!empty($data['BIRTHDAY'])) {

                $USERINFO->BIRTHDAY = $data['BIRTHDAY'];

            }

        }


        if (array_key_exists("HIREDDAY", $data)) {


            if (!empty($data['HIREDDAY'])) {

                $USERINFO->HIREDDAY = $data['HIREDDAY'];

            }

        }


        if (array_key_exists("street", $data)) {


            if (!empty($data['street'])) {

                $USERINFO->street = $data['street'];

            }

        }


        if (array_key_exists("CITY", $data)) {


            if (!empty($data['CITY'])) {

                $USERINFO->CITY = $data['CITY'];

            }

        }


        if (array_key_exists("STATE", $data)) {


            if (!empty($data['STATE'])) {

                $USERINFO->STATE = $data['STATE'];

            }

        }


        if (array_key_exists("ZIP", $data)) {


            if (!empty($data['ZIP'])) {

                $USERINFO->ZIP = $data['ZIP'];

            }

        }


        if (array_key_exists("OPHONE", $data)) {


            if (!empty($data['OPHONE'])) {

                $USERINFO->OPHONE = $data['OPHONE'];

            }

        }


        if (array_key_exists("FPHONE", $data)) {


            if (!empty($data['FPHONE'])) {

                $USERINFO->FPHONE = $data['FPHONE'];

            }

        }


        if (array_key_exists("VERIFICATIONMETHOD", $data)) {


            if (!empty($data['VERIFICATIONMETHOD'])) {

                $USERINFO->VERIFICATIONMETHOD = $data['VERIFICATIONMETHOD'];

            }

        }


        if (array_key_exists("DEFAULTDEPTID", $data)) {


            if (!empty($data['DEFAULTDEPTID'])) {

                $USERINFO->DEFAULTDEPTID = $data['DEFAULTDEPTID'];

            }

        }


        if (array_key_exists("SECURITYFLAGS", $data)) {


            if (!empty($data['SECURITYFLAGS'])) {

                $USERINFO->SECURITYFLAGS = $data['SECURITYFLAGS'];

            }

        }


        if (array_key_exists("ATT", $data)) {


            if (!empty($data['ATT'])) {

                $USERINFO->ATT = $data['ATT'];

            }

        }


        if (array_key_exists("INLATE", $data)) {


            if (!empty($data['INLATE'])) {

                $USERINFO->INLATE = $data['INLATE'];

            }

        }


        if (array_key_exists("OUTEARLY", $data)) {


            if (!empty($data['OUTEARLY'])) {

                $USERINFO->OUTEARLY = $data['OUTEARLY'];

            }

        }


        if (array_key_exists("OVERTIME", $data)) {


            if (!empty($data['OVERTIME'])) {

                $USERINFO->OVERTIME = $data['OVERTIME'];

            }

        }


        if (array_key_exists("SEP", $data)) {


            if (!empty($data['SEP'])) {

                $USERINFO->SEP = $data['SEP'];

            }

        }


        if (array_key_exists("HOLIDAY", $data)) {


            if (!empty($data['HOLIDAY'])) {

                $USERINFO->HOLIDAY = $data['HOLIDAY'];

            }

        }


        if (array_key_exists("MINZU", $data)) {


            if (!empty($data['MINZU'])) {

                $USERINFO->MINZU = $data['MINZU'];

            }

        }


        if (array_key_exists("PASSWORD", $data)) {


            if (!empty($data['PASSWORD'])) {

                $USERINFO->PASSWORD = $data['PASSWORD'];

            }

        }


        if (array_key_exists("LUNCHDURATION", $data)) {


            if (!empty($data['LUNCHDURATION'])) {

                $USERINFO->LUNCHDURATION = $data['LUNCHDURATION'];

            }

        }


        if (array_key_exists("PHOTO", $data)) {


            if (!empty($data['PHOTO'])) {

                $USERINFO->PHOTO = $data['PHOTO'];

            }

        }


        if (array_key_exists("mverifypass", $data)) {


            if (!empty($data['mverifypass'])) {

                $USERINFO->mverifypass = $data['mverifypass'];

            }

        }


        if (array_key_exists("Notes", $data)) {


            if (!empty($data['Notes'])) {

                $USERINFO->Notes = $data['Notes'];

            }

        }


        if (array_key_exists("privilege", $data)) {


            if (!empty($data['privilege'])) {

                $USERINFO->privilege = $data['privilege'];

            }

        }


        if (array_key_exists("InheritDeptSch", $data)) {


            if (!empty($data['InheritDeptSch'])) {

                $USERINFO->InheritDeptSch = $data['InheritDeptSch'];

            }

        }


        if (array_key_exists("InheritDeptSchClass", $data)) {


            if (!empty($data['InheritDeptSchClass'])) {

                $USERINFO->InheritDeptSchClass = $data['InheritDeptSchClass'];

            }

        }


        if (array_key_exists("AutoSchPlan", $data)) {


            if (!empty($data['AutoSchPlan'])) {

                $USERINFO->AutoSchPlan = $data['AutoSchPlan'];

            }

        }


        if (array_key_exists("MinAutoSchInterval", $data)) {


            if (!empty($data['MinAutoSchInterval'])) {

                $USERINFO->MinAutoSchInterval = $data['MinAutoSchInterval'];

            }

        }


        if (array_key_exists("RegisterOT", $data)) {


            if (!empty($data['RegisterOT'])) {

                $USERINFO->RegisterOT = $data['RegisterOT'];

            }

        }


        if (array_key_exists("InheritDeptRule", $data)) {


            if (!empty($data['InheritDeptRule'])) {

                $USERINFO->InheritDeptRule = $data['InheritDeptRule'];

            }

        }


        if (array_key_exists("EMPRIVILEGE", $data)) {


            if (!empty($data['EMPRIVILEGE'])) {

                $USERINFO->EMPRIVILEGE = $data['EMPRIVILEGE'];

            }

        }


        if (array_key_exists("CardNo", $data)) {


            if (!empty($data['CardNo'])) {

                $USERINFO->CardNo = $data['CardNo'];

            }

        }


        if (array_key_exists("change_operator", $data)) {


            if (!empty($data['change_operator'])) {

                $USERINFO->change_operator = $data['change_operator'];

            }

        }


        if (array_key_exists("change_time", $data)) {


            if (!empty($data['change_time'])) {

                $USERINFO->change_time = $data['change_time'];

            }

        }


        if (array_key_exists("create_operator", $data)) {


            if (!empty($data['create_operator'])) {

                $USERINFO->create_operator = $data['create_operator'];

            }

        }


        if (array_key_exists("create_time", $data)) {


            if (!empty($data['create_time'])) {

                $USERINFO->create_time = $data['create_time'];

            }

        }


        if (array_key_exists("delete_operator", $data)) {


            if (!empty($data['delete_operator'])) {

                $USERINFO->delete_operator = $data['delete_operator'];

            }

        }


        if (array_key_exists("delete_time", $data)) {


            if (!empty($data['delete_time'])) {

                $USERINFO->delete_time = $data['delete_time'];

            }

        }


        if (array_key_exists("status", $data)) {


            if (!empty($data['status'])) {

                $USERINFO->status = $data['status'];

            }

        }


        if (array_key_exists("lastname", $data)) {


            if (!empty($data['lastname'])) {

                $USERINFO->lastname = $data['lastname'];

            }

        }


        if (array_key_exists("AccGroup", $data)) {


            if (!empty($data['AccGroup'])) {

                $USERINFO->AccGroup = $data['AccGroup'];

            }

        }


        if (array_key_exists("TimeZones", $data)) {


            if (!empty($data['TimeZones'])) {

                $USERINFO->TimeZones = $data['TimeZones'];

            }

        }


        if (array_key_exists("identitycard", $data)) {


            if (!empty($data['identitycard'])) {

                $USERINFO->identitycard = $data['identitycard'];

            }

        }


        if (array_key_exists("UTime", $data)) {


            if (!empty($data['UTime'])) {

                $USERINFO->UTime = $data['UTime'];

            }

        }


        if (array_key_exists("Education", $data)) {


            if (!empty($data['Education'])) {

                $USERINFO->Education = $data['Education'];

            }

        }


        if (array_key_exists("OffDuty", $data)) {


            if (!empty($data['OffDuty'])) {

                $USERINFO->OffDuty = $data['OffDuty'];

            }

        }


        if (array_key_exists("DelTag", $data)) {


            if (!empty($data['DelTag'])) {

                $USERINFO->DelTag = $data['DelTag'];

            }

        }


        if (array_key_exists("morecard_group_id", $data)) {


            if (!empty($data['morecard_group_id'])) {

                $USERINFO->morecard_group_id = $data['morecard_group_id'];

            }

        }


        if (array_key_exists("set_valid_time", $data)) {


            if (!empty($data['set_valid_time'])) {

                $USERINFO->set_valid_time = $data['set_valid_time'];

            }

        }


        if (array_key_exists("acc_startdate", $data)) {


            if (!empty($data['acc_startdate'])) {

                $USERINFO->acc_startdate = $data['acc_startdate'];

            }

        }


        if (array_key_exists("acc_enddate", $data)) {


            if (!empty($data['acc_enddate'])) {

                $USERINFO->acc_enddate = $data['acc_enddate'];

            }

        }


        if (array_key_exists("birthplace", $data)) {


            if (!empty($data['birthplace'])) {

                $USERINFO->birthplace = $data['birthplace'];

            }

        }


        if (array_key_exists("Political", $data)) {


            if (!empty($data['Political'])) {

                $USERINFO->Political = $data['Political'];

            }

        }


        if (array_key_exists("contry", $data)) {


            if (!empty($data['contry'])) {

                $USERINFO->contry = $data['contry'];

            }

        }


        if (array_key_exists("hiretype", $data)) {


            if (!empty($data['hiretype'])) {

                $USERINFO->hiretype = $data['hiretype'];

            }

        }


        if (array_key_exists("email", $data)) {


            if (!empty($data['email'])) {

                $USERINFO->email = $data['email'];

            }

        }


        if (array_key_exists("firedate", $data)) {


            if (!empty($data['firedate'])) {

                $USERINFO->firedate = $data['firedate'];

            }

        }


        if (array_key_exists("isatt", $data)) {


            if (!empty($data['isatt'])) {

                $USERINFO->isatt = $data['isatt'];

            }

        }


        if (array_key_exists("homeaddress", $data)) {


            if (!empty($data['homeaddress'])) {

                $USERINFO->homeaddress = $data['homeaddress'];

            }

        }


        if (array_key_exists("emptype", $data)) {


            if (!empty($data['emptype'])) {

                $USERINFO->emptype = $data['emptype'];

            }

        }


        if (array_key_exists("bankcode1", $data)) {


            if (!empty($data['bankcode1'])) {

                $USERINFO->bankcode1 = $data['bankcode1'];

            }

        }


        if (array_key_exists("bankcode2", $data)) {


            if (!empty($data['bankcode2'])) {

                $USERINFO->bankcode2 = $data['bankcode2'];

            }

        }


        if (array_key_exists("isblacklist", $data)) {


            if (!empty($data['isblacklist'])) {

                $USERINFO->isblacklist = $data['isblacklist'];

            }

        }


        if (array_key_exists("Iuser1", $data)) {


            if (!empty($data['Iuser1'])) {

                $USERINFO->Iuser1 = $data['Iuser1'];

            }

        }


        if (array_key_exists("Iuser2", $data)) {


            if (!empty($data['Iuser2'])) {

                $USERINFO->Iuser2 = $data['Iuser2'];

            }

        }


        if (array_key_exists("Iuser3", $data)) {


            if (!empty($data['Iuser3'])) {

                $USERINFO->Iuser3 = $data['Iuser3'];

            }

        }


        if (array_key_exists("Iuser4", $data)) {


            if (!empty($data['Iuser4'])) {

                $USERINFO->Iuser4 = $data['Iuser4'];

            }

        }


        if (array_key_exists("Iuser5", $data)) {


            if (!empty($data['Iuser5'])) {

                $USERINFO->Iuser5 = $data['Iuser5'];

            }

        }


        if (array_key_exists("Cuser1", $data)) {


            if (!empty($data['Cuser1'])) {

                $USERINFO->Cuser1 = $data['Cuser1'];

            }

        }


        if (array_key_exists("Cuser2", $data)) {


            if (!empty($data['Cuser2'])) {

                $USERINFO->Cuser2 = $data['Cuser2'];

            }

        }


        if (array_key_exists("Cuser3", $data)) {


            if (!empty($data['Cuser3'])) {

                $USERINFO->Cuser3 = $data['Cuser3'];

            }

        }


        if (array_key_exists("Cuser4", $data)) {


            if (!empty($data['Cuser4'])) {

                $USERINFO->Cuser4 = $data['Cuser4'];

            }

        }


        if (array_key_exists("Cuser5", $data)) {


            if (!empty($data['Cuser5'])) {

                $USERINFO->Cuser5 = $data['Cuser5'];

            }

        }


        if (array_key_exists("Duser1", $data)) {


            if (!empty($data['Duser1'])) {

                $USERINFO->Duser1 = $data['Duser1'];

            }

        }


        if (array_key_exists("Duser2", $data)) {


            if (!empty($data['Duser2'])) {

                $USERINFO->Duser2 = $data['Duser2'];

            }

        }


        if (array_key_exists("Duser3", $data)) {


            if (!empty($data['Duser3'])) {

                $USERINFO->Duser3 = $data['Duser3'];

            }

        }


        if (array_key_exists("Duser4", $data)) {


            if (!empty($data['Duser4'])) {

                $USERINFO->Duser4 = $data['Duser4'];

            }

        }


        if (array_key_exists("Duser5", $data)) {


            if (!empty($data['Duser5'])) {

                $USERINFO->Duser5 = $data['Duser5'];

            }

        }


        if (array_key_exists("reserve", $data)) {


            if (!empty($data['reserve'])) {

                $USERINFO->reserve = $data['reserve'];

            }

        }


        if (array_key_exists("carNo", $data)) {


            if (!empty($data['carNo'])) {

                $USERINFO->carNo = $data['carNo'];

            }

        }


        if (array_key_exists("carType", $data)) {


            if (!empty($data['carType'])) {

                $USERINFO->carType = $data['carType'];

            }

        }


        if (array_key_exists("carBrand", $data)) {


            if (!empty($data['carBrand'])) {

                $USERINFO->carBrand = $data['carBrand'];

            }

        }


        if (array_key_exists("carColor", $data)) {


            if (!empty($data['carColor'])) {

                $USERINFO->carColor = $data['carColor'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $USERINFO->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\USERINFOExtras') &&
            method_exists('\App\Http\Extras\USERINFOExtras', 'beforeSaveUpdate')
        ) {
            USERINFOExtras::beforeSaveUpdate($request, $USERINFO);
        }

        $USERINFO->save();
        $USERINFO = USERINFO::find($USERINFO->id);


        $newCrudData = [];

        $newCrudData['USERID'] = $USERINFO->USERID;
        $newCrudData['Badgenumber'] = $USERINFO->Badgenumber;
        $newCrudData['SSN'] = $USERINFO->SSN;
        $newCrudData['name'] = $USERINFO->name;
        $newCrudData['Gender'] = $USERINFO->Gender;
        $newCrudData['TITLE'] = $USERINFO->TITLE;
        $newCrudData['PAGER'] = $USERINFO->PAGER;
        $newCrudData['BIRTHDAY'] = $USERINFO->BIRTHDAY;
        $newCrudData['HIREDDAY'] = $USERINFO->HIREDDAY;
        $newCrudData['street'] = $USERINFO->street;
        $newCrudData['CITY'] = $USERINFO->CITY;
        $newCrudData['STATE'] = $USERINFO->STATE;
        $newCrudData['ZIP'] = $USERINFO->ZIP;
        $newCrudData['OPHONE'] = $USERINFO->OPHONE;
        $newCrudData['FPHONE'] = $USERINFO->FPHONE;
        $newCrudData['VERIFICATIONMETHOD'] = $USERINFO->VERIFICATIONMETHOD;
        $newCrudData['DEFAULTDEPTID'] = $USERINFO->DEFAULTDEPTID;
        $newCrudData['SECURITYFLAGS'] = $USERINFO->SECURITYFLAGS;
        $newCrudData['ATT'] = $USERINFO->ATT;
        $newCrudData['INLATE'] = $USERINFO->INLATE;
        $newCrudData['OUTEARLY'] = $USERINFO->OUTEARLY;
        $newCrudData['OVERTIME'] = $USERINFO->OVERTIME;
        $newCrudData['SEP'] = $USERINFO->SEP;
        $newCrudData['HOLIDAY'] = $USERINFO->HOLIDAY;
        $newCrudData['MINZU'] = $USERINFO->MINZU;
        $newCrudData['PASSWORD'] = $USERINFO->PASSWORD;
        $newCrudData['LUNCHDURATION'] = $USERINFO->LUNCHDURATION;
        $newCrudData['PHOTO'] = $USERINFO->PHOTO;
        $newCrudData['mverifypass'] = $USERINFO->mverifypass;
        $newCrudData['Notes'] = $USERINFO->Notes;
        $newCrudData['privilege'] = $USERINFO->privilege;
        $newCrudData['InheritDeptSch'] = $USERINFO->InheritDeptSch;
        $newCrudData['InheritDeptSchClass'] = $USERINFO->InheritDeptSchClass;
        $newCrudData['AutoSchPlan'] = $USERINFO->AutoSchPlan;
        $newCrudData['MinAutoSchInterval'] = $USERINFO->MinAutoSchInterval;
        $newCrudData['RegisterOT'] = $USERINFO->RegisterOT;
        $newCrudData['InheritDeptRule'] = $USERINFO->InheritDeptRule;
        $newCrudData['EMPRIVILEGE'] = $USERINFO->EMPRIVILEGE;
        $newCrudData['CardNo'] = $USERINFO->CardNo;
        $newCrudData['change_operator'] = $USERINFO->change_operator;
        $newCrudData['change_time'] = $USERINFO->change_time;
        $newCrudData['create_operator'] = $USERINFO->create_operator;
        $newCrudData['create_time'] = $USERINFO->create_time;
        $newCrudData['delete_operator'] = $USERINFO->delete_operator;
        $newCrudData['delete_time'] = $USERINFO->delete_time;
        $newCrudData['status'] = $USERINFO->status;
        $newCrudData['lastname'] = $USERINFO->lastname;
        $newCrudData['AccGroup'] = $USERINFO->AccGroup;
        $newCrudData['TimeZones'] = $USERINFO->TimeZones;
        $newCrudData['identitycard'] = $USERINFO->identitycard;
        $newCrudData['UTime'] = $USERINFO->UTime;
        $newCrudData['Education'] = $USERINFO->Education;
        $newCrudData['OffDuty'] = $USERINFO->OffDuty;
        $newCrudData['DelTag'] = $USERINFO->DelTag;
        $newCrudData['set_valid_time'] = $USERINFO->set_valid_time;
        $newCrudData['acc_startdate'] = $USERINFO->acc_startdate;
        $newCrudData['acc_enddate'] = $USERINFO->acc_enddate;
        $newCrudData['birthplace'] = $USERINFO->birthplace;
        $newCrudData['Political'] = $USERINFO->Political;
        $newCrudData['contry'] = $USERINFO->contry;
        $newCrudData['hiretype'] = $USERINFO->hiretype;
        $newCrudData['email'] = $USERINFO->email;
        $newCrudData['firedate'] = $USERINFO->firedate;
        $newCrudData['isatt'] = $USERINFO->isatt;
        $newCrudData['homeaddress'] = $USERINFO->homeaddress;
        $newCrudData['emptype'] = $USERINFO->emptype;
        $newCrudData['bankcode1'] = $USERINFO->bankcode1;
        $newCrudData['bankcode2'] = $USERINFO->bankcode2;
        $newCrudData['isblacklist'] = $USERINFO->isblacklist;
        $newCrudData['Iuser1'] = $USERINFO->Iuser1;
        $newCrudData['Iuser2'] = $USERINFO->Iuser2;
        $newCrudData['Iuser3'] = $USERINFO->Iuser3;
        $newCrudData['Iuser4'] = $USERINFO->Iuser4;
        $newCrudData['Iuser5'] = $USERINFO->Iuser5;
        $newCrudData['Cuser1'] = $USERINFO->Cuser1;
        $newCrudData['Cuser2'] = $USERINFO->Cuser2;
        $newCrudData['Cuser3'] = $USERINFO->Cuser3;
        $newCrudData['Cuser4'] = $USERINFO->Cuser4;
        $newCrudData['Cuser5'] = $USERINFO->Cuser5;
        $newCrudData['Duser1'] = $USERINFO->Duser1;
        $newCrudData['Duser2'] = $USERINFO->Duser2;
        $newCrudData['Duser3'] = $USERINFO->Duser3;
        $newCrudData['Duser4'] = $USERINFO->Duser4;
        $newCrudData['Duser5'] = $USERINFO->Duser5;
        $newCrudData['reserve'] = $USERINFO->reserve;
        $newCrudData['carNo'] = $USERINFO->carNo;
        $newCrudData['carType'] = $USERINFO->carType;
        $newCrudData['carBrand'] = $USERINFO->carBrand;
        $newCrudData['carColor'] = $USERINFO->carColor;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'USERINFO', 'entite_cle' => $USERINFO->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $USERINFO->toArray();


        try {

            foreach ($USERINFO->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, USERINFO $USERINFO)
    {


        $newCrudData = [];

        $newCrudData['USERID'] = $USERINFO->USERID;
        $newCrudData['Badgenumber'] = $USERINFO->Badgenumber;
        $newCrudData['SSN'] = $USERINFO->SSN;
        $newCrudData['name'] = $USERINFO->name;
        $newCrudData['Gender'] = $USERINFO->Gender;
        $newCrudData['TITLE'] = $USERINFO->TITLE;
        $newCrudData['PAGER'] = $USERINFO->PAGER;
        $newCrudData['BIRTHDAY'] = $USERINFO->BIRTHDAY;
        $newCrudData['HIREDDAY'] = $USERINFO->HIREDDAY;
        $newCrudData['street'] = $USERINFO->street;
        $newCrudData['CITY'] = $USERINFO->CITY;
        $newCrudData['STATE'] = $USERINFO->STATE;
        $newCrudData['ZIP'] = $USERINFO->ZIP;
        $newCrudData['OPHONE'] = $USERINFO->OPHONE;
        $newCrudData['FPHONE'] = $USERINFO->FPHONE;
        $newCrudData['VERIFICATIONMETHOD'] = $USERINFO->VERIFICATIONMETHOD;
        $newCrudData['DEFAULTDEPTID'] = $USERINFO->DEFAULTDEPTID;
        $newCrudData['SECURITYFLAGS'] = $USERINFO->SECURITYFLAGS;
        $newCrudData['ATT'] = $USERINFO->ATT;
        $newCrudData['INLATE'] = $USERINFO->INLATE;
        $newCrudData['OUTEARLY'] = $USERINFO->OUTEARLY;
        $newCrudData['OVERTIME'] = $USERINFO->OVERTIME;
        $newCrudData['SEP'] = $USERINFO->SEP;
        $newCrudData['HOLIDAY'] = $USERINFO->HOLIDAY;
        $newCrudData['MINZU'] = $USERINFO->MINZU;
        $newCrudData['PASSWORD'] = $USERINFO->PASSWORD;
        $newCrudData['LUNCHDURATION'] = $USERINFO->LUNCHDURATION;
        $newCrudData['PHOTO'] = $USERINFO->PHOTO;
        $newCrudData['mverifypass'] = $USERINFO->mverifypass;
        $newCrudData['Notes'] = $USERINFO->Notes;
        $newCrudData['privilege'] = $USERINFO->privilege;
        $newCrudData['InheritDeptSch'] = $USERINFO->InheritDeptSch;
        $newCrudData['InheritDeptSchClass'] = $USERINFO->InheritDeptSchClass;
        $newCrudData['AutoSchPlan'] = $USERINFO->AutoSchPlan;
        $newCrudData['MinAutoSchInterval'] = $USERINFO->MinAutoSchInterval;
        $newCrudData['RegisterOT'] = $USERINFO->RegisterOT;
        $newCrudData['InheritDeptRule'] = $USERINFO->InheritDeptRule;
        $newCrudData['EMPRIVILEGE'] = $USERINFO->EMPRIVILEGE;
        $newCrudData['CardNo'] = $USERINFO->CardNo;
        $newCrudData['change_operator'] = $USERINFO->change_operator;
        $newCrudData['change_time'] = $USERINFO->change_time;
        $newCrudData['create_operator'] = $USERINFO->create_operator;
        $newCrudData['create_time'] = $USERINFO->create_time;
        $newCrudData['delete_operator'] = $USERINFO->delete_operator;
        $newCrudData['delete_time'] = $USERINFO->delete_time;
        $newCrudData['status'] = $USERINFO->status;
        $newCrudData['lastname'] = $USERINFO->lastname;
        $newCrudData['AccGroup'] = $USERINFO->AccGroup;
        $newCrudData['TimeZones'] = $USERINFO->TimeZones;
        $newCrudData['identitycard'] = $USERINFO->identitycard;
        $newCrudData['UTime'] = $USERINFO->UTime;
        $newCrudData['Education'] = $USERINFO->Education;
        $newCrudData['OffDuty'] = $USERINFO->OffDuty;
        $newCrudData['DelTag'] = $USERINFO->DelTag;
        $newCrudData['set_valid_time'] = $USERINFO->set_valid_time;
        $newCrudData['acc_startdate'] = $USERINFO->acc_startdate;
        $newCrudData['acc_enddate'] = $USERINFO->acc_enddate;
        $newCrudData['birthplace'] = $USERINFO->birthplace;
        $newCrudData['Political'] = $USERINFO->Political;
        $newCrudData['contry'] = $USERINFO->contry;
        $newCrudData['hiretype'] = $USERINFO->hiretype;
        $newCrudData['email'] = $USERINFO->email;
        $newCrudData['firedate'] = $USERINFO->firedate;
        $newCrudData['isatt'] = $USERINFO->isatt;
        $newCrudData['homeaddress'] = $USERINFO->homeaddress;
        $newCrudData['emptype'] = $USERINFO->emptype;
        $newCrudData['bankcode1'] = $USERINFO->bankcode1;
        $newCrudData['bankcode2'] = $USERINFO->bankcode2;
        $newCrudData['isblacklist'] = $USERINFO->isblacklist;
        $newCrudData['Iuser1'] = $USERINFO->Iuser1;
        $newCrudData['Iuser2'] = $USERINFO->Iuser2;
        $newCrudData['Iuser3'] = $USERINFO->Iuser3;
        $newCrudData['Iuser4'] = $USERINFO->Iuser4;
        $newCrudData['Iuser5'] = $USERINFO->Iuser5;
        $newCrudData['Cuser1'] = $USERINFO->Cuser1;
        $newCrudData['Cuser2'] = $USERINFO->Cuser2;
        $newCrudData['Cuser3'] = $USERINFO->Cuser3;
        $newCrudData['Cuser4'] = $USERINFO->Cuser4;
        $newCrudData['Cuser5'] = $USERINFO->Cuser5;
        $newCrudData['Duser1'] = $USERINFO->Duser1;
        $newCrudData['Duser2'] = $USERINFO->Duser2;
        $newCrudData['Duser3'] = $USERINFO->Duser3;
        $newCrudData['Duser4'] = $USERINFO->Duser4;
        $newCrudData['Duser5'] = $USERINFO->Duser5;
        $newCrudData['reserve'] = $USERINFO->reserve;
        $newCrudData['carNo'] = $USERINFO->carNo;
        $newCrudData['carType'] = $USERINFO->carType;
        $newCrudData['carBrand'] = $USERINFO->carBrand;
        $newCrudData['carColor'] = $USERINFO->carColor;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'USERINFO', 'entite_cle' => $USERINFO->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $USERINFO->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new USERINFOActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
