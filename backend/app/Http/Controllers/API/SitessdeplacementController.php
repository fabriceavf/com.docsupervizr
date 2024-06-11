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
// use App\Repository\prod\SitessdeplacementsRepository;
use App\Models\Sitessdeplacement;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Deplacement;
                use App\Models\Site;
    
class SitessdeplacementController extends Controller
{

private $SitessdeplacementsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\SitessdeplacementsRepository $SitessdeplacementsRepository
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
class_exists('\App\Http\Extras\SitessdeplacementExtras') &&
method_exists('\App\Http\Extras\SitessdeplacementExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\SitessdeplacementExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Sitessdeplacement::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\SitessdeplacementExtras') &&
method_exists('\App\Http\Extras\SitessdeplacementExtras', 'filterAgGridQuery')
){
\App\Http\Extras\SitessdeplacementExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('sitessdeplacements',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\SitessdeplacementExtras') &&
method_exists('\App\Http\Extras\SitessdeplacementExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\SitessdeplacementExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  sitessdeplacements reussi',
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
return response()->json(Sitessdeplacement::count());
}
$data = QueryBuilder::for(Sitessdeplacement::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('deplacement_id'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('durees'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('date'),

    
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

    
            AllowedSort::field('deplacement_id'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('durees'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('date'),

    
])
    
    
->allowedIncludes([

            'deplacement',
        

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




$data = QueryBuilder::for(Sitessdeplacement::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('deplacement_id'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('durees'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('date'),

    
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

    
            AllowedSort::field('deplacement_id'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('durees'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('date'),

    
])
    
    
->allowedIncludes([
            'deplacement',
        

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



public function create(Request $request, Sitessdeplacement $Sitessdeplacements)
{


try{
$can=\App\Helpers\Helpers::can('Creer des sitessdeplacements');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "sitessdeplacements"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'deplacement_id',
    'site_id',
    'durees',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'date',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'deplacement_id' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'durees' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'date' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'deplacement_id' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'durees' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'date' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['deplacement_id'])){
        
            $Sitessdeplacements->deplacement_id = $data['deplacement_id'];
        
        }



    







    

        if(!empty($data['site_id'])){
        
            $Sitessdeplacements->site_id = $data['site_id'];
        
        }



    







    

        if(!empty($data['durees'])){
        
            $Sitessdeplacements->durees = $data['durees'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Sitessdeplacements->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['date'])){
        
            $Sitessdeplacements->date = $data['date'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Sitessdeplacements->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\SitessdeplacementExtras') &&
method_exists('\App\Http\Extras\SitessdeplacementExtras', 'beforeSaveCreate')
){
\App\Http\Extras\SitessdeplacementExtras::beforeSaveCreate($request,$Sitessdeplacements);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\SitessdeplacementExtras') &&
method_exists('\App\Http\Extras\SitessdeplacementExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\SitessdeplacementExtras::canCreate($request, $Sitessdeplacements);
}catch (\Throwable $e){

}

}


if($canSave){
$Sitessdeplacements->save();
}else{
return response()->json($Sitessdeplacements, 200);
}

$Sitessdeplacements=Sitessdeplacement::find($Sitessdeplacements->id);
$newCrudData=[];

                $newCrudData['deplacement_id']=$Sitessdeplacements->deplacement_id;
                $newCrudData['site_id']=$Sitessdeplacements->site_id;
                $newCrudData['durees']=$Sitessdeplacements->durees;
                $newCrudData['creat_by']=$Sitessdeplacements->creat_by;
                                $newCrudData['date']=$Sitessdeplacements->date;
    
 try{ $newCrudData['deplacement']=$Sitessdeplacements->deplacement->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Sitessdeplacements->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Sitessdeplacements','entite_cle' => $Sitessdeplacements->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Sitessdeplacements->toArray();




try{

foreach ($Sitessdeplacements->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Sitessdeplacement $Sitessdeplacements)
{
try{
$can=\App\Helpers\Helpers::can('Editer des sitessdeplacements');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['deplacement_id']=$Sitessdeplacements->deplacement_id;
                $oldCrudData['site_id']=$Sitessdeplacements->site_id;
                $oldCrudData['durees']=$Sitessdeplacements->durees;
                $oldCrudData['creat_by']=$Sitessdeplacements->creat_by;
                                $oldCrudData['date']=$Sitessdeplacements->date;
    
 try{ $oldCrudData['deplacement']=$Sitessdeplacements->deplacement->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['site']=$Sitessdeplacements->site->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "sitessdeplacements"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'deplacement_id',
    'site_id',
    'durees',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'date',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'deplacement_id' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'durees' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'date' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'deplacement_id' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'durees' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'date' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("deplacement_id",$data)){


        if(!empty($data['deplacement_id'])){
        
            $Sitessdeplacements->deplacement_id = $data['deplacement_id'];
        
        }

        }

    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Sitessdeplacements->site_id = $data['site_id'];
        
        }

        }

    







    

        if(array_key_exists("durees",$data)){


        if(!empty($data['durees'])){
        
            $Sitessdeplacements->durees = $data['durees'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Sitessdeplacements->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("date",$data)){


        if(!empty($data['date'])){
        
            $Sitessdeplacements->date = $data['date'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Sitessdeplacements->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\SitessdeplacementExtras') &&
method_exists('\App\Http\Extras\SitessdeplacementExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\SitessdeplacementExtras::beforeSaveUpdate($request,$Sitessdeplacements);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\SitessdeplacementExtras') &&
method_exists('\App\Http\Extras\SitessdeplacementExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\SitessdeplacementExtras::canUpdate($request, $Sitessdeplacements);
}catch (\Throwable $e){

}

}


if($canSave){
$Sitessdeplacements->save();
}else{
return response()->json($Sitessdeplacements, 200);

}


$Sitessdeplacements=Sitessdeplacement::find($Sitessdeplacements->id);



$newCrudData=[];

                $newCrudData['deplacement_id']=$Sitessdeplacements->deplacement_id;
                $newCrudData['site_id']=$Sitessdeplacements->site_id;
                $newCrudData['durees']=$Sitessdeplacements->durees;
                $newCrudData['creat_by']=$Sitessdeplacements->creat_by;
                                $newCrudData['date']=$Sitessdeplacements->date;
    
 try{ $newCrudData['deplacement']=$Sitessdeplacements->deplacement->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Sitessdeplacements->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Sitessdeplacements','entite_cle' => $Sitessdeplacements->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Sitessdeplacements->toArray();




try{

foreach ($Sitessdeplacements->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Sitessdeplacement $Sitessdeplacements)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des sitessdeplacements');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['deplacement_id']=$Sitessdeplacements->deplacement_id;
                $newCrudData['site_id']=$Sitessdeplacements->site_id;
                $newCrudData['durees']=$Sitessdeplacements->durees;
                $newCrudData['creat_by']=$Sitessdeplacements->creat_by;
                                $newCrudData['date']=$Sitessdeplacements->date;
    
 try{ $newCrudData['deplacement']=$Sitessdeplacements->deplacement->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Sitessdeplacements->site->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Sitessdeplacements','entite_cle' => $Sitessdeplacements->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\SitessdeplacementExtras') &&
method_exists('\App\Http\Extras\SitessdeplacementExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\SitessdeplacementExtras::canDelete($request, $Sitessdeplacements);
}catch (\Throwable $e){

}

}



if($canSave){
$Sitessdeplacements->delete();
}else{
return response()->json($Sitessdeplacements, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\SitessdeplacementsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
