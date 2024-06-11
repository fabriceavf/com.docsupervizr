<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\prod\GroupesModel;
use App\Models\prod\USERINFO;
use App\Models\prod\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


// use App\Repository\prod\USERINFORepository;


ini_set('memory_limit', '8192M');
ini_set('max_execution_time', '300');


class USERINFOControllerWeb extends Controller
{

    private $USERINFORepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\USERINFORepository $USERINFORepository
     * @param int $id
     */
    public function __construct(Request $request)
    {
        if (!$request->has('__internalId__')) {
            $id = "USERINFO_" . Str::uuid()->toString() . '_unique';
            $id = Str::replace('-', '_', $id);

            $request->merge(['__internalId__' => $id]);
        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (
            true
            && !$request->hasValidSignature()
            && !Auth::user()->can("Voir les USERINFO")
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


        $vue = view('/content/USERINFO.USERINFO', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'preselect' => $new, 'options' => $donnees ?? [], 'options' => $donnees ?? [],

        ]);
        return response($vue, 200);
    }

    public function index_component(Request $request)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature() && !Auth::user()->can("Voir les USERINFO")) {
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
            $USERINFO_disposition->disposition = $request->get('disposition');
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


        $vue = view('/content/USERINFO.USERINFO_component', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'USERINFO_disposition' => $USERINFO_disposition, 'preselect' => $new, 'options' => $donnees ?? [], 'options' => $donnees ?? [],
        ]);
        return response($vue, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return  Response
     */
    public function index_two(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature() && !Auth::user()->can("Voir les USERINFO")) {
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
            $USERINFO_disposition->disposition = $request->get('disposition');
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


        $vue = view('/content/USERINFO.USERINFO', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'USERINFO_disposition' => $USERINFO_disposition, 'preselect' => $new, 'options' => $donnees ?? [],
        ]);
        return response($vue, 200);
    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return Response
     */

    public function index_one(Request $request, USERINFO $USERINFO)
    {


        if ($request->has('disposition')) {
            $USERINFO_disposition->disposition = $request->get('disposition');
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


        $vue = view('/content/USERINFO.USERINFO_one', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'USERINFO' => $USERINFO,
            'USERINFO_disposition' => $USERINFO_disposition
            , 'preselect' => $new, 'options' => $donnees ?? [],
        ]);


        return response($vue, 200);

    }

    public function index_one_component(Request $request, USERINFO $USERINFO)
    {


        if ($request->has('disposition')) {
            $USERINFO_disposition->disposition = $request->get('disposition');
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


        $vue = view('/content/USERINFO.USERINFO_one_component', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'USERINFO' => $USERINFO,
            'USERINFO_disposition' => $USERINFO_disposition
            , 'preselect' => $new, 'options' => $donnees ?? [],
        ]);


        return response($vue, 200);

    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return Response
     */

    public function show_impression(Request $request, USERINFO $USERINFO)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }


        if ($request->has('disposition')) {
            $USERINFO_disposition->disposition = $request->get('disposition');
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


        $vue = view('/content/USERINFO.impression', [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'USERINFO' => $USERINFO,
            'USERINFO_disposition' => $USERINFO_disposition
            , 'preselect' => $new, 'options' => $donnees ?? [],
        ]);
        return response($vue, 200);

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
//

        $this->USERINFORepository->show($id);

    }


}



