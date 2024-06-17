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
// use App\Repository\prod\ImportsRepository;
use App\Models\Import;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Typeseffectif;
                use App\Models\Typespointage;
                use App\Models\Typesposte;
    
class ImportController extends Controller
{

private $ImportsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ImportsRepository $ImportsRepository
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
class_exists('\App\Http\Extras\ImportExtras') &&
method_exists('\App\Http\Extras\ImportExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ImportExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Import::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ImportExtras') &&
method_exists('\App\Http\Extras\ImportExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ImportExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('imports',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ImportExtras') &&
method_exists('\App\Http\Extras\ImportExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ImportExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  imports reussi',
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
return response()->json(Import::count());
}
$data = QueryBuilder::for(Import::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('liaisons'),

    
            AllowedFilter::exact('identifiant'),

    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('file'),

    
            AllowedFilter::exact('create'),

    
            AllowedFilter::exact('update'),

    
            AllowedFilter::exact('delete'),

    
            AllowedFilter::exact('valider'),

    
            AllowedFilter::exact('description'),

    
            AllowedFilter::exact('typesposte_id'),

    
            AllowedFilter::exact('typeseffectif_id'),

    
            AllowedFilter::exact('typespointage_id'),

    
            AllowedFilter::exact('typespointages'),

    
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

    
            AllowedSort::field('type'),

    
            AllowedSort::field('liaisons'),

    
            AllowedSort::field('identifiant'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('file'),

    
            AllowedSort::field('create'),

    
            AllowedSort::field('update'),

    
            AllowedSort::field('delete'),

    
            AllowedSort::field('valider'),

    
            AllowedSort::field('description'),

    
            AllowedSort::field('typesposte_id'),

    
            AllowedSort::field('typeseffectif_id'),

    
            AllowedSort::field('typespointage_id'),

    
            AllowedSort::field('typespointages'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
    
->allowedIncludes([

            'typeseffectif',
        

                'typespointage',
        

                'typesposte',
        

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




$data = QueryBuilder::for(Import::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('liaisons'),

    
            AllowedFilter::exact('identifiant'),

    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('file'),

    
            AllowedFilter::exact('create'),

    
            AllowedFilter::exact('update'),

    
            AllowedFilter::exact('delete'),

    
            AllowedFilter::exact('valider'),

    
            AllowedFilter::exact('description'),

    
            AllowedFilter::exact('typesposte_id'),

    
            AllowedFilter::exact('typeseffectif_id'),

    
            AllowedFilter::exact('typespointage_id'),

    
            AllowedFilter::exact('typespointages'),

    
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

    
            AllowedSort::field('type'),

    
            AllowedSort::field('liaisons'),

    
            AllowedSort::field('identifiant'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('file'),

    
            AllowedSort::field('create'),

    
            AllowedSort::field('update'),

    
            AllowedSort::field('delete'),

    
            AllowedSort::field('valider'),

    
            AllowedSort::field('description'),

    
            AllowedSort::field('typesposte_id'),

    
            AllowedSort::field('typeseffectif_id'),

    
            AllowedSort::field('typespointage_id'),

    
            AllowedSort::field('typespointages'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
    
->allowedIncludes([
            'typeseffectif',
        

                'typespointage',
        

                'typesposte',
        

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



public function create(Request $request, Import $Imports)
{


try{
$can=\App\Helpers\Helpers::can('Creer des imports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "imports"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'type',
    'liaisons',
    'identifiant',
    'etats',
    'creat_by',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'file',
    'create',
    'update',
    'delete',
    'valider',
    'description',
    'typesposte_id',
    'typeseffectif_id',
    'typespointage_id',
    'typespointages',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'liaisons' => [
            //'required'
            ],
        
    
    
                    'identifiant' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'file' => [
            //'required'
            ],
        
    
    
                    'create' => [
            //'required'
            ],
        
    
    
                    'update' => [
            //'required'
            ],
        
    
    
                    'delete' => [
            //'required'
            ],
        
    
    
                    'valider' => [
            //'required'
            ],
        
    
    
                    'description' => [
            //'required'
            ],
        
    
    
                    'typesposte_id' => [
            //'required'
            ],
        
    
    
                    'typeseffectif_id' => [
            //'required'
            ],
        
    
    
                    'typespointage_id' => [
            //'required'
            ],
        
    
    
                    'typespointages' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'liaisons' => ['cette donnee est obligatoire'],

    
    
        'identifiant' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'file' => ['cette donnee est obligatoire'],

    
    
        'create' => ['cette donnee est obligatoire'],

    
    
        'update' => ['cette donnee est obligatoire'],

    
    
        'delete' => ['cette donnee est obligatoire'],

    
    
        'valider' => ['cette donnee est obligatoire'],

    
    
        'description' => ['cette donnee est obligatoire'],

    
    
        'typesposte_id' => ['cette donnee est obligatoire'],

    
    
        'typeseffectif_id' => ['cette donnee est obligatoire'],

    
    
        'typespointage_id' => ['cette donnee est obligatoire'],

    
    
        'typespointages' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['type'])){
        
            $Imports->type = $data['type'];
        
        }



    







    

        if(!empty($data['liaisons'])){
        
            $Imports->liaisons = $data['liaisons'];
        
        }



    







    

        if(!empty($data['identifiant'])){
        
            $Imports->identifiant = $data['identifiant'];
        
        }



    







    

        if(!empty($data['etats'])){
        
            $Imports->etats = $data['etats'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Imports->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['file'])){
        
            $Imports->file = $data['file'];
        
        }



    







    

        if(!empty($data['create'])){
        
            $Imports->create = $data['create'];
        
        }



    







    

        if(!empty($data['update'])){
        
            $Imports->update = $data['update'];
        
        }



    







    

        if(!empty($data['delete'])){
        
            $Imports->delete = $data['delete'];
        
        }



    







    

        if(!empty($data['valider'])){
        
            $Imports->valider = $data['valider'];
        
        }



    







    

        if(!empty($data['description'])){
        
            $Imports->description = $data['description'];
        
        }



    







    

        if(!empty($data['typesposte_id'])){
        
            $Imports->typesposte_id = $data['typesposte_id'];
        
        }



    







    

        if(!empty($data['typeseffectif_id'])){
        
            $Imports->typeseffectif_id = $data['typeseffectif_id'];
        
        }



    







    

        if(!empty($data['typespointage_id'])){
        
            $Imports->typespointage_id = $data['typespointage_id'];
        
        }



    







    

        if(!empty($data['typespointages'])){
        
            $Imports->typespointages = $data['typespointages'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Imports->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Imports->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ImportExtras') &&
method_exists('\App\Http\Extras\ImportExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ImportExtras::beforeSaveCreate($request,$Imports);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ImportExtras') &&
method_exists('\App\Http\Extras\ImportExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ImportExtras::canCreate($request, $Imports);
}catch (\Throwable $e){

}

}


if($canSave){
$Imports->save();
}else{
return response()->json($Imports, 200);
}

$Imports=Import::find($Imports->id);
$newCrudData=[];

                $newCrudData['type']=$Imports->type;
                $newCrudData['liaisons']=$Imports->liaisons;
                $newCrudData['identifiant']=$Imports->identifiant;
                $newCrudData['etats']=$Imports->etats;
                $newCrudData['creat_by']=$Imports->creat_by;
                                $newCrudData['file']=$Imports->file;
                $newCrudData['create']=$Imports->create;
                $newCrudData['update']=$Imports->update;
                $newCrudData['delete']=$Imports->delete;
                $newCrudData['valider']=$Imports->valider;
                $newCrudData['description']=$Imports->description;
                $newCrudData['typesposte_id']=$Imports->typesposte_id;
                $newCrudData['typeseffectif_id']=$Imports->typeseffectif_id;
                $newCrudData['typespointage_id']=$Imports->typespointage_id;
                $newCrudData['typespointages']=$Imports->typespointages;
                $newCrudData['identifiants_sadge']=$Imports->identifiants_sadge;
    
 try{ $newCrudData['typeseffectif']=$Imports->typeseffectif->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typespointage']=$Imports->typespointage->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typesposte']=$Imports->typesposte->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Imports','entite_cle' => $Imports->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Imports->toArray();




try{

foreach ($Imports->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Import $Imports)
{
try{
$can=\App\Helpers\Helpers::can('Editer des imports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['type']=$Imports->type;
                $oldCrudData['liaisons']=$Imports->liaisons;
                $oldCrudData['identifiant']=$Imports->identifiant;
                $oldCrudData['etats']=$Imports->etats;
                $oldCrudData['creat_by']=$Imports->creat_by;
                                $oldCrudData['file']=$Imports->file;
                $oldCrudData['create']=$Imports->create;
                $oldCrudData['update']=$Imports->update;
                $oldCrudData['delete']=$Imports->delete;
                $oldCrudData['valider']=$Imports->valider;
                $oldCrudData['description']=$Imports->description;
                $oldCrudData['typesposte_id']=$Imports->typesposte_id;
                $oldCrudData['typeseffectif_id']=$Imports->typeseffectif_id;
                $oldCrudData['typespointage_id']=$Imports->typespointage_id;
                $oldCrudData['typespointages']=$Imports->typespointages;
                $oldCrudData['identifiants_sadge']=$Imports->identifiants_sadge;
    
 try{ $oldCrudData['typeseffectif']=$Imports->typeseffectif->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['typespointage']=$Imports->typespointage->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['typesposte']=$Imports->typesposte->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "imports"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'type',
    'liaisons',
    'identifiant',
    'etats',
    'creat_by',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'file',
    'create',
    'update',
    'delete',
    'valider',
    'description',
    'typesposte_id',
    'typeseffectif_id',
    'typespointage_id',
    'typespointages',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'liaisons' => [
            //'required'
            ],
        
    
    
                    'identifiant' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'file' => [
            //'required'
            ],
        
    
    
                    'create' => [
            //'required'
            ],
        
    
    
                    'update' => [
            //'required'
            ],
        
    
    
                    'delete' => [
            //'required'
            ],
        
    
    
                    'valider' => [
            //'required'
            ],
        
    
    
                    'description' => [
            //'required'
            ],
        
    
    
                    'typesposte_id' => [
            //'required'
            ],
        
    
    
                    'typeseffectif_id' => [
            //'required'
            ],
        
    
    
                    'typespointage_id' => [
            //'required'
            ],
        
    
    
                    'typespointages' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'liaisons' => ['cette donnee est obligatoire'],

    
    
        'identifiant' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'file' => ['cette donnee est obligatoire'],

    
    
        'create' => ['cette donnee est obligatoire'],

    
    
        'update' => ['cette donnee est obligatoire'],

    
    
        'delete' => ['cette donnee est obligatoire'],

    
    
        'valider' => ['cette donnee est obligatoire'],

    
    
        'description' => ['cette donnee est obligatoire'],

    
    
        'typesposte_id' => ['cette donnee est obligatoire'],

    
    
        'typeseffectif_id' => ['cette donnee est obligatoire'],

    
    
        'typespointage_id' => ['cette donnee est obligatoire'],

    
    
        'typespointages' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Imports->type = $data['type'];
        
        }

        }

    







    

        if(array_key_exists("liaisons",$data)){


        if(!empty($data['liaisons'])){
        
            $Imports->liaisons = $data['liaisons'];
        
        }

        }

    







    

        if(array_key_exists("identifiant",$data)){


        if(!empty($data['identifiant'])){
        
            $Imports->identifiant = $data['identifiant'];
        
        }

        }

    







    

        if(array_key_exists("etats",$data)){


        if(!empty($data['etats'])){
        
            $Imports->etats = $data['etats'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Imports->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("file",$data)){


        if(!empty($data['file'])){
        
            $Imports->file = $data['file'];
        
        }

        }

    







    

        if(array_key_exists("create",$data)){


        if(!empty($data['create'])){
        
            $Imports->create = $data['create'];
        
        }

        }

    







    

        if(array_key_exists("update",$data)){


        if(!empty($data['update'])){
        
            $Imports->update = $data['update'];
        
        }

        }

    







    

        if(array_key_exists("delete",$data)){


        if(!empty($data['delete'])){
        
            $Imports->delete = $data['delete'];
        
        }

        }

    







    

        if(array_key_exists("valider",$data)){


        if(!empty($data['valider'])){
        
            $Imports->valider = $data['valider'];
        
        }

        }

    







    

        if(array_key_exists("description",$data)){


        if(!empty($data['description'])){
        
            $Imports->description = $data['description'];
        
        }

        }

    







    

        if(array_key_exists("typesposte_id",$data)){


        if(!empty($data['typesposte_id'])){
        
            $Imports->typesposte_id = $data['typesposte_id'];
        
        }

        }

    







    

        if(array_key_exists("typeseffectif_id",$data)){


        if(!empty($data['typeseffectif_id'])){
        
            $Imports->typeseffectif_id = $data['typeseffectif_id'];
        
        }

        }

    







    

        if(array_key_exists("typespointage_id",$data)){


        if(!empty($data['typespointage_id'])){
        
            $Imports->typespointage_id = $data['typespointage_id'];
        
        }

        }

    







    

        if(array_key_exists("typespointages",$data)){


        if(!empty($data['typespointages'])){
        
            $Imports->typespointages = $data['typespointages'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Imports->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Imports->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ImportExtras') &&
method_exists('\App\Http\Extras\ImportExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ImportExtras::beforeSaveUpdate($request,$Imports);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ImportExtras') &&
method_exists('\App\Http\Extras\ImportExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ImportExtras::canUpdate($request, $Imports);
}catch (\Throwable $e){

}

}


if($canSave){
$Imports->save();
}else{
return response()->json($Imports, 200);

}


$Imports=Import::find($Imports->id);



$newCrudData=[];

                $newCrudData['type']=$Imports->type;
                $newCrudData['liaisons']=$Imports->liaisons;
                $newCrudData['identifiant']=$Imports->identifiant;
                $newCrudData['etats']=$Imports->etats;
                $newCrudData['creat_by']=$Imports->creat_by;
                                $newCrudData['file']=$Imports->file;
                $newCrudData['create']=$Imports->create;
                $newCrudData['update']=$Imports->update;
                $newCrudData['delete']=$Imports->delete;
                $newCrudData['valider']=$Imports->valider;
                $newCrudData['description']=$Imports->description;
                $newCrudData['typesposte_id']=$Imports->typesposte_id;
                $newCrudData['typeseffectif_id']=$Imports->typeseffectif_id;
                $newCrudData['typespointage_id']=$Imports->typespointage_id;
                $newCrudData['typespointages']=$Imports->typespointages;
                $newCrudData['identifiants_sadge']=$Imports->identifiants_sadge;
    
 try{ $newCrudData['typeseffectif']=$Imports->typeseffectif->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typespointage']=$Imports->typespointage->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typesposte']=$Imports->typesposte->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Imports','entite_cle' => $Imports->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Imports->toArray();




try{

foreach ($Imports->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Import $Imports)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des imports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['type']=$Imports->type;
                $newCrudData['liaisons']=$Imports->liaisons;
                $newCrudData['identifiant']=$Imports->identifiant;
                $newCrudData['etats']=$Imports->etats;
                $newCrudData['creat_by']=$Imports->creat_by;
                                $newCrudData['file']=$Imports->file;
                $newCrudData['create']=$Imports->create;
                $newCrudData['update']=$Imports->update;
                $newCrudData['delete']=$Imports->delete;
                $newCrudData['valider']=$Imports->valider;
                $newCrudData['description']=$Imports->description;
                $newCrudData['typesposte_id']=$Imports->typesposte_id;
                $newCrudData['typeseffectif_id']=$Imports->typeseffectif_id;
                $newCrudData['typespointage_id']=$Imports->typespointage_id;
                $newCrudData['typespointages']=$Imports->typespointages;
                $newCrudData['identifiants_sadge']=$Imports->identifiants_sadge;
    
 try{ $newCrudData['typeseffectif']=$Imports->typeseffectif->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typespointage']=$Imports->typespointage->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typesposte']=$Imports->typesposte->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Imports','entite_cle' => $Imports->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ImportExtras') &&
method_exists('\App\Http\Extras\ImportExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ImportExtras::canDelete($request, $Imports);
}catch (\Throwable $e){

}

}



if($canSave){
$Imports->delete();
}else{
return response()->json($Imports, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ImportsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
