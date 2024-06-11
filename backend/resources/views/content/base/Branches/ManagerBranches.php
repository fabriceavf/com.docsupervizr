<?php

use App\Models\prod\BranchesModel;
use App\Models\prod\DispositionsModel;
use DataTables\GetDb;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;


// use App\Repository\prod\BranchesRepository;


$db = GetDb::getDatabase();

class Managerbranches
{


    /**
     * Display a listing of the resource.
     *
     * @return  Response
     */
    public function index(Request $request)
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
        $branches_disposition = DispositionsModel::where(['table' => 'branches'])->first();


        if ($request->has('disposition')) {
            $branches_disposition->disposition = $request->get('disposition');
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


        $vue = ['pageConfigs' => $pageConfig, 'branches_disposition' => $branches_disposition, 'preselect' => $new, 'options' => $donnees ?? [], 'options' => $donnees ?? [],
        ];
        return $vue;
    }

    public function index_two(Request $request, $key, $val)
    {

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
        $branches_disposition = DispositionsModel::where(['table' => 'branches'])->first();


        if ($request->has('disposition')) {
            $branches_disposition->disposition = $request->get('disposition');
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


        $vue = ['pageConfigs' => $pageConfig, 'branches_disposition' => $branches_disposition, 'preselect' => $new, 'options' => $donnees ?? [],
        ];
        return $vue;
    }

    public function index_one(Request $request, BranchesModel $Branches)
    {

        $branches_disposition = DispositionsModel::where(['table' => 'branches'])->first();


        if ($request->has('disposition')) {
            $branches_disposition->disposition = $request->get('disposition');
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


        $vue = [
            'pageConfigs' => $pageConfig,
            'editorData' => $request->All(),
            'Branches' => $Branches,
            'branches_disposition' => $branches_disposition
            , 'preselect' => $new, 'options' => $donnees ?? [],
        ];


        return $vue;

    }


}



