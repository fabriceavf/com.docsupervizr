<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\prod\Actif;
use App\Models\prod\Balise;
use App\Models\prod\Categorie;
use App\Models\prod\Client;
use App\Models\prod\Contrat;
use App\Models\prod\Direction;
use App\Models\prod\Echelon;
use App\Models\prod\Faction;
use App\Models\prod\Fonction;
use App\Models\prod\GroupesModel;
use App\Models\prod\Matrimoniale;
use App\Models\prod\Nationalite;
use App\Models\prod\Online;
use App\Models\prod\Pointeuse;
use App\Models\prod\Poste;
use App\Models\prod\Sexe;
use App\Models\prod\Site;
use App\Models\prod\Situation;
use App\Models\prod\UsersModel;
use App\Models\prod\ViewsTransactionac94222a67b54b73acb390e50444fd7d;
use App\Models\prod\Ville;
use App\Models\prod\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


// use App\Repository\prod\ViewsTransactionsac94222a67b54b73acb390e50444fd7dRepository;


ini_set('memory_limit', '8192M');
ini_set('max_execution_time', '300');

class ViewsTransactionsac94222a67b54b73acb390e50444fd7dControllerWeb extends Controller
{

    private $ViewsTransactionsac94222a67b54b73acb390e50444fd7dRepository;
    private $menu;


    /**
     * Return .
     * @param \Illuminate\Http\Request $request
     * @param App\Repository\prod\ViewsTransactionsac94222a67b54b73acb390e50444fd7dRepository $ViewsTransactionsac94222a67b54b73acb390e50444fd7dRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {
        if (!$request->has('__internalId__')) {
            $id = "ViewsTransactionsac94222a67b54b73acb390e50444fd7d_" . Str::uuid()->toString() . '_unique';
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
            && !Auth::user()->can("Voir les ViewsTransactionsac94222a67b54b73acb390e50444fd7d")
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


        $vue = view('/content/ViewsTransactionsac94222a67b54b73acb390e50444fd7d.ViewsTransactionsac94222a67b54b73acb390e50444fd7d', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'preselect' => $new, 'options' => $donnees ?? [], 'options' => $donnees ?? [],

        ]);
        return response($vue, 200);
    }

    public function index_component(Request $request)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature() && !Auth::user()->can("Voir les ViewsTransactionsac94222a67b54b73acb390e50444fd7d")) {
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
            $ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition->disposition = $request->get('disposition');
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


        $vue = view('/content/ViewsTransactionsac94222a67b54b73acb390e50444fd7d.ViewsTransactionsac94222a67b54b73acb390e50444fd7d_component', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition' => $ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition, 'preselect' => $new, 'options' => $donnees ?? [], 'options' => $donnees ?? [],
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
        if (!$request->hasValidSignature() && !Auth::user()->can("Voir les ViewsTransactionsac94222a67b54b73acb390e50444fd7d")) {
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
            $ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition->disposition = $request->get('disposition');
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


        $vue = view('/content/ViewsTransactionsac94222a67b54b73acb390e50444fd7d.ViewsTransactionsac94222a67b54b73acb390e50444fd7d', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition' => $ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition, 'preselect' => $new, 'options' => $donnees ?? [],
        ]);
        return response($vue, 200);
    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function index_one(Request $request, ViewsTransactionac94222a67b54b73acb390e50444fd7d $ViewsTransactionsac94222a67b54b73acb390e50444fd7d)
    {


        if ($request->has('disposition')) {
            $ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition->disposition = $request->get('disposition');
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


        $vue = view('/content/ViewsTransactionsac94222a67b54b73acb390e50444fd7d.ViewsTransactionsac94222a67b54b73acb390e50444fd7d_one', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'ViewsTransactionsac94222a67b54b73acb390e50444fd7d' => $ViewsTransactionsac94222a67b54b73acb390e50444fd7d,
            'ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition' => $ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition
            , 'preselect' => $new, 'options' => $donnees ?? [],
        ]);


        return response($vue, 200);

    }

    public function index_one_component(Request $request, ViewsTransactionac94222a67b54b73acb390e50444fd7d $ViewsTransactionsac94222a67b54b73acb390e50444fd7d)
    {


        if ($request->has('disposition')) {
            $ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition->disposition = $request->get('disposition');
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


        $vue = view('/content/ViewsTransactionsac94222a67b54b73acb390e50444fd7d.ViewsTransactionsac94222a67b54b73acb390e50444fd7d_one_component', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'ViewsTransactionsac94222a67b54b73acb390e50444fd7d' => $ViewsTransactionsac94222a67b54b73acb390e50444fd7d,
            'ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition' => $ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition
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

    public function show_impression(Request $request, ViewsTransactionac94222a67b54b73acb390e50444fd7d $ViewsTransactionsac94222a67b54b73acb390e50444fd7d)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }


        if ($request->has('disposition')) {
            $ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition->disposition = $request->get('disposition');
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


        $vue = view('/content/ViewsTransactionsac94222a67b54b73acb390e50444fd7d.impression', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'ViewsTransactionsac94222a67b54b73acb390e50444fd7d' => $ViewsTransactionsac94222a67b54b73acb390e50444fd7d,
            'ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition' => $ViewsTransactionsac94222a67b54b73acb390e50444fd7d_disposition
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

        $this->ViewsTransactionsac94222a67b54b73acb390e50444fd7dRepository->show($id);

    }


}



