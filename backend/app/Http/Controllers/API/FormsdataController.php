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
// use App\Repository\prod\FormsdatasRepository;
use App\Models\Formsdata;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Form;
    
class FormsdataController extends Controller
{

private $FormsdatasRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\FormsdatasRepository $FormsdatasRepository
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
class_exists('\App\Http\Extras\FormsdataExtras') &&
method_exists('\App\Http\Extras\FormsdataExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\FormsdataExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Formsdata::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\FormsdataExtras') &&
method_exists('\App\Http\Extras\FormsdataExtras', 'filterAgGridQuery')
){
\App\Http\Extras\FormsdataExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('formsdatas',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\FormsdataExtras') &&
method_exists('\App\Http\Extras\FormsdataExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\FormsdataExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  formsdatas reussi',
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
return response()->json(Formsdata::count());
}
$data = QueryBuilder::for(Formsdata::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('parent'),

    
            AllowedFilter::exact('form_id'),

    
            AllowedFilter::exact('cle0'),

    
            AllowedFilter::exact('cle1'),

    
            AllowedFilter::exact('cle2'),

    
            AllowedFilter::exact('cle3'),

    
            AllowedFilter::exact('cle4'),

    
            AllowedFilter::exact('cle5'),

    
            AllowedFilter::exact('cle6'),

    
            AllowedFilter::exact('cle7'),

    
            AllowedFilter::exact('cle8'),

    
            AllowedFilter::exact('cle9'),

    
            AllowedFilter::exact('cle10'),

    
            AllowedFilter::exact('cle11'),

    
            AllowedFilter::exact('cle12'),

    
            AllowedFilter::exact('cle13'),

    
            AllowedFilter::exact('cle14'),

    
            AllowedFilter::exact('cle15'),

    
            AllowedFilter::exact('cle16'),

    
            AllowedFilter::exact('cle17'),

    
            AllowedFilter::exact('cle18'),

    
            AllowedFilter::exact('cle19'),

    
            AllowedFilter::exact('cle20'),

    
            AllowedFilter::exact('cle21'),

    
            AllowedFilter::exact('cle22'),

    
            AllowedFilter::exact('cle23'),

    
            AllowedFilter::exact('cle24'),

    
            AllowedFilter::exact('cle25'),

    
            AllowedFilter::exact('cle26'),

    
            AllowedFilter::exact('cle27'),

    
            AllowedFilter::exact('cle28'),

    
            AllowedFilter::exact('cle29'),

    
            AllowedFilter::exact('cle30'),

    
            AllowedFilter::exact('cle31'),

    
            AllowedFilter::exact('cle32'),

    
            AllowedFilter::exact('cle33'),

    
            AllowedFilter::exact('cle34'),

    
            AllowedFilter::exact('cle35'),

    
            AllowedFilter::exact('cle36'),

    
            AllowedFilter::exact('cle37'),

    
            AllowedFilter::exact('cle38'),

    
            AllowedFilter::exact('cle39'),

    
            AllowedFilter::exact('cle40'),

    
            AllowedFilter::exact('cle41'),

    
            AllowedFilter::exact('cle42'),

    
            AllowedFilter::exact('cle43'),

    
            AllowedFilter::exact('cle44'),

    
            AllowedFilter::exact('cle45'),

    
            AllowedFilter::exact('cle46'),

    
            AllowedFilter::exact('cle47'),

    
            AllowedFilter::exact('cle48'),

    
            AllowedFilter::exact('cle49'),

    
            AllowedFilter::exact('cle50'),

    
            AllowedFilter::exact('cle51'),

    
            AllowedFilter::exact('cle52'),

    
            AllowedFilter::exact('cle53'),

    
            AllowedFilter::exact('cle54'),

    
            AllowedFilter::exact('cle55'),

    
            AllowedFilter::exact('cle56'),

    
            AllowedFilter::exact('cle57'),

    
            AllowedFilter::exact('cle58'),

    
            AllowedFilter::exact('cle59'),

    
            AllowedFilter::exact('cle60'),

    
            AllowedFilter::exact('cle61'),

    
            AllowedFilter::exact('cle62'),

    
            AllowedFilter::exact('cle63'),

    
            AllowedFilter::exact('cle64'),

    
            AllowedFilter::exact('cle65'),

    
            AllowedFilter::exact('cle66'),

    
            AllowedFilter::exact('cle67'),

    
            AllowedFilter::exact('cle68'),

    
            AllowedFilter::exact('cle69'),

    
            AllowedFilter::exact('cle70'),

    
            AllowedFilter::exact('cle71'),

    
            AllowedFilter::exact('cle72'),

    
            AllowedFilter::exact('cle73'),

    
            AllowedFilter::exact('cle74'),

    
            AllowedFilter::exact('cle75'),

    
            AllowedFilter::exact('cle76'),

    
            AllowedFilter::exact('cle77'),

    
            AllowedFilter::exact('cle78'),

    
            AllowedFilter::exact('cle79'),

    
            AllowedFilter::exact('cle80'),

    
            AllowedFilter::exact('cle81'),

    
            AllowedFilter::exact('cle82'),

    
            AllowedFilter::exact('cle83'),

    
            AllowedFilter::exact('cle84'),

    
            AllowedFilter::exact('cle85'),

    
            AllowedFilter::exact('cle86'),

    
            AllowedFilter::exact('cle87'),

    
            AllowedFilter::exact('cle88'),

    
            AllowedFilter::exact('cle89'),

    
            AllowedFilter::exact('cle90'),

    
            AllowedFilter::exact('cle91'),

    
            AllowedFilter::exact('cle92'),

    
            AllowedFilter::exact('cle93'),

    
            AllowedFilter::exact('cle94'),

    
            AllowedFilter::exact('cle95'),

    
            AllowedFilter::exact('cle96'),

    
            AllowedFilter::exact('cle97'),

    
            AllowedFilter::exact('cle98'),

    
            AllowedFilter::exact('cle99'),

    
    
            AllowedFilter::exact('creat_by'),

    
    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
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

    
            AllowedSort::field('parent'),

    
            AllowedSort::field('form_id'),

    
            AllowedSort::field('cle0'),

    
            AllowedSort::field('cle1'),

    
            AllowedSort::field('cle2'),

    
            AllowedSort::field('cle3'),

    
            AllowedSort::field('cle4'),

    
            AllowedSort::field('cle5'),

    
            AllowedSort::field('cle6'),

    
            AllowedSort::field('cle7'),

    
            AllowedSort::field('cle8'),

    
            AllowedSort::field('cle9'),

    
            AllowedSort::field('cle10'),

    
            AllowedSort::field('cle11'),

    
            AllowedSort::field('cle12'),

    
            AllowedSort::field('cle13'),

    
            AllowedSort::field('cle14'),

    
            AllowedSort::field('cle15'),

    
            AllowedSort::field('cle16'),

    
            AllowedSort::field('cle17'),

    
            AllowedSort::field('cle18'),

    
            AllowedSort::field('cle19'),

    
            AllowedSort::field('cle20'),

    
            AllowedSort::field('cle21'),

    
            AllowedSort::field('cle22'),

    
            AllowedSort::field('cle23'),

    
            AllowedSort::field('cle24'),

    
            AllowedSort::field('cle25'),

    
            AllowedSort::field('cle26'),

    
            AllowedSort::field('cle27'),

    
            AllowedSort::field('cle28'),

    
            AllowedSort::field('cle29'),

    
            AllowedSort::field('cle30'),

    
            AllowedSort::field('cle31'),

    
            AllowedSort::field('cle32'),

    
            AllowedSort::field('cle33'),

    
            AllowedSort::field('cle34'),

    
            AllowedSort::field('cle35'),

    
            AllowedSort::field('cle36'),

    
            AllowedSort::field('cle37'),

    
            AllowedSort::field('cle38'),

    
            AllowedSort::field('cle39'),

    
            AllowedSort::field('cle40'),

    
            AllowedSort::field('cle41'),

    
            AllowedSort::field('cle42'),

    
            AllowedSort::field('cle43'),

    
            AllowedSort::field('cle44'),

    
            AllowedSort::field('cle45'),

    
            AllowedSort::field('cle46'),

    
            AllowedSort::field('cle47'),

    
            AllowedSort::field('cle48'),

    
            AllowedSort::field('cle49'),

    
            AllowedSort::field('cle50'),

    
            AllowedSort::field('cle51'),

    
            AllowedSort::field('cle52'),

    
            AllowedSort::field('cle53'),

    
            AllowedSort::field('cle54'),

    
            AllowedSort::field('cle55'),

    
            AllowedSort::field('cle56'),

    
            AllowedSort::field('cle57'),

    
            AllowedSort::field('cle58'),

    
            AllowedSort::field('cle59'),

    
            AllowedSort::field('cle60'),

    
            AllowedSort::field('cle61'),

    
            AllowedSort::field('cle62'),

    
            AllowedSort::field('cle63'),

    
            AllowedSort::field('cle64'),

    
            AllowedSort::field('cle65'),

    
            AllowedSort::field('cle66'),

    
            AllowedSort::field('cle67'),

    
            AllowedSort::field('cle68'),

    
            AllowedSort::field('cle69'),

    
            AllowedSort::field('cle70'),

    
            AllowedSort::field('cle71'),

    
            AllowedSort::field('cle72'),

    
            AllowedSort::field('cle73'),

    
            AllowedSort::field('cle74'),

    
            AllowedSort::field('cle75'),

    
            AllowedSort::field('cle76'),

    
            AllowedSort::field('cle77'),

    
            AllowedSort::field('cle78'),

    
            AllowedSort::field('cle79'),

    
            AllowedSort::field('cle80'),

    
            AllowedSort::field('cle81'),

    
            AllowedSort::field('cle82'),

    
            AllowedSort::field('cle83'),

    
            AllowedSort::field('cle84'),

    
            AllowedSort::field('cle85'),

    
            AllowedSort::field('cle86'),

    
            AllowedSort::field('cle87'),

    
            AllowedSort::field('cle88'),

    
            AllowedSort::field('cle89'),

    
            AllowedSort::field('cle90'),

    
            AllowedSort::field('cle91'),

    
            AllowedSort::field('cle92'),

    
            AllowedSort::field('cle93'),

    
            AllowedSort::field('cle94'),

    
            AllowedSort::field('cle95'),

    
            AllowedSort::field('cle96'),

    
            AllowedSort::field('cle97'),

    
            AllowedSort::field('cle98'),

    
            AllowedSort::field('cle99'),

    
    
            AllowedSort::field('creat_by'),

    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([

            'form',
        

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




$data = QueryBuilder::for(Formsdata::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('libelle'),

    
            AllowedFilter::exact('parent'),

    
            AllowedFilter::exact('form_id'),

    
            AllowedFilter::exact('cle0'),

    
            AllowedFilter::exact('cle1'),

    
            AllowedFilter::exact('cle2'),

    
            AllowedFilter::exact('cle3'),

    
            AllowedFilter::exact('cle4'),

    
            AllowedFilter::exact('cle5'),

    
            AllowedFilter::exact('cle6'),

    
            AllowedFilter::exact('cle7'),

    
            AllowedFilter::exact('cle8'),

    
            AllowedFilter::exact('cle9'),

    
            AllowedFilter::exact('cle10'),

    
            AllowedFilter::exact('cle11'),

    
            AllowedFilter::exact('cle12'),

    
            AllowedFilter::exact('cle13'),

    
            AllowedFilter::exact('cle14'),

    
            AllowedFilter::exact('cle15'),

    
            AllowedFilter::exact('cle16'),

    
            AllowedFilter::exact('cle17'),

    
            AllowedFilter::exact('cle18'),

    
            AllowedFilter::exact('cle19'),

    
            AllowedFilter::exact('cle20'),

    
            AllowedFilter::exact('cle21'),

    
            AllowedFilter::exact('cle22'),

    
            AllowedFilter::exact('cle23'),

    
            AllowedFilter::exact('cle24'),

    
            AllowedFilter::exact('cle25'),

    
            AllowedFilter::exact('cle26'),

    
            AllowedFilter::exact('cle27'),

    
            AllowedFilter::exact('cle28'),

    
            AllowedFilter::exact('cle29'),

    
            AllowedFilter::exact('cle30'),

    
            AllowedFilter::exact('cle31'),

    
            AllowedFilter::exact('cle32'),

    
            AllowedFilter::exact('cle33'),

    
            AllowedFilter::exact('cle34'),

    
            AllowedFilter::exact('cle35'),

    
            AllowedFilter::exact('cle36'),

    
            AllowedFilter::exact('cle37'),

    
            AllowedFilter::exact('cle38'),

    
            AllowedFilter::exact('cle39'),

    
            AllowedFilter::exact('cle40'),

    
            AllowedFilter::exact('cle41'),

    
            AllowedFilter::exact('cle42'),

    
            AllowedFilter::exact('cle43'),

    
            AllowedFilter::exact('cle44'),

    
            AllowedFilter::exact('cle45'),

    
            AllowedFilter::exact('cle46'),

    
            AllowedFilter::exact('cle47'),

    
            AllowedFilter::exact('cle48'),

    
            AllowedFilter::exact('cle49'),

    
            AllowedFilter::exact('cle50'),

    
            AllowedFilter::exact('cle51'),

    
            AllowedFilter::exact('cle52'),

    
            AllowedFilter::exact('cle53'),

    
            AllowedFilter::exact('cle54'),

    
            AllowedFilter::exact('cle55'),

    
            AllowedFilter::exact('cle56'),

    
            AllowedFilter::exact('cle57'),

    
            AllowedFilter::exact('cle58'),

    
            AllowedFilter::exact('cle59'),

    
            AllowedFilter::exact('cle60'),

    
            AllowedFilter::exact('cle61'),

    
            AllowedFilter::exact('cle62'),

    
            AllowedFilter::exact('cle63'),

    
            AllowedFilter::exact('cle64'),

    
            AllowedFilter::exact('cle65'),

    
            AllowedFilter::exact('cle66'),

    
            AllowedFilter::exact('cle67'),

    
            AllowedFilter::exact('cle68'),

    
            AllowedFilter::exact('cle69'),

    
            AllowedFilter::exact('cle70'),

    
            AllowedFilter::exact('cle71'),

    
            AllowedFilter::exact('cle72'),

    
            AllowedFilter::exact('cle73'),

    
            AllowedFilter::exact('cle74'),

    
            AllowedFilter::exact('cle75'),

    
            AllowedFilter::exact('cle76'),

    
            AllowedFilter::exact('cle77'),

    
            AllowedFilter::exact('cle78'),

    
            AllowedFilter::exact('cle79'),

    
            AllowedFilter::exact('cle80'),

    
            AllowedFilter::exact('cle81'),

    
            AllowedFilter::exact('cle82'),

    
            AllowedFilter::exact('cle83'),

    
            AllowedFilter::exact('cle84'),

    
            AllowedFilter::exact('cle85'),

    
            AllowedFilter::exact('cle86'),

    
            AllowedFilter::exact('cle87'),

    
            AllowedFilter::exact('cle88'),

    
            AllowedFilter::exact('cle89'),

    
            AllowedFilter::exact('cle90'),

    
            AllowedFilter::exact('cle91'),

    
            AllowedFilter::exact('cle92'),

    
            AllowedFilter::exact('cle93'),

    
            AllowedFilter::exact('cle94'),

    
            AllowedFilter::exact('cle95'),

    
            AllowedFilter::exact('cle96'),

    
            AllowedFilter::exact('cle97'),

    
            AllowedFilter::exact('cle98'),

    
            AllowedFilter::exact('cle99'),

    
    
            AllowedFilter::exact('creat_by'),

    
    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
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

    
            AllowedSort::field('parent'),

    
            AllowedSort::field('form_id'),

    
            AllowedSort::field('cle0'),

    
            AllowedSort::field('cle1'),

    
            AllowedSort::field('cle2'),

    
            AllowedSort::field('cle3'),

    
            AllowedSort::field('cle4'),

    
            AllowedSort::field('cle5'),

    
            AllowedSort::field('cle6'),

    
            AllowedSort::field('cle7'),

    
            AllowedSort::field('cle8'),

    
            AllowedSort::field('cle9'),

    
            AllowedSort::field('cle10'),

    
            AllowedSort::field('cle11'),

    
            AllowedSort::field('cle12'),

    
            AllowedSort::field('cle13'),

    
            AllowedSort::field('cle14'),

    
            AllowedSort::field('cle15'),

    
            AllowedSort::field('cle16'),

    
            AllowedSort::field('cle17'),

    
            AllowedSort::field('cle18'),

    
            AllowedSort::field('cle19'),

    
            AllowedSort::field('cle20'),

    
            AllowedSort::field('cle21'),

    
            AllowedSort::field('cle22'),

    
            AllowedSort::field('cle23'),

    
            AllowedSort::field('cle24'),

    
            AllowedSort::field('cle25'),

    
            AllowedSort::field('cle26'),

    
            AllowedSort::field('cle27'),

    
            AllowedSort::field('cle28'),

    
            AllowedSort::field('cle29'),

    
            AllowedSort::field('cle30'),

    
            AllowedSort::field('cle31'),

    
            AllowedSort::field('cle32'),

    
            AllowedSort::field('cle33'),

    
            AllowedSort::field('cle34'),

    
            AllowedSort::field('cle35'),

    
            AllowedSort::field('cle36'),

    
            AllowedSort::field('cle37'),

    
            AllowedSort::field('cle38'),

    
            AllowedSort::field('cle39'),

    
            AllowedSort::field('cle40'),

    
            AllowedSort::field('cle41'),

    
            AllowedSort::field('cle42'),

    
            AllowedSort::field('cle43'),

    
            AllowedSort::field('cle44'),

    
            AllowedSort::field('cle45'),

    
            AllowedSort::field('cle46'),

    
            AllowedSort::field('cle47'),

    
            AllowedSort::field('cle48'),

    
            AllowedSort::field('cle49'),

    
            AllowedSort::field('cle50'),

    
            AllowedSort::field('cle51'),

    
            AllowedSort::field('cle52'),

    
            AllowedSort::field('cle53'),

    
            AllowedSort::field('cle54'),

    
            AllowedSort::field('cle55'),

    
            AllowedSort::field('cle56'),

    
            AllowedSort::field('cle57'),

    
            AllowedSort::field('cle58'),

    
            AllowedSort::field('cle59'),

    
            AllowedSort::field('cle60'),

    
            AllowedSort::field('cle61'),

    
            AllowedSort::field('cle62'),

    
            AllowedSort::field('cle63'),

    
            AllowedSort::field('cle64'),

    
            AllowedSort::field('cle65'),

    
            AllowedSort::field('cle66'),

    
            AllowedSort::field('cle67'),

    
            AllowedSort::field('cle68'),

    
            AllowedSort::field('cle69'),

    
            AllowedSort::field('cle70'),

    
            AllowedSort::field('cle71'),

    
            AllowedSort::field('cle72'),

    
            AllowedSort::field('cle73'),

    
            AllowedSort::field('cle74'),

    
            AllowedSort::field('cle75'),

    
            AllowedSort::field('cle76'),

    
            AllowedSort::field('cle77'),

    
            AllowedSort::field('cle78'),

    
            AllowedSort::field('cle79'),

    
            AllowedSort::field('cle80'),

    
            AllowedSort::field('cle81'),

    
            AllowedSort::field('cle82'),

    
            AllowedSort::field('cle83'),

    
            AllowedSort::field('cle84'),

    
            AllowedSort::field('cle85'),

    
            AllowedSort::field('cle86'),

    
            AllowedSort::field('cle87'),

    
            AllowedSort::field('cle88'),

    
            AllowedSort::field('cle89'),

    
            AllowedSort::field('cle90'),

    
            AllowedSort::field('cle91'),

    
            AllowedSort::field('cle92'),

    
            AllowedSort::field('cle93'),

    
            AllowedSort::field('cle94'),

    
            AllowedSort::field('cle95'),

    
            AllowedSort::field('cle96'),

    
            AllowedSort::field('cle97'),

    
            AllowedSort::field('cle98'),

    
            AllowedSort::field('cle99'),

    
    
            AllowedSort::field('creat_by'),

    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
->allowedIncludes([
            'form',
        

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



public function create(Request $request, Formsdata $Formsdatas)
{


try{
$can=\App\Helpers\Helpers::can('Creer des formsdatas');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "formsdatas"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'parent',
    'form_id',
    'cle0',
    'cle1',
    'cle2',
    'cle3',
    'cle4',
    'cle5',
    'cle6',
    'cle7',
    'cle8',
    'cle9',
    'cle10',
    'cle11',
    'cle12',
    'cle13',
    'cle14',
    'cle15',
    'cle16',
    'cle17',
    'cle18',
    'cle19',
    'cle20',
    'cle21',
    'cle22',
    'cle23',
    'cle24',
    'cle25',
    'cle26',
    'cle27',
    'cle28',
    'cle29',
    'cle30',
    'cle31',
    'cle32',
    'cle33',
    'cle34',
    'cle35',
    'cle36',
    'cle37',
    'cle38',
    'cle39',
    'cle40',
    'cle41',
    'cle42',
    'cle43',
    'cle44',
    'cle45',
    'cle46',
    'cle47',
    'cle48',
    'cle49',
    'cle50',
    'cle51',
    'cle52',
    'cle53',
    'cle54',
    'cle55',
    'cle56',
    'cle57',
    'cle58',
    'cle59',
    'cle60',
    'cle61',
    'cle62',
    'cle63',
    'cle64',
    'cle65',
    'cle66',
    'cle67',
    'cle68',
    'cle69',
    'cle70',
    'cle71',
    'cle72',
    'cle73',
    'cle74',
    'cle75',
    'cle76',
    'cle77',
    'cle78',
    'cle79',
    'cle80',
    'cle81',
    'cle82',
    'cle83',
    'cle84',
    'cle85',
    'cle86',
    'cle87',
    'cle88',
    'cle89',
    'cle90',
    'cle91',
    'cle92',
    'cle93',
    'cle94',
    'cle95',
    'cle96',
    'cle97',
    'cle98',
    'cle99',
    'extra_attributes',
    'creat_by',
    'deleted_at',
    'created_at',
    'updated_at',
    'identifiants_sadge',
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
        
    
    
                    'parent' => [
            //'required'
            ],
        
    
    
                    'form_id' => [
            //'required'
            ],
        
    
    
                    'cle0' => [
            //'required'
            ],
        
    
    
                    'cle1' => [
            //'required'
            ],
        
    
    
                    'cle2' => [
            //'required'
            ],
        
    
    
                    'cle3' => [
            //'required'
            ],
        
    
    
                    'cle4' => [
            //'required'
            ],
        
    
    
                    'cle5' => [
            //'required'
            ],
        
    
    
                    'cle6' => [
            //'required'
            ],
        
    
    
                    'cle7' => [
            //'required'
            ],
        
    
    
                    'cle8' => [
            //'required'
            ],
        
    
    
                    'cle9' => [
            //'required'
            ],
        
    
    
                    'cle10' => [
            //'required'
            ],
        
    
    
                    'cle11' => [
            //'required'
            ],
        
    
    
                    'cle12' => [
            //'required'
            ],
        
    
    
                    'cle13' => [
            //'required'
            ],
        
    
    
                    'cle14' => [
            //'required'
            ],
        
    
    
                    'cle15' => [
            //'required'
            ],
        
    
    
                    'cle16' => [
            //'required'
            ],
        
    
    
                    'cle17' => [
            //'required'
            ],
        
    
    
                    'cle18' => [
            //'required'
            ],
        
    
    
                    'cle19' => [
            //'required'
            ],
        
    
    
                    'cle20' => [
            //'required'
            ],
        
    
    
                    'cle21' => [
            //'required'
            ],
        
    
    
                    'cle22' => [
            //'required'
            ],
        
    
    
                    'cle23' => [
            //'required'
            ],
        
    
    
                    'cle24' => [
            //'required'
            ],
        
    
    
                    'cle25' => [
            //'required'
            ],
        
    
    
                    'cle26' => [
            //'required'
            ],
        
    
    
                    'cle27' => [
            //'required'
            ],
        
    
    
                    'cle28' => [
            //'required'
            ],
        
    
    
                    'cle29' => [
            //'required'
            ],
        
    
    
                    'cle30' => [
            //'required'
            ],
        
    
    
                    'cle31' => [
            //'required'
            ],
        
    
    
                    'cle32' => [
            //'required'
            ],
        
    
    
                    'cle33' => [
            //'required'
            ],
        
    
    
                    'cle34' => [
            //'required'
            ],
        
    
    
                    'cle35' => [
            //'required'
            ],
        
    
    
                    'cle36' => [
            //'required'
            ],
        
    
    
                    'cle37' => [
            //'required'
            ],
        
    
    
                    'cle38' => [
            //'required'
            ],
        
    
    
                    'cle39' => [
            //'required'
            ],
        
    
    
                    'cle40' => [
            //'required'
            ],
        
    
    
                    'cle41' => [
            //'required'
            ],
        
    
    
                    'cle42' => [
            //'required'
            ],
        
    
    
                    'cle43' => [
            //'required'
            ],
        
    
    
                    'cle44' => [
            //'required'
            ],
        
    
    
                    'cle45' => [
            //'required'
            ],
        
    
    
                    'cle46' => [
            //'required'
            ],
        
    
    
                    'cle47' => [
            //'required'
            ],
        
    
    
                    'cle48' => [
            //'required'
            ],
        
    
    
                    'cle49' => [
            //'required'
            ],
        
    
    
                    'cle50' => [
            //'required'
            ],
        
    
    
                    'cle51' => [
            //'required'
            ],
        
    
    
                    'cle52' => [
            //'required'
            ],
        
    
    
                    'cle53' => [
            //'required'
            ],
        
    
    
                    'cle54' => [
            //'required'
            ],
        
    
    
                    'cle55' => [
            //'required'
            ],
        
    
    
                    'cle56' => [
            //'required'
            ],
        
    
    
                    'cle57' => [
            //'required'
            ],
        
    
    
                    'cle58' => [
            //'required'
            ],
        
    
    
                    'cle59' => [
            //'required'
            ],
        
    
    
                    'cle60' => [
            //'required'
            ],
        
    
    
                    'cle61' => [
            //'required'
            ],
        
    
    
                    'cle62' => [
            //'required'
            ],
        
    
    
                    'cle63' => [
            //'required'
            ],
        
    
    
                    'cle64' => [
            //'required'
            ],
        
    
    
                    'cle65' => [
            //'required'
            ],
        
    
    
                    'cle66' => [
            //'required'
            ],
        
    
    
                    'cle67' => [
            //'required'
            ],
        
    
    
                    'cle68' => [
            //'required'
            ],
        
    
    
                    'cle69' => [
            //'required'
            ],
        
    
    
                    'cle70' => [
            //'required'
            ],
        
    
    
                    'cle71' => [
            //'required'
            ],
        
    
    
                    'cle72' => [
            //'required'
            ],
        
    
    
                    'cle73' => [
            //'required'
            ],
        
    
    
                    'cle74' => [
            //'required'
            ],
        
    
    
                    'cle75' => [
            //'required'
            ],
        
    
    
                    'cle76' => [
            //'required'
            ],
        
    
    
                    'cle77' => [
            //'required'
            ],
        
    
    
                    'cle78' => [
            //'required'
            ],
        
    
    
                    'cle79' => [
            //'required'
            ],
        
    
    
                    'cle80' => [
            //'required'
            ],
        
    
    
                    'cle81' => [
            //'required'
            ],
        
    
    
                    'cle82' => [
            //'required'
            ],
        
    
    
                    'cle83' => [
            //'required'
            ],
        
    
    
                    'cle84' => [
            //'required'
            ],
        
    
    
                    'cle85' => [
            //'required'
            ],
        
    
    
                    'cle86' => [
            //'required'
            ],
        
    
    
                    'cle87' => [
            //'required'
            ],
        
    
    
                    'cle88' => [
            //'required'
            ],
        
    
    
                    'cle89' => [
            //'required'
            ],
        
    
    
                    'cle90' => [
            //'required'
            ],
        
    
    
                    'cle91' => [
            //'required'
            ],
        
    
    
                    'cle92' => [
            //'required'
            ],
        
    
    
                    'cle93' => [
            //'required'
            ],
        
    
    
                    'cle94' => [
            //'required'
            ],
        
    
    
                    'cle95' => [
            //'required'
            ],
        
    
    
                    'cle96' => [
            //'required'
            ],
        
    
    
                    'cle97' => [
            //'required'
            ],
        
    
    
                    'cle98' => [
            //'required'
            ],
        
    
    
                    'cle99' => [
            //'required'
            ],
        
    
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'parent' => ['cette donnee est obligatoire'],

    
    
        'form_id' => ['cette donnee est obligatoire'],

    
    
        'cle0' => ['cette donnee est obligatoire'],

    
    
        'cle1' => ['cette donnee est obligatoire'],

    
    
        'cle2' => ['cette donnee est obligatoire'],

    
    
        'cle3' => ['cette donnee est obligatoire'],

    
    
        'cle4' => ['cette donnee est obligatoire'],

    
    
        'cle5' => ['cette donnee est obligatoire'],

    
    
        'cle6' => ['cette donnee est obligatoire'],

    
    
        'cle7' => ['cette donnee est obligatoire'],

    
    
        'cle8' => ['cette donnee est obligatoire'],

    
    
        'cle9' => ['cette donnee est obligatoire'],

    
    
        'cle10' => ['cette donnee est obligatoire'],

    
    
        'cle11' => ['cette donnee est obligatoire'],

    
    
        'cle12' => ['cette donnee est obligatoire'],

    
    
        'cle13' => ['cette donnee est obligatoire'],

    
    
        'cle14' => ['cette donnee est obligatoire'],

    
    
        'cle15' => ['cette donnee est obligatoire'],

    
    
        'cle16' => ['cette donnee est obligatoire'],

    
    
        'cle17' => ['cette donnee est obligatoire'],

    
    
        'cle18' => ['cette donnee est obligatoire'],

    
    
        'cle19' => ['cette donnee est obligatoire'],

    
    
        'cle20' => ['cette donnee est obligatoire'],

    
    
        'cle21' => ['cette donnee est obligatoire'],

    
    
        'cle22' => ['cette donnee est obligatoire'],

    
    
        'cle23' => ['cette donnee est obligatoire'],

    
    
        'cle24' => ['cette donnee est obligatoire'],

    
    
        'cle25' => ['cette donnee est obligatoire'],

    
    
        'cle26' => ['cette donnee est obligatoire'],

    
    
        'cle27' => ['cette donnee est obligatoire'],

    
    
        'cle28' => ['cette donnee est obligatoire'],

    
    
        'cle29' => ['cette donnee est obligatoire'],

    
    
        'cle30' => ['cette donnee est obligatoire'],

    
    
        'cle31' => ['cette donnee est obligatoire'],

    
    
        'cle32' => ['cette donnee est obligatoire'],

    
    
        'cle33' => ['cette donnee est obligatoire'],

    
    
        'cle34' => ['cette donnee est obligatoire'],

    
    
        'cle35' => ['cette donnee est obligatoire'],

    
    
        'cle36' => ['cette donnee est obligatoire'],

    
    
        'cle37' => ['cette donnee est obligatoire'],

    
    
        'cle38' => ['cette donnee est obligatoire'],

    
    
        'cle39' => ['cette donnee est obligatoire'],

    
    
        'cle40' => ['cette donnee est obligatoire'],

    
    
        'cle41' => ['cette donnee est obligatoire'],

    
    
        'cle42' => ['cette donnee est obligatoire'],

    
    
        'cle43' => ['cette donnee est obligatoire'],

    
    
        'cle44' => ['cette donnee est obligatoire'],

    
    
        'cle45' => ['cette donnee est obligatoire'],

    
    
        'cle46' => ['cette donnee est obligatoire'],

    
    
        'cle47' => ['cette donnee est obligatoire'],

    
    
        'cle48' => ['cette donnee est obligatoire'],

    
    
        'cle49' => ['cette donnee est obligatoire'],

    
    
        'cle50' => ['cette donnee est obligatoire'],

    
    
        'cle51' => ['cette donnee est obligatoire'],

    
    
        'cle52' => ['cette donnee est obligatoire'],

    
    
        'cle53' => ['cette donnee est obligatoire'],

    
    
        'cle54' => ['cette donnee est obligatoire'],

    
    
        'cle55' => ['cette donnee est obligatoire'],

    
    
        'cle56' => ['cette donnee est obligatoire'],

    
    
        'cle57' => ['cette donnee est obligatoire'],

    
    
        'cle58' => ['cette donnee est obligatoire'],

    
    
        'cle59' => ['cette donnee est obligatoire'],

    
    
        'cle60' => ['cette donnee est obligatoire'],

    
    
        'cle61' => ['cette donnee est obligatoire'],

    
    
        'cle62' => ['cette donnee est obligatoire'],

    
    
        'cle63' => ['cette donnee est obligatoire'],

    
    
        'cle64' => ['cette donnee est obligatoire'],

    
    
        'cle65' => ['cette donnee est obligatoire'],

    
    
        'cle66' => ['cette donnee est obligatoire'],

    
    
        'cle67' => ['cette donnee est obligatoire'],

    
    
        'cle68' => ['cette donnee est obligatoire'],

    
    
        'cle69' => ['cette donnee est obligatoire'],

    
    
        'cle70' => ['cette donnee est obligatoire'],

    
    
        'cle71' => ['cette donnee est obligatoire'],

    
    
        'cle72' => ['cette donnee est obligatoire'],

    
    
        'cle73' => ['cette donnee est obligatoire'],

    
    
        'cle74' => ['cette donnee est obligatoire'],

    
    
        'cle75' => ['cette donnee est obligatoire'],

    
    
        'cle76' => ['cette donnee est obligatoire'],

    
    
        'cle77' => ['cette donnee est obligatoire'],

    
    
        'cle78' => ['cette donnee est obligatoire'],

    
    
        'cle79' => ['cette donnee est obligatoire'],

    
    
        'cle80' => ['cette donnee est obligatoire'],

    
    
        'cle81' => ['cette donnee est obligatoire'],

    
    
        'cle82' => ['cette donnee est obligatoire'],

    
    
        'cle83' => ['cette donnee est obligatoire'],

    
    
        'cle84' => ['cette donnee est obligatoire'],

    
    
        'cle85' => ['cette donnee est obligatoire'],

    
    
        'cle86' => ['cette donnee est obligatoire'],

    
    
        'cle87' => ['cette donnee est obligatoire'],

    
    
        'cle88' => ['cette donnee est obligatoire'],

    
    
        'cle89' => ['cette donnee est obligatoire'],

    
    
        'cle90' => ['cette donnee est obligatoire'],

    
    
        'cle91' => ['cette donnee est obligatoire'],

    
    
        'cle92' => ['cette donnee est obligatoire'],

    
    
        'cle93' => ['cette donnee est obligatoire'],

    
    
        'cle94' => ['cette donnee est obligatoire'],

    
    
        'cle95' => ['cette donnee est obligatoire'],

    
    
        'cle96' => ['cette donnee est obligatoire'],

    
    
        'cle97' => ['cette donnee est obligatoire'],

    
    
        'cle98' => ['cette donnee est obligatoire'],

    
    
        'cle99' => ['cette donnee est obligatoire'],

    
    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['libelle'])){
        
            $Formsdatas->libelle = $data['libelle'];
        
        }



    







    

        if(!empty($data['parent'])){
        
            $Formsdatas->parent = $data['parent'];
        
        }



    







    

        if(!empty($data['form_id'])){
        
            $Formsdatas->form_id = $data['form_id'];
        
        }



    







    

        if(!empty($data['cle0'])){
        
            $Formsdatas->cle0 = $data['cle0'];
        
        }



    







    

        if(!empty($data['cle1'])){
        
            $Formsdatas->cle1 = $data['cle1'];
        
        }



    







    

        if(!empty($data['cle2'])){
        
            $Formsdatas->cle2 = $data['cle2'];
        
        }



    







    

        if(!empty($data['cle3'])){
        
            $Formsdatas->cle3 = $data['cle3'];
        
        }



    







    

        if(!empty($data['cle4'])){
        
            $Formsdatas->cle4 = $data['cle4'];
        
        }



    







    

        if(!empty($data['cle5'])){
        
            $Formsdatas->cle5 = $data['cle5'];
        
        }



    







    

        if(!empty($data['cle6'])){
        
            $Formsdatas->cle6 = $data['cle6'];
        
        }



    







    

        if(!empty($data['cle7'])){
        
            $Formsdatas->cle7 = $data['cle7'];
        
        }



    







    

        if(!empty($data['cle8'])){
        
            $Formsdatas->cle8 = $data['cle8'];
        
        }



    







    

        if(!empty($data['cle9'])){
        
            $Formsdatas->cle9 = $data['cle9'];
        
        }



    







    

        if(!empty($data['cle10'])){
        
            $Formsdatas->cle10 = $data['cle10'];
        
        }



    







    

        if(!empty($data['cle11'])){
        
            $Formsdatas->cle11 = $data['cle11'];
        
        }



    







    

        if(!empty($data['cle12'])){
        
            $Formsdatas->cle12 = $data['cle12'];
        
        }



    







    

        if(!empty($data['cle13'])){
        
            $Formsdatas->cle13 = $data['cle13'];
        
        }



    







    

        if(!empty($data['cle14'])){
        
            $Formsdatas->cle14 = $data['cle14'];
        
        }



    







    

        if(!empty($data['cle15'])){
        
            $Formsdatas->cle15 = $data['cle15'];
        
        }



    







    

        if(!empty($data['cle16'])){
        
            $Formsdatas->cle16 = $data['cle16'];
        
        }



    







    

        if(!empty($data['cle17'])){
        
            $Formsdatas->cle17 = $data['cle17'];
        
        }



    







    

        if(!empty($data['cle18'])){
        
            $Formsdatas->cle18 = $data['cle18'];
        
        }



    







    

        if(!empty($data['cle19'])){
        
            $Formsdatas->cle19 = $data['cle19'];
        
        }



    







    

        if(!empty($data['cle20'])){
        
            $Formsdatas->cle20 = $data['cle20'];
        
        }



    







    

        if(!empty($data['cle21'])){
        
            $Formsdatas->cle21 = $data['cle21'];
        
        }



    







    

        if(!empty($data['cle22'])){
        
            $Formsdatas->cle22 = $data['cle22'];
        
        }



    







    

        if(!empty($data['cle23'])){
        
            $Formsdatas->cle23 = $data['cle23'];
        
        }



    







    

        if(!empty($data['cle24'])){
        
            $Formsdatas->cle24 = $data['cle24'];
        
        }



    







    

        if(!empty($data['cle25'])){
        
            $Formsdatas->cle25 = $data['cle25'];
        
        }



    







    

        if(!empty($data['cle26'])){
        
            $Formsdatas->cle26 = $data['cle26'];
        
        }



    







    

        if(!empty($data['cle27'])){
        
            $Formsdatas->cle27 = $data['cle27'];
        
        }



    







    

        if(!empty($data['cle28'])){
        
            $Formsdatas->cle28 = $data['cle28'];
        
        }



    







    

        if(!empty($data['cle29'])){
        
            $Formsdatas->cle29 = $data['cle29'];
        
        }



    







    

        if(!empty($data['cle30'])){
        
            $Formsdatas->cle30 = $data['cle30'];
        
        }



    







    

        if(!empty($data['cle31'])){
        
            $Formsdatas->cle31 = $data['cle31'];
        
        }



    







    

        if(!empty($data['cle32'])){
        
            $Formsdatas->cle32 = $data['cle32'];
        
        }



    







    

        if(!empty($data['cle33'])){
        
            $Formsdatas->cle33 = $data['cle33'];
        
        }



    







    

        if(!empty($data['cle34'])){
        
            $Formsdatas->cle34 = $data['cle34'];
        
        }



    







    

        if(!empty($data['cle35'])){
        
            $Formsdatas->cle35 = $data['cle35'];
        
        }



    







    

        if(!empty($data['cle36'])){
        
            $Formsdatas->cle36 = $data['cle36'];
        
        }



    







    

        if(!empty($data['cle37'])){
        
            $Formsdatas->cle37 = $data['cle37'];
        
        }



    







    

        if(!empty($data['cle38'])){
        
            $Formsdatas->cle38 = $data['cle38'];
        
        }



    







    

        if(!empty($data['cle39'])){
        
            $Formsdatas->cle39 = $data['cle39'];
        
        }



    







    

        if(!empty($data['cle40'])){
        
            $Formsdatas->cle40 = $data['cle40'];
        
        }



    







    

        if(!empty($data['cle41'])){
        
            $Formsdatas->cle41 = $data['cle41'];
        
        }



    







    

        if(!empty($data['cle42'])){
        
            $Formsdatas->cle42 = $data['cle42'];
        
        }



    







    

        if(!empty($data['cle43'])){
        
            $Formsdatas->cle43 = $data['cle43'];
        
        }



    







    

        if(!empty($data['cle44'])){
        
            $Formsdatas->cle44 = $data['cle44'];
        
        }



    







    

        if(!empty($data['cle45'])){
        
            $Formsdatas->cle45 = $data['cle45'];
        
        }



    







    

        if(!empty($data['cle46'])){
        
            $Formsdatas->cle46 = $data['cle46'];
        
        }



    







    

        if(!empty($data['cle47'])){
        
            $Formsdatas->cle47 = $data['cle47'];
        
        }



    







    

        if(!empty($data['cle48'])){
        
            $Formsdatas->cle48 = $data['cle48'];
        
        }



    







    

        if(!empty($data['cle49'])){
        
            $Formsdatas->cle49 = $data['cle49'];
        
        }



    







    

        if(!empty($data['cle50'])){
        
            $Formsdatas->cle50 = $data['cle50'];
        
        }



    







    

        if(!empty($data['cle51'])){
        
            $Formsdatas->cle51 = $data['cle51'];
        
        }



    







    

        if(!empty($data['cle52'])){
        
            $Formsdatas->cle52 = $data['cle52'];
        
        }



    







    

        if(!empty($data['cle53'])){
        
            $Formsdatas->cle53 = $data['cle53'];
        
        }



    







    

        if(!empty($data['cle54'])){
        
            $Formsdatas->cle54 = $data['cle54'];
        
        }



    







    

        if(!empty($data['cle55'])){
        
            $Formsdatas->cle55 = $data['cle55'];
        
        }



    







    

        if(!empty($data['cle56'])){
        
            $Formsdatas->cle56 = $data['cle56'];
        
        }



    







    

        if(!empty($data['cle57'])){
        
            $Formsdatas->cle57 = $data['cle57'];
        
        }



    







    

        if(!empty($data['cle58'])){
        
            $Formsdatas->cle58 = $data['cle58'];
        
        }



    







    

        if(!empty($data['cle59'])){
        
            $Formsdatas->cle59 = $data['cle59'];
        
        }



    







    

        if(!empty($data['cle60'])){
        
            $Formsdatas->cle60 = $data['cle60'];
        
        }



    







    

        if(!empty($data['cle61'])){
        
            $Formsdatas->cle61 = $data['cle61'];
        
        }



    







    

        if(!empty($data['cle62'])){
        
            $Formsdatas->cle62 = $data['cle62'];
        
        }



    







    

        if(!empty($data['cle63'])){
        
            $Formsdatas->cle63 = $data['cle63'];
        
        }



    







    

        if(!empty($data['cle64'])){
        
            $Formsdatas->cle64 = $data['cle64'];
        
        }



    







    

        if(!empty($data['cle65'])){
        
            $Formsdatas->cle65 = $data['cle65'];
        
        }



    







    

        if(!empty($data['cle66'])){
        
            $Formsdatas->cle66 = $data['cle66'];
        
        }



    







    

        if(!empty($data['cle67'])){
        
            $Formsdatas->cle67 = $data['cle67'];
        
        }



    







    

        if(!empty($data['cle68'])){
        
            $Formsdatas->cle68 = $data['cle68'];
        
        }



    







    

        if(!empty($data['cle69'])){
        
            $Formsdatas->cle69 = $data['cle69'];
        
        }



    







    

        if(!empty($data['cle70'])){
        
            $Formsdatas->cle70 = $data['cle70'];
        
        }



    







    

        if(!empty($data['cle71'])){
        
            $Formsdatas->cle71 = $data['cle71'];
        
        }



    







    

        if(!empty($data['cle72'])){
        
            $Formsdatas->cle72 = $data['cle72'];
        
        }



    







    

        if(!empty($data['cle73'])){
        
            $Formsdatas->cle73 = $data['cle73'];
        
        }



    







    

        if(!empty($data['cle74'])){
        
            $Formsdatas->cle74 = $data['cle74'];
        
        }



    







    

        if(!empty($data['cle75'])){
        
            $Formsdatas->cle75 = $data['cle75'];
        
        }



    







    

        if(!empty($data['cle76'])){
        
            $Formsdatas->cle76 = $data['cle76'];
        
        }



    







    

        if(!empty($data['cle77'])){
        
            $Formsdatas->cle77 = $data['cle77'];
        
        }



    







    

        if(!empty($data['cle78'])){
        
            $Formsdatas->cle78 = $data['cle78'];
        
        }



    







    

        if(!empty($data['cle79'])){
        
            $Formsdatas->cle79 = $data['cle79'];
        
        }



    







    

        if(!empty($data['cle80'])){
        
            $Formsdatas->cle80 = $data['cle80'];
        
        }



    







    

        if(!empty($data['cle81'])){
        
            $Formsdatas->cle81 = $data['cle81'];
        
        }



    







    

        if(!empty($data['cle82'])){
        
            $Formsdatas->cle82 = $data['cle82'];
        
        }



    







    

        if(!empty($data['cle83'])){
        
            $Formsdatas->cle83 = $data['cle83'];
        
        }



    







    

        if(!empty($data['cle84'])){
        
            $Formsdatas->cle84 = $data['cle84'];
        
        }



    







    

        if(!empty($data['cle85'])){
        
            $Formsdatas->cle85 = $data['cle85'];
        
        }



    







    

        if(!empty($data['cle86'])){
        
            $Formsdatas->cle86 = $data['cle86'];
        
        }



    







    

        if(!empty($data['cle87'])){
        
            $Formsdatas->cle87 = $data['cle87'];
        
        }



    







    

        if(!empty($data['cle88'])){
        
            $Formsdatas->cle88 = $data['cle88'];
        
        }



    







    

        if(!empty($data['cle89'])){
        
            $Formsdatas->cle89 = $data['cle89'];
        
        }



    







    

        if(!empty($data['cle90'])){
        
            $Formsdatas->cle90 = $data['cle90'];
        
        }



    







    

        if(!empty($data['cle91'])){
        
            $Formsdatas->cle91 = $data['cle91'];
        
        }



    







    

        if(!empty($data['cle92'])){
        
            $Formsdatas->cle92 = $data['cle92'];
        
        }



    







    

        if(!empty($data['cle93'])){
        
            $Formsdatas->cle93 = $data['cle93'];
        
        }



    







    

        if(!empty($data['cle94'])){
        
            $Formsdatas->cle94 = $data['cle94'];
        
        }



    







    

        if(!empty($data['cle95'])){
        
            $Formsdatas->cle95 = $data['cle95'];
        
        }



    







    

        if(!empty($data['cle96'])){
        
            $Formsdatas->cle96 = $data['cle96'];
        
        }



    







    

        if(!empty($data['cle97'])){
        
            $Formsdatas->cle97 = $data['cle97'];
        
        }



    







    

        if(!empty($data['cle98'])){
        
            $Formsdatas->cle98 = $data['cle98'];
        
        }



    







    

        if(!empty($data['cle99'])){
        
            $Formsdatas->cle99 = $data['cle99'];
        
        }



    







    







    

        if(!empty($data['creat_by'])){
        
            $Formsdatas->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Formsdatas->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Formsdatas->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\FormsdataExtras') &&
method_exists('\App\Http\Extras\FormsdataExtras', 'beforeSaveCreate')
){
\App\Http\Extras\FormsdataExtras::beforeSaveCreate($request,$Formsdatas);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\FormsdataExtras') &&
method_exists('\App\Http\Extras\FormsdataExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\FormsdataExtras::canCreate($request, $Formsdatas);
}catch (\Throwable $e){

}

}


if($canSave){
$Formsdatas->save();
}else{
return response()->json($Formsdatas, 200);
}

$Formsdatas=Formsdata::find($Formsdatas->id);
$newCrudData=[];

                $newCrudData['libelle']=$Formsdatas->libelle;
                $newCrudData['parent']=$Formsdatas->parent;
                $newCrudData['form_id']=$Formsdatas->form_id;
                $newCrudData['cle0']=$Formsdatas->cle0;
                $newCrudData['cle1']=$Formsdatas->cle1;
                $newCrudData['cle2']=$Formsdatas->cle2;
                $newCrudData['cle3']=$Formsdatas->cle3;
                $newCrudData['cle4']=$Formsdatas->cle4;
                $newCrudData['cle5']=$Formsdatas->cle5;
                $newCrudData['cle6']=$Formsdatas->cle6;
                $newCrudData['cle7']=$Formsdatas->cle7;
                $newCrudData['cle8']=$Formsdatas->cle8;
                $newCrudData['cle9']=$Formsdatas->cle9;
                $newCrudData['cle10']=$Formsdatas->cle10;
                $newCrudData['cle11']=$Formsdatas->cle11;
                $newCrudData['cle12']=$Formsdatas->cle12;
                $newCrudData['cle13']=$Formsdatas->cle13;
                $newCrudData['cle14']=$Formsdatas->cle14;
                $newCrudData['cle15']=$Formsdatas->cle15;
                $newCrudData['cle16']=$Formsdatas->cle16;
                $newCrudData['cle17']=$Formsdatas->cle17;
                $newCrudData['cle18']=$Formsdatas->cle18;
                $newCrudData['cle19']=$Formsdatas->cle19;
                $newCrudData['cle20']=$Formsdatas->cle20;
                $newCrudData['cle21']=$Formsdatas->cle21;
                $newCrudData['cle22']=$Formsdatas->cle22;
                $newCrudData['cle23']=$Formsdatas->cle23;
                $newCrudData['cle24']=$Formsdatas->cle24;
                $newCrudData['cle25']=$Formsdatas->cle25;
                $newCrudData['cle26']=$Formsdatas->cle26;
                $newCrudData['cle27']=$Formsdatas->cle27;
                $newCrudData['cle28']=$Formsdatas->cle28;
                $newCrudData['cle29']=$Formsdatas->cle29;
                $newCrudData['cle30']=$Formsdatas->cle30;
                $newCrudData['cle31']=$Formsdatas->cle31;
                $newCrudData['cle32']=$Formsdatas->cle32;
                $newCrudData['cle33']=$Formsdatas->cle33;
                $newCrudData['cle34']=$Formsdatas->cle34;
                $newCrudData['cle35']=$Formsdatas->cle35;
                $newCrudData['cle36']=$Formsdatas->cle36;
                $newCrudData['cle37']=$Formsdatas->cle37;
                $newCrudData['cle38']=$Formsdatas->cle38;
                $newCrudData['cle39']=$Formsdatas->cle39;
                $newCrudData['cle40']=$Formsdatas->cle40;
                $newCrudData['cle41']=$Formsdatas->cle41;
                $newCrudData['cle42']=$Formsdatas->cle42;
                $newCrudData['cle43']=$Formsdatas->cle43;
                $newCrudData['cle44']=$Formsdatas->cle44;
                $newCrudData['cle45']=$Formsdatas->cle45;
                $newCrudData['cle46']=$Formsdatas->cle46;
                $newCrudData['cle47']=$Formsdatas->cle47;
                $newCrudData['cle48']=$Formsdatas->cle48;
                $newCrudData['cle49']=$Formsdatas->cle49;
                $newCrudData['cle50']=$Formsdatas->cle50;
                $newCrudData['cle51']=$Formsdatas->cle51;
                $newCrudData['cle52']=$Formsdatas->cle52;
                $newCrudData['cle53']=$Formsdatas->cle53;
                $newCrudData['cle54']=$Formsdatas->cle54;
                $newCrudData['cle55']=$Formsdatas->cle55;
                $newCrudData['cle56']=$Formsdatas->cle56;
                $newCrudData['cle57']=$Formsdatas->cle57;
                $newCrudData['cle58']=$Formsdatas->cle58;
                $newCrudData['cle59']=$Formsdatas->cle59;
                $newCrudData['cle60']=$Formsdatas->cle60;
                $newCrudData['cle61']=$Formsdatas->cle61;
                $newCrudData['cle62']=$Formsdatas->cle62;
                $newCrudData['cle63']=$Formsdatas->cle63;
                $newCrudData['cle64']=$Formsdatas->cle64;
                $newCrudData['cle65']=$Formsdatas->cle65;
                $newCrudData['cle66']=$Formsdatas->cle66;
                $newCrudData['cle67']=$Formsdatas->cle67;
                $newCrudData['cle68']=$Formsdatas->cle68;
                $newCrudData['cle69']=$Formsdatas->cle69;
                $newCrudData['cle70']=$Formsdatas->cle70;
                $newCrudData['cle71']=$Formsdatas->cle71;
                $newCrudData['cle72']=$Formsdatas->cle72;
                $newCrudData['cle73']=$Formsdatas->cle73;
                $newCrudData['cle74']=$Formsdatas->cle74;
                $newCrudData['cle75']=$Formsdatas->cle75;
                $newCrudData['cle76']=$Formsdatas->cle76;
                $newCrudData['cle77']=$Formsdatas->cle77;
                $newCrudData['cle78']=$Formsdatas->cle78;
                $newCrudData['cle79']=$Formsdatas->cle79;
                $newCrudData['cle80']=$Formsdatas->cle80;
                $newCrudData['cle81']=$Formsdatas->cle81;
                $newCrudData['cle82']=$Formsdatas->cle82;
                $newCrudData['cle83']=$Formsdatas->cle83;
                $newCrudData['cle84']=$Formsdatas->cle84;
                $newCrudData['cle85']=$Formsdatas->cle85;
                $newCrudData['cle86']=$Formsdatas->cle86;
                $newCrudData['cle87']=$Formsdatas->cle87;
                $newCrudData['cle88']=$Formsdatas->cle88;
                $newCrudData['cle89']=$Formsdatas->cle89;
                $newCrudData['cle90']=$Formsdatas->cle90;
                $newCrudData['cle91']=$Formsdatas->cle91;
                $newCrudData['cle92']=$Formsdatas->cle92;
                $newCrudData['cle93']=$Formsdatas->cle93;
                $newCrudData['cle94']=$Formsdatas->cle94;
                $newCrudData['cle95']=$Formsdatas->cle95;
                $newCrudData['cle96']=$Formsdatas->cle96;
                $newCrudData['cle97']=$Formsdatas->cle97;
                $newCrudData['cle98']=$Formsdatas->cle98;
                $newCrudData['cle99']=$Formsdatas->cle99;
                    $newCrudData['creat_by']=$Formsdatas->creat_by;
                            $newCrudData['identifiants_sadge']=$Formsdatas->identifiants_sadge;
    
 try{ $newCrudData['form']=$Formsdatas->form->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Formsdatas','entite_cle' => $Formsdatas->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Formsdatas->toArray();




try{

foreach ($Formsdatas->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Formsdata $Formsdatas)
{
try{
$can=\App\Helpers\Helpers::can('Editer des formsdatas');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['libelle']=$Formsdatas->libelle;
                $oldCrudData['parent']=$Formsdatas->parent;
                $oldCrudData['form_id']=$Formsdatas->form_id;
                $oldCrudData['cle0']=$Formsdatas->cle0;
                $oldCrudData['cle1']=$Formsdatas->cle1;
                $oldCrudData['cle2']=$Formsdatas->cle2;
                $oldCrudData['cle3']=$Formsdatas->cle3;
                $oldCrudData['cle4']=$Formsdatas->cle4;
                $oldCrudData['cle5']=$Formsdatas->cle5;
                $oldCrudData['cle6']=$Formsdatas->cle6;
                $oldCrudData['cle7']=$Formsdatas->cle7;
                $oldCrudData['cle8']=$Formsdatas->cle8;
                $oldCrudData['cle9']=$Formsdatas->cle9;
                $oldCrudData['cle10']=$Formsdatas->cle10;
                $oldCrudData['cle11']=$Formsdatas->cle11;
                $oldCrudData['cle12']=$Formsdatas->cle12;
                $oldCrudData['cle13']=$Formsdatas->cle13;
                $oldCrudData['cle14']=$Formsdatas->cle14;
                $oldCrudData['cle15']=$Formsdatas->cle15;
                $oldCrudData['cle16']=$Formsdatas->cle16;
                $oldCrudData['cle17']=$Formsdatas->cle17;
                $oldCrudData['cle18']=$Formsdatas->cle18;
                $oldCrudData['cle19']=$Formsdatas->cle19;
                $oldCrudData['cle20']=$Formsdatas->cle20;
                $oldCrudData['cle21']=$Formsdatas->cle21;
                $oldCrudData['cle22']=$Formsdatas->cle22;
                $oldCrudData['cle23']=$Formsdatas->cle23;
                $oldCrudData['cle24']=$Formsdatas->cle24;
                $oldCrudData['cle25']=$Formsdatas->cle25;
                $oldCrudData['cle26']=$Formsdatas->cle26;
                $oldCrudData['cle27']=$Formsdatas->cle27;
                $oldCrudData['cle28']=$Formsdatas->cle28;
                $oldCrudData['cle29']=$Formsdatas->cle29;
                $oldCrudData['cle30']=$Formsdatas->cle30;
                $oldCrudData['cle31']=$Formsdatas->cle31;
                $oldCrudData['cle32']=$Formsdatas->cle32;
                $oldCrudData['cle33']=$Formsdatas->cle33;
                $oldCrudData['cle34']=$Formsdatas->cle34;
                $oldCrudData['cle35']=$Formsdatas->cle35;
                $oldCrudData['cle36']=$Formsdatas->cle36;
                $oldCrudData['cle37']=$Formsdatas->cle37;
                $oldCrudData['cle38']=$Formsdatas->cle38;
                $oldCrudData['cle39']=$Formsdatas->cle39;
                $oldCrudData['cle40']=$Formsdatas->cle40;
                $oldCrudData['cle41']=$Formsdatas->cle41;
                $oldCrudData['cle42']=$Formsdatas->cle42;
                $oldCrudData['cle43']=$Formsdatas->cle43;
                $oldCrudData['cle44']=$Formsdatas->cle44;
                $oldCrudData['cle45']=$Formsdatas->cle45;
                $oldCrudData['cle46']=$Formsdatas->cle46;
                $oldCrudData['cle47']=$Formsdatas->cle47;
                $oldCrudData['cle48']=$Formsdatas->cle48;
                $oldCrudData['cle49']=$Formsdatas->cle49;
                $oldCrudData['cle50']=$Formsdatas->cle50;
                $oldCrudData['cle51']=$Formsdatas->cle51;
                $oldCrudData['cle52']=$Formsdatas->cle52;
                $oldCrudData['cle53']=$Formsdatas->cle53;
                $oldCrudData['cle54']=$Formsdatas->cle54;
                $oldCrudData['cle55']=$Formsdatas->cle55;
                $oldCrudData['cle56']=$Formsdatas->cle56;
                $oldCrudData['cle57']=$Formsdatas->cle57;
                $oldCrudData['cle58']=$Formsdatas->cle58;
                $oldCrudData['cle59']=$Formsdatas->cle59;
                $oldCrudData['cle60']=$Formsdatas->cle60;
                $oldCrudData['cle61']=$Formsdatas->cle61;
                $oldCrudData['cle62']=$Formsdatas->cle62;
                $oldCrudData['cle63']=$Formsdatas->cle63;
                $oldCrudData['cle64']=$Formsdatas->cle64;
                $oldCrudData['cle65']=$Formsdatas->cle65;
                $oldCrudData['cle66']=$Formsdatas->cle66;
                $oldCrudData['cle67']=$Formsdatas->cle67;
                $oldCrudData['cle68']=$Formsdatas->cle68;
                $oldCrudData['cle69']=$Formsdatas->cle69;
                $oldCrudData['cle70']=$Formsdatas->cle70;
                $oldCrudData['cle71']=$Formsdatas->cle71;
                $oldCrudData['cle72']=$Formsdatas->cle72;
                $oldCrudData['cle73']=$Formsdatas->cle73;
                $oldCrudData['cle74']=$Formsdatas->cle74;
                $oldCrudData['cle75']=$Formsdatas->cle75;
                $oldCrudData['cle76']=$Formsdatas->cle76;
                $oldCrudData['cle77']=$Formsdatas->cle77;
                $oldCrudData['cle78']=$Formsdatas->cle78;
                $oldCrudData['cle79']=$Formsdatas->cle79;
                $oldCrudData['cle80']=$Formsdatas->cle80;
                $oldCrudData['cle81']=$Formsdatas->cle81;
                $oldCrudData['cle82']=$Formsdatas->cle82;
                $oldCrudData['cle83']=$Formsdatas->cle83;
                $oldCrudData['cle84']=$Formsdatas->cle84;
                $oldCrudData['cle85']=$Formsdatas->cle85;
                $oldCrudData['cle86']=$Formsdatas->cle86;
                $oldCrudData['cle87']=$Formsdatas->cle87;
                $oldCrudData['cle88']=$Formsdatas->cle88;
                $oldCrudData['cle89']=$Formsdatas->cle89;
                $oldCrudData['cle90']=$Formsdatas->cle90;
                $oldCrudData['cle91']=$Formsdatas->cle91;
                $oldCrudData['cle92']=$Formsdatas->cle92;
                $oldCrudData['cle93']=$Formsdatas->cle93;
                $oldCrudData['cle94']=$Formsdatas->cle94;
                $oldCrudData['cle95']=$Formsdatas->cle95;
                $oldCrudData['cle96']=$Formsdatas->cle96;
                $oldCrudData['cle97']=$Formsdatas->cle97;
                $oldCrudData['cle98']=$Formsdatas->cle98;
                $oldCrudData['cle99']=$Formsdatas->cle99;
                    $oldCrudData['creat_by']=$Formsdatas->creat_by;
                            $oldCrudData['identifiants_sadge']=$Formsdatas->identifiants_sadge;
    
 try{ $oldCrudData['form']=$Formsdatas->form->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "formsdatas"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'libelle',
    'parent',
    'form_id',
    'cle0',
    'cle1',
    'cle2',
    'cle3',
    'cle4',
    'cle5',
    'cle6',
    'cle7',
    'cle8',
    'cle9',
    'cle10',
    'cle11',
    'cle12',
    'cle13',
    'cle14',
    'cle15',
    'cle16',
    'cle17',
    'cle18',
    'cle19',
    'cle20',
    'cle21',
    'cle22',
    'cle23',
    'cle24',
    'cle25',
    'cle26',
    'cle27',
    'cle28',
    'cle29',
    'cle30',
    'cle31',
    'cle32',
    'cle33',
    'cle34',
    'cle35',
    'cle36',
    'cle37',
    'cle38',
    'cle39',
    'cle40',
    'cle41',
    'cle42',
    'cle43',
    'cle44',
    'cle45',
    'cle46',
    'cle47',
    'cle48',
    'cle49',
    'cle50',
    'cle51',
    'cle52',
    'cle53',
    'cle54',
    'cle55',
    'cle56',
    'cle57',
    'cle58',
    'cle59',
    'cle60',
    'cle61',
    'cle62',
    'cle63',
    'cle64',
    'cle65',
    'cle66',
    'cle67',
    'cle68',
    'cle69',
    'cle70',
    'cle71',
    'cle72',
    'cle73',
    'cle74',
    'cle75',
    'cle76',
    'cle77',
    'cle78',
    'cle79',
    'cle80',
    'cle81',
    'cle82',
    'cle83',
    'cle84',
    'cle85',
    'cle86',
    'cle87',
    'cle88',
    'cle89',
    'cle90',
    'cle91',
    'cle92',
    'cle93',
    'cle94',
    'cle95',
    'cle96',
    'cle97',
    'cle98',
    'cle99',
    'extra_attributes',
    'creat_by',
    'deleted_at',
    'created_at',
    'updated_at',
    'identifiants_sadge',
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
        
    
    
                    'parent' => [
            //'required'
            ],
        
    
    
                    'form_id' => [
            //'required'
            ],
        
    
    
                    'cle0' => [
            //'required'
            ],
        
    
    
                    'cle1' => [
            //'required'
            ],
        
    
    
                    'cle2' => [
            //'required'
            ],
        
    
    
                    'cle3' => [
            //'required'
            ],
        
    
    
                    'cle4' => [
            //'required'
            ],
        
    
    
                    'cle5' => [
            //'required'
            ],
        
    
    
                    'cle6' => [
            //'required'
            ],
        
    
    
                    'cle7' => [
            //'required'
            ],
        
    
    
                    'cle8' => [
            //'required'
            ],
        
    
    
                    'cle9' => [
            //'required'
            ],
        
    
    
                    'cle10' => [
            //'required'
            ],
        
    
    
                    'cle11' => [
            //'required'
            ],
        
    
    
                    'cle12' => [
            //'required'
            ],
        
    
    
                    'cle13' => [
            //'required'
            ],
        
    
    
                    'cle14' => [
            //'required'
            ],
        
    
    
                    'cle15' => [
            //'required'
            ],
        
    
    
                    'cle16' => [
            //'required'
            ],
        
    
    
                    'cle17' => [
            //'required'
            ],
        
    
    
                    'cle18' => [
            //'required'
            ],
        
    
    
                    'cle19' => [
            //'required'
            ],
        
    
    
                    'cle20' => [
            //'required'
            ],
        
    
    
                    'cle21' => [
            //'required'
            ],
        
    
    
                    'cle22' => [
            //'required'
            ],
        
    
    
                    'cle23' => [
            //'required'
            ],
        
    
    
                    'cle24' => [
            //'required'
            ],
        
    
    
                    'cle25' => [
            //'required'
            ],
        
    
    
                    'cle26' => [
            //'required'
            ],
        
    
    
                    'cle27' => [
            //'required'
            ],
        
    
    
                    'cle28' => [
            //'required'
            ],
        
    
    
                    'cle29' => [
            //'required'
            ],
        
    
    
                    'cle30' => [
            //'required'
            ],
        
    
    
                    'cle31' => [
            //'required'
            ],
        
    
    
                    'cle32' => [
            //'required'
            ],
        
    
    
                    'cle33' => [
            //'required'
            ],
        
    
    
                    'cle34' => [
            //'required'
            ],
        
    
    
                    'cle35' => [
            //'required'
            ],
        
    
    
                    'cle36' => [
            //'required'
            ],
        
    
    
                    'cle37' => [
            //'required'
            ],
        
    
    
                    'cle38' => [
            //'required'
            ],
        
    
    
                    'cle39' => [
            //'required'
            ],
        
    
    
                    'cle40' => [
            //'required'
            ],
        
    
    
                    'cle41' => [
            //'required'
            ],
        
    
    
                    'cle42' => [
            //'required'
            ],
        
    
    
                    'cle43' => [
            //'required'
            ],
        
    
    
                    'cle44' => [
            //'required'
            ],
        
    
    
                    'cle45' => [
            //'required'
            ],
        
    
    
                    'cle46' => [
            //'required'
            ],
        
    
    
                    'cle47' => [
            //'required'
            ],
        
    
    
                    'cle48' => [
            //'required'
            ],
        
    
    
                    'cle49' => [
            //'required'
            ],
        
    
    
                    'cle50' => [
            //'required'
            ],
        
    
    
                    'cle51' => [
            //'required'
            ],
        
    
    
                    'cle52' => [
            //'required'
            ],
        
    
    
                    'cle53' => [
            //'required'
            ],
        
    
    
                    'cle54' => [
            //'required'
            ],
        
    
    
                    'cle55' => [
            //'required'
            ],
        
    
    
                    'cle56' => [
            //'required'
            ],
        
    
    
                    'cle57' => [
            //'required'
            ],
        
    
    
                    'cle58' => [
            //'required'
            ],
        
    
    
                    'cle59' => [
            //'required'
            ],
        
    
    
                    'cle60' => [
            //'required'
            ],
        
    
    
                    'cle61' => [
            //'required'
            ],
        
    
    
                    'cle62' => [
            //'required'
            ],
        
    
    
                    'cle63' => [
            //'required'
            ],
        
    
    
                    'cle64' => [
            //'required'
            ],
        
    
    
                    'cle65' => [
            //'required'
            ],
        
    
    
                    'cle66' => [
            //'required'
            ],
        
    
    
                    'cle67' => [
            //'required'
            ],
        
    
    
                    'cle68' => [
            //'required'
            ],
        
    
    
                    'cle69' => [
            //'required'
            ],
        
    
    
                    'cle70' => [
            //'required'
            ],
        
    
    
                    'cle71' => [
            //'required'
            ],
        
    
    
                    'cle72' => [
            //'required'
            ],
        
    
    
                    'cle73' => [
            //'required'
            ],
        
    
    
                    'cle74' => [
            //'required'
            ],
        
    
    
                    'cle75' => [
            //'required'
            ],
        
    
    
                    'cle76' => [
            //'required'
            ],
        
    
    
                    'cle77' => [
            //'required'
            ],
        
    
    
                    'cle78' => [
            //'required'
            ],
        
    
    
                    'cle79' => [
            //'required'
            ],
        
    
    
                    'cle80' => [
            //'required'
            ],
        
    
    
                    'cle81' => [
            //'required'
            ],
        
    
    
                    'cle82' => [
            //'required'
            ],
        
    
    
                    'cle83' => [
            //'required'
            ],
        
    
    
                    'cle84' => [
            //'required'
            ],
        
    
    
                    'cle85' => [
            //'required'
            ],
        
    
    
                    'cle86' => [
            //'required'
            ],
        
    
    
                    'cle87' => [
            //'required'
            ],
        
    
    
                    'cle88' => [
            //'required'
            ],
        
    
    
                    'cle89' => [
            //'required'
            ],
        
    
    
                    'cle90' => [
            //'required'
            ],
        
    
    
                    'cle91' => [
            //'required'
            ],
        
    
    
                    'cle92' => [
            //'required'
            ],
        
    
    
                    'cle93' => [
            //'required'
            ],
        
    
    
                    'cle94' => [
            //'required'
            ],
        
    
    
                    'cle95' => [
            //'required'
            ],
        
    
    
                    'cle96' => [
            //'required'
            ],
        
    
    
                    'cle97' => [
            //'required'
            ],
        
    
    
                    'cle98' => [
            //'required'
            ],
        
    
    
                    'cle99' => [
            //'required'
            ],
        
    
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
    
        'parent' => ['cette donnee est obligatoire'],

    
    
        'form_id' => ['cette donnee est obligatoire'],

    
    
        'cle0' => ['cette donnee est obligatoire'],

    
    
        'cle1' => ['cette donnee est obligatoire'],

    
    
        'cle2' => ['cette donnee est obligatoire'],

    
    
        'cle3' => ['cette donnee est obligatoire'],

    
    
        'cle4' => ['cette donnee est obligatoire'],

    
    
        'cle5' => ['cette donnee est obligatoire'],

    
    
        'cle6' => ['cette donnee est obligatoire'],

    
    
        'cle7' => ['cette donnee est obligatoire'],

    
    
        'cle8' => ['cette donnee est obligatoire'],

    
    
        'cle9' => ['cette donnee est obligatoire'],

    
    
        'cle10' => ['cette donnee est obligatoire'],

    
    
        'cle11' => ['cette donnee est obligatoire'],

    
    
        'cle12' => ['cette donnee est obligatoire'],

    
    
        'cle13' => ['cette donnee est obligatoire'],

    
    
        'cle14' => ['cette donnee est obligatoire'],

    
    
        'cle15' => ['cette donnee est obligatoire'],

    
    
        'cle16' => ['cette donnee est obligatoire'],

    
    
        'cle17' => ['cette donnee est obligatoire'],

    
    
        'cle18' => ['cette donnee est obligatoire'],

    
    
        'cle19' => ['cette donnee est obligatoire'],

    
    
        'cle20' => ['cette donnee est obligatoire'],

    
    
        'cle21' => ['cette donnee est obligatoire'],

    
    
        'cle22' => ['cette donnee est obligatoire'],

    
    
        'cle23' => ['cette donnee est obligatoire'],

    
    
        'cle24' => ['cette donnee est obligatoire'],

    
    
        'cle25' => ['cette donnee est obligatoire'],

    
    
        'cle26' => ['cette donnee est obligatoire'],

    
    
        'cle27' => ['cette donnee est obligatoire'],

    
    
        'cle28' => ['cette donnee est obligatoire'],

    
    
        'cle29' => ['cette donnee est obligatoire'],

    
    
        'cle30' => ['cette donnee est obligatoire'],

    
    
        'cle31' => ['cette donnee est obligatoire'],

    
    
        'cle32' => ['cette donnee est obligatoire'],

    
    
        'cle33' => ['cette donnee est obligatoire'],

    
    
        'cle34' => ['cette donnee est obligatoire'],

    
    
        'cle35' => ['cette donnee est obligatoire'],

    
    
        'cle36' => ['cette donnee est obligatoire'],

    
    
        'cle37' => ['cette donnee est obligatoire'],

    
    
        'cle38' => ['cette donnee est obligatoire'],

    
    
        'cle39' => ['cette donnee est obligatoire'],

    
    
        'cle40' => ['cette donnee est obligatoire'],

    
    
        'cle41' => ['cette donnee est obligatoire'],

    
    
        'cle42' => ['cette donnee est obligatoire'],

    
    
        'cle43' => ['cette donnee est obligatoire'],

    
    
        'cle44' => ['cette donnee est obligatoire'],

    
    
        'cle45' => ['cette donnee est obligatoire'],

    
    
        'cle46' => ['cette donnee est obligatoire'],

    
    
        'cle47' => ['cette donnee est obligatoire'],

    
    
        'cle48' => ['cette donnee est obligatoire'],

    
    
        'cle49' => ['cette donnee est obligatoire'],

    
    
        'cle50' => ['cette donnee est obligatoire'],

    
    
        'cle51' => ['cette donnee est obligatoire'],

    
    
        'cle52' => ['cette donnee est obligatoire'],

    
    
        'cle53' => ['cette donnee est obligatoire'],

    
    
        'cle54' => ['cette donnee est obligatoire'],

    
    
        'cle55' => ['cette donnee est obligatoire'],

    
    
        'cle56' => ['cette donnee est obligatoire'],

    
    
        'cle57' => ['cette donnee est obligatoire'],

    
    
        'cle58' => ['cette donnee est obligatoire'],

    
    
        'cle59' => ['cette donnee est obligatoire'],

    
    
        'cle60' => ['cette donnee est obligatoire'],

    
    
        'cle61' => ['cette donnee est obligatoire'],

    
    
        'cle62' => ['cette donnee est obligatoire'],

    
    
        'cle63' => ['cette donnee est obligatoire'],

    
    
        'cle64' => ['cette donnee est obligatoire'],

    
    
        'cle65' => ['cette donnee est obligatoire'],

    
    
        'cle66' => ['cette donnee est obligatoire'],

    
    
        'cle67' => ['cette donnee est obligatoire'],

    
    
        'cle68' => ['cette donnee est obligatoire'],

    
    
        'cle69' => ['cette donnee est obligatoire'],

    
    
        'cle70' => ['cette donnee est obligatoire'],

    
    
        'cle71' => ['cette donnee est obligatoire'],

    
    
        'cle72' => ['cette donnee est obligatoire'],

    
    
        'cle73' => ['cette donnee est obligatoire'],

    
    
        'cle74' => ['cette donnee est obligatoire'],

    
    
        'cle75' => ['cette donnee est obligatoire'],

    
    
        'cle76' => ['cette donnee est obligatoire'],

    
    
        'cle77' => ['cette donnee est obligatoire'],

    
    
        'cle78' => ['cette donnee est obligatoire'],

    
    
        'cle79' => ['cette donnee est obligatoire'],

    
    
        'cle80' => ['cette donnee est obligatoire'],

    
    
        'cle81' => ['cette donnee est obligatoire'],

    
    
        'cle82' => ['cette donnee est obligatoire'],

    
    
        'cle83' => ['cette donnee est obligatoire'],

    
    
        'cle84' => ['cette donnee est obligatoire'],

    
    
        'cle85' => ['cette donnee est obligatoire'],

    
    
        'cle86' => ['cette donnee est obligatoire'],

    
    
        'cle87' => ['cette donnee est obligatoire'],

    
    
        'cle88' => ['cette donnee est obligatoire'],

    
    
        'cle89' => ['cette donnee est obligatoire'],

    
    
        'cle90' => ['cette donnee est obligatoire'],

    
    
        'cle91' => ['cette donnee est obligatoire'],

    
    
        'cle92' => ['cette donnee est obligatoire'],

    
    
        'cle93' => ['cette donnee est obligatoire'],

    
    
        'cle94' => ['cette donnee est obligatoire'],

    
    
        'cle95' => ['cette donnee est obligatoire'],

    
    
        'cle96' => ['cette donnee est obligatoire'],

    
    
        'cle97' => ['cette donnee est obligatoire'],

    
    
        'cle98' => ['cette donnee est obligatoire'],

    
    
        'cle99' => ['cette donnee est obligatoire'],

    
    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Formsdatas->libelle = $data['libelle'];
        
        }

        }

    







    

        if(array_key_exists("parent",$data)){


        if(!empty($data['parent'])){
        
            $Formsdatas->parent = $data['parent'];
        
        }

        }

    







    

        if(array_key_exists("form_id",$data)){


        if(!empty($data['form_id'])){
        
            $Formsdatas->form_id = $data['form_id'];
        
        }

        }

    







    

        if(array_key_exists("cle0",$data)){


        if(!empty($data['cle0'])){
        
            $Formsdatas->cle0 = $data['cle0'];
        
        }

        }

    







    

        if(array_key_exists("cle1",$data)){


        if(!empty($data['cle1'])){
        
            $Formsdatas->cle1 = $data['cle1'];
        
        }

        }

    







    

        if(array_key_exists("cle2",$data)){


        if(!empty($data['cle2'])){
        
            $Formsdatas->cle2 = $data['cle2'];
        
        }

        }

    







    

        if(array_key_exists("cle3",$data)){


        if(!empty($data['cle3'])){
        
            $Formsdatas->cle3 = $data['cle3'];
        
        }

        }

    







    

        if(array_key_exists("cle4",$data)){


        if(!empty($data['cle4'])){
        
            $Formsdatas->cle4 = $data['cle4'];
        
        }

        }

    







    

        if(array_key_exists("cle5",$data)){


        if(!empty($data['cle5'])){
        
            $Formsdatas->cle5 = $data['cle5'];
        
        }

        }

    







    

        if(array_key_exists("cle6",$data)){


        if(!empty($data['cle6'])){
        
            $Formsdatas->cle6 = $data['cle6'];
        
        }

        }

    







    

        if(array_key_exists("cle7",$data)){


        if(!empty($data['cle7'])){
        
            $Formsdatas->cle7 = $data['cle7'];
        
        }

        }

    







    

        if(array_key_exists("cle8",$data)){


        if(!empty($data['cle8'])){
        
            $Formsdatas->cle8 = $data['cle8'];
        
        }

        }

    







    

        if(array_key_exists("cle9",$data)){


        if(!empty($data['cle9'])){
        
            $Formsdatas->cle9 = $data['cle9'];
        
        }

        }

    







    

        if(array_key_exists("cle10",$data)){


        if(!empty($data['cle10'])){
        
            $Formsdatas->cle10 = $data['cle10'];
        
        }

        }

    







    

        if(array_key_exists("cle11",$data)){


        if(!empty($data['cle11'])){
        
            $Formsdatas->cle11 = $data['cle11'];
        
        }

        }

    







    

        if(array_key_exists("cle12",$data)){


        if(!empty($data['cle12'])){
        
            $Formsdatas->cle12 = $data['cle12'];
        
        }

        }

    







    

        if(array_key_exists("cle13",$data)){


        if(!empty($data['cle13'])){
        
            $Formsdatas->cle13 = $data['cle13'];
        
        }

        }

    







    

        if(array_key_exists("cle14",$data)){


        if(!empty($data['cle14'])){
        
            $Formsdatas->cle14 = $data['cle14'];
        
        }

        }

    







    

        if(array_key_exists("cle15",$data)){


        if(!empty($data['cle15'])){
        
            $Formsdatas->cle15 = $data['cle15'];
        
        }

        }

    







    

        if(array_key_exists("cle16",$data)){


        if(!empty($data['cle16'])){
        
            $Formsdatas->cle16 = $data['cle16'];
        
        }

        }

    







    

        if(array_key_exists("cle17",$data)){


        if(!empty($data['cle17'])){
        
            $Formsdatas->cle17 = $data['cle17'];
        
        }

        }

    







    

        if(array_key_exists("cle18",$data)){


        if(!empty($data['cle18'])){
        
            $Formsdatas->cle18 = $data['cle18'];
        
        }

        }

    







    

        if(array_key_exists("cle19",$data)){


        if(!empty($data['cle19'])){
        
            $Formsdatas->cle19 = $data['cle19'];
        
        }

        }

    







    

        if(array_key_exists("cle20",$data)){


        if(!empty($data['cle20'])){
        
            $Formsdatas->cle20 = $data['cle20'];
        
        }

        }

    







    

        if(array_key_exists("cle21",$data)){


        if(!empty($data['cle21'])){
        
            $Formsdatas->cle21 = $data['cle21'];
        
        }

        }

    







    

        if(array_key_exists("cle22",$data)){


        if(!empty($data['cle22'])){
        
            $Formsdatas->cle22 = $data['cle22'];
        
        }

        }

    







    

        if(array_key_exists("cle23",$data)){


        if(!empty($data['cle23'])){
        
            $Formsdatas->cle23 = $data['cle23'];
        
        }

        }

    







    

        if(array_key_exists("cle24",$data)){


        if(!empty($data['cle24'])){
        
            $Formsdatas->cle24 = $data['cle24'];
        
        }

        }

    







    

        if(array_key_exists("cle25",$data)){


        if(!empty($data['cle25'])){
        
            $Formsdatas->cle25 = $data['cle25'];
        
        }

        }

    







    

        if(array_key_exists("cle26",$data)){


        if(!empty($data['cle26'])){
        
            $Formsdatas->cle26 = $data['cle26'];
        
        }

        }

    







    

        if(array_key_exists("cle27",$data)){


        if(!empty($data['cle27'])){
        
            $Formsdatas->cle27 = $data['cle27'];
        
        }

        }

    







    

        if(array_key_exists("cle28",$data)){


        if(!empty($data['cle28'])){
        
            $Formsdatas->cle28 = $data['cle28'];
        
        }

        }

    







    

        if(array_key_exists("cle29",$data)){


        if(!empty($data['cle29'])){
        
            $Formsdatas->cle29 = $data['cle29'];
        
        }

        }

    







    

        if(array_key_exists("cle30",$data)){


        if(!empty($data['cle30'])){
        
            $Formsdatas->cle30 = $data['cle30'];
        
        }

        }

    







    

        if(array_key_exists("cle31",$data)){


        if(!empty($data['cle31'])){
        
            $Formsdatas->cle31 = $data['cle31'];
        
        }

        }

    







    

        if(array_key_exists("cle32",$data)){


        if(!empty($data['cle32'])){
        
            $Formsdatas->cle32 = $data['cle32'];
        
        }

        }

    







    

        if(array_key_exists("cle33",$data)){


        if(!empty($data['cle33'])){
        
            $Formsdatas->cle33 = $data['cle33'];
        
        }

        }

    







    

        if(array_key_exists("cle34",$data)){


        if(!empty($data['cle34'])){
        
            $Formsdatas->cle34 = $data['cle34'];
        
        }

        }

    







    

        if(array_key_exists("cle35",$data)){


        if(!empty($data['cle35'])){
        
            $Formsdatas->cle35 = $data['cle35'];
        
        }

        }

    







    

        if(array_key_exists("cle36",$data)){


        if(!empty($data['cle36'])){
        
            $Formsdatas->cle36 = $data['cle36'];
        
        }

        }

    







    

        if(array_key_exists("cle37",$data)){


        if(!empty($data['cle37'])){
        
            $Formsdatas->cle37 = $data['cle37'];
        
        }

        }

    







    

        if(array_key_exists("cle38",$data)){


        if(!empty($data['cle38'])){
        
            $Formsdatas->cle38 = $data['cle38'];
        
        }

        }

    







    

        if(array_key_exists("cle39",$data)){


        if(!empty($data['cle39'])){
        
            $Formsdatas->cle39 = $data['cle39'];
        
        }

        }

    







    

        if(array_key_exists("cle40",$data)){


        if(!empty($data['cle40'])){
        
            $Formsdatas->cle40 = $data['cle40'];
        
        }

        }

    







    

        if(array_key_exists("cle41",$data)){


        if(!empty($data['cle41'])){
        
            $Formsdatas->cle41 = $data['cle41'];
        
        }

        }

    







    

        if(array_key_exists("cle42",$data)){


        if(!empty($data['cle42'])){
        
            $Formsdatas->cle42 = $data['cle42'];
        
        }

        }

    







    

        if(array_key_exists("cle43",$data)){


        if(!empty($data['cle43'])){
        
            $Formsdatas->cle43 = $data['cle43'];
        
        }

        }

    







    

        if(array_key_exists("cle44",$data)){


        if(!empty($data['cle44'])){
        
            $Formsdatas->cle44 = $data['cle44'];
        
        }

        }

    







    

        if(array_key_exists("cle45",$data)){


        if(!empty($data['cle45'])){
        
            $Formsdatas->cle45 = $data['cle45'];
        
        }

        }

    







    

        if(array_key_exists("cle46",$data)){


        if(!empty($data['cle46'])){
        
            $Formsdatas->cle46 = $data['cle46'];
        
        }

        }

    







    

        if(array_key_exists("cle47",$data)){


        if(!empty($data['cle47'])){
        
            $Formsdatas->cle47 = $data['cle47'];
        
        }

        }

    







    

        if(array_key_exists("cle48",$data)){


        if(!empty($data['cle48'])){
        
            $Formsdatas->cle48 = $data['cle48'];
        
        }

        }

    







    

        if(array_key_exists("cle49",$data)){


        if(!empty($data['cle49'])){
        
            $Formsdatas->cle49 = $data['cle49'];
        
        }

        }

    







    

        if(array_key_exists("cle50",$data)){


        if(!empty($data['cle50'])){
        
            $Formsdatas->cle50 = $data['cle50'];
        
        }

        }

    







    

        if(array_key_exists("cle51",$data)){


        if(!empty($data['cle51'])){
        
            $Formsdatas->cle51 = $data['cle51'];
        
        }

        }

    







    

        if(array_key_exists("cle52",$data)){


        if(!empty($data['cle52'])){
        
            $Formsdatas->cle52 = $data['cle52'];
        
        }

        }

    







    

        if(array_key_exists("cle53",$data)){


        if(!empty($data['cle53'])){
        
            $Formsdatas->cle53 = $data['cle53'];
        
        }

        }

    







    

        if(array_key_exists("cle54",$data)){


        if(!empty($data['cle54'])){
        
            $Formsdatas->cle54 = $data['cle54'];
        
        }

        }

    







    

        if(array_key_exists("cle55",$data)){


        if(!empty($data['cle55'])){
        
            $Formsdatas->cle55 = $data['cle55'];
        
        }

        }

    







    

        if(array_key_exists("cle56",$data)){


        if(!empty($data['cle56'])){
        
            $Formsdatas->cle56 = $data['cle56'];
        
        }

        }

    







    

        if(array_key_exists("cle57",$data)){


        if(!empty($data['cle57'])){
        
            $Formsdatas->cle57 = $data['cle57'];
        
        }

        }

    







    

        if(array_key_exists("cle58",$data)){


        if(!empty($data['cle58'])){
        
            $Formsdatas->cle58 = $data['cle58'];
        
        }

        }

    







    

        if(array_key_exists("cle59",$data)){


        if(!empty($data['cle59'])){
        
            $Formsdatas->cle59 = $data['cle59'];
        
        }

        }

    







    

        if(array_key_exists("cle60",$data)){


        if(!empty($data['cle60'])){
        
            $Formsdatas->cle60 = $data['cle60'];
        
        }

        }

    







    

        if(array_key_exists("cle61",$data)){


        if(!empty($data['cle61'])){
        
            $Formsdatas->cle61 = $data['cle61'];
        
        }

        }

    







    

        if(array_key_exists("cle62",$data)){


        if(!empty($data['cle62'])){
        
            $Formsdatas->cle62 = $data['cle62'];
        
        }

        }

    







    

        if(array_key_exists("cle63",$data)){


        if(!empty($data['cle63'])){
        
            $Formsdatas->cle63 = $data['cle63'];
        
        }

        }

    







    

        if(array_key_exists("cle64",$data)){


        if(!empty($data['cle64'])){
        
            $Formsdatas->cle64 = $data['cle64'];
        
        }

        }

    







    

        if(array_key_exists("cle65",$data)){


        if(!empty($data['cle65'])){
        
            $Formsdatas->cle65 = $data['cle65'];
        
        }

        }

    







    

        if(array_key_exists("cle66",$data)){


        if(!empty($data['cle66'])){
        
            $Formsdatas->cle66 = $data['cle66'];
        
        }

        }

    







    

        if(array_key_exists("cle67",$data)){


        if(!empty($data['cle67'])){
        
            $Formsdatas->cle67 = $data['cle67'];
        
        }

        }

    







    

        if(array_key_exists("cle68",$data)){


        if(!empty($data['cle68'])){
        
            $Formsdatas->cle68 = $data['cle68'];
        
        }

        }

    







    

        if(array_key_exists("cle69",$data)){


        if(!empty($data['cle69'])){
        
            $Formsdatas->cle69 = $data['cle69'];
        
        }

        }

    







    

        if(array_key_exists("cle70",$data)){


        if(!empty($data['cle70'])){
        
            $Formsdatas->cle70 = $data['cle70'];
        
        }

        }

    







    

        if(array_key_exists("cle71",$data)){


        if(!empty($data['cle71'])){
        
            $Formsdatas->cle71 = $data['cle71'];
        
        }

        }

    







    

        if(array_key_exists("cle72",$data)){


        if(!empty($data['cle72'])){
        
            $Formsdatas->cle72 = $data['cle72'];
        
        }

        }

    







    

        if(array_key_exists("cle73",$data)){


        if(!empty($data['cle73'])){
        
            $Formsdatas->cle73 = $data['cle73'];
        
        }

        }

    







    

        if(array_key_exists("cle74",$data)){


        if(!empty($data['cle74'])){
        
            $Formsdatas->cle74 = $data['cle74'];
        
        }

        }

    







    

        if(array_key_exists("cle75",$data)){


        if(!empty($data['cle75'])){
        
            $Formsdatas->cle75 = $data['cle75'];
        
        }

        }

    







    

        if(array_key_exists("cle76",$data)){


        if(!empty($data['cle76'])){
        
            $Formsdatas->cle76 = $data['cle76'];
        
        }

        }

    







    

        if(array_key_exists("cle77",$data)){


        if(!empty($data['cle77'])){
        
            $Formsdatas->cle77 = $data['cle77'];
        
        }

        }

    







    

        if(array_key_exists("cle78",$data)){


        if(!empty($data['cle78'])){
        
            $Formsdatas->cle78 = $data['cle78'];
        
        }

        }

    







    

        if(array_key_exists("cle79",$data)){


        if(!empty($data['cle79'])){
        
            $Formsdatas->cle79 = $data['cle79'];
        
        }

        }

    







    

        if(array_key_exists("cle80",$data)){


        if(!empty($data['cle80'])){
        
            $Formsdatas->cle80 = $data['cle80'];
        
        }

        }

    







    

        if(array_key_exists("cle81",$data)){


        if(!empty($data['cle81'])){
        
            $Formsdatas->cle81 = $data['cle81'];
        
        }

        }

    







    

        if(array_key_exists("cle82",$data)){


        if(!empty($data['cle82'])){
        
            $Formsdatas->cle82 = $data['cle82'];
        
        }

        }

    







    

        if(array_key_exists("cle83",$data)){


        if(!empty($data['cle83'])){
        
            $Formsdatas->cle83 = $data['cle83'];
        
        }

        }

    







    

        if(array_key_exists("cle84",$data)){


        if(!empty($data['cle84'])){
        
            $Formsdatas->cle84 = $data['cle84'];
        
        }

        }

    







    

        if(array_key_exists("cle85",$data)){


        if(!empty($data['cle85'])){
        
            $Formsdatas->cle85 = $data['cle85'];
        
        }

        }

    







    

        if(array_key_exists("cle86",$data)){


        if(!empty($data['cle86'])){
        
            $Formsdatas->cle86 = $data['cle86'];
        
        }

        }

    







    

        if(array_key_exists("cle87",$data)){


        if(!empty($data['cle87'])){
        
            $Formsdatas->cle87 = $data['cle87'];
        
        }

        }

    







    

        if(array_key_exists("cle88",$data)){


        if(!empty($data['cle88'])){
        
            $Formsdatas->cle88 = $data['cle88'];
        
        }

        }

    







    

        if(array_key_exists("cle89",$data)){


        if(!empty($data['cle89'])){
        
            $Formsdatas->cle89 = $data['cle89'];
        
        }

        }

    







    

        if(array_key_exists("cle90",$data)){


        if(!empty($data['cle90'])){
        
            $Formsdatas->cle90 = $data['cle90'];
        
        }

        }

    







    

        if(array_key_exists("cle91",$data)){


        if(!empty($data['cle91'])){
        
            $Formsdatas->cle91 = $data['cle91'];
        
        }

        }

    







    

        if(array_key_exists("cle92",$data)){


        if(!empty($data['cle92'])){
        
            $Formsdatas->cle92 = $data['cle92'];
        
        }

        }

    







    

        if(array_key_exists("cle93",$data)){


        if(!empty($data['cle93'])){
        
            $Formsdatas->cle93 = $data['cle93'];
        
        }

        }

    







    

        if(array_key_exists("cle94",$data)){


        if(!empty($data['cle94'])){
        
            $Formsdatas->cle94 = $data['cle94'];
        
        }

        }

    







    

        if(array_key_exists("cle95",$data)){


        if(!empty($data['cle95'])){
        
            $Formsdatas->cle95 = $data['cle95'];
        
        }

        }

    







    

        if(array_key_exists("cle96",$data)){


        if(!empty($data['cle96'])){
        
            $Formsdatas->cle96 = $data['cle96'];
        
        }

        }

    







    

        if(array_key_exists("cle97",$data)){


        if(!empty($data['cle97'])){
        
            $Formsdatas->cle97 = $data['cle97'];
        
        }

        }

    







    

        if(array_key_exists("cle98",$data)){


        if(!empty($data['cle98'])){
        
            $Formsdatas->cle98 = $data['cle98'];
        
        }

        }

    







    

        if(array_key_exists("cle99",$data)){


        if(!empty($data['cle99'])){
        
            $Formsdatas->cle99 = $data['cle99'];
        
        }

        }

    







    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Formsdatas->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Formsdatas->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Formsdatas->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\FormsdataExtras') &&
method_exists('\App\Http\Extras\FormsdataExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\FormsdataExtras::beforeSaveUpdate($request,$Formsdatas);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\FormsdataExtras') &&
method_exists('\App\Http\Extras\FormsdataExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\FormsdataExtras::canUpdate($request, $Formsdatas);
}catch (\Throwable $e){

}

}


if($canSave){
$Formsdatas->save();
}else{
return response()->json($Formsdatas, 200);

}


$Formsdatas=Formsdata::find($Formsdatas->id);



$newCrudData=[];

                $newCrudData['libelle']=$Formsdatas->libelle;
                $newCrudData['parent']=$Formsdatas->parent;
                $newCrudData['form_id']=$Formsdatas->form_id;
                $newCrudData['cle0']=$Formsdatas->cle0;
                $newCrudData['cle1']=$Formsdatas->cle1;
                $newCrudData['cle2']=$Formsdatas->cle2;
                $newCrudData['cle3']=$Formsdatas->cle3;
                $newCrudData['cle4']=$Formsdatas->cle4;
                $newCrudData['cle5']=$Formsdatas->cle5;
                $newCrudData['cle6']=$Formsdatas->cle6;
                $newCrudData['cle7']=$Formsdatas->cle7;
                $newCrudData['cle8']=$Formsdatas->cle8;
                $newCrudData['cle9']=$Formsdatas->cle9;
                $newCrudData['cle10']=$Formsdatas->cle10;
                $newCrudData['cle11']=$Formsdatas->cle11;
                $newCrudData['cle12']=$Formsdatas->cle12;
                $newCrudData['cle13']=$Formsdatas->cle13;
                $newCrudData['cle14']=$Formsdatas->cle14;
                $newCrudData['cle15']=$Formsdatas->cle15;
                $newCrudData['cle16']=$Formsdatas->cle16;
                $newCrudData['cle17']=$Formsdatas->cle17;
                $newCrudData['cle18']=$Formsdatas->cle18;
                $newCrudData['cle19']=$Formsdatas->cle19;
                $newCrudData['cle20']=$Formsdatas->cle20;
                $newCrudData['cle21']=$Formsdatas->cle21;
                $newCrudData['cle22']=$Formsdatas->cle22;
                $newCrudData['cle23']=$Formsdatas->cle23;
                $newCrudData['cle24']=$Formsdatas->cle24;
                $newCrudData['cle25']=$Formsdatas->cle25;
                $newCrudData['cle26']=$Formsdatas->cle26;
                $newCrudData['cle27']=$Formsdatas->cle27;
                $newCrudData['cle28']=$Formsdatas->cle28;
                $newCrudData['cle29']=$Formsdatas->cle29;
                $newCrudData['cle30']=$Formsdatas->cle30;
                $newCrudData['cle31']=$Formsdatas->cle31;
                $newCrudData['cle32']=$Formsdatas->cle32;
                $newCrudData['cle33']=$Formsdatas->cle33;
                $newCrudData['cle34']=$Formsdatas->cle34;
                $newCrudData['cle35']=$Formsdatas->cle35;
                $newCrudData['cle36']=$Formsdatas->cle36;
                $newCrudData['cle37']=$Formsdatas->cle37;
                $newCrudData['cle38']=$Formsdatas->cle38;
                $newCrudData['cle39']=$Formsdatas->cle39;
                $newCrudData['cle40']=$Formsdatas->cle40;
                $newCrudData['cle41']=$Formsdatas->cle41;
                $newCrudData['cle42']=$Formsdatas->cle42;
                $newCrudData['cle43']=$Formsdatas->cle43;
                $newCrudData['cle44']=$Formsdatas->cle44;
                $newCrudData['cle45']=$Formsdatas->cle45;
                $newCrudData['cle46']=$Formsdatas->cle46;
                $newCrudData['cle47']=$Formsdatas->cle47;
                $newCrudData['cle48']=$Formsdatas->cle48;
                $newCrudData['cle49']=$Formsdatas->cle49;
                $newCrudData['cle50']=$Formsdatas->cle50;
                $newCrudData['cle51']=$Formsdatas->cle51;
                $newCrudData['cle52']=$Formsdatas->cle52;
                $newCrudData['cle53']=$Formsdatas->cle53;
                $newCrudData['cle54']=$Formsdatas->cle54;
                $newCrudData['cle55']=$Formsdatas->cle55;
                $newCrudData['cle56']=$Formsdatas->cle56;
                $newCrudData['cle57']=$Formsdatas->cle57;
                $newCrudData['cle58']=$Formsdatas->cle58;
                $newCrudData['cle59']=$Formsdatas->cle59;
                $newCrudData['cle60']=$Formsdatas->cle60;
                $newCrudData['cle61']=$Formsdatas->cle61;
                $newCrudData['cle62']=$Formsdatas->cle62;
                $newCrudData['cle63']=$Formsdatas->cle63;
                $newCrudData['cle64']=$Formsdatas->cle64;
                $newCrudData['cle65']=$Formsdatas->cle65;
                $newCrudData['cle66']=$Formsdatas->cle66;
                $newCrudData['cle67']=$Formsdatas->cle67;
                $newCrudData['cle68']=$Formsdatas->cle68;
                $newCrudData['cle69']=$Formsdatas->cle69;
                $newCrudData['cle70']=$Formsdatas->cle70;
                $newCrudData['cle71']=$Formsdatas->cle71;
                $newCrudData['cle72']=$Formsdatas->cle72;
                $newCrudData['cle73']=$Formsdatas->cle73;
                $newCrudData['cle74']=$Formsdatas->cle74;
                $newCrudData['cle75']=$Formsdatas->cle75;
                $newCrudData['cle76']=$Formsdatas->cle76;
                $newCrudData['cle77']=$Formsdatas->cle77;
                $newCrudData['cle78']=$Formsdatas->cle78;
                $newCrudData['cle79']=$Formsdatas->cle79;
                $newCrudData['cle80']=$Formsdatas->cle80;
                $newCrudData['cle81']=$Formsdatas->cle81;
                $newCrudData['cle82']=$Formsdatas->cle82;
                $newCrudData['cle83']=$Formsdatas->cle83;
                $newCrudData['cle84']=$Formsdatas->cle84;
                $newCrudData['cle85']=$Formsdatas->cle85;
                $newCrudData['cle86']=$Formsdatas->cle86;
                $newCrudData['cle87']=$Formsdatas->cle87;
                $newCrudData['cle88']=$Formsdatas->cle88;
                $newCrudData['cle89']=$Formsdatas->cle89;
                $newCrudData['cle90']=$Formsdatas->cle90;
                $newCrudData['cle91']=$Formsdatas->cle91;
                $newCrudData['cle92']=$Formsdatas->cle92;
                $newCrudData['cle93']=$Formsdatas->cle93;
                $newCrudData['cle94']=$Formsdatas->cle94;
                $newCrudData['cle95']=$Formsdatas->cle95;
                $newCrudData['cle96']=$Formsdatas->cle96;
                $newCrudData['cle97']=$Formsdatas->cle97;
                $newCrudData['cle98']=$Formsdatas->cle98;
                $newCrudData['cle99']=$Formsdatas->cle99;
                    $newCrudData['creat_by']=$Formsdatas->creat_by;
                            $newCrudData['identifiants_sadge']=$Formsdatas->identifiants_sadge;
    
 try{ $newCrudData['form']=$Formsdatas->form->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Formsdatas','entite_cle' => $Formsdatas->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Formsdatas->toArray();




try{

foreach ($Formsdatas->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Formsdata $Formsdatas)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des formsdatas');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['libelle']=$Formsdatas->libelle;
                $newCrudData['parent']=$Formsdatas->parent;
                $newCrudData['form_id']=$Formsdatas->form_id;
                $newCrudData['cle0']=$Formsdatas->cle0;
                $newCrudData['cle1']=$Formsdatas->cle1;
                $newCrudData['cle2']=$Formsdatas->cle2;
                $newCrudData['cle3']=$Formsdatas->cle3;
                $newCrudData['cle4']=$Formsdatas->cle4;
                $newCrudData['cle5']=$Formsdatas->cle5;
                $newCrudData['cle6']=$Formsdatas->cle6;
                $newCrudData['cle7']=$Formsdatas->cle7;
                $newCrudData['cle8']=$Formsdatas->cle8;
                $newCrudData['cle9']=$Formsdatas->cle9;
                $newCrudData['cle10']=$Formsdatas->cle10;
                $newCrudData['cle11']=$Formsdatas->cle11;
                $newCrudData['cle12']=$Formsdatas->cle12;
                $newCrudData['cle13']=$Formsdatas->cle13;
                $newCrudData['cle14']=$Formsdatas->cle14;
                $newCrudData['cle15']=$Formsdatas->cle15;
                $newCrudData['cle16']=$Formsdatas->cle16;
                $newCrudData['cle17']=$Formsdatas->cle17;
                $newCrudData['cle18']=$Formsdatas->cle18;
                $newCrudData['cle19']=$Formsdatas->cle19;
                $newCrudData['cle20']=$Formsdatas->cle20;
                $newCrudData['cle21']=$Formsdatas->cle21;
                $newCrudData['cle22']=$Formsdatas->cle22;
                $newCrudData['cle23']=$Formsdatas->cle23;
                $newCrudData['cle24']=$Formsdatas->cle24;
                $newCrudData['cle25']=$Formsdatas->cle25;
                $newCrudData['cle26']=$Formsdatas->cle26;
                $newCrudData['cle27']=$Formsdatas->cle27;
                $newCrudData['cle28']=$Formsdatas->cle28;
                $newCrudData['cle29']=$Formsdatas->cle29;
                $newCrudData['cle30']=$Formsdatas->cle30;
                $newCrudData['cle31']=$Formsdatas->cle31;
                $newCrudData['cle32']=$Formsdatas->cle32;
                $newCrudData['cle33']=$Formsdatas->cle33;
                $newCrudData['cle34']=$Formsdatas->cle34;
                $newCrudData['cle35']=$Formsdatas->cle35;
                $newCrudData['cle36']=$Formsdatas->cle36;
                $newCrudData['cle37']=$Formsdatas->cle37;
                $newCrudData['cle38']=$Formsdatas->cle38;
                $newCrudData['cle39']=$Formsdatas->cle39;
                $newCrudData['cle40']=$Formsdatas->cle40;
                $newCrudData['cle41']=$Formsdatas->cle41;
                $newCrudData['cle42']=$Formsdatas->cle42;
                $newCrudData['cle43']=$Formsdatas->cle43;
                $newCrudData['cle44']=$Formsdatas->cle44;
                $newCrudData['cle45']=$Formsdatas->cle45;
                $newCrudData['cle46']=$Formsdatas->cle46;
                $newCrudData['cle47']=$Formsdatas->cle47;
                $newCrudData['cle48']=$Formsdatas->cle48;
                $newCrudData['cle49']=$Formsdatas->cle49;
                $newCrudData['cle50']=$Formsdatas->cle50;
                $newCrudData['cle51']=$Formsdatas->cle51;
                $newCrudData['cle52']=$Formsdatas->cle52;
                $newCrudData['cle53']=$Formsdatas->cle53;
                $newCrudData['cle54']=$Formsdatas->cle54;
                $newCrudData['cle55']=$Formsdatas->cle55;
                $newCrudData['cle56']=$Formsdatas->cle56;
                $newCrudData['cle57']=$Formsdatas->cle57;
                $newCrudData['cle58']=$Formsdatas->cle58;
                $newCrudData['cle59']=$Formsdatas->cle59;
                $newCrudData['cle60']=$Formsdatas->cle60;
                $newCrudData['cle61']=$Formsdatas->cle61;
                $newCrudData['cle62']=$Formsdatas->cle62;
                $newCrudData['cle63']=$Formsdatas->cle63;
                $newCrudData['cle64']=$Formsdatas->cle64;
                $newCrudData['cle65']=$Formsdatas->cle65;
                $newCrudData['cle66']=$Formsdatas->cle66;
                $newCrudData['cle67']=$Formsdatas->cle67;
                $newCrudData['cle68']=$Formsdatas->cle68;
                $newCrudData['cle69']=$Formsdatas->cle69;
                $newCrudData['cle70']=$Formsdatas->cle70;
                $newCrudData['cle71']=$Formsdatas->cle71;
                $newCrudData['cle72']=$Formsdatas->cle72;
                $newCrudData['cle73']=$Formsdatas->cle73;
                $newCrudData['cle74']=$Formsdatas->cle74;
                $newCrudData['cle75']=$Formsdatas->cle75;
                $newCrudData['cle76']=$Formsdatas->cle76;
                $newCrudData['cle77']=$Formsdatas->cle77;
                $newCrudData['cle78']=$Formsdatas->cle78;
                $newCrudData['cle79']=$Formsdatas->cle79;
                $newCrudData['cle80']=$Formsdatas->cle80;
                $newCrudData['cle81']=$Formsdatas->cle81;
                $newCrudData['cle82']=$Formsdatas->cle82;
                $newCrudData['cle83']=$Formsdatas->cle83;
                $newCrudData['cle84']=$Formsdatas->cle84;
                $newCrudData['cle85']=$Formsdatas->cle85;
                $newCrudData['cle86']=$Formsdatas->cle86;
                $newCrudData['cle87']=$Formsdatas->cle87;
                $newCrudData['cle88']=$Formsdatas->cle88;
                $newCrudData['cle89']=$Formsdatas->cle89;
                $newCrudData['cle90']=$Formsdatas->cle90;
                $newCrudData['cle91']=$Formsdatas->cle91;
                $newCrudData['cle92']=$Formsdatas->cle92;
                $newCrudData['cle93']=$Formsdatas->cle93;
                $newCrudData['cle94']=$Formsdatas->cle94;
                $newCrudData['cle95']=$Formsdatas->cle95;
                $newCrudData['cle96']=$Formsdatas->cle96;
                $newCrudData['cle97']=$Formsdatas->cle97;
                $newCrudData['cle98']=$Formsdatas->cle98;
                $newCrudData['cle99']=$Formsdatas->cle99;
                    $newCrudData['creat_by']=$Formsdatas->creat_by;
                            $newCrudData['identifiants_sadge']=$Formsdatas->identifiants_sadge;
    
 try{ $newCrudData['form']=$Formsdatas->form->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Formsdatas','entite_cle' => $Formsdatas->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\FormsdataExtras') &&
method_exists('\App\Http\Extras\FormsdataExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\FormsdataExtras::canDelete($request, $Formsdatas);
}catch (\Throwable $e){

}

}



if($canSave){
$Formsdatas->delete();
}else{
return response()->json($Formsdatas, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\FormsdatasActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
