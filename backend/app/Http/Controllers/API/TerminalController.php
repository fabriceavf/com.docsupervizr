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
// use App\Repository\prod\TerminalsRepository;
use App\Models\Terminal;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Voiture;
    
class TerminalController extends Controller
{

private $TerminalsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TerminalsRepository $TerminalsRepository
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
class_exists('\App\Http\Extras\TerminalExtras') &&
method_exists('\App\Http\Extras\TerminalExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TerminalExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Terminal::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TerminalExtras') &&
method_exists('\App\Http\Extras\TerminalExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TerminalExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('terminals',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TerminalExtras') &&
method_exists('\App\Http\Extras\TerminalExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TerminalExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  terminals reussi',
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
return response()->json(Terminal::count());
}
$data = QueryBuilder::for(Terminal::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('adresse_mac'),

    
            AllowedFilter::exact('etat'),

    
            AllowedFilter::exact('alimentation'),

    
            AllowedFilter::exact('reseau'),

    
            AllowedFilter::exact('voiture_id'),

    
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

    
            AllowedSort::field('code'),

    
            AllowedSort::field('adresse_mac'),

    
            AllowedSort::field('etat'),

    
            AllowedSort::field('alimentation'),

    
            AllowedSort::field('reseau'),

    
            AllowedSort::field('voiture_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([

            'voiture',
        

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




$data = QueryBuilder::for(Terminal::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('adresse_mac'),

    
            AllowedFilter::exact('etat'),

    
            AllowedFilter::exact('alimentation'),

    
            AllowedFilter::exact('reseau'),

    
            AllowedFilter::exact('voiture_id'),

    
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

    
            AllowedSort::field('code'),

    
            AllowedSort::field('adresse_mac'),

    
            AllowedSort::field('etat'),

    
            AllowedSort::field('alimentation'),

    
            AllowedSort::field('reseau'),

    
            AllowedSort::field('voiture_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([
            'voiture',
        

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



public function create(Request $request, Terminal $Terminals)
{


try{
$can=\App\Helpers\Helpers::can('Creer des terminals');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "terminals"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'adresse_mac',
    'etat',
    'alimentation',
    'reseau',
    'voiture_id',
    'creat_by',
    'created_at',
    'updated_at',
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
    
    
                    'code' => [
            //'required'
            ],
        
    
    
                    'adresse_mac' => [
            //'required'
            ],
        
    
    
                    'etat' => [
            //'required'
            ],
        
    
    
                    'alimentation' => [
            //'required'
            ],
        
    
    
                    'reseau' => [
            //'required'
            ],
        
    
    
                    'voiture_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'adresse_mac' => ['cette donnee est obligatoire'],

    
    
        'etat' => ['cette donnee est obligatoire'],

    
    
        'alimentation' => ['cette donnee est obligatoire'],

    
    
        'reseau' => ['cette donnee est obligatoire'],

    
    
        'voiture_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['code'])){
        
            $Terminals->code = $data['code'];
        
        }



    







    

        if(!empty($data['adresse_mac'])){
        
            $Terminals->adresse_mac = $data['adresse_mac'];
        
        }



    







    

        if(!empty($data['etat'])){
        
            $Terminals->etat = $data['etat'];
        
        }



    







    

        if(!empty($data['alimentation'])){
        
            $Terminals->alimentation = $data['alimentation'];
        
        }



    







    

        if(!empty($data['reseau'])){
        
            $Terminals->reseau = $data['reseau'];
        
        }



    







    

        if(!empty($data['voiture_id'])){
        
            $Terminals->voiture_id = $data['voiture_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Terminals->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Terminals->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Terminals->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TerminalExtras') &&
method_exists('\App\Http\Extras\TerminalExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TerminalExtras::beforeSaveCreate($request,$Terminals);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TerminalExtras') &&
method_exists('\App\Http\Extras\TerminalExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TerminalExtras::canCreate($request, $Terminals);
}catch (\Throwable $e){

}

}


if($canSave){
$Terminals->save();
}else{
return response()->json($Terminals, 200);
}

$Terminals=Terminal::find($Terminals->id);
$newCrudData=[];

                $newCrudData['code']=$Terminals->code;
                $newCrudData['adresse_mac']=$Terminals->adresse_mac;
                $newCrudData['etat']=$Terminals->etat;
                $newCrudData['alimentation']=$Terminals->alimentation;
                $newCrudData['reseau']=$Terminals->reseau;
                $newCrudData['voiture_id']=$Terminals->voiture_id;
                $newCrudData['creat_by']=$Terminals->creat_by;
                                $newCrudData['identifiants_sadge']=$Terminals->identifiants_sadge;
    
 try{ $newCrudData['voiture']=$Terminals->voiture->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Terminals','entite_cle' => $Terminals->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Terminals->toArray();




try{

foreach ($Terminals->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Terminal $Terminals)
{
try{
$can=\App\Helpers\Helpers::can('Editer des terminals');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['code']=$Terminals->code;
                $oldCrudData['adresse_mac']=$Terminals->adresse_mac;
                $oldCrudData['etat']=$Terminals->etat;
                $oldCrudData['alimentation']=$Terminals->alimentation;
                $oldCrudData['reseau']=$Terminals->reseau;
                $oldCrudData['voiture_id']=$Terminals->voiture_id;
                $oldCrudData['creat_by']=$Terminals->creat_by;
                                $oldCrudData['identifiants_sadge']=$Terminals->identifiants_sadge;
    
 try{ $oldCrudData['voiture']=$Terminals->voiture->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "terminals"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'adresse_mac',
    'etat',
    'alimentation',
    'reseau',
    'voiture_id',
    'creat_by',
    'created_at',
    'updated_at',
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
    
    
                    'code' => [
            //'required'
            ],
        
    
    
                    'adresse_mac' => [
            //'required'
            ],
        
    
    
                    'etat' => [
            //'required'
            ],
        
    
    
                    'alimentation' => [
            //'required'
            ],
        
    
    
                    'reseau' => [
            //'required'
            ],
        
    
    
                    'voiture_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'adresse_mac' => ['cette donnee est obligatoire'],

    
    
        'etat' => ['cette donnee est obligatoire'],

    
    
        'alimentation' => ['cette donnee est obligatoire'],

    
    
        'reseau' => ['cette donnee est obligatoire'],

    
    
        'voiture_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("code",$data)){


        if(!empty($data['code'])){
        
            $Terminals->code = $data['code'];
        
        }

        }

    







    

        if(array_key_exists("adresse_mac",$data)){


        if(!empty($data['adresse_mac'])){
        
            $Terminals->adresse_mac = $data['adresse_mac'];
        
        }

        }

    







    

        if(array_key_exists("etat",$data)){


        if(!empty($data['etat'])){
        
            $Terminals->etat = $data['etat'];
        
        }

        }

    







    

        if(array_key_exists("alimentation",$data)){


        if(!empty($data['alimentation'])){
        
            $Terminals->alimentation = $data['alimentation'];
        
        }

        }

    







    

        if(array_key_exists("reseau",$data)){


        if(!empty($data['reseau'])){
        
            $Terminals->reseau = $data['reseau'];
        
        }

        }

    







    

        if(array_key_exists("voiture_id",$data)){


        if(!empty($data['voiture_id'])){
        
            $Terminals->voiture_id = $data['voiture_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Terminals->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Terminals->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Terminals->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TerminalExtras') &&
method_exists('\App\Http\Extras\TerminalExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TerminalExtras::beforeSaveUpdate($request,$Terminals);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TerminalExtras') &&
method_exists('\App\Http\Extras\TerminalExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TerminalExtras::canUpdate($request, $Terminals);
}catch (\Throwable $e){

}

}


if($canSave){
$Terminals->save();
}else{
return response()->json($Terminals, 200);

}


$Terminals=Terminal::find($Terminals->id);



$newCrudData=[];

                $newCrudData['code']=$Terminals->code;
                $newCrudData['adresse_mac']=$Terminals->adresse_mac;
                $newCrudData['etat']=$Terminals->etat;
                $newCrudData['alimentation']=$Terminals->alimentation;
                $newCrudData['reseau']=$Terminals->reseau;
                $newCrudData['voiture_id']=$Terminals->voiture_id;
                $newCrudData['creat_by']=$Terminals->creat_by;
                                $newCrudData['identifiants_sadge']=$Terminals->identifiants_sadge;
    
 try{ $newCrudData['voiture']=$Terminals->voiture->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Terminals','entite_cle' => $Terminals->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Terminals->toArray();




try{

foreach ($Terminals->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Terminal $Terminals)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des terminals');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['code']=$Terminals->code;
                $newCrudData['adresse_mac']=$Terminals->adresse_mac;
                $newCrudData['etat']=$Terminals->etat;
                $newCrudData['alimentation']=$Terminals->alimentation;
                $newCrudData['reseau']=$Terminals->reseau;
                $newCrudData['voiture_id']=$Terminals->voiture_id;
                $newCrudData['creat_by']=$Terminals->creat_by;
                                $newCrudData['identifiants_sadge']=$Terminals->identifiants_sadge;
    
 try{ $newCrudData['voiture']=$Terminals->voiture->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Terminals','entite_cle' => $Terminals->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TerminalExtras') &&
method_exists('\App\Http\Extras\TerminalExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TerminalExtras::canDelete($request, $Terminals);
}catch (\Throwable $e){

}

}



if($canSave){
$Terminals->delete();
}else{
return response()->json($Terminals, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TerminalsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
