<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\prod\Actif;
use App\Models\prod\Balise;
use App\Models\prod\Categorie;
use App\Models\prod\Contrat;
use App\Models\prod\Direction;
use App\Models\prod\Echelon;
use App\Models\prod\Faction;
use App\Models\prod\Fonction;
use App\Models\prod\GroupesModel;
use App\Models\prod\Matrimoniale;
use App\Models\prod\Nationalite;
use App\Models\prod\Online;
use App\Models\prod\Poste;
use App\Models\prod\Sexe;
use App\Models\prod\Site;
use App\Models\prod\Situation;
use App\Models\prod\Tables2a742596f0fe42ad8cd61eedf81eaa69Table;
use App\Models\prod\Type;
use App\Models\prod\UsersModel;
use App\Models\prod\Ville;
use App\Models\prod\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


// use App\Repository\prod\Tables2a742596f0fe42ad8cd61eedf81eaa69TablesRepository;


ini_set('memory_limit', '8192M');
ini_set('max_execution_time', '300');

class Tables2a742596f0fe42ad8cd61eedf81eaa69TablesControllerWeb extends Controller
{

    private $Tables2a742596f0fe42ad8cd61eedf81eaa69TablesRepository;
    private $menu;


    /**
     * Return .
     * @param \Illuminate\Http\Request $request
     * @param App\Repository\prod\Tables2a742596f0fe42ad8cd61eedf81eaa69TablesRepository $Tables2a742596f0fe42ad8cd61eedf81eaa69TablesRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {
        if (!$request->has('__internalId__')) {
            $id = "Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_" . Str::uuid()->toString() . '_unique';
            $id = Str::replace('-', '_', $id);

            $request->merge(['__internalId__' => $id]);
        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (
            true
            && !$request->hasValidSignature()
            && !Auth::user()->can("Voir les Tables2a742596f0fe42ad8cd61eedf81eaa69Tables")
        ) {
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


        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => $request->has('is_navbar') ? $request->get('is_navbar') : true,
            'footer' => $request->has('footer') ? $request->get('footer') : true,
            'showMenu' => $request->has('showMenu') ? $request->get('showMenu') : true,
            'pageHeader' => $request->has('pageHeader') ? $request->get('pageHeader') : true,

        ];


        $vue = view('/content/Tables2a742596f0fe42ad8cd61eedf81eaa69Tables.Tables2a742596f0fe42ad8cd61eedf81eaa69Tables', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'preselect' => $new, 'options' => $donnees ?? [], 'options' => $donnees ?? [],

        ]);
        return response($vue, 200);
    }

    public function index_component(Request $request)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature() && !Auth::user()->can("Voir les Tables2a742596f0fe42ad8cd61eedf81eaa69Tables")) {
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


        if ($request->has('disposition')) {
            $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition->disposition = $request->get('disposition');
        }


        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => $request->has('is_navbar') ? $request->get('is_navbar') : true,
            'footer' => $request->has('footer') ? $request->get('footer') : true,
            'showMenu' => $request->has('showMenu') ? $request->get('showMenu') : true,
            'pageHeader' => $request->has('pageHeader') ? $request->get('pageHeader') : true,

        ];


        $vue = view('/content/Tables2a742596f0fe42ad8cd61eedf81eaa69Tables.Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_component', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition' => $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition, 'preselect' => $new, 'options' => $donnees ?? [], 'options' => $donnees ?? [],
        ]);
        return response($vue, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index_two(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature() && !Auth::user()->can("Voir les Tables2a742596f0fe42ad8cd61eedf81eaa69Tables")) {
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


        if ($request->has('disposition')) {
            $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition->disposition = $request->get('disposition');
        }


        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => $request->has('is_navbar') ? $request->get('is_navbar') : true,
            'footer' => $request->has('footer') ? $request->get('footer') : true,
            'showMenu' => $request->has('showMenu') ? $request->get('showMenu') : true,
            'pageHeader' => $request->has('pageHeader') ? $request->get('pageHeader') : true,

        ];


        $vue = view('/content/Tables2a742596f0fe42ad8cd61eedf81eaa69Tables.Tables2a742596f0fe42ad8cd61eedf81eaa69Tables', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition' => $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition, 'preselect' => $new, 'options' => $donnees ?? [],
        ]);
        return response($vue, 200);
    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function index_one(Request $request, Tables2a742596f0fe42ad8cd61eedf81eaa69Table $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables)
    {


        if ($request->has('disposition')) {
            $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition->disposition = $request->get('disposition');
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

        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => $request->has('is_navbar') ? $request->get('is_navbar') : true,
            'footer' => $request->has('footer') ? $request->get('footer') : true,
            'showMenu' => $request->has('showMenu') ? $request->get('showMenu') : true,
            'pageHeader' => $request->has('pageHeader') ? $request->get('pageHeader') : true,

        ];
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }


        $vue = view('/content/Tables2a742596f0fe42ad8cd61eedf81eaa69Tables.Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_one', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'Tables2a742596f0fe42ad8cd61eedf81eaa69Tables' => $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables,
            'Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition' => $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition
            , 'preselect' => $new, 'options' => $donnees ?? [],
        ]);


        return response($vue, 200);

    }

    public function index_one_component(Request $request, Tables2a742596f0fe42ad8cd61eedf81eaa69Table $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables)
    {


        if ($request->has('disposition')) {
            $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition->disposition = $request->get('disposition');
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

        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => $request->has('is_navbar') ? $request->get('is_navbar') : true,
            'footer' => $request->has('footer') ? $request->get('footer') : true,
            'showMenu' => $request->has('showMenu') ? $request->get('showMenu') : true,
            'pageHeader' => $request->has('pageHeader') ? $request->get('pageHeader') : true,

        ];
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }


        $vue = view('/content/Tables2a742596f0fe42ad8cd61eedf81eaa69Tables.Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_one_component', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'Tables2a742596f0fe42ad8cd61eedf81eaa69Tables' => $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables,
            'Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition' => $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition
            , 'preselect' => $new, 'options' => $donnees ?? [],
        ]);


        return response($vue, 200);

    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function show_impression(Request $request, Tables2a742596f0fe42ad8cd61eedf81eaa69Table $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }


        if ($request->has('disposition')) {
            $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition->disposition = $request->get('disposition');
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

        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => false,
            'showMenu' => false,
            'footer' => false,
            'pageHeader' => false,
        ];


        $vue = view('/content/Tables2a742596f0fe42ad8cd61eedf81eaa69Tables.impression', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'Tables2a742596f0fe42ad8cd61eedf81eaa69Tables' => $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables,
            'Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition' => $Tables2a742596f0fe42ad8cd61eedf81eaa69Tables_disposition
            , 'preselect' => $new, 'options' => $donnees ?? [],
        ]);
        return response($vue, 200);

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//

        $this->Tables2a742596f0fe42ad8cd61eedf81eaa69TablesRepository->show($id);

    }


}



