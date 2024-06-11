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
// use App\Repository\prod\StatszonesRepository;
use App\Models\Statszone;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



    
class StatszoneController extends Controller
{

private $StatszonesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\StatszonesRepository $StatszonesRepository
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
class_exists('\App\Http\Extras\StatszoneExtras') &&
method_exists('\App\Http\Extras\StatszoneExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\StatszoneExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Statszone::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\StatszoneExtras') &&
method_exists('\App\Http\Extras\StatszoneExtras', 'filterAgGridQuery')
){
\App\Http\Extras\StatszoneExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('statszones',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\StatszoneExtras') &&
method_exists('\App\Http\Extras\StatszoneExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\StatszoneExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  statszones reussi',
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
return response()->json(Statszone::count());
}
$data = QueryBuilder::for(Statszone::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('nom1'),

    
            AllowedFilter::exact('modelslistingnuit1_id'),

    
            AllowedFilter::exact('modelslistingjour1_id'),

    
            AllowedFilter::exact('nom2'),

    
            AllowedFilter::exact('modelslistingnuit2_id'),

    
            AllowedFilter::exact('modelslistingjour2_id'),

    
            AllowedFilter::exact('nom3'),

    
            AllowedFilter::exact('modelslistingnuit3_id'),

    
            AllowedFilter::exact('modelslistingjour3_id'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('modelslistingnuit1'),

    
            AllowedFilter::exact('modelslistingnuit2'),

    
            AllowedFilter::exact('modelslistingnuit3'),

    
            AllowedFilter::exact('modelslistingjour1'),

    
            AllowedFilter::exact('modelslistingjour2'),

    
            AllowedFilter::exact('modelslistingjour3'),

    
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

    
            AllowedSort::field('nom1'),

    
            AllowedSort::field('modelslistingnuit1_id'),

    
            AllowedSort::field('modelslistingjour1_id'),

    
            AllowedSort::field('nom2'),

    
            AllowedSort::field('modelslistingnuit2_id'),

    
            AllowedSort::field('modelslistingjour2_id'),

    
            AllowedSort::field('nom3'),

    
            AllowedSort::field('modelslistingnuit3_id'),

    
            AllowedSort::field('modelslistingjour3_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('modelslistingnuit1'),

    
            AllowedSort::field('modelslistingnuit2'),

    
            AllowedSort::field('modelslistingnuit3'),

    
            AllowedSort::field('modelslistingjour1'),

    
            AllowedSort::field('modelslistingjour2'),

    
            AllowedSort::field('modelslistingjour3'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([

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




$data = QueryBuilder::for(Statszone::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('nom1'),

    
            AllowedFilter::exact('modelslistingnuit1_id'),

    
            AllowedFilter::exact('modelslistingjour1_id'),

    
            AllowedFilter::exact('nom2'),

    
            AllowedFilter::exact('modelslistingnuit2_id'),

    
            AllowedFilter::exact('modelslistingjour2_id'),

    
            AllowedFilter::exact('nom3'),

    
            AllowedFilter::exact('modelslistingnuit3_id'),

    
            AllowedFilter::exact('modelslistingjour3_id'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('modelslistingnuit1'),

    
            AllowedFilter::exact('modelslistingnuit2'),

    
            AllowedFilter::exact('modelslistingnuit3'),

    
            AllowedFilter::exact('modelslistingjour1'),

    
            AllowedFilter::exact('modelslistingjour2'),

    
            AllowedFilter::exact('modelslistingjour3'),

    
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

    
            AllowedSort::field('nom1'),

    
            AllowedSort::field('modelslistingnuit1_id'),

    
            AllowedSort::field('modelslistingjour1_id'),

    
            AllowedSort::field('nom2'),

    
            AllowedSort::field('modelslistingnuit2_id'),

    
            AllowedSort::field('modelslistingjour2_id'),

    
            AllowedSort::field('nom3'),

    
            AllowedSort::field('modelslistingnuit3_id'),

    
            AllowedSort::field('modelslistingjour3_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('modelslistingnuit1'),

    
            AllowedSort::field('modelslistingnuit2'),

    
            AllowedSort::field('modelslistingnuit3'),

    
            AllowedSort::field('modelslistingjour1'),

    
            AllowedSort::field('modelslistingjour2'),

    
            AllowedSort::field('modelslistingjour3'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([
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



public function create(Request $request, Statszone $Statszones)
{


try{
$can=\App\Helpers\Helpers::can('Creer des statszones');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "statszones"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'nom1',
    'modelslistingnuit1_id',
    'modelslistingjour1_id',
    'nom2',
    'modelslistingnuit2_id',
    'modelslistingjour2_id',
    'nom3',
    'modelslistingnuit3_id',
    'modelslistingjour3_id',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'user_id',
    'modelslistingnuit1',
    'modelslistingnuit2',
    'modelslistingnuit3',
    'modelslistingjour1',
    'modelslistingjour2',
    'modelslistingjour3',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'nom1' => [
            //'required'
            ],
        
    
    
                    'modelslistingnuit1_id' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour1_id' => [
            //'required'
            ],
        
    
    
                    'nom2' => [
            //'required'
            ],
        
    
    
                    'modelslistingnuit2_id' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour2_id' => [
            //'required'
            ],
        
    
    
                    'nom3' => [
            //'required'
            ],
        
    
    
                    'modelslistingnuit3_id' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour3_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
    
                    'modelslistingnuit1' => [
            //'required'
            ],
        
    
    
                    'modelslistingnuit2' => [
            //'required'
            ],
        
    
    
                    'modelslistingnuit3' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour1' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour2' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour3' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'nom1' => ['cette donnee est obligatoire'],

    
    
        'modelslistingnuit1_id' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour1_id' => ['cette donnee est obligatoire'],

    
    
        'nom2' => ['cette donnee est obligatoire'],

    
    
        'modelslistingnuit2_id' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour2_id' => ['cette donnee est obligatoire'],

    
    
        'nom3' => ['cette donnee est obligatoire'],

    
    
        'modelslistingnuit3_id' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour3_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
    
        'modelslistingnuit1' => ['cette donnee est obligatoire'],

    
    
        'modelslistingnuit2' => ['cette donnee est obligatoire'],

    
    
        'modelslistingnuit3' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour1' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour2' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour3' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['nom1'])){
        
            $Statszones->nom1 = $data['nom1'];
        
        }



    







    

        if(!empty($data['modelslistingnuit1_id'])){
        
            $Statszones->modelslistingnuit1_id = $data['modelslistingnuit1_id'];
        
        }



    







    

        if(!empty($data['modelslistingjour1_id'])){
        
            $Statszones->modelslistingjour1_id = $data['modelslistingjour1_id'];
        
        }



    







    

        if(!empty($data['nom2'])){
        
            $Statszones->nom2 = $data['nom2'];
        
        }



    







    

        if(!empty($data['modelslistingnuit2_id'])){
        
            $Statszones->modelslistingnuit2_id = $data['modelslistingnuit2_id'];
        
        }



    







    

        if(!empty($data['modelslistingjour2_id'])){
        
            $Statszones->modelslistingjour2_id = $data['modelslistingjour2_id'];
        
        }



    







    

        if(!empty($data['nom3'])){
        
            $Statszones->nom3 = $data['nom3'];
        
        }



    







    

        if(!empty($data['modelslistingnuit3_id'])){
        
            $Statszones->modelslistingnuit3_id = $data['modelslistingnuit3_id'];
        
        }



    







    

        if(!empty($data['modelslistingjour3_id'])){
        
            $Statszones->modelslistingjour3_id = $data['modelslistingjour3_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Statszones->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['user_id'])){
        
            $Statszones->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['modelslistingnuit1'])){
        
            $Statszones->modelslistingnuit1 = $data['modelslistingnuit1'];
        
        }



    







    

        if(!empty($data['modelslistingnuit2'])){
        
            $Statszones->modelslistingnuit2 = $data['modelslistingnuit2'];
        
        }



    







    

        if(!empty($data['modelslistingnuit3'])){
        
            $Statszones->modelslistingnuit3 = $data['modelslistingnuit3'];
        
        }



    







    

        if(!empty($data['modelslistingjour1'])){
        
            $Statszones->modelslistingjour1 = $data['modelslistingjour1'];
        
        }



    







    

        if(!empty($data['modelslistingjour2'])){
        
            $Statszones->modelslistingjour2 = $data['modelslistingjour2'];
        
        }



    







    

        if(!empty($data['modelslistingjour3'])){
        
            $Statszones->modelslistingjour3 = $data['modelslistingjour3'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Statszones->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Statszones->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\StatszoneExtras') &&
method_exists('\App\Http\Extras\StatszoneExtras', 'beforeSaveCreate')
){
\App\Http\Extras\StatszoneExtras::beforeSaveCreate($request,$Statszones);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\StatszoneExtras') &&
method_exists('\App\Http\Extras\StatszoneExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\StatszoneExtras::canCreate($request, $Statszones);
}catch (\Throwable $e){

}

}


if($canSave){
$Statszones->save();
}else{
return response()->json($Statszones, 200);
}

$Statszones=Statszone::find($Statszones->id);
$newCrudData=[];

                $newCrudData['nom1']=$Statszones->nom1;
                $newCrudData['modelslistingnuit1_id']=$Statszones->modelslistingnuit1_id;
                $newCrudData['modelslistingjour1_id']=$Statszones->modelslistingjour1_id;
                $newCrudData['nom2']=$Statszones->nom2;
                $newCrudData['modelslistingnuit2_id']=$Statszones->modelslistingnuit2_id;
                $newCrudData['modelslistingjour2_id']=$Statszones->modelslistingjour2_id;
                $newCrudData['nom3']=$Statszones->nom3;
                $newCrudData['modelslistingnuit3_id']=$Statszones->modelslistingnuit3_id;
                $newCrudData['modelslistingjour3_id']=$Statszones->modelslistingjour3_id;
                $newCrudData['creat_by']=$Statszones->creat_by;
                                $newCrudData['user_id']=$Statszones->user_id;
                $newCrudData['modelslistingnuit1']=$Statszones->modelslistingnuit1;
                $newCrudData['modelslistingnuit2']=$Statszones->modelslistingnuit2;
                $newCrudData['modelslistingnuit3']=$Statszones->modelslistingnuit3;
                $newCrudData['modelslistingjour1']=$Statszones->modelslistingjour1;
                $newCrudData['modelslistingjour2']=$Statszones->modelslistingjour2;
                $newCrudData['modelslistingjour3']=$Statszones->modelslistingjour3;
                $newCrudData['identifiants_sadge']=$Statszones->identifiants_sadge;
    
 try{ $newCrudData['user']=$Statszones->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Statszones','entite_cle' => $Statszones->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Statszones->toArray();




try{

foreach ($Statszones->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Statszone $Statszones)
{
try{
$can=\App\Helpers\Helpers::can('Editer des statszones');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['nom1']=$Statszones->nom1;
                $oldCrudData['modelslistingnuit1_id']=$Statszones->modelslistingnuit1_id;
                $oldCrudData['modelslistingjour1_id']=$Statszones->modelslistingjour1_id;
                $oldCrudData['nom2']=$Statszones->nom2;
                $oldCrudData['modelslistingnuit2_id']=$Statszones->modelslistingnuit2_id;
                $oldCrudData['modelslistingjour2_id']=$Statszones->modelslistingjour2_id;
                $oldCrudData['nom3']=$Statszones->nom3;
                $oldCrudData['modelslistingnuit3_id']=$Statszones->modelslistingnuit3_id;
                $oldCrudData['modelslistingjour3_id']=$Statszones->modelslistingjour3_id;
                $oldCrudData['creat_by']=$Statszones->creat_by;
                                $oldCrudData['user_id']=$Statszones->user_id;
                $oldCrudData['modelslistingnuit1']=$Statszones->modelslistingnuit1;
                $oldCrudData['modelslistingnuit2']=$Statszones->modelslistingnuit2;
                $oldCrudData['modelslistingnuit3']=$Statszones->modelslistingnuit3;
                $oldCrudData['modelslistingjour1']=$Statszones->modelslistingjour1;
                $oldCrudData['modelslistingjour2']=$Statszones->modelslistingjour2;
                $oldCrudData['modelslistingjour3']=$Statszones->modelslistingjour3;
                $oldCrudData['identifiants_sadge']=$Statszones->identifiants_sadge;
    
 try{ $oldCrudData['user']=$Statszones->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "statszones"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'nom1',
    'modelslistingnuit1_id',
    'modelslistingjour1_id',
    'nom2',
    'modelslistingnuit2_id',
    'modelslistingjour2_id',
    'nom3',
    'modelslistingnuit3_id',
    'modelslistingjour3_id',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'user_id',
    'modelslistingnuit1',
    'modelslistingnuit2',
    'modelslistingnuit3',
    'modelslistingjour1',
    'modelslistingjour2',
    'modelslistingjour3',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'nom1' => [
            //'required'
            ],
        
    
    
                    'modelslistingnuit1_id' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour1_id' => [
            //'required'
            ],
        
    
    
                    'nom2' => [
            //'required'
            ],
        
    
    
                    'modelslistingnuit2_id' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour2_id' => [
            //'required'
            ],
        
    
    
                    'nom3' => [
            //'required'
            ],
        
    
    
                    'modelslistingnuit3_id' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour3_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
    
                    'modelslistingnuit1' => [
            //'required'
            ],
        
    
    
                    'modelslistingnuit2' => [
            //'required'
            ],
        
    
    
                    'modelslistingnuit3' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour1' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour2' => [
            //'required'
            ],
        
    
    
                    'modelslistingjour3' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'nom1' => ['cette donnee est obligatoire'],

    
    
        'modelslistingnuit1_id' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour1_id' => ['cette donnee est obligatoire'],

    
    
        'nom2' => ['cette donnee est obligatoire'],

    
    
        'modelslistingnuit2_id' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour2_id' => ['cette donnee est obligatoire'],

    
    
        'nom3' => ['cette donnee est obligatoire'],

    
    
        'modelslistingnuit3_id' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour3_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
    
        'modelslistingnuit1' => ['cette donnee est obligatoire'],

    
    
        'modelslistingnuit2' => ['cette donnee est obligatoire'],

    
    
        'modelslistingnuit3' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour1' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour2' => ['cette donnee est obligatoire'],

    
    
        'modelslistingjour3' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("nom1",$data)){


        if(!empty($data['nom1'])){
        
            $Statszones->nom1 = $data['nom1'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingnuit1_id",$data)){


        if(!empty($data['modelslistingnuit1_id'])){
        
            $Statszones->modelslistingnuit1_id = $data['modelslistingnuit1_id'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingjour1_id",$data)){


        if(!empty($data['modelslistingjour1_id'])){
        
            $Statszones->modelslistingjour1_id = $data['modelslistingjour1_id'];
        
        }

        }

    







    

        if(array_key_exists("nom2",$data)){


        if(!empty($data['nom2'])){
        
            $Statszones->nom2 = $data['nom2'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingnuit2_id",$data)){


        if(!empty($data['modelslistingnuit2_id'])){
        
            $Statszones->modelslistingnuit2_id = $data['modelslistingnuit2_id'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingjour2_id",$data)){


        if(!empty($data['modelslistingjour2_id'])){
        
            $Statszones->modelslistingjour2_id = $data['modelslistingjour2_id'];
        
        }

        }

    







    

        if(array_key_exists("nom3",$data)){


        if(!empty($data['nom3'])){
        
            $Statszones->nom3 = $data['nom3'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingnuit3_id",$data)){


        if(!empty($data['modelslistingnuit3_id'])){
        
            $Statszones->modelslistingnuit3_id = $data['modelslistingnuit3_id'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingjour3_id",$data)){


        if(!empty($data['modelslistingjour3_id'])){
        
            $Statszones->modelslistingjour3_id = $data['modelslistingjour3_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Statszones->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Statszones->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingnuit1",$data)){


        if(!empty($data['modelslistingnuit1'])){
        
            $Statszones->modelslistingnuit1 = $data['modelslistingnuit1'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingnuit2",$data)){


        if(!empty($data['modelslistingnuit2'])){
        
            $Statszones->modelslistingnuit2 = $data['modelslistingnuit2'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingnuit3",$data)){


        if(!empty($data['modelslistingnuit3'])){
        
            $Statszones->modelslistingnuit3 = $data['modelslistingnuit3'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingjour1",$data)){


        if(!empty($data['modelslistingjour1'])){
        
            $Statszones->modelslistingjour1 = $data['modelslistingjour1'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingjour2",$data)){


        if(!empty($data['modelslistingjour2'])){
        
            $Statszones->modelslistingjour2 = $data['modelslistingjour2'];
        
        }

        }

    







    

        if(array_key_exists("modelslistingjour3",$data)){


        if(!empty($data['modelslistingjour3'])){
        
            $Statszones->modelslistingjour3 = $data['modelslistingjour3'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Statszones->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Statszones->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\StatszoneExtras') &&
method_exists('\App\Http\Extras\StatszoneExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\StatszoneExtras::beforeSaveUpdate($request,$Statszones);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\StatszoneExtras') &&
method_exists('\App\Http\Extras\StatszoneExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\StatszoneExtras::canUpdate($request, $Statszones);
}catch (\Throwable $e){

}

}


if($canSave){
$Statszones->save();
}else{
return response()->json($Statszones, 200);

}


$Statszones=Statszone::find($Statszones->id);



$newCrudData=[];

                $newCrudData['nom1']=$Statszones->nom1;
                $newCrudData['modelslistingnuit1_id']=$Statszones->modelslistingnuit1_id;
                $newCrudData['modelslistingjour1_id']=$Statszones->modelslistingjour1_id;
                $newCrudData['nom2']=$Statszones->nom2;
                $newCrudData['modelslistingnuit2_id']=$Statszones->modelslistingnuit2_id;
                $newCrudData['modelslistingjour2_id']=$Statszones->modelslistingjour2_id;
                $newCrudData['nom3']=$Statszones->nom3;
                $newCrudData['modelslistingnuit3_id']=$Statszones->modelslistingnuit3_id;
                $newCrudData['modelslistingjour3_id']=$Statszones->modelslistingjour3_id;
                $newCrudData['creat_by']=$Statszones->creat_by;
                                $newCrudData['user_id']=$Statszones->user_id;
                $newCrudData['modelslistingnuit1']=$Statszones->modelslistingnuit1;
                $newCrudData['modelslistingnuit2']=$Statszones->modelslistingnuit2;
                $newCrudData['modelslistingnuit3']=$Statszones->modelslistingnuit3;
                $newCrudData['modelslistingjour1']=$Statszones->modelslistingjour1;
                $newCrudData['modelslistingjour2']=$Statszones->modelslistingjour2;
                $newCrudData['modelslistingjour3']=$Statszones->modelslistingjour3;
                $newCrudData['identifiants_sadge']=$Statszones->identifiants_sadge;
    
 try{ $newCrudData['user']=$Statszones->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Statszones','entite_cle' => $Statszones->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Statszones->toArray();




try{

foreach ($Statszones->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Statszone $Statszones)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des statszones');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['nom1']=$Statszones->nom1;
                $newCrudData['modelslistingnuit1_id']=$Statszones->modelslistingnuit1_id;
                $newCrudData['modelslistingjour1_id']=$Statszones->modelslistingjour1_id;
                $newCrudData['nom2']=$Statszones->nom2;
                $newCrudData['modelslistingnuit2_id']=$Statszones->modelslistingnuit2_id;
                $newCrudData['modelslistingjour2_id']=$Statszones->modelslistingjour2_id;
                $newCrudData['nom3']=$Statszones->nom3;
                $newCrudData['modelslistingnuit3_id']=$Statszones->modelslistingnuit3_id;
                $newCrudData['modelslistingjour3_id']=$Statszones->modelslistingjour3_id;
                $newCrudData['creat_by']=$Statszones->creat_by;
                                $newCrudData['user_id']=$Statszones->user_id;
                $newCrudData['modelslistingnuit1']=$Statszones->modelslistingnuit1;
                $newCrudData['modelslistingnuit2']=$Statszones->modelslistingnuit2;
                $newCrudData['modelslistingnuit3']=$Statszones->modelslistingnuit3;
                $newCrudData['modelslistingjour1']=$Statszones->modelslistingjour1;
                $newCrudData['modelslistingjour2']=$Statszones->modelslistingjour2;
                $newCrudData['modelslistingjour3']=$Statszones->modelslistingjour3;
                $newCrudData['identifiants_sadge']=$Statszones->identifiants_sadge;
    
 try{ $newCrudData['user']=$Statszones->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Statszones','entite_cle' => $Statszones->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\StatszoneExtras') &&
method_exists('\App\Http\Extras\StatszoneExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\StatszoneExtras::canDelete($request, $Statszones);
}catch (\Throwable $e){

}

}



if($canSave){
$Statszones->delete();
}else{
return response()->json($Statszones, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\StatszonesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
