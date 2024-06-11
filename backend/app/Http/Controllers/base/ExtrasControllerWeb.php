<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\base\ExtrasModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

// use App\Repository\base\ExtrasRepository;


ini_set('memory_limit', '8192M');

$db = GetDb::getDatabase();

class ExtrasControllerWeb extends Controller
{

    private $ExtrasRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
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

        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => true,
            'footer' => true,
        ];

        $vue = view('/content/base/Extras.extras', ['pageConfigs' => $pageConfig, 'menu' => $this->menu]);
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
// some additional logic or checking
        $request->request->add([
            'pkey' => $key,
            'pval' => $val,
        ]);
        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => true,
            'footer' => true,
        ];

        $vue = view('/content/base/Extras.extras', ['pageConfigs' => $pageConfig, 'menu' => $this->menu]);
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
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $request->merge(['filter' => [$key => $val]]);
        $data = QueryBuilder::for(ExtrasModel::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('libelle'),


                AllowedFilter::exact('types'),


                AllowedFilter::exact('text'),


                AllowedFilter::exact('files'),


                AllowedFilter::exact('textarea'),


                AllowedFilter::exact('datetime'),


            ])
            ->get()
            ->map(function ($data) {
                return array_merge($data->toArray(), ['PipelinesAvf' => $data->PipelinesAvf]);
            });

        $donnees['data'] = $data;


        return response()->json($donnees, 200);


    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data1(Request $request)
    {


        $data = QueryBuilder::for(ExtrasModel::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('libelle'),


                AllowedFilter::exact('types'),


                AllowedFilter::exact('text'),


                AllowedFilter::exact('files'),


                AllowedFilter::exact('textarea'),


                AllowedFilter::exact('datetime'),


            ])
            ->get()
            ->map(function ($data) {
                return array_merge($data->toArray(), ['PipelinesAvf' => $data->PipelinesAvf]);
            });

        $donnees['data'] = $data;


        return response()->json($donnees, 200);


// $columns = array(
        // array( 'db' => 'id',   'dt' => 'id'),


        // array( 'db' => 'libelle',   'dt' => 'libelle'),


        // array( 'db' => 'types',   'dt' => 'types'),


        // array( 'db' => 'text',   'dt' => 'text'),


        // array( 'db' => 'files',   'dt' => 'files'),


        // array( 'db' => 'textarea',   'dt' => 'textarea'),


        // array( 'db' => 'datetime',   'dt' => 'datetime'),


