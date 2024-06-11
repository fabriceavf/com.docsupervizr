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
// use App\Repository\prod\SitespointeusesRepository;
use App\Models\Sitespointeuse;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Pointeuse;
                use App\Models\Site;
    
class SitespointeuseController extends Controller
{

private $SitespointeusesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\SitespointeusesRepository $SitespointeusesRepository
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
class_exists('\App\Http\Extras\SitespointeuseExtras') &&
method_exists('\App\Http\Extras\SitespointeuseExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\SitespointeuseExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Sitespointeuse::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\SitespointeuseExtras') &&
method_exists('\App\Http\Extras\SitespointeuseExtras', 'filterAgGridQuery')
){
\App\Http\Extras\SitespointeuseExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('sitespointeuses',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\SitespointeuseExtras') &&
method_exists('\App\Http\Extras\SitespointeuseExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\SitespointeuseExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  sitespointeuses reussi',
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
return response()->json(Sitespointeuse::count());
}
$data = QueryBuilder::for(Sitespointeuse::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('pointeuse_id'),

    
            AllowedFilter::exact('retirer'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
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

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('pointeuse_id'),

    
            AllowedSort::field('retirer'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
])
    
    
->allowedIncludes([

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




$data = QueryBuilder::for(Sitespointeuse::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('pointeuse_id'),

    
            AllowedFilter::exact('retirer'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
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

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('pointeuse_id'),

    
            AllowedSort::field('retirer'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
])
    
    
->allowedIncludes([
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



public function create(Request $request, Sitespointeuse $Sitespointeuses)
{


try{
$can=\App\Helpers\Helpers::can('Creer des sitespointeuses');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "sitespointeuses"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'site_id',
    'pointeuse_id',
    'retirer',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'debut',
    'fin',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'pointeuse_id' => [
            //'required'
            ],
        
    
    
                    'retirer' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'pointeuse_id' => ['cette donnee est obligatoire'],

    
    
        'retirer' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['site_id'])){
        
            $Sitespointeuses->site_id = $data['site_id'];
        
        }



    







    

        if(!empty($data['pointeuse_id'])){
        
            $Sitespointeuses->pointeuse_id = $data['pointeuse_id'];
        
        }



    







    

        if(!empty($data['retirer'])){
        
            $Sitespointeuses->retirer = $data['retirer'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Sitespointeuses->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['debut'])){
        
            $Sitespointeuses->debut = $data['debut'];
        
        }



    







    

        if(!empty($data['fin'])){
        
            $Sitespointeuses->fin = $data['fin'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Sitespointeuses->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\SitespointeuseExtras') &&
method_exists('\App\Http\Extras\SitespointeuseExtras', 'beforeSaveCreate')
){
\App\Http\Extras\SitespointeuseExtras::beforeSaveCreate($request,$Sitespointeuses);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\SitespointeuseExtras') &&
method_exists('\App\Http\Extras\SitespointeuseExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\SitespointeuseExtras::canCreate($request, $Sitespointeuses);
}catch (\Throwable $e){

}

}


if($canSave){
$Sitespointeuses->save();
}else{
return response()->json($Sitespointeuses, 200);
}

$Sitespointeuses=Sitespointeuse::find($Sitespointeuses->id);
$newCrudData=[];

                $newCrudData['site_id']=$Sitespointeuses->site_id;
                $newCrudData['pointeuse_id']=$Sitespointeuses->pointeuse_id;
                $newCrudData['retirer']=$Sitespointeuses->retirer;
                $newCrudData['creat_by']=$Sitespointeuses->creat_by;
                                $newCrudData['debut']=$Sitespointeuses->debut;
                $newCrudData['fin']=$Sitespointeuses->fin;
    
 try{ $newCrudData['pointeuse']=$Sitespointeuses->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Sitespointeuses->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Sitespointeuses','entite_cle' => $Sitespointeuses->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Sitespointeuses->toArray();




try{

foreach ($Sitespointeuses->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Sitespointeuse $Sitespointeuses)
{
try{
$can=\App\Helpers\Helpers::can('Editer des sitespointeuses');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['site_id']=$Sitespointeuses->site_id;
                $oldCrudData['pointeuse_id']=$Sitespointeuses->pointeuse_id;
                $oldCrudData['retirer']=$Sitespointeuses->retirer;
                $oldCrudData['creat_by']=$Sitespointeuses->creat_by;
                                $oldCrudData['debut']=$Sitespointeuses->debut;
                $oldCrudData['fin']=$Sitespointeuses->fin;
    
 try{ $oldCrudData['pointeuse']=$Sitespointeuses->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['site']=$Sitespointeuses->site->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "sitespointeuses"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'site_id',
    'pointeuse_id',
    'retirer',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'debut',
    'fin',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'pointeuse_id' => [
            //'required'
            ],
        
    
    
                    'retirer' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'pointeuse_id' => ['cette donnee est obligatoire'],

    
    
        'retirer' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Sitespointeuses->site_id = $data['site_id'];
        
        }

        }

    







    

        if(array_key_exists("pointeuse_id",$data)){


        if(!empty($data['pointeuse_id'])){
        
            $Sitespointeuses->pointeuse_id = $data['pointeuse_id'];
        
        }

        }

    







    

        if(array_key_exists("retirer",$data)){


        if(!empty($data['retirer'])){
        
            $Sitespointeuses->retirer = $data['retirer'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Sitespointeuses->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("debut",$data)){


        if(!empty($data['debut'])){
        
            $Sitespointeuses->debut = $data['debut'];
        
        }

        }

    







    

        if(array_key_exists("fin",$data)){


        if(!empty($data['fin'])){
        
            $Sitespointeuses->fin = $data['fin'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Sitespointeuses->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\SitespointeuseExtras') &&
method_exists('\App\Http\Extras\SitespointeuseExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\SitespointeuseExtras::beforeSaveUpdate($request,$Sitespointeuses);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\SitespointeuseExtras') &&
method_exists('\App\Http\Extras\SitespointeuseExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\SitespointeuseExtras::canUpdate($request, $Sitespointeuses);
}catch (\Throwable $e){

}

}


if($canSave){
$Sitespointeuses->save();
}else{
return response()->json($Sitespointeuses, 200);

}


$Sitespointeuses=Sitespointeuse::find($Sitespointeuses->id);



$newCrudData=[];

                $newCrudData['site_id']=$Sitespointeuses->site_id;
                $newCrudData['pointeuse_id']=$Sitespointeuses->pointeuse_id;
                $newCrudData['retirer']=$Sitespointeuses->retirer;
                $newCrudData['creat_by']=$Sitespointeuses->creat_by;
                                $newCrudData['debut']=$Sitespointeuses->debut;
                $newCrudData['fin']=$Sitespointeuses->fin;
    
 try{ $newCrudData['pointeuse']=$Sitespointeuses->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Sitespointeuses->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Sitespointeuses','entite_cle' => $Sitespointeuses->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Sitespointeuses->toArray();




try{

foreach ($Sitespointeuses->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Sitespointeuse $Sitespointeuses)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des sitespointeuses');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['site_id']=$Sitespointeuses->site_id;
                $newCrudData['pointeuse_id']=$Sitespointeuses->pointeuse_id;
                $newCrudData['retirer']=$Sitespointeuses->retirer;
                $newCrudData['creat_by']=$Sitespointeuses->creat_by;
                                $newCrudData['debut']=$Sitespointeuses->debut;
                $newCrudData['fin']=$Sitespointeuses->fin;
    
 try{ $newCrudData['pointeuse']=$Sitespointeuses->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Sitespointeuses->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Sitespointeuses','entite_cle' => $Sitespointeuses->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\SitespointeuseExtras') &&
method_exists('\App\Http\Extras\SitespointeuseExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\SitespointeuseExtras::canDelete($request, $Sitespointeuses);
}catch (\Throwable $e){

}

}



if($canSave){
$Sitespointeuses->delete();
}else{
return response()->json($Sitespointeuses, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\SitespointeusesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
