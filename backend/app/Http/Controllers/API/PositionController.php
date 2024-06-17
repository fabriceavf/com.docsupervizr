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
// use App\Repository\prod\PositionsRepository;
use App\Models\Position;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Balise;
    
class PositionController extends Controller
{

private $PositionsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\PositionsRepository $PositionsRepository
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
class_exists('\App\Http\Extras\PositionExtras') &&
method_exists('\App\Http\Extras\PositionExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\PositionExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Position::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\PositionExtras') &&
method_exists('\App\Http\Extras\PositionExtras', 'filterAgGridQuery')
){
\App\Http\Extras\PositionExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('positions',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\PositionExtras') &&
method_exists('\App\Http\Extras\PositionExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\PositionExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  positions reussi',
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
return response()->json(Position::count());
}
$data = QueryBuilder::for(Position::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('lat'),

    
            AllowedFilter::exact('lon'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('title'),

    
            AllowedFilter::exact('speed'),

    
            AllowedFilter::exact('icon_color'),

    
            AllowedFilter::exact('moyenstransportid'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('tracername'),

    
            AllowedFilter::exact('traceruniqueid'),

    
            AllowedFilter::exact('sim'),

    
            AllowedFilter::exact('balise_id'),

    
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

    
            AllowedSort::field('lat'),

    
            AllowedSort::field('lon'),

    
            AllowedSort::field('name'),

    
            AllowedSort::field('title'),

    
            AllowedSort::field('speed'),

    
            AllowedSort::field('icon_color'),

    
            AllowedSort::field('moyenstransportid'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('date'),

    
            AllowedSort::field('tracername'),

    
            AllowedSort::field('traceruniqueid'),

    
            AllowedSort::field('sim'),

    
            AllowedSort::field('balise_id'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([

            'balise',
        

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




$data = QueryBuilder::for(Position::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('lat'),

    
            AllowedFilter::exact('lon'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('title'),

    
            AllowedFilter::exact('speed'),

    
            AllowedFilter::exact('icon_color'),

    
            AllowedFilter::exact('moyenstransportid'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('tracername'),

    
            AllowedFilter::exact('traceruniqueid'),

    
            AllowedFilter::exact('sim'),

    
            AllowedFilter::exact('balise_id'),

    
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

    
            AllowedSort::field('lat'),

    
            AllowedSort::field('lon'),

    
            AllowedSort::field('name'),

    
            AllowedSort::field('title'),

    
            AllowedSort::field('speed'),

    
            AllowedSort::field('icon_color'),

    
            AllowedSort::field('moyenstransportid'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('date'),

    
            AllowedSort::field('tracername'),

    
            AllowedSort::field('traceruniqueid'),

    
            AllowedSort::field('sim'),

    
            AllowedSort::field('balise_id'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([
            'balise',
        

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



public function create(Request $request, Position $Positions)
{


try{
$can=\App\Helpers\Helpers::can('Creer des positions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "positions"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'lat',
    'lon',
    'name',
    'title',
    'speed',
    'icon_color',
    'moyenstransportid',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'date',
    'tracername',
    'traceruniqueid',
    'sim',
    'balise_id',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'lat' => [
            //'required'
            ],
        
    
    
                    'lon' => [
            //'required'
            ],
        
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'title' => [
            //'required'
            ],
        
    
    
                    'speed' => [
            //'required'
            ],
        
    
    
                    'icon_color' => [
            //'required'
            ],
        
    
    
                    'moyenstransportid' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'date' => [
            //'required'
            ],
        
    
    
                    'tracername' => [
            //'required'
            ],
        
    
    
                    'traceruniqueid' => [
            //'required'
            ],
        
    
    
                    'sim' => [
            //'required'
            ],
        
    
    
                    'balise_id' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'lat' => ['cette donnee est obligatoire'],

    
    
        'lon' => ['cette donnee est obligatoire'],

    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'title' => ['cette donnee est obligatoire'],

    
    
        'speed' => ['cette donnee est obligatoire'],

    
    
        'icon_color' => ['cette donnee est obligatoire'],

    
    
        'moyenstransportid' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'tracername' => ['cette donnee est obligatoire'],

    
    
        'traceruniqueid' => ['cette donnee est obligatoire'],

    
    
        'sim' => ['cette donnee est obligatoire'],

    
    
        'balise_id' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['lat'])){
        
            $Positions->lat = $data['lat'];
        
        }



    







    

        if(!empty($data['lon'])){
        
            $Positions->lon = $data['lon'];
        
        }



    







    

        if(!empty($data['name'])){
        
            $Positions->name = $data['name'];
        
        }



    







    

        if(!empty($data['title'])){
        
            $Positions->title = $data['title'];
        
        }



    







    

        if(!empty($data['speed'])){
        
            $Positions->speed = $data['speed'];
        
        }



    







    

        if(!empty($data['icon_color'])){
        
            $Positions->icon_color = $data['icon_color'];
        
        }



    







    

        if(!empty($data['moyenstransportid'])){
        
            $Positions->moyenstransportid = $data['moyenstransportid'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Positions->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['date'])){
        
            $Positions->date = $data['date'];
        
        }



    







    

        if(!empty($data['tracername'])){
        
            $Positions->tracername = $data['tracername'];
        
        }



    







    

        if(!empty($data['traceruniqueid'])){
        
            $Positions->traceruniqueid = $data['traceruniqueid'];
        
        }



    







    

        if(!empty($data['sim'])){
        
            $Positions->sim = $data['sim'];
        
        }



    







    

        if(!empty($data['balise_id'])){
        
            $Positions->balise_id = $data['balise_id'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Positions->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Positions->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\PositionExtras') &&
method_exists('\App\Http\Extras\PositionExtras', 'beforeSaveCreate')
){
\App\Http\Extras\PositionExtras::beforeSaveCreate($request,$Positions);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PositionExtras') &&
method_exists('\App\Http\Extras\PositionExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\PositionExtras::canCreate($request, $Positions);
}catch (\Throwable $e){

}

}


if($canSave){
$Positions->save();
}else{
return response()->json($Positions, 200);
}

$Positions=Position::find($Positions->id);
$newCrudData=[];

                $newCrudData['lat']=$Positions->lat;
                $newCrudData['lon']=$Positions->lon;
                $newCrudData['name']=$Positions->name;
                $newCrudData['title']=$Positions->title;
                $newCrudData['speed']=$Positions->speed;
                $newCrudData['icon_color']=$Positions->icon_color;
                $newCrudData['moyenstransportid']=$Positions->moyenstransportid;
                $newCrudData['creat_by']=$Positions->creat_by;
                                $newCrudData['date']=$Positions->date;
                $newCrudData['tracername']=$Positions->tracername;
                $newCrudData['traceruniqueid']=$Positions->traceruniqueid;
                $newCrudData['sim']=$Positions->sim;
                $newCrudData['balise_id']=$Positions->balise_id;
                $newCrudData['identifiants_sadge']=$Positions->identifiants_sadge;
    
 try{ $newCrudData['balise']=$Positions->balise->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Positions','entite_cle' => $Positions->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Positions->toArray();




try{

foreach ($Positions->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Position $Positions)
{
try{
$can=\App\Helpers\Helpers::can('Editer des positions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['lat']=$Positions->lat;
                $oldCrudData['lon']=$Positions->lon;
                $oldCrudData['name']=$Positions->name;
                $oldCrudData['title']=$Positions->title;
                $oldCrudData['speed']=$Positions->speed;
                $oldCrudData['icon_color']=$Positions->icon_color;
                $oldCrudData['moyenstransportid']=$Positions->moyenstransportid;
                $oldCrudData['creat_by']=$Positions->creat_by;
                                $oldCrudData['date']=$Positions->date;
                $oldCrudData['tracername']=$Positions->tracername;
                $oldCrudData['traceruniqueid']=$Positions->traceruniqueid;
                $oldCrudData['sim']=$Positions->sim;
                $oldCrudData['balise_id']=$Positions->balise_id;
                $oldCrudData['identifiants_sadge']=$Positions->identifiants_sadge;
    
 try{ $oldCrudData['balise']=$Positions->balise->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "positions"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'lat',
    'lon',
    'name',
    'title',
    'speed',
    'icon_color',
    'moyenstransportid',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'date',
    'tracername',
    'traceruniqueid',
    'sim',
    'balise_id',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'lat' => [
            //'required'
            ],
        
    
    
                    'lon' => [
            //'required'
            ],
        
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'title' => [
            //'required'
            ],
        
    
    
                    'speed' => [
            //'required'
            ],
        
    
    
                    'icon_color' => [
            //'required'
            ],
        
    
    
                    'moyenstransportid' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'date' => [
            //'required'
            ],
        
    
    
                    'tracername' => [
            //'required'
            ],
        
    
    
                    'traceruniqueid' => [
            //'required'
            ],
        
    
    
                    'sim' => [
            //'required'
            ],
        
    
    
                    'balise_id' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'lat' => ['cette donnee est obligatoire'],

    
    
        'lon' => ['cette donnee est obligatoire'],

    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'title' => ['cette donnee est obligatoire'],

    
    
        'speed' => ['cette donnee est obligatoire'],

    
    
        'icon_color' => ['cette donnee est obligatoire'],

    
    
        'moyenstransportid' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'tracername' => ['cette donnee est obligatoire'],

    
    
        'traceruniqueid' => ['cette donnee est obligatoire'],

    
    
        'sim' => ['cette donnee est obligatoire'],

    
    
        'balise_id' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("lat",$data)){


        if(!empty($data['lat'])){
        
            $Positions->lat = $data['lat'];
        
        }

        }

    







    

        if(array_key_exists("lon",$data)){


        if(!empty($data['lon'])){
        
            $Positions->lon = $data['lon'];
        
        }

        }

    







    

        if(array_key_exists("name",$data)){


        if(!empty($data['name'])){
        
            $Positions->name = $data['name'];
        
        }

        }

    







    

        if(array_key_exists("title",$data)){


        if(!empty($data['title'])){
        
            $Positions->title = $data['title'];
        
        }

        }

    







    

        if(array_key_exists("speed",$data)){


        if(!empty($data['speed'])){
        
            $Positions->speed = $data['speed'];
        
        }

        }

    







    

        if(array_key_exists("icon_color",$data)){


        if(!empty($data['icon_color'])){
        
            $Positions->icon_color = $data['icon_color'];
        
        }

        }

    







    

        if(array_key_exists("moyenstransportid",$data)){


        if(!empty($data['moyenstransportid'])){
        
            $Positions->moyenstransportid = $data['moyenstransportid'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Positions->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("date",$data)){


        if(!empty($data['date'])){
        
            $Positions->date = $data['date'];
        
        }

        }

    







    

        if(array_key_exists("tracername",$data)){


        if(!empty($data['tracername'])){
        
            $Positions->tracername = $data['tracername'];
        
        }

        }

    







    

        if(array_key_exists("traceruniqueid",$data)){


        if(!empty($data['traceruniqueid'])){
        
            $Positions->traceruniqueid = $data['traceruniqueid'];
        
        }

        }

    







    

        if(array_key_exists("sim",$data)){


        if(!empty($data['sim'])){
        
            $Positions->sim = $data['sim'];
        
        }

        }

    







    

        if(array_key_exists("balise_id",$data)){


        if(!empty($data['balise_id'])){
        
            $Positions->balise_id = $data['balise_id'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Positions->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Positions->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\PositionExtras') &&
method_exists('\App\Http\Extras\PositionExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\PositionExtras::beforeSaveUpdate($request,$Positions);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PositionExtras') &&
method_exists('\App\Http\Extras\PositionExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\PositionExtras::canUpdate($request, $Positions);
}catch (\Throwable $e){

}

}


if($canSave){
$Positions->save();
}else{
return response()->json($Positions, 200);

}


$Positions=Position::find($Positions->id);



$newCrudData=[];

                $newCrudData['lat']=$Positions->lat;
                $newCrudData['lon']=$Positions->lon;
                $newCrudData['name']=$Positions->name;
                $newCrudData['title']=$Positions->title;
                $newCrudData['speed']=$Positions->speed;
                $newCrudData['icon_color']=$Positions->icon_color;
                $newCrudData['moyenstransportid']=$Positions->moyenstransportid;
                $newCrudData['creat_by']=$Positions->creat_by;
                                $newCrudData['date']=$Positions->date;
                $newCrudData['tracername']=$Positions->tracername;
                $newCrudData['traceruniqueid']=$Positions->traceruniqueid;
                $newCrudData['sim']=$Positions->sim;
                $newCrudData['balise_id']=$Positions->balise_id;
                $newCrudData['identifiants_sadge']=$Positions->identifiants_sadge;
    
 try{ $newCrudData['balise']=$Positions->balise->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Positions','entite_cle' => $Positions->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Positions->toArray();




try{

foreach ($Positions->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Position $Positions)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des positions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['lat']=$Positions->lat;
                $newCrudData['lon']=$Positions->lon;
                $newCrudData['name']=$Positions->name;
                $newCrudData['title']=$Positions->title;
                $newCrudData['speed']=$Positions->speed;
                $newCrudData['icon_color']=$Positions->icon_color;
                $newCrudData['moyenstransportid']=$Positions->moyenstransportid;
                $newCrudData['creat_by']=$Positions->creat_by;
                                $newCrudData['date']=$Positions->date;
                $newCrudData['tracername']=$Positions->tracername;
                $newCrudData['traceruniqueid']=$Positions->traceruniqueid;
                $newCrudData['sim']=$Positions->sim;
                $newCrudData['balise_id']=$Positions->balise_id;
                $newCrudData['identifiants_sadge']=$Positions->identifiants_sadge;
    
 try{ $newCrudData['balise']=$Positions->balise->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Positions','entite_cle' => $Positions->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\PositionExtras') &&
method_exists('\App\Http\Extras\PositionExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\PositionExtras::canDelete($request, $Positions);
}catch (\Throwable $e){

}

}



if($canSave){
$Positions->delete();
}else{
return response()->json($Positions, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\PositionsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
