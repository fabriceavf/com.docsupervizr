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
// use App\Repository\prod\SitesRepository;
use App\Models\Site;
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
                use App\Models\Pointeuse;
                use App\Models\Typessite;
                use App\Models\Zone;
    
class SiteController extends Controller
{

private $SitesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\SitesRepository $SitesRepository
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
class_exists('\App\Http\Extras\SiteExtras') &&
method_exists('\App\Http\Extras\SiteExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\SiteExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Site::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\SiteExtras') &&
method_exists('\App\Http\Extras\SiteExtras', 'filterAgGridQuery')
){
\App\Http\Extras\SiteExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('sites',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\SiteExtras') &&
method_exists('\App\Http\Extras\SiteExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\SiteExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  sites reussi',
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
return response()->json(Site::count());
}
$data = QueryBuilder::for(Site::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('zone_id'),

    
    
    
            AllowedFilter::exact('pointeuse_id'),

    
            AllowedFilter::exact('NbrsJours'),

    
            AllowedFilter::exact('NbrsNuits'),

    
            AllowedFilter::exact('type'),

    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('pastille'),

    
            AllowedFilter::exact('typessite_id'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('date_fin'),

    
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

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('zone_id'),

    
    
    
            AllowedSort::field('pointeuse_id'),

    
            AllowedSort::field('NbrsJours'),

    
            AllowedSort::field('NbrsNuits'),

    
            AllowedSort::field('type'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('pastille'),

    
            AllowedSort::field('typessite_id'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('date_fin'),

    
])
    
    
    
    
->allowedIncludes([
            'cartes',
        

                'contratssites',
        

                'controlleursacces',
        

                'interventions',
        

                'listings',
        

                'passagesrondes',
        

                'pastilles',
        

                'pointeuses',
        

                'postes',
        

                'rapports',
        

                'sitespointeuses',
        

                'sitessdeplacements',
        

                'taches',
        

                'trajets',
        

                'users',
        

    
            'client',
        

                'pointeuse',
        

                'typessite',
        

                'zone',
        

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




$data = QueryBuilder::for(Site::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('zone_id'),

    
    
    
            AllowedFilter::exact('pointeuse_id'),

    
            AllowedFilter::exact('NbrsJours'),

    
            AllowedFilter::exact('NbrsNuits'),

    
            AllowedFilter::exact('type'),

    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('pastille'),

    
            AllowedFilter::exact('typessite_id'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('date_fin'),

    
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

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('zone_id'),

    
    
    
            AllowedSort::field('pointeuse_id'),

    
            AllowedSort::field('NbrsJours'),

    
            AllowedSort::field('NbrsNuits'),

    
            AllowedSort::field('type'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('pastille'),

    
            AllowedSort::field('typessite_id'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('date_fin'),

    
])
    
    
    
    
->allowedIncludes([
            'cartes',
        

                'contratssites',
        

                'controlleursacces',
        

                'interventions',
        

                'listings',
        

                'passagesrondes',
        

                'pastilles',
        

                'pointeuses',
        

                'postes',
        

                'rapports',
        

                'sitespointeuses',
        

                'sitessdeplacements',
        

                'taches',
        

                'trajets',
        

                'users',
        

                'client',
        

                'pointeuse',
        

                'typessite',
        

                'zone',
        

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



public function create(Request $request, Site $Sites)
{


try{
$can=\App\Helpers\Helpers::can('Creer des sites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "sites"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'client_id',
    'zone_id',
    'created_at',
    'updated_at',
    'pointeuse_id',
    'NbrsJours',
    'NbrsNuits',
    'type',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
    'pastille',
    'typessite_id',
    'date_debut',
    'date_fin',
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
        
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
    
    
                    'pointeuse_id' => [
            //'required'
            ],
        
    
    
                    'NbrsJours' => [
            //'required'
            ],
        
    
    
                    'NbrsNuits' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'pastille' => [
            //'required'
            ],
        
    
    
                    'typessite_id' => [
            //'required'
            ],
        
    
    
                    'date_debut' => [
            //'required'
            ],
        
    
    
                    'date_fin' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'pointeuse_id' => ['cette donnee est obligatoire'],

    
    
        'NbrsJours' => ['cette donnee est obligatoire'],

    
    
        'NbrsNuits' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'pastille' => ['cette donnee est obligatoire'],

    
    
        'typessite_id' => ['cette donnee est obligatoire'],

    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'date_fin' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Sites->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['client_id'])){
        
            $Sites->client_id = $data['client_id'];
        
        }



    







    

        if(!empty($data['zone_id'])){
        
            $Sites->zone_id = $data['zone_id'];
        
        }



    







    







    







    

        if(!empty($data['pointeuse_id'])){
        
            $Sites->pointeuse_id = $data['pointeuse_id'];
        
        }



    







    

        if(!empty($data['NbrsJours'])){
        
            $Sites->NbrsJours = $data['NbrsJours'];
        
        }



    







    

        if(!empty($data['NbrsNuits'])){
        
            $Sites->NbrsNuits = $data['NbrsNuits'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Sites->type = $data['type'];
        
        }



    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Sites->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Sites->creat_by = $data['creat_by'];
        
        }



    







    

        if(!empty($data['pastille'])){
        
            $Sites->pastille = $data['pastille'];
        
        }



    







    

        if(!empty($data['typessite_id'])){
        
            $Sites->typessite_id = $data['typessite_id'];
        
        }



    







    

        if(!empty($data['date_debut'])){
        
            $Sites->date_debut = $data['date_debut'];
        
        }



    







    

        if(!empty($data['date_fin'])){
        
            $Sites->date_fin = $data['date_fin'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Sites->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\SiteExtras') &&
method_exists('\App\Http\Extras\SiteExtras', 'beforeSaveCreate')
){
\App\Http\Extras\SiteExtras::beforeSaveCreate($request,$Sites);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\SiteExtras') &&
method_exists('\App\Http\Extras\SiteExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\SiteExtras::canCreate($request, $Sites);
}catch (\Throwable $e){

}

}


if($canSave){
$Sites->save();
}else{
return response()->json($Sites, 200);
}

$Sites=Site::find($Sites->id);
$newCrudData=[];

                $newCrudData['libelle']=$Sites->libelle;
                $newCrudData['client_id']=$Sites->client_id;
                $newCrudData['zone_id']=$Sites->zone_id;
                        $newCrudData['pointeuse_id']=$Sites->pointeuse_id;
                $newCrudData['NbrsJours']=$Sites->NbrsJours;
                $newCrudData['NbrsNuits']=$Sites->NbrsNuits;
                $newCrudData['type']=$Sites->type;
                        $newCrudData['identifiants_sadge']=$Sites->identifiants_sadge;
                $newCrudData['creat_by']=$Sites->creat_by;
                $newCrudData['pastille']=$Sites->pastille;
                $newCrudData['typessite_id']=$Sites->typessite_id;
                $newCrudData['date_debut']=$Sites->date_debut;
                $newCrudData['date_fin']=$Sites->date_fin;
    
 try{ $newCrudData['client']=$Sites->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['pointeuse']=$Sites->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typessite']=$Sites->typessite->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Sites->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Sites','entite_cle' => $Sites->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Sites->toArray();




try{

foreach ($Sites->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Site $Sites)
{
try{
$can=\App\Helpers\Helpers::can('Editer des sites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Sites->libelle;
                $oldCrudData['client_id']=$Sites->client_id;
                $oldCrudData['zone_id']=$Sites->zone_id;
                        $oldCrudData['pointeuse_id']=$Sites->pointeuse_id;
                $oldCrudData['NbrsJours']=$Sites->NbrsJours;
                $oldCrudData['NbrsNuits']=$Sites->NbrsNuits;
                $oldCrudData['type']=$Sites->type;
                        $oldCrudData['identifiants_sadge']=$Sites->identifiants_sadge;
                $oldCrudData['creat_by']=$Sites->creat_by;
                $oldCrudData['pastille']=$Sites->pastille;
                $oldCrudData['typessite_id']=$Sites->typessite_id;
                $oldCrudData['date_debut']=$Sites->date_debut;
                $oldCrudData['date_fin']=$Sites->date_fin;
    
 try{ $oldCrudData['client']=$Sites->client->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['pointeuse']=$Sites->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['typessite']=$Sites->typessite->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['zone']=$Sites->zone->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "sites"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'client_id',
    'zone_id',
    'created_at',
    'updated_at',
    'pointeuse_id',
    'NbrsJours',
    'NbrsNuits',
    'type',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
    'pastille',
    'typessite_id',
    'date_debut',
    'date_fin',
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
        
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
    
    
                    'pointeuse_id' => [
            //'required'
            ],
        
    
    
                    'NbrsJours' => [
            //'required'
            ],
        
    
    
                    'NbrsNuits' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'pastille' => [
            //'required'
            ],
        
    
    
                    'typessite_id' => [
            //'required'
            ],
        
    
    
                    'date_debut' => [
            //'required'
            ],
        
    
    
                    'date_fin' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'pointeuse_id' => ['cette donnee est obligatoire'],

    
    
        'NbrsJours' => ['cette donnee est obligatoire'],

    
    
        'NbrsNuits' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'pastille' => ['cette donnee est obligatoire'],

    
    
        'typessite_id' => ['cette donnee est obligatoire'],

    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'date_fin' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Sites->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("client_id",$data)){


        if(!empty($data['client_id'])){
        
            $Sites->client_id = $data['client_id'];
        
        }

        }

    







    

        if(array_key_exists("zone_id",$data)){


        if(!empty($data['zone_id'])){
        
            $Sites->zone_id = $data['zone_id'];
        
        }

        }

    







    







    







    

        if(array_key_exists("pointeuse_id",$data)){


        if(!empty($data['pointeuse_id'])){
        
            $Sites->pointeuse_id = $data['pointeuse_id'];
        
        }

        }

    







    

        if(array_key_exists("NbrsJours",$data)){


        if(!empty($data['NbrsJours'])){
        
            $Sites->NbrsJours = $data['NbrsJours'];
        
        }

        }

    







    

        if(array_key_exists("NbrsNuits",$data)){


        if(!empty($data['NbrsNuits'])){
        
            $Sites->NbrsNuits = $data['NbrsNuits'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Sites->type = $data['type'];
        
        }

        }

    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Sites->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Sites->creat_by = $data['creat_by'];
        
        }

        }

    







    

        if(array_key_exists("pastille",$data)){


        if(!empty($data['pastille'])){
        
            $Sites->pastille = $data['pastille'];
        
        }

        }

    







    

        if(array_key_exists("typessite_id",$data)){


        if(!empty($data['typessite_id'])){
        
            $Sites->typessite_id = $data['typessite_id'];
        
        }

        }

    







    

        if(array_key_exists("date_debut",$data)){


        if(!empty($data['date_debut'])){
        
            $Sites->date_debut = $data['date_debut'];
        
        }

        }

    







    

        if(array_key_exists("date_fin",$data)){


        if(!empty($data['date_fin'])){
        
            $Sites->date_fin = $data['date_fin'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Sites->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\SiteExtras') &&
method_exists('\App\Http\Extras\SiteExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\SiteExtras::beforeSaveUpdate($request,$Sites);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\SiteExtras') &&
method_exists('\App\Http\Extras\SiteExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\SiteExtras::canUpdate($request, $Sites);
}catch (\Throwable $e){

}

}


if($canSave){
$Sites->save();
}else{
return response()->json($Sites, 200);

}


$Sites=Site::find($Sites->id);



$newCrudData=[];

                $newCrudData['libelle']=$Sites->libelle;
                $newCrudData['client_id']=$Sites->client_id;
                $newCrudData['zone_id']=$Sites->zone_id;
                        $newCrudData['pointeuse_id']=$Sites->pointeuse_id;
                $newCrudData['NbrsJours']=$Sites->NbrsJours;
                $newCrudData['NbrsNuits']=$Sites->NbrsNuits;
                $newCrudData['type']=$Sites->type;
                        $newCrudData['identifiants_sadge']=$Sites->identifiants_sadge;
                $newCrudData['creat_by']=$Sites->creat_by;
                $newCrudData['pastille']=$Sites->pastille;
                $newCrudData['typessite_id']=$Sites->typessite_id;
                $newCrudData['date_debut']=$Sites->date_debut;
                $newCrudData['date_fin']=$Sites->date_fin;
    
 try{ $newCrudData['client']=$Sites->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['pointeuse']=$Sites->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typessite']=$Sites->typessite->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Sites->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Sites','entite_cle' => $Sites->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Sites->toArray();




try{

foreach ($Sites->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Site $Sites)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des sites');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Sites->libelle;
                $newCrudData['client_id']=$Sites->client_id;
                $newCrudData['zone_id']=$Sites->zone_id;
                        $newCrudData['pointeuse_id']=$Sites->pointeuse_id;
                $newCrudData['NbrsJours']=$Sites->NbrsJours;
                $newCrudData['NbrsNuits']=$Sites->NbrsNuits;
                $newCrudData['type']=$Sites->type;
                        $newCrudData['identifiants_sadge']=$Sites->identifiants_sadge;
                $newCrudData['creat_by']=$Sites->creat_by;
                $newCrudData['pastille']=$Sites->pastille;
                $newCrudData['typessite_id']=$Sites->typessite_id;
                $newCrudData['date_debut']=$Sites->date_debut;
                $newCrudData['date_fin']=$Sites->date_fin;
    
 try{ $newCrudData['client']=$Sites->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['pointeuse']=$Sites->pointeuse->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typessite']=$Sites->typessite->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Sites->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Sites','entite_cle' => $Sites->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\SiteExtras') &&
method_exists('\App\Http\Extras\SiteExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\SiteExtras::canDelete($request, $Sites);
}catch (\Throwable $e){

}

}



if($canSave){
$Sites->delete();
}else{
return response()->json($Sites, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\SitesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
