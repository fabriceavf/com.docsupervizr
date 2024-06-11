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
// use App\Repository\prod\ZonesRepository;
use App\Models\Zone;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Province;
                use App\Models\Ville;
    
class ZoneController extends Controller
{

private $ZonesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ZonesRepository $ZonesRepository
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
class_exists('\App\Http\Extras\ZoneExtras') &&
method_exists('\App\Http\Extras\ZoneExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ZoneExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Zone::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ZoneExtras') &&
method_exists('\App\Http\Extras\ZoneExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ZoneExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('zones',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ZoneExtras') &&
method_exists('\App\Http\Extras\ZoneExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ZoneExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  zones reussi',
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
return response()->json(Zone::count());
}
$data = QueryBuilder::for(Zone::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('province_id'),

    
    
    
            AllowedFilter::exact('total_titulaires_therorique'),

    
            AllowedFilter::exact('total_titulaires_reel_jour'),

    
            AllowedFilter::exact('total_titulaires_reel_nuit'),

    
            AllowedFilter::exact('total_present_jour'),

    
            AllowedFilter::exact('total_present_nuit'),

    
            AllowedFilter::exact('ordre'),

    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('ville_id'),

    
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

    
            AllowedSort::field('province_id'),

    
    
    
            AllowedSort::field('total_titulaires_therorique'),

    
            AllowedSort::field('total_titulaires_reel_jour'),

    
            AllowedSort::field('total_titulaires_reel_nuit'),

    
            AllowedSort::field('total_present_jour'),

    
            AllowedSort::field('total_present_nuit'),

    
            AllowedSort::field('ordre'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('ville_id'),

    
])
    
    
->allowedIncludes([
            'homezones',
        

                'listings',
        

                'modelslistings',
        

                'programmations',
        

                'programmationsrondes',
        

                'rapports',
        

                'sites',
        

                'users',
        

                'userszones',
        

                'villeszones',
        

    
            'province',
        

                'ville',
        

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




$data = QueryBuilder::for(Zone::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('province_id'),

    
    
    
            AllowedFilter::exact('total_titulaires_therorique'),

    
            AllowedFilter::exact('total_titulaires_reel_jour'),

    
            AllowedFilter::exact('total_titulaires_reel_nuit'),

    
            AllowedFilter::exact('total_present_jour'),

    
            AllowedFilter::exact('total_present_nuit'),

    
            AllowedFilter::exact('ordre'),

    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('ville_id'),

    
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

    
            AllowedSort::field('province_id'),

    
    
    
            AllowedSort::field('total_titulaires_therorique'),

    
            AllowedSort::field('total_titulaires_reel_jour'),

    
            AllowedSort::field('total_titulaires_reel_nuit'),

    
            AllowedSort::field('total_present_jour'),

    
            AllowedSort::field('total_present_nuit'),

    
            AllowedSort::field('ordre'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('ville_id'),

    
])
    
    
->allowedIncludes([
            'homezones',
        

                'listings',
        

                'modelslistings',
        

                'programmations',
        

                'programmationsrondes',
        

                'rapports',
        

                'sites',
        

                'users',
        

                'userszones',
        

                'villeszones',
        

                'province',
        

                'ville',
        

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



public function create(Request $request, Zone $Zones)
{


try{
$can=\App\Helpers\Helpers::can('Creer des zones');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "zones"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'libelle',
    'province_id',
    'created_at',
    'updated_at',
    'total_titulaires_therorique',
    'total_titulaires_reel_jour',
    'total_titulaires_reel_nuit',
    'total_present_jour',
    'total_present_nuit',
    'ordre',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
    'ville_id',
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
        
    
    
                    'province_id' => [
            //'required'
            ],
        
    
    
    
    
                    'total_titulaires_therorique' => [
            //'required'
            ],
        
    
    
                    'total_titulaires_reel_jour' => [
            //'required'
            ],
        
    
    
                    'total_titulaires_reel_nuit' => [
            //'required'
            ],
        
    
    
                    'total_present_jour' => [
            //'required'
            ],
        
    
    
                    'total_present_nuit' => [
            //'required'
            ],
        
    
    
                    'ordre' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'ville_id' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'province_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'total_titulaires_therorique' => ['cette donnee est obligatoire'],

    
    
        'total_titulaires_reel_jour' => ['cette donnee est obligatoire'],

    
    
        'total_titulaires_reel_nuit' => ['cette donnee est obligatoire'],

    
    
        'total_present_jour' => ['cette donnee est obligatoire'],

    
    
        'total_present_nuit' => ['cette donnee est obligatoire'],

    
    
        'ordre' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'ville_id' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['code'])){
        
            $Zones->code = $data['code'];
        
        }



    







    

        if(!empty($data['libelle'])){
        
            $Zones->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['province_id'])){
        
            $Zones->province_id = $data['province_id'];
        
        }



    







    







    







    

        if(!empty($data['total_titulaires_therorique'])){
        
            $Zones->total_titulaires_therorique = $data['total_titulaires_therorique'];
        
        }



    







    

        if(!empty($data['total_titulaires_reel_jour'])){
        
            $Zones->total_titulaires_reel_jour = $data['total_titulaires_reel_jour'];
        
        }



    







    

        if(!empty($data['total_titulaires_reel_nuit'])){
        
            $Zones->total_titulaires_reel_nuit = $data['total_titulaires_reel_nuit'];
        
        }



    







    

        if(!empty($data['total_present_jour'])){
        
            $Zones->total_present_jour = $data['total_present_jour'];
        
        }



    







    

        if(!empty($data['total_present_nuit'])){
        
            $Zones->total_present_nuit = $data['total_present_nuit'];
        
        }



    







    

        if(!empty($data['ordre'])){
        
            $Zones->ordre = $data['ordre'];
        
        }



    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Zones->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Zones->creat_by = $data['creat_by'];
        
        }



    







    

        if(!empty($data['ville_id'])){
        
            $Zones->ville_id = $data['ville_id'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Zones->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ZoneExtras') &&
method_exists('\App\Http\Extras\ZoneExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ZoneExtras::beforeSaveCreate($request,$Zones);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ZoneExtras') &&
method_exists('\App\Http\Extras\ZoneExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ZoneExtras::canCreate($request, $Zones);
}catch (\Throwable $e){

}

}


if($canSave){
$Zones->save();
}else{
return response()->json($Zones, 200);
}

$Zones=Zone::find($Zones->id);
$newCrudData=[];

                $newCrudData['code']=$Zones->code;
                $newCrudData['libelle']=$Zones->libelle;
                $newCrudData['province_id']=$Zones->province_id;
                        $newCrudData['total_titulaires_therorique']=$Zones->total_titulaires_therorique;
                $newCrudData['total_titulaires_reel_jour']=$Zones->total_titulaires_reel_jour;
                $newCrudData['total_titulaires_reel_nuit']=$Zones->total_titulaires_reel_nuit;
                $newCrudData['total_present_jour']=$Zones->total_present_jour;
                $newCrudData['total_present_nuit']=$Zones->total_present_nuit;
                $newCrudData['ordre']=$Zones->ordre;
                        $newCrudData['identifiants_sadge']=$Zones->identifiants_sadge;
                $newCrudData['creat_by']=$Zones->creat_by;
                $newCrudData['ville_id']=$Zones->ville_id;
    
 try{ $newCrudData['province']=$Zones->province->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Zones->ville->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Zones','entite_cle' => $Zones->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Zones->toArray();




try{

foreach ($Zones->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Zone $Zones)
{
try{
$can=\App\Helpers\Helpers::can('Editer des zones');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['code']=$Zones->code;
                $oldCrudData['libelle']=$Zones->libelle;
                $oldCrudData['province_id']=$Zones->province_id;
                        $oldCrudData['total_titulaires_therorique']=$Zones->total_titulaires_therorique;
                $oldCrudData['total_titulaires_reel_jour']=$Zones->total_titulaires_reel_jour;
                $oldCrudData['total_titulaires_reel_nuit']=$Zones->total_titulaires_reel_nuit;
                $oldCrudData['total_present_jour']=$Zones->total_present_jour;
                $oldCrudData['total_present_nuit']=$Zones->total_present_nuit;
                $oldCrudData['ordre']=$Zones->ordre;
                        $oldCrudData['identifiants_sadge']=$Zones->identifiants_sadge;
                $oldCrudData['creat_by']=$Zones->creat_by;
                $oldCrudData['ville_id']=$Zones->ville_id;
    
 try{ $oldCrudData['province']=$Zones->province->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['ville']=$Zones->ville->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "zones"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'libelle',
    'province_id',
    'created_at',
    'updated_at',
    'total_titulaires_therorique',
    'total_titulaires_reel_jour',
    'total_titulaires_reel_nuit',
    'total_present_jour',
    'total_present_nuit',
    'ordre',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
    'ville_id',
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
        
    
    
                    'province_id' => [
            //'required'
            ],
        
    
    
    
    
                    'total_titulaires_therorique' => [
            //'required'
            ],
        
    
    
                    'total_titulaires_reel_jour' => [
            //'required'
            ],
        
    
    
                    'total_titulaires_reel_nuit' => [
            //'required'
            ],
        
    
    
                    'total_present_jour' => [
            //'required'
            ],
        
    
    
                    'total_present_nuit' => [
            //'required'
            ],
        
    
    
                    'ordre' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'ville_id' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'province_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'total_titulaires_therorique' => ['cette donnee est obligatoire'],

    
    
        'total_titulaires_reel_jour' => ['cette donnee est obligatoire'],

    
    
        'total_titulaires_reel_nuit' => ['cette donnee est obligatoire'],

    
    
        'total_present_jour' => ['cette donnee est obligatoire'],

    
    
        'total_present_nuit' => ['cette donnee est obligatoire'],

    
    
        'ordre' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'ville_id' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("code",$data)){


        if(!empty($data['code'])){
        
            $Zones->code = $data['code'];
        
        }

        }

    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Zones->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("province_id",$data)){


        if(!empty($data['province_id'])){
        
            $Zones->province_id = $data['province_id'];
        
        }

        }

    







    







    







    

        if(array_key_exists("total_titulaires_therorique",$data)){


        if(!empty($data['total_titulaires_therorique'])){
        
            $Zones->total_titulaires_therorique = $data['total_titulaires_therorique'];
        
        }

        }

    







    

        if(array_key_exists("total_titulaires_reel_jour",$data)){


        if(!empty($data['total_titulaires_reel_jour'])){
        
            $Zones->total_titulaires_reel_jour = $data['total_titulaires_reel_jour'];
        
        }

        }

    







    

        if(array_key_exists("total_titulaires_reel_nuit",$data)){


        if(!empty($data['total_titulaires_reel_nuit'])){
        
            $Zones->total_titulaires_reel_nuit = $data['total_titulaires_reel_nuit'];
        
        }

        }

    







    

        if(array_key_exists("total_present_jour",$data)){


        if(!empty($data['total_present_jour'])){
        
            $Zones->total_present_jour = $data['total_present_jour'];
        
        }

        }

    







    

        if(array_key_exists("total_present_nuit",$data)){


        if(!empty($data['total_present_nuit'])){
        
            $Zones->total_present_nuit = $data['total_present_nuit'];
        
        }

        }

    







    

        if(array_key_exists("ordre",$data)){


        if(!empty($data['ordre'])){
        
            $Zones->ordre = $data['ordre'];
        
        }

        }

    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Zones->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Zones->creat_by = $data['creat_by'];
        
        }

        }

    







    

        if(array_key_exists("ville_id",$data)){


        if(!empty($data['ville_id'])){
        
            $Zones->ville_id = $data['ville_id'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Zones->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ZoneExtras') &&
method_exists('\App\Http\Extras\ZoneExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ZoneExtras::beforeSaveUpdate($request,$Zones);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ZoneExtras') &&
method_exists('\App\Http\Extras\ZoneExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ZoneExtras::canUpdate($request, $Zones);
}catch (\Throwable $e){

}

}


if($canSave){
$Zones->save();
}else{
return response()->json($Zones, 200);

}


$Zones=Zone::find($Zones->id);



$newCrudData=[];

                $newCrudData['code']=$Zones->code;
                $newCrudData['libelle']=$Zones->libelle;
                $newCrudData['province_id']=$Zones->province_id;
                        $newCrudData['total_titulaires_therorique']=$Zones->total_titulaires_therorique;
                $newCrudData['total_titulaires_reel_jour']=$Zones->total_titulaires_reel_jour;
                $newCrudData['total_titulaires_reel_nuit']=$Zones->total_titulaires_reel_nuit;
                $newCrudData['total_present_jour']=$Zones->total_present_jour;
                $newCrudData['total_present_nuit']=$Zones->total_present_nuit;
                $newCrudData['ordre']=$Zones->ordre;
                        $newCrudData['identifiants_sadge']=$Zones->identifiants_sadge;
                $newCrudData['creat_by']=$Zones->creat_by;
                $newCrudData['ville_id']=$Zones->ville_id;
    
 try{ $newCrudData['province']=$Zones->province->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Zones->ville->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Zones','entite_cle' => $Zones->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Zones->toArray();




try{

foreach ($Zones->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Zone $Zones)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des zones');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['code']=$Zones->code;
                $newCrudData['libelle']=$Zones->libelle;
                $newCrudData['province_id']=$Zones->province_id;
                        $newCrudData['total_titulaires_therorique']=$Zones->total_titulaires_therorique;
                $newCrudData['total_titulaires_reel_jour']=$Zones->total_titulaires_reel_jour;
                $newCrudData['total_titulaires_reel_nuit']=$Zones->total_titulaires_reel_nuit;
                $newCrudData['total_present_jour']=$Zones->total_present_jour;
                $newCrudData['total_present_nuit']=$Zones->total_present_nuit;
                $newCrudData['ordre']=$Zones->ordre;
                        $newCrudData['identifiants_sadge']=$Zones->identifiants_sadge;
                $newCrudData['creat_by']=$Zones->creat_by;
                $newCrudData['ville_id']=$Zones->ville_id;
    
 try{ $newCrudData['province']=$Zones->province->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Zones->ville->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Zones','entite_cle' => $Zones->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ZoneExtras') &&
method_exists('\App\Http\Extras\ZoneExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ZoneExtras::canDelete($request, $Zones);
}catch (\Throwable $e){

}

}



if($canSave){
$Zones->delete();
}else{
return response()->json($Zones, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ZonesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