// );
// $db = GetDb::getDatabase()->database_driver;
// $resultat=SSP::simple( $request->all(), $db, 'extras', 'id', $columns );
// $new_data=[];
// foreach ($resultat['data'] as $data){
// $donnes=ExtrasModel::find($data['id']);
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
// $don= $donnes->toArray();
// $don['PipelinesAvf'] = "";
// //            dd(Gate::inspect('view', $donnes)->allowed());
// if(!Gate::inspect('view', $donnes)->allowed()){
// $test= [];
// foreach ($don as $key=>$value){
// $test[$key]="#########";
//
// }
// $don=$test;
//
// }
// $new_data[] = $don;
// }
// $resultat['data']=$new_data;
// echo json_encode(
// $resultat
// );
    }


    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return  Response
     */

    public function index_one(Request $request, ExtrasModel $Extras)
    {


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

        $vue = view('/content/base/Extras.extras_one', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'Extras' => $Extras,
        ]);
        return response($vue, 200);

    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return  Response
     */

    public function show_impression(Request $request, ExtrasModel $Extras)
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

        $vue = view('/content/base/Extras.impression', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'Extras' => $Extras,
        ]);
        return response($vue, 200);

    }

    public function create(Request $request, ExtrasModel $Extras)
    {
        $Permission = Gate::inspect('create', ExtrasModel::class);

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $donnes = $request->only(['data.0'])['data'][0];
        $request->merge(['action' => 'create']);

        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'extras');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs libelle
        $editor->Fields(Field::inst('libelle')
            ->set(false)
            //        ->get(false)

            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs types
        $editor->Fields(Field::inst('types')
            ->set(false)
            //        ->get(false)

            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


//        dd($donnes);
//        if(!empty($donnes))

//        dd($donnes);
        if (!empty($donnes) && $donnes['types'] == "TEXT") {
            // le champs text
            $editor->Fields(Field::inst('text')
                ->set(false)
                //        ->get(false)

                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );
        }
        if (!empty($donnes) && $donnes['types'] == "FILES") {
            // le champs files
            $editor->Fields(Field::inst('files')
                ->set(false)
                //        ->get(false)

                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );
        }
        if (!empty($donnes) && $donnes['types'] == "TEXTAREA") {
            // le champs textarea
            $editor->Fields(Field::inst('textarea')
                ->set(false)
                //        ->get(false)

                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );
        }
        if (!empty($donnes) && $donnes['types'] == "DATETIME") {
            // le champs datetime
            $editor->Fields(Field::inst('datetime')
                ->set(false)
                //        ->get(false)

                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );
        }


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


        $Extras->libelle = $donnes['libelle'];


        $Extras->types = $donnes['types'];


        $Extras->text = $donnes['text'] ?? "";


        $Extras->files = $donnes['files'] ?? "";


        $Extras->textarea = $donnes['textarea'] ?? "";


        $Extras->datetime = $donnes['datetime'] ?? "";


        $Extras->save();


        $Extras = $Extras::find($Extras->id);
        $response = $Extras->toArray();

        $response['PipelinesAvf'] = $Extras->PipelinesAvf;

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
// $this->ExtrasRepository->store($validated);

        $vue = view('/content/base/Extras.post_extras', ['editorData' => $request->All()]);
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

        $this->ExtrasRepository->show($id);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return  Response
     */

    public function update(Request $request, ExtrasModel $Extras)
    {

        $Permission = Gate::inspect('update', $Extras);
        $donnes = $request->input()['data']['row_' . (is_array($Extras->id) ? $Extras->id[0] : $Extras->id)];

        $request->merge(['action' => 'edit']);
        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'extras');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs libelle
        $editor->Fields(Field::inst('libelle')
            ->set(false)
            //        ->get(false)

            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs types
        $editor->Fields(Field::inst('types')
            ->set(false)
            //        ->get(false)

            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


//        dd($donnes);
        if (!empty($donnes) && $donnes['types'] == "TEXT") {
            // le champs text
            $editor->Fields(Field::inst('text')
                ->set(false)
                //        ->get(false)

                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );
        }
        if (!empty($donnes) && $donnes['types'] == "FILES") {
            // le champs files
            $editor->Fields(Field::inst('files')
                ->set(false)
                //        ->get(false)

                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );
        }
        if (!empty($donnes) && $donnes['types'] == "TEXTAREA") {
            // le champs textarea
            $editor->Fields(Field::inst('textarea')
                ->set(false)
                //        ->get(false)

                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );
        }
        if (!empty($donnes) && $donnes['types'] == "DATETIME") {
            // le champs datetime
            $editor->Fields(Field::inst('datetime')
                ->set(false)
                //        ->get(false)

                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );
        }


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


        $Extras->libelle = $donnes['libelle'];


        $Extras->types = $donnes['types'];


        $Extras->text = $donnes['text'] ?? "";


        $Extras->files = $donnes['files'] ?? [];


        $Extras->textarea = $donnes['textarea'] ?? "";


        $Extras->datetime = $donnes['datetime'] ?? "";


        $Extras->save();

        $response = $Extras
            ->toArray();
        $response['PipelinesAvf'] = $Extras->PipelinesAvf;
        $donnees['data'][] = $response;


        return response()->json($donnees, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return  Response
     */
    public function delete(Request $request, ExtrasModel $Extras)
    {
        $donnes = $request->input()['data']['row_' . (is_array($Extras->id) ? $Extras->id[0] : $Extras->id)];

        $Permission = Gate::inspect('delete', $Extras);

        if ($Permission->allowed()) {
            $Extras->delete();
        }
        $data = [];

        return response()->json($data, 200);


    }


}
