<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Actions\Auth_userActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\Auth_uerExtras;
use App\Models\AuthUer;
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

// use App\Repository\prod\Auth_userRepository;


class AuthUerController extends Controller
{

    private $Auth_userRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\Auth_userRepository $Auth_userRepository
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
        $query = AuthUer::query();
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
            class_exists('\App\Http\Extras\Auth_uerExtras') &&
            method_exists('\App\Http\Extras\Auth_uerExtras', 'filterAgGridQuery')
        ) {
            Auth_uerExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('auth_user', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\Auth_uerExtras') &&
            method_exists('\App\Http\Extras\Auth_uerExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = Auth_uerExtras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
            $data['rowData'] = $_d;

            if ($_d->count() > $data['rowCount']) {
                $data['rowCount'] = $_d->count();
            }
        }

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
            return response()->json(AuthUer::count());
        }
        $data = QueryBuilder::for(AuthUer::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('username'),


                AllowedFilter::exact('password'),


                AllowedFilter::exact('Status'),


                AllowedFilter::exact('last_login'),


                AllowedFilter::exact('RoleID'),


                AllowedFilter::exact('Remark'),


                AllowedFilter::exact('identifiants_sadge'),


                AllowedFilter::exact('creat_by'),


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


                AllowedSort::field('username'),


                AllowedSort::field('password'),


                AllowedSort::field('Status'),


                AllowedSort::field('last_login'),


                AllowedSort::field('RoleID'),


                AllowedSort::field('Remark'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


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


        $data = QueryBuilder::for(AuthUer::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('username'),


                AllowedFilter::exact('password'),


                AllowedFilter::exact('Status'),


                AllowedFilter::exact('last_login'),


                AllowedFilter::exact('RoleID'),


                AllowedFilter::exact('Remark'),


                AllowedFilter::exact('identifiants_sadge'),


                AllowedFilter::exact('creat_by'),


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


                AllowedSort::field('username'),


                AllowedSort::field('password'),


                AllowedSort::field('Status'),


                AllowedSort::field('last_login'),


                AllowedSort::field('RoleID'),


                AllowedSort::field('Remark'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


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


    public function create(Request $request, AuthUer $Auth_user)
    {


        try {
            $can = Helpers::can('Creer des auth_user');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "auth_user" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'username',
            'password',
            'Status',
            'last_login',
            'RoleID',
            'Remark',
            'extra_attributes',
            'deleted_at',
            'identifiants_sadge',
            'creat_by',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'username' => [
                //'required'
            ],


            'password' => [
                //'required'
            ],


            'Status' => [
                //'required'
            ],


            'last_login' => [
                //'required'
            ],


            'RoleID' => [
                //'required'
            ],


            'Remark' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'username' => ['cette donnee est obligatoire'],


            'password' => ['cette donnee est obligatoire'],


            'Status' => ['cette donnee est obligatoire'],


            'last_login' => ['cette donnee est obligatoire'],


            'RoleID' => ['cette donnee est obligatoire'],


            'Remark' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['username'])) {

            $Auth_user->username = $data['username'];

        }


        if (!empty($data['password'])) {

            $Auth_user->password = $data['password'];

        }


        if (!empty($data['Status'])) {

            $Auth_user->Status = $data['Status'];

        }


        if (!empty($data['last_login'])) {

            $Auth_user->last_login = $data['last_login'];

        }


        if (!empty($data['RoleID'])) {

            $Auth_user->RoleID = $data['RoleID'];

        }


        if (!empty($data['Remark'])) {

            $Auth_user->Remark = $data['Remark'];

        }


        if (!empty($data['identifiants_sadge'])) {

            $Auth_user->identifiants_sadge = $data['identifiants_sadge'];

        }


        if (!empty($data['creat_by'])) {

            $Auth_user->creat_by = $data['creat_by'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Auth_user->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\Auth_uerExtras') &&
            method_exists('\App\Http\Extras\Auth_uerExtras', 'beforeSaveCreate')
        ) {
            Auth_uerExtras::beforeSaveCreate($request, $Auth_user);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Auth_uerExtras') &&
            method_exists('\App\Http\Extras\Auth_uerExtras', 'canCreate')
        ) {
            try {
                $canSave = Auth_uerExtras::canCreate($request, $Auth_user);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Auth_user->save();
        } else {
            return response()->json($Auth_user, 200);
        }

        $Auth_user = AuthUer::find($Auth_user->id);
        $newCrudData = [];

        $newCrudData['username'] = $Auth_user->username;
        $newCrudData['password'] = $Auth_user->password;
        $newCrudData['Status'] = $Auth_user->Status;
        $newCrudData['last_login'] = $Auth_user->last_login;
        $newCrudData['RoleID'] = $Auth_user->RoleID;
        $newCrudData['Remark'] = $Auth_user->Remark;
        $newCrudData['identifiants_sadge'] = $Auth_user->identifiants_sadge;
        $newCrudData['creat_by'] = $Auth_user->creat_by;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Auth_user', 'entite_cle' => $Auth_user->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Auth_user->toArray();


        try {

            foreach ($Auth_user->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, AuthUer $Auth_user)
    {
        try {
            $can = Helpers::can('Editer des auth_user');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['username'] = $Auth_user->username;
        $oldCrudData['password'] = $Auth_user->password;
        $oldCrudData['Status'] = $Auth_user->Status;
        $oldCrudData['last_login'] = $Auth_user->last_login;
        $oldCrudData['RoleID'] = $Auth_user->RoleID;
        $oldCrudData['Remark'] = $Auth_user->Remark;
        $oldCrudData['identifiants_sadge'] = $Auth_user->identifiants_sadge;
        $oldCrudData['creat_by'] = $Auth_user->creat_by;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "auth_user" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'username',
            'password',
            'Status',
            'last_login',
            'RoleID',
            'Remark',
            'extra_attributes',
            'deleted_at',
            'identifiants_sadge',
            'creat_by',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'username' => [
                //'required'
            ],


            'password' => [
                //'required'
            ],


            'Status' => [
                //'required'
            ],


            'last_login' => [
                //'required'
            ],


            'RoleID' => [
                //'required'
            ],


            'Remark' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'username' => ['cette donnee est obligatoire'],


            'password' => ['cette donnee est obligatoire'],


            'Status' => ['cette donnee est obligatoire'],


            'last_login' => ['cette donnee est obligatoire'],


            'RoleID' => ['cette donnee est obligatoire'],


            'Remark' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("username", $data)) {


            if (!empty($data['username'])) {

                $Auth_user->username = $data['username'];

            }

        }


        if (array_key_exists("password", $data)) {


            if (!empty($data['password'])) {

                $Auth_user->password = $data['password'];

            }

        }


        if (array_key_exists("Status", $data)) {


            if (!empty($data['Status'])) {

                $Auth_user->Status = $data['Status'];

            }

        }


        if (array_key_exists("last_login", $data)) {


            if (!empty($data['last_login'])) {

                $Auth_user->last_login = $data['last_login'];

            }

        }


        if (array_key_exists("RoleID", $data)) {


            if (!empty($data['RoleID'])) {

                $Auth_user->RoleID = $data['RoleID'];

            }

        }


        if (array_key_exists("Remark", $data)) {


            if (!empty($data['Remark'])) {

                $Auth_user->Remark = $data['Remark'];

            }

        }


        if (array_key_exists("identifiants_sadge", $data)) {


            if (!empty($data['identifiants_sadge'])) {

                $Auth_user->identifiants_sadge = $data['identifiants_sadge'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Auth_user->creat_by = $data['creat_by'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Auth_user->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\Auth_uerExtras') &&
            method_exists('\App\Http\Extras\Auth_uerExtras', 'beforeSaveUpdate')
        ) {
            Auth_uerExtras::beforeSaveUpdate($request, $Auth_user);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Auth_uerExtras') &&
            method_exists('\App\Http\Extras\Auth_uerExtras', 'canUpdate')
        ) {
            try {
                $canSave = Auth_uerExtras::canUpdate($request, $Auth_user);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Auth_user->save();
        } else {
            return response()->json($Auth_user, 200);

        }


        $Auth_user = AuthUer::find($Auth_user->id);


        $newCrudData = [];

        $newCrudData['username'] = $Auth_user->username;
        $newCrudData['password'] = $Auth_user->password;
        $newCrudData['Status'] = $Auth_user->Status;
        $newCrudData['last_login'] = $Auth_user->last_login;
        $newCrudData['RoleID'] = $Auth_user->RoleID;
        $newCrudData['Remark'] = $Auth_user->Remark;
        $newCrudData['identifiants_sadge'] = $Auth_user->identifiants_sadge;
        $newCrudData['creat_by'] = $Auth_user->creat_by;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Auth_user', 'entite_cle' => $Auth_user->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Auth_user->toArray();


        try {

            foreach ($Auth_user->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, AuthUer $Auth_user)
    {
        try {
            $can = Helpers::can('Supprimer des auth_user');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['username'] = $Auth_user->username;
        $newCrudData['password'] = $Auth_user->password;
        $newCrudData['Status'] = $Auth_user->Status;
        $newCrudData['last_login'] = $Auth_user->last_login;
        $newCrudData['RoleID'] = $Auth_user->RoleID;
        $newCrudData['Remark'] = $Auth_user->Remark;
        $newCrudData['identifiants_sadge'] = $Auth_user->identifiants_sadge;
        $newCrudData['creat_by'] = $Auth_user->creat_by;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Auth_user', 'entite_cle' => $Auth_user->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Auth_uerExtras') &&
            method_exists('\App\Http\Extras\Auth_uerExtras', 'canDelete')
        ) {
            try {
                $canSave = Auth_uerExtras::canDelete($request, $Auth_user);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Auth_user->delete();
        } else {
            return response()->json($Auth_user, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new Auth_userActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
