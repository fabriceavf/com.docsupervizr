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
// use App\Repository\prod\TransactionspostessynthesesvacationsRepository;
use App\Models\Transactionspostessynthesesvacation;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Poste;
    
class TransactionspostessynthesesvacationController extends Controller
{

private $TransactionspostessynthesesvacationsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TransactionspostessynthesesvacationsRepository $TransactionspostessynthesesvacationsRepository
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
class_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras') &&
method_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TransactionspostessynthesesvacationExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Transactionspostessynthesesvacation::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras') &&
method_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TransactionspostessynthesesvacationExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('transactionspostessynthesesvacations',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras') &&
method_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TransactionspostessynthesesvacationExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  transactionspostessynthesesvacations reussi',
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
return response()->json(Transactionspostessynthesesvacation::count());
}
$data = QueryBuilder::for(Transactionspostessynthesesvacation::class)
->allowedFilters([
            AllowedFilter::exact('transactions_totals'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('transactions_id'),

    
            AllowedFilter::exact('transactions_heures'),

    
            AllowedFilter::exact('date'),

    
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
            AllowedSort::field('transactions_totals'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('transactions_id'),

    
            AllowedSort::field('transactions_heures'),

    
            AllowedSort::field('date'),

    
])
    
->allowedIncludes([

            'poste',
        

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




$data = QueryBuilder::for(Transactionspostessynthesesvacation::class)
->allowedFilters([
            AllowedFilter::exact('transactions_totals'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('transactions_id'),

    
            AllowedFilter::exact('transactions_heures'),

    
            AllowedFilter::exact('date'),

    
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
            AllowedSort::field('transactions_totals'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('transactions_id'),

    
            AllowedSort::field('transactions_heures'),

    
            AllowedSort::field('date'),

    
])
    
->allowedIncludes([
            'poste',
        

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



public function create(Request $request, Transactionspostessynthesesvacation $Transactionspostessynthesesvacations)
{


try{
$can=\App\Helpers\Helpers::can('Creer des transactionspostessynthesesvacations');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "transactionspostessynthesesvacations"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'transactions_totals',
    'poste_id',
    'transactions_id',
    'transactions_heures',
    'date',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
                    'transactions_totals' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'transactions_id' => [
            //'required'
            ],
        
    
    
                    'transactions_heures' => [
            //'required'
            ],
        
    
    
                    'date' => [
            //'required'
            ],
        
    


], $messages = [

    
        'transactions_totals' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'transactions_id' => ['cette donnee est obligatoire'],

    
    
        'transactions_heures' => ['cette donnee est obligatoire'],

    
    
        'date' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    

        if(!empty($data['transactions_totals'])){
        
            $Transactionspostessynthesesvacations->transactions_totals = $data['transactions_totals'];
        
        }



    







    

        if(!empty($data['poste_id'])){
        
            $Transactionspostessynthesesvacations->poste_id = $data['poste_id'];
        
        }



    







    

        if(!empty($data['transactions_id'])){
        
            $Transactionspostessynthesesvacations->transactions_id = $data['transactions_id'];
        
        }



    







    

        if(!empty($data['transactions_heures'])){
        
            $Transactionspostessynthesesvacations->transactions_heures = $data['transactions_heures'];
        
        }



    







    

        if(!empty($data['date'])){
        
            $Transactionspostessynthesesvacations->date = $data['date'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Transactionspostessynthesesvacations->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras') &&
method_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TransactionspostessynthesesvacationExtras::beforeSaveCreate($request,$Transactionspostessynthesesvacations);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras') &&
method_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TransactionspostessynthesesvacationExtras::canCreate($request, $Transactionspostessynthesesvacations);
}catch (\Throwable $e){

}

}


if($canSave){
$Transactionspostessynthesesvacations->save();
}else{
return response()->json($Transactionspostessynthesesvacations, 200);
}

$Transactionspostessynthesesvacations=Transactionspostessynthesesvacation::find($Transactionspostessynthesesvacations->id);
$newCrudData=[];

            $newCrudData['transactions_totals']=$Transactionspostessynthesesvacations->transactions_totals;
                $newCrudData['poste_id']=$Transactionspostessynthesesvacations->poste_id;
                $newCrudData['transactions_id']=$Transactionspostessynthesesvacations->transactions_id;
                $newCrudData['transactions_heures']=$Transactionspostessynthesesvacations->transactions_heures;
                $newCrudData['date']=$Transactionspostessynthesesvacations->date;
    
 try{ $newCrudData['poste']=$Transactionspostessynthesesvacations->poste->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Transactionspostessynthesesvacations','entite_cle' => $Transactionspostessynthesesvacations->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Transactionspostessynthesesvacations->toArray();




try{

foreach ($Transactionspostessynthesesvacations->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Transactionspostessynthesesvacation $Transactionspostessynthesesvacations)
{
try{
$can=\App\Helpers\Helpers::can('Editer des transactionspostessynthesesvacations');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

            $oldCrudData['transactions_totals']=$Transactionspostessynthesesvacations->transactions_totals;
                $oldCrudData['poste_id']=$Transactionspostessynthesesvacations->poste_id;
                $oldCrudData['transactions_id']=$Transactionspostessynthesesvacations->transactions_id;
                $oldCrudData['transactions_heures']=$Transactionspostessynthesesvacations->transactions_heures;
                $oldCrudData['date']=$Transactionspostessynthesesvacations->date;
    
 try{ $oldCrudData['poste']=$Transactionspostessynthesesvacations->poste->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "transactionspostessynthesesvacations"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'transactions_totals',
    'poste_id',
    'transactions_id',
    'transactions_heures',
    'date',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
                    'transactions_totals' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'transactions_id' => [
            //'required'
            ],
        
    
    
                    'transactions_heures' => [
            //'required'
            ],
        
    
    
                    'date' => [
            //'required'
            ],
        
    


], $messages = [

    
        'transactions_totals' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'transactions_id' => ['cette donnee est obligatoire'],

    
    
        'transactions_heures' => ['cette donnee est obligatoire'],

    
    
        'date' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    

        if(array_key_exists("transactions_totals",$data)){


        if(!empty($data['transactions_totals'])){
        
            $Transactionspostessynthesesvacations->transactions_totals = $data['transactions_totals'];
        
        }

        }

    







    

        if(array_key_exists("poste_id",$data)){


        if(!empty($data['poste_id'])){
        
            $Transactionspostessynthesesvacations->poste_id = $data['poste_id'];
        
        }

        }

    







    

        if(array_key_exists("transactions_id",$data)){


        if(!empty($data['transactions_id'])){
        
            $Transactionspostessynthesesvacations->transactions_id = $data['transactions_id'];
        
        }

        }

    







    

        if(array_key_exists("transactions_heures",$data)){


        if(!empty($data['transactions_heures'])){
        
            $Transactionspostessynthesesvacations->transactions_heures = $data['transactions_heures'];
        
        }

        }

    







    

        if(array_key_exists("date",$data)){


        if(!empty($data['date'])){
        
            $Transactionspostessynthesesvacations->date = $data['date'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Transactionspostessynthesesvacations->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras') &&
method_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TransactionspostessynthesesvacationExtras::beforeSaveUpdate($request,$Transactionspostessynthesesvacations);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras') &&
method_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TransactionspostessynthesesvacationExtras::canUpdate($request, $Transactionspostessynthesesvacations);
}catch (\Throwable $e){

}

}


if($canSave){
$Transactionspostessynthesesvacations->save();
}else{
return response()->json($Transactionspostessynthesesvacations, 200);

}


$Transactionspostessynthesesvacations=Transactionspostessynthesesvacation::find($Transactionspostessynthesesvacations->id);



$newCrudData=[];

            $newCrudData['transactions_totals']=$Transactionspostessynthesesvacations->transactions_totals;
                $newCrudData['poste_id']=$Transactionspostessynthesesvacations->poste_id;
                $newCrudData['transactions_id']=$Transactionspostessynthesesvacations->transactions_id;
                $newCrudData['transactions_heures']=$Transactionspostessynthesesvacations->transactions_heures;
                $newCrudData['date']=$Transactionspostessynthesesvacations->date;
    
 try{ $newCrudData['poste']=$Transactionspostessynthesesvacations->poste->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Transactionspostessynthesesvacations','entite_cle' => $Transactionspostessynthesesvacations->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Transactionspostessynthesesvacations->toArray();




try{

foreach ($Transactionspostessynthesesvacations->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Transactionspostessynthesesvacation $Transactionspostessynthesesvacations)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des transactionspostessynthesesvacations');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

            $newCrudData['transactions_totals']=$Transactionspostessynthesesvacations->transactions_totals;
                $newCrudData['poste_id']=$Transactionspostessynthesesvacations->poste_id;
                $newCrudData['transactions_id']=$Transactionspostessynthesesvacations->transactions_id;
                $newCrudData['transactions_heures']=$Transactionspostessynthesesvacations->transactions_heures;
                $newCrudData['date']=$Transactionspostessynthesesvacations->date;
    
 try{ $newCrudData['poste']=$Transactionspostessynthesesvacations->poste->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Transactionspostessynthesesvacations','entite_cle' => $Transactionspostessynthesesvacations->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras') &&
method_exists('\App\Http\Extras\TransactionspostessynthesesvacationExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TransactionspostessynthesesvacationExtras::canDelete($request, $Transactionspostessynthesesvacations);
}catch (\Throwable $e){

}

}



if($canSave){
$Transactionspostessynthesesvacations->delete();
}else{
return response()->json($Transactionspostessynthesesvacations, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TransactionspostessynthesesvacationsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
