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
// use App\Repository\prod\TypespostesRepository;
use App\Models\Typesposte;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;




class TypesposteController extends Controller
{

private $TypespostesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TypespostesRepository $TypespostesRepository
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
class_exists('\App\Http\Extras\TypesposteExtras') &&
method_exists('\App\Http\Extras\TypesposteExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TypesposteExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Typesposte::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TypesposteExtras') &&
method_exists('\App\Http\Extras\TypesposteExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TypesposteExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('typespostes',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TypesposteExtras') &&
method_exists('\App\Http\Extras\TypesposteExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TypesposteExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  typespostes reussi',
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
return response()->json(Typesposte::count());
}
$data = QueryBuilder::for(Typesposte::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('canCreate'),

    
            AllowedFilter::exact('canUpdate'),

    
            AllowedFilter::exact('canDelete'),

    
            AllowedFilter::exact('maxagent'),

    
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

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('canCreate'),

    
            AllowedSort::field('canUpdate'),

    
            AllowedSort::field('canDelete'),

    
            AllowedSort::field('maxagent'),

    
])
->allowedIncludes([
            'horairestypespostes',
        

                'imports',
        

                'postes',
        

                'userstypespostes',
        

    
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




$data = QueryBuilder::for(Typesposte::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('canCreate'),

    
            AllowedFilter::exact('canUpdate'),

    
            AllowedFilter::exact('canDelete'),

    
            AllowedFilter::exact('maxagent'),

    
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

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('canCreate'),

    
            AllowedSort::field('canUpdate'),

    
            AllowedSort::field('canDelete'),

    
            AllowedSort::field('maxagent'),

    
])
->allowedIncludes([
            'horairestypespostes',
        

                'imports',
        

                'postes',
        

                'userstypespostes',
        

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



public function create(Request $request, Typesposte $Typespostes)
{


try{
$can=\App\Helpers\Helpers::can('Creer des typespostes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "typespostes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'libelle',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'identifiants_sadge',
    'canCreate',
    'canUpdate',
    'canDelete',
    'maxagent',
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
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
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
        
    
    
                    'maxagent' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'canCreate' => ['cette donnee est obligatoire'],

    
    
        'canUpdate' => ['cette donnee est obligatoire'],

    
    
        'canDelete' => ['cette donnee est obligatoire'],

    
    
        'maxagent' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['code'])){
        
            $Typespostes->code = $data['code'];
        
        }



    







    

        if(!empty($data['libelle'])){
        
            $Typespostes->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Typespostes->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Typespostes->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['canCreate'])){
        
            $Typespostes->canCreate = $data['canCreate'];
        
        }



    







    

        if(!empty($data['canUpdate'])){
        
            $Typespostes->canUpdate = $data['canUpdate'];
        
        }



    







    

        if(!empty($data['canDelete'])){
        
            $Typespostes->canDelete = $data['canDelete'];
        
        }



    







    

        if(!empty($data['maxagent'])){
        
            $Typespostes->maxagent = $data['maxagent'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Typespostes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TypesposteExtras') &&
method_exists('\App\Http\Extras\TypesposteExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TypesposteExtras::beforeSaveCreate($request,$Typespostes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TypesposteExtras') &&
method_exists('\App\Http\Extras\TypesposteExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TypesposteExtras::canCreate($request, $Typespostes);
}catch (\Throwable $e){

}

}


if($canSave){
$Typespostes->save();
}else{
return response()->json($Typespostes, 200);
}

$Typespostes=Typesposte::find($Typespostes->id);
$newCrudData=[];

                $newCrudData['code']=$Typespostes->code;
                $newCrudData['libelle']=$Typespostes->libelle;
                $newCrudData['creat_by']=$Typespostes->creat_by;
                                $newCrudData['identifiants_sadge']=$Typespostes->identifiants_sadge;
                $newCrudData['canCreate']=$Typespostes->canCreate;
                $newCrudData['canUpdate']=$Typespostes->canUpdate;
                $newCrudData['canDelete']=$Typespostes->canDelete;
                $newCrudData['maxagent']=$Typespostes->maxagent;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Typespostes','entite_cle' => $Typespostes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Typespostes->toArray();




try{

foreach ($Typespostes->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Typesposte $Typespostes)
{
try{
$can=\App\Helpers\Helpers::can('Editer des typespostes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['code']=$Typespostes->code;
                $oldCrudData['libelle']=$Typespostes->libelle;
                $oldCrudData['creat_by']=$Typespostes->creat_by;
                                $oldCrudData['identifiants_sadge']=$Typespostes->identifiants_sadge;
                $oldCrudData['canCreate']=$Typespostes->canCreate;
                $oldCrudData['canUpdate']=$Typespostes->canUpdate;
                $oldCrudData['canDelete']=$Typespostes->canDelete;
                $oldCrudData['maxagent']=$Typespostes->maxagent;
    


$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "typespostes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'libelle',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'identifiants_sadge',
    'canCreate',
    'canUpdate',
    'canDelete',
    'maxagent',
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
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
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
        
    
    
                    'maxagent' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'canCreate' => ['cette donnee est obligatoire'],

    
    
        'canUpdate' => ['cette donnee est obligatoire'],

    
    
        'canDelete' => ['cette donnee est obligatoire'],

    
    
        'maxagent' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("code",$data)){


        if(!empty($data['code'])){
        
            $Typespostes->code = $data['code'];
        
        }

        }

    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Typespostes->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Typespostes->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Typespostes->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("canCreate",$data)){


        if(!empty($data['canCreate'])){
        
            $Typespostes->canCreate = $data['canCreate'];
        
        }

        }

    







    

        if(array_key_exists("canUpdate",$data)){


        if(!empty($data['canUpdate'])){
        
            $Typespostes->canUpdate = $data['canUpdate'];
        
        }

        }

    







    

        if(array_key_exists("canDelete",$data)){


        if(!empty($data['canDelete'])){
        
            $Typespostes->canDelete = $data['canDelete'];
        
        }

        }

    







    

        if(array_key_exists("maxagent",$data)){


        if(!empty($data['maxagent'])){
        
            $Typespostes->maxagent = $data['maxagent'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Typespostes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TypesposteExtras') &&
method_exists('\App\Http\Extras\TypesposteExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TypesposteExtras::beforeSaveUpdate($request,$Typespostes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TypesposteExtras') &&
method_exists('\App\Http\Extras\TypesposteExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TypesposteExtras::canUpdate($request, $Typespostes);
}catch (\Throwable $e){

}

}


if($canSave){
$Typespostes->save();
}else{
return response()->json($Typespostes, 200);

}


$Typespostes=Typesposte::find($Typespostes->id);



$newCrudData=[];

                $newCrudData['code']=$Typespostes->code;
                $newCrudData['libelle']=$Typespostes->libelle;
                $newCrudData['creat_by']=$Typespostes->creat_by;
                                $newCrudData['identifiants_sadge']=$Typespostes->identifiants_sadge;
                $newCrudData['canCreate']=$Typespostes->canCreate;
                $newCrudData['canUpdate']=$Typespostes->canUpdate;
                $newCrudData['canDelete']=$Typespostes->canDelete;
                $newCrudData['maxagent']=$Typespostes->maxagent;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Typespostes','entite_cle' => $Typespostes->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Typespostes->toArray();




try{

foreach ($Typespostes->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Typesposte $Typespostes)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des typespostes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['code']=$Typespostes->code;
                $newCrudData['libelle']=$Typespostes->libelle;
                $newCrudData['creat_by']=$Typespostes->creat_by;
                                $newCrudData['identifiants_sadge']=$Typespostes->identifiants_sadge;
                $newCrudData['canCreate']=$Typespostes->canCreate;
                $newCrudData['canUpdate']=$Typespostes->canUpdate;
                $newCrudData['canDelete']=$Typespostes->canDelete;
                $newCrudData['maxagent']=$Typespostes->maxagent;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Typespostes','entite_cle' => $Typespostes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TypesposteExtras') &&
method_exists('\App\Http\Extras\TypesposteExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TypesposteExtras::canDelete($request, $Typespostes);
}catch (\Throwable $e){

}

}



if($canSave){
$Typespostes->delete();
}else{
return response()->json($Typespostes, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TypespostesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
