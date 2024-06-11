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
// use App\Repository\prod\CrudsRepository;
use App\Models\Crud;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



    
class CrudController extends Controller
{

private $CrudsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\CrudsRepository $CrudsRepository
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
class_exists('\App\Http\Extras\CrudExtras') &&
method_exists('\App\Http\Extras\CrudExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\CrudExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Crud::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\CrudExtras') &&
method_exists('\App\Http\Extras\CrudExtras', 'filterAgGridQuery')
){
\App\Http\Extras\CrudExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('cruds',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\CrudExtras') &&
method_exists('\App\Http\Extras\CrudExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\CrudExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  cruds reussi',
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
return response()->json(Crud::count());
}
$data = QueryBuilder::for(Crud::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('action'),

    
            AllowedFilter::exact('entite'),

    
            AllowedFilter::exact('entite_cle'),

    
            AllowedFilter::exact('ancien'),

    
            AllowedFilter::exact('nouveau'),

    
            AllowedFilter::exact('user_id'),

    
    
    
    
    
            AllowedFilter::exact('Detail'),

    
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

    
            AllowedSort::field('action'),

    
            AllowedSort::field('entite'),

    
            AllowedSort::field('entite_cle'),

    
            AllowedSort::field('ancien'),

    
            AllowedSort::field('nouveau'),

    
            AllowedSort::field('user_id'),

    
    
    
    
    
            AllowedSort::field('Detail'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([

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




$data = QueryBuilder::for(Crud::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('action'),

    
            AllowedFilter::exact('entite'),

    
            AllowedFilter::exact('entite_cle'),

    
            AllowedFilter::exact('ancien'),

    
            AllowedFilter::exact('nouveau'),

    
            AllowedFilter::exact('user_id'),

    
    
    
    
    
            AllowedFilter::exact('Detail'),

    
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

    
            AllowedSort::field('action'),

    
            AllowedSort::field('entite'),

    
            AllowedSort::field('entite_cle'),

    
            AllowedSort::field('ancien'),

    
            AllowedSort::field('nouveau'),

    
            AllowedSort::field('user_id'),

    
    
    
    
    
            AllowedSort::field('Detail'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
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



public function create(Request $request, Crud $Cruds)
{


try{
$can=\App\Helpers\Helpers::can('Creer des cruds');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "cruds"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'action',
    'entite',
    'entite_cle',
    'ancien',
    'nouveau',
    'user_id',
    'created_at',
    'updated_at',
    'deleted_at',
    'extra_attributes',
    'Detail',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'action' => [
            //'required'
            ],
        
    
    
                    'entite' => [
            //'required'
            ],
        
    
    
                    'entite_cle' => [
            //'required'
            ],
        
    
    
                    'ancien' => [
            //'required'
            ],
        
    
    
                    'nouveau' => [
            //'required'
            ],
        
    
    
    
    
    
    
    
                    'Detail' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'action' => ['cette donnee est obligatoire'],

    
    
        'entite' => ['cette donnee est obligatoire'],

    
    
        'entite_cle' => ['cette donnee est obligatoire'],

    
    
        'ancien' => ['cette donnee est obligatoire'],

    
    
        'nouveau' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
    
        'Detail' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['action'])){
        
            $Cruds->action = $data['action'];
        
        }



    







    

        if(!empty($data['entite'])){
        
            $Cruds->entite = $data['entite'];
        
        }



    







    

        if(!empty($data['entite_cle'])){
        
            $Cruds->entite_cle = $data['entite_cle'];
        
        }



    







    

        if(!empty($data['ancien'])){
        
            $Cruds->ancien = $data['ancien'];
        
        }



    







    

        if(!empty($data['nouveau'])){
        
            $Cruds->nouveau = $data['nouveau'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Cruds->user_id = $data['user_id'];
        
        }



    







    







    







    







    







    

        if(!empty($data['Detail'])){
        
            $Cruds->Detail = $data['Detail'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Cruds->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Cruds->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Cruds->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\CrudExtras') &&
method_exists('\App\Http\Extras\CrudExtras', 'beforeSaveCreate')
){
\App\Http\Extras\CrudExtras::beforeSaveCreate($request,$Cruds);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\CrudExtras') &&
method_exists('\App\Http\Extras\CrudExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\CrudExtras::canCreate($request, $Cruds);
}catch (\Throwable $e){

}

}


if($canSave){
$Cruds->save();
}else{
return response()->json($Cruds, 200);
}

$Cruds=Crud::find($Cruds->id);
$newCrudData=[];

                $newCrudData['action']=$Cruds->action;
                $newCrudData['entite']=$Cruds->entite;
                $newCrudData['entite_cle']=$Cruds->entite_cle;
                $newCrudData['ancien']=$Cruds->ancien;
                $newCrudData['nouveau']=$Cruds->nouveau;
                $newCrudData['user_id']=$Cruds->user_id;
                                $newCrudData['Detail']=$Cruds->Detail;
                $newCrudData['identifiants_sadge']=$Cruds->identifiants_sadge;
                $newCrudData['creat_by']=$Cruds->creat_by;
    
 try{ $newCrudData['user']=$Cruds->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Cruds','entite_cle' => $Cruds->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Cruds->toArray();




try{

foreach ($Cruds->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Crud $Cruds)
{
try{
$can=\App\Helpers\Helpers::can('Editer des cruds');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['action']=$Cruds->action;
                $oldCrudData['entite']=$Cruds->entite;
                $oldCrudData['entite_cle']=$Cruds->entite_cle;
                $oldCrudData['ancien']=$Cruds->ancien;
                $oldCrudData['nouveau']=$Cruds->nouveau;
                $oldCrudData['user_id']=$Cruds->user_id;
                                $oldCrudData['Detail']=$Cruds->Detail;
                $oldCrudData['identifiants_sadge']=$Cruds->identifiants_sadge;
                $oldCrudData['creat_by']=$Cruds->creat_by;
    
 try{ $oldCrudData['user']=$Cruds->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "cruds"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'action',
    'entite',
    'entite_cle',
    'ancien',
    'nouveau',
    'user_id',
    'created_at',
    'updated_at',
    'deleted_at',
    'extra_attributes',
    'Detail',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'action' => [
            //'required'
            ],
        
    
    
                    'entite' => [
            //'required'
            ],
        
    
    
                    'entite_cle' => [
            //'required'
            ],
        
    
    
                    'ancien' => [
            //'required'
            ],
        
    
    
                    'nouveau' => [
            //'required'
            ],
        
    
    
    
    
    
    
    
                    'Detail' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'action' => ['cette donnee est obligatoire'],

    
    
        'entite' => ['cette donnee est obligatoire'],

    
    
        'entite_cle' => ['cette donnee est obligatoire'],

    
    
        'ancien' => ['cette donnee est obligatoire'],

    
    
        'nouveau' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
    
        'Detail' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("action",$data)){


        if(!empty($data['action'])){
        
            $Cruds->action = $data['action'];
        
        }

        }

    







    

        if(array_key_exists("entite",$data)){


        if(!empty($data['entite'])){
        
            $Cruds->entite = $data['entite'];
        
        }

        }

    







    

        if(array_key_exists("entite_cle",$data)){


        if(!empty($data['entite_cle'])){
        
            $Cruds->entite_cle = $data['entite_cle'];
        
        }

        }

    







    

        if(array_key_exists("ancien",$data)){


        if(!empty($data['ancien'])){
        
            $Cruds->ancien = $data['ancien'];
        
        }

        }

    







    

        if(array_key_exists("nouveau",$data)){


        if(!empty($data['nouveau'])){
        
            $Cruds->nouveau = $data['nouveau'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Cruds->user_id = $data['user_id'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("Detail",$data)){


        if(!empty($data['Detail'])){
        
            $Cruds->Detail = $data['Detail'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Cruds->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Cruds->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Cruds->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\CrudExtras') &&
method_exists('\App\Http\Extras\CrudExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\CrudExtras::beforeSaveUpdate($request,$Cruds);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\CrudExtras') &&
method_exists('\App\Http\Extras\CrudExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\CrudExtras::canUpdate($request, $Cruds);
}catch (\Throwable $e){

}

}


if($canSave){
$Cruds->save();
}else{
return response()->json($Cruds, 200);

}


$Cruds=Crud::find($Cruds->id);



$newCrudData=[];

                $newCrudData['action']=$Cruds->action;
                $newCrudData['entite']=$Cruds->entite;
                $newCrudData['entite_cle']=$Cruds->entite_cle;
                $newCrudData['ancien']=$Cruds->ancien;
                $newCrudData['nouveau']=$Cruds->nouveau;
                $newCrudData['user_id']=$Cruds->user_id;
                                $newCrudData['Detail']=$Cruds->Detail;
                $newCrudData['identifiants_sadge']=$Cruds->identifiants_sadge;
                $newCrudData['creat_by']=$Cruds->creat_by;
    
 try{ $newCrudData['user']=$Cruds->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Cruds','entite_cle' => $Cruds->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Cruds->toArray();




try{

foreach ($Cruds->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Crud $Cruds)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des cruds');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['action']=$Cruds->action;
                $newCrudData['entite']=$Cruds->entite;
                $newCrudData['entite_cle']=$Cruds->entite_cle;
                $newCrudData['ancien']=$Cruds->ancien;
                $newCrudData['nouveau']=$Cruds->nouveau;
                $newCrudData['user_id']=$Cruds->user_id;
                                $newCrudData['Detail']=$Cruds->Detail;
                $newCrudData['identifiants_sadge']=$Cruds->identifiants_sadge;
                $newCrudData['creat_by']=$Cruds->creat_by;
    
 try{ $newCrudData['user']=$Cruds->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Cruds','entite_cle' => $Cruds->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\CrudExtras') &&
method_exists('\App\Http\Extras\CrudExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\CrudExtras::canDelete($request, $Cruds);
}catch (\Throwable $e){

}

}



if($canSave){
$Cruds->delete();
}else{
return response()->json($Cruds, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\CrudsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
