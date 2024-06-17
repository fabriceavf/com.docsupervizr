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
// use App\Repository\prod\PointeusesRepository;
use App\Models\Pointeuse;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Site;
    
class PointeuseController extends Controller
{

private $PointeusesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\PointeusesRepository $PointeusesRepository
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
class_exists('\App\Http\Extras\PointeuseExtras') &&
method_exists('\App\Http\Extras\PointeuseExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\PointeuseExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Pointeuse::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\PointeuseExtras') &&
method_exists('\App\Http\Extras\PointeuseExtras', 'filterAgGridQuery')
){
\App\Http\Extras\PointeuseExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('pointeuses',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\PointeuseExtras') &&
method_exists('\App\Http\Extras\PointeuseExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\PointeuseExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  pointeuses reussi',
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
return response()->json(Pointeuse::count());
}
$data = QueryBuilder::for(Pointeuse::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('libelle'),

    
    
    
            AllowedFilter::exact('nom_local'),

    
            AllowedFilter::exact('supervirzclient_id'),

    
            AllowedFilter::exact('code_teleric'),

    
            AllowedFilter::exact('postes'),

    
            AllowedFilter::exact('Taches'),

    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
            AllowedFilter::exact('site_id'),

    
    
    
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

    
            AllowedSort::field('code'),

    
            AllowedSort::field('libelle'),

    
    
    
            AllowedSort::field('nom_local'),

    
            AllowedSort::field('supervirzclient_id'),

    
            AllowedSort::field('code_teleric'),

    
            AllowedSort::field('postes'),

    
            AllowedSort::field('Taches'),

    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
            AllowedSort::field('site_id'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
            'controlleursacces',
        

                'deploiementspointeusesmoyenstransports',
        

                'postespointeuses',
        

                'sites',
        

                'sitespointeuses',
        

    
            'site',
        

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




$data = QueryBuilder::for(Pointeuse::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('libelle'),

    
    
    
            AllowedFilter::exact('nom_local'),

    
            AllowedFilter::exact('supervirzclient_id'),

    
            AllowedFilter::exact('code_teleric'),

    
            AllowedFilter::exact('postes'),

    
            AllowedFilter::exact('Taches'),

    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
            AllowedFilter::exact('site_id'),

    
    
    
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

    
            AllowedSort::field('code'),

    
            AllowedSort::field('libelle'),

    
    
    
            AllowedSort::field('nom_local'),

    
            AllowedSort::field('supervirzclient_id'),

    
            AllowedSort::field('code_teleric'),

    
            AllowedSort::field('postes'),

    
            AllowedSort::field('Taches'),

    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
            AllowedSort::field('site_id'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
            'controlleursacces',
        

                'deploiementspointeusesmoyenstransports',
        

                'postespointeuses',
        

                'sites',
        

                'sitespointeuses',
        

                'site',
        

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



public function create(Request $request, Pointeuse $Pointeuses)
{


try{
$can=\App\Helpers\Helpers::can('Creer des pointeuses');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "pointeuses"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'libelle',
    'created_at',
    'updated_at',
    'nom_local',
    'supervirzclient_id',
    'code_teleric',
    'postes',
    'Taches',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'site_id',
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
    
    
                    'code' => [
            //'required'
            ],
        
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
    
    
                    'nom_local' => [
            //'required'
            ],
        
    
    
                    'supervirzclient_id' => [
            //'required'
            ],
        
    
    
                    'code_teleric' => [
            //'required'
            ],
        
    
    
                    'postes' => [
            //'required'
            ],
        
    
    
                    'Taches' => [
            //'required'
            ],
        
    
    
                    'lun' => [
            //'required'
            ],
        
    
    
                    'mar' => [
            //'required'
            ],
        
    
    
                    'mer' => [
            //'required'
            ],
        
    
    
                    'jeu' => [
            //'required'
            ],
        
    
    
                    'ven' => [
            //'required'
            ],
        
    
    
                    'sam' => [
            //'required'
            ],
        
    
    
                    'dim' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
    
    
        'nom_local' => ['cette donnee est obligatoire'],

    
    
        'supervirzclient_id' => ['cette donnee est obligatoire'],

    
    
        'code_teleric' => ['cette donnee est obligatoire'],

    
    
        'postes' => ['cette donnee est obligatoire'],

    
    
        'Taches' => ['cette donnee est obligatoire'],

    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['code'])){
        
            $Pointeuses->code = $data['code'];
        
        }



    







    

        if(!empty($data['libelle'])){
        
            $Pointeuses->libelle = $data['libelle'];
        
        }



    







    







    







    

        if(!empty($data['nom_local'])){
        
            $Pointeuses->nom_local = $data['nom_local'];
        
        }



    







    

        if(!empty($data['supervirzclient_id'])){
        
            $Pointeuses->supervirzclient_id = $data['supervirzclient_id'];
        
        }



    







    

        if(!empty($data['code_teleric'])){
        
            $Pointeuses->code_teleric = $data['code_teleric'];
        
        }



    







    

        if(!empty($data['postes'])){
        
            $Pointeuses->postes = $data['postes'];
        
        }



    







    

        if(!empty($data['Taches'])){
        
            $Pointeuses->Taches = $data['Taches'];
        
        }



    







    

        if(!empty($data['lun'])){
        
            $Pointeuses->lun = $data['lun'];
        
        }



    







    

        if(!empty($data['mar'])){
        
            $Pointeuses->mar = $data['mar'];
        
        }



    







    

        if(!empty($data['mer'])){
        
            $Pointeuses->mer = $data['mer'];
        
        }



    







    

        if(!empty($data['jeu'])){
        
            $Pointeuses->jeu = $data['jeu'];
        
        }



    







    

        if(!empty($data['ven'])){
        
            $Pointeuses->ven = $data['ven'];
        
        }



    







    

        if(!empty($data['sam'])){
        
            $Pointeuses->sam = $data['sam'];
        
        }



    







    

        if(!empty($data['dim'])){
        
            $Pointeuses->dim = $data['dim'];
        
        }



    







    

        if(!empty($data['site_id'])){
        
            $Pointeuses->site_id = $data['site_id'];
        
        }



    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Pointeuses->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Pointeuses->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Pointeuses->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\PointeuseExtras') &&
method_exists('\App\Http\Extras\PointeuseExtras', 'beforeSaveCreate')
){
\App\Http\Extras\PointeuseExtras::beforeSaveCreate($request,$Pointeuses);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PointeuseExtras') &&
method_exists('\App\Http\Extras\PointeuseExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\PointeuseExtras::canCreate($request, $Pointeuses);
}catch (\Throwable $e){

}

}


if($canSave){
$Pointeuses->save();
}else{
return response()->json($Pointeuses, 200);
}

$Pointeuses=Pointeuse::find($Pointeuses->id);
$newCrudData=[];

                $newCrudData['code']=$Pointeuses->code;
                $newCrudData['libelle']=$Pointeuses->libelle;
                        $newCrudData['nom_local']=$Pointeuses->nom_local;
                $newCrudData['supervirzclient_id']=$Pointeuses->supervirzclient_id;
                $newCrudData['code_teleric']=$Pointeuses->code_teleric;
                $newCrudData['postes']=$Pointeuses->postes;
                $newCrudData['Taches']=$Pointeuses->Taches;
                $newCrudData['lun']=$Pointeuses->lun;
                $newCrudData['mar']=$Pointeuses->mar;
                $newCrudData['mer']=$Pointeuses->mer;
                $newCrudData['jeu']=$Pointeuses->jeu;
                $newCrudData['ven']=$Pointeuses->ven;
                $newCrudData['sam']=$Pointeuses->sam;
                $newCrudData['dim']=$Pointeuses->dim;
                $newCrudData['site_id']=$Pointeuses->site_id;
                        $newCrudData['identifiants_sadge']=$Pointeuses->identifiants_sadge;
                $newCrudData['creat_by']=$Pointeuses->creat_by;
    
 try{ $newCrudData['site']=$Pointeuses->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Pointeuses','entite_cle' => $Pointeuses->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Pointeuses->toArray();




try{

foreach ($Pointeuses->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Pointeuse $Pointeuses)
{
try{
$can=\App\Helpers\Helpers::can('Editer des pointeuses');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['code']=$Pointeuses->code;
                $oldCrudData['libelle']=$Pointeuses->libelle;
                        $oldCrudData['nom_local']=$Pointeuses->nom_local;
                $oldCrudData['supervirzclient_id']=$Pointeuses->supervirzclient_id;
                $oldCrudData['code_teleric']=$Pointeuses->code_teleric;
                $oldCrudData['postes']=$Pointeuses->postes;
                $oldCrudData['Taches']=$Pointeuses->Taches;
                $oldCrudData['lun']=$Pointeuses->lun;
                $oldCrudData['mar']=$Pointeuses->mar;
                $oldCrudData['mer']=$Pointeuses->mer;
                $oldCrudData['jeu']=$Pointeuses->jeu;
                $oldCrudData['ven']=$Pointeuses->ven;
                $oldCrudData['sam']=$Pointeuses->sam;
                $oldCrudData['dim']=$Pointeuses->dim;
                $oldCrudData['site_id']=$Pointeuses->site_id;
                        $oldCrudData['identifiants_sadge']=$Pointeuses->identifiants_sadge;
                $oldCrudData['creat_by']=$Pointeuses->creat_by;
    
 try{ $oldCrudData['site']=$Pointeuses->site->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "pointeuses"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'libelle',
    'created_at',
    'updated_at',
    'nom_local',
    'supervirzclient_id',
    'code_teleric',
    'postes',
    'Taches',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'site_id',
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
    
    
                    'code' => [
            //'required'
            ],
        
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
    
    
                    'nom_local' => [
            //'required'
            ],
        
    
    
                    'supervirzclient_id' => [
            //'required'
            ],
        
    
    
                    'code_teleric' => [
            //'required'
            ],
        
    
    
                    'postes' => [
            //'required'
            ],
        
    
    
                    'Taches' => [
            //'required'
            ],
        
    
    
                    'lun' => [
            //'required'
            ],
        
    
    
                    'mar' => [
            //'required'
            ],
        
    
    
                    'mer' => [
            //'required'
            ],
        
    
    
                    'jeu' => [
            //'required'
            ],
        
    
    
                    'ven' => [
            //'required'
            ],
        
    
    
                    'sam' => [
            //'required'
            ],
        
    
    
                    'dim' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
    
    
        'nom_local' => ['cette donnee est obligatoire'],

    
    
        'supervirzclient_id' => ['cette donnee est obligatoire'],

    
    
        'code_teleric' => ['cette donnee est obligatoire'],

    
    
        'postes' => ['cette donnee est obligatoire'],

    
    
        'Taches' => ['cette donnee est obligatoire'],

    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("code",$data)){


        if(!empty($data['code'])){
        
            $Pointeuses->code = $data['code'];
        
        }

        }

    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Pointeuses->libelle = $data['libelle'];
        
        }

        }

    







    







    







    

        if(array_key_exists("nom_local",$data)){


        if(!empty($data['nom_local'])){
        
            $Pointeuses->nom_local = $data['nom_local'];
        
        }

        }

    







    

        if(array_key_exists("supervirzclient_id",$data)){


        if(!empty($data['supervirzclient_id'])){
        
            $Pointeuses->supervirzclient_id = $data['supervirzclient_id'];
        
        }

        }

    







    

        if(array_key_exists("code_teleric",$data)){


        if(!empty($data['code_teleric'])){
        
            $Pointeuses->code_teleric = $data['code_teleric'];
        
        }

        }

    







    

        if(array_key_exists("postes",$data)){


        if(!empty($data['postes'])){
        
            $Pointeuses->postes = $data['postes'];
        
        }

        }

    







    

        if(array_key_exists("Taches",$data)){


        if(!empty($data['Taches'])){
        
            $Pointeuses->Taches = $data['Taches'];
        
        }

        }

    







    

        if(array_key_exists("lun",$data)){


        if(!empty($data['lun'])){
        
            $Pointeuses->lun = $data['lun'];
        
        }

        }

    







    

        if(array_key_exists("mar",$data)){


        if(!empty($data['mar'])){
        
            $Pointeuses->mar = $data['mar'];
        
        }

        }

    







    

        if(array_key_exists("mer",$data)){


        if(!empty($data['mer'])){
        
            $Pointeuses->mer = $data['mer'];
        
        }

        }

    







    

        if(array_key_exists("jeu",$data)){


        if(!empty($data['jeu'])){
        
            $Pointeuses->jeu = $data['jeu'];
        
        }

        }

    







    

        if(array_key_exists("ven",$data)){


        if(!empty($data['ven'])){
        
            $Pointeuses->ven = $data['ven'];
        
        }

        }

    







    

        if(array_key_exists("sam",$data)){


        if(!empty($data['sam'])){
        
            $Pointeuses->sam = $data['sam'];
        
        }

        }

    







    

        if(array_key_exists("dim",$data)){


        if(!empty($data['dim'])){
        
            $Pointeuses->dim = $data['dim'];
        
        }

        }

    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Pointeuses->site_id = $data['site_id'];
        
        }

        }

    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Pointeuses->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Pointeuses->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Pointeuses->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\PointeuseExtras') &&
method_exists('\App\Http\Extras\PointeuseExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\PointeuseExtras::beforeSaveUpdate($request,$Pointeuses);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PointeuseExtras') &&
method_exists('\App\Http\Extras\PointeuseExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\PointeuseExtras::canUpdate($request, $Pointeuses);
}catch (\Throwable $e){

}

}


if($canSave){
$Pointeuses->save();
}else{
return response()->json($Pointeuses, 200);

}


$Pointeuses=Pointeuse::find($Pointeuses->id);



$newCrudData=[];

                $newCrudData['code']=$Pointeuses->code;
                $newCrudData['libelle']=$Pointeuses->libelle;
                        $newCrudData['nom_local']=$Pointeuses->nom_local;
                $newCrudData['supervirzclient_id']=$Pointeuses->supervirzclient_id;
                $newCrudData['code_teleric']=$Pointeuses->code_teleric;
                $newCrudData['postes']=$Pointeuses->postes;
                $newCrudData['Taches']=$Pointeuses->Taches;
                $newCrudData['lun']=$Pointeuses->lun;
                $newCrudData['mar']=$Pointeuses->mar;
                $newCrudData['mer']=$Pointeuses->mer;
                $newCrudData['jeu']=$Pointeuses->jeu;
                $newCrudData['ven']=$Pointeuses->ven;
                $newCrudData['sam']=$Pointeuses->sam;
                $newCrudData['dim']=$Pointeuses->dim;
                $newCrudData['site_id']=$Pointeuses->site_id;
                        $newCrudData['identifiants_sadge']=$Pointeuses->identifiants_sadge;
                $newCrudData['creat_by']=$Pointeuses->creat_by;
    
 try{ $newCrudData['site']=$Pointeuses->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Pointeuses','entite_cle' => $Pointeuses->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Pointeuses->toArray();




try{

foreach ($Pointeuses->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Pointeuse $Pointeuses)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des pointeuses');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['code']=$Pointeuses->code;
                $newCrudData['libelle']=$Pointeuses->libelle;
                        $newCrudData['nom_local']=$Pointeuses->nom_local;
                $newCrudData['supervirzclient_id']=$Pointeuses->supervirzclient_id;
                $newCrudData['code_teleric']=$Pointeuses->code_teleric;
                $newCrudData['postes']=$Pointeuses->postes;
                $newCrudData['Taches']=$Pointeuses->Taches;
                $newCrudData['lun']=$Pointeuses->lun;
                $newCrudData['mar']=$Pointeuses->mar;
                $newCrudData['mer']=$Pointeuses->mer;
                $newCrudData['jeu']=$Pointeuses->jeu;
                $newCrudData['ven']=$Pointeuses->ven;
                $newCrudData['sam']=$Pointeuses->sam;
                $newCrudData['dim']=$Pointeuses->dim;
                $newCrudData['site_id']=$Pointeuses->site_id;
                        $newCrudData['identifiants_sadge']=$Pointeuses->identifiants_sadge;
                $newCrudData['creat_by']=$Pointeuses->creat_by;
    
 try{ $newCrudData['site']=$Pointeuses->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Pointeuses','entite_cle' => $Pointeuses->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\PointeuseExtras') &&
method_exists('\App\Http\Extras\PointeuseExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\PointeuseExtras::canDelete($request, $Pointeuses);
}catch (\Throwable $e){

}

}



if($canSave){
$Pointeuses->delete();
}else{
return response()->json($Pointeuses, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\PointeusesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
