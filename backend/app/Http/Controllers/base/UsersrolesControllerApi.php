<?php

namespace App\Http\Controllers\prod;

use App\Http\Controllers\Controller;
use App\Models\prod\RolesModel;
use App\Models\prod\UsersModel;
use App\Models\prod\UsersrolesModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\GetDb;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

// use App\Repository\prod\UsersrolesRepository;


$db = GetDb::getDatabase();

class UsersrolesControllerApi extends Controller
{

    private $UsersrolesRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\UsersrolesRepository $UsersrolesRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {


    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
        $request->merge(['filter' => [$key => $val]]);
        $data = QueryBuilder::for(UsersrolesModel::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('users'),


                AllowedFilter::exact('roles'),


            ])
            ->get()
            ->filter(function ($data) {
                return Gate::inspect('view', $data)->allowed();
            });
        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20;
        $records = new LengthAwarePaginator(
            $data->forPage($page, $perPage), $data->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
        );
        $donnees = $records;
        $donnees = $donnees->toArray();


        if (empty($users)) {

            $users = UsersModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['users'] = $users;


        if (empty($roles)) {

            $roles = RolesModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['roles'] = $roles;


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data1(Request $request)
    {


        $data = QueryBuilder::for(UsersrolesModel::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('users'),


                AllowedFilter::exact('roles'),


            ])
            ->get()
            ->filter(function ($data) {
                return Gate::inspect('view', $data)->allowed();
            });
        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20;
        $records = new LengthAwarePaginator(
            $data->forPage($page, $perPage), $data->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
        );
        $donnees = $records;
        $donnees = $donnees->toArray();


        if (empty($users)) {

            $users = UsersModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['users'] = $users;


        if (empty($roles)) {

            $roles = RolesModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['roles'] = $roles;


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


    public function create(Request $request, UsersrolesModel $Usersroles)
    {
        $Permission = Gate::inspect('create', UsersrolesModel::class);

// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
        if (empty($request->only(['data.0'])['data'][0])) {
            $donnes = [
                'data' => [[]],
                'action' => 'create',
            ];
        } else {
            $donnes = [
                'data' => [$request->only(['data.0'])['data'][0]],
                'action' => 'create',
            ];

        }
        $request->merge(['action' => 'create']);


        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'usersroles');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs users
        $editor->Fields(Field::inst('users')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })

        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))


        );


        // le champs roles
        $editor->Fields(Field::inst('roles')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })

        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))


        );


        // le champs extra_attributes
        $editor->Fields(Field::inst('extra_attributes')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs created_at
        $editor->Fields(Field::inst('created_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs updated_at
        $editor->Fields(Field::inst('updated_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs deleted_at
        $editor->Fields(Field::inst('deleted_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        $editor->process($donnes);

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Usersroles->users = $donnes['users'];


        $Usersroles->roles = $donnes['roles'];


        $Usersroles->save();


        $Usersroles = $Usersroles::find($Usersroles->id);
        $response = $Usersroles->toArray();
        $donnees['data'][] = $response;


        if (empty($users)) {

            $users = UsersModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['users'] = $users;


        if (empty($roles)) {

            $roles = RolesModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['roles'] = $roles;


        return response()->json($donnees, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return  Response
     */
    public function show($id)
    {
//

        $this->UsersrolesRepository->show($id);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return  Response
     */

    public function update(Request $request, UsersrolesModel $Usersroles)
    {

        $Permission = Gate::inspect('update', $Usersroles);
        if (empty($request->only(['data.0'])['data'][0])) {
            $donnes = [
                'data' => [[]],
                'action' => 'create',
            ];
        } else {
            $donnes = [
                'data' => [$request->only(['data.0'])['data'][0]],
                'action' => 'create',
            ];

        }
        $request->merge(['action' => 'edit']);
        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'usersroles');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs users
        $editor->Fields(Field::inst('users')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })


        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))


        );


        // le champs roles
        $editor->Fields(Field::inst('roles')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })


        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))


        );


        // le champs extra_attributes
        $editor->Fields(Field::inst('extra_attributes')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs created_at
        $editor->Fields(Field::inst('created_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs updated_at
        $editor->Fields(Field::inst('updated_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs deleted_at
        $editor->Fields(Field::inst('deleted_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        $editor->process($donnes);

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Usersroles->users = $donnes['users'];


        $Usersroles->roles = $donnes['roles'];


        $Usersroles->save();

        $response = $Usersroles
            ->toArray();
        $donnees['data'][] = $response;


        if (empty($users)) {

            $users = UsersModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['users'] = $users;


        if (empty($roles)) {

            $roles = RolesModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['roles'] = $roles;


        return response()->json($donnees, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return  Response
     */
    public function delete(Request $request, UsersrolesModel $Usersroles)
    {
        if (empty($request->only(['data.0'])['data'][0])) {
            $donnes = [
                'data' => [[]],
                'action' => 'create',
            ];
        } else {
            $donnes = [
                'data' => [$request->only(['data.0'])['data'][0]],
                'action' => 'create',
            ];

        }

        $Permission = Gate::inspect('delete', $Usersroles);

        if ($Permission->allowed()) {
            $Usersroles->delete();
        }
        $data = [];

        return response()->json($data, 200);


    }


}
