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
// use App\Repository\prod\ModelslistingsRepository;
use App\Models\Modelslisting;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



                use App\Models\Zone;
    
class ModelslistingController extends Controller
{

private $ModelslistingsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ModelslistingsRepository $ModelslistingsRepository
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
class_exists('\App\Http\Extras\ModelslistingExtras') &&
method_exists('\App\Http\Extras\ModelslistingExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ModelslistingExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Modelslisting::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ModelslistingExtras') &&
method_exists('\App\Http\Extras\ModelslistingExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ModelslistingExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('modelslistings',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ModelslistingExtras') &&
method_exists('\App\Http\Extras\ModelslistingExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ModelslistingExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  modelslistings reussi',
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
return response()->json(Modelslisting::count());
}
$data = QueryBuilder::for(Modelslisting::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('Libelle'),

    
    
    
    
    
            AllowedFilter::exact('postes'),

    
            AllowedFilter::exact('zone_id'),

    
            AllowedFilter::exact('faction'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('min_partage'),

    
            AllowedFilter::exact('Generate'),

    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('user_id_2'),

    
            AllowedFilter::exact('user_id_3'),

    
            AllowedFilter::exact('user_id_4'),

    
            AllowedFilter::exact('typelistings'),

    
            AllowedFilter::exact('horaires'),

    
            AllowedFilter::exact('directions'),

    
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

    
            AllowedSort::field('Libelle'),

    
    
    
    
    
            AllowedSort::field('postes'),

    
            AllowedSort::field('zone_id'),

    
            AllowedSort::field('faction'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('min_partage'),

    
            AllowedSort::field('Generate'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('user_id_2'),

    
            AllowedSort::field('user_id_3'),

    
            AllowedSort::field('user_id_4'),

    
            AllowedSort::field('typelistings'),

    
            AllowedSort::field('horaires'),

    
            AllowedSort::field('directions'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'homezones',
        

                'validations',
        

    
            'user',
        

                'zone',
        

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




$data = QueryBuilder::for(Modelslisting::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('Libelle'),

    
    
    
    
    
            AllowedFilter::exact('postes'),

    
            AllowedFilter::exact('zone_id'),

    
            AllowedFilter::exact('faction'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('min_partage'),

    
            AllowedFilter::exact('Generate'),

    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('user_id_2'),

    
            AllowedFilter::exact('user_id_3'),

    
            AllowedFilter::exact('user_id_4'),

    
            AllowedFilter::exact('typelistings'),

    
            AllowedFilter::exact('horaires'),

    
            AllowedFilter::exact('directions'),

    
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

    
            AllowedSort::field('Libelle'),

    
    
    
    
    
            AllowedSort::field('postes'),

    
            AllowedSort::field('zone_id'),

    
            AllowedSort::field('faction'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('min_partage'),

    
            AllowedSort::field('Generate'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('user_id_2'),

    
            AllowedSort::field('user_id_3'),

    
            AllowedSort::field('user_id_4'),

    
            AllowedSort::field('typelistings'),

    
            AllowedSort::field('horaires'),

    
            AllowedSort::field('directions'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'homezones',
        

                'validations',
        

                'user',
        

                'zone',
        

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



public function create(Request $request, Modelslisting $Modelslistings)
{


try{
$can=\App\Helpers\Helpers::can('Creer des modelslistings');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "modelslistings"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'Libelle',
    'extra_attributes',
    'deleted_at',
    'created_at',
    'updated_at',
    'postes',
    'zone_id',
    'faction',
    'user_id',
    'date_debut',
    'min_partage',
    'Generate',
    'etats',
    'user_id_2',
    'user_id_3',
    'user_id_4',
    'typelistings',
    'horaires',
    'directions',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'Libelle' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'postes' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
                    'faction' => [
            //'required'
            ],
        
    
    
    
                    'date_debut' => [
            //'required'
            ],
        
    
    
                    'min_partage' => [
            //'required'
            ],
        
    
    
                    'Generate' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'user_id_2' => [
            //'required'
            ],
        
    
    
                    'user_id_3' => [
            //'required'
            ],
        
    
    
                    'user_id_4' => [
            //'required'
            ],
        
    
    
                    'typelistings' => [
            //'required'
            ],
        
    
    
                    'horaires' => [
            //'required'
            ],
        
    
    
                    'directions' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'Libelle' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'postes' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
        'faction' => ['cette donnee est obligatoire'],

    
    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'min_partage' => ['cette donnee est obligatoire'],

    
    
        'Generate' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'user_id_2' => ['cette donnee est obligatoire'],

    
    
        'user_id_3' => ['cette donnee est obligatoire'],

    
    
        'user_id_4' => ['cette donnee est obligatoire'],

    
    
        'typelistings' => ['cette donnee est obligatoire'],

    
    
        'horaires' => ['cette donnee est obligatoire'],

    
    
        'directions' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['Libelle'])){
        
            $Modelslistings->Libelle = $data['Libelle'];
        
        }



    







    







    







    







    







    

        if(!empty($data['postes'])){
        
            $Modelslistings->postes = $data['postes'];
        
        }



    







    

        if(!empty($data['zone_id'])){
        
            $Modelslistings->zone_id = $data['zone_id'];
        
        }



    







    

        if(!empty($data['faction'])){
        
            $Modelslistings->faction = $data['faction'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Modelslistings->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['date_debut'])){
        
            $Modelslistings->date_debut = $data['date_debut'];
        
        }



    







    

        if(!empty($data['min_partage'])){
        
            $Modelslistings->min_partage = $data['min_partage'];
        
        }



    







    

        if(!empty($data['Generate'])){
        
            $Modelslistings->Generate = $data['Generate'];
        
        }



    







    

        if(!empty($data['etats'])){
        
            $Modelslistings->etats = $data['etats'];
        
        }



    







    

        if(!empty($data['user_id_2'])){
        
            $Modelslistings->user_id_2 = $data['user_id_2'];
        
        }



    







    

        if(!empty($data['user_id_3'])){
        
            $Modelslistings->user_id_3 = $data['user_id_3'];
        
        }



    







    

        if(!empty($data['user_id_4'])){
        
            $Modelslistings->user_id_4 = $data['user_id_4'];
        
        }



    







    

        if(!empty($data['typelistings'])){
        
            $Modelslistings->typelistings = $data['typelistings'];
        
        }



    







    

        if(!empty($data['horaires'])){
        
            $Modelslistings->horaires = $data['horaires'];
        
        }



    







    

        if(!empty($data['directions'])){
        
            $Modelslistings->directions = $data['directions'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Modelslistings->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Modelslistings->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Modelslistings->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ModelslistingExtras') &&
method_exists('\App\Http\Extras\ModelslistingExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ModelslistingExtras::beforeSaveCreate($request,$Modelslistings);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ModelslistingExtras') &&
method_exists('\App\Http\Extras\ModelslistingExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ModelslistingExtras::canCreate($request, $Modelslistings);
}catch (\Throwable $e){

}

}


if($canSave){
$Modelslistings->save();
}else{
return response()->json($Modelslistings, 200);
}

$Modelslistings=Modelslisting::find($Modelslistings->id);
$newCrudData=[];

                $newCrudData['Libelle']=$Modelslistings->Libelle;
                                $newCrudData['postes']=$Modelslistings->postes;
                $newCrudData['zone_id']=$Modelslistings->zone_id;
                $newCrudData['faction']=$Modelslistings->faction;
                $newCrudData['user_id']=$Modelslistings->user_id;
                $newCrudData['date_debut']=$Modelslistings->date_debut;
                $newCrudData['min_partage']=$Modelslistings->min_partage;
                $newCrudData['Generate']=$Modelslistings->Generate;
                $newCrudData['etats']=$Modelslistings->etats;
                $newCrudData['user_id_2']=$Modelslistings->user_id_2;
                $newCrudData['user_id_3']=$Modelslistings->user_id_3;
                $newCrudData['user_id_4']=$Modelslistings->user_id_4;
                $newCrudData['typelistings']=$Modelslistings->typelistings;
                $newCrudData['horaires']=$Modelslistings->horaires;
                $newCrudData['directions']=$Modelslistings->directions;
                $newCrudData['identifiants_sadge']=$Modelslistings->identifiants_sadge;
                $newCrudData['creat_by']=$Modelslistings->creat_by;
    
 try{ $newCrudData['user']=$Modelslistings->user->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Modelslistings->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Modelslistings','entite_cle' => $Modelslistings->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Modelslistings->toArray();




try{

foreach ($Modelslistings->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Modelslisting $Modelslistings)
{
try{
$can=\App\Helpers\Helpers::can('Editer des modelslistings');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['Libelle']=$Modelslistings->Libelle;
                                $oldCrudData['postes']=$Modelslistings->postes;
                $oldCrudData['zone_id']=$Modelslistings->zone_id;
                $oldCrudData['faction']=$Modelslistings->faction;
                $oldCrudData['user_id']=$Modelslistings->user_id;
                $oldCrudData['date_debut']=$Modelslistings->date_debut;
                $oldCrudData['min_partage']=$Modelslistings->min_partage;
                $oldCrudData['Generate']=$Modelslistings->Generate;
                $oldCrudData['etats']=$Modelslistings->etats;
                $oldCrudData['user_id_2']=$Modelslistings->user_id_2;
                $oldCrudData['user_id_3']=$Modelslistings->user_id_3;
                $oldCrudData['user_id_4']=$Modelslistings->user_id_4;
                $oldCrudData['typelistings']=$Modelslistings->typelistings;
                $oldCrudData['horaires']=$Modelslistings->horaires;
                $oldCrudData['directions']=$Modelslistings->directions;
                $oldCrudData['identifiants_sadge']=$Modelslistings->identifiants_sadge;
                $oldCrudData['creat_by']=$Modelslistings->creat_by;
    
 try{ $oldCrudData['user']=$Modelslistings->user->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['zone']=$Modelslistings->zone->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "modelslistings"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'Libelle',
    'extra_attributes',
    'deleted_at',
    'created_at',
    'updated_at',
    'postes',
    'zone_id',
    'faction',
    'user_id',
    'date_debut',
    'min_partage',
    'Generate',
    'etats',
    'user_id_2',
    'user_id_3',
    'user_id_4',
    'typelistings',
    'horaires',
    'directions',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'Libelle' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'postes' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
                    'faction' => [
            //'required'
            ],
        
    
    
    
                    'date_debut' => [
            //'required'
            ],
        
    
    
                    'min_partage' => [
            //'required'
            ],
        
    
    
                    'Generate' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'user_id_2' => [
            //'required'
            ],
        
    
    
                    'user_id_3' => [
            //'required'
            ],
        
    
    
                    'user_id_4' => [
            //'required'
            ],
        
    
    
                    'typelistings' => [
            //'required'
            ],
        
    
    
                    'horaires' => [
            //'required'
            ],
        
    
    
                    'directions' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'Libelle' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'postes' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
        'faction' => ['cette donnee est obligatoire'],

    
    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'min_partage' => ['cette donnee est obligatoire'],

    
    
        'Generate' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'user_id_2' => ['cette donnee est obligatoire'],

    
    
        'user_id_3' => ['cette donnee est obligatoire'],

    
    
        'user_id_4' => ['cette donnee est obligatoire'],

    
    
        'typelistings' => ['cette donnee est obligatoire'],

    
    
        'horaires' => ['cette donnee est obligatoire'],

    
    
        'directions' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("Libelle",$data)){


        if(!empty($data['Libelle'])){
        
            $Modelslistings->Libelle = $data['Libelle'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("postes",$data)){


        if(!empty($data['postes'])){
        
            $Modelslistings->postes = $data['postes'];
        
        }

        }

    







    

        if(array_key_exists("zone_id",$data)){


        if(!empty($data['zone_id'])){
        
            $Modelslistings->zone_id = $data['zone_id'];
        
        }

        }

    







    

        if(array_key_exists("faction",$data)){


        if(!empty($data['faction'])){
        
            $Modelslistings->faction = $data['faction'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Modelslistings->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("date_debut",$data)){


        if(!empty($data['date_debut'])){
        
            $Modelslistings->date_debut = $data['date_debut'];
        
        }

        }

    







    

        if(array_key_exists("min_partage",$data)){


        if(!empty($data['min_partage'])){
        
            $Modelslistings->min_partage = $data['min_partage'];
        
        }

        }

    







    

        if(array_key_exists("Generate",$data)){


        if(!empty($data['Generate'])){
        
            $Modelslistings->Generate = $data['Generate'];
        
        }

        }

    







    

        if(array_key_exists("etats",$data)){


        if(!empty($data['etats'])){
        
            $Modelslistings->etats = $data['etats'];
        
        }

        }

    







    

        if(array_key_exists("user_id_2",$data)){


        if(!empty($data['user_id_2'])){
        
            $Modelslistings->user_id_2 = $data['user_id_2'];
        
        }

        }

    







    

        if(array_key_exists("user_id_3",$data)){


        if(!empty($data['user_id_3'])){
        
            $Modelslistings->user_id_3 = $data['user_id_3'];
        
        }

        }

    







    

        if(array_key_exists("user_id_4",$data)){


        if(!empty($data['user_id_4'])){
        
            $Modelslistings->user_id_4 = $data['user_id_4'];
        
        }

        }

    







    

        if(array_key_exists("typelistings",$data)){


        if(!empty($data['typelistings'])){
        
            $Modelslistings->typelistings = $data['typelistings'];
        
        }

        }

    







    

        if(array_key_exists("horaires",$data)){


        if(!empty($data['horaires'])){
        
            $Modelslistings->horaires = $data['horaires'];
        
        }

        }

    







    

        if(array_key_exists("directions",$data)){


        if(!empty($data['directions'])){
        
            $Modelslistings->directions = $data['directions'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Modelslistings->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Modelslistings->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Modelslistings->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ModelslistingExtras') &&
method_exists('\App\Http\Extras\ModelslistingExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ModelslistingExtras::beforeSaveUpdate($request,$Modelslistings);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ModelslistingExtras') &&
method_exists('\App\Http\Extras\ModelslistingExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ModelslistingExtras::canUpdate($request, $Modelslistings);
}catch (\Throwable $e){

}

}


if($canSave){
$Modelslistings->save();
}else{
return response()->json($Modelslistings, 200);

}


$Modelslistings=Modelslisting::find($Modelslistings->id);



$newCrudData=[];

                $newCrudData['Libelle']=$Modelslistings->Libelle;
                                $newCrudData['postes']=$Modelslistings->postes;
                $newCrudData['zone_id']=$Modelslistings->zone_id;
                $newCrudData['faction']=$Modelslistings->faction;
                $newCrudData['user_id']=$Modelslistings->user_id;
                $newCrudData['date_debut']=$Modelslistings->date_debut;
                $newCrudData['min_partage']=$Modelslistings->min_partage;
                $newCrudData['Generate']=$Modelslistings->Generate;
                $newCrudData['etats']=$Modelslistings->etats;
                $newCrudData['user_id_2']=$Modelslistings->user_id_2;
                $newCrudData['user_id_3']=$Modelslistings->user_id_3;
                $newCrudData['user_id_4']=$Modelslistings->user_id_4;
                $newCrudData['typelistings']=$Modelslistings->typelistings;
                $newCrudData['horaires']=$Modelslistings->horaires;
                $newCrudData['directions']=$Modelslistings->directions;
                $newCrudData['identifiants_sadge']=$Modelslistings->identifiants_sadge;
                $newCrudData['creat_by']=$Modelslistings->creat_by;
    
 try{ $newCrudData['user']=$Modelslistings->user->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Modelslistings->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Modelslistings','entite_cle' => $Modelslistings->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Modelslistings->toArray();




try{

foreach ($Modelslistings->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Modelslisting $Modelslistings)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des modelslistings');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['Libelle']=$Modelslistings->Libelle;
                                $newCrudData['postes']=$Modelslistings->postes;
                $newCrudData['zone_id']=$Modelslistings->zone_id;
                $newCrudData['faction']=$Modelslistings->faction;
                $newCrudData['user_id']=$Modelslistings->user_id;
                $newCrudData['date_debut']=$Modelslistings->date_debut;
                $newCrudData['min_partage']=$Modelslistings->min_partage;
                $newCrudData['Generate']=$Modelslistings->Generate;
                $newCrudData['etats']=$Modelslistings->etats;
                $newCrudData['user_id_2']=$Modelslistings->user_id_2;
                $newCrudData['user_id_3']=$Modelslistings->user_id_3;
                $newCrudData['user_id_4']=$Modelslistings->user_id_4;
                $newCrudData['typelistings']=$Modelslistings->typelistings;
                $newCrudData['horaires']=$Modelslistings->horaires;
                $newCrudData['directions']=$Modelslistings->directions;
                $newCrudData['identifiants_sadge']=$Modelslistings->identifiants_sadge;
                $newCrudData['creat_by']=$Modelslistings->creat_by;
    
 try{ $newCrudData['user']=$Modelslistings->user->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Modelslistings->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Modelslistings','entite_cle' => $Modelslistings->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ModelslistingExtras') &&
method_exists('\App\Http\Extras\ModelslistingExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ModelslistingExtras::canDelete($request, $Modelslistings);
}catch (\Throwable $e){

}

}



if($canSave){
$Modelslistings->delete();
}else{
return response()->json($Modelslistings, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ModelslistingsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
