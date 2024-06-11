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
// use App\Repository\prod\TachesRepository;
use App\Models\Tache;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Site;
                use App\Models\Typestache;
                use App\Models\Ville;
    
class TacheController extends Controller
{

private $TachesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TachesRepository $TachesRepository
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
class_exists('\App\Http\Extras\TacheExtras') &&
method_exists('\App\Http\Extras\TacheExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TacheExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Tache::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TacheExtras') &&
method_exists('\App\Http\Extras\TacheExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TacheExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('taches',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TacheExtras') &&
method_exists('\App\Http\Extras\TacheExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TacheExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  taches reussi',
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
return response()->json(Tache::count());
}
$data = QueryBuilder::for(Tache::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('typestache_id'),

    
            AllowedFilter::exact('libelle'),

    
    
    
    
            AllowedFilter::exact('pastille'),

    
            AllowedFilter::exact('Pointeuses'),

    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('ville_id'),

    
            AllowedFilter::exact('jours'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('maxjours'),

    
            AllowedFilter::exact('maxnuits'),

    
            AllowedFilter::exact('NbrsJours'),

    
            AllowedFilter::exact('NbrsNuits'),

    
            AllowedFilter::exact('IsCouvert'),

    
            AllowedFilter::exact('Agentjour'),

    
            AllowedFilter::exact('Agentnuit'),

    
            AllowedFilter::exact('couvertAgentjour'),

    
            AllowedFilter::exact('couvertAgentnuit'),

    
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

    
            AllowedSort::field('typestache_id'),

    
            AllowedSort::field('libelle'),

    
    
    
    
            AllowedSort::field('pastille'),

    
            AllowedSort::field('Pointeuses'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('ville_id'),

    
            AllowedSort::field('jours'),

    
            AllowedSort::field('code'),

    
            AllowedSort::field('maxjours'),

    
            AllowedSort::field('maxnuits'),

    
            AllowedSort::field('NbrsJours'),

    
            AllowedSort::field('NbrsNuits'),

    
            AllowedSort::field('IsCouvert'),

    
            AllowedSort::field('Agentjour'),

    
            AllowedSort::field('Agentnuit'),

    
            AllowedSort::field('couvertAgentjour'),

    
            AllowedSort::field('couvertAgentnuit'),

    
])
    
    
    
->allowedIncludes([
            'programmations',
        

                'tachespointeuses',
        

                'travailleurs',
        

    
            'site',
        

                'typestache',
        

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




$data = QueryBuilder::for(Tache::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('typestache_id'),

    
            AllowedFilter::exact('libelle'),

    
    
    
    
            AllowedFilter::exact('pastille'),

    
            AllowedFilter::exact('Pointeuses'),

    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('ville_id'),

    
            AllowedFilter::exact('jours'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('maxjours'),

    
            AllowedFilter::exact('maxnuits'),

    
            AllowedFilter::exact('NbrsJours'),

    
            AllowedFilter::exact('NbrsNuits'),

    
            AllowedFilter::exact('IsCouvert'),

    
            AllowedFilter::exact('Agentjour'),

    
            AllowedFilter::exact('Agentnuit'),

    
            AllowedFilter::exact('couvertAgentjour'),

    
            AllowedFilter::exact('couvertAgentnuit'),

    
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

    
            AllowedSort::field('typestache_id'),

    
            AllowedSort::field('libelle'),

    
    
    
    
            AllowedSort::field('pastille'),

    
            AllowedSort::field('Pointeuses'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('ville_id'),

    
            AllowedSort::field('jours'),

    
            AllowedSort::field('code'),

    
            AllowedSort::field('maxjours'),

    
            AllowedSort::field('maxnuits'),

    
            AllowedSort::field('NbrsJours'),

    
            AllowedSort::field('NbrsNuits'),

    
            AllowedSort::field('IsCouvert'),

    
            AllowedSort::field('Agentjour'),

    
            AllowedSort::field('Agentnuit'),

    
            AllowedSort::field('couvertAgentjour'),

    
            AllowedSort::field('couvertAgentnuit'),

    
])
    
    
    
->allowedIncludes([
            'programmations',
        

                'tachespointeuses',
        

                'travailleurs',
        

                'site',
        

                'typestache',
        

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



public function create(Request $request, Tache $Taches)
{


try{
$can=\App\Helpers\Helpers::can('Creer des taches');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "taches"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'typestache_id',
    'libelle',
    'extra_attributes',
    'created_at',
    'updated_at',
    'pastille',
    'Pointeuses',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
    'site_id',
    'ville_id',
    'jours',
    'code',
    'maxjours',
    'maxnuits',
    'NbrsJours',
    'NbrsNuits',
    'IsCouvert',
    'Agentjour',
    'Agentnuit',
    'couvertAgentjour',
    'couvertAgentnuit',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'typestache_id' => [
            //'required'
            ],
        
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
    
    
    
                    'pastille' => [
            //'required'
            ],
        
    
    
                    'Pointeuses' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'ville_id' => [
            //'required'
            ],
        
    
    
                    'jours' => [
            //'required'
            ],
        
    
    
                    'code' => [
            //'required'
            ],
        
    
    
                    'maxjours' => [
            //'required'
            ],
        
    
    
                    'maxnuits' => [
            //'required'
            ],
        
    
    
                    'NbrsJours' => [
            //'required'
            ],
        
    
    
                    'NbrsNuits' => [
            //'required'
            ],
        
    
    
                    'IsCouvert' => [
            //'required'
            ],
        
    
    
                    'Agentjour' => [
            //'required'
            ],
        
    
    
                    'Agentnuit' => [
            //'required'
            ],
        
    
    
                    'couvertAgentjour' => [
            //'required'
            ],
        
    
    
                    'couvertAgentnuit' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'typestache_id' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'pastille' => ['cette donnee est obligatoire'],

    
    
        'Pointeuses' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'ville_id' => ['cette donnee est obligatoire'],

    
    
        'jours' => ['cette donnee est obligatoire'],

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'maxjours' => ['cette donnee est obligatoire'],

    
    
        'maxnuits' => ['cette donnee est obligatoire'],

    
    
        'NbrsJours' => ['cette donnee est obligatoire'],

    
    
        'NbrsNuits' => ['cette donnee est obligatoire'],

    
    
        'IsCouvert' => ['cette donnee est obligatoire'],

    
    
        'Agentjour' => ['cette donnee est obligatoire'],

    
    
        'Agentnuit' => ['cette donnee est obligatoire'],

    
    
        'couvertAgentjour' => ['cette donnee est obligatoire'],

    
    
        'couvertAgentnuit' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['typestache_id'])){
        
            $Taches->typestache_id = $data['typestache_id'];
        
        }



    







    

        if(!empty($data['libelle'])){
        
            $Taches->libelle = $data['libelle'];
        
        }



    







    







    







    







    

        if(!empty($data['pastille'])){
        
            $Taches->pastille = $data['pastille'];
        
        }



    







    

        if(!empty($data['Pointeuses'])){
        
            $Taches->Pointeuses = $data['Pointeuses'];
        
        }



    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Taches->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Taches->creat_by = $data['creat_by'];
        
        }



    







    

        if(!empty($data['site_id'])){
        
            $Taches->site_id = $data['site_id'];
        
        }



    







    

        if(!empty($data['ville_id'])){
        
            $Taches->ville_id = $data['ville_id'];
        
        }



    







    

        if(!empty($data['jours'])){
        
            $Taches->jours = $data['jours'];
        
        }



    







    

        if(!empty($data['code'])){
        
            $Taches->code = $data['code'];
        
        }



    







    

        if(!empty($data['maxjours'])){
        
            $Taches->maxjours = $data['maxjours'];
        
        }



    







    

        if(!empty($data['maxnuits'])){
        
            $Taches->maxnuits = $data['maxnuits'];
        
        }



    







    

        if(!empty($data['NbrsJours'])){
        
            $Taches->NbrsJours = $data['NbrsJours'];
        
        }



    







    

        if(!empty($data['NbrsNuits'])){
        
            $Taches->NbrsNuits = $data['NbrsNuits'];
        
        }



    







    

        if(!empty($data['IsCouvert'])){
        
            $Taches->IsCouvert = $data['IsCouvert'];
        
        }



    







    

        if(!empty($data['Agentjour'])){
        
            $Taches->Agentjour = $data['Agentjour'];
        
        }



    







    

        if(!empty($data['Agentnuit'])){
        
            $Taches->Agentnuit = $data['Agentnuit'];
        
        }



    







    

        if(!empty($data['couvertAgentjour'])){
        
            $Taches->couvertAgentjour = $data['couvertAgentjour'];
        
        }



    







    

        if(!empty($data['couvertAgentnuit'])){
        
            $Taches->couvertAgentnuit = $data['couvertAgentnuit'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Taches->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TacheExtras') &&
method_exists('\App\Http\Extras\TacheExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TacheExtras::beforeSaveCreate($request,$Taches);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TacheExtras') &&
method_exists('\App\Http\Extras\TacheExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TacheExtras::canCreate($request, $Taches);
}catch (\Throwable $e){

}

}


if($canSave){
$Taches->save();
}else{
return response()->json($Taches, 200);
}

$Taches=Tache::find($Taches->id);
$newCrudData=[];

                $newCrudData['typestache_id']=$Taches->typestache_id;
                $newCrudData['libelle']=$Taches->libelle;
                            $newCrudData['pastille']=$Taches->pastille;
                $newCrudData['Pointeuses']=$Taches->Pointeuses;
                    $newCrudData['identifiants_sadge']=$Taches->identifiants_sadge;
                $newCrudData['creat_by']=$Taches->creat_by;
                $newCrudData['site_id']=$Taches->site_id;
                $newCrudData['ville_id']=$Taches->ville_id;
                $newCrudData['jours']=$Taches->jours;
                $newCrudData['code']=$Taches->code;
                $newCrudData['maxjours']=$Taches->maxjours;
                $newCrudData['maxnuits']=$Taches->maxnuits;
                $newCrudData['NbrsJours']=$Taches->NbrsJours;
                $newCrudData['NbrsNuits']=$Taches->NbrsNuits;
                $newCrudData['IsCouvert']=$Taches->IsCouvert;
                $newCrudData['Agentjour']=$Taches->Agentjour;
                $newCrudData['Agentnuit']=$Taches->Agentnuit;
                $newCrudData['couvertAgentjour']=$Taches->couvertAgentjour;
                $newCrudData['couvertAgentnuit']=$Taches->couvertAgentnuit;
    
 try{ $newCrudData['site']=$Taches->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typestache']=$Taches->typestache->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Taches->ville->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Taches','entite_cle' => $Taches->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Taches->toArray();




try{

foreach ($Taches->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Tache $Taches)
{
try{
$can=\App\Helpers\Helpers::can('Editer des taches');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['typestache_id']=$Taches->typestache_id;
                $oldCrudData['libelle']=$Taches->libelle;
                            $oldCrudData['pastille']=$Taches->pastille;
                $oldCrudData['Pointeuses']=$Taches->Pointeuses;
                    $oldCrudData['identifiants_sadge']=$Taches->identifiants_sadge;
                $oldCrudData['creat_by']=$Taches->creat_by;
                $oldCrudData['site_id']=$Taches->site_id;
                $oldCrudData['ville_id']=$Taches->ville_id;
                $oldCrudData['jours']=$Taches->jours;
                $oldCrudData['code']=$Taches->code;
                $oldCrudData['maxjours']=$Taches->maxjours;
                $oldCrudData['maxnuits']=$Taches->maxnuits;
                $oldCrudData['NbrsJours']=$Taches->NbrsJours;
                $oldCrudData['NbrsNuits']=$Taches->NbrsNuits;
                $oldCrudData['IsCouvert']=$Taches->IsCouvert;
                $oldCrudData['Agentjour']=$Taches->Agentjour;
                $oldCrudData['Agentnuit']=$Taches->Agentnuit;
                $oldCrudData['couvertAgentjour']=$Taches->couvertAgentjour;
                $oldCrudData['couvertAgentnuit']=$Taches->couvertAgentnuit;
    
 try{ $oldCrudData['site']=$Taches->site->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['typestache']=$Taches->typestache->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['ville']=$Taches->ville->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "taches"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'typestache_id',
    'libelle',
    'extra_attributes',
    'created_at',
    'updated_at',
    'pastille',
    'Pointeuses',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
    'site_id',
    'ville_id',
    'jours',
    'code',
    'maxjours',
    'maxnuits',
    'NbrsJours',
    'NbrsNuits',
    'IsCouvert',
    'Agentjour',
    'Agentnuit',
    'couvertAgentjour',
    'couvertAgentnuit',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'typestache_id' => [
            //'required'
            ],
        
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
    
    
    
                    'pastille' => [
            //'required'
            ],
        
    
    
                    'Pointeuses' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'ville_id' => [
            //'required'
            ],
        
    
    
                    'jours' => [
            //'required'
            ],
        
    
    
                    'code' => [
            //'required'
            ],
        
    
    
                    'maxjours' => [
            //'required'
            ],
        
    
    
                    'maxnuits' => [
            //'required'
            ],
        
    
    
                    'NbrsJours' => [
            //'required'
            ],
        
    
    
                    'NbrsNuits' => [
            //'required'
            ],
        
    
    
                    'IsCouvert' => [
            //'required'
            ],
        
    
    
                    'Agentjour' => [
            //'required'
            ],
        
    
    
                    'Agentnuit' => [
            //'required'
            ],
        
    
    
                    'couvertAgentjour' => [
            //'required'
            ],
        
    
    
                    'couvertAgentnuit' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'typestache_id' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'pastille' => ['cette donnee est obligatoire'],

    
    
        'Pointeuses' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'ville_id' => ['cette donnee est obligatoire'],

    
    
        'jours' => ['cette donnee est obligatoire'],

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'maxjours' => ['cette donnee est obligatoire'],

    
    
        'maxnuits' => ['cette donnee est obligatoire'],

    
    
        'NbrsJours' => ['cette donnee est obligatoire'],

    
    
        'NbrsNuits' => ['cette donnee est obligatoire'],

    
    
        'IsCouvert' => ['cette donnee est obligatoire'],

    
    
        'Agentjour' => ['cette donnee est obligatoire'],

    
    
        'Agentnuit' => ['cette donnee est obligatoire'],

    
    
        'couvertAgentjour' => ['cette donnee est obligatoire'],

    
    
        'couvertAgentnuit' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("typestache_id",$data)){


        if(!empty($data['typestache_id'])){
        
            $Taches->typestache_id = $data['typestache_id'];
        
        }

        }

    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Taches->libelle = $data['libelle'];
        
        }

        }

    







    







    







    







    

        if(array_key_exists("pastille",$data)){


        if(!empty($data['pastille'])){
        
            $Taches->pastille = $data['pastille'];
        
        }

        }

    







    

        if(array_key_exists("Pointeuses",$data)){


        if(!empty($data['Pointeuses'])){
        
            $Taches->Pointeuses = $data['Pointeuses'];
        
        }

        }

    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Taches->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Taches->creat_by = $data['creat_by'];
        
        }

        }

    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Taches->site_id = $data['site_id'];
        
        }

        }

    







    

        if(array_key_exists("ville_id",$data)){


        if(!empty($data['ville_id'])){
        
            $Taches->ville_id = $data['ville_id'];
        
        }

        }

    







    

        if(array_key_exists("jours",$data)){


        if(!empty($data['jours'])){
        
            $Taches->jours = $data['jours'];
        
        }

        }

    







    

        if(array_key_exists("code",$data)){


        if(!empty($data['code'])){
        
            $Taches->code = $data['code'];
        
        }

        }

    







    

        if(array_key_exists("maxjours",$data)){


        if(!empty($data['maxjours'])){
        
            $Taches->maxjours = $data['maxjours'];
        
        }

        }

    







    

        if(array_key_exists("maxnuits",$data)){


        if(!empty($data['maxnuits'])){
        
            $Taches->maxnuits = $data['maxnuits'];
        
        }

        }

    







    

        if(array_key_exists("NbrsJours",$data)){


        if(!empty($data['NbrsJours'])){
        
            $Taches->NbrsJours = $data['NbrsJours'];
        
        }

        }

    







    

        if(array_key_exists("NbrsNuits",$data)){


        if(!empty($data['NbrsNuits'])){
        
            $Taches->NbrsNuits = $data['NbrsNuits'];
        
        }

        }

    







    

        if(array_key_exists("IsCouvert",$data)){


        if(!empty($data['IsCouvert'])){
        
            $Taches->IsCouvert = $data['IsCouvert'];
        
        }

        }

    







    

        if(array_key_exists("Agentjour",$data)){


        if(!empty($data['Agentjour'])){
        
            $Taches->Agentjour = $data['Agentjour'];
        
        }

        }

    







    

        if(array_key_exists("Agentnuit",$data)){


        if(!empty($data['Agentnuit'])){
        
            $Taches->Agentnuit = $data['Agentnuit'];
        
        }

        }

    







    

        if(array_key_exists("couvertAgentjour",$data)){


        if(!empty($data['couvertAgentjour'])){
        
            $Taches->couvertAgentjour = $data['couvertAgentjour'];
        
        }

        }

    







    

        if(array_key_exists("couvertAgentnuit",$data)){


        if(!empty($data['couvertAgentnuit'])){
        
            $Taches->couvertAgentnuit = $data['couvertAgentnuit'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Taches->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TacheExtras') &&
method_exists('\App\Http\Extras\TacheExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TacheExtras::beforeSaveUpdate($request,$Taches);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TacheExtras') &&
method_exists('\App\Http\Extras\TacheExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TacheExtras::canUpdate($request, $Taches);
}catch (\Throwable $e){

}

}


if($canSave){
$Taches->save();
}else{
return response()->json($Taches, 200);

}


$Taches=Tache::find($Taches->id);



$newCrudData=[];

                $newCrudData['typestache_id']=$Taches->typestache_id;
                $newCrudData['libelle']=$Taches->libelle;
                            $newCrudData['pastille']=$Taches->pastille;
                $newCrudData['Pointeuses']=$Taches->Pointeuses;
                    $newCrudData['identifiants_sadge']=$Taches->identifiants_sadge;
                $newCrudData['creat_by']=$Taches->creat_by;
                $newCrudData['site_id']=$Taches->site_id;
                $newCrudData['ville_id']=$Taches->ville_id;
                $newCrudData['jours']=$Taches->jours;
                $newCrudData['code']=$Taches->code;
                $newCrudData['maxjours']=$Taches->maxjours;
                $newCrudData['maxnuits']=$Taches->maxnuits;
                $newCrudData['NbrsJours']=$Taches->NbrsJours;
                $newCrudData['NbrsNuits']=$Taches->NbrsNuits;
                $newCrudData['IsCouvert']=$Taches->IsCouvert;
                $newCrudData['Agentjour']=$Taches->Agentjour;
                $newCrudData['Agentnuit']=$Taches->Agentnuit;
                $newCrudData['couvertAgentjour']=$Taches->couvertAgentjour;
                $newCrudData['couvertAgentnuit']=$Taches->couvertAgentnuit;
    
 try{ $newCrudData['site']=$Taches->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typestache']=$Taches->typestache->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Taches->ville->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Taches','entite_cle' => $Taches->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Taches->toArray();




try{

foreach ($Taches->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Tache $Taches)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des taches');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['typestache_id']=$Taches->typestache_id;
                $newCrudData['libelle']=$Taches->libelle;
                            $newCrudData['pastille']=$Taches->pastille;
                $newCrudData['Pointeuses']=$Taches->Pointeuses;
                    $newCrudData['identifiants_sadge']=$Taches->identifiants_sadge;
                $newCrudData['creat_by']=$Taches->creat_by;
                $newCrudData['site_id']=$Taches->site_id;
                $newCrudData['ville_id']=$Taches->ville_id;
                $newCrudData['jours']=$Taches->jours;
                $newCrudData['code']=$Taches->code;
                $newCrudData['maxjours']=$Taches->maxjours;
                $newCrudData['maxnuits']=$Taches->maxnuits;
                $newCrudData['NbrsJours']=$Taches->NbrsJours;
                $newCrudData['NbrsNuits']=$Taches->NbrsNuits;
                $newCrudData['IsCouvert']=$Taches->IsCouvert;
                $newCrudData['Agentjour']=$Taches->Agentjour;
                $newCrudData['Agentnuit']=$Taches->Agentnuit;
                $newCrudData['couvertAgentjour']=$Taches->couvertAgentjour;
                $newCrudData['couvertAgentnuit']=$Taches->couvertAgentnuit;
    
 try{ $newCrudData['site']=$Taches->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typestache']=$Taches->typestache->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Taches->ville->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Taches','entite_cle' => $Taches->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TacheExtras') &&
method_exists('\App\Http\Extras\TacheExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TacheExtras::canDelete($request, $Taches);
}catch (\Throwable $e){

}

}



if($canSave){
$Taches->delete();
}else{
return response()->json($Taches, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TachesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
