<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\production\ActivitesModel;
use App\Models\production\ProjetsModel;
use App\Models\production\UsersModel;
use App\Models\User;
use App\Repository\production\ActivitesRepository;
use Auth;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class InscriptionsControllerWeb extends Controller
{


    private $validateField = [

        'email',
        'password',
    ];
    private $validateRegles = [
        'name' => 'required',
        'prenoms' => 'required',
        'contact' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'password1' => 'required',
    ];
    private $validateMessages = [
        'name.required' => 'Cette donnee est requis',
        'prenoms.required' => 'Cette donnee est requis',
        'contact.required' => 'Cette donnee est requis',
        'contact.unique' => 'Cett numero est deja utiliser ',
        'email.required' => 'Veuillez entre votre email',
        'email.unique' => 'Cette adresse email est dej utiliser',
        'password.required' => 'Veuillez saisir votre mot de passe ',
        'password1.required' => 'Veuillez saisir votre mot de passe ',
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


    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return Response
     */

    public function create(Request $request, ActivitesModel $Activites)
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
            if ($donnes['password'] != $donnes['password1']) {


                $dat['name'] = 'password';
                $dat['status'] = "Les mot de passe ne concorde pas";
                $data['fieldErrors'][] = $dat;
                $dat['name'] = 'password1';
                $dat['status'] = "Les mot de passe ne concorde pas";
                $data['fieldErrors'][] = $dat;

            } else {
                $users = new User();
                $users->name = $donnes['name'];
                $users->prenoms = $donnes['prenoms'];
                $users->contact = $donnes['contact'];
                $users->email = $donnes['email'];
                $users->password = $donnes['password'];
                $users->add_by = 0;
                $users->save();
                Auth::login($users);

                $data['data']['url'] = route('Users_web_index_one', ['Users' => $users->id]);

            }
        }


        return response()->json($data, 200);


    }


    public function apiinscriptions(Request $request, User $Users)
    {
        $Permission = Gate::inspect('create', UsersModel::class);
        $request->merge(['action' => 'create']);


        $donnes = $request->only(['data.0'])['data'][0];
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
            ->validator(Validate::unique(ValidateOptions::inst()->message("Cet email est deja utiliser")))


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

//            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs apiclient
        $editor->Fields(Field::inst('apiclient')
            ->set(false)
        //        ->get(false)

//            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs status
        $editor->Fields(Field::inst('statut')
            ->set(false)
        //        ->get(false)

//            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs extra_attributes
        $editor->Fields(Field::inst('extra_attributes')
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


        $Users->name = $donnes['name'];


        $Users->email = $donnes['email'];


        $Users->password = Hash::make($donnes['password']);


        $Users->prenoms = $donnes['prenoms'];


        $Users->contact = $donnes['contact'];


        $Users->email_interne = "apiclient_" . $donnes['email'];


        $Users->apiclient = 1;


        $Users->statut = 1;


        $Users->save();


        $Users = $Users::find($Users->id);
        $response = $Users->toArray();
        $response['token'] = $Users->createToken('myapp')->accessToken;
        $donnees['data'][] = $response;


        return response()->json($donnees, 200);
    }


}



