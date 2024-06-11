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
// use App\Repository\prod\ChantiersRepository;
use App\Models\Chantier;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;




class ChantierController extends Controller
{

private $ChantiersRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ChantiersRepository $ChantiersRepository
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
class_exists('\App\Http\Extras\ChantierExtras') &&
method_exists('\App\Http\Extras\ChantierExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ChantierExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Chantier::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ChantierExtras') &&
method_exists('\App\Http\Extras\ChantierExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ChantierExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('chantiers',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ChantierExtras') &&
method_exists('\App\Http\Extras\ChantierExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ChantierExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  chantiers reussi',
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
return response()->json(Chantier::count());
}
$data = QueryBuilder::for(Chantier::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('couleur'),

    
            AllowedFilter::exact('debut_prevus'),

    
            AllowedFilter::exact('fin_prevus'),

    
            AllowedFilter::exact('debut_effectif'),

    
            AllowedFilter::exact('fin_effectif'),

    
    
    
    
    
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

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('couleur'),

    
            AllowedSort::field('debut_prevus'),

    
            AllowedSort::field('fin_prevus'),

    
            AllowedSort::field('debut_effectif'),

    
            AllowedSort::field('fin_effectif'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
->allowedIncludes([
            'chantierlocalisations',
        

                'materielprevisionnels',
        

    
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




$data = QueryBuilder::for(Chantier::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('couleur'),

    
            AllowedFilter::exact('debut_prevus'),

    
            AllowedFilter::exact('fin_prevus'),

    
            AllowedFilter::exact('debut_effectif'),

    
            AllowedFilter::exact('fin_effectif'),

    
    
    
    
    
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

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('couleur'),

    
            AllowedSort::field('debut_prevus'),

    
            AllowedSort::field('fin_prevus'),

    
            AllowedSort::field('debut_effectif'),

    
            AllowedSort::field('fin_effectif'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
->allowedIncludes([
            'chantierlocalisations',
        

                'materielprevisionnels',
        

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



public function create(Request $request, Chantier $Chantiers)
{


try{
$can=\App\Helpers\Helpers::can('Creer des chantiers');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "chantiers"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'couleur',
    'debut_prevus',
    'fin_prevus',
    'debut_effectif',
    'fin_effectif',
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
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'couleur' => [
            //'required'
            ],
        
    
    
                    'debut_prevus' => [
            //'required'
            ],
        
    
    
                    'fin_prevus' => [
            //'required'
            ],
        
    
    
                    'debut_effectif' => [
            //'required'
            ],
        
    
    
                    'fin_effectif' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'couleur' => ['cette donnee est obligatoire'],

    
    
        'debut_prevus' => ['cette donnee est obligatoire'],

    
    
        'fin_prevus' => ['cette donnee est obligatoire'],

    
    
        'debut_effectif' => ['cette donnee est obligatoire'],

    
    
        'fin_effectif' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Chantiers->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['couleur'])){
        
            $Chantiers->couleur = $data['couleur'];
        
        }



    







    

        if(!empty($data['debut_prevus'])){
        
            $Chantiers->debut_prevus = $data['debut_prevus'];
        
        }



    







    

        if(!empty($data['fin_prevus'])){
        
            $Chantiers->fin_prevus = $data['fin_prevus'];
        
        }



    







    

        if(!empty($data['debut_effectif'])){
        
            $Chantiers->debut_effectif = $data['debut_effectif'];
        
        }



    







    

        if(!empty($data['fin_effectif'])){
        
            $Chantiers->fin_effectif = $data['fin_effectif'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Chantiers->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Chantiers->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Chantiers->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ChantierExtras') &&
method_exists('\App\Http\Extras\ChantierExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ChantierExtras::beforeSaveCreate($request,$Chantiers);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ChantierExtras') &&
method_exists('\App\Http\Extras\ChantierExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ChantierExtras::canCreate($request, $Chantiers);
}catch (\Throwable $e){

}

}


if($canSave){
$Chantiers->save();
}else{
return response()->json($Chantiers, 200);
}

$Chantiers=Chantier::find($Chantiers->id);
$newCrudData=[];

                $newCrudData['libelle']=$Chantiers->libelle;
                $newCrudData['couleur']=$Chantiers->couleur;
                $newCrudData['debut_prevus']=$Chantiers->debut_prevus;
                $newCrudData['fin_prevus']=$Chantiers->fin_prevus;
                $newCrudData['debut_effectif']=$Chantiers->debut_effectif;
                $newCrudData['fin_effectif']=$Chantiers->fin_effectif;
                                $newCrudData['identifiants_sadge']=$Chantiers->identifiants_sadge;
                $newCrudData['creat_by']=$Chantiers->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Chantiers','entite_cle' => $Chantiers->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Chantiers->toArray();




try{

foreach ($Chantiers->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Chantier $Chantiers)
{
try{
$can=\App\Helpers\Helpers::can('Editer des chantiers');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Chantiers->libelle;
                $oldCrudData['couleur']=$Chantiers->couleur;
                $oldCrudData['debut_prevus']=$Chantiers->debut_prevus;
                $oldCrudData['fin_prevus']=$Chantiers->fin_prevus;
                $oldCrudData['debut_effectif']=$Chantiers->debut_effectif;
                $oldCrudData['fin_effectif']=$Chantiers->fin_effectif;
                                $oldCrudData['identifiants_sadge']=$Chantiers->identifiants_sadge;
                $oldCrudData['creat_by']=$Chantiers->creat_by;
    


$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "chantiers"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'couleur',
    'debut_prevus',
    'fin_prevus',
    'debut_effectif',
    'fin_effectif',
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
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'couleur' => [
            //'required'
            ],
        
    
    
                    'debut_prevus' => [
            //'required'
            ],
        
    
    
                    'fin_prevus' => [
            //'required'
            ],
        
    
    
                    'debut_effectif' => [
            //'required'
            ],
        
    
    
                    'fin_effectif' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'couleur' => ['cette donnee est obligatoire'],

    
    
        'debut_prevus' => ['cette donnee est obligatoire'],

    
    
        'fin_prevus' => ['cette donnee est obligatoire'],

    
    
        'debut_effectif' => ['cette donnee est obligatoire'],

    
    
        'fin_effectif' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Chantiers->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("couleur",$data)){


        if(!empty($data['couleur'])){
        
            $Chantiers->couleur = $data['couleur'];
        
        }

        }

    







    

        if(array_key_exists("debut_prevus",$data)){


        if(!empty($data['debut_prevus'])){
        
            $Chantiers->debut_prevus = $data['debut_prevus'];
        
        }

        }

    







    

        if(array_key_exists("fin_prevus",$data)){


        if(!empty($data['fin_prevus'])){
        
            $Chantiers->fin_prevus = $data['fin_prevus'];
        
        }

        }

    







    

        if(array_key_exists("debut_effectif",$data)){


        if(!empty($data['debut_effectif'])){
        
            $Chantiers->debut_effectif = $data['debut_effectif'];
        
        }

        }

    







    

        if(array_key_exists("fin_effectif",$data)){


        if(!empty($data['fin_effectif'])){
        
            $Chantiers->fin_effectif = $data['fin_effectif'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Chantiers->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Chantiers->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Chantiers->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ChantierExtras') &&
method_exists('\App\Http\Extras\ChantierExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ChantierExtras::beforeSaveUpdate($request,$Chantiers);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ChantierExtras') &&
method_exists('\App\Http\Extras\ChantierExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ChantierExtras::canUpdate($request, $Chantiers);
}catch (\Throwable $e){

}

}


if($canSave){
$Chantiers->save();
}else{
return response()->json($Chantiers, 200);

}


$Chantiers=Chantier::find($Chantiers->id);



$newCrudData=[];

                $newCrudData['libelle']=$Chantiers->libelle;
                $newCrudData['couleur']=$Chantiers->couleur;
                $newCrudData['debut_prevus']=$Chantiers->debut_prevus;
                $newCrudData['fin_prevus']=$Chantiers->fin_prevus;
                $newCrudData['debut_effectif']=$Chantiers->debut_effectif;
                $newCrudData['fin_effectif']=$Chantiers->fin_effectif;
                                $newCrudData['identifiants_sadge']=$Chantiers->identifiants_sadge;
                $newCrudData['creat_by']=$Chantiers->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Chantiers','entite_cle' => $Chantiers->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Chantiers->toArray();




try{

foreach ($Chantiers->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Chantier $Chantiers)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des chantiers');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Chantiers->libelle;
                $newCrudData['couleur']=$Chantiers->couleur;
                $newCrudData['debut_prevus']=$Chantiers->debut_prevus;
                $newCrudData['fin_prevus']=$Chantiers->fin_prevus;
                $newCrudData['debut_effectif']=$Chantiers->debut_effectif;
                $newCrudData['fin_effectif']=$Chantiers->fin_effectif;
                                $newCrudData['identifiants_sadge']=$Chantiers->identifiants_sadge;
                $newCrudData['creat_by']=$Chantiers->creat_by;
    

DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Chantiers','entite_cle' => $Chantiers->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ChantierExtras') &&
method_exists('\App\Http\Extras\ChantierExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ChantierExtras::canDelete($request, $Chantiers);
}catch (\Throwable $e){

}

}



if($canSave){
$Chantiers->delete();
}else{
return response()->json($Chantiers, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ChantiersActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
