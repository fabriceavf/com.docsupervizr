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
// use App\Repository\prod\AbscencesRepository;
use App\Models\Abscence;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Typesabscence;
        
class AbscenceController extends Controller
{

private $AbscencesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\AbscencesRepository $AbscencesRepository
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
class_exists('\App\Http\Extras\AbscenceExtras') &&
method_exists('\App\Http\Extras\AbscenceExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\AbscenceExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Abscence::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\AbscenceExtras') &&
method_exists('\App\Http\Extras\AbscenceExtras', 'filterAgGridQuery')
){
\App\Http\Extras\AbscenceExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('abscences',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\AbscenceExtras') &&
method_exists('\App\Http\Extras\AbscenceExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\AbscenceExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  abscences reussi',
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
return response()->json(Abscence::count());
}
$data = QueryBuilder::for(Abscence::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('raison'),

    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('typesabscence_id'),

    
    
    
    
            AllowedFilter::exact('valide'),

    
    
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

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('raison'),

    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('typesabscence_id'),

    
    
    
    
            AllowedSort::field('valide'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([

            'typesabscence',
        

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




$data = QueryBuilder::for(Abscence::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('raison'),

    
            AllowedFilter::exact('debut'),

    
            AllowedFilter::exact('fin'),

    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('typesabscence_id'),

    
    
    
    
            AllowedFilter::exact('valide'),

    
    
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

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('raison'),

    
            AllowedSort::field('debut'),

    
            AllowedSort::field('fin'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('typesabscence_id'),

    
    
    
    
            AllowedSort::field('valide'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'typesabscence',
        

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



public function create(Request $request, Abscence $Abscences)
{


try{
$can=\App\Helpers\Helpers::can('Creer des abscences');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "abscences"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'raison',
    'debut',
    'fin',
    'etats',
    'typesabscence_id',
    'extra_attributes',
    'created_at',
    'updated_at',
    'valide',
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
    
    
    
                    'raison' => [
            //'required'
            ],
        
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'typesabscence_id' => [
            //'required'
            ],
        
    
    
    
    
    
                    'valide' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
    
        'raison' => ['cette donnee est obligatoire'],

    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'typesabscence_id' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'valide' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['user_id'])){
        
            $Abscences->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['raison'])){
        
            $Abscences->raison = $data['raison'];
        
        }



    







    

        if(!empty($data['debut'])){
        
            $Abscences->debut = $data['debut'];
        
        }



    







    

        if(!empty($data['fin'])){
        
            $Abscences->fin = $data['fin'];
        
        }



    







    

        if(!empty($data['etats'])){
        
            $Abscences->etats = $data['etats'];
        
        }



    







    

        if(!empty($data['typesabscence_id'])){
        
            $Abscences->typesabscence_id = $data['typesabscence_id'];
        
        }



    







    







    







    







    

        if(!empty($data['valide'])){
        
            $Abscences->valide = $data['valide'];
        
        }



    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Abscences->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Abscences->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Abscences->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\AbscenceExtras') &&
method_exists('\App\Http\Extras\AbscenceExtras', 'beforeSaveCreate')
){
\App\Http\Extras\AbscenceExtras::beforeSaveCreate($request,$Abscences);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\AbscenceExtras') &&
method_exists('\App\Http\Extras\AbscenceExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\AbscenceExtras::canCreate($request, $Abscences);
}catch (\Throwable $e){

}

}


if($canSave){
$Abscences->save();
}else{
return response()->json($Abscences, 200);
}

$Abscences=Abscence::find($Abscences->id);
$newCrudData=[];

                $newCrudData['user_id']=$Abscences->user_id;
                $newCrudData['raison']=$Abscences->raison;
                $newCrudData['debut']=$Abscences->debut;
                $newCrudData['fin']=$Abscences->fin;
                $newCrudData['etats']=$Abscences->etats;
                $newCrudData['typesabscence_id']=$Abscences->typesabscence_id;
                            $newCrudData['valide']=$Abscences->valide;
                    $newCrudData['identifiants_sadge']=$Abscences->identifiants_sadge;
                $newCrudData['creat_by']=$Abscences->creat_by;
    
 try{ $newCrudData['typesabscence']=$Abscences->typesabscence->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Abscences->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Abscences','entite_cle' => $Abscences->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Abscences->toArray();




try{

foreach ($Abscences->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Abscence $Abscences)
{
try{
$can=\App\Helpers\Helpers::can('Editer des abscences');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['user_id']=$Abscences->user_id;
                $oldCrudData['raison']=$Abscences->raison;
                $oldCrudData['debut']=$Abscences->debut;
                $oldCrudData['fin']=$Abscences->fin;
                $oldCrudData['etats']=$Abscences->etats;
                $oldCrudData['typesabscence_id']=$Abscences->typesabscence_id;
                            $oldCrudData['valide']=$Abscences->valide;
                    $oldCrudData['identifiants_sadge']=$Abscences->identifiants_sadge;
                $oldCrudData['creat_by']=$Abscences->creat_by;
    
 try{ $oldCrudData['typesabscence']=$Abscences->typesabscence->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Abscences->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "abscences"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'raison',
    'debut',
    'fin',
    'etats',
    'typesabscence_id',
    'extra_attributes',
    'created_at',
    'updated_at',
    'valide',
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
    
    
    
                    'raison' => [
            //'required'
            ],
        
    
    
                    'debut' => [
            //'required'
            ],
        
    
    
                    'fin' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'typesabscence_id' => [
            //'required'
            ],
        
    
    
    
    
    
                    'valide' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
    
        'raison' => ['cette donnee est obligatoire'],

    
    
        'debut' => ['cette donnee est obligatoire'],

    
    
        'fin' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'typesabscence_id' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'valide' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Abscences->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("raison",$data)){


        if(!empty($data['raison'])){
        
            $Abscences->raison = $data['raison'];
        
        }

        }

    







    

        if(array_key_exists("debut",$data)){


        if(!empty($data['debut'])){
        
            $Abscences->debut = $data['debut'];
        
        }

        }

    







    

        if(array_key_exists("fin",$data)){


        if(!empty($data['fin'])){
        
            $Abscences->fin = $data['fin'];
        
        }

        }

    







    

        if(array_key_exists("etats",$data)){


        if(!empty($data['etats'])){
        
            $Abscences->etats = $data['etats'];
        
        }

        }

    







    

        if(array_key_exists("typesabscence_id",$data)){


        if(!empty($data['typesabscence_id'])){
        
            $Abscences->typesabscence_id = $data['typesabscence_id'];
        
        }

        }

    







    







    







    







    

        if(array_key_exists("valide",$data)){


        if(!empty($data['valide'])){
        
            $Abscences->valide = $data['valide'];
        
        }

        }

    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Abscences->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Abscences->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Abscences->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\AbscenceExtras') &&
method_exists('\App\Http\Extras\AbscenceExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\AbscenceExtras::beforeSaveUpdate($request,$Abscences);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\AbscenceExtras') &&
method_exists('\App\Http\Extras\AbscenceExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\AbscenceExtras::canUpdate($request, $Abscences);
}catch (\Throwable $e){

}

}


if($canSave){
$Abscences->save();
}else{
return response()->json($Abscences, 200);

}


$Abscences=Abscence::find($Abscences->id);



$newCrudData=[];

                $newCrudData['user_id']=$Abscences->user_id;
                $newCrudData['raison']=$Abscences->raison;
                $newCrudData['debut']=$Abscences->debut;
                $newCrudData['fin']=$Abscences->fin;
                $newCrudData['etats']=$Abscences->etats;
                $newCrudData['typesabscence_id']=$Abscences->typesabscence_id;
                            $newCrudData['valide']=$Abscences->valide;
                    $newCrudData['identifiants_sadge']=$Abscences->identifiants_sadge;
                $newCrudData['creat_by']=$Abscences->creat_by;
    
 try{ $newCrudData['typesabscence']=$Abscences->typesabscence->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Abscences->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Abscences','entite_cle' => $Abscences->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Abscences->toArray();




try{

foreach ($Abscences->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Abscence $Abscences)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des abscences');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['user_id']=$Abscences->user_id;
                $newCrudData['raison']=$Abscences->raison;
                $newCrudData['debut']=$Abscences->debut;
                $newCrudData['fin']=$Abscences->fin;
                $newCrudData['etats']=$Abscences->etats;
                $newCrudData['typesabscence_id']=$Abscences->typesabscence_id;
                            $newCrudData['valide']=$Abscences->valide;
                    $newCrudData['identifiants_sadge']=$Abscences->identifiants_sadge;
                $newCrudData['creat_by']=$Abscences->creat_by;
    
 try{ $newCrudData['typesabscence']=$Abscences->typesabscence->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Abscences->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Abscences','entite_cle' => $Abscences->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\AbscenceExtras') &&
method_exists('\App\Http\Extras\AbscenceExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\AbscenceExtras::canDelete($request, $Abscences);
}catch (\Throwable $e){

}

}



if($canSave){
$Abscences->delete();
}else{
return response()->json($Abscences, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\AbscencesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
