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
// use App\Repository\prod\HomezonesRepository;
use App\Models\Homezone;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Modelslisting;
                use App\Models\Zone;
    
class HomezoneController extends Controller
{

private $HomezonesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\HomezonesRepository $HomezonesRepository
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
class_exists('\App\Http\Extras\HomezoneExtras') &&
method_exists('\App\Http\Extras\HomezoneExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\HomezoneExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Homezone::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\HomezoneExtras') &&
method_exists('\App\Http\Extras\HomezoneExtras', 'filterAgGridQuery')
){
\App\Http\Extras\HomezoneExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('homezones',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\HomezoneExtras') &&
method_exists('\App\Http\Extras\HomezoneExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\HomezoneExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  homezones reussi',
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
return response()->json(Homezone::count());
}
$data = QueryBuilder::for(Homezone::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('zone_id'),

    
            AllowedFilter::exact('modelslisting_id'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('modelslisting'),

    
            AllowedFilter::exact('effectifsjour'),

    
            AllowedFilter::exact('presentsjour'),

    
            AllowedFilter::exact('effectifsnuit'),

    
            AllowedFilter::exact('presentsnuit'),

    
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

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('zone_id'),

    
            AllowedSort::field('modelslisting_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('modelslisting'),

    
            AllowedSort::field('effectifsjour'),

    
            AllowedSort::field('presentsjour'),

    
            AllowedSort::field('effectifsnuit'),

    
            AllowedSort::field('presentsnuit'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
->allowedIncludes([

            'modelslisting',
        

                'zone',
        

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




$data = QueryBuilder::for(Homezone::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('zone_id'),

    
            AllowedFilter::exact('modelslisting_id'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('modelslisting'),

    
            AllowedFilter::exact('effectifsjour'),

    
            AllowedFilter::exact('presentsjour'),

    
            AllowedFilter::exact('effectifsnuit'),

    
            AllowedFilter::exact('presentsnuit'),

    
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

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('zone_id'),

    
            AllowedSort::field('modelslisting_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('modelslisting'),

    
            AllowedSort::field('effectifsjour'),

    
            AllowedSort::field('presentsjour'),

    
            AllowedSort::field('effectifsnuit'),

    
            AllowedSort::field('presentsnuit'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
->allowedIncludes([
            'modelslisting',
        

                'zone',
        

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



public function create(Request $request, Homezone $Homezones)
{


try{
$can=\App\Helpers\Helpers::can('Creer des homezones');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "homezones"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'type',
    'zone_id',
    'modelslisting_id',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'modelslisting',
    'effectifsjour',
    'presentsjour',
    'effectifsnuit',
    'presentsnuit',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
                    'modelslisting_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'modelslisting' => [
            //'required'
            ],
        
    
    
                    'effectifsjour' => [
            //'required'
            ],
        
    
    
                    'presentsjour' => [
            //'required'
            ],
        
    
    
                    'effectifsnuit' => [
            //'required'
            ],
        
    
    
                    'presentsnuit' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
        'modelslisting_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'modelslisting' => ['cette donnee est obligatoire'],

    
    
        'effectifsjour' => ['cette donnee est obligatoire'],

    
    
        'presentsjour' => ['cette donnee est obligatoire'],

    
    
        'effectifsnuit' => ['cette donnee est obligatoire'],

    
    
        'presentsnuit' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Homezones->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Homezones->type = $data['type'];
        
        }



    







    

        if(!empty($data['zone_id'])){
        
            $Homezones->zone_id = $data['zone_id'];
        
        }



    







    

        if(!empty($data['modelslisting_id'])){
        
            $Homezones->modelslisting_id = $data['modelslisting_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Homezones->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['modelslisting'])){
        
            $Homezones->modelslisting = $data['modelslisting'];
        
        }



    







    

        if(!empty($data['effectifsjour'])){
        
            $Homezones->effectifsjour = $data['effectifsjour'];
        
        }



    







    

        if(!empty($data['presentsjour'])){
        
            $Homezones->presentsjour = $data['presentsjour'];
        
        }



    







    

        if(!empty($data['effectifsnuit'])){
        
            $Homezones->effectifsnuit = $data['effectifsnuit'];
        
        }



    







    

        if(!empty($data['presentsnuit'])){
        
            $Homezones->presentsnuit = $data['presentsnuit'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Homezones->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Homezones->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\HomezoneExtras') &&
method_exists('\App\Http\Extras\HomezoneExtras', 'beforeSaveCreate')
){
\App\Http\Extras\HomezoneExtras::beforeSaveCreate($request,$Homezones);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\HomezoneExtras') &&
method_exists('\App\Http\Extras\HomezoneExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\HomezoneExtras::canCreate($request, $Homezones);
}catch (\Throwable $e){

}

}


if($canSave){
$Homezones->save();
}else{
return response()->json($Homezones, 200);
}

$Homezones=Homezone::find($Homezones->id);
$newCrudData=[];

                $newCrudData['libelle']=$Homezones->libelle;
                $newCrudData['type']=$Homezones->type;
                $newCrudData['zone_id']=$Homezones->zone_id;
                $newCrudData['modelslisting_id']=$Homezones->modelslisting_id;
                $newCrudData['creat_by']=$Homezones->creat_by;
                                $newCrudData['modelslisting']=$Homezones->modelslisting;
                $newCrudData['effectifsjour']=$Homezones->effectifsjour;
                $newCrudData['presentsjour']=$Homezones->presentsjour;
                $newCrudData['effectifsnuit']=$Homezones->effectifsnuit;
                $newCrudData['presentsnuit']=$Homezones->presentsnuit;
                $newCrudData['identifiants_sadge']=$Homezones->identifiants_sadge;
    
 try{ $newCrudData['modelslisting']=$Homezones->modelslisting->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Homezones->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Homezones','entite_cle' => $Homezones->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Homezones->toArray();




try{

foreach ($Homezones->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Homezone $Homezones)
{
try{
$can=\App\Helpers\Helpers::can('Editer des homezones');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Homezones->libelle;
                $oldCrudData['type']=$Homezones->type;
                $oldCrudData['zone_id']=$Homezones->zone_id;
                $oldCrudData['modelslisting_id']=$Homezones->modelslisting_id;
                $oldCrudData['creat_by']=$Homezones->creat_by;
                                $oldCrudData['modelslisting']=$Homezones->modelslisting;
                $oldCrudData['effectifsjour']=$Homezones->effectifsjour;
                $oldCrudData['presentsjour']=$Homezones->presentsjour;
                $oldCrudData['effectifsnuit']=$Homezones->effectifsnuit;
                $oldCrudData['presentsnuit']=$Homezones->presentsnuit;
                $oldCrudData['identifiants_sadge']=$Homezones->identifiants_sadge;
    
 try{ $oldCrudData['modelslisting']=$Homezones->modelslisting->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['zone']=$Homezones->zone->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "homezones"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'type',
    'zone_id',
    'modelslisting_id',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'modelslisting',
    'effectifsjour',
    'presentsjour',
    'effectifsnuit',
    'presentsnuit',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
                    'modelslisting_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'modelslisting' => [
            //'required'
            ],
        
    
    
                    'effectifsjour' => [
            //'required'
            ],
        
    
    
                    'presentsjour' => [
            //'required'
            ],
        
    
    
                    'effectifsnuit' => [
            //'required'
            ],
        
    
    
                    'presentsnuit' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
        'modelslisting_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'modelslisting' => ['cette donnee est obligatoire'],

    
    
        'effectifsjour' => ['cette donnee est obligatoire'],

    
    
        'presentsjour' => ['cette donnee est obligatoire'],

    
    
        'effectifsnuit' => ['cette donnee est obligatoire'],

    
    
        'presentsnuit' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Homezones->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Homezones->type = $data['type'];
        
        }

        }

    







    

        if(array_key_exists("zone_id",$data)){


        if(!empty($data['zone_id'])){
        
            $Homezones->zone_id = $data['zone_id'];
        
        }

        }

    







    

        if(array_key_exists("modelslisting_id",$data)){


        if(!empty($data['modelslisting_id'])){
        
            $Homezones->modelslisting_id = $data['modelslisting_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Homezones->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("modelslisting",$data)){


        if(!empty($data['modelslisting'])){
        
            $Homezones->modelslisting = $data['modelslisting'];
        
        }

        }

    







    

        if(array_key_exists("effectifsjour",$data)){


        if(!empty($data['effectifsjour'])){
        
            $Homezones->effectifsjour = $data['effectifsjour'];
        
        }

        }

    







    

        if(array_key_exists("presentsjour",$data)){


        if(!empty($data['presentsjour'])){
        
            $Homezones->presentsjour = $data['presentsjour'];
        
        }

        }

    







    

        if(array_key_exists("effectifsnuit",$data)){


        if(!empty($data['effectifsnuit'])){
        
            $Homezones->effectifsnuit = $data['effectifsnuit'];
        
        }

        }

    







    

        if(array_key_exists("presentsnuit",$data)){


        if(!empty($data['presentsnuit'])){
        
            $Homezones->presentsnuit = $data['presentsnuit'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Homezones->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Homezones->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\HomezoneExtras') &&
method_exists('\App\Http\Extras\HomezoneExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\HomezoneExtras::beforeSaveUpdate($request,$Homezones);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\HomezoneExtras') &&
method_exists('\App\Http\Extras\HomezoneExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\HomezoneExtras::canUpdate($request, $Homezones);
}catch (\Throwable $e){

}

}


if($canSave){
$Homezones->save();
}else{
return response()->json($Homezones, 200);

}


$Homezones=Homezone::find($Homezones->id);



$newCrudData=[];

                $newCrudData['libelle']=$Homezones->libelle;
                $newCrudData['type']=$Homezones->type;
                $newCrudData['zone_id']=$Homezones->zone_id;
                $newCrudData['modelslisting_id']=$Homezones->modelslisting_id;
                $newCrudData['creat_by']=$Homezones->creat_by;
                                $newCrudData['modelslisting']=$Homezones->modelslisting;
                $newCrudData['effectifsjour']=$Homezones->effectifsjour;
                $newCrudData['presentsjour']=$Homezones->presentsjour;
                $newCrudData['effectifsnuit']=$Homezones->effectifsnuit;
                $newCrudData['presentsnuit']=$Homezones->presentsnuit;
                $newCrudData['identifiants_sadge']=$Homezones->identifiants_sadge;
    
 try{ $newCrudData['modelslisting']=$Homezones->modelslisting->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Homezones->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Homezones','entite_cle' => $Homezones->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Homezones->toArray();




try{

foreach ($Homezones->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Homezone $Homezones)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des homezones');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Homezones->libelle;
                $newCrudData['type']=$Homezones->type;
                $newCrudData['zone_id']=$Homezones->zone_id;
                $newCrudData['modelslisting_id']=$Homezones->modelslisting_id;
                $newCrudData['creat_by']=$Homezones->creat_by;
                                $newCrudData['modelslisting']=$Homezones->modelslisting;
                $newCrudData['effectifsjour']=$Homezones->effectifsjour;
                $newCrudData['presentsjour']=$Homezones->presentsjour;
                $newCrudData['effectifsnuit']=$Homezones->effectifsnuit;
                $newCrudData['presentsnuit']=$Homezones->presentsnuit;
                $newCrudData['identifiants_sadge']=$Homezones->identifiants_sadge;
    
 try{ $newCrudData['modelslisting']=$Homezones->modelslisting->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Homezones->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Homezones','entite_cle' => $Homezones->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\HomezoneExtras') &&
method_exists('\App\Http\Extras\HomezoneExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\HomezoneExtras::canDelete($request, $Homezones);
}catch (\Throwable $e){

}

}



if($canSave){
$Homezones->delete();
}else{
return response()->json($Homezones, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\HomezonesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
