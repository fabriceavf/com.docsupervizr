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
// use App\Repository\prod\Websockets_statistics_entriesRepository;
use App\Models\WebsocketsStatisticsEntrie;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;




class WebsocketsStatisticsEntrieController extends Controller
{

private $Websockets_statistics_entriesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\Websockets_statistics_entriesRepository $Websockets_statistics_entriesRepository
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
class_exists('\App\Http\Extras\Websockets_statistics_entrieExtras') &&
method_exists('\App\Http\Extras\Websockets_statistics_entrieExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\Websockets_statistics_entrieExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=WebsocketsStatisticsEntrie::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\Websockets_statistics_entrieExtras') &&
method_exists('\App\Http\Extras\Websockets_statistics_entrieExtras', 'filterAgGridQuery')
){
\App\Http\Extras\Websockets_statistics_entrieExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('websockets_statistics_entries',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\Websockets_statistics_entrieExtras') &&
method_exists('\App\Http\Extras\Websockets_statistics_entrieExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\Websockets_statistics_entrieExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  websockets_statistics_entries reussi',
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
return response()->json(WebsocketsStatisticsEntrie::count());
}
$data = QueryBuilder::for(WebsocketsStatisticsEntrie::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('app_id'),

    
            AllowedFilter::exact('peak_connection_count'),

    
            AllowedFilter::exact('websocket_message_count'),

    
            AllowedFilter::exact('api_message_count'),

    
    
    
    
    
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

    
            AllowedSort::field('app_id'),

    
            AllowedSort::field('peak_connection_count'),

    
            AllowedSort::field('websocket_message_count'),

    
            AllowedSort::field('api_message_count'),

    
    
    
    
    
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




$data = QueryBuilder::for(WebsocketsStatisticsEntrie::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('app_id'),

    
            AllowedFilter::exact('peak_connection_count'),

    
            AllowedFilter::exact('websocket_message_count'),

    
            AllowedFilter::exact('api_message_count'),

    
    
    
    
    
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

    
            AllowedSort::field('app_id'),

    
            AllowedSort::field('peak_connection_count'),

    
            AllowedSort::field('websocket_message_count'),

    
            AllowedSort::field('api_message_count'),

    
    
    
    
    
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



public function create(Request $request, WebsocketsStatisticsEntrie $Websockets_statistics_entries)
{


try{
$can=\App\Helpers\Helpers::can('Creer des websockets_statistics_entries');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "websockets_statistics_entries"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'app_id',
    'peak_connection_count',
    'websocket_message_count',
    'api_message_count',
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
    
    
                    'app_id' => [
            //'required'
            ],
        
    
    
                    'peak_connection_count' => [
            //'required'
            ],
        
    
    
                    'websocket_message_count' => [
            //'required'
            ],
        
    
    
                    'api_message_count' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'app_id' => ['cette donnee est obligatoire'],

    
    
        'peak_connection_count' => ['cette donnee est obligatoire'],

    
    
        'websocket_message_count' => ['cette donnee est obligatoire'],

    
    
        'api_message_count' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['app_id'])){
        
            $Websockets_statistics_entries->app_id = $data['app_id'];
        
        }



    







    

        if(!empty($data['peak_connection_count'])){
        
            $Websockets_statistics_entries->peak_connection_count = $data['peak_connection_count'];
        
        }



    







    

        if(!empty($data['websocket_message_count'])){
        
            $Websockets_statistics_entries->websocket_message_count = $data['websocket_message_count'];
        
        }



    







    

        if(!empty($data['api_message_count'])){
        
            $Websockets_statistics_entries->api_message_count = $data['api_message_count'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Websockets_statistics_entries->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Websockets_statistics_entries->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Websockets_statistics_entries->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\Websockets_statistics_entrieExtras') &&
method_exists('\App\Http\Extras\Websockets_statistics_entrieExtras', 'beforeSaveCreate')
){
\App\Http\Extras\Websockets_statistics_entrieExtras::beforeSaveCreate($request,$Websockets_statistics_entries);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Websockets_statistics_entrieExtras') &&
method_exists('\App\Http\Extras\Websockets_statistics_entrieExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\Websockets_statistics_entrieExtras::canCreate($request, $Websockets_statistics_entries);
}catch (\Throwable $e){

}

}


if($canSave){
$Websockets_statistics_entries->save();
}else{
return response()->json($Websockets_statistics_entries, 200);
}

$Websockets_statistics_entries=WebsocketsStatisticsEntrie::find($Websockets_statistics_entries->id);
$newCrudData=[];

                $newCrudData['app_id']=$Websockets_statistics_entries->app_id;
                $newCrudData['peak_connection_count']=$Websockets_statistics_entries->peak_connection_count;
                $newCrudData['websocket_message_count']=$Websockets_statistics_entries->websocket_message_count;
                $newCrudData['api_message_count']=$Websockets_statistics_entries->api_message_count;
                                $newCrudData['identifiants_sadge']=$Websockets_statistics_entries->identifiants_sadge;
                $newCrudData['creat_by']=$Websockets_statistics_entries->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Websockets_statistics_entries','entite_cle' => $Websockets_statistics_entries->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Websockets_statistics_entries->toArray();




try{

foreach ($Websockets_statistics_entries->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, WebsocketsStatisticsEntrie $Websockets_statistics_entries)
{
try{
$can=\App\Helpers\Helpers::can('Editer des websockets_statistics_entries');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['app_id']=$Websockets_statistics_entries->app_id;
                $oldCrudData['peak_connection_count']=$Websockets_statistics_entries->peak_connection_count;
                $oldCrudData['websocket_message_count']=$Websockets_statistics_entries->websocket_message_count;
                $oldCrudData['api_message_count']=$Websockets_statistics_entries->api_message_count;
                                $oldCrudData['identifiants_sadge']=$Websockets_statistics_entries->identifiants_sadge;
                $oldCrudData['creat_by']=$Websockets_statistics_entries->creat_by;
    


$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "websockets_statistics_entries"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'app_id',
    'peak_connection_count',
    'websocket_message_count',
    'api_message_count',
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
    
    
                    'app_id' => [
            //'required'
            ],
        
    
    
                    'peak_connection_count' => [
            //'required'
            ],
        
    
    
                    'websocket_message_count' => [
            //'required'
            ],
        
    
    
                    'api_message_count' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'app_id' => ['cette donnee est obligatoire'],

    
    
        'peak_connection_count' => ['cette donnee est obligatoire'],

    
    
        'websocket_message_count' => ['cette donnee est obligatoire'],

    
    
        'api_message_count' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("app_id",$data)){


        if(!empty($data['app_id'])){
        
            $Websockets_statistics_entries->app_id = $data['app_id'];
        
        }

        }

    







    

        if(array_key_exists("peak_connection_count",$data)){


        if(!empty($data['peak_connection_count'])){
        
            $Websockets_statistics_entries->peak_connection_count = $data['peak_connection_count'];
        
        }

        }

    







    

        if(array_key_exists("websocket_message_count",$data)){


        if(!empty($data['websocket_message_count'])){
        
            $Websockets_statistics_entries->websocket_message_count = $data['websocket_message_count'];
        
        }

        }

    







    

        if(array_key_exists("api_message_count",$data)){


        if(!empty($data['api_message_count'])){
        
            $Websockets_statistics_entries->api_message_count = $data['api_message_count'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Websockets_statistics_entries->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Websockets_statistics_entries->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Websockets_statistics_entries->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\Websockets_statistics_entrieExtras') &&
method_exists('\App\Http\Extras\Websockets_statistics_entrieExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\Websockets_statistics_entrieExtras::beforeSaveUpdate($request,$Websockets_statistics_entries);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Websockets_statistics_entrieExtras') &&
method_exists('\App\Http\Extras\Websockets_statistics_entrieExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\Websockets_statistics_entrieExtras::canUpdate($request, $Websockets_statistics_entries);
}catch (\Throwable $e){

}

}


if($canSave){
$Websockets_statistics_entries->save();
}else{
return response()->json($Websockets_statistics_entries, 200);

}


$Websockets_statistics_entries=WebsocketsStatisticsEntrie::find($Websockets_statistics_entries->id);



$newCrudData=[];

                $newCrudData['app_id']=$Websockets_statistics_entries->app_id;
                $newCrudData['peak_connection_count']=$Websockets_statistics_entries->peak_connection_count;
                $newCrudData['websocket_message_count']=$Websockets_statistics_entries->websocket_message_count;
                $newCrudData['api_message_count']=$Websockets_statistics_entries->api_message_count;
                                $newCrudData['identifiants_sadge']=$Websockets_statistics_entries->identifiants_sadge;
                $newCrudData['creat_by']=$Websockets_statistics_entries->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Websockets_statistics_entries','entite_cle' => $Websockets_statistics_entries->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Websockets_statistics_entries->toArray();




try{

foreach ($Websockets_statistics_entries->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, WebsocketsStatisticsEntrie $Websockets_statistics_entries)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des websockets_statistics_entries');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['app_id']=$Websockets_statistics_entries->app_id;
                $newCrudData['peak_connection_count']=$Websockets_statistics_entries->peak_connection_count;
                $newCrudData['websocket_message_count']=$Websockets_statistics_entries->websocket_message_count;
                $newCrudData['api_message_count']=$Websockets_statistics_entries->api_message_count;
                                $newCrudData['identifiants_sadge']=$Websockets_statistics_entries->identifiants_sadge;
                $newCrudData['creat_by']=$Websockets_statistics_entries->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Websockets_statistics_entries','entite_cle' => $Websockets_statistics_entries->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\Websockets_statistics_entrieExtras') &&
method_exists('\App\Http\Extras\Websockets_statistics_entrieExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\Websockets_statistics_entrieExtras::canDelete($request, $Websockets_statistics_entries);
}catch (\Throwable $e){

}

}



if($canSave){
$Websockets_statistics_entries->delete();
}else{
return response()->json($Websockets_statistics_entries, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\Websockets_statistics_entriesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
