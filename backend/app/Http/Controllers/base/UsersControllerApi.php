<?php

namespace App\Http\Controllers\prod;

use App\Http\Controllers\Controller;
use App\Models\prod\UsersModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

// use App\Repository\prod\UsersRepository;

$db = GetDb::getDatabase();

class UsersControllerApi extends Controller
{

    private $UsersRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\UsersRepository $UsersRepository
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
        $data = QueryBuilder::for(UsersModel::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('name'),


                AllowedFilter::exact('email'),


                AllowedFilter::exact('email_verified_at'),


                AllowedFilter::exact('password'),


                AllowedFilter::exact('two_factor_secret'),


                AllowedFilter::exact('two_factor_recovery_codes'),


                AllowedFilter::exact('remember_token'),


                AllowedFilter::exact('current_team_id'),


                AllowedFilter::exact('profile_photo_path'),


                AllowedFilter::exact('prenoms'),


                AllowedFilter::exact('contact'),


                AllowedFilter::exact('email_interne'),


                AllowedFilter::exact('others'),


                AllowedFilter::exact('types'),


                AllowedFilter::exact('statut'),


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


        $data = QueryBuilder::for(UsersModel::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('name'),


                AllowedFilter::exact('email'),


                AllowedFilter::exact('email_verified_at'),


                AllowedFilter::exact('password'),


                AllowedFilter::exact('two_factor_secret'),


                AllowedFilter::exact('two_factor_recovery_codes'),


                AllowedFilter::exact('remember_token'),


                AllowedFilter::exact('current_team_id'),


                AllowedFilter::exact('profile_photo_path'),


                AllowedFilter::exact('prenoms'),


                AllowedFilter::exact('contact'),


                AllowedFilter::exact('email_interne'),


                AllowedFilter::exact('others'),


                AllowedFilter::exact('types'),


                AllowedFilter::exact('statut'),


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


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


    public function create(Request $request, UsersModel $Users)
    {
        $Permission = Gate::inspect('create', UsersModel::class);

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

        $editor = Editor::inst($db, 'users');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs name
        $editor->Fields(Field::inst('name')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs email
        $editor->Fields(Field::inst('email')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs email_verified_at
        $editor->Fields(Field::inst('email_verified_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs password
        $editor->Fields(Field::inst('password')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs two_factor_secret
        $editor->Fields(Field::inst('two_factor_secret')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs two_factor_recovery_codes
        $editor->Fields(Field::inst('two_factor_recovery_codes')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs remember_token
        $editor->Fields(Field::inst('remember_token')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs current_team_id
        $editor->Fields(Field::inst('current_team_id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs profile_photo_path
        $editor->Fields(Field::inst('profile_photo_path')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs prenoms
        $editor->Fields(Field::inst('prenoms')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs contact
        $editor->Fields(Field::inst('contact')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs email_interne
        $editor->Fields(Field::inst('email_interne')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs others
        $editor->Fields(Field::inst('others')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs types
        $editor->Fields(Field::inst('types')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs statut
        $editor->Fields(Field::inst('statut')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs extra_attributes
        $editor->Fields(Field::inst('extra_attributes')
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


        $editor->process($donnes);

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Users->name = $donnes['name'];


        $Users->email = $donnes['email'];


        $Users->password = $donnes['password'];


        $Users->prenoms = $donnes['prenoms'];


        $Users->contact = $donnes['contact'];


        $Users->email_interne = $donnes['email_interne'];


        $Users->others = $donnes['others'];


        $Users->types = $donnes['types'];


        $Users->statut = $donnes['statut'];


        $Users->save();


        $Users = $Users::find($Users->id);
        $response = $Users->toArray();
        $donnees['data'][] = $response;


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

        $this->UsersRepository->show($id);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return  Response
     */

    public function update(Request $request, UsersModel $Users)
    {

        $Permission = Gate::inspect('update', $Users);
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

        $editor = Editor::inst($db, 'users');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs name
        $editor->Fields(Field::inst('name')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs email
        $editor->Fields(Field::inst('email')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs email_verified_at
        $editor->Fields(Field::inst('email_verified_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs password
        $editor->Fields(Field::inst('password')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs two_factor_secret
        $editor->Fields(Field::inst('two_factor_secret')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs two_factor_recovery_codes
        $editor->Fields(Field::inst('two_factor_recovery_codes')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs remember_token
        $editor->Fields(Field::inst('remember_token')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs current_team_id
        $editor->Fields(Field::inst('current_team_id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs profile_photo_path
        $editor->Fields(Field::inst('profile_photo_path')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs prenoms
        $editor->Fields(Field::inst('prenoms')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs contact
        $editor->Fields(Field::inst('contact')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs email_interne
        $editor->Fields(Field::inst('email_interne')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs others
        $editor->Fields(Field::inst('others')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs types
        $editor->Fields(Field::inst('types')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs statut
        $editor->Fields(Field::inst('statut')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs extra_attributes
        $editor->Fields(Field::inst('extra_attributes')
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


        $editor->process($donnes);

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Users->name = $donnes['name'];


        $Users->email = $donnes['email'];


        $Users->password = $donnes['password'];


        $Users->prenoms = $donnes['prenoms'];


        $Users->contact = $donnes['contact'];


        $Users->email_interne = $donnes['email_interne'];


        $Users->others = $donnes['others'];


        $Users->types = $donnes['types'];


        $Users->statut = $donnes['statut'];


        $Users->save();

        $response = $Users
            ->toArray();
        $donnees['data'][] = $response;


        return response()->json($donnees, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return  Response
     */
    public function delete(Request $request, UsersModel $Users)
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

        $Permission = Gate::inspect('delete', $Users);

        if ($Permission->allowed()) {
            $Users->delete();
        }
        $data = [];

        return response()->json($data, 200);


    }


}
