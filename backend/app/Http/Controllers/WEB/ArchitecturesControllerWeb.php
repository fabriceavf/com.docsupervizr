<?php 
namespace App\Http\Controllers\WEB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
// use App\Repository\prod\ArchitecturesRepository;
use App\Models\prod\Architecture;

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


class ArchitecturesControllerWeb extends Controller
{

private $ArchitecturesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ArchitecturesRepository $ArchitecturesRepository
* @param int $id
*/
public function __construct(Request $request)
{
if (!$request->has('__internalId__')) {
$id="Architectures_".Str::uuid()->toString().'_unique';
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
'action' => 'Navigation vers page architectures Reussi',
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
&& !Auth::user()->can("Voir les architectures")
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



$vue = view('/content/Architectures.Architectures', ['pageConfigs' => $pageConfig, 'menu' => $this->menu,'preselect'=>$new,'options'=>$donnees??[],'options'=>$donnees??[],

]);
return response($vue, 200);
}
public function index_component(Request $request)
{

// La securite qui empeiche darriver sur cette sans avoir une signature valide
if (! $request->hasValidSignature() && !Auth::user()->can("Voir les architectures")) {
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
$architectures_disposition->disposition=$request->get('disposition');
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



$vue = view('/content/Architectures.architectures_component', ['pageConfigs' => $pageConfig, 'menu' => $this->menu,'architectures_disposition'=>$architectures_disposition,'preselect'=>$new,'options'=>$donnees??[],'options'=>$donnees??[],
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
if (! $request->hasValidSignature() && !Auth::user()->can("Voir les architectures")) {
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
$architectures_disposition->disposition=$request->get('disposition');
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



        

            





        

            





        

            





        

            





        

            





        

            





        

            




$vue = view('/content/Architectures.Architectures', ['pageConfigs' => $pageConfig, 'menu' => $this->menu,'architectures_disposition'=>$architectures_disposition,'preselect'=>$new,'options'=>$donnees??[],
]);
return response($vue, 200);
}

/**
* Show the form for creating a new resource.
* Return .
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/

public function index_one(Request $request, Architecture $Architectures)
{



if($request->has('disposition')){
$architectures_disposition->disposition=$request->get('disposition');
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







        

            





        

            





        

            





        

            





        

            





        

            





        

            






$vue = view('/content/Architectures.architectures_one', [
'pageConfigs' => $pageConfig,
'editorData' => $request->All(),
'Architectures' => $Architectures,
'architectures_disposition'=>$architectures_disposition
,'preselect'=>$new,'options'=>$donnees??[],
]);



return response($vue, 200);

}
public function index_one_component(Request $request, Architecture $Architectures)
{



if($request->has('disposition')){
$architectures_disposition->disposition=$request->get('disposition');
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







        

            





        

            





        

            





        

            





        

            





        

            





        

            






$vue = view('/content/Architectures.architectures_one_component', [
'pageConfigs' => $pageConfig,
'editorData' => $request->All(),
'Architectures' => $Architectures,
'architectures_disposition'=>$architectures_disposition
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

public function show_impression(Request $request, Architecture $Architectures)
{
// La securite qui empeiche darriver sur cette sans avoir une signature valide
if (! $request->hasValidSignature()) {
abort(401);
}



if($request->has('disposition')){
$architectures_disposition->disposition=$request->get('disposition');
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









$vue = view('/content/Architectures.impression', [
'pageConfigs' => $pageConfig,
'editorData' => $request->All(),
'Architectures' => $Architectures,
'architectures_disposition'=>$architectures_disposition
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

$this->ArchitecturesRepository->show($id);

}


}


