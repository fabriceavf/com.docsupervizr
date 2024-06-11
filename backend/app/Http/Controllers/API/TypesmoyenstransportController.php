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
// use App\Repository\prod\TypesmoyenstransportsRepository;
use App\Models\Typesmoyenstransport;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;




class TypesmoyenstransportController extends Controller
{

private $TypesmoyenstransportsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TypesmoyenstransportsRepository $TypesmoyenstransportsRepository
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
class_exists('\App\Http\Extras\TypesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\TypesmoyenstransportExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TypesmoyenstransportExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Typesmoyenstransport::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TypesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\TypesmoyenstransportExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TypesmoyenstransportExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('typesmoyenstransports',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TypesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\TypesmoyenstransportExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TypesmoyenstransportExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  typesmoyenstransports reussi',
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
return response()->json(Typesmoyenstransport::count());
}
$data = QueryBuilder::for(Typesmoyenstransport::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('canCreate'),

    
            AllowedFilter::exact('canUpdate'),

    
            AllowedFilter::exact('canDelete'),

    
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

    
            AllowedSort::field('code'),

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('canCreate'),

    
            AllowedSort::field('canUpdate'),

    
            AllowedSort::field('canDelete'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
])
->allowedIncludes([
            'moyenstransports',
        

    
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




$data = QueryBuilder::for(Typesmoyenstransport::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('canCreate'),

    
            AllowedFilter::exact('canUpdate'),

    
            AllowedFilter::exact('canDelete'),

    
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

    
            AllowedSort::field('code'),

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('canCreate'),

    
            AllowedSort::field('canUpdate'),

    
            AllowedSort::field('canDelete'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
])
->allowedIncludes([
            'moyenstransports',
        

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



public function create(Request $request, Typesmoyenstransport $Typesmoyenstransports)
{


try{
$can=\App\Helpers\Helpers::can('Creer des typesmoyenstransports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "typesmoyenstransports"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'libelle',
    'canCreate',
    'canUpdate',
    'canDelete',
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
    
    
                    'code' => [
            //'required'
            ],
        
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'canCreate' => [
            //'required'
            ],
        
    
    
                    'canUpdate' => [
            //'required'
            ],
        
    
    
                    'canDelete' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'canCreate' => ['cette donnee est obligatoire'],

    
    
        'canUpdate' => ['cette donnee est obligatoire'],

    
    
        'canDelete' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['code'])){
        
            $Typesmoyenstransports->code = $data['code'];
        
        }



    







    

        if(!empty($data['libelle'])){
        
            $Typesmoyenstransports->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['canCreate'])){
        
            $Typesmoyenstransports->canCreate = $data['canCreate'];
        
        }



    







    

        if(!empty($data['canUpdate'])){
        
            $Typesmoyenstransports->canUpdate = $data['canUpdate'];
        
        }



    







    

        if(!empty($data['canDelete'])){
        
            $Typesmoyenstransports->canDelete = $data['canDelete'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Typesmoyenstransports->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Typesmoyenstransports->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TypesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\TypesmoyenstransportExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TypesmoyenstransportExtras::beforeSaveCreate($request,$Typesmoyenstransports);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TypesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\TypesmoyenstransportExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TypesmoyenstransportExtras::canCreate($request, $Typesmoyenstransports);
}catch (\Throwable $e){

}

}


if($canSave){
$Typesmoyenstransports->save();
}else{
return response()->json($Typesmoyenstransports, 200);
}

$Typesmoyenstransports=Typesmoyenstransport::find($Typesmoyenstransports->id);
$newCrudData=[];

                $newCrudData['code']=$Typesmoyenstransports->code;
                $newCrudData['libelle']=$Typesmoyenstransports->libelle;
                $newCrudData['canCreate']=$Typesmoyenstransports->canCreate;
                $newCrudData['canUpdate']=$Typesmoyenstransports->canUpdate;
                $newCrudData['canDelete']=$Typesmoyenstransports->canDelete;
                $newCrudData['creat_by']=$Typesmoyenstransports->creat_by;
                    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Typesmoyenstransports','entite_cle' => $Typesmoyenstransports->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Typesmoyenstransports->toArray();




try{

foreach ($Typesmoyenstransports->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Typesmoyenstransport $Typesmoyenstransports)
{
try{
$can=\App\Helpers\Helpers::can('Editer des typesmoyenstransports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['code']=$Typesmoyenstransports->code;
                $oldCrudData['libelle']=$Typesmoyenstransports->libelle;
                $oldCrudData['canCreate']=$Typesmoyenstransports->canCreate;
                $oldCrudData['canUpdate']=$Typesmoyenstransports->canUpdate;
                $oldCrudData['canDelete']=$Typesmoyenstransports->canDelete;
                $oldCrudData['creat_by']=$Typesmoyenstransports->creat_by;
                    


$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "typesmoyenstransports"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'libelle',
    'canCreate',
    'canUpdate',
    'canDelete',
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
    
    
                    'code' => [
            //'required'
            ],
        
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'canCreate' => [
            //'required'
            ],
        
    
    
                    'canUpdate' => [
            //'required'
            ],
        
    
    
                    'canDelete' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'canCreate' => ['cette donnee est obligatoire'],

    
    
        'canUpdate' => ['cette donnee est obligatoire'],

    
    
        'canDelete' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("code",$data)){


        if(!empty($data['code'])){
        
            $Typesmoyenstransports->code = $data['code'];
        
        }

        }

    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Typesmoyenstransports->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("canCreate",$data)){


        if(!empty($data['canCreate'])){
        
            $Typesmoyenstransports->canCreate = $data['canCreate'];
        
        }

        }

    







    

        if(array_key_exists("canUpdate",$data)){


        if(!empty($data['canUpdate'])){
        
            $Typesmoyenstransports->canUpdate = $data['canUpdate'];
        
        }

        }

    







    

        if(array_key_exists("canDelete",$data)){


        if(!empty($data['canDelete'])){
        
            $Typesmoyenstransports->canDelete = $data['canDelete'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Typesmoyenstransports->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Typesmoyenstransports->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TypesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\TypesmoyenstransportExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TypesmoyenstransportExtras::beforeSaveUpdate($request,$Typesmoyenstransports);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TypesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\TypesmoyenstransportExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TypesmoyenstransportExtras::canUpdate($request, $Typesmoyenstransports);
}catch (\Throwable $e){

}

}


if($canSave){
$Typesmoyenstransports->save();
}else{
return response()->json($Typesmoyenstransports, 200);

}


$Typesmoyenstransports=Typesmoyenstransport::find($Typesmoyenstransports->id);



$newCrudData=[];

                $newCrudData['code']=$Typesmoyenstransports->code;
                $newCrudData['libelle']=$Typesmoyenstransports->libelle;
                $newCrudData['canCreate']=$Typesmoyenstransports->canCreate;
                $newCrudData['canUpdate']=$Typesmoyenstransports->canUpdate;
                $newCrudData['canDelete']=$Typesmoyenstransports->canDelete;
                $newCrudData['creat_by']=$Typesmoyenstransports->creat_by;
                    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Typesmoyenstransports','entite_cle' => $Typesmoyenstransports->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Typesmoyenstransports->toArray();




try{

foreach ($Typesmoyenstransports->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Typesmoyenstransport $Typesmoyenstransports)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des typesmoyenstransports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['code']=$Typesmoyenstransports->code;
                $newCrudData['libelle']=$Typesmoyenstransports->libelle;
                $newCrudData['canCreate']=$Typesmoyenstransports->canCreate;
                $newCrudData['canUpdate']=$Typesmoyenstransports->canUpdate;
                $newCrudData['canDelete']=$Typesmoyenstransports->canDelete;
                $newCrudData['creat_by']=$Typesmoyenstransports->creat_by;
                    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Typesmoyenstransports','entite_cle' => $Typesmoyenstransports->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TypesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\TypesmoyenstransportExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TypesmoyenstransportExtras::canDelete($request, $Typesmoyenstransports);
}catch (\Throwable $e){

}

}



if($canSave){
$Typesmoyenstransports->delete();
}else{
return response()->json($Typesmoyenstransports, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TypesmoyenstransportsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
