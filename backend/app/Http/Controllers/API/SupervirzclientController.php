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
// use App\Repository\prod\SupervirzclientsRepository;
use App\Models\Supervirzclient;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;




class SupervirzclientController extends Controller
{

private $SupervirzclientsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\SupervirzclientsRepository $SupervirzclientsRepository
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
class_exists('\App\Http\Extras\SupervirzclientExtras') &&
method_exists('\App\Http\Extras\SupervirzclientExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\SupervirzclientExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Supervirzclient::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\SupervirzclientExtras') &&
method_exists('\App\Http\Extras\SupervirzclientExtras', 'filterAgGridQuery')
){
\App\Http\Extras\SupervirzclientExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('supervirzclients',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\SupervirzclientExtras') &&
method_exists('\App\Http\Extras\SupervirzclientExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\SupervirzclientExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  supervirzclients reussi',
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
return response()->json(Supervirzclient::count());
}
$data = QueryBuilder::for(Supervirzclient::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('nom'),

    
            AllowedFilter::exact('domaine'),

    
            AllowedFilter::exact('path'),

    
    
    
            AllowedFilter::exact('db_connection'),

    
            AllowedFilter::exact('db_host'),

    
            AllowedFilter::exact('db_port'),

    
            AllowedFilter::exact('db_database'),

    
            AllowedFilter::exact('db_username'),

    
            AllowedFilter::exact('db_password'),

    
    
    
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

    
            AllowedSort::field('domaine'),

    
            AllowedSort::field('path'),

    
    
    
            AllowedSort::field('db_connection'),

    
            AllowedSort::field('db_host'),

    
            AllowedSort::field('db_port'),

    
            AllowedSort::field('db_database'),

    
            AllowedSort::field('db_username'),

    
            AllowedSort::field('db_password'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
->allowedIncludes([
            'pointeuses',
        

                'supervirzclientshides',
        

    
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




$data = QueryBuilder::for(Supervirzclient::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('nom'),

    
            AllowedFilter::exact('domaine'),

    
            AllowedFilter::exact('path'),

    
    
    
            AllowedFilter::exact('db_connection'),

    
            AllowedFilter::exact('db_host'),

    
            AllowedFilter::exact('db_port'),

    
            AllowedFilter::exact('db_database'),

    
            AllowedFilter::exact('db_username'),

    
            AllowedFilter::exact('db_password'),

    
    
    
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

    
            AllowedSort::field('domaine'),

    
            AllowedSort::field('path'),

    
    
    
            AllowedSort::field('db_connection'),

    
            AllowedSort::field('db_host'),

    
            AllowedSort::field('db_port'),

    
            AllowedSort::field('db_database'),

    
            AllowedSort::field('db_username'),

    
            AllowedSort::field('db_password'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
->allowedIncludes([
            'pointeuses',
        

                'supervirzclientshides',
        

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



public function create(Request $request, Supervirzclient $Supervirzclients)
{


try{
$can=\App\Helpers\Helpers::can('Creer des supervirzclients');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "supervirzclients"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'nom',
    'domaine',
    'path',
    'created_at',
    'updated_at',
    'db_connection',
    'db_host',
    'db_port',
    'db_database',
    'db_username',
    'db_password',
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
    
    
                    'nom' => [
            //'required'
            ],
        
    
    
                    'domaine' => [
            //'required'
            ],
        
    
    
                    'path' => [
            //'required'
            ],
        
    
    
    
    
                    'db_connection' => [
            //'required'
            ],
        
    
    
                    'db_host' => [
            //'required'
            ],
        
    
    
                    'db_port' => [
            //'required'
            ],
        
    
    
                    'db_database' => [
            //'required'
            ],
        
    
    
                    'db_username' => [
            //'required'
            ],
        
    
    
                    'db_password' => [
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

    
    
        'domaine' => ['cette donnee est obligatoire'],

    
    
        'path' => ['cette donnee est obligatoire'],

    
    
    
    
        'db_connection' => ['cette donnee est obligatoire'],

    
    
        'db_host' => ['cette donnee est obligatoire'],

    
    
        'db_port' => ['cette donnee est obligatoire'],

    
    
        'db_database' => ['cette donnee est obligatoire'],

    
    
        'db_username' => ['cette donnee est obligatoire'],

    
    
        'db_password' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['nom'])){
        
            $Supervirzclients->nom = $data['nom'];
        
        }



    







    

        if(!empty($data['domaine'])){
        
            $Supervirzclients->domaine = $data['domaine'];
        
        }



    







    

        if(!empty($data['path'])){
        
            $Supervirzclients->path = $data['path'];
        
        }



    







    







    







    

        if(!empty($data['db_connection'])){
        
            $Supervirzclients->db_connection = $data['db_connection'];
        
        }



    







    

        if(!empty($data['db_host'])){
        
            $Supervirzclients->db_host = $data['db_host'];
        
        }



    







    

        if(!empty($data['db_port'])){
        
            $Supervirzclients->db_port = $data['db_port'];
        
        }



    







    

        if(!empty($data['db_database'])){
        
            $Supervirzclients->db_database = $data['db_database'];
        
        }



    







    

        if(!empty($data['db_username'])){
        
            $Supervirzclients->db_username = $data['db_username'];
        
        }



    







    

        if(!empty($data['db_password'])){
        
            $Supervirzclients->db_password = $data['db_password'];
        
        }



    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Supervirzclients->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Supervirzclients->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Supervirzclients->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\SupervirzclientExtras') &&
method_exists('\App\Http\Extras\SupervirzclientExtras', 'beforeSaveCreate')
){
\App\Http\Extras\SupervirzclientExtras::beforeSaveCreate($request,$Supervirzclients);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\SupervirzclientExtras') &&
method_exists('\App\Http\Extras\SupervirzclientExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\SupervirzclientExtras::canCreate($request, $Supervirzclients);
}catch (\Throwable $e){

}

}


if($canSave){
$Supervirzclients->save();
}else{
return response()->json($Supervirzclients, 200);
}

$Supervirzclients=Supervirzclient::find($Supervirzclients->id);
$newCrudData=[];

                $newCrudData['nom']=$Supervirzclients->nom;
                $newCrudData['domaine']=$Supervirzclients->domaine;
                $newCrudData['path']=$Supervirzclients->path;
                        $newCrudData['db_connection']=$Supervirzclients->db_connection;
                $newCrudData['db_host']=$Supervirzclients->db_host;
                $newCrudData['db_port']=$Supervirzclients->db_port;
                $newCrudData['db_database']=$Supervirzclients->db_database;
                $newCrudData['db_username']=$Supervirzclients->db_username;
                $newCrudData['db_password']=$Supervirzclients->db_password;
                        $newCrudData['identifiants_sadge']=$Supervirzclients->identifiants_sadge;
                $newCrudData['creat_by']=$Supervirzclients->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Supervirzclients','entite_cle' => $Supervirzclients->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Supervirzclients->toArray();




try{

foreach ($Supervirzclients->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Supervirzclient $Supervirzclients)
{
try{
$can=\App\Helpers\Helpers::can('Editer des supervirzclients');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['nom']=$Supervirzclients->nom;
                $oldCrudData['domaine']=$Supervirzclients->domaine;
                $oldCrudData['path']=$Supervirzclients->path;
                        $oldCrudData['db_connection']=$Supervirzclients->db_connection;
                $oldCrudData['db_host']=$Supervirzclients->db_host;
                $oldCrudData['db_port']=$Supervirzclients->db_port;
                $oldCrudData['db_database']=$Supervirzclients->db_database;
                $oldCrudData['db_username']=$Supervirzclients->db_username;
                $oldCrudData['db_password']=$Supervirzclients->db_password;
                        $oldCrudData['identifiants_sadge']=$Supervirzclients->identifiants_sadge;
                $oldCrudData['creat_by']=$Supervirzclients->creat_by;
    


$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "supervirzclients"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'nom',
    'domaine',
    'path',
    'created_at',
    'updated_at',
    'db_connection',
    'db_host',
    'db_port',
    'db_database',
    'db_username',
    'db_password',
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
    
    
                    'nom' => [
            //'required'
            ],
        
    
    
                    'domaine' => [
            //'required'
            ],
        
    
    
                    'path' => [
            //'required'
            ],
        
    
    
    
    
                    'db_connection' => [
            //'required'
            ],
        
    
    
                    'db_host' => [
            //'required'
            ],
        
    
    
                    'db_port' => [
            //'required'
            ],
        
    
    
                    'db_database' => [
            //'required'
            ],
        
    
    
                    'db_username' => [
            //'required'
            ],
        
    
    
                    'db_password' => [
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

    
    
        'domaine' => ['cette donnee est obligatoire'],

    
    
        'path' => ['cette donnee est obligatoire'],

    
    
    
    
        'db_connection' => ['cette donnee est obligatoire'],

    
    
        'db_host' => ['cette donnee est obligatoire'],

    
    
        'db_port' => ['cette donnee est obligatoire'],

    
    
        'db_database' => ['cette donnee est obligatoire'],

    
    
        'db_username' => ['cette donnee est obligatoire'],

    
    
        'db_password' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("nom",$data)){


        if(!empty($data['nom'])){
        
            $Supervirzclients->nom = $data['nom'];
        
        }

        }

    







    

        if(array_key_exists("domaine",$data)){


        if(!empty($data['domaine'])){
        
            $Supervirzclients->domaine = $data['domaine'];
        
        }

        }

    







    

        if(array_key_exists("path",$data)){


        if(!empty($data['path'])){
        
            $Supervirzclients->path = $data['path'];
        
        }

        }

    







    







    







    

        if(array_key_exists("db_connection",$data)){


        if(!empty($data['db_connection'])){
        
            $Supervirzclients->db_connection = $data['db_connection'];
        
        }

        }

    







    

        if(array_key_exists("db_host",$data)){


        if(!empty($data['db_host'])){
        
            $Supervirzclients->db_host = $data['db_host'];
        
        }

        }

    







    

        if(array_key_exists("db_port",$data)){


        if(!empty($data['db_port'])){
        
            $Supervirzclients->db_port = $data['db_port'];
        
        }

        }

    







    

        if(array_key_exists("db_database",$data)){


        if(!empty($data['db_database'])){
        
            $Supervirzclients->db_database = $data['db_database'];
        
        }

        }

    







    

        if(array_key_exists("db_username",$data)){


        if(!empty($data['db_username'])){
        
            $Supervirzclients->db_username = $data['db_username'];
        
        }

        }

    







    

        if(array_key_exists("db_password",$data)){


        if(!empty($data['db_password'])){
        
            $Supervirzclients->db_password = $data['db_password'];
        
        }

        }

    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Supervirzclients->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Supervirzclients->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Supervirzclients->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\SupervirzclientExtras') &&
method_exists('\App\Http\Extras\SupervirzclientExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\SupervirzclientExtras::beforeSaveUpdate($request,$Supervirzclients);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\SupervirzclientExtras') &&
method_exists('\App\Http\Extras\SupervirzclientExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\SupervirzclientExtras::canUpdate($request, $Supervirzclients);
}catch (\Throwable $e){

}

}


if($canSave){
$Supervirzclients->save();
}else{
return response()->json($Supervirzclients, 200);

}


$Supervirzclients=Supervirzclient::find($Supervirzclients->id);



$newCrudData=[];

                $newCrudData['nom']=$Supervirzclients->nom;
                $newCrudData['domaine']=$Supervirzclients->domaine;
                $newCrudData['path']=$Supervirzclients->path;
                        $newCrudData['db_connection']=$Supervirzclients->db_connection;
                $newCrudData['db_host']=$Supervirzclients->db_host;
                $newCrudData['db_port']=$Supervirzclients->db_port;
                $newCrudData['db_database']=$Supervirzclients->db_database;
                $newCrudData['db_username']=$Supervirzclients->db_username;
                $newCrudData['db_password']=$Supervirzclients->db_password;
                        $newCrudData['identifiants_sadge']=$Supervirzclients->identifiants_sadge;
                $newCrudData['creat_by']=$Supervirzclients->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Supervirzclients','entite_cle' => $Supervirzclients->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Supervirzclients->toArray();




try{

foreach ($Supervirzclients->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Supervirzclient $Supervirzclients)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des supervirzclients');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['nom']=$Supervirzclients->nom;
                $newCrudData['domaine']=$Supervirzclients->domaine;
                $newCrudData['path']=$Supervirzclients->path;
                        $newCrudData['db_connection']=$Supervirzclients->db_connection;
                $newCrudData['db_host']=$Supervirzclients->db_host;
                $newCrudData['db_port']=$Supervirzclients->db_port;
                $newCrudData['db_database']=$Supervirzclients->db_database;
                $newCrudData['db_username']=$Supervirzclients->db_username;
                $newCrudData['db_password']=$Supervirzclients->db_password;
                        $newCrudData['identifiants_sadge']=$Supervirzclients->identifiants_sadge;
                $newCrudData['creat_by']=$Supervirzclients->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Supervirzclients','entite_cle' => $Supervirzclients->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\SupervirzclientExtras') &&
method_exists('\App\Http\Extras\SupervirzclientExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\SupervirzclientExtras::canDelete($request, $Supervirzclients);
}catch (\Throwable $e){

}

}



if($canSave){
$Supervirzclients->delete();
}else{
return response()->json($Supervirzclients, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\SupervirzclientsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
