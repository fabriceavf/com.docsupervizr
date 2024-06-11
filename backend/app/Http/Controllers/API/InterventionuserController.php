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
// use App\Repository\prod\InterventionusersRepository;
use App\Models\Interventionuser;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Intervention;
        
class InterventionuserController extends Controller
{

private $InterventionusersRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\InterventionusersRepository $InterventionusersRepository
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
class_exists('\App\Http\Extras\InterventionuserExtras') &&
method_exists('\App\Http\Extras\InterventionuserExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\InterventionuserExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Interventionuser::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\InterventionuserExtras') &&
method_exists('\App\Http\Extras\InterventionuserExtras', 'filterAgGridQuery')
){
\App\Http\Extras\InterventionuserExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('interventionusers',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\InterventionuserExtras') &&
method_exists('\App\Http\Extras\InterventionuserExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\InterventionuserExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  interventionusers reussi',
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
return response()->json(Interventionuser::count());
}
$data = QueryBuilder::for(Interventionuser::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('intervention_id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('statut'),

    
    
    
    
    
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

    
            AllowedSort::field('intervention_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('statut'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'interventiondetails',
        

    
            'intervention',
        

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




$data = QueryBuilder::for(Interventionuser::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('intervention_id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('statut'),

    
    
    
    
    
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

    
            AllowedSort::field('intervention_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('statut'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'interventiondetails',
        

                'intervention',
        

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



public function create(Request $request, Interventionuser $Interventionusers)
{


try{
$can=\App\Helpers\Helpers::can('Creer des interventionusers');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "interventionusers"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'intervention_id',
    'user_id',
    'statut',
    'created_at',
    'updated_at',
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
    
    
                    'intervention_id' => [
            //'required'
            ],
        
    
    
    
                    'statut' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'intervention_id' => ['cette donnee est obligatoire'],

    
    
    
        'statut' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['intervention_id'])){
        
            $Interventionusers->intervention_id = $data['intervention_id'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Interventionusers->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['statut'])){
        
            $Interventionusers->statut = $data['statut'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Interventionusers->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Interventionusers->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Interventionusers->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\InterventionuserExtras') &&
method_exists('\App\Http\Extras\InterventionuserExtras', 'beforeSaveCreate')
){
\App\Http\Extras\InterventionuserExtras::beforeSaveCreate($request,$Interventionusers);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\InterventionuserExtras') &&
method_exists('\App\Http\Extras\InterventionuserExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\InterventionuserExtras::canCreate($request, $Interventionusers);
}catch (\Throwable $e){

}

}


if($canSave){
$Interventionusers->save();
}else{
return response()->json($Interventionusers, 200);
}

$Interventionusers=Interventionuser::find($Interventionusers->id);
$newCrudData=[];

                $newCrudData['intervention_id']=$Interventionusers->intervention_id;
                $newCrudData['user_id']=$Interventionusers->user_id;
                $newCrudData['statut']=$Interventionusers->statut;
                                $newCrudData['identifiants_sadge']=$Interventionusers->identifiants_sadge;
                $newCrudData['creat_by']=$Interventionusers->creat_by;
    
 try{ $newCrudData['intervention']=$Interventionusers->intervention->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Interventionusers->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Interventionusers','entite_cle' => $Interventionusers->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Interventionusers->toArray();




try{

foreach ($Interventionusers->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Interventionuser $Interventionusers)
{
try{
$can=\App\Helpers\Helpers::can('Editer des interventionusers');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['intervention_id']=$Interventionusers->intervention_id;
                $oldCrudData['user_id']=$Interventionusers->user_id;
                $oldCrudData['statut']=$Interventionusers->statut;
                                $oldCrudData['identifiants_sadge']=$Interventionusers->identifiants_sadge;
                $oldCrudData['creat_by']=$Interventionusers->creat_by;
    
 try{ $oldCrudData['intervention']=$Interventionusers->intervention->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Interventionusers->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "interventionusers"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'intervention_id',
    'user_id',
    'statut',
    'created_at',
    'updated_at',
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
    
    
                    'intervention_id' => [
            //'required'
            ],
        
    
    
    
                    'statut' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'intervention_id' => ['cette donnee est obligatoire'],

    
    
    
        'statut' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("intervention_id",$data)){


        if(!empty($data['intervention_id'])){
        
            $Interventionusers->intervention_id = $data['intervention_id'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Interventionusers->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("statut",$data)){


        if(!empty($data['statut'])){
        
            $Interventionusers->statut = $data['statut'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Interventionusers->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Interventionusers->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Interventionusers->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\InterventionuserExtras') &&
method_exists('\App\Http\Extras\InterventionuserExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\InterventionuserExtras::beforeSaveUpdate($request,$Interventionusers);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\InterventionuserExtras') &&
method_exists('\App\Http\Extras\InterventionuserExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\InterventionuserExtras::canUpdate($request, $Interventionusers);
}catch (\Throwable $e){

}

}


if($canSave){
$Interventionusers->save();
}else{
return response()->json($Interventionusers, 200);

}


$Interventionusers=Interventionuser::find($Interventionusers->id);



$newCrudData=[];

                $newCrudData['intervention_id']=$Interventionusers->intervention_id;
                $newCrudData['user_id']=$Interventionusers->user_id;
                $newCrudData['statut']=$Interventionusers->statut;
                                $newCrudData['identifiants_sadge']=$Interventionusers->identifiants_sadge;
                $newCrudData['creat_by']=$Interventionusers->creat_by;
    
 try{ $newCrudData['intervention']=$Interventionusers->intervention->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Interventionusers->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Interventionusers','entite_cle' => $Interventionusers->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Interventionusers->toArray();




try{

foreach ($Interventionusers->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Interventionuser $Interventionusers)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des interventionusers');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['intervention_id']=$Interventionusers->intervention_id;
                $newCrudData['user_id']=$Interventionusers->user_id;
                $newCrudData['statut']=$Interventionusers->statut;
                                $newCrudData['identifiants_sadge']=$Interventionusers->identifiants_sadge;
                $newCrudData['creat_by']=$Interventionusers->creat_by;
    
 try{ $newCrudData['intervention']=$Interventionusers->intervention->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Interventionusers->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Interventionusers','entite_cle' => $Interventionusers->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\InterventionuserExtras') &&
method_exists('\App\Http\Extras\InterventionuserExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\InterventionuserExtras::canDelete($request, $Interventionusers);
}catch (\Throwable $e){

}

}



if($canSave){
$Interventionusers->delete();
}else{
return response()->json($Interventionusers, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\InterventionusersActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
