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
// use App\Repository\prod\HoraireagentsRepository;
use App\Models\Horaireagent;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Horaire;
        
class HoraireagentController extends Controller
{

private $HoraireagentsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\HoraireagentsRepository $HoraireagentsRepository
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
class_exists('\App\Http\Extras\HoraireagentExtras') &&
method_exists('\App\Http\Extras\HoraireagentExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\HoraireagentExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Horaireagent::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\HoraireagentExtras') &&
method_exists('\App\Http\Extras\HoraireagentExtras', 'filterAgGridQuery')
){
\App\Http\Extras\HoraireagentExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('horaireagents',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\HoraireagentExtras') &&
method_exists('\App\Http\Extras\HoraireagentExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\HoraireagentExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  horaireagents reussi',
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
return response()->json(Horaireagent::count());
}
$data = QueryBuilder::for(Horaireagent::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('horaire_id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
    
    
    
    
            AllowedFilter::exact('typesagents'),

    
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

    
            AllowedSort::field('horaire_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
    
    
    
    
            AllowedSort::field('typesagents'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([

            'horaire',
        

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




$data = QueryBuilder::for(Horaireagent::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('horaire_id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
    
    
    
    
            AllowedFilter::exact('typesagents'),

    
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

    
            AllowedSort::field('horaire_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
    
    
    
    
            AllowedSort::field('typesagents'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'horaire',
        

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



public function create(Request $request, Horaireagent $Horaireagents)
{


try{
$can=\App\Helpers\Helpers::can('Creer des horaireagents');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "horaireagents"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'horaire_id',
    'user_id',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'typesagents',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'horaire_id' => [
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
        
    
    
    
    
    
    
                    'typesagents' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'horaire_id' => ['cette donnee est obligatoire'],

    
    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'typesagents' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['horaire_id'])){
        
            $Horaireagents->horaire_id = $data['horaire_id'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Horaireagents->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['lun'])){
        
            $Horaireagents->lun = $data['lun'];
        
        }



    







    

        if(!empty($data['mar'])){
        
            $Horaireagents->mar = $data['mar'];
        
        }



    







    

        if(!empty($data['mer'])){
        
            $Horaireagents->mer = $data['mer'];
        
        }



    







    

        if(!empty($data['jeu'])){
        
            $Horaireagents->jeu = $data['jeu'];
        
        }



    







    

        if(!empty($data['ven'])){
        
            $Horaireagents->ven = $data['ven'];
        
        }



    







    

        if(!empty($data['sam'])){
        
            $Horaireagents->sam = $data['sam'];
        
        }



    







    

        if(!empty($data['dim'])){
        
            $Horaireagents->dim = $data['dim'];
        
        }



    







    







    







    







    







    

        if(!empty($data['typesagents'])){
        
            $Horaireagents->typesagents = $data['typesagents'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Horaireagents->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Horaireagents->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Horaireagents->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\HoraireagentExtras') &&
method_exists('\App\Http\Extras\HoraireagentExtras', 'beforeSaveCreate')
){
\App\Http\Extras\HoraireagentExtras::beforeSaveCreate($request,$Horaireagents);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\HoraireagentExtras') &&
method_exists('\App\Http\Extras\HoraireagentExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\HoraireagentExtras::canCreate($request, $Horaireagents);
}catch (\Throwable $e){

}

}


if($canSave){
$Horaireagents->save();
}else{
return response()->json($Horaireagents, 200);
}

$Horaireagents=Horaireagent::find($Horaireagents->id);
$newCrudData=[];

                $newCrudData['horaire_id']=$Horaireagents->horaire_id;
                $newCrudData['user_id']=$Horaireagents->user_id;
                $newCrudData['lun']=$Horaireagents->lun;
                $newCrudData['mar']=$Horaireagents->mar;
                $newCrudData['mer']=$Horaireagents->mer;
                $newCrudData['jeu']=$Horaireagents->jeu;
                $newCrudData['ven']=$Horaireagents->ven;
                $newCrudData['sam']=$Horaireagents->sam;
                $newCrudData['dim']=$Horaireagents->dim;
                                $newCrudData['typesagents']=$Horaireagents->typesagents;
                $newCrudData['identifiants_sadge']=$Horaireagents->identifiants_sadge;
                $newCrudData['creat_by']=$Horaireagents->creat_by;
    
 try{ $newCrudData['horaire']=$Horaireagents->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Horaireagents->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Horaireagents','entite_cle' => $Horaireagents->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Horaireagents->toArray();




try{

foreach ($Horaireagents->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Horaireagent $Horaireagents)
{
try{
$can=\App\Helpers\Helpers::can('Editer des horaireagents');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['horaire_id']=$Horaireagents->horaire_id;
                $oldCrudData['user_id']=$Horaireagents->user_id;
                $oldCrudData['lun']=$Horaireagents->lun;
                $oldCrudData['mar']=$Horaireagents->mar;
                $oldCrudData['mer']=$Horaireagents->mer;
                $oldCrudData['jeu']=$Horaireagents->jeu;
                $oldCrudData['ven']=$Horaireagents->ven;
                $oldCrudData['sam']=$Horaireagents->sam;
                $oldCrudData['dim']=$Horaireagents->dim;
                                $oldCrudData['typesagents']=$Horaireagents->typesagents;
                $oldCrudData['identifiants_sadge']=$Horaireagents->identifiants_sadge;
                $oldCrudData['creat_by']=$Horaireagents->creat_by;
    
 try{ $oldCrudData['horaire']=$Horaireagents->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Horaireagents->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "horaireagents"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'horaire_id',
    'user_id',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'typesagents',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'horaire_id' => [
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
        
    
    
    
    
    
    
                    'typesagents' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'horaire_id' => ['cette donnee est obligatoire'],

    
    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'typesagents' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("horaire_id",$data)){


        if(!empty($data['horaire_id'])){
        
            $Horaireagents->horaire_id = $data['horaire_id'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Horaireagents->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("lun",$data)){


        if(!empty($data['lun'])){
        
            $Horaireagents->lun = $data['lun'];
        
        }

        }

    







    

        if(array_key_exists("mar",$data)){


        if(!empty($data['mar'])){
        
            $Horaireagents->mar = $data['mar'];
        
        }

        }

    







    

        if(array_key_exists("mer",$data)){


        if(!empty($data['mer'])){
        
            $Horaireagents->mer = $data['mer'];
        
        }

        }

    







    

        if(array_key_exists("jeu",$data)){


        if(!empty($data['jeu'])){
        
            $Horaireagents->jeu = $data['jeu'];
        
        }

        }

    







    

        if(array_key_exists("ven",$data)){


        if(!empty($data['ven'])){
        
            $Horaireagents->ven = $data['ven'];
        
        }

        }

    







    

        if(array_key_exists("sam",$data)){


        if(!empty($data['sam'])){
        
            $Horaireagents->sam = $data['sam'];
        
        }

        }

    







    

        if(array_key_exists("dim",$data)){


        if(!empty($data['dim'])){
        
            $Horaireagents->dim = $data['dim'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("typesagents",$data)){


        if(!empty($data['typesagents'])){
        
            $Horaireagents->typesagents = $data['typesagents'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Horaireagents->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Horaireagents->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Horaireagents->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\HoraireagentExtras') &&
method_exists('\App\Http\Extras\HoraireagentExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\HoraireagentExtras::beforeSaveUpdate($request,$Horaireagents);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\HoraireagentExtras') &&
method_exists('\App\Http\Extras\HoraireagentExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\HoraireagentExtras::canUpdate($request, $Horaireagents);
}catch (\Throwable $e){

}

}


if($canSave){
$Horaireagents->save();
}else{
return response()->json($Horaireagents, 200);

}


$Horaireagents=Horaireagent::find($Horaireagents->id);



$newCrudData=[];

                $newCrudData['horaire_id']=$Horaireagents->horaire_id;
                $newCrudData['user_id']=$Horaireagents->user_id;
                $newCrudData['lun']=$Horaireagents->lun;
                $newCrudData['mar']=$Horaireagents->mar;
                $newCrudData['mer']=$Horaireagents->mer;
                $newCrudData['jeu']=$Horaireagents->jeu;
                $newCrudData['ven']=$Horaireagents->ven;
                $newCrudData['sam']=$Horaireagents->sam;
                $newCrudData['dim']=$Horaireagents->dim;
                                $newCrudData['typesagents']=$Horaireagents->typesagents;
                $newCrudData['identifiants_sadge']=$Horaireagents->identifiants_sadge;
                $newCrudData['creat_by']=$Horaireagents->creat_by;
    
 try{ $newCrudData['horaire']=$Horaireagents->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Horaireagents->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Horaireagents','entite_cle' => $Horaireagents->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Horaireagents->toArray();




try{

foreach ($Horaireagents->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Horaireagent $Horaireagents)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des horaireagents');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['horaire_id']=$Horaireagents->horaire_id;
                $newCrudData['user_id']=$Horaireagents->user_id;
                $newCrudData['lun']=$Horaireagents->lun;
                $newCrudData['mar']=$Horaireagents->mar;
                $newCrudData['mer']=$Horaireagents->mer;
                $newCrudData['jeu']=$Horaireagents->jeu;
                $newCrudData['ven']=$Horaireagents->ven;
                $newCrudData['sam']=$Horaireagents->sam;
                $newCrudData['dim']=$Horaireagents->dim;
                                $newCrudData['typesagents']=$Horaireagents->typesagents;
                $newCrudData['identifiants_sadge']=$Horaireagents->identifiants_sadge;
                $newCrudData['creat_by']=$Horaireagents->creat_by;
    
 try{ $newCrudData['horaire']=$Horaireagents->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Horaireagents->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Horaireagents','entite_cle' => $Horaireagents->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\HoraireagentExtras') &&
method_exists('\App\Http\Extras\HoraireagentExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\HoraireagentExtras::canDelete($request, $Horaireagents);
}catch (\Throwable $e){

}

}



if($canSave){
$Horaireagents->delete();
}else{
return response()->json($Horaireagents, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\HoraireagentsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
