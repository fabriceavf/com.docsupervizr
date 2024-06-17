<?php 
namespace App\Http\Controllers\WEB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
// use App\Repository\prod\UsersRepository;
use App\Models\prod\User;

    use App\Models\prod\GroupesModel;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

ini_set('memory_limit', '8192M');
ini_set('max_execution_time', '300');

            use App\Models\prod\Balise;
                use App\Models\prod\Categorie;
                use App\Models\prod\Contrat;
                use App\Models\prod\Direction;
                use App\Models\prod\Echelon;
                use App\Models\prod\Fonction;
                use App\Models\prod\Matrimoniale;
                use App\Models\prod\Nationalite;
                use App\Models\prod\Poste;
                use App\Models\prod\Role;
                use App\Models\prod\Sexe;
                use App\Models\prod\Site;
                use App\Models\prod\Situation;
                use App\Models\prod\Type;
                use App\Models\prod\Typeseffectif;
                    use App\Models\prod\Ville;
                use App\Models\prod\Zone;
    
class UsersControllerWeb extends Controller
{

private $UsersRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\UsersRepository $UsersRepository
* @param int $id
*/
public function __construct(Request $request)
{
if (!$request->has('__internalId__')) {
$id="Users_".Str::uuid()->toString().'_unique';
$id=Str::replace('-','_',$id);

$request->merge(['__internalId__' =>$id ]);
}

}


/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Navigation vers page users Reussi',
'ip' =>'Non defini',
'pays' =>'Non defini',
'ville' => 'Non defini',
'navigateur' => $request->header('User-Agent'),
'created_at' => now(),
]);

}catch (\Throwable){

}

// La securite qui empeiche darriver sur cette sans avoir une signature valide
if (
true
 && ! $request->hasValidSignature()
&& !Auth::user()->can("Voir les users")
){
abort(401);
}

$params=collect($request->all());
$params=$params->filter(function ($value, $key) {
//            dd($key);
return Str::is('__key__*',$key);
})->toArray();
$new=[];
foreach ($params as $key=>$par){
$new[Str::replace('__key__',"",$key)]=$par;
}






$pageConfig = [
 'mainLayoutType' => 'vertical',
'type' => 'admin',
'menu_type' => 'admin',
'is_navbar' => $request->has('is_navbar')?$request->get('is_navbar'):true,
'footer' => $request->has('footer')?$request->get('footer'):true,
'showMenu' =>$request->has('showMenu')?$request->get('showMenu'):true,
'pageHeader' =>$request->has('pageHeader')?$request->get('pageHeader'):true,

];



