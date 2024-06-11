<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\base\BuildersModel;
use App\Models\base\DispositionsModel;
use App\Models\base\UsersModel;
use App\Models\prod\TablesModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\GetDb;
use DataTables\SSP;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


// use App\Repository\base\BuildersRepository;


ini_set('memory_limit', '8192M');
ini_set('max_execution_time', '300');

$db = GetDb::getDatabase();

class BuildersControllerWeb extends Controller
{

    private $BuildersRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\base\BuildersRepository $BuildersRepository
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
    public function index(Request $request, TablesModel $tables)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide


        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => true,
            'footer' => true,

        ];

        $vue = view('/content/base/Builders.builders', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, "Tables" => $tables, 'data' => $this->personal_infos($tables->id)]);
        return response($vue, 200);
    }

    private function personal_infos($table_id)
    {
        $allData = [];

        $allData['champs'] = DB::table('champs')
            ->whereIn('table_id', [$table_id])
            ->get('id')->map(function ($data) {
                return $data->id;
            })->toArray();

//        $allData['permis']=DB::table('permis')
//            ->whereIn('table_id',[$table_id])
//            ->get('id')->map(function($data){return $data->id;})->toArray();


//        $allData['getters']=DB::table('getters')
//            ->whereIn('champ_id',$allData['champs'])
//            ->get('id')->map(function($data){return $data->id;})->toArray();
//
//        $allData['setters']=DB::table('setters')
//            ->whereIn('champ_id',$allData['champs'])
//            ->get('id')->map(function($data){return $data->id;})->toArray();
//
//        $allData['validators']=DB::table('validators')
//            ->whereIn('champ_id',$allData['champs'])
//            ->get('id')->map(function($data){return $data->id;})->toArray();
//
//        $allData['get_vals']=DB::table('get_vals')
//            ->whereIn('getter_id',$allData['getters'])
//            ->get('id')->map(function($data){return $data->id;})->toArray();
//
//        $allData['set_vals']=DB::table('set_vals')
//            ->whereIn('setter_id',$allData['setters'])
//            ->get('id')->map(function($data){return $data->id;})->toArray();
//        $allData['val_vals']=DB::table('set_vals')
//            ->whereIn('validator_id',$allData['validators'])
//            ->get('id')->map(function($data){return $data->id;})->toArray();
        $newDatas = [];
        foreach ($allData as $key => $data) {
            $newDatas[$key] = DB::table($key)->whereIn('id', $data)->get()->toArray();


        }


        return $newDatas;


    }

    /**
     * Display a listing of the resource.
     *
     * @return    Response
     */
    public function index_two(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature() && !Auth::user()->can("Voir les builders")) {
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
        $builders_disposition = DispositionsModel::where(['table' => 'builders'])->first();


        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => true,
            'footer' => true,
        ];


        if (empty($users)) {

            $users = UsersModel::all()

                //   ->filter(function($data){ return Gate::inspect('view',$data)->allowed(); })

                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['createurs'] = $users;


        $vue = view('/content/base/Builders.builders', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'builders_disposition' => $builders_disposition, 'preselect' => $new, 'options' => $donnees ?? [],
        ]);
        return response($vue, 200);
    }

    public function where()
    {
        $groupes = [];
// $groupes=Auth::user()->MyGroupes->toArray();
        $where = [];
        foreach ($groupes as $groupe) {
// $where[]="recepteurs_connus LIKE '$groupe'";
// $where[]="recepteurs_connus LIKE '$groupe,%'";
// $where[]="recepteurs_connus LIKE '%,$groupe'";
// $where[]="recepteurs_connus LIKE '%,$groupe,%'";
// $where[]="emetteurs_connus LIKE '$groupe'";
// $where[]="emetteurs_connus LIKE '$groupe,%'";
// $where[]="emetteurs_connus LIKE '%,$groupe'";
// $where[]="emetteurs_connus LIKE '%,$groupe,%'";

        }
        if (count($where) > 0) {
            $where = '(' . implode(' OR ', $where) . ')';

        }


        if (Auth::user()->can("Voir les builders")) {
            $where = [];
        }
        return $where;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data(Request $request, $key, $val)
    {


        $val = explode(',', $val);
        $val = '(' . implode(',', $val) . ')';
        $val = Str::replaceFirst('(', "('", $val);
        $val = Str::replaceLast(')', "')", $val);
        $val = Str::replace(',', "','", $val);
// La securite qui empeiche darriver sur cette sans avoir une signature valide


        $columns = array(

            array('db' => 'id', 'dt' => 'id'),


            array('db' => 'statut', 'dt' => 'statut'),


            array('db' => 'createurs', 'dt' => 'createurs'),


        );


        $filters = ['deleted_at IS NULL'];
        $filters[] = "$key IN $val ";
        if (!is_array($this->where())) {
            $filters[] = $this->where();
        }
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::complex($request->all(), $db, 'builders', 'id', $columns, null, $filters);
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = BuildersModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();


                $don['PipelinesAvf'] = "";
                try {
                    $don['CardRender'] = $donnes->CardRender ?? "";
                } catch (Exception $e) {

                }
                try {
                    $don['CardRenderMini'] = $donnes->CardRenderMini ?? "";
                } catch (Exception $e) {

                }
                try {
                    $don['CardRenderSelect'] = $donnes->CardRenderSelect ?? "";
                } catch (Exception $e) {

                }
                try {
                    $don['CardRenderComponent'] = $donnes->CardRenderComponent ?? "";
                } catch (Exception $e) {

                }
//            dd(Gate::inspect('view', $donnes)->allowed());


                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;


        echo json_encode(
            $donnees
        );


    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data4(Request $request, $key, $val)
    {


        $val = explode(',', $val);
        $val = '(' . implode(',', $val) . ')';
        $val = Str::replaceFirst('(', "('", $val);
        $val = Str::replaceLast(')', "')", $val);
        $val = Str::replace(',', "','", $val);
// La securite qui empeiche darriver sur cette sans avoir une signature valide


        $columns = array(


            array('db' => 'id', 'dt' => 'id'),


            array('db' => 'statut', 'dt' => 'statut'),


            array('db' => 'createurs', 'dt' => 'createurs'),


        );
        $filters = ['deleted_at IS NULL'];
        $filters[] = "$key IN $val ";
        if (!is_array($this->where())) {
            $filters[] = $this->where();
        }
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::complex($request->all(), $db, 'builders', 'id', $columns, null, $filters);
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = BuildersModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();


                $don['PipelinesAvf'] = "";
                try {
                    $don['CardRender'] = $donnes->CardRender ?? "";
                } catch (Exception $e) {

                }
                try {
                    $don['CardRenderMini'] = $donnes->CardRenderMini ?? "";
                } catch (Exception $e) {

                }
                try {
                    $don['CardRenderSelect'] = $donnes->CardRenderSelect ?? "";
                } catch (Exception $e) {

                }
                try {
                    $don['CardRenderComponent'] = $donnes->CardRenderComponent ?? "";
                } catch (Exception $e) {

                }
//            dd(Gate::inspect('view', $donnes)->allowed());

                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;


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


            array('db' => 'statut', 'dt' => 'statut'),


            array('db' => 'createurs', 'dt' => 'createurs'),


        );

        $filters = ['deleted_at IS NULL'];
        if (!is_array($this->where())) {
            $filters[] = $this->where();
        }
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::complex($request->all(), $db, 'builders', 'id', $columns, null, $filters);
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = BuildersModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();


                $don['PipelinesAvf'] = "";
                try {
                    $don['CardRender'] = $donnes->CardRender ?? "";
                } catch (Exception $e) {

                }
                try {
                    $don['CardRenderMini'] = $donnes->CardRenderMini ?? "";
                } catch (Exception $e) {

                }
                try {
                    $don['CardRenderSelect'] = $donnes->CardRenderSelect ?? "";
                } catch (Exception $e) {

                }
                try {
                    $don['CardRenderComponent'] = $donnes->CardRenderComponent ?? "";
                } catch (Exception $e) {

                }
//            dd(Gate::inspect('view', $donnes)->allowed());

                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;


        echo json_encode(
            $donnees
        );
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function dataselect(Request $request)
    {


        $columns = array(


            array('db' => 'id', 'dt' => 'id'),


            array('db' => 'statut', 'dt' => 'statut'),


            array('db' => 'createurs', 'dt' => 'createurs'),


        );

        $filters = ['deleted_at IS NULL'];
        if (!is_array($this->where())) {
            $filters[] = $this->where();
        }
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::complex($request->all(), $db, 'builders', 'id', $columns, null, $filters);
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = BuildersModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();
                $don['PipelinesAvf'] = "";
                try {
                    $don['CardRenderSelect'] = $donnes->CardRenderSelect ?? "";

                } catch (Exception $e) {
                }


                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;


        echo json_encode(
            $donnees
        );
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data3(Request $request)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
        $request->merge(['filter' => [$key => $val]]);
        $data = QueryBuilder::for(BuildersModel::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('statut'),


                AllowedFilter::exact('createurs'),


            ])
            ->get()//   ->filter(function($data){ return Gate::inspect('view',$data)->allowed(); })

        ;
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
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return  Response
     */

    public function index_one(Request $request, BuildersModel $Builders)
    {

        $builders_disposition = DispositionsModel::where(['table' => 'builders'])->first();


        $params = collect($request->all());
        $params = $params->filter(function ($value, $key) {
//            dd($key);
            return Str::is('__key__*', $key);
        })->toArray();
        $new = [];
        foreach ($params as $key => $par) {
            $new[Str::replace('__key__', "", $key)] = $par;
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


        if (empty($users)) {

            $users = UsersModel::all()

                //   ->filter(function($data){ return Gate::inspect('view',$data)->allowed(); })

                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['createurs'] = $users;


        $vue = view('/content/base/Builders.builders_one', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'Builders' => $Builders,
            'builders_disposition' => $builders_disposition
            , 'preselect' => $new, 'options' => $donnees ?? [],
        ]);


        return response($vue, 200);

    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return  Response
     */

    public function show_impression(Request $request, BuildersModel $Builders)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $builders_disposition = DispositionsModel::where(['table' => 'builders'])->first();


        $params = collect($request->all());
        $params = $params->filter(function ($value, $key) {
//            dd($key);
            return Str::is('__key__*', $key);
        })->toArray();
        $new = [];
        foreach ($params as $key => $par) {
            $new[Str::replace('__key__', "", $key)] = $par;
        }

        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => false,
            'showMenu' => false,
            'footer' => false,
            'pageHeader' => false,
        ];


        $vue = view('/content/base/Builders.impression', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'Builders' => $Builders,
            'builders_disposition' => $builders_disposition
            , 'preselect' => $new, 'options' => $donnees ?? [],
        ]);
        return response($vue, 200);

    }

    public function create(Request $request, TablesModel $tables, BuildersModel $Builders)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }


        $donnes = $request->only(['data.0'])['data'][0];


        $champsRechercher = [
            'id',
            'statut',
            'extra_attributes',
            'deleted_at',
            'created_at',
            'updated_at',
            'createurs',
        ];
        $envoyer = [];
        foreach ($donnes as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);


        $extra_data = array_diff($envoyer, $champsRechercher);
        $request->merge(['action' => 'create']);

        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'builders');
        // le champs id
        $editor->Fields(Field::inst('id')
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
        // le champs createurs
        $editor->Fields(Field::inst('createurs')
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
        $Builders->createurs = $donnes['createurs'] ?? [];
        $Builders->etats = $donnes['Etats'] ?? "";
        $Builders->etats = $donnes['Etats'] ?? "";
        $Permission = Gate::inspect('create', $Builders);

        $editor = Editor::inst($db, 'builders');


        $editor->process($request->all());
        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }

//        dd('voici lextra data',$extra_data);
        foreach ($extra_data as $d) {


            $dat[$d] = $donnes[$d] ?? "";

            $Builders->extra_attributes["extra-data"] = $dat;
        }
        $Builders->save();


        $Builders = $Builders::find($Builders->id);
        $response = $Builders->toArray();

        $response['PipelinesAvf'] = $Builders->PipelinesAvf;
        try {
            $response['CardRender'] = $Builders->CardRender ?? "";
        } catch (Exception $e) {

        }
        try {
            $response['CardRenderMini'] = $Builders->CardRenderMini ?? "";
        } catch (Exception $e) {

        }
        try {
            $response['CardRenderSelect'] = $Builders->CardRenderSelect ?? "";
        } catch (Exception $e) {

        }
        try {
            $response['CardRenderComponent'] = $Builders->CardRenderComponent ?? "";
        } catch (Exception $e) {

        }

        foreach ($Builders->extra_attributes["extra-data"] as $key => $dat) {
            $response[$key] = $dat;
        }
        $donnees['data'][] = $response;

        return response()->json($donnees, 200);


    }

    public function create1(Request $request, $tables, BuildersModel $Builders)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $donnes = $request->only(['data.0'])['data'][0];
        $champsRechercher = [
            'id',
            'statut',
            'extra_attributes',
            'deleted_at',
            'created_at',
            'updated_at',
            'createurs',
        ];
        $envoyer = [];
        foreach ($donnes as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);


        $extra_data = array_diff($envoyer, $champsRechercher);
        $request->merge(['action' => 'create']);


        $Builders->etats = $donnes['Etats'] ?? "";


        $Builders->etats = $donnes['Etats'] ?? "";


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $donnes[$d];

        }
        $Builders->extra_attributes["extra-data"] = $dat;
        $Builders->save();


        $Builders = $Builders::find($Builders->id);
        $response = $Builders->toArray();

        $response['PipelinesAvf'] = $Builders->PipelinesAvf;
        try {
            $response['CardRender'] = $Builders->CardRender ?? "";
        } catch (Exception $e) {

        }
        try {
            $response['CardRenderMini'] = $Builders->CardRenderMini ?? "";
        } catch (Exception $e) {

        }
        try {
            $response['CardRenderSelect'] = $Builders->CardRenderSelect ?? "";
        } catch (Exception $e) {

        }
        try {
            $response['CardRenderComponent'] = $Builders->CardRenderComponent ?? "";
        } catch (Exception $e) {

        }

        foreach ($Builders->extra_attributes["extra-data"] as $key => $dat) {
            $response[$key] = $dat;
        }
        $donnees['data'][] = $response;
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
// $this->BuildersRepository->store($validated);

        $vue = view('/content/base/Builders.post_builders', ['editorData' => $request->All()]);
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

        $this->BuildersRepository->show($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return  Response
     */

    public function update(Request $request, $tables, BuildersModel $Builders)
    {

        $donnes = $request->input()['data']['row_' . (is_array($Builders->id) ? $Builders->id[0] : $Builders->id)];

        $champsRechercher = [
            'id',
            'statut',
            'extra_attributes',
            'deleted_at',
            'created_at',
            'updated_at',
            'createurs',
        ];
        $envoyer = [];
        foreach ($donnes as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);


        $extra_data = array_diff($envoyer, $champsRechercher);
        $request->merge(['action' => 'edit']);
        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'builders');
        // le champs id
        $editor->Fields(Field::inst('id')
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


        // le champs createurs
        $editor->Fields(Field::inst('createurs')
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


        $Builders->etats = $donnes['Etats'] ?? "";


        $Permission = Gate::inspect('update', $Builders);

        $editor = Editor::inst($db, 'builders');


        $editor->process($request->all());
        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }

        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $donnes[$d];

        }
        $Builders->extra_attributes["extra-data"] = $dat;
        $Builders->save();


        $response = $Builders
            ->toArray();
        $response['PipelinesAvf'] = $Builders->PipelinesAvf;
        try {
            $response['CardRender'] = $Builders->CardRender ?? "";
        } catch (Exception $e) {

        }
        try {
            $response['CardRenderMini'] = $Builders->CardRenderMini ?? "";
        } catch (Exception $e) {

        }
        try {
            $response['CardRenderSelect'] = $Builders->CardRenderSelect ?? "";
        } catch (Exception $e) {

        }
        try {
            $response['CardRenderComponent'] = $Builders->CardRenderComponent ?? "";
        } catch (Exception $e) {

        }
        foreach ($Builders->extra_attributes["extra-data"] as $key => $dat) {
            $response[$key] = $dat;
        }
        $donnees['data'][] = $response;


        return response()->json($donnees, 200);


    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return  Response
     */
    public function delete(Request $request, $tables, BuildersModel $Builders)
    {
        $donnes = $request->input()['data']['row_' . (is_array($Builders->id) ? $Builders->id[0] : $Builders->id)];

        $Permission = Gate::inspect('delete', $Builders);

        if ($Permission->allowed()) {
            $Builders->delete();
        }
        $data = [];

        return response()->json($data, 200);


    }

    public function infos(Request $request, $table_id)
    {


        return response()->json($this->personal_infos($table_id), 200);


    }

    public function cardrender(Request $request, TablesModel $table)
    {

        $content = view('/content/base/builders/cardrender', ['data' => $table])->render();


        return response($content, 200);


    }


}



