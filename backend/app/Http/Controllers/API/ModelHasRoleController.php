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
// use App\Repository\prod\Model_has_rolesRepository;
use App\Models\ModelHasRole;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Role;
    
class ModelHasRoleController extends Controller
{

private $Model_has_rolesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\Model_has_rolesRepository $Model_has_rolesRepository
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
class_exists('\App\Http\Extras\Model_has_roleExtras') &&
method_exists('\App\Http\Extras\Model_has_roleExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\Model_has_roleExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=ModelHasRole::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\Model_has_roleExtras') &&
method_exists('\App\Http\Extras\Model_has_roleExtras', 'filterAgGridQuery')
){
\App\Http\Extras\Model_has_roleExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('model_has_roles',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\Model_has_roleExtras') &&
method_exists('\App\Http\Extras\Model_has_roleExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\Model_has_roleExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  model_has_roles reussi',
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
return response()->json(ModelHasRole::count());
}
$data = QueryBuilder::for(ModelHasRole::class)
->allowedFilters([
            AllowedFilter::exact('role_id'),

    
            AllowedFilter::exact('model_type'),

    
            AllowedFilter::exact('model_id'),

    
    
    
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
            AllowedSort::field('role_id'),

    
            AllowedSort::field('model_type'),

    
            AllowedSort::field('model_id'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([

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




$data = QueryBuilder::for(ModelHasRole::class)
->allowedFilters([
            AllowedFilter::exact('role_id'),

    
            AllowedFilter::exact('model_type'),

    
            AllowedFilter::exact('model_id'),

    
    
    
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
            AllowedSort::field('role_id'),

    
            AllowedSort::field('model_type'),

    
            AllowedSort::field('model_id'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
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



public function create(Request $request, ModelHasRole $Model_has_roles)
{


try{
$can=\App\Helpers\Helpers::can('Creer des model_has_roles');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "model_has_roles"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'role_id',
    'model_type',
    'model_id',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
                    'role_id' => [
            //'required'
            ],
        
    
    
                    'model_type' => [
            //'required'
            ],
        
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
        'role_id' => ['cette donnee est obligatoire'],

    
    
        'model_type' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    

        if(!empty($data['role_id'])){
        
            $Model_has_roles->role_id = $data['role_id'];
        
        }



    







    

        if(!empty($data['model_type'])){
        
            $Model_has_roles->model_type = $data['model_type'];
        
        }



    







    

        if(!empty($data['model_id'])){
        
            $Model_has_roles->model_id = $data['model_id'];
        
        }



    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Model_has_roles->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Model_has_roles->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Model_has_roles->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\Model_has_roleExtras') &&
method_exists('\App\Http\Extras\Model_has_roleExtras', 'beforeSaveCreate')
){
\App\Http\Extras\Model_has_roleExtras::beforeSaveCreate($request,$Model_has_roles);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Model_has_roleExtras') &&
method_exists('\App\Http\Extras\Model_has_roleExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\Model_has_roleExtras::canCreate($request, $Model_has_roles);
}catch (\Throwable $e){

}

}


if($canSave){
$Model_has_roles->save();
}else{
return response()->json($Model_has_roles, 200);
}

$Model_has_roles=ModelHasRole::find($Model_has_roles->id);
$newCrudData=[];

            $newCrudData['role_id']=$Model_has_roles->role_id;
                $newCrudData['model_type']=$Model_has_roles->model_type;
                            $newCrudData['identifiants_sadge']=$Model_has_roles->identifiants_sadge;
                $newCrudData['creat_by']=$Model_has_roles->creat_by;
    
 try{ $newCrudData['role']=$Model_has_roles->role->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Model_has_roles','entite_cle' => $Model_has_roles->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Model_has_roles->toArray();




try{

foreach ($Model_has_roles->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, ModelHasRole $Model_has_roles)
{
try{
$can=\App\Helpers\Helpers::can('Editer des model_has_roles');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

            $oldCrudData['role_id']=$Model_has_roles->role_id;
                $oldCrudData['model_type']=$Model_has_roles->model_type;
                            $oldCrudData['identifiants_sadge']=$Model_has_roles->identifiants_sadge;
                $oldCrudData['creat_by']=$Model_has_roles->creat_by;
    
 try{ $oldCrudData['role']=$Model_has_roles->role->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "model_has_roles"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'role_id',
    'model_type',
    'model_id',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
                    'role_id' => [
            //'required'
            ],
        
    
    
                    'model_type' => [
            //'required'
            ],
        
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
        'role_id' => ['cette donnee est obligatoire'],

    
    
        'model_type' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    

        if(array_key_exists("role_id",$data)){


        if(!empty($data['role_id'])){
        
            $Model_has_roles->role_id = $data['role_id'];
        
        }

        }

    







    

        if(array_key_exists("model_type",$data)){


        if(!empty($data['model_type'])){
        
            $Model_has_roles->model_type = $data['model_type'];
        
        }

        }

    







    

        if(array_key_exists("model_id",$data)){


        if(!empty($data['model_id'])){
        
            $Model_has_roles->model_id = $data['model_id'];
        
        }

        }

    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Model_has_roles->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Model_has_roles->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Model_has_roles->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\Model_has_roleExtras') &&
method_exists('\App\Http\Extras\Model_has_roleExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\Model_has_roleExtras::beforeSaveUpdate($request,$Model_has_roles);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Model_has_roleExtras') &&
method_exists('\App\Http\Extras\Model_has_roleExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\Model_has_roleExtras::canUpdate($request, $Model_has_roles);
}catch (\Throwable $e){

}

}


if($canSave){
$Model_has_roles->save();
}else{
return response()->json($Model_has_roles, 200);

}


$Model_has_roles=ModelHasRole::find($Model_has_roles->id);



$newCrudData=[];

            $newCrudData['role_id']=$Model_has_roles->role_id;
                $newCrudData['model_type']=$Model_has_roles->model_type;
                            $newCrudData['identifiants_sadge']=$Model_has_roles->identifiants_sadge;
                $newCrudData['creat_by']=$Model_has_roles->creat_by;
    
 try{ $newCrudData['role']=$Model_has_roles->role->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Model_has_roles','entite_cle' => $Model_has_roles->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Model_has_roles->toArray();




try{

foreach ($Model_has_roles->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, ModelHasRole $Model_has_roles)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des model_has_roles');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

            $newCrudData['role_id']=$Model_has_roles->role_id;
                $newCrudData['model_type']=$Model_has_roles->model_type;
                            $newCrudData['identifiants_sadge']=$Model_has_roles->identifiants_sadge;
                $newCrudData['creat_by']=$Model_has_roles->creat_by;
    
 try{ $newCrudData['role']=$Model_has_roles->role->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Model_has_roles','entite_cle' => $Model_has_roles->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\Model_has_roleExtras') &&
method_exists('\App\Http\Extras\Model_has_roleExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\Model_has_roleExtras::canDelete($request, $Model_has_roles);
}catch (\Throwable $e){

}

}



if($canSave){
$Model_has_roles->delete();
}else{
return response()->json($Model_has_roles, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\Model_has_rolesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
