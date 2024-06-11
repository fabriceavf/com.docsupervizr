<?php

namespace App\Http\Controllers\prod;

use App\Http\Controllers\Controller;
use App\Models\prod\DispositionsModel;
use App\Models\prod\RolesModel;
use App\Models\prod\UsersModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;
use DataTables\SSP;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// use App\Repository\prod\UsersRepository;


ini_set('memory_limit', '8192M');

$db = GetDb::getDatabase();

class UsersControllerWeb extends Controller
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
     *
     * @return  Response
     */
    public function index(Request $request)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $params = collect($request->all());
        $params = $params->filter(function ($value, $key) {
//            dd($key);
            return Str::is('__key__*', $key);
        })->toArray();
        $new = [];
        foreach ($params as $key => $par) {
            $new[Str::replace('__key__', "", $key)] = $par;
        }
        $disposition = DispositionsModel::where(['disposition' => 'Grid', 'table' => 'users'])->get();
        if ($disposition->count() == 1) {
            $disposition = 'Grid';
        } else {
            $disposition = 'LISTES';
        }
        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => true,
            'footer' => true,
        ];

        $vue = view('/content/prod/Users.users', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'disposition' => $disposition, 'preselect' => $new]);
        return response($vue, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return    Response
     */
    public function index_two(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $params = collect($request->all());
        $params = $params->filter(function ($value, $k) {
//            dd($k);
            return Str::is('__key__*', $k);
        })->toArray();
        $new = [];
        foreach ($params as $k => $par) {
            $new[Str::replace('__key__', "", $k)] = $par;
        }
// some additional logic or checking
        $request->request->add([
            'pkey' => $key,
            'pval' => $val,
        ]);
        $disposition = DispositionsModel::where(['disposition' => 'Grid', 'table' => 'users'])->get();
        if ($disposition->count() == 1) {
            $disposition = 'Grid';
        } else {
            $disposition = 'LISTES';
        }
        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => true,
            'footer' => true,
        ];

        $vue = view('/content/prod/Users.users', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'disposition' => $disposition, 'preselect' => $new]);
        return response($vue, 200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide


        $columns = array(
            array('db' => 'id', 'dt' => 'id'),


            array('db' => 'name', 'dt' => 'name'),


            array('db' => 'email', 'dt' => 'email'),


            array('db' => 'email_verified_at', 'dt' => 'email_verified_at'),


            array('db' => 'password', 'dt' => 'password'),


            array('db' => 'two_factor_secret', 'dt' => 'two_factor_secret'),


            array('db' => 'two_factor_recovery_codes', 'dt' => 'two_factor_recovery_codes'),


            array('db' => 'remember_token', 'dt' => 'remember_token'),


            array('db' => 'current_team_id', 'dt' => 'current_team_id'),


            array('db' => 'profile_photo_path', 'dt' => 'profile_photo_path'),


            array('db' => 'prenoms', 'dt' => 'prenoms'),


            array('db' => 'contact', 'dt' => 'contact'),


            array('db' => 'email_interne', 'dt' => 'email_interne'),


            array('db' => 'others', 'dt' => 'others'),


            array('db' => 'types', 'dt' => 'types'),


            array('db' => 'statut', 'dt' => 'statut'),


        );
        $filterAttributes = [
            'id',
            'name',
            'email',
            'email_verified_at',
            'password',
            'two_factor_secret',
            'two_factor_recovery_codes',
            'remember_token',
            'current_team_id',
            'profile_photo_path',
            'prenoms',
            'contact',
            'email_interne',
            'others',
            'types',
            'statut',
            'extra_attributes',
            'deleted_at',
            'created_at',
            'updated_at',
            'DT_RowId', 'Selectvalue', 'Selectlabel', 'CardRender', 'ForMe',
            'SignedEditUrl', 'SignedDeleteUrl', 'SignedShowUrl', 'SignedImpressionUrl', 'CreateursCruds',


            'NameRender',


            'EmailRender',


            'EmailVerifiedAtRender',


            'PasswordRender',


            'TwoFactorSecretRender',


            'TwoFactorRecoveryCodesRender',


            'RememberTokenRender',


            'CurrentTeamIdRender',


            'ProfilePhotoPathRender',


            'PrenomsRender',


            'ContactRender',


            'EmailInterneRender',


            'OthersRender',


            'TypesRender',


            'StatutRender',


            'Groupes_usersRender',
            'Signedgroupes_usersUrl',


            'Oauth_access_tokensRender',
            'Signedoauth_access_tokensUrl',


            'Oauth_auth_codesRender',
            'Signedoauth_auth_codesUrl',


            'Oauth_clientsRender',
            'Signedoauth_clientsUrl',


            'Team_userRender',
            'Signedteam_userUrl',


        ];
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::simple($request->all(), $db, 'users', 'id', $columns, $filterAttributes, 'App\Models\prod\UsersModel', [$key => $val]);
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = UsersModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();
                $don['PipelinesAvf'] = "";
//            dd(Gate::inspect('view', $donnes)->allowed());
                if (!Gate::inspect('view', $donnes)->allowed()) {
                    $test = [];
                    foreach ($don as $key => $value) {
                        $test[$key] = "#########";

                    }
                    $don = $test;

                }
                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;
        if (empty($Roles)) {

            $Roles = RolesModel::where('guard_name', 'web')
                ->get()
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

        $donnees['options']['Roles'] = $Roles;


        echo json_encode(
            $donnees
        );


    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data1(Request $request)
    {


        $columns = array(
            array('db' => 'id', 'dt' => 'id'),


            array('db' => 'name', 'dt' => 'name'),


            array('db' => 'email', 'dt' => 'email'),


            array('db' => 'email_verified_at', 'dt' => 'email_verified_at'),


            array('db' => 'password', 'dt' => 'password'),


            array('db' => 'two_factor_secret', 'dt' => 'two_factor_secret'),


            array('db' => 'two_factor_recovery_codes', 'dt' => 'two_factor_recovery_codes'),


            array('db' => 'remember_token', 'dt' => 'remember_token'),


            array('db' => 'current_team_id', 'dt' => 'current_team_id'),


            array('db' => 'profile_photo_path', 'dt' => 'profile_photo_path'),


            array('db' => 'prenoms', 'dt' => 'prenoms'),


            array('db' => 'contact', 'dt' => 'contact'),


            array('db' => 'email_interne', 'dt' => 'email_interne'),


            array('db' => 'others', 'dt' => 'others'),


            array('db' => 'types', 'dt' => 'types'),


            array('db' => 'statut', 'dt' => 'statut'),


        );
        $filterAttributes = [
            'id',
            'name',
            'email',
            'email_verified_at',
            'password',
            'two_factor_secret',
            'two_factor_recovery_codes',
            'remember_token',
            'current_team_id',
            'profile_photo_path',
            'prenoms',
            'contact',
            'email_interne',
            'others',
            'types',
            'statut',
            'extra_attributes',
            'deleted_at',
            'created_at',
            'updated_at',
            'DT_RowId', 'Selectvalue', 'Selectlabel', 'CardRender', 'ForMe',
            'SignedEditUrl', 'SignedDeleteUrl', 'SignedShowUrl', 'SignedImpressionUrl', 'CreateursCruds',


            'NameRender',


            'EmailRender',


            'EmailVerifiedAtRender',


            'PasswordRender',


            'TwoFactorSecretRender',


            'TwoFactorRecoveryCodesRender',


            'RememberTokenRender',


            'CurrentTeamIdRender',


            'ProfilePhotoPathRender',


            'PrenomsRender',


            'ContactRender',


            'EmailInterneRender',


            'OthersRender',


            'TypesRender',


            'StatutRender',


            'Groupes_usersRender',
            'Signedgroupes_usersUrl',


            'Oauth_access_tokensRender',
            'Signedoauth_access_tokensUrl',


            'Oauth_auth_codesRender',
            'Signedoauth_auth_codesUrl',


            'Oauth_clientsRender',
            'Signedoauth_clientsUrl',


            'Team_userRender',
            'Signedteam_userUrl',


        ];
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::simple($request->all(), $db, 'users', 'id', $columns, $filterAttributes, 'App\Models\prod\UsersModel');
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = UsersModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();
                $don['PipelinesAvf'] = "";
//            dd(Gate::inspect('view', $donnes)->allowed());
                if (!Gate::inspect('view', $donnes)->allowed()) {
                    $test = [];
                    foreach ($don as $key => $value) {
                        $test[$key] = "#########";

                    }
                    $don = $test;

                }
                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;
        if (empty($Roles)) {

            $Roles = RolesModel::where('guard_name', 'web')
                ->get()
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

        $donnees['options']['Roles'] = $Roles;


        echo json_encode(
            $donnees
        );
    }


    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return  Response
     */

    public function index_one(Request $request, UsersModel $Users)
    {

        $params = collect($request->all());
        $params = $params->filter(function ($value, $key) {
//            dd($key);
            return Str::is('__key__*', $key);
        })->toArray();
        $new = [];
        foreach ($params as $key => $par) {
            $new[Str::replace('__key__', "", $key)] = $par;
        }
        $disposition = DispositionsModel::where(['disposition' => 'Grid', 'table' => 'users'])->get();
        if ($disposition->count() == 1) {
            $disposition = 'Grid';
        } else {
            $disposition = 'LISTES';
        }

        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => true,
            'footer' => true,
        ];
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $vue = view('/content/prod/Users.users_one', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'Users' => $Users,
            'disposition' => $disposition,
            'preselect' => $new
        ]);
        return response($vue, 200);

    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return  Response
     */

    public function show_impression(Request $request, UsersModel $Users)
    {


        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => false,
            'showMenu' => false,
            'footer' => false,
            'pageHeader' => false,
        ];
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $vue = view('/content/prod/Users.impression', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'data' => $Users,
        ]);
        return response($vue, 200);

    }

    public function create(Request $request, UsersModel $Users)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $donnes = $request->only(['data.0'])['data'][0];
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


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs email
        $editor->Fields(Field::inst('email')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            ->validator(Validate::unique(ValidateOptions::inst()->message("Cette donnee existe deja")))

        );
        // le champs confirmPassword
        $editor->Fields(Field::inst('id as passwordConfirm')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            //        ->get(false)
            ->validator(function ($data, $all) {
                $resultat = true;
                if (!empty($all['password']) && $data != $all['password']) {
                    $resultat = 'Les mots de passe ne corresponde pas';
                }

                return $resultat;
            })

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


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs contact
        $editor->Fields(Field::inst('contact')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs email_interne
        $editor->Fields(Field::inst('email_interne')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            ->validator(Validate::unique(ValidateOptions::inst()->message("Cette donnee existe deja")))

        );


        // le champs others
        $editor->Fields(Field::inst('others')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs types
        $editor->Fields(Field::inst('types')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs statut
        $editor->Fields(Field::inst('statut')
            ->set(false)
            //        ->get(false)


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


        $editor->process($request->all());

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Users->name = $donnes['name'] ?? "";


        $Users->email = $donnes['email'] ?? "";


        $Users->password = Hash::make($donnes['password']);


        $Users->prenoms = $donnes['prenoms'] ?? "";


        $Users->contact = $donnes['contact'] ?? "";


        $Users->email_interne = $donnes['email_interne'] ?? "";


        $Users->others = $donnes['others'] ?? "";


        $Users->types = $donnes['types'] ?? "";


        $Users->statut = $donnes['statut'] ?? "";


        $Users->name = $donnes['name'] ?? "";


        $Users->email = $donnes['email'] ?? "";


        $Users->prenoms = $donnes['prenoms'] ?? "";


        $Users->contact = $donnes['contact'] ?? "";


        $Users->email_interne = $donnes['email_interne'] ?? "";


        $Users->others = $donnes['others'] ?? "";


        $Users->types = $donnes['types'] ?? "";


        $Users->statut = $donnes['statut'] ?? "";


        $Users->etats = $donnes['Etats'] ?? "";

        $Users->Roles = $donnes['Roles'] ?? [];
        $Permission = Gate::inspect('create', $Users);

        $editor = Editor::inst($db, 'users');


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


        );


        $editor->process($request->all());
        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }

        $Users->save();


        $Users = $Users::find($Users->id);
        $response = $Users->toArray();

        $response['PipelinesAvf'] = $Users->PipelinesAvf;

        $donnees['data'][] = $response;


        return response()->json($donnees, 200);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return  Response
     */
    public function store(Request $request)
    {
// je valide les donnees recu
// $validator = Validator::make($request->only($this->validateField), $this->validateRegles,$this->validateMessages);
// if ($validator->fails()) {
//             return redirect()->back()
//                 ->withErrors($validator)
//                 ->withInput();
// }
//  // Retrieve the validated input..
// $validated = $validator->validated();
// dd($validated);
// $this->UsersRepository->store($validated);

        $vue = view('/content/prod/Users.post_users', ['editorData' => $request->All()]);
        return response($vue, 200);

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

        $donnes = $request->input()['data']['row_' . (is_array($Users->id) ? $Users->id[0] : $Users->id)];

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


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs email
        $editor->Fields(Field::inst('email')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        if ($Users->email != $donnes['email']) {

            // le champs email
            $editor->Fields(Field::inst('email')
                ->validator(Validate::unique(ValidateOptions::inst()->message("Cette donnee existe deja")))
            );

        }


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


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs contact
        $editor->Fields(Field::inst('contact')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs email_interne
        $editor->Fields(Field::inst('email_interne')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        if ($Users->email_interne != $donnes['email_interne']) {

            // le champs email_interne
            $editor->Fields(Field::inst('email_interne')
                ->validator(Validate::unique(ValidateOptions::inst()->message("Cette donnee existe deja")))
            );

        }


        // le champs others
        $editor->Fields(Field::inst('others')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs types
        $editor->Fields(Field::inst('types')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs statut
        $editor->Fields(Field::inst('statut')
            ->set(false)
            //        ->get(false)


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


        $editor->process($request->all());

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Users->name = $donnes['name'] ?? "";


        $Users->email = $donnes['email'] ?? "";


        $Users->prenoms = $donnes['prenoms'] ?? "";


        $Users->contact = $donnes['contact'] ?? "";


        $Users->email_interne = $donnes['email_interne'] ?? "";


        $Users->others = $donnes['others'] ?? "";


        $Users->types = $donnes['types'] ?? "";


        $Users->statut = $donnes['statut'] ?? "";


        $Users->etats = $donnes['Etats'] ?? "";

        $Users->Roles = $donnes['Roles'] ?? [];
        $Permission = Gate::inspect('update', $Users);

        $editor = Editor::inst($db, 'users');


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


        );


        $editor->process($request->all());
        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }

        $Users->save();

        $response = $Users
            ->toArray();
        $response['PipelinesAvf'] = $Users->PipelinesAvf;
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
        $donnes = $request->input()['data']['row_' . (is_array($Users->id) ? $Users->id[0] : $Users->id)];

        $Permission = Gate::inspect('delete', $Users);

        if ($Permission->allowed()) {
            $Users->delete();
        }
        $data = [];

        return response()->json($data, 200);


    }


}



