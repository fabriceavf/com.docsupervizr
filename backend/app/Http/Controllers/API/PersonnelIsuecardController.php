<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\Personnel_issuecardActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\Personnel_isuecardExtras;
use App\Models\Groupe;
use App\Models\PersonnelIsuecard;
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

// use App\Repository\prod\Personnel_issuecardRepository;


class PersonnelIsuecardController extends Controller
{

    private $Personnel_issuecardRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\Personnel_issuecardRepository $Personnel_issuecardRepository
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
        $query = PersonnelIsuecard::query();
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
            class_exists('\App\Http\Extras\Personnel_isuecardExtras') &&
            method_exists('\App\Http\Extras\Personnel_isuecardExtras', 'filterAgGridQuery')
        ) {
            Personnel_isuecardExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('personnel_issuecard', $query);
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
            return response()->json(PersonnelIsuecard::count());
        }
        $data = QueryBuilder::for(PersonnelIsuecard::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('change_operator'),


                AllowedFilter::exact('change_time'),


                AllowedFilter::exact('create_operator'),


                AllowedFilter::exact('create_time'),


                AllowedFilter::exact('delete_operator'),


                AllowedFilter::exact('delete_time'),


                AllowedFilter::exact('status'),


                AllowedFilter::exact('UserID_id'),


                AllowedFilter::exact('cardno'),


                AllowedFilter::exact('effectivenessdate'),


                AllowedFilter::exact('isvalid'),


                AllowedFilter::exact('cardpwd'),


                AllowedFilter::exact('failuredate'),


                AllowedFilter::exact('cardstatus'),


                AllowedFilter::exact('issuedate'),


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


                AllowedSort::field('UserID_id'),


                AllowedSort::field('cardno'),


                AllowedSort::field('effectivenessdate'),


                AllowedSort::field('isvalid'),


                AllowedSort::field('cardpwd'),


                AllowedSort::field('failuredate'),


                AllowedSort::field('cardstatus'),


                AllowedSort::field('issuedate'),


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


        $data = QueryBuilder::for(PersonnelIsuecard::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('change_operator'),


                AllowedFilter::exact('change_time'),


                AllowedFilter::exact('create_operator'),


                AllowedFilter::exact('create_time'),


                AllowedFilter::exact('delete_operator'),


                AllowedFilter::exact('delete_time'),


                AllowedFilter::exact('status'),


                AllowedFilter::exact('UserID_id'),


                AllowedFilter::exact('cardno'),


                AllowedFilter::exact('effectivenessdate'),


                AllowedFilter::exact('isvalid'),


                AllowedFilter::exact('cardpwd'),


                AllowedFilter::exact('failuredate'),


                AllowedFilter::exact('cardstatus'),


                AllowedFilter::exact('issuedate'),


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


                AllowedSort::field('UserID_id'),


                AllowedSort::field('cardno'),


                AllowedSort::field('effectivenessdate'),


                AllowedSort::field('isvalid'),


                AllowedSort::field('cardpwd'),


                AllowedSort::field('failuredate'),


                AllowedSort::field('cardstatus'),


                AllowedSort::field('issuedate'),


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


    public function create(Request $request, PersonnelIsuecard $Personnel_issuecard)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "personnel_issuecard" . "-" . $key . "_" . time() . "." . $file->extension()
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
            'UserID_id',
            'cardno',
            'effectivenessdate',
            'isvalid',
            'cardpwd',
            'failuredate',
            'cardstatus',
            'issuedate',
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


            'UserID_id' => [
                //'required'
            ],


            'cardno' => [
                //'required'
            ],


            'effectivenessdate' => [
                //'required'
            ],


            'isvalid' => [
                //'required'
            ],


            'cardpwd' => [
                //'required'
            ],


            'failuredate' => [
                //'required'
            ],


            'cardstatus' => [
                //'required'
            ],


            'issuedate' => [
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


            'UserID_id' => ['cette donnee est obligatoire'],


            'cardno' => ['cette donnee est obligatoire'],


            'effectivenessdate' => ['cette donnee est obligatoire'],


            'isvalid' => ['cette donnee est obligatoire'],


            'cardpwd' => ['cette donnee est obligatoire'],


            'failuredate' => ['cette donnee est obligatoire'],


            'cardstatus' => ['cette donnee est obligatoire'],


            'issuedate' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['change_operator'])) {

            $Personnel_issuecard->change_operator = $data['change_operator'];

        }


        if (!empty($data['change_time'])) {

            $Personnel_issuecard->change_time = $data['change_time'];

        }


        if (!empty($data['create_operator'])) {

            $Personnel_issuecard->create_operator = $data['create_operator'];

        }


        if (!empty($data['create_time'])) {

            $Personnel_issuecard->create_time = $data['create_time'];

        }


        if (!empty($data['delete_operator'])) {

            $Personnel_issuecard->delete_operator = $data['delete_operator'];

        }


        if (!empty($data['delete_time'])) {

            $Personnel_issuecard->delete_time = $data['delete_time'];

        }


        if (!empty($data['status'])) {

            $Personnel_issuecard->status = $data['status'];

        }


        if (!empty($data['UserID_id'])) {

            $Personnel_issuecard->UserID_id = $data['UserID_id'];

        }


        if (!empty($data['cardno'])) {

            $Personnel_issuecard->cardno = $data['cardno'];

        }


        if (!empty($data['effectivenessdate'])) {

            $Personnel_issuecard->effectivenessdate = $data['effectivenessdate'];

        }


        if (!empty($data['isvalid'])) {

            $Personnel_issuecard->isvalid = $data['isvalid'];

        }


        if (!empty($data['cardpwd'])) {

            $Personnel_issuecard->cardpwd = $data['cardpwd'];

        }


        if (!empty($data['failuredate'])) {

            $Personnel_issuecard->failuredate = $data['failuredate'];

        }


        if (!empty($data['cardstatus'])) {

            $Personnel_issuecard->cardstatus = $data['cardstatus'];

        }


        if (!empty($data['issuedate'])) {

            $Personnel_issuecard->issuedate = $data['issuedate'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Personnel_issuecard->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\Personnel_isuecardExtras') &&
            method_exists('\App\Http\Extras\Personnel_isuecardExtras', 'beforeSaveCreate')
        ) {
            Personnel_isuecardExtras::beforeSaveCreate($request, $Personnel_issuecard);
        }


        $Personnel_issuecard->save();
        $Personnel_issuecard = PersonnelIsuecard::find($Personnel_issuecard->id);
        $newCrudData = [];

        $newCrudData['change_operator'] = $Personnel_issuecard->change_operator;
        $newCrudData['change_time'] = $Personnel_issuecard->change_time;
        $newCrudData['create_operator'] = $Personnel_issuecard->create_operator;
        $newCrudData['create_time'] = $Personnel_issuecard->create_time;
        $newCrudData['delete_operator'] = $Personnel_issuecard->delete_operator;
        $newCrudData['delete_time'] = $Personnel_issuecard->delete_time;
        $newCrudData['status'] = $Personnel_issuecard->status;
        $newCrudData['cardno'] = $Personnel_issuecard->cardno;
        $newCrudData['effectivenessdate'] = $Personnel_issuecard->effectivenessdate;
        $newCrudData['isvalid'] = $Personnel_issuecard->isvalid;
        $newCrudData['cardpwd'] = $Personnel_issuecard->cardpwd;
        $newCrudData['failuredate'] = $Personnel_issuecard->failuredate;
        $newCrudData['cardstatus'] = $Personnel_issuecard->cardstatus;
        $newCrudData['issuedate'] = $Personnel_issuecard->issuedate;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Personnel_issuecard', 'entite_cle' => $Personnel_issuecard->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Personnel_issuecard->toArray();


        try {

            foreach ($Personnel_issuecard->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, PersonnelIsuecard $Personnel_issuecard)
    {


        $oldCrudData = [];

        $oldCrudData['change_operator'] = $Personnel_issuecard->change_operator;
        $oldCrudData['change_time'] = $Personnel_issuecard->change_time;
        $oldCrudData['create_operator'] = $Personnel_issuecard->create_operator;
        $oldCrudData['create_time'] = $Personnel_issuecard->create_time;
        $oldCrudData['delete_operator'] = $Personnel_issuecard->delete_operator;
        $oldCrudData['delete_time'] = $Personnel_issuecard->delete_time;
        $oldCrudData['status'] = $Personnel_issuecard->status;
        $oldCrudData['cardno'] = $Personnel_issuecard->cardno;
        $oldCrudData['effectivenessdate'] = $Personnel_issuecard->effectivenessdate;
        $oldCrudData['isvalid'] = $Personnel_issuecard->isvalid;
        $oldCrudData['cardpwd'] = $Personnel_issuecard->cardpwd;
        $oldCrudData['failuredate'] = $Personnel_issuecard->failuredate;
        $oldCrudData['cardstatus'] = $Personnel_issuecard->cardstatus;
        $oldCrudData['issuedate'] = $Personnel_issuecard->issuedate;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "personnel_issuecard" . "-" . $key . "_" . time() . "." . $file->extension()
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
            'UserID_id',
            'cardno',
            'effectivenessdate',
            'isvalid',
            'cardpwd',
            'failuredate',
            'cardstatus',
            'issuedate',
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


            'UserID_id' => [
                //'required'
            ],


            'cardno' => [
                //'required'
            ],


            'effectivenessdate' => [
                //'required'
            ],


            'isvalid' => [
                //'required'
            ],


            'cardpwd' => [
                //'required'
            ],


            'failuredate' => [
                //'required'
            ],


            'cardstatus' => [
                //'required'
            ],


            'issuedate' => [
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


            'UserID_id' => ['cette donnee est obligatoire'],


            'cardno' => ['cette donnee est obligatoire'],


            'effectivenessdate' => ['cette donnee est obligatoire'],


            'isvalid' => ['cette donnee est obligatoire'],


            'cardpwd' => ['cette donnee est obligatoire'],


            'failuredate' => ['cette donnee est obligatoire'],


            'cardstatus' => ['cette donnee est obligatoire'],


            'issuedate' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("change_operator", $data)) {


            if (!empty($data['change_operator'])) {

                $Personnel_issuecard->change_operator = $data['change_operator'];

            }

        }


        if (array_key_exists("change_time", $data)) {


            if (!empty($data['change_time'])) {

                $Personnel_issuecard->change_time = $data['change_time'];

            }

        }


        if (array_key_exists("create_operator", $data)) {


            if (!empty($data['create_operator'])) {

                $Personnel_issuecard->create_operator = $data['create_operator'];

            }

        }


        if (array_key_exists("create_time", $data)) {


            if (!empty($data['create_time'])) {

                $Personnel_issuecard->create_time = $data['create_time'];

            }

        }


        if (array_key_exists("delete_operator", $data)) {


            if (!empty($data['delete_operator'])) {

                $Personnel_issuecard->delete_operator = $data['delete_operator'];

            }

        }


        if (array_key_exists("delete_time", $data)) {


            if (!empty($data['delete_time'])) {

                $Personnel_issuecard->delete_time = $data['delete_time'];

            }

        }


        if (array_key_exists("status", $data)) {


            if (!empty($data['status'])) {

                $Personnel_issuecard->status = $data['status'];

            }

        }


        if (array_key_exists("UserID_id", $data)) {


            if (!empty($data['UserID_id'])) {

                $Personnel_issuecard->UserID_id = $data['UserID_id'];

            }

        }


        if (array_key_exists("cardno", $data)) {


            if (!empty($data['cardno'])) {

                $Personnel_issuecard->cardno = $data['cardno'];

            }

        }


        if (array_key_exists("effectivenessdate", $data)) {


            if (!empty($data['effectivenessdate'])) {

                $Personnel_issuecard->effectivenessdate = $data['effectivenessdate'];

            }

        }


        if (array_key_exists("isvalid", $data)) {


            if (!empty($data['isvalid'])) {

                $Personnel_issuecard->isvalid = $data['isvalid'];

            }

        }


        if (array_key_exists("cardpwd", $data)) {


            if (!empty($data['cardpwd'])) {

                $Personnel_issuecard->cardpwd = $data['cardpwd'];

            }

        }


        if (array_key_exists("failuredate", $data)) {


            if (!empty($data['failuredate'])) {

                $Personnel_issuecard->failuredate = $data['failuredate'];

            }

        }


        if (array_key_exists("cardstatus", $data)) {


            if (!empty($data['cardstatus'])) {

                $Personnel_issuecard->cardstatus = $data['cardstatus'];

            }

        }


        if (array_key_exists("issuedate", $data)) {


            if (!empty($data['issuedate'])) {

                $Personnel_issuecard->issuedate = $data['issuedate'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Personnel_issuecard->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\Personnel_isuecardExtras') &&
            method_exists('\App\Http\Extras\Personnel_isuecardExtras', 'beforeSaveUpdate')
        ) {
            Personnel_isuecardExtras::beforeSaveUpdate($request, $Personnel_issuecard);
        }

        $Personnel_issuecard->save();
        $Personnel_issuecard = PersonnelIsuecard::find($Personnel_issuecard->id);


        $newCrudData = [];

        $newCrudData['change_operator'] = $Personnel_issuecard->change_operator;
        $newCrudData['change_time'] = $Personnel_issuecard->change_time;
        $newCrudData['create_operator'] = $Personnel_issuecard->create_operator;
        $newCrudData['create_time'] = $Personnel_issuecard->create_time;
        $newCrudData['delete_operator'] = $Personnel_issuecard->delete_operator;
        $newCrudData['delete_time'] = $Personnel_issuecard->delete_time;
        $newCrudData['status'] = $Personnel_issuecard->status;
        $newCrudData['cardno'] = $Personnel_issuecard->cardno;
        $newCrudData['effectivenessdate'] = $Personnel_issuecard->effectivenessdate;
        $newCrudData['isvalid'] = $Personnel_issuecard->isvalid;
        $newCrudData['cardpwd'] = $Personnel_issuecard->cardpwd;
        $newCrudData['failuredate'] = $Personnel_issuecard->failuredate;
        $newCrudData['cardstatus'] = $Personnel_issuecard->cardstatus;
        $newCrudData['issuedate'] = $Personnel_issuecard->issuedate;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Personnel_issuecard', 'entite_cle' => $Personnel_issuecard->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Personnel_issuecard->toArray();


        try {

            foreach ($Personnel_issuecard->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, PersonnelIsuecard $Personnel_issuecard)
    {


        $newCrudData = [];

        $newCrudData['change_operator'] = $Personnel_issuecard->change_operator;
        $newCrudData['change_time'] = $Personnel_issuecard->change_time;
        $newCrudData['create_operator'] = $Personnel_issuecard->create_operator;
        $newCrudData['create_time'] = $Personnel_issuecard->create_time;
        $newCrudData['delete_operator'] = $Personnel_issuecard->delete_operator;
        $newCrudData['delete_time'] = $Personnel_issuecard->delete_time;
        $newCrudData['status'] = $Personnel_issuecard->status;
        $newCrudData['cardno'] = $Personnel_issuecard->cardno;
        $newCrudData['effectivenessdate'] = $Personnel_issuecard->effectivenessdate;
        $newCrudData['isvalid'] = $Personnel_issuecard->isvalid;
        $newCrudData['cardpwd'] = $Personnel_issuecard->cardpwd;
        $newCrudData['failuredate'] = $Personnel_issuecard->failuredate;
        $newCrudData['cardstatus'] = $Personnel_issuecard->cardstatus;
        $newCrudData['issuedate'] = $Personnel_issuecard->issuedate;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Personnel_issuecard', 'entite_cle' => $Personnel_issuecard->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $Personnel_issuecard->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new Personnel_issuecardActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
