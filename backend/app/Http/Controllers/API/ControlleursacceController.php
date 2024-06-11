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
// use App\Repository\prod\ControlleursaccesRepository;
use App\Models\Controlleursacce;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Deplacement;
                use App\Models\Ligne;
                use App\Models\Pointeuse;
                use App\Models\Site;
    
class ControlleursacceController extends Controller
{

private $ControlleursaccesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ControlleursaccesRepository $ControlleursaccesRepository
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
class_exists('\App\Http\Extras\ControlleursacceExtras') &&
method_exists('\App\Http\Extras\ControlleursacceExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ControlleursacceExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Controlleursacce::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ControlleursacceExtras') &&
method_exists('\App\Http\Extras\ControlleursacceExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ControlleursacceExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('controlleursacces',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ControlleursacceExtras') &&
method_exists('\App\Http\Extras\ControlleursacceExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ControlleursacceExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  controlleursacces reussi',
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
return response()->json(Controlleursacce::count());
}
$data = QueryBuilder::for(Controlleursacce::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('pointeuse_id'),

    
            AllowedFilter::exact('ligne_id'),

    
            AllowedFilter::exact('deplacement_id'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('date_fin'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('type'),

    
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

    
            AllowedSort::field('pointeuse_id'),

    
            AllowedSort::field('ligne_id'),

    
            AllowedSort::field('deplacement_id'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('date_fin'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('type'),

    
])
    
    
    
    
->allowedIncludes([
            'transactions',
        

    
            'deplacement',
        

                'ligne',
        

                'pointeuse',
        

                'site',
        

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




$data = QueryBuilder::for(Controlleursacce::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('pointeuse_id'),

    
            AllowedFilter::exact('ligne_id'),

    
            AllowedFilter::exact('deplacement_id'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('date_fin'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('type'),

    
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

    
            AllowedSort::field('pointeuse_id'),

    
            AllowedSort::field('ligne_id'),

    
            AllowedSort::field('deplacement_id'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('date_fin'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('type'),

    
])
    
    
    
    
->allowedIncludes([
            'transactions',
        

                'deplacement',
        

                'ligne',
        

                'pointeuse',
        

                'site',
        

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



public function create(Request $request, Controlleursacce $Controlleursacces)
{


try{
$can=\App\Helpers\Helpers::can('Creer des controlleursacces');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "controlleursacces"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'pointeuse_id',
    'ligne_id',
    'deplacement_id',
    'site_id',
    'date_debut',
    'date_fin',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'type',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'pointeuse_id' => [
            //'required'
            ],
        
    
    
                    'ligne_id' => [
            //'required'
            ],
        
    
    
                    'deplacement_id' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'date_debut' => [
            //'required'
            ],
        
    
    
                    'date_fin' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'type' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'pointeuse_id' => ['cette donnee est obligatoire'],

    
    
        'ligne_id' => ['cette donnee est obligatoire'],

    
    
        'deplacement_id' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'date_fin' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'type' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['pointeuse_id'])){
        
            $Controlleursacces->pointeuse_id = $data['pointeuse_id'];
        
        }



    







    

        if(!empty($data['ligne_id'])){
        
            $Controlleursacces->ligne_id = $data['ligne_id'];
        
        }



    







    

        if(!empty($data['deplacement_id'])){
        
            $Controlleursacces->deplacement_id = $data['deplacement_id'];
        
        }



    







    

        if(!empty($data['site_id'])){
        
            $Controlleursacces->site_id = $data['site_id'];
        
        }



    







    

        if(!empty($data['date_debut'])){
        
            $Controlleursacces->date_debut = $data['date_debut'];
        
        }



    







    

        if(!empty($data['date_fin'])){
        
            $Controlleursacces->date_fin = $data['date_fin'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Controlleursacces->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['type'])){
        
            $Controlleursacces->type = $data['type'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Controlleursacces->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ControlleursacceExtras') &&
method_exists('\App\Http\Extras\ControlleursacceExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ControlleursacceExtras::beforeSaveCreate($request,$Controlleursacces);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ControlleursacceExtras') &&
method_exists('\App\Http\Extras\ControlleursacceExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ControlleursacceExtras::canCreate($request, $Controlleursacces);
}catch (\Throwable $e){

}

}


if($canSave){
$Controlleursacces->save();
}else{
return response()->json($Controlleursacces, 200);
}

$Controlleursacces=Controlleursacce::find($Controlleursacces->id);
$newCrudData=[];

                $newCrudData['pointeuse_id']=$Controlleursacces->pointeuse_id;
                $newCrudData['ligne_id']=$Controlleursacces->ligne_id;
                $newCrudData['deplacement_id']=$Controlleursacces->deplacement_id;
                $newCrudData['site_id']=$Controlleursacces->site_id;
                $newCrudData['date_debut']=$Controlleursacces->date_debut;
                $newCrudData['date_fin']=$Controlleursacces->date_fin;
                $newCrudData['creat_by']=$Controlleursacces->creat_by;
                                $newCrudData['type']=$Controlleursacces->type;
    
 try{ $newCrudData['deplacement']=$Controlleursacces->deplacement->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ligne']=$Controlleursacces->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['pointeuse']=$Controlleursacces->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Controlleursacces->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Controlleursacces','entite_cle' => $Controlleursacces->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Controlleursacces->toArray();




try{

foreach ($Controlleursacces->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Controlleursacce $Controlleursacces)
{
try{
$can=\App\Helpers\Helpers::can('Editer des controlleursacces');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['pointeuse_id']=$Controlleursacces->pointeuse_id;
                $oldCrudData['ligne_id']=$Controlleursacces->ligne_id;
                $oldCrudData['deplacement_id']=$Controlleursacces->deplacement_id;
                $oldCrudData['site_id']=$Controlleursacces->site_id;
                $oldCrudData['date_debut']=$Controlleursacces->date_debut;
                $oldCrudData['date_fin']=$Controlleursacces->date_fin;
                $oldCrudData['creat_by']=$Controlleursacces->creat_by;
                                $oldCrudData['type']=$Controlleursacces->type;
    
 try{ $oldCrudData['deplacement']=$Controlleursacces->deplacement->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['ligne']=$Controlleursacces->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['pointeuse']=$Controlleursacces->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['site']=$Controlleursacces->site->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "controlleursacces"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'pointeuse_id',
    'ligne_id',
    'deplacement_id',
    'site_id',
    'date_debut',
    'date_fin',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'type',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'pointeuse_id' => [
            //'required'
            ],
        
    
    
                    'ligne_id' => [
            //'required'
            ],
        
    
    
                    'deplacement_id' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'date_debut' => [
            //'required'
            ],
        
    
    
                    'date_fin' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'type' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'pointeuse_id' => ['cette donnee est obligatoire'],

    
    
        'ligne_id' => ['cette donnee est obligatoire'],

    
    
        'deplacement_id' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'date_fin' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'type' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("pointeuse_id",$data)){


        if(!empty($data['pointeuse_id'])){
        
            $Controlleursacces->pointeuse_id = $data['pointeuse_id'];
        
        }

        }

    







    

        if(array_key_exists("ligne_id",$data)){


        if(!empty($data['ligne_id'])){
        
            $Controlleursacces->ligne_id = $data['ligne_id'];
        
        }

        }

    







    

        if(array_key_exists("deplacement_id",$data)){


        if(!empty($data['deplacement_id'])){
        
            $Controlleursacces->deplacement_id = $data['deplacement_id'];
        
        }

        }

    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Controlleursacces->site_id = $data['site_id'];
        
        }

        }

    







    

        if(array_key_exists("date_debut",$data)){


        if(!empty($data['date_debut'])){
        
            $Controlleursacces->date_debut = $data['date_debut'];
        
        }

        }

    







    

        if(array_key_exists("date_fin",$data)){


        if(!empty($data['date_fin'])){
        
            $Controlleursacces->date_fin = $data['date_fin'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Controlleursacces->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Controlleursacces->type = $data['type'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Controlleursacces->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ControlleursacceExtras') &&
method_exists('\App\Http\Extras\ControlleursacceExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ControlleursacceExtras::beforeSaveUpdate($request,$Controlleursacces);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ControlleursacceExtras') &&
method_exists('\App\Http\Extras\ControlleursacceExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ControlleursacceExtras::canUpdate($request, $Controlleursacces);
}catch (\Throwable $e){

}

}


if($canSave){
$Controlleursacces->save();
}else{
return response()->json($Controlleursacces, 200);

}


$Controlleursacces=Controlleursacce::find($Controlleursacces->id);



$newCrudData=[];

                $newCrudData['pointeuse_id']=$Controlleursacces->pointeuse_id;
                $newCrudData['ligne_id']=$Controlleursacces->ligne_id;
                $newCrudData['deplacement_id']=$Controlleursacces->deplacement_id;
                $newCrudData['site_id']=$Controlleursacces->site_id;
                $newCrudData['date_debut']=$Controlleursacces->date_debut;
                $newCrudData['date_fin']=$Controlleursacces->date_fin;
                $newCrudData['creat_by']=$Controlleursacces->creat_by;
                                $newCrudData['type']=$Controlleursacces->type;
    
 try{ $newCrudData['deplacement']=$Controlleursacces->deplacement->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ligne']=$Controlleursacces->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['pointeuse']=$Controlleursacces->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Controlleursacces->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Controlleursacces','entite_cle' => $Controlleursacces->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Controlleursacces->toArray();




try{

foreach ($Controlleursacces->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Controlleursacce $Controlleursacces)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des controlleursacces');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['pointeuse_id']=$Controlleursacces->pointeuse_id;
                $newCrudData['ligne_id']=$Controlleursacces->ligne_id;
                $newCrudData['deplacement_id']=$Controlleursacces->deplacement_id;
                $newCrudData['site_id']=$Controlleursacces->site_id;
                $newCrudData['date_debut']=$Controlleursacces->date_debut;
                $newCrudData['date_fin']=$Controlleursacces->date_fin;
                $newCrudData['creat_by']=$Controlleursacces->creat_by;
                                $newCrudData['type']=$Controlleursacces->type;
    
 try{ $newCrudData['deplacement']=$Controlleursacces->deplacement->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ligne']=$Controlleursacces->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['pointeuse']=$Controlleursacces->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Controlleursacces->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Controlleursacces','entite_cle' => $Controlleursacces->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ControlleursacceExtras') &&
method_exists('\App\Http\Extras\ControlleursacceExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ControlleursacceExtras::canDelete($request, $Controlleursacces);
}catch (\Throwable $e){

}

}



if($canSave){
$Controlleursacces->delete();
}else{
return response()->json($Controlleursacces, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ControlleursaccesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
