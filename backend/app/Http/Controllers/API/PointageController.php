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
// use App\Repository\prod\PointagesRepository;
use App\Models\Pointage;
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
                use App\Models\Programme;
        
class PointageController extends Controller
{

private $PointagesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\PointagesRepository $PointagesRepository
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
class_exists('\App\Http\Extras\PointageExtras') &&
method_exists('\App\Http\Extras\PointageExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\PointageExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Pointage::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\PointageExtras') &&
method_exists('\App\Http\Extras\PointageExtras', 'filterAgGridQuery')
){
\App\Http\Extras\PointageExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('pointages',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\PointageExtras') &&
method_exists('\App\Http\Extras\PointageExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\PointageExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  pointages reussi',
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
return response()->json(Pointage::count());
}
$data = QueryBuilder::for(Pointage::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('pointeuse'),

    
            AllowedFilter::exact('lieu'),

    
            AllowedFilter::exact('debut_prevu'),

    
            AllowedFilter::exact('fin_prevu'),

    
            AllowedFilter::exact('faction_horaire'),

    
            AllowedFilter::exact('debut_reel'),

    
            AllowedFilter::exact('debut_realise'),

    
            AllowedFilter::exact('fin_realise'),

    
            AllowedFilter::exact('volume_realise'),

    
            AllowedFilter::exact('emp_code'),

    
            AllowedFilter::exact('motif'),

    
            AllowedFilter::exact('volume_prevu'),

    
            AllowedFilter::exact('actif'),

    
            AllowedFilter::exact('est_valide'),

    
            AllowedFilter::exact('horaire_id'),

    
            AllowedFilter::exact('programme_id'),

    
            AllowedFilter::exact('tolerance'),

    
            AllowedFilter::exact('est_attendu'),

    
            AllowedFilter::exact('etats'),

    
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

    
            AllowedSort::field('pointeuse'),

    
            AllowedSort::field('lieu'),

    
            AllowedSort::field('debut_prevu'),

    
            AllowedSort::field('fin_prevu'),

    
            AllowedSort::field('faction_horaire'),

    
            AllowedSort::field('debut_reel'),

    
            AllowedSort::field('debut_realise'),

    
            AllowedSort::field('fin_realise'),

    
            AllowedSort::field('volume_realise'),

    
            AllowedSort::field('emp_code'),

    
            AllowedSort::field('motif'),

    
            AllowedSort::field('volume_prevu'),

    
            AllowedSort::field('actif'),

    
            AllowedSort::field('est_valide'),

    
            AllowedSort::field('horaire_id'),

    
            AllowedSort::field('programme_id'),

    
            AllowedSort::field('tolerance'),

    
            AllowedSort::field('est_attendu'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('user_id'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
->allowedIncludes([

            'horaire',
        

                'programme',
        

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




$data = QueryBuilder::for(Pointage::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('pointeuse'),

    
            AllowedFilter::exact('lieu'),

    
            AllowedFilter::exact('debut_prevu'),

    
            AllowedFilter::exact('fin_prevu'),

    
            AllowedFilter::exact('faction_horaire'),

    
            AllowedFilter::exact('debut_reel'),

    
            AllowedFilter::exact('debut_realise'),

    
            AllowedFilter::exact('fin_realise'),

    
            AllowedFilter::exact('volume_realise'),

    
            AllowedFilter::exact('emp_code'),

    
            AllowedFilter::exact('motif'),

    
            AllowedFilter::exact('volume_prevu'),

    
            AllowedFilter::exact('actif'),

    
            AllowedFilter::exact('est_valide'),

    
            AllowedFilter::exact('horaire_id'),

    
            AllowedFilter::exact('programme_id'),

    
            AllowedFilter::exact('tolerance'),

    
            AllowedFilter::exact('est_attendu'),

    
            AllowedFilter::exact('etats'),

    
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

    
            AllowedSort::field('pointeuse'),

    
            AllowedSort::field('lieu'),

    
            AllowedSort::field('debut_prevu'),

    
            AllowedSort::field('fin_prevu'),

    
            AllowedSort::field('faction_horaire'),

    
            AllowedSort::field('debut_reel'),

    
            AllowedSort::field('debut_realise'),

    
            AllowedSort::field('fin_realise'),

    
            AllowedSort::field('volume_realise'),

    
            AllowedSort::field('emp_code'),

    
            AllowedSort::field('motif'),

    
            AllowedSort::field('volume_prevu'),

    
            AllowedSort::field('actif'),

    
            AllowedSort::field('est_valide'),

    
            AllowedSort::field('horaire_id'),

    
            AllowedSort::field('programme_id'),

    
            AllowedSort::field('tolerance'),

    
            AllowedSort::field('est_attendu'),

    
            AllowedSort::field('etats'),

    
            AllowedSort::field('user_id'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
->allowedIncludes([
            'horaire',
        

                'programme',
        

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



public function create(Request $request, Pointage $Pointages)
{


try{
$can=\App\Helpers\Helpers::can('Creer des pointages');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "pointages"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'pointeuse',
    'lieu',
    'debut_prevu',
    'fin_prevu',
    'faction_horaire',
    'debut_reel',
    'debut_realise',
    'fin_realise',
    'volume_realise',
    'emp_code',
    'motif',
    'volume_prevu',
    'actif',
    'est_valide',
    'horaire_id',
    'programme_id',
    'tolerance',
    'est_attendu',
    'etats',
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
    
    
                    'pointeuse' => [
            //'required'
            ],
        
    
    
                    'lieu' => [
            //'required'
            ],
        
    
    
                    'debut_prevu' => [
            //'required'
            ],
        
    
    
                    'fin_prevu' => [
            //'required'
            ],
        
    
    
                    'faction_horaire' => [
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
        
    
    
                    'volume_realise' => [
            //'required'
            ],
        
    
    
                    'emp_code' => [
            //'required'
            ],
        
    
    
                    'motif' => [
            //'required'
            ],
        
    
    
                    'volume_prevu' => [
            //'required'
            ],
        
    
    
                    'actif' => [
            //'required'
            ],
        
    
    
                    'est_valide' => [
            //'required'
            ],
        
    
    
                    'horaire_id' => [
            //'required'
            ],
        
    
    
                    'programme_id' => [
            //'required'
            ],
        
    
    
                    'tolerance' => [
            //'required'
            ],
        
    
    
                    'est_attendu' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'pointeuse' => ['cette donnee est obligatoire'],

    
    
        'lieu' => ['cette donnee est obligatoire'],

    
    
        'debut_prevu' => ['cette donnee est obligatoire'],

    
    
        'fin_prevu' => ['cette donnee est obligatoire'],

    
    
        'faction_horaire' => ['cette donnee est obligatoire'],

    
    
        'debut_reel' => ['cette donnee est obligatoire'],

    
    
        'debut_realise' => ['cette donnee est obligatoire'],

    
    
        'fin_realise' => ['cette donnee est obligatoire'],

    
    
        'volume_realise' => ['cette donnee est obligatoire'],

    
    
        'emp_code' => ['cette donnee est obligatoire'],

    
    
        'motif' => ['cette donnee est obligatoire'],

    
    
        'volume_prevu' => ['cette donnee est obligatoire'],

    
    
        'actif' => ['cette donnee est obligatoire'],

    
    
        'est_valide' => ['cette donnee est obligatoire'],

    
    
        'horaire_id' => ['cette donnee est obligatoire'],

    
    
        'programme_id' => ['cette donnee est obligatoire'],

    
    
        'tolerance' => ['cette donnee est obligatoire'],

    
    
        'est_attendu' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['pointeuse'])){
        
            $Pointages->pointeuse = $data['pointeuse'];
        
        }



    







    

        if(!empty($data['lieu'])){
        
            $Pointages->lieu = $data['lieu'];
        
        }



    







    

        if(!empty($data['debut_prevu'])){
        
            $Pointages->debut_prevu = $data['debut_prevu'];
        
        }



    







    

        if(!empty($data['fin_prevu'])){
        
            $Pointages->fin_prevu = $data['fin_prevu'];
        
        }



    







    

        if(!empty($data['faction_horaire'])){
        
            $Pointages->faction_horaire = $data['faction_horaire'];
        
        }



    







    

        if(!empty($data['debut_reel'])){
        
            $Pointages->debut_reel = $data['debut_reel'];
        
        }



    







    

        if(!empty($data['debut_realise'])){
        
            $Pointages->debut_realise = $data['debut_realise'];
        
        }



    







    

        if(!empty($data['fin_realise'])){
        
            $Pointages->fin_realise = $data['fin_realise'];
        
        }



    







    

        if(!empty($data['volume_realise'])){
        
            $Pointages->volume_realise = $data['volume_realise'];
        
        }



    







    

        if(!empty($data['emp_code'])){
        
            $Pointages->emp_code = $data['emp_code'];
        
        }



    







    

        if(!empty($data['motif'])){
        
            $Pointages->motif = $data['motif'];
        
        }



    







    

        if(!empty($data['volume_prevu'])){
        
            $Pointages->volume_prevu = $data['volume_prevu'];
        
        }



    







    

        if(!empty($data['actif'])){
        
            $Pointages->actif = $data['actif'];
        
        }



    







    

        if(!empty($data['est_valide'])){
        
            $Pointages->est_valide = $data['est_valide'];
        
        }



    







    

        if(!empty($data['horaire_id'])){
        
            $Pointages->horaire_id = $data['horaire_id'];
        
        }



    







    

        if(!empty($data['programme_id'])){
        
            $Pointages->programme_id = $data['programme_id'];
        
        }



    







    

        if(!empty($data['tolerance'])){
        
            $Pointages->tolerance = $data['tolerance'];
        
        }



    







    

        if(!empty($data['est_attendu'])){
        
            $Pointages->est_attendu = $data['est_attendu'];
        
        }



    







    

        if(!empty($data['etats'])){
        
            $Pointages->etats = $data['etats'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Pointages->user_id = $data['user_id'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Pointages->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Pointages->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Pointages->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\PointageExtras') &&
method_exists('\App\Http\Extras\PointageExtras', 'beforeSaveCreate')
){
\App\Http\Extras\PointageExtras::beforeSaveCreate($request,$Pointages);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PointageExtras') &&
method_exists('\App\Http\Extras\PointageExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\PointageExtras::canCreate($request, $Pointages);
}catch (\Throwable $e){

}

}


if($canSave){
$Pointages->save();
}else{
return response()->json($Pointages, 200);
}

$Pointages=Pointage::find($Pointages->id);
$newCrudData=[];

                $newCrudData['pointeuse']=$Pointages->pointeuse;
                $newCrudData['lieu']=$Pointages->lieu;
                $newCrudData['debut_prevu']=$Pointages->debut_prevu;
                $newCrudData['fin_prevu']=$Pointages->fin_prevu;
                $newCrudData['faction_horaire']=$Pointages->faction_horaire;
                $newCrudData['debut_reel']=$Pointages->debut_reel;
                $newCrudData['debut_realise']=$Pointages->debut_realise;
                $newCrudData['fin_realise']=$Pointages->fin_realise;
                $newCrudData['volume_realise']=$Pointages->volume_realise;
                $newCrudData['emp_code']=$Pointages->emp_code;
                $newCrudData['motif']=$Pointages->motif;
                $newCrudData['volume_prevu']=$Pointages->volume_prevu;
                $newCrudData['actif']=$Pointages->actif;
                $newCrudData['est_valide']=$Pointages->est_valide;
                $newCrudData['horaire_id']=$Pointages->horaire_id;
                $newCrudData['programme_id']=$Pointages->programme_id;
                $newCrudData['tolerance']=$Pointages->tolerance;
                $newCrudData['est_attendu']=$Pointages->est_attendu;
                $newCrudData['etats']=$Pointages->etats;
                $newCrudData['user_id']=$Pointages->user_id;
                                $newCrudData['identifiants_sadge']=$Pointages->identifiants_sadge;
                $newCrudData['creat_by']=$Pointages->creat_by;
    
 try{ $newCrudData['horaire']=$Pointages->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['programme']=$Pointages->programme->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Pointages->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Pointages','entite_cle' => $Pointages->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Pointages->toArray();




try{

foreach ($Pointages->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Pointage $Pointages)
{
try{
$can=\App\Helpers\Helpers::can('Editer des pointages');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['pointeuse']=$Pointages->pointeuse;
                $oldCrudData['lieu']=$Pointages->lieu;
                $oldCrudData['debut_prevu']=$Pointages->debut_prevu;
                $oldCrudData['fin_prevu']=$Pointages->fin_prevu;
                $oldCrudData['faction_horaire']=$Pointages->faction_horaire;
                $oldCrudData['debut_reel']=$Pointages->debut_reel;
                $oldCrudData['debut_realise']=$Pointages->debut_realise;
                $oldCrudData['fin_realise']=$Pointages->fin_realise;
                $oldCrudData['volume_realise']=$Pointages->volume_realise;
                $oldCrudData['emp_code']=$Pointages->emp_code;
                $oldCrudData['motif']=$Pointages->motif;
                $oldCrudData['volume_prevu']=$Pointages->volume_prevu;
                $oldCrudData['actif']=$Pointages->actif;
                $oldCrudData['est_valide']=$Pointages->est_valide;
                $oldCrudData['horaire_id']=$Pointages->horaire_id;
                $oldCrudData['programme_id']=$Pointages->programme_id;
                $oldCrudData['tolerance']=$Pointages->tolerance;
                $oldCrudData['est_attendu']=$Pointages->est_attendu;
                $oldCrudData['etats']=$Pointages->etats;
                $oldCrudData['user_id']=$Pointages->user_id;
                                $oldCrudData['identifiants_sadge']=$Pointages->identifiants_sadge;
                $oldCrudData['creat_by']=$Pointages->creat_by;
    
 try{ $oldCrudData['horaire']=$Pointages->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['programme']=$Pointages->programme->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Pointages->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "pointages"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'pointeuse',
    'lieu',
    'debut_prevu',
    'fin_prevu',
    'faction_horaire',
    'debut_reel',
    'debut_realise',
    'fin_realise',
    'volume_realise',
    'emp_code',
    'motif',
    'volume_prevu',
    'actif',
    'est_valide',
    'horaire_id',
    'programme_id',
    'tolerance',
    'est_attendu',
    'etats',
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
    
    
                    'pointeuse' => [
            //'required'
            ],
        
    
    
                    'lieu' => [
            //'required'
            ],
        
    
    
                    'debut_prevu' => [
            //'required'
            ],
        
    
    
                    'fin_prevu' => [
            //'required'
            ],
        
    
    
                    'faction_horaire' => [
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
        
    
    
                    'volume_realise' => [
            //'required'
            ],
        
    
    
                    'emp_code' => [
            //'required'
            ],
        
    
    
                    'motif' => [
            //'required'
            ],
        
    
    
                    'volume_prevu' => [
            //'required'
            ],
        
    
    
                    'actif' => [
            //'required'
            ],
        
    
    
                    'est_valide' => [
            //'required'
            ],
        
    
    
                    'horaire_id' => [
            //'required'
            ],
        
    
    
                    'programme_id' => [
            //'required'
            ],
        
    
    
                    'tolerance' => [
            //'required'
            ],
        
    
    
                    'est_attendu' => [
            //'required'
            ],
        
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'pointeuse' => ['cette donnee est obligatoire'],

    
    
        'lieu' => ['cette donnee est obligatoire'],

    
    
        'debut_prevu' => ['cette donnee est obligatoire'],

    
    
        'fin_prevu' => ['cette donnee est obligatoire'],

    
    
        'faction_horaire' => ['cette donnee est obligatoire'],

    
    
        'debut_reel' => ['cette donnee est obligatoire'],

    
    
        'debut_realise' => ['cette donnee est obligatoire'],

    
    
        'fin_realise' => ['cette donnee est obligatoire'],

    
    
        'volume_realise' => ['cette donnee est obligatoire'],

    
    
        'emp_code' => ['cette donnee est obligatoire'],

    
    
        'motif' => ['cette donnee est obligatoire'],

    
    
        'volume_prevu' => ['cette donnee est obligatoire'],

    
    
        'actif' => ['cette donnee est obligatoire'],

    
    
        'est_valide' => ['cette donnee est obligatoire'],

    
    
        'horaire_id' => ['cette donnee est obligatoire'],

    
    
        'programme_id' => ['cette donnee est obligatoire'],

    
    
        'tolerance' => ['cette donnee est obligatoire'],

    
    
        'est_attendu' => ['cette donnee est obligatoire'],

    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("pointeuse",$data)){


        if(!empty($data['pointeuse'])){
        
            $Pointages->pointeuse = $data['pointeuse'];
        
        }

        }

    







    

        if(array_key_exists("lieu",$data)){


        if(!empty($data['lieu'])){
        
            $Pointages->lieu = $data['lieu'];
        
        }

        }

    







    

        if(array_key_exists("debut_prevu",$data)){


        if(!empty($data['debut_prevu'])){
        
            $Pointages->debut_prevu = $data['debut_prevu'];
        
        }

        }

    







    

        if(array_key_exists("fin_prevu",$data)){


        if(!empty($data['fin_prevu'])){
        
            $Pointages->fin_prevu = $data['fin_prevu'];
        
        }

        }

    







    

        if(array_key_exists("faction_horaire",$data)){


        if(!empty($data['faction_horaire'])){
        
            $Pointages->faction_horaire = $data['faction_horaire'];
        
        }

        }

    







    

        if(array_key_exists("debut_reel",$data)){


        if(!empty($data['debut_reel'])){
        
            $Pointages->debut_reel = $data['debut_reel'];
        
        }

        }

    







    

        if(array_key_exists("debut_realise",$data)){


        if(!empty($data['debut_realise'])){
        
            $Pointages->debut_realise = $data['debut_realise'];
        
        }

        }

    







    

        if(array_key_exists("fin_realise",$data)){


        if(!empty($data['fin_realise'])){
        
            $Pointages->fin_realise = $data['fin_realise'];
        
        }

        }

    







    

        if(array_key_exists("volume_realise",$data)){


        if(!empty($data['volume_realise'])){
        
            $Pointages->volume_realise = $data['volume_realise'];
        
        }

        }

    







    

        if(array_key_exists("emp_code",$data)){


        if(!empty($data['emp_code'])){
        
            $Pointages->emp_code = $data['emp_code'];
        
        }

        }

    







    

        if(array_key_exists("motif",$data)){


        if(!empty($data['motif'])){
        
            $Pointages->motif = $data['motif'];
        
        }

        }

    







    

        if(array_key_exists("volume_prevu",$data)){


        if(!empty($data['volume_prevu'])){
        
            $Pointages->volume_prevu = $data['volume_prevu'];
        
        }

        }

    







    

        if(array_key_exists("actif",$data)){


        if(!empty($data['actif'])){
        
            $Pointages->actif = $data['actif'];
        
        }

        }

    







    

        if(array_key_exists("est_valide",$data)){


        if(!empty($data['est_valide'])){
        
            $Pointages->est_valide = $data['est_valide'];
        
        }

        }

    







    

        if(array_key_exists("horaire_id",$data)){


        if(!empty($data['horaire_id'])){
        
            $Pointages->horaire_id = $data['horaire_id'];
        
        }

        }

    







    

        if(array_key_exists("programme_id",$data)){


        if(!empty($data['programme_id'])){
        
            $Pointages->programme_id = $data['programme_id'];
        
        }

        }

    







    

        if(array_key_exists("tolerance",$data)){


        if(!empty($data['tolerance'])){
        
            $Pointages->tolerance = $data['tolerance'];
        
        }

        }

    







    

        if(array_key_exists("est_attendu",$data)){


        if(!empty($data['est_attendu'])){
        
            $Pointages->est_attendu = $data['est_attendu'];
        
        }

        }

    







    

        if(array_key_exists("etats",$data)){


        if(!empty($data['etats'])){
        
            $Pointages->etats = $data['etats'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Pointages->user_id = $data['user_id'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Pointages->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Pointages->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Pointages->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\PointageExtras') &&
method_exists('\App\Http\Extras\PointageExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\PointageExtras::beforeSaveUpdate($request,$Pointages);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PointageExtras') &&
method_exists('\App\Http\Extras\PointageExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\PointageExtras::canUpdate($request, $Pointages);
}catch (\Throwable $e){

}

}


if($canSave){
$Pointages->save();
}else{
return response()->json($Pointages, 200);

}


$Pointages=Pointage::find($Pointages->id);



$newCrudData=[];

                $newCrudData['pointeuse']=$Pointages->pointeuse;
                $newCrudData['lieu']=$Pointages->lieu;
                $newCrudData['debut_prevu']=$Pointages->debut_prevu;
                $newCrudData['fin_prevu']=$Pointages->fin_prevu;
                $newCrudData['faction_horaire']=$Pointages->faction_horaire;
                $newCrudData['debut_reel']=$Pointages->debut_reel;
                $newCrudData['debut_realise']=$Pointages->debut_realise;
                $newCrudData['fin_realise']=$Pointages->fin_realise;
                $newCrudData['volume_realise']=$Pointages->volume_realise;
                $newCrudData['emp_code']=$Pointages->emp_code;
                $newCrudData['motif']=$Pointages->motif;
                $newCrudData['volume_prevu']=$Pointages->volume_prevu;
                $newCrudData['actif']=$Pointages->actif;
                $newCrudData['est_valide']=$Pointages->est_valide;
                $newCrudData['horaire_id']=$Pointages->horaire_id;
                $newCrudData['programme_id']=$Pointages->programme_id;
                $newCrudData['tolerance']=$Pointages->tolerance;
                $newCrudData['est_attendu']=$Pointages->est_attendu;
                $newCrudData['etats']=$Pointages->etats;
                $newCrudData['user_id']=$Pointages->user_id;
                                $newCrudData['identifiants_sadge']=$Pointages->identifiants_sadge;
                $newCrudData['creat_by']=$Pointages->creat_by;
    
 try{ $newCrudData['horaire']=$Pointages->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['programme']=$Pointages->programme->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Pointages->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Pointages','entite_cle' => $Pointages->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Pointages->toArray();




try{

foreach ($Pointages->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Pointage $Pointages)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des pointages');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['pointeuse']=$Pointages->pointeuse;
                $newCrudData['lieu']=$Pointages->lieu;
                $newCrudData['debut_prevu']=$Pointages->debut_prevu;
                $newCrudData['fin_prevu']=$Pointages->fin_prevu;
                $newCrudData['faction_horaire']=$Pointages->faction_horaire;
                $newCrudData['debut_reel']=$Pointages->debut_reel;
                $newCrudData['debut_realise']=$Pointages->debut_realise;
                $newCrudData['fin_realise']=$Pointages->fin_realise;
                $newCrudData['volume_realise']=$Pointages->volume_realise;
                $newCrudData['emp_code']=$Pointages->emp_code;
                $newCrudData['motif']=$Pointages->motif;
                $newCrudData['volume_prevu']=$Pointages->volume_prevu;
                $newCrudData['actif']=$Pointages->actif;
                $newCrudData['est_valide']=$Pointages->est_valide;
                $newCrudData['horaire_id']=$Pointages->horaire_id;
                $newCrudData['programme_id']=$Pointages->programme_id;
                $newCrudData['tolerance']=$Pointages->tolerance;
                $newCrudData['est_attendu']=$Pointages->est_attendu;
                $newCrudData['etats']=$Pointages->etats;
                $newCrudData['user_id']=$Pointages->user_id;
                                $newCrudData['identifiants_sadge']=$Pointages->identifiants_sadge;
                $newCrudData['creat_by']=$Pointages->creat_by;
    
 try{ $newCrudData['horaire']=$Pointages->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['programme']=$Pointages->programme->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Pointages->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Pointages','entite_cle' => $Pointages->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\PointageExtras') &&
method_exists('\App\Http\Extras\PointageExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\PointageExtras::canDelete($request, $Pointages);
}catch (\Throwable $e){

}

}



if($canSave){
$Pointages->delete();
}else{
return response()->json($Pointages, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\PointagesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
