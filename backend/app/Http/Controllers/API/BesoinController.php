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
// use App\Repository\prod\BesoinsRepository;
use App\Models\Besoin;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Projet;
    
class BesoinController extends Controller
{

private $BesoinsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\BesoinsRepository $BesoinsRepository
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
class_exists('\App\Http\Extras\BesoinExtras') &&
method_exists('\App\Http\Extras\BesoinExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\BesoinExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Besoin::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\BesoinExtras') &&
method_exists('\App\Http\Extras\BesoinExtras', 'filterAgGridQuery')
){
\App\Http\Extras\BesoinExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('besoins',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\BesoinExtras') &&
method_exists('\App\Http\Extras\BesoinExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\BesoinExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  besoins reussi',
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
return response()->json(Besoin::count());
}
$data = QueryBuilder::for(Besoin::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('descriptions'),

    
            AllowedFilter::exact('debut_previsionnel'),

    
            AllowedFilter::exact('fin_previsionnel'),

    
            AllowedFilter::exact('debut_reel'),

    
            AllowedFilter::exact('fin_reel'),

    
            AllowedFilter::exact('projet_id'),

    
            AllowedFilter::exact('evaluation'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('valider'),

    
    
    
    
    
            AllowedFilter::exact('Child'),

    
            AllowedFilter::exact('ChildPrevu'),

    
            AllowedFilter::exact('ChildImprevu'),

    
            AllowedFilter::exact('ChildReussi'),

    
            AllowedFilter::exact('ChildBloquer'),

    
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

    
            AllowedSort::field('descriptions'),

    
            AllowedSort::field('debut_previsionnel'),

    
            AllowedSort::field('fin_previsionnel'),

    
            AllowedSort::field('debut_reel'),

    
            AllowedSort::field('fin_reel'),

    
            AllowedSort::field('projet_id'),

    
            AllowedSort::field('evaluation'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('valider'),

    
    
    
    
    
            AllowedSort::field('Child'),

    
            AllowedSort::field('ChildPrevu'),

    
            AllowedSort::field('ChildImprevu'),

    
            AllowedSort::field('ChildReussi'),

    
            AllowedSort::field('ChildBloquer'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([
            'actionsprevisionelles',
        

    
            'projet',
        

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




$data = QueryBuilder::for(Besoin::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('descriptions'),

    
            AllowedFilter::exact('debut_previsionnel'),

    
            AllowedFilter::exact('fin_previsionnel'),

    
            AllowedFilter::exact('debut_reel'),

    
            AllowedFilter::exact('fin_reel'),

    
            AllowedFilter::exact('projet_id'),

    
            AllowedFilter::exact('evaluation'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('valider'),

    
    
    
    
    
            AllowedFilter::exact('Child'),

    
            AllowedFilter::exact('ChildPrevu'),

    
            AllowedFilter::exact('ChildImprevu'),

    
            AllowedFilter::exact('ChildReussi'),

    
            AllowedFilter::exact('ChildBloquer'),

    
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

    
            AllowedSort::field('descriptions'),

    
            AllowedSort::field('debut_previsionnel'),

    
            AllowedSort::field('fin_previsionnel'),

    
            AllowedSort::field('debut_reel'),

    
            AllowedSort::field('fin_reel'),

    
            AllowedSort::field('projet_id'),

    
            AllowedSort::field('evaluation'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('valider'),

    
    
    
    
    
            AllowedSort::field('Child'),

    
            AllowedSort::field('ChildPrevu'),

    
            AllowedSort::field('ChildImprevu'),

    
            AllowedSort::field('ChildReussi'),

    
            AllowedSort::field('ChildBloquer'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([
            'actionsprevisionelles',
        

                'projet',
        

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



public function create(Request $request, Besoin $Besoins)
{


try{
$can=\App\Helpers\Helpers::can('Creer des besoins');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "besoins"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'descriptions',
    'debut_previsionnel',
    'fin_previsionnel',
    'debut_reel',
    'fin_reel',
    'projet_id',
    'evaluation',
    'creat_by',
    'valider',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'Child',
    'ChildPrevu',
    'ChildImprevu',
    'ChildReussi',
    'ChildBloquer',
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
        
    
    
                    'descriptions' => [
            //'required'
            ],
        
    
    
                    'debut_previsionnel' => [
            //'required'
            ],
        
    
    
                    'fin_previsionnel' => [
            //'required'
            ],
        
    
    
                    'debut_reel' => [
            //'required'
            ],
        
    
    
                    'fin_reel' => [
            //'required'
            ],
        
    
    
                    'projet_id' => [
            //'required'
            ],
        
    
    
                    'evaluation' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'valider' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'Child' => [
            //'required'
            ],
        
    
    
                    'ChildPrevu' => [
            //'required'
            ],
        
    
    
                    'ChildImprevu' => [
            //'required'
            ],
        
    
    
                    'ChildReussi' => [
            //'required'
            ],
        
    
    
                    'ChildBloquer' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'descriptions' => ['cette donnee est obligatoire'],

    
    
        'debut_previsionnel' => ['cette donnee est obligatoire'],

    
    
        'fin_previsionnel' => ['cette donnee est obligatoire'],

    
    
        'debut_reel' => ['cette donnee est obligatoire'],

    
    
        'fin_reel' => ['cette donnee est obligatoire'],

    
    
        'projet_id' => ['cette donnee est obligatoire'],

    
    
        'evaluation' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'valider' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'Child' => ['cette donnee est obligatoire'],

    
    
        'ChildPrevu' => ['cette donnee est obligatoire'],

    
    
        'ChildImprevu' => ['cette donnee est obligatoire'],

    
    
        'ChildReussi' => ['cette donnee est obligatoire'],

    
    
        'ChildBloquer' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Besoins->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['descriptions'])){
        
            $Besoins->descriptions = $data['descriptions'];
        
        }



    







    

        if(!empty($data['debut_previsionnel'])){
        
            $Besoins->debut_previsionnel = $data['debut_previsionnel'];
        
        }



    







    

        if(!empty($data['fin_previsionnel'])){
        
            $Besoins->fin_previsionnel = $data['fin_previsionnel'];
        
        }



    







    

        if(!empty($data['debut_reel'])){
        
            $Besoins->debut_reel = $data['debut_reel'];
        
        }



    







    

        if(!empty($data['fin_reel'])){
        
            $Besoins->fin_reel = $data['fin_reel'];
        
        }



    







    

        if(!empty($data['projet_id'])){
        
            $Besoins->projet_id = $data['projet_id'];
        
        }



    







    

        if(!empty($data['evaluation'])){
        
            $Besoins->evaluation = $data['evaluation'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Besoins->creat_by = $data['creat_by'];
        
        }



    







    

        if(!empty($data['valider'])){
        
            $Besoins->valider = $data['valider'];
        
        }



    







    







    







    







    







    

        if(!empty($data['Child'])){
        
            $Besoins->Child = $data['Child'];
        
        }



    







    

        if(!empty($data['ChildPrevu'])){
        
            $Besoins->ChildPrevu = $data['ChildPrevu'];
        
        }



    







    

        if(!empty($data['ChildImprevu'])){
        
            $Besoins->ChildImprevu = $data['ChildImprevu'];
        
        }



    







    

        if(!empty($data['ChildReussi'])){
        
            $Besoins->ChildReussi = $data['ChildReussi'];
        
        }



    







    

        if(!empty($data['ChildBloquer'])){
        
            $Besoins->ChildBloquer = $data['ChildBloquer'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Besoins->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Besoins->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\BesoinExtras') &&
method_exists('\App\Http\Extras\BesoinExtras', 'beforeSaveCreate')
){
\App\Http\Extras\BesoinExtras::beforeSaveCreate($request,$Besoins);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\BesoinExtras') &&
method_exists('\App\Http\Extras\BesoinExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\BesoinExtras::canCreate($request, $Besoins);
}catch (\Throwable $e){

}

}


if($canSave){
$Besoins->save();
}else{
return response()->json($Besoins, 200);
}

$Besoins=Besoin::find($Besoins->id);
$newCrudData=[];

                $newCrudData['libelle']=$Besoins->libelle;
                $newCrudData['descriptions']=$Besoins->descriptions;
                $newCrudData['debut_previsionnel']=$Besoins->debut_previsionnel;
                $newCrudData['fin_previsionnel']=$Besoins->fin_previsionnel;
                $newCrudData['debut_reel']=$Besoins->debut_reel;
                $newCrudData['fin_reel']=$Besoins->fin_reel;
                $newCrudData['projet_id']=$Besoins->projet_id;
                $newCrudData['evaluation']=$Besoins->evaluation;
                $newCrudData['creat_by']=$Besoins->creat_by;
                $newCrudData['valider']=$Besoins->valider;
                                $newCrudData['Child']=$Besoins->Child;
                $newCrudData['ChildPrevu']=$Besoins->ChildPrevu;
                $newCrudData['ChildImprevu']=$Besoins->ChildImprevu;
                $newCrudData['ChildReussi']=$Besoins->ChildReussi;
                $newCrudData['ChildBloquer']=$Besoins->ChildBloquer;
                $newCrudData['identifiants_sadge']=$Besoins->identifiants_sadge;
    
 try{ $newCrudData['projet']=$Besoins->projet->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Besoins','entite_cle' => $Besoins->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Besoins->toArray();




try{

foreach ($Besoins->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Besoin $Besoins)
{
try{
$can=\App\Helpers\Helpers::can('Editer des besoins');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Besoins->libelle;
                $oldCrudData['descriptions']=$Besoins->descriptions;
                $oldCrudData['debut_previsionnel']=$Besoins->debut_previsionnel;
                $oldCrudData['fin_previsionnel']=$Besoins->fin_previsionnel;
                $oldCrudData['debut_reel']=$Besoins->debut_reel;
                $oldCrudData['fin_reel']=$Besoins->fin_reel;
                $oldCrudData['projet_id']=$Besoins->projet_id;
                $oldCrudData['evaluation']=$Besoins->evaluation;
                $oldCrudData['creat_by']=$Besoins->creat_by;
                $oldCrudData['valider']=$Besoins->valider;
                                $oldCrudData['Child']=$Besoins->Child;
                $oldCrudData['ChildPrevu']=$Besoins->ChildPrevu;
                $oldCrudData['ChildImprevu']=$Besoins->ChildImprevu;
                $oldCrudData['ChildReussi']=$Besoins->ChildReussi;
                $oldCrudData['ChildBloquer']=$Besoins->ChildBloquer;
                $oldCrudData['identifiants_sadge']=$Besoins->identifiants_sadge;
    
 try{ $oldCrudData['projet']=$Besoins->projet->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "besoins"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'descriptions',
    'debut_previsionnel',
    'fin_previsionnel',
    'debut_reel',
    'fin_reel',
    'projet_id',
    'evaluation',
    'creat_by',
    'valider',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'Child',
    'ChildPrevu',
    'ChildImprevu',
    'ChildReussi',
    'ChildBloquer',
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
        
    
    
                    'descriptions' => [
            //'required'
            ],
        
    
    
                    'debut_previsionnel' => [
            //'required'
            ],
        
    
    
                    'fin_previsionnel' => [
            //'required'
            ],
        
    
    
                    'debut_reel' => [
            //'required'
            ],
        
    
    
                    'fin_reel' => [
            //'required'
            ],
        
    
    
                    'projet_id' => [
            //'required'
            ],
        
    
    
                    'evaluation' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'valider' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'Child' => [
            //'required'
            ],
        
    
    
                    'ChildPrevu' => [
            //'required'
            ],
        
    
    
                    'ChildImprevu' => [
            //'required'
            ],
        
    
    
                    'ChildReussi' => [
            //'required'
            ],
        
    
    
                    'ChildBloquer' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'descriptions' => ['cette donnee est obligatoire'],

    
    
        'debut_previsionnel' => ['cette donnee est obligatoire'],

    
    
        'fin_previsionnel' => ['cette donnee est obligatoire'],

    
    
        'debut_reel' => ['cette donnee est obligatoire'],

    
    
        'fin_reel' => ['cette donnee est obligatoire'],

    
    
        'projet_id' => ['cette donnee est obligatoire'],

    
    
        'evaluation' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'valider' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'Child' => ['cette donnee est obligatoire'],

    
    
        'ChildPrevu' => ['cette donnee est obligatoire'],

    
    
        'ChildImprevu' => ['cette donnee est obligatoire'],

    
    
        'ChildReussi' => ['cette donnee est obligatoire'],

    
    
        'ChildBloquer' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Besoins->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("descriptions",$data)){


        if(!empty($data['descriptions'])){
        
            $Besoins->descriptions = $data['descriptions'];
        
        }

        }

    







    

        if(array_key_exists("debut_previsionnel",$data)){


        if(!empty($data['debut_previsionnel'])){
        
            $Besoins->debut_previsionnel = $data['debut_previsionnel'];
        
        }

        }

    







    

        if(array_key_exists("fin_previsionnel",$data)){


        if(!empty($data['fin_previsionnel'])){
        
            $Besoins->fin_previsionnel = $data['fin_previsionnel'];
        
        }

        }

    







    

        if(array_key_exists("debut_reel",$data)){


        if(!empty($data['debut_reel'])){
        
            $Besoins->debut_reel = $data['debut_reel'];
        
        }

        }

    







    

        if(array_key_exists("fin_reel",$data)){


        if(!empty($data['fin_reel'])){
        
            $Besoins->fin_reel = $data['fin_reel'];
        
        }

        }

    







    

        if(array_key_exists("projet_id",$data)){


        if(!empty($data['projet_id'])){
        
            $Besoins->projet_id = $data['projet_id'];
        
        }

        }

    







    

        if(array_key_exists("evaluation",$data)){


        if(!empty($data['evaluation'])){
        
            $Besoins->evaluation = $data['evaluation'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Besoins->creat_by = $data['creat_by'];
        
        }

        }

    







    

        if(array_key_exists("valider",$data)){


        if(!empty($data['valider'])){
        
            $Besoins->valider = $data['valider'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("Child",$data)){


        if(!empty($data['Child'])){
        
            $Besoins->Child = $data['Child'];
        
        }

        }

    







    

        if(array_key_exists("ChildPrevu",$data)){


        if(!empty($data['ChildPrevu'])){
        
            $Besoins->ChildPrevu = $data['ChildPrevu'];
        
        }

        }

    







    

        if(array_key_exists("ChildImprevu",$data)){


        if(!empty($data['ChildImprevu'])){
        
            $Besoins->ChildImprevu = $data['ChildImprevu'];
        
        }

        }

    







    

        if(array_key_exists("ChildReussi",$data)){


        if(!empty($data['ChildReussi'])){
        
            $Besoins->ChildReussi = $data['ChildReussi'];
        
        }

        }

    







    

        if(array_key_exists("ChildBloquer",$data)){


        if(!empty($data['ChildBloquer'])){
        
            $Besoins->ChildBloquer = $data['ChildBloquer'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Besoins->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Besoins->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\BesoinExtras') &&
method_exists('\App\Http\Extras\BesoinExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\BesoinExtras::beforeSaveUpdate($request,$Besoins);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\BesoinExtras') &&
method_exists('\App\Http\Extras\BesoinExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\BesoinExtras::canUpdate($request, $Besoins);
}catch (\Throwable $e){

}

}


if($canSave){
$Besoins->save();
}else{
return response()->json($Besoins, 200);

}


$Besoins=Besoin::find($Besoins->id);



$newCrudData=[];

                $newCrudData['libelle']=$Besoins->libelle;
                $newCrudData['descriptions']=$Besoins->descriptions;
                $newCrudData['debut_previsionnel']=$Besoins->debut_previsionnel;
                $newCrudData['fin_previsionnel']=$Besoins->fin_previsionnel;
                $newCrudData['debut_reel']=$Besoins->debut_reel;
                $newCrudData['fin_reel']=$Besoins->fin_reel;
                $newCrudData['projet_id']=$Besoins->projet_id;
                $newCrudData['evaluation']=$Besoins->evaluation;
                $newCrudData['creat_by']=$Besoins->creat_by;
                $newCrudData['valider']=$Besoins->valider;
                                $newCrudData['Child']=$Besoins->Child;
                $newCrudData['ChildPrevu']=$Besoins->ChildPrevu;
                $newCrudData['ChildImprevu']=$Besoins->ChildImprevu;
                $newCrudData['ChildReussi']=$Besoins->ChildReussi;
                $newCrudData['ChildBloquer']=$Besoins->ChildBloquer;
                $newCrudData['identifiants_sadge']=$Besoins->identifiants_sadge;
    
 try{ $newCrudData['projet']=$Besoins->projet->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Besoins','entite_cle' => $Besoins->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Besoins->toArray();




try{

foreach ($Besoins->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Besoin $Besoins)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des besoins');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Besoins->libelle;
                $newCrudData['descriptions']=$Besoins->descriptions;
                $newCrudData['debut_previsionnel']=$Besoins->debut_previsionnel;
                $newCrudData['fin_previsionnel']=$Besoins->fin_previsionnel;
                $newCrudData['debut_reel']=$Besoins->debut_reel;
                $newCrudData['fin_reel']=$Besoins->fin_reel;
                $newCrudData['projet_id']=$Besoins->projet_id;
                $newCrudData['evaluation']=$Besoins->evaluation;
                $newCrudData['creat_by']=$Besoins->creat_by;
                $newCrudData['valider']=$Besoins->valider;
                                $newCrudData['Child']=$Besoins->Child;
                $newCrudData['ChildPrevu']=$Besoins->ChildPrevu;
                $newCrudData['ChildImprevu']=$Besoins->ChildImprevu;
                $newCrudData['ChildReussi']=$Besoins->ChildReussi;
                $newCrudData['ChildBloquer']=$Besoins->ChildBloquer;
                $newCrudData['identifiants_sadge']=$Besoins->identifiants_sadge;
    
 try{ $newCrudData['projet']=$Besoins->projet->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Besoins','entite_cle' => $Besoins->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\BesoinExtras') &&
method_exists('\App\Http\Extras\BesoinExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\BesoinExtras::canDelete($request, $Besoins);
}catch (\Throwable $e){

}

}



if($canSave){
$Besoins->delete();
}else{
return response()->json($Besoins, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\BesoinsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
