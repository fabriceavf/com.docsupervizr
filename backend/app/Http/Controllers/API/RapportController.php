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
// use App\Repository\prod\RapportsRepository;
use App\Models\Rapport;
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
                use App\Models\Fonction;
                use App\Models\Poste;
                use App\Models\Site;
                use App\Models\Type;
                use App\Models\Ville;
                use App\Models\Zone;
    
class RapportController extends Controller
{

private $RapportsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\RapportsRepository $RapportsRepository
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
class_exists('\App\Http\Extras\RapportExtras') &&
method_exists('\App\Http\Extras\RapportExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\RapportExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Rapport::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\RapportExtras') &&
method_exists('\App\Http\Extras\RapportExtras', 'filterAgGridQuery')
){
\App\Http\Extras\RapportExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('rapports',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\RapportExtras') &&
method_exists('\App\Http\Extras\RapportExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\RapportExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  rapports reussi',
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
return response()->json(Rapport::count());
}
$data = QueryBuilder::for(Rapport::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('mois'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('ville_id'),

    
            AllowedFilter::exact('zone_id'),

    
            AllowedFilter::exact('fonction_id'),

    
            AllowedFilter::exact('type_id'),

    
            AllowedFilter::exact('faction_id'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('day_01'),

    
            AllowedFilter::exact('day_02'),

    
            AllowedFilter::exact('day_03'),

    
            AllowedFilter::exact('day_04'),

    
            AllowedFilter::exact('day_05'),

    
            AllowedFilter::exact('day_06'),

    
            AllowedFilter::exact('day_07'),

    
            AllowedFilter::exact('day_08'),

    
            AllowedFilter::exact('day_09'),

    
            AllowedFilter::exact('day_10'),

    
            AllowedFilter::exact('day_11'),

    
            AllowedFilter::exact('day_12'),

    
            AllowedFilter::exact('day_13'),

    
            AllowedFilter::exact('day_14'),

    
            AllowedFilter::exact('day_15'),

    
            AllowedFilter::exact('day_16'),

    
            AllowedFilter::exact('day_17'),

    
            AllowedFilter::exact('day_18'),

    
            AllowedFilter::exact('day_19'),

    
            AllowedFilter::exact('day_20'),

    
            AllowedFilter::exact('day_21'),

    
            AllowedFilter::exact('day_22'),

    
            AllowedFilter::exact('day_23'),

    
            AllowedFilter::exact('day_24'),

    
            AllowedFilter::exact('day_25'),

    
            AllowedFilter::exact('day_26'),

    
            AllowedFilter::exact('day_27'),

    
            AllowedFilter::exact('day_28'),

    
            AllowedFilter::exact('day_29'),

    
            AllowedFilter::exact('day_30'),

    
            AllowedFilter::exact('day_31'),

    
    
    
    
    
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

    
            AllowedSort::field('mois'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('ville_id'),

    
            AllowedSort::field('zone_id'),

    
            AllowedSort::field('fonction_id'),

    
            AllowedSort::field('type_id'),

    
            AllowedSort::field('faction_id'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('day_01'),

    
            AllowedSort::field('day_02'),

    
            AllowedSort::field('day_03'),

    
            AllowedSort::field('day_04'),

    
            AllowedSort::field('day_05'),

    
            AllowedSort::field('day_06'),

    
            AllowedSort::field('day_07'),

    
            AllowedSort::field('day_08'),

    
            AllowedSort::field('day_09'),

    
            AllowedSort::field('day_10'),

    
            AllowedSort::field('day_11'),

    
            AllowedSort::field('day_12'),

    
            AllowedSort::field('day_13'),

    
            AllowedSort::field('day_14'),

    
            AllowedSort::field('day_15'),

    
            AllowedSort::field('day_16'),

    
            AllowedSort::field('day_17'),

    
            AllowedSort::field('day_18'),

    
            AllowedSort::field('day_19'),

    
            AllowedSort::field('day_20'),

    
            AllowedSort::field('day_21'),

    
            AllowedSort::field('day_22'),

    
            AllowedSort::field('day_23'),

    
            AllowedSort::field('day_24'),

    
            AllowedSort::field('day_25'),

    
            AllowedSort::field('day_26'),

    
            AllowedSort::field('day_27'),

    
            AllowedSort::field('day_28'),

    
            AllowedSort::field('day_29'),

    
            AllowedSort::field('day_30'),

    
            AllowedSort::field('day_31'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
    
    
    
    
->allowedIncludes([

            'client',
        

                'fonction',
        

                'poste',
        

                'site',
        

                'type',
        

                'ville',
        

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




$data = QueryBuilder::for(Rapport::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('mois'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('ville_id'),

    
            AllowedFilter::exact('zone_id'),

    
            AllowedFilter::exact('fonction_id'),

    
            AllowedFilter::exact('type_id'),

    
            AllowedFilter::exact('faction_id'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('day_01'),

    
            AllowedFilter::exact('day_02'),

    
            AllowedFilter::exact('day_03'),

    
            AllowedFilter::exact('day_04'),

    
            AllowedFilter::exact('day_05'),

    
            AllowedFilter::exact('day_06'),

    
            AllowedFilter::exact('day_07'),

    
            AllowedFilter::exact('day_08'),

    
            AllowedFilter::exact('day_09'),

    
            AllowedFilter::exact('day_10'),

    
            AllowedFilter::exact('day_11'),

    
            AllowedFilter::exact('day_12'),

    
            AllowedFilter::exact('day_13'),

    
            AllowedFilter::exact('day_14'),

    
            AllowedFilter::exact('day_15'),

    
            AllowedFilter::exact('day_16'),

    
            AllowedFilter::exact('day_17'),

    
            AllowedFilter::exact('day_18'),

    
            AllowedFilter::exact('day_19'),

    
            AllowedFilter::exact('day_20'),

    
            AllowedFilter::exact('day_21'),

    
            AllowedFilter::exact('day_22'),

    
            AllowedFilter::exact('day_23'),

    
            AllowedFilter::exact('day_24'),

    
            AllowedFilter::exact('day_25'),

    
            AllowedFilter::exact('day_26'),

    
            AllowedFilter::exact('day_27'),

    
            AllowedFilter::exact('day_28'),

    
            AllowedFilter::exact('day_29'),

    
            AllowedFilter::exact('day_30'),

    
            AllowedFilter::exact('day_31'),

    
    
    
    
    
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

    
            AllowedSort::field('mois'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('ville_id'),

    
            AllowedSort::field('zone_id'),

    
            AllowedSort::field('fonction_id'),

    
            AllowedSort::field('type_id'),

    
            AllowedSort::field('faction_id'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('day_01'),

    
            AllowedSort::field('day_02'),

    
            AllowedSort::field('day_03'),

    
            AllowedSort::field('day_04'),

    
            AllowedSort::field('day_05'),

    
            AllowedSort::field('day_06'),

    
            AllowedSort::field('day_07'),

    
            AllowedSort::field('day_08'),

    
            AllowedSort::field('day_09'),

    
            AllowedSort::field('day_10'),

    
            AllowedSort::field('day_11'),

    
            AllowedSort::field('day_12'),

    
            AllowedSort::field('day_13'),

    
            AllowedSort::field('day_14'),

    
            AllowedSort::field('day_15'),

    
            AllowedSort::field('day_16'),

    
            AllowedSort::field('day_17'),

    
            AllowedSort::field('day_18'),

    
            AllowedSort::field('day_19'),

    
            AllowedSort::field('day_20'),

    
            AllowedSort::field('day_21'),

    
            AllowedSort::field('day_22'),

    
            AllowedSort::field('day_23'),

    
            AllowedSort::field('day_24'),

    
            AllowedSort::field('day_25'),

    
            AllowedSort::field('day_26'),

    
            AllowedSort::field('day_27'),

    
            AllowedSort::field('day_28'),

    
            AllowedSort::field('day_29'),

    
            AllowedSort::field('day_30'),

    
            AllowedSort::field('day_31'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
    
    
    
    
->allowedIncludes([
            'client',
        

                'fonction',
        

                'poste',
        

                'site',
        

                'type',
        

                'ville',
        

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



public function create(Request $request, Rapport $Rapports)
{


try{
$can=\App\Helpers\Helpers::can('Creer des rapports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "rapports"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'mois',
    'poste_id',
    'ville_id',
    'zone_id',
    'fonction_id',
    'type_id',
    'faction_id',
    'site_id',
    'client_id',
    'day_01',
    'day_02',
    'day_03',
    'day_04',
    'day_05',
    'day_06',
    'day_07',
    'day_08',
    'day_09',
    'day_10',
    'day_11',
    'day_12',
    'day_13',
    'day_14',
    'day_15',
    'day_16',
    'day_17',
    'day_18',
    'day_19',
    'day_20',
    'day_21',
    'day_22',
    'day_23',
    'day_24',
    'day_25',
    'day_26',
    'day_27',
    'day_28',
    'day_29',
    'day_30',
    'day_31',
    'extra_attributes',
    'created_at',
    'updated_at',
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
    
    
                    'mois' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'ville_id' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
                    'fonction_id' => [
            //'required'
            ],
        
    
    
                    'type_id' => [
            //'required'
            ],
        
    
    
                    'faction_id' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'day_01' => [
            //'required'
            ],
        
    
    
                    'day_02' => [
            //'required'
            ],
        
    
    
                    'day_03' => [
            //'required'
            ],
        
    
    
                    'day_04' => [
            //'required'
            ],
        
    
    
                    'day_05' => [
            //'required'
            ],
        
    
    
                    'day_06' => [
            //'required'
            ],
        
    
    
                    'day_07' => [
            //'required'
            ],
        
    
    
                    'day_08' => [
            //'required'
            ],
        
    
    
                    'day_09' => [
            //'required'
            ],
        
    
    
                    'day_10' => [
            //'required'
            ],
        
    
    
                    'day_11' => [
            //'required'
            ],
        
    
    
                    'day_12' => [
            //'required'
            ],
        
    
    
                    'day_13' => [
            //'required'
            ],
        
    
    
                    'day_14' => [
            //'required'
            ],
        
    
    
                    'day_15' => [
            //'required'
            ],
        
    
    
                    'day_16' => [
            //'required'
            ],
        
    
    
                    'day_17' => [
            //'required'
            ],
        
    
    
                    'day_18' => [
            //'required'
            ],
        
    
    
                    'day_19' => [
            //'required'
            ],
        
    
    
                    'day_20' => [
            //'required'
            ],
        
    
    
                    'day_21' => [
            //'required'
            ],
        
    
    
                    'day_22' => [
            //'required'
            ],
        
    
    
                    'day_23' => [
            //'required'
            ],
        
    
    
                    'day_24' => [
            //'required'
            ],
        
    
    
                    'day_25' => [
            //'required'
            ],
        
    
    
                    'day_26' => [
            //'required'
            ],
        
    
    
                    'day_27' => [
            //'required'
            ],
        
    
    
                    'day_28' => [
            //'required'
            ],
        
    
    
                    'day_29' => [
            //'required'
            ],
        
    
    
                    'day_30' => [
            //'required'
            ],
        
    
    
                    'day_31' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'mois' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'ville_id' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
        'fonction_id' => ['cette donnee est obligatoire'],

    
    
        'type_id' => ['cette donnee est obligatoire'],

    
    
        'faction_id' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'day_01' => ['cette donnee est obligatoire'],

    
    
        'day_02' => ['cette donnee est obligatoire'],

    
    
        'day_03' => ['cette donnee est obligatoire'],

    
    
        'day_04' => ['cette donnee est obligatoire'],

    
    
        'day_05' => ['cette donnee est obligatoire'],

    
    
        'day_06' => ['cette donnee est obligatoire'],

    
    
        'day_07' => ['cette donnee est obligatoire'],

    
    
        'day_08' => ['cette donnee est obligatoire'],

    
    
        'day_09' => ['cette donnee est obligatoire'],

    
    
        'day_10' => ['cette donnee est obligatoire'],

    
    
        'day_11' => ['cette donnee est obligatoire'],

    
    
        'day_12' => ['cette donnee est obligatoire'],

    
    
        'day_13' => ['cette donnee est obligatoire'],

    
    
        'day_14' => ['cette donnee est obligatoire'],

    
    
        'day_15' => ['cette donnee est obligatoire'],

    
    
        'day_16' => ['cette donnee est obligatoire'],

    
    
        'day_17' => ['cette donnee est obligatoire'],

    
    
        'day_18' => ['cette donnee est obligatoire'],

    
    
        'day_19' => ['cette donnee est obligatoire'],

    
    
        'day_20' => ['cette donnee est obligatoire'],

    
    
        'day_21' => ['cette donnee est obligatoire'],

    
    
        'day_22' => ['cette donnee est obligatoire'],

    
    
        'day_23' => ['cette donnee est obligatoire'],

    
    
        'day_24' => ['cette donnee est obligatoire'],

    
    
        'day_25' => ['cette donnee est obligatoire'],

    
    
        'day_26' => ['cette donnee est obligatoire'],

    
    
        'day_27' => ['cette donnee est obligatoire'],

    
    
        'day_28' => ['cette donnee est obligatoire'],

    
    
        'day_29' => ['cette donnee est obligatoire'],

    
    
        'day_30' => ['cette donnee est obligatoire'],

    
    
        'day_31' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['mois'])){
        
            $Rapports->mois = $data['mois'];
        
        }



    







    

        if(!empty($data['poste_id'])){
        
            $Rapports->poste_id = $data['poste_id'];
        
        }



    







    

        if(!empty($data['ville_id'])){
        
            $Rapports->ville_id = $data['ville_id'];
        
        }



    







    

        if(!empty($data['zone_id'])){
        
            $Rapports->zone_id = $data['zone_id'];
        
        }



    







    

        if(!empty($data['fonction_id'])){
        
            $Rapports->fonction_id = $data['fonction_id'];
        
        }



    







    

        if(!empty($data['type_id'])){
        
            $Rapports->type_id = $data['type_id'];
        
        }



    







    

        if(!empty($data['faction_id'])){
        
            $Rapports->faction_id = $data['faction_id'];
        
        }



    







    

        if(!empty($data['site_id'])){
        
            $Rapports->site_id = $data['site_id'];
        
        }



    







    

        if(!empty($data['client_id'])){
        
            $Rapports->client_id = $data['client_id'];
        
        }



    







    

        if(!empty($data['day_01'])){
        
            $Rapports->day_01 = $data['day_01'];
        
        }



    







    

        if(!empty($data['day_02'])){
        
            $Rapports->day_02 = $data['day_02'];
        
        }



    







    

        if(!empty($data['day_03'])){
        
            $Rapports->day_03 = $data['day_03'];
        
        }



    







    

        if(!empty($data['day_04'])){
        
            $Rapports->day_04 = $data['day_04'];
        
        }



    







    

        if(!empty($data['day_05'])){
        
            $Rapports->day_05 = $data['day_05'];
        
        }



    







    

        if(!empty($data['day_06'])){
        
            $Rapports->day_06 = $data['day_06'];
        
        }



    







    

        if(!empty($data['day_07'])){
        
            $Rapports->day_07 = $data['day_07'];
        
        }



    







    

        if(!empty($data['day_08'])){
        
            $Rapports->day_08 = $data['day_08'];
        
        }



    







    

        if(!empty($data['day_09'])){
        
            $Rapports->day_09 = $data['day_09'];
        
        }



    







    

        if(!empty($data['day_10'])){
        
            $Rapports->day_10 = $data['day_10'];
        
        }



    







    

        if(!empty($data['day_11'])){
        
            $Rapports->day_11 = $data['day_11'];
        
        }



    







    

        if(!empty($data['day_12'])){
        
            $Rapports->day_12 = $data['day_12'];
        
        }



    







    

        if(!empty($data['day_13'])){
        
            $Rapports->day_13 = $data['day_13'];
        
        }



    







    

        if(!empty($data['day_14'])){
        
            $Rapports->day_14 = $data['day_14'];
        
        }



    







    

        if(!empty($data['day_15'])){
        
            $Rapports->day_15 = $data['day_15'];
        
        }



    







    

        if(!empty($data['day_16'])){
        
            $Rapports->day_16 = $data['day_16'];
        
        }



    







    

        if(!empty($data['day_17'])){
        
            $Rapports->day_17 = $data['day_17'];
        
        }



    







    

        if(!empty($data['day_18'])){
        
            $Rapports->day_18 = $data['day_18'];
        
        }



    







    

        if(!empty($data['day_19'])){
        
            $Rapports->day_19 = $data['day_19'];
        
        }



    







    

        if(!empty($data['day_20'])){
        
            $Rapports->day_20 = $data['day_20'];
        
        }



    







    

        if(!empty($data['day_21'])){
        
            $Rapports->day_21 = $data['day_21'];
        
        }



    







    

        if(!empty($data['day_22'])){
        
            $Rapports->day_22 = $data['day_22'];
        
        }



    







    

        if(!empty($data['day_23'])){
        
            $Rapports->day_23 = $data['day_23'];
        
        }



    







    

        if(!empty($data['day_24'])){
        
            $Rapports->day_24 = $data['day_24'];
        
        }



    







    

        if(!empty($data['day_25'])){
        
            $Rapports->day_25 = $data['day_25'];
        
        }



    







    

        if(!empty($data['day_26'])){
        
            $Rapports->day_26 = $data['day_26'];
        
        }



    







    

        if(!empty($data['day_27'])){
        
            $Rapports->day_27 = $data['day_27'];
        
        }



    







    

        if(!empty($data['day_28'])){
        
            $Rapports->day_28 = $data['day_28'];
        
        }



    







    

        if(!empty($data['day_29'])){
        
            $Rapports->day_29 = $data['day_29'];
        
        }



    







    

        if(!empty($data['day_30'])){
        
            $Rapports->day_30 = $data['day_30'];
        
        }



    







    

        if(!empty($data['day_31'])){
        
            $Rapports->day_31 = $data['day_31'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Rapports->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Rapports->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Rapports->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\RapportExtras') &&
method_exists('\App\Http\Extras\RapportExtras', 'beforeSaveCreate')
){
\App\Http\Extras\RapportExtras::beforeSaveCreate($request,$Rapports);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\RapportExtras') &&
method_exists('\App\Http\Extras\RapportExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\RapportExtras::canCreate($request, $Rapports);
}catch (\Throwable $e){

}

}


if($canSave){
$Rapports->save();
}else{
return response()->json($Rapports, 200);
}

$Rapports=Rapport::find($Rapports->id);
$newCrudData=[];

                $newCrudData['mois']=$Rapports->mois;
                $newCrudData['poste_id']=$Rapports->poste_id;
                $newCrudData['ville_id']=$Rapports->ville_id;
                $newCrudData['zone_id']=$Rapports->zone_id;
                $newCrudData['fonction_id']=$Rapports->fonction_id;
                $newCrudData['type_id']=$Rapports->type_id;
                $newCrudData['faction_id']=$Rapports->faction_id;
                $newCrudData['site_id']=$Rapports->site_id;
                $newCrudData['client_id']=$Rapports->client_id;
                $newCrudData['day_01']=$Rapports->day_01;
                $newCrudData['day_02']=$Rapports->day_02;
                $newCrudData['day_03']=$Rapports->day_03;
                $newCrudData['day_04']=$Rapports->day_04;
                $newCrudData['day_05']=$Rapports->day_05;
                $newCrudData['day_06']=$Rapports->day_06;
                $newCrudData['day_07']=$Rapports->day_07;
                $newCrudData['day_08']=$Rapports->day_08;
                $newCrudData['day_09']=$Rapports->day_09;
                $newCrudData['day_10']=$Rapports->day_10;
                $newCrudData['day_11']=$Rapports->day_11;
                $newCrudData['day_12']=$Rapports->day_12;
                $newCrudData['day_13']=$Rapports->day_13;
                $newCrudData['day_14']=$Rapports->day_14;
                $newCrudData['day_15']=$Rapports->day_15;
                $newCrudData['day_16']=$Rapports->day_16;
                $newCrudData['day_17']=$Rapports->day_17;
                $newCrudData['day_18']=$Rapports->day_18;
                $newCrudData['day_19']=$Rapports->day_19;
                $newCrudData['day_20']=$Rapports->day_20;
                $newCrudData['day_21']=$Rapports->day_21;
                $newCrudData['day_22']=$Rapports->day_22;
                $newCrudData['day_23']=$Rapports->day_23;
                $newCrudData['day_24']=$Rapports->day_24;
                $newCrudData['day_25']=$Rapports->day_25;
                $newCrudData['day_26']=$Rapports->day_26;
                $newCrudData['day_27']=$Rapports->day_27;
                $newCrudData['day_28']=$Rapports->day_28;
                $newCrudData['day_29']=$Rapports->day_29;
                $newCrudData['day_30']=$Rapports->day_30;
                $newCrudData['day_31']=$Rapports->day_31;
                                $newCrudData['identifiants_sadge']=$Rapports->identifiants_sadge;
                $newCrudData['creat_by']=$Rapports->creat_by;
    
 try{ $newCrudData['client']=$Rapports->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['fonction']=$Rapports->fonction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Rapports->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Rapports->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['type']=$Rapports->type->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Rapports->ville->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Rapports->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Rapports','entite_cle' => $Rapports->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Rapports->toArray();




try{

foreach ($Rapports->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Rapport $Rapports)
{
try{
$can=\App\Helpers\Helpers::can('Editer des rapports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['mois']=$Rapports->mois;
                $oldCrudData['poste_id']=$Rapports->poste_id;
                $oldCrudData['ville_id']=$Rapports->ville_id;
                $oldCrudData['zone_id']=$Rapports->zone_id;
                $oldCrudData['fonction_id']=$Rapports->fonction_id;
                $oldCrudData['type_id']=$Rapports->type_id;
                $oldCrudData['faction_id']=$Rapports->faction_id;
                $oldCrudData['site_id']=$Rapports->site_id;
                $oldCrudData['client_id']=$Rapports->client_id;
                $oldCrudData['day_01']=$Rapports->day_01;
                $oldCrudData['day_02']=$Rapports->day_02;
                $oldCrudData['day_03']=$Rapports->day_03;
                $oldCrudData['day_04']=$Rapports->day_04;
                $oldCrudData['day_05']=$Rapports->day_05;
                $oldCrudData['day_06']=$Rapports->day_06;
                $oldCrudData['day_07']=$Rapports->day_07;
                $oldCrudData['day_08']=$Rapports->day_08;
                $oldCrudData['day_09']=$Rapports->day_09;
                $oldCrudData['day_10']=$Rapports->day_10;
                $oldCrudData['day_11']=$Rapports->day_11;
                $oldCrudData['day_12']=$Rapports->day_12;
                $oldCrudData['day_13']=$Rapports->day_13;
                $oldCrudData['day_14']=$Rapports->day_14;
                $oldCrudData['day_15']=$Rapports->day_15;
                $oldCrudData['day_16']=$Rapports->day_16;
                $oldCrudData['day_17']=$Rapports->day_17;
                $oldCrudData['day_18']=$Rapports->day_18;
                $oldCrudData['day_19']=$Rapports->day_19;
                $oldCrudData['day_20']=$Rapports->day_20;
                $oldCrudData['day_21']=$Rapports->day_21;
                $oldCrudData['day_22']=$Rapports->day_22;
                $oldCrudData['day_23']=$Rapports->day_23;
                $oldCrudData['day_24']=$Rapports->day_24;
                $oldCrudData['day_25']=$Rapports->day_25;
                $oldCrudData['day_26']=$Rapports->day_26;
                $oldCrudData['day_27']=$Rapports->day_27;
                $oldCrudData['day_28']=$Rapports->day_28;
                $oldCrudData['day_29']=$Rapports->day_29;
                $oldCrudData['day_30']=$Rapports->day_30;
                $oldCrudData['day_31']=$Rapports->day_31;
                                $oldCrudData['identifiants_sadge']=$Rapports->identifiants_sadge;
                $oldCrudData['creat_by']=$Rapports->creat_by;
    
 try{ $oldCrudData['client']=$Rapports->client->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['fonction']=$Rapports->fonction->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['poste']=$Rapports->poste->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['site']=$Rapports->site->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['type']=$Rapports->type->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['ville']=$Rapports->ville->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['zone']=$Rapports->zone->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "rapports"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'mois',
    'poste_id',
    'ville_id',
    'zone_id',
    'fonction_id',
    'type_id',
    'faction_id',
    'site_id',
    'client_id',
    'day_01',
    'day_02',
    'day_03',
    'day_04',
    'day_05',
    'day_06',
    'day_07',
    'day_08',
    'day_09',
    'day_10',
    'day_11',
    'day_12',
    'day_13',
    'day_14',
    'day_15',
    'day_16',
    'day_17',
    'day_18',
    'day_19',
    'day_20',
    'day_21',
    'day_22',
    'day_23',
    'day_24',
    'day_25',
    'day_26',
    'day_27',
    'day_28',
    'day_29',
    'day_30',
    'day_31',
    'extra_attributes',
    'created_at',
    'updated_at',
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
    
    
                    'mois' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'ville_id' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
                    'fonction_id' => [
            //'required'
            ],
        
    
    
                    'type_id' => [
            //'required'
            ],
        
    
    
                    'faction_id' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'day_01' => [
            //'required'
            ],
        
    
    
                    'day_02' => [
            //'required'
            ],
        
    
    
                    'day_03' => [
            //'required'
            ],
        
    
    
                    'day_04' => [
            //'required'
            ],
        
    
    
                    'day_05' => [
            //'required'
            ],
        
    
    
                    'day_06' => [
            //'required'
            ],
        
    
    
                    'day_07' => [
            //'required'
            ],
        
    
    
                    'day_08' => [
            //'required'
            ],
        
    
    
                    'day_09' => [
            //'required'
            ],
        
    
    
                    'day_10' => [
            //'required'
            ],
        
    
    
                    'day_11' => [
            //'required'
            ],
        
    
    
                    'day_12' => [
            //'required'
            ],
        
    
    
                    'day_13' => [
            //'required'
            ],
        
    
    
                    'day_14' => [
            //'required'
            ],
        
    
    
                    'day_15' => [
            //'required'
            ],
        
    
    
                    'day_16' => [
            //'required'
            ],
        
    
    
                    'day_17' => [
            //'required'
            ],
        
    
    
                    'day_18' => [
            //'required'
            ],
        
    
    
                    'day_19' => [
            //'required'
            ],
        
    
    
                    'day_20' => [
            //'required'
            ],
        
    
    
                    'day_21' => [
            //'required'
            ],
        
    
    
                    'day_22' => [
            //'required'
            ],
        
    
    
                    'day_23' => [
            //'required'
            ],
        
    
    
                    'day_24' => [
            //'required'
            ],
        
    
    
                    'day_25' => [
            //'required'
            ],
        
    
    
                    'day_26' => [
            //'required'
            ],
        
    
    
                    'day_27' => [
            //'required'
            ],
        
    
    
                    'day_28' => [
            //'required'
            ],
        
    
    
                    'day_29' => [
            //'required'
            ],
        
    
    
                    'day_30' => [
            //'required'
            ],
        
    
    
                    'day_31' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'mois' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'ville_id' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
        'fonction_id' => ['cette donnee est obligatoire'],

    
    
        'type_id' => ['cette donnee est obligatoire'],

    
    
        'faction_id' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'day_01' => ['cette donnee est obligatoire'],

    
    
        'day_02' => ['cette donnee est obligatoire'],

    
    
        'day_03' => ['cette donnee est obligatoire'],

    
    
        'day_04' => ['cette donnee est obligatoire'],

    
    
        'day_05' => ['cette donnee est obligatoire'],

    
    
        'day_06' => ['cette donnee est obligatoire'],

    
    
        'day_07' => ['cette donnee est obligatoire'],

    
    
        'day_08' => ['cette donnee est obligatoire'],

    
    
        'day_09' => ['cette donnee est obligatoire'],

    
    
        'day_10' => ['cette donnee est obligatoire'],

    
    
        'day_11' => ['cette donnee est obligatoire'],

    
    
        'day_12' => ['cette donnee est obligatoire'],

    
    
        'day_13' => ['cette donnee est obligatoire'],

    
    
        'day_14' => ['cette donnee est obligatoire'],

    
    
        'day_15' => ['cette donnee est obligatoire'],

    
    
        'day_16' => ['cette donnee est obligatoire'],

    
    
        'day_17' => ['cette donnee est obligatoire'],

    
    
        'day_18' => ['cette donnee est obligatoire'],

    
    
        'day_19' => ['cette donnee est obligatoire'],

    
    
        'day_20' => ['cette donnee est obligatoire'],

    
    
        'day_21' => ['cette donnee est obligatoire'],

    
    
        'day_22' => ['cette donnee est obligatoire'],

    
    
        'day_23' => ['cette donnee est obligatoire'],

    
    
        'day_24' => ['cette donnee est obligatoire'],

    
    
        'day_25' => ['cette donnee est obligatoire'],

    
    
        'day_26' => ['cette donnee est obligatoire'],

    
    
        'day_27' => ['cette donnee est obligatoire'],

    
    
        'day_28' => ['cette donnee est obligatoire'],

    
    
        'day_29' => ['cette donnee est obligatoire'],

    
    
        'day_30' => ['cette donnee est obligatoire'],

    
    
        'day_31' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("mois",$data)){


        if(!empty($data['mois'])){
        
            $Rapports->mois = $data['mois'];
        
        }

        }

    







    

        if(array_key_exists("poste_id",$data)){


        if(!empty($data['poste_id'])){
        
            $Rapports->poste_id = $data['poste_id'];
        
        }

        }

    







    

        if(array_key_exists("ville_id",$data)){


        if(!empty($data['ville_id'])){
        
            $Rapports->ville_id = $data['ville_id'];
        
        }

        }

    







    

        if(array_key_exists("zone_id",$data)){


        if(!empty($data['zone_id'])){
        
            $Rapports->zone_id = $data['zone_id'];
        
        }

        }

    







    

        if(array_key_exists("fonction_id",$data)){


        if(!empty($data['fonction_id'])){
        
            $Rapports->fonction_id = $data['fonction_id'];
        
        }

        }

    







    

        if(array_key_exists("type_id",$data)){


        if(!empty($data['type_id'])){
        
            $Rapports->type_id = $data['type_id'];
        
        }

        }

    







    

        if(array_key_exists("faction_id",$data)){


        if(!empty($data['faction_id'])){
        
            $Rapports->faction_id = $data['faction_id'];
        
        }

        }

    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Rapports->site_id = $data['site_id'];
        
        }

        }

    







    

        if(array_key_exists("client_id",$data)){


        if(!empty($data['client_id'])){
        
            $Rapports->client_id = $data['client_id'];
        
        }

        }

    







    

        if(array_key_exists("day_01",$data)){


        if(!empty($data['day_01'])){
        
            $Rapports->day_01 = $data['day_01'];
        
        }

        }

    







    

        if(array_key_exists("day_02",$data)){


        if(!empty($data['day_02'])){
        
            $Rapports->day_02 = $data['day_02'];
        
        }

        }

    







    

        if(array_key_exists("day_03",$data)){


        if(!empty($data['day_03'])){
        
            $Rapports->day_03 = $data['day_03'];
        
        }

        }

    







    

        if(array_key_exists("day_04",$data)){


        if(!empty($data['day_04'])){
        
            $Rapports->day_04 = $data['day_04'];
        
        }

        }

    







    

        if(array_key_exists("day_05",$data)){


        if(!empty($data['day_05'])){
        
            $Rapports->day_05 = $data['day_05'];
        
        }

        }

    







    

        if(array_key_exists("day_06",$data)){


        if(!empty($data['day_06'])){
        
            $Rapports->day_06 = $data['day_06'];
        
        }

        }

    







    

        if(array_key_exists("day_07",$data)){


        if(!empty($data['day_07'])){
        
            $Rapports->day_07 = $data['day_07'];
        
        }

        }

    







    

        if(array_key_exists("day_08",$data)){


        if(!empty($data['day_08'])){
        
            $Rapports->day_08 = $data['day_08'];
        
        }

        }

    







    

        if(array_key_exists("day_09",$data)){


        if(!empty($data['day_09'])){
        
            $Rapports->day_09 = $data['day_09'];
        
        }

        }

    







    

        if(array_key_exists("day_10",$data)){


        if(!empty($data['day_10'])){
        
            $Rapports->day_10 = $data['day_10'];
        
        }

        }

    







    

        if(array_key_exists("day_11",$data)){


        if(!empty($data['day_11'])){
        
            $Rapports->day_11 = $data['day_11'];
        
        }

        }

    







    

        if(array_key_exists("day_12",$data)){


        if(!empty($data['day_12'])){
        
            $Rapports->day_12 = $data['day_12'];
        
        }

        }

    







    

        if(array_key_exists("day_13",$data)){


        if(!empty($data['day_13'])){
        
            $Rapports->day_13 = $data['day_13'];
        
        }

        }

    







    

        if(array_key_exists("day_14",$data)){


        if(!empty($data['day_14'])){
        
            $Rapports->day_14 = $data['day_14'];
        
        }

        }

    







    

        if(array_key_exists("day_15",$data)){


        if(!empty($data['day_15'])){
        
            $Rapports->day_15 = $data['day_15'];
        
        }

        }

    







    

        if(array_key_exists("day_16",$data)){


        if(!empty($data['day_16'])){
        
            $Rapports->day_16 = $data['day_16'];
        
        }

        }

    







    

        if(array_key_exists("day_17",$data)){


        if(!empty($data['day_17'])){
        
            $Rapports->day_17 = $data['day_17'];
        
        }

        }

    







    

        if(array_key_exists("day_18",$data)){


        if(!empty($data['day_18'])){
        
            $Rapports->day_18 = $data['day_18'];
        
        }

        }

    







    

        if(array_key_exists("day_19",$data)){


        if(!empty($data['day_19'])){
        
            $Rapports->day_19 = $data['day_19'];
        
        }

        }

    







    

        if(array_key_exists("day_20",$data)){


        if(!empty($data['day_20'])){
        
            $Rapports->day_20 = $data['day_20'];
        
        }

        }

    







    

        if(array_key_exists("day_21",$data)){


        if(!empty($data['day_21'])){
        
            $Rapports->day_21 = $data['day_21'];
        
        }

        }

    







    

        if(array_key_exists("day_22",$data)){


        if(!empty($data['day_22'])){
        
            $Rapports->day_22 = $data['day_22'];
        
        }

        }

    







    

        if(array_key_exists("day_23",$data)){


        if(!empty($data['day_23'])){
        
            $Rapports->day_23 = $data['day_23'];
        
        }

        }

    







    

        if(array_key_exists("day_24",$data)){


        if(!empty($data['day_24'])){
        
            $Rapports->day_24 = $data['day_24'];
        
        }

        }

    







    

        if(array_key_exists("day_25",$data)){


        if(!empty($data['day_25'])){
        
            $Rapports->day_25 = $data['day_25'];
        
        }

        }

    







    

        if(array_key_exists("day_26",$data)){


        if(!empty($data['day_26'])){
        
            $Rapports->day_26 = $data['day_26'];
        
        }

        }

    







    

        if(array_key_exists("day_27",$data)){


        if(!empty($data['day_27'])){
        
            $Rapports->day_27 = $data['day_27'];
        
        }

        }

    







    

        if(array_key_exists("day_28",$data)){


        if(!empty($data['day_28'])){
        
            $Rapports->day_28 = $data['day_28'];
        
        }

        }

    







    

        if(array_key_exists("day_29",$data)){


        if(!empty($data['day_29'])){
        
            $Rapports->day_29 = $data['day_29'];
        
        }

        }

    







    

        if(array_key_exists("day_30",$data)){


        if(!empty($data['day_30'])){
        
            $Rapports->day_30 = $data['day_30'];
        
        }

        }

    







    

        if(array_key_exists("day_31",$data)){


        if(!empty($data['day_31'])){
        
            $Rapports->day_31 = $data['day_31'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Rapports->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Rapports->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Rapports->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\RapportExtras') &&
method_exists('\App\Http\Extras\RapportExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\RapportExtras::beforeSaveUpdate($request,$Rapports);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\RapportExtras') &&
method_exists('\App\Http\Extras\RapportExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\RapportExtras::canUpdate($request, $Rapports);
}catch (\Throwable $e){

}

}


if($canSave){
$Rapports->save();
}else{
return response()->json($Rapports, 200);

}


$Rapports=Rapport::find($Rapports->id);



$newCrudData=[];

                $newCrudData['mois']=$Rapports->mois;
                $newCrudData['poste_id']=$Rapports->poste_id;
                $newCrudData['ville_id']=$Rapports->ville_id;
                $newCrudData['zone_id']=$Rapports->zone_id;
                $newCrudData['fonction_id']=$Rapports->fonction_id;
                $newCrudData['type_id']=$Rapports->type_id;
                $newCrudData['faction_id']=$Rapports->faction_id;
                $newCrudData['site_id']=$Rapports->site_id;
                $newCrudData['client_id']=$Rapports->client_id;
                $newCrudData['day_01']=$Rapports->day_01;
                $newCrudData['day_02']=$Rapports->day_02;
                $newCrudData['day_03']=$Rapports->day_03;
                $newCrudData['day_04']=$Rapports->day_04;
                $newCrudData['day_05']=$Rapports->day_05;
                $newCrudData['day_06']=$Rapports->day_06;
                $newCrudData['day_07']=$Rapports->day_07;
                $newCrudData['day_08']=$Rapports->day_08;
                $newCrudData['day_09']=$Rapports->day_09;
                $newCrudData['day_10']=$Rapports->day_10;
                $newCrudData['day_11']=$Rapports->day_11;
                $newCrudData['day_12']=$Rapports->day_12;
                $newCrudData['day_13']=$Rapports->day_13;
                $newCrudData['day_14']=$Rapports->day_14;
                $newCrudData['day_15']=$Rapports->day_15;
                $newCrudData['day_16']=$Rapports->day_16;
                $newCrudData['day_17']=$Rapports->day_17;
                $newCrudData['day_18']=$Rapports->day_18;
                $newCrudData['day_19']=$Rapports->day_19;
                $newCrudData['day_20']=$Rapports->day_20;
                $newCrudData['day_21']=$Rapports->day_21;
                $newCrudData['day_22']=$Rapports->day_22;
                $newCrudData['day_23']=$Rapports->day_23;
                $newCrudData['day_24']=$Rapports->day_24;
                $newCrudData['day_25']=$Rapports->day_25;
                $newCrudData['day_26']=$Rapports->day_26;
                $newCrudData['day_27']=$Rapports->day_27;
                $newCrudData['day_28']=$Rapports->day_28;
                $newCrudData['day_29']=$Rapports->day_29;
                $newCrudData['day_30']=$Rapports->day_30;
                $newCrudData['day_31']=$Rapports->day_31;
                                $newCrudData['identifiants_sadge']=$Rapports->identifiants_sadge;
                $newCrudData['creat_by']=$Rapports->creat_by;
    
 try{ $newCrudData['client']=$Rapports->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['fonction']=$Rapports->fonction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Rapports->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Rapports->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['type']=$Rapports->type->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Rapports->ville->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Rapports->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Rapports','entite_cle' => $Rapports->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Rapports->toArray();




try{

foreach ($Rapports->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Rapport $Rapports)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des rapports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['mois']=$Rapports->mois;
                $newCrudData['poste_id']=$Rapports->poste_id;
                $newCrudData['ville_id']=$Rapports->ville_id;
                $newCrudData['zone_id']=$Rapports->zone_id;
                $newCrudData['fonction_id']=$Rapports->fonction_id;
                $newCrudData['type_id']=$Rapports->type_id;
                $newCrudData['faction_id']=$Rapports->faction_id;
                $newCrudData['site_id']=$Rapports->site_id;
                $newCrudData['client_id']=$Rapports->client_id;
                $newCrudData['day_01']=$Rapports->day_01;
                $newCrudData['day_02']=$Rapports->day_02;
                $newCrudData['day_03']=$Rapports->day_03;
                $newCrudData['day_04']=$Rapports->day_04;
                $newCrudData['day_05']=$Rapports->day_05;
                $newCrudData['day_06']=$Rapports->day_06;
                $newCrudData['day_07']=$Rapports->day_07;
                $newCrudData['day_08']=$Rapports->day_08;
                $newCrudData['day_09']=$Rapports->day_09;
                $newCrudData['day_10']=$Rapports->day_10;
                $newCrudData['day_11']=$Rapports->day_11;
                $newCrudData['day_12']=$Rapports->day_12;
                $newCrudData['day_13']=$Rapports->day_13;
                $newCrudData['day_14']=$Rapports->day_14;
                $newCrudData['day_15']=$Rapports->day_15;
                $newCrudData['day_16']=$Rapports->day_16;
                $newCrudData['day_17']=$Rapports->day_17;
                $newCrudData['day_18']=$Rapports->day_18;
                $newCrudData['day_19']=$Rapports->day_19;
                $newCrudData['day_20']=$Rapports->day_20;
                $newCrudData['day_21']=$Rapports->day_21;
                $newCrudData['day_22']=$Rapports->day_22;
                $newCrudData['day_23']=$Rapports->day_23;
                $newCrudData['day_24']=$Rapports->day_24;
                $newCrudData['day_25']=$Rapports->day_25;
                $newCrudData['day_26']=$Rapports->day_26;
                $newCrudData['day_27']=$Rapports->day_27;
                $newCrudData['day_28']=$Rapports->day_28;
                $newCrudData['day_29']=$Rapports->day_29;
                $newCrudData['day_30']=$Rapports->day_30;
                $newCrudData['day_31']=$Rapports->day_31;
                                $newCrudData['identifiants_sadge']=$Rapports->identifiants_sadge;
                $newCrudData['creat_by']=$Rapports->creat_by;
    
 try{ $newCrudData['client']=$Rapports->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['fonction']=$Rapports->fonction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Rapports->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Rapports->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['type']=$Rapports->type->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Rapports->ville->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Rapports->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Rapports','entite_cle' => $Rapports->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\RapportExtras') &&
method_exists('\App\Http\Extras\RapportExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\RapportExtras::canDelete($request, $Rapports);
}catch (\Throwable $e){

}

}



if($canSave){
$Rapports->delete();
}else{
return response()->json($Rapports, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\RapportsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
