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
// use App\Repository\prod\VehiculesRepository;
use App\Models\Vehicule;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;




class VehiculeController extends Controller
{

private $VehiculesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\VehiculesRepository $VehiculesRepository
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
class_exists('\App\Http\Extras\VehiculeExtras') &&
method_exists('\App\Http\Extras\VehiculeExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\VehiculeExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Vehicule::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\VehiculeExtras') &&
method_exists('\App\Http\Extras\VehiculeExtras', 'filterAgGridQuery')
){
\App\Http\Extras\VehiculeExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('vehicules',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\VehiculeExtras') &&
method_exists('\App\Http\Extras\VehiculeExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\VehiculeExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  vehicules reussi',
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
return response()->json(Vehicule::count());
}
$data = QueryBuilder::for(Vehicule::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('marque'),

    
            AllowedFilter::exact('modele'),

    
            AllowedFilter::exact('generation'),

    
            AllowedFilter::exact('serie'),

    
            AllowedFilter::exact('valeur'),

    
            AllowedFilter::exact('moteur'),

    
            AllowedFilter::exact('poids'),

    
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

    
            AllowedSort::field('code'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('marque'),

    
            AllowedSort::field('modele'),

    
            AllowedSort::field('generation'),

    
            AllowedSort::field('serie'),

    
            AllowedSort::field('valeur'),

    
            AllowedSort::field('moteur'),

    
            AllowedSort::field('poids'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
->allowedIncludes([

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




$data = QueryBuilder::for(Vehicule::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('marque'),

    
            AllowedFilter::exact('modele'),

    
            AllowedFilter::exact('generation'),

    
            AllowedFilter::exact('serie'),

    
            AllowedFilter::exact('valeur'),

    
            AllowedFilter::exact('moteur'),

    
            AllowedFilter::exact('poids'),

    
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

    
            AllowedSort::field('code'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('marque'),

    
            AllowedSort::field('modele'),

    
            AllowedSort::field('generation'),

    
            AllowedSort::field('serie'),

    
            AllowedSort::field('valeur'),

    
            AllowedSort::field('moteur'),

    
            AllowedSort::field('poids'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
->allowedIncludes([
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



public function create(Request $request, Vehicule $Vehicules)
{


try{
$can=\App\Helpers\Helpers::can('Creer des vehicules');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "vehicules"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'type',
    'marque',
    'modele',
    'generation',
    'serie',
    'valeur',
    'moteur',
    'poids',
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
    
    
                    'code' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'marque' => [
            //'required'
            ],
        
    
    
                    'modele' => [
            //'required'
            ],
        
    
    
                    'generation' => [
            //'required'
            ],
        
    
    
                    'serie' => [
            //'required'
            ],
        
    
    
                    'valeur' => [
            //'required'
            ],
        
    
    
                    'moteur' => [
            //'required'
            ],
        
    
    
                    'poids' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'marque' => ['cette donnee est obligatoire'],

    
    
        'modele' => ['cette donnee est obligatoire'],

    
    
        'generation' => ['cette donnee est obligatoire'],

    
    
        'serie' => ['cette donnee est obligatoire'],

    
    
        'valeur' => ['cette donnee est obligatoire'],

    
    
        'moteur' => ['cette donnee est obligatoire'],

    
    
        'poids' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['code'])){
        
            $Vehicules->code = $data['code'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Vehicules->type = $data['type'];
        
        }



    







    

        if(!empty($data['marque'])){
        
            $Vehicules->marque = $data['marque'];
        
        }



    







    

        if(!empty($data['modele'])){
        
            $Vehicules->modele = $data['modele'];
        
        }



    







    

        if(!empty($data['generation'])){
        
            $Vehicules->generation = $data['generation'];
        
        }



    







    

        if(!empty($data['serie'])){
        
            $Vehicules->serie = $data['serie'];
        
        }



    







    

        if(!empty($data['valeur'])){
        
            $Vehicules->valeur = $data['valeur'];
        
        }



    







    

        if(!empty($data['moteur'])){
        
            $Vehicules->moteur = $data['moteur'];
        
        }



    







    

        if(!empty($data['poids'])){
        
            $Vehicules->poids = $data['poids'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Vehicules->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Vehicules->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Vehicules->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\VehiculeExtras') &&
method_exists('\App\Http\Extras\VehiculeExtras', 'beforeSaveCreate')
){
\App\Http\Extras\VehiculeExtras::beforeSaveCreate($request,$Vehicules);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\VehiculeExtras') &&
method_exists('\App\Http\Extras\VehiculeExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\VehiculeExtras::canCreate($request, $Vehicules);
}catch (\Throwable $e){

}

}


if($canSave){
$Vehicules->save();
}else{
return response()->json($Vehicules, 200);
}

$Vehicules=Vehicule::find($Vehicules->id);
$newCrudData=[];

                $newCrudData['code']=$Vehicules->code;
                $newCrudData['type']=$Vehicules->type;
                $newCrudData['marque']=$Vehicules->marque;
                $newCrudData['modele']=$Vehicules->modele;
                $newCrudData['generation']=$Vehicules->generation;
                $newCrudData['serie']=$Vehicules->serie;
                $newCrudData['valeur']=$Vehicules->valeur;
                $newCrudData['moteur']=$Vehicules->moteur;
                $newCrudData['poids']=$Vehicules->poids;
                $newCrudData['creat_by']=$Vehicules->creat_by;
                                $newCrudData['identifiants_sadge']=$Vehicules->identifiants_sadge;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Vehicules','entite_cle' => $Vehicules->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Vehicules->toArray();




try{

foreach ($Vehicules->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Vehicule $Vehicules)
{
try{
$can=\App\Helpers\Helpers::can('Editer des vehicules');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['code']=$Vehicules->code;
                $oldCrudData['type']=$Vehicules->type;
                $oldCrudData['marque']=$Vehicules->marque;
                $oldCrudData['modele']=$Vehicules->modele;
                $oldCrudData['generation']=$Vehicules->generation;
                $oldCrudData['serie']=$Vehicules->serie;
                $oldCrudData['valeur']=$Vehicules->valeur;
                $oldCrudData['moteur']=$Vehicules->moteur;
                $oldCrudData['poids']=$Vehicules->poids;
                $oldCrudData['creat_by']=$Vehicules->creat_by;
                                $oldCrudData['identifiants_sadge']=$Vehicules->identifiants_sadge;
    


$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "vehicules"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'type',
    'marque',
    'modele',
    'generation',
    'serie',
    'valeur',
    'moteur',
    'poids',
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
    
    
                    'code' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'marque' => [
            //'required'
            ],
        
    
    
                    'modele' => [
            //'required'
            ],
        
    
    
                    'generation' => [
            //'required'
            ],
        
    
    
                    'serie' => [
            //'required'
            ],
        
    
    
                    'valeur' => [
            //'required'
            ],
        
    
    
                    'moteur' => [
            //'required'
            ],
        
    
    
                    'poids' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'marque' => ['cette donnee est obligatoire'],

    
    
        'modele' => ['cette donnee est obligatoire'],

    
    
        'generation' => ['cette donnee est obligatoire'],

    
    
        'serie' => ['cette donnee est obligatoire'],

    
    
        'valeur' => ['cette donnee est obligatoire'],

    
    
        'moteur' => ['cette donnee est obligatoire'],

    
    
        'poids' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("code",$data)){


        if(!empty($data['code'])){
        
            $Vehicules->code = $data['code'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Vehicules->type = $data['type'];
        
        }

        }

    







    

        if(array_key_exists("marque",$data)){


        if(!empty($data['marque'])){
        
            $Vehicules->marque = $data['marque'];
        
        }

        }

    







    

        if(array_key_exists("modele",$data)){


        if(!empty($data['modele'])){
        
            $Vehicules->modele = $data['modele'];
        
        }

        }

    







    

        if(array_key_exists("generation",$data)){


        if(!empty($data['generation'])){
        
            $Vehicules->generation = $data['generation'];
        
        }

        }

    







    

        if(array_key_exists("serie",$data)){


        if(!empty($data['serie'])){
        
            $Vehicules->serie = $data['serie'];
        
        }

        }

    







    

        if(array_key_exists("valeur",$data)){


        if(!empty($data['valeur'])){
        
            $Vehicules->valeur = $data['valeur'];
        
        }

        }

    







    

        if(array_key_exists("moteur",$data)){


        if(!empty($data['moteur'])){
        
            $Vehicules->moteur = $data['moteur'];
        
        }

        }

    







    

        if(array_key_exists("poids",$data)){


        if(!empty($data['poids'])){
        
            $Vehicules->poids = $data['poids'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Vehicules->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Vehicules->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Vehicules->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\VehiculeExtras') &&
method_exists('\App\Http\Extras\VehiculeExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\VehiculeExtras::beforeSaveUpdate($request,$Vehicules);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\VehiculeExtras') &&
method_exists('\App\Http\Extras\VehiculeExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\VehiculeExtras::canUpdate($request, $Vehicules);
}catch (\Throwable $e){

}

}


if($canSave){
$Vehicules->save();
}else{
return response()->json($Vehicules, 200);

}


$Vehicules=Vehicule::find($Vehicules->id);



$newCrudData=[];

                $newCrudData['code']=$Vehicules->code;
                $newCrudData['type']=$Vehicules->type;
                $newCrudData['marque']=$Vehicules->marque;
                $newCrudData['modele']=$Vehicules->modele;
                $newCrudData['generation']=$Vehicules->generation;
                $newCrudData['serie']=$Vehicules->serie;
                $newCrudData['valeur']=$Vehicules->valeur;
                $newCrudData['moteur']=$Vehicules->moteur;
                $newCrudData['poids']=$Vehicules->poids;
                $newCrudData['creat_by']=$Vehicules->creat_by;
                                $newCrudData['identifiants_sadge']=$Vehicules->identifiants_sadge;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Vehicules','entite_cle' => $Vehicules->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Vehicules->toArray();




try{

foreach ($Vehicules->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Vehicule $Vehicules)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des vehicules');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['code']=$Vehicules->code;
                $newCrudData['type']=$Vehicules->type;
                $newCrudData['marque']=$Vehicules->marque;
                $newCrudData['modele']=$Vehicules->modele;
                $newCrudData['generation']=$Vehicules->generation;
                $newCrudData['serie']=$Vehicules->serie;
                $newCrudData['valeur']=$Vehicules->valeur;
                $newCrudData['moteur']=$Vehicules->moteur;
                $newCrudData['poids']=$Vehicules->poids;
                $newCrudData['creat_by']=$Vehicules->creat_by;
                                $newCrudData['identifiants_sadge']=$Vehicules->identifiants_sadge;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Vehicules','entite_cle' => $Vehicules->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\VehiculeExtras') &&
method_exists('\App\Http\Extras\VehiculeExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\VehiculeExtras::canDelete($request, $Vehicules);
}catch (\Throwable $e){

}

}



if($canSave){
$Vehicules->delete();
}else{
return response()->json($Vehicules, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\VehiculesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
