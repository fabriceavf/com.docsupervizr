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
// use App\Repository\prod\BadgesRepository;
use App\Models\Badge;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Client;
    
class BadgeController extends Controller
{

private $BadgesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\BadgesRepository $BadgesRepository
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
class_exists('\App\Http\Extras\BadgeExtras') &&
method_exists('\App\Http\Extras\BadgeExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\BadgeExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Badge::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\BadgeExtras') &&
method_exists('\App\Http\Extras\BadgeExtras', 'filterAgGridQuery')
){
\App\Http\Extras\BadgeExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('badges',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\BadgeExtras') &&
method_exists('\App\Http\Extras\BadgeExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\BadgeExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  badges reussi',
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
return response()->json(Badge::count());
}
$data = QueryBuilder::for(Badge::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('content'),

    
    
    
            AllowedFilter::exact('js'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('css'),

    
            AllowedFilter::exact('node_version'),

    
    
    
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

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('content'),

    
    
    
            AllowedSort::field('js'),

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('css'),

    
            AllowedSort::field('node_version'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
            'dependances',
        

    
            'client',
        

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




$data = QueryBuilder::for(Badge::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('content'),

    
    
    
            AllowedFilter::exact('js'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('css'),

    
            AllowedFilter::exact('node_version'),

    
    
    
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

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('content'),

    
    
    
            AllowedSort::field('js'),

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('css'),

    
            AllowedSort::field('node_version'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
            'dependances',
        

                'client',
        

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



public function create(Request $request, Badge $Badges)
{


try{
$can=\App\Helpers\Helpers::can('Creer des badges');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "badges"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'client_id',
    'content',
    'created_at',
    'updated_at',
    'js',
    'libelle',
    'css',
    'node_version',
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
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'content' => [
            //'required'
            ],
        
    
    
    
    
                    'js' => [
            //'required'
            ],
        
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'css' => [
            //'required'
            ],
        
    
    
                    'node_version' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'content' => ['cette donnee est obligatoire'],

    
    
    
    
        'js' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'css' => ['cette donnee est obligatoire'],

    
    
        'node_version' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['client_id'])){
        
            $Badges->client_id = $data['client_id'];
        
        }



    







    

        if(!empty($data['content'])){
        
            $Badges->content = $data['content'];
        
        }



    







    







    







    

        if(!empty($data['js'])){
        
            $Badges->js = $data['js'];
        
        }



    







    

        if(!empty($data['libelle'])){
        
            $Badges->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['css'])){
        
            $Badges->css = $data['css'];
        
        }



    







    

        if(!empty($data['node_version'])){
        
            $Badges->node_version = $data['node_version'];
        
        }



    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Badges->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Badges->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Badges->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\BadgeExtras') &&
method_exists('\App\Http\Extras\BadgeExtras', 'beforeSaveCreate')
){
\App\Http\Extras\BadgeExtras::beforeSaveCreate($request,$Badges);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\BadgeExtras') &&
method_exists('\App\Http\Extras\BadgeExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\BadgeExtras::canCreate($request, $Badges);
}catch (\Throwable $e){

}

}


if($canSave){
$Badges->save();
}else{
return response()->json($Badges, 200);
}

$Badges=Badge::find($Badges->id);
$newCrudData=[];

                $newCrudData['client_id']=$Badges->client_id;
                $newCrudData['content']=$Badges->content;
                        $newCrudData['js']=$Badges->js;
                $newCrudData['libelle']=$Badges->libelle;
                $newCrudData['css']=$Badges->css;
                $newCrudData['node_version']=$Badges->node_version;
                        $newCrudData['identifiants_sadge']=$Badges->identifiants_sadge;
                $newCrudData['creat_by']=$Badges->creat_by;
    
 try{ $newCrudData['client']=$Badges->client->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Badges','entite_cle' => $Badges->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Badges->toArray();




try{

foreach ($Badges->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Badge $Badges)
{
try{
$can=\App\Helpers\Helpers::can('Editer des badges');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['client_id']=$Badges->client_id;
                $oldCrudData['content']=$Badges->content;
                        $oldCrudData['js']=$Badges->js;
                $oldCrudData['libelle']=$Badges->libelle;
                $oldCrudData['css']=$Badges->css;
                $oldCrudData['node_version']=$Badges->node_version;
                        $oldCrudData['identifiants_sadge']=$Badges->identifiants_sadge;
                $oldCrudData['creat_by']=$Badges->creat_by;
    
 try{ $oldCrudData['client']=$Badges->client->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "badges"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'client_id',
    'content',
    'created_at',
    'updated_at',
    'js',
    'libelle',
    'css',
    'node_version',
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
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'content' => [
            //'required'
            ],
        
    
    
    
    
                    'js' => [
            //'required'
            ],
        
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'css' => [
            //'required'
            ],
        
    
    
                    'node_version' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'content' => ['cette donnee est obligatoire'],

    
    
    
    
        'js' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'css' => ['cette donnee est obligatoire'],

    
    
        'node_version' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("client_id",$data)){


        if(!empty($data['client_id'])){
        
            $Badges->client_id = $data['client_id'];
        
        }

        }

    







    

        if(array_key_exists("content",$data)){


        if(!empty($data['content'])){
        
            $Badges->content = $data['content'];
        
        }

        }

    







    







    







    

        if(array_key_exists("js",$data)){


        if(!empty($data['js'])){
        
            $Badges->js = $data['js'];
        
        }

        }

    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Badges->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("css",$data)){


        if(!empty($data['css'])){
        
            $Badges->css = $data['css'];
        
        }

        }

    







    

        if(array_key_exists("node_version",$data)){


        if(!empty($data['node_version'])){
        
            $Badges->node_version = $data['node_version'];
        
        }

        }

    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Badges->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Badges->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Badges->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\BadgeExtras') &&
method_exists('\App\Http\Extras\BadgeExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\BadgeExtras::beforeSaveUpdate($request,$Badges);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\BadgeExtras') &&
method_exists('\App\Http\Extras\BadgeExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\BadgeExtras::canUpdate($request, $Badges);
}catch (\Throwable $e){

}

}


if($canSave){
$Badges->save();
}else{
return response()->json($Badges, 200);

}


$Badges=Badge::find($Badges->id);



$newCrudData=[];

                $newCrudData['client_id']=$Badges->client_id;
                $newCrudData['content']=$Badges->content;
                        $newCrudData['js']=$Badges->js;
                $newCrudData['libelle']=$Badges->libelle;
                $newCrudData['css']=$Badges->css;
                $newCrudData['node_version']=$Badges->node_version;
                        $newCrudData['identifiants_sadge']=$Badges->identifiants_sadge;
                $newCrudData['creat_by']=$Badges->creat_by;
    
 try{ $newCrudData['client']=$Badges->client->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Badges','entite_cle' => $Badges->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Badges->toArray();




try{

foreach ($Badges->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Badge $Badges)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des badges');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['client_id']=$Badges->client_id;
                $newCrudData['content']=$Badges->content;
                        $newCrudData['js']=$Badges->js;
                $newCrudData['libelle']=$Badges->libelle;
                $newCrudData['css']=$Badges->css;
                $newCrudData['node_version']=$Badges->node_version;
                        $newCrudData['identifiants_sadge']=$Badges->identifiants_sadge;
                $newCrudData['creat_by']=$Badges->creat_by;
    
 try{ $newCrudData['client']=$Badges->client->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Badges','entite_cle' => $Badges->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\BadgeExtras') &&
method_exists('\App\Http\Extras\BadgeExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\BadgeExtras::canDelete($request, $Badges);
}catch (\Throwable $e){

}

}



if($canSave){
$Badges->delete();
}else{
return response()->json($Badges, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\BadgesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
