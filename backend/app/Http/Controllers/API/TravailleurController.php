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
// use App\Repository\prod\TravailleursRepository;
use App\Models\Travailleur;
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
                use App\Models\Tache;
        
class TravailleurController extends Controller
{

private $TravailleursRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TravailleursRepository $TravailleursRepository
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
class_exists('\App\Http\Extras\TravailleurExtras') &&
method_exists('\App\Http\Extras\TravailleurExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TravailleurExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Travailleur::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TravailleurExtras') &&
method_exists('\App\Http\Extras\TravailleurExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TravailleurExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('travailleurs',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TravailleurExtras') &&
method_exists('\App\Http\Extras\TravailleurExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TravailleurExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  travailleurs reussi',
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
return response()->json(Travailleur::count());
}
$data = QueryBuilder::for(Travailleur::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('horaire_id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
    
    
    
    
            AllowedFilter::exact('tache_id'),

    
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

    
            AllowedSort::field('horaire_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
    
    
    
    
            AllowedSort::field('tache_id'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
->allowedIncludes([

            'horaire',
        

                'tache',
        

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




$data = QueryBuilder::for(Travailleur::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('horaire_id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('lun'),

    
            AllowedFilter::exact('mar'),

    
            AllowedFilter::exact('mer'),

    
            AllowedFilter::exact('jeu'),

    
            AllowedFilter::exact('ven'),

    
            AllowedFilter::exact('sam'),

    
            AllowedFilter::exact('dim'),

    
    
    
    
    
            AllowedFilter::exact('tache_id'),

    
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

    
            AllowedSort::field('horaire_id'),

    
            AllowedSort::field('user_id'),

    
            AllowedSort::field('lun'),

    
            AllowedSort::field('mar'),

    
            AllowedSort::field('mer'),

    
            AllowedSort::field('jeu'),

    
            AllowedSort::field('ven'),

    
            AllowedSort::field('sam'),

    
            AllowedSort::field('dim'),

    
    
    
    
    
            AllowedSort::field('tache_id'),

    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
->allowedIncludes([
            'horaire',
        

                'tache',
        

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



public function create(Request $request, Travailleur $Travailleurs)
{


try{
$can=\App\Helpers\Helpers::can('Creer des travailleurs');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "travailleurs"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'horaire_id',
    'user_id',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'tache_id',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'horaire_id' => [
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
        
    
    
    
    
    
    
                    'tache_id' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'horaire_id' => ['cette donnee est obligatoire'],

    
    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'tache_id' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['horaire_id'])){
        
            $Travailleurs->horaire_id = $data['horaire_id'];
        
        }



    







    

        if(!empty($data['user_id'])){
        
            $Travailleurs->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['lun'])){
        
            $Travailleurs->lun = $data['lun'];
        
        }



    







    

        if(!empty($data['mar'])){
        
            $Travailleurs->mar = $data['mar'];
        
        }



    







    

        if(!empty($data['mer'])){
        
            $Travailleurs->mer = $data['mer'];
        
        }



    







    

        if(!empty($data['jeu'])){
        
            $Travailleurs->jeu = $data['jeu'];
        
        }



    







    

        if(!empty($data['ven'])){
        
            $Travailleurs->ven = $data['ven'];
        
        }



    







    

        if(!empty($data['sam'])){
        
            $Travailleurs->sam = $data['sam'];
        
        }



    







    

        if(!empty($data['dim'])){
        
            $Travailleurs->dim = $data['dim'];
        
        }



    







    







    







    







    







    

        if(!empty($data['tache_id'])){
        
            $Travailleurs->tache_id = $data['tache_id'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Travailleurs->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Travailleurs->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Travailleurs->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TravailleurExtras') &&
method_exists('\App\Http\Extras\TravailleurExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TravailleurExtras::beforeSaveCreate($request,$Travailleurs);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TravailleurExtras') &&
method_exists('\App\Http\Extras\TravailleurExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TravailleurExtras::canCreate($request, $Travailleurs);
}catch (\Throwable $e){

}

}


if($canSave){
$Travailleurs->save();
}else{
return response()->json($Travailleurs, 200);
}

$Travailleurs=Travailleur::find($Travailleurs->id);
$newCrudData=[];

                $newCrudData['horaire_id']=$Travailleurs->horaire_id;
                $newCrudData['user_id']=$Travailleurs->user_id;
                $newCrudData['lun']=$Travailleurs->lun;
                $newCrudData['mar']=$Travailleurs->mar;
                $newCrudData['mer']=$Travailleurs->mer;
                $newCrudData['jeu']=$Travailleurs->jeu;
                $newCrudData['ven']=$Travailleurs->ven;
                $newCrudData['sam']=$Travailleurs->sam;
                $newCrudData['dim']=$Travailleurs->dim;
                                $newCrudData['tache_id']=$Travailleurs->tache_id;
                $newCrudData['identifiants_sadge']=$Travailleurs->identifiants_sadge;
                $newCrudData['creat_by']=$Travailleurs->creat_by;
    
 try{ $newCrudData['horaire']=$Travailleurs->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['tache']=$Travailleurs->tache->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Travailleurs->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Travailleurs','entite_cle' => $Travailleurs->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Travailleurs->toArray();




try{

foreach ($Travailleurs->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Travailleur $Travailleurs)
{
try{
$can=\App\Helpers\Helpers::can('Editer des travailleurs');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['horaire_id']=$Travailleurs->horaire_id;
                $oldCrudData['user_id']=$Travailleurs->user_id;
                $oldCrudData['lun']=$Travailleurs->lun;
                $oldCrudData['mar']=$Travailleurs->mar;
                $oldCrudData['mer']=$Travailleurs->mer;
                $oldCrudData['jeu']=$Travailleurs->jeu;
                $oldCrudData['ven']=$Travailleurs->ven;
                $oldCrudData['sam']=$Travailleurs->sam;
                $oldCrudData['dim']=$Travailleurs->dim;
                                $oldCrudData['tache_id']=$Travailleurs->tache_id;
                $oldCrudData['identifiants_sadge']=$Travailleurs->identifiants_sadge;
                $oldCrudData['creat_by']=$Travailleurs->creat_by;
    
 try{ $oldCrudData['horaire']=$Travailleurs->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['tache']=$Travailleurs->tache->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Travailleurs->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "travailleurs"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'horaire_id',
    'user_id',
    'lun',
    'mar',
    'mer',
    'jeu',
    'ven',
    'sam',
    'dim',
    'created_at',
    'updated_at',
    'extra_attributes',
    'deleted_at',
    'tache_id',
    'identifiants_sadge',
    'creat_by',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'horaire_id' => [
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
        
    
    
    
    
    
    
                    'tache_id' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'horaire_id' => ['cette donnee est obligatoire'],

    
    
    
        'lun' => ['cette donnee est obligatoire'],

    
    
        'mar' => ['cette donnee est obligatoire'],

    
    
        'mer' => ['cette donnee est obligatoire'],

    
    
        'jeu' => ['cette donnee est obligatoire'],

    
    
        'ven' => ['cette donnee est obligatoire'],

    
    
        'sam' => ['cette donnee est obligatoire'],

    
    
        'dim' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'tache_id' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("horaire_id",$data)){


        if(!empty($data['horaire_id'])){
        
            $Travailleurs->horaire_id = $data['horaire_id'];
        
        }

        }

    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Travailleurs->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("lun",$data)){


        if(!empty($data['lun'])){
        
            $Travailleurs->lun = $data['lun'];
        
        }

        }

    







    

        if(array_key_exists("mar",$data)){


        if(!empty($data['mar'])){
        
            $Travailleurs->mar = $data['mar'];
        
        }

        }

    







    

        if(array_key_exists("mer",$data)){


        if(!empty($data['mer'])){
        
            $Travailleurs->mer = $data['mer'];
        
        }

        }

    







    

        if(array_key_exists("jeu",$data)){


        if(!empty($data['jeu'])){
        
            $Travailleurs->jeu = $data['jeu'];
        
        }

        }

    







    

        if(array_key_exists("ven",$data)){


        if(!empty($data['ven'])){
        
            $Travailleurs->ven = $data['ven'];
        
        }

        }

    







    

        if(array_key_exists("sam",$data)){


        if(!empty($data['sam'])){
        
            $Travailleurs->sam = $data['sam'];
        
        }

        }

    







    

        if(array_key_exists("dim",$data)){


        if(!empty($data['dim'])){
        
            $Travailleurs->dim = $data['dim'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("tache_id",$data)){


        if(!empty($data['tache_id'])){
        
            $Travailleurs->tache_id = $data['tache_id'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Travailleurs->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Travailleurs->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Travailleurs->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TravailleurExtras') &&
method_exists('\App\Http\Extras\TravailleurExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TravailleurExtras::beforeSaveUpdate($request,$Travailleurs);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TravailleurExtras') &&
method_exists('\App\Http\Extras\TravailleurExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TravailleurExtras::canUpdate($request, $Travailleurs);
}catch (\Throwable $e){

}

}


if($canSave){
$Travailleurs->save();
}else{
return response()->json($Travailleurs, 200);

}


$Travailleurs=Travailleur::find($Travailleurs->id);



$newCrudData=[];

                $newCrudData['horaire_id']=$Travailleurs->horaire_id;
                $newCrudData['user_id']=$Travailleurs->user_id;
                $newCrudData['lun']=$Travailleurs->lun;
                $newCrudData['mar']=$Travailleurs->mar;
                $newCrudData['mer']=$Travailleurs->mer;
                $newCrudData['jeu']=$Travailleurs->jeu;
                $newCrudData['ven']=$Travailleurs->ven;
                $newCrudData['sam']=$Travailleurs->sam;
                $newCrudData['dim']=$Travailleurs->dim;
                                $newCrudData['tache_id']=$Travailleurs->tache_id;
                $newCrudData['identifiants_sadge']=$Travailleurs->identifiants_sadge;
                $newCrudData['creat_by']=$Travailleurs->creat_by;
    
 try{ $newCrudData['horaire']=$Travailleurs->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['tache']=$Travailleurs->tache->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Travailleurs->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Travailleurs','entite_cle' => $Travailleurs->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Travailleurs->toArray();




try{

foreach ($Travailleurs->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Travailleur $Travailleurs)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des travailleurs');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['horaire_id']=$Travailleurs->horaire_id;
                $newCrudData['user_id']=$Travailleurs->user_id;
                $newCrudData['lun']=$Travailleurs->lun;
                $newCrudData['mar']=$Travailleurs->mar;
                $newCrudData['mer']=$Travailleurs->mer;
                $newCrudData['jeu']=$Travailleurs->jeu;
                $newCrudData['ven']=$Travailleurs->ven;
                $newCrudData['sam']=$Travailleurs->sam;
                $newCrudData['dim']=$Travailleurs->dim;
                                $newCrudData['tache_id']=$Travailleurs->tache_id;
                $newCrudData['identifiants_sadge']=$Travailleurs->identifiants_sadge;
                $newCrudData['creat_by']=$Travailleurs->creat_by;
    
 try{ $newCrudData['horaire']=$Travailleurs->horaire->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['tache']=$Travailleurs->tache->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Travailleurs->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Travailleurs','entite_cle' => $Travailleurs->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TravailleurExtras') &&
method_exists('\App\Http\Extras\TravailleurExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TravailleurExtras::canDelete($request, $Travailleurs);
}catch (\Throwable $e){

}

}



if($canSave){
$Travailleurs->delete();
}else{
return response()->json($Travailleurs, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TravailleursActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
