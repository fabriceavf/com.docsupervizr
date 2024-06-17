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
// use App\Repository\prod\ProgrammationsRepository;
use App\Models\Programmation;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Poste;
                    use App\Models\Zone;
    
class ProgrammationController extends Controller
{

private $ProgrammationsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ProgrammationsRepository $ProgrammationsRepository
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
class_exists('\App\Http\Extras\ProgrammationExtras') &&
method_exists('\App\Http\Extras\ProgrammationExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ProgrammationExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Programmation::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ProgrammationExtras') &&
method_exists('\App\Http\Extras\ProgrammationExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ProgrammationExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('programmations',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ProgrammationExtras') &&
method_exists('\App\Http\Extras\ProgrammationExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ProgrammationExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  programmations reussi',
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
return response()->json(Programmation::count());
}
$data = QueryBuilder::for(Programmation::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('description'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('date_fin'),

    
            AllowedFilter::exact('default_heure_debut'),

    
            AllowedFilter::exact('default_heure_fin'),

    
            AllowedFilter::exact('tache_id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('statut'),

    
            AllowedFilter::exact('type'),

    
    
    
    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('faction'),

    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('valider1'),

    
            AllowedFilter::exact('valider2'),

    
            AllowedFilter::exact('postes'),

    
            AllowedFilter::exact('Allclients'),

    
            AllowedFilter::exact('AllDatesInRange'),

    
            AllowedFilter::exact('Presents'),

    
            AllowedFilter::exact('Abscents'),

    
            AllowedFilter::exact('Presentsid'),

    
            AllowedFilter::exact('Abscentsid'),

    
            AllowedFilter::exact('zone_id'),

    
            AllowedFilter::exact('user_id_2'),

    
            AllowedFilter::exact('user_id_3'),

    
            AllowedFilter::exact('user_id_4'),

    
            AllowedFilter::exact('min_pointage'),

    
            AllowedFilter::exact('valideur_1'),

    
            AllowedFilter::exact('valideur_2'),

    
            AllowedFilter::exact('typelistings'),

    
            AllowedFilter::exact('postesbaladeur'),

    
            AllowedFilter::exact('directions'),

    
    
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

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('description'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('date_fin'),

    
            AllowedSort::field('default_heure_debut'),

    
            AllowedSort::field('default_heure_fin'),

    
            AllowedSort::field('tache_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('statut'),

    
            AllowedSort::field('type'),

    
    
    
    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('faction'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('valider1'),

    
            AllowedSort::field('valider2'),

    
            AllowedSort::field('postes'),

    
            AllowedSort::field('Allclients'),

    
            AllowedSort::field('AllDatesInRange'),

    
            AllowedSort::field('Presents'),

    
            AllowedSort::field('Abscents'),

    
            AllowedSort::field('Presentsid'),

    
            AllowedSort::field('Abscentsid'),

    
            AllowedSort::field('zone_id'),

    
            AllowedSort::field('user_id_2'),

    
            AllowedSort::field('user_id_3'),

    
            AllowedSort::field('user_id_4'),

    
            AllowedSort::field('min_pointage'),

    
            AllowedSort::field('valideur_1'),

    
            AllowedSort::field('valideur_2'),

    
            AllowedSort::field('typelistings'),

    
            AllowedSort::field('postesbaladeur'),

    
            AllowedSort::field('directions'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
->allowedIncludes([
            'programmes',
        

                'ventilations',
        

    
            'poste',
        

                'user',
        

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




$data = QueryBuilder::for(Programmation::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('description'),

    
            AllowedFilter::exact('date_debut'),

    
            AllowedFilter::exact('date_fin'),

    
            AllowedFilter::exact('default_heure_debut'),

    
            AllowedFilter::exact('default_heure_fin'),

    
            AllowedFilter::exact('tache_id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('statut'),

    
            AllowedFilter::exact('type'),

    
    
    
    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('faction'),

    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('valider1'),

    
            AllowedFilter::exact('valider2'),

    
            AllowedFilter::exact('postes'),

    
            AllowedFilter::exact('Allclients'),

    
            AllowedFilter::exact('AllDatesInRange'),

    
            AllowedFilter::exact('Presents'),

    
            AllowedFilter::exact('Abscents'),

    
            AllowedFilter::exact('Presentsid'),

    
            AllowedFilter::exact('Abscentsid'),

    
            AllowedFilter::exact('zone_id'),

    
            AllowedFilter::exact('user_id_2'),

    
            AllowedFilter::exact('user_id_3'),

    
            AllowedFilter::exact('user_id_4'),

    
            AllowedFilter::exact('min_pointage'),

    
            AllowedFilter::exact('valideur_1'),

    
            AllowedFilter::exact('valideur_2'),

    
            AllowedFilter::exact('typelistings'),

    
            AllowedFilter::exact('postesbaladeur'),

    
            AllowedFilter::exact('directions'),

    
    
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

    
            AllowedSort::field('libelle'),

    
            AllowedSort::field('description'),

    
            AllowedSort::field('date_debut'),

    
            AllowedSort::field('date_fin'),

    
            AllowedSort::field('default_heure_debut'),

    
            AllowedSort::field('default_heure_fin'),

    
            AllowedSort::field('tache_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('statut'),

    
            AllowedSort::field('type'),

    
    
    
    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('faction'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('valider1'),

    
            AllowedSort::field('valider2'),

    
            AllowedSort::field('postes'),

    
            AllowedSort::field('Allclients'),

    
            AllowedSort::field('AllDatesInRange'),

    
            AllowedSort::field('Presents'),

    
            AllowedSort::field('Abscents'),

    
            AllowedSort::field('Presentsid'),

    
            AllowedSort::field('Abscentsid'),

    
            AllowedSort::field('zone_id'),

    
            AllowedSort::field('user_id_2'),

    
            AllowedSort::field('user_id_3'),

    
            AllowedSort::field('user_id_4'),

    
            AllowedSort::field('min_pointage'),

    
            AllowedSort::field('valideur_1'),

    
            AllowedSort::field('valideur_2'),

    
            AllowedSort::field('typelistings'),

    
            AllowedSort::field('postesbaladeur'),

    
            AllowedSort::field('directions'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
->allowedIncludes([
            'programmes',
        

                'ventilations',
        

                'poste',
        

                'user',
        

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



public function create(Request $request, Programmation $Programmations)
{


try{
$can=\App\Helpers\Helpers::can('Creer des programmations');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "programmations"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'description',
    'date_debut',
    'date_fin',
    'default_heure_debut',
    'default_heure_fin',
    'tache_id',
    'user_id',
    'statut',
    'type',
    'extra_attributes',
    'created_at',
    'updated_at',
    'poste_id',
    'faction',
    'etats',
    'valider1',
    'valider2',
    'postes',
    'Allclients',
    'AllDatesInRange',
    'Presents',
    'Abscents',
    'Presentsid',
    'Abscentsid',
    'zone_id',
    'user_id_2',
    'user_id_3',
    'user_id_4',
    'min_pointage',
    'valideur_1',
    'valideur_2',
    'typelistings',
    'postesbaladeur',
    'directions',
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
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'description' => [
            //'required'
            ],
        
    
    
                    'date_debut' => [
            //'required'
            ],
        
    
    
                    'date_fin' => [
            //'required'
            ],
        
    
    
                    'default_heure_debut' => [
            //'required'
            ],
        
    
    
                    'default_heure_fin' => [
            //'required'
            ],
        
    
    
                    'tache_id' => [
            //'required'
            ],
        
    
    
    
                    'statut' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
    
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'faction' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'valider1' => [
            //'required'
            ],
        
    
    
                    'valider2' => [
            //'required'
            ],
        
    
    
                    'postes' => [
            //'required'
            ],
        
    
    
                    'Allclients' => [
            //'required'
            ],
        
    
    
                    'AllDatesInRange' => [
            //'required'
            ],
        
    
    
                    'Presents' => [
            //'required'
            ],
        
    
    
                    'Abscents' => [
            //'required'
            ],
        
    
    
                    'Presentsid' => [
            //'required'
            ],
        
    
    
                    'Abscentsid' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
                    'user_id_2' => [
            //'required'
            ],
        
    
    
                    'user_id_3' => [
            //'required'
            ],
        
    
    
                    'user_id_4' => [
            //'required'
            ],
        
    
    
                    'min_pointage' => [
            //'required'
            ],
        
    
    
                    'valideur_1' => [
            //'required'
            ],
        
    
    
                    'valideur_2' => [
            //'required'
            ],
        
    
    
                    'typelistings' => [
            //'required'
            ],
        
    
    
                    'postesbaladeur' => [
            //'required'
            ],
        
    
    
                    'directions' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'description' => ['cette donnee est obligatoire'],

    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'date_fin' => ['cette donnee est obligatoire'],

    
    
        'default_heure_debut' => ['cette donnee est obligatoire'],

    
    
        'default_heure_fin' => ['cette donnee est obligatoire'],

    
    
        'tache_id' => ['cette donnee est obligatoire'],

    
    
    
        'statut' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'faction' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'valider1' => ['cette donnee est obligatoire'],

    
    
        'valider2' => ['cette donnee est obligatoire'],

    
    
        'postes' => ['cette donnee est obligatoire'],

    
    
        'Allclients' => ['cette donnee est obligatoire'],

    
    
        'AllDatesInRange' => ['cette donnee est obligatoire'],

    
    
        'Presents' => ['cette donnee est obligatoire'],

    
    
        'Abscents' => ['cette donnee est obligatoire'],

    
    
        'Presentsid' => ['cette donnee est obligatoire'],

    
    
        'Abscentsid' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
        'user_id_2' => ['cette donnee est obligatoire'],

    
    
        'user_id_3' => ['cette donnee est obligatoire'],

    
    
        'user_id_4' => ['cette donnee est obligatoire'],

    
    
        'min_pointage' => ['cette donnee est obligatoire'],

    
    
        'valideur_1' => ['cette donnee est obligatoire'],

    
    
        'valideur_2' => ['cette donnee est obligatoire'],

    
    
        'typelistings' => ['cette donnee est obligatoire'],

    
    
        'postesbaladeur' => ['cette donnee est obligatoire'],

    
    
        'directions' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Programmations->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['description'])){
        
            $Programmations->description = $data['description'];
        
        }



    







    

        if(!empty($data['date_debut'])){
        
            $Programmations->date_debut = $data['date_debut'];
        
        }



    







    

        if(!empty($data['date_fin'])){
        
            $Programmations->date_fin = $data['date_fin'];
        
        }



    







    

        if(!empty($data['default_heure_debut'])){
        
            $Programmations->default_heure_debut = $data['default_heure_debut'];
        
        }



    







    

        if(!empty($data['default_heure_fin'])){
        
            $Programmations->default_heure_fin = $data['default_heure_fin'];
        
        }



    







    

        if(!empty($data['tache_id'])){
        
            $Programmations->tache_id = $data['tache_id'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Programmations->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['statut'])){
        
            $Programmations->statut = $data['statut'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Programmations->type = $data['type'];
        
        }



    







    







    







    







    

        if(!empty($data['poste_id'])){
        
            $Programmations->poste_id = $data['poste_id'];
        
        }



    







    

        if(!empty($data['faction'])){
        
            $Programmations->faction = $data['faction'];
        
        }



    







    

        if(!empty($data['etats'])){
        
            $Programmations->etats = $data['etats'];
        
        }



    







    

        if(!empty($data['valider1'])){
        
            $Programmations->valider1 = $data['valider1'];
        
        }



    







    

        if(!empty($data['valider2'])){
        
            $Programmations->valider2 = $data['valider2'];
        
        }



    







    

        if(!empty($data['postes'])){
        
            $Programmations->postes = $data['postes'];
        
        }



    







    

        if(!empty($data['Allclients'])){
        
            $Programmations->Allclients = $data['Allclients'];
        
        }



    







    

        if(!empty($data['AllDatesInRange'])){
        
            $Programmations->AllDatesInRange = $data['AllDatesInRange'];
        
        }



    







    

        if(!empty($data['Presents'])){
        
            $Programmations->Presents = $data['Presents'];
        
        }



    







    

        if(!empty($data['Abscents'])){
        
            $Programmations->Abscents = $data['Abscents'];
        
        }



    







    

        if(!empty($data['Presentsid'])){
        
            $Programmations->Presentsid = $data['Presentsid'];
        
        }



    







    

        if(!empty($data['Abscentsid'])){
        
            $Programmations->Abscentsid = $data['Abscentsid'];
        
        }



    







    

        if(!empty($data['zone_id'])){
        
            $Programmations->zone_id = $data['zone_id'];
        
        }



    







    

        if(!empty($data['user_id_2'])){
        
            $Programmations->user_id_2 = $data['user_id_2'];
        
        }



    







    

        if(!empty($data['user_id_3'])){
        
            $Programmations->user_id_3 = $data['user_id_3'];
        
        }



    







    

        if(!empty($data['user_id_4'])){
        
            $Programmations->user_id_4 = $data['user_id_4'];
        
        }



    







    

        if(!empty($data['min_pointage'])){
        
            $Programmations->min_pointage = $data['min_pointage'];
        
        }



    







    

        if(!empty($data['valideur_1'])){
        
            $Programmations->valideur_1 = $data['valideur_1'];
        
        }



    







    

        if(!empty($data['valideur_2'])){
        
            $Programmations->valideur_2 = $data['valideur_2'];
        
        }



    







    

        if(!empty($data['typelistings'])){
        
            $Programmations->typelistings = $data['typelistings'];
        
        }



    







    

        if(!empty($data['postesbaladeur'])){
        
            $Programmations->postesbaladeur = $data['postesbaladeur'];
        
        }



    







    

        if(!empty($data['directions'])){
        
            $Programmations->directions = $data['directions'];
        
        }



    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Programmations->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Programmations->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Programmations->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ProgrammationExtras') &&
method_exists('\App\Http\Extras\ProgrammationExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ProgrammationExtras::beforeSaveCreate($request,$Programmations);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ProgrammationExtras') &&
method_exists('\App\Http\Extras\ProgrammationExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ProgrammationExtras::canCreate($request, $Programmations);
}catch (\Throwable $e){

}

}


if($canSave){
$Programmations->save();
}else{
return response()->json($Programmations, 200);
}

$Programmations=Programmation::find($Programmations->id);
$newCrudData=[];

                $newCrudData['libelle']=$Programmations->libelle;
                $newCrudData['description']=$Programmations->description;
                $newCrudData['date_debut']=$Programmations->date_debut;
                $newCrudData['date_fin']=$Programmations->date_fin;
                $newCrudData['default_heure_debut']=$Programmations->default_heure_debut;
                $newCrudData['default_heure_fin']=$Programmations->default_heure_fin;
                $newCrudData['tache_id']=$Programmations->tache_id;
                $newCrudData['user_id']=$Programmations->user_id;
                $newCrudData['statut']=$Programmations->statut;
                $newCrudData['type']=$Programmations->type;
                            $newCrudData['poste_id']=$Programmations->poste_id;
                $newCrudData['faction']=$Programmations->faction;
                $newCrudData['etats']=$Programmations->etats;
                $newCrudData['valider1']=$Programmations->valider1;
                $newCrudData['valider2']=$Programmations->valider2;
                $newCrudData['postes']=$Programmations->postes;
                $newCrudData['Allclients']=$Programmations->Allclients;
                $newCrudData['AllDatesInRange']=$Programmations->AllDatesInRange;
                $newCrudData['Presents']=$Programmations->Presents;
                $newCrudData['Abscents']=$Programmations->Abscents;
                $newCrudData['Presentsid']=$Programmations->Presentsid;
                $newCrudData['Abscentsid']=$Programmations->Abscentsid;
                $newCrudData['zone_id']=$Programmations->zone_id;
                $newCrudData['user_id_2']=$Programmations->user_id_2;
                $newCrudData['user_id_3']=$Programmations->user_id_3;
                $newCrudData['user_id_4']=$Programmations->user_id_4;
                $newCrudData['min_pointage']=$Programmations->min_pointage;
                $newCrudData['valideur_1']=$Programmations->valideur_1;
                $newCrudData['valideur_2']=$Programmations->valideur_2;
                $newCrudData['typelistings']=$Programmations->typelistings;
                $newCrudData['postesbaladeur']=$Programmations->postesbaladeur;
                $newCrudData['directions']=$Programmations->directions;
                    $newCrudData['identifiants_sadge']=$Programmations->identifiants_sadge;
                $newCrudData['creat_by']=$Programmations->creat_by;
    
 try{ $newCrudData['poste']=$Programmations->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Programmations->user->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Programmations->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Programmations','entite_cle' => $Programmations->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Programmations->toArray();




try{

foreach ($Programmations->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Programmation $Programmations)
{
try{
$can=\App\Helpers\Helpers::can('Editer des programmations');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Programmations->libelle;
                $oldCrudData['description']=$Programmations->description;
                $oldCrudData['date_debut']=$Programmations->date_debut;
                $oldCrudData['date_fin']=$Programmations->date_fin;
                $oldCrudData['default_heure_debut']=$Programmations->default_heure_debut;
                $oldCrudData['default_heure_fin']=$Programmations->default_heure_fin;
                $oldCrudData['tache_id']=$Programmations->tache_id;
                $oldCrudData['user_id']=$Programmations->user_id;
                $oldCrudData['statut']=$Programmations->statut;
                $oldCrudData['type']=$Programmations->type;
                            $oldCrudData['poste_id']=$Programmations->poste_id;
                $oldCrudData['faction']=$Programmations->faction;
                $oldCrudData['etats']=$Programmations->etats;
                $oldCrudData['valider1']=$Programmations->valider1;
                $oldCrudData['valider2']=$Programmations->valider2;
                $oldCrudData['postes']=$Programmations->postes;
                $oldCrudData['Allclients']=$Programmations->Allclients;
                $oldCrudData['AllDatesInRange']=$Programmations->AllDatesInRange;
                $oldCrudData['Presents']=$Programmations->Presents;
                $oldCrudData['Abscents']=$Programmations->Abscents;
                $oldCrudData['Presentsid']=$Programmations->Presentsid;
                $oldCrudData['Abscentsid']=$Programmations->Abscentsid;
                $oldCrudData['zone_id']=$Programmations->zone_id;
                $oldCrudData['user_id_2']=$Programmations->user_id_2;
                $oldCrudData['user_id_3']=$Programmations->user_id_3;
                $oldCrudData['user_id_4']=$Programmations->user_id_4;
                $oldCrudData['min_pointage']=$Programmations->min_pointage;
                $oldCrudData['valideur_1']=$Programmations->valideur_1;
                $oldCrudData['valideur_2']=$Programmations->valideur_2;
                $oldCrudData['typelistings']=$Programmations->typelistings;
                $oldCrudData['postesbaladeur']=$Programmations->postesbaladeur;
                $oldCrudData['directions']=$Programmations->directions;
                    $oldCrudData['identifiants_sadge']=$Programmations->identifiants_sadge;
                $oldCrudData['creat_by']=$Programmations->creat_by;
    
 try{ $oldCrudData['poste']=$Programmations->poste->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Programmations->user->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['zone']=$Programmations->zone->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "programmations"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'description',
    'date_debut',
    'date_fin',
    'default_heure_debut',
    'default_heure_fin',
    'tache_id',
    'user_id',
    'statut',
    'type',
    'extra_attributes',
    'created_at',
    'updated_at',
    'poste_id',
    'faction',
    'etats',
    'valider1',
    'valider2',
    'postes',
    'Allclients',
    'AllDatesInRange',
    'Presents',
    'Abscents',
    'Presentsid',
    'Abscentsid',
    'zone_id',
    'user_id_2',
    'user_id_3',
    'user_id_4',
    'min_pointage',
    'valideur_1',
    'valideur_2',
    'typelistings',
    'postesbaladeur',
    'directions',
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
    
    
                    'libelle' => [
            //'required'
            ],
        
    
    
                    'description' => [
            //'required'
            ],
        
    
    
                    'date_debut' => [
            //'required'
            ],
        
    
    
                    'date_fin' => [
            //'required'
            ],
        
    
    
                    'default_heure_debut' => [
            //'required'
            ],
        
    
    
                    'default_heure_fin' => [
            //'required'
            ],
        
    
    
                    'tache_id' => [
            //'required'
            ],
        
    
    
    
                    'statut' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
    
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'faction' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'valider1' => [
            //'required'
            ],
        
    
    
                    'valider2' => [
            //'required'
            ],
        
    
    
                    'postes' => [
            //'required'
            ],
        
    
    
                    'Allclients' => [
            //'required'
            ],
        
    
    
                    'AllDatesInRange' => [
            //'required'
            ],
        
    
    
                    'Presents' => [
            //'required'
            ],
        
    
    
                    'Abscents' => [
            //'required'
            ],
        
    
    
                    'Presentsid' => [
            //'required'
            ],
        
    
    
                    'Abscentsid' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
                    'user_id_2' => [
            //'required'
            ],
        
    
    
                    'user_id_3' => [
            //'required'
            ],
        
    
    
                    'user_id_4' => [
            //'required'
            ],
        
    
    
                    'min_pointage' => [
            //'required'
            ],
        
    
    
                    'valideur_1' => [
            //'required'
            ],
        
    
    
                    'valideur_2' => [
            //'required'
            ],
        
    
    
                    'typelistings' => [
            //'required'
            ],
        
    
    
                    'postesbaladeur' => [
            //'required'
            ],
        
    
    
                    'directions' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'description' => ['cette donnee est obligatoire'],

    
    
        'date_debut' => ['cette donnee est obligatoire'],

    
    
        'date_fin' => ['cette donnee est obligatoire'],

    
    
        'default_heure_debut' => ['cette donnee est obligatoire'],

    
    
        'default_heure_fin' => ['cette donnee est obligatoire'],

    
    
        'tache_id' => ['cette donnee est obligatoire'],

    
    
    
        'statut' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'faction' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'valider1' => ['cette donnee est obligatoire'],

    
    
        'valider2' => ['cette donnee est obligatoire'],

    
    
        'postes' => ['cette donnee est obligatoire'],

    
    
        'Allclients' => ['cette donnee est obligatoire'],

    
    
        'AllDatesInRange' => ['cette donnee est obligatoire'],

    
    
        'Presents' => ['cette donnee est obligatoire'],

    
    
        'Abscents' => ['cette donnee est obligatoire'],

    
    
        'Presentsid' => ['cette donnee est obligatoire'],

    
    
        'Abscentsid' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
        'user_id_2' => ['cette donnee est obligatoire'],

    
    
        'user_id_3' => ['cette donnee est obligatoire'],

    
    
        'user_id_4' => ['cette donnee est obligatoire'],

    
    
        'min_pointage' => ['cette donnee est obligatoire'],

    
    
        'valideur_1' => ['cette donnee est obligatoire'],

    
    
        'valideur_2' => ['cette donnee est obligatoire'],

    
    
        'typelistings' => ['cette donnee est obligatoire'],

    
    
        'postesbaladeur' => ['cette donnee est obligatoire'],

    
    
        'directions' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Programmations->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("description",$data)){


        if(!empty($data['description'])){
        
            $Programmations->description = $data['description'];
        
        }

        }

    







    

        if(array_key_exists("date_debut",$data)){


        if(!empty($data['date_debut'])){
        
            $Programmations->date_debut = $data['date_debut'];
        
        }

        }

    







    

        if(array_key_exists("date_fin",$data)){


        if(!empty($data['date_fin'])){
        
            $Programmations->date_fin = $data['date_fin'];
        
        }

        }

    







    

        if(array_key_exists("default_heure_debut",$data)){


        if(!empty($data['default_heure_debut'])){
        
            $Programmations->default_heure_debut = $data['default_heure_debut'];
        
        }

        }

    







    

        if(array_key_exists("default_heure_fin",$data)){


        if(!empty($data['default_heure_fin'])){
        
            $Programmations->default_heure_fin = $data['default_heure_fin'];
        
        }

        }

    







    

        if(array_key_exists("tache_id",$data)){


        if(!empty($data['tache_id'])){
        
            $Programmations->tache_id = $data['tache_id'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Programmations->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("statut",$data)){


        if(!empty($data['statut'])){
        
            $Programmations->statut = $data['statut'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Programmations->type = $data['type'];
        
        }

        }

    







    







    







    







    

        if(array_key_exists("poste_id",$data)){


        if(!empty($data['poste_id'])){
        
            $Programmations->poste_id = $data['poste_id'];
        
        }

        }

    







    

        if(array_key_exists("faction",$data)){


        if(!empty($data['faction'])){
        
            $Programmations->faction = $data['faction'];
        
        }

        }

    







    

        if(array_key_exists("etats",$data)){


        if(!empty($data['etats'])){
        
            $Programmations->etats = $data['etats'];
        
        }

        }

    







    

        if(array_key_exists("valider1",$data)){


        if(!empty($data['valider1'])){
        
            $Programmations->valider1 = $data['valider1'];
        
        }

        }

    







    

        if(array_key_exists("valider2",$data)){


        if(!empty($data['valider2'])){
        
            $Programmations->valider2 = $data['valider2'];
        
        }

        }

    







    

        if(array_key_exists("postes",$data)){


        if(!empty($data['postes'])){
        
            $Programmations->postes = $data['postes'];
        
        }

        }

    







    

        if(array_key_exists("Allclients",$data)){


        if(!empty($data['Allclients'])){
        
            $Programmations->Allclients = $data['Allclients'];
        
        }

        }

    







    

        if(array_key_exists("AllDatesInRange",$data)){


        if(!empty($data['AllDatesInRange'])){
        
            $Programmations->AllDatesInRange = $data['AllDatesInRange'];
        
        }

        }

    







    

        if(array_key_exists("Presents",$data)){


        if(!empty($data['Presents'])){
        
            $Programmations->Presents = $data['Presents'];
        
        }

        }

    







    

        if(array_key_exists("Abscents",$data)){


        if(!empty($data['Abscents'])){
        
            $Programmations->Abscents = $data['Abscents'];
        
        }

        }

    







    

        if(array_key_exists("Presentsid",$data)){


        if(!empty($data['Presentsid'])){
        
            $Programmations->Presentsid = $data['Presentsid'];
        
        }

        }

    







    

        if(array_key_exists("Abscentsid",$data)){


        if(!empty($data['Abscentsid'])){
        
            $Programmations->Abscentsid = $data['Abscentsid'];
        
        }

        }

    







    

        if(array_key_exists("zone_id",$data)){


        if(!empty($data['zone_id'])){
        
            $Programmations->zone_id = $data['zone_id'];
        
        }

        }

    







    

        if(array_key_exists("user_id_2",$data)){


        if(!empty($data['user_id_2'])){
        
            $Programmations->user_id_2 = $data['user_id_2'];
        
        }

        }

    







    

        if(array_key_exists("user_id_3",$data)){


        if(!empty($data['user_id_3'])){
        
            $Programmations->user_id_3 = $data['user_id_3'];
        
        }

        }

    







    

        if(array_key_exists("user_id_4",$data)){


        if(!empty($data['user_id_4'])){
        
            $Programmations->user_id_4 = $data['user_id_4'];
        
        }

        }

    







    

        if(array_key_exists("min_pointage",$data)){


        if(!empty($data['min_pointage'])){
        
            $Programmations->min_pointage = $data['min_pointage'];
        
        }

        }

    







    

        if(array_key_exists("valideur_1",$data)){


        if(!empty($data['valideur_1'])){
        
            $Programmations->valideur_1 = $data['valideur_1'];
        
        }

        }

    







    

        if(array_key_exists("valideur_2",$data)){


        if(!empty($data['valideur_2'])){
        
            $Programmations->valideur_2 = $data['valideur_2'];
        
        }

        }

    







    

        if(array_key_exists("typelistings",$data)){


        if(!empty($data['typelistings'])){
        
            $Programmations->typelistings = $data['typelistings'];
        
        }

        }

    







    

        if(array_key_exists("postesbaladeur",$data)){


        if(!empty($data['postesbaladeur'])){
        
            $Programmations->postesbaladeur = $data['postesbaladeur'];
        
        }

        }

    







    

        if(array_key_exists("directions",$data)){


        if(!empty($data['directions'])){
        
            $Programmations->directions = $data['directions'];
        
        }

        }

    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Programmations->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Programmations->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Programmations->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ProgrammationExtras') &&
method_exists('\App\Http\Extras\ProgrammationExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ProgrammationExtras::beforeSaveUpdate($request,$Programmations);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ProgrammationExtras') &&
method_exists('\App\Http\Extras\ProgrammationExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ProgrammationExtras::canUpdate($request, $Programmations);
}catch (\Throwable $e){

}

}


if($canSave){
$Programmations->save();
}else{
return response()->json($Programmations, 200);

}


$Programmations=Programmation::find($Programmations->id);



$newCrudData=[];

                $newCrudData['libelle']=$Programmations->libelle;
                $newCrudData['description']=$Programmations->description;
                $newCrudData['date_debut']=$Programmations->date_debut;
                $newCrudData['date_fin']=$Programmations->date_fin;
                $newCrudData['default_heure_debut']=$Programmations->default_heure_debut;
                $newCrudData['default_heure_fin']=$Programmations->default_heure_fin;
                $newCrudData['tache_id']=$Programmations->tache_id;
                $newCrudData['user_id']=$Programmations->user_id;
                $newCrudData['statut']=$Programmations->statut;
                $newCrudData['type']=$Programmations->type;
                            $newCrudData['poste_id']=$Programmations->poste_id;
                $newCrudData['faction']=$Programmations->faction;
                $newCrudData['etats']=$Programmations->etats;
                $newCrudData['valider1']=$Programmations->valider1;
                $newCrudData['valider2']=$Programmations->valider2;
                $newCrudData['postes']=$Programmations->postes;
                $newCrudData['Allclients']=$Programmations->Allclients;
                $newCrudData['AllDatesInRange']=$Programmations->AllDatesInRange;
                $newCrudData['Presents']=$Programmations->Presents;
                $newCrudData['Abscents']=$Programmations->Abscents;
                $newCrudData['Presentsid']=$Programmations->Presentsid;
                $newCrudData['Abscentsid']=$Programmations->Abscentsid;
                $newCrudData['zone_id']=$Programmations->zone_id;
                $newCrudData['user_id_2']=$Programmations->user_id_2;
                $newCrudData['user_id_3']=$Programmations->user_id_3;
                $newCrudData['user_id_4']=$Programmations->user_id_4;
                $newCrudData['min_pointage']=$Programmations->min_pointage;
                $newCrudData['valideur_1']=$Programmations->valideur_1;
                $newCrudData['valideur_2']=$Programmations->valideur_2;
                $newCrudData['typelistings']=$Programmations->typelistings;
                $newCrudData['postesbaladeur']=$Programmations->postesbaladeur;
                $newCrudData['directions']=$Programmations->directions;
                    $newCrudData['identifiants_sadge']=$Programmations->identifiants_sadge;
                $newCrudData['creat_by']=$Programmations->creat_by;
    
 try{ $newCrudData['poste']=$Programmations->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Programmations->user->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Programmations->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Programmations','entite_cle' => $Programmations->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Programmations->toArray();




try{

foreach ($Programmations->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Programmation $Programmations)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des programmations');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Programmations->libelle;
                $newCrudData['description']=$Programmations->description;
                $newCrudData['date_debut']=$Programmations->date_debut;
                $newCrudData['date_fin']=$Programmations->date_fin;
                $newCrudData['default_heure_debut']=$Programmations->default_heure_debut;
                $newCrudData['default_heure_fin']=$Programmations->default_heure_fin;
                $newCrudData['tache_id']=$Programmations->tache_id;
                $newCrudData['user_id']=$Programmations->user_id;
                $newCrudData['statut']=$Programmations->statut;
                $newCrudData['type']=$Programmations->type;
                            $newCrudData['poste_id']=$Programmations->poste_id;
                $newCrudData['faction']=$Programmations->faction;
                $newCrudData['etats']=$Programmations->etats;
                $newCrudData['valider1']=$Programmations->valider1;
                $newCrudData['valider2']=$Programmations->valider2;
                $newCrudData['postes']=$Programmations->postes;
                $newCrudData['Allclients']=$Programmations->Allclients;
                $newCrudData['AllDatesInRange']=$Programmations->AllDatesInRange;
                $newCrudData['Presents']=$Programmations->Presents;
                $newCrudData['Abscents']=$Programmations->Abscents;
                $newCrudData['Presentsid']=$Programmations->Presentsid;
                $newCrudData['Abscentsid']=$Programmations->Abscentsid;
                $newCrudData['zone_id']=$Programmations->zone_id;
                $newCrudData['user_id_2']=$Programmations->user_id_2;
                $newCrudData['user_id_3']=$Programmations->user_id_3;
                $newCrudData['user_id_4']=$Programmations->user_id_4;
                $newCrudData['min_pointage']=$Programmations->min_pointage;
                $newCrudData['valideur_1']=$Programmations->valideur_1;
                $newCrudData['valideur_2']=$Programmations->valideur_2;
                $newCrudData['typelistings']=$Programmations->typelistings;
                $newCrudData['postesbaladeur']=$Programmations->postesbaladeur;
                $newCrudData['directions']=$Programmations->directions;
                    $newCrudData['identifiants_sadge']=$Programmations->identifiants_sadge;
                $newCrudData['creat_by']=$Programmations->creat_by;
    
 try{ $newCrudData['poste']=$Programmations->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Programmations->user->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Programmations->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Programmations','entite_cle' => $Programmations->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ProgrammationExtras') &&
method_exists('\App\Http\Extras\ProgrammationExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ProgrammationExtras::canDelete($request, $Programmations);
}catch (\Throwable $e){

}

}



if($canSave){
$Programmations->delete();
}else{
return response()->json($Programmations, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ProgrammationsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
