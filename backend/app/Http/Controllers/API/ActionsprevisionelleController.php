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
// use App\Repository\prod\ActionsprevisionellesRepository;
use App\Models\Actionsprevisionelle;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Besoin;
    
class ActionsprevisionelleController extends Controller
{

private $ActionsprevisionellesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ActionsprevisionellesRepository $ActionsprevisionellesRepository
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
class_exists('\App\Http\Extras\ActionsprevisionelleExtras') &&
method_exists('\App\Http\Extras\ActionsprevisionelleExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ActionsprevisionelleExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Actionsprevisionelle::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ActionsprevisionelleExtras') &&
method_exists('\App\Http\Extras\ActionsprevisionelleExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ActionsprevisionelleExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('actionsprevisionelles',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ActionsprevisionelleExtras') &&
method_exists('\App\Http\Extras\ActionsprevisionelleExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ActionsprevisionelleExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  actionsprevisionelles reussi',
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
return response()->json(Actionsprevisionelle::count());
}
$data = QueryBuilder::for(Actionsprevisionelle::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('descriptions'),

    
            AllowedFilter::exact('debut_previsionnel'),

    
            AllowedFilter::exact('fin_previsionnel'),

    
            AllowedFilter::exact('debut_reel'),

    
            AllowedFilter::exact('fin_reel'),

    
            AllowedFilter::exact('besoin_id'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('evaluation'),

    
            AllowedFilter::exact('valider'),

    
            AllowedFilter::exact('type'),

    
    
    
    
    
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

    
            AllowedSort::field('besoin_id'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('evaluation'),

    
            AllowedSort::field('valider'),

    
            AllowedSort::field('type'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([
            'actionsrealises',
        

    
            'besoin',
        

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




$data = QueryBuilder::for(Actionsprevisionelle::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('descriptions'),

    
            AllowedFilter::exact('debut_previsionnel'),

    
            AllowedFilter::exact('fin_previsionnel'),

    
            AllowedFilter::exact('debut_reel'),

    
            AllowedFilter::exact('fin_reel'),

    
            AllowedFilter::exact('besoin_id'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('evaluation'),

    
            AllowedFilter::exact('valider'),

    
            AllowedFilter::exact('type'),

    
    
    
    
    
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

    
            AllowedSort::field('besoin_id'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('evaluation'),

    
            AllowedSort::field('valider'),

    
            AllowedSort::field('type'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([
            'actionsrealises',
        

                'besoin',
        

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



public function create(Request $request, Actionsprevisionelle $Actionsprevisionelles)
{


try{
$can=\App\Helpers\Helpers::can('Creer des actionsprevisionelles');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "actionsprevisionelles"."-".$key."_".time().".".$file->extension()
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
    'besoin_id',
    'creat_by',
    'evaluation',
    'valider',
    'type',
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
        
    
    
                    'besoin_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'evaluation' => [
            //'required'
            ],
        
    
    
                    'valider' => [
            //'required'
            ],
        
    
    
                    'type' => [
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

    
    
        'besoin_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'evaluation' => ['cette donnee est obligatoire'],

    
    
        'valider' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Actionsprevisionelles->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['descriptions'])){
        
            $Actionsprevisionelles->descriptions = $data['descriptions'];
        
        }



    







    

        if(!empty($data['debut_previsionnel'])){
        
            $Actionsprevisionelles->debut_previsionnel = $data['debut_previsionnel'];
        
        }



    







    

        if(!empty($data['fin_previsionnel'])){
        
            $Actionsprevisionelles->fin_previsionnel = $data['fin_previsionnel'];
        
        }



    







    

        if(!empty($data['debut_reel'])){
        
            $Actionsprevisionelles->debut_reel = $data['debut_reel'];
        
        }



    







    

        if(!empty($data['fin_reel'])){
        
            $Actionsprevisionelles->fin_reel = $data['fin_reel'];
        
        }



    







    

        if(!empty($data['besoin_id'])){
        
            $Actionsprevisionelles->besoin_id = $data['besoin_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Actionsprevisionelles->creat_by = $data['creat_by'];
        
        }



    







    

        if(!empty($data['evaluation'])){
        
            $Actionsprevisionelles->evaluation = $data['evaluation'];
        
        }



    







    

        if(!empty($data['valider'])){
        
            $Actionsprevisionelles->valider = $data['valider'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Actionsprevisionelles->type = $data['type'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Actionsprevisionelles->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Actionsprevisionelles->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ActionsprevisionelleExtras') &&
method_exists('\App\Http\Extras\ActionsprevisionelleExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ActionsprevisionelleExtras::beforeSaveCreate($request,$Actionsprevisionelles);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ActionsprevisionelleExtras') &&
method_exists('\App\Http\Extras\ActionsprevisionelleExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ActionsprevisionelleExtras::canCreate($request, $Actionsprevisionelles);
}catch (\Throwable $e){

}

}


if($canSave){
$Actionsprevisionelles->save();
}else{
return response()->json($Actionsprevisionelles, 200);
}

$Actionsprevisionelles=Actionsprevisionelle::find($Actionsprevisionelles->id);
$newCrudData=[];

                $newCrudData['libelle']=$Actionsprevisionelles->libelle;
                $newCrudData['descriptions']=$Actionsprevisionelles->descriptions;
                $newCrudData['debut_previsionnel']=$Actionsprevisionelles->debut_previsionnel;
                $newCrudData['fin_previsionnel']=$Actionsprevisionelles->fin_previsionnel;
                $newCrudData['debut_reel']=$Actionsprevisionelles->debut_reel;
                $newCrudData['fin_reel']=$Actionsprevisionelles->fin_reel;
                $newCrudData['besoin_id']=$Actionsprevisionelles->besoin_id;
                $newCrudData['creat_by']=$Actionsprevisionelles->creat_by;
                $newCrudData['evaluation']=$Actionsprevisionelles->evaluation;
                $newCrudData['valider']=$Actionsprevisionelles->valider;
                $newCrudData['type']=$Actionsprevisionelles->type;
                                $newCrudData['identifiants_sadge']=$Actionsprevisionelles->identifiants_sadge;
    
 try{ $newCrudData['besoin']=$Actionsprevisionelles->besoin->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Actionsprevisionelles','entite_cle' => $Actionsprevisionelles->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Actionsprevisionelles->toArray();




try{

foreach ($Actionsprevisionelles->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Actionsprevisionelle $Actionsprevisionelles)
{
try{
$can=\App\Helpers\Helpers::can('Editer des actionsprevisionelles');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Actionsprevisionelles->libelle;
                $oldCrudData['descriptions']=$Actionsprevisionelles->descriptions;
                $oldCrudData['debut_previsionnel']=$Actionsprevisionelles->debut_previsionnel;
                $oldCrudData['fin_previsionnel']=$Actionsprevisionelles->fin_previsionnel;
                $oldCrudData['debut_reel']=$Actionsprevisionelles->debut_reel;
                $oldCrudData['fin_reel']=$Actionsprevisionelles->fin_reel;
                $oldCrudData['besoin_id']=$Actionsprevisionelles->besoin_id;
                $oldCrudData['creat_by']=$Actionsprevisionelles->creat_by;
                $oldCrudData['evaluation']=$Actionsprevisionelles->evaluation;
                $oldCrudData['valider']=$Actionsprevisionelles->valider;
                $oldCrudData['type']=$Actionsprevisionelles->type;
                                $oldCrudData['identifiants_sadge']=$Actionsprevisionelles->identifiants_sadge;
    
 try{ $oldCrudData['besoin']=$Actionsprevisionelles->besoin->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "actionsprevisionelles"."-".$key."_".time().".".$file->extension()
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
    'besoin_id',
    'creat_by',
    'evaluation',
    'valider',
    'type',
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
        
    
    
                    'besoin_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'evaluation' => [
            //'required'
            ],
        
    
    
                    'valider' => [
            //'required'
            ],
        
    
    
                    'type' => [
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

    
    
        'besoin_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'evaluation' => ['cette donnee est obligatoire'],

    
    
        'valider' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Actionsprevisionelles->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("descriptions",$data)){


        if(!empty($data['descriptions'])){
        
            $Actionsprevisionelles->descriptions = $data['descriptions'];
        
        }

        }

    







    

        if(array_key_exists("debut_previsionnel",$data)){


        if(!empty($data['debut_previsionnel'])){
        
            $Actionsprevisionelles->debut_previsionnel = $data['debut_previsionnel'];
        
        }

        }

    







    

        if(array_key_exists("fin_previsionnel",$data)){


        if(!empty($data['fin_previsionnel'])){
        
            $Actionsprevisionelles->fin_previsionnel = $data['fin_previsionnel'];
        
        }

        }

    







    

        if(array_key_exists("debut_reel",$data)){


        if(!empty($data['debut_reel'])){
        
            $Actionsprevisionelles->debut_reel = $data['debut_reel'];
        
        }

        }

    







    

        if(array_key_exists("fin_reel",$data)){


        if(!empty($data['fin_reel'])){
        
            $Actionsprevisionelles->fin_reel = $data['fin_reel'];
        
        }

        }

    







    

        if(array_key_exists("besoin_id",$data)){


        if(!empty($data['besoin_id'])){
        
            $Actionsprevisionelles->besoin_id = $data['besoin_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Actionsprevisionelles->creat_by = $data['creat_by'];
        
        }

        }

    







    

        if(array_key_exists("evaluation",$data)){


        if(!empty($data['evaluation'])){
        
            $Actionsprevisionelles->evaluation = $data['evaluation'];
        
        }

        }

    







    

        if(array_key_exists("valider",$data)){


        if(!empty($data['valider'])){
        
            $Actionsprevisionelles->valider = $data['valider'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Actionsprevisionelles->type = $data['type'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Actionsprevisionelles->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Actionsprevisionelles->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ActionsprevisionelleExtras') &&
method_exists('\App\Http\Extras\ActionsprevisionelleExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ActionsprevisionelleExtras::beforeSaveUpdate($request,$Actionsprevisionelles);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ActionsprevisionelleExtras') &&
method_exists('\App\Http\Extras\ActionsprevisionelleExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ActionsprevisionelleExtras::canUpdate($request, $Actionsprevisionelles);
}catch (\Throwable $e){

}

}


if($canSave){
$Actionsprevisionelles->save();
}else{
return response()->json($Actionsprevisionelles, 200);

}


$Actionsprevisionelles=Actionsprevisionelle::find($Actionsprevisionelles->id);



$newCrudData=[];

                $newCrudData['libelle']=$Actionsprevisionelles->libelle;
                $newCrudData['descriptions']=$Actionsprevisionelles->descriptions;
                $newCrudData['debut_previsionnel']=$Actionsprevisionelles->debut_previsionnel;
                $newCrudData['fin_previsionnel']=$Actionsprevisionelles->fin_previsionnel;
                $newCrudData['debut_reel']=$Actionsprevisionelles->debut_reel;
                $newCrudData['fin_reel']=$Actionsprevisionelles->fin_reel;
                $newCrudData['besoin_id']=$Actionsprevisionelles->besoin_id;
                $newCrudData['creat_by']=$Actionsprevisionelles->creat_by;
                $newCrudData['evaluation']=$Actionsprevisionelles->evaluation;
                $newCrudData['valider']=$Actionsprevisionelles->valider;
                $newCrudData['type']=$Actionsprevisionelles->type;
                                $newCrudData['identifiants_sadge']=$Actionsprevisionelles->identifiants_sadge;
    
 try{ $newCrudData['besoin']=$Actionsprevisionelles->besoin->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Actionsprevisionelles','entite_cle' => $Actionsprevisionelles->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Actionsprevisionelles->toArray();




try{

foreach ($Actionsprevisionelles->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Actionsprevisionelle $Actionsprevisionelles)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des actionsprevisionelles');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Actionsprevisionelles->libelle;
                $newCrudData['descriptions']=$Actionsprevisionelles->descriptions;
                $newCrudData['debut_previsionnel']=$Actionsprevisionelles->debut_previsionnel;
                $newCrudData['fin_previsionnel']=$Actionsprevisionelles->fin_previsionnel;
                $newCrudData['debut_reel']=$Actionsprevisionelles->debut_reel;
                $newCrudData['fin_reel']=$Actionsprevisionelles->fin_reel;
                $newCrudData['besoin_id']=$Actionsprevisionelles->besoin_id;
                $newCrudData['creat_by']=$Actionsprevisionelles->creat_by;
                $newCrudData['evaluation']=$Actionsprevisionelles->evaluation;
                $newCrudData['valider']=$Actionsprevisionelles->valider;
                $newCrudData['type']=$Actionsprevisionelles->type;
                                $newCrudData['identifiants_sadge']=$Actionsprevisionelles->identifiants_sadge;
    
 try{ $newCrudData['besoin']=$Actionsprevisionelles->besoin->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Actionsprevisionelles','entite_cle' => $Actionsprevisionelles->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ActionsprevisionelleExtras') &&
method_exists('\App\Http\Extras\ActionsprevisionelleExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ActionsprevisionelleExtras::canDelete($request, $Actionsprevisionelles);
}catch (\Throwable $e){

}

}



if($canSave){
$Actionsprevisionelles->delete();
}else{
return response()->json($Actionsprevisionelles, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ActionsprevisionellesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
