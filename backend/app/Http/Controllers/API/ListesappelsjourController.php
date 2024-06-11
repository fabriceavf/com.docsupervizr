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
// use App\Repository\prod\ListesappelsjoursRepository;
use App\Models\Listesappelsjour;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Listesappel;
        
class ListesappelsjourController extends Controller
{

private $ListesappelsjoursRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ListesappelsjoursRepository $ListesappelsjoursRepository
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
class_exists('\App\Http\Extras\ListesappelsjourExtras') &&
method_exists('\App\Http\Extras\ListesappelsjourExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ListesappelsjourExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Listesappelsjour::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ListesappelsjourExtras') &&
method_exists('\App\Http\Extras\ListesappelsjourExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ListesappelsjourExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('listesappelsjours',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ListesappelsjourExtras') &&
method_exists('\App\Http\Extras\ListesappelsjourExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ListesappelsjourExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  listesappelsjours reussi',
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
return response()->json(Listesappelsjour::count());
}
$data = QueryBuilder::for(Listesappelsjour::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('rand'),

    
            AllowedFilter::exact('jour01'),

    
            AllowedFilter::exact('jour02'),

    
            AllowedFilter::exact('jour03'),

    
            AllowedFilter::exact('jour04'),

    
            AllowedFilter::exact('jour05'),

    
            AllowedFilter::exact('jour06'),

    
            AllowedFilter::exact('jour07'),

    
            AllowedFilter::exact('jour08'),

    
            AllowedFilter::exact('jour09'),

    
            AllowedFilter::exact('jour10'),

    
            AllowedFilter::exact('jour11'),

    
            AllowedFilter::exact('jour12'),

    
            AllowedFilter::exact('jour13'),

    
            AllowedFilter::exact('jour14'),

    
            AllowedFilter::exact('jour15'),

    
            AllowedFilter::exact('jour16'),

    
            AllowedFilter::exact('jour17'),

    
            AllowedFilter::exact('jour18'),

    
            AllowedFilter::exact('jour19'),

    
            AllowedFilter::exact('jour20'),

    
            AllowedFilter::exact('jour21'),

    
            AllowedFilter::exact('jour22'),

    
            AllowedFilter::exact('jour23'),

    
            AllowedFilter::exact('jour24'),

    
            AllowedFilter::exact('jour25'),

    
            AllowedFilter::exact('jour26'),

    
            AllowedFilter::exact('jour27'),

    
            AllowedFilter::exact('jour28'),

    
            AllowedFilter::exact('jour29'),

    
            AllowedFilter::exact('jour30'),

    
            AllowedFilter::exact('jour31'),

    
            AllowedFilter::exact('tache01'),

    
            AllowedFilter::exact('tache02'),

    
            AllowedFilter::exact('tache03'),

    
            AllowedFilter::exact('tache04'),

    
            AllowedFilter::exact('tache05'),

    
            AllowedFilter::exact('tache06'),

    
            AllowedFilter::exact('tache07'),

    
            AllowedFilter::exact('tache08'),

    
            AllowedFilter::exact('tache09'),

    
            AllowedFilter::exact('tache10'),

    
            AllowedFilter::exact('tache11'),

    
            AllowedFilter::exact('tache12'),

    
            AllowedFilter::exact('tache13'),

    
            AllowedFilter::exact('tache14'),

    
            AllowedFilter::exact('tache15'),

    
            AllowedFilter::exact('tache16'),

    
            AllowedFilter::exact('tache17'),

    
            AllowedFilter::exact('tache18'),

    
            AllowedFilter::exact('tache19'),

    
            AllowedFilter::exact('tache20'),

    
            AllowedFilter::exact('tache21'),

    
            AllowedFilter::exact('tache22'),

    
            AllowedFilter::exact('tache23'),

    
            AllowedFilter::exact('tache24'),

    
            AllowedFilter::exact('tache25'),

    
            AllowedFilter::exact('tache26'),

    
            AllowedFilter::exact('tache27'),

    
            AllowedFilter::exact('tache28'),

    
            AllowedFilter::exact('tache29'),

    
            AllowedFilter::exact('tache30'),

    
            AllowedFilter::exact('tache31'),

    
            AllowedFilter::exact('listesappel_id'),

    
            AllowedFilter::exact('user_id'),

    
    
    
    
    
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

    
            AllowedSort::field('rand'),

    
            AllowedSort::field('jour01'),

    
            AllowedSort::field('jour02'),

    
            AllowedSort::field('jour03'),

    
            AllowedSort::field('jour04'),

    
            AllowedSort::field('jour05'),

    
            AllowedSort::field('jour06'),

    
            AllowedSort::field('jour07'),

    
            AllowedSort::field('jour08'),

    
            AllowedSort::field('jour09'),

    
            AllowedSort::field('jour10'),

    
            AllowedSort::field('jour11'),

    
            AllowedSort::field('jour12'),

    
            AllowedSort::field('jour13'),

    
            AllowedSort::field('jour14'),

    
            AllowedSort::field('jour15'),

    
            AllowedSort::field('jour16'),

    
            AllowedSort::field('jour17'),

    
            AllowedSort::field('jour18'),

    
            AllowedSort::field('jour19'),

    
            AllowedSort::field('jour20'),

    
            AllowedSort::field('jour21'),

    
            AllowedSort::field('jour22'),

    
            AllowedSort::field('jour23'),

    
            AllowedSort::field('jour24'),

    
            AllowedSort::field('jour25'),

    
            AllowedSort::field('jour26'),

    
            AllowedSort::field('jour27'),

    
            AllowedSort::field('jour28'),

    
            AllowedSort::field('jour29'),

    
            AllowedSort::field('jour30'),

    
            AllowedSort::field('jour31'),

    
            AllowedSort::field('tache01'),

    
            AllowedSort::field('tache02'),

    
            AllowedSort::field('tache03'),

    
            AllowedSort::field('tache04'),

    
            AllowedSort::field('tache05'),

    
            AllowedSort::field('tache06'),

    
            AllowedSort::field('tache07'),

    
            AllowedSort::field('tache08'),

    
            AllowedSort::field('tache09'),

    
            AllowedSort::field('tache10'),

    
            AllowedSort::field('tache11'),

    
            AllowedSort::field('tache12'),

    
            AllowedSort::field('tache13'),

    
            AllowedSort::field('tache14'),

    
            AllowedSort::field('tache15'),

    
            AllowedSort::field('tache16'),

    
            AllowedSort::field('tache17'),

    
            AllowedSort::field('tache18'),

    
            AllowedSort::field('tache19'),

    
            AllowedSort::field('tache20'),

    
            AllowedSort::field('tache21'),

    
            AllowedSort::field('tache22'),

    
            AllowedSort::field('tache23'),

    
            AllowedSort::field('tache24'),

    
            AllowedSort::field('tache25'),

    
            AllowedSort::field('tache26'),

    
            AllowedSort::field('tache27'),

    
            AllowedSort::field('tache28'),

    
            AllowedSort::field('tache29'),

    
            AllowedSort::field('tache30'),

    
            AllowedSort::field('tache31'),

    
            AllowedSort::field('listesappel_id'),

    
            AllowedSort::field('user_id'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([

            'listesappel',
        

                'user',
        

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




$data = QueryBuilder::for(Listesappelsjour::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('rand'),

    
            AllowedFilter::exact('jour01'),

    
            AllowedFilter::exact('jour02'),

    
            AllowedFilter::exact('jour03'),

    
            AllowedFilter::exact('jour04'),

    
            AllowedFilter::exact('jour05'),

    
            AllowedFilter::exact('jour06'),

    
            AllowedFilter::exact('jour07'),

    
            AllowedFilter::exact('jour08'),

    
            AllowedFilter::exact('jour09'),

    
            AllowedFilter::exact('jour10'),

    
            AllowedFilter::exact('jour11'),

    
            AllowedFilter::exact('jour12'),

    
            AllowedFilter::exact('jour13'),

    
            AllowedFilter::exact('jour14'),

    
            AllowedFilter::exact('jour15'),

    
            AllowedFilter::exact('jour16'),

    
            AllowedFilter::exact('jour17'),

    
            AllowedFilter::exact('jour18'),

    
            AllowedFilter::exact('jour19'),

    
            AllowedFilter::exact('jour20'),

    
            AllowedFilter::exact('jour21'),

    
            AllowedFilter::exact('jour22'),

    
            AllowedFilter::exact('jour23'),

    
            AllowedFilter::exact('jour24'),

    
            AllowedFilter::exact('jour25'),

    
            AllowedFilter::exact('jour26'),

    
            AllowedFilter::exact('jour27'),

    
            AllowedFilter::exact('jour28'),

    
            AllowedFilter::exact('jour29'),

    
            AllowedFilter::exact('jour30'),

    
            AllowedFilter::exact('jour31'),

    
            AllowedFilter::exact('tache01'),

    
            AllowedFilter::exact('tache02'),

    
            AllowedFilter::exact('tache03'),

    
            AllowedFilter::exact('tache04'),

    
            AllowedFilter::exact('tache05'),

    
            AllowedFilter::exact('tache06'),

    
            AllowedFilter::exact('tache07'),

    
            AllowedFilter::exact('tache08'),

    
            AllowedFilter::exact('tache09'),

    
            AllowedFilter::exact('tache10'),

    
            AllowedFilter::exact('tache11'),

    
            AllowedFilter::exact('tache12'),

    
            AllowedFilter::exact('tache13'),

    
            AllowedFilter::exact('tache14'),

    
            AllowedFilter::exact('tache15'),

    
            AllowedFilter::exact('tache16'),

    
            AllowedFilter::exact('tache17'),

    
            AllowedFilter::exact('tache18'),

    
            AllowedFilter::exact('tache19'),

    
            AllowedFilter::exact('tache20'),

    
            AllowedFilter::exact('tache21'),

    
            AllowedFilter::exact('tache22'),

    
            AllowedFilter::exact('tache23'),

    
            AllowedFilter::exact('tache24'),

    
            AllowedFilter::exact('tache25'),

    
            AllowedFilter::exact('tache26'),

    
            AllowedFilter::exact('tache27'),

    
            AllowedFilter::exact('tache28'),

    
            AllowedFilter::exact('tache29'),

    
            AllowedFilter::exact('tache30'),

    
            AllowedFilter::exact('tache31'),

    
            AllowedFilter::exact('listesappel_id'),

    
            AllowedFilter::exact('user_id'),

    
    
    
    
    
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

    
            AllowedSort::field('rand'),

    
            AllowedSort::field('jour01'),

    
            AllowedSort::field('jour02'),

    
            AllowedSort::field('jour03'),

    
            AllowedSort::field('jour04'),

    
            AllowedSort::field('jour05'),

    
            AllowedSort::field('jour06'),

    
            AllowedSort::field('jour07'),

    
            AllowedSort::field('jour08'),

    
            AllowedSort::field('jour09'),

    
            AllowedSort::field('jour10'),

    
            AllowedSort::field('jour11'),

    
            AllowedSort::field('jour12'),

    
            AllowedSort::field('jour13'),

    
            AllowedSort::field('jour14'),

    
            AllowedSort::field('jour15'),

    
            AllowedSort::field('jour16'),

    
            AllowedSort::field('jour17'),

    
            AllowedSort::field('jour18'),

    
            AllowedSort::field('jour19'),

    
            AllowedSort::field('jour20'),

    
            AllowedSort::field('jour21'),

    
            AllowedSort::field('jour22'),

    
            AllowedSort::field('jour23'),

    
            AllowedSort::field('jour24'),

    
            AllowedSort::field('jour25'),

    
            AllowedSort::field('jour26'),

    
            AllowedSort::field('jour27'),

    
            AllowedSort::field('jour28'),

    
            AllowedSort::field('jour29'),

    
            AllowedSort::field('jour30'),

    
            AllowedSort::field('jour31'),

    
            AllowedSort::field('tache01'),

    
            AllowedSort::field('tache02'),

    
            AllowedSort::field('tache03'),

    
            AllowedSort::field('tache04'),

    
            AllowedSort::field('tache05'),

    
            AllowedSort::field('tache06'),

    
            AllowedSort::field('tache07'),

    
            AllowedSort::field('tache08'),

    
            AllowedSort::field('tache09'),

    
            AllowedSort::field('tache10'),

    
            AllowedSort::field('tache11'),

    
            AllowedSort::field('tache12'),

    
            AllowedSort::field('tache13'),

    
            AllowedSort::field('tache14'),

    
            AllowedSort::field('tache15'),

    
            AllowedSort::field('tache16'),

    
            AllowedSort::field('tache17'),

    
            AllowedSort::field('tache18'),

    
            AllowedSort::field('tache19'),

    
            AllowedSort::field('tache20'),

    
            AllowedSort::field('tache21'),

    
            AllowedSort::field('tache22'),

    
            AllowedSort::field('tache23'),

    
            AllowedSort::field('tache24'),

    
            AllowedSort::field('tache25'),

    
            AllowedSort::field('tache26'),

    
            AllowedSort::field('tache27'),

    
            AllowedSort::field('tache28'),

    
            AllowedSort::field('tache29'),

    
            AllowedSort::field('tache30'),

    
            AllowedSort::field('tache31'),

    
            AllowedSort::field('listesappel_id'),

    
            AllowedSort::field('user_id'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'listesappel',
        

                'user',
        

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



public function create(Request $request, Listesappelsjour $Listesappelsjours)
{


try{
$can=\App\Helpers\Helpers::can('Creer des listesappelsjours');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "listesappelsjours"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'rand',
    'jour01',
    'jour02',
    'jour03',
    'jour04',
    'jour05',
    'jour06',
    'jour07',
    'jour08',
    'jour09',
    'jour10',
    'jour11',
    'jour12',
    'jour13',
    'jour14',
    'jour15',
    'jour16',
    'jour17',
    'jour18',
    'jour19',
    'jour20',
    'jour21',
    'jour22',
    'jour23',
    'jour24',
    'jour25',
    'jour26',
    'jour27',
    'jour28',
    'jour29',
    'jour30',
    'jour31',
    'tache01',
    'tache02',
    'tache03',
    'tache04',
    'tache05',
    'tache06',
    'tache07',
    'tache08',
    'tache09',
    'tache10',
    'tache11',
    'tache12',
    'tache13',
    'tache14',
    'tache15',
    'tache16',
    'tache17',
    'tache18',
    'tache19',
    'tache20',
    'tache21',
    'tache22',
    'tache23',
    'tache24',
    'tache25',
    'tache26',
    'tache27',
    'tache28',
    'tache29',
    'tache30',
    'tache31',
    'listesappel_id',
    'user_id',
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
    
    
                    'rand' => [
            //'required'
            ],
        
    
    
                    'jour01' => [
            //'required'
            ],
        
    
    
                    'jour02' => [
            //'required'
            ],
        
    
    
                    'jour03' => [
            //'required'
            ],
        
    
    
                    'jour04' => [
            //'required'
            ],
        
    
    
                    'jour05' => [
            //'required'
            ],
        
    
    
                    'jour06' => [
            //'required'
            ],
        
    
    
                    'jour07' => [
            //'required'
            ],
        
    
    
                    'jour08' => [
            //'required'
            ],
        
    
    
                    'jour09' => [
            //'required'
            ],
        
    
    
                    'jour10' => [
            //'required'
            ],
        
    
    
                    'jour11' => [
            //'required'
            ],
        
    
    
                    'jour12' => [
            //'required'
            ],
        
    
    
                    'jour13' => [
            //'required'
            ],
        
    
    
                    'jour14' => [
            //'required'
            ],
        
    
    
                    'jour15' => [
            //'required'
            ],
        
    
    
                    'jour16' => [
            //'required'
            ],
        
    
    
                    'jour17' => [
            //'required'
            ],
        
    
    
                    'jour18' => [
            //'required'
            ],
        
    
    
                    'jour19' => [
            //'required'
            ],
        
    
    
                    'jour20' => [
            //'required'
            ],
        
    
    
                    'jour21' => [
            //'required'
            ],
        
    
    
                    'jour22' => [
            //'required'
            ],
        
    
    
                    'jour23' => [
            //'required'
            ],
        
    
    
                    'jour24' => [
            //'required'
            ],
        
    
    
                    'jour25' => [
            //'required'
            ],
        
    
    
                    'jour26' => [
            //'required'
            ],
        
    
    
                    'jour27' => [
            //'required'
            ],
        
    
    
                    'jour28' => [
            //'required'
            ],
        
    
    
                    'jour29' => [
            //'required'
            ],
        
    
    
                    'jour30' => [
            //'required'
            ],
        
    
    
                    'jour31' => [
            //'required'
            ],
        
    
    
                    'tache01' => [
            //'required'
            ],
        
    
    
                    'tache02' => [
            //'required'
            ],
        
    
    
                    'tache03' => [
            //'required'
            ],
        
    
    
                    'tache04' => [
            //'required'
            ],
        
    
    
                    'tache05' => [
            //'required'
            ],
        
    
    
                    'tache06' => [
            //'required'
            ],
        
    
    
                    'tache07' => [
            //'required'
            ],
        
    
    
                    'tache08' => [
            //'required'
            ],
        
    
    
                    'tache09' => [
            //'required'
            ],
        
    
    
                    'tache10' => [
            //'required'
            ],
        
    
    
                    'tache11' => [
            //'required'
            ],
        
    
    
                    'tache12' => [
            //'required'
            ],
        
    
    
                    'tache13' => [
            //'required'
            ],
        
    
    
                    'tache14' => [
            //'required'
            ],
        
    
    
                    'tache15' => [
            //'required'
            ],
        
    
    
                    'tache16' => [
            //'required'
            ],
        
    
    
                    'tache17' => [
            //'required'
            ],
        
    
    
                    'tache18' => [
            //'required'
            ],
        
    
    
                    'tache19' => [
            //'required'
            ],
        
    
    
                    'tache20' => [
            //'required'
            ],
        
    
    
                    'tache21' => [
            //'required'
            ],
        
    
    
                    'tache22' => [
            //'required'
            ],
        
    
    
                    'tache23' => [
            //'required'
            ],
        
    
    
                    'tache24' => [
            //'required'
            ],
        
    
    
                    'tache25' => [
            //'required'
            ],
        
    
    
                    'tache26' => [
            //'required'
            ],
        
    
    
                    'tache27' => [
            //'required'
            ],
        
    
    
                    'tache28' => [
            //'required'
            ],
        
    
    
                    'tache29' => [
            //'required'
            ],
        
    
    
                    'tache30' => [
            //'required'
            ],
        
    
    
                    'tache31' => [
            //'required'
            ],
        
    
    
                    'listesappel_id' => [
            //'required'
            ],
        
    
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'rand' => ['cette donnee est obligatoire'],

    
    
        'jour01' => ['cette donnee est obligatoire'],

    
    
        'jour02' => ['cette donnee est obligatoire'],

    
    
        'jour03' => ['cette donnee est obligatoire'],

    
    
        'jour04' => ['cette donnee est obligatoire'],

    
    
        'jour05' => ['cette donnee est obligatoire'],

    
    
        'jour06' => ['cette donnee est obligatoire'],

    
    
        'jour07' => ['cette donnee est obligatoire'],

    
    
        'jour08' => ['cette donnee est obligatoire'],

    
    
        'jour09' => ['cette donnee est obligatoire'],

    
    
        'jour10' => ['cette donnee est obligatoire'],

    
    
        'jour11' => ['cette donnee est obligatoire'],

    
    
        'jour12' => ['cette donnee est obligatoire'],

    
    
        'jour13' => ['cette donnee est obligatoire'],

    
    
        'jour14' => ['cette donnee est obligatoire'],

    
    
        'jour15' => ['cette donnee est obligatoire'],

    
    
        'jour16' => ['cette donnee est obligatoire'],

    
    
        'jour17' => ['cette donnee est obligatoire'],

    
    
        'jour18' => ['cette donnee est obligatoire'],

    
    
        'jour19' => ['cette donnee est obligatoire'],

    
    
        'jour20' => ['cette donnee est obligatoire'],

    
    
        'jour21' => ['cette donnee est obligatoire'],

    
    
        'jour22' => ['cette donnee est obligatoire'],

    
    
        'jour23' => ['cette donnee est obligatoire'],

    
    
        'jour24' => ['cette donnee est obligatoire'],

    
    
        'jour25' => ['cette donnee est obligatoire'],

    
    
        'jour26' => ['cette donnee est obligatoire'],

    
    
        'jour27' => ['cette donnee est obligatoire'],

    
    
        'jour28' => ['cette donnee est obligatoire'],

    
    
        'jour29' => ['cette donnee est obligatoire'],

    
    
        'jour30' => ['cette donnee est obligatoire'],

    
    
        'jour31' => ['cette donnee est obligatoire'],

    
    
        'tache01' => ['cette donnee est obligatoire'],

    
    
        'tache02' => ['cette donnee est obligatoire'],

    
    
        'tache03' => ['cette donnee est obligatoire'],

    
    
        'tache04' => ['cette donnee est obligatoire'],

    
    
        'tache05' => ['cette donnee est obligatoire'],

    
    
        'tache06' => ['cette donnee est obligatoire'],

    
    
        'tache07' => ['cette donnee est obligatoire'],

    
    
        'tache08' => ['cette donnee est obligatoire'],

    
    
        'tache09' => ['cette donnee est obligatoire'],

    
    
        'tache10' => ['cette donnee est obligatoire'],

    
    
        'tache11' => ['cette donnee est obligatoire'],

    
    
        'tache12' => ['cette donnee est obligatoire'],

    
    
        'tache13' => ['cette donnee est obligatoire'],

    
    
        'tache14' => ['cette donnee est obligatoire'],

    
    
        'tache15' => ['cette donnee est obligatoire'],

    
    
        'tache16' => ['cette donnee est obligatoire'],

    
    
        'tache17' => ['cette donnee est obligatoire'],

    
    
        'tache18' => ['cette donnee est obligatoire'],

    
    
        'tache19' => ['cette donnee est obligatoire'],

    
    
        'tache20' => ['cette donnee est obligatoire'],

    
    
        'tache21' => ['cette donnee est obligatoire'],

    
    
        'tache22' => ['cette donnee est obligatoire'],

    
    
        'tache23' => ['cette donnee est obligatoire'],

    
    
        'tache24' => ['cette donnee est obligatoire'],

    
    
        'tache25' => ['cette donnee est obligatoire'],

    
    
        'tache26' => ['cette donnee est obligatoire'],

    
    
        'tache27' => ['cette donnee est obligatoire'],

    
    
        'tache28' => ['cette donnee est obligatoire'],

    
    
        'tache29' => ['cette donnee est obligatoire'],

    
    
        'tache30' => ['cette donnee est obligatoire'],

    
    
        'tache31' => ['cette donnee est obligatoire'],

    
    
        'listesappel_id' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['rand'])){
        
            $Listesappelsjours->rand = $data['rand'];
        
        }



    







    

        if(!empty($data['jour01'])){
        
            $Listesappelsjours->jour01 = $data['jour01'];
        
        }



    







    

        if(!empty($data['jour02'])){
        
            $Listesappelsjours->jour02 = $data['jour02'];
        
        }



    







    

        if(!empty($data['jour03'])){
        
            $Listesappelsjours->jour03 = $data['jour03'];
        
        }



    







    

        if(!empty($data['jour04'])){
        
            $Listesappelsjours->jour04 = $data['jour04'];
        
        }



    







    

        if(!empty($data['jour05'])){
        
            $Listesappelsjours->jour05 = $data['jour05'];
        
        }



    







    

        if(!empty($data['jour06'])){
        
            $Listesappelsjours->jour06 = $data['jour06'];
        
        }



    







    

        if(!empty($data['jour07'])){
        
            $Listesappelsjours->jour07 = $data['jour07'];
        
        }



    







    

        if(!empty($data['jour08'])){
        
            $Listesappelsjours->jour08 = $data['jour08'];
        
        }



    







    

        if(!empty($data['jour09'])){
        
            $Listesappelsjours->jour09 = $data['jour09'];
        
        }



    







    

        if(!empty($data['jour10'])){
        
            $Listesappelsjours->jour10 = $data['jour10'];
        
        }



    







    

        if(!empty($data['jour11'])){
        
            $Listesappelsjours->jour11 = $data['jour11'];
        
        }



    







    

        if(!empty($data['jour12'])){
        
            $Listesappelsjours->jour12 = $data['jour12'];
        
        }



    







    

        if(!empty($data['jour13'])){
        
            $Listesappelsjours->jour13 = $data['jour13'];
        
        }



    







    

        if(!empty($data['jour14'])){
        
            $Listesappelsjours->jour14 = $data['jour14'];
        
        }



    







    

        if(!empty($data['jour15'])){
        
            $Listesappelsjours->jour15 = $data['jour15'];
        
        }



    







    

        if(!empty($data['jour16'])){
        
            $Listesappelsjours->jour16 = $data['jour16'];
        
        }



    







    

        if(!empty($data['jour17'])){
        
            $Listesappelsjours->jour17 = $data['jour17'];
        
        }



    







    

        if(!empty($data['jour18'])){
        
            $Listesappelsjours->jour18 = $data['jour18'];
        
        }



    







    

        if(!empty($data['jour19'])){
        
            $Listesappelsjours->jour19 = $data['jour19'];
        
        }



    







    

        if(!empty($data['jour20'])){
        
            $Listesappelsjours->jour20 = $data['jour20'];
        
        }



    







    

        if(!empty($data['jour21'])){
        
            $Listesappelsjours->jour21 = $data['jour21'];
        
        }



    







    

        if(!empty($data['jour22'])){
        
            $Listesappelsjours->jour22 = $data['jour22'];
        
        }



    







    

        if(!empty($data['jour23'])){
        
            $Listesappelsjours->jour23 = $data['jour23'];
        
        }



    







    

        if(!empty($data['jour24'])){
        
            $Listesappelsjours->jour24 = $data['jour24'];
        
        }



    







    

        if(!empty($data['jour25'])){
        
            $Listesappelsjours->jour25 = $data['jour25'];
        
        }



    







    

        if(!empty($data['jour26'])){
        
            $Listesappelsjours->jour26 = $data['jour26'];
        
        }



    







    

        if(!empty($data['jour27'])){
        
            $Listesappelsjours->jour27 = $data['jour27'];
        
        }



    







    

        if(!empty($data['jour28'])){
        
            $Listesappelsjours->jour28 = $data['jour28'];
        
        }



    







    

        if(!empty($data['jour29'])){
        
            $Listesappelsjours->jour29 = $data['jour29'];
        
        }



    







    

        if(!empty($data['jour30'])){
        
            $Listesappelsjours->jour30 = $data['jour30'];
        
        }



    







    

        if(!empty($data['jour31'])){
        
            $Listesappelsjours->jour31 = $data['jour31'];
        
        }



    







    

        if(!empty($data['tache01'])){
        
            $Listesappelsjours->tache01 = $data['tache01'];
        
        }



    







    

        if(!empty($data['tache02'])){
        
            $Listesappelsjours->tache02 = $data['tache02'];
        
        }



    







    

        if(!empty($data['tache03'])){
        
            $Listesappelsjours->tache03 = $data['tache03'];
        
        }



    







    

        if(!empty($data['tache04'])){
        
            $Listesappelsjours->tache04 = $data['tache04'];
        
        }



    







    

        if(!empty($data['tache05'])){
        
            $Listesappelsjours->tache05 = $data['tache05'];
        
        }



    







    

        if(!empty($data['tache06'])){
        
            $Listesappelsjours->tache06 = $data['tache06'];
        
        }



    







    

        if(!empty($data['tache07'])){
        
            $Listesappelsjours->tache07 = $data['tache07'];
        
        }



    







    

        if(!empty($data['tache08'])){
        
            $Listesappelsjours->tache08 = $data['tache08'];
        
        }



    







    

        if(!empty($data['tache09'])){
        
            $Listesappelsjours->tache09 = $data['tache09'];
        
        }



    







    

        if(!empty($data['tache10'])){
        
            $Listesappelsjours->tache10 = $data['tache10'];
        
        }



    







    

        if(!empty($data['tache11'])){
        
            $Listesappelsjours->tache11 = $data['tache11'];
        
        }



    







    

        if(!empty($data['tache12'])){
        
            $Listesappelsjours->tache12 = $data['tache12'];
        
        }



    







    

        if(!empty($data['tache13'])){
        
            $Listesappelsjours->tache13 = $data['tache13'];
        
        }



    







    

        if(!empty($data['tache14'])){
        
            $Listesappelsjours->tache14 = $data['tache14'];
        
        }



    







    

        if(!empty($data['tache15'])){
        
            $Listesappelsjours->tache15 = $data['tache15'];
        
        }



    







    

        if(!empty($data['tache16'])){
        
            $Listesappelsjours->tache16 = $data['tache16'];
        
        }



    







    

        if(!empty($data['tache17'])){
        
            $Listesappelsjours->tache17 = $data['tache17'];
        
        }



    







    

        if(!empty($data['tache18'])){
        
            $Listesappelsjours->tache18 = $data['tache18'];
        
        }



    







    

        if(!empty($data['tache19'])){
        
            $Listesappelsjours->tache19 = $data['tache19'];
        
        }



    







    

        if(!empty($data['tache20'])){
        
            $Listesappelsjours->tache20 = $data['tache20'];
        
        }



    







    

        if(!empty($data['tache21'])){
        
            $Listesappelsjours->tache21 = $data['tache21'];
        
        }



    







    

        if(!empty($data['tache22'])){
        
            $Listesappelsjours->tache22 = $data['tache22'];
        
        }



    







    

        if(!empty($data['tache23'])){
        
            $Listesappelsjours->tache23 = $data['tache23'];
        
        }



    







    

        if(!empty($data['tache24'])){
        
            $Listesappelsjours->tache24 = $data['tache24'];
        
        }



    







    

        if(!empty($data['tache25'])){
        
            $Listesappelsjours->tache25 = $data['tache25'];
        
        }



    







    

        if(!empty($data['tache26'])){
        
            $Listesappelsjours->tache26 = $data['tache26'];
        
        }



    







    

        if(!empty($data['tache27'])){
        
            $Listesappelsjours->tache27 = $data['tache27'];
        
        }



    







    

        if(!empty($data['tache28'])){
        
            $Listesappelsjours->tache28 = $data['tache28'];
        
        }



    







    

        if(!empty($data['tache29'])){
        
            $Listesappelsjours->tache29 = $data['tache29'];
        
        }



    







    

        if(!empty($data['tache30'])){
        
            $Listesappelsjours->tache30 = $data['tache30'];
        
        }



    







    

        if(!empty($data['tache31'])){
        
            $Listesappelsjours->tache31 = $data['tache31'];
        
        }



    







    

        if(!empty($data['listesappel_id'])){
        
            $Listesappelsjours->listesappel_id = $data['listesappel_id'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Listesappelsjours->user_id = $data['user_id'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Listesappelsjours->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Listesappelsjours->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Listesappelsjours->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ListesappelsjourExtras') &&
method_exists('\App\Http\Extras\ListesappelsjourExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ListesappelsjourExtras::beforeSaveCreate($request,$Listesappelsjours);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ListesappelsjourExtras') &&
method_exists('\App\Http\Extras\ListesappelsjourExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ListesappelsjourExtras::canCreate($request, $Listesappelsjours);
}catch (\Throwable $e){

}

}


if($canSave){
$Listesappelsjours->save();
}else{
return response()->json($Listesappelsjours, 200);
}

$Listesappelsjours=Listesappelsjour::find($Listesappelsjours->id);
$newCrudData=[];

                $newCrudData['rand']=$Listesappelsjours->rand;
                $newCrudData['jour01']=$Listesappelsjours->jour01;
                $newCrudData['jour02']=$Listesappelsjours->jour02;
                $newCrudData['jour03']=$Listesappelsjours->jour03;
                $newCrudData['jour04']=$Listesappelsjours->jour04;
                $newCrudData['jour05']=$Listesappelsjours->jour05;
                $newCrudData['jour06']=$Listesappelsjours->jour06;
                $newCrudData['jour07']=$Listesappelsjours->jour07;
                $newCrudData['jour08']=$Listesappelsjours->jour08;
                $newCrudData['jour09']=$Listesappelsjours->jour09;
                $newCrudData['jour10']=$Listesappelsjours->jour10;
                $newCrudData['jour11']=$Listesappelsjours->jour11;
                $newCrudData['jour12']=$Listesappelsjours->jour12;
                $newCrudData['jour13']=$Listesappelsjours->jour13;
                $newCrudData['jour14']=$Listesappelsjours->jour14;
                $newCrudData['jour15']=$Listesappelsjours->jour15;
                $newCrudData['jour16']=$Listesappelsjours->jour16;
                $newCrudData['jour17']=$Listesappelsjours->jour17;
                $newCrudData['jour18']=$Listesappelsjours->jour18;
                $newCrudData['jour19']=$Listesappelsjours->jour19;
                $newCrudData['jour20']=$Listesappelsjours->jour20;
                $newCrudData['jour21']=$Listesappelsjours->jour21;
                $newCrudData['jour22']=$Listesappelsjours->jour22;
                $newCrudData['jour23']=$Listesappelsjours->jour23;
                $newCrudData['jour24']=$Listesappelsjours->jour24;
                $newCrudData['jour25']=$Listesappelsjours->jour25;
                $newCrudData['jour26']=$Listesappelsjours->jour26;
                $newCrudData['jour27']=$Listesappelsjours->jour27;
                $newCrudData['jour28']=$Listesappelsjours->jour28;
                $newCrudData['jour29']=$Listesappelsjours->jour29;
                $newCrudData['jour30']=$Listesappelsjours->jour30;
                $newCrudData['jour31']=$Listesappelsjours->jour31;
                $newCrudData['tache01']=$Listesappelsjours->tache01;
                $newCrudData['tache02']=$Listesappelsjours->tache02;
                $newCrudData['tache03']=$Listesappelsjours->tache03;
                $newCrudData['tache04']=$Listesappelsjours->tache04;
                $newCrudData['tache05']=$Listesappelsjours->tache05;
                $newCrudData['tache06']=$Listesappelsjours->tache06;
                $newCrudData['tache07']=$Listesappelsjours->tache07;
                $newCrudData['tache08']=$Listesappelsjours->tache08;
                $newCrudData['tache09']=$Listesappelsjours->tache09;
                $newCrudData['tache10']=$Listesappelsjours->tache10;
                $newCrudData['tache11']=$Listesappelsjours->tache11;
                $newCrudData['tache12']=$Listesappelsjours->tache12;
                $newCrudData['tache13']=$Listesappelsjours->tache13;
                $newCrudData['tache14']=$Listesappelsjours->tache14;
                $newCrudData['tache15']=$Listesappelsjours->tache15;
                $newCrudData['tache16']=$Listesappelsjours->tache16;
                $newCrudData['tache17']=$Listesappelsjours->tache17;
                $newCrudData['tache18']=$Listesappelsjours->tache18;
                $newCrudData['tache19']=$Listesappelsjours->tache19;
                $newCrudData['tache20']=$Listesappelsjours->tache20;
                $newCrudData['tache21']=$Listesappelsjours->tache21;
                $newCrudData['tache22']=$Listesappelsjours->tache22;
                $newCrudData['tache23']=$Listesappelsjours->tache23;
                $newCrudData['tache24']=$Listesappelsjours->tache24;
                $newCrudData['tache25']=$Listesappelsjours->tache25;
                $newCrudData['tache26']=$Listesappelsjours->tache26;
                $newCrudData['tache27']=$Listesappelsjours->tache27;
                $newCrudData['tache28']=$Listesappelsjours->tache28;
                $newCrudData['tache29']=$Listesappelsjours->tache29;
                $newCrudData['tache30']=$Listesappelsjours->tache30;
                $newCrudData['tache31']=$Listesappelsjours->tache31;
                $newCrudData['listesappel_id']=$Listesappelsjours->listesappel_id;
                $newCrudData['user_id']=$Listesappelsjours->user_id;
                                $newCrudData['identifiants_sadge']=$Listesappelsjours->identifiants_sadge;
                $newCrudData['creat_by']=$Listesappelsjours->creat_by;
    
 try{ $newCrudData['listesappel']=$Listesappelsjours->listesappel->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Listesappelsjours->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Listesappelsjours','entite_cle' => $Listesappelsjours->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Listesappelsjours->toArray();




try{

foreach ($Listesappelsjours->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Listesappelsjour $Listesappelsjours)
{
try{
$can=\App\Helpers\Helpers::can('Editer des listesappelsjours');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['rand']=$Listesappelsjours->rand;
                $oldCrudData['jour01']=$Listesappelsjours->jour01;
                $oldCrudData['jour02']=$Listesappelsjours->jour02;
                $oldCrudData['jour03']=$Listesappelsjours->jour03;
                $oldCrudData['jour04']=$Listesappelsjours->jour04;
                $oldCrudData['jour05']=$Listesappelsjours->jour05;
                $oldCrudData['jour06']=$Listesappelsjours->jour06;
                $oldCrudData['jour07']=$Listesappelsjours->jour07;
                $oldCrudData['jour08']=$Listesappelsjours->jour08;
                $oldCrudData['jour09']=$Listesappelsjours->jour09;
                $oldCrudData['jour10']=$Listesappelsjours->jour10;
                $oldCrudData['jour11']=$Listesappelsjours->jour11;
                $oldCrudData['jour12']=$Listesappelsjours->jour12;
                $oldCrudData['jour13']=$Listesappelsjours->jour13;
                $oldCrudData['jour14']=$Listesappelsjours->jour14;
                $oldCrudData['jour15']=$Listesappelsjours->jour15;
                $oldCrudData['jour16']=$Listesappelsjours->jour16;
                $oldCrudData['jour17']=$Listesappelsjours->jour17;
                $oldCrudData['jour18']=$Listesappelsjours->jour18;
                $oldCrudData['jour19']=$Listesappelsjours->jour19;
                $oldCrudData['jour20']=$Listesappelsjours->jour20;
                $oldCrudData['jour21']=$Listesappelsjours->jour21;
                $oldCrudData['jour22']=$Listesappelsjours->jour22;
                $oldCrudData['jour23']=$Listesappelsjours->jour23;
                $oldCrudData['jour24']=$Listesappelsjours->jour24;
                $oldCrudData['jour25']=$Listesappelsjours->jour25;
                $oldCrudData['jour26']=$Listesappelsjours->jour26;
                $oldCrudData['jour27']=$Listesappelsjours->jour27;
                $oldCrudData['jour28']=$Listesappelsjours->jour28;
                $oldCrudData['jour29']=$Listesappelsjours->jour29;
                $oldCrudData['jour30']=$Listesappelsjours->jour30;
                $oldCrudData['jour31']=$Listesappelsjours->jour31;
                $oldCrudData['tache01']=$Listesappelsjours->tache01;
                $oldCrudData['tache02']=$Listesappelsjours->tache02;
                $oldCrudData['tache03']=$Listesappelsjours->tache03;
                $oldCrudData['tache04']=$Listesappelsjours->tache04;
                $oldCrudData['tache05']=$Listesappelsjours->tache05;
                $oldCrudData['tache06']=$Listesappelsjours->tache06;
                $oldCrudData['tache07']=$Listesappelsjours->tache07;
                $oldCrudData['tache08']=$Listesappelsjours->tache08;
                $oldCrudData['tache09']=$Listesappelsjours->tache09;
                $oldCrudData['tache10']=$Listesappelsjours->tache10;
                $oldCrudData['tache11']=$Listesappelsjours->tache11;
                $oldCrudData['tache12']=$Listesappelsjours->tache12;
                $oldCrudData['tache13']=$Listesappelsjours->tache13;
                $oldCrudData['tache14']=$Listesappelsjours->tache14;
                $oldCrudData['tache15']=$Listesappelsjours->tache15;
                $oldCrudData['tache16']=$Listesappelsjours->tache16;
                $oldCrudData['tache17']=$Listesappelsjours->tache17;
                $oldCrudData['tache18']=$Listesappelsjours->tache18;
                $oldCrudData['tache19']=$Listesappelsjours->tache19;
                $oldCrudData['tache20']=$Listesappelsjours->tache20;
                $oldCrudData['tache21']=$Listesappelsjours->tache21;
                $oldCrudData['tache22']=$Listesappelsjours->tache22;
                $oldCrudData['tache23']=$Listesappelsjours->tache23;
                $oldCrudData['tache24']=$Listesappelsjours->tache24;
                $oldCrudData['tache25']=$Listesappelsjours->tache25;
                $oldCrudData['tache26']=$Listesappelsjours->tache26;
                $oldCrudData['tache27']=$Listesappelsjours->tache27;
                $oldCrudData['tache28']=$Listesappelsjours->tache28;
                $oldCrudData['tache29']=$Listesappelsjours->tache29;
                $oldCrudData['tache30']=$Listesappelsjours->tache30;
                $oldCrudData['tache31']=$Listesappelsjours->tache31;
                $oldCrudData['listesappel_id']=$Listesappelsjours->listesappel_id;
                $oldCrudData['user_id']=$Listesappelsjours->user_id;
                                $oldCrudData['identifiants_sadge']=$Listesappelsjours->identifiants_sadge;
                $oldCrudData['creat_by']=$Listesappelsjours->creat_by;
    
 try{ $oldCrudData['listesappel']=$Listesappelsjours->listesappel->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Listesappelsjours->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "listesappelsjours"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'rand',
    'jour01',
    'jour02',
    'jour03',
    'jour04',
    'jour05',
    'jour06',
    'jour07',
    'jour08',
    'jour09',
    'jour10',
    'jour11',
    'jour12',
    'jour13',
    'jour14',
    'jour15',
    'jour16',
    'jour17',
    'jour18',
    'jour19',
    'jour20',
    'jour21',
    'jour22',
    'jour23',
    'jour24',
    'jour25',
    'jour26',
    'jour27',
    'jour28',
    'jour29',
    'jour30',
    'jour31',
    'tache01',
    'tache02',
    'tache03',
    'tache04',
    'tache05',
    'tache06',
    'tache07',
    'tache08',
    'tache09',
    'tache10',
    'tache11',
    'tache12',
    'tache13',
    'tache14',
    'tache15',
    'tache16',
    'tache17',
    'tache18',
    'tache19',
    'tache20',
    'tache21',
    'tache22',
    'tache23',
    'tache24',
    'tache25',
    'tache26',
    'tache27',
    'tache28',
    'tache29',
    'tache30',
    'tache31',
    'listesappel_id',
    'user_id',
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
    
    
                    'rand' => [
            //'required'
            ],
        
    
    
                    'jour01' => [
            //'required'
            ],
        
    
    
                    'jour02' => [
            //'required'
            ],
        
    
    
                    'jour03' => [
            //'required'
            ],
        
    
    
                    'jour04' => [
            //'required'
            ],
        
    
    
                    'jour05' => [
            //'required'
            ],
        
    
    
                    'jour06' => [
            //'required'
            ],
        
    
    
                    'jour07' => [
            //'required'
            ],
        
    
    
                    'jour08' => [
            //'required'
            ],
        
    
    
                    'jour09' => [
            //'required'
            ],
        
    
    
                    'jour10' => [
            //'required'
            ],
        
    
    
                    'jour11' => [
            //'required'
            ],
        
    
    
                    'jour12' => [
            //'required'
            ],
        
    
    
                    'jour13' => [
            //'required'
            ],
        
    
    
                    'jour14' => [
            //'required'
            ],
        
    
    
                    'jour15' => [
            //'required'
            ],
        
    
    
                    'jour16' => [
            //'required'
            ],
        
    
    
                    'jour17' => [
            //'required'
            ],
        
    
    
                    'jour18' => [
            //'required'
            ],
        
    
    
                    'jour19' => [
            //'required'
            ],
        
    
    
                    'jour20' => [
            //'required'
            ],
        
    
    
                    'jour21' => [
            //'required'
            ],
        
    
    
                    'jour22' => [
            //'required'
            ],
        
    
    
                    'jour23' => [
            //'required'
            ],
        
    
    
                    'jour24' => [
            //'required'
            ],
        
    
    
                    'jour25' => [
            //'required'
            ],
        
    
    
                    'jour26' => [
            //'required'
            ],
        
    
    
                    'jour27' => [
            //'required'
            ],
        
    
    
                    'jour28' => [
            //'required'
            ],
        
    
    
                    'jour29' => [
            //'required'
            ],
        
    
    
                    'jour30' => [
            //'required'
            ],
        
    
    
                    'jour31' => [
            //'required'
            ],
        
    
    
                    'tache01' => [
            //'required'
            ],
        
    
    
                    'tache02' => [
            //'required'
            ],
        
    
    
                    'tache03' => [
            //'required'
            ],
        
    
    
                    'tache04' => [
            //'required'
            ],
        
    
    
                    'tache05' => [
            //'required'
            ],
        
    
    
                    'tache06' => [
            //'required'
            ],
        
    
    
                    'tache07' => [
            //'required'
            ],
        
    
    
                    'tache08' => [
            //'required'
            ],
        
    
    
                    'tache09' => [
            //'required'
            ],
        
    
    
                    'tache10' => [
            //'required'
            ],
        
    
    
                    'tache11' => [
            //'required'
            ],
        
    
    
                    'tache12' => [
            //'required'
            ],
        
    
    
                    'tache13' => [
            //'required'
            ],
        
    
    
                    'tache14' => [
            //'required'
            ],
        
    
    
                    'tache15' => [
            //'required'
            ],
        
    
    
                    'tache16' => [
            //'required'
            ],
        
    
    
                    'tache17' => [
            //'required'
            ],
        
    
    
                    'tache18' => [
            //'required'
            ],
        
    
    
                    'tache19' => [
            //'required'
            ],
        
    
    
                    'tache20' => [
            //'required'
            ],
        
    
    
                    'tache21' => [
            //'required'
            ],
        
    
    
                    'tache22' => [
            //'required'
            ],
        
    
    
                    'tache23' => [
            //'required'
            ],
        
    
    
                    'tache24' => [
            //'required'
            ],
        
    
    
                    'tache25' => [
            //'required'
            ],
        
    
    
                    'tache26' => [
            //'required'
            ],
        
    
    
                    'tache27' => [
            //'required'
            ],
        
    
    
                    'tache28' => [
            //'required'
            ],
        
    
    
                    'tache29' => [
            //'required'
            ],
        
    
    
                    'tache30' => [
            //'required'
            ],
        
    
    
                    'tache31' => [
            //'required'
            ],
        
    
    
                    'listesappel_id' => [
            //'required'
            ],
        
    
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'rand' => ['cette donnee est obligatoire'],

    
    
        'jour01' => ['cette donnee est obligatoire'],

    
    
        'jour02' => ['cette donnee est obligatoire'],

    
    
        'jour03' => ['cette donnee est obligatoire'],

    
    
        'jour04' => ['cette donnee est obligatoire'],

    
    
        'jour05' => ['cette donnee est obligatoire'],

    
    
        'jour06' => ['cette donnee est obligatoire'],

    
    
        'jour07' => ['cette donnee est obligatoire'],

    
    
        'jour08' => ['cette donnee est obligatoire'],

    
    
        'jour09' => ['cette donnee est obligatoire'],

    
    
        'jour10' => ['cette donnee est obligatoire'],

    
    
        'jour11' => ['cette donnee est obligatoire'],

    
    
        'jour12' => ['cette donnee est obligatoire'],

    
    
        'jour13' => ['cette donnee est obligatoire'],

    
    
        'jour14' => ['cette donnee est obligatoire'],

    
    
        'jour15' => ['cette donnee est obligatoire'],

    
    
        'jour16' => ['cette donnee est obligatoire'],

    
    
        'jour17' => ['cette donnee est obligatoire'],

    
    
        'jour18' => ['cette donnee est obligatoire'],

    
    
        'jour19' => ['cette donnee est obligatoire'],

    
    
        'jour20' => ['cette donnee est obligatoire'],

    
    
        'jour21' => ['cette donnee est obligatoire'],

    
    
        'jour22' => ['cette donnee est obligatoire'],

    
    
        'jour23' => ['cette donnee est obligatoire'],

    
    
        'jour24' => ['cette donnee est obligatoire'],

    
    
        'jour25' => ['cette donnee est obligatoire'],

    
    
        'jour26' => ['cette donnee est obligatoire'],

    
    
        'jour27' => ['cette donnee est obligatoire'],

    
    
        'jour28' => ['cette donnee est obligatoire'],

    
    
        'jour29' => ['cette donnee est obligatoire'],

    
    
        'jour30' => ['cette donnee est obligatoire'],

    
    
        'jour31' => ['cette donnee est obligatoire'],

    
    
        'tache01' => ['cette donnee est obligatoire'],

    
    
        'tache02' => ['cette donnee est obligatoire'],

    
    
        'tache03' => ['cette donnee est obligatoire'],

    
    
        'tache04' => ['cette donnee est obligatoire'],

    
    
        'tache05' => ['cette donnee est obligatoire'],

    
    
        'tache06' => ['cette donnee est obligatoire'],

    
    
        'tache07' => ['cette donnee est obligatoire'],

    
    
        'tache08' => ['cette donnee est obligatoire'],

    
    
        'tache09' => ['cette donnee est obligatoire'],

    
    
        'tache10' => ['cette donnee est obligatoire'],

    
    
        'tache11' => ['cette donnee est obligatoire'],

    
    
        'tache12' => ['cette donnee est obligatoire'],

    
    
        'tache13' => ['cette donnee est obligatoire'],

    
    
        'tache14' => ['cette donnee est obligatoire'],

    
    
        'tache15' => ['cette donnee est obligatoire'],

    
    
        'tache16' => ['cette donnee est obligatoire'],

    
    
        'tache17' => ['cette donnee est obligatoire'],

    
    
        'tache18' => ['cette donnee est obligatoire'],

    
    
        'tache19' => ['cette donnee est obligatoire'],

    
    
        'tache20' => ['cette donnee est obligatoire'],

    
    
        'tache21' => ['cette donnee est obligatoire'],

    
    
        'tache22' => ['cette donnee est obligatoire'],

    
    
        'tache23' => ['cette donnee est obligatoire'],

    
    
        'tache24' => ['cette donnee est obligatoire'],

    
    
        'tache25' => ['cette donnee est obligatoire'],

    
    
        'tache26' => ['cette donnee est obligatoire'],

    
    
        'tache27' => ['cette donnee est obligatoire'],

    
    
        'tache28' => ['cette donnee est obligatoire'],

    
    
        'tache29' => ['cette donnee est obligatoire'],

    
    
        'tache30' => ['cette donnee est obligatoire'],

    
    
        'tache31' => ['cette donnee est obligatoire'],

    
    
        'listesappel_id' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("rand",$data)){


        if(!empty($data['rand'])){
        
            $Listesappelsjours->rand = $data['rand'];
        
        }

        }

    







    

        if(array_key_exists("jour01",$data)){


        if(!empty($data['jour01'])){
        
            $Listesappelsjours->jour01 = $data['jour01'];
        
        }

        }

    







    

        if(array_key_exists("jour02",$data)){


        if(!empty($data['jour02'])){
        
            $Listesappelsjours->jour02 = $data['jour02'];
        
        }

        }

    







    

        if(array_key_exists("jour03",$data)){


        if(!empty($data['jour03'])){
        
            $Listesappelsjours->jour03 = $data['jour03'];
        
        }

        }

    







    

        if(array_key_exists("jour04",$data)){


        if(!empty($data['jour04'])){
        
            $Listesappelsjours->jour04 = $data['jour04'];
        
        }

        }

    







    

        if(array_key_exists("jour05",$data)){


        if(!empty($data['jour05'])){
        
            $Listesappelsjours->jour05 = $data['jour05'];
        
        }

        }

    







    

        if(array_key_exists("jour06",$data)){


        if(!empty($data['jour06'])){
        
            $Listesappelsjours->jour06 = $data['jour06'];
        
        }

        }

    







    

        if(array_key_exists("jour07",$data)){


        if(!empty($data['jour07'])){
        
            $Listesappelsjours->jour07 = $data['jour07'];
        
        }

        }

    







    

        if(array_key_exists("jour08",$data)){


        if(!empty($data['jour08'])){
        
            $Listesappelsjours->jour08 = $data['jour08'];
        
        }

        }

    







    

        if(array_key_exists("jour09",$data)){


        if(!empty($data['jour09'])){
        
            $Listesappelsjours->jour09 = $data['jour09'];
        
        }

        }

    







    

        if(array_key_exists("jour10",$data)){


        if(!empty($data['jour10'])){
        
            $Listesappelsjours->jour10 = $data['jour10'];
        
        }

        }

    







    

        if(array_key_exists("jour11",$data)){


        if(!empty($data['jour11'])){
        
            $Listesappelsjours->jour11 = $data['jour11'];
        
        }

        }

    







    

        if(array_key_exists("jour12",$data)){


        if(!empty($data['jour12'])){
        
            $Listesappelsjours->jour12 = $data['jour12'];
        
        }

        }

    







    

        if(array_key_exists("jour13",$data)){


        if(!empty($data['jour13'])){
        
            $Listesappelsjours->jour13 = $data['jour13'];
        
        }

        }

    







    

        if(array_key_exists("jour14",$data)){


        if(!empty($data['jour14'])){
        
            $Listesappelsjours->jour14 = $data['jour14'];
        
        }

        }

    







    

        if(array_key_exists("jour15",$data)){


        if(!empty($data['jour15'])){
        
            $Listesappelsjours->jour15 = $data['jour15'];
        
        }

        }

    







    

        if(array_key_exists("jour16",$data)){


        if(!empty($data['jour16'])){
        
            $Listesappelsjours->jour16 = $data['jour16'];
        
        }

        }

    







    

        if(array_key_exists("jour17",$data)){


        if(!empty($data['jour17'])){
        
            $Listesappelsjours->jour17 = $data['jour17'];
        
        }

        }

    







    

        if(array_key_exists("jour18",$data)){


        if(!empty($data['jour18'])){
        
            $Listesappelsjours->jour18 = $data['jour18'];
        
        }

        }

    







    

        if(array_key_exists("jour19",$data)){


        if(!empty($data['jour19'])){
        
            $Listesappelsjours->jour19 = $data['jour19'];
        
        }

        }

    







    

        if(array_key_exists("jour20",$data)){


        if(!empty($data['jour20'])){
        
            $Listesappelsjours->jour20 = $data['jour20'];
        
        }

        }

    







    

        if(array_key_exists("jour21",$data)){


        if(!empty($data['jour21'])){
        
            $Listesappelsjours->jour21 = $data['jour21'];
        
        }

        }

    







    

        if(array_key_exists("jour22",$data)){


        if(!empty($data['jour22'])){
        
            $Listesappelsjours->jour22 = $data['jour22'];
        
        }

        }

    







    

        if(array_key_exists("jour23",$data)){


        if(!empty($data['jour23'])){
        
            $Listesappelsjours->jour23 = $data['jour23'];
        
        }

        }

    







    

        if(array_key_exists("jour24",$data)){


        if(!empty($data['jour24'])){
        
            $Listesappelsjours->jour24 = $data['jour24'];
        
        }

        }

    







    

        if(array_key_exists("jour25",$data)){


        if(!empty($data['jour25'])){
        
            $Listesappelsjours->jour25 = $data['jour25'];
        
        }

        }

    







    

        if(array_key_exists("jour26",$data)){


        if(!empty($data['jour26'])){
        
            $Listesappelsjours->jour26 = $data['jour26'];
        
        }

        }

    







    

        if(array_key_exists("jour27",$data)){


        if(!empty($data['jour27'])){
        
            $Listesappelsjours->jour27 = $data['jour27'];
        
        }

        }

    







    

        if(array_key_exists("jour28",$data)){


        if(!empty($data['jour28'])){
        
            $Listesappelsjours->jour28 = $data['jour28'];
        
        }

        }

    







    

        if(array_key_exists("jour29",$data)){


        if(!empty($data['jour29'])){
        
            $Listesappelsjours->jour29 = $data['jour29'];
        
        }

        }

    







    

        if(array_key_exists("jour30",$data)){


        if(!empty($data['jour30'])){
        
            $Listesappelsjours->jour30 = $data['jour30'];
        
        }

        }

    







    

        if(array_key_exists("jour31",$data)){


        if(!empty($data['jour31'])){
        
            $Listesappelsjours->jour31 = $data['jour31'];
        
        }

        }

    







    

        if(array_key_exists("tache01",$data)){


        if(!empty($data['tache01'])){
        
            $Listesappelsjours->tache01 = $data['tache01'];
        
        }

        }

    







    

        if(array_key_exists("tache02",$data)){


        if(!empty($data['tache02'])){
        
            $Listesappelsjours->tache02 = $data['tache02'];
        
        }

        }

    







    

        if(array_key_exists("tache03",$data)){


        if(!empty($data['tache03'])){
        
            $Listesappelsjours->tache03 = $data['tache03'];
        
        }

        }

    







    

        if(array_key_exists("tache04",$data)){


        if(!empty($data['tache04'])){
        
            $Listesappelsjours->tache04 = $data['tache04'];
        
        }

        }

    







    

        if(array_key_exists("tache05",$data)){


        if(!empty($data['tache05'])){
        
            $Listesappelsjours->tache05 = $data['tache05'];
        
        }

        }

    







    

        if(array_key_exists("tache06",$data)){


        if(!empty($data['tache06'])){
        
            $Listesappelsjours->tache06 = $data['tache06'];
        
        }

        }

    







    

        if(array_key_exists("tache07",$data)){


        if(!empty($data['tache07'])){
        
            $Listesappelsjours->tache07 = $data['tache07'];
        
        }

        }

    







    

        if(array_key_exists("tache08",$data)){


        if(!empty($data['tache08'])){
        
            $Listesappelsjours->tache08 = $data['tache08'];
        
        }

        }

    







    

        if(array_key_exists("tache09",$data)){


        if(!empty($data['tache09'])){
        
            $Listesappelsjours->tache09 = $data['tache09'];
        
        }

        }

    







    

        if(array_key_exists("tache10",$data)){


        if(!empty($data['tache10'])){
        
            $Listesappelsjours->tache10 = $data['tache10'];
        
        }

        }

    







    

        if(array_key_exists("tache11",$data)){


        if(!empty($data['tache11'])){
        
            $Listesappelsjours->tache11 = $data['tache11'];
        
        }

        }

    







    

        if(array_key_exists("tache12",$data)){


        if(!empty($data['tache12'])){
        
            $Listesappelsjours->tache12 = $data['tache12'];
        
        }

        }

    







    

        if(array_key_exists("tache13",$data)){


        if(!empty($data['tache13'])){
        
            $Listesappelsjours->tache13 = $data['tache13'];
        
        }

        }

    







    

        if(array_key_exists("tache14",$data)){


        if(!empty($data['tache14'])){
        
            $Listesappelsjours->tache14 = $data['tache14'];
        
        }

        }

    







    

        if(array_key_exists("tache15",$data)){


        if(!empty($data['tache15'])){
        
            $Listesappelsjours->tache15 = $data['tache15'];
        
        }

        }

    







    

        if(array_key_exists("tache16",$data)){


        if(!empty($data['tache16'])){
        
            $Listesappelsjours->tache16 = $data['tache16'];
        
        }

        }

    







    

        if(array_key_exists("tache17",$data)){


        if(!empty($data['tache17'])){
        
            $Listesappelsjours->tache17 = $data['tache17'];
        
        }

        }

    







    

        if(array_key_exists("tache18",$data)){


        if(!empty($data['tache18'])){
        
            $Listesappelsjours->tache18 = $data['tache18'];
        
        }

        }

    







    

        if(array_key_exists("tache19",$data)){


        if(!empty($data['tache19'])){
        
            $Listesappelsjours->tache19 = $data['tache19'];
        
        }

        }

    







    

        if(array_key_exists("tache20",$data)){


        if(!empty($data['tache20'])){
        
            $Listesappelsjours->tache20 = $data['tache20'];
        
        }

        }

    







    

        if(array_key_exists("tache21",$data)){


        if(!empty($data['tache21'])){
        
            $Listesappelsjours->tache21 = $data['tache21'];
        
        }

        }

    







    

        if(array_key_exists("tache22",$data)){


        if(!empty($data['tache22'])){
        
            $Listesappelsjours->tache22 = $data['tache22'];
        
        }

        }

    







    

        if(array_key_exists("tache23",$data)){


        if(!empty($data['tache23'])){
        
            $Listesappelsjours->tache23 = $data['tache23'];
        
        }

        }

    







    

        if(array_key_exists("tache24",$data)){


        if(!empty($data['tache24'])){
        
            $Listesappelsjours->tache24 = $data['tache24'];
        
        }

        }

    







    

        if(array_key_exists("tache25",$data)){


        if(!empty($data['tache25'])){
        
            $Listesappelsjours->tache25 = $data['tache25'];
        
        }

        }

    







    

        if(array_key_exists("tache26",$data)){


        if(!empty($data['tache26'])){
        
            $Listesappelsjours->tache26 = $data['tache26'];
        
        }

        }

    







    

        if(array_key_exists("tache27",$data)){


        if(!empty($data['tache27'])){
        
            $Listesappelsjours->tache27 = $data['tache27'];
        
        }

        }

    







    

        if(array_key_exists("tache28",$data)){


        if(!empty($data['tache28'])){
        
            $Listesappelsjours->tache28 = $data['tache28'];
        
        }

        }

    







    

        if(array_key_exists("tache29",$data)){


        if(!empty($data['tache29'])){
        
            $Listesappelsjours->tache29 = $data['tache29'];
        
        }

        }

    







    

        if(array_key_exists("tache30",$data)){


        if(!empty($data['tache30'])){
        
            $Listesappelsjours->tache30 = $data['tache30'];
        
        }

        }

    







    

        if(array_key_exists("tache31",$data)){


        if(!empty($data['tache31'])){
        
            $Listesappelsjours->tache31 = $data['tache31'];
        
        }

        }

    







    

        if(array_key_exists("listesappel_id",$data)){


        if(!empty($data['listesappel_id'])){
        
            $Listesappelsjours->listesappel_id = $data['listesappel_id'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Listesappelsjours->user_id = $data['user_id'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Listesappelsjours->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Listesappelsjours->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Listesappelsjours->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ListesappelsjourExtras') &&
method_exists('\App\Http\Extras\ListesappelsjourExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ListesappelsjourExtras::beforeSaveUpdate($request,$Listesappelsjours);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ListesappelsjourExtras') &&
method_exists('\App\Http\Extras\ListesappelsjourExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ListesappelsjourExtras::canUpdate($request, $Listesappelsjours);
}catch (\Throwable $e){

}

}


if($canSave){
$Listesappelsjours->save();
}else{
return response()->json($Listesappelsjours, 200);

}


$Listesappelsjours=Listesappelsjour::find($Listesappelsjours->id);



$newCrudData=[];

                $newCrudData['rand']=$Listesappelsjours->rand;
                $newCrudData['jour01']=$Listesappelsjours->jour01;
                $newCrudData['jour02']=$Listesappelsjours->jour02;
                $newCrudData['jour03']=$Listesappelsjours->jour03;
                $newCrudData['jour04']=$Listesappelsjours->jour04;
                $newCrudData['jour05']=$Listesappelsjours->jour05;
                $newCrudData['jour06']=$Listesappelsjours->jour06;
                $newCrudData['jour07']=$Listesappelsjours->jour07;
                $newCrudData['jour08']=$Listesappelsjours->jour08;
                $newCrudData['jour09']=$Listesappelsjours->jour09;
                $newCrudData['jour10']=$Listesappelsjours->jour10;
                $newCrudData['jour11']=$Listesappelsjours->jour11;
                $newCrudData['jour12']=$Listesappelsjours->jour12;
                $newCrudData['jour13']=$Listesappelsjours->jour13;
                $newCrudData['jour14']=$Listesappelsjours->jour14;
                $newCrudData['jour15']=$Listesappelsjours->jour15;
                $newCrudData['jour16']=$Listesappelsjours->jour16;
                $newCrudData['jour17']=$Listesappelsjours->jour17;
                $newCrudData['jour18']=$Listesappelsjours->jour18;
                $newCrudData['jour19']=$Listesappelsjours->jour19;
                $newCrudData['jour20']=$Listesappelsjours->jour20;
                $newCrudData['jour21']=$Listesappelsjours->jour21;
                $newCrudData['jour22']=$Listesappelsjours->jour22;
                $newCrudData['jour23']=$Listesappelsjours->jour23;
                $newCrudData['jour24']=$Listesappelsjours->jour24;
                $newCrudData['jour25']=$Listesappelsjours->jour25;
                $newCrudData['jour26']=$Listesappelsjours->jour26;
                $newCrudData['jour27']=$Listesappelsjours->jour27;
                $newCrudData['jour28']=$Listesappelsjours->jour28;
                $newCrudData['jour29']=$Listesappelsjours->jour29;
                $newCrudData['jour30']=$Listesappelsjours->jour30;
                $newCrudData['jour31']=$Listesappelsjours->jour31;
                $newCrudData['tache01']=$Listesappelsjours->tache01;
                $newCrudData['tache02']=$Listesappelsjours->tache02;
                $newCrudData['tache03']=$Listesappelsjours->tache03;
                $newCrudData['tache04']=$Listesappelsjours->tache04;
                $newCrudData['tache05']=$Listesappelsjours->tache05;
                $newCrudData['tache06']=$Listesappelsjours->tache06;
                $newCrudData['tache07']=$Listesappelsjours->tache07;
                $newCrudData['tache08']=$Listesappelsjours->tache08;
                $newCrudData['tache09']=$Listesappelsjours->tache09;
                $newCrudData['tache10']=$Listesappelsjours->tache10;
                $newCrudData['tache11']=$Listesappelsjours->tache11;
                $newCrudData['tache12']=$Listesappelsjours->tache12;
                $newCrudData['tache13']=$Listesappelsjours->tache13;
                $newCrudData['tache14']=$Listesappelsjours->tache14;
                $newCrudData['tache15']=$Listesappelsjours->tache15;
                $newCrudData['tache16']=$Listesappelsjours->tache16;
                $newCrudData['tache17']=$Listesappelsjours->tache17;
                $newCrudData['tache18']=$Listesappelsjours->tache18;
                $newCrudData['tache19']=$Listesappelsjours->tache19;
                $newCrudData['tache20']=$Listesappelsjours->tache20;
                $newCrudData['tache21']=$Listesappelsjours->tache21;
                $newCrudData['tache22']=$Listesappelsjours->tache22;
                $newCrudData['tache23']=$Listesappelsjours->tache23;
                $newCrudData['tache24']=$Listesappelsjours->tache24;
                $newCrudData['tache25']=$Listesappelsjours->tache25;
                $newCrudData['tache26']=$Listesappelsjours->tache26;
                $newCrudData['tache27']=$Listesappelsjours->tache27;
                $newCrudData['tache28']=$Listesappelsjours->tache28;
                $newCrudData['tache29']=$Listesappelsjours->tache29;
                $newCrudData['tache30']=$Listesappelsjours->tache30;
                $newCrudData['tache31']=$Listesappelsjours->tache31;
                $newCrudData['listesappel_id']=$Listesappelsjours->listesappel_id;
                $newCrudData['user_id']=$Listesappelsjours->user_id;
                                $newCrudData['identifiants_sadge']=$Listesappelsjours->identifiants_sadge;
                $newCrudData['creat_by']=$Listesappelsjours->creat_by;
    
 try{ $newCrudData['listesappel']=$Listesappelsjours->listesappel->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Listesappelsjours->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Listesappelsjours','entite_cle' => $Listesappelsjours->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Listesappelsjours->toArray();




try{

foreach ($Listesappelsjours->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Listesappelsjour $Listesappelsjours)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des listesappelsjours');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['rand']=$Listesappelsjours->rand;
                $newCrudData['jour01']=$Listesappelsjours->jour01;
                $newCrudData['jour02']=$Listesappelsjours->jour02;
                $newCrudData['jour03']=$Listesappelsjours->jour03;
                $newCrudData['jour04']=$Listesappelsjours->jour04;
                $newCrudData['jour05']=$Listesappelsjours->jour05;
                $newCrudData['jour06']=$Listesappelsjours->jour06;
                $newCrudData['jour07']=$Listesappelsjours->jour07;
                $newCrudData['jour08']=$Listesappelsjours->jour08;
                $newCrudData['jour09']=$Listesappelsjours->jour09;
                $newCrudData['jour10']=$Listesappelsjours->jour10;
                $newCrudData['jour11']=$Listesappelsjours->jour11;
                $newCrudData['jour12']=$Listesappelsjours->jour12;
                $newCrudData['jour13']=$Listesappelsjours->jour13;
                $newCrudData['jour14']=$Listesappelsjours->jour14;
                $newCrudData['jour15']=$Listesappelsjours->jour15;
                $newCrudData['jour16']=$Listesappelsjours->jour16;
                $newCrudData['jour17']=$Listesappelsjours->jour17;
                $newCrudData['jour18']=$Listesappelsjours->jour18;
                $newCrudData['jour19']=$Listesappelsjours->jour19;
                $newCrudData['jour20']=$Listesappelsjours->jour20;
                $newCrudData['jour21']=$Listesappelsjours->jour21;
                $newCrudData['jour22']=$Listesappelsjours->jour22;
                $newCrudData['jour23']=$Listesappelsjours->jour23;
                $newCrudData['jour24']=$Listesappelsjours->jour24;
                $newCrudData['jour25']=$Listesappelsjours->jour25;
                $newCrudData['jour26']=$Listesappelsjours->jour26;
                $newCrudData['jour27']=$Listesappelsjours->jour27;
                $newCrudData['jour28']=$Listesappelsjours->jour28;
                $newCrudData['jour29']=$Listesappelsjours->jour29;
                $newCrudData['jour30']=$Listesappelsjours->jour30;
                $newCrudData['jour31']=$Listesappelsjours->jour31;
                $newCrudData['tache01']=$Listesappelsjours->tache01;
                $newCrudData['tache02']=$Listesappelsjours->tache02;
                $newCrudData['tache03']=$Listesappelsjours->tache03;
                $newCrudData['tache04']=$Listesappelsjours->tache04;
                $newCrudData['tache05']=$Listesappelsjours->tache05;
                $newCrudData['tache06']=$Listesappelsjours->tache06;
                $newCrudData['tache07']=$Listesappelsjours->tache07;
                $newCrudData['tache08']=$Listesappelsjours->tache08;
                $newCrudData['tache09']=$Listesappelsjours->tache09;
                $newCrudData['tache10']=$Listesappelsjours->tache10;
                $newCrudData['tache11']=$Listesappelsjours->tache11;
                $newCrudData['tache12']=$Listesappelsjours->tache12;
                $newCrudData['tache13']=$Listesappelsjours->tache13;
                $newCrudData['tache14']=$Listesappelsjours->tache14;
                $newCrudData['tache15']=$Listesappelsjours->tache15;
                $newCrudData['tache16']=$Listesappelsjours->tache16;
                $newCrudData['tache17']=$Listesappelsjours->tache17;
                $newCrudData['tache18']=$Listesappelsjours->tache18;
                $newCrudData['tache19']=$Listesappelsjours->tache19;
                $newCrudData['tache20']=$Listesappelsjours->tache20;
                $newCrudData['tache21']=$Listesappelsjours->tache21;
                $newCrudData['tache22']=$Listesappelsjours->tache22;
                $newCrudData['tache23']=$Listesappelsjours->tache23;
                $newCrudData['tache24']=$Listesappelsjours->tache24;
                $newCrudData['tache25']=$Listesappelsjours->tache25;
                $newCrudData['tache26']=$Listesappelsjours->tache26;
                $newCrudData['tache27']=$Listesappelsjours->tache27;
                $newCrudData['tache28']=$Listesappelsjours->tache28;
                $newCrudData['tache29']=$Listesappelsjours->tache29;
                $newCrudData['tache30']=$Listesappelsjours->tache30;
                $newCrudData['tache31']=$Listesappelsjours->tache31;
                $newCrudData['listesappel_id']=$Listesappelsjours->listesappel_id;
                $newCrudData['user_id']=$Listesappelsjours->user_id;
                                $newCrudData['identifiants_sadge']=$Listesappelsjours->identifiants_sadge;
                $newCrudData['creat_by']=$Listesappelsjours->creat_by;
    
 try{ $newCrudData['listesappel']=$Listesappelsjours->listesappel->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Listesappelsjours->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Listesappelsjours','entite_cle' => $Listesappelsjours->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ListesappelsjourExtras') &&
method_exists('\App\Http\Extras\ListesappelsjourExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ListesappelsjourExtras::canDelete($request, $Listesappelsjours);
}catch (\Throwable $e){

}

}



if($canSave){
$Listesappelsjours->delete();
}else{
return response()->json($Listesappelsjours, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ListesappelsjoursActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
