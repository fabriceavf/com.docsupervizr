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
// use App\Repository\prod\PostesRepository;
use App\Models\Poste;
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
                use App\Models\Postesarticle;
                use App\Models\Site;
                use App\Models\Typesposte;
    
class PosteController extends Controller
{

private $PostesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\PostesRepository $PostesRepository
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
class_exists('\App\Http\Extras\PosteExtras') &&
method_exists('\App\Http\Extras\PosteExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\PosteExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Poste::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\PosteExtras') &&
method_exists('\App\Http\Extras\PosteExtras', 'filterAgGridQuery')
){
\App\Http\Extras\PosteExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('postes',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\PosteExtras') &&
method_exists('\App\Http\Extras\PosteExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\PosteExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  postes reussi',
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
return response()->json(Poste::count());
}
$data = QueryBuilder::for(Poste::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('nature'),

    
            AllowedFilter::exact('coordonnees'),

    
            AllowedFilter::exact('site_id'),

    
    
    
            AllowedFilter::exact('jours'),

    
            AllowedFilter::exact('contratsclient_id'),

    
            AllowedFilter::exact('maxjours'),

    
            AllowedFilter::exact('maxnuits'),

    
            AllowedFilter::exact('NbrsJours'),

    
            AllowedFilter::exact('NbrsNuits'),

    
            AllowedFilter::exact('IsCouvert'),

    
            AllowedFilter::exact('pointeuses'),

    
            AllowedFilter::exact('Agentjour'),

    
            AllowedFilter::exact('Agentnuit'),

    
            AllowedFilter::exact('couvertAgentjour'),

    
            AllowedFilter::exact('couvertAgentnuit'),

    
            AllowedFilter::exact('type'),

    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('typeagents'),

    
            AllowedFilter::exact('typesposte_id'),

    
            AllowedFilter::exact('postesarticle_id'),

    
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

    
            AllowedSort::field('nature'),

    
            AllowedSort::field('coordonnees'),

    
            AllowedSort::field('site_id'),

    
    
    
            AllowedSort::field('jours'),

    
            AllowedSort::field('contratsclient_id'),

    
            AllowedSort::field('maxjours'),

    
            AllowedSort::field('maxnuits'),

    
            AllowedSort::field('NbrsJours'),

    
            AllowedSort::field('NbrsNuits'),

    
            AllowedSort::field('IsCouvert'),

    
            AllowedSort::field('pointeuses'),

    
            AllowedSort::field('Agentjour'),

    
            AllowedSort::field('Agentnuit'),

    
            AllowedSort::field('couvertAgentjour'),

    
            AllowedSort::field('couvertAgentnuit'),

    
            AllowedSort::field('type'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('typeagents'),

    
            AllowedSort::field('typesposte_id'),

    
            AllowedSort::field('postesarticle_id'),

    
])
    
    
    
    
->allowedIncludes([
            'contratspostes',
        

                'horaires',
        

                'listings',
        

                'postesagents',
        

                'postespointeuses',
        

                'programmations',
        

                'programmationsrondes',
        

                'programmes',
        

                'programmesrondes',
        

                'rapportpostes',
        

                'rapports',
        

                'transactions',
        

                'transactionspostessynthesesvacations',
        

                'users',
        

                'vacationspostes',
        

    
            'contratsclient',
        

                'postesarticle',
        

                'site',
        

                'typesposte',
        

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




$data = QueryBuilder::for(Poste::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('code'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('nature'),

    
            AllowedFilter::exact('coordonnees'),

    
            AllowedFilter::exact('site_id'),

    
    
    
            AllowedFilter::exact('jours'),

    
            AllowedFilter::exact('contratsclient_id'),

    
            AllowedFilter::exact('maxjours'),

    
            AllowedFilter::exact('maxnuits'),

    
            AllowedFilter::exact('NbrsJours'),

    
            AllowedFilter::exact('NbrsNuits'),

    
            AllowedFilter::exact('IsCouvert'),

    
            AllowedFilter::exact('pointeuses'),

    
            AllowedFilter::exact('Agentjour'),

    
            AllowedFilter::exact('Agentnuit'),

    
            AllowedFilter::exact('couvertAgentjour'),

    
            AllowedFilter::exact('couvertAgentnuit'),

    
            AllowedFilter::exact('type'),

    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('creat_by'),

    
            AllowedFilter::exact('typeagents'),

    
            AllowedFilter::exact('typesposte_id'),

    
            AllowedFilter::exact('postesarticle_id'),

    
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

    
            AllowedSort::field('nature'),

    
            AllowedSort::field('coordonnees'),

    
            AllowedSort::field('site_id'),

    
    
    
            AllowedSort::field('jours'),

    
            AllowedSort::field('contratsclient_id'),

    
            AllowedSort::field('maxjours'),

    
            AllowedSort::field('maxnuits'),

    
            AllowedSort::field('NbrsJours'),

    
            AllowedSort::field('NbrsNuits'),

    
            AllowedSort::field('IsCouvert'),

    
            AllowedSort::field('pointeuses'),

    
            AllowedSort::field('Agentjour'),

    
            AllowedSort::field('Agentnuit'),

    
            AllowedSort::field('couvertAgentjour'),

    
            AllowedSort::field('couvertAgentnuit'),

    
            AllowedSort::field('type'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
            AllowedSort::field('typeagents'),

    
            AllowedSort::field('typesposte_id'),

    
            AllowedSort::field('postesarticle_id'),

    
])
    
    
    
    
->allowedIncludes([
            'contratspostes',
        

                'horaires',
        

                'listings',
        

                'postesagents',
        

                'postespointeuses',
        

                'programmations',
        

                'programmationsrondes',
        

                'programmes',
        

                'programmesrondes',
        

                'rapportpostes',
        

                'rapports',
        

                'transactions',
        

                'transactionspostessynthesesvacations',
        

                'users',
        

                'vacationspostes',
        

                'contratsclient',
        

                'postesarticle',
        

                'site',
        

                'typesposte',
        

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



public function create(Request $request, Poste $Postes)
{


try{
$can=\App\Helpers\Helpers::can('Creer des postes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "postes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'libelle',
    'nature',
    'coordonnees',
    'site_id',
    'created_at',
    'updated_at',
    'jours',
    'contratsclient_id',
    'maxjours',
    'maxnuits',
    'NbrsJours',
    'NbrsNuits',
    'IsCouvert',
    'pointeuses',
    'Agentjour',
    'Agentnuit',
    'couvertAgentjour',
    'couvertAgentnuit',
    'type',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
    'typeagents',
    'typesposte_id',
    'postesarticle_id',
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
        
    
    
                    'nature' => [
            //'required'
            ],
        
    
    
                    'coordonnees' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
    
    
                    'jours' => [
            //'required'
            ],
        
    
    
                    'contratsclient_id' => [
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
        
    
    
                    'pointeuses' => [
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
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'typeagents' => [
            //'required'
            ],
        
    
    
                    'typesposte_id' => [
            //'required'
            ],
        
    
    
                    'postesarticle_id' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'nature' => ['cette donnee est obligatoire'],

    
    
        'coordonnees' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'jours' => ['cette donnee est obligatoire'],

    
    
        'contratsclient_id' => ['cette donnee est obligatoire'],

    
    
        'maxjours' => ['cette donnee est obligatoire'],

    
    
        'maxnuits' => ['cette donnee est obligatoire'],

    
    
        'NbrsJours' => ['cette donnee est obligatoire'],

    
    
        'NbrsNuits' => ['cette donnee est obligatoire'],

    
    
        'IsCouvert' => ['cette donnee est obligatoire'],

    
    
        'pointeuses' => ['cette donnee est obligatoire'],

    
    
        'Agentjour' => ['cette donnee est obligatoire'],

    
    
        'Agentnuit' => ['cette donnee est obligatoire'],

    
    
        'couvertAgentjour' => ['cette donnee est obligatoire'],

    
    
        'couvertAgentnuit' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'typeagents' => ['cette donnee est obligatoire'],

    
    
        'typesposte_id' => ['cette donnee est obligatoire'],

    
    
        'postesarticle_id' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['code'])){
        
            $Postes->code = $data['code'];
        
        }



    







    

        if(!empty($data['libelle'])){
        
            $Postes->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['nature'])){
        
            $Postes->nature = $data['nature'];
        
        }



    







    

        if(!empty($data['coordonnees'])){
        
            $Postes->coordonnees = $data['coordonnees'];
        
        }



    







    

        if(!empty($data['site_id'])){
        
            $Postes->site_id = $data['site_id'];
        
        }



    







    







    







    

        if(!empty($data['jours'])){
        
            $Postes->jours = $data['jours'];
        
        }



    







    

        if(!empty($data['contratsclient_id'])){
        
            $Postes->contratsclient_id = $data['contratsclient_id'];
        
        }



    







    

        if(!empty($data['maxjours'])){
        
            $Postes->maxjours = $data['maxjours'];
        
        }



    







    

        if(!empty($data['maxnuits'])){
        
            $Postes->maxnuits = $data['maxnuits'];
        
        }



    







    

        if(!empty($data['NbrsJours'])){
        
            $Postes->NbrsJours = $data['NbrsJours'];
        
        }



    







    

        if(!empty($data['NbrsNuits'])){
        
            $Postes->NbrsNuits = $data['NbrsNuits'];
        
        }



    







    

        if(!empty($data['IsCouvert'])){
        
            $Postes->IsCouvert = $data['IsCouvert'];
        
        }



    







    

        if(!empty($data['pointeuses'])){
        
            $Postes->pointeuses = $data['pointeuses'];
        
        }



    







    

        if(!empty($data['Agentjour'])){
        
            $Postes->Agentjour = $data['Agentjour'];
        
        }



    







    

        if(!empty($data['Agentnuit'])){
        
            $Postes->Agentnuit = $data['Agentnuit'];
        
        }



    







    

        if(!empty($data['couvertAgentjour'])){
        
            $Postes->couvertAgentjour = $data['couvertAgentjour'];
        
        }



    







    

        if(!empty($data['couvertAgentnuit'])){
        
            $Postes->couvertAgentnuit = $data['couvertAgentnuit'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Postes->type = $data['type'];
        
        }



    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Postes->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Postes->creat_by = $data['creat_by'];
        
        }



    







    

        if(!empty($data['typeagents'])){
        
            $Postes->typeagents = $data['typeagents'];
        
        }



    







    

        if(!empty($data['typesposte_id'])){
        
            $Postes->typesposte_id = $data['typesposte_id'];
        
        }



    







    

        if(!empty($data['postesarticle_id'])){
        
            $Postes->postesarticle_id = $data['postesarticle_id'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Postes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\PosteExtras') &&
method_exists('\App\Http\Extras\PosteExtras', 'beforeSaveCreate')
){
\App\Http\Extras\PosteExtras::beforeSaveCreate($request,$Postes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PosteExtras') &&
method_exists('\App\Http\Extras\PosteExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\PosteExtras::canCreate($request, $Postes);
}catch (\Throwable $e){

}

}


if($canSave){
$Postes->save();
}else{
return response()->json($Postes, 200);
}

$Postes=Poste::find($Postes->id);
$newCrudData=[];

                $newCrudData['code']=$Postes->code;
                $newCrudData['libelle']=$Postes->libelle;
                $newCrudData['nature']=$Postes->nature;
                $newCrudData['coordonnees']=$Postes->coordonnees;
                $newCrudData['site_id']=$Postes->site_id;
                        $newCrudData['jours']=$Postes->jours;
                $newCrudData['contratsclient_id']=$Postes->contratsclient_id;
                $newCrudData['maxjours']=$Postes->maxjours;
                $newCrudData['maxnuits']=$Postes->maxnuits;
                $newCrudData['NbrsJours']=$Postes->NbrsJours;
                $newCrudData['NbrsNuits']=$Postes->NbrsNuits;
                $newCrudData['IsCouvert']=$Postes->IsCouvert;
                $newCrudData['pointeuses']=$Postes->pointeuses;
                $newCrudData['Agentjour']=$Postes->Agentjour;
                $newCrudData['Agentnuit']=$Postes->Agentnuit;
                $newCrudData['couvertAgentjour']=$Postes->couvertAgentjour;
                $newCrudData['couvertAgentnuit']=$Postes->couvertAgentnuit;
                $newCrudData['type']=$Postes->type;
                        $newCrudData['identifiants_sadge']=$Postes->identifiants_sadge;
                $newCrudData['creat_by']=$Postes->creat_by;
                $newCrudData['typeagents']=$Postes->typeagents;
                $newCrudData['typesposte_id']=$Postes->typesposte_id;
                $newCrudData['postesarticle_id']=$Postes->postesarticle_id;
    
 try{ $newCrudData['contratsclient']=$Postes->contratsclient->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['postesarticle']=$Postes->postesarticle->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Postes->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typesposte']=$Postes->typesposte->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Postes','entite_cle' => $Postes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Postes->toArray();




try{

foreach ($Postes->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Poste $Postes)
{
try{
$can=\App\Helpers\Helpers::can('Editer des postes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['code']=$Postes->code;
                $oldCrudData['libelle']=$Postes->libelle;
                $oldCrudData['nature']=$Postes->nature;
                $oldCrudData['coordonnees']=$Postes->coordonnees;
                $oldCrudData['site_id']=$Postes->site_id;
                        $oldCrudData['jours']=$Postes->jours;
                $oldCrudData['contratsclient_id']=$Postes->contratsclient_id;
                $oldCrudData['maxjours']=$Postes->maxjours;
                $oldCrudData['maxnuits']=$Postes->maxnuits;
                $oldCrudData['NbrsJours']=$Postes->NbrsJours;
                $oldCrudData['NbrsNuits']=$Postes->NbrsNuits;
                $oldCrudData['IsCouvert']=$Postes->IsCouvert;
                $oldCrudData['pointeuses']=$Postes->pointeuses;
                $oldCrudData['Agentjour']=$Postes->Agentjour;
                $oldCrudData['Agentnuit']=$Postes->Agentnuit;
                $oldCrudData['couvertAgentjour']=$Postes->couvertAgentjour;
                $oldCrudData['couvertAgentnuit']=$Postes->couvertAgentnuit;
                $oldCrudData['type']=$Postes->type;
                        $oldCrudData['identifiants_sadge']=$Postes->identifiants_sadge;
                $oldCrudData['creat_by']=$Postes->creat_by;
                $oldCrudData['typeagents']=$Postes->typeagents;
                $oldCrudData['typesposte_id']=$Postes->typesposte_id;
                $oldCrudData['postesarticle_id']=$Postes->postesarticle_id;
    
 try{ $oldCrudData['contratsclient']=$Postes->contratsclient->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['postesarticle']=$Postes->postesarticle->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['site']=$Postes->site->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['typesposte']=$Postes->typesposte->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "postes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'code',
    'libelle',
    'nature',
    'coordonnees',
    'site_id',
    'created_at',
    'updated_at',
    'jours',
    'contratsclient_id',
    'maxjours',
    'maxnuits',
    'NbrsJours',
    'NbrsNuits',
    'IsCouvert',
    'pointeuses',
    'Agentjour',
    'Agentnuit',
    'couvertAgentjour',
    'couvertAgentnuit',
    'type',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'creat_by',
    'typeagents',
    'typesposte_id',
    'postesarticle_id',
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
        
    
    
                    'nature' => [
            //'required'
            ],
        
    
    
                    'coordonnees' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
    
    
                    'jours' => [
            //'required'
            ],
        
    
    
                    'contratsclient_id' => [
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
        
    
    
                    'pointeuses' => [
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
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
                    'typeagents' => [
            //'required'
            ],
        
    
    
                    'typesposte_id' => [
            //'required'
            ],
        
    
    
                    'postesarticle_id' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'code' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'nature' => ['cette donnee est obligatoire'],

    
    
        'coordonnees' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
    
    
        'jours' => ['cette donnee est obligatoire'],

    
    
        'contratsclient_id' => ['cette donnee est obligatoire'],

    
    
        'maxjours' => ['cette donnee est obligatoire'],

    
    
        'maxnuits' => ['cette donnee est obligatoire'],

    
    
        'NbrsJours' => ['cette donnee est obligatoire'],

    
    
        'NbrsNuits' => ['cette donnee est obligatoire'],

    
    
        'IsCouvert' => ['cette donnee est obligatoire'],

    
    
        'pointeuses' => ['cette donnee est obligatoire'],

    
    
        'Agentjour' => ['cette donnee est obligatoire'],

    
    
        'Agentnuit' => ['cette donnee est obligatoire'],

    
    
        'couvertAgentjour' => ['cette donnee est obligatoire'],

    
    
        'couvertAgentnuit' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
        'typeagents' => ['cette donnee est obligatoire'],

    
    
        'typesposte_id' => ['cette donnee est obligatoire'],

    
    
        'postesarticle_id' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("code",$data)){


        if(!empty($data['code'])){
        
            $Postes->code = $data['code'];
        
        }

        }

    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Postes->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("nature",$data)){


        if(!empty($data['nature'])){
        
            $Postes->nature = $data['nature'];
        
        }

        }

    







    

        if(array_key_exists("coordonnees",$data)){


        if(!empty($data['coordonnees'])){
        
            $Postes->coordonnees = $data['coordonnees'];
        
        }

        }

    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Postes->site_id = $data['site_id'];
        
        }

        }

    







    







    







    

        if(array_key_exists("jours",$data)){


        if(!empty($data['jours'])){
        
            $Postes->jours = $data['jours'];
        
        }

        }

    







    

        if(array_key_exists("contratsclient_id",$data)){


        if(!empty($data['contratsclient_id'])){
        
            $Postes->contratsclient_id = $data['contratsclient_id'];
        
        }

        }

    







    

        if(array_key_exists("maxjours",$data)){


        if(!empty($data['maxjours'])){
        
            $Postes->maxjours = $data['maxjours'];
        
        }

        }

    







    

        if(array_key_exists("maxnuits",$data)){


        if(!empty($data['maxnuits'])){
        
            $Postes->maxnuits = $data['maxnuits'];
        
        }

        }

    







    

        if(array_key_exists("NbrsJours",$data)){


        if(!empty($data['NbrsJours'])){
        
            $Postes->NbrsJours = $data['NbrsJours'];
        
        }

        }

    







    

        if(array_key_exists("NbrsNuits",$data)){


        if(!empty($data['NbrsNuits'])){
        
            $Postes->NbrsNuits = $data['NbrsNuits'];
        
        }

        }

    







    

        if(array_key_exists("IsCouvert",$data)){


        if(!empty($data['IsCouvert'])){
        
            $Postes->IsCouvert = $data['IsCouvert'];
        
        }

        }

    







    

        if(array_key_exists("pointeuses",$data)){


        if(!empty($data['pointeuses'])){
        
            $Postes->pointeuses = $data['pointeuses'];
        
        }

        }

    







    

        if(array_key_exists("Agentjour",$data)){


        if(!empty($data['Agentjour'])){
        
            $Postes->Agentjour = $data['Agentjour'];
        
        }

        }

    







    

        if(array_key_exists("Agentnuit",$data)){


        if(!empty($data['Agentnuit'])){
        
            $Postes->Agentnuit = $data['Agentnuit'];
        
        }

        }

    







    

        if(array_key_exists("couvertAgentjour",$data)){


        if(!empty($data['couvertAgentjour'])){
        
            $Postes->couvertAgentjour = $data['couvertAgentjour'];
        
        }

        }

    







    

        if(array_key_exists("couvertAgentnuit",$data)){


        if(!empty($data['couvertAgentnuit'])){
        
            $Postes->couvertAgentnuit = $data['couvertAgentnuit'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Postes->type = $data['type'];
        
        }

        }

    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Postes->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Postes->creat_by = $data['creat_by'];
        
        }

        }

    







    

        if(array_key_exists("typeagents",$data)){


        if(!empty($data['typeagents'])){
        
            $Postes->typeagents = $data['typeagents'];
        
        }

        }

    







    

        if(array_key_exists("typesposte_id",$data)){


        if(!empty($data['typesposte_id'])){
        
            $Postes->typesposte_id = $data['typesposte_id'];
        
        }

        }

    







    

        if(array_key_exists("postesarticle_id",$data)){


        if(!empty($data['postesarticle_id'])){
        
            $Postes->postesarticle_id = $data['postesarticle_id'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Postes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\PosteExtras') &&
method_exists('\App\Http\Extras\PosteExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\PosteExtras::beforeSaveUpdate($request,$Postes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PosteExtras') &&
method_exists('\App\Http\Extras\PosteExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\PosteExtras::canUpdate($request, $Postes);
}catch (\Throwable $e){

}

}


if($canSave){
$Postes->save();
}else{
return response()->json($Postes, 200);

}


$Postes=Poste::find($Postes->id);



$newCrudData=[];

                $newCrudData['code']=$Postes->code;
                $newCrudData['libelle']=$Postes->libelle;
                $newCrudData['nature']=$Postes->nature;
                $newCrudData['coordonnees']=$Postes->coordonnees;
                $newCrudData['site_id']=$Postes->site_id;
                        $newCrudData['jours']=$Postes->jours;
                $newCrudData['contratsclient_id']=$Postes->contratsclient_id;
                $newCrudData['maxjours']=$Postes->maxjours;
                $newCrudData['maxnuits']=$Postes->maxnuits;
                $newCrudData['NbrsJours']=$Postes->NbrsJours;
                $newCrudData['NbrsNuits']=$Postes->NbrsNuits;
                $newCrudData['IsCouvert']=$Postes->IsCouvert;
                $newCrudData['pointeuses']=$Postes->pointeuses;
                $newCrudData['Agentjour']=$Postes->Agentjour;
                $newCrudData['Agentnuit']=$Postes->Agentnuit;
                $newCrudData['couvertAgentjour']=$Postes->couvertAgentjour;
                $newCrudData['couvertAgentnuit']=$Postes->couvertAgentnuit;
                $newCrudData['type']=$Postes->type;
                        $newCrudData['identifiants_sadge']=$Postes->identifiants_sadge;
                $newCrudData['creat_by']=$Postes->creat_by;
                $newCrudData['typeagents']=$Postes->typeagents;
                $newCrudData['typesposte_id']=$Postes->typesposte_id;
                $newCrudData['postesarticle_id']=$Postes->postesarticle_id;
    
 try{ $newCrudData['contratsclient']=$Postes->contratsclient->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['postesarticle']=$Postes->postesarticle->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Postes->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typesposte']=$Postes->typesposte->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Postes','entite_cle' => $Postes->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Postes->toArray();




try{

foreach ($Postes->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Poste $Postes)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des postes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['code']=$Postes->code;
                $newCrudData['libelle']=$Postes->libelle;
                $newCrudData['nature']=$Postes->nature;
                $newCrudData['coordonnees']=$Postes->coordonnees;
                $newCrudData['site_id']=$Postes->site_id;
                        $newCrudData['jours']=$Postes->jours;
                $newCrudData['contratsclient_id']=$Postes->contratsclient_id;
                $newCrudData['maxjours']=$Postes->maxjours;
                $newCrudData['maxnuits']=$Postes->maxnuits;
                $newCrudData['NbrsJours']=$Postes->NbrsJours;
                $newCrudData['NbrsNuits']=$Postes->NbrsNuits;
                $newCrudData['IsCouvert']=$Postes->IsCouvert;
                $newCrudData['pointeuses']=$Postes->pointeuses;
                $newCrudData['Agentjour']=$Postes->Agentjour;
                $newCrudData['Agentnuit']=$Postes->Agentnuit;
                $newCrudData['couvertAgentjour']=$Postes->couvertAgentjour;
                $newCrudData['couvertAgentnuit']=$Postes->couvertAgentnuit;
                $newCrudData['type']=$Postes->type;
                        $newCrudData['identifiants_sadge']=$Postes->identifiants_sadge;
                $newCrudData['creat_by']=$Postes->creat_by;
                $newCrudData['typeagents']=$Postes->typeagents;
                $newCrudData['typesposte_id']=$Postes->typesposte_id;
                $newCrudData['postesarticle_id']=$Postes->postesarticle_id;
    
 try{ $newCrudData['contratsclient']=$Postes->contratsclient->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['postesarticle']=$Postes->postesarticle->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Postes->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['typesposte']=$Postes->typesposte->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Postes','entite_cle' => $Postes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\PosteExtras') &&
method_exists('\App\Http\Extras\PosteExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\PosteExtras::canDelete($request, $Postes);
}catch (\Throwable $e){

}

}



if($canSave){
$Postes->delete();
}else{
return response()->json($Postes, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\PostesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
