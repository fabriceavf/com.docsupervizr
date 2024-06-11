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
// use App\Repository\prod\ActionsrealisesRepository;
use App\Models\Actionsrealise;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Actionsprevisionelle;
    
class ActionsrealiseController extends Controller
{

private $ActionsrealisesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ActionsrealisesRepository $ActionsrealisesRepository
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
class_exists('\App\Http\Extras\ActionsrealiseExtras') &&
method_exists('\App\Http\Extras\ActionsrealiseExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ActionsrealiseExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Actionsrealise::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ActionsrealiseExtras') &&
method_exists('\App\Http\Extras\ActionsrealiseExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ActionsrealiseExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('actionsrealises',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ActionsrealiseExtras') &&
method_exists('\App\Http\Extras\ActionsrealiseExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ActionsrealiseExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  actionsrealises reussi',
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
return response()->json(Actionsrealise::count());
}
$data = QueryBuilder::for(Actionsrealise::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('descriptions'),

    
            AllowedFilter::exact('debut_previsionnel'),

    
            AllowedFilter::exact('fin_previsionnel'),

    
            AllowedFilter::exact('debut_reel'),

    
            AllowedFilter::exact('fin_reel'),

    
            AllowedFilter::exact('actionsprevisionelle_id'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('evaluation'),

    
    
    
    
    
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

    
            AllowedSort::field('actionsprevisionelle_id'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('evaluation'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([

            'actionsprevisionelle',
        

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




$data = QueryBuilder::for(Actionsrealise::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('descriptions'),

    
            AllowedFilter::exact('debut_previsionnel'),

    
            AllowedFilter::exact('fin_previsionnel'),

    
            AllowedFilter::exact('debut_reel'),

    
            AllowedFilter::exact('fin_reel'),

    
            AllowedFilter::exact('actionsprevisionelle_id'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('evaluation'),

    
    
    
    
    
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

    
            AllowedSort::field('actionsprevisionelle_id'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('evaluation'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([
            'actionsprevisionelle',
        

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



public function create(Request $request, Actionsrealise $Actionsrealises)
{


try{
$can=\App\Helpers\Helpers::can('Creer des actionsrealises');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "actionsrealises"."-".$key."_".time().".".$file->extension()
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
    'actionsprevisionelle_id',
    'creat_by',
    'evaluation',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
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
        
    
    
                    'actionsprevisionelle_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'evaluation' => [
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

    
    
        'actionsprevisionelle_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'evaluation' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Actionsrealises->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['descriptions'])){
        
            $Actionsrealises->descriptions = $data['descriptions'];
        
        }



    







    

        if(!empty($data['debut_previsionnel'])){
        
            $Actionsrealises->debut_previsionnel = $data['debut_previsionnel'];
        
        }



    







    

        if(!empty($data['fin_previsionnel'])){
        
            $Actionsrealises->fin_previsionnel = $data['fin_previsionnel'];
        
        }



    







    

        if(!empty($data['debut_reel'])){
        
            $Actionsrealises->debut_reel = $data['debut_reel'];
        
        }



    







    

        if(!empty($data['fin_reel'])){
        
            $Actionsrealises->fin_reel = $data['fin_reel'];
        
        }



    







    

        if(!empty($data['actionsprevisionelle_id'])){
        
            $Actionsrealises->actionsprevisionelle_id = $data['actionsprevisionelle_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Actionsrealises->creat_by = $data['creat_by'];
        
        }



    







    

        if(!empty($data['evaluation'])){
        
            $Actionsrealises->evaluation = $data['evaluation'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Actionsrealises->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Actionsrealises->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ActionsrealiseExtras') &&
method_exists('\App\Http\Extras\ActionsrealiseExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ActionsrealiseExtras::beforeSaveCreate($request,$Actionsrealises);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ActionsrealiseExtras') &&
method_exists('\App\Http\Extras\ActionsrealiseExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ActionsrealiseExtras::canCreate($request, $Actionsrealises);
}catch (\Throwable $e){

}

}


if($canSave){
$Actionsrealises->save();
}else{
return response()->json($Actionsrealises, 200);
}

$Actionsrealises=Actionsrealise::find($Actionsrealises->id);
$newCrudData=[];

                $newCrudData['libelle']=$Actionsrealises->libelle;
                $newCrudData['descriptions']=$Actionsrealises->descriptions;
                $newCrudData['debut_previsionnel']=$Actionsrealises->debut_previsionnel;
                $newCrudData['fin_previsionnel']=$Actionsrealises->fin_previsionnel;
                $newCrudData['debut_reel']=$Actionsrealises->debut_reel;
                $newCrudData['fin_reel']=$Actionsrealises->fin_reel;
                $newCrudData['actionsprevisionelle_id']=$Actionsrealises->actionsprevisionelle_id;
                $newCrudData['creat_by']=$Actionsrealises->creat_by;
                $newCrudData['evaluation']=$Actionsrealises->evaluation;
                                $newCrudData['identifiants_sadge']=$Actionsrealises->identifiants_sadge;
    
 try{ $newCrudData['actionsprevisionelle']=$Actionsrealises->actionsprevisionelle->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Actionsrealises','entite_cle' => $Actionsrealises->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Actionsrealises->toArray();




try{

foreach ($Actionsrealises->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Actionsrealise $Actionsrealises)
{
try{
$can=\App\Helpers\Helpers::can('Editer des actionsrealises');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Actionsrealises->libelle;
                $oldCrudData['descriptions']=$Actionsrealises->descriptions;
                $oldCrudData['debut_previsionnel']=$Actionsrealises->debut_previsionnel;
                $oldCrudData['fin_previsionnel']=$Actionsrealises->fin_previsionnel;
                $oldCrudData['debut_reel']=$Actionsrealises->debut_reel;
                $oldCrudData['fin_reel']=$Actionsrealises->fin_reel;
                $oldCrudData['actionsprevisionelle_id']=$Actionsrealises->actionsprevisionelle_id;
                $oldCrudData['creat_by']=$Actionsrealises->creat_by;
                $oldCrudData['evaluation']=$Actionsrealises->evaluation;
                                $oldCrudData['identifiants_sadge']=$Actionsrealises->identifiants_sadge;
    
 try{ $oldCrudData['actionsprevisionelle']=$Actionsrealises->actionsprevisionelle->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "actionsrealises"."-".$key."_".time().".".$file->extension()
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
    'actionsprevisionelle_id',
    'creat_by',
    'evaluation',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
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
        
    
    
                    'actionsprevisionelle_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'evaluation' => [
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

    
    
        'actionsprevisionelle_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'evaluation' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Actionsrealises->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("descriptions",$data)){


        if(!empty($data['descriptions'])){
        
            $Actionsrealises->descriptions = $data['descriptions'];
        
        }

        }

    







    

        if(array_key_exists("debut_previsionnel",$data)){


        if(!empty($data['debut_previsionnel'])){
        
            $Actionsrealises->debut_previsionnel = $data['debut_previsionnel'];
        
        }

        }

    







    

        if(array_key_exists("fin_previsionnel",$data)){


        if(!empty($data['fin_previsionnel'])){
        
            $Actionsrealises->fin_previsionnel = $data['fin_previsionnel'];
        
        }

        }

    







    

        if(array_key_exists("debut_reel",$data)){


        if(!empty($data['debut_reel'])){
        
            $Actionsrealises->debut_reel = $data['debut_reel'];
        
        }

        }

    







    

        if(array_key_exists("fin_reel",$data)){


        if(!empty($data['fin_reel'])){
        
            $Actionsrealises->fin_reel = $data['fin_reel'];
        
        }

        }

    







    

        if(array_key_exists("actionsprevisionelle_id",$data)){


        if(!empty($data['actionsprevisionelle_id'])){
        
            $Actionsrealises->actionsprevisionelle_id = $data['actionsprevisionelle_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Actionsrealises->creat_by = $data['creat_by'];
        
        }

        }

    







    

        if(array_key_exists("evaluation",$data)){


        if(!empty($data['evaluation'])){
        
            $Actionsrealises->evaluation = $data['evaluation'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Actionsrealises->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Actionsrealises->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ActionsrealiseExtras') &&
method_exists('\App\Http\Extras\ActionsrealiseExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ActionsrealiseExtras::beforeSaveUpdate($request,$Actionsrealises);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ActionsrealiseExtras') &&
method_exists('\App\Http\Extras\ActionsrealiseExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ActionsrealiseExtras::canUpdate($request, $Actionsrealises);
}catch (\Throwable $e){

}

}


if($canSave){
$Actionsrealises->save();
}else{
return response()->json($Actionsrealises, 200);

}


$Actionsrealises=Actionsrealise::find($Actionsrealises->id);



$newCrudData=[];

                $newCrudData['libelle']=$Actionsrealises->libelle;
                $newCrudData['descriptions']=$Actionsrealises->descriptions;
                $newCrudData['debut_previsionnel']=$Actionsrealises->debut_previsionnel;
                $newCrudData['fin_previsionnel']=$Actionsrealises->fin_previsionnel;
                $newCrudData['debut_reel']=$Actionsrealises->debut_reel;
                $newCrudData['fin_reel']=$Actionsrealises->fin_reel;
                $newCrudData['actionsprevisionelle_id']=$Actionsrealises->actionsprevisionelle_id;
                $newCrudData['creat_by']=$Actionsrealises->creat_by;
                $newCrudData['evaluation']=$Actionsrealises->evaluation;
                                $newCrudData['identifiants_sadge']=$Actionsrealises->identifiants_sadge;
    
 try{ $newCrudData['actionsprevisionelle']=$Actionsrealises->actionsprevisionelle->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Actionsrealises','entite_cle' => $Actionsrealises->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Actionsrealises->toArray();




try{

foreach ($Actionsrealises->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Actionsrealise $Actionsrealises)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des actionsrealises');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Actionsrealises->libelle;
                $newCrudData['descriptions']=$Actionsrealises->descriptions;
                $newCrudData['debut_previsionnel']=$Actionsrealises->debut_previsionnel;
                $newCrudData['fin_previsionnel']=$Actionsrealises->fin_previsionnel;
                $newCrudData['debut_reel']=$Actionsrealises->debut_reel;
                $newCrudData['fin_reel']=$Actionsrealises->fin_reel;
                $newCrudData['actionsprevisionelle_id']=$Actionsrealises->actionsprevisionelle_id;
                $newCrudData['creat_by']=$Actionsrealises->creat_by;
                $newCrudData['evaluation']=$Actionsrealises->evaluation;
                                $newCrudData['identifiants_sadge']=$Actionsrealises->identifiants_sadge;
    
 try{ $newCrudData['actionsprevisionelle']=$Actionsrealises->actionsprevisionelle->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Actionsrealises','entite_cle' => $Actionsrealises->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ActionsrealiseExtras') &&
method_exists('\App\Http\Extras\ActionsrealiseExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ActionsrealiseExtras::canDelete($request, $Actionsrealises);
}catch (\Throwable $e){

}

}



if($canSave){
$Actionsrealises->delete();
}else{
return response()->json($Actionsrealises, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ActionsrealisesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