$vue = view('/content/Users.Users', ['pageConfigs' => $pageConfig, 'menu' => $this->menu,'preselect'=>$new,'options'=>$donnees??[],'options'=>$donnees??[],

]);
return response($vue, 200);
}
public function index_component(Request $request)
{

// La securite qui empeiche darriver sur cette sans avoir une signature valide
if (! $request->hasValidSignature() && !Auth::user()->can("Voir les users")) {
abort(401);
}

$params=collect($request->all());
$params=$params->filter(function ($value, $key) {
//            dd($key);
return Str::is('__key__*',$key);
})->toArray();
$new=[];
foreach ($params as $key=>$par){
$new[Str::replace('__key__',"",$key)]=$par;
}


if($request->has('disposition')){
$users_disposition->disposition=$request->get('disposition');
}




























































































































































        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





$pageConfig = [
 'mainLayoutType' => 'vertical',
'type' => 'admin',
'menu_type' => 'admin',
'is_navbar' => $request->has('is_navbar')?$request->get('is_navbar'):true,
'footer' => $request->has('footer')?$request->get('footer'):true,
'showMenu' =>$request->has('showMenu')?$request->get('showMenu'):true,
'pageHeader' =>$request->has('pageHeader')?$request->get('pageHeader'):true,

];



$vue = view('/content/Users.users_component', ['pageConfigs' => $pageConfig, 'menu' => $this->menu,'users_disposition'=>$users_disposition,'preselect'=>$new,'options'=>$donnees??[],'options'=>$donnees??[],

    'abscences_disposition'=>$abscences_disposition,


    'agentsrapports_disposition'=>$agentsrapports_disposition,


    'assignations_disposition'=>$assignations_disposition,


    'conges_disposition'=>$conges_disposition,


    'cruds_disposition'=>$cruds_disposition,


    'historiquemodelslistings_disposition'=>$historiquemodelslistings_disposition,


    'horaireagents_disposition'=>$horaireagents_disposition,


    'identifications_disposition'=>$identifications_disposition,


    'listingsetats_disposition'=>$listingsetats_disposition,


    'logs_disposition'=>$logs_disposition,


    'modelslistings_disposition'=>$modelslistings_disposition,


    'oauth_access_tokens_disposition'=>$oauth_access_tokens_disposition,


    'oauth_auth_codes_disposition'=>$oauth_auth_codes_disposition,


    'oauth_clients_disposition'=>$oauth_clients_disposition,


    'perms_disposition'=>$perms_disposition,


    'pointages_disposition'=>$pointages_disposition,


    'presences_disposition'=>$presences_disposition,


    'programmations_disposition'=>$programmations_disposition,


    'programmes_disposition'=>$programmes_disposition,


    'statszones_disposition'=>$statszones_disposition,


    'surveillances_disposition'=>$surveillances_disposition,


    'users_disposition'=>$users_disposition,


    'userszones_disposition'=>$userszones_disposition,


    'ventilations_disposition'=>$ventilations_disposition,


    'works_disposition'=>$works_disposition,

]);
return response($vue, 200);
}
/**
* Display a listing of the resource.
*
* @return  \Illuminate\Http\Response
*/
public function index_two(Request $request,$key,$val)
{
// La securite qui empeiche darriver sur cette sans avoir une signature valide
if (! $request->hasValidSignature() && !Auth::user()->can("Voir les users")) {
abort(401);
}
$params=collect($request->all());
$params=$params->filter(function ($value, $k) {
//            dd($k);
return Str::is('__key__*',$k);
})->toArray();
$new=[];
foreach ($params as $k=>$par){
$new[Str::replace('__key__',"",$k)]=$par;
}
// some additional logic or checking
$request->request->add([
'pkey' => $key,
'pval' => $val,
]);


if($request->has('disposition')){
$users_disposition->disposition=$request->get('disposition');
}

























































































































































$pageConfig = [
 'mainLayoutType' => 'vertical',
'type' => 'admin',
'menu_type' => 'admin',
'is_navbar' => $request->has('is_navbar')?$request->get('is_navbar'):true,
'footer' => $request->has('footer')?$request->get('footer'):true,
'showMenu' =>$request->has('showMenu')?$request->get('showMenu'):true,
'pageHeader' =>$request->has('pageHeader')?$request->get('pageHeader'):true,

];



        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            




$vue = view('/content/Users.Users', ['pageConfigs' => $pageConfig, 'menu' => $this->menu,'users_disposition'=>$users_disposition,'preselect'=>$new,'options'=>$donnees??[],

    'abscences_disposition'=>$abscences_disposition,


    'agentsrapports_disposition'=>$agentsrapports_disposition,


    'assignations_disposition'=>$assignations_disposition,


    'conges_disposition'=>$conges_disposition,


    'cruds_disposition'=>$cruds_disposition,


    'historiquemodelslistings_disposition'=>$historiquemodelslistings_disposition,


    'horaireagents_disposition'=>$horaireagents_disposition,


    'identifications_disposition'=>$identifications_disposition,


    'listingsetats_disposition'=>$listingsetats_disposition,


    'logs_disposition'=>$logs_disposition,


    'modelslistings_disposition'=>$modelslistings_disposition,


    'oauth_access_tokens_disposition'=>$oauth_access_tokens_disposition,


    'oauth_auth_codes_disposition'=>$oauth_auth_codes_disposition,


    'oauth_clients_disposition'=>$oauth_clients_disposition,


    'perms_disposition'=>$perms_disposition,


    'pointages_disposition'=>$pointages_disposition,


    'presences_disposition'=>$presences_disposition,


    'programmations_disposition'=>$programmations_disposition,


    'programmes_disposition'=>$programmes_disposition,


    'statszones_disposition'=>$statszones_disposition,


    'surveillances_disposition'=>$surveillances_disposition,


    'users_disposition'=>$users_disposition,


    'userszones_disposition'=>$userszones_disposition,


    'ventilations_disposition'=>$ventilations_disposition,


    'works_disposition'=>$works_disposition,

]);
return response($vue, 200);
}

