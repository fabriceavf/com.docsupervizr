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
// use App\Repository\prod\DeploiementspointeusesmoyenstransportsRepository;
use App\Models\Deploiementspointeusesmoyenstransport;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Moyenstransport;
                use App\Models\Pointeuse;
    
class DeploiementspointeusesmoyenstransportController extends Controller
{

private $DeploiementspointeusesmoyenstransportsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\DeploiementspointeusesmoyenstransportsRepository $DeploiementspointeusesmoyenstransportsRepository
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
class_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Deploiementspointeusesmoyenstransport::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras', 'filterAgGridQuery')
){
\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('deploiementspointeusesmoyenstransports',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\DeploiementspointeusesmoyenstransportExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  deploiementspointeusesmoyenstransports reussi',
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
return response()->json(Deploiementspointeusesmoyenstransport::count());
}
$data = QueryBuilder::for(Deploiementspointeusesmoyenstransport::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('pointeuse_id'),

    
            AllowedFilter::exact('moyenstransport_id'),

    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
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

    
            AllowedSort::field('date'),

    
            AllowedSort::field('pointeuse_id'),

    
            AllowedSort::field('moyenstransport_id'),

    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
])
    
    
->allowedIncludes([

            'moyenstransport',
        

                'pointeuse',
        

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




$data = QueryBuilder::for(Deploiementspointeusesmoyenstransport::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('pointeuse_id'),

    
            AllowedFilter::exact('moyenstransport_id'),

    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
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

    
            AllowedSort::field('date'),

    
            AllowedSort::field('pointeuse_id'),

    
            AllowedSort::field('moyenstransport_id'),

    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
])
    
    
->allowedIncludes([
            'moyenstransport',
        

                'pointeuse',
        

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



public function create(Request $request, Deploiementspointeusesmoyenstransport $Deploiementspointeusesmoyenstransports)
{


try{
$can=\App\Helpers\Helpers::can('Creer des deploiementspointeusesmoyenstransports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "deploiementspointeusesmoyenstransports"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'date',
    'pointeuse_id',
    'moyenstransport_id',
    'debut',
    'fin',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'date' => [
            //'required'
            ],
        
    
    
                    'pointeuse_id' => [
            //'required'
            ],
        
    
    
                    'moyenstransport_id' => [
            //'required'
            ],
        
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    


], $messages = [

    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'pointeuse_id' => ['cette donnee est obligatoire'],

    
    
        'moyenstransport_id' => ['cette donnee est obligatoire'],

    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['date'])){
        
            $Deploiementspointeusesmoyenstransports->date = $data['date'];
        
        }



    







    

        if(!empty($data['pointeuse_id'])){
        
            $Deploiementspointeusesmoyenstransports->pointeuse_id = $data['pointeuse_id'];
        
        }



    







    

        if(!empty($data['moyenstransport_id'])){
        
            $Deploiementspointeusesmoyenstransports->moyenstransport_id = $data['moyenstransport_id'];
        
        }



    







    

        if(!empty($data['debut'])){
        
            $Deploiementspointeusesmoyenstransports->debut = $data['debut'];
        
        }



    







    

        if(!empty($data['fin'])){
        
            $Deploiementspointeusesmoyenstransports->fin = $data['fin'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Deploiementspointeusesmoyenstransports->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Deploiementspointeusesmoyenstransports->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras', 'beforeSaveCreate')
){
\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras::beforeSaveCreate($request,$Deploiementspointeusesmoyenstransports);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras::canCreate($request, $Deploiementspointeusesmoyenstransports);
}catch (\Throwable $e){

}

}


if($canSave){
$Deploiementspointeusesmoyenstransports->save();
}else{
return response()->json($Deploiementspointeusesmoyenstransports, 200);
}

$Deploiementspointeusesmoyenstransports=Deploiementspointeusesmoyenstransport::find($Deploiementspointeusesmoyenstransports->id);
$newCrudData=[];

                $newCrudData['date']=$Deploiementspointeusesmoyenstransports->date;
                $newCrudData['pointeuse_id']=$Deploiementspointeusesmoyenstransports->pointeuse_id;
                $newCrudData['moyenstransport_id']=$Deploiementspointeusesmoyenstransports->moyenstransport_id;
                $newCrudData['debut']=$Deploiementspointeusesmoyenstransports->debut;
                $newCrudData['fin']=$Deploiementspointeusesmoyenstransports->fin;
                $newCrudData['creat_by']=$Deploiementspointeusesmoyenstransports->creat_by;
                    
 try{ $newCrudData['moyenstransport']=$Deploiementspointeusesmoyenstransports->moyenstransport->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['pointeuse']=$Deploiementspointeusesmoyenstransports->pointeuse->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Deploiementspointeusesmoyenstransports','entite_cle' => $Deploiementspointeusesmoyenstransports->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Deploiementspointeusesmoyenstransports->toArray();




try{

foreach ($Deploiementspointeusesmoyenstransports->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Deploiementspointeusesmoyenstransport $Deploiementspointeusesmoyenstransports)
{
try{
$can=\App\Helpers\Helpers::can('Editer des deploiementspointeusesmoyenstransports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['date']=$Deploiementspointeusesmoyenstransports->date;
                $oldCrudData['pointeuse_id']=$Deploiementspointeusesmoyenstransports->pointeuse_id;
                $oldCrudData['moyenstransport_id']=$Deploiementspointeusesmoyenstransports->moyenstransport_id;
                $oldCrudData['debut']=$Deploiementspointeusesmoyenstransports->debut;
                $oldCrudData['fin']=$Deploiementspointeusesmoyenstransports->fin;
                $oldCrudData['creat_by']=$Deploiementspointeusesmoyenstransports->creat_by;
                    
 try{ $oldCrudData['moyenstransport']=$Deploiementspointeusesmoyenstransports->moyenstransport->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['pointeuse']=$Deploiementspointeusesmoyenstransports->pointeuse->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "deploiementspointeusesmoyenstransports"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'date',
    'pointeuse_id',
    'moyenstransport_id',
    'debut',
    'fin',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'date' => [
            //'required'
            ],
        
    
    
                    'pointeuse_id' => [
            //'required'
            ],
        
    
    
                    'moyenstransport_id' => [
            //'required'
            ],
        
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    


], $messages = [

    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'pointeuse_id' => ['cette donnee est obligatoire'],

    
    
        'moyenstransport_id' => ['cette donnee est obligatoire'],

    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("date",$data)){


        if(!empty($data['date'])){
        
            $Deploiementspointeusesmoyenstransports->date = $data['date'];
        
        }

        }

    







    

        if(array_key_exists("pointeuse_id",$data)){


        if(!empty($data['pointeuse_id'])){
        
            $Deploiementspointeusesmoyenstransports->pointeuse_id = $data['pointeuse_id'];
        
        }

        }

    







    

        if(array_key_exists("moyenstransport_id",$data)){


        if(!empty($data['moyenstransport_id'])){
        
            $Deploiementspointeusesmoyenstransports->moyenstransport_id = $data['moyenstransport_id'];
        
        }

        }

    







    

        if(array_key_exists("debut",$data)){


        if(!empty($data['debut'])){
        
            $Deploiementspointeusesmoyenstransports->debut = $data['debut'];
        
        }

        }

    







    

        if(array_key_exists("fin",$data)){


        if(!empty($data['fin'])){
        
            $Deploiementspointeusesmoyenstransports->fin = $data['fin'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Deploiementspointeusesmoyenstransports->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Deploiementspointeusesmoyenstransports->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras::beforeSaveUpdate($request,$Deploiementspointeusesmoyenstransports);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras::canUpdate($request, $Deploiementspointeusesmoyenstransports);
}catch (\Throwable $e){

}

}


if($canSave){
$Deploiementspointeusesmoyenstransports->save();
}else{
return response()->json($Deploiementspointeusesmoyenstransports, 200);

}


$Deploiementspointeusesmoyenstransports=Deploiementspointeusesmoyenstransport::find($Deploiementspointeusesmoyenstransports->id);



$newCrudData=[];

                $newCrudData['date']=$Deploiementspointeusesmoyenstransports->date;
                $newCrudData['pointeuse_id']=$Deploiementspointeusesmoyenstransports->pointeuse_id;
                $newCrudData['moyenstransport_id']=$Deploiementspointeusesmoyenstransports->moyenstransport_id;
                $newCrudData['debut']=$Deploiementspointeusesmoyenstransports->debut;
                $newCrudData['fin']=$Deploiementspointeusesmoyenstransports->fin;
                $newCrudData['creat_by']=$Deploiementspointeusesmoyenstransports->creat_by;
                    
 try{ $newCrudData['moyenstransport']=$Deploiementspointeusesmoyenstransports->moyenstransport->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['pointeuse']=$Deploiementspointeusesmoyenstransports->pointeuse->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Deploiementspointeusesmoyenstransports','entite_cle' => $Deploiementspointeusesmoyenstransports->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Deploiementspointeusesmoyenstransports->toArray();




try{

foreach ($Deploiementspointeusesmoyenstransports->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Deploiementspointeusesmoyenstransport $Deploiementspointeusesmoyenstransports)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des deploiementspointeusesmoyenstransports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['date']=$Deploiementspointeusesmoyenstransports->date;
                $newCrudData['pointeuse_id']=$Deploiementspointeusesmoyenstransports->pointeuse_id;
                $newCrudData['moyenstransport_id']=$Deploiementspointeusesmoyenstransports->moyenstransport_id;
                $newCrudData['debut']=$Deploiementspointeusesmoyenstransports->debut;
                $newCrudData['fin']=$Deploiementspointeusesmoyenstransports->fin;
                $newCrudData['creat_by']=$Deploiementspointeusesmoyenstransports->creat_by;
                    
 try{ $newCrudData['moyenstransport']=$Deploiementspointeusesmoyenstransports->moyenstransport->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['pointeuse']=$Deploiementspointeusesmoyenstransports->pointeuse->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Deploiementspointeusesmoyenstransports','entite_cle' => $Deploiementspointeusesmoyenstransports->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\DeploiementspointeusesmoyenstransportExtras::canDelete($request, $Deploiementspointeusesmoyenstransports);
}catch (\Throwable $e){

}

}



if($canSave){
$Deploiementspointeusesmoyenstransports->delete();
}else{
return response()->json($Deploiementspointeusesmoyenstransports, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\DeploiementspointeusesmoyenstransportsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
