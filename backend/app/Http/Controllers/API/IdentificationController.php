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
// use App\Repository\prod\IdentificationsRepository;
use App\Models\Identification;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Carte;
        
class IdentificationController extends Controller
{

private $IdentificationsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\IdentificationsRepository $IdentificationsRepository
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
class_exists('\App\Http\Extras\IdentificationExtras') &&
method_exists('\App\Http\Extras\IdentificationExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\IdentificationExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Identification::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\IdentificationExtras') &&
method_exists('\App\Http\Extras\IdentificationExtras', 'filterAgGridQuery')
){
\App\Http\Extras\IdentificationExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('identifications',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\IdentificationExtras') &&
method_exists('\App\Http\Extras\IdentificationExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\IdentificationExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  identifications reussi',
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
return response()->json(Identification::count());
}
$data = QueryBuilder::for(Identification::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('carte_id'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('date_fin'),

    
            AllowedFilter::exact('statuts'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
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

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('carte_id'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('date_fin'),

    
            AllowedSort::field('statuts'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
->allowedIncludes([
            'credits',
        

                'debits',
        

                'transactions',
        

    
            'carte',
        

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




$data = QueryBuilder::for(Identification::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('carte_id'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('date_fin'),

    
            AllowedFilter::exact('statuts'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
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

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('carte_id'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('date_fin'),

    
            AllowedSort::field('statuts'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
->allowedIncludes([
            'credits',
        

                'debits',
        

                'transactions',
        

                'carte',
        

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



public function create(Request $request, Identification $Identifications)
{


try{
$can=\App\Helpers\Helpers::can('Creer des identifications');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "identifications"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'carte_id',
    'date_debut',
    'date_fin',
    'statuts',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
    
                    'carte_id' => [
            //'required'
            ],
        
    
    
                    'date_debut' => [
            //'required'
            ],
        
    
    
                    'date_fin' => [
            //'required'
            ],
        
    
    
                    'statuts' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
    
        'carte_id' => ['cette donnee est obligatoire'],

    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'date_fin' => ['cette donnee est obligatoire'],

    
    
        'statuts' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['user_id'])){
        
            $Identifications->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['carte_id'])){
        
            $Identifications->carte_id = $data['carte_id'];
        
        }



    







    

        if(!empty($data['date_debut'])){
        
            $Identifications->date_debut = $data['date_debut'];
        
        }



    







    

        if(!empty($data['date_fin'])){
        
            $Identifications->date_fin = $data['date_fin'];
        
        }



    







    

        if(!empty($data['statuts'])){
        
            $Identifications->statuts = $data['statuts'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Identifications->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Identifications->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Identifications->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\IdentificationExtras') &&
method_exists('\App\Http\Extras\IdentificationExtras', 'beforeSaveCreate')
){
\App\Http\Extras\IdentificationExtras::beforeSaveCreate($request,$Identifications);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\IdentificationExtras') &&
method_exists('\App\Http\Extras\IdentificationExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\IdentificationExtras::canCreate($request, $Identifications);
}catch (\Throwable $e){

}

}


if($canSave){
$Identifications->save();
}else{
return response()->json($Identifications, 200);
}

$Identifications=Identification::find($Identifications->id);
$newCrudData=[];

                $newCrudData['user_id']=$Identifications->user_id;
                $newCrudData['carte_id']=$Identifications->carte_id;
                $newCrudData['date_debut']=$Identifications->date_debut;
                $newCrudData['date_fin']=$Identifications->date_fin;
                $newCrudData['statuts']=$Identifications->statuts;
                $newCrudData['creat_by']=$Identifications->creat_by;
                                $newCrudData['identifiants_sadge']=$Identifications->identifiants_sadge;
    
 try{ $newCrudData['carte']=$Identifications->carte->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Identifications->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Identifications','entite_cle' => $Identifications->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Identifications->toArray();




try{

foreach ($Identifications->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Identification $Identifications)
{
try{
$can=\App\Helpers\Helpers::can('Editer des identifications');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['user_id']=$Identifications->user_id;
                $oldCrudData['carte_id']=$Identifications->carte_id;
                $oldCrudData['date_debut']=$Identifications->date_debut;
                $oldCrudData['date_fin']=$Identifications->date_fin;
                $oldCrudData['statuts']=$Identifications->statuts;
                $oldCrudData['creat_by']=$Identifications->creat_by;
                                $oldCrudData['identifiants_sadge']=$Identifications->identifiants_sadge;
    
 try{ $oldCrudData['carte']=$Identifications->carte->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Identifications->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "identifications"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'carte_id',
    'date_debut',
    'date_fin',
    'statuts',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
    
                    'carte_id' => [
            //'required'
            ],
        
    
    
                    'date_debut' => [
            //'required'
            ],
        
    
    
                    'date_fin' => [
            //'required'
            ],
        
    
    
                    'statuts' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
    
        'carte_id' => ['cette donnee est obligatoire'],

    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'date_fin' => ['cette donnee est obligatoire'],

    
    
        'statuts' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Identifications->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("carte_id",$data)){


        if(!empty($data['carte_id'])){
        
            $Identifications->carte_id = $data['carte_id'];
        
        }

        }

    







    

        if(array_key_exists("date_debut",$data)){


        if(!empty($data['date_debut'])){
        
            $Identifications->date_debut = $data['date_debut'];
        
        }

        }

    







    

        if(array_key_exists("date_fin",$data)){


        if(!empty($data['date_fin'])){
        
            $Identifications->date_fin = $data['date_fin'];
        
        }

        }

    







    

        if(array_key_exists("statuts",$data)){


        if(!empty($data['statuts'])){
        
            $Identifications->statuts = $data['statuts'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Identifications->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Identifications->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Identifications->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\IdentificationExtras') &&
method_exists('\App\Http\Extras\IdentificationExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\IdentificationExtras::beforeSaveUpdate($request,$Identifications);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\IdentificationExtras') &&
method_exists('\App\Http\Extras\IdentificationExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\IdentificationExtras::canUpdate($request, $Identifications);
}catch (\Throwable $e){

}

}


if($canSave){
$Identifications->save();
}else{
return response()->json($Identifications, 200);

}


$Identifications=Identification::find($Identifications->id);



$newCrudData=[];

                $newCrudData['user_id']=$Identifications->user_id;
                $newCrudData['carte_id']=$Identifications->carte_id;
                $newCrudData['date_debut']=$Identifications->date_debut;
                $newCrudData['date_fin']=$Identifications->date_fin;
                $newCrudData['statuts']=$Identifications->statuts;
                $newCrudData['creat_by']=$Identifications->creat_by;
                                $newCrudData['identifiants_sadge']=$Identifications->identifiants_sadge;
    
 try{ $newCrudData['carte']=$Identifications->carte->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Identifications->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Identifications','entite_cle' => $Identifications->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Identifications->toArray();




try{

foreach ($Identifications->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Identification $Identifications)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des identifications');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['user_id']=$Identifications->user_id;
                $newCrudData['carte_id']=$Identifications->carte_id;
                $newCrudData['date_debut']=$Identifications->date_debut;
                $newCrudData['date_fin']=$Identifications->date_fin;
                $newCrudData['statuts']=$Identifications->statuts;
                $newCrudData['creat_by']=$Identifications->creat_by;
                                $newCrudData['identifiants_sadge']=$Identifications->identifiants_sadge;
    
 try{ $newCrudData['carte']=$Identifications->carte->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Identifications->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Identifications','entite_cle' => $Identifications->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\IdentificationExtras') &&
method_exists('\App\Http\Extras\IdentificationExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\IdentificationExtras::canDelete($request, $Identifications);
}catch (\Throwable $e){

}

}



if($canSave){
$Identifications->delete();
}else{
return response()->json($Identifications, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\IdentificationsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
