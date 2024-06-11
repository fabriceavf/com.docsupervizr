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
// use App\Repository\prod\PostesagentsRepository;
use App\Models\Postesagent;
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
        
class PostesagentController extends Controller
{

private $PostesagentsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\PostesagentsRepository $PostesagentsRepository
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
class_exists('\App\Http\Extras\PostesagentExtras') &&
method_exists('\App\Http\Extras\PostesagentExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\PostesagentExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Postesagent::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\PostesagentExtras') &&
method_exists('\App\Http\Extras\PostesagentExtras', 'filterAgGridQuery')
){
\App\Http\Extras\PostesagentExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('postesagents',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\PostesagentExtras') &&
method_exists('\App\Http\Extras\PostesagentExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\PostesagentExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  postesagents reussi',
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
return response()->json(Postesagent::count());
}
$data = QueryBuilder::for(Postesagent::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('faction'),

    
    
    
    
    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
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

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('faction'),

    
    
    
    
    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([

            'poste',
        

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




$data = QueryBuilder::for(Postesagent::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('faction'),

    
    
    
    
    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
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

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('faction'),

    
    
    
    
    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'poste',
        

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



public function create(Request $request, Postesagent $Postesagents)
{


try{
$can=\App\Helpers\Helpers::can('Creer des postesagents');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "postesagents"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'poste_id',
    'user_id',
    'faction',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
    
                    'faction' => [
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
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
    
        'faction' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['poste_id'])){
        
            $Postesagents->poste_id = $data['poste_id'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Postesagents->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['faction'])){
        
            $Postesagents->faction = $data['faction'];
        
        }



    







    







    







    







    







    

        if(!empty($data['lun'])){
        
            $Postesagents->lun = $data['lun'];
        
        }



    







    

        if(!empty($data['mar'])){
        
            $Postesagents->mar = $data['mar'];
        
        }



    







    

        if(!empty($data['mer'])){
        
            $Postesagents->mer = $data['mer'];
        
        }



    







    

        if(!empty($data['jeu'])){
        
            $Postesagents->jeu = $data['jeu'];
        
        }



    







    

        if(!empty($data['ven'])){
        
            $Postesagents->ven = $data['ven'];
        
        }



    







    

        if(!empty($data['sam'])){
        
            $Postesagents->sam = $data['sam'];
        
        }



    







    

        if(!empty($data['dim'])){
        
            $Postesagents->dim = $data['dim'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Postesagents->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Postesagents->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Postesagents->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\PostesagentExtras') &&
method_exists('\App\Http\Extras\PostesagentExtras', 'beforeSaveCreate')
){
\App\Http\Extras\PostesagentExtras::beforeSaveCreate($request,$Postesagents);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PostesagentExtras') &&
method_exists('\App\Http\Extras\PostesagentExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\PostesagentExtras::canCreate($request, $Postesagents);
}catch (\Throwable $e){

}

}


if($canSave){
$Postesagents->save();
}else{
return response()->json($Postesagents, 200);
}

$Postesagents=Postesagent::find($Postesagents->id);
$newCrudData=[];

                $newCrudData['poste_id']=$Postesagents->poste_id;
                $newCrudData['user_id']=$Postesagents->user_id;
                $newCrudData['faction']=$Postesagents->faction;
                                $newCrudData['lun']=$Postesagents->lun;
                $newCrudData['mar']=$Postesagents->mar;
                $newCrudData['mer']=$Postesagents->mer;
                $newCrudData['jeu']=$Postesagents->jeu;
                $newCrudData['ven']=$Postesagents->ven;
                $newCrudData['sam']=$Postesagents->sam;
                $newCrudData['dim']=$Postesagents->dim;
                $newCrudData['identifiants_sadge']=$Postesagents->identifiants_sadge;
                $newCrudData['creat_by']=$Postesagents->creat_by;
    
 try{ $newCrudData['poste']=$Postesagents->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Postesagents->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Postesagents','entite_cle' => $Postesagents->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Postesagents->toArray();




try{

foreach ($Postesagents->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Postesagent $Postesagents)
{
try{
$can=\App\Helpers\Helpers::can('Editer des postesagents');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['poste_id']=$Postesagents->poste_id;
                $oldCrudData['user_id']=$Postesagents->user_id;
                $oldCrudData['faction']=$Postesagents->faction;
                                $oldCrudData['lun']=$Postesagents->lun;
                $oldCrudData['mar']=$Postesagents->mar;
                $oldCrudData['mer']=$Postesagents->mer;
                $oldCrudData['jeu']=$Postesagents->jeu;
                $oldCrudData['ven']=$Postesagents->ven;
                $oldCrudData['sam']=$Postesagents->sam;
                $oldCrudData['dim']=$Postesagents->dim;
                $oldCrudData['identifiants_sadge']=$Postesagents->identifiants_sadge;
                $oldCrudData['creat_by']=$Postesagents->creat_by;
    
 try{ $oldCrudData['poste']=$Postesagents->poste->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Postesagents->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "postesagents"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'poste_id',
    'user_id',
    'faction',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
    
                    'faction' => [
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
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
    
        'faction' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("poste_id",$data)){


        if(!empty($data['poste_id'])){
        
            $Postesagents->poste_id = $data['poste_id'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Postesagents->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("faction",$data)){


        if(!empty($data['faction'])){
        
            $Postesagents->faction = $data['faction'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("lun",$data)){


        if(!empty($data['lun'])){
        
            $Postesagents->lun = $data['lun'];
        
        }

        }

    







    

        if(array_key_exists("mar",$data)){


        if(!empty($data['mar'])){
        
            $Postesagents->mar = $data['mar'];
        
        }

        }

    







    

        if(array_key_exists("mer",$data)){


        if(!empty($data['mer'])){
        
            $Postesagents->mer = $data['mer'];
        
        }

        }

    







    

        if(array_key_exists("jeu",$data)){


        if(!empty($data['jeu'])){
        
            $Postesagents->jeu = $data['jeu'];
        
        }

        }

    







    

        if(array_key_exists("ven",$data)){


        if(!empty($data['ven'])){
        
            $Postesagents->ven = $data['ven'];
        
        }

        }

    







    

        if(array_key_exists("sam",$data)){


        if(!empty($data['sam'])){
        
            $Postesagents->sam = $data['sam'];
        
        }

        }

    







    

        if(array_key_exists("dim",$data)){


        if(!empty($data['dim'])){
        
            $Postesagents->dim = $data['dim'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Postesagents->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Postesagents->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Postesagents->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\PostesagentExtras') &&
method_exists('\App\Http\Extras\PostesagentExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\PostesagentExtras::beforeSaveUpdate($request,$Postesagents);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PostesagentExtras') &&
method_exists('\App\Http\Extras\PostesagentExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\PostesagentExtras::canUpdate($request, $Postesagents);
}catch (\Throwable $e){

}

}


if($canSave){
$Postesagents->save();
}else{
return response()->json($Postesagents, 200);

}


$Postesagents=Postesagent::find($Postesagents->id);



$newCrudData=[];

                $newCrudData['poste_id']=$Postesagents->poste_id;
                $newCrudData['user_id']=$Postesagents->user_id;
                $newCrudData['faction']=$Postesagents->faction;
                                $newCrudData['lun']=$Postesagents->lun;
                $newCrudData['mar']=$Postesagents->mar;
                $newCrudData['mer']=$Postesagents->mer;
                $newCrudData['jeu']=$Postesagents->jeu;
                $newCrudData['ven']=$Postesagents->ven;
                $newCrudData['sam']=$Postesagents->sam;
                $newCrudData['dim']=$Postesagents->dim;
                $newCrudData['identifiants_sadge']=$Postesagents->identifiants_sadge;
                $newCrudData['creat_by']=$Postesagents->creat_by;
    
 try{ $newCrudData['poste']=$Postesagents->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Postesagents->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Postesagents','entite_cle' => $Postesagents->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Postesagents->toArray();




try{

foreach ($Postesagents->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Postesagent $Postesagents)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des postesagents');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['poste_id']=$Postesagents->poste_id;
                $newCrudData['user_id']=$Postesagents->user_id;
                $newCrudData['faction']=$Postesagents->faction;
                                $newCrudData['lun']=$Postesagents->lun;
                $newCrudData['mar']=$Postesagents->mar;
                $newCrudData['mer']=$Postesagents->mer;
                $newCrudData['jeu']=$Postesagents->jeu;
                $newCrudData['ven']=$Postesagents->ven;
                $newCrudData['sam']=$Postesagents->sam;
                $newCrudData['dim']=$Postesagents->dim;
                $newCrudData['identifiants_sadge']=$Postesagents->identifiants_sadge;
                $newCrudData['creat_by']=$Postesagents->creat_by;
    
 try{ $newCrudData['poste']=$Postesagents->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Postesagents->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Postesagents','entite_cle' => $Postesagents->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\PostesagentExtras') &&
method_exists('\App\Http\Extras\PostesagentExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\PostesagentExtras::canDelete($request, $Postesagents);
}catch (\Throwable $e){

}

}



if($canSave){
$Postesagents->delete();
}else{
return response()->json($Postesagents, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\PostesagentsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
