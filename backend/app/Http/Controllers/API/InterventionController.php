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
// use App\Repository\prod\InterventionsRepository;
use App\Models\Intervention;
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
                use App\Models\Site;
    
class InterventionController extends Controller
{

private $InterventionsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\InterventionsRepository $InterventionsRepository
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
class_exists('\App\Http\Extras\InterventionExtras') &&
method_exists('\App\Http\Extras\InterventionExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\InterventionExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Intervention::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\InterventionExtras') &&
method_exists('\App\Http\Extras\InterventionExtras', 'filterAgGridQuery')
){
\App\Http\Extras\InterventionExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('interventions',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\InterventionExtras') &&
method_exists('\App\Http\Extras\InterventionExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\InterventionExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  interventions reussi',
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
return response()->json(Intervention::count());
}
$data = QueryBuilder::for(Intervention::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('ref'),

    
            AllowedFilter::exact('agent'),

    
            AllowedFilter::exact('debut_prevu'),

    
            AllowedFilter::exact('debut_realise'),

    
            AllowedFilter::exact('fin_prevu'),

    
            AllowedFilter::exact('fin_realise'),

    
            AllowedFilter::exact('etats'),

    
    
    
    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('site_libelle'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('client_libelle'),

    
    
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

    
            AllowedSort::field('ref'),

    
            AllowedSort::field('agent'),

    
            AllowedSort::field('debut_prevu'),

    
            AllowedSort::field('debut_realise'),

    
            AllowedSort::field('fin_prevu'),

    
            AllowedSort::field('fin_realise'),

    
            AllowedSort::field('etats'),

    
    
    
    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('site_libelle'),

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('client_libelle'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'interventionimages',
        

                'interventionusers',
        

                'materielinterventions',
        

    
            'client',
        

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




$data = QueryBuilder::for(Intervention::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('ref'),

    
            AllowedFilter::exact('agent'),

    
            AllowedFilter::exact('debut_prevu'),

    
            AllowedFilter::exact('debut_realise'),

    
            AllowedFilter::exact('fin_prevu'),

    
            AllowedFilter::exact('fin_realise'),

    
            AllowedFilter::exact('etats'),

    
    
    
    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('site_libelle'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('client_libelle'),

    
    
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

    
            AllowedSort::field('ref'),

    
            AllowedSort::field('agent'),

    
            AllowedSort::field('debut_prevu'),

    
            AllowedSort::field('debut_realise'),

    
            AllowedSort::field('fin_prevu'),

    
            AllowedSort::field('fin_realise'),

    
            AllowedSort::field('etats'),

    
    
    
    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('site_libelle'),

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('client_libelle'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'interventionimages',
        

                'interventionusers',
        

                'materielinterventions',
        

                'client',
        

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



public function create(Request $request, Intervention $Interventions)
{


try{
$can=\App\Helpers\Helpers::can('Creer des interventions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "interventions"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'ref',
    'agent',
    'debut_prevu',
    'debut_realise',
    'fin_prevu',
    'fin_realise',
    'etats',
    'extra_attributes',
    'created_at',
    'updated_at',
    'site_id',
    'site_libelle',
    'client_id',
    'client_libelle',
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
    
    
                    'ref' => [
            //'required'
            ],
        
    
    
                    'agent' => [
            //'required'
            ],
        
    
    
                    'debut_prevu' => [
            //'required'
            ],
        
    
    
                    'debut_realise' => [
            //'required'
            ],
        
    
    
                    'fin_prevu' => [
            //'required'
            ],
        
    
    
                    'fin_realise' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
    
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'site_libelle' => [
            //'required'
            ],
        
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'client_libelle' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'ref' => ['cette donnee est obligatoire'],

    
    
        'agent' => ['cette donnee est obligatoire'],

    
    
        'debut_prevu' => ['cette donnee est obligatoire'],

    
    
        'debut_realise' => ['cette donnee est obligatoire'],

    
    
        'fin_prevu' => ['cette donnee est obligatoire'],

    
    
        'fin_realise' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'site_libelle' => ['cette donnee est obligatoire'],

    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'client_libelle' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['ref'])){
        
            $Interventions->ref = $data['ref'];
        
        }



    







    

        if(!empty($data['agent'])){
        
            $Interventions->agent = $data['agent'];
        
        }



    







    

        if(!empty($data['debut_prevu'])){
        
            $Interventions->debut_prevu = $data['debut_prevu'];
        
        }



    







    

        if(!empty($data['debut_realise'])){
        
            $Interventions->debut_realise = $data['debut_realise'];
        
        }



    







    

        if(!empty($data['fin_prevu'])){
        
            $Interventions->fin_prevu = $data['fin_prevu'];
        
        }



    







    

        if(!empty($data['fin_realise'])){
        
            $Interventions->fin_realise = $data['fin_realise'];
        
        }



    







    

        if(!empty($data['etats'])){
        
            $Interventions->etats = $data['etats'];
        
        }



    







    







    







    







    

        if(!empty($data['site_id'])){
        
            $Interventions->site_id = $data['site_id'];
        
        }



    







    

        if(!empty($data['site_libelle'])){
        
            $Interventions->site_libelle = $data['site_libelle'];
        
        }



    







    

        if(!empty($data['client_id'])){
        
            $Interventions->client_id = $data['client_id'];
        
        }



    







    

        if(!empty($data['client_libelle'])){
        
            $Interventions->client_libelle = $data['client_libelle'];
        
        }



    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Interventions->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Interventions->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Interventions->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\InterventionExtras') &&
method_exists('\App\Http\Extras\InterventionExtras', 'beforeSaveCreate')
){
\App\Http\Extras\InterventionExtras::beforeSaveCreate($request,$Interventions);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\InterventionExtras') &&
method_exists('\App\Http\Extras\InterventionExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\InterventionExtras::canCreate($request, $Interventions);
}catch (\Throwable $e){

}

}


if($canSave){
$Interventions->save();
}else{
return response()->json($Interventions, 200);
}

$Interventions=Intervention::find($Interventions->id);
$newCrudData=[];

                $newCrudData['ref']=$Interventions->ref;
                $newCrudData['agent']=$Interventions->agent;
                $newCrudData['debut_prevu']=$Interventions->debut_prevu;
                $newCrudData['debut_realise']=$Interventions->debut_realise;
                $newCrudData['fin_prevu']=$Interventions->fin_prevu;
                $newCrudData['fin_realise']=$Interventions->fin_realise;
                $newCrudData['etats']=$Interventions->etats;
                            $newCrudData['site_id']=$Interventions->site_id;
                $newCrudData['site_libelle']=$Interventions->site_libelle;
                $newCrudData['client_id']=$Interventions->client_id;
                $newCrudData['client_libelle']=$Interventions->client_libelle;
                    $newCrudData['identifiants_sadge']=$Interventions->identifiants_sadge;
                $newCrudData['creat_by']=$Interventions->creat_by;
    
 try{ $newCrudData['client']=$Interventions->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Interventions->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Interventions','entite_cle' => $Interventions->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Interventions->toArray();




try{

foreach ($Interventions->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Intervention $Interventions)
{
try{
$can=\App\Helpers\Helpers::can('Editer des interventions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['ref']=$Interventions->ref;
                $oldCrudData['agent']=$Interventions->agent;
                $oldCrudData['debut_prevu']=$Interventions->debut_prevu;
                $oldCrudData['debut_realise']=$Interventions->debut_realise;
                $oldCrudData['fin_prevu']=$Interventions->fin_prevu;
                $oldCrudData['fin_realise']=$Interventions->fin_realise;
                $oldCrudData['etats']=$Interventions->etats;
                            $oldCrudData['site_id']=$Interventions->site_id;
                $oldCrudData['site_libelle']=$Interventions->site_libelle;
                $oldCrudData['client_id']=$Interventions->client_id;
                $oldCrudData['client_libelle']=$Interventions->client_libelle;
                    $oldCrudData['identifiants_sadge']=$Interventions->identifiants_sadge;
                $oldCrudData['creat_by']=$Interventions->creat_by;
    
 try{ $oldCrudData['client']=$Interventions->client->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['site']=$Interventions->site->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "interventions"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'ref',
    'agent',
    'debut_prevu',
    'debut_realise',
    'fin_prevu',
    'fin_realise',
    'etats',
    'extra_attributes',
    'created_at',
    'updated_at',
    'site_id',
    'site_libelle',
    'client_id',
    'client_libelle',
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
    
    
                    'ref' => [
            //'required'
            ],
        
    
    
                    'agent' => [
            //'required'
            ],
        
    
    
                    'debut_prevu' => [
            //'required'
            ],
        
    
    
                    'debut_realise' => [
            //'required'
            ],
        
    
    
                    'fin_prevu' => [
            //'required'
            ],
        
    
    
                    'fin_realise' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
    
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'site_libelle' => [
            //'required'
            ],
        
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'client_libelle' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'ref' => ['cette donnee est obligatoire'],

    
    
        'agent' => ['cette donnee est obligatoire'],

    
    
        'debut_prevu' => ['cette donnee est obligatoire'],

    
    
        'debut_realise' => ['cette donnee est obligatoire'],

    
    
        'fin_prevu' => ['cette donnee est obligatoire'],

    
    
        'fin_realise' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'site_libelle' => ['cette donnee est obligatoire'],

    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'client_libelle' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("ref",$data)){


        if(!empty($data['ref'])){
        
            $Interventions->ref = $data['ref'];
        
        }

        }

    







    

        if(array_key_exists("agent",$data)){


        if(!empty($data['agent'])){
        
            $Interventions->agent = $data['agent'];
        
        }

        }

    







    

        if(array_key_exists("debut_prevu",$data)){


        if(!empty($data['debut_prevu'])){
        
            $Interventions->debut_prevu = $data['debut_prevu'];
        
        }

        }

    







    

        if(array_key_exists("debut_realise",$data)){


        if(!empty($data['debut_realise'])){
        
            $Interventions->debut_realise = $data['debut_realise'];
        
        }

        }

    







    

        if(array_key_exists("fin_prevu",$data)){


        if(!empty($data['fin_prevu'])){
        
            $Interventions->fin_prevu = $data['fin_prevu'];
        
        }

        }

    







    

        if(array_key_exists("fin_realise",$data)){


        if(!empty($data['fin_realise'])){
        
            $Interventions->fin_realise = $data['fin_realise'];
        
        }

        }

    







    

        if(array_key_exists("etats",$data)){


        if(!empty($data['etats'])){
        
            $Interventions->etats = $data['etats'];
        
        }

        }

    







    







    







    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Interventions->site_id = $data['site_id'];
        
        }

        }

    







    

        if(array_key_exists("site_libelle",$data)){


        if(!empty($data['site_libelle'])){
        
            $Interventions->site_libelle = $data['site_libelle'];
        
        }

        }

    







    

        if(array_key_exists("client_id",$data)){


        if(!empty($data['client_id'])){
        
            $Interventions->client_id = $data['client_id'];
        
        }

        }

    







    

        if(array_key_exists("client_libelle",$data)){


        if(!empty($data['client_libelle'])){
        
            $Interventions->client_libelle = $data['client_libelle'];
        
        }

        }

    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Interventions->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Interventions->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Interventions->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\InterventionExtras') &&
method_exists('\App\Http\Extras\InterventionExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\InterventionExtras::beforeSaveUpdate($request,$Interventions);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\InterventionExtras') &&
method_exists('\App\Http\Extras\InterventionExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\InterventionExtras::canUpdate($request, $Interventions);
}catch (\Throwable $e){

}

}


if($canSave){
$Interventions->save();
}else{
return response()->json($Interventions, 200);

}


$Interventions=Intervention::find($Interventions->id);



$newCrudData=[];

                $newCrudData['ref']=$Interventions->ref;
                $newCrudData['agent']=$Interventions->agent;
                $newCrudData['debut_prevu']=$Interventions->debut_prevu;
                $newCrudData['debut_realise']=$Interventions->debut_realise;
                $newCrudData['fin_prevu']=$Interventions->fin_prevu;
                $newCrudData['fin_realise']=$Interventions->fin_realise;
                $newCrudData['etats']=$Interventions->etats;
                            $newCrudData['site_id']=$Interventions->site_id;
                $newCrudData['site_libelle']=$Interventions->site_libelle;
                $newCrudData['client_id']=$Interventions->client_id;
                $newCrudData['client_libelle']=$Interventions->client_libelle;
                    $newCrudData['identifiants_sadge']=$Interventions->identifiants_sadge;
                $newCrudData['creat_by']=$Interventions->creat_by;
    
 try{ $newCrudData['client']=$Interventions->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Interventions->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Interventions','entite_cle' => $Interventions->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Interventions->toArray();




try{

foreach ($Interventions->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Intervention $Interventions)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des interventions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['ref']=$Interventions->ref;
                $newCrudData['agent']=$Interventions->agent;
                $newCrudData['debut_prevu']=$Interventions->debut_prevu;
                $newCrudData['debut_realise']=$Interventions->debut_realise;
                $newCrudData['fin_prevu']=$Interventions->fin_prevu;
                $newCrudData['fin_realise']=$Interventions->fin_realise;
                $newCrudData['etats']=$Interventions->etats;
                            $newCrudData['site_id']=$Interventions->site_id;
                $newCrudData['site_libelle']=$Interventions->site_libelle;
                $newCrudData['client_id']=$Interventions->client_id;
                $newCrudData['client_libelle']=$Interventions->client_libelle;
                    $newCrudData['identifiants_sadge']=$Interventions->identifiants_sadge;
                $newCrudData['creat_by']=$Interventions->creat_by;
    
 try{ $newCrudData['client']=$Interventions->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Interventions->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Interventions','entite_cle' => $Interventions->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\InterventionExtras') &&
method_exists('\App\Http\Extras\InterventionExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\InterventionExtras::canDelete($request, $Interventions);
}catch (\Throwable $e){

}

}



if($canSave){
$Interventions->delete();
}else{
return response()->json($Interventions, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\InterventionsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
