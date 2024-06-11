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
// use App\Repository\prod\PermsRepository;
use App\Models\Perm;
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
        
class PermController extends Controller
{

private $PermsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\PermsRepository $PermsRepository
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
class_exists('\App\Http\Extras\PermExtras') &&
method_exists('\App\Http\Extras\PermExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\PermExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Perm::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\PermExtras') &&
method_exists('\App\Http\Extras\PermExtras', 'filterAgGridQuery')
){
\App\Http\Extras\PermExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('perms',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\PermExtras') &&
method_exists('\App\Http\Extras\PermExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\PermExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  perms reussi',
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
return response()->json(Perm::count());
}
$data = QueryBuilder::for(Perm::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('permission_label'),

    
            AllowedFilter::exact('permission_nom'),

    
            AllowedFilter::exact('permission_id'),

    
    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('nom'),

    
            AllowedFilter::exact('prenom'),

    
            AllowedFilter::exact('type'),

    
    
    
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

    
            AllowedSort::field('permission_label'),

    
            AllowedSort::field('permission_nom'),

    
            AllowedSort::field('permission_id'),

    
    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('nom'),

    
            AllowedSort::field('prenom'),

    
            AllowedSort::field('type'),

    
    
    
])
    
    
->allowedIncludes([

            'permission',
        

                'user',
        

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




$data = QueryBuilder::for(Perm::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('permission_label'),

    
            AllowedFilter::exact('permission_nom'),

    
            AllowedFilter::exact('permission_id'),

    
    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('nom'),

    
            AllowedFilter::exact('prenom'),

    
            AllowedFilter::exact('type'),

    
    
    
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

    
            AllowedSort::field('permission_label'),

    
            AllowedSort::field('permission_nom'),

    
            AllowedSort::field('permission_id'),

    
    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('nom'),

    
            AllowedSort::field('prenom'),

    
            AllowedSort::field('type'),

    
    
    
])
    
    
->allowedIncludes([
            'permission',
        

                'user',
        

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



public function create(Request $request, Perm $Perms)
{


try{
$can=\App\Helpers\Helpers::can('Creer des perms');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "perms"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'permission_label',
    'permission_nom',
    'permission_id',
    'updated_at',
    'user_id',
    'nom',
    'prenom',
    'type',
    'deleted_at',
    'created_at',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'permission_label' => [
            //'required'
            ],
        
    
    
                    'permission_nom' => [
            //'required'
            ],
        
    
    
                    'permission_id' => [
            //'required'
            ],
        
    
    
    
    
                    'nom' => ['required'],
        
    
    
                    'prenom' => ['required'],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
    


], $messages = [

    
    
        'permission_label' => ['cette donnee est obligatoire'],

    
    
        'permission_nom' => ['cette donnee est obligatoire'],

    
    
        'permission_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'nom' => ['cette donnee est obligatoire'],

    
    
        'prenom' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['permission_label'])){
        
            $Perms->permission_label = $data['permission_label'];
        
        }



    







    

        if(!empty($data['permission_nom'])){
        
            $Perms->permission_nom = $data['permission_nom'];
        
        }



    







    

        if(!empty($data['permission_id'])){
        
            $Perms->permission_id = $data['permission_id'];
        
        }



    







    







    

        if(!empty($data['user_id'])){
        
            $Perms->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['nom'])){
        
            $Perms->nom = $data['nom'];
        
        }



    







    

        if(!empty($data['prenom'])){
        
            $Perms->prenom = $data['prenom'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Perms->type = $data['type'];
        
        }



    







    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Perms->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\PermExtras') &&
method_exists('\App\Http\Extras\PermExtras', 'beforeSaveCreate')
){
\App\Http\Extras\PermExtras::beforeSaveCreate($request,$Perms);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PermExtras') &&
method_exists('\App\Http\Extras\PermExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\PermExtras::canCreate($request, $Perms);
}catch (\Throwable $e){

}

}


if($canSave){
$Perms->save();
}else{
return response()->json($Perms, 200);
}

$Perms=Perm::find($Perms->id);
$newCrudData=[];

                $newCrudData['permission_label']=$Perms->permission_label;
                $newCrudData['permission_nom']=$Perms->permission_nom;
                $newCrudData['permission_id']=$Perms->permission_id;
                    $newCrudData['user_id']=$Perms->user_id;
                $newCrudData['nom']=$Perms->nom;
                $newCrudData['prenom']=$Perms->prenom;
                $newCrudData['type']=$Perms->type;
            
 try{ $newCrudData['permission']=$Perms->permission->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Perms->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Perms','entite_cle' => $Perms->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Perms->toArray();




try{

foreach ($Perms->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Perm $Perms)
{
try{
$can=\App\Helpers\Helpers::can('Editer des perms');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['permission_label']=$Perms->permission_label;
                $oldCrudData['permission_nom']=$Perms->permission_nom;
                $oldCrudData['permission_id']=$Perms->permission_id;
                    $oldCrudData['user_id']=$Perms->user_id;
                $oldCrudData['nom']=$Perms->nom;
                $oldCrudData['prenom']=$Perms->prenom;
                $oldCrudData['type']=$Perms->type;
            
 try{ $oldCrudData['permission']=$Perms->permission->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Perms->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "perms"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'permission_label',
    'permission_nom',
    'permission_id',
    'updated_at',
    'user_id',
    'nom',
    'prenom',
    'type',
    'deleted_at',
    'created_at',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'permission_label' => [
            //'required'
            ],
        
    
    
                    'permission_nom' => [
            //'required'
            ],
        
    
    
                    'permission_id' => [
            //'required'
            ],
        
    
    
    
    
                    'nom' => ['required'],
        
    
    
                    'prenom' => ['required'],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
    


], $messages = [

    
    
        'permission_label' => ['cette donnee est obligatoire'],

    
    
        'permission_nom' => ['cette donnee est obligatoire'],

    
    
        'permission_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'nom' => ['cette donnee est obligatoire'],

    
    
        'prenom' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("permission_label",$data)){


        if(!empty($data['permission_label'])){
        
            $Perms->permission_label = $data['permission_label'];
        
        }

        }

    







    

        if(array_key_exists("permission_nom",$data)){


        if(!empty($data['permission_nom'])){
        
            $Perms->permission_nom = $data['permission_nom'];
        
        }

        }

    







    

        if(array_key_exists("permission_id",$data)){


        if(!empty($data['permission_id'])){
        
            $Perms->permission_id = $data['permission_id'];
        
        }

        }

    







    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Perms->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("nom",$data)){


        if(!empty($data['nom'])){
        
            $Perms->nom = $data['nom'];
        
        }

        }

    







    

        if(array_key_exists("prenom",$data)){


        if(!empty($data['prenom'])){
        
            $Perms->prenom = $data['prenom'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Perms->type = $data['type'];
        
        }

        }

    







    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Perms->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\PermExtras') &&
method_exists('\App\Http\Extras\PermExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\PermExtras::beforeSaveUpdate($request,$Perms);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PermExtras') &&
method_exists('\App\Http\Extras\PermExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\PermExtras::canUpdate($request, $Perms);
}catch (\Throwable $e){

}

}


if($canSave){
$Perms->save();
}else{
return response()->json($Perms, 200);

}


$Perms=Perm::find($Perms->id);



$newCrudData=[];

                $newCrudData['permission_label']=$Perms->permission_label;
                $newCrudData['permission_nom']=$Perms->permission_nom;
                $newCrudData['permission_id']=$Perms->permission_id;
                    $newCrudData['user_id']=$Perms->user_id;
                $newCrudData['nom']=$Perms->nom;
                $newCrudData['prenom']=$Perms->prenom;
                $newCrudData['type']=$Perms->type;
            
 try{ $newCrudData['permission']=$Perms->permission->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Perms->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Perms','entite_cle' => $Perms->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Perms->toArray();




try{

foreach ($Perms->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Perm $Perms)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des perms');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['permission_label']=$Perms->permission_label;
                $newCrudData['permission_nom']=$Perms->permission_nom;
                $newCrudData['permission_id']=$Perms->permission_id;
                    $newCrudData['user_id']=$Perms->user_id;
                $newCrudData['nom']=$Perms->nom;
                $newCrudData['prenom']=$Perms->prenom;
                $newCrudData['type']=$Perms->type;
            
 try{ $newCrudData['permission']=$Perms->permission->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Perms->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Perms','entite_cle' => $Perms->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\PermExtras') &&
method_exists('\App\Http\Extras\PermExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\PermExtras::canDelete($request, $Perms);
}catch (\Throwable $e){

}

}



if($canSave){
$Perms->delete();
}else{
return response()->json($Perms, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\PermsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
