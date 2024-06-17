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
// use App\Repository\prod\LignesmoyenstransportsRepository;
use App\Models\Lignesmoyenstransport;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Ligne;
                use App\Models\Moyenstransport;
    
class LignesmoyenstransportController extends Controller
{

private $LignesmoyenstransportsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\LignesmoyenstransportsRepository $LignesmoyenstransportsRepository
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
class_exists('\App\Http\Extras\LignesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\LignesmoyenstransportExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\LignesmoyenstransportExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Lignesmoyenstransport::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\LignesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\LignesmoyenstransportExtras', 'filterAgGridQuery')
){
\App\Http\Extras\LignesmoyenstransportExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('lignesmoyenstransports',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\LignesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\LignesmoyenstransportExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\LignesmoyenstransportExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  lignesmoyenstransports reussi',
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
return response()->json(Lignesmoyenstransport::count());
}
$data = QueryBuilder::for(Lignesmoyenstransport::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('moyenstransport_id'),

    
            AllowedFilter::exact('ligne_id'),

    
            AllowedFilter::exact('heure_debut'),

    
            AllowedFilter::exact('heure_fin'),

    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
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

    
            AllowedSort::field('moyenstransport_id'),

    
            AllowedSort::field('ligne_id'),

    
            AllowedSort::field('heure_debut'),

    
            AllowedSort::field('heure_fin'),

    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
->allowedIncludes([
            'deplacements',
        

    
            'ligne',
        

                'moyenstransport',
        

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




$data = QueryBuilder::for(Lignesmoyenstransport::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('moyenstransport_id'),

    
            AllowedFilter::exact('ligne_id'),

    
            AllowedFilter::exact('heure_debut'),

    
            AllowedFilter::exact('heure_fin'),

    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
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

    
            AllowedSort::field('moyenstransport_id'),

    
            AllowedSort::field('ligne_id'),

    
            AllowedSort::field('heure_debut'),

    
            AllowedSort::field('heure_fin'),

    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
->allowedIncludes([
            'deplacements',
        

                'ligne',
        

                'moyenstransport',
        

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



public function create(Request $request, Lignesmoyenstransport $Lignesmoyenstransports)
{


try{
$can=\App\Helpers\Helpers::can('Creer des lignesmoyenstransports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "lignesmoyenstransports"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'moyenstransport_id',
    'ligne_id',
    'heure_debut',
    'heure_fin',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'moyenstransport_id' => [
            //'required'
            ],
        
    
    
                    'ligne_id' => [
            //'required'
            ],
        
    
    
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
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'moyenstransport_id' => ['cette donnee est obligatoire'],

    
    
        'ligne_id' => ['cette donnee est obligatoire'],

    
    
        'heure_debut' => ['cette donnee est obligatoire'],

    
    
        'heure_fin' => ['cette donnee est obligatoire'],

    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['moyenstransport_id'])){
        
            $Lignesmoyenstransports->moyenstransport_id = $data['moyenstransport_id'];
        
        }



    







    

        if(!empty($data['ligne_id'])){
        
            $Lignesmoyenstransports->ligne_id = $data['ligne_id'];
        
        }



    







    

        if(!empty($data['heure_debut'])){
        
            $Lignesmoyenstransports->heure_debut = $data['heure_debut'];
        
        }



    







    

        if(!empty($data['heure_fin'])){
        
            $Lignesmoyenstransports->heure_fin = $data['heure_fin'];
        
        }



    







    

        if(!empty($data['lun'])){
        
            $Lignesmoyenstransports->lun = $data['lun'];
        
        }



    







    

        if(!empty($data['mar'])){
        
            $Lignesmoyenstransports->mar = $data['mar'];
        
        }



    







    

        if(!empty($data['mer'])){
        
            $Lignesmoyenstransports->mer = $data['mer'];
        
        }



    







    

        if(!empty($data['jeu'])){
        
            $Lignesmoyenstransports->jeu = $data['jeu'];
        
        }



    







    

        if(!empty($data['ven'])){
        
            $Lignesmoyenstransports->ven = $data['ven'];
        
        }



    







    

        if(!empty($data['sam'])){
        
            $Lignesmoyenstransports->sam = $data['sam'];
        
        }



    







    

        if(!empty($data['dim'])){
        
            $Lignesmoyenstransports->dim = $data['dim'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Lignesmoyenstransports->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Lignesmoyenstransports->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Lignesmoyenstransports->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\LignesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\LignesmoyenstransportExtras', 'beforeSaveCreate')
){
\App\Http\Extras\LignesmoyenstransportExtras::beforeSaveCreate($request,$Lignesmoyenstransports);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\LignesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\LignesmoyenstransportExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\LignesmoyenstransportExtras::canCreate($request, $Lignesmoyenstransports);
}catch (\Throwable $e){

}

}


if($canSave){
$Lignesmoyenstransports->save();
}else{
return response()->json($Lignesmoyenstransports, 200);
}

$Lignesmoyenstransports=Lignesmoyenstransport::find($Lignesmoyenstransports->id);
$newCrudData=[];

                $newCrudData['moyenstransport_id']=$Lignesmoyenstransports->moyenstransport_id;
                $newCrudData['ligne_id']=$Lignesmoyenstransports->ligne_id;
                $newCrudData['heure_debut']=$Lignesmoyenstransports->heure_debut;
                $newCrudData['heure_fin']=$Lignesmoyenstransports->heure_fin;
                $newCrudData['lun']=$Lignesmoyenstransports->lun;
                $newCrudData['mar']=$Lignesmoyenstransports->mar;
                $newCrudData['mer']=$Lignesmoyenstransports->mer;
                $newCrudData['jeu']=$Lignesmoyenstransports->jeu;
                $newCrudData['ven']=$Lignesmoyenstransports->ven;
                $newCrudData['sam']=$Lignesmoyenstransports->sam;
                $newCrudData['dim']=$Lignesmoyenstransports->dim;
                $newCrudData['creat_by']=$Lignesmoyenstransports->creat_by;
                                $newCrudData['identifiants_sadge']=$Lignesmoyenstransports->identifiants_sadge;
    
 try{ $newCrudData['ligne']=$Lignesmoyenstransports->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['moyenstransport']=$Lignesmoyenstransports->moyenstransport->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Lignesmoyenstransports','entite_cle' => $Lignesmoyenstransports->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Lignesmoyenstransports->toArray();




try{

foreach ($Lignesmoyenstransports->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Lignesmoyenstransport $Lignesmoyenstransports)
{
try{
$can=\App\Helpers\Helpers::can('Editer des lignesmoyenstransports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['moyenstransport_id']=$Lignesmoyenstransports->moyenstransport_id;
                $oldCrudData['ligne_id']=$Lignesmoyenstransports->ligne_id;
                $oldCrudData['heure_debut']=$Lignesmoyenstransports->heure_debut;
                $oldCrudData['heure_fin']=$Lignesmoyenstransports->heure_fin;
                $oldCrudData['lun']=$Lignesmoyenstransports->lun;
                $oldCrudData['mar']=$Lignesmoyenstransports->mar;
                $oldCrudData['mer']=$Lignesmoyenstransports->mer;
                $oldCrudData['jeu']=$Lignesmoyenstransports->jeu;
                $oldCrudData['ven']=$Lignesmoyenstransports->ven;
                $oldCrudData['sam']=$Lignesmoyenstransports->sam;
                $oldCrudData['dim']=$Lignesmoyenstransports->dim;
                $oldCrudData['creat_by']=$Lignesmoyenstransports->creat_by;
                                $oldCrudData['identifiants_sadge']=$Lignesmoyenstransports->identifiants_sadge;
    
 try{ $oldCrudData['ligne']=$Lignesmoyenstransports->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['moyenstransport']=$Lignesmoyenstransports->moyenstransport->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "lignesmoyenstransports"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'moyenstransport_id',
    'ligne_id',
    'heure_debut',
    'heure_fin',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'moyenstransport_id' => [
            //'required'
            ],
        
    
    
                    'ligne_id' => [
            //'required'
            ],
        
    
    
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
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'moyenstransport_id' => ['cette donnee est obligatoire'],

    
    
        'ligne_id' => ['cette donnee est obligatoire'],

    
    
        'heure_debut' => ['cette donnee est obligatoire'],

    
    
        'heure_fin' => ['cette donnee est obligatoire'],

    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("moyenstransport_id",$data)){


        if(!empty($data['moyenstransport_id'])){
        
            $Lignesmoyenstransports->moyenstransport_id = $data['moyenstransport_id'];
        
        }

        }

    







    

        if(array_key_exists("ligne_id",$data)){


        if(!empty($data['ligne_id'])){
        
            $Lignesmoyenstransports->ligne_id = $data['ligne_id'];
        
        }

        }

    







    

        if(array_key_exists("heure_debut",$data)){


        if(!empty($data['heure_debut'])){
        
            $Lignesmoyenstransports->heure_debut = $data['heure_debut'];
        
        }

        }

    







    

        if(array_key_exists("heure_fin",$data)){


        if(!empty($data['heure_fin'])){
        
            $Lignesmoyenstransports->heure_fin = $data['heure_fin'];
        
        }

        }

    







    

        if(array_key_exists("lun",$data)){


        if(!empty($data['lun'])){
        
            $Lignesmoyenstransports->lun = $data['lun'];
        
        }

        }

    







    

        if(array_key_exists("mar",$data)){


        if(!empty($data['mar'])){
        
            $Lignesmoyenstransports->mar = $data['mar'];
        
        }

        }

    







    

        if(array_key_exists("mer",$data)){


        if(!empty($data['mer'])){
        
            $Lignesmoyenstransports->mer = $data['mer'];
        
        }

        }

    







    

        if(array_key_exists("jeu",$data)){


        if(!empty($data['jeu'])){
        
            $Lignesmoyenstransports->jeu = $data['jeu'];
        
        }

        }

    







    

        if(array_key_exists("ven",$data)){


        if(!empty($data['ven'])){
        
            $Lignesmoyenstransports->ven = $data['ven'];
        
        }

        }

    







    

        if(array_key_exists("sam",$data)){


        if(!empty($data['sam'])){
        
            $Lignesmoyenstransports->sam = $data['sam'];
        
        }

        }

    







    

        if(array_key_exists("dim",$data)){


        if(!empty($data['dim'])){
        
            $Lignesmoyenstransports->dim = $data['dim'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Lignesmoyenstransports->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Lignesmoyenstransports->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Lignesmoyenstransports->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\LignesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\LignesmoyenstransportExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\LignesmoyenstransportExtras::beforeSaveUpdate($request,$Lignesmoyenstransports);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\LignesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\LignesmoyenstransportExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\LignesmoyenstransportExtras::canUpdate($request, $Lignesmoyenstransports);
}catch (\Throwable $e){

}

}


if($canSave){
$Lignesmoyenstransports->save();
}else{
return response()->json($Lignesmoyenstransports, 200);

}


$Lignesmoyenstransports=Lignesmoyenstransport::find($Lignesmoyenstransports->id);



$newCrudData=[];

                $newCrudData['moyenstransport_id']=$Lignesmoyenstransports->moyenstransport_id;
                $newCrudData['ligne_id']=$Lignesmoyenstransports->ligne_id;
                $newCrudData['heure_debut']=$Lignesmoyenstransports->heure_debut;
                $newCrudData['heure_fin']=$Lignesmoyenstransports->heure_fin;
                $newCrudData['lun']=$Lignesmoyenstransports->lun;
                $newCrudData['mar']=$Lignesmoyenstransports->mar;
                $newCrudData['mer']=$Lignesmoyenstransports->mer;
                $newCrudData['jeu']=$Lignesmoyenstransports->jeu;
                $newCrudData['ven']=$Lignesmoyenstransports->ven;
                $newCrudData['sam']=$Lignesmoyenstransports->sam;
                $newCrudData['dim']=$Lignesmoyenstransports->dim;
                $newCrudData['creat_by']=$Lignesmoyenstransports->creat_by;
                                $newCrudData['identifiants_sadge']=$Lignesmoyenstransports->identifiants_sadge;
    
 try{ $newCrudData['ligne']=$Lignesmoyenstransports->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['moyenstransport']=$Lignesmoyenstransports->moyenstransport->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Lignesmoyenstransports','entite_cle' => $Lignesmoyenstransports->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Lignesmoyenstransports->toArray();




try{

foreach ($Lignesmoyenstransports->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Lignesmoyenstransport $Lignesmoyenstransports)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des lignesmoyenstransports');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['moyenstransport_id']=$Lignesmoyenstransports->moyenstransport_id;
                $newCrudData['ligne_id']=$Lignesmoyenstransports->ligne_id;
                $newCrudData['heure_debut']=$Lignesmoyenstransports->heure_debut;
                $newCrudData['heure_fin']=$Lignesmoyenstransports->heure_fin;
                $newCrudData['lun']=$Lignesmoyenstransports->lun;
                $newCrudData['mar']=$Lignesmoyenstransports->mar;
                $newCrudData['mer']=$Lignesmoyenstransports->mer;
                $newCrudData['jeu']=$Lignesmoyenstransports->jeu;
                $newCrudData['ven']=$Lignesmoyenstransports->ven;
                $newCrudData['sam']=$Lignesmoyenstransports->sam;
                $newCrudData['dim']=$Lignesmoyenstransports->dim;
                $newCrudData['creat_by']=$Lignesmoyenstransports->creat_by;
                                $newCrudData['identifiants_sadge']=$Lignesmoyenstransports->identifiants_sadge;
    
 try{ $newCrudData['ligne']=$Lignesmoyenstransports->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['moyenstransport']=$Lignesmoyenstransports->moyenstransport->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Lignesmoyenstransports','entite_cle' => $Lignesmoyenstransports->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\LignesmoyenstransportExtras') &&
method_exists('\App\Http\Extras\LignesmoyenstransportExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\LignesmoyenstransportExtras::canDelete($request, $Lignesmoyenstransports);
}catch (\Throwable $e){

}

}



if($canSave){
$Lignesmoyenstransports->delete();
}else{
return response()->json($Lignesmoyenstransports, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\LignesmoyenstransportsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
