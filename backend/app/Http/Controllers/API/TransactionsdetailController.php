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
// use App\Repository\prod\TransactionsdetailsRepository;
use App\Models\Transactionsdetail;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Transaction;
    
class TransactionsdetailController extends Controller
{

private $TransactionsdetailsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TransactionsdetailsRepository $TransactionsdetailsRepository
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
class_exists('\App\Http\Extras\TransactionsdetailExtras') &&
method_exists('\App\Http\Extras\TransactionsdetailExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TransactionsdetailExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Transactionsdetail::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TransactionsdetailExtras') &&
method_exists('\App\Http\Extras\TransactionsdetailExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TransactionsdetailExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('transactionsdetails',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TransactionsdetailExtras') &&
method_exists('\App\Http\Extras\TransactionsdetailExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TransactionsdetailExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  transactionsdetails reussi',
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
return response()->json(Transactionsdetail::count());
}
$data = QueryBuilder::for(Transactionsdetail::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('parent'),

    
            AllowedFilter::exact('parentId'),

    
            AllowedFilter::exact('transaction_id'),

    
    
    
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

    
            AllowedSort::field('parent'),

    
            AllowedSort::field('parentId'),

    
            AllowedSort::field('transaction_id'),

    
    
    
            AllowedSort::field('creat_by'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([

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




$data = QueryBuilder::for(Transactionsdetail::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('parent'),

    
            AllowedFilter::exact('parentId'),

    
            AllowedFilter::exact('transaction_id'),

    
    
    
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

    
            AllowedSort::field('parent'),

    
            AllowedSort::field('parentId'),

    
            AllowedSort::field('transaction_id'),

    
    
    
            AllowedSort::field('creat_by'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([
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



public function create(Request $request, Transactionsdetail $Transactionsdetails)
{


try{
$can=\App\Helpers\Helpers::can('Creer des transactionsdetails');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "transactionsdetails"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'parent',
    'parentId',
    'transaction_id',
    'created_at',
    'updated_at',
    'creat_by',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'parent' => [
            //'required'
            ],
        
    
    
                    'parentId' => [
            //'required'
            ],
        
    
    
                    'transaction_id' => [
            //'required'
            ],
        
    
    
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'parent' => ['cette donnee est obligatoire'],

    
    
        'parentId' => ['cette donnee est obligatoire'],

    
    
        'transaction_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['parent'])){
        
            $Transactionsdetails->parent = $data['parent'];
        
        }



    







    

        if(!empty($data['parentId'])){
        
            $Transactionsdetails->parentId = $data['parentId'];
        
        }



    







    

        if(!empty($data['transaction_id'])){
        
            $Transactionsdetails->transaction_id = $data['transaction_id'];
        
        }



    







    







    







    

        if(!empty($data['creat_by'])){
        
            $Transactionsdetails->creat_by = $data['creat_by'];
        
        }



    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Transactionsdetails->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Transactionsdetails->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TransactionsdetailExtras') &&
method_exists('\App\Http\Extras\TransactionsdetailExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TransactionsdetailExtras::beforeSaveCreate($request,$Transactionsdetails);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TransactionsdetailExtras') &&
method_exists('\App\Http\Extras\TransactionsdetailExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TransactionsdetailExtras::canCreate($request, $Transactionsdetails);
}catch (\Throwable $e){

}

}


if($canSave){
$Transactionsdetails->save();
}else{
return response()->json($Transactionsdetails, 200);
}

$Transactionsdetails=Transactionsdetail::find($Transactionsdetails->id);
$newCrudData=[];

                $newCrudData['parent']=$Transactionsdetails->parent;
                $newCrudData['parentId']=$Transactionsdetails->parentId;
                $newCrudData['transaction_id']=$Transactionsdetails->transaction_id;
                        $newCrudData['creat_by']=$Transactionsdetails->creat_by;
                        $newCrudData['identifiants_sadge']=$Transactionsdetails->identifiants_sadge;
    
 try{ $newCrudData['transaction']=$Transactionsdetails->transaction->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Transactionsdetails','entite_cle' => $Transactionsdetails->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Transactionsdetails->toArray();




try{

foreach ($Transactionsdetails->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Transactionsdetail $Transactionsdetails)
{
try{
$can=\App\Helpers\Helpers::can('Editer des transactionsdetails');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['parent']=$Transactionsdetails->parent;
                $oldCrudData['parentId']=$Transactionsdetails->parentId;
                $oldCrudData['transaction_id']=$Transactionsdetails->transaction_id;
                        $oldCrudData['creat_by']=$Transactionsdetails->creat_by;
                        $oldCrudData['identifiants_sadge']=$Transactionsdetails->identifiants_sadge;
    
 try{ $oldCrudData['transaction']=$Transactionsdetails->transaction->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "transactionsdetails"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'parent',
    'parentId',
    'transaction_id',
    'created_at',
    'updated_at',
    'creat_by',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'parent' => [
            //'required'
            ],
        
    
    
                    'parentId' => [
            //'required'
            ],
        
    
    
                    'transaction_id' => [
            //'required'
            ],
        
    
    
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'parent' => ['cette donnee est obligatoire'],

    
    
        'parentId' => ['cette donnee est obligatoire'],

    
    
        'transaction_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("parent",$data)){


        if(!empty($data['parent'])){
        
            $Transactionsdetails->parent = $data['parent'];
        
        }

        }

    







    

        if(array_key_exists("parentId",$data)){


        if(!empty($data['parentId'])){
        
            $Transactionsdetails->parentId = $data['parentId'];
        
        }

        }

    







    

        if(array_key_exists("transaction_id",$data)){


        if(!empty($data['transaction_id'])){
        
            $Transactionsdetails->transaction_id = $data['transaction_id'];
        
        }

        }

    







    







    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Transactionsdetails->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Transactionsdetails->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Transactionsdetails->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TransactionsdetailExtras') &&
method_exists('\App\Http\Extras\TransactionsdetailExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TransactionsdetailExtras::beforeSaveUpdate($request,$Transactionsdetails);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TransactionsdetailExtras') &&
method_exists('\App\Http\Extras\TransactionsdetailExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TransactionsdetailExtras::canUpdate($request, $Transactionsdetails);
}catch (\Throwable $e){

}

}


if($canSave){
$Transactionsdetails->save();
}else{
return response()->json($Transactionsdetails, 200);

}


$Transactionsdetails=Transactionsdetail::find($Transactionsdetails->id);



$newCrudData=[];

                $newCrudData['parent']=$Transactionsdetails->parent;
                $newCrudData['parentId']=$Transactionsdetails->parentId;
                $newCrudData['transaction_id']=$Transactionsdetails->transaction_id;
                        $newCrudData['creat_by']=$Transactionsdetails->creat_by;
                        $newCrudData['identifiants_sadge']=$Transactionsdetails->identifiants_sadge;
    
 try{ $newCrudData['transaction']=$Transactionsdetails->transaction->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Transactionsdetails','entite_cle' => $Transactionsdetails->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Transactionsdetails->toArray();




try{

foreach ($Transactionsdetails->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Transactionsdetail $Transactionsdetails)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des transactionsdetails');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['parent']=$Transactionsdetails->parent;
                $newCrudData['parentId']=$Transactionsdetails->parentId;
                $newCrudData['transaction_id']=$Transactionsdetails->transaction_id;
                        $newCrudData['creat_by']=$Transactionsdetails->creat_by;
                        $newCrudData['identifiants_sadge']=$Transactionsdetails->identifiants_sadge;
    
 try{ $newCrudData['transaction']=$Transactionsdetails->transaction->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Transactionsdetails','entite_cle' => $Transactionsdetails->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TransactionsdetailExtras') &&
method_exists('\App\Http\Extras\TransactionsdetailExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TransactionsdetailExtras::canDelete($request, $Transactionsdetails);
}catch (\Throwable $e){

}

}



if($canSave){
$Transactionsdetails->delete();
}else{
return response()->json($Transactionsdetails, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TransactionsdetailsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
