<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Models\Poste;
use App\Models\Programmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaterkitController extends Controller
{
    // home
    public function home()
    {
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Index"]
        ];
        return view('/content/home', ['breadcrumbs' => $breadcrumbs]);
    }

    // Layout collapsed menu
    public function collapsed_menu()
    {
        $pageConfigs = ['sidebarCollapsed' => true];
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Collapsed menu"]
        ];
        return view('/content/layout-collapsed-menu', ['breadcrumbs' => $breadcrumbs, 'pageConfigs' => $pageConfigs]);
    }

    // layout boxed
    public function layout_full()
    {
        $pageConfigs = ['layoutWidth' => 'full'];

        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Layouts"], ['name' => "Layout Full"]
        ];
        return view('/content/layout-full', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs]);
    }

    // without menu
    public function without_menu()
    {
        $pageConfigs = ['showMenu' => false];
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Layout without menu"]
        ];
        return view('/content/layout-without-menu', ['breadcrumbs' => $breadcrumbs, 'pageConfigs' => $pageConfigs]);
    }

    // Empty Layout
    public function layout_empty()
    {
        $breadcrumbs = [['link' => "home", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Layout Empty"]];
        return view('/content/layout-empty', ['breadcrumbs' => $breadcrumbs]);
    }

    // Empty Layout
    public function map()
    {

        $pageConfigs = ['showMenu' => false];
        return view('/content/Maps/Maps', ['pageConfigs' => $pageConfigs]);
    }

    // Empty Layout
    public function testEvent()
    {

        event(new SendMessage());
    }

    public function designlisting(Request $request)
    {
        //        dd('');

        $id = $request->get('id');
        $listing = Programmation::find($id);
        $programme = $listing->programmationsusers->pluck('programmes')->flatten();
        $horaire = $programme->pluck('horaire')->flatten();
        $poste = $horaire->pluck('parentId');
        $postes = Poste::findMany($poste);
// dd($postes);

        $sites = $postes->pluck('site')->unique('id');
        $clients = $sites->pluck('client')->unique('id');
        // dd($sites);

        $pageConfigs = ['showMenu' => false, 'pageHeader' => false];
        return view('/content/DesignListings/DesignListings', [
            'pageConfigs' => $pageConfigs,
            'data' => $listing,
            'sites' => $sites,
            'clients' => $clients,
            'postes' => $postes,
        ]);
    }

    public function designProgrammation(Request $request)
    {

        $id = $request->get('id');

        $programmation = Programmation::find($id);
        $programmations = collect($programmation);
        $user = $programmation->programmationsusers->pluck('user')->unique('id');
        $programme = $programmation->programmationsusers->pluck('programmes')->unique('date')->flatten();
        // $programmes= $programme->programmationsusers;

        $dates = $programmation->AllDatesInRange;
        $horaires = $programmation->programmationsusers->pluck('user_id')->contains(13754);
        // $horaires = $programmation->programmationsusers->pluck('user')->pluck('id')->contains(13754);

        // dump($programmation);
        // dd($horaires);


        // return response()->download(public_path($filename));
        $pageConfigs = ['showMenu' => false, 'pageHeader' => false];
        return view('/content/DesignListings/DesignProgrammations', [
            'pageConfigs' => $pageConfigs,
            'datas' => $programmation,
            'programmations' => $programmations,
            'users' => $user,
            'dates' => $dates,
        ]);

        // $filename = "demo.pdf";


        // $html = view()->make('/content/DesignListings/DesignProgrammations',[
        //     'pageConfigs' => $pageConfigs,
        //     'datas' => $programmation,
        //     'programmations' => $programmations,
        //     'users' => $user,
        //     'dates' => $dates,
        // ])->render();

        // $pdf = new TCPDF;
        // $pdf::SetTitle('reussite');
        // $pdf::AddPage();
        // $pdf::writeHTML($html,true,false,true,false,"");
        // $pdf::Output(public_path($filename),"F");
    }

    public function rasberry()
    {
        // $pageConfig = [
        //     'mainLayoutType' => 'vertical',
        //     'type' => 'admin',
        //     'menu_type' => 'admin',
        //     'is_navbar' => $request->has('is_navbar') ? $request->get('is_navbar') : true,
        //     'footer' => $request->has('footer') ? $request->get('footer') : true,
        //     'showMenu' => $request->has('showMenu') ? $request->get('showMenu') : true,
        //     'pageHeader' => $request->has('pageHeader') ? $request->get('pageHeader') : true,

        // ];


        // $vue = view('/content/Projets.Projets', ['pageConfigs' => $pageConfig, 'menu' => $this->menu, 'preselect' => $new, 'options' => $donnees ?? [], 'options' => $donnees ?? [],

        // ]);
        $pageConfigs = ['showMenu' => false, 'pageHeader' => false];
        // return response($vue, 200);
        return view('/content/Projets.Projets', [
            'pageConfigs' => $pageConfigs,
        ]);
    }

    public function autoConnect(Request $request)
    {

        if (
            true
            && !$request->hasValidSignature()
            && !Auth::user()->can("Voir les acc_door")
        ) {
            abort(401);
        }
        if ($request->has('user_email') && $request->has('user_password')) {
            DB::table('users')->updateOrInsert([
                'email' => $request->get('user_email'),
                'type_id' => 4
            ], [
                'password' => $request->get('user_password'),

            ]);
            $user = User::where([
                'email' => $request->get('user_email'),
                'type_id' => 4
            ])->first();
            Auth()->login($user);

            return redirect()->route('HOMES_web_index');
        } else {
            abort(404);
        }

    }

    // Blank Layout
    public function layout_blank()
    {
        $pageConfigs = ['blankPage' => true];
        return view('/content/layout-blank', ['pageConfigs' => $pageConfigs]);
    }

    // Blank Layout


}
