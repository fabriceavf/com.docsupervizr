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
// use App\Repository\prod\TrackingsRepository;
use App\Models\Tracking;
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
                use App\Models\Moyenstransport;
    
class TrackingController extends Controller
{

private $TrackingsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TrackingsRepository $TrackingsRepository
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
class_exists('\App\Http\Extras\TrackingExtras') &&
method_exists('\App\Http\Extras\TrackingExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TrackingExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Tracking::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TrackingExtras') &&
method_exists('\App\Http\Extras\TrackingExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TrackingExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('trackings',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TrackingExtras') &&
method_exists('\App\Http\Extras\TrackingExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TrackingExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  trackings reussi',
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
return response()->json(Tracking::count());
}
$data = QueryBuilder::for(Tracking::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('balise_id'),

    
            AllowedFilter::exact('moyenstransport_id'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('date_fin'),

    
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

    
            AllowedSort::field('balise_id'),

    
            AllowedSort::field('moyenstransport_id'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('date_fin'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
->allowedIncludes([

            'balise',
        

                'moyenstransport',
        

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




$data = QueryBuilder::for(Tracking::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('balise_id'),

    
            AllowedFilter::exact('moyenstransport_id'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('date_fin'),

    
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

    
            AllowedSort::field('balise_id'),

    
            AllowedSort::field('moyenstransport_id'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('date_fin'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
->allowedIncludes([
            'balise',
        

                'moyenstransport',
        

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



public function create(Request $request, Tracking $Trackings)
{


try{
$can=\App\Helpers\Helpers::can('Creer des trackings');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "trackings"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'balise_id',
    'moyenstransport_id',
    'date_debut',
    'date_fin',
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
    
    
                    'balise_id' => [
            //'required'
            ],
        
    
    
                    'moyenstransport_id' => [
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
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'balise_id' => ['cette donnee est obligatoire'],

    
    
        'moyenstransport_id' => ['cette donnee est obligatoire'],

    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'date_fin' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['balise_id'])){
        
            $Trackings->balise_id = $data['balise_id'];
        
        }



    







    

        if(!empty($data['moyenstransport_id'])){
        
            $Trackings->moyenstransport_id = $data['moyenstransport_id'];
        
        }



    







    

        if(!empty($data['date_debut'])){
        
            $Trackings->date_debut = $data['date_debut'];
        
        }



    







    

        if(!empty($data['date_fin'])){
        
            $Trackings->date_fin = $data['date_fin'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Trackings->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Trackings->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Trackings->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TrackingExtras') &&
method_exists('\App\Http\Extras\TrackingExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TrackingExtras::beforeSaveCreate($request,$Trackings);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TrackingExtras') &&
method_exists('\App\Http\Extras\TrackingExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TrackingExtras::canCreate($request, $Trackings);
}catch (\Throwable $e){

}

}


if($canSave){
$Trackings->save();
}else{
return response()->json($Trackings, 200);
}

$Trackings=Tracking::find($Trackings->id);
$newCrudData=[];

                $newCrudData['balise_id']=$Trackings->balise_id;
                $newCrudData['moyenstransport_id']=$Trackings->moyenstransport_id;
                $newCrudData['date_debut']=$Trackings->date_debut;
                $newCrudData['date_fin']=$Trackings->date_fin;
                $newCrudData['creat_by']=$Trackings->creat_by;
                                $newCrudData['identifiants_sadge']=$Trackings->identifiants_sadge;
    
 try{ $newCrudData['balise']=$Trackings->balise->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['moyenstransport']=$Trackings->moyenstransport->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Trackings','entite_cle' => $Trackings->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Trackings->toArray();




try{

foreach ($Trackings->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Tracking $Trackings)
{
try{
$can=\App\Helpers\Helpers::can('Editer des trackings');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['balise_id']=$Trackings->balise_id;
                $oldCrudData['moyenstransport_id']=$Trackings->moyenstransport_id;
                $oldCrudData['date_debut']=$Trackings->date_debut;
                $oldCrudData['date_fin']=$Trackings->date_fin;
                $oldCrudData['creat_by']=$Trackings->creat_by;
                                $oldCrudData['identifiants_sadge']=$Trackings->identifiants_sadge;
    
 try{ $oldCrudData['balise']=$Trackings->balise->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['moyenstransport']=$Trackings->moyenstransport->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "trackings"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'balise_id',
    'moyenstransport_id',
    'date_debut',
    'date_fin',
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
    
    
                    'balise_id' => [
            //'required'
            ],
        
    
    
                    'moyenstransport_id' => [
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
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'balise_id' => ['cette donnee est obligatoire'],

    
    
        'moyenstransport_id' => ['cette donnee est obligatoire'],

    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'date_fin' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("balise_id",$data)){


        if(!empty($data['balise_id'])){
        
            $Trackings->balise_id = $data['balise_id'];
        
        }

        }

    







    

        if(array_key_exists("moyenstransport_id",$data)){


        if(!empty($data['moyenstransport_id'])){
        
            $Trackings->moyenstransport_id = $data['moyenstransport_id'];
        
        }

        }

    







    

        if(array_key_exists("date_debut",$data)){


        if(!empty($data['date_debut'])){
        
            $Trackings->date_debut = $data['date_debut'];
        
        }

        }

    







    

        if(array_key_exists("date_fin",$data)){


        if(!empty($data['date_fin'])){
        
            $Trackings->date_fin = $data['date_fin'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Trackings->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Trackings->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Trackings->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TrackingExtras') &&
method_exists('\App\Http\Extras\TrackingExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TrackingExtras::beforeSaveUpdate($request,$Trackings);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TrackingExtras') &&
method_exists('\App\Http\Extras\TrackingExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TrackingExtras::canUpdate($request, $Trackings);
}catch (\Throwable $e){

}

}


if($canSave){
$Trackings->save();
}else{
return response()->json($Trackings, 200);

}


$Trackings=Tracking::find($Trackings->id);



$newCrudData=[];

                $newCrudData['balise_id']=$Trackings->balise_id;
                $newCrudData['moyenstransport_id']=$Trackings->moyenstransport_id;
                $newCrudData['date_debut']=$Trackings->date_debut;
                $newCrudData['date_fin']=$Trackings->date_fin;
                $newCrudData['creat_by']=$Trackings->creat_by;
                                $newCrudData['identifiants_sadge']=$Trackings->identifiants_sadge;
    
 try{ $newCrudData['balise']=$Trackings->balise->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['moyenstransport']=$Trackings->moyenstransport->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Trackings','entite_cle' => $Trackings->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Trackings->toArray();




try{

foreach ($Trackings->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Tracking $Trackings)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des trackings');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['balise_id']=$Trackings->balise_id;
                $newCrudData['moyenstransport_id']=$Trackings->moyenstransport_id;
                $newCrudData['date_debut']=$Trackings->date_debut;
                $newCrudData['date_fin']=$Trackings->date_fin;
                $newCrudData['creat_by']=$Trackings->creat_by;
                                $newCrudData['identifiants_sadge']=$Trackings->identifiants_sadge;
    
 try{ $newCrudData['balise']=$Trackings->balise->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['moyenstransport']=$Trackings->moyenstransport->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Trackings','entite_cle' => $Trackings->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TrackingExtras') &&
method_exists('\App\Http\Extras\TrackingExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TrackingExtras::canDelete($request, $Trackings);
}catch (\Throwable $e){

}

}



if($canSave){
$Trackings->delete();
}else{
return response()->json($Trackings, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TrackingsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
