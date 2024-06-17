<?php 
namespace App\Http\Controllers\API;
namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
// use App\Repository\prod\EntreprisesRepository;
use App\Models\Entreprise;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;




class EntrepriseController extends Controller
{

private $EntreprisesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\EntreprisesRepository $EntreprisesRepository
* @param int $id
*/
public function __construct(Request $request)
{


}

public function agGridData(Request $request){
$newFilter=$request->get('filterModel', []);
$extras = $request->get('__extras__', []);
if(!empty($extras['baseFilter']) && is_array($extras['baseFilter'])){
$oldFilter=$request->get('filterModel', []);
$newFilter=array_merge($oldFilter, $extras['baseFilter']);
}
$request->merge(['filterModel'=>$newFilter]);
$relationsWhenDataIsMutlipleHide=[];
if(
class_exists('\App\Http\Extras\EntrepriseExtras') &&
method_exists('\App\Http\Extras\EntrepriseExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\EntrepriseExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Entreprise::withoutGlobalScope(SoftDeletingScope::class);

if(count($relationsWhenDataIsMutlipleHide) >0 ){
$query=$query->with($relationsWhenDataIsMutlipleHide);
}

if (!empty($extras['filterFields']) && is_array($extras['filterFields']) && !empty($extras['globalSearch'])) {
$query->where(function($q1)use($extras){

foreach ($extras['filterFields'] as $key=>$ex){
$value = "%" . $extras['globalSearch'] . "%";
if($key==0){

$q1->where($ex, "LIKE", $value);
}else{
$q1->orWhere($ex, "LIKE", $value);
}

};

});


}
if(
class_exists('\App\Http\Extras\EntrepriseExtras') &&
method_exists('\App\Http\Extras\EntrepriseExtras', 'filterAgGridQuery')
){
\App\Http\Extras\EntrepriseExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('entreprises',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\EntrepriseExtras') &&
method_exists('\App\Http\Extras\EntrepriseExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\EntrepriseExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  entreprises reussi',
'ip' =>'Non defini',
'pays' =>'Non defini',
'ville' => 'Non defini',
'navigateur' => $request->header('User-Agent'),
'created_at' => now(),
]);

}catch (\Throwable){

}

return $data;
}

/**
* Display a listing of the resource.
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/
public function data(Request $request,$key,$val)
{
// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
$old = $request->all();
$filter = [];
if (array_key_exists('filter', $old)) {
$filter = $old['filter'];

}
$filter[$key] = $val;
$request->merge(['filter' => $filter]);

if(!empty($_REQUEST["count"]) && $_REQUEST["count"]==1 ){
return response()->json(Entreprise::count());
}
$data = QueryBuilder::for(Entreprise::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('nom'),

    
            AllowedFilter::exact('menu'),

    
            AllowedFilter::exact('host'),

    
    
    
    
    
            AllowedFilter::exact('icon'),

    
            AllowedFilter::exact('favicon'),

    
            AllowedFilter::exact('status'),

    
            AllowedFilter::exact('db_host'),

    
            AllowedFilter::exact('db_user'),

    
            AllowedFilter::exact('db_pass'),

    
            AllowedFilter::exact('badge_avant'),

    
            AllowedFilter::exact('badge_arriere'),

    
            AllowedFilter::exact('modules'),

    
            AllowedFilter::exact('filemodules'),

    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
AllowedFilter::callback('not_null', function (Builder $query, $value) {
//                    dump($value);

if (!is_array($value)) {
$value = explode(',', $value);
}
foreach ($value as $val) {
$query->whereNotNull($val);

}


return $query;
}),
AllowedFilter::callback('null', function (Builder $query, $value) {
//                    dump($value);
if (!is_array($value)) {
$value = explode(',', $value);
}


foreach ($value as $val) {
$query->whereNull($val);

}


return $query;
}),
AllowedFilter::callback('date', function (Builder $query, $value) {
//                    dd($value);


if (!is_array($value)) {
$value=explode(',',$value);
}
foreach ($value as $val) {
$dat = explode('/', $val);
if (count($dat) == 3) {
if ($dat[1] != 'like') {
$query->where($dat[0], $dat[1], Carbon::parse($dat[2]));

} else {

$query->where($dat[0], "LIKE", "%" . $dat[2] . "%");
}
//                                dd($dat,$dat[0],Carbon::parse($dat[2]));

}

}


return $query;
}),

AllowedFilter::callback('like', function (Builder $query, $value) {
if (!is_array($value)) {
$value = explode(',', $value);
}

foreach ($value as $val) {
$dat = explode('/', $val);
if (count($dat) == 2) {
$query->where($dat[0], "LIKE", "%" . $dat[1] . "%");

}

}


return $query;
}),
AllowedFilter::callback('where', function (Builder $query, $value) {
if (!is_array($value)) {
$value = explode(',', $value);
}

foreach ($value as $val) {
$dat = explode('/', $val);
if (count($dat) == 3) {
$query->where($dat[0], $dat[1], $dat[2]);

}

}


return $query;
}),
])
->allowedSorts([
            AllowedSort::field('id'),

    
            AllowedSort::field('nom'),

    
            AllowedSort::field('menu'),

    
            AllowedSort::field('host'),

    
    
    
    
    
            AllowedSort::field('icon'),

    
            AllowedSort::field('favicon'),

    
            AllowedSort::field('status'),

    
            AllowedSort::field('db_host'),

    
            AllowedSort::field('db_user'),

    
            AllowedSort::field('db_pass'),

    
            AllowedSort::field('badge_avant'),

    
            AllowedSort::field('badge_arriere'),

    
            AllowedSort::field('modules'),

    
            AllowedSort::field('filemodules'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
->allowedIncludes([
            'headselements',
        

                'menus',
        

    
]);

if(!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"]==1 ){
$data=$data->paginate(isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20);
}else{
$data=$data->get();
}
$donnees=$data->toArray();


    






    






    






    






    






    






    






    






    






    






    






    






    






    






    






    






    






    






    






    









if(!empty($donnees['data']) && is_array($donnees['data'])){
$new=[];
foreach ($donnees['data'] as $response) {
try {

foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
$response[$key] = $dat;
}
$response['extra_attributes'] = false;
} catch (\Throwable $e) {

}
$new[]=$response;
}
$donnees['data']=$new;
}else{

foreach ($donnees as $response) {
try {

foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
$response[$key] = $dat;
}
$response['extra_attributes'] = false;
} catch (\Throwable $e) {

}
}
}


return response()->json($donnees, 200);


//                        return response()->json($data,200);
}
/**
* Display a listing of the resource.
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\Response
*/
public function data1(Request $request)
{




$data = QueryBuilder::for(Entreprise::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('nom'),

    
            AllowedFilter::exact('menu'),

    
            AllowedFilter::exact('host'),

    
    
    
    
    
            AllowedFilter::exact('icon'),

    
            AllowedFilter::exact('favicon'),

    
            AllowedFilter::exact('status'),

    
            AllowedFilter::exact('db_host'),

    
            AllowedFilter::exact('db_user'),

    
            AllowedFilter::exact('db_pass'),

    
            AllowedFilter::exact('badge_avant'),

    
            AllowedFilter::exact('badge_arriere'),

    
            AllowedFilter::exact('modules'),

    
            AllowedFilter::exact('filemodules'),

    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
AllowedFilter::callback('not_null', function (Builder $query, $value) {
//                    dump($value);

if (!is_array($value)) {
$value = explode(',', $value);
}
foreach ($value as $val) {
$query->whereNotNull($val);

}


return $query;
}),
AllowedFilter::callback('null', function (Builder $query, $value) {
//                    dump($value);
if (!is_array($value)) {
$value = explode(',', $value);
}


foreach ($value as $val) {
$query->whereNull($val);

}


return $query;
}),
AllowedFilter::callback('date', function (Builder $query, $value) {
//                    dd($value);


if (!is_array($value)) {
$value=explode(',',$value);
}
foreach ($value as $val) {
$dat = explode('/', $val);
if (count($dat) == 3) {
if ($dat[1] != 'like') {
$query->where($dat[0], $dat[1], Carbon::parse($dat[2]));

} else {

$query->where($dat[0], "LIKE", "%" . $dat[2] . "%");
}
//                                dd($dat,$dat[0],Carbon::parse($dat[2]));

}

}


return $query;
}),

AllowedFilter::callback('like', function (Builder $query, $value) {
if (!is_array($value)) {
$value = explode(',', $value);
}

foreach ($value as $val) {
$dat = explode('/', $val);
if (count($dat) == 2) {
$query->where($dat[0], "LIKE", "%" . $dat[1] . "%");

}

}


return $query;
}),
AllowedFilter::callback('where', function (Builder $query, $value) {
if (!is_array($value)) {
$value = explode(',', $value);
}

foreach ($value as $val) {
$dat = explode('/', $val);
if (count($dat) == 3) {
$query->where($dat[0], $dat[1], $dat[2]);

}

}


return $query;
}),
])
->allowedSorts([
            AllowedSort::field('id'),

    
            AllowedSort::field('nom'),

    
            AllowedSort::field('menu'),

    
            AllowedSort::field('host'),

    
    
    
    
    
            AllowedSort::field('icon'),

    
            AllowedSort::field('favicon'),

    
            AllowedSort::field('status'),

    
            AllowedSort::field('db_host'),

    
            AllowedSort::field('db_user'),

    
            AllowedSort::field('db_pass'),

    
            AllowedSort::field('badge_avant'),

    
            AllowedSort::field('badge_arriere'),

    
            AllowedSort::field('modules'),

    
            AllowedSort::field('filemodules'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
->allowedIncludes([
            'headselements',
        

                'menus',
        

    ]);

if(!empty($_REQUEST["count"]) && $_REQUEST["count"]==1 ){
return response()->json($data->count());
}

if(!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"]==1 ){
$data=$data->paginate(isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20);
}else{
$data=$data->get();
}
$donnees=$data->toArray();





    






    






    






    






    






    






    






    






    






    






    






    






    






    






    






    






    






    






    






    





if(!empty($donnees['data']) && is_array($donnees['data'])){
$new=[];
foreach ($donnees['data'] as $response) {
try {

foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
$response[$key] = $dat;
}
$response['extra_attributes'] = false;
} catch (\Throwable $e) {

}
$new[]=$response;
}
$donnees['data']=$new;
}else{

foreach ($donnees as $response) {
try {

foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
$response[$key] = $dat;
}
$response['extra_attributes'] = false;
} catch (\Throwable $e) {

}
}
}


return response()->json($donnees, 200);


//                        return response()->json($data,200);
}



public function create(Request $request, Entreprise $Entreprises)
{


try{
$can=\App\Helpers\Helpers::can('Creer des entreprises');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "entreprises"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'nom',
    'menu',
    'host',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'icon',
    'favicon',
    'status',
    'db_host',
    'db_user',
    'db_pass',
    'badge_avant',
    'badge_arriere',
    'modules',
    'filemodules',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'nom' => [
            //'required'
            ],
        
    
    
                    'menu' => [
            //'required'
            ],
        
    
    
                    'host' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'icon' => [
            //'required'
            ],
        
    
    
                    'favicon' => [
            //'required'
            ],
        
    
    
                    'status' => [
            //'required'
            ],
        
    
    
                    'db_host' => [
            //'required'
            ],
        
    
    
                    'db_user' => [
            //'required'
            ],
        
    
    
                    'db_pass' => [
            //'required'
            ],
        
    
    
                    'badge_avant' => [
            //'required'
            ],
        
    
    
                    'badge_arriere' => [
            //'required'
            ],
        
    
    
                    'modules' => [
            //'required'
            ],
        
    
    
                    'filemodules' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'nom' => ['cette donnee est obligatoire'],

    
    
        'menu' => ['cette donnee est obligatoire'],

    
    
        'host' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'icon' => ['cette donnee est obligatoire'],

    
    
        'favicon' => ['cette donnee est obligatoire'],

    
    
        'status' => ['cette donnee est obligatoire'],

    
    
        'db_host' => ['cette donnee est obligatoire'],

    
    
        'db_user' => ['cette donnee est obligatoire'],

    
    
        'db_pass' => ['cette donnee est obligatoire'],

    
    
        'badge_avant' => ['cette donnee est obligatoire'],

    
    
        'badge_arriere' => ['cette donnee est obligatoire'],

    
    
        'modules' => ['cette donnee est obligatoire'],

    
    
        'filemodules' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['nom'])){
        
            $Entreprises->nom = $data['nom'];
        
        }



    







    

        if(!empty($data['menu'])){
        
            $Entreprises->menu = $data['menu'];
        
        }



    







    

        if(!empty($data['host'])){
        
            $Entreprises->host = $data['host'];
        
        }



    







    







    







    







    







    

        if(!empty($data['icon'])){
        
            $Entreprises->icon = $data['icon'];
        
        }



    







    

        if(!empty($data['favicon'])){
        
            $Entreprises->favicon = $data['favicon'];
        
        }



    







    

        if(!empty($data['status'])){
        
            $Entreprises->status = $data['status'];
        
        }



    







    

        if(!empty($data['db_host'])){
        
            $Entreprises->db_host = $data['db_host'];
        
        }



    







    

        if(!empty($data['db_user'])){
        
            $Entreprises->db_user = $data['db_user'];
        
        }



    







    

        if(!empty($data['db_pass'])){
        
            $Entreprises->db_pass = $data['db_pass'];
        
        }



    







    

        if(!empty($data['badge_avant'])){
        
            $Entreprises->badge_avant = $data['badge_avant'];
        
        }



    







    

        if(!empty($data['badge_arriere'])){
        
            $Entreprises->badge_arriere = $data['badge_arriere'];
        
        }



    







    

        if(!empty($data['modules'])){
        
            $Entreprises->modules = $data['modules'];
        
        }



    







    

        if(!empty($data['filemodules'])){
        
            $Entreprises->filemodules = $data['filemodules'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Entreprises->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Entreprises->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Entreprises->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\EntrepriseExtras') &&
method_exists('\App\Http\Extras\EntrepriseExtras', 'beforeSaveCreate')
){
\App\Http\Extras\EntrepriseExtras::beforeSaveCreate($request,$Entreprises);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\EntrepriseExtras') &&
method_exists('\App\Http\Extras\EntrepriseExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\EntrepriseExtras::canCreate($request, $Entreprises);
}catch (\Throwable $e){

}

}


if($canSave){
$Entreprises->save();
}else{
return response()->json($Entreprises, 200);
}

$Entreprises=Entreprise::find($Entreprises->id);
$newCrudData=[];

                $newCrudData['nom']=$Entreprises->nom;
                $newCrudData['menu']=$Entreprises->menu;
                $newCrudData['host']=$Entreprises->host;
                                $newCrudData['icon']=$Entreprises->icon;
                $newCrudData['favicon']=$Entreprises->favicon;
                $newCrudData['status']=$Entreprises->status;
                $newCrudData['db_host']=$Entreprises->db_host;
                $newCrudData['db_user']=$Entreprises->db_user;
                $newCrudData['db_pass']=$Entreprises->db_pass;
                $newCrudData['badge_avant']=$Entreprises->badge_avant;
                $newCrudData['badge_arriere']=$Entreprises->badge_arriere;
                $newCrudData['modules']=$Entreprises->modules;
                $newCrudData['filemodules']=$Entreprises->filemodules;
                $newCrudData['identifiants_sadge']=$Entreprises->identifiants_sadge;
                $newCrudData['creat_by']=$Entreprises->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Entreprises','entite_cle' => $Entreprises->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Entreprises->toArray();




try{

foreach ($Entreprises->extra_attributes["extra-data"] as $key=>$dat){
$response[$key]=$dat;
}


}catch(\Throwable $e){
}


return response()->json($response, 200);


}




/**
* Update the specified resource in storage.
*
* @param \Illuminate\Http\Request $request
* @param int $id
* @return \Illuminate\Http\Response
*/


public function update(Request $request, Entreprise $Entreprises)
{
try{
$can=\App\Helpers\Helpers::can('Editer des entreprises');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['nom']=$Entreprises->nom;
                $oldCrudData['menu']=$Entreprises->menu;
                $oldCrudData['host']=$Entreprises->host;
                                $oldCrudData['icon']=$Entreprises->icon;
                $oldCrudData['favicon']=$Entreprises->favicon;
                $oldCrudData['status']=$Entreprises->status;
                $oldCrudData['db_host']=$Entreprises->db_host;
                $oldCrudData['db_user']=$Entreprises->db_user;
                $oldCrudData['db_pass']=$Entreprises->db_pass;
                $oldCrudData['badge_avant']=$Entreprises->badge_avant;
                $oldCrudData['badge_arriere']=$Entreprises->badge_arriere;
                $oldCrudData['modules']=$Entreprises->modules;
                $oldCrudData['filemodules']=$Entreprises->filemodules;
                $oldCrudData['identifiants_sadge']=$Entreprises->identifiants_sadge;
                $oldCrudData['creat_by']=$Entreprises->creat_by;
    


$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "entreprises"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'nom',
    'menu',
    'host',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'icon',
    'favicon',
    'status',
    'db_host',
    'db_user',
    'db_pass',
    'badge_avant',
    'badge_arriere',
    'modules',
    'filemodules',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'nom' => [
            //'required'
            ],
        
    
    
                    'menu' => [
            //'required'
            ],
        
    
    
                    'host' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'icon' => [
            //'required'
            ],
        
    
    
                    'favicon' => [
            //'required'
            ],
        
    
    
                    'status' => [
            //'required'
            ],
        
    
    
                    'db_host' => [
            //'required'
            ],
        
    
    
                    'db_user' => [
            //'required'
            ],
        
    
    
                    'db_pass' => [
            //'required'
            ],
        
    
    
                    'badge_avant' => [
            //'required'
            ],
        
    
    
                    'badge_arriere' => [
            //'required'
            ],
        
    
    
                    'modules' => [
            //'required'
            ],
        
    
    
                    'filemodules' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'nom' => ['cette donnee est obligatoire'],

    
    
        'menu' => ['cette donnee est obligatoire'],

    
    
        'host' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'icon' => ['cette donnee est obligatoire'],

    
    
        'favicon' => ['cette donnee est obligatoire'],

    
    
        'status' => ['cette donnee est obligatoire'],

    
    
        'db_host' => ['cette donnee est obligatoire'],

    
    
        'db_user' => ['cette donnee est obligatoire'],

    
    
        'db_pass' => ['cette donnee est obligatoire'],

    
    
        'badge_avant' => ['cette donnee est obligatoire'],

    
    
        'badge_arriere' => ['cette donnee est obligatoire'],

    
    
        'modules' => ['cette donnee est obligatoire'],

    
    
        'filemodules' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("nom",$data)){


        if(!empty($data['nom'])){
        
            $Entreprises->nom = $data['nom'];
        
        }

        }

    







    

        if(array_key_exists("menu",$data)){


        if(!empty($data['menu'])){
        
            $Entreprises->menu = $data['menu'];
        
        }

        }

    







    

        if(array_key_exists("host",$data)){


        if(!empty($data['host'])){
        
            $Entreprises->host = $data['host'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("icon",$data)){


        if(!empty($data['icon'])){
        
            $Entreprises->icon = $data['icon'];
        
        }

        }

    







    

        if(array_key_exists("favicon",$data)){


        if(!empty($data['favicon'])){
        
            $Entreprises->favicon = $data['favicon'];
        
        }

        }

    







    

        if(array_key_exists("status",$data)){


        if(!empty($data['status'])){
        
            $Entreprises->status = $data['status'];
        
        }

        }

    







    

        if(array_key_exists("db_host",$data)){


        if(!empty($data['db_host'])){
        
            $Entreprises->db_host = $data['db_host'];
        
        }

        }

    







    

        if(array_key_exists("db_user",$data)){


        if(!empty($data['db_user'])){
        
            $Entreprises->db_user = $data['db_user'];
        
        }

        }

    







    

        if(array_key_exists("db_pass",$data)){


        if(!empty($data['db_pass'])){
        
            $Entreprises->db_pass = $data['db_pass'];
        
        }

        }

    







    

        if(array_key_exists("badge_avant",$data)){


        if(!empty($data['badge_avant'])){
        
            $Entreprises->badge_avant = $data['badge_avant'];
        
        }

        }

    







    

        if(array_key_exists("badge_arriere",$data)){


        if(!empty($data['badge_arriere'])){
        
            $Entreprises->badge_arriere = $data['badge_arriere'];
        
        }

        }

    







    

        if(array_key_exists("modules",$data)){


        if(!empty($data['modules'])){
        
            $Entreprises->modules = $data['modules'];
        
        }

        }

    







    

        if(array_key_exists("filemodules",$data)){


        if(!empty($data['filemodules'])){
        
            $Entreprises->filemodules = $data['filemodules'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Entreprises->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Entreprises->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Entreprises->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\EntrepriseExtras') &&
method_exists('\App\Http\Extras\EntrepriseExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\EntrepriseExtras::beforeSaveUpdate($request,$Entreprises);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\EntrepriseExtras') &&
method_exists('\App\Http\Extras\EntrepriseExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\EntrepriseExtras::canUpdate($request, $Entreprises);
}catch (\Throwable $e){

}

}


if($canSave){
$Entreprises->save();
}else{
return response()->json($Entreprises, 200);

}


$Entreprises=Entreprise::find($Entreprises->id);



$newCrudData=[];

                $newCrudData['nom']=$Entreprises->nom;
                $newCrudData['menu']=$Entreprises->menu;
                $newCrudData['host']=$Entreprises->host;
                                $newCrudData['icon']=$Entreprises->icon;
                $newCrudData['favicon']=$Entreprises->favicon;
                $newCrudData['status']=$Entreprises->status;
                $newCrudData['db_host']=$Entreprises->db_host;
                $newCrudData['db_user']=$Entreprises->db_user;
                $newCrudData['db_pass']=$Entreprises->db_pass;
                $newCrudData['badge_avant']=$Entreprises->badge_avant;
                $newCrudData['badge_arriere']=$Entreprises->badge_arriere;
                $newCrudData['modules']=$Entreprises->modules;
                $newCrudData['filemodules']=$Entreprises->filemodules;
                $newCrudData['identifiants_sadge']=$Entreprises->identifiants_sadge;
                $newCrudData['creat_by']=$Entreprises->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Entreprises','entite_cle' => $Entreprises->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Entreprises->toArray();




try{

foreach ($Entreprises->extra_attributes["extra-data"] as $key=>$dat){
$response[$key]=$dat;
}


}catch(\Throwable $e){
}


return response()->json($response, 200);



}


/**
* Remove the specified resource from storage.
* @param \Illuminate\Http\Request $request
* @param int $id
* @return \Illuminate\Http\Response
*/
public function delete(Request $request, Entreprise $Entreprises)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des entreprises');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['nom']=$Entreprises->nom;
                $newCrudData['menu']=$Entreprises->menu;
                $newCrudData['host']=$Entreprises->host;
                                $newCrudData['icon']=$Entreprises->icon;
                $newCrudData['favicon']=$Entreprises->favicon;
                $newCrudData['status']=$Entreprises->status;
                $newCrudData['db_host']=$Entreprises->db_host;
                $newCrudData['db_user']=$Entreprises->db_user;
                $newCrudData['db_pass']=$Entreprises->db_pass;
                $newCrudData['badge_avant']=$Entreprises->badge_avant;
                $newCrudData['badge_arriere']=$Entreprises->badge_arriere;
                $newCrudData['modules']=$Entreprises->modules;
                $newCrudData['filemodules']=$Entreprises->filemodules;
                $newCrudData['identifiants_sadge']=$Entreprises->identifiants_sadge;
                $newCrudData['creat_by']=$Entreprises->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Entreprises','entite_cle' => $Entreprises->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\EntrepriseExtras') &&
method_exists('\App\Http\Extras\EntrepriseExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\EntrepriseExtras::canDelete($request, $Entreprises);
}catch (\Throwable $e){

}

}



if($canSave){
$Entreprises->delete();
}else{
return response()->json($Entreprises, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\EntreprisesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
