<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\FingerVeinActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\FingerVeinExtras;
use App\Models\FingerVein;
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

// use App\Repository\prod\FingerVeinRepository;


class FingerVeinController extends Controller
{

    private $FingerVeinRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\FingerVeinRepository $FingerVeinRepository
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
        $query = FingerVein::query();
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
            class_exists('\App\Http\Extras\FingerVeinExtras') &&
            method_exists('\App\Http\Extras\FingerVeinExtras', 'filterAgGridQuery')
        ) {
            FingerVeinExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('FingerVein', $query);
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
            return response()->json(FingerVein::count());
        }
        $data = QueryBuilder::for(FingerVein::class)
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


        $data = QueryBuilder::for(FingerVein::class)
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


    public function create(Request $request, FingerVein $FingerVein)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "FingerVein" . "-" . $key . "_" . time() . "." . $file->extension()
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

            $FingerVein->FVID = $data['FVID'];

        }


        if (!empty($data['UserID'])) {

            $FingerVein->UserID = $data['UserID'];

        }


        if (!empty($data['FingerID'])) {

            $FingerVein->FingerID = $data['FingerID'];

        }


        if (!empty($data['Template'])) {

            $FingerVein->Template = $data['Template'];

        }


        if (!empty($data['Size'])) {

            $FingerVein->Size = $data['Size'];

        }


        if (!empty($data['DuressFlag'])) {

            $FingerVein->DuressFlag = $data['DuressFlag'];

        }


        if (!empty($data['UserCode'])) {

            $FingerVein->UserCode = $data['UserCode'];

        }


        if (!empty($data['Fv_ID_Index'])) {

            $FingerVein->Fv_ID_Index = $data['Fv_ID_Index'];

        }


        if (!empty($data['StateMigrationFlag'])) {

            $FingerVein->StateMigrationFlag = $data['StateMigrationFlag'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $FingerVein->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\FingerVeinExtras') &&
            method_exists('\App\Http\Extras\FingerVeinExtras', 'beforeSaveCreate')
        ) {
            FingerVeinExtras::beforeSaveCreate($request, $FingerVein);
        }


        $FingerVein->save();
        $FingerVein = FingerVein::find($FingerVein->id);
        $newCrudData = [];

        $newCrudData['FVID'] = $FingerVein->FVID;
        $newCrudData['UserID'] = $FingerVein->UserID;
        $newCrudData['FingerID'] = $FingerVein->FingerID;
        $newCrudData['Template'] = $FingerVein->Template;
        $newCrudData['Size'] = $FingerVein->Size;
        $newCrudData['DuressFlag'] = $FingerVein->DuressFlag;
        $newCrudData['UserCode'] = $FingerVein->UserCode;
        $newCrudData['Fv_ID_Index'] = $FingerVein->Fv_ID_Index;
        $newCrudData['StateMigrationFlag'] = $FingerVein->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'FingerVein', 'entite_cle' => $FingerVein->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $FingerVein->toArray();


        try {

            foreach ($FingerVein->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, FingerVein $FingerVein)
    {


        $oldCrudData = [];

        $oldCrudData['FVID'] = $FingerVein->FVID;
        $oldCrudData['UserID'] = $FingerVein->UserID;
        $oldCrudData['FingerID'] = $FingerVein->FingerID;
        $oldCrudData['Template'] = $FingerVein->Template;
        $oldCrudData['Size'] = $FingerVein->Size;
        $oldCrudData['DuressFlag'] = $FingerVein->DuressFlag;
        $oldCrudData['UserCode'] = $FingerVein->UserCode;
        $oldCrudData['Fv_ID_Index'] = $FingerVein->Fv_ID_Index;
        $oldCrudData['StateMigrationFlag'] = $FingerVein->StateMigrationFlag;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "FingerVein" . "-" . $key . "_" . time() . "." . $file->extension()
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

                $FingerVein->FVID = $data['FVID'];

            }

        }


        if (array_key_exists("UserID", $data)) {


            if (!empty($data['UserID'])) {

                $FingerVein->UserID = $data['UserID'];

            }

        }


        if (array_key_exists("FingerID", $data)) {


            if (!empty($data['FingerID'])) {

                $FingerVein->FingerID = $data['FingerID'];

            }

        }


        if (array_key_exists("Template", $data)) {


            if (!empty($data['Template'])) {

                $FingerVein->Template = $data['Template'];

            }

        }


        if (array_key_exists("Size", $data)) {


            if (!empty($data['Size'])) {

                $FingerVein->Size = $data['Size'];

            }

        }


        if (array_key_exists("DuressFlag", $data)) {


            if (!empty($data['DuressFlag'])) {

                $FingerVein->DuressFlag = $data['DuressFlag'];

            }

        }


        if (array_key_exists("UserCode", $data)) {


            if (!empty($data['UserCode'])) {

                $FingerVein->UserCode = $data['UserCode'];

            }

        }


        if (array_key_exists("Fv_ID_Index", $data)) {


            if (!empty($data['Fv_ID_Index'])) {

                $FingerVein->Fv_ID_Index = $data['Fv_ID_Index'];

            }

        }


        if (array_key_exists("StateMigrationFlag", $data)) {


            if (!empty($data['StateMigrationFlag'])) {

                $FingerVein->StateMigrationFlag = $data['StateMigrationFlag'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $FingerVein->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\FingerVeinExtras') &&
            method_exists('\App\Http\Extras\FingerVeinExtras', 'beforeSaveUpdate')
        ) {
            FingerVeinExtras::beforeSaveUpdate($request, $FingerVein);
        }

        $FingerVein->save();
        $FingerVein = FingerVein::find($FingerVein->id);


        $newCrudData = [];

        $newCrudData['FVID'] = $FingerVein->FVID;
        $newCrudData['UserID'] = $FingerVein->UserID;
        $newCrudData['FingerID'] = $FingerVein->FingerID;
        $newCrudData['Template'] = $FingerVein->Template;
        $newCrudData['Size'] = $FingerVein->Size;
        $newCrudData['DuressFlag'] = $FingerVein->DuressFlag;
        $newCrudData['UserCode'] = $FingerVein->UserCode;
        $newCrudData['Fv_ID_Index'] = $FingerVein->Fv_ID_Index;
        $newCrudData['StateMigrationFlag'] = $FingerVein->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'FingerVein', 'entite_cle' => $FingerVein->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $FingerVein->toArray();


        try {

            foreach ($FingerVein->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, FingerVein $FingerVein)
    {


        $newCrudData = [];

        $newCrudData['FVID'] = $FingerVein->FVID;
        $newCrudData['UserID'] = $FingerVein->UserID;
        $newCrudData['FingerID'] = $FingerVein->FingerID;
        $newCrudData['Template'] = $FingerVein->Template;
        $newCrudData['Size'] = $FingerVein->Size;
        $newCrudData['DuressFlag'] = $FingerVein->DuressFlag;
        $newCrudData['UserCode'] = $FingerVein->UserCode;
        $newCrudData['Fv_ID_Index'] = $FingerVein->Fv_ID_Index;
        $newCrudData['StateMigrationFlag'] = $FingerVein->StateMigrationFlag;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'FingerVein', 'entite_cle' => $FingerVein->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $FingerVein->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new FingerVeinActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
