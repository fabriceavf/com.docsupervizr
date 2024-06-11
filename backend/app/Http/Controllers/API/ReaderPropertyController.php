<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\ReaderPropertyActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\ReaderPropertyExtras;
use App\Models\Groupe;
use App\Models\ReaderProperty;
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

// use App\Repository\prod\ReaderPropertyRepository;


class ReaderPropertyController extends Controller
{

    private $ReaderPropertyRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\ReaderPropertyRepository $ReaderPropertyRepository
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
        $query = ReaderProperty::query();
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
            class_exists('\App\Http\Extras\ReaderPropertyExtras') &&
            method_exists('\App\Http\Extras\ReaderPropertyExtras', 'filterAgGridQuery')
        ) {
            ReaderPropertyExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('ReaderProperty', $query);
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
            return response()->json(ReaderProperty::count());
        }
        $data = QueryBuilder::for(ReaderProperty::class)
            ->allowedFilters([
                AllowedFilter::exact('ID'),


                AllowedFilter::exact('DevID'),


                AllowedFilter::exact('DoorID'),


                AllowedFilter::exact('Type'),


                AllowedFilter::exact('InOut'),


                AllowedFilter::exact('Address'),


                AllowedFilter::exact('IPAddress'),


                AllowedFilter::exact('Port'),


                AllowedFilter::exact('MAC'),


                AllowedFilter::exact('Disable'),


                AllowedFilter::exact('VerifyType'),


                AllowedFilter::exact('Multicast'),


                AllowedFilter::exact('OfflineRefuse'),


                AllowedFilter::exact('create_operator'),


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
                AllowedSort::field('ID'),


                AllowedSort::field('DevID'),


                AllowedSort::field('DoorID'),


                AllowedSort::field('Type'),


                AllowedSort::field('InOut'),


                AllowedSort::field('Address'),


                AllowedSort::field('IPAddress'),


                AllowedSort::field('Port'),


                AllowedSort::field('MAC'),


                AllowedSort::field('Disable'),


                AllowedSort::field('VerifyType'),


                AllowedSort::field('Multicast'),


                AllowedSort::field('OfflineRefuse'),


                AllowedSort::field('create_operator'),


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


        $data = QueryBuilder::for(ReaderProperty::class)
            ->allowedFilters([
                AllowedFilter::exact('ID'),


                AllowedFilter::exact('DevID'),


                AllowedFilter::exact('DoorID'),


                AllowedFilter::exact('Type'),


                AllowedFilter::exact('InOut'),


                AllowedFilter::exact('Address'),


                AllowedFilter::exact('IPAddress'),


                AllowedFilter::exact('Port'),


                AllowedFilter::exact('MAC'),


                AllowedFilter::exact('Disable'),


                AllowedFilter::exact('VerifyType'),


                AllowedFilter::exact('Multicast'),


                AllowedFilter::exact('OfflineRefuse'),


                AllowedFilter::exact('create_operator'),


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
                AllowedSort::field('ID'),


                AllowedSort::field('DevID'),


                AllowedSort::field('DoorID'),


                AllowedSort::field('Type'),


                AllowedSort::field('InOut'),


                AllowedSort::field('Address'),


                AllowedSort::field('IPAddress'),


                AllowedSort::field('Port'),


                AllowedSort::field('MAC'),


                AllowedSort::field('Disable'),


                AllowedSort::field('VerifyType'),


                AllowedSort::field('Multicast'),


                AllowedSort::field('OfflineRefuse'),


                AllowedSort::field('create_operator'),


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


    public function create(Request $request, ReaderProperty $ReaderProperty)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "ReaderProperty" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'ID',
            'DevID',
            'DoorID',
            'Type',
            'InOut',
            'Address',
            'IPAddress',
            'Port',
            'MAC',
            'Disable',
            'VerifyType',
            'Multicast',
            'OfflineRefuse',
            'create_operator',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'ID' => [
                //'required'
            ],


            'DevID' => [
                //'required'
            ],


            'DoorID' => [
                //'required'
            ],


            'Type' => [
                //'required'
            ],


            'InOut' => [
                //'required'
            ],


            'Address' => [
                //'required'
            ],


            'IPAddress' => [
                //'required'
            ],


            'Port' => [
                //'required'
            ],


            'MAC' => [
                //'required'
            ],


            'Disable' => [
                //'required'
            ],


            'VerifyType' => [
                //'required'
            ],


            'Multicast' => [
                //'required'
            ],


            'OfflineRefuse' => [
                //'required'
            ],


            'create_operator' => [
                //'required'
            ],


        ], $messages = [


            'ID' => ['cette donnee est obligatoire'],


            'DevID' => ['cette donnee est obligatoire'],


            'DoorID' => ['cette donnee est obligatoire'],


            'Type' => ['cette donnee est obligatoire'],


            'InOut' => ['cette donnee est obligatoire'],


            'Address' => ['cette donnee est obligatoire'],


            'IPAddress' => ['cette donnee est obligatoire'],


            'Port' => ['cette donnee est obligatoire'],


            'MAC' => ['cette donnee est obligatoire'],


            'Disable' => ['cette donnee est obligatoire'],


            'VerifyType' => ['cette donnee est obligatoire'],


            'Multicast' => ['cette donnee est obligatoire'],


            'OfflineRefuse' => ['cette donnee est obligatoire'],


            'create_operator' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['ID'])) {

            $ReaderProperty->ID = $data['ID'];

        }


        if (!empty($data['DevID'])) {

            $ReaderProperty->DevID = $data['DevID'];

        }


        if (!empty($data['DoorID'])) {

            $ReaderProperty->DoorID = $data['DoorID'];

        }


        if (!empty($data['Type'])) {

            $ReaderProperty->Type = $data['Type'];

        }


        if (!empty($data['InOut'])) {

            $ReaderProperty->InOut = $data['InOut'];

        }


        if (!empty($data['Address'])) {

            $ReaderProperty->Address = $data['Address'];

        }


        if (!empty($data['IPAddress'])) {

            $ReaderProperty->IPAddress = $data['IPAddress'];

        }


        if (!empty($data['Port'])) {

            $ReaderProperty->Port = $data['Port'];

        }


        if (!empty($data['MAC'])) {

            $ReaderProperty->MAC = $data['MAC'];

        }


        if (!empty($data['Disable'])) {

            $ReaderProperty->Disable = $data['Disable'];

        }


        if (!empty($data['VerifyType'])) {

            $ReaderProperty->VerifyType = $data['VerifyType'];

        }


        if (!empty($data['Multicast'])) {

            $ReaderProperty->Multicast = $data['Multicast'];

        }


        if (!empty($data['OfflineRefuse'])) {

            $ReaderProperty->OfflineRefuse = $data['OfflineRefuse'];

        }


        if (!empty($data['create_operator'])) {

            $ReaderProperty->create_operator = $data['create_operator'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $ReaderProperty->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\ReaderPropertyExtras') &&
            method_exists('\App\Http\Extras\ReaderPropertyExtras', 'beforeSaveCreate')
        ) {
            ReaderPropertyExtras::beforeSaveCreate($request, $ReaderProperty);
        }


        $ReaderProperty->save();
        $ReaderProperty = ReaderProperty::find($ReaderProperty->id);
        $newCrudData = [];

        $newCrudData['ID'] = $ReaderProperty->ID;
        $newCrudData['DevID'] = $ReaderProperty->DevID;
        $newCrudData['DoorID'] = $ReaderProperty->DoorID;
        $newCrudData['Type'] = $ReaderProperty->Type;
        $newCrudData['InOut'] = $ReaderProperty->InOut;
        $newCrudData['Address'] = $ReaderProperty->Address;
        $newCrudData['IPAddress'] = $ReaderProperty->IPAddress;
        $newCrudData['Port'] = $ReaderProperty->Port;
        $newCrudData['MAC'] = $ReaderProperty->MAC;
        $newCrudData['Disable'] = $ReaderProperty->Disable;
        $newCrudData['VerifyType'] = $ReaderProperty->VerifyType;
        $newCrudData['Multicast'] = $ReaderProperty->Multicast;
        $newCrudData['OfflineRefuse'] = $ReaderProperty->OfflineRefuse;
        $newCrudData['create_operator'] = $ReaderProperty->create_operator;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'ReaderProperty', 'entite_cle' => $ReaderProperty->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $ReaderProperty->toArray();


        try {

            foreach ($ReaderProperty->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, ReaderProperty $ReaderProperty)
    {


        $oldCrudData = [];

        $oldCrudData['ID'] = $ReaderProperty->ID;
        $oldCrudData['DevID'] = $ReaderProperty->DevID;
        $oldCrudData['DoorID'] = $ReaderProperty->DoorID;
        $oldCrudData['Type'] = $ReaderProperty->Type;
        $oldCrudData['InOut'] = $ReaderProperty->InOut;
        $oldCrudData['Address'] = $ReaderProperty->Address;
        $oldCrudData['IPAddress'] = $ReaderProperty->IPAddress;
        $oldCrudData['Port'] = $ReaderProperty->Port;
        $oldCrudData['MAC'] = $ReaderProperty->MAC;
        $oldCrudData['Disable'] = $ReaderProperty->Disable;
        $oldCrudData['VerifyType'] = $ReaderProperty->VerifyType;
        $oldCrudData['Multicast'] = $ReaderProperty->Multicast;
        $oldCrudData['OfflineRefuse'] = $ReaderProperty->OfflineRefuse;
        $oldCrudData['create_operator'] = $ReaderProperty->create_operator;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "ReaderProperty" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'ID',
            'DevID',
            'DoorID',
            'Type',
            'InOut',
            'Address',
            'IPAddress',
            'Port',
            'MAC',
            'Disable',
            'VerifyType',
            'Multicast',
            'OfflineRefuse',
            'create_operator',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [

            'ID' => [
                //'required'
            ],


            'DevID' => [
                //'required'
            ],


            'DoorID' => [
                //'required'
            ],


            'Type' => [
                //'required'
            ],


            'InOut' => [
                //'required'
            ],


            'Address' => [
                //'required'
            ],


            'IPAddress' => [
                //'required'
            ],


            'Port' => [
                //'required'
            ],


            'MAC' => [
                //'required'
            ],


            'Disable' => [
                //'required'
            ],


            'VerifyType' => [
                //'required'
            ],


            'Multicast' => [
                //'required'
            ],


            'OfflineRefuse' => [
                //'required'
            ],


            'create_operator' => [
                //'required'
            ],


        ], $messages = [


            'ID' => ['cette donnee est obligatoire'],


            'DevID' => ['cette donnee est obligatoire'],


            'DoorID' => ['cette donnee est obligatoire'],


            'Type' => ['cette donnee est obligatoire'],


            'InOut' => ['cette donnee est obligatoire'],


            'Address' => ['cette donnee est obligatoire'],


            'IPAddress' => ['cette donnee est obligatoire'],


            'Port' => ['cette donnee est obligatoire'],


            'MAC' => ['cette donnee est obligatoire'],


            'Disable' => ['cette donnee est obligatoire'],


            'VerifyType' => ['cette donnee est obligatoire'],


            'Multicast' => ['cette donnee est obligatoire'],


            'OfflineRefuse' => ['cette donnee est obligatoire'],


            'create_operator' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("ID", $data)) {


            if (!empty($data['ID'])) {

                $ReaderProperty->ID = $data['ID'];

            }

        }


        if (array_key_exists("DevID", $data)) {


            if (!empty($data['DevID'])) {

                $ReaderProperty->DevID = $data['DevID'];

            }

        }


        if (array_key_exists("DoorID", $data)) {


            if (!empty($data['DoorID'])) {

                $ReaderProperty->DoorID = $data['DoorID'];

            }

        }


        if (array_key_exists("Type", $data)) {


            if (!empty($data['Type'])) {

                $ReaderProperty->Type = $data['Type'];

            }

        }


        if (array_key_exists("InOut", $data)) {


            if (!empty($data['InOut'])) {

                $ReaderProperty->InOut = $data['InOut'];

            }

        }


        if (array_key_exists("Address", $data)) {


            if (!empty($data['Address'])) {

                $ReaderProperty->Address = $data['Address'];

            }

        }


        if (array_key_exists("IPAddress", $data)) {


            if (!empty($data['IPAddress'])) {

                $ReaderProperty->IPAddress = $data['IPAddress'];

            }

        }


        if (array_key_exists("Port", $data)) {


            if (!empty($data['Port'])) {

                $ReaderProperty->Port = $data['Port'];

            }

        }


        if (array_key_exists("MAC", $data)) {


            if (!empty($data['MAC'])) {

                $ReaderProperty->MAC = $data['MAC'];

            }

        }


        if (array_key_exists("Disable", $data)) {


            if (!empty($data['Disable'])) {

                $ReaderProperty->Disable = $data['Disable'];

            }

        }


        if (array_key_exists("VerifyType", $data)) {


            if (!empty($data['VerifyType'])) {

                $ReaderProperty->VerifyType = $data['VerifyType'];

            }

        }


        if (array_key_exists("Multicast", $data)) {


            if (!empty($data['Multicast'])) {

                $ReaderProperty->Multicast = $data['Multicast'];

            }

        }


        if (array_key_exists("OfflineRefuse", $data)) {


            if (!empty($data['OfflineRefuse'])) {

                $ReaderProperty->OfflineRefuse = $data['OfflineRefuse'];

            }

        }


        if (array_key_exists("create_operator", $data)) {


            if (!empty($data['create_operator'])) {

                $ReaderProperty->create_operator = $data['create_operator'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $ReaderProperty->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\ReaderPropertyExtras') &&
            method_exists('\App\Http\Extras\ReaderPropertyExtras', 'beforeSaveUpdate')
        ) {
            ReaderPropertyExtras::beforeSaveUpdate($request, $ReaderProperty);
        }

        $ReaderProperty->save();
        $ReaderProperty = ReaderProperty::find($ReaderProperty->id);


        $newCrudData = [];

        $newCrudData['ID'] = $ReaderProperty->ID;
        $newCrudData['DevID'] = $ReaderProperty->DevID;
        $newCrudData['DoorID'] = $ReaderProperty->DoorID;
        $newCrudData['Type'] = $ReaderProperty->Type;
        $newCrudData['InOut'] = $ReaderProperty->InOut;
        $newCrudData['Address'] = $ReaderProperty->Address;
        $newCrudData['IPAddress'] = $ReaderProperty->IPAddress;
        $newCrudData['Port'] = $ReaderProperty->Port;
        $newCrudData['MAC'] = $ReaderProperty->MAC;
        $newCrudData['Disable'] = $ReaderProperty->Disable;
        $newCrudData['VerifyType'] = $ReaderProperty->VerifyType;
        $newCrudData['Multicast'] = $ReaderProperty->Multicast;
        $newCrudData['OfflineRefuse'] = $ReaderProperty->OfflineRefuse;
        $newCrudData['create_operator'] = $ReaderProperty->create_operator;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'ReaderProperty', 'entite_cle' => $ReaderProperty->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $ReaderProperty->toArray();


        try {

            foreach ($ReaderProperty->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, ReaderProperty $ReaderProperty)
    {


        $newCrudData = [];

        $newCrudData['ID'] = $ReaderProperty->ID;
        $newCrudData['DevID'] = $ReaderProperty->DevID;
        $newCrudData['DoorID'] = $ReaderProperty->DoorID;
        $newCrudData['Type'] = $ReaderProperty->Type;
        $newCrudData['InOut'] = $ReaderProperty->InOut;
        $newCrudData['Address'] = $ReaderProperty->Address;
        $newCrudData['IPAddress'] = $ReaderProperty->IPAddress;
        $newCrudData['Port'] = $ReaderProperty->Port;
        $newCrudData['MAC'] = $ReaderProperty->MAC;
        $newCrudData['Disable'] = $ReaderProperty->Disable;
        $newCrudData['VerifyType'] = $ReaderProperty->VerifyType;
        $newCrudData['Multicast'] = $ReaderProperty->Multicast;
        $newCrudData['OfflineRefuse'] = $ReaderProperty->OfflineRefuse;
        $newCrudData['create_operator'] = $ReaderProperty->create_operator;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'ReaderProperty', 'entite_cle' => $ReaderProperty->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $ReaderProperty->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new ReaderPropertyActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
