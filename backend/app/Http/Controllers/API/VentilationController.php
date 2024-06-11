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
// use App\Repository\prod\VentilationsRepository;
use App\Models\Ventilation;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Programmation;
        
class VentilationController extends Controller
{

private $VentilationsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\VentilationsRepository $VentilationsRepository
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
class_exists('\App\Http\Extras\VentilationExtras') &&
method_exists('\App\Http\Extras\VentilationExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\VentilationExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Ventilation::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\VentilationExtras') &&
method_exists('\App\Http\Extras\VentilationExtras', 'filterAgGridQuery')
){
\App\Http\Extras\VentilationExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('ventilations',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\VentilationExtras') &&
method_exists('\App\Http\Extras\VentilationExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\VentilationExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  ventilations reussi',
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
return response()->json(Ventilation::count());
}
$data = QueryBuilder::for(Ventilation::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('semaine'),

    
            AllowedFilter::exact('dimanche_date'),

    
            AllowedFilter::exact('lundi_date'),

    
            AllowedFilter::exact('mardi_date'),

    
            AllowedFilter::exact('mercredi_date'),

    
            AllowedFilter::exact('jeudi_date'),

    
            AllowedFilter::exact('vendredi_date'),

    
            AllowedFilter::exact('samedi_date'),

    
            AllowedFilter::exact('dimanche_horaire'),

    
            AllowedFilter::exact('lundi_horaire'),

    
            AllowedFilter::exact('mardi_horaire'),

    
            AllowedFilter::exact('mercredi_horaire'),

    
            AllowedFilter::exact('jeudi_horaire'),

    
            AllowedFilter::exact('vendredi_horaire'),

    
            AllowedFilter::exact('samedi_horaire'),

    
            AllowedFilter::exact('dimanche'),

    
            AllowedFilter::exact('lundi'),

    
            AllowedFilter::exact('mardi'),

    
            AllowedFilter::exact('mercredi'),

    
            AllowedFilter::exact('jeudi'),

    
            AllowedFilter::exact('vendredi'),

    
            AllowedFilter::exact('samedi'),

    
            AllowedFilter::exact('dimanche_pointage'),

    
            AllowedFilter::exact('lundi_pointage'),

    
            AllowedFilter::exact('mardi_pointage'),

    
            AllowedFilter::exact('mercredi_pointage'),

    
            AllowedFilter::exact('jeudi_pointage'),

    
            AllowedFilter::exact('vendredi_pointage'),

    
            AllowedFilter::exact('samedi_pointage'),

    
            AllowedFilter::exact('dimanche_collecter'),

    
            AllowedFilter::exact('lundi_collecter'),

    
            AllowedFilter::exact('mardi_collecter'),

    
            AllowedFilter::exact('mercredi_collecter'),

    
            AllowedFilter::exact('jeudi_collecter'),

    
            AllowedFilter::exact('vendredi_collecter'),

    
            AllowedFilter::exact('samedi_collecter'),

    
            AllowedFilter::exact('dimanche_depassement'),

    
            AllowedFilter::exact('lundi_depassement'),

    
            AllowedFilter::exact('mardi_depassement'),

    
            AllowedFilter::exact('mercredi_depassement'),

    
            AllowedFilter::exact('jeudi_depassement'),

    
            AllowedFilter::exact('vendredi_depassement'),

    
            AllowedFilter::exact('samedi_depassement'),

    
            AllowedFilter::exact('dimanche_programmer'),

    
            AllowedFilter::exact('lundi_programmer'),

    
            AllowedFilter::exact('mardi_programmer'),

    
            AllowedFilter::exact('mercredi_programmer'),

    
            AllowedFilter::exact('jeudi_programmer'),

    
            AllowedFilter::exact('vendredi_programmer'),

    
            AllowedFilter::exact('samedi_programmer'),

    
            AllowedFilter::exact('dimanche_retard'),

    
            AllowedFilter::exact('lundi_retard'),

    
            AllowedFilter::exact('mardi_retard'),

    
            AllowedFilter::exact('mercredi_retard'),

    
            AllowedFilter::exact('jeudi_retard'),

    
            AllowedFilter::exact('vendredi_retard'),

    
            AllowedFilter::exact('samedi_retard'),

    
            AllowedFilter::exact('programmation_id'),

    
            AllowedFilter::exact('total_programmer'),

    
            AllowedFilter::exact('total_colecter'),

    
            AllowedFilter::exact('total_depassement'),

    
            AllowedFilter::exact('hs15'),

    
            AllowedFilter::exact('hs26'),

    
            AllowedFilter::exact('hs55'),

    
            AllowedFilter::exact('hs30'),

    
            AllowedFilter::exact('hs60'),

    
            AllowedFilter::exact('hs115'),

    
            AllowedFilter::exact('hs130'),

    
            AllowedFilter::exact('total'),

    
    
    
    
    
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

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('semaine'),

    
            AllowedSort::field('dimanche_date'),

    
            AllowedSort::field('lundi_date'),

    
            AllowedSort::field('mardi_date'),

    
            AllowedSort::field('mercredi_date'),

    
            AllowedSort::field('jeudi_date'),

    
            AllowedSort::field('vendredi_date'),

    
            AllowedSort::field('samedi_date'),

    
            AllowedSort::field('dimanche_horaire'),

    
            AllowedSort::field('lundi_horaire'),

    
            AllowedSort::field('mardi_horaire'),

    
            AllowedSort::field('mercredi_horaire'),

    
            AllowedSort::field('jeudi_horaire'),

    
            AllowedSort::field('vendredi_horaire'),

    
            AllowedSort::field('samedi_horaire'),

    
            AllowedSort::field('dimanche'),

    
            AllowedSort::field('lundi'),

    
            AllowedSort::field('mardi'),

    
            AllowedSort::field('mercredi'),

    
            AllowedSort::field('jeudi'),

    
            AllowedSort::field('vendredi'),

    
            AllowedSort::field('samedi'),

    
            AllowedSort::field('dimanche_pointage'),

    
            AllowedSort::field('lundi_pointage'),

    
            AllowedSort::field('mardi_pointage'),

    
            AllowedSort::field('mercredi_pointage'),

    
            AllowedSort::field('jeudi_pointage'),

    
            AllowedSort::field('vendredi_pointage'),

    
            AllowedSort::field('samedi_pointage'),

    
            AllowedSort::field('dimanche_collecter'),

    
            AllowedSort::field('lundi_collecter'),

    
            AllowedSort::field('mardi_collecter'),

    
            AllowedSort::field('mercredi_collecter'),

    
            AllowedSort::field('jeudi_collecter'),

    
            AllowedSort::field('vendredi_collecter'),

    
            AllowedSort::field('samedi_collecter'),

    
            AllowedSort::field('dimanche_depassement'),

    
            AllowedSort::field('lundi_depassement'),

    
            AllowedSort::field('mardi_depassement'),

    
            AllowedSort::field('mercredi_depassement'),

    
            AllowedSort::field('jeudi_depassement'),

    
            AllowedSort::field('vendredi_depassement'),

    
            AllowedSort::field('samedi_depassement'),

    
            AllowedSort::field('dimanche_programmer'),

    
            AllowedSort::field('lundi_programmer'),

    
            AllowedSort::field('mardi_programmer'),

    
            AllowedSort::field('mercredi_programmer'),

    
            AllowedSort::field('jeudi_programmer'),

    
            AllowedSort::field('vendredi_programmer'),

    
            AllowedSort::field('samedi_programmer'),

    
            AllowedSort::field('dimanche_retard'),

    
            AllowedSort::field('lundi_retard'),

    
            AllowedSort::field('mardi_retard'),

    
            AllowedSort::field('mercredi_retard'),

    
            AllowedSort::field('jeudi_retard'),

    
            AllowedSort::field('vendredi_retard'),

    
            AllowedSort::field('samedi_retard'),

    
            AllowedSort::field('programmation_id'),

    
            AllowedSort::field('total_programmer'),

    
            AllowedSort::field('total_colecter'),

    
            AllowedSort::field('total_depassement'),

    
            AllowedSort::field('hs15'),

    
            AllowedSort::field('hs26'),

    
            AllowedSort::field('hs55'),

    
            AllowedSort::field('hs30'),

    
            AllowedSort::field('hs60'),

    
            AllowedSort::field('hs115'),

    
            AllowedSort::field('hs130'),

    
            AllowedSort::field('total'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([

            'programmation',
        

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




$data = QueryBuilder::for(Ventilation::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('semaine'),

    
            AllowedFilter::exact('dimanche_date'),

    
            AllowedFilter::exact('lundi_date'),

    
            AllowedFilter::exact('mardi_date'),

    
            AllowedFilter::exact('mercredi_date'),

    
            AllowedFilter::exact('jeudi_date'),

    
            AllowedFilter::exact('vendredi_date'),

    
            AllowedFilter::exact('samedi_date'),

    
            AllowedFilter::exact('dimanche_horaire'),

    
            AllowedFilter::exact('lundi_horaire'),

    
            AllowedFilter::exact('mardi_horaire'),

    
            AllowedFilter::exact('mercredi_horaire'),

    
            AllowedFilter::exact('jeudi_horaire'),

    
            AllowedFilter::exact('vendredi_horaire'),

    
            AllowedFilter::exact('samedi_horaire'),

    
            AllowedFilter::exact('dimanche'),

    
            AllowedFilter::exact('lundi'),

    
            AllowedFilter::exact('mardi'),

    
            AllowedFilter::exact('mercredi'),

    
            AllowedFilter::exact('jeudi'),

    
            AllowedFilter::exact('vendredi'),

    
            AllowedFilter::exact('samedi'),

    
            AllowedFilter::exact('dimanche_pointage'),

    
            AllowedFilter::exact('lundi_pointage'),

    
            AllowedFilter::exact('mardi_pointage'),

    
            AllowedFilter::exact('mercredi_pointage'),

    
            AllowedFilter::exact('jeudi_pointage'),

    
            AllowedFilter::exact('vendredi_pointage'),

    
            AllowedFilter::exact('samedi_pointage'),

    
            AllowedFilter::exact('dimanche_collecter'),

    
            AllowedFilter::exact('lundi_collecter'),

    
            AllowedFilter::exact('mardi_collecter'),

    
            AllowedFilter::exact('mercredi_collecter'),

    
            AllowedFilter::exact('jeudi_collecter'),

    
            AllowedFilter::exact('vendredi_collecter'),

    
            AllowedFilter::exact('samedi_collecter'),

    
            AllowedFilter::exact('dimanche_depassement'),

    
            AllowedFilter::exact('lundi_depassement'),

    
            AllowedFilter::exact('mardi_depassement'),

    
            AllowedFilter::exact('mercredi_depassement'),

    
            AllowedFilter::exact('jeudi_depassement'),

    
            AllowedFilter::exact('vendredi_depassement'),

    
            AllowedFilter::exact('samedi_depassement'),

    
            AllowedFilter::exact('dimanche_programmer'),

    
            AllowedFilter::exact('lundi_programmer'),

    
            AllowedFilter::exact('mardi_programmer'),

    
            AllowedFilter::exact('mercredi_programmer'),

    
            AllowedFilter::exact('jeudi_programmer'),

    
            AllowedFilter::exact('vendredi_programmer'),

    
            AllowedFilter::exact('samedi_programmer'),

    
            AllowedFilter::exact('dimanche_retard'),

    
            AllowedFilter::exact('lundi_retard'),

    
            AllowedFilter::exact('mardi_retard'),

    
            AllowedFilter::exact('mercredi_retard'),

    
            AllowedFilter::exact('jeudi_retard'),

    
            AllowedFilter::exact('vendredi_retard'),

    
            AllowedFilter::exact('samedi_retard'),

    
            AllowedFilter::exact('programmation_id'),

    
            AllowedFilter::exact('total_programmer'),

    
            AllowedFilter::exact('total_colecter'),

    
            AllowedFilter::exact('total_depassement'),

    
            AllowedFilter::exact('hs15'),

    
            AllowedFilter::exact('hs26'),

    
            AllowedFilter::exact('hs55'),

    
            AllowedFilter::exact('hs30'),

    
            AllowedFilter::exact('hs60'),

    
            AllowedFilter::exact('hs115'),

    
            AllowedFilter::exact('hs130'),

    
            AllowedFilter::exact('total'),

    
    
    
    
    
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

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('semaine'),

    
            AllowedSort::field('dimanche_date'),

    
            AllowedSort::field('lundi_date'),

    
            AllowedSort::field('mardi_date'),

    
            AllowedSort::field('mercredi_date'),

    
            AllowedSort::field('jeudi_date'),

    
            AllowedSort::field('vendredi_date'),

    
            AllowedSort::field('samedi_date'),

    
            AllowedSort::field('dimanche_horaire'),

    
            AllowedSort::field('lundi_horaire'),

    
            AllowedSort::field('mardi_horaire'),

    
            AllowedSort::field('mercredi_horaire'),

    
            AllowedSort::field('jeudi_horaire'),

    
            AllowedSort::field('vendredi_horaire'),

    
            AllowedSort::field('samedi_horaire'),

    
            AllowedSort::field('dimanche'),

    
            AllowedSort::field('lundi'),

    
            AllowedSort::field('mardi'),

    
            AllowedSort::field('mercredi'),

    
            AllowedSort::field('jeudi'),

    
            AllowedSort::field('vendredi'),

    
            AllowedSort::field('samedi'),

    
            AllowedSort::field('dimanche_pointage'),

    
            AllowedSort::field('lundi_pointage'),

    
            AllowedSort::field('mardi_pointage'),

    
            AllowedSort::field('mercredi_pointage'),

    
            AllowedSort::field('jeudi_pointage'),

    
            AllowedSort::field('vendredi_pointage'),

    
            AllowedSort::field('samedi_pointage'),

    
            AllowedSort::field('dimanche_collecter'),

    
            AllowedSort::field('lundi_collecter'),

    
            AllowedSort::field('mardi_collecter'),

    
            AllowedSort::field('mercredi_collecter'),

    
            AllowedSort::field('jeudi_collecter'),

    
            AllowedSort::field('vendredi_collecter'),

    
            AllowedSort::field('samedi_collecter'),

    
            AllowedSort::field('dimanche_depassement'),

    
            AllowedSort::field('lundi_depassement'),

    
            AllowedSort::field('mardi_depassement'),

    
            AllowedSort::field('mercredi_depassement'),

    
            AllowedSort::field('jeudi_depassement'),

    
            AllowedSort::field('vendredi_depassement'),

    
            AllowedSort::field('samedi_depassement'),

    
            AllowedSort::field('dimanche_programmer'),

    
            AllowedSort::field('lundi_programmer'),

    
            AllowedSort::field('mardi_programmer'),

    
            AllowedSort::field('mercredi_programmer'),

    
            AllowedSort::field('jeudi_programmer'),

    
            AllowedSort::field('vendredi_programmer'),

    
            AllowedSort::field('samedi_programmer'),

    
            AllowedSort::field('dimanche_retard'),

    
            AllowedSort::field('lundi_retard'),

    
            AllowedSort::field('mardi_retard'),

    
            AllowedSort::field('mercredi_retard'),

    
            AllowedSort::field('jeudi_retard'),

    
            AllowedSort::field('vendredi_retard'),

    
            AllowedSort::field('samedi_retard'),

    
            AllowedSort::field('programmation_id'),

    
            AllowedSort::field('total_programmer'),

    
            AllowedSort::field('total_colecter'),

    
            AllowedSort::field('total_depassement'),

    
            AllowedSort::field('hs15'),

    
            AllowedSort::field('hs26'),

    
            AllowedSort::field('hs55'),

    
            AllowedSort::field('hs30'),

    
            AllowedSort::field('hs60'),

    
            AllowedSort::field('hs115'),

    
            AllowedSort::field('hs130'),

    
            AllowedSort::field('total'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'programmation',
        

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



public function create(Request $request, Ventilation $Ventilations)
{


try{
$can=\App\Helpers\Helpers::can('Creer des ventilations');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "ventilations"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'semaine',
    'dimanche_date',
    'lundi_date',
    'mardi_date',
    'mercredi_date',
    'jeudi_date',
    'vendredi_date',
    'samedi_date',
    'dimanche_horaire',
    'lundi_horaire',
    'mardi_horaire',
    'mercredi_horaire',
    'jeudi_horaire',
    'vendredi_horaire',
    'samedi_horaire',
    'dimanche',
    'lundi',
    'mardi',
    'mercredi',
    'jeudi',
    'vendredi',
    'samedi',
    'dimanche_pointage',
    'lundi_pointage',
    'mardi_pointage',
    'mercredi_pointage',
    'jeudi_pointage',
    'vendredi_pointage',
    'samedi_pointage',
    'dimanche_collecter',
    'lundi_collecter',
    'mardi_collecter',
    'mercredi_collecter',
    'jeudi_collecter',
    'vendredi_collecter',
    'samedi_collecter',
    'dimanche_depassement',
    'lundi_depassement',
    'mardi_depassement',
    'mercredi_depassement',
    'jeudi_depassement',
    'vendredi_depassement',
    'samedi_depassement',
    'dimanche_programmer',
    'lundi_programmer',
    'mardi_programmer',
    'mercredi_programmer',
    'jeudi_programmer',
    'vendredi_programmer',
    'samedi_programmer',
    'dimanche_retard',
    'lundi_retard',
    'mardi_retard',
    'mercredi_retard',
    'jeudi_retard',
    'vendredi_retard',
    'samedi_retard',
    'programmation_id',
    'total_programmer',
    'total_colecter',
    'total_depassement',
    'hs15',
    'hs26',
    'hs55',
    'hs30',
    'hs60',
    'hs115',
    'hs130',
    'total',
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
    
    
    
                    'semaine' => [
            //'required'
            ],
        
    
    
                    'dimanche_date' => [
            //'required'
            ],
        
    
    
                    'lundi_date' => [
            //'required'
            ],
        
    
    
                    'mardi_date' => [
            //'required'
            ],
        
    
    
                    'mercredi_date' => [
            //'required'
            ],
        
    
    
                    'jeudi_date' => [
            //'required'
            ],
        
    
    
                    'vendredi_date' => [
            //'required'
            ],
        
    
    
                    'samedi_date' => [
            //'required'
            ],
        
    
    
                    'dimanche_horaire' => [
            //'required'
            ],
        
    
    
                    'lundi_horaire' => [
            //'required'
            ],
        
    
    
                    'mardi_horaire' => [
            //'required'
            ],
        
    
    
                    'mercredi_horaire' => [
            //'required'
            ],
        
    
    
                    'jeudi_horaire' => [
            //'required'
            ],
        
    
    
                    'vendredi_horaire' => [
            //'required'
            ],
        
    
    
                    'samedi_horaire' => [
            //'required'
            ],
        
    
    
                    'dimanche' => [
            //'required'
            ],
        
    
    
                    'lundi' => [
            //'required'
            ],
        
    
    
                    'mardi' => [
            //'required'
            ],
        
    
    
                    'mercredi' => [
            //'required'
            ],
        
    
    
                    'jeudi' => [
            //'required'
            ],
        
    
    
                    'vendredi' => [
            //'required'
            ],
        
    
    
                    'samedi' => [
            //'required'
            ],
        
    
    
                    'dimanche_pointage' => [
            //'required'
            ],
        
    
    
                    'lundi_pointage' => [
            //'required'
            ],
        
    
    
                    'mardi_pointage' => [
            //'required'
            ],
        
    
    
                    'mercredi_pointage' => [
            //'required'
            ],
        
    
    
                    'jeudi_pointage' => [
            //'required'
            ],
        
    
    
                    'vendredi_pointage' => [
            //'required'
            ],
        
    
    
                    'samedi_pointage' => [
            //'required'
            ],
        
    
    
                    'dimanche_collecter' => [
            //'required'
            ],
        
    
    
                    'lundi_collecter' => [
            //'required'
            ],
        
    
    
                    'mardi_collecter' => [
            //'required'
            ],
        
    
    
                    'mercredi_collecter' => [
            //'required'
            ],
        
    
    
                    'jeudi_collecter' => [
            //'required'
            ],
        
    
    
                    'vendredi_collecter' => [
            //'required'
            ],
        
    
    
                    'samedi_collecter' => [
            //'required'
            ],
        
    
    
                    'dimanche_depassement' => [
            //'required'
            ],
        
    
    
                    'lundi_depassement' => [
            //'required'
            ],
        
    
    
                    'mardi_depassement' => [
            //'required'
            ],
        
    
    
                    'mercredi_depassement' => [
            //'required'
            ],
        
    
    
                    'jeudi_depassement' => [
            //'required'
            ],
        
    
    
                    'vendredi_depassement' => [
            //'required'
            ],
        
    
    
                    'samedi_depassement' => [
            //'required'
            ],
        
    
    
                    'dimanche_programmer' => [
            //'required'
            ],
        
    
    
                    'lundi_programmer' => [
            //'required'
            ],
        
    
    
                    'mardi_programmer' => [
            //'required'
            ],
        
    
    
                    'mercredi_programmer' => [
            //'required'
            ],
        
    
    
                    'jeudi_programmer' => [
            //'required'
            ],
        
    
    
                    'vendredi_programmer' => [
            //'required'
            ],
        
    
    
                    'samedi_programmer' => [
            //'required'
            ],
        
    
    
                    'dimanche_retard' => [
            //'required'
            ],
        
    
    
                    'lundi_retard' => [
            //'required'
            ],
        
    
    
                    'mardi_retard' => [
            //'required'
            ],
        
    
    
                    'mercredi_retard' => [
            //'required'
            ],
        
    
    
                    'jeudi_retard' => [
            //'required'
            ],
        
    
    
                    'vendredi_retard' => [
            //'required'
            ],
        
    
    
                    'samedi_retard' => [
            //'required'
            ],
        
    
    
                    'programmation_id' => [
            //'required'
            ],
        
    
    
                    'total_programmer' => [
            //'required'
            ],
        
    
    
                    'total_colecter' => [
            //'required'
            ],
        
    
    
                    'total_depassement' => [
            //'required'
            ],
        
    
    
                    'hs15' => [
            //'required'
            ],
        
    
    
                    'hs26' => [
            //'required'
            ],
        
    
    
                    'hs55' => [
            //'required'
            ],
        
    
    
                    'hs30' => [
            //'required'
            ],
        
    
    
                    'hs60' => [
            //'required'
            ],
        
    
    
                    'hs115' => [
            //'required'
            ],
        
    
    
                    'hs130' => [
            //'required'
            ],
        
    
    
                    'total' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
    
        'semaine' => ['cette donnee est obligatoire'],

    
    
        'dimanche_date' => ['cette donnee est obligatoire'],

    
    
        'lundi_date' => ['cette donnee est obligatoire'],

    
    
        'mardi_date' => ['cette donnee est obligatoire'],

    
    
        'mercredi_date' => ['cette donnee est obligatoire'],

    
    
        'jeudi_date' => ['cette donnee est obligatoire'],

    
    
        'vendredi_date' => ['cette donnee est obligatoire'],

    
    
        'samedi_date' => ['cette donnee est obligatoire'],

    
    
        'dimanche_horaire' => ['cette donnee est obligatoire'],

    
    
        'lundi_horaire' => ['cette donnee est obligatoire'],

    
    
        'mardi_horaire' => ['cette donnee est obligatoire'],

    
    
        'mercredi_horaire' => ['cette donnee est obligatoire'],

    
    
        'jeudi_horaire' => ['cette donnee est obligatoire'],

    
    
        'vendredi_horaire' => ['cette donnee est obligatoire'],

    
    
        'samedi_horaire' => ['cette donnee est obligatoire'],

    
    
        'dimanche' => ['cette donnee est obligatoire'],

    
    
        'lundi' => ['cette donnee est obligatoire'],

    
    
        'mardi' => ['cette donnee est obligatoire'],

    
    
        'mercredi' => ['cette donnee est obligatoire'],

    
    
        'jeudi' => ['cette donnee est obligatoire'],

    
    
        'vendredi' => ['cette donnee est obligatoire'],

    
    
        'samedi' => ['cette donnee est obligatoire'],

    
    
        'dimanche_pointage' => ['cette donnee est obligatoire'],

    
    
        'lundi_pointage' => ['cette donnee est obligatoire'],

    
    
        'mardi_pointage' => ['cette donnee est obligatoire'],

    
    
        'mercredi_pointage' => ['cette donnee est obligatoire'],

    
    
        'jeudi_pointage' => ['cette donnee est obligatoire'],

    
    
        'vendredi_pointage' => ['cette donnee est obligatoire'],

    
    
        'samedi_pointage' => ['cette donnee est obligatoire'],

    
    
        'dimanche_collecter' => ['cette donnee est obligatoire'],

    
    
        'lundi_collecter' => ['cette donnee est obligatoire'],

    
    
        'mardi_collecter' => ['cette donnee est obligatoire'],

    
    
        'mercredi_collecter' => ['cette donnee est obligatoire'],

    
    
        'jeudi_collecter' => ['cette donnee est obligatoire'],

    
    
        'vendredi_collecter' => ['cette donnee est obligatoire'],

    
    
        'samedi_collecter' => ['cette donnee est obligatoire'],

    
    
        'dimanche_depassement' => ['cette donnee est obligatoire'],

    
    
        'lundi_depassement' => ['cette donnee est obligatoire'],

    
    
        'mardi_depassement' => ['cette donnee est obligatoire'],

    
    
        'mercredi_depassement' => ['cette donnee est obligatoire'],

    
    
        'jeudi_depassement' => ['cette donnee est obligatoire'],

    
    
        'vendredi_depassement' => ['cette donnee est obligatoire'],

    
    
        'samedi_depassement' => ['cette donnee est obligatoire'],

    
    
        'dimanche_programmer' => ['cette donnee est obligatoire'],

    
    
        'lundi_programmer' => ['cette donnee est obligatoire'],

    
    
        'mardi_programmer' => ['cette donnee est obligatoire'],

    
    
        'mercredi_programmer' => ['cette donnee est obligatoire'],

    
    
        'jeudi_programmer' => ['cette donnee est obligatoire'],

    
    
        'vendredi_programmer' => ['cette donnee est obligatoire'],

    
    
        'samedi_programmer' => ['cette donnee est obligatoire'],

    
    
        'dimanche_retard' => ['cette donnee est obligatoire'],

    
    
        'lundi_retard' => ['cette donnee est obligatoire'],

    
    
        'mardi_retard' => ['cette donnee est obligatoire'],

    
    
        'mercredi_retard' => ['cette donnee est obligatoire'],

    
    
        'jeudi_retard' => ['cette donnee est obligatoire'],

    
    
        'vendredi_retard' => ['cette donnee est obligatoire'],

    
    
        'samedi_retard' => ['cette donnee est obligatoire'],

    
    
        'programmation_id' => ['cette donnee est obligatoire'],

    
    
        'total_programmer' => ['cette donnee est obligatoire'],

    
    
        'total_colecter' => ['cette donnee est obligatoire'],

    
    
        'total_depassement' => ['cette donnee est obligatoire'],

    
    
        'hs15' => ['cette donnee est obligatoire'],

    
    
        'hs26' => ['cette donnee est obligatoire'],

    
    
        'hs55' => ['cette donnee est obligatoire'],

    
    
        'hs30' => ['cette donnee est obligatoire'],

    
    
        'hs60' => ['cette donnee est obligatoire'],

    
    
        'hs115' => ['cette donnee est obligatoire'],

    
    
        'hs130' => ['cette donnee est obligatoire'],

    
    
        'total' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['user_id'])){
        
            $Ventilations->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['semaine'])){
        
            $Ventilations->semaine = $data['semaine'];
        
        }



    







    

        if(!empty($data['dimanche_date'])){
        
            $Ventilations->dimanche_date = $data['dimanche_date'];
        
        }



    







    

        if(!empty($data['lundi_date'])){
        
            $Ventilations->lundi_date = $data['lundi_date'];
        
        }



    







    

        if(!empty($data['mardi_date'])){
        
            $Ventilations->mardi_date = $data['mardi_date'];
        
        }



    







    

        if(!empty($data['mercredi_date'])){
        
            $Ventilations->mercredi_date = $data['mercredi_date'];
        
        }



    







    

        if(!empty($data['jeudi_date'])){
        
            $Ventilations->jeudi_date = $data['jeudi_date'];
        
        }



    







    

        if(!empty($data['vendredi_date'])){
        
            $Ventilations->vendredi_date = $data['vendredi_date'];
        
        }



    







    

        if(!empty($data['samedi_date'])){
        
            $Ventilations->samedi_date = $data['samedi_date'];
        
        }



    







    

        if(!empty($data['dimanche_horaire'])){
        
            $Ventilations->dimanche_horaire = $data['dimanche_horaire'];
        
        }



    







    

        if(!empty($data['lundi_horaire'])){
        
            $Ventilations->lundi_horaire = $data['lundi_horaire'];
        
        }



    







    

        if(!empty($data['mardi_horaire'])){
        
            $Ventilations->mardi_horaire = $data['mardi_horaire'];
        
        }



    







    

        if(!empty($data['mercredi_horaire'])){
        
            $Ventilations->mercredi_horaire = $data['mercredi_horaire'];
        
        }



    







    

        if(!empty($data['jeudi_horaire'])){
        
            $Ventilations->jeudi_horaire = $data['jeudi_horaire'];
        
        }



    







    

        if(!empty($data['vendredi_horaire'])){
        
            $Ventilations->vendredi_horaire = $data['vendredi_horaire'];
        
        }



    







    

        if(!empty($data['samedi_horaire'])){
        
            $Ventilations->samedi_horaire = $data['samedi_horaire'];
        
        }



    







    

        if(!empty($data['dimanche'])){
        
            $Ventilations->dimanche = $data['dimanche'];
        
        }



    







    

        if(!empty($data['lundi'])){
        
            $Ventilations->lundi = $data['lundi'];
        
        }



    







    

        if(!empty($data['mardi'])){
        
            $Ventilations->mardi = $data['mardi'];
        
        }



    







    

        if(!empty($data['mercredi'])){
        
            $Ventilations->mercredi = $data['mercredi'];
        
        }



    







    

        if(!empty($data['jeudi'])){
        
            $Ventilations->jeudi = $data['jeudi'];
        
        }



    







    

        if(!empty($data['vendredi'])){
        
            $Ventilations->vendredi = $data['vendredi'];
        
        }



    







    

        if(!empty($data['samedi'])){
        
            $Ventilations->samedi = $data['samedi'];
        
        }



    







    

        if(!empty($data['dimanche_pointage'])){
        
            $Ventilations->dimanche_pointage = $data['dimanche_pointage'];
        
        }



    







    

        if(!empty($data['lundi_pointage'])){
        
            $Ventilations->lundi_pointage = $data['lundi_pointage'];
        
        }



    







    

        if(!empty($data['mardi_pointage'])){
        
            $Ventilations->mardi_pointage = $data['mardi_pointage'];
        
        }



    







    

        if(!empty($data['mercredi_pointage'])){
        
            $Ventilations->mercredi_pointage = $data['mercredi_pointage'];
        
        }



    







    

        if(!empty($data['jeudi_pointage'])){
        
            $Ventilations->jeudi_pointage = $data['jeudi_pointage'];
        
        }



    







    

        if(!empty($data['vendredi_pointage'])){
        
            $Ventilations->vendredi_pointage = $data['vendredi_pointage'];
        
        }



    







    

        if(!empty($data['samedi_pointage'])){
        
            $Ventilations->samedi_pointage = $data['samedi_pointage'];
        
        }



    







    

        if(!empty($data['dimanche_collecter'])){
        
            $Ventilations->dimanche_collecter = $data['dimanche_collecter'];
        
        }



    







    

        if(!empty($data['lundi_collecter'])){
        
            $Ventilations->lundi_collecter = $data['lundi_collecter'];
        
        }



    







    

        if(!empty($data['mardi_collecter'])){
        
            $Ventilations->mardi_collecter = $data['mardi_collecter'];
        
        }



    







    

        if(!empty($data['mercredi_collecter'])){
        
            $Ventilations->mercredi_collecter = $data['mercredi_collecter'];
        
        }



    







    

        if(!empty($data['jeudi_collecter'])){
        
            $Ventilations->jeudi_collecter = $data['jeudi_collecter'];
        
        }



    







    

        if(!empty($data['vendredi_collecter'])){
        
            $Ventilations->vendredi_collecter = $data['vendredi_collecter'];
        
        }



    







    

        if(!empty($data['samedi_collecter'])){
        
            $Ventilations->samedi_collecter = $data['samedi_collecter'];
        
        }



    







    

        if(!empty($data['dimanche_depassement'])){
        
            $Ventilations->dimanche_depassement = $data['dimanche_depassement'];
        
        }



    







    

        if(!empty($data['lundi_depassement'])){
        
            $Ventilations->lundi_depassement = $data['lundi_depassement'];
        
        }



    







    

        if(!empty($data['mardi_depassement'])){
        
            $Ventilations->mardi_depassement = $data['mardi_depassement'];
        
        }



    







    

        if(!empty($data['mercredi_depassement'])){
        
            $Ventilations->mercredi_depassement = $data['mercredi_depassement'];
        
        }



    







    

        if(!empty($data['jeudi_depassement'])){
        
            $Ventilations->jeudi_depassement = $data['jeudi_depassement'];
        
        }



    







    

        if(!empty($data['vendredi_depassement'])){
        
            $Ventilations->vendredi_depassement = $data['vendredi_depassement'];
        
        }



    







    

        if(!empty($data['samedi_depassement'])){
        
            $Ventilations->samedi_depassement = $data['samedi_depassement'];
        
        }



    







    

        if(!empty($data['dimanche_programmer'])){
        
            $Ventilations->dimanche_programmer = $data['dimanche_programmer'];
        
        }



    







    

        if(!empty($data['lundi_programmer'])){
        
            $Ventilations->lundi_programmer = $data['lundi_programmer'];
        
        }



    







    

        if(!empty($data['mardi_programmer'])){
        
            $Ventilations->mardi_programmer = $data['mardi_programmer'];
        
        }



    







    

        if(!empty($data['mercredi_programmer'])){
        
            $Ventilations->mercredi_programmer = $data['mercredi_programmer'];
        
        }



    







    

        if(!empty($data['jeudi_programmer'])){
        
            $Ventilations->jeudi_programmer = $data['jeudi_programmer'];
        
        }



    







    

        if(!empty($data['vendredi_programmer'])){
        
            $Ventilations->vendredi_programmer = $data['vendredi_programmer'];
        
        }



    







    

        if(!empty($data['samedi_programmer'])){
        
            $Ventilations->samedi_programmer = $data['samedi_programmer'];
        
        }



    







    

        if(!empty($data['dimanche_retard'])){
        
            $Ventilations->dimanche_retard = $data['dimanche_retard'];
        
        }



    







    

        if(!empty($data['lundi_retard'])){
        
            $Ventilations->lundi_retard = $data['lundi_retard'];
        
        }



    







    

        if(!empty($data['mardi_retard'])){
        
            $Ventilations->mardi_retard = $data['mardi_retard'];
        
        }



    







    

        if(!empty($data['mercredi_retard'])){
        
            $Ventilations->mercredi_retard = $data['mercredi_retard'];
        
        }



    







    

        if(!empty($data['jeudi_retard'])){
        
            $Ventilations->jeudi_retard = $data['jeudi_retard'];
        
        }



    







    

        if(!empty($data['vendredi_retard'])){
        
            $Ventilations->vendredi_retard = $data['vendredi_retard'];
        
        }



    







    

        if(!empty($data['samedi_retard'])){
        
            $Ventilations->samedi_retard = $data['samedi_retard'];
        
        }



    







    

        if(!empty($data['programmation_id'])){
        
            $Ventilations->programmation_id = $data['programmation_id'];
        
        }



    







    

        if(!empty($data['total_programmer'])){
        
            $Ventilations->total_programmer = $data['total_programmer'];
        
        }



    







    

        if(!empty($data['total_colecter'])){
        
            $Ventilations->total_colecter = $data['total_colecter'];
        
        }



    







    

        if(!empty($data['total_depassement'])){
        
            $Ventilations->total_depassement = $data['total_depassement'];
        
        }



    







    

        if(!empty($data['hs15'])){
        
            $Ventilations->hs15 = $data['hs15'];
        
        }



    







    

        if(!empty($data['hs26'])){
        
            $Ventilations->hs26 = $data['hs26'];
        
        }



    







    

        if(!empty($data['hs55'])){
        
            $Ventilations->hs55 = $data['hs55'];
        
        }



    







    

        if(!empty($data['hs30'])){
        
            $Ventilations->hs30 = $data['hs30'];
        
        }



    







    

        if(!empty($data['hs60'])){
        
            $Ventilations->hs60 = $data['hs60'];
        
        }



    







    

        if(!empty($data['hs115'])){
        
            $Ventilations->hs115 = $data['hs115'];
        
        }



    







    

        if(!empty($data['hs130'])){
        
            $Ventilations->hs130 = $data['hs130'];
        
        }



    







    

        if(!empty($data['total'])){
        
            $Ventilations->total = $data['total'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Ventilations->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Ventilations->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Ventilations->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\VentilationExtras') &&
method_exists('\App\Http\Extras\VentilationExtras', 'beforeSaveCreate')
){
\App\Http\Extras\VentilationExtras::beforeSaveCreate($request,$Ventilations);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\VentilationExtras') &&
method_exists('\App\Http\Extras\VentilationExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\VentilationExtras::canCreate($request, $Ventilations);
}catch (\Throwable $e){

}

}


if($canSave){
$Ventilations->save();
}else{
return response()->json($Ventilations, 200);
}

$Ventilations=Ventilation::find($Ventilations->id);
$newCrudData=[];

                $newCrudData['user_id']=$Ventilations->user_id;
                $newCrudData['semaine']=$Ventilations->semaine;
                $newCrudData['dimanche_date']=$Ventilations->dimanche_date;
                $newCrudData['lundi_date']=$Ventilations->lundi_date;
                $newCrudData['mardi_date']=$Ventilations->mardi_date;
                $newCrudData['mercredi_date']=$Ventilations->mercredi_date;
                $newCrudData['jeudi_date']=$Ventilations->jeudi_date;
                $newCrudData['vendredi_date']=$Ventilations->vendredi_date;
                $newCrudData['samedi_date']=$Ventilations->samedi_date;
                $newCrudData['dimanche_horaire']=$Ventilations->dimanche_horaire;
                $newCrudData['lundi_horaire']=$Ventilations->lundi_horaire;
                $newCrudData['mardi_horaire']=$Ventilations->mardi_horaire;
                $newCrudData['mercredi_horaire']=$Ventilations->mercredi_horaire;
                $newCrudData['jeudi_horaire']=$Ventilations->jeudi_horaire;
                $newCrudData['vendredi_horaire']=$Ventilations->vendredi_horaire;
                $newCrudData['samedi_horaire']=$Ventilations->samedi_horaire;
                $newCrudData['dimanche']=$Ventilations->dimanche;
                $newCrudData['lundi']=$Ventilations->lundi;
                $newCrudData['mardi']=$Ventilations->mardi;
                $newCrudData['mercredi']=$Ventilations->mercredi;
                $newCrudData['jeudi']=$Ventilations->jeudi;
                $newCrudData['vendredi']=$Ventilations->vendredi;
                $newCrudData['samedi']=$Ventilations->samedi;
                $newCrudData['dimanche_pointage']=$Ventilations->dimanche_pointage;
                $newCrudData['lundi_pointage']=$Ventilations->lundi_pointage;
                $newCrudData['mardi_pointage']=$Ventilations->mardi_pointage;
                $newCrudData['mercredi_pointage']=$Ventilations->mercredi_pointage;
                $newCrudData['jeudi_pointage']=$Ventilations->jeudi_pointage;
                $newCrudData['vendredi_pointage']=$Ventilations->vendredi_pointage;
                $newCrudData['samedi_pointage']=$Ventilations->samedi_pointage;
                $newCrudData['dimanche_collecter']=$Ventilations->dimanche_collecter;
                $newCrudData['lundi_collecter']=$Ventilations->lundi_collecter;
                $newCrudData['mardi_collecter']=$Ventilations->mardi_collecter;
                $newCrudData['mercredi_collecter']=$Ventilations->mercredi_collecter;
                $newCrudData['jeudi_collecter']=$Ventilations->jeudi_collecter;
                $newCrudData['vendredi_collecter']=$Ventilations->vendredi_collecter;
                $newCrudData['samedi_collecter']=$Ventilations->samedi_collecter;
                $newCrudData['dimanche_depassement']=$Ventilations->dimanche_depassement;
                $newCrudData['lundi_depassement']=$Ventilations->lundi_depassement;
                $newCrudData['mardi_depassement']=$Ventilations->mardi_depassement;
                $newCrudData['mercredi_depassement']=$Ventilations->mercredi_depassement;
                $newCrudData['jeudi_depassement']=$Ventilations->jeudi_depassement;
                $newCrudData['vendredi_depassement']=$Ventilations->vendredi_depassement;
                $newCrudData['samedi_depassement']=$Ventilations->samedi_depassement;
                $newCrudData['dimanche_programmer']=$Ventilations->dimanche_programmer;
                $newCrudData['lundi_programmer']=$Ventilations->lundi_programmer;
                $newCrudData['mardi_programmer']=$Ventilations->mardi_programmer;
                $newCrudData['mercredi_programmer']=$Ventilations->mercredi_programmer;
                $newCrudData['jeudi_programmer']=$Ventilations->jeudi_programmer;
                $newCrudData['vendredi_programmer']=$Ventilations->vendredi_programmer;
                $newCrudData['samedi_programmer']=$Ventilations->samedi_programmer;
                $newCrudData['dimanche_retard']=$Ventilations->dimanche_retard;
                $newCrudData['lundi_retard']=$Ventilations->lundi_retard;
                $newCrudData['mardi_retard']=$Ventilations->mardi_retard;
                $newCrudData['mercredi_retard']=$Ventilations->mercredi_retard;
                $newCrudData['jeudi_retard']=$Ventilations->jeudi_retard;
                $newCrudData['vendredi_retard']=$Ventilations->vendredi_retard;
                $newCrudData['samedi_retard']=$Ventilations->samedi_retard;
                $newCrudData['programmation_id']=$Ventilations->programmation_id;
                $newCrudData['total_programmer']=$Ventilations->total_programmer;
                $newCrudData['total_colecter']=$Ventilations->total_colecter;
                $newCrudData['total_depassement']=$Ventilations->total_depassement;
                $newCrudData['hs15']=$Ventilations->hs15;
                $newCrudData['hs26']=$Ventilations->hs26;
                $newCrudData['hs55']=$Ventilations->hs55;
                $newCrudData['hs30']=$Ventilations->hs30;
                $newCrudData['hs60']=$Ventilations->hs60;
                $newCrudData['hs115']=$Ventilations->hs115;
                $newCrudData['hs130']=$Ventilations->hs130;
                $newCrudData['total']=$Ventilations->total;
                                $newCrudData['identifiants_sadge']=$Ventilations->identifiants_sadge;
                $newCrudData['creat_by']=$Ventilations->creat_by;
    
 try{ $newCrudData['programmation']=$Ventilations->programmation->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Ventilations->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Ventilations','entite_cle' => $Ventilations->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Ventilations->toArray();




try{

foreach ($Ventilations->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Ventilation $Ventilations)
{
try{
$can=\App\Helpers\Helpers::can('Editer des ventilations');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['user_id']=$Ventilations->user_id;
                $oldCrudData['semaine']=$Ventilations->semaine;
                $oldCrudData['dimanche_date']=$Ventilations->dimanche_date;
                $oldCrudData['lundi_date']=$Ventilations->lundi_date;
                $oldCrudData['mardi_date']=$Ventilations->mardi_date;
                $oldCrudData['mercredi_date']=$Ventilations->mercredi_date;
                $oldCrudData['jeudi_date']=$Ventilations->jeudi_date;
                $oldCrudData['vendredi_date']=$Ventilations->vendredi_date;
                $oldCrudData['samedi_date']=$Ventilations->samedi_date;
                $oldCrudData['dimanche_horaire']=$Ventilations->dimanche_horaire;
                $oldCrudData['lundi_horaire']=$Ventilations->lundi_horaire;
                $oldCrudData['mardi_horaire']=$Ventilations->mardi_horaire;
                $oldCrudData['mercredi_horaire']=$Ventilations->mercredi_horaire;
                $oldCrudData['jeudi_horaire']=$Ventilations->jeudi_horaire;
                $oldCrudData['vendredi_horaire']=$Ventilations->vendredi_horaire;
                $oldCrudData['samedi_horaire']=$Ventilations->samedi_horaire;
                $oldCrudData['dimanche']=$Ventilations->dimanche;
                $oldCrudData['lundi']=$Ventilations->lundi;
                $oldCrudData['mardi']=$Ventilations->mardi;
                $oldCrudData['mercredi']=$Ventilations->mercredi;
                $oldCrudData['jeudi']=$Ventilations->jeudi;
                $oldCrudData['vendredi']=$Ventilations->vendredi;
                $oldCrudData['samedi']=$Ventilations->samedi;
                $oldCrudData['dimanche_pointage']=$Ventilations->dimanche_pointage;
                $oldCrudData['lundi_pointage']=$Ventilations->lundi_pointage;
                $oldCrudData['mardi_pointage']=$Ventilations->mardi_pointage;
                $oldCrudData['mercredi_pointage']=$Ventilations->mercredi_pointage;
                $oldCrudData['jeudi_pointage']=$Ventilations->jeudi_pointage;
                $oldCrudData['vendredi_pointage']=$Ventilations->vendredi_pointage;
                $oldCrudData['samedi_pointage']=$Ventilations->samedi_pointage;
                $oldCrudData['dimanche_collecter']=$Ventilations->dimanche_collecter;
                $oldCrudData['lundi_collecter']=$Ventilations->lundi_collecter;
                $oldCrudData['mardi_collecter']=$Ventilations->mardi_collecter;
                $oldCrudData['mercredi_collecter']=$Ventilations->mercredi_collecter;
                $oldCrudData['jeudi_collecter']=$Ventilations->jeudi_collecter;
                $oldCrudData['vendredi_collecter']=$Ventilations->vendredi_collecter;
                $oldCrudData['samedi_collecter']=$Ventilations->samedi_collecter;
                $oldCrudData['dimanche_depassement']=$Ventilations->dimanche_depassement;
                $oldCrudData['lundi_depassement']=$Ventilations->lundi_depassement;
                $oldCrudData['mardi_depassement']=$Ventilations->mardi_depassement;
                $oldCrudData['mercredi_depassement']=$Ventilations->mercredi_depassement;
                $oldCrudData['jeudi_depassement']=$Ventilations->jeudi_depassement;
                $oldCrudData['vendredi_depassement']=$Ventilations->vendredi_depassement;
                $oldCrudData['samedi_depassement']=$Ventilations->samedi_depassement;
                $oldCrudData['dimanche_programmer']=$Ventilations->dimanche_programmer;
                $oldCrudData['lundi_programmer']=$Ventilations->lundi_programmer;
                $oldCrudData['mardi_programmer']=$Ventilations->mardi_programmer;
                $oldCrudData['mercredi_programmer']=$Ventilations->mercredi_programmer;
                $oldCrudData['jeudi_programmer']=$Ventilations->jeudi_programmer;
                $oldCrudData['vendredi_programmer']=$Ventilations->vendredi_programmer;
                $oldCrudData['samedi_programmer']=$Ventilations->samedi_programmer;
                $oldCrudData['dimanche_retard']=$Ventilations->dimanche_retard;
                $oldCrudData['lundi_retard']=$Ventilations->lundi_retard;
                $oldCrudData['mardi_retard']=$Ventilations->mardi_retard;
                $oldCrudData['mercredi_retard']=$Ventilations->mercredi_retard;
                $oldCrudData['jeudi_retard']=$Ventilations->jeudi_retard;
                $oldCrudData['vendredi_retard']=$Ventilations->vendredi_retard;
                $oldCrudData['samedi_retard']=$Ventilations->samedi_retard;
                $oldCrudData['programmation_id']=$Ventilations->programmation_id;
                $oldCrudData['total_programmer']=$Ventilations->total_programmer;
                $oldCrudData['total_colecter']=$Ventilations->total_colecter;
                $oldCrudData['total_depassement']=$Ventilations->total_depassement;
                $oldCrudData['hs15']=$Ventilations->hs15;
                $oldCrudData['hs26']=$Ventilations->hs26;
                $oldCrudData['hs55']=$Ventilations->hs55;
                $oldCrudData['hs30']=$Ventilations->hs30;
                $oldCrudData['hs60']=$Ventilations->hs60;
                $oldCrudData['hs115']=$Ventilations->hs115;
                $oldCrudData['hs130']=$Ventilations->hs130;
                $oldCrudData['total']=$Ventilations->total;
                                $oldCrudData['identifiants_sadge']=$Ventilations->identifiants_sadge;
                $oldCrudData['creat_by']=$Ventilations->creat_by;
    
 try{ $oldCrudData['programmation']=$Ventilations->programmation->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Ventilations->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "ventilations"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'semaine',
    'dimanche_date',
    'lundi_date',
    'mardi_date',
    'mercredi_date',
    'jeudi_date',
    'vendredi_date',
    'samedi_date',
    'dimanche_horaire',
    'lundi_horaire',
    'mardi_horaire',
    'mercredi_horaire',
    'jeudi_horaire',
    'vendredi_horaire',
    'samedi_horaire',
    'dimanche',
    'lundi',
    'mardi',
    'mercredi',
    'jeudi',
    'vendredi',
    'samedi',
    'dimanche_pointage',
    'lundi_pointage',
    'mardi_pointage',
    'mercredi_pointage',
    'jeudi_pointage',
    'vendredi_pointage',
    'samedi_pointage',
    'dimanche_collecter',
    'lundi_collecter',
    'mardi_collecter',
    'mercredi_collecter',
    'jeudi_collecter',
    'vendredi_collecter',
    'samedi_collecter',
    'dimanche_depassement',
    'lundi_depassement',
    'mardi_depassement',
    'mercredi_depassement',
    'jeudi_depassement',
    'vendredi_depassement',
    'samedi_depassement',
    'dimanche_programmer',
    'lundi_programmer',
    'mardi_programmer',
    'mercredi_programmer',
    'jeudi_programmer',
    'vendredi_programmer',
    'samedi_programmer',
    'dimanche_retard',
    'lundi_retard',
    'mardi_retard',
    'mercredi_retard',
    'jeudi_retard',
    'vendredi_retard',
    'samedi_retard',
    'programmation_id',
    'total_programmer',
    'total_colecter',
    'total_depassement',
    'hs15',
    'hs26',
    'hs55',
    'hs30',
    'hs60',
    'hs115',
    'hs130',
    'total',
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
    
    
    
                    'semaine' => [
            //'required'
            ],
        
    
    
                    'dimanche_date' => [
            //'required'
            ],
        
    
    
                    'lundi_date' => [
            //'required'
            ],
        
    
    
                    'mardi_date' => [
            //'required'
            ],
        
    
    
                    'mercredi_date' => [
            //'required'
            ],
        
    
    
                    'jeudi_date' => [
            //'required'
            ],
        
    
    
                    'vendredi_date' => [
            //'required'
            ],
        
    
    
                    'samedi_date' => [
            //'required'
            ],
        
    
    
                    'dimanche_horaire' => [
            //'required'
            ],
        
    
    
                    'lundi_horaire' => [
            //'required'
            ],
        
    
    
                    'mardi_horaire' => [
            //'required'
            ],
        
    
    
                    'mercredi_horaire' => [
            //'required'
            ],
        
    
    
                    'jeudi_horaire' => [
            //'required'
            ],
        
    
    
                    'vendredi_horaire' => [
            //'required'
            ],
        
    
    
                    'samedi_horaire' => [
            //'required'
            ],
        
    
    
                    'dimanche' => [
            //'required'
            ],
        
    
    
                    'lundi' => [
            //'required'
            ],
        
    
    
                    'mardi' => [
            //'required'
            ],
        
    
    
                    'mercredi' => [
            //'required'
            ],
        
    
    
                    'jeudi' => [
            //'required'
            ],
        
    
    
                    'vendredi' => [
            //'required'
            ],
        
    
    
                    'samedi' => [
            //'required'
            ],
        
    
    
                    'dimanche_pointage' => [
            //'required'
            ],
        
    
    
                    'lundi_pointage' => [
            //'required'
            ],
        
    
    
                    'mardi_pointage' => [
            //'required'
            ],
        
    
    
                    'mercredi_pointage' => [
            //'required'
            ],
        
    
    
                    'jeudi_pointage' => [
            //'required'
            ],
        
    
    
                    'vendredi_pointage' => [
            //'required'
            ],
        
    
    
                    'samedi_pointage' => [
            //'required'
            ],
        
    
    
                    'dimanche_collecter' => [
            //'required'
            ],
        
    
    
                    'lundi_collecter' => [
            //'required'
            ],
        
    
    
                    'mardi_collecter' => [
            //'required'
            ],
        
    
    
                    'mercredi_collecter' => [
            //'required'
            ],
        
    
    
                    'jeudi_collecter' => [
            //'required'
            ],
        
    
    
                    'vendredi_collecter' => [
            //'required'
            ],
        
    
    
                    'samedi_collecter' => [
            //'required'
            ],
        
    
    
                    'dimanche_depassement' => [
            //'required'
            ],
        
    
    
                    'lundi_depassement' => [
            //'required'
            ],
        
    
    
                    'mardi_depassement' => [
            //'required'
            ],
        
    
    
                    'mercredi_depassement' => [
            //'required'
            ],
        
    
    
                    'jeudi_depassement' => [
            //'required'
            ],
        
    
    
                    'vendredi_depassement' => [
            //'required'
            ],
        
    
    
                    'samedi_depassement' => [
            //'required'
            ],
        
    
    
                    'dimanche_programmer' => [
            //'required'
            ],
        
    
    
                    'lundi_programmer' => [
            //'required'
            ],
        
    
    
                    'mardi_programmer' => [
            //'required'
            ],
        
    
    
                    'mercredi_programmer' => [
            //'required'
            ],
        
    
    
                    'jeudi_programmer' => [
            //'required'
            ],
        
    
    
                    'vendredi_programmer' => [
            //'required'
            ],
        
    
    
                    'samedi_programmer' => [
            //'required'
            ],
        
    
    
                    'dimanche_retard' => [
            //'required'
            ],
        
    
    
                    'lundi_retard' => [
            //'required'
            ],
        
    
    
                    'mardi_retard' => [
            //'required'
            ],
        
    
    
                    'mercredi_retard' => [
            //'required'
            ],
        
    
    
                    'jeudi_retard' => [
            //'required'
            ],
        
    
    
                    'vendredi_retard' => [
            //'required'
            ],
        
    
    
                    'samedi_retard' => [
            //'required'
            ],
        
    
    
                    'programmation_id' => [
            //'required'
            ],
        
    
    
                    'total_programmer' => [
            //'required'
            ],
        
    
    
                    'total_colecter' => [
            //'required'
            ],
        
    
    
                    'total_depassement' => [
            //'required'
            ],
        
    
    
                    'hs15' => [
            //'required'
            ],
        
    
    
                    'hs26' => [
            //'required'
            ],
        
    
    
                    'hs55' => [
            //'required'
            ],
        
    
    
                    'hs30' => [
            //'required'
            ],
        
    
    
                    'hs60' => [
            //'required'
            ],
        
    
    
                    'hs115' => [
            //'required'
            ],
        
    
    
                    'hs130' => [
            //'required'
            ],
        
    
    
                    'total' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
    
        'semaine' => ['cette donnee est obligatoire'],

    
    
        'dimanche_date' => ['cette donnee est obligatoire'],

    
    
        'lundi_date' => ['cette donnee est obligatoire'],

    
    
        'mardi_date' => ['cette donnee est obligatoire'],

    
    
        'mercredi_date' => ['cette donnee est obligatoire'],

    
    
        'jeudi_date' => ['cette donnee est obligatoire'],

    
    
        'vendredi_date' => ['cette donnee est obligatoire'],

    
    
        'samedi_date' => ['cette donnee est obligatoire'],

    
    
        'dimanche_horaire' => ['cette donnee est obligatoire'],

    
    
        'lundi_horaire' => ['cette donnee est obligatoire'],

    
    
        'mardi_horaire' => ['cette donnee est obligatoire'],

    
    
        'mercredi_horaire' => ['cette donnee est obligatoire'],

    
    
        'jeudi_horaire' => ['cette donnee est obligatoire'],

    
    
        'vendredi_horaire' => ['cette donnee est obligatoire'],

    
    
        'samedi_horaire' => ['cette donnee est obligatoire'],

    
    
        'dimanche' => ['cette donnee est obligatoire'],

    
    
        'lundi' => ['cette donnee est obligatoire'],

    
    
        'mardi' => ['cette donnee est obligatoire'],

    
    
        'mercredi' => ['cette donnee est obligatoire'],

    
    
        'jeudi' => ['cette donnee est obligatoire'],

    
    
        'vendredi' => ['cette donnee est obligatoire'],

    
    
        'samedi' => ['cette donnee est obligatoire'],

    
    
        'dimanche_pointage' => ['cette donnee est obligatoire'],

    
    
        'lundi_pointage' => ['cette donnee est obligatoire'],

    
    
        'mardi_pointage' => ['cette donnee est obligatoire'],

    
    
        'mercredi_pointage' => ['cette donnee est obligatoire'],

    
    
        'jeudi_pointage' => ['cette donnee est obligatoire'],

    
    
        'vendredi_pointage' => ['cette donnee est obligatoire'],

    
    
        'samedi_pointage' => ['cette donnee est obligatoire'],

    
    
        'dimanche_collecter' => ['cette donnee est obligatoire'],

    
    
        'lundi_collecter' => ['cette donnee est obligatoire'],

    
    
        'mardi_collecter' => ['cette donnee est obligatoire'],

    
    
        'mercredi_collecter' => ['cette donnee est obligatoire'],

    
    
        'jeudi_collecter' => ['cette donnee est obligatoire'],

    
    
        'vendredi_collecter' => ['cette donnee est obligatoire'],

    
    
        'samedi_collecter' => ['cette donnee est obligatoire'],

    
    
        'dimanche_depassement' => ['cette donnee est obligatoire'],

    
    
        'lundi_depassement' => ['cette donnee est obligatoire'],

    
    
        'mardi_depassement' => ['cette donnee est obligatoire'],

    
    
        'mercredi_depassement' => ['cette donnee est obligatoire'],

    
    
        'jeudi_depassement' => ['cette donnee est obligatoire'],

    
    
        'vendredi_depassement' => ['cette donnee est obligatoire'],

    
    
        'samedi_depassement' => ['cette donnee est obligatoire'],

    
    
        'dimanche_programmer' => ['cette donnee est obligatoire'],

    
    
        'lundi_programmer' => ['cette donnee est obligatoire'],

    
    
        'mardi_programmer' => ['cette donnee est obligatoire'],

    
    
        'mercredi_programmer' => ['cette donnee est obligatoire'],

    
    
        'jeudi_programmer' => ['cette donnee est obligatoire'],

    
    
        'vendredi_programmer' => ['cette donnee est obligatoire'],

    
    
        'samedi_programmer' => ['cette donnee est obligatoire'],

    
    
        'dimanche_retard' => ['cette donnee est obligatoire'],

    
    
        'lundi_retard' => ['cette donnee est obligatoire'],

    
    
        'mardi_retard' => ['cette donnee est obligatoire'],

    
    
        'mercredi_retard' => ['cette donnee est obligatoire'],

    
    
        'jeudi_retard' => ['cette donnee est obligatoire'],

    
    
        'vendredi_retard' => ['cette donnee est obligatoire'],

    
    
        'samedi_retard' => ['cette donnee est obligatoire'],

    
    
        'programmation_id' => ['cette donnee est obligatoire'],

    
    
        'total_programmer' => ['cette donnee est obligatoire'],

    
    
        'total_colecter' => ['cette donnee est obligatoire'],

    
    
        'total_depassement' => ['cette donnee est obligatoire'],

    
    
        'hs15' => ['cette donnee est obligatoire'],

    
    
        'hs26' => ['cette donnee est obligatoire'],

    
    
        'hs55' => ['cette donnee est obligatoire'],

    
    
        'hs30' => ['cette donnee est obligatoire'],

    
    
        'hs60' => ['cette donnee est obligatoire'],

    
    
        'hs115' => ['cette donnee est obligatoire'],

    
    
        'hs130' => ['cette donnee est obligatoire'],

    
    
        'total' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Ventilations->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("semaine",$data)){


        if(!empty($data['semaine'])){
        
            $Ventilations->semaine = $data['semaine'];
        
        }

        }

    







    

        if(array_key_exists("dimanche_date",$data)){


        if(!empty($data['dimanche_date'])){
        
            $Ventilations->dimanche_date = $data['dimanche_date'];
        
        }

        }

    







    

        if(array_key_exists("lundi_date",$data)){


        if(!empty($data['lundi_date'])){
        
            $Ventilations->lundi_date = $data['lundi_date'];
        
        }

        }

    







    

        if(array_key_exists("mardi_date",$data)){


        if(!empty($data['mardi_date'])){
        
            $Ventilations->mardi_date = $data['mardi_date'];
        
        }

        }

    







    

        if(array_key_exists("mercredi_date",$data)){


        if(!empty($data['mercredi_date'])){
        
            $Ventilations->mercredi_date = $data['mercredi_date'];
        
        }

        }

    







    

        if(array_key_exists("jeudi_date",$data)){


        if(!empty($data['jeudi_date'])){
        
            $Ventilations->jeudi_date = $data['jeudi_date'];
        
        }

        }

    







    

        if(array_key_exists("vendredi_date",$data)){


        if(!empty($data['vendredi_date'])){
        
            $Ventilations->vendredi_date = $data['vendredi_date'];
        
        }

        }

    







    

        if(array_key_exists("samedi_date",$data)){


        if(!empty($data['samedi_date'])){
        
            $Ventilations->samedi_date = $data['samedi_date'];
        
        }

        }

    







    

        if(array_key_exists("dimanche_horaire",$data)){


        if(!empty($data['dimanche_horaire'])){
        
            $Ventilations->dimanche_horaire = $data['dimanche_horaire'];
        
        }

        }

    







    

        if(array_key_exists("lundi_horaire",$data)){


        if(!empty($data['lundi_horaire'])){
        
            $Ventilations->lundi_horaire = $data['lundi_horaire'];
        
        }

        }

    







    

        if(array_key_exists("mardi_horaire",$data)){


        if(!empty($data['mardi_horaire'])){
        
            $Ventilations->mardi_horaire = $data['mardi_horaire'];
        
        }

        }

    







    

        if(array_key_exists("mercredi_horaire",$data)){


        if(!empty($data['mercredi_horaire'])){
        
            $Ventilations->mercredi_horaire = $data['mercredi_horaire'];
        
        }

        }

    







    

        if(array_key_exists("jeudi_horaire",$data)){


        if(!empty($data['jeudi_horaire'])){
        
            $Ventilations->jeudi_horaire = $data['jeudi_horaire'];
        
        }

        }

    







    

        if(array_key_exists("vendredi_horaire",$data)){


        if(!empty($data['vendredi_horaire'])){
        
            $Ventilations->vendredi_horaire = $data['vendredi_horaire'];
        
        }

        }

    







    

        if(array_key_exists("samedi_horaire",$data)){


        if(!empty($data['samedi_horaire'])){
        
            $Ventilations->samedi_horaire = $data['samedi_horaire'];
        
        }

        }

    







    

        if(array_key_exists("dimanche",$data)){


        if(!empty($data['dimanche'])){
        
            $Ventilations->dimanche = $data['dimanche'];
        
        }

        }

    







    

        if(array_key_exists("lundi",$data)){


        if(!empty($data['lundi'])){
        
            $Ventilations->lundi = $data['lundi'];
        
        }

        }

    







    

        if(array_key_exists("mardi",$data)){


        if(!empty($data['mardi'])){
        
            $Ventilations->mardi = $data['mardi'];
        
        }

        }

    







    

        if(array_key_exists("mercredi",$data)){


        if(!empty($data['mercredi'])){
        
            $Ventilations->mercredi = $data['mercredi'];
        
        }

        }

    







    

        if(array_key_exists("jeudi",$data)){


        if(!empty($data['jeudi'])){
        
            $Ventilations->jeudi = $data['jeudi'];
        
        }

        }

    







    

        if(array_key_exists("vendredi",$data)){


        if(!empty($data['vendredi'])){
        
            $Ventilations->vendredi = $data['vendredi'];
        
        }

        }

    







    

        if(array_key_exists("samedi",$data)){


        if(!empty($data['samedi'])){
        
            $Ventilations->samedi = $data['samedi'];
        
        }

        }

    







    

        if(array_key_exists("dimanche_pointage",$data)){


        if(!empty($data['dimanche_pointage'])){
        
            $Ventilations->dimanche_pointage = $data['dimanche_pointage'];
        
        }

        }

    







    

        if(array_key_exists("lundi_pointage",$data)){


        if(!empty($data['lundi_pointage'])){
        
            $Ventilations->lundi_pointage = $data['lundi_pointage'];
        
        }

        }

    







    

        if(array_key_exists("mardi_pointage",$data)){


        if(!empty($data['mardi_pointage'])){
        
            $Ventilations->mardi_pointage = $data['mardi_pointage'];
        
        }

        }

    







    

        if(array_key_exists("mercredi_pointage",$data)){


        if(!empty($data['mercredi_pointage'])){
        
            $Ventilations->mercredi_pointage = $data['mercredi_pointage'];
        
        }

        }

    







    

        if(array_key_exists("jeudi_pointage",$data)){


        if(!empty($data['jeudi_pointage'])){
        
            $Ventilations->jeudi_pointage = $data['jeudi_pointage'];
        
        }

        }

    







    

        if(array_key_exists("vendredi_pointage",$data)){


        if(!empty($data['vendredi_pointage'])){
        
            $Ventilations->vendredi_pointage = $data['vendredi_pointage'];
        
        }

        }

    







    

        if(array_key_exists("samedi_pointage",$data)){


        if(!empty($data['samedi_pointage'])){
        
            $Ventilations->samedi_pointage = $data['samedi_pointage'];
        
        }

        }

    







    

        if(array_key_exists("dimanche_collecter",$data)){


        if(!empty($data['dimanche_collecter'])){
        
            $Ventilations->dimanche_collecter = $data['dimanche_collecter'];
        
        }

        }

    







    

        if(array_key_exists("lundi_collecter",$data)){


        if(!empty($data['lundi_collecter'])){
        
            $Ventilations->lundi_collecter = $data['lundi_collecter'];
        
        }

        }

    







    

        if(array_key_exists("mardi_collecter",$data)){


        if(!empty($data['mardi_collecter'])){
        
            $Ventilations->mardi_collecter = $data['mardi_collecter'];
        
        }

        }

    







    

        if(array_key_exists("mercredi_collecter",$data)){


        if(!empty($data['mercredi_collecter'])){
        
            $Ventilations->mercredi_collecter = $data['mercredi_collecter'];
        
        }

        }

    







    

        if(array_key_exists("jeudi_collecter",$data)){


        if(!empty($data['jeudi_collecter'])){
        
            $Ventilations->jeudi_collecter = $data['jeudi_collecter'];
        
        }

        }

    







    

        if(array_key_exists("vendredi_collecter",$data)){


        if(!empty($data['vendredi_collecter'])){
        
            $Ventilations->vendredi_collecter = $data['vendredi_collecter'];
        
        }

        }

    







    

        if(array_key_exists("samedi_collecter",$data)){


        if(!empty($data['samedi_collecter'])){
        
            $Ventilations->samedi_collecter = $data['samedi_collecter'];
        
        }

        }

    







    

        if(array_key_exists("dimanche_depassement",$data)){


        if(!empty($data['dimanche_depassement'])){
        
            $Ventilations->dimanche_depassement = $data['dimanche_depassement'];
        
        }

        }

    







    

        if(array_key_exists("lundi_depassement",$data)){


        if(!empty($data['lundi_depassement'])){
        
            $Ventilations->lundi_depassement = $data['lundi_depassement'];
        
        }

        }

    







    

        if(array_key_exists("mardi_depassement",$data)){


        if(!empty($data['mardi_depassement'])){
        
            $Ventilations->mardi_depassement = $data['mardi_depassement'];
        
        }

        }

    







    

        if(array_key_exists("mercredi_depassement",$data)){


        if(!empty($data['mercredi_depassement'])){
        
            $Ventilations->mercredi_depassement = $data['mercredi_depassement'];
        
        }

        }

    







    

        if(array_key_exists("jeudi_depassement",$data)){


        if(!empty($data['jeudi_depassement'])){
        
            $Ventilations->jeudi_depassement = $data['jeudi_depassement'];
        
        }

        }

    







    

        if(array_key_exists("vendredi_depassement",$data)){


        if(!empty($data['vendredi_depassement'])){
        
            $Ventilations->vendredi_depassement = $data['vendredi_depassement'];
        
        }

        }

    







    

        if(array_key_exists("samedi_depassement",$data)){


        if(!empty($data['samedi_depassement'])){
        
            $Ventilations->samedi_depassement = $data['samedi_depassement'];
        
        }

        }

    







    

        if(array_key_exists("dimanche_programmer",$data)){


        if(!empty($data['dimanche_programmer'])){
        
            $Ventilations->dimanche_programmer = $data['dimanche_programmer'];
        
        }

        }

    







    

        if(array_key_exists("lundi_programmer",$data)){


        if(!empty($data['lundi_programmer'])){
        
            $Ventilations->lundi_programmer = $data['lundi_programmer'];
        
        }

        }

    







    

        if(array_key_exists("mardi_programmer",$data)){


        if(!empty($data['mardi_programmer'])){
        
            $Ventilations->mardi_programmer = $data['mardi_programmer'];
        
        }

        }

    







    

        if(array_key_exists("mercredi_programmer",$data)){


        if(!empty($data['mercredi_programmer'])){
        
            $Ventilations->mercredi_programmer = $data['mercredi_programmer'];
        
        }

        }

    







    

        if(array_key_exists("jeudi_programmer",$data)){


        if(!empty($data['jeudi_programmer'])){
        
            $Ventilations->jeudi_programmer = $data['jeudi_programmer'];
        
        }

        }

    







    

        if(array_key_exists("vendredi_programmer",$data)){


        if(!empty($data['vendredi_programmer'])){
        
            $Ventilations->vendredi_programmer = $data['vendredi_programmer'];
        
        }

        }

    







    

        if(array_key_exists("samedi_programmer",$data)){


        if(!empty($data['samedi_programmer'])){
        
            $Ventilations->samedi_programmer = $data['samedi_programmer'];
        
        }

        }

    







    

        if(array_key_exists("dimanche_retard",$data)){


        if(!empty($data['dimanche_retard'])){
        
            $Ventilations->dimanche_retard = $data['dimanche_retard'];
        
        }

        }

    







    

        if(array_key_exists("lundi_retard",$data)){


        if(!empty($data['lundi_retard'])){
        
            $Ventilations->lundi_retard = $data['lundi_retard'];
        
        }

        }

    







    

        if(array_key_exists("mardi_retard",$data)){


        if(!empty($data['mardi_retard'])){
        
            $Ventilations->mardi_retard = $data['mardi_retard'];
        
        }

        }

    







    

        if(array_key_exists("mercredi_retard",$data)){


        if(!empty($data['mercredi_retard'])){
        
            $Ventilations->mercredi_retard = $data['mercredi_retard'];
        
        }

        }

    







    

        if(array_key_exists("jeudi_retard",$data)){


        if(!empty($data['jeudi_retard'])){
        
            $Ventilations->jeudi_retard = $data['jeudi_retard'];
        
        }

        }

    







    

        if(array_key_exists("vendredi_retard",$data)){


        if(!empty($data['vendredi_retard'])){
        
            $Ventilations->vendredi_retard = $data['vendredi_retard'];
        
        }

        }

    







    

        if(array_key_exists("samedi_retard",$data)){


        if(!empty($data['samedi_retard'])){
        
            $Ventilations->samedi_retard = $data['samedi_retard'];
        
        }

        }

    







    

        if(array_key_exists("programmation_id",$data)){


        if(!empty($data['programmation_id'])){
        
            $Ventilations->programmation_id = $data['programmation_id'];
        
        }

        }

    







    

        if(array_key_exists("total_programmer",$data)){


        if(!empty($data['total_programmer'])){
        
            $Ventilations->total_programmer = $data['total_programmer'];
        
        }

        }

    







    

        if(array_key_exists("total_colecter",$data)){


        if(!empty($data['total_colecter'])){
        
            $Ventilations->total_colecter = $data['total_colecter'];
        
        }

        }

    







    

        if(array_key_exists("total_depassement",$data)){


        if(!empty($data['total_depassement'])){
        
            $Ventilations->total_depassement = $data['total_depassement'];
        
        }

        }

    







    

        if(array_key_exists("hs15",$data)){


        if(!empty($data['hs15'])){
        
            $Ventilations->hs15 = $data['hs15'];
        
        }

        }

    







    

        if(array_key_exists("hs26",$data)){


        if(!empty($data['hs26'])){
        
            $Ventilations->hs26 = $data['hs26'];
        
        }

        }

    







    

        if(array_key_exists("hs55",$data)){


        if(!empty($data['hs55'])){
        
            $Ventilations->hs55 = $data['hs55'];
        
        }

        }

    







    

        if(array_key_exists("hs30",$data)){


        if(!empty($data['hs30'])){
        
            $Ventilations->hs30 = $data['hs30'];
        
        }

        }

    







    

        if(array_key_exists("hs60",$data)){


        if(!empty($data['hs60'])){
        
            $Ventilations->hs60 = $data['hs60'];
        
        }

        }

    







    

        if(array_key_exists("hs115",$data)){


        if(!empty($data['hs115'])){
        
            $Ventilations->hs115 = $data['hs115'];
        
        }

        }

    







    

        if(array_key_exists("hs130",$data)){


        if(!empty($data['hs130'])){
        
            $Ventilations->hs130 = $data['hs130'];
        
        }

        }

    







    

        if(array_key_exists("total",$data)){


        if(!empty($data['total'])){
        
            $Ventilations->total = $data['total'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Ventilations->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Ventilations->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Ventilations->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\VentilationExtras') &&
method_exists('\App\Http\Extras\VentilationExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\VentilationExtras::beforeSaveUpdate($request,$Ventilations);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\VentilationExtras') &&
method_exists('\App\Http\Extras\VentilationExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\VentilationExtras::canUpdate($request, $Ventilations);
}catch (\Throwable $e){

}

}


if($canSave){
$Ventilations->save();
}else{
return response()->json($Ventilations, 200);

}


$Ventilations=Ventilation::find($Ventilations->id);



$newCrudData=[];

                $newCrudData['user_id']=$Ventilations->user_id;
                $newCrudData['semaine']=$Ventilations->semaine;
                $newCrudData['dimanche_date']=$Ventilations->dimanche_date;
                $newCrudData['lundi_date']=$Ventilations->lundi_date;
                $newCrudData['mardi_date']=$Ventilations->mardi_date;
                $newCrudData['mercredi_date']=$Ventilations->mercredi_date;
                $newCrudData['jeudi_date']=$Ventilations->jeudi_date;
                $newCrudData['vendredi_date']=$Ventilations->vendredi_date;
                $newCrudData['samedi_date']=$Ventilations->samedi_date;
                $newCrudData['dimanche_horaire']=$Ventilations->dimanche_horaire;
                $newCrudData['lundi_horaire']=$Ventilations->lundi_horaire;
                $newCrudData['mardi_horaire']=$Ventilations->mardi_horaire;
                $newCrudData['mercredi_horaire']=$Ventilations->mercredi_horaire;
                $newCrudData['jeudi_horaire']=$Ventilations->jeudi_horaire;
                $newCrudData['vendredi_horaire']=$Ventilations->vendredi_horaire;
                $newCrudData['samedi_horaire']=$Ventilations->samedi_horaire;
                $newCrudData['dimanche']=$Ventilations->dimanche;
                $newCrudData['lundi']=$Ventilations->lundi;
                $newCrudData['mardi']=$Ventilations->mardi;
                $newCrudData['mercredi']=$Ventilations->mercredi;
                $newCrudData['jeudi']=$Ventilations->jeudi;
                $newCrudData['vendredi']=$Ventilations->vendredi;
                $newCrudData['samedi']=$Ventilations->samedi;
                $newCrudData['dimanche_pointage']=$Ventilations->dimanche_pointage;
                $newCrudData['lundi_pointage']=$Ventilations->lundi_pointage;
                $newCrudData['mardi_pointage']=$Ventilations->mardi_pointage;
                $newCrudData['mercredi_pointage']=$Ventilations->mercredi_pointage;
                $newCrudData['jeudi_pointage']=$Ventilations->jeudi_pointage;
                $newCrudData['vendredi_pointage']=$Ventilations->vendredi_pointage;
                $newCrudData['samedi_pointage']=$Ventilations->samedi_pointage;
                $newCrudData['dimanche_collecter']=$Ventilations->dimanche_collecter;
                $newCrudData['lundi_collecter']=$Ventilations->lundi_collecter;
                $newCrudData['mardi_collecter']=$Ventilations->mardi_collecter;
                $newCrudData['mercredi_collecter']=$Ventilations->mercredi_collecter;
                $newCrudData['jeudi_collecter']=$Ventilations->jeudi_collecter;
                $newCrudData['vendredi_collecter']=$Ventilations->vendredi_collecter;
                $newCrudData['samedi_collecter']=$Ventilations->samedi_collecter;
                $newCrudData['dimanche_depassement']=$Ventilations->dimanche_depassement;
                $newCrudData['lundi_depassement']=$Ventilations->lundi_depassement;
                $newCrudData['mardi_depassement']=$Ventilations->mardi_depassement;
                $newCrudData['mercredi_depassement']=$Ventilations->mercredi_depassement;
                $newCrudData['jeudi_depassement']=$Ventilations->jeudi_depassement;
                $newCrudData['vendredi_depassement']=$Ventilations->vendredi_depassement;
                $newCrudData['samedi_depassement']=$Ventilations->samedi_depassement;
                $newCrudData['dimanche_programmer']=$Ventilations->dimanche_programmer;
                $newCrudData['lundi_programmer']=$Ventilations->lundi_programmer;
                $newCrudData['mardi_programmer']=$Ventilations->mardi_programmer;
                $newCrudData['mercredi_programmer']=$Ventilations->mercredi_programmer;
                $newCrudData['jeudi_programmer']=$Ventilations->jeudi_programmer;
                $newCrudData['vendredi_programmer']=$Ventilations->vendredi_programmer;
                $newCrudData['samedi_programmer']=$Ventilations->samedi_programmer;
                $newCrudData['dimanche_retard']=$Ventilations->dimanche_retard;
                $newCrudData['lundi_retard']=$Ventilations->lundi_retard;
                $newCrudData['mardi_retard']=$Ventilations->mardi_retard;
                $newCrudData['mercredi_retard']=$Ventilations->mercredi_retard;
                $newCrudData['jeudi_retard']=$Ventilations->jeudi_retard;
                $newCrudData['vendredi_retard']=$Ventilations->vendredi_retard;
                $newCrudData['samedi_retard']=$Ventilations->samedi_retard;
                $newCrudData['programmation_id']=$Ventilations->programmation_id;
                $newCrudData['total_programmer']=$Ventilations->total_programmer;
                $newCrudData['total_colecter']=$Ventilations->total_colecter;
                $newCrudData['total_depassement']=$Ventilations->total_depassement;
                $newCrudData['hs15']=$Ventilations->hs15;
                $newCrudData['hs26']=$Ventilations->hs26;
                $newCrudData['hs55']=$Ventilations->hs55;
                $newCrudData['hs30']=$Ventilations->hs30;
                $newCrudData['hs60']=$Ventilations->hs60;
                $newCrudData['hs115']=$Ventilations->hs115;
                $newCrudData['hs130']=$Ventilations->hs130;
                $newCrudData['total']=$Ventilations->total;
                                $newCrudData['identifiants_sadge']=$Ventilations->identifiants_sadge;
                $newCrudData['creat_by']=$Ventilations->creat_by;
    
 try{ $newCrudData['programmation']=$Ventilations->programmation->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Ventilations->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Ventilations','entite_cle' => $Ventilations->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Ventilations->toArray();




try{

foreach ($Ventilations->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Ventilation $Ventilations)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des ventilations');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['user_id']=$Ventilations->user_id;
                $newCrudData['semaine']=$Ventilations->semaine;
                $newCrudData['dimanche_date']=$Ventilations->dimanche_date;
                $newCrudData['lundi_date']=$Ventilations->lundi_date;
                $newCrudData['mardi_date']=$Ventilations->mardi_date;
                $newCrudData['mercredi_date']=$Ventilations->mercredi_date;
                $newCrudData['jeudi_date']=$Ventilations->jeudi_date;
                $newCrudData['vendredi_date']=$Ventilations->vendredi_date;
                $newCrudData['samedi_date']=$Ventilations->samedi_date;
                $newCrudData['dimanche_horaire']=$Ventilations->dimanche_horaire;
                $newCrudData['lundi_horaire']=$Ventilations->lundi_horaire;
                $newCrudData['mardi_horaire']=$Ventilations->mardi_horaire;
                $newCrudData['mercredi_horaire']=$Ventilations->mercredi_horaire;
                $newCrudData['jeudi_horaire']=$Ventilations->jeudi_horaire;
                $newCrudData['vendredi_horaire']=$Ventilations->vendredi_horaire;
                $newCrudData['samedi_horaire']=$Ventilations->samedi_horaire;
                $newCrudData['dimanche']=$Ventilations->dimanche;
                $newCrudData['lundi']=$Ventilations->lundi;
                $newCrudData['mardi']=$Ventilations->mardi;
                $newCrudData['mercredi']=$Ventilations->mercredi;
                $newCrudData['jeudi']=$Ventilations->jeudi;
                $newCrudData['vendredi']=$Ventilations->vendredi;
                $newCrudData['samedi']=$Ventilations->samedi;
                $newCrudData['dimanche_pointage']=$Ventilations->dimanche_pointage;
                $newCrudData['lundi_pointage']=$Ventilations->lundi_pointage;
                $newCrudData['mardi_pointage']=$Ventilations->mardi_pointage;
                $newCrudData['mercredi_pointage']=$Ventilations->mercredi_pointage;
                $newCrudData['jeudi_pointage']=$Ventilations->jeudi_pointage;
                $newCrudData['vendredi_pointage']=$Ventilations->vendredi_pointage;
                $newCrudData['samedi_pointage']=$Ventilations->samedi_pointage;
                $newCrudData['dimanche_collecter']=$Ventilations->dimanche_collecter;
                $newCrudData['lundi_collecter']=$Ventilations->lundi_collecter;
                $newCrudData['mardi_collecter']=$Ventilations->mardi_collecter;
                $newCrudData['mercredi_collecter']=$Ventilations->mercredi_collecter;
                $newCrudData['jeudi_collecter']=$Ventilations->jeudi_collecter;
                $newCrudData['vendredi_collecter']=$Ventilations->vendredi_collecter;
                $newCrudData['samedi_collecter']=$Ventilations->samedi_collecter;
                $newCrudData['dimanche_depassement']=$Ventilations->dimanche_depassement;
                $newCrudData['lundi_depassement']=$Ventilations->lundi_depassement;
                $newCrudData['mardi_depassement']=$Ventilations->mardi_depassement;
                $newCrudData['mercredi_depassement']=$Ventilations->mercredi_depassement;
                $newCrudData['jeudi_depassement']=$Ventilations->jeudi_depassement;
                $newCrudData['vendredi_depassement']=$Ventilations->vendredi_depassement;
                $newCrudData['samedi_depassement']=$Ventilations->samedi_depassement;
                $newCrudData['dimanche_programmer']=$Ventilations->dimanche_programmer;
                $newCrudData['lundi_programmer']=$Ventilations->lundi_programmer;
                $newCrudData['mardi_programmer']=$Ventilations->mardi_programmer;
                $newCrudData['mercredi_programmer']=$Ventilations->mercredi_programmer;
                $newCrudData['jeudi_programmer']=$Ventilations->jeudi_programmer;
                $newCrudData['vendredi_programmer']=$Ventilations->vendredi_programmer;
                $newCrudData['samedi_programmer']=$Ventilations->samedi_programmer;
                $newCrudData['dimanche_retard']=$Ventilations->dimanche_retard;
                $newCrudData['lundi_retard']=$Ventilations->lundi_retard;
                $newCrudData['mardi_retard']=$Ventilations->mardi_retard;
                $newCrudData['mercredi_retard']=$Ventilations->mercredi_retard;
                $newCrudData['jeudi_retard']=$Ventilations->jeudi_retard;
                $newCrudData['vendredi_retard']=$Ventilations->vendredi_retard;
                $newCrudData['samedi_retard']=$Ventilations->samedi_retard;
                $newCrudData['programmation_id']=$Ventilations->programmation_id;
                $newCrudData['total_programmer']=$Ventilations->total_programmer;
                $newCrudData['total_colecter']=$Ventilations->total_colecter;
                $newCrudData['total_depassement']=$Ventilations->total_depassement;
                $newCrudData['hs15']=$Ventilations->hs15;
                $newCrudData['hs26']=$Ventilations->hs26;
                $newCrudData['hs55']=$Ventilations->hs55;
                $newCrudData['hs30']=$Ventilations->hs30;
                $newCrudData['hs60']=$Ventilations->hs60;
                $newCrudData['hs115']=$Ventilations->hs115;
                $newCrudData['hs130']=$Ventilations->hs130;
                $newCrudData['total']=$Ventilations->total;
                                $newCrudData['identifiants_sadge']=$Ventilations->identifiants_sadge;
                $newCrudData['creat_by']=$Ventilations->creat_by;
    
 try{ $newCrudData['programmation']=$Ventilations->programmation->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Ventilations->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Ventilations','entite_cle' => $Ventilations->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\VentilationExtras') &&
method_exists('\App\Http\Extras\VentilationExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\VentilationExtras::canDelete($request, $Ventilations);
}catch (\Throwable $e){

}

}



if($canSave){
$Ventilations->delete();
}else{
return response()->json($Ventilations, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\VentilationsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
