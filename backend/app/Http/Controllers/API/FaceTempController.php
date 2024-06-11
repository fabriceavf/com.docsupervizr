<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\FaceTempActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\FaceTempExtras;
use App\Models\FaceTemp;
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

// use App\Repository\prod\FaceTempRepository;


class FaceTempController extends Controller
{

    private $FaceTempRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\FaceTempRepository $FaceTempRepository
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
        $query = FaceTemp::query();
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
            class_exists('\App\Http\Extras\FaceTempExtras') &&
            method_exists('\App\Http\Extras\FaceTempExtras', 'filterAgGridQuery')
        ) {
            FaceTempExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('FaceTemp', $query);
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
            return response()->json(FaceTemp::count());
        }
        $data = QueryBuilder::for(FaceTemp::class)
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


        $data = QueryBuilder::for(FaceTemp::class)
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


    public function create(Request $request, FaceTemp $FaceTemp)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "FaceTemp" . "-" . $key . "_" . time() . "." . $file->extension()
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

            $FaceTemp->TEMPLATEID = $data['TEMPLATEID'];

        }


        if (!empty($data['USERNO'])) {

            $FaceTemp->USERNO = $data['USERNO'];

        }


        if (!empty($data['SIZE'])) {

            $FaceTemp->SIZE = $data['SIZE'];

        }


        if (!empty($data['pin'])) {

            $FaceTemp->pin = $data['pin'];

        }


        if (!empty($data['FACEID'])) {

            $FaceTemp->FACEID = $data['FACEID'];

        }


        if (!empty($data['VALID'])) {

            $FaceTemp->VALID = $data['VALID'];

        }


        if (!empty($data['RESERVE'])) {

            $FaceTemp->RESERVE = $data['RESERVE'];

        }


        if (!empty($data['ACTIVETIME'])) {

            $FaceTemp->ACTIVETIME = $data['ACTIVETIME'];

        }


        if (!empty($data['VFCOUNT'])) {

            $FaceTemp->VFCOUNT = $data['VFCOUNT'];

        }


        if (!empty($data['TEMPLATE'])) {

            $FaceTemp->TEMPLATE = $data['TEMPLATE'];

        }


        if (!empty($data['FaceType'])) {

            $FaceTemp->FaceType = $data['FaceType'];

        }


        if (!empty($data['StateMigrationFlag'])) {

            $FaceTemp->StateMigrationFlag = $data['StateMigrationFlag'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $FaceTemp->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\FaceTempExtras') &&
            method_exists('\App\Http\Extras\FaceTempExtras', 'beforeSaveCreate')
        ) {
            FaceTempExtras::beforeSaveCreate($request, $FaceTemp);
        }


        $FaceTemp->save();
        $FaceTemp = FaceTemp::find($FaceTemp->id);
        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $FaceTemp->TEMPLATEID;
        $newCrudData['USERNO'] = $FaceTemp->USERNO;
        $newCrudData['SIZE'] = $FaceTemp->SIZE;
        $newCrudData['pin'] = $FaceTemp->pin;
        $newCrudData['FACEID'] = $FaceTemp->FACEID;
        $newCrudData['VALID'] = $FaceTemp->VALID;
        $newCrudData['RESERVE'] = $FaceTemp->RESERVE;
        $newCrudData['ACTIVETIME'] = $FaceTemp->ACTIVETIME;
        $newCrudData['VFCOUNT'] = $FaceTemp->VFCOUNT;
        $newCrudData['TEMPLATE'] = $FaceTemp->TEMPLATE;
        $newCrudData['FaceType'] = $FaceTemp->FaceType;
        $newCrudData['StateMigrationFlag'] = $FaceTemp->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'FaceTemp', 'entite_cle' => $FaceTemp->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $FaceTemp->toArray();


        try {

            foreach ($FaceTemp->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, FaceTemp $FaceTemp)
    {


        $oldCrudData = [];

        $oldCrudData['TEMPLATEID'] = $FaceTemp->TEMPLATEID;
        $oldCrudData['USERNO'] = $FaceTemp->USERNO;
        $oldCrudData['SIZE'] = $FaceTemp->SIZE;
        $oldCrudData['pin'] = $FaceTemp->pin;
        $oldCrudData['FACEID'] = $FaceTemp->FACEID;
        $oldCrudData['VALID'] = $FaceTemp->VALID;
        $oldCrudData['RESERVE'] = $FaceTemp->RESERVE;
        $oldCrudData['ACTIVETIME'] = $FaceTemp->ACTIVETIME;
        $oldCrudData['VFCOUNT'] = $FaceTemp->VFCOUNT;
        $oldCrudData['TEMPLATE'] = $FaceTemp->TEMPLATE;
        $oldCrudData['FaceType'] = $FaceTemp->FaceType;
        $oldCrudData['StateMigrationFlag'] = $FaceTemp->StateMigrationFlag;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "FaceTemp" . "-" . $key . "_" . time() . "." . $file->extension()
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

                $FaceTemp->TEMPLATEID = $data['TEMPLATEID'];

            }

        }


        if (array_key_exists("USERNO", $data)) {


            if (!empty($data['USERNO'])) {

                $FaceTemp->USERNO = $data['USERNO'];

            }

        }


        if (array_key_exists("SIZE", $data)) {


            if (!empty($data['SIZE'])) {

                $FaceTemp->SIZE = $data['SIZE'];

            }

        }


        if (array_key_exists("pin", $data)) {


            if (!empty($data['pin'])) {

                $FaceTemp->pin = $data['pin'];

            }

        }


        if (array_key_exists("FACEID", $data)) {


            if (!empty($data['FACEID'])) {

                $FaceTemp->FACEID = $data['FACEID'];

            }

        }


        if (array_key_exists("VALID", $data)) {


            if (!empty($data['VALID'])) {

                $FaceTemp->VALID = $data['VALID'];

            }

        }


        if (array_key_exists("RESERVE", $data)) {


            if (!empty($data['RESERVE'])) {

                $FaceTemp->RESERVE = $data['RESERVE'];

            }

        }


        if (array_key_exists("ACTIVETIME", $data)) {


            if (!empty($data['ACTIVETIME'])) {

                $FaceTemp->ACTIVETIME = $data['ACTIVETIME'];

            }

        }


        if (array_key_exists("VFCOUNT", $data)) {


            if (!empty($data['VFCOUNT'])) {

                $FaceTemp->VFCOUNT = $data['VFCOUNT'];

            }

        }


        if (array_key_exists("TEMPLATE", $data)) {


            if (!empty($data['TEMPLATE'])) {

                $FaceTemp->TEMPLATE = $data['TEMPLATE'];

            }

        }


        if (array_key_exists("FaceType", $data)) {


            if (!empty($data['FaceType'])) {

                $FaceTemp->FaceType = $data['FaceType'];

            }

        }


        if (array_key_exists("StateMigrationFlag", $data)) {


            if (!empty($data['StateMigrationFlag'])) {

                $FaceTemp->StateMigrationFlag = $data['StateMigrationFlag'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $FaceTemp->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\FaceTempExtras') &&
            method_exists('\App\Http\Extras\FaceTempExtras', 'beforeSaveUpdate')
        ) {
            FaceTempExtras::beforeSaveUpdate($request, $FaceTemp);
        }

        $FaceTemp->save();
        $FaceTemp = FaceTemp::find($FaceTemp->id);


        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $FaceTemp->TEMPLATEID;
        $newCrudData['USERNO'] = $FaceTemp->USERNO;
        $newCrudData['SIZE'] = $FaceTemp->SIZE;
        $newCrudData['pin'] = $FaceTemp->pin;
        $newCrudData['FACEID'] = $FaceTemp->FACEID;
        $newCrudData['VALID'] = $FaceTemp->VALID;
        $newCrudData['RESERVE'] = $FaceTemp->RESERVE;
        $newCrudData['ACTIVETIME'] = $FaceTemp->ACTIVETIME;
        $newCrudData['VFCOUNT'] = $FaceTemp->VFCOUNT;
        $newCrudData['TEMPLATE'] = $FaceTemp->TEMPLATE;
        $newCrudData['FaceType'] = $FaceTemp->FaceType;
        $newCrudData['StateMigrationFlag'] = $FaceTemp->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'FaceTemp', 'entite_cle' => $FaceTemp->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $FaceTemp->toArray();


        try {

            foreach ($FaceTemp->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, FaceTemp $FaceTemp)
    {


        $newCrudData = [];

        $newCrudData['TEMPLATEID'] = $FaceTemp->TEMPLATEID;
        $newCrudData['USERNO'] = $FaceTemp->USERNO;
        $newCrudData['SIZE'] = $FaceTemp->SIZE;
        $newCrudData['pin'] = $FaceTemp->pin;
        $newCrudData['FACEID'] = $FaceTemp->FACEID;
        $newCrudData['VALID'] = $FaceTemp->VALID;
        $newCrudData['RESERVE'] = $FaceTemp->RESERVE;
        $newCrudData['ACTIVETIME'] = $FaceTemp->ACTIVETIME;
        $newCrudData['VFCOUNT'] = $FaceTemp->VFCOUNT;
        $newCrudData['TEMPLATE'] = $FaceTemp->TEMPLATE;
        $newCrudData['FaceType'] = $FaceTemp->FaceType;
        $newCrudData['StateMigrationFlag'] = $FaceTemp->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'FaceTemp', 'entite_cle' => $FaceTemp->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $FaceTemp->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new FaceTempActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
