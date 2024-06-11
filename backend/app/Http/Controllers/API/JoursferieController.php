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
// use App\Repository\prod\JoursferiesRepository;
use App\Models\Joursferie;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;




class JoursferieController extends Controller
{

private $JoursferiesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\JoursferiesRepository $JoursferiesRepository
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
class_exists('\App\Http\Extras\JoursferieExtras') &&
method_exists('\App\Http\Extras\JoursferieExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\JoursferieExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Joursferie::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\JoursferieExtras') &&
method_exists('\App\Http\Extras\JoursferieExtras', 'filterAgGridQuery')
){
\App\Http\Extras\JoursferieExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('joursferies',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\JoursferieExtras') &&
method_exists('\App\Http\Extras\JoursferieExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\JoursferieExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  joursferies reussi',
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
return response()->json(Joursferie::count());
}
$data = QueryBuilder::for(Joursferie::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('raison'),

    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
            AllowedFilter::exact('etats'),

    
    
    
    
    
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

    
            AllowedSort::field('raison'),

    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
            AllowedSort::field('etats'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
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




$data = QueryBuilder::for(Joursferie::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('raison'),

    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
            AllowedFilter::exact('etats'),

    
    
    
    
    
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

    
            AllowedSort::field('raison'),

    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
            AllowedSort::field('etats'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
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



public function create(Request $request, Joursferie $Joursferies)
{


try{
$can=\App\Helpers\Helpers::can('Creer des joursferies');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "joursferies"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'raison',
    'debut',
    'fin',
    'etats',
    'extra_attributes',
    'created_at',
    'updated_at',
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
    
    
                    'raison' => [
            //'required'
            ],
        
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'raison' => ['cette donnee est obligatoire'],

    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['raison'])){
        
            $Joursferies->raison = $data['raison'];
        
        }



    







    

        if(!empty($data['debut'])){
        
            $Joursferies->debut = $data['debut'];
        
        }



    







    

        if(!empty($data['fin'])){
        
            $Joursferies->fin = $data['fin'];
        
        }



    







    

        if(!empty($data['etats'])){
        
            $Joursferies->etats = $data['etats'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Joursferies->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Joursferies->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Joursferies->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\JoursferieExtras') &&
method_exists('\App\Http\Extras\JoursferieExtras', 'beforeSaveCreate')
){
\App\Http\Extras\JoursferieExtras::beforeSaveCreate($request,$Joursferies);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\JoursferieExtras') &&
method_exists('\App\Http\Extras\JoursferieExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\JoursferieExtras::canCreate($request, $Joursferies);
}catch (\Throwable $e){

}

}


if($canSave){
$Joursferies->save();
}else{
return response()->json($Joursferies, 200);
}

$Joursferies=Joursferie::find($Joursferies->id);
$newCrudData=[];

                $newCrudData['raison']=$Joursferies->raison;
                $newCrudData['debut']=$Joursferies->debut;
                $newCrudData['fin']=$Joursferies->fin;
                $newCrudData['etats']=$Joursferies->etats;
                                $newCrudData['identifiants_sadge']=$Joursferies->identifiants_sadge;
                $newCrudData['creat_by']=$Joursferies->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Joursferies','entite_cle' => $Joursferies->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Joursferies->toArray();




try{

foreach ($Joursferies->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Joursferie $Joursferies)
{
try{
$can=\App\Helpers\Helpers::can('Editer des joursferies');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['raison']=$Joursferies->raison;
                $oldCrudData['debut']=$Joursferies->debut;
                $oldCrudData['fin']=$Joursferies->fin;
                $oldCrudData['etats']=$Joursferies->etats;
                                $oldCrudData['identifiants_sadge']=$Joursferies->identifiants_sadge;
                $oldCrudData['creat_by']=$Joursferies->creat_by;
    


$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "joursferies"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'raison',
    'debut',
    'fin',
    'etats',
    'extra_attributes',
    'created_at',
    'updated_at',
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
    
    
                    'raison' => [
            //'required'
            ],
        
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'raison' => ['cette donnee est obligatoire'],

    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("raison",$data)){


        if(!empty($data['raison'])){
        
            $Joursferies->raison = $data['raison'];
        
        }

        }

    







    

        if(array_key_exists("debut",$data)){


        if(!empty($data['debut'])){
        
            $Joursferies->debut = $data['debut'];
        
        }

        }

    







    

        if(array_key_exists("fin",$data)){


        if(!empty($data['fin'])){
        
            $Joursferies->fin = $data['fin'];
        
        }

        }

    







    

        if(array_key_exists("etats",$data)){


        if(!empty($data['etats'])){
        
            $Joursferies->etats = $data['etats'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Joursferies->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Joursferies->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Joursferies->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\JoursferieExtras') &&
method_exists('\App\Http\Extras\JoursferieExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\JoursferieExtras::beforeSaveUpdate($request,$Joursferies);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\JoursferieExtras') &&
method_exists('\App\Http\Extras\JoursferieExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\JoursferieExtras::canUpdate($request, $Joursferies);
}catch (\Throwable $e){

}

}


if($canSave){
$Joursferies->save();
}else{
return response()->json($Joursferies, 200);

}


$Joursferies=Joursferie::find($Joursferies->id);



$newCrudData=[];

                $newCrudData['raison']=$Joursferies->raison;
                $newCrudData['debut']=$Joursferies->debut;
                $newCrudData['fin']=$Joursferies->fin;
                $newCrudData['etats']=$Joursferies->etats;
                                $newCrudData['identifiants_sadge']=$Joursferies->identifiants_sadge;
                $newCrudData['creat_by']=$Joursferies->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Joursferies','entite_cle' => $Joursferies->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Joursferies->toArray();




try{

foreach ($Joursferies->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Joursferie $Joursferies)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des joursferies');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['raison']=$Joursferies->raison;
                $newCrudData['debut']=$Joursferies->debut;
                $newCrudData['fin']=$Joursferies->fin;
                $newCrudData['etats']=$Joursferies->etats;
                                $newCrudData['identifiants_sadge']=$Joursferies->identifiants_sadge;
                $newCrudData['creat_by']=$Joursferies->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Joursferies','entite_cle' => $Joursferies->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\JoursferieExtras') &&
method_exists('\App\Http\Extras\JoursferieExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\JoursferieExtras::canDelete($request, $Joursferies);
}catch (\Throwable $e){

}

}



if($canSave){
$Joursferies->delete();
}else{
return response()->json($Joursferies, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\JoursferiesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
