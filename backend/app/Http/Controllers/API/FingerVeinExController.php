<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\FingerVeinExActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\FingerVeinExExtras;
use App\Models\FingerVeinEx;
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

// use App\Repository\prod\FingerVeinExRepository;


class FingerVeinExController extends Controller
{

    private $FingerVeinExRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\FingerVeinExRepository $FingerVeinExRepository
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
        $query = FingerVeinEx::query();
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
            class_exists('\App\Http\Extras\FingerVeinExExtras') &&
            method_exists('\App\Http\Extras\FingerVeinExExtras', 'filterAgGridQuery')
        ) {
            FingerVeinExExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('FingerVeinEx', $query);
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
            return response()->json(FingerVeinEx::count());
        }
        $data = QueryBuilder::for(FingerVeinEx::class)
            ->allowedFilters([
                AllowedFilter::exact('FVID'),


                AllowedFilter::exact('UserID'),


                AllowedFilter::exact('FingerID'),


                AllowedFilter::exact('Template'),


                AllowedFilter::exact('Size'),


                AllowedFilter::exact('DuressFlag'),


                AllowedFilter::exact('UserCode'),


                AllowedFilter::exact('Fv_ID_Index'),


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
                AllowedSort::field('FVID'),


                AllowedSort::field('UserID'),


                AllowedSort::field('FingerID'),


                AllowedSort::field('Template'),


                AllowedSort::field('Size'),


                AllowedSort::field('DuressFlag'),


                AllowedSort::field('UserCode'),


                AllowedSort::field('Fv_ID_Index'),


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


        $data = QueryBuilder::for(FingerVeinEx::class)
            ->allowedFilters([
                AllowedFilter::exact('FVID'),


                AllowedFilter::exact('UserID'),


                AllowedFilter::exact('FingerID'),


                AllowedFilter::exact('Template'),


                AllowedFilter::exact('Size'),


                AllowedFilter::exact('DuressFlag'),


                AllowedFilter::exact('UserCode'),


                AllowedFilter::exact('Fv_ID_Index'),


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
                AllowedSort::field('FVID'),


                AllowedSort::field('UserID'),


                AllowedSort::field('FingerID'),


                AllowedSort::field('Template'),


                AllowedSort::field('Size'),


                AllowedSort::field('DuressFlag'),


                AllowedSort::field('UserCode'),


                AllowedSort::field('Fv_ID_Index'),


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


    public function create(Request $request, FingerVeinEx $FingerVeinEx)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "FingerVeinEx" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'FVID',
            'UserID',
            'FingerID',
            'Template',
            'Size',
            'DuressFlag',
            'UserCode',
            'Fv_ID_Index',
            'StateMigrationFlag',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'FVID' => [
                //'required'
            ],


            'UserID' => [
                //'required'
            ],


            'FingerID' => [
                //'required'
            ],


            'Template' => [
                //'required'
            ],


            'Size' => [
                //'required'
            ],


            'DuressFlag' => [
                //'required'
            ],


            'UserCode' => [
                //'required'
            ],


            'Fv_ID_Index' => [
                //'required'
            ],


            'StateMigrationFlag' => [
                //'required'
            ],


        ], $messages = [


            'FVID' => ['cette donnee est obligatoire'],


            'UserID' => ['cette donnee est obligatoire'],


            'FingerID' => ['cette donnee est obligatoire'],


            'Template' => ['cette donnee est obligatoire'],


            'Size' => ['cette donnee est obligatoire'],


            'DuressFlag' => ['cette donnee est obligatoire'],


            'UserCode' => ['cette donnee est obligatoire'],


            'Fv_ID_Index' => ['cette donnee est obligatoire'],


            'StateMigrationFlag' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['FVID'])) {

            $FingerVeinEx->FVID = $data['FVID'];

        }


        if (!empty($data['UserID'])) {

            $FingerVeinEx->UserID = $data['UserID'];

        }


        if (!empty($data['FingerID'])) {

            $FingerVeinEx->FingerID = $data['FingerID'];

        }


        if (!empty($data['Template'])) {

            $FingerVeinEx->Template = $data['Template'];

        }


        if (!empty($data['Size'])) {

            $FingerVeinEx->Size = $data['Size'];

        }


        if (!empty($data['DuressFlag'])) {

            $FingerVeinEx->DuressFlag = $data['DuressFlag'];

        }


        if (!empty($data['UserCode'])) {

            $FingerVeinEx->UserCode = $data['UserCode'];

        }


        if (!empty($data['Fv_ID_Index'])) {

            $FingerVeinEx->Fv_ID_Index = $data['Fv_ID_Index'];

        }


        if (!empty($data['StateMigrationFlag'])) {

            $FingerVeinEx->StateMigrationFlag = $data['StateMigrationFlag'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $FingerVeinEx->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\FingerVeinExExtras') &&
            method_exists('\App\Http\Extras\FingerVeinExExtras', 'beforeSaveCreate')
        ) {
            FingerVeinExExtras::beforeSaveCreate($request, $FingerVeinEx);
        }


        $FingerVeinEx->save();
        $FingerVeinEx = FingerVeinEx::find($FingerVeinEx->id);
        $newCrudData = [];

        $newCrudData['FVID'] = $FingerVeinEx->FVID;
        $newCrudData['UserID'] = $FingerVeinEx->UserID;
        $newCrudData['FingerID'] = $FingerVeinEx->FingerID;
        $newCrudData['Template'] = $FingerVeinEx->Template;
        $newCrudData['Size'] = $FingerVeinEx->Size;
        $newCrudData['DuressFlag'] = $FingerVeinEx->DuressFlag;
        $newCrudData['UserCode'] = $FingerVeinEx->UserCode;
        $newCrudData['Fv_ID_Index'] = $FingerVeinEx->Fv_ID_Index;
        $newCrudData['StateMigrationFlag'] = $FingerVeinEx->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'FingerVeinEx', 'entite_cle' => $FingerVeinEx->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $FingerVeinEx->toArray();


        try {

            foreach ($FingerVeinEx->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, FingerVeinEx $FingerVeinEx)
    {


        $oldCrudData = [];

        $oldCrudData['FVID'] = $FingerVeinEx->FVID;
        $oldCrudData['UserID'] = $FingerVeinEx->UserID;
        $oldCrudData['FingerID'] = $FingerVeinEx->FingerID;
        $oldCrudData['Template'] = $FingerVeinEx->Template;
        $oldCrudData['Size'] = $FingerVeinEx->Size;
        $oldCrudData['DuressFlag'] = $FingerVeinEx->DuressFlag;
        $oldCrudData['UserCode'] = $FingerVeinEx->UserCode;
        $oldCrudData['Fv_ID_Index'] = $FingerVeinEx->Fv_ID_Index;
        $oldCrudData['StateMigrationFlag'] = $FingerVeinEx->StateMigrationFlag;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "FingerVeinEx" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'FVID',
            'UserID',
            'FingerID',
            'Template',
            'Size',
            'DuressFlag',
            'UserCode',
            'Fv_ID_Index',
            'StateMigrationFlag',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'FVID' => [
                //'required'
            ],


            'UserID' => [
                //'required'
            ],


            'FingerID' => [
                //'required'
            ],


            'Template' => [
                //'required'
            ],


            'Size' => [
                //'required'
            ],


            'DuressFlag' => [
                //'required'
            ],


            'UserCode' => [
                //'required'
            ],


            'Fv_ID_Index' => [
                //'required'
            ],


            'StateMigrationFlag' => [
                //'required'
            ],


        ], $messages = [


            'FVID' => ['cette donnee est obligatoire'],


            'UserID' => ['cette donnee est obligatoire'],


            'FingerID' => ['cette donnee est obligatoire'],


            'Template' => ['cette donnee est obligatoire'],


            'Size' => ['cette donnee est obligatoire'],


            'DuressFlag' => ['cette donnee est obligatoire'],


            'UserCode' => ['cette donnee est obligatoire'],


            'Fv_ID_Index' => ['cette donnee est obligatoire'],


            'StateMigrationFlag' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("FVID", $data)) {


            if (!empty($data['FVID'])) {

                $FingerVeinEx->FVID = $data['FVID'];

            }

        }


        if (array_key_exists("UserID", $data)) {


            if (!empty($data['UserID'])) {

                $FingerVeinEx->UserID = $data['UserID'];

            }

        }


        if (array_key_exists("FingerID", $data)) {


            if (!empty($data['FingerID'])) {

                $FingerVeinEx->FingerID = $data['FingerID'];

            }

        }


        if (array_key_exists("Template", $data)) {


            if (!empty($data['Template'])) {

                $FingerVeinEx->Template = $data['Template'];

            }

        }


        if (array_key_exists("Size", $data)) {


            if (!empty($data['Size'])) {

                $FingerVeinEx->Size = $data['Size'];

            }

        }


        if (array_key_exists("DuressFlag", $data)) {


            if (!empty($data['DuressFlag'])) {

                $FingerVeinEx->DuressFlag = $data['DuressFlag'];

            }

        }


        if (array_key_exists("UserCode", $data)) {


            if (!empty($data['UserCode'])) {

                $FingerVeinEx->UserCode = $data['UserCode'];

            }

        }


        if (array_key_exists("Fv_ID_Index", $data)) {


            if (!empty($data['Fv_ID_Index'])) {

                $FingerVeinEx->Fv_ID_Index = $data['Fv_ID_Index'];

            }

        }


        if (array_key_exists("StateMigrationFlag", $data)) {


            if (!empty($data['StateMigrationFlag'])) {

                $FingerVeinEx->StateMigrationFlag = $data['StateMigrationFlag'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $FingerVeinEx->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\FingerVeinExExtras') &&
            method_exists('\App\Http\Extras\FingerVeinExExtras', 'beforeSaveUpdate')
        ) {
            FingerVeinExExtras::beforeSaveUpdate($request, $FingerVeinEx);
        }

        $FingerVeinEx->save();
        $FingerVeinEx = FingerVeinEx::find($FingerVeinEx->id);


        $newCrudData = [];

        $newCrudData['FVID'] = $FingerVeinEx->FVID;
        $newCrudData['UserID'] = $FingerVeinEx->UserID;
        $newCrudData['FingerID'] = $FingerVeinEx->FingerID;
        $newCrudData['Template'] = $FingerVeinEx->Template;
        $newCrudData['Size'] = $FingerVeinEx->Size;
        $newCrudData['DuressFlag'] = $FingerVeinEx->DuressFlag;
        $newCrudData['UserCode'] = $FingerVeinEx->UserCode;
        $newCrudData['Fv_ID_Index'] = $FingerVeinEx->Fv_ID_Index;
        $newCrudData['StateMigrationFlag'] = $FingerVeinEx->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'FingerVeinEx', 'entite_cle' => $FingerVeinEx->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $FingerVeinEx->toArray();


        try {

            foreach ($FingerVeinEx->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, FingerVeinEx $FingerVeinEx)
    {


        $newCrudData = [];

        $newCrudData['FVID'] = $FingerVeinEx->FVID;
        $newCrudData['UserID'] = $FingerVeinEx->UserID;
        $newCrudData['FingerID'] = $FingerVeinEx->FingerID;
        $newCrudData['Template'] = $FingerVeinEx->Template;
        $newCrudData['Size'] = $FingerVeinEx->Size;
        $newCrudData['DuressFlag'] = $FingerVeinEx->DuressFlag;
        $newCrudData['UserCode'] = $FingerVeinEx->UserCode;
        $newCrudData['Fv_ID_Index'] = $FingerVeinEx->Fv_ID_Index;
        $newCrudData['StateMigrationFlag'] = $FingerVeinEx->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'FingerVeinEx', 'entite_cle' => $FingerVeinEx->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $FingerVeinEx->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new FingerVeinExActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
