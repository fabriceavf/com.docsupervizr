<?php 
namespace App\Http\Controllers\WEB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
// use App\Repository\prod\Role_has_permissionsRepository;
use App\Models\prod\RoleHasPermission;

    use App\Models\prod\UsersModel;


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

            use App\Models\prod\Permission;
                use App\Models\prod\Role;
    
class Role_has_permissionsControllerWeb extends Controller
{

private $Role_has_permissionsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\Role_has_permissionsRepository $Role_has_permissionsRepository
* @param int $id
*/
public function __construct(Request $request)
{
if (!$request->has('__internalId__')) {
$id="Role_has_permissions_".Str::uuid()->toString().'_unique';
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
'action' => 'Navigation vers page role_has_permissions Reussi',
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
&& !Auth::user()->can("Voir les role_has_permissions")
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



$vue = view('/content/Role_has_permissions.Role_has_permissions', ['pageConfigs' => $pageConfig, 'menu' => $this->menu,'preselect'=>$new,'options'=>$donnees??[],'options'=>$donnees??[],

]);
return response($vue, 200);
}
public function index_component(Request $request)
{

// La securite qui empeiche darriver sur cette sans avoir une signature valide
if (! $request->hasValidSignature() && !Auth::user()->can("Voir les role_has_permissions")) {
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
$role_has_permissions_disposition->disposition=$request->get('disposition');
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



$vue = view('/content/Role_has_permissions.role_has_permissions_component', ['pageConfigs' => $pageConfig, 'menu' => $this->menu,'role_has_permissions_disposition'=>$role_has_permissions_disposition,'preselect'=>$new,'options'=>$donnees??[],'options'=>$donnees??[],
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
if (! $request->hasValidSignature() && !Auth::user()->can("Voir les role_has_permissions")) {
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
$role_has_permissions_disposition->disposition=$request->get('disposition');
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



        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            




$vue = view('/content/Role_has_permissions.Role_has_permissions', ['pageConfigs' => $pageConfig, 'menu' => $this->menu,'role_has_permissions_disposition'=>$role_has_permissions_disposition,'preselect'=>$new,'options'=>$donnees??[],
]);
return response($vue, 200);
}

/**
* Show the form for creating a new resource.
* Return .
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/

public function index_one(Request $request, RoleHasPermission $Role_has_permissions)
{



if($request->has('disposition')){
$role_has_permissions_disposition->disposition=$request->get('disposition');
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







        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            






$vue = view('/content/Role_has_permissions.role_has_permissions_one', [
'pageConfigs' => $pageConfig,
'editorData' => $request->All(),
'Role_has_permissions' => $Role_has_permissions,
'role_has_permissions_disposition'=>$role_has_permissions_disposition
,'preselect'=>$new,'options'=>$donnees??[],
]);



return response($vue, 200);

}
public function index_one_component(Request $request, RoleHasPermission $Role_has_permissions)
{



if($request->has('disposition')){
$role_has_permissions_disposition->disposition=$request->get('disposition');
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







        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            





        

            






$vue = view('/content/Role_has_permissions.role_has_permissions_one_component', [
'pageConfigs' => $pageConfig,
'editorData' => $request->All(),
'Role_has_permissions' => $Role_has_permissions,
'role_has_permissions_disposition'=>$role_has_permissions_disposition
,'preselect'=>$new,'options'=>$donnees??[],
]);



return response($vue, 200);

}
/**
* Show the form for creating a new resource.
* Return .
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/

public function show_impression(Request $request, RoleHasPermission $Role_has_permissions)
{
// La securite qui empeiche darriver sur cette sans avoir une signature valide
if (! $request->hasValidSignature()) {
abort(401);
}



if($request->has('disposition')){
$role_has_permissions_disposition->disposition=$request->get('disposition');
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









$vue = view('/content/Role_has_permissions.impression', [
'pageConfigs' => $pageConfig,
'editorData' => $request->All(),
'Role_has_permissions' => $Role_has_permissions,
'role_has_permissions_disposition'=>$role_has_permissions_disposition
,'preselect'=>$new,'options'=>$donnees??[],
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

$this->Role_has_permissionsRepository->show($id);

}


}



