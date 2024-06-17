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
// use App\Repository\prod\TraitementsRepository;
use App\Models\Traitement;
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
    
class TraitementController extends Controller
{

private $TraitementsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TraitementsRepository $TraitementsRepository
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
class_exists('\App\Http\Extras\TraitementExtras') &&
method_exists('\App\Http\Extras\TraitementExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TraitementExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Traitement::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TraitementExtras') &&
method_exists('\App\Http\Extras\TraitementExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TraitementExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('traitements',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TraitementExtras') &&
method_exists('\App\Http\Extras\TraitementExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TraitementExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  traitements reussi',
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
return response()->json(Traitement::count());
}
$data = QueryBuilder::for(Traitement::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('etat_depart'),

    
            AllowedFilter::exact('etat_arrive'),

    
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

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('date'),

    
            AllowedSort::field('etat_depart'),

    
            AllowedSort::field('etat_arrive'),

    
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




$data = QueryBuilder::for(Traitement::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('etat_depart'),

    
            AllowedFilter::exact('etat_arrive'),

    
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

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('date'),

    
            AllowedSort::field('etat_depart'),

    
            AllowedSort::field('etat_arrive'),

    
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



public function create(Request $request, Traitement $Traitements)
{


try{
$can=\App\Helpers\Helpers::can('Creer des traitements');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "traitements"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'date',
    'etat_depart',
    'etat_arrive',
    'transaction_id',
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
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'date' => [
            //'required'
            ],
        
    
    
                    'etat_depart' => [
            //'required'
            ],
        
    
    
                    'etat_arrive' => [
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

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'etat_depart' => ['cette donnee est obligatoire'],

    
    
        'etat_arrive' => ['cette donnee est obligatoire'],

    
    
        'transaction_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Traitements->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['date'])){
        
            $Traitements->date = $data['date'];
        
        }



    







    

        if(!empty($data['etat_depart'])){
        
            $Traitements->etat_depart = $data['etat_depart'];
        
        }



    







    

        if(!empty($data['etat_arrive'])){
        
            $Traitements->etat_arrive = $data['etat_arrive'];
        
        }



    







    

        if(!empty($data['transaction_id'])){
        
            $Traitements->transaction_id = $data['transaction_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Traitements->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Traitements->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Traitements->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TraitementExtras') &&
method_exists('\App\Http\Extras\TraitementExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TraitementExtras::beforeSaveCreate($request,$Traitements);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TraitementExtras') &&
method_exists('\App\Http\Extras\TraitementExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TraitementExtras::canCreate($request, $Traitements);
}catch (\Throwable $e){

}

}


if($canSave){
$Traitements->save();
}else{
return response()->json($Traitements, 200);
}

$Traitements=Traitement::find($Traitements->id);
$newCrudData=[];

                $newCrudData['libelle']=$Traitements->libelle;
                $newCrudData['date']=$Traitements->date;
                $newCrudData['etat_depart']=$Traitements->etat_depart;
                $newCrudData['etat_arrive']=$Traitements->etat_arrive;
                $newCrudData['transaction_id']=$Traitements->transaction_id;
                $newCrudData['creat_by']=$Traitements->creat_by;
                                $newCrudData['identifiants_sadge']=$Traitements->identifiants_sadge;
    
 try{ $newCrudData['transaction']=$Traitements->transaction->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Traitements','entite_cle' => $Traitements->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Traitements->toArray();




try{

foreach ($Traitements->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Traitement $Traitements)
{
try{
$can=\App\Helpers\Helpers::can('Editer des traitements');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Traitements->libelle;
                $oldCrudData['date']=$Traitements->date;
                $oldCrudData['etat_depart']=$Traitements->etat_depart;
                $oldCrudData['etat_arrive']=$Traitements->etat_arrive;
                $oldCrudData['transaction_id']=$Traitements->transaction_id;
                $oldCrudData['creat_by']=$Traitements->creat_by;
                                $oldCrudData['identifiants_sadge']=$Traitements->identifiants_sadge;
    
 try{ $oldCrudData['transaction']=$Traitements->transaction->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "traitements"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'date',
    'etat_depart',
    'etat_arrive',
    'transaction_id',
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
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'date' => [
            //'required'
            ],
        
    
    
                    'etat_depart' => [
            //'required'
            ],
        
    
    
                    'etat_arrive' => [
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

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'etat_depart' => ['cette donnee est obligatoire'],

    
    
        'etat_arrive' => ['cette donnee est obligatoire'],

    
    
        'transaction_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Traitements->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("date",$data)){


        if(!empty($data['date'])){
        
            $Traitements->date = $data['date'];
        
        }

        }

    







    

        if(array_key_exists("etat_depart",$data)){


        if(!empty($data['etat_depart'])){
        
            $Traitements->etat_depart = $data['etat_depart'];
        
        }

        }

    







    

        if(array_key_exists("etat_arrive",$data)){


        if(!empty($data['etat_arrive'])){
        
            $Traitements->etat_arrive = $data['etat_arrive'];
        
        }

        }

    







    

        if(array_key_exists("transaction_id",$data)){


        if(!empty($data['transaction_id'])){
        
            $Traitements->transaction_id = $data['transaction_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Traitements->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Traitements->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Traitements->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TraitementExtras') &&
method_exists('\App\Http\Extras\TraitementExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TraitementExtras::beforeSaveUpdate($request,$Traitements);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TraitementExtras') &&
method_exists('\App\Http\Extras\TraitementExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TraitementExtras::canUpdate($request, $Traitements);
}catch (\Throwable $e){

}

}


if($canSave){
$Traitements->save();
}else{
return response()->json($Traitements, 200);

}


$Traitements=Traitement::find($Traitements->id);



$newCrudData=[];

                $newCrudData['libelle']=$Traitements->libelle;
                $newCrudData['date']=$Traitements->date;
                $newCrudData['etat_depart']=$Traitements->etat_depart;
                $newCrudData['etat_arrive']=$Traitements->etat_arrive;
                $newCrudData['transaction_id']=$Traitements->transaction_id;
                $newCrudData['creat_by']=$Traitements->creat_by;
                                $newCrudData['identifiants_sadge']=$Traitements->identifiants_sadge;
    
 try{ $newCrudData['transaction']=$Traitements->transaction->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Traitements','entite_cle' => $Traitements->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Traitements->toArray();




try{

foreach ($Traitements->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Traitement $Traitements)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des traitements');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Traitements->libelle;
                $newCrudData['date']=$Traitements->date;
                $newCrudData['etat_depart']=$Traitements->etat_depart;
                $newCrudData['etat_arrive']=$Traitements->etat_arrive;
                $newCrudData['transaction_id']=$Traitements->transaction_id;
                $newCrudData['creat_by']=$Traitements->creat_by;
                                $newCrudData['identifiants_sadge']=$Traitements->identifiants_sadge;
    
 try{ $newCrudData['transaction']=$Traitements->transaction->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Traitements','entite_cle' => $Traitements->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TraitementExtras') &&
method_exists('\App\Http\Extras\TraitementExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TraitementExtras::canDelete($request, $Traitements);
}catch (\Throwable $e){

}

}



if($canSave){
$Traitements->delete();
}else{
return response()->json($Traitements, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TraitementsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
