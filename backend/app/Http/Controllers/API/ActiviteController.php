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
// use App\Repository\prod\ActivitesRepository;
use App\Models\Activite;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



    
class ActiviteController extends Controller
{

private $ActivitesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ActivitesRepository $ActivitesRepository
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
class_exists('\App\Http\Extras\ActiviteExtras') &&
method_exists('\App\Http\Extras\ActiviteExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ActiviteExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Activite::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ActiviteExtras') &&
method_exists('\App\Http\Extras\ActiviteExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ActiviteExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('activites',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ActiviteExtras') &&
method_exists('\App\Http\Extras\ActiviteExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ActiviteExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  activites reussi',
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
return response()->json(Activite::count());
}
$data = QueryBuilder::for(Activite::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
    
    
    
    
            AllowedFilter::exact('duree'),

    
            AllowedFilter::exact('parent'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('has_child'),

    
            AllowedFilter::exact('description'),

    
            AllowedFilter::exact('validate'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('etats_actuel'),

    
            AllowedFilter::exact('description_actuel'),

    
            AllowedFilter::exact('ParentElements'),

    
            AllowedFilter::exact('AllEtats'),

    
            AllowedFilter::exact('CanUpdate'),

    
            AllowedFilter::exact('IsCreateByMe'),

    
            AllowedFilter::exact('IsWorkForMe'),

    
            AllowedFilter::exact('Status'),

    
            AllowedFilter::exact('Createur'),

    
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

    
    
    
    
    
            AllowedSort::field('duree'),

    
            AllowedSort::field('parent'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('has_child'),

    
            AllowedSort::field('description'),

    
            AllowedSort::field('validate'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('etats_actuel'),

    
            AllowedSort::field('description_actuel'),

    
            AllowedSort::field('ParentElements'),

    
            AllowedSort::field('AllEtats'),

    
            AllowedSort::field('CanUpdate'),

    
            AllowedSort::field('IsCreateByMe'),

    
            AllowedSort::field('IsWorkForMe'),

    
            AllowedSort::field('Status'),

    
            AllowedSort::field('Createur'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
            'objectifs',
        

                'ressources',
        

                'works',
        

    
            'user',
        

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




$data = QueryBuilder::for(Activite::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
    
    
    
    
            AllowedFilter::exact('duree'),

    
            AllowedFilter::exact('parent'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('has_child'),

    
            AllowedFilter::exact('description'),

    
            AllowedFilter::exact('validate'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('etats_actuel'),

    
            AllowedFilter::exact('description_actuel'),

    
            AllowedFilter::exact('ParentElements'),

    
            AllowedFilter::exact('AllEtats'),

    
            AllowedFilter::exact('CanUpdate'),

    
            AllowedFilter::exact('IsCreateByMe'),

    
            AllowedFilter::exact('IsWorkForMe'),

    
            AllowedFilter::exact('Status'),

    
            AllowedFilter::exact('Createur'),

    
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

    
    
    
    
    
            AllowedSort::field('duree'),

    
            AllowedSort::field('parent'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('has_child'),

    
            AllowedSort::field('description'),

    
            AllowedSort::field('validate'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('etats_actuel'),

    
            AllowedSort::field('description_actuel'),

    
            AllowedSort::field('ParentElements'),

    
            AllowedSort::field('AllEtats'),

    
            AllowedSort::field('CanUpdate'),

    
            AllowedSort::field('IsCreateByMe'),

    
            AllowedSort::field('IsWorkForMe'),

    
            AllowedSort::field('Status'),

    
            AllowedSort::field('Createur'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
            'objectifs',
        

                'ressources',
        

                'works',
        

                'user',
        

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



public function create(Request $request, Activite $Activites)
{


try{
$can=\App\Helpers\Helpers::can('Creer des activites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "activites"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'duree',
    'parent',
    'user_id',
    'has_child',
    'description',
    'validate',
    'type',
    'etats_actuel',
    'description_actuel',
    'ParentElements',
    'AllEtats',
    'CanUpdate',
    'IsCreateByMe',
    'IsWorkForMe',
    'Status',
    'Createur',
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
        
    
    
    
    
    
    
                    'duree' => [
            //'required'
            ],
        
    
    
                    'parent' => [
            //'required'
            ],
        
    
    
    
                    'has_child' => [
            //'required'
            ],
        
    
    
                    'description' => [
            //'required'
            ],
        
    
    
                    'validate' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'etats_actuel' => [
            //'required'
            ],
        
    
    
                    'description_actuel' => [
            //'required'
            ],
        
    
    
                    'ParentElements' => [
            //'required'
            ],
        
    
    
                    'AllEtats' => [
            //'required'
            ],
        
    
    
                    'CanUpdate' => [
            //'required'
            ],
        
    
    
                    'IsCreateByMe' => [
            //'required'
            ],
        
    
    
                    'IsWorkForMe' => [
            //'required'
            ],
        
    
    
                    'Status' => [
            //'required'
            ],
        
    
    
                    'Createur' => [
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

    
    
    
    
    
    
        'duree' => ['cette donnee est obligatoire'],

    
    
        'parent' => ['cette donnee est obligatoire'],

    
    
    
        'has_child' => ['cette donnee est obligatoire'],

    
    
        'description' => ['cette donnee est obligatoire'],

    
    
        'validate' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'etats_actuel' => ['cette donnee est obligatoire'],

    
    
        'description_actuel' => ['cette donnee est obligatoire'],

    
    
        'ParentElements' => ['cette donnee est obligatoire'],

    
    
        'AllEtats' => ['cette donnee est obligatoire'],

    
    
        'CanUpdate' => ['cette donnee est obligatoire'],

    
    
        'IsCreateByMe' => ['cette donnee est obligatoire'],

    
    
        'IsWorkForMe' => ['cette donnee est obligatoire'],

    
    
        'Status' => ['cette donnee est obligatoire'],

    
    
        'Createur' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Activites->libelle = $data['libelle'];
        
        }



    







    







    







    







    







    

        if(!empty($data['duree'])){
        
            $Activites->duree = $data['duree'];
        
        }



    







    

        if(!empty($data['parent'])){
        
            $Activites->parent = $data['parent'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Activites->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['has_child'])){
        
            $Activites->has_child = $data['has_child'];
        
        }



    







    

        if(!empty($data['description'])){
        
            $Activites->description = $data['description'];
        
        }



    







    

        if(!empty($data['validate'])){
        
            $Activites->validate = $data['validate'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Activites->type = $data['type'];
        
        }



    







    

        if(!empty($data['etats_actuel'])){
        
            $Activites->etats_actuel = $data['etats_actuel'];
        
        }



    







    

        if(!empty($data['description_actuel'])){
        
            $Activites->description_actuel = $data['description_actuel'];
        
        }



    







    

        if(!empty($data['ParentElements'])){
        
            $Activites->ParentElements = $data['ParentElements'];
        
        }



    







    

        if(!empty($data['AllEtats'])){
        
            $Activites->AllEtats = $data['AllEtats'];
        
        }



    







    

        if(!empty($data['CanUpdate'])){
        
            $Activites->CanUpdate = $data['CanUpdate'];
        
        }



    







    

        if(!empty($data['IsCreateByMe'])){
        
            $Activites->IsCreateByMe = $data['IsCreateByMe'];
        
        }



    







    

        if(!empty($data['IsWorkForMe'])){
        
            $Activites->IsWorkForMe = $data['IsWorkForMe'];
        
        }



    







    

        if(!empty($data['Status'])){
        
            $Activites->Status = $data['Status'];
        
        }



    







    

        if(!empty($data['Createur'])){
        
            $Activites->Createur = $data['Createur'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Activites->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Activites->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Activites->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ActiviteExtras') &&
method_exists('\App\Http\Extras\ActiviteExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ActiviteExtras::beforeSaveCreate($request,$Activites);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ActiviteExtras') &&
method_exists('\App\Http\Extras\ActiviteExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ActiviteExtras::canCreate($request, $Activites);
}catch (\Throwable $e){

}

}


if($canSave){
$Activites->save();
}else{
return response()->json($Activites, 200);
}

$Activites=Activite::find($Activites->id);
$newCrudData=[];

                $newCrudData['libelle']=$Activites->libelle;
                                $newCrudData['duree']=$Activites->duree;
                $newCrudData['parent']=$Activites->parent;
                $newCrudData['user_id']=$Activites->user_id;
                $newCrudData['has_child']=$Activites->has_child;
                $newCrudData['description']=$Activites->description;
                $newCrudData['validate']=$Activites->validate;
                $newCrudData['type']=$Activites->type;
                $newCrudData['etats_actuel']=$Activites->etats_actuel;
                $newCrudData['description_actuel']=$Activites->description_actuel;
                $newCrudData['ParentElements']=$Activites->ParentElements;
                $newCrudData['AllEtats']=$Activites->AllEtats;
                $newCrudData['CanUpdate']=$Activites->CanUpdate;
                $newCrudData['IsCreateByMe']=$Activites->IsCreateByMe;
                $newCrudData['IsWorkForMe']=$Activites->IsWorkForMe;
                $newCrudData['Status']=$Activites->Status;
                $newCrudData['Createur']=$Activites->Createur;
                $newCrudData['identifiants_sadge']=$Activites->identifiants_sadge;
                $newCrudData['creat_by']=$Activites->creat_by;
    
 try{ $newCrudData['user']=$Activites->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Activites','entite_cle' => $Activites->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Activites->toArray();




try{

foreach ($Activites->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Activite $Activites)
{
try{
$can=\App\Helpers\Helpers::can('Editer des activites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Activites->libelle;
                                $oldCrudData['duree']=$Activites->duree;
                $oldCrudData['parent']=$Activites->parent;
                $oldCrudData['user_id']=$Activites->user_id;
                $oldCrudData['has_child']=$Activites->has_child;
                $oldCrudData['description']=$Activites->description;
                $oldCrudData['validate']=$Activites->validate;
                $oldCrudData['type']=$Activites->type;
                $oldCrudData['etats_actuel']=$Activites->etats_actuel;
                $oldCrudData['description_actuel']=$Activites->description_actuel;
                $oldCrudData['ParentElements']=$Activites->ParentElements;
                $oldCrudData['AllEtats']=$Activites->AllEtats;
                $oldCrudData['CanUpdate']=$Activites->CanUpdate;
                $oldCrudData['IsCreateByMe']=$Activites->IsCreateByMe;
                $oldCrudData['IsWorkForMe']=$Activites->IsWorkForMe;
                $oldCrudData['Status']=$Activites->Status;
                $oldCrudData['Createur']=$Activites->Createur;
                $oldCrudData['identifiants_sadge']=$Activites->identifiants_sadge;
                $oldCrudData['creat_by']=$Activites->creat_by;
    
 try{ $oldCrudData['user']=$Activites->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "activites"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'duree',
    'parent',
    'user_id',
    'has_child',
    'description',
    'validate',
    'type',
    'etats_actuel',
    'description_actuel',
    'ParentElements',
    'AllEtats',
    'CanUpdate',
    'IsCreateByMe',
    'IsWorkForMe',
    'Status',
    'Createur',
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
        
    
    
    
    
    
    
                    'duree' => [
            //'required'
            ],
        
    
    
                    'parent' => [
            //'required'
            ],
        
    
    
    
                    'has_child' => [
            //'required'
            ],
        
    
    
                    'description' => [
            //'required'
            ],
        
    
    
                    'validate' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'etats_actuel' => [
            //'required'
            ],
        
    
    
                    'description_actuel' => [
            //'required'
            ],
        
    
    
                    'ParentElements' => [
            //'required'
            ],
        
    
    
                    'AllEtats' => [
            //'required'
            ],
        
    
    
                    'CanUpdate' => [
            //'required'
            ],
        
    
    
                    'IsCreateByMe' => [
            //'required'
            ],
        
    
    
                    'IsWorkForMe' => [
            //'required'
            ],
        
    
    
                    'Status' => [
            //'required'
            ],
        
    
    
                    'Createur' => [
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

    
    
    
    
    
    
        'duree' => ['cette donnee est obligatoire'],

    
    
        'parent' => ['cette donnee est obligatoire'],

    
    
    
        'has_child' => ['cette donnee est obligatoire'],

    
    
        'description' => ['cette donnee est obligatoire'],

    
    
        'validate' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'etats_actuel' => ['cette donnee est obligatoire'],

    
    
        'description_actuel' => ['cette donnee est obligatoire'],

    
    
        'ParentElements' => ['cette donnee est obligatoire'],

    
    
        'AllEtats' => ['cette donnee est obligatoire'],

    
    
        'CanUpdate' => ['cette donnee est obligatoire'],

    
    
        'IsCreateByMe' => ['cette donnee est obligatoire'],

    
    
        'IsWorkForMe' => ['cette donnee est obligatoire'],

    
    
        'Status' => ['cette donnee est obligatoire'],

    
    
        'Createur' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Activites->libelle = $data['libelle'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("duree",$data)){


        if(!empty($data['duree'])){
        
            $Activites->duree = $data['duree'];
        
        }

        }

    







    

        if(array_key_exists("parent",$data)){


        if(!empty($data['parent'])){
        
            $Activites->parent = $data['parent'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Activites->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("has_child",$data)){


        if(!empty($data['has_child'])){
        
            $Activites->has_child = $data['has_child'];
        
        }

        }

    







    

        if(array_key_exists("description",$data)){


        if(!empty($data['description'])){
        
            $Activites->description = $data['description'];
        
        }

        }

    







    

        if(array_key_exists("validate",$data)){


        if(!empty($data['validate'])){
        
            $Activites->validate = $data['validate'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Activites->type = $data['type'];
        
        }

        }

    







    

        if(array_key_exists("etats_actuel",$data)){


        if(!empty($data['etats_actuel'])){
        
            $Activites->etats_actuel = $data['etats_actuel'];
        
        }

        }

    







    

        if(array_key_exists("description_actuel",$data)){


        if(!empty($data['description_actuel'])){
        
            $Activites->description_actuel = $data['description_actuel'];
        
        }

        }

    







    

        if(array_key_exists("ParentElements",$data)){


        if(!empty($data['ParentElements'])){
        
            $Activites->ParentElements = $data['ParentElements'];
        
        }

        }

    







    

        if(array_key_exists("AllEtats",$data)){


        if(!empty($data['AllEtats'])){
        
            $Activites->AllEtats = $data['AllEtats'];
        
        }

        }

    







    

        if(array_key_exists("CanUpdate",$data)){


        if(!empty($data['CanUpdate'])){
        
            $Activites->CanUpdate = $data['CanUpdate'];
        
        }

        }

    







    

        if(array_key_exists("IsCreateByMe",$data)){


        if(!empty($data['IsCreateByMe'])){
        
            $Activites->IsCreateByMe = $data['IsCreateByMe'];
        
        }

        }

    







    

        if(array_key_exists("IsWorkForMe",$data)){


        if(!empty($data['IsWorkForMe'])){
        
            $Activites->IsWorkForMe = $data['IsWorkForMe'];
        
        }

        }

    







    

        if(array_key_exists("Status",$data)){


        if(!empty($data['Status'])){
        
            $Activites->Status = $data['Status'];
        
        }

        }

    







    

        if(array_key_exists("Createur",$data)){


        if(!empty($data['Createur'])){
        
            $Activites->Createur = $data['Createur'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Activites->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Activites->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Activites->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ActiviteExtras') &&
method_exists('\App\Http\Extras\ActiviteExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ActiviteExtras::beforeSaveUpdate($request,$Activites);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ActiviteExtras') &&
method_exists('\App\Http\Extras\ActiviteExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ActiviteExtras::canUpdate($request, $Activites);
}catch (\Throwable $e){

}

}


if($canSave){
$Activites->save();
}else{
return response()->json($Activites, 200);

}


$Activites=Activite::find($Activites->id);



$newCrudData=[];

                $newCrudData['libelle']=$Activites->libelle;
                                $newCrudData['duree']=$Activites->duree;
                $newCrudData['parent']=$Activites->parent;
                $newCrudData['user_id']=$Activites->user_id;
                $newCrudData['has_child']=$Activites->has_child;
                $newCrudData['description']=$Activites->description;
                $newCrudData['validate']=$Activites->validate;
                $newCrudData['type']=$Activites->type;
                $newCrudData['etats_actuel']=$Activites->etats_actuel;
                $newCrudData['description_actuel']=$Activites->description_actuel;
                $newCrudData['ParentElements']=$Activites->ParentElements;
                $newCrudData['AllEtats']=$Activites->AllEtats;
                $newCrudData['CanUpdate']=$Activites->CanUpdate;
                $newCrudData['IsCreateByMe']=$Activites->IsCreateByMe;
                $newCrudData['IsWorkForMe']=$Activites->IsWorkForMe;
                $newCrudData['Status']=$Activites->Status;
                $newCrudData['Createur']=$Activites->Createur;
                $newCrudData['identifiants_sadge']=$Activites->identifiants_sadge;
                $newCrudData['creat_by']=$Activites->creat_by;
    
 try{ $newCrudData['user']=$Activites->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Activites','entite_cle' => $Activites->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Activites->toArray();




try{

foreach ($Activites->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Activite $Activites)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des activites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Activites->libelle;
                                $newCrudData['duree']=$Activites->duree;
                $newCrudData['parent']=$Activites->parent;
                $newCrudData['user_id']=$Activites->user_id;
                $newCrudData['has_child']=$Activites->has_child;
                $newCrudData['description']=$Activites->description;
                $newCrudData['validate']=$Activites->validate;
                $newCrudData['type']=$Activites->type;
                $newCrudData['etats_actuel']=$Activites->etats_actuel;
                $newCrudData['description_actuel']=$Activites->description_actuel;
                $newCrudData['ParentElements']=$Activites->ParentElements;
                $newCrudData['AllEtats']=$Activites->AllEtats;
                $newCrudData['CanUpdate']=$Activites->CanUpdate;
                $newCrudData['IsCreateByMe']=$Activites->IsCreateByMe;
                $newCrudData['IsWorkForMe']=$Activites->IsWorkForMe;
                $newCrudData['Status']=$Activites->Status;
                $newCrudData['Createur']=$Activites->Createur;
                $newCrudData['identifiants_sadge']=$Activites->identifiants_sadge;
                $newCrudData['creat_by']=$Activites->creat_by;
    
 try{ $newCrudData['user']=$Activites->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Activites','entite_cle' => $Activites->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ActiviteExtras') &&
method_exists('\App\Http\Extras\ActiviteExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ActiviteExtras::canDelete($request, $Activites);
}catch (\Throwable $e){

}

}



if($canSave){
$Activites->delete();
}else{
return response()->json($Activites, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ActivitesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
