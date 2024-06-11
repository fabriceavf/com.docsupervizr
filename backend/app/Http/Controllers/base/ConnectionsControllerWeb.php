<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\base\AuthentificationsModel;
use Auth;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use URL;

class ConnectionsControllerWeb extends Controller
{


    private $validateField = [

        'email',
        'password',
    ];
    private $validateRegles = [
        'email' => 'required',
        'password' => 'required'
    ];
    private $validateMessages = [
        'email.required' => 'Veuillez entre votre email',
        'password.required' => 'Veuillez saisir votre mot de passe ',
    ];


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\production\ActivitesRepository $ActivitesRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => false,
            'showMenu' => false,
            'pageHeader' => false,
        ];
//        $articles = ArticlesModel::all();
        $articles = collect([]);

        $vue = view('/content/base/connections.index', [
            'pageConfigs' => $pageConfig,
            'articles' => $articles,
        ]);
        return response($vue, 200);
    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return Response
     */

    public function create(Request $request)
    {
        $data = [];
        $donnes = $request->only(['data.0'])['data'][0];
        $extra_ereur = [];
        $validator = Validator::make($donnes, $this->validateRegles, $this->validateMessages);
        if ($validator->fails()) {
            $data = [];
            $data['data'] = [];
            $data['fieldErrors'] = [];
            foreach ($validator->errors()->toArray() as $key => $error) {
                $dat['name'] = $key;
                $dat['status'] = $error[0];
                $data['fieldErrors'][] = $dat;

            }
        } else {
            if (Auth::attempt([
                'email' => $donnes['email'],
                'password' => $donnes['password'],
                'deleted_at' => NULL,
            ])) {

//               $response= Http::get("https://ipinfo.io/".$request->ip()."json");
//               dd($response);

                $login = new AuthentificationsModel();
                $login->ip = $request->ip();
                $login->email = $donnes['email'];
                $login->operations = 'login';
                $login->lieu = $request->ip();
                $login->save();

                $data['data']['url'] = URL::signedRoute('Dashboard_web_index');
                $data['data']['id'] = Auth::id();
                $data['data']['noms'] = Auth::user()->name;
                $data['data']['prenoms'] = Auth::user()->prenoms;
                $data['data']['contact'] = Auth::user()->contact;


            } else {

                $dat['name'] = 'email';
                $dat['status'] = "Identifiant ou password incorrect";
                $data['fieldErrors'][] = $dat;
                $dat['name'] = 'password';
                $dat['status'] = "Identifiant ou password incorrect";
                $data['fieldErrors'][] = $dat;

            }
        }


        return response()->json($data, 200);


    }

    public function apiconnections(Request $request)
    {
        $donnes = $request->only(['data.0'])['data'][0];
//       print_r($donnes);
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


        // le champs label
        $editor->Fields(Field::inst('email')
            ->set(false)
            //        ->get(false)
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs introduction
        $editor->Fields(Field::inst('password')
            ->set(false)
            //        ->get(false)
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            ->validator(function ($data) use ($donnes) {

                $resultat = "Identififnat ou password incorrect";
                if (!empty($donnes['email']) && Auth::attempt([
                        'email' => $donnes['email'],
                        'password' => $donnes['password'],
                        'types' => 'Client api'])) {
                    $resultat = true;
                }
                return $resultat;
            })


        );


        $editor->process($request->all());

        $result = json_decode($editor->json(false), true);

        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
//    dd($result);

        } else if (!empty($result['error'])) {
            return response()->json($result, 200);
        } else {
            $token = Auth::guard('web')->user()->createToken('myapp')->accessToken;
            return response()->json(['token' => $token], 200);
        }


    }

    public function logout(Request $request)
    {

//        dd("on veut se deconnecter");

        $login = new AuthentificationsModel();
        $login->ip = $request->ip();
        $login->email = Auth::user()->email;
        $login->operations = 'logout';
        $login->lieu = $request->ip();
        $login->save();

        Auth::logout();
        return redirect()->route('Singleton_connections_web_index');


    }


}



