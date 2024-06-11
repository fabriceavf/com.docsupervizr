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
// use App\Repository\prod\HorairestypessitesRepository;
use App\Models\Horairestypessite;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Typessite;
    
class HorairestypessiteController extends Controller
{

private $HorairestypessitesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\HorairestypessitesRepository $HorairestypessitesRepository
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
class_exists('\App\Http\Extras\HorairestypessiteExtras') &&
method_exists('\App\Http\Extras\HorairestypessiteExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\HorairestypessiteExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Horairestypessite::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\HorairestypessiteExtras') &&
method_exists('\App\Http\Extras\HorairestypessiteExtras', 'filterAgGridQuery')
){
\App\Http\Extras\HorairestypessiteExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('horairestypessites',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\HorairestypessiteExtras') &&
method_exists('\App\Http\Extras\HorairestypessiteExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\HorairestypessiteExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  horairestypessites reussi',
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
return response()->json(Horairestypessite::count());
}
$data = QueryBuilder::for(Horairestypessite::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
            AllowedFilter::exact('typessite_id'),

    
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

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
            AllowedSort::field('typessite_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
])
    
->allowedIncludes([

            'typessite',
        

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




$data = QueryBuilder::for(Horairestypessite::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
            AllowedFilter::exact('typessite_id'),

    
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

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
            AllowedSort::field('typessite_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
])
    
->allowedIncludes([
            'typessite',
        

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



public function create(Request $request, Horairestypessite $Horairestypessites)
{


try{
$can=\App\Helpers\Helpers::can('Creer des horairestypessites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "horairestypessites"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'debut',
    'fin',
    'typessite_id',
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
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    
    
                    'typessite_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
    
        'typessite_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Horairestypessites->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['debut'])){
        
            $Horairestypessites->debut = $data['debut'];
        
        }



    







    

        if(!empty($data['fin'])){
        
            $Horairestypessites->fin = $data['fin'];
        
        }



    







    

        if(!empty($data['typessite_id'])){
        
            $Horairestypessites->typessite_id = $data['typessite_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Horairestypessites->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Horairestypessites->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\HorairestypessiteExtras') &&
method_exists('\App\Http\Extras\HorairestypessiteExtras', 'beforeSaveCreate')
){
\App\Http\Extras\HorairestypessiteExtras::beforeSaveCreate($request,$Horairestypessites);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\HorairestypessiteExtras') &&
method_exists('\App\Http\Extras\HorairestypessiteExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\HorairestypessiteExtras::canCreate($request, $Horairestypessites);
}catch (\Throwable $e){

}

}


if($canSave){
$Horairestypessites->save();
}else{
return response()->json($Horairestypessites, 200);
}

$Horairestypessites=Horairestypessite::find($Horairestypessites->id);
$newCrudData=[];

                $newCrudData['libelle']=$Horairestypessites->libelle;
                $newCrudData['debut']=$Horairestypessites->debut;
                $newCrudData['fin']=$Horairestypessites->fin;
                $newCrudData['typessite_id']=$Horairestypessites->typessite_id;
                $newCrudData['creat_by']=$Horairestypessites->creat_by;
                    
 try{ $newCrudData['typessite']=$Horairestypessites->typessite->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Horairestypessites','entite_cle' => $Horairestypessites->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Horairestypessites->toArray();




try{

foreach ($Horairestypessites->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Horairestypessite $Horairestypessites)
{
try{
$can=\App\Helpers\Helpers::can('Editer des horairestypessites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Horairestypessites->libelle;
                $oldCrudData['debut']=$Horairestypessites->debut;
                $oldCrudData['fin']=$Horairestypessites->fin;
                $oldCrudData['typessite_id']=$Horairestypessites->typessite_id;
                $oldCrudData['creat_by']=$Horairestypessites->creat_by;
                    
 try{ $oldCrudData['typessite']=$Horairestypessites->typessite->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "horairestypessites"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'debut',
    'fin',
    'typessite_id',
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
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    
    
                    'typessite_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
    
        'typessite_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Horairestypessites->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("debut",$data)){


        if(!empty($data['debut'])){
        
            $Horairestypessites->debut = $data['debut'];
        
        }

        }

    







    

        if(array_key_exists("fin",$data)){


        if(!empty($data['fin'])){
        
            $Horairestypessites->fin = $data['fin'];
        
        }

        }

    







    

        if(array_key_exists("typessite_id",$data)){


        if(!empty($data['typessite_id'])){
        
            $Horairestypessites->typessite_id = $data['typessite_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Horairestypessites->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Horairestypessites->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\HorairestypessiteExtras') &&
method_exists('\App\Http\Extras\HorairestypessiteExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\HorairestypessiteExtras::beforeSaveUpdate($request,$Horairestypessites);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\HorairestypessiteExtras') &&
method_exists('\App\Http\Extras\HorairestypessiteExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\HorairestypessiteExtras::canUpdate($request, $Horairestypessites);
}catch (\Throwable $e){

}

}


if($canSave){
$Horairestypessites->save();
}else{
return response()->json($Horairestypessites, 200);

}


$Horairestypessites=Horairestypessite::find($Horairestypessites->id);



$newCrudData=[];

                $newCrudData['libelle']=$Horairestypessites->libelle;
                $newCrudData['debut']=$Horairestypessites->debut;
                $newCrudData['fin']=$Horairestypessites->fin;
                $newCrudData['typessite_id']=$Horairestypessites->typessite_id;
                $newCrudData['creat_by']=$Horairestypessites->creat_by;
                    
 try{ $newCrudData['typessite']=$Horairestypessites->typessite->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Horairestypessites','entite_cle' => $Horairestypessites->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Horairestypessites->toArray();




try{

foreach ($Horairestypessites->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Horairestypessite $Horairestypessites)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des horairestypessites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Horairestypessites->libelle;
                $newCrudData['debut']=$Horairestypessites->debut;
                $newCrudData['fin']=$Horairestypessites->fin;
                $newCrudData['typessite_id']=$Horairestypessites->typessite_id;
                $newCrudData['creat_by']=$Horairestypessites->creat_by;
                    
 try{ $newCrudData['typessite']=$Horairestypessites->typessite->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Horairestypessites','entite_cle' => $Horairestypessites->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\HorairestypessiteExtras') &&
method_exists('\App\Http\Extras\HorairestypessiteExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\HorairestypessiteExtras::canDelete($request, $Horairestypessites);
}catch (\Throwable $e){

}

}



if($canSave){
$Horairestypessites->delete();
}else{
return response()->json($Horairestypessites, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\HorairestypessitesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
