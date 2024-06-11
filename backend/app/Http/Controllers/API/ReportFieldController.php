<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\ReportFieldActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\ReportFieldExtras;
use App\Models\Groupe;
use App\Models\ReportField;
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

// use App\Repository\prod\ReportFieldRepository;


class ReportFieldController extends Controller
{

    private $ReportFieldRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\ReportFieldRepository $ReportFieldRepository
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
        $query = ReportField::query();
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
            class_exists('\App\Http\Extras\ReportFieldExtras') &&
            method_exists('\App\Http\Extras\ReportFieldExtras', 'filterAgGridQuery')
        ) {
            ReportFieldExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('ReportField', $query);
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
            return response()->json(ReportField::count());
        }
        $data = QueryBuilder::for(ReportField::class)
            ->allowedFilters([
                AllowedFilter::exact('CRId'),


                AllowedFilter::exact('TableName'),


                AllowedFilter::exact('FieldName'),


                AllowedFilter::exact('ShowIndex'),


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
                AllowedSort::field('CRId'),


                AllowedSort::field('TableName'),


                AllowedSort::field('FieldName'),


                AllowedSort::field('ShowIndex'),


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


        $data = QueryBuilder::for(ReportField::class)
            ->allowedFilters([
                AllowedFilter::exact('CRId'),


                AllowedFilter::exact('TableName'),


                AllowedFilter::exact('FieldName'),


                AllowedFilter::exact('ShowIndex'),


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
                AllowedSort::field('CRId'),


                AllowedSort::field('TableName'),


                AllowedSort::field('FieldName'),


                AllowedSort::field('ShowIndex'),


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


    public function create(Request $request, ReportField $ReportField)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "ReportField" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'CRId',
            'TableName',
            'FieldName',
            'ShowIndex',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'CRId' => [
                //'required'
            ],


            'TableName' => [
                //'required'
            ],


            'FieldName' => [
                //'required'
            ],


            'ShowIndex' => [
                //'required'
            ],


        ], $messages = [


            'CRId' => ['cette donnee est obligatoire'],


            'TableName' => ['cette donnee est obligatoire'],


            'FieldName' => ['cette donnee est obligatoire'],


            'ShowIndex' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['CRId'])) {

            $ReportField->CRId = $data['CRId'];

        }


        if (!empty($data['TableName'])) {

            $ReportField->TableName = $data['TableName'];

        }


        if (!empty($data['FieldName'])) {

            $ReportField->FieldName = $data['FieldName'];

        }


        if (!empty($data['ShowIndex'])) {

            $ReportField->ShowIndex = $data['ShowIndex'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $ReportField->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\ReportFieldExtras') &&
            method_exists('\App\Http\Extras\ReportFieldExtras', 'beforeSaveCreate')
        ) {
            ReportFieldExtras::beforeSaveCreate($request, $ReportField);
        }


        $ReportField->save();
        $ReportField = ReportField::find($ReportField->id);
        $newCrudData = [];

        $newCrudData['CRId'] = $ReportField->CRId;
        $newCrudData['TableName'] = $ReportField->TableName;
        $newCrudData['FieldName'] = $ReportField->FieldName;
        $newCrudData['ShowIndex'] = $ReportField->ShowIndex;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'ReportField', 'entite_cle' => $ReportField->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $ReportField->toArray();


        try {

            foreach ($ReportField->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, ReportField $ReportField)
    {


        $oldCrudData = [];

        $oldCrudData['CRId'] = $ReportField->CRId;
        $oldCrudData['TableName'] = $ReportField->TableName;
        $oldCrudData['FieldName'] = $ReportField->FieldName;
        $oldCrudData['ShowIndex'] = $ReportField->ShowIndex;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "ReportField" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'CRId',
            'TableName',
            'FieldName',
            'ShowIndex',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'CRId' => [
                //'required'
            ],


            'TableName' => [
                //'required'
            ],


            'FieldName' => [
                //'required'
            ],


            'ShowIndex' => [
                //'required'
            ],


        ], $messages = [


            'CRId' => ['cette donnee est obligatoire'],


            'TableName' => ['cette donnee est obligatoire'],


            'FieldName' => ['cette donnee est obligatoire'],


            'ShowIndex' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("CRId", $data)) {


            if (!empty($data['CRId'])) {

                $ReportField->CRId = $data['CRId'];

            }

        }


        if (array_key_exists("TableName", $data)) {


            if (!empty($data['TableName'])) {

                $ReportField->TableName = $data['TableName'];

            }

        }


        if (array_key_exists("FieldName", $data)) {


            if (!empty($data['FieldName'])) {

                $ReportField->FieldName = $data['FieldName'];

            }

        }


        if (array_key_exists("ShowIndex", $data)) {


            if (!empty($data['ShowIndex'])) {

                $ReportField->ShowIndex = $data['ShowIndex'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $ReportField->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\ReportFieldExtras') &&
            method_exists('\App\Http\Extras\ReportFieldExtras', 'beforeSaveUpdate')
        ) {
            ReportFieldExtras::beforeSaveUpdate($request, $ReportField);
        }

        $ReportField->save();
        $ReportField = ReportField::find($ReportField->id);


        $newCrudData = [];

        $newCrudData['CRId'] = $ReportField->CRId;
        $newCrudData['TableName'] = $ReportField->TableName;
        $newCrudData['FieldName'] = $ReportField->FieldName;
        $newCrudData['ShowIndex'] = $ReportField->ShowIndex;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'ReportField', 'entite_cle' => $ReportField->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $ReportField->toArray();


        try {

            foreach ($ReportField->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, ReportField $ReportField)
    {


        $newCrudData = [];

        $newCrudData['CRId'] = $ReportField->CRId;
        $newCrudData['TableName'] = $ReportField->TableName;
        $newCrudData['FieldName'] = $ReportField->FieldName;
        $newCrudData['ShowIndex'] = $ReportField->ShowIndex;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'ReportField', 'entite_cle' => $ReportField->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $ReportField->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new ReportFieldActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
