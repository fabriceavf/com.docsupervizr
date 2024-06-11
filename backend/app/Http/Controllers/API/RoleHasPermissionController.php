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
// use App\Repository\prod\Role_has_permissionsRepository;
use App\Models\RoleHasPermission;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Permission;
                use App\Models\Role;
    
class RoleHasPermissionController extends Controller
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
class_exists('\App\Http\Extras\Role_has_permissionExtras') &&
method_exists('\App\Http\Extras\Role_has_permissionExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\Role_has_permissionExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=RoleHasPermission::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\Role_has_permissionExtras') &&
method_exists('\App\Http\Extras\Role_has_permissionExtras', 'filterAgGridQuery')
){
\App\Http\Extras\Role_has_permissionExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('role_has_permissions',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\Role_has_permissionExtras') &&
method_exists('\App\Http\Extras\Role_has_permissionExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\Role_has_permissionExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  role_has_permissions reussi',
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
return response()->json(RoleHasPermission::count());
}
$data = QueryBuilder::for(RoleHasPermission::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('permission_id'),

    
            AllowedFilter::exact('role_id'),

    
    
    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('canCreate'),

    
            AllowedFilter::exact('canUpdate'),

    
            AllowedFilter::exact('canDelete'),

    
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

    
            AllowedSort::field('permission_id'),

    
            AllowedSort::field('role_id'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('canCreate'),

    
            AllowedSort::field('canUpdate'),

    
            AllowedSort::field('canDelete'),

    
])
    
    
->allowedIncludes([

            'permission',
        

                'role',
        

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




$data = QueryBuilder::for(RoleHasPermission::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('permission_id'),

    
            AllowedFilter::exact('role_id'),

    
    
    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('canCreate'),

    
            AllowedFilter::exact('canUpdate'),

    
            AllowedFilter::exact('canDelete'),

    
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

    
            AllowedSort::field('permission_id'),

    
            AllowedSort::field('role_id'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('canCreate'),

    
            AllowedSort::field('canUpdate'),

    
            AllowedSort::field('canDelete'),

    
])
    
    
->allowedIncludes([
            'permission',
        

                'role',
        

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



public function create(Request $request, RoleHasPermission $Role_has_permissions)
{


try{
$can=\App\Helpers\Helpers::can('Creer des role_has_permissions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "role_has_permissions"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'permission_id',
    'role_id',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
    'canCreate',
    'canUpdate',
    'canDelete',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'permission_id' => [
            //'required'
            ],
        
    
    
                    'role_id' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'canCreate' => [
            //'required'
            ],
        
    
    
                    'canUpdate' => [
            //'required'
            ],
        
    
    
                    'canDelete' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'permission_id' => ['cette donnee est obligatoire'],

    
    
        'role_id' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'canCreate' => ['cette donnee est obligatoire'],

    
    
        'canUpdate' => ['cette donnee est obligatoire'],

    
    
        'canDelete' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['permission_id'])){
        
            $Role_has_permissions->permission_id = $data['permission_id'];
        
        }



    







    

        if(!empty($data['role_id'])){
        
            $Role_has_permissions->role_id = $data['role_id'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Role_has_permissions->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Role_has_permissions->creat_by = $data['creat_by'];
        
        }



    







    

        if(!empty($data['canCreate'])){
        
            $Role_has_permissions->canCreate = $data['canCreate'];
        
        }



    







    

        if(!empty($data['canUpdate'])){
        
            $Role_has_permissions->canUpdate = $data['canUpdate'];
        
        }



    







    

        if(!empty($data['canDelete'])){
        
            $Role_has_permissions->canDelete = $data['canDelete'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Role_has_permissions->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\Role_has_permissionExtras') &&
method_exists('\App\Http\Extras\Role_has_permissionExtras', 'beforeSaveCreate')
){
\App\Http\Extras\Role_has_permissionExtras::beforeSaveCreate($request,$Role_has_permissions);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Role_has_permissionExtras') &&
method_exists('\App\Http\Extras\Role_has_permissionExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\Role_has_permissionExtras::canCreate($request, $Role_has_permissions);
}catch (\Throwable $e){

}

}


if($canSave){
$Role_has_permissions->save();
}else{
return response()->json($Role_has_permissions, 200);
}

$Role_has_permissions=RoleHasPermission::find($Role_has_permissions->id);
$newCrudData=[];

                $newCrudData['permission_id']=$Role_has_permissions->permission_id;
                $newCrudData['role_id']=$Role_has_permissions->role_id;
                                $newCrudData['identifiants_sadge']=$Role_has_permissions->identifiants_sadge;
                $newCrudData['creat_by']=$Role_has_permissions->creat_by;
                $newCrudData['canCreate']=$Role_has_permissions->canCreate;
                $newCrudData['canUpdate']=$Role_has_permissions->canUpdate;
                $newCrudData['canDelete']=$Role_has_permissions->canDelete;
    
 try{ $newCrudData['permission']=$Role_has_permissions->permission->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['role']=$Role_has_permissions->role->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Role_has_permissions','entite_cle' => $Role_has_permissions->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Role_has_permissions->toArray();




try{

foreach ($Role_has_permissions->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, RoleHasPermission $Role_has_permissions)
{
try{
$can=\App\Helpers\Helpers::can('Editer des role_has_permissions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['permission_id']=$Role_has_permissions->permission_id;
                $oldCrudData['role_id']=$Role_has_permissions->role_id;
                                $oldCrudData['identifiants_sadge']=$Role_has_permissions->identifiants_sadge;
                $oldCrudData['creat_by']=$Role_has_permissions->creat_by;
                $oldCrudData['canCreate']=$Role_has_permissions->canCreate;
                $oldCrudData['canUpdate']=$Role_has_permissions->canUpdate;
                $oldCrudData['canDelete']=$Role_has_permissions->canDelete;
    
 try{ $oldCrudData['permission']=$Role_has_permissions->permission->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['role']=$Role_has_permissions->role->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "role_has_permissions"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'permission_id',
    'role_id',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
    'canCreate',
    'canUpdate',
    'canDelete',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'permission_id' => [
            //'required'
            ],
        
    
    
                    'role_id' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'canCreate' => [
            //'required'
            ],
        
    
    
                    'canUpdate' => [
            //'required'
            ],
        
    
    
                    'canDelete' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'permission_id' => ['cette donnee est obligatoire'],

    
    
        'role_id' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'canCreate' => ['cette donnee est obligatoire'],

    
    
        'canUpdate' => ['cette donnee est obligatoire'],

    
    
        'canDelete' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("permission_id",$data)){


        if(!empty($data['permission_id'])){
        
            $Role_has_permissions->permission_id = $data['permission_id'];
        
        }

        }

    







    

        if(array_key_exists("role_id",$data)){


        if(!empty($data['role_id'])){
        
            $Role_has_permissions->role_id = $data['role_id'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Role_has_permissions->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Role_has_permissions->creat_by = $data['creat_by'];
        
        }

        }

    







    

        if(array_key_exists("canCreate",$data)){


        if(!empty($data['canCreate'])){
        
            $Role_has_permissions->canCreate = $data['canCreate'];
        
        }

        }

    







    

        if(array_key_exists("canUpdate",$data)){


        if(!empty($data['canUpdate'])){
        
            $Role_has_permissions->canUpdate = $data['canUpdate'];
        
        }

        }

    







    

        if(array_key_exists("canDelete",$data)){


        if(!empty($data['canDelete'])){
        
            $Role_has_permissions->canDelete = $data['canDelete'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Role_has_permissions->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\Role_has_permissionExtras') &&
method_exists('\App\Http\Extras\Role_has_permissionExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\Role_has_permissionExtras::beforeSaveUpdate($request,$Role_has_permissions);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Role_has_permissionExtras') &&
method_exists('\App\Http\Extras\Role_has_permissionExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\Role_has_permissionExtras::canUpdate($request, $Role_has_permissions);
}catch (\Throwable $e){

}

}


if($canSave){
$Role_has_permissions->save();
}else{
return response()->json($Role_has_permissions, 200);

}


$Role_has_permissions=RoleHasPermission::find($Role_has_permissions->id);



$newCrudData=[];

                $newCrudData['permission_id']=$Role_has_permissions->permission_id;
                $newCrudData['role_id']=$Role_has_permissions->role_id;
                                $newCrudData['identifiants_sadge']=$Role_has_permissions->identifiants_sadge;
                $newCrudData['creat_by']=$Role_has_permissions->creat_by;
                $newCrudData['canCreate']=$Role_has_permissions->canCreate;
                $newCrudData['canUpdate']=$Role_has_permissions->canUpdate;
                $newCrudData['canDelete']=$Role_has_permissions->canDelete;
    
 try{ $newCrudData['permission']=$Role_has_permissions->permission->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['role']=$Role_has_permissions->role->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Role_has_permissions','entite_cle' => $Role_has_permissions->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Role_has_permissions->toArray();




try{

foreach ($Role_has_permissions->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, RoleHasPermission $Role_has_permissions)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des role_has_permissions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['permission_id']=$Role_has_permissions->permission_id;
                $newCrudData['role_id']=$Role_has_permissions->role_id;
                                $newCrudData['identifiants_sadge']=$Role_has_permissions->identifiants_sadge;
                $newCrudData['creat_by']=$Role_has_permissions->creat_by;
                $newCrudData['canCreate']=$Role_has_permissions->canCreate;
                $newCrudData['canUpdate']=$Role_has_permissions->canUpdate;
                $newCrudData['canDelete']=$Role_has_permissions->canDelete;
    
 try{ $newCrudData['permission']=$Role_has_permissions->permission->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['role']=$Role_has_permissions->role->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Role_has_permissions','entite_cle' => $Role_has_permissions->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\Role_has_permissionExtras') &&
method_exists('\App\Http\Extras\Role_has_permissionExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\Role_has_permissionExtras::canDelete($request, $Role_has_permissions);
}catch (\Throwable $e){

}

}



if($canSave){
$Role_has_permissions->delete();
}else{
return response()->json($Role_has_permissions, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\Role_has_permissionsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
