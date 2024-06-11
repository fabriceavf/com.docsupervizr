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
// use App\Repository\prod\PreuvesRepository;
use App\Models\Preuve;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Programme;
                use App\Models\Transaction;
    
class PreuveController extends Controller
{

private $PreuvesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\PreuvesRepository $PreuvesRepository
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
class_exists('\App\Http\Extras\PreuveExtras') &&
method_exists('\App\Http\Extras\PreuveExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\PreuveExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Preuve::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\PreuveExtras') &&
method_exists('\App\Http\Extras\PreuveExtras', 'filterAgGridQuery')
){
\App\Http\Extras\PreuveExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('preuves',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\PreuveExtras') &&
method_exists('\App\Http\Extras\PreuveExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\PreuveExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  preuves reussi',
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
return response()->json(Preuve::count());
}
$data = QueryBuilder::for(Preuve::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('programme_id'),

    
            AllowedFilter::exact('transaction_id'),

    
            AllowedFilter::exact('punch_time'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('role'),

    
            AllowedFilter::exact('etats'),

    
    
    
    
            AllowedFilter::exact('valide'),

    
            AllowedFilter::exact('remarque'),

    
    
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

    
            AllowedSort::field('programme_id'),

    
            AllowedSort::field('transaction_id'),

    
            AllowedSort::field('punch_time'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('role'),

    
            AllowedSort::field('etats'),

    
    
    
    
            AllowedSort::field('valide'),

    
            AllowedSort::field('remarque'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([

            'programme',
        

                'transaction',
        

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




$data = QueryBuilder::for(Preuve::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('programme_id'),

    
            AllowedFilter::exact('transaction_id'),

    
            AllowedFilter::exact('punch_time'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('role'),

    
            AllowedFilter::exact('etats'),

    
    
    
    
            AllowedFilter::exact('valide'),

    
            AllowedFilter::exact('remarque'),

    
    
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

    
            AllowedSort::field('programme_id'),

    
            AllowedSort::field('transaction_id'),

    
            AllowedSort::field('punch_time'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('role'),

    
            AllowedSort::field('etats'),

    
    
    
    
            AllowedSort::field('valide'),

    
            AllowedSort::field('remarque'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'programme',
        

                'transaction',
        

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



public function create(Request $request, Preuve $Preuves)
{


try{
$can=\App\Helpers\Helpers::can('Creer des preuves');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "preuves"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'programme_id',
    'transaction_id',
    'punch_time',
    'type',
    'role',
    'etats',
    'extra_attributes',
    'created_at',
    'updated_at',
    'valide',
    'remarque',
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
    
    
                    'programme_id' => [
            //'required'
            ],
        
    
    
                    'transaction_id' => [
            //'required'
            ],
        
    
    
                    'punch_time' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'role' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
    
    
    
                    'valide' => [
            //'required'
            ],
        
    
    
                    'remarque' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'programme_id' => ['cette donnee est obligatoire'],

    
    
        'transaction_id' => ['cette donnee est obligatoire'],

    
    
        'punch_time' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'role' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'valide' => ['cette donnee est obligatoire'],

    
    
        'remarque' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['programme_id'])){
        
            $Preuves->programme_id = $data['programme_id'];
        
        }



    







    

        if(!empty($data['transaction_id'])){
        
            $Preuves->transaction_id = $data['transaction_id'];
        
        }



    







    

        if(!empty($data['punch_time'])){
        
            $Preuves->punch_time = $data['punch_time'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Preuves->type = $data['type'];
        
        }



    







    

        if(!empty($data['role'])){
        
            $Preuves->role = $data['role'];
        
        }



    







    

        if(!empty($data['etats'])){
        
            $Preuves->etats = $data['etats'];
        
        }



    







    







    







    







    

        if(!empty($data['valide'])){
        
            $Preuves->valide = $data['valide'];
        
        }



    







    

        if(!empty($data['remarque'])){
        
            $Preuves->remarque = $data['remarque'];
        
        }



    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Preuves->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Preuves->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Preuves->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\PreuveExtras') &&
method_exists('\App\Http\Extras\PreuveExtras', 'beforeSaveCreate')
){
\App\Http\Extras\PreuveExtras::beforeSaveCreate($request,$Preuves);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PreuveExtras') &&
method_exists('\App\Http\Extras\PreuveExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\PreuveExtras::canCreate($request, $Preuves);
}catch (\Throwable $e){

}

}


if($canSave){
$Preuves->save();
}else{
return response()->json($Preuves, 200);
}

$Preuves=Preuve::find($Preuves->id);
$newCrudData=[];

                $newCrudData['programme_id']=$Preuves->programme_id;
                $newCrudData['transaction_id']=$Preuves->transaction_id;
                $newCrudData['punch_time']=$Preuves->punch_time;
                $newCrudData['type']=$Preuves->type;
                $newCrudData['role']=$Preuves->role;
                $newCrudData['etats']=$Preuves->etats;
                            $newCrudData['valide']=$Preuves->valide;
                $newCrudData['remarque']=$Preuves->remarque;
                    $newCrudData['identifiants_sadge']=$Preuves->identifiants_sadge;
                $newCrudData['creat_by']=$Preuves->creat_by;
    
 try{ $newCrudData['programme']=$Preuves->programme->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['transaction']=$Preuves->transaction->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Preuves','entite_cle' => $Preuves->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Preuves->toArray();




try{

foreach ($Preuves->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Preuve $Preuves)
{
try{
$can=\App\Helpers\Helpers::can('Editer des preuves');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['programme_id']=$Preuves->programme_id;
                $oldCrudData['transaction_id']=$Preuves->transaction_id;
                $oldCrudData['punch_time']=$Preuves->punch_time;
                $oldCrudData['type']=$Preuves->type;
                $oldCrudData['role']=$Preuves->role;
                $oldCrudData['etats']=$Preuves->etats;
                            $oldCrudData['valide']=$Preuves->valide;
                $oldCrudData['remarque']=$Preuves->remarque;
                    $oldCrudData['identifiants_sadge']=$Preuves->identifiants_sadge;
                $oldCrudData['creat_by']=$Preuves->creat_by;
    
 try{ $oldCrudData['programme']=$Preuves->programme->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['transaction']=$Preuves->transaction->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "preuves"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'programme_id',
    'transaction_id',
    'punch_time',
    'type',
    'role',
    'etats',
    'extra_attributes',
    'created_at',
    'updated_at',
    'valide',
    'remarque',
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
    
    
                    'programme_id' => [
            //'required'
            ],
        
    
    
                    'transaction_id' => [
            //'required'
            ],
        
    
    
                    'punch_time' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'role' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
    
    
    
                    'valide' => [
            //'required'
            ],
        
    
    
                    'remarque' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'programme_id' => ['cette donnee est obligatoire'],

    
    
        'transaction_id' => ['cette donnee est obligatoire'],

    
    
        'punch_time' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'role' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'valide' => ['cette donnee est obligatoire'],

    
    
        'remarque' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("programme_id",$data)){


        if(!empty($data['programme_id'])){
        
            $Preuves->programme_id = $data['programme_id'];
        
        }

        }

    







    

        if(array_key_exists("transaction_id",$data)){


        if(!empty($data['transaction_id'])){
        
            $Preuves->transaction_id = $data['transaction_id'];
        
        }

        }

    







    

        if(array_key_exists("punch_time",$data)){


        if(!empty($data['punch_time'])){
        
            $Preuves->punch_time = $data['punch_time'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Preuves->type = $data['type'];
        
        }

        }

    







    

        if(array_key_exists("role",$data)){


        if(!empty($data['role'])){
        
            $Preuves->role = $data['role'];
        
        }

        }

    







    

        if(array_key_exists("etats",$data)){


        if(!empty($data['etats'])){
        
            $Preuves->etats = $data['etats'];
        
        }

        }

    







    







    







    







    

        if(array_key_exists("valide",$data)){


        if(!empty($data['valide'])){
        
            $Preuves->valide = $data['valide'];
        
        }

        }

    







    

        if(array_key_exists("remarque",$data)){


        if(!empty($data['remarque'])){
        
            $Preuves->remarque = $data['remarque'];
        
        }

        }

    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Preuves->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Preuves->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Preuves->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\PreuveExtras') &&
method_exists('\App\Http\Extras\PreuveExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\PreuveExtras::beforeSaveUpdate($request,$Preuves);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PreuveExtras') &&
method_exists('\App\Http\Extras\PreuveExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\PreuveExtras::canUpdate($request, $Preuves);
}catch (\Throwable $e){

}

}


if($canSave){
$Preuves->save();
}else{
return response()->json($Preuves, 200);

}


$Preuves=Preuve::find($Preuves->id);



$newCrudData=[];

                $newCrudData['programme_id']=$Preuves->programme_id;
                $newCrudData['transaction_id']=$Preuves->transaction_id;
                $newCrudData['punch_time']=$Preuves->punch_time;
                $newCrudData['type']=$Preuves->type;
                $newCrudData['role']=$Preuves->role;
                $newCrudData['etats']=$Preuves->etats;
                            $newCrudData['valide']=$Preuves->valide;
                $newCrudData['remarque']=$Preuves->remarque;
                    $newCrudData['identifiants_sadge']=$Preuves->identifiants_sadge;
                $newCrudData['creat_by']=$Preuves->creat_by;
    
 try{ $newCrudData['programme']=$Preuves->programme->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['transaction']=$Preuves->transaction->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Preuves','entite_cle' => $Preuves->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Preuves->toArray();




try{

foreach ($Preuves->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Preuve $Preuves)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des preuves');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['programme_id']=$Preuves->programme_id;
                $newCrudData['transaction_id']=$Preuves->transaction_id;
                $newCrudData['punch_time']=$Preuves->punch_time;
                $newCrudData['type']=$Preuves->type;
                $newCrudData['role']=$Preuves->role;
                $newCrudData['etats']=$Preuves->etats;
                            $newCrudData['valide']=$Preuves->valide;
                $newCrudData['remarque']=$Preuves->remarque;
                    $newCrudData['identifiants_sadge']=$Preuves->identifiants_sadge;
                $newCrudData['creat_by']=$Preuves->creat_by;
    
 try{ $newCrudData['programme']=$Preuves->programme->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['transaction']=$Preuves->transaction->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Preuves','entite_cle' => $Preuves->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\PreuveExtras') &&
method_exists('\App\Http\Extras\PreuveExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\PreuveExtras::canDelete($request, $Preuves);
}catch (\Throwable $e){

}

}



if($canSave){
$Preuves->delete();
}else{
return response()->json($Preuves, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\PreuvesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
