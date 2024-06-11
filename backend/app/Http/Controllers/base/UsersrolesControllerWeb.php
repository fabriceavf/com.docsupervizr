<?php

namespace App\Http\Controllers\prod;

use App\Http\Controllers\Controller;
use App\Models\prod\DispositionsModel;
use App\Models\prod\RolesModel;
use App\Models\prod\UsersModel;
use App\Models\prod\UsersrolesModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;
use DataTables\SSP;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

// use App\Repository\prod\UsersrolesRepository;


ini_set('memory_limit', '8192M');

$db = GetDb::getDatabase();

class UsersrolesControllerWeb extends Controller
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
        $disposition = DispositionsModel::where(['disposition' => 'Grid', 'table' => 'usersroles'])->get();
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

        $vue = view('/content/prod/Usersroles.usersroles', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'disposition' => $disposition, 'preselect' => $new]);
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
        $disposition = DispositionsModel::where(['disposition' => 'Grid', 'table' => 'usersroles'])->get();
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

        $vue = view('/content/prod/Usersroles.usersroles', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'disposition' => $disposition, 'preselect' => $new]);
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


            array('db' => 'users', 'dt' => 'users'),


            array('db' => 'roles', 'dt' => 'roles'),


        );
        $filterAttributes = [
            'id',
            'users',
            'roles',
            'extra_attributes',
            'created_at',
            'updated_at',
            'deleted_at',
            'DT_RowId', 'Selectvalue', 'Selectlabel', 'CardRender', 'ForMe',
            'SignedEditUrl', 'SignedDeleteUrl', 'SignedShowUrl', 'SignedImpressionUrl', 'CreateursCruds',


            'UsersRender',


            'RolesRender',


        ];
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::simple($request->all(), $db, 'usersroles', 'id', $columns, $filterAttributes, 'App\Models\prod\UsersrolesModel', [$key => $val]);
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = UsersrolesModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();
                $don['PipelinesAvf'] = "";

                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;


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


            array('db' => 'users', 'dt' => 'users'),


            array('db' => 'roles', 'dt' => 'roles'),


        );
        $filterAttributes = [
            'id',
            'users',
            'roles',
            'extra_attributes',
            'created_at',
            'updated_at',
            'deleted_at',
            'DT_RowId', 'Selectvalue', 'Selectlabel', 'CardRender', 'ForMe',
            'SignedEditUrl', 'SignedDeleteUrl', 'SignedShowUrl', 'SignedImpressionUrl', 'CreateursCruds',


            'UsersRender',


            'RolesRender',


        ];
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::simple($request->all(), $db, 'usersroles', 'id', $columns, $filterAttributes, 'App\Models\prod\UsersrolesModel');
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = UsersrolesModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();
                $don['PipelinesAvf'] = "";

                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;


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

    public function index_one(Request $request, UsersrolesModel $Usersroles)
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
        $disposition = DispositionsModel::where(['disposition' => 'Grid', 'table' => 'usersroles'])->get();
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

        $vue = view('/content/prod/Usersroles.usersroles_one', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'Usersroles' => $Usersroles,
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

    public function show_impression(Request $request, UsersrolesModel $Usersroles)
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

        $vue = view('/content/prod/Usersroles.impression', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'data' => $Usersroles,
        ]);
        return response($vue, 200);

    }

    public function create(Request $request, UsersrolesModel $Usersroles)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $donnes = $request->only(['data.0'])['data'][0];
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


            // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))


            ->validator(Validate::unique(ValidateOptions::inst()->message("Cette donnee existe deja")))

        );


        // le champs roles
        $editor->Fields(Field::inst('roles')
            ->set(false)
        //        ->get(false)


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


        $editor->process($request->all());

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Usersroles->users = $donnes['users'] ?? [];


        $Usersroles->roles = $donnes['roles'] ?? [];


        $Usersroles->users = $donnes['users'] ?? [];


        $Usersroles->roles = $donnes['roles'] ?? [];


        $Usersroles->etats = $donnes['Etats'] ?? "";

        $Usersroles->etats = $donnes['Etats'] ?? "";
        $Permission = Gate::inspect('create', $Usersroles);

        $editor = Editor::inst($db, 'usersroles');


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


        );


        $editor->process($request->all());
        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }

        $Usersroles->save();


        $Usersroles = $Usersroles::find($Usersroles->id);
        $response = $Usersroles->toArray();

        $response['PipelinesAvf'] = $Usersroles->PipelinesAvf;

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
// $this->UsersrolesRepository->store($validated);

        $vue = view('/content/prod/Usersroles.post_usersroles', ['editorData' => $request->All()]);
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

        $donnes = $request->input()['data']['row_' . (is_array($Usersroles->id) ? $Usersroles->id[0] : $Usersroles->id)];

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


        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))


        );


        if ($Usersroles->users != $donnes['users']) {

            // le champs users
            $editor->Fields(Field::inst('users')
                ->validator(Validate::unique(ValidateOptions::inst()->message("Cette donnee existe deja")))
            );

        }


        // le champs roles
        $editor->Fields(Field::inst('roles')
            ->set(false)
        //        ->get(false)


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


        $editor->process($request->all());

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Usersroles->users = $donnes['users'] ?? [];


        $Usersroles->roles = $donnes['roles'] ?? [];


        $Usersroles->etats = $donnes['Etats'] ?? "";
        $Permission = Gate::inspect('update', $Usersroles);

        $editor = Editor::inst($db, 'usersroles');


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


        );


        $editor->process($request->all());
        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }

        $Usersroles->save();

        $response = $Usersroles
            ->toArray();
        $response['PipelinesAvf'] = $Usersroles->PipelinesAvf;
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
        $donnes = $request->input()['data']['row_' . (is_array($Usersroles->id) ? $Usersroles->id[0] : $Usersroles->id)];

        $Permission = Gate::inspect('delete', $Usersroles);

        if ($Permission->allowed()) {
            $Usersroles->delete();
        }
        $data = [];

        return response()->json($data, 200);


    }


}