/**
* Show the form for creating a new resource.
* Return .
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/

public function index_one(Request $request, User $Users)
{



if($request->has('disposition')){
$users_disposition->disposition=$request->get('disposition');
}









    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    
$params=collect($request->all());
$params=$params->filter(function ($value, $key) {
//            dd($key);
return Str::is('__key__*',$key);
})->toArray();
$new=[];
foreach ($params as $key=>$par){
$new[Str::replace('__key__',"",$key)]=$par;
}

$pageConfig = [
 'mainLayoutType' => 'vertical',
'type' => 'admin',
'menu_type' => 'admin',
'is_navbar' => $request->has('is_navbar')?$request->get('is_navbar'):true,
'footer' => $request->has('footer')?$request->get('footer'):true,
'showMenu' =>$request->has('showMenu')?$request->get('showMenu'):true,
'pageHeader' =>$request->has('pageHeader')?$request->get('pageHeader'):true,

];
// La securite qui empeiche darriver sur cette sans avoir une signature valide
if (! $request->hasValidSignature()) {
abort(401);
}







        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            






$vue = view('/content/Users.users_one', [
'pageConfigs' => $pageConfig,
'editorData' => $request->All(),
'Users' => $Users,
'users_disposition'=>$users_disposition
,'preselect'=>$new,'options'=>$donnees??[],

    'abscences_disposition'=>$abscences_disposition,


    'agentsrapports_disposition'=>$agentsrapports_disposition,


    'assignations_disposition'=>$assignations_disposition,


    'conges_disposition'=>$conges_disposition,


    'cruds_disposition'=>$cruds_disposition,


    'historiquemodelslistings_disposition'=>$historiquemodelslistings_disposition,


    'horaireagents_disposition'=>$horaireagents_disposition,


    'identifications_disposition'=>$identifications_disposition,


    'listingsetats_disposition'=>$listingsetats_disposition,


    'logs_disposition'=>$logs_disposition,


    'modelslistings_disposition'=>$modelslistings_disposition,


    'oauth_access_tokens_disposition'=>$oauth_access_tokens_disposition,


    'oauth_auth_codes_disposition'=>$oauth_auth_codes_disposition,


    'oauth_clients_disposition'=>$oauth_clients_disposition,


    'perms_disposition'=>$perms_disposition,


    'pointages_disposition'=>$pointages_disposition,


    'presences_disposition'=>$presences_disposition,


    'programmations_disposition'=>$programmations_disposition,


    'programmes_disposition'=>$programmes_disposition,


    'statszones_disposition'=>$statszones_disposition,


    'surveillances_disposition'=>$surveillances_disposition,


    'users_disposition'=>$users_disposition,


    'userszones_disposition'=>$userszones_disposition,


    'ventilations_disposition'=>$ventilations_disposition,


    'works_disposition'=>$works_disposition,

]);



return response($vue, 200);

}
public function index_one_component(Request $request, User $Users)
{



if($request->has('disposition')){
$users_disposition->disposition=$request->get('disposition');
}









    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    
$params=collect($request->all());
$params=$params->filter(function ($value, $key) {
//            dd($key);
return Str::is('__key__*',$key);
})->toArray();
$new=[];
foreach ($params as $key=>$par){
$new[Str::replace('__key__',"",$key)]=$par;
}

$pageConfig = [
 'mainLayoutType' => 'vertical',
'type' => 'admin',
'menu_type' => 'admin',
'is_navbar' => $request->has('is_navbar')?$request->get('is_navbar'):true,
'footer' => $request->has('footer')?$request->get('footer'):true,
'showMenu' =>$request->has('showMenu')?$request->get('showMenu'):true,
'pageHeader' =>$request->has('pageHeader')?$request->get('pageHeader'):true,

];
// La securite qui empeiche darriver sur cette sans avoir une signature valide
if (! $request->hasValidSignature()) {
abort(401);
}







        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            






$vue = view('/content/Users.users_one_component', [
'pageConfigs' => $pageConfig,
'editorData' => $request->All(),
'Users' => $Users,
'users_disposition'=>$users_disposition
,'preselect'=>$new,'options'=>$donnees??[],

    'abscences_disposition'=>$abscences_disposition,


    'agentsrapports_disposition'=>$agentsrapports_disposition,


    'assignations_disposition'=>$assignations_disposition,


    'conges_disposition'=>$conges_disposition,


    'cruds_disposition'=>$cruds_disposition,


    'historiquemodelslistings_disposition'=>$historiquemodelslistings_disposition,


    'horaireagents_disposition'=>$horaireagents_disposition,


    'identifications_disposition'=>$identifications_disposition,


    'listingsetats_disposition'=>$listingsetats_disposition,


    'logs_disposition'=>$logs_disposition,


    'modelslistings_disposition'=>$modelslistings_disposition,


    'oauth_access_tokens_disposition'=>$oauth_access_tokens_disposition,


    'oauth_auth_codes_disposition'=>$oauth_auth_codes_disposition,


    'oauth_clients_disposition'=>$oauth_clients_disposition,


    'perms_disposition'=>$perms_disposition,


    'pointages_disposition'=>$pointages_disposition,


    'presences_disposition'=>$presences_disposition,


    'programmations_disposition'=>$programmations_disposition,


    'programmes_disposition'=>$programmes_disposition,


    'statszones_disposition'=>$statszones_disposition,


    'surveillances_disposition'=>$surveillances_disposition,


    'users_disposition'=>$users_disposition,


    'userszones_disposition'=>$userszones_disposition,


    'ventilations_disposition'=>$ventilations_disposition,


    'works_disposition'=>$works_disposition,

]);



return response($vue, 200);

}
/**
* Show the form for creating a new resource.
* Return .
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/

public function show_impression(Request $request, User $Users)
{
// La securite qui empeiche darriver sur cette sans avoir une signature valide
if (! $request->hasValidSignature()) {
abort(401);
}



if($request->has('disposition')){
$users_disposition->disposition=$request->get('disposition');
}









    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    







    
$params=collect($request->all());
$params=$params->filter(function ($value, $key) {
//            dd($key);
return Str::is('__key__*',$key);
})->toArray();
$new=[];
foreach ($params as $key=>$par){
$new[Str::replace('__key__',"",$key)]=$par;
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









$vue = view('/content/Users.impression', [
'pageConfigs' => $pageConfig,
'editorData' => $request->All(),
'Users' => $Users,
'users_disposition'=>$users_disposition
,'preselect'=>$new,'options'=>$donnees??[],

    'abscences_disposition'=>$abscences_disposition,


    'agentsrapports_disposition'=>$agentsrapports_disposition,


    'assignations_disposition'=>$assignations_disposition,


    'conges_disposition'=>$conges_disposition,


    'cruds_disposition'=>$cruds_disposition,


    'historiquemodelslistings_disposition'=>$historiquemodelslistings_disposition,


    'horaireagents_disposition'=>$horaireagents_disposition,


    'identifications_disposition'=>$identifications_disposition,


    'listingsetats_disposition'=>$listingsetats_disposition,


    'logs_disposition'=>$logs_disposition,


    'modelslistings_disposition'=>$modelslistings_disposition,


    'oauth_access_tokens_disposition'=>$oauth_access_tokens_disposition,


    'oauth_auth_codes_disposition'=>$oauth_auth_codes_disposition,


    'oauth_clients_disposition'=>$oauth_clients_disposition,


    'perms_disposition'=>$perms_disposition,


    'pointages_disposition'=>$pointages_disposition,


    'presences_disposition'=>$presences_disposition,


    'programmations_disposition'=>$programmations_disposition,


    'programmes_disposition'=>$programmes_disposition,


    'statszones_disposition'=>$statszones_disposition,


    'surveillances_disposition'=>$surveillances_disposition,


    'users_disposition'=>$users_disposition,


    'userszones_disposition'=>$userszones_disposition,


    'ventilations_disposition'=>$ventilations_disposition,


    'works_disposition'=>$works_disposition,

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

$this->UsersRepository->show($id);

}


}



