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
// use App\Repository\prod\PassagesrondesRepository;
use App\Models\Passagesronde;
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
    
class PassagesrondeController extends Controller
{

private $PassagesrondesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\PassagesrondesRepository $PassagesrondesRepository
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
class_exists('\App\Http\Extras\PassagesrondeExtras') &&
method_exists('\App\Http\Extras\PassagesrondeExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\PassagesrondeExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Passagesronde::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\PassagesrondeExtras') &&
method_exists('\App\Http\Extras\PassagesrondeExtras', 'filterAgGridQuery')
){
\App\Http\Extras\PassagesrondeExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('passagesrondes',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\PassagesrondeExtras') &&
method_exists('\App\Http\Extras\PassagesrondeExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\PassagesrondeExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  passagesrondes reussi',
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
return response()->json(Passagesronde::count());
}
$data = QueryBuilder::for(Passagesronde::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('heure_debut'),

    
            AllowedFilter::exact('heure_fin'),

    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('libelle'),

    
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

    
            AllowedSort::field('heure_debut'),

    
            AllowedSort::field('heure_fin'),

    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('libelle'),

    
])
    
->allowedIncludes([

            'site',
        

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




$data = QueryBuilder::for(Passagesronde::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('heure_debut'),

    
            AllowedFilter::exact('heure_fin'),

    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('identifiants_sadge'),

    
            AllowedFilter::exact('libelle'),

    
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

    
            AllowedSort::field('heure_debut'),

    
            AllowedSort::field('heure_fin'),

    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('libelle'),

    
])
    
->allowedIncludes([
            'site',
        

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



public function create(Request $request, Passagesronde $Passagesrondes)
{


try{
$can=\App\Helpers\Helpers::can('Creer des passagesrondes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "passagesrondes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'heure_debut',
    'heure_fin',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'site_id',
    'creat_by',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'libelle',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'heure_debut' => [
            //'required'
            ],
        
    
    
                    'heure_fin' => [
            //'required'
            ],
        
    
    
                    'lun' => [
            //'required'
            ],
        
    
    
                    'mar' => [
            //'required'
            ],
        
    
    
                    'mer' => [
            //'required'
            ],
        
    
    
                    'jeu' => [
            //'required'
            ],
        
    
    
                    'ven' => [
            //'required'
            ],
        
    
    
                    'sam' => [
            //'required'
            ],
        
    
    
                    'dim' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'libelle' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'heure_debut' => ['cette donnee est obligatoire'],

    
    
        'heure_fin' => ['cette donnee est obligatoire'],

    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['heure_debut'])){
        
            $Passagesrondes->heure_debut = $data['heure_debut'];
        
        }



    







    

        if(!empty($data['heure_fin'])){
        
            $Passagesrondes->heure_fin = $data['heure_fin'];
        
        }



    







    

        if(!empty($data['lun'])){
        
            $Passagesrondes->lun = $data['lun'];
        
        }



    







    

        if(!empty($data['mar'])){
        
            $Passagesrondes->mar = $data['mar'];
        
        }



    







    

        if(!empty($data['mer'])){
        
            $Passagesrondes->mer = $data['mer'];
        
        }



    







    

        if(!empty($data['jeu'])){
        
            $Passagesrondes->jeu = $data['jeu'];
        
        }



    







    

        if(!empty($data['ven'])){
        
            $Passagesrondes->ven = $data['ven'];
        
        }



    







    

        if(!empty($data['sam'])){
        
            $Passagesrondes->sam = $data['sam'];
        
        }



    







    

        if(!empty($data['dim'])){
        
            $Passagesrondes->dim = $data['dim'];
        
        }



    







    

        if(!empty($data['site_id'])){
        
            $Passagesrondes->site_id = $data['site_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Passagesrondes->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Passagesrondes->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['libelle'])){
        
            $Passagesrondes->libelle = $data['libelle'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Passagesrondes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\PassagesrondeExtras') &&
method_exists('\App\Http\Extras\PassagesrondeExtras', 'beforeSaveCreate')
){
\App\Http\Extras\PassagesrondeExtras::beforeSaveCreate($request,$Passagesrondes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PassagesrondeExtras') &&
method_exists('\App\Http\Extras\PassagesrondeExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\PassagesrondeExtras::canCreate($request, $Passagesrondes);
}catch (\Throwable $e){

}

}


if($canSave){
$Passagesrondes->save();
}else{
return response()->json($Passagesrondes, 200);
}

$Passagesrondes=Passagesronde::find($Passagesrondes->id);
$newCrudData=[];

                $newCrudData['heure_debut']=$Passagesrondes->heure_debut;
                $newCrudData['heure_fin']=$Passagesrondes->heure_fin;
                $newCrudData['lun']=$Passagesrondes->lun;
                $newCrudData['mar']=$Passagesrondes->mar;
                $newCrudData['mer']=$Passagesrondes->mer;
                $newCrudData['jeu']=$Passagesrondes->jeu;
                $newCrudData['ven']=$Passagesrondes->ven;
                $newCrudData['sam']=$Passagesrondes->sam;
                $newCrudData['dim']=$Passagesrondes->dim;
                $newCrudData['site_id']=$Passagesrondes->site_id;
                $newCrudData['creat_by']=$Passagesrondes->creat_by;
                                $newCrudData['identifiants_sadge']=$Passagesrondes->identifiants_sadge;
                $newCrudData['libelle']=$Passagesrondes->libelle;
    
 try{ $newCrudData['site']=$Passagesrondes->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Passagesrondes','entite_cle' => $Passagesrondes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Passagesrondes->toArray();




try{

foreach ($Passagesrondes->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Passagesronde $Passagesrondes)
{
try{
$can=\App\Helpers\Helpers::can('Editer des passagesrondes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['heure_debut']=$Passagesrondes->heure_debut;
                $oldCrudData['heure_fin']=$Passagesrondes->heure_fin;
                $oldCrudData['lun']=$Passagesrondes->lun;
                $oldCrudData['mar']=$Passagesrondes->mar;
                $oldCrudData['mer']=$Passagesrondes->mer;
                $oldCrudData['jeu']=$Passagesrondes->jeu;
                $oldCrudData['ven']=$Passagesrondes->ven;
                $oldCrudData['sam']=$Passagesrondes->sam;
                $oldCrudData['dim']=$Passagesrondes->dim;
                $oldCrudData['site_id']=$Passagesrondes->site_id;
                $oldCrudData['creat_by']=$Passagesrondes->creat_by;
                                $oldCrudData['identifiants_sadge']=$Passagesrondes->identifiants_sadge;
                $oldCrudData['libelle']=$Passagesrondes->libelle;
    
 try{ $oldCrudData['site']=$Passagesrondes->site->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "passagesrondes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'heure_debut',
    'heure_fin',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'site_id',
    'creat_by',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'identifiants_sadge',
    'libelle',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'heure_debut' => [
            //'required'
            ],
        
    
    
                    'heure_fin' => [
            //'required'
            ],
        
    
    
                    'lun' => [
            //'required'
            ],
        
    
    
                    'mar' => [
            //'required'
            ],
        
    
    
                    'mer' => [
            //'required'
            ],
        
    
    
                    'jeu' => [
            //'required'
            ],
        
    
    
                    'ven' => [
            //'required'
            ],
        
    
    
                    'sam' => [
            //'required'
            ],
        
    
    
                    'dim' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'libelle' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'heure_debut' => ['cette donnee est obligatoire'],

    
    
        'heure_fin' => ['cette donnee est obligatoire'],

    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'libelle' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("heure_debut",$data)){


        if(!empty($data['heure_debut'])){
        
            $Passagesrondes->heure_debut = $data['heure_debut'];
        
        }

        }

    







    

        if(array_key_exists("heure_fin",$data)){


        if(!empty($data['heure_fin'])){
        
            $Passagesrondes->heure_fin = $data['heure_fin'];
        
        }

        }

    







    

        if(array_key_exists("lun",$data)){


        if(!empty($data['lun'])){
        
            $Passagesrondes->lun = $data['lun'];
        
        }

        }

    







    

        if(array_key_exists("mar",$data)){


        if(!empty($data['mar'])){
        
            $Passagesrondes->mar = $data['mar'];
        
        }

        }

    







    

        if(array_key_exists("mer",$data)){


        if(!empty($data['mer'])){
        
            $Passagesrondes->mer = $data['mer'];
        
        }

        }

    







    

        if(array_key_exists("jeu",$data)){


        if(!empty($data['jeu'])){
        
            $Passagesrondes->jeu = $data['jeu'];
        
        }

        }

    







    

        if(array_key_exists("ven",$data)){


        if(!empty($data['ven'])){
        
            $Passagesrondes->ven = $data['ven'];
        
        }

        }

    







    

        if(array_key_exists("sam",$data)){


        if(!empty($data['sam'])){
        
            $Passagesrondes->sam = $data['sam'];
        
        }

        }

    







    

        if(array_key_exists("dim",$data)){


        if(!empty($data['dim'])){
        
            $Passagesrondes->dim = $data['dim'];
        
        }

        }

    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Passagesrondes->site_id = $data['site_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Passagesrondes->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Passagesrondes->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){
        
            $Passagesrondes->libelle = $data['libelle'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Passagesrondes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\PassagesrondeExtras') &&
method_exists('\App\Http\Extras\PassagesrondeExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\PassagesrondeExtras::beforeSaveUpdate($request,$Passagesrondes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\PassagesrondeExtras') &&
method_exists('\App\Http\Extras\PassagesrondeExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\PassagesrondeExtras::canUpdate($request, $Passagesrondes);
}catch (\Throwable $e){

}

}


if($canSave){
$Passagesrondes->save();
}else{
return response()->json($Passagesrondes, 200);

}


$Passagesrondes=Passagesronde::find($Passagesrondes->id);



$newCrudData=[];

                $newCrudData['heure_debut']=$Passagesrondes->heure_debut;
                $newCrudData['heure_fin']=$Passagesrondes->heure_fin;
                $newCrudData['lun']=$Passagesrondes->lun;
                $newCrudData['mar']=$Passagesrondes->mar;
                $newCrudData['mer']=$Passagesrondes->mer;
                $newCrudData['jeu']=$Passagesrondes->jeu;
                $newCrudData['ven']=$Passagesrondes->ven;
                $newCrudData['sam']=$Passagesrondes->sam;
                $newCrudData['dim']=$Passagesrondes->dim;
                $newCrudData['site_id']=$Passagesrondes->site_id;
                $newCrudData['creat_by']=$Passagesrondes->creat_by;
                                $newCrudData['identifiants_sadge']=$Passagesrondes->identifiants_sadge;
                $newCrudData['libelle']=$Passagesrondes->libelle;
    
 try{ $newCrudData['site']=$Passagesrondes->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Passagesrondes','entite_cle' => $Passagesrondes->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Passagesrondes->toArray();




try{

foreach ($Passagesrondes->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Passagesronde $Passagesrondes)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des passagesrondes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['heure_debut']=$Passagesrondes->heure_debut;
                $newCrudData['heure_fin']=$Passagesrondes->heure_fin;
                $newCrudData['lun']=$Passagesrondes->lun;
                $newCrudData['mar']=$Passagesrondes->mar;
                $newCrudData['mer']=$Passagesrondes->mer;
                $newCrudData['jeu']=$Passagesrondes->jeu;
                $newCrudData['ven']=$Passagesrondes->ven;
                $newCrudData['sam']=$Passagesrondes->sam;
                $newCrudData['dim']=$Passagesrondes->dim;
                $newCrudData['site_id']=$Passagesrondes->site_id;
                $newCrudData['creat_by']=$Passagesrondes->creat_by;
                                $newCrudData['identifiants_sadge']=$Passagesrondes->identifiants_sadge;
                $newCrudData['libelle']=$Passagesrondes->libelle;
    
 try{ $newCrudData['site']=$Passagesrondes->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Passagesrondes','entite_cle' => $Passagesrondes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\PassagesrondeExtras') &&
method_exists('\App\Http\Extras\PassagesrondeExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\PassagesrondeExtras::canDelete($request, $Passagesrondes);
}catch (\Throwable $e){

}

}



if($canSave){
$Passagesrondes->delete();
}else{
return response()->json($Passagesrondes, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\PassagesrondesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
