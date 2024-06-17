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
// use App\Repository\prod\TrajetsRepository;
use App\Models\Trajet;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Ligne;
                use App\Models\Site;
    
class TrajetController extends Controller
{

private $TrajetsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TrajetsRepository $TrajetsRepository
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
class_exists('\App\Http\Extras\TrajetExtras') &&
method_exists('\App\Http\Extras\TrajetExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TrajetExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Trajet::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TrajetExtras') &&
method_exists('\App\Http\Extras\TrajetExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TrajetExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('trajets',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TrajetExtras') &&
method_exists('\App\Http\Extras\TrajetExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TrajetExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  trajets reussi',
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
return response()->json(Trajet::count());
}
$data = QueryBuilder::for(Trajet::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('ligne_id'),

    
            AllowedFilter::exact('distance'),

    
    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('identifiants_sadge'),

    
    
    
    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('durees'),

    
            AllowedFilter::exact('ordre'),

    
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

    
            AllowedSort::field('ligne_id'),

    
            AllowedSort::field('distance'),

    
    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('identifiants_sadge'),

    
    
    
    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('durees'),

    
            AllowedSort::field('ordre'),

    
])
    
    
->allowedIncludes([

            'ligne',
        

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




$data = QueryBuilder::for(Trajet::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('ligne_id'),

    
            AllowedFilter::exact('distance'),

    
    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('identifiants_sadge'),

    
    
    
    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('durees'),

    
            AllowedFilter::exact('ordre'),

    
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

    
            AllowedSort::field('ligne_id'),

    
            AllowedSort::field('distance'),

    
    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('identifiants_sadge'),

    
    
    
    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('durees'),

    
            AllowedSort::field('ordre'),

    
])
    
    
->allowedIncludes([
            'ligne',
        

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



public function create(Request $request, Trajet $Trajets)
{


try{
$can=\App\Helpers\Helpers::can('Creer des trajets');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "trajets"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'ligne_id',
    'distance',
    'deleted_at',
    'creat_by',
    'identifiants_sadge',
    'extra_attributes',
    'created_at',
    'updated_at',
    'site_id',
    'durees',
    'ordre',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'ligne_id' => [
            //'required'
            ],
        
    
    
                    'distance' => [
            //'required'
            ],
        
    
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
    
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'durees' => [
            //'required'
            ],
        
    
    
                    'ordre' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'ligne_id' => ['cette donnee est obligatoire'],

    
    
        'distance' => ['cette donnee est obligatoire'],

    
    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'durees' => ['cette donnee est obligatoire'],

    
    
        'ordre' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['ligne_id'])){
        
            $Trajets->ligne_id = $data['ligne_id'];
        
        }



    







    

        if(!empty($data['distance'])){
        
            $Trajets->distance = $data['distance'];
        
        }



    







    







    

        if(!empty($data['creat_by'])){
        
            $Trajets->creat_by = $data['creat_by'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Trajets->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    







    







    







    

        if(!empty($data['site_id'])){
        
            $Trajets->site_id = $data['site_id'];
        
        }



    







    

        if(!empty($data['durees'])){
        
            $Trajets->durees = $data['durees'];
        
        }



    







    

        if(!empty($data['ordre'])){
        
            $Trajets->ordre = $data['ordre'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Trajets->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TrajetExtras') &&
method_exists('\App\Http\Extras\TrajetExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TrajetExtras::beforeSaveCreate($request,$Trajets);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TrajetExtras') &&
method_exists('\App\Http\Extras\TrajetExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TrajetExtras::canCreate($request, $Trajets);
}catch (\Throwable $e){

}

}


if($canSave){
$Trajets->save();
}else{
return response()->json($Trajets, 200);
}

$Trajets=Trajet::find($Trajets->id);
$newCrudData=[];

                $newCrudData['ligne_id']=$Trajets->ligne_id;
                $newCrudData['distance']=$Trajets->distance;
                    $newCrudData['creat_by']=$Trajets->creat_by;
                $newCrudData['identifiants_sadge']=$Trajets->identifiants_sadge;
                            $newCrudData['site_id']=$Trajets->site_id;
                $newCrudData['durees']=$Trajets->durees;
                $newCrudData['ordre']=$Trajets->ordre;
    
 try{ $newCrudData['ligne']=$Trajets->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Trajets->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Trajets','entite_cle' => $Trajets->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Trajets->toArray();




try{

foreach ($Trajets->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Trajet $Trajets)
{
try{
$can=\App\Helpers\Helpers::can('Editer des trajets');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['ligne_id']=$Trajets->ligne_id;
                $oldCrudData['distance']=$Trajets->distance;
                    $oldCrudData['creat_by']=$Trajets->creat_by;
                $oldCrudData['identifiants_sadge']=$Trajets->identifiants_sadge;
                            $oldCrudData['site_id']=$Trajets->site_id;
                $oldCrudData['durees']=$Trajets->durees;
                $oldCrudData['ordre']=$Trajets->ordre;
    
 try{ $oldCrudData['ligne']=$Trajets->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['site']=$Trajets->site->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "trajets"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'ligne_id',
    'distance',
    'deleted_at',
    'creat_by',
    'identifiants_sadge',
    'extra_attributes',
    'created_at',
    'updated_at',
    'site_id',
    'durees',
    'ordre',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'ligne_id' => [
            //'required'
            ],
        
    
    
                    'distance' => [
            //'required'
            ],
        
    
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
    
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'durees' => [
            //'required'
            ],
        
    
    
                    'ordre' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'ligne_id' => ['cette donnee est obligatoire'],

    
    
        'distance' => ['cette donnee est obligatoire'],

    
    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'durees' => ['cette donnee est obligatoire'],

    
    
        'ordre' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("ligne_id",$data)){


        if(!empty($data['ligne_id'])){
        
            $Trajets->ligne_id = $data['ligne_id'];
        
        }

        }

    







    

        if(array_key_exists("distance",$data)){


        if(!empty($data['distance'])){
        
            $Trajets->distance = $data['distance'];
        
        }

        }

    







    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Trajets->creat_by = $data['creat_by'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Trajets->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    







    







    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Trajets->site_id = $data['site_id'];
        
        }

        }

    







    

        if(array_key_exists("durees",$data)){


        if(!empty($data['durees'])){
        
            $Trajets->durees = $data['durees'];
        
        }

        }

    







    

        if(array_key_exists("ordre",$data)){


        if(!empty($data['ordre'])){
        
            $Trajets->ordre = $data['ordre'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Trajets->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TrajetExtras') &&
method_exists('\App\Http\Extras\TrajetExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TrajetExtras::beforeSaveUpdate($request,$Trajets);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TrajetExtras') &&
method_exists('\App\Http\Extras\TrajetExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TrajetExtras::canUpdate($request, $Trajets);
}catch (\Throwable $e){

}

}


if($canSave){
$Trajets->save();
}else{
return response()->json($Trajets, 200);

}


$Trajets=Trajet::find($Trajets->id);



$newCrudData=[];

                $newCrudData['ligne_id']=$Trajets->ligne_id;
                $newCrudData['distance']=$Trajets->distance;
                    $newCrudData['creat_by']=$Trajets->creat_by;
                $newCrudData['identifiants_sadge']=$Trajets->identifiants_sadge;
                            $newCrudData['site_id']=$Trajets->site_id;
                $newCrudData['durees']=$Trajets->durees;
                $newCrudData['ordre']=$Trajets->ordre;
    
 try{ $newCrudData['ligne']=$Trajets->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Trajets->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Trajets','entite_cle' => $Trajets->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Trajets->toArray();




try{

foreach ($Trajets->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Trajet $Trajets)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des trajets');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['ligne_id']=$Trajets->ligne_id;
                $newCrudData['distance']=$Trajets->distance;
                    $newCrudData['creat_by']=$Trajets->creat_by;
                $newCrudData['identifiants_sadge']=$Trajets->identifiants_sadge;
                            $newCrudData['site_id']=$Trajets->site_id;
                $newCrudData['durees']=$Trajets->durees;
                $newCrudData['ordre']=$Trajets->ordre;
    
 try{ $newCrudData['ligne']=$Trajets->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Trajets->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Trajets','entite_cle' => $Trajets->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TrajetExtras') &&
method_exists('\App\Http\Extras\TrajetExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TrajetExtras::canDelete($request, $Trajets);
}catch (\Throwable $e){

}

}



if($canSave){
$Trajets->delete();
}else{
return response()->json($Trajets, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TrajetsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
