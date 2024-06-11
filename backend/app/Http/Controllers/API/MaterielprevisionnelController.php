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
// use App\Repository\prod\MaterielprevisionnelsRepository;
use App\Models\Materielprevisionnel;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Chantier;
                use App\Models\Materiel;
    
class MaterielprevisionnelController extends Controller
{

private $MaterielprevisionnelsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\MaterielprevisionnelsRepository $MaterielprevisionnelsRepository
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
class_exists('\App\Http\Extras\MaterielprevisionnelExtras') &&
method_exists('\App\Http\Extras\MaterielprevisionnelExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\MaterielprevisionnelExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Materielprevisionnel::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\MaterielprevisionnelExtras') &&
method_exists('\App\Http\Extras\MaterielprevisionnelExtras', 'filterAgGridQuery')
){
\App\Http\Extras\MaterielprevisionnelExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('materielprevisionnels',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\MaterielprevisionnelExtras') &&
method_exists('\App\Http\Extras\MaterielprevisionnelExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\MaterielprevisionnelExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  materielprevisionnels reussi',
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
return response()->json(Materielprevisionnel::count());
}
$data = QueryBuilder::for(Materielprevisionnel::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('materiel_id'),

    
            AllowedFilter::exact('chantier_id'),

    
            AllowedFilter::exact('quantite'),

    
    
    
    
    
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

    
            AllowedSort::field('materiel_id'),

    
            AllowedSort::field('chantier_id'),

    
            AllowedSort::field('quantite'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([

            'chantier',
        

                'materiel',
        

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




$data = QueryBuilder::for(Materielprevisionnel::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('materiel_id'),

    
            AllowedFilter::exact('chantier_id'),

    
            AllowedFilter::exact('quantite'),

    
    
    
    
    
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

    
            AllowedSort::field('materiel_id'),

    
            AllowedSort::field('chantier_id'),

    
            AllowedSort::field('quantite'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'chantier',
        

                'materiel',
        

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



public function create(Request $request, Materielprevisionnel $Materielprevisionnels)
{


try{
$can=\App\Helpers\Helpers::can('Creer des materielprevisionnels');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "materielprevisionnels"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'materiel_id',
    'chantier_id',
    'quantite',
    'created_at',
    'updated_at',
    'extra_attributes',
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
    
    
                    'materiel_id' => [
            //'required'
            ],
        
    
    
                    'chantier_id' => [
            //'required'
            ],
        
    
    
                    'quantite' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'materiel_id' => ['cette donnee est obligatoire'],

    
    
        'chantier_id' => ['cette donnee est obligatoire'],

    
    
        'quantite' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['materiel_id'])){
        
            $Materielprevisionnels->materiel_id = $data['materiel_id'];
        
        }



    







    

        if(!empty($data['chantier_id'])){
        
            $Materielprevisionnels->chantier_id = $data['chantier_id'];
        
        }



    







    

        if(!empty($data['quantite'])){
        
            $Materielprevisionnels->quantite = $data['quantite'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Materielprevisionnels->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Materielprevisionnels->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Materielprevisionnels->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\MaterielprevisionnelExtras') &&
method_exists('\App\Http\Extras\MaterielprevisionnelExtras', 'beforeSaveCreate')
){
\App\Http\Extras\MaterielprevisionnelExtras::beforeSaveCreate($request,$Materielprevisionnels);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\MaterielprevisionnelExtras') &&
method_exists('\App\Http\Extras\MaterielprevisionnelExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\MaterielprevisionnelExtras::canCreate($request, $Materielprevisionnels);
}catch (\Throwable $e){

}

}


if($canSave){
$Materielprevisionnels->save();
}else{
return response()->json($Materielprevisionnels, 200);
}

$Materielprevisionnels=Materielprevisionnel::find($Materielprevisionnels->id);
$newCrudData=[];

                $newCrudData['materiel_id']=$Materielprevisionnels->materiel_id;
                $newCrudData['chantier_id']=$Materielprevisionnels->chantier_id;
                $newCrudData['quantite']=$Materielprevisionnels->quantite;
                                $newCrudData['identifiants_sadge']=$Materielprevisionnels->identifiants_sadge;
                $newCrudData['creat_by']=$Materielprevisionnels->creat_by;
    
 try{ $newCrudData['chantier']=$Materielprevisionnels->chantier->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['materiel']=$Materielprevisionnels->materiel->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Materielprevisionnels','entite_cle' => $Materielprevisionnels->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Materielprevisionnels->toArray();




try{

foreach ($Materielprevisionnels->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Materielprevisionnel $Materielprevisionnels)
{
try{
$can=\App\Helpers\Helpers::can('Editer des materielprevisionnels');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['materiel_id']=$Materielprevisionnels->materiel_id;
                $oldCrudData['chantier_id']=$Materielprevisionnels->chantier_id;
                $oldCrudData['quantite']=$Materielprevisionnels->quantite;
                                $oldCrudData['identifiants_sadge']=$Materielprevisionnels->identifiants_sadge;
                $oldCrudData['creat_by']=$Materielprevisionnels->creat_by;
    
 try{ $oldCrudData['chantier']=$Materielprevisionnels->chantier->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['materiel']=$Materielprevisionnels->materiel->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "materielprevisionnels"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'materiel_id',
    'chantier_id',
    'quantite',
    'created_at',
    'updated_at',
    'extra_attributes',
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
    
    
                    'materiel_id' => [
            //'required'
            ],
        
    
    
                    'chantier_id' => [
            //'required'
            ],
        
    
    
                    'quantite' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'materiel_id' => ['cette donnee est obligatoire'],

    
    
        'chantier_id' => ['cette donnee est obligatoire'],

    
    
        'quantite' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("materiel_id",$data)){


        if(!empty($data['materiel_id'])){
        
            $Materielprevisionnels->materiel_id = $data['materiel_id'];
        
        }

        }

    







    

        if(array_key_exists("chantier_id",$data)){


        if(!empty($data['chantier_id'])){
        
            $Materielprevisionnels->chantier_id = $data['chantier_id'];
        
        }

        }

    







    

        if(array_key_exists("quantite",$data)){


        if(!empty($data['quantite'])){
        
            $Materielprevisionnels->quantite = $data['quantite'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Materielprevisionnels->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Materielprevisionnels->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Materielprevisionnels->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\MaterielprevisionnelExtras') &&
method_exists('\App\Http\Extras\MaterielprevisionnelExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\MaterielprevisionnelExtras::beforeSaveUpdate($request,$Materielprevisionnels);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\MaterielprevisionnelExtras') &&
method_exists('\App\Http\Extras\MaterielprevisionnelExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\MaterielprevisionnelExtras::canUpdate($request, $Materielprevisionnels);
}catch (\Throwable $e){

}

}


if($canSave){
$Materielprevisionnels->save();
}else{
return response()->json($Materielprevisionnels, 200);

}


$Materielprevisionnels=Materielprevisionnel::find($Materielprevisionnels->id);



$newCrudData=[];

                $newCrudData['materiel_id']=$Materielprevisionnels->materiel_id;
                $newCrudData['chantier_id']=$Materielprevisionnels->chantier_id;
                $newCrudData['quantite']=$Materielprevisionnels->quantite;
                                $newCrudData['identifiants_sadge']=$Materielprevisionnels->identifiants_sadge;
                $newCrudData['creat_by']=$Materielprevisionnels->creat_by;
    
 try{ $newCrudData['chantier']=$Materielprevisionnels->chantier->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['materiel']=$Materielprevisionnels->materiel->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Materielprevisionnels','entite_cle' => $Materielprevisionnels->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Materielprevisionnels->toArray();




try{

foreach ($Materielprevisionnels->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Materielprevisionnel $Materielprevisionnels)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des materielprevisionnels');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['materiel_id']=$Materielprevisionnels->materiel_id;
                $newCrudData['chantier_id']=$Materielprevisionnels->chantier_id;
                $newCrudData['quantite']=$Materielprevisionnels->quantite;
                                $newCrudData['identifiants_sadge']=$Materielprevisionnels->identifiants_sadge;
                $newCrudData['creat_by']=$Materielprevisionnels->creat_by;
    
 try{ $newCrudData['chantier']=$Materielprevisionnels->chantier->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['materiel']=$Materielprevisionnels->materiel->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Materielprevisionnels','entite_cle' => $Materielprevisionnels->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\MaterielprevisionnelExtras') &&
method_exists('\App\Http\Extras\MaterielprevisionnelExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\MaterielprevisionnelExtras::canDelete($request, $Materielprevisionnels);
}catch (\Throwable $e){

}

}



if($canSave){
$Materielprevisionnels->delete();
}else{
return response()->json($Materielprevisionnels, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\MaterielprevisionnelsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
