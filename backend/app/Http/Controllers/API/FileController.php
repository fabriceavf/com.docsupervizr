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
// use App\Repository\prod\FilesRepository;
use App\Models\File;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;




class FileController extends Controller
{

private $FilesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\FilesRepository $FilesRepository
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
class_exists('\App\Http\Extras\FileExtras') &&
method_exists('\App\Http\Extras\FileExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\FileExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=File::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\FileExtras') &&
method_exists('\App\Http\Extras\FileExtras', 'filterAgGridQuery')
){
\App\Http\Extras\FileExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('files',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\FileExtras') &&
method_exists('\App\Http\Extras\FileExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\FileExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  files reussi',
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
return response()->json(File::count());
}
$data = QueryBuilder::for(File::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('old_name'),

    
            AllowedFilter::exact('new_name'),

    
            AllowedFilter::exact('descriptions'),

    
            AllowedFilter::exact('extensions'),

    
            AllowedFilter::exact('size'),

    
            AllowedFilter::exact('path'),

    
            AllowedFilter::exact('web_path'),

    
            AllowedFilter::exact('statut'),

    
    
    
    
    
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

    
            AllowedSort::field('old_name'),

    
            AllowedSort::field('new_name'),

    
            AllowedSort::field('descriptions'),

    
            AllowedSort::field('extensions'),

    
            AllowedSort::field('size'),

    
            AllowedSort::field('path'),

    
            AllowedSort::field('web_path'),

    
            AllowedSort::field('statut'),

    
    
    
    
    
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




$data = QueryBuilder::for(File::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('old_name'),

    
            AllowedFilter::exact('new_name'),

    
            AllowedFilter::exact('descriptions'),

    
            AllowedFilter::exact('extensions'),

    
            AllowedFilter::exact('size'),

    
            AllowedFilter::exact('path'),

    
            AllowedFilter::exact('web_path'),

    
            AllowedFilter::exact('statut'),

    
    
    
    
    
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

    
            AllowedSort::field('old_name'),

    
            AllowedSort::field('new_name'),

    
            AllowedSort::field('descriptions'),

    
            AllowedSort::field('extensions'),

    
            AllowedSort::field('size'),

    
            AllowedSort::field('path'),

    
            AllowedSort::field('web_path'),

    
            AllowedSort::field('statut'),

    
    
    
    
    
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



public function create(Request $request, File $Files)
{


try{
$can=\App\Helpers\Helpers::can('Creer des files');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "files"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'old_name',
    'new_name',
    'descriptions',
    'extensions',
    'size',
    'path',
    'web_path',
    'statut',
    'extra_attributes',
    'created_at',
    'updated_at',
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
    
    
                    'old_name' => [
            //'required'
            ],
        
    
    
                    'new_name' => [
            //'required'
            ],
        
    
    
                    'descriptions' => [
            //'required'
            ],
        
    
    
                    'extensions' => [
            //'required'
            ],
        
    
    
                    'size' => [
            //'required'
            ],
        
    
    
                    'path' => [
            //'required'
            ],
        
    
    
                    'web_path' => [
            //'required'
            ],
        
    
    
                    'statut' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'old_name' => ['cette donnee est obligatoire'],

    
    
        'new_name' => ['cette donnee est obligatoire'],

    
    
        'descriptions' => ['cette donnee est obligatoire'],

    
    
        'extensions' => ['cette donnee est obligatoire'],

    
    
        'size' => ['cette donnee est obligatoire'],

    
    
        'path' => ['cette donnee est obligatoire'],

    
    
        'web_path' => ['cette donnee est obligatoire'],

    
    
        'statut' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['old_name'])){
        
            $Files->old_name = $data['old_name'];
        
        }



    







    

        if(!empty($data['new_name'])){
        
            $Files->new_name = $data['new_name'];
        
        }



    







    

        if(!empty($data['descriptions'])){
        
            $Files->descriptions = $data['descriptions'];
        
        }



    







    

        if(!empty($data['extensions'])){
        
            $Files->extensions = $data['extensions'];
        
        }



    







    

        if(!empty($data['size'])){
        
            $Files->size = $data['size'];
        
        }



    







    

        if(!empty($data['path'])){
        
            $Files->path = $data['path'];
        
        }



    







    

        if(!empty($data['web_path'])){
        
            $Files->web_path = $data['web_path'];
        
        }



    







    

        if(!empty($data['statut'])){
        
            $Files->statut = $data['statut'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Files->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Files->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Files->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\FileExtras') &&
method_exists('\App\Http\Extras\FileExtras', 'beforeSaveCreate')
){
\App\Http\Extras\FileExtras::beforeSaveCreate($request,$Files);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\FileExtras') &&
method_exists('\App\Http\Extras\FileExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\FileExtras::canCreate($request, $Files);
}catch (\Throwable $e){

}

}


if($canSave){
$Files->save();
}else{
return response()->json($Files, 200);
}

$Files=File::find($Files->id);
$newCrudData=[];

                $newCrudData['old_name']=$Files->old_name;
                $newCrudData['new_name']=$Files->new_name;
                $newCrudData['descriptions']=$Files->descriptions;
                $newCrudData['extensions']=$Files->extensions;
                $newCrudData['size']=$Files->size;
                $newCrudData['path']=$Files->path;
                $newCrudData['web_path']=$Files->web_path;
                $newCrudData['statut']=$Files->statut;
                                $newCrudData['identifiants_sadge']=$Files->identifiants_sadge;
                $newCrudData['creat_by']=$Files->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Files','entite_cle' => $Files->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Files->toArray();




try{

foreach ($Files->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, File $Files)
{
try{
$can=\App\Helpers\Helpers::can('Editer des files');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['old_name']=$Files->old_name;
                $oldCrudData['new_name']=$Files->new_name;
                $oldCrudData['descriptions']=$Files->descriptions;
                $oldCrudData['extensions']=$Files->extensions;
                $oldCrudData['size']=$Files->size;
                $oldCrudData['path']=$Files->path;
                $oldCrudData['web_path']=$Files->web_path;
                $oldCrudData['statut']=$Files->statut;
                                $oldCrudData['identifiants_sadge']=$Files->identifiants_sadge;
                $oldCrudData['creat_by']=$Files->creat_by;
    


$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "files"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'old_name',
    'new_name',
    'descriptions',
    'extensions',
    'size',
    'path',
    'web_path',
    'statut',
    'extra_attributes',
    'created_at',
    'updated_at',
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
    
    
                    'old_name' => [
            //'required'
            ],
        
    
    
                    'new_name' => [
            //'required'
            ],
        
    
    
                    'descriptions' => [
            //'required'
            ],
        
    
    
                    'extensions' => [
            //'required'
            ],
        
    
    
                    'size' => [
            //'required'
            ],
        
    
    
                    'path' => [
            //'required'
            ],
        
    
    
                    'web_path' => [
            //'required'
            ],
        
    
    
                    'statut' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'old_name' => ['cette donnee est obligatoire'],

    
    
        'new_name' => ['cette donnee est obligatoire'],

    
    
        'descriptions' => ['cette donnee est obligatoire'],

    
    
        'extensions' => ['cette donnee est obligatoire'],

    
    
        'size' => ['cette donnee est obligatoire'],

    
    
        'path' => ['cette donnee est obligatoire'],

    
    
        'web_path' => ['cette donnee est obligatoire'],

    
    
        'statut' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("old_name",$data)){


        if(!empty($data['old_name'])){
        
            $Files->old_name = $data['old_name'];
        
        }

        }

    







    

        if(array_key_exists("new_name",$data)){


        if(!empty($data['new_name'])){
        
            $Files->new_name = $data['new_name'];
        
        }

        }

    







    

        if(array_key_exists("descriptions",$data)){


        if(!empty($data['descriptions'])){
        
            $Files->descriptions = $data['descriptions'];
        
        }

        }

    







    

        if(array_key_exists("extensions",$data)){


        if(!empty($data['extensions'])){
        
            $Files->extensions = $data['extensions'];
        
        }

        }

    







    

        if(array_key_exists("size",$data)){


        if(!empty($data['size'])){
        
            $Files->size = $data['size'];
        
        }

        }

    







    

        if(array_key_exists("path",$data)){


        if(!empty($data['path'])){
        
            $Files->path = $data['path'];
        
        }

        }

    







    

        if(array_key_exists("web_path",$data)){


        if(!empty($data['web_path'])){
        
            $Files->web_path = $data['web_path'];
        
        }

        }

    







    

        if(array_key_exists("statut",$data)){


        if(!empty($data['statut'])){
        
            $Files->statut = $data['statut'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Files->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Files->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Files->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\FileExtras') &&
method_exists('\App\Http\Extras\FileExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\FileExtras::beforeSaveUpdate($request,$Files);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\FileExtras') &&
method_exists('\App\Http\Extras\FileExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\FileExtras::canUpdate($request, $Files);
}catch (\Throwable $e){

}

}


if($canSave){
$Files->save();
}else{
return response()->json($Files, 200);

}


$Files=File::find($Files->id);



$newCrudData=[];

                $newCrudData['old_name']=$Files->old_name;
                $newCrudData['new_name']=$Files->new_name;
                $newCrudData['descriptions']=$Files->descriptions;
                $newCrudData['extensions']=$Files->extensions;
                $newCrudData['size']=$Files->size;
                $newCrudData['path']=$Files->path;
                $newCrudData['web_path']=$Files->web_path;
                $newCrudData['statut']=$Files->statut;
                                $newCrudData['identifiants_sadge']=$Files->identifiants_sadge;
                $newCrudData['creat_by']=$Files->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Files','entite_cle' => $Files->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Files->toArray();




try{

foreach ($Files->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, File $Files)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des files');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['old_name']=$Files->old_name;
                $newCrudData['new_name']=$Files->new_name;
                $newCrudData['descriptions']=$Files->descriptions;
                $newCrudData['extensions']=$Files->extensions;
                $newCrudData['size']=$Files->size;
                $newCrudData['path']=$Files->path;
                $newCrudData['web_path']=$Files->web_path;
                $newCrudData['statut']=$Files->statut;
                                $newCrudData['identifiants_sadge']=$Files->identifiants_sadge;
                $newCrudData['creat_by']=$Files->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Files','entite_cle' => $Files->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\FileExtras') &&
method_exists('\App\Http\Extras\FileExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\FileExtras::canDelete($request, $Files);
}catch (\Throwable $e){

}

}



if($canSave){
$Files->delete();
}else{
return response()->json($Files, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\FilesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
