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
// use App\Repository\prod\ProgrammesrondesRepository;
use App\Models\Programmesronde;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Horaire;
                use App\Models\Poste;
                use App\Models\Programmationsronde;
                use App\Models\Programmationsuser;
        
class ProgrammesrondeController extends Controller
{

private $ProgrammesrondesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ProgrammesrondesRepository $ProgrammesrondesRepository
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
class_exists('\App\Http\Extras\ProgrammesrondeExtras') &&
method_exists('\App\Http\Extras\ProgrammesrondeExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ProgrammesrondeExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Programmesronde::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ProgrammesrondeExtras') &&
method_exists('\App\Http\Extras\ProgrammesrondeExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ProgrammesrondeExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('programmesrondes',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ProgrammesrondeExtras') &&
method_exists('\App\Http\Extras\ProgrammesrondeExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ProgrammesrondeExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  programmesrondes reussi',
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
return response()->json(Programmesronde::count());
}
$data = QueryBuilder::for(Programmesronde::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('debut_prevu'),

    
            AllowedFilter::exact('fin_prevu'),

    
            AllowedFilter::exact('debut_reel'),

    
            AllowedFilter::exact('debut_realise'),

    
            AllowedFilter::exact('fin_realise'),

    
            AllowedFilter::exact('volume_horaire'),

    
            AllowedFilter::exact('hs_base'),

    
            AllowedFilter::exact('hs_hors_faction'),

    
            AllowedFilter::exact('hs_in_faction'),

    
            AllowedFilter::exact('programmationsuser_id'),

    
            AllowedFilter::exact('horaire_id'),

    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('totalReel'),

    
            AllowedFilter::exact('totalFictif'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('remplacant'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('week'),

    
            AllowedFilter::exact('user'),

    
            AllowedFilter::exact('DayStatut'),

    
            AllowedFilter::exact('Remplacantuser'),

    
            AllowedFilter::exact('PresencesDeclarer'),

    
            AllowedFilter::exact('AbscencesDeclarer'),

    
            AllowedFilter::exact('EtatsDeclarer'),

    
            AllowedFilter::exact('Totalpresent'),

    
            AllowedFilter::exact('J1'),

    
            AllowedFilter::exact('J2'),

    
            AllowedFilter::exact('J3'),

    
            AllowedFilter::exact('J4'),

    
            AllowedFilter::exact('J5'),

    
            AllowedFilter::exact('J6'),

    
            AllowedFilter::exact('J7'),

    
            AllowedFilter::exact('J8'),

    
            AllowedFilter::exact('J9'),

    
            AllowedFilter::exact('J10'),

    
            AllowedFilter::exact('J11'),

    
            AllowedFilter::exact('J12'),

    
            AllowedFilter::exact('J13'),

    
            AllowedFilter::exact('J14'),

    
            AllowedFilter::exact('J15'),

    
            AllowedFilter::exact('J16'),

    
            AllowedFilter::exact('J17'),

    
            AllowedFilter::exact('J18'),

    
            AllowedFilter::exact('J19'),

    
            AllowedFilter::exact('J20'),

    
            AllowedFilter::exact('J21'),

    
            AllowedFilter::exact('J22'),

    
            AllowedFilter::exact('J23'),

    
            AllowedFilter::exact('J24'),

    
            AllowedFilter::exact('J25'),

    
            AllowedFilter::exact('J26'),

    
            AllowedFilter::exact('J27'),

    
            AllowedFilter::exact('J28'),

    
            AllowedFilter::exact('J29'),

    
            AllowedFilter::exact('J30'),

    
            AllowedFilter::exact('J31'),

    
            AllowedFilter::exact('deja_annaliser'),

    
            AllowedFilter::exact('pointages_rattacher_auto'),

    
            AllowedFilter::exact('pointages_rattacher_manuel'),

    
            AllowedFilter::exact('pointages_debut_auto'),

    
            AllowedFilter::exact('pointages_debut_manuel'),

    
            AllowedFilter::exact('pointages_fin_auto'),

    
            AllowedFilter::exact('pointages_fin_manuel'),

    
            AllowedFilter::exact('presence_declarer_auto'),

    
            AllowedFilter::exact('presence_declarer_manuel'),

    
            AllowedFilter::exact('programmationsronde_id'),

    
            AllowedFilter::exact('user_id'),

    
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

    
            AllowedSort::field('date'),

    
            AllowedSort::field('debut_prevu'),

    
            AllowedSort::field('fin_prevu'),

    
            AllowedSort::field('debut_reel'),

    
            AllowedSort::field('debut_realise'),

    
            AllowedSort::field('fin_realise'),

    
            AllowedSort::field('volume_horaire'),

    
            AllowedSort::field('hs_base'),

    
            AllowedSort::field('hs_hors_faction'),

    
            AllowedSort::field('hs_in_faction'),

    
            AllowedSort::field('programmationsuser_id'),

    
            AllowedSort::field('horaire_id'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('totalReel'),

    
            AllowedSort::field('totalFictif'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('remplacant'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('week'),

    
            AllowedSort::field('user'),

    
            AllowedSort::field('DayStatut'),

    
            AllowedSort::field('Remplacantuser'),

    
            AllowedSort::field('PresencesDeclarer'),

    
            AllowedSort::field('AbscencesDeclarer'),

    
            AllowedSort::field('EtatsDeclarer'),

    
            AllowedSort::field('Totalpresent'),

    
            AllowedSort::field('J1'),

    
            AllowedSort::field('J2'),

    
            AllowedSort::field('J3'),

    
            AllowedSort::field('J4'),

    
            AllowedSort::field('J5'),

    
            AllowedSort::field('J6'),

    
            AllowedSort::field('J7'),

    
            AllowedSort::field('J8'),

    
            AllowedSort::field('J9'),

    
            AllowedSort::field('J10'),

    
            AllowedSort::field('J11'),

    
            AllowedSort::field('J12'),

    
            AllowedSort::field('J13'),

    
            AllowedSort::field('J14'),

    
            AllowedSort::field('J15'),

    
            AllowedSort::field('J16'),

    
            AllowedSort::field('J17'),

    
            AllowedSort::field('J18'),

    
            AllowedSort::field('J19'),

    
            AllowedSort::field('J20'),

    
            AllowedSort::field('J21'),

    
            AllowedSort::field('J22'),

    
            AllowedSort::field('J23'),

    
            AllowedSort::field('J24'),

    
            AllowedSort::field('J25'),

    
            AllowedSort::field('J26'),

    
            AllowedSort::field('J27'),

    
            AllowedSort::field('J28'),

    
            AllowedSort::field('J29'),

    
            AllowedSort::field('J30'),

    
            AllowedSort::field('J31'),

    
            AllowedSort::field('deja_annaliser'),

    
            AllowedSort::field('pointages_rattacher_auto'),

    
            AllowedSort::field('pointages_rattacher_manuel'),

    
            AllowedSort::field('pointages_debut_auto'),

    
            AllowedSort::field('pointages_debut_manuel'),

    
            AllowedSort::field('pointages_fin_auto'),

    
            AllowedSort::field('pointages_fin_manuel'),

    
            AllowedSort::field('presence_declarer_auto'),

    
            AllowedSort::field('presence_declarer_manuel'),

    
            AllowedSort::field('programmationsronde_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
])
    
    
    
    
    
->allowedIncludes([

            'horaire',
        

                'poste',
        

                'programmationsronde',
        

                'programmationsuser',
        

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




$data = QueryBuilder::for(Programmesronde::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('debut_prevu'),

    
            AllowedFilter::exact('fin_prevu'),

    
            AllowedFilter::exact('debut_reel'),

    
            AllowedFilter::exact('debut_realise'),

    
            AllowedFilter::exact('fin_realise'),

    
            AllowedFilter::exact('volume_horaire'),

    
            AllowedFilter::exact('hs_base'),

    
            AllowedFilter::exact('hs_hors_faction'),

    
            AllowedFilter::exact('hs_in_faction'),

    
            AllowedFilter::exact('programmationsuser_id'),

    
            AllowedFilter::exact('horaire_id'),

    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('totalReel'),

    
            AllowedFilter::exact('totalFictif'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('remplacant'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('week'),

    
            AllowedFilter::exact('user'),

    
            AllowedFilter::exact('DayStatut'),

    
            AllowedFilter::exact('Remplacantuser'),

    
            AllowedFilter::exact('PresencesDeclarer'),

    
            AllowedFilter::exact('AbscencesDeclarer'),

    
            AllowedFilter::exact('EtatsDeclarer'),

    
            AllowedFilter::exact('Totalpresent'),

    
            AllowedFilter::exact('J1'),

    
            AllowedFilter::exact('J2'),

    
            AllowedFilter::exact('J3'),

    
            AllowedFilter::exact('J4'),

    
            AllowedFilter::exact('J5'),

    
            AllowedFilter::exact('J6'),

    
            AllowedFilter::exact('J7'),

    
            AllowedFilter::exact('J8'),

    
            AllowedFilter::exact('J9'),

    
            AllowedFilter::exact('J10'),

    
            AllowedFilter::exact('J11'),

    
            AllowedFilter::exact('J12'),

    
            AllowedFilter::exact('J13'),

    
            AllowedFilter::exact('J14'),

    
            AllowedFilter::exact('J15'),

    
            AllowedFilter::exact('J16'),

    
            AllowedFilter::exact('J17'),

    
            AllowedFilter::exact('J18'),

    
            AllowedFilter::exact('J19'),

    
            AllowedFilter::exact('J20'),

    
            AllowedFilter::exact('J21'),

    
            AllowedFilter::exact('J22'),

    
            AllowedFilter::exact('J23'),

    
            AllowedFilter::exact('J24'),

    
            AllowedFilter::exact('J25'),

    
            AllowedFilter::exact('J26'),

    
            AllowedFilter::exact('J27'),

    
            AllowedFilter::exact('J28'),

    
            AllowedFilter::exact('J29'),

    
            AllowedFilter::exact('J30'),

    
            AllowedFilter::exact('J31'),

    
            AllowedFilter::exact('deja_annaliser'),

    
            AllowedFilter::exact('pointages_rattacher_auto'),

    
            AllowedFilter::exact('pointages_rattacher_manuel'),

    
            AllowedFilter::exact('pointages_debut_auto'),

    
            AllowedFilter::exact('pointages_debut_manuel'),

    
            AllowedFilter::exact('pointages_fin_auto'),

    
            AllowedFilter::exact('pointages_fin_manuel'),

    
            AllowedFilter::exact('presence_declarer_auto'),

    
            AllowedFilter::exact('presence_declarer_manuel'),

    
            AllowedFilter::exact('programmationsronde_id'),

    
            AllowedFilter::exact('user_id'),

    
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

    
            AllowedSort::field('date'),

    
            AllowedSort::field('debut_prevu'),

    
            AllowedSort::field('fin_prevu'),

    
            AllowedSort::field('debut_reel'),

    
            AllowedSort::field('debut_realise'),

    
            AllowedSort::field('fin_realise'),

    
            AllowedSort::field('volume_horaire'),

    
            AllowedSort::field('hs_base'),

    
            AllowedSort::field('hs_hors_faction'),

    
            AllowedSort::field('hs_in_faction'),

    
            AllowedSort::field('programmationsuser_id'),

    
            AllowedSort::field('horaire_id'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('totalReel'),

    
            AllowedSort::field('totalFictif'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('remplacant'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('week'),

    
            AllowedSort::field('user'),

    
            AllowedSort::field('DayStatut'),

    
            AllowedSort::field('Remplacantuser'),

    
            AllowedSort::field('PresencesDeclarer'),

    
            AllowedSort::field('AbscencesDeclarer'),

    
            AllowedSort::field('EtatsDeclarer'),

    
            AllowedSort::field('Totalpresent'),

    
            AllowedSort::field('J1'),

    
            AllowedSort::field('J2'),

    
            AllowedSort::field('J3'),

    
            AllowedSort::field('J4'),

    
            AllowedSort::field('J5'),

    
            AllowedSort::field('J6'),

    
            AllowedSort::field('J7'),

    
            AllowedSort::field('J8'),

    
            AllowedSort::field('J9'),

    
            AllowedSort::field('J10'),

    
            AllowedSort::field('J11'),

    
            AllowedSort::field('J12'),

    
            AllowedSort::field('J13'),

    
            AllowedSort::field('J14'),

    
            AllowedSort::field('J15'),

    
            AllowedSort::field('J16'),

    
            AllowedSort::field('J17'),

    
            AllowedSort::field('J18'),

    
            AllowedSort::field('J19'),

    
            AllowedSort::field('J20'),

    
            AllowedSort::field('J21'),

    
            AllowedSort::field('J22'),

    
            AllowedSort::field('J23'),

    
            AllowedSort::field('J24'),

    
            AllowedSort::field('J25'),

    
            AllowedSort::field('J26'),

    
            AllowedSort::field('J27'),

    
            AllowedSort::field('J28'),

    
            AllowedSort::field('J29'),

    
            AllowedSort::field('J30'),

    
            AllowedSort::field('J31'),

    
            AllowedSort::field('deja_annaliser'),

    
            AllowedSort::field('pointages_rattacher_auto'),

    
            AllowedSort::field('pointages_rattacher_manuel'),

    
            AllowedSort::field('pointages_debut_auto'),

    
            AllowedSort::field('pointages_debut_manuel'),

    
            AllowedSort::field('pointages_fin_auto'),

    
            AllowedSort::field('pointages_fin_manuel'),

    
            AllowedSort::field('presence_declarer_auto'),

    
            AllowedSort::field('presence_declarer_manuel'),

    
            AllowedSort::field('programmationsronde_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
])
    
    
    
    
    
->allowedIncludes([
            'horaire',
        

                'poste',
        

                'programmationsronde',
        

                'programmationsuser',
        

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



public function create(Request $request, Programmesronde $Programmesrondes)
{


try{
$can=\App\Helpers\Helpers::can('Creer des programmesrondes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "programmesrondes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'date',
    'debut_prevu',
    'fin_prevu',
    'debut_reel',
    'debut_realise',
    'fin_realise',
    'volume_horaire',
    'hs_base',
    'hs_hors_faction',
    'hs_in_faction',
    'programmationsuser_id',
    'horaire_id',
    'etats',
    'totalReel',
    'totalFictif',
    'poste_id',
    'remplacant',
    'type',
    'week',
    'user',
    'DayStatut',
    'Remplacantuser',
    'PresencesDeclarer',
    'AbscencesDeclarer',
    'EtatsDeclarer',
    'Totalpresent',
    'J1',
    'J2',
    'J3',
    'J4',
    'J5',
    'J6',
    'J7',
    'J8',
    'J9',
    'J10',
    'J11',
    'J12',
    'J13',
    'J14',
    'J15',
    'J16',
    'J17',
    'J18',
    'J19',
    'J20',
    'J21',
    'J22',
    'J23',
    'J24',
    'J25',
    'J26',
    'J27',
    'J28',
    'J29',
    'J30',
    'J31',
    'deja_annaliser',
    'pointages_rattacher_auto',
    'pointages_rattacher_manuel',
    'pointages_debut_auto',
    'pointages_debut_manuel',
    'pointages_fin_auto',
    'pointages_fin_manuel',
    'presence_declarer_auto',
    'presence_declarer_manuel',
    'programmationsronde_id',
    'user_id',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'date' => [
            //'required'
            ],
        
    
    
                    'debut_prevu' => [
            //'required'
            ],
        
    
    
                    'fin_prevu' => [
            //'required'
            ],
        
    
    
                    'debut_reel' => [
            //'required'
            ],
        
    
    
                    'debut_realise' => [
            //'required'
            ],
        
    
    
                    'fin_realise' => [
            //'required'
            ],
        
    
    
                    'volume_horaire' => [
            //'required'
            ],
        
    
    
                    'hs_base' => [
            //'required'
            ],
        
    
    
                    'hs_hors_faction' => [
            //'required'
            ],
        
    
    
                    'hs_in_faction' => [
            //'required'
            ],
        
    
    
                    'programmationsuser_id' => [
            //'required'
            ],
        
    
    
                    'horaire_id' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'totalReel' => [
            //'required'
            ],
        
    
    
                    'totalFictif' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'remplacant' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'week' => [
            //'required'
            ],
        
    
    
                    'user' => [
            //'required'
            ],
        
    
    
                    'DayStatut' => [
            //'required'
            ],
        
    
    
                    'Remplacantuser' => [
            //'required'
            ],
        
    
    
                    'PresencesDeclarer' => [
            //'required'
            ],
        
    
    
                    'AbscencesDeclarer' => [
            //'required'
            ],
        
    
    
                    'EtatsDeclarer' => [
            //'required'
            ],
        
    
    
                    'Totalpresent' => [
            //'required'
            ],
        
    
    
                    'J1' => [
            //'required'
            ],
        
    
    
                    'J2' => [
            //'required'
            ],
        
    
    
                    'J3' => [
            //'required'
            ],
        
    
    
                    'J4' => [
            //'required'
            ],
        
    
    
                    'J5' => [
            //'required'
            ],
        
    
    
                    'J6' => [
            //'required'
            ],
        
    
    
                    'J7' => [
            //'required'
            ],
        
    
    
                    'J8' => [
            //'required'
            ],
        
    
    
                    'J9' => [
            //'required'
            ],
        
    
    
                    'J10' => [
            //'required'
            ],
        
    
    
                    'J11' => [
            //'required'
            ],
        
    
    
                    'J12' => [
            //'required'
            ],
        
    
    
                    'J13' => [
            //'required'
            ],
        
    
    
                    'J14' => [
            //'required'
            ],
        
    
    
                    'J15' => [
            //'required'
            ],
        
    
    
                    'J16' => [
            //'required'
            ],
        
    
    
                    'J17' => [
            //'required'
            ],
        
    
    
                    'J18' => [
            //'required'
            ],
        
    
    
                    'J19' => [
            //'required'
            ],
        
    
    
                    'J20' => [
            //'required'
            ],
        
    
    
                    'J21' => [
            //'required'
            ],
        
    
    
                    'J22' => [
            //'required'
            ],
        
    
    
                    'J23' => [
            //'required'
            ],
        
    
    
                    'J24' => [
            //'required'
            ],
        
    
    
                    'J25' => [
            //'required'
            ],
        
    
    
                    'J26' => [
            //'required'
            ],
        
    
    
                    'J27' => [
            //'required'
            ],
        
    
    
                    'J28' => [
            //'required'
            ],
        
    
    
                    'J29' => [
            //'required'
            ],
        
    
    
                    'J30' => [
            //'required'
            ],
        
    
    
                    'J31' => [
            //'required'
            ],
        
    
    
                    'deja_annaliser' => [
            //'required'
            ],
        
    
    
                    'pointages_rattacher_auto' => [
            //'required'
            ],
        
    
    
                    'pointages_rattacher_manuel' => [
            //'required'
            ],
        
    
    
                    'pointages_debut_auto' => [
            //'required'
            ],
        
    
    
                    'pointages_debut_manuel' => [
            //'required'
            ],
        
    
    
                    'pointages_fin_auto' => [
            //'required'
            ],
        
    
    
                    'pointages_fin_manuel' => [
            //'required'
            ],
        
    
    
                    'presence_declarer_auto' => [
            //'required'
            ],
        
    
    
                    'presence_declarer_manuel' => [
            //'required'
            ],
        
    
    
                    'programmationsronde_id' => [
            //'required'
            ],
        
    
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    


], $messages = [

    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'debut_prevu' => ['cette donnee est obligatoire'],

    
    
        'fin_prevu' => ['cette donnee est obligatoire'],

    
    
        'debut_reel' => ['cette donnee est obligatoire'],

    
    
        'debut_realise' => ['cette donnee est obligatoire'],

    
    
        'fin_realise' => ['cette donnee est obligatoire'],

    
    
        'volume_horaire' => ['cette donnee est obligatoire'],

    
    
        'hs_base' => ['cette donnee est obligatoire'],

    
    
        'hs_hors_faction' => ['cette donnee est obligatoire'],

    
    
        'hs_in_faction' => ['cette donnee est obligatoire'],

    
    
        'programmationsuser_id' => ['cette donnee est obligatoire'],

    
    
        'horaire_id' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'totalReel' => ['cette donnee est obligatoire'],

    
    
        'totalFictif' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'remplacant' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'week' => ['cette donnee est obligatoire'],

    
    
        'user' => ['cette donnee est obligatoire'],

    
    
        'DayStatut' => ['cette donnee est obligatoire'],

    
    
        'Remplacantuser' => ['cette donnee est obligatoire'],

    
    
        'PresencesDeclarer' => ['cette donnee est obligatoire'],

    
    
        'AbscencesDeclarer' => ['cette donnee est obligatoire'],

    
    
        'EtatsDeclarer' => ['cette donnee est obligatoire'],

    
    
        'Totalpresent' => ['cette donnee est obligatoire'],

    
    
        'J1' => ['cette donnee est obligatoire'],

    
    
        'J2' => ['cette donnee est obligatoire'],

    
    
        'J3' => ['cette donnee est obligatoire'],

    
    
        'J4' => ['cette donnee est obligatoire'],

    
    
        'J5' => ['cette donnee est obligatoire'],

    
    
        'J6' => ['cette donnee est obligatoire'],

    
    
        'J7' => ['cette donnee est obligatoire'],

    
    
        'J8' => ['cette donnee est obligatoire'],

    
    
        'J9' => ['cette donnee est obligatoire'],

    
    
        'J10' => ['cette donnee est obligatoire'],

    
    
        'J11' => ['cette donnee est obligatoire'],

    
    
        'J12' => ['cette donnee est obligatoire'],

    
    
        'J13' => ['cette donnee est obligatoire'],

    
    
        'J14' => ['cette donnee est obligatoire'],

    
    
        'J15' => ['cette donnee est obligatoire'],

    
    
        'J16' => ['cette donnee est obligatoire'],

    
    
        'J17' => ['cette donnee est obligatoire'],

    
    
        'J18' => ['cette donnee est obligatoire'],

    
    
        'J19' => ['cette donnee est obligatoire'],

    
    
        'J20' => ['cette donnee est obligatoire'],

    
    
        'J21' => ['cette donnee est obligatoire'],

    
    
        'J22' => ['cette donnee est obligatoire'],

    
    
        'J23' => ['cette donnee est obligatoire'],

    
    
        'J24' => ['cette donnee est obligatoire'],

    
    
        'J25' => ['cette donnee est obligatoire'],

    
    
        'J26' => ['cette donnee est obligatoire'],

    
    
        'J27' => ['cette donnee est obligatoire'],

    
    
        'J28' => ['cette donnee est obligatoire'],

    
    
        'J29' => ['cette donnee est obligatoire'],

    
    
        'J30' => ['cette donnee est obligatoire'],

    
    
        'J31' => ['cette donnee est obligatoire'],

    
    
        'deja_annaliser' => ['cette donnee est obligatoire'],

    
    
        'pointages_rattacher_auto' => ['cette donnee est obligatoire'],

    
    
        'pointages_rattacher_manuel' => ['cette donnee est obligatoire'],

    
    
        'pointages_debut_auto' => ['cette donnee est obligatoire'],

    
    
        'pointages_debut_manuel' => ['cette donnee est obligatoire'],

    
    
        'pointages_fin_auto' => ['cette donnee est obligatoire'],

    
    
        'pointages_fin_manuel' => ['cette donnee est obligatoire'],

    
    
        'presence_declarer_auto' => ['cette donnee est obligatoire'],

    
    
        'presence_declarer_manuel' => ['cette donnee est obligatoire'],

    
    
        'programmationsronde_id' => ['cette donnee est obligatoire'],

    
    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['date'])){
        
            $Programmesrondes->date = $data['date'];
        
        }



    







    

        if(!empty($data['debut_prevu'])){
        
            $Programmesrondes->debut_prevu = $data['debut_prevu'];
        
        }



    







    

        if(!empty($data['fin_prevu'])){
        
            $Programmesrondes->fin_prevu = $data['fin_prevu'];
        
        }



    







    

        if(!empty($data['debut_reel'])){
        
            $Programmesrondes->debut_reel = $data['debut_reel'];
        
        }



    







    

        if(!empty($data['debut_realise'])){
        
            $Programmesrondes->debut_realise = $data['debut_realise'];
        
        }



    







    

        if(!empty($data['fin_realise'])){
        
            $Programmesrondes->fin_realise = $data['fin_realise'];
        
        }



    







    

        if(!empty($data['volume_horaire'])){
        
            $Programmesrondes->volume_horaire = $data['volume_horaire'];
        
        }



    







    

        if(!empty($data['hs_base'])){
        
            $Programmesrondes->hs_base = $data['hs_base'];
        
        }



    







    

        if(!empty($data['hs_hors_faction'])){
        
            $Programmesrondes->hs_hors_faction = $data['hs_hors_faction'];
        
        }



    







    

        if(!empty($data['hs_in_faction'])){
        
            $Programmesrondes->hs_in_faction = $data['hs_in_faction'];
        
        }



    







    

        if(!empty($data['programmationsuser_id'])){
        
            $Programmesrondes->programmationsuser_id = $data['programmationsuser_id'];
        
        }



    







    

        if(!empty($data['horaire_id'])){
        
            $Programmesrondes->horaire_id = $data['horaire_id'];
        
        }



    







    

        if(!empty($data['etats'])){
        
            $Programmesrondes->etats = $data['etats'];
        
        }



    







    

        if(!empty($data['totalReel'])){
        
            $Programmesrondes->totalReel = $data['totalReel'];
        
        }



    







    

        if(!empty($data['totalFictif'])){
        
            $Programmesrondes->totalFictif = $data['totalFictif'];
        
        }



    







    

        if(!empty($data['poste_id'])){
        
            $Programmesrondes->poste_id = $data['poste_id'];
        
        }



    







    

        if(!empty($data['remplacant'])){
        
            $Programmesrondes->remplacant = $data['remplacant'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Programmesrondes->type = $data['type'];
        
        }



    







    

        if(!empty($data['week'])){
        
            $Programmesrondes->week = $data['week'];
        
        }



    







    

        if(!empty($data['user'])){
        
            $Programmesrondes->user = $data['user'];
        
        }



    







    

        if(!empty($data['DayStatut'])){
        
            $Programmesrondes->DayStatut = $data['DayStatut'];
        
        }



    







    

        if(!empty($data['Remplacantuser'])){
        
            $Programmesrondes->Remplacantuser = $data['Remplacantuser'];
        
        }



    







    

        if(!empty($data['PresencesDeclarer'])){
        
            $Programmesrondes->PresencesDeclarer = $data['PresencesDeclarer'];
        
        }



    







    

        if(!empty($data['AbscencesDeclarer'])){
        
            $Programmesrondes->AbscencesDeclarer = $data['AbscencesDeclarer'];
        
        }



    







    

        if(!empty($data['EtatsDeclarer'])){
        
            $Programmesrondes->EtatsDeclarer = $data['EtatsDeclarer'];
        
        }



    







    

        if(!empty($data['Totalpresent'])){
        
            $Programmesrondes->Totalpresent = $data['Totalpresent'];
        
        }



    







    

        if(!empty($data['J1'])){
        
            $Programmesrondes->J1 = $data['J1'];
        
        }



    







    

        if(!empty($data['J2'])){
        
            $Programmesrondes->J2 = $data['J2'];
        
        }



    







    

        if(!empty($data['J3'])){
        
            $Programmesrondes->J3 = $data['J3'];
        
        }



    







    

        if(!empty($data['J4'])){
        
            $Programmesrondes->J4 = $data['J4'];
        
        }



    







    

        if(!empty($data['J5'])){
        
            $Programmesrondes->J5 = $data['J5'];
        
        }



    







    

        if(!empty($data['J6'])){
        
            $Programmesrondes->J6 = $data['J6'];
        
        }



    







    

        if(!empty($data['J7'])){
        
            $Programmesrondes->J7 = $data['J7'];
        
        }



    







    

        if(!empty($data['J8'])){
        
            $Programmesrondes->J8 = $data['J8'];
        
        }



    







    

        if(!empty($data['J9'])){
        
            $Programmesrondes->J9 = $data['J9'];
        
        }



    







    

        if(!empty($data['J10'])){
        
            $Programmesrondes->J10 = $data['J10'];
        
        }



    







    

        if(!empty($data['J11'])){
        
            $Programmesrondes->J11 = $data['J11'];
        
        }



    







    

        if(!empty($data['J12'])){
        
            $Programmesrondes->J12 = $data['J12'];
        
        }



    







    

        if(!empty($data['J13'])){
        
            $Programmesrondes->J13 = $data['J13'];
        
        }



    







    

        if(!empty($data['J14'])){
        
            $Programmesrondes->J14 = $data['J14'];
        
        }



    







    

        if(!empty($data['J15'])){
        
            $Programmesrondes->J15 = $data['J15'];
        
        }



    







    

        if(!empty($data['J16'])){
        
            $Programmesrondes->J16 = $data['J16'];
        
        }



    







    

        if(!empty($data['J17'])){
        
            $Programmesrondes->J17 = $data['J17'];
        
        }



    







    

        if(!empty($data['J18'])){
        
            $Programmesrondes->J18 = $data['J18'];
        
        }



    







    

        if(!empty($data['J19'])){
        
            $Programmesrondes->J19 = $data['J19'];
        
        }



    







    

        if(!empty($data['J20'])){
        
            $Programmesrondes->J20 = $data['J20'];
        
        }



    







    

        if(!empty($data['J21'])){
        
            $Programmesrondes->J21 = $data['J21'];
        
        }



    







    

        if(!empty($data['J22'])){
        
            $Programmesrondes->J22 = $data['J22'];
        
        }



    







    

        if(!empty($data['J23'])){
        
            $Programmesrondes->J23 = $data['J23'];
        
        }



    







    

        if(!empty($data['J24'])){
        
            $Programmesrondes->J24 = $data['J24'];
        
        }



    







    

        if(!empty($data['J25'])){
        
            $Programmesrondes->J25 = $data['J25'];
        
        }



    







    

        if(!empty($data['J26'])){
        
            $Programmesrondes->J26 = $data['J26'];
        
        }



    







    

        if(!empty($data['J27'])){
        
            $Programmesrondes->J27 = $data['J27'];
        
        }



    







    

        if(!empty($data['J28'])){
        
            $Programmesrondes->J28 = $data['J28'];
        
        }



    







    

        if(!empty($data['J29'])){
        
            $Programmesrondes->J29 = $data['J29'];
        
        }



    







    

        if(!empty($data['J30'])){
        
            $Programmesrondes->J30 = $data['J30'];
        
        }



    







    

        if(!empty($data['J31'])){
        
            $Programmesrondes->J31 = $data['J31'];
        
        }



    







    

        if(!empty($data['deja_annaliser'])){
        
            $Programmesrondes->deja_annaliser = $data['deja_annaliser'];
        
        }



    







    

        if(!empty($data['pointages_rattacher_auto'])){
        
            $Programmesrondes->pointages_rattacher_auto = $data['pointages_rattacher_auto'];
        
        }



    







    

        if(!empty($data['pointages_rattacher_manuel'])){
        
            $Programmesrondes->pointages_rattacher_manuel = $data['pointages_rattacher_manuel'];
        
        }



    







    

        if(!empty($data['pointages_debut_auto'])){
        
            $Programmesrondes->pointages_debut_auto = $data['pointages_debut_auto'];
        
        }



    







    

        if(!empty($data['pointages_debut_manuel'])){
        
            $Programmesrondes->pointages_debut_manuel = $data['pointages_debut_manuel'];
        
        }



    







    

        if(!empty($data['pointages_fin_auto'])){
        
            $Programmesrondes->pointages_fin_auto = $data['pointages_fin_auto'];
        
        }



    







    

        if(!empty($data['pointages_fin_manuel'])){
        
            $Programmesrondes->pointages_fin_manuel = $data['pointages_fin_manuel'];
        
        }



    







    

        if(!empty($data['presence_declarer_auto'])){
        
            $Programmesrondes->presence_declarer_auto = $data['presence_declarer_auto'];
        
        }



    







    

        if(!empty($data['presence_declarer_manuel'])){
        
            $Programmesrondes->presence_declarer_manuel = $data['presence_declarer_manuel'];
        
        }



    







    

        if(!empty($data['programmationsronde_id'])){
        
            $Programmesrondes->programmationsronde_id = $data['programmationsronde_id'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Programmesrondes->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Programmesrondes->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Programmesrondes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ProgrammesrondeExtras') &&
method_exists('\App\Http\Extras\ProgrammesrondeExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ProgrammesrondeExtras::beforeSaveCreate($request,$Programmesrondes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ProgrammesrondeExtras') &&
method_exists('\App\Http\Extras\ProgrammesrondeExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ProgrammesrondeExtras::canCreate($request, $Programmesrondes);
}catch (\Throwable $e){

}

}


if($canSave){
$Programmesrondes->save();
}else{
return response()->json($Programmesrondes, 200);
}

$Programmesrondes=Programmesronde::find($Programmesrondes->id);
$newCrudData=[];

                $newCrudData['date']=$Programmesrondes->date;
                $newCrudData['debut_prevu']=$Programmesrondes->debut_prevu;
                $newCrudData['fin_prevu']=$Programmesrondes->fin_prevu;
                $newCrudData['debut_reel']=$Programmesrondes->debut_reel;
                $newCrudData['debut_realise']=$Programmesrondes->debut_realise;
                $newCrudData['fin_realise']=$Programmesrondes->fin_realise;
                $newCrudData['volume_horaire']=$Programmesrondes->volume_horaire;
                $newCrudData['hs_base']=$Programmesrondes->hs_base;
                $newCrudData['hs_hors_faction']=$Programmesrondes->hs_hors_faction;
                $newCrudData['hs_in_faction']=$Programmesrondes->hs_in_faction;
                $newCrudData['programmationsuser_id']=$Programmesrondes->programmationsuser_id;
                $newCrudData['horaire_id']=$Programmesrondes->horaire_id;
                $newCrudData['etats']=$Programmesrondes->etats;
                $newCrudData['totalReel']=$Programmesrondes->totalReel;
                $newCrudData['totalFictif']=$Programmesrondes->totalFictif;
                $newCrudData['poste_id']=$Programmesrondes->poste_id;
                $newCrudData['remplacant']=$Programmesrondes->remplacant;
                $newCrudData['type']=$Programmesrondes->type;
                $newCrudData['week']=$Programmesrondes->week;
                $newCrudData['user']=$Programmesrondes->user;
                $newCrudData['DayStatut']=$Programmesrondes->DayStatut;
                $newCrudData['Remplacantuser']=$Programmesrondes->Remplacantuser;
                $newCrudData['PresencesDeclarer']=$Programmesrondes->PresencesDeclarer;
                $newCrudData['AbscencesDeclarer']=$Programmesrondes->AbscencesDeclarer;
                $newCrudData['EtatsDeclarer']=$Programmesrondes->EtatsDeclarer;
                $newCrudData['Totalpresent']=$Programmesrondes->Totalpresent;
                $newCrudData['J1']=$Programmesrondes->J1;
                $newCrudData['J2']=$Programmesrondes->J2;
                $newCrudData['J3']=$Programmesrondes->J3;
                $newCrudData['J4']=$Programmesrondes->J4;
                $newCrudData['J5']=$Programmesrondes->J5;
                $newCrudData['J6']=$Programmesrondes->J6;
                $newCrudData['J7']=$Programmesrondes->J7;
                $newCrudData['J8']=$Programmesrondes->J8;
                $newCrudData['J9']=$Programmesrondes->J9;
                $newCrudData['J10']=$Programmesrondes->J10;
                $newCrudData['J11']=$Programmesrondes->J11;
                $newCrudData['J12']=$Programmesrondes->J12;
                $newCrudData['J13']=$Programmesrondes->J13;
                $newCrudData['J14']=$Programmesrondes->J14;
                $newCrudData['J15']=$Programmesrondes->J15;
                $newCrudData['J16']=$Programmesrondes->J16;
                $newCrudData['J17']=$Programmesrondes->J17;
                $newCrudData['J18']=$Programmesrondes->J18;
                $newCrudData['J19']=$Programmesrondes->J19;
                $newCrudData['J20']=$Programmesrondes->J20;
                $newCrudData['J21']=$Programmesrondes->J21;
                $newCrudData['J22']=$Programmesrondes->J22;
                $newCrudData['J23']=$Programmesrondes->J23;
                $newCrudData['J24']=$Programmesrondes->J24;
                $newCrudData['J25']=$Programmesrondes->J25;
                $newCrudData['J26']=$Programmesrondes->J26;
                $newCrudData['J27']=$Programmesrondes->J27;
                $newCrudData['J28']=$Programmesrondes->J28;
                $newCrudData['J29']=$Programmesrondes->J29;
                $newCrudData['J30']=$Programmesrondes->J30;
                $newCrudData['J31']=$Programmesrondes->J31;
                $newCrudData['deja_annaliser']=$Programmesrondes->deja_annaliser;
                $newCrudData['pointages_rattacher_auto']=$Programmesrondes->pointages_rattacher_auto;
                $newCrudData['pointages_rattacher_manuel']=$Programmesrondes->pointages_rattacher_manuel;
                $newCrudData['pointages_debut_auto']=$Programmesrondes->pointages_debut_auto;
                $newCrudData['pointages_debut_manuel']=$Programmesrondes->pointages_debut_manuel;
                $newCrudData['pointages_fin_auto']=$Programmesrondes->pointages_fin_auto;
                $newCrudData['pointages_fin_manuel']=$Programmesrondes->pointages_fin_manuel;
                $newCrudData['presence_declarer_auto']=$Programmesrondes->presence_declarer_auto;
                $newCrudData['presence_declarer_manuel']=$Programmesrondes->presence_declarer_manuel;
                $newCrudData['programmationsronde_id']=$Programmesrondes->programmationsronde_id;
                $newCrudData['user_id']=$Programmesrondes->user_id;
                $newCrudData['creat_by']=$Programmesrondes->creat_by;
                    
 try{ $newCrudData['horaire']=$Programmesrondes->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Programmesrondes->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['programmationsronde']=$Programmesrondes->programmationsronde->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['programmationsuser']=$Programmesrondes->programmationsuser->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Programmesrondes->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Programmesrondes','entite_cle' => $Programmesrondes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Programmesrondes->toArray();




try{

foreach ($Programmesrondes->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Programmesronde $Programmesrondes)
{
try{
$can=\App\Helpers\Helpers::can('Editer des programmesrondes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['date']=$Programmesrondes->date;
                $oldCrudData['debut_prevu']=$Programmesrondes->debut_prevu;
                $oldCrudData['fin_prevu']=$Programmesrondes->fin_prevu;
                $oldCrudData['debut_reel']=$Programmesrondes->debut_reel;
                $oldCrudData['debut_realise']=$Programmesrondes->debut_realise;
                $oldCrudData['fin_realise']=$Programmesrondes->fin_realise;
                $oldCrudData['volume_horaire']=$Programmesrondes->volume_horaire;
                $oldCrudData['hs_base']=$Programmesrondes->hs_base;
                $oldCrudData['hs_hors_faction']=$Programmesrondes->hs_hors_faction;
                $oldCrudData['hs_in_faction']=$Programmesrondes->hs_in_faction;
                $oldCrudData['programmationsuser_id']=$Programmesrondes->programmationsuser_id;
                $oldCrudData['horaire_id']=$Programmesrondes->horaire_id;
                $oldCrudData['etats']=$Programmesrondes->etats;
                $oldCrudData['totalReel']=$Programmesrondes->totalReel;
                $oldCrudData['totalFictif']=$Programmesrondes->totalFictif;
                $oldCrudData['poste_id']=$Programmesrondes->poste_id;
                $oldCrudData['remplacant']=$Programmesrondes->remplacant;
                $oldCrudData['type']=$Programmesrondes->type;
                $oldCrudData['week']=$Programmesrondes->week;
                $oldCrudData['user']=$Programmesrondes->user;
                $oldCrudData['DayStatut']=$Programmesrondes->DayStatut;
                $oldCrudData['Remplacantuser']=$Programmesrondes->Remplacantuser;
                $oldCrudData['PresencesDeclarer']=$Programmesrondes->PresencesDeclarer;
                $oldCrudData['AbscencesDeclarer']=$Programmesrondes->AbscencesDeclarer;
                $oldCrudData['EtatsDeclarer']=$Programmesrondes->EtatsDeclarer;
                $oldCrudData['Totalpresent']=$Programmesrondes->Totalpresent;
                $oldCrudData['J1']=$Programmesrondes->J1;
                $oldCrudData['J2']=$Programmesrondes->J2;
                $oldCrudData['J3']=$Programmesrondes->J3;
                $oldCrudData['J4']=$Programmesrondes->J4;
                $oldCrudData['J5']=$Programmesrondes->J5;
                $oldCrudData['J6']=$Programmesrondes->J6;
                $oldCrudData['J7']=$Programmesrondes->J7;
                $oldCrudData['J8']=$Programmesrondes->J8;
                $oldCrudData['J9']=$Programmesrondes->J9;
                $oldCrudData['J10']=$Programmesrondes->J10;
                $oldCrudData['J11']=$Programmesrondes->J11;
                $oldCrudData['J12']=$Programmesrondes->J12;
                $oldCrudData['J13']=$Programmesrondes->J13;
                $oldCrudData['J14']=$Programmesrondes->J14;
                $oldCrudData['J15']=$Programmesrondes->J15;
                $oldCrudData['J16']=$Programmesrondes->J16;
                $oldCrudData['J17']=$Programmesrondes->J17;
                $oldCrudData['J18']=$Programmesrondes->J18;
                $oldCrudData['J19']=$Programmesrondes->J19;
                $oldCrudData['J20']=$Programmesrondes->J20;
                $oldCrudData['J21']=$Programmesrondes->J21;
                $oldCrudData['J22']=$Programmesrondes->J22;
                $oldCrudData['J23']=$Programmesrondes->J23;
                $oldCrudData['J24']=$Programmesrondes->J24;
                $oldCrudData['J25']=$Programmesrondes->J25;
                $oldCrudData['J26']=$Programmesrondes->J26;
                $oldCrudData['J27']=$Programmesrondes->J27;
                $oldCrudData['J28']=$Programmesrondes->J28;
                $oldCrudData['J29']=$Programmesrondes->J29;
                $oldCrudData['J30']=$Programmesrondes->J30;
                $oldCrudData['J31']=$Programmesrondes->J31;
                $oldCrudData['deja_annaliser']=$Programmesrondes->deja_annaliser;
                $oldCrudData['pointages_rattacher_auto']=$Programmesrondes->pointages_rattacher_auto;
                $oldCrudData['pointages_rattacher_manuel']=$Programmesrondes->pointages_rattacher_manuel;
                $oldCrudData['pointages_debut_auto']=$Programmesrondes->pointages_debut_auto;
                $oldCrudData['pointages_debut_manuel']=$Programmesrondes->pointages_debut_manuel;
                $oldCrudData['pointages_fin_auto']=$Programmesrondes->pointages_fin_auto;
                $oldCrudData['pointages_fin_manuel']=$Programmesrondes->pointages_fin_manuel;
                $oldCrudData['presence_declarer_auto']=$Programmesrondes->presence_declarer_auto;
                $oldCrudData['presence_declarer_manuel']=$Programmesrondes->presence_declarer_manuel;
                $oldCrudData['programmationsronde_id']=$Programmesrondes->programmationsronde_id;
                $oldCrudData['user_id']=$Programmesrondes->user_id;
                $oldCrudData['creat_by']=$Programmesrondes->creat_by;
                    
 try{ $oldCrudData['horaire']=$Programmesrondes->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['poste']=$Programmesrondes->poste->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['programmationsronde']=$Programmesrondes->programmationsronde->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['programmationsuser']=$Programmesrondes->programmationsuser->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Programmesrondes->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "programmesrondes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'date',
    'debut_prevu',
    'fin_prevu',
    'debut_reel',
    'debut_realise',
    'fin_realise',
    'volume_horaire',
    'hs_base',
    'hs_hors_faction',
    'hs_in_faction',
    'programmationsuser_id',
    'horaire_id',
    'etats',
    'totalReel',
    'totalFictif',
    'poste_id',
    'remplacant',
    'type',
    'week',
    'user',
    'DayStatut',
    'Remplacantuser',
    'PresencesDeclarer',
    'AbscencesDeclarer',
    'EtatsDeclarer',
    'Totalpresent',
    'J1',
    'J2',
    'J3',
    'J4',
    'J5',
    'J6',
    'J7',
    'J8',
    'J9',
    'J10',
    'J11',
    'J12',
    'J13',
    'J14',
    'J15',
    'J16',
    'J17',
    'J18',
    'J19',
    'J20',
    'J21',
    'J22',
    'J23',
    'J24',
    'J25',
    'J26',
    'J27',
    'J28',
    'J29',
    'J30',
    'J31',
    'deja_annaliser',
    'pointages_rattacher_auto',
    'pointages_rattacher_manuel',
    'pointages_debut_auto',
    'pointages_debut_manuel',
    'pointages_fin_auto',
    'pointages_fin_manuel',
    'presence_declarer_auto',
    'presence_declarer_manuel',
    'programmationsronde_id',
    'user_id',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'date' => [
            //'required'
            ],
        
    
    
                    'debut_prevu' => [
            //'required'
            ],
        
    
    
                    'fin_prevu' => [
            //'required'
            ],
        
    
    
                    'debut_reel' => [
            //'required'
            ],
        
    
    
                    'debut_realise' => [
            //'required'
            ],
        
    
    
                    'fin_realise' => [
            //'required'
            ],
        
    
    
                    'volume_horaire' => [
            //'required'
            ],
        
    
    
                    'hs_base' => [
            //'required'
            ],
        
    
    
                    'hs_hors_faction' => [
            //'required'
            ],
        
    
    
                    'hs_in_faction' => [
            //'required'
            ],
        
    
    
                    'programmationsuser_id' => [
            //'required'
            ],
        
    
    
                    'horaire_id' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'totalReel' => [
            //'required'
            ],
        
    
    
                    'totalFictif' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'remplacant' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'week' => [
            //'required'
            ],
        
    
    
                    'user' => [
            //'required'
            ],
        
    
    
                    'DayStatut' => [
            //'required'
            ],
        
    
    
                    'Remplacantuser' => [
            //'required'
            ],
        
    
    
                    'PresencesDeclarer' => [
            //'required'
            ],
        
    
    
                    'AbscencesDeclarer' => [
            //'required'
            ],
        
    
    
                    'EtatsDeclarer' => [
            //'required'
            ],
        
    
    
                    'Totalpresent' => [
            //'required'
            ],
        
    
    
                    'J1' => [
            //'required'
            ],
        
    
    
                    'J2' => [
            //'required'
            ],
        
    
    
                    'J3' => [
            //'required'
            ],
        
    
    
                    'J4' => [
            //'required'
            ],
        
    
    
                    'J5' => [
            //'required'
            ],
        
    
    
                    'J6' => [
            //'required'
            ],
        
    
    
                    'J7' => [
            //'required'
            ],
        
    
    
                    'J8' => [
            //'required'
            ],
        
    
    
                    'J9' => [
            //'required'
            ],
        
    
    
                    'J10' => [
            //'required'
            ],
        
    
    
                    'J11' => [
            //'required'
            ],
        
    
    
                    'J12' => [
            //'required'
            ],
        
    
    
                    'J13' => [
            //'required'
            ],
        
    
    
                    'J14' => [
            //'required'
            ],
        
    
    
                    'J15' => [
            //'required'
            ],
        
    
    
                    'J16' => [
            //'required'
            ],
        
    
    
                    'J17' => [
            //'required'
            ],
        
    
    
                    'J18' => [
            //'required'
            ],
        
    
    
                    'J19' => [
            //'required'
            ],
        
    
    
                    'J20' => [
            //'required'
            ],
        
    
    
                    'J21' => [
            //'required'
            ],
        
    
    
                    'J22' => [
            //'required'
            ],
        
    
    
                    'J23' => [
            //'required'
            ],
        
    
    
                    'J24' => [
            //'required'
            ],
        
    
    
                    'J25' => [
            //'required'
            ],
        
    
    
                    'J26' => [
            //'required'
            ],
        
    
    
                    'J27' => [
            //'required'
            ],
        
    
    
                    'J28' => [
            //'required'
            ],
        
    
    
                    'J29' => [
            //'required'
            ],
        
    
    
                    'J30' => [
            //'required'
            ],
        
    
    
                    'J31' => [
            //'required'
            ],
        
    
    
                    'deja_annaliser' => [
            //'required'
            ],
        
    
    
                    'pointages_rattacher_auto' => [
            //'required'
            ],
        
    
    
                    'pointages_rattacher_manuel' => [
            //'required'
            ],
        
    
    
                    'pointages_debut_auto' => [
            //'required'
            ],
        
    
    
                    'pointages_debut_manuel' => [
            //'required'
            ],
        
    
    
                    'pointages_fin_auto' => [
            //'required'
            ],
        
    
    
                    'pointages_fin_manuel' => [
            //'required'
            ],
        
    
    
                    'presence_declarer_auto' => [
            //'required'
            ],
        
    
    
                    'presence_declarer_manuel' => [
            //'required'
            ],
        
    
    
                    'programmationsronde_id' => [
            //'required'
            ],
        
    
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    


], $messages = [

    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'debut_prevu' => ['cette donnee est obligatoire'],

    
    
        'fin_prevu' => ['cette donnee est obligatoire'],

    
    
        'debut_reel' => ['cette donnee est obligatoire'],

    
    
        'debut_realise' => ['cette donnee est obligatoire'],

    
    
        'fin_realise' => ['cette donnee est obligatoire'],

    
    
        'volume_horaire' => ['cette donnee est obligatoire'],

    
    
        'hs_base' => ['cette donnee est obligatoire'],

    
    
        'hs_hors_faction' => ['cette donnee est obligatoire'],

    
    
        'hs_in_faction' => ['cette donnee est obligatoire'],

    
    
        'programmationsuser_id' => ['cette donnee est obligatoire'],

    
    
        'horaire_id' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'totalReel' => ['cette donnee est obligatoire'],

    
    
        'totalFictif' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'remplacant' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'week' => ['cette donnee est obligatoire'],

    
    
        'user' => ['cette donnee est obligatoire'],

    
    
        'DayStatut' => ['cette donnee est obligatoire'],

    
    
        'Remplacantuser' => ['cette donnee est obligatoire'],

    
    
        'PresencesDeclarer' => ['cette donnee est obligatoire'],

    
    
        'AbscencesDeclarer' => ['cette donnee est obligatoire'],

    
    
        'EtatsDeclarer' => ['cette donnee est obligatoire'],

    
    
        'Totalpresent' => ['cette donnee est obligatoire'],

    
    
        'J1' => ['cette donnee est obligatoire'],

    
    
        'J2' => ['cette donnee est obligatoire'],

    
    
        'J3' => ['cette donnee est obligatoire'],

    
    
        'J4' => ['cette donnee est obligatoire'],

    
    
        'J5' => ['cette donnee est obligatoire'],

    
    
        'J6' => ['cette donnee est obligatoire'],

    
    
        'J7' => ['cette donnee est obligatoire'],

    
    
        'J8' => ['cette donnee est obligatoire'],

    
    
        'J9' => ['cette donnee est obligatoire'],

    
    
        'J10' => ['cette donnee est obligatoire'],

    
    
        'J11' => ['cette donnee est obligatoire'],

    
    
        'J12' => ['cette donnee est obligatoire'],

    
    
        'J13' => ['cette donnee est obligatoire'],

    
    
        'J14' => ['cette donnee est obligatoire'],

    
    
        'J15' => ['cette donnee est obligatoire'],

    
    
        'J16' => ['cette donnee est obligatoire'],

    
    
        'J17' => ['cette donnee est obligatoire'],

    
    
        'J18' => ['cette donnee est obligatoire'],

    
    
        'J19' => ['cette donnee est obligatoire'],

    
    
        'J20' => ['cette donnee est obligatoire'],

    
    
        'J21' => ['cette donnee est obligatoire'],

    
    
        'J22' => ['cette donnee est obligatoire'],

    
    
        'J23' => ['cette donnee est obligatoire'],

    
    
        'J24' => ['cette donnee est obligatoire'],

    
    
        'J25' => ['cette donnee est obligatoire'],

    
    
        'J26' => ['cette donnee est obligatoire'],

    
    
        'J27' => ['cette donnee est obligatoire'],

    
    
        'J28' => ['cette donnee est obligatoire'],

    
    
        'J29' => ['cette donnee est obligatoire'],

    
    
        'J30' => ['cette donnee est obligatoire'],

    
    
        'J31' => ['cette donnee est obligatoire'],

    
    
        'deja_annaliser' => ['cette donnee est obligatoire'],

    
    
        'pointages_rattacher_auto' => ['cette donnee est obligatoire'],

    
    
        'pointages_rattacher_manuel' => ['cette donnee est obligatoire'],

    
    
        'pointages_debut_auto' => ['cette donnee est obligatoire'],

    
    
        'pointages_debut_manuel' => ['cette donnee est obligatoire'],

    
    
        'pointages_fin_auto' => ['cette donnee est obligatoire'],

    
    
        'pointages_fin_manuel' => ['cette donnee est obligatoire'],

    
    
        'presence_declarer_auto' => ['cette donnee est obligatoire'],

    
    
        'presence_declarer_manuel' => ['cette donnee est obligatoire'],

    
    
        'programmationsronde_id' => ['cette donnee est obligatoire'],

    
    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("date",$data)){


        if(!empty($data['date'])){
        
            $Programmesrondes->date = $data['date'];
        
        }

        }

    







    

        if(array_key_exists("debut_prevu",$data)){


        if(!empty($data['debut_prevu'])){
        
            $Programmesrondes->debut_prevu = $data['debut_prevu'];
        
        }

        }

    







    

        if(array_key_exists("fin_prevu",$data)){


        if(!empty($data['fin_prevu'])){
        
            $Programmesrondes->fin_prevu = $data['fin_prevu'];
        
        }

        }

    







    

        if(array_key_exists("debut_reel",$data)){


        if(!empty($data['debut_reel'])){
        
            $Programmesrondes->debut_reel = $data['debut_reel'];
        
        }

        }

    







    

        if(array_key_exists("debut_realise",$data)){


        if(!empty($data['debut_realise'])){
        
            $Programmesrondes->debut_realise = $data['debut_realise'];
        
        }

        }

    







    

        if(array_key_exists("fin_realise",$data)){


        if(!empty($data['fin_realise'])){
        
            $Programmesrondes->fin_realise = $data['fin_realise'];
        
        }

        }

    







    

        if(array_key_exists("volume_horaire",$data)){


        if(!empty($data['volume_horaire'])){
        
            $Programmesrondes->volume_horaire = $data['volume_horaire'];
        
        }

        }

    







    

        if(array_key_exists("hs_base",$data)){


        if(!empty($data['hs_base'])){
        
            $Programmesrondes->hs_base = $data['hs_base'];
        
        }

        }

    







    

        if(array_key_exists("hs_hors_faction",$data)){


        if(!empty($data['hs_hors_faction'])){
        
            $Programmesrondes->hs_hors_faction = $data['hs_hors_faction'];
        
        }

        }

    







    

        if(array_key_exists("hs_in_faction",$data)){


        if(!empty($data['hs_in_faction'])){
        
            $Programmesrondes->hs_in_faction = $data['hs_in_faction'];
        
        }

        }

    







    

        if(array_key_exists("programmationsuser_id",$data)){


        if(!empty($data['programmationsuser_id'])){
        
            $Programmesrondes->programmationsuser_id = $data['programmationsuser_id'];
        
        }

        }

    







    

        if(array_key_exists("horaire_id",$data)){


        if(!empty($data['horaire_id'])){
        
            $Programmesrondes->horaire_id = $data['horaire_id'];
        
        }

        }

    







    

        if(array_key_exists("etats",$data)){


        if(!empty($data['etats'])){
        
            $Programmesrondes->etats = $data['etats'];
        
        }

        }

    







    

        if(array_key_exists("totalReel",$data)){


        if(!empty($data['totalReel'])){
        
            $Programmesrondes->totalReel = $data['totalReel'];
        
        }

        }

    







    

        if(array_key_exists("totalFictif",$data)){


        if(!empty($data['totalFictif'])){
        
            $Programmesrondes->totalFictif = $data['totalFictif'];
        
        }

        }

    







    

        if(array_key_exists("poste_id",$data)){


        if(!empty($data['poste_id'])){
        
            $Programmesrondes->poste_id = $data['poste_id'];
        
        }

        }

    







    

        if(array_key_exists("remplacant",$data)){


        if(!empty($data['remplacant'])){
        
            $Programmesrondes->remplacant = $data['remplacant'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Programmesrondes->type = $data['type'];
        
        }

        }

    







    

        if(array_key_exists("week",$data)){


        if(!empty($data['week'])){
        
            $Programmesrondes->week = $data['week'];
        
        }

        }

    







    

        if(array_key_exists("user",$data)){


        if(!empty($data['user'])){
        
            $Programmesrondes->user = $data['user'];
        
        }

        }

    







    

        if(array_key_exists("DayStatut",$data)){


        if(!empty($data['DayStatut'])){
        
            $Programmesrondes->DayStatut = $data['DayStatut'];
        
        }

        }

    







    

        if(array_key_exists("Remplacantuser",$data)){


        if(!empty($data['Remplacantuser'])){
        
            $Programmesrondes->Remplacantuser = $data['Remplacantuser'];
        
        }

        }

    







    

        if(array_key_exists("PresencesDeclarer",$data)){


        if(!empty($data['PresencesDeclarer'])){
        
            $Programmesrondes->PresencesDeclarer = $data['PresencesDeclarer'];
        
        }

        }

    







    

        if(array_key_exists("AbscencesDeclarer",$data)){


        if(!empty($data['AbscencesDeclarer'])){
        
            $Programmesrondes->AbscencesDeclarer = $data['AbscencesDeclarer'];
        
        }

        }

    







    

        if(array_key_exists("EtatsDeclarer",$data)){


        if(!empty($data['EtatsDeclarer'])){
        
            $Programmesrondes->EtatsDeclarer = $data['EtatsDeclarer'];
        
        }

        }

    







    

        if(array_key_exists("Totalpresent",$data)){


        if(!empty($data['Totalpresent'])){
        
            $Programmesrondes->Totalpresent = $data['Totalpresent'];
        
        }

        }

    







    

        if(array_key_exists("J1",$data)){


        if(!empty($data['J1'])){
        
            $Programmesrondes->J1 = $data['J1'];
        
        }

        }

    







    

        if(array_key_exists("J2",$data)){


        if(!empty($data['J2'])){
        
            $Programmesrondes->J2 = $data['J2'];
        
        }

        }

    







    

        if(array_key_exists("J3",$data)){


        if(!empty($data['J3'])){
        
            $Programmesrondes->J3 = $data['J3'];
        
        }

        }

    







    

        if(array_key_exists("J4",$data)){


        if(!empty($data['J4'])){
        
            $Programmesrondes->J4 = $data['J4'];
        
        }

        }

    







    

        if(array_key_exists("J5",$data)){


        if(!empty($data['J5'])){
        
            $Programmesrondes->J5 = $data['J5'];
        
        }

        }

    







    

        if(array_key_exists("J6",$data)){


        if(!empty($data['J6'])){
        
            $Programmesrondes->J6 = $data['J6'];
        
        }

        }

    







    

        if(array_key_exists("J7",$data)){


        if(!empty($data['J7'])){
        
            $Programmesrondes->J7 = $data['J7'];
        
        }

        }

    







    

        if(array_key_exists("J8",$data)){


        if(!empty($data['J8'])){
        
            $Programmesrondes->J8 = $data['J8'];
        
        }

        }

    







    

        if(array_key_exists("J9",$data)){


        if(!empty($data['J9'])){
        
            $Programmesrondes->J9 = $data['J9'];
        
        }

        }

    







    

        if(array_key_exists("J10",$data)){


        if(!empty($data['J10'])){
        
            $Programmesrondes->J10 = $data['J10'];
        
        }

        }

    







    

        if(array_key_exists("J11",$data)){


        if(!empty($data['J11'])){
        
            $Programmesrondes->J11 = $data['J11'];
        
        }

        }

    







    

        if(array_key_exists("J12",$data)){


        if(!empty($data['J12'])){
        
            $Programmesrondes->J12 = $data['J12'];
        
        }

        }

    







    

        if(array_key_exists("J13",$data)){


        if(!empty($data['J13'])){
        
            $Programmesrondes->J13 = $data['J13'];
        
        }

        }

    







    

        if(array_key_exists("J14",$data)){


        if(!empty($data['J14'])){
        
            $Programmesrondes->J14 = $data['J14'];
        
        }

        }

    







    

        if(array_key_exists("J15",$data)){


        if(!empty($data['J15'])){
        
            $Programmesrondes->J15 = $data['J15'];
        
        }

        }

    







    

        if(array_key_exists("J16",$data)){


        if(!empty($data['J16'])){
        
            $Programmesrondes->J16 = $data['J16'];
        
        }

        }

    







    

        if(array_key_exists("J17",$data)){


        if(!empty($data['J17'])){
        
            $Programmesrondes->J17 = $data['J17'];
        
        }

        }

    







    

        if(array_key_exists("J18",$data)){


        if(!empty($data['J18'])){
        
            $Programmesrondes->J18 = $data['J18'];
        
        }

        }

    







    

        if(array_key_exists("J19",$data)){


        if(!empty($data['J19'])){
        
            $Programmesrondes->J19 = $data['J19'];
        
        }

        }

    







    

        if(array_key_exists("J20",$data)){


        if(!empty($data['J20'])){
        
            $Programmesrondes->J20 = $data['J20'];
        
        }

        }

    







    

        if(array_key_exists("J21",$data)){


        if(!empty($data['J21'])){
        
            $Programmesrondes->J21 = $data['J21'];
        
        }

        }

    







    

        if(array_key_exists("J22",$data)){


        if(!empty($data['J22'])){
        
            $Programmesrondes->J22 = $data['J22'];
        
        }

        }

    







    

        if(array_key_exists("J23",$data)){


        if(!empty($data['J23'])){
        
            $Programmesrondes->J23 = $data['J23'];
        
        }

        }

    







    

        if(array_key_exists("J24",$data)){


        if(!empty($data['J24'])){
        
            $Programmesrondes->J24 = $data['J24'];
        
        }

        }

    







    

        if(array_key_exists("J25",$data)){


        if(!empty($data['J25'])){
        
            $Programmesrondes->J25 = $data['J25'];
        
        }

        }

    







    

        if(array_key_exists("J26",$data)){


        if(!empty($data['J26'])){
        
            $Programmesrondes->J26 = $data['J26'];
        
        }

        }

    







    

        if(array_key_exists("J27",$data)){


        if(!empty($data['J27'])){
        
            $Programmesrondes->J27 = $data['J27'];
        
        }

        }

    







    

        if(array_key_exists("J28",$data)){


        if(!empty($data['J28'])){
        
            $Programmesrondes->J28 = $data['J28'];
        
        }

        }

    







    

        if(array_key_exists("J29",$data)){


        if(!empty($data['J29'])){
        
            $Programmesrondes->J29 = $data['J29'];
        
        }

        }

    







    

        if(array_key_exists("J30",$data)){


        if(!empty($data['J30'])){
        
            $Programmesrondes->J30 = $data['J30'];
        
        }

        }

    







    

        if(array_key_exists("J31",$data)){


        if(!empty($data['J31'])){
        
            $Programmesrondes->J31 = $data['J31'];
        
        }

        }

    







    

        if(array_key_exists("deja_annaliser",$data)){


        if(!empty($data['deja_annaliser'])){
        
            $Programmesrondes->deja_annaliser = $data['deja_annaliser'];
        
        }

        }

    







    

        if(array_key_exists("pointages_rattacher_auto",$data)){


        if(!empty($data['pointages_rattacher_auto'])){
        
            $Programmesrondes->pointages_rattacher_auto = $data['pointages_rattacher_auto'];
        
        }

        }

    







    

        if(array_key_exists("pointages_rattacher_manuel",$data)){


        if(!empty($data['pointages_rattacher_manuel'])){
        
            $Programmesrondes->pointages_rattacher_manuel = $data['pointages_rattacher_manuel'];
        
        }

        }

    







    

        if(array_key_exists("pointages_debut_auto",$data)){


        if(!empty($data['pointages_debut_auto'])){
        
            $Programmesrondes->pointages_debut_auto = $data['pointages_debut_auto'];
        
        }

        }

    







    

        if(array_key_exists("pointages_debut_manuel",$data)){


        if(!empty($data['pointages_debut_manuel'])){
        
            $Programmesrondes->pointages_debut_manuel = $data['pointages_debut_manuel'];
        
        }

        }

    







    

        if(array_key_exists("pointages_fin_auto",$data)){


        if(!empty($data['pointages_fin_auto'])){
        
            $Programmesrondes->pointages_fin_auto = $data['pointages_fin_auto'];
        
        }

        }

    







    

        if(array_key_exists("pointages_fin_manuel",$data)){


        if(!empty($data['pointages_fin_manuel'])){
        
            $Programmesrondes->pointages_fin_manuel = $data['pointages_fin_manuel'];
        
        }

        }

    







    

        if(array_key_exists("presence_declarer_auto",$data)){


        if(!empty($data['presence_declarer_auto'])){
        
            $Programmesrondes->presence_declarer_auto = $data['presence_declarer_auto'];
        
        }

        }

    







    

        if(array_key_exists("presence_declarer_manuel",$data)){


        if(!empty($data['presence_declarer_manuel'])){
        
            $Programmesrondes->presence_declarer_manuel = $data['presence_declarer_manuel'];
        
        }

        }

    







    

        if(array_key_exists("programmationsronde_id",$data)){


        if(!empty($data['programmationsronde_id'])){
        
            $Programmesrondes->programmationsronde_id = $data['programmationsronde_id'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Programmesrondes->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Programmesrondes->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Programmesrondes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ProgrammesrondeExtras') &&
method_exists('\App\Http\Extras\ProgrammesrondeExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ProgrammesrondeExtras::beforeSaveUpdate($request,$Programmesrondes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ProgrammesrondeExtras') &&
method_exists('\App\Http\Extras\ProgrammesrondeExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ProgrammesrondeExtras::canUpdate($request, $Programmesrondes);
}catch (\Throwable $e){

}

}


if($canSave){
$Programmesrondes->save();
}else{
return response()->json($Programmesrondes, 200);

}


$Programmesrondes=Programmesronde::find($Programmesrondes->id);



$newCrudData=[];

                $newCrudData['date']=$Programmesrondes->date;
                $newCrudData['debut_prevu']=$Programmesrondes->debut_prevu;
                $newCrudData['fin_prevu']=$Programmesrondes->fin_prevu;
                $newCrudData['debut_reel']=$Programmesrondes->debut_reel;
                $newCrudData['debut_realise']=$Programmesrondes->debut_realise;
                $newCrudData['fin_realise']=$Programmesrondes->fin_realise;
                $newCrudData['volume_horaire']=$Programmesrondes->volume_horaire;
                $newCrudData['hs_base']=$Programmesrondes->hs_base;
                $newCrudData['hs_hors_faction']=$Programmesrondes->hs_hors_faction;
                $newCrudData['hs_in_faction']=$Programmesrondes->hs_in_faction;
                $newCrudData['programmationsuser_id']=$Programmesrondes->programmationsuser_id;
                $newCrudData['horaire_id']=$Programmesrondes->horaire_id;
                $newCrudData['etats']=$Programmesrondes->etats;
                $newCrudData['totalReel']=$Programmesrondes->totalReel;
                $newCrudData['totalFictif']=$Programmesrondes->totalFictif;
                $newCrudData['poste_id']=$Programmesrondes->poste_id;
                $newCrudData['remplacant']=$Programmesrondes->remplacant;
                $newCrudData['type']=$Programmesrondes->type;
                $newCrudData['week']=$Programmesrondes->week;
                $newCrudData['user']=$Programmesrondes->user;
                $newCrudData['DayStatut']=$Programmesrondes->DayStatut;
                $newCrudData['Remplacantuser']=$Programmesrondes->Remplacantuser;
                $newCrudData['PresencesDeclarer']=$Programmesrondes->PresencesDeclarer;
                $newCrudData['AbscencesDeclarer']=$Programmesrondes->AbscencesDeclarer;
                $newCrudData['EtatsDeclarer']=$Programmesrondes->EtatsDeclarer;
                $newCrudData['Totalpresent']=$Programmesrondes->Totalpresent;
                $newCrudData['J1']=$Programmesrondes->J1;
                $newCrudData['J2']=$Programmesrondes->J2;
                $newCrudData['J3']=$Programmesrondes->J3;
                $newCrudData['J4']=$Programmesrondes->J4;
                $newCrudData['J5']=$Programmesrondes->J5;
                $newCrudData['J6']=$Programmesrondes->J6;
                $newCrudData['J7']=$Programmesrondes->J7;
                $newCrudData['J8']=$Programmesrondes->J8;
                $newCrudData['J9']=$Programmesrondes->J9;
                $newCrudData['J10']=$Programmesrondes->J10;
                $newCrudData['J11']=$Programmesrondes->J11;
                $newCrudData['J12']=$Programmesrondes->J12;
                $newCrudData['J13']=$Programmesrondes->J13;
                $newCrudData['J14']=$Programmesrondes->J14;
                $newCrudData['J15']=$Programmesrondes->J15;
                $newCrudData['J16']=$Programmesrondes->J16;
                $newCrudData['J17']=$Programmesrondes->J17;
                $newCrudData['J18']=$Programmesrondes->J18;
                $newCrudData['J19']=$Programmesrondes->J19;
                $newCrudData['J20']=$Programmesrondes->J20;
                $newCrudData['J21']=$Programmesrondes->J21;
                $newCrudData['J22']=$Programmesrondes->J22;
                $newCrudData['J23']=$Programmesrondes->J23;
                $newCrudData['J24']=$Programmesrondes->J24;
                $newCrudData['J25']=$Programmesrondes->J25;
                $newCrudData['J26']=$Programmesrondes->J26;
                $newCrudData['J27']=$Programmesrondes->J27;
                $newCrudData['J28']=$Programmesrondes->J28;
                $newCrudData['J29']=$Programmesrondes->J29;
                $newCrudData['J30']=$Programmesrondes->J30;
                $newCrudData['J31']=$Programmesrondes->J31;
                $newCrudData['deja_annaliser']=$Programmesrondes->deja_annaliser;
                $newCrudData['pointages_rattacher_auto']=$Programmesrondes->pointages_rattacher_auto;
                $newCrudData['pointages_rattacher_manuel']=$Programmesrondes->pointages_rattacher_manuel;
                $newCrudData['pointages_debut_auto']=$Programmesrondes->pointages_debut_auto;
                $newCrudData['pointages_debut_manuel']=$Programmesrondes->pointages_debut_manuel;
                $newCrudData['pointages_fin_auto']=$Programmesrondes->pointages_fin_auto;
                $newCrudData['pointages_fin_manuel']=$Programmesrondes->pointages_fin_manuel;
                $newCrudData['presence_declarer_auto']=$Programmesrondes->presence_declarer_auto;
                $newCrudData['presence_declarer_manuel']=$Programmesrondes->presence_declarer_manuel;
                $newCrudData['programmationsronde_id']=$Programmesrondes->programmationsronde_id;
                $newCrudData['user_id']=$Programmesrondes->user_id;
                $newCrudData['creat_by']=$Programmesrondes->creat_by;
                    
 try{ $newCrudData['horaire']=$Programmesrondes->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Programmesrondes->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['programmationsronde']=$Programmesrondes->programmationsronde->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['programmationsuser']=$Programmesrondes->programmationsuser->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Programmesrondes->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Programmesrondes','entite_cle' => $Programmesrondes->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Programmesrondes->toArray();




try{

foreach ($Programmesrondes->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Programmesronde $Programmesrondes)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des programmesrondes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['date']=$Programmesrondes->date;
                $newCrudData['debut_prevu']=$Programmesrondes->debut_prevu;
                $newCrudData['fin_prevu']=$Programmesrondes->fin_prevu;
                $newCrudData['debut_reel']=$Programmesrondes->debut_reel;
                $newCrudData['debut_realise']=$Programmesrondes->debut_realise;
                $newCrudData['fin_realise']=$Programmesrondes->fin_realise;
                $newCrudData['volume_horaire']=$Programmesrondes->volume_horaire;
                $newCrudData['hs_base']=$Programmesrondes->hs_base;
                $newCrudData['hs_hors_faction']=$Programmesrondes->hs_hors_faction;
                $newCrudData['hs_in_faction']=$Programmesrondes->hs_in_faction;
                $newCrudData['programmationsuser_id']=$Programmesrondes->programmationsuser_id;
                $newCrudData['horaire_id']=$Programmesrondes->horaire_id;
                $newCrudData['etats']=$Programmesrondes->etats;
                $newCrudData['totalReel']=$Programmesrondes->totalReel;
                $newCrudData['totalFictif']=$Programmesrondes->totalFictif;
                $newCrudData['poste_id']=$Programmesrondes->poste_id;
                $newCrudData['remplacant']=$Programmesrondes->remplacant;
                $newCrudData['type']=$Programmesrondes->type;
                $newCrudData['week']=$Programmesrondes->week;
                $newCrudData['user']=$Programmesrondes->user;
                $newCrudData['DayStatut']=$Programmesrondes->DayStatut;
                $newCrudData['Remplacantuser']=$Programmesrondes->Remplacantuser;
                $newCrudData['PresencesDeclarer']=$Programmesrondes->PresencesDeclarer;
                $newCrudData['AbscencesDeclarer']=$Programmesrondes->AbscencesDeclarer;
                $newCrudData['EtatsDeclarer']=$Programmesrondes->EtatsDeclarer;
                $newCrudData['Totalpresent']=$Programmesrondes->Totalpresent;
                $newCrudData['J1']=$Programmesrondes->J1;
                $newCrudData['J2']=$Programmesrondes->J2;
                $newCrudData['J3']=$Programmesrondes->J3;
                $newCrudData['J4']=$Programmesrondes->J4;
                $newCrudData['J5']=$Programmesrondes->J5;
                $newCrudData['J6']=$Programmesrondes->J6;
                $newCrudData['J7']=$Programmesrondes->J7;
                $newCrudData['J8']=$Programmesrondes->J8;
                $newCrudData['J9']=$Programmesrondes->J9;
                $newCrudData['J10']=$Programmesrondes->J10;
                $newCrudData['J11']=$Programmesrondes->J11;
                $newCrudData['J12']=$Programmesrondes->J12;
                $newCrudData['J13']=$Programmesrondes->J13;
                $newCrudData['J14']=$Programmesrondes->J14;
                $newCrudData['J15']=$Programmesrondes->J15;
                $newCrudData['J16']=$Programmesrondes->J16;
                $newCrudData['J17']=$Programmesrondes->J17;
                $newCrudData['J18']=$Programmesrondes->J18;
                $newCrudData['J19']=$Programmesrondes->J19;
                $newCrudData['J20']=$Programmesrondes->J20;
                $newCrudData['J21']=$Programmesrondes->J21;
                $newCrudData['J22']=$Programmesrondes->J22;
                $newCrudData['J23']=$Programmesrondes->J23;
                $newCrudData['J24']=$Programmesrondes->J24;
                $newCrudData['J25']=$Programmesrondes->J25;
                $newCrudData['J26']=$Programmesrondes->J26;
                $newCrudData['J27']=$Programmesrondes->J27;
                $newCrudData['J28']=$Programmesrondes->J28;
                $newCrudData['J29']=$Programmesrondes->J29;
                $newCrudData['J30']=$Programmesrondes->J30;
                $newCrudData['J31']=$Programmesrondes->J31;
                $newCrudData['deja_annaliser']=$Programmesrondes->deja_annaliser;
                $newCrudData['pointages_rattacher_auto']=$Programmesrondes->pointages_rattacher_auto;
                $newCrudData['pointages_rattacher_manuel']=$Programmesrondes->pointages_rattacher_manuel;
                $newCrudData['pointages_debut_auto']=$Programmesrondes->pointages_debut_auto;
                $newCrudData['pointages_debut_manuel']=$Programmesrondes->pointages_debut_manuel;
                $newCrudData['pointages_fin_auto']=$Programmesrondes->pointages_fin_auto;
                $newCrudData['pointages_fin_manuel']=$Programmesrondes->pointages_fin_manuel;
                $newCrudData['presence_declarer_auto']=$Programmesrondes->presence_declarer_auto;
                $newCrudData['presence_declarer_manuel']=$Programmesrondes->presence_declarer_manuel;
                $newCrudData['programmationsronde_id']=$Programmesrondes->programmationsronde_id;
                $newCrudData['user_id']=$Programmesrondes->user_id;
                $newCrudData['creat_by']=$Programmesrondes->creat_by;
                    
 try{ $newCrudData['horaire']=$Programmesrondes->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Programmesrondes->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['programmationsronde']=$Programmesrondes->programmationsronde->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['programmationsuser']=$Programmesrondes->programmationsuser->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Programmesrondes->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Programmesrondes','entite_cle' => $Programmesrondes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ProgrammesrondeExtras') &&
method_exists('\App\Http\Extras\ProgrammesrondeExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ProgrammesrondeExtras::canDelete($request, $Programmesrondes);
}catch (\Throwable $e){

}

}



if($canSave){
$Programmesrondes->delete();
}else{
return response()->json($Programmesrondes, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ProgrammesrondesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
