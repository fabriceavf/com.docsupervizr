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
// use App\Repository\prod\ContratssitesRepository;
use App\Models\Contratssite;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Contratsclient;
                use App\Models\Prestation;
                use App\Models\Site;
    
class ContratssiteController extends Controller
{

private $ContratssitesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ContratssitesRepository $ContratssitesRepository
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
class_exists('\App\Http\Extras\ContratssiteExtras') &&
method_exists('\App\Http\Extras\ContratssiteExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ContratssiteExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Contratssite::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ContratssiteExtras') &&
method_exists('\App\Http\Extras\ContratssiteExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ContratssiteExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('contratssites',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ContratssiteExtras') &&
method_exists('\App\Http\Extras\ContratssiteExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ContratssiteExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  contratssites reussi',
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
return response()->json(Contratssite::count());
}
$data = QueryBuilder::for(Contratssite::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('contratsclient_id'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('prestation_id'),

    
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

    
            AllowedSort::field('contratsclient_id'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('prestation_id'),

    
            AllowedSort::field('agentsjour'),

    
            AllowedSort::field('agentsnuit'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
->allowedIncludes([
            'contratspostes',
        

    
            'contratsclient',
        

                'prestation',
        

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




$data = QueryBuilder::for(Contratssite::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('contratsclient_id'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('prestation_id'),

    
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

    
            AllowedSort::field('contratsclient_id'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('prestation_id'),

    
            AllowedSort::field('agentsjour'),

    
            AllowedSort::field('agentsnuit'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
->allowedIncludes([
            'contratspostes',
        

                'contratsclient',
        

                'prestation',
        

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



public function create(Request $request, Contratssite $Contratssites)
{


try{
$can=\App\Helpers\Helpers::can('Creer des contratssites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "contratssites"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'contratsclient_id',
    'site_id',
    'prestation_id',
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
    
    
                    'contratsclient_id' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'prestation_id' => [
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

    
    
        'contratsclient_id' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'prestation_id' => ['cette donnee est obligatoire'],

    
    
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








    







    

        if(!empty($data['contratsclient_id'])){
        
            $Contratssites->contratsclient_id = $data['contratsclient_id'];
        
        }



    







    

        if(!empty($data['site_id'])){
        
            $Contratssites->site_id = $data['site_id'];
        
        }



    







    

        if(!empty($data['prestation_id'])){
        
            $Contratssites->prestation_id = $data['prestation_id'];
        
        }



    







    

        if(!empty($data['agentsjour'])){
        
            $Contratssites->agentsjour = $data['agentsjour'];
        
        }



    







    

        if(!empty($data['agentsnuit'])){
        
            $Contratssites->agentsnuit = $data['agentsnuit'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Contratssites->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Contratssites->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Contratssites->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ContratssiteExtras') &&
method_exists('\App\Http\Extras\ContratssiteExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ContratssiteExtras::beforeSaveCreate($request,$Contratssites);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ContratssiteExtras') &&
method_exists('\App\Http\Extras\ContratssiteExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ContratssiteExtras::canCreate($request, $Contratssites);
}catch (\Throwable $e){

}

}


if($canSave){
$Contratssites->save();
}else{
return response()->json($Contratssites, 200);
}

$Contratssites=Contratssite::find($Contratssites->id);
$newCrudData=[];

                $newCrudData['contratsclient_id']=$Contratssites->contratsclient_id;
                $newCrudData['site_id']=$Contratssites->site_id;
                $newCrudData['prestation_id']=$Contratssites->prestation_id;
                $newCrudData['agentsjour']=$Contratssites->agentsjour;
                $newCrudData['agentsnuit']=$Contratssites->agentsnuit;
                                $newCrudData['identifiants_sadge']=$Contratssites->identifiants_sadge;
                $newCrudData['creat_by']=$Contratssites->creat_by;
    
 try{ $newCrudData['contratsclient']=$Contratssites->contratsclient->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['prestation']=$Contratssites->prestation->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Contratssites->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Contratssites','entite_cle' => $Contratssites->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Contratssites->toArray();




try{

foreach ($Contratssites->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Contratssite $Contratssites)
{
try{
$can=\App\Helpers\Helpers::can('Editer des contratssites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['contratsclient_id']=$Contratssites->contratsclient_id;
                $oldCrudData['site_id']=$Contratssites->site_id;
                $oldCrudData['prestation_id']=$Contratssites->prestation_id;
                $oldCrudData['agentsjour']=$Contratssites->agentsjour;
                $oldCrudData['agentsnuit']=$Contratssites->agentsnuit;
                                $oldCrudData['identifiants_sadge']=$Contratssites->identifiants_sadge;
                $oldCrudData['creat_by']=$Contratssites->creat_by;
    
 try{ $oldCrudData['contratsclient']=$Contratssites->contratsclient->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['prestation']=$Contratssites->prestation->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['site']=$Contratssites->site->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "contratssites"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'contratsclient_id',
    'site_id',
    'prestation_id',
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
    
    
                    'contratsclient_id' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'prestation_id' => [
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

    
    
        'contratsclient_id' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'prestation_id' => ['cette donnee est obligatoire'],

    
    
        'agentsjour' => ['cette donnee est obligatoire'],

    
    
        'agentsnuit' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("contratsclient_id",$data)){


        if(!empty($data['contratsclient_id'])){
        
            $Contratssites->contratsclient_id = $data['contratsclient_id'];
        
        }

        }

    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Contratssites->site_id = $data['site_id'];
        
        }

        }

    







    

        if(array_key_exists("prestation_id",$data)){


        if(!empty($data['prestation_id'])){
        
            $Contratssites->prestation_id = $data['prestation_id'];
        
        }

        }

    







    

        if(array_key_exists("agentsjour",$data)){


        if(!empty($data['agentsjour'])){
        
            $Contratssites->agentsjour = $data['agentsjour'];
        
        }

        }

    







    

        if(array_key_exists("agentsnuit",$data)){


        if(!empty($data['agentsnuit'])){
        
            $Contratssites->agentsnuit = $data['agentsnuit'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Contratssites->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Contratssites->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Contratssites->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ContratssiteExtras') &&
method_exists('\App\Http\Extras\ContratssiteExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ContratssiteExtras::beforeSaveUpdate($request,$Contratssites);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ContratssiteExtras') &&
method_exists('\App\Http\Extras\ContratssiteExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ContratssiteExtras::canUpdate($request, $Contratssites);
}catch (\Throwable $e){

}

}


if($canSave){
$Contratssites->save();
}else{
return response()->json($Contratssites, 200);

}


$Contratssites=Contratssite::find($Contratssites->id);



$newCrudData=[];

                $newCrudData['contratsclient_id']=$Contratssites->contratsclient_id;
                $newCrudData['site_id']=$Contratssites->site_id;
                $newCrudData['prestation_id']=$Contratssites->prestation_id;
                $newCrudData['agentsjour']=$Contratssites->agentsjour;
                $newCrudData['agentsnuit']=$Contratssites->agentsnuit;
                                $newCrudData['identifiants_sadge']=$Contratssites->identifiants_sadge;
                $newCrudData['creat_by']=$Contratssites->creat_by;
    
 try{ $newCrudData['contratsclient']=$Contratssites->contratsclient->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['prestation']=$Contratssites->prestation->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Contratssites->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Contratssites','entite_cle' => $Contratssites->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Contratssites->toArray();




try{

foreach ($Contratssites->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Contratssite $Contratssites)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des contratssites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['contratsclient_id']=$Contratssites->contratsclient_id;
                $newCrudData['site_id']=$Contratssites->site_id;
                $newCrudData['prestation_id']=$Contratssites->prestation_id;
                $newCrudData['agentsjour']=$Contratssites->agentsjour;
                $newCrudData['agentsnuit']=$Contratssites->agentsnuit;
                                $newCrudData['identifiants_sadge']=$Contratssites->identifiants_sadge;
                $newCrudData['creat_by']=$Contratssites->creat_by;
    
 try{ $newCrudData['contratsclient']=$Contratssites->contratsclient->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['prestation']=$Contratssites->prestation->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Contratssites->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Contratssites','entite_cle' => $Contratssites->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ContratssiteExtras') &&
method_exists('\App\Http\Extras\ContratssiteExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ContratssiteExtras::canDelete($request, $Contratssites);
}catch (\Throwable $e){

}

}



if($canSave){
$Contratssites->delete();
}else{
return response()->json($Contratssites, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ContratssitesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
