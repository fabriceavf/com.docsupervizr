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
// use App\Repository\prod\PermissionsRepository;
use App\Models\Permission;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Groupepermission;
    
class PermissionController extends Controller
{

private $PermissionsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\PermissionsRepository $PermissionsRepository
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
class_exists('\App\Http\Extras\PermissionExtras') &&
method_exists('\App\Http\Extras\PermissionExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\PermissionExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Permission::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\PermissionExtras') &&
method_exists('\App\Http\Extras\PermissionExtras', 'filterAgGridQuery')
){
\App\Http\Extras\PermissionExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('permissions',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\PermissionExtras') &&
method_exists('\App\Http\Extras\PermissionExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\PermissionExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  permissions reussi',
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
return response()->json(Permission::count());
}
$data = QueryBuilder::for(Permission::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('guard_name'),

    
    
    
    
    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('nom'),

    
            AllowedFilter::exact('visible'),

    
            AllowedFilter::exact('groupepermission_id'),

    
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

    
            AllowedSort::field('name'),

    
            AllowedSort::field('guard_name'),

    
    
    
    
    
            AllowedSort::field('type'),

    
            AllowedSort::field('nom'),

    
            AllowedSort::field('visible'),

    
            AllowedSort::field('groupepermission_id'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
            'model_has_permissions',
        

                'perms',
        

                'role_has_permissions',
        

    
            'groupepermission',
        

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




$data = QueryBuilder::for(Permission::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('guard_name'),

    
    
    
    
    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('nom'),

    
            AllowedFilter::exact('visible'),

    
            AllowedFilter::exact('groupepermission_id'),

    
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

    
            AllowedSort::field('name'),

    
            AllowedSort::field('guard_name'),

    
    
    
    
    
            AllowedSort::field('type'),

    
            AllowedSort::field('nom'),

    
            AllowedSort::field('visible'),

    
            AllowedSort::field('groupepermission_id'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
            'model_has_permissions',
        

                'perms',
        

                'role_has_permissions',
        

                'groupepermission',
        

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



public function create(Request $request, Permission $Permissions)
{


try{
$can=\App\Helpers\Helpers::can('Creer des permissions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "permissions"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'name',
    'guard_name',
    'created_at',
    'updated_at',
    'deleted_at',
    'extra_attributes',
    'type',
    'nom',
    'visible',
    'groupepermission_id',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'guard_name' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'nom' => [
            //'required'
            ],
        
    
    
                    'visible' => [
            //'required'
            ],
        
    
    
                    'groupepermission_id' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'guard_name' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'nom' => ['cette donnee est obligatoire'],

    
    
        'visible' => ['cette donnee est obligatoire'],

    
    
        'groupepermission_id' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['name'])){
        
            $Permissions->name = $data['name'];
        
        }



    







    

        if(!empty($data['guard_name'])){
        
            $Permissions->guard_name = $data['guard_name'];
        
        }



    







    







    







    







    







    

        if(!empty($data['type'])){
        
            $Permissions->type = $data['type'];
        
        }



    







    

        if(!empty($data['nom'])){
        
            $Permissions->nom = $data['nom'];
        
        }



    







    

        if(!empty($data['visible'])){
        
            $Permissions->visible = $data['visible'];
        
        }



    







    

        if(!empty($data['groupepermission_id'])){
        
            $Permissions->groupepermission_id = $data['groupepermission_id'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Permissions->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Permissions->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Permissions->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\PermissionExtras') &&
method_exists('\App\Http\Extras\PermissionExtras', 'beforeSaveCreate')
){
\App\Http\Extras\PermissionExtras::beforeSaveCreate($request,$Permissions);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PermissionExtras') &&
method_exists('\App\Http\Extras\PermissionExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\PermissionExtras::canCreate($request, $Permissions);
}catch (\Throwable $e){

}

}


if($canSave){
$Permissions->save();
}else{
return response()->json($Permissions, 200);
}

$Permissions=Permission::find($Permissions->id);
$newCrudData=[];

                $newCrudData['name']=$Permissions->name;
                $newCrudData['guard_name']=$Permissions->guard_name;
                                $newCrudData['type']=$Permissions->type;
                $newCrudData['nom']=$Permissions->nom;
                $newCrudData['visible']=$Permissions->visible;
                $newCrudData['groupepermission_id']=$Permissions->groupepermission_id;
                $newCrudData['identifiants_sadge']=$Permissions->identifiants_sadge;
                $newCrudData['creat_by']=$Permissions->creat_by;
    
 try{ $newCrudData['groupepermission']=$Permissions->groupepermission->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Permissions','entite_cle' => $Permissions->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Permissions->toArray();




try{

foreach ($Permissions->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Permission $Permissions)
{
try{
$can=\App\Helpers\Helpers::can('Editer des permissions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['name']=$Permissions->name;
                $oldCrudData['guard_name']=$Permissions->guard_name;
                                $oldCrudData['type']=$Permissions->type;
                $oldCrudData['nom']=$Permissions->nom;
                $oldCrudData['visible']=$Permissions->visible;
                $oldCrudData['groupepermission_id']=$Permissions->groupepermission_id;
                $oldCrudData['identifiants_sadge']=$Permissions->identifiants_sadge;
                $oldCrudData['creat_by']=$Permissions->creat_by;
    
 try{ $oldCrudData['groupepermission']=$Permissions->groupepermission->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "permissions"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'name',
    'guard_name',
    'created_at',
    'updated_at',
    'deleted_at',
    'extra_attributes',
    'type',
    'nom',
    'visible',
    'groupepermission_id',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'guard_name' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'nom' => [
            //'required'
            ],
        
    
    
                    'visible' => [
            //'required'
            ],
        
    
    
                    'groupepermission_id' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'guard_name' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'nom' => ['cette donnee est obligatoire'],

    
    
        'visible' => ['cette donnee est obligatoire'],

    
    
        'groupepermission_id' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("name",$data)){


        if(!empty($data['name'])){
        
            $Permissions->name = $data['name'];
        
        }

        }

    







    

        if(array_key_exists("guard_name",$data)){


        if(!empty($data['guard_name'])){
        
            $Permissions->guard_name = $data['guard_name'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Permissions->type = $data['type'];
        
        }

        }

    







    

        if(array_key_exists("nom",$data)){


        if(!empty($data['nom'])){
        
            $Permissions->nom = $data['nom'];
        
        }

        }

    







    

        if(array_key_exists("visible",$data)){


        if(!empty($data['visible'])){
        
            $Permissions->visible = $data['visible'];
        
        }

        }

    







    

        if(array_key_exists("groupepermission_id",$data)){


        if(!empty($data['groupepermission_id'])){
        
            $Permissions->groupepermission_id = $data['groupepermission_id'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Permissions->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Permissions->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Permissions->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\PermissionExtras') &&
method_exists('\App\Http\Extras\PermissionExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\PermissionExtras::beforeSaveUpdate($request,$Permissions);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PermissionExtras') &&
method_exists('\App\Http\Extras\PermissionExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\PermissionExtras::canUpdate($request, $Permissions);
}catch (\Throwable $e){

}

}


if($canSave){
$Permissions->save();
}else{
return response()->json($Permissions, 200);

}


$Permissions=Permission::find($Permissions->id);



$newCrudData=[];

                $newCrudData['name']=$Permissions->name;
                $newCrudData['guard_name']=$Permissions->guard_name;
                                $newCrudData['type']=$Permissions->type;
                $newCrudData['nom']=$Permissions->nom;
                $newCrudData['visible']=$Permissions->visible;
                $newCrudData['groupepermission_id']=$Permissions->groupepermission_id;
                $newCrudData['identifiants_sadge']=$Permissions->identifiants_sadge;
                $newCrudData['creat_by']=$Permissions->creat_by;
    
 try{ $newCrudData['groupepermission']=$Permissions->groupepermission->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Permissions','entite_cle' => $Permissions->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Permissions->toArray();




try{

foreach ($Permissions->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Permission $Permissions)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des permissions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['name']=$Permissions->name;
                $newCrudData['guard_name']=$Permissions->guard_name;
                                $newCrudData['type']=$Permissions->type;
                $newCrudData['nom']=$Permissions->nom;
                $newCrudData['visible']=$Permissions->visible;
                $newCrudData['groupepermission_id']=$Permissions->groupepermission_id;
                $newCrudData['identifiants_sadge']=$Permissions->identifiants_sadge;
                $newCrudData['creat_by']=$Permissions->creat_by;
    
 try{ $newCrudData['groupepermission']=$Permissions->groupepermission->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Permissions','entite_cle' => $Permissions->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\PermissionExtras') &&
method_exists('\App\Http\Extras\PermissionExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\PermissionExtras::canDelete($request, $Permissions);
}catch (\Throwable $e){

}

}



if($canSave){
$Permissions->delete();
}else{
return response()->json($Permissions, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\PermissionsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
