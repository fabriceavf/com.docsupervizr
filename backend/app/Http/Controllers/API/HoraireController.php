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
// use App\Repository\prod\HorairesRepository;
use App\Models\Horaire;
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
    
class HoraireController extends Controller
{

private $HorairesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\HorairesRepository $HorairesRepository
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
class_exists('\App\Http\Extras\HoraireExtras') &&
method_exists('\App\Http\Extras\HoraireExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\HoraireExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Horaire::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\HoraireExtras') &&
method_exists('\App\Http\Extras\HoraireExtras', 'filterAgGridQuery')
){
\App\Http\Extras\HoraireExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('horaires',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\HoraireExtras') &&
method_exists('\App\Http\Extras\HoraireExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\HoraireExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  horaires reussi',
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
return response()->json(Horaire::count());
}
$data = QueryBuilder::for(Horaire::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
            AllowedFilter::exact('tolerance'),

    
            AllowedFilter::exact('type'),

    
    
    
    
            AllowedFilter::exact('parent'),

    
            AllowedFilter::exact('parentId'),

    
            AllowedFilter::exact('vol_horaire_min'),

    
            AllowedFilter::exact('nmb_pointage_min'),

    
            AllowedFilter::exact('poste_id'),

    
    
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

    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
            AllowedSort::field('tolerance'),

    
            AllowedSort::field('type'),

    
    
    
    
            AllowedSort::field('parent'),

    
            AllowedSort::field('parentId'),

    
            AllowedSort::field('vol_horaire_min'),

    
            AllowedSort::field('nmb_pointage_min'),

    
            AllowedSort::field('poste_id'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
            'horaireagents',
        

                'pointages',
        

                'programmes',
        

    
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




$data = QueryBuilder::for(Horaire::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
            AllowedFilter::exact('tolerance'),

    
            AllowedFilter::exact('type'),

    
    
    
    
            AllowedFilter::exact('parent'),

    
            AllowedFilter::exact('parentId'),

    
            AllowedFilter::exact('vol_horaire_min'),

    
            AllowedFilter::exact('nmb_pointage_min'),

    
            AllowedFilter::exact('poste_id'),

    
    
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

    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
            AllowedSort::field('tolerance'),

    
            AllowedSort::field('type'),

    
    
    
    
            AllowedSort::field('parent'),

    
            AllowedSort::field('parentId'),

    
            AllowedSort::field('vol_horaire_min'),

    
            AllowedSort::field('nmb_pointage_min'),

    
            AllowedSort::field('poste_id'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
            'horaireagents',
        

                'pointages',
        

                'programmes',
        

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



public function create(Request $request, Horaire $Horaires)
{


try{
$can=\App\Helpers\Helpers::can('Creer des horaires');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "horaires"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'debut',
    'fin',
    'tolerance',
    'type',
    'extra_attributes',
    'created_at',
    'updated_at',
    'parent',
    'parentId',
    'vol_horaire_min',
    'nmb_pointage_min',
    'poste_id',
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
        
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    
    
                    'tolerance' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
    
    
    
                    'parent' => [
            //'required'
            ],
        
    
    
                    'parentId' => [
            //'required'
            ],
        
    
    
                    'vol_horaire_min' => [
            //'required'
            ],
        
    
    
                    'nmb_pointage_min' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
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

    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
    
        'tolerance' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'parent' => ['cette donnee est obligatoire'],

    
    
        'parentId' => ['cette donnee est obligatoire'],

    
    
        'vol_horaire_min' => ['cette donnee est obligatoire'],

    
    
        'nmb_pointage_min' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Horaires->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['debut'])){
        
            $Horaires->debut = $data['debut'];
        
        }



    







    

        if(!empty($data['fin'])){
        
            $Horaires->fin = $data['fin'];
        
        }



    







    

        if(!empty($data['tolerance'])){
        
            $Horaires->tolerance = $data['tolerance'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Horaires->type = $data['type'];
        
        }



    







    







    







    







    

        if(!empty($data['parent'])){
        
            $Horaires->parent = $data['parent'];
        
        }



    







    

        if(!empty($data['parentId'])){
        
            $Horaires->parentId = $data['parentId'];
        
        }



    







    

        if(!empty($data['vol_horaire_min'])){
        
            $Horaires->vol_horaire_min = $data['vol_horaire_min'];
        
        }



    







    

        if(!empty($data['nmb_pointage_min'])){
        
            $Horaires->nmb_pointage_min = $data['nmb_pointage_min'];
        
        }



    







    

        if(!empty($data['poste_id'])){
        
            $Horaires->poste_id = $data['poste_id'];
        
        }



    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Horaires->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Horaires->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Horaires->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\HoraireExtras') &&
method_exists('\App\Http\Extras\HoraireExtras', 'beforeSaveCreate')
){
\App\Http\Extras\HoraireExtras::beforeSaveCreate($request,$Horaires);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\HoraireExtras') &&
method_exists('\App\Http\Extras\HoraireExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\HoraireExtras::canCreate($request, $Horaires);
}catch (\Throwable $e){

}

}


if($canSave){
$Horaires->save();
}else{
return response()->json($Horaires, 200);
}

$Horaires=Horaire::find($Horaires->id);
$newCrudData=[];

                $newCrudData['libelle']=$Horaires->libelle;
                $newCrudData['debut']=$Horaires->debut;
                $newCrudData['fin']=$Horaires->fin;
                $newCrudData['tolerance']=$Horaires->tolerance;
                $newCrudData['type']=$Horaires->type;
                            $newCrudData['parent']=$Horaires->parent;
                $newCrudData['parentId']=$Horaires->parentId;
                $newCrudData['vol_horaire_min']=$Horaires->vol_horaire_min;
                $newCrudData['nmb_pointage_min']=$Horaires->nmb_pointage_min;
                $newCrudData['poste_id']=$Horaires->poste_id;
                    $newCrudData['identifiants_sadge']=$Horaires->identifiants_sadge;
                $newCrudData['creat_by']=$Horaires->creat_by;
    
 try{ $newCrudData['poste']=$Horaires->poste->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Horaires','entite_cle' => $Horaires->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Horaires->toArray();




try{

foreach ($Horaires->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Horaire $Horaires)
{
try{
$can=\App\Helpers\Helpers::can('Editer des horaires');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Horaires->libelle;
                $oldCrudData['debut']=$Horaires->debut;
                $oldCrudData['fin']=$Horaires->fin;
                $oldCrudData['tolerance']=$Horaires->tolerance;
                $oldCrudData['type']=$Horaires->type;
                            $oldCrudData['parent']=$Horaires->parent;
                $oldCrudData['parentId']=$Horaires->parentId;
                $oldCrudData['vol_horaire_min']=$Horaires->vol_horaire_min;
                $oldCrudData['nmb_pointage_min']=$Horaires->nmb_pointage_min;
                $oldCrudData['poste_id']=$Horaires->poste_id;
                    $oldCrudData['identifiants_sadge']=$Horaires->identifiants_sadge;
                $oldCrudData['creat_by']=$Horaires->creat_by;
    
 try{ $oldCrudData['poste']=$Horaires->poste->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "horaires"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'debut',
    'fin',
    'tolerance',
    'type',
    'extra_attributes',
    'created_at',
    'updated_at',
    'parent',
    'parentId',
    'vol_horaire_min',
    'nmb_pointage_min',
    'poste_id',
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
        
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    
    
                    'tolerance' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
    
    
    
                    'parent' => [
            //'required'
            ],
        
    
    
                    'parentId' => [
            //'required'
            ],
        
    
    
                    'vol_horaire_min' => [
            //'required'
            ],
        
    
    
                    'nmb_pointage_min' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
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

    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
    
        'tolerance' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'parent' => ['cette donnee est obligatoire'],

    
    
        'parentId' => ['cette donnee est obligatoire'],

    
    
        'vol_horaire_min' => ['cette donnee est obligatoire'],

    
    
        'nmb_pointage_min' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Horaires->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("debut",$data)){


        if(!empty($data['debut'])){
        
            $Horaires->debut = $data['debut'];
        
        }

        }

    







    

        if(array_key_exists("fin",$data)){


        if(!empty($data['fin'])){
        
            $Horaires->fin = $data['fin'];
        
        }

        }

    







    

        if(array_key_exists("tolerance",$data)){


        if(!empty($data['tolerance'])){
        
            $Horaires->tolerance = $data['tolerance'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Horaires->type = $data['type'];
        
        }

        }

    







    







    







    







    

        if(array_key_exists("parent",$data)){


        if(!empty($data['parent'])){
        
            $Horaires->parent = $data['parent'];
        
        }

        }

    







    

        if(array_key_exists("parentId",$data)){


        if(!empty($data['parentId'])){
        
            $Horaires->parentId = $data['parentId'];
        
        }

        }

    







    

        if(array_key_exists("vol_horaire_min",$data)){


        if(!empty($data['vol_horaire_min'])){
        
            $Horaires->vol_horaire_min = $data['vol_horaire_min'];
        
        }

        }

    







    

        if(array_key_exists("nmb_pointage_min",$data)){


        if(!empty($data['nmb_pointage_min'])){
        
            $Horaires->nmb_pointage_min = $data['nmb_pointage_min'];
        
        }

        }

    







    

        if(array_key_exists("poste_id",$data)){


        if(!empty($data['poste_id'])){
        
            $Horaires->poste_id = $data['poste_id'];
        
        }

        }

    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Horaires->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Horaires->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Horaires->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\HoraireExtras') &&
method_exists('\App\Http\Extras\HoraireExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\HoraireExtras::beforeSaveUpdate($request,$Horaires);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\HoraireExtras') &&
method_exists('\App\Http\Extras\HoraireExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\HoraireExtras::canUpdate($request, $Horaires);
}catch (\Throwable $e){

}

}


if($canSave){
$Horaires->save();
}else{
return response()->json($Horaires, 200);

}


$Horaires=Horaire::find($Horaires->id);



$newCrudData=[];

                $newCrudData['libelle']=$Horaires->libelle;
                $newCrudData['debut']=$Horaires->debut;
                $newCrudData['fin']=$Horaires->fin;
                $newCrudData['tolerance']=$Horaires->tolerance;
                $newCrudData['type']=$Horaires->type;
                            $newCrudData['parent']=$Horaires->parent;
                $newCrudData['parentId']=$Horaires->parentId;
                $newCrudData['vol_horaire_min']=$Horaires->vol_horaire_min;
                $newCrudData['nmb_pointage_min']=$Horaires->nmb_pointage_min;
                $newCrudData['poste_id']=$Horaires->poste_id;
                    $newCrudData['identifiants_sadge']=$Horaires->identifiants_sadge;
                $newCrudData['creat_by']=$Horaires->creat_by;
    
 try{ $newCrudData['poste']=$Horaires->poste->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Horaires','entite_cle' => $Horaires->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Horaires->toArray();




try{

foreach ($Horaires->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Horaire $Horaires)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des horaires');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Horaires->libelle;
                $newCrudData['debut']=$Horaires->debut;
                $newCrudData['fin']=$Horaires->fin;
                $newCrudData['tolerance']=$Horaires->tolerance;
                $newCrudData['type']=$Horaires->type;
                            $newCrudData['parent']=$Horaires->parent;
                $newCrudData['parentId']=$Horaires->parentId;
                $newCrudData['vol_horaire_min']=$Horaires->vol_horaire_min;
                $newCrudData['nmb_pointage_min']=$Horaires->nmb_pointage_min;
                $newCrudData['poste_id']=$Horaires->poste_id;
                    $newCrudData['identifiants_sadge']=$Horaires->identifiants_sadge;
                $newCrudData['creat_by']=$Horaires->creat_by;
    
 try{ $newCrudData['poste']=$Horaires->poste->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Horaires','entite_cle' => $Horaires->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\HoraireExtras') &&
method_exists('\App\Http\Extras\HoraireExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\HoraireExtras::canDelete($request, $Horaires);
}catch (\Throwable $e){

}

}



if($canSave){
$Horaires->delete();
}else{
return response()->json($Horaires, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\HorairesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
