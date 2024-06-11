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
// use App\Repository\prod\ContratspostesRepository;
use App\Models\Contratsposte;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Contratssite;
                use App\Models\Poste;
    
class ContratsposteController extends Controller
{

private $ContratspostesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ContratspostesRepository $ContratspostesRepository
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
class_exists('\App\Http\Extras\ContratsposteExtras') &&
method_exists('\App\Http\Extras\ContratsposteExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ContratsposteExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Contratsposte::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ContratsposteExtras') &&
method_exists('\App\Http\Extras\ContratsposteExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ContratsposteExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('contratspostes',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ContratsposteExtras') &&
method_exists('\App\Http\Extras\ContratsposteExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ContratsposteExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  contratspostes reussi',
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
return response()->json(Contratsposte::count());
}
$data = QueryBuilder::for(Contratsposte::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('contratssite_id'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('jours'),

    
            AllowedFilter::exact('agentsjour'),

    
            AllowedFilter::exact('agentsnuit'),

    
    
    
    
    
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

    
            AllowedSort::field('contratssite_id'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('jours'),

    
            AllowedSort::field('agentsjour'),

    
            AllowedSort::field('agentsnuit'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'contratsagents',
        

    
            'contratssite',
        

                'poste',
        

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




$data = QueryBuilder::for(Contratsposte::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('contratssite_id'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('jours'),

    
            AllowedFilter::exact('agentsjour'),

    
            AllowedFilter::exact('agentsnuit'),

    
    
    
    
    
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

    
            AllowedSort::field('contratssite_id'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('jours'),

    
            AllowedSort::field('agentsjour'),

    
            AllowedSort::field('agentsnuit'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'contratsagents',
        

                'contratssite',
        

                'poste',
        

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



public function create(Request $request, Contratsposte $Contratspostes)
{


try{
$can=\App\Helpers\Helpers::can('Creer des contratspostes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "contratspostes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'contratssite_id',
    'poste_id',
    'jours',
    'agentsjour',
    'agentsnuit',
    'created_at',
    'updated_at',
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
    
    
                    'contratssite_id' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'jours' => [
            //'required'
            ],
        
    
    
                    'agentsjour' => [
            //'required'
            ],
        
    
    
                    'agentsnuit' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'contratssite_id' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'jours' => ['cette donnee est obligatoire'],

    
    
        'agentsjour' => ['cette donnee est obligatoire'],

    
    
        'agentsnuit' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['contratssite_id'])){
        
            $Contratspostes->contratssite_id = $data['contratssite_id'];
        
        }



    







    

        if(!empty($data['poste_id'])){
        
            $Contratspostes->poste_id = $data['poste_id'];
        
        }



    







    

        if(!empty($data['jours'])){
        
            $Contratspostes->jours = $data['jours'];
        
        }



    







    

        if(!empty($data['agentsjour'])){
        
            $Contratspostes->agentsjour = $data['agentsjour'];
        
        }



    







    

        if(!empty($data['agentsnuit'])){
        
            $Contratspostes->agentsnuit = $data['agentsnuit'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Contratspostes->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Contratspostes->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Contratspostes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ContratsposteExtras') &&
method_exists('\App\Http\Extras\ContratsposteExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ContratsposteExtras::beforeSaveCreate($request,$Contratspostes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ContratsposteExtras') &&
method_exists('\App\Http\Extras\ContratsposteExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ContratsposteExtras::canCreate($request, $Contratspostes);
}catch (\Throwable $e){

}

}


if($canSave){
$Contratspostes->save();
}else{
return response()->json($Contratspostes, 200);
}

$Contratspostes=Contratsposte::find($Contratspostes->id);
$newCrudData=[];

                $newCrudData['contratssite_id']=$Contratspostes->contratssite_id;
                $newCrudData['poste_id']=$Contratspostes->poste_id;
                $newCrudData['jours']=$Contratspostes->jours;
                $newCrudData['agentsjour']=$Contratspostes->agentsjour;
                $newCrudData['agentsnuit']=$Contratspostes->agentsnuit;
                                $newCrudData['identifiants_sadge']=$Contratspostes->identifiants_sadge;
                $newCrudData['creat_by']=$Contratspostes->creat_by;
    
 try{ $newCrudData['contratssite']=$Contratspostes->contratssite->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Contratspostes->poste->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Contratspostes','entite_cle' => $Contratspostes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Contratspostes->toArray();




try{

foreach ($Contratspostes->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Contratsposte $Contratspostes)
{
try{
$can=\App\Helpers\Helpers::can('Editer des contratspostes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['contratssite_id']=$Contratspostes->contratssite_id;
                $oldCrudData['poste_id']=$Contratspostes->poste_id;
                $oldCrudData['jours']=$Contratspostes->jours;
                $oldCrudData['agentsjour']=$Contratspostes->agentsjour;
                $oldCrudData['agentsnuit']=$Contratspostes->agentsnuit;
                                $oldCrudData['identifiants_sadge']=$Contratspostes->identifiants_sadge;
                $oldCrudData['creat_by']=$Contratspostes->creat_by;
    
 try{ $oldCrudData['contratssite']=$Contratspostes->contratssite->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['poste']=$Contratspostes->poste->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "contratspostes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'contratssite_id',
    'poste_id',
    'jours',
    'agentsjour',
    'agentsnuit',
    'created_at',
    'updated_at',
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
    
    
                    'contratssite_id' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'jours' => [
            //'required'
            ],
        
    
    
                    'agentsjour' => [
            //'required'
            ],
        
    
    
                    'agentsnuit' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'contratssite_id' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'jours' => ['cette donnee est obligatoire'],

    
    
        'agentsjour' => ['cette donnee est obligatoire'],

    
    
        'agentsnuit' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("contratssite_id",$data)){


        if(!empty($data['contratssite_id'])){
        
            $Contratspostes->contratssite_id = $data['contratssite_id'];
        
        }

        }

    







    

        if(array_key_exists("poste_id",$data)){


        if(!empty($data['poste_id'])){
        
            $Contratspostes->poste_id = $data['poste_id'];
        
        }

        }

    







    

        if(array_key_exists("jours",$data)){


        if(!empty($data['jours'])){
        
            $Contratspostes->jours = $data['jours'];
        
        }

        }

    







    

        if(array_key_exists("agentsjour",$data)){


        if(!empty($data['agentsjour'])){
        
            $Contratspostes->agentsjour = $data['agentsjour'];
        
        }

        }

    







    

        if(array_key_exists("agentsnuit",$data)){


        if(!empty($data['agentsnuit'])){
        
            $Contratspostes->agentsnuit = $data['agentsnuit'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Contratspostes->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Contratspostes->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Contratspostes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ContratsposteExtras') &&
method_exists('\App\Http\Extras\ContratsposteExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ContratsposteExtras::beforeSaveUpdate($request,$Contratspostes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ContratsposteExtras') &&
method_exists('\App\Http\Extras\ContratsposteExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ContratsposteExtras::canUpdate($request, $Contratspostes);
}catch (\Throwable $e){

}

}


if($canSave){
$Contratspostes->save();
}else{
return response()->json($Contratspostes, 200);

}


$Contratspostes=Contratsposte::find($Contratspostes->id);



$newCrudData=[];

                $newCrudData['contratssite_id']=$Contratspostes->contratssite_id;
                $newCrudData['poste_id']=$Contratspostes->poste_id;
                $newCrudData['jours']=$Contratspostes->jours;
                $newCrudData['agentsjour']=$Contratspostes->agentsjour;
                $newCrudData['agentsnuit']=$Contratspostes->agentsnuit;
                                $newCrudData['identifiants_sadge']=$Contratspostes->identifiants_sadge;
                $newCrudData['creat_by']=$Contratspostes->creat_by;
    
 try{ $newCrudData['contratssite']=$Contratspostes->contratssite->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Contratspostes->poste->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Contratspostes','entite_cle' => $Contratspostes->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Contratspostes->toArray();




try{

foreach ($Contratspostes->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Contratsposte $Contratspostes)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des contratspostes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['contratssite_id']=$Contratspostes->contratssite_id;
                $newCrudData['poste_id']=$Contratspostes->poste_id;
                $newCrudData['jours']=$Contratspostes->jours;
                $newCrudData['agentsjour']=$Contratspostes->agentsjour;
                $newCrudData['agentsnuit']=$Contratspostes->agentsnuit;
                                $newCrudData['identifiants_sadge']=$Contratspostes->identifiants_sadge;
                $newCrudData['creat_by']=$Contratspostes->creat_by;
    
 try{ $newCrudData['contratssite']=$Contratspostes->contratssite->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Contratspostes->poste->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Contratspostes','entite_cle' => $Contratspostes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ContratsposteExtras') &&
method_exists('\App\Http\Extras\ContratsposteExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ContratsposteExtras::canDelete($request, $Contratspostes);
}catch (\Throwable $e){

}

}



if($canSave){
$Contratspostes->delete();
}else{
return response()->json($Contratspostes, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ContratspostesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
