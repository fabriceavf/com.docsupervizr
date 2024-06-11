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
// use App\Repository\prod\MenusRepository;
use App\Models\Menu;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Entreprise;
        
class MenuController extends Controller
{

private $MenusRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\MenusRepository $MenusRepository
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
class_exists('\App\Http\Extras\MenuExtras') &&
method_exists('\App\Http\Extras\MenuExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\MenuExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Menu::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\MenuExtras') &&
method_exists('\App\Http\Extras\MenuExtras', 'filterAgGridQuery')
){
\App\Http\Extras\MenuExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('menus',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\MenuExtras') &&
method_exists('\App\Http\Extras\MenuExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\MenuExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  menus reussi',
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
return response()->json(Menu::count());
}
$data = QueryBuilder::for(Menu::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('icon'),

    
            AllowedFilter::exact('slug'),

    
            AllowedFilter::exact('url'),

    
            AllowedFilter::exact('ordre'),

    
            AllowedFilter::exact('isSu'),

    
            AllowedFilter::exact('menu_id'),

    
            AllowedFilter::exact('entreprise_id'),

    
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

    
            AllowedSort::field('name'),

    
            AllowedSort::field('icon'),

    
            AllowedSort::field('slug'),

    
            AllowedSort::field('url'),

    
            AllowedSort::field('ordre'),

    
            AllowedSort::field('isSu'),

    
            AllowedSort::field('menu_id'),

    
            AllowedSort::field('entreprise_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
->allowedIncludes([
            'menus',
        

    
            'entreprise',
        

                'menu',
        

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




$data = QueryBuilder::for(Menu::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('icon'),

    
            AllowedFilter::exact('slug'),

    
            AllowedFilter::exact('url'),

    
            AllowedFilter::exact('ordre'),

    
            AllowedFilter::exact('isSu'),

    
            AllowedFilter::exact('menu_id'),

    
            AllowedFilter::exact('entreprise_id'),

    
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

    
            AllowedSort::field('name'),

    
            AllowedSort::field('icon'),

    
            AllowedSort::field('slug'),

    
            AllowedSort::field('url'),

    
            AllowedSort::field('ordre'),

    
            AllowedSort::field('isSu'),

    
            AllowedSort::field('menu_id'),

    
            AllowedSort::field('entreprise_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
->allowedIncludes([
            'menus',
        

                'entreprise',
        

                'menu',
        

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



public function create(Request $request, Menu $Menus)
{


try{
$can=\App\Helpers\Helpers::can('Creer des menus');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "menus"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'name',
    'icon',
    'slug',
    'url',
    'ordre',
    'isSu',
    'menu_id',
    'entreprise_id',
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
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'icon' => [
            //'required'
            ],
        
    
    
                    'slug' => [
            //'required'
            ],
        
    
    
                    'url' => [
            //'required'
            ],
        
    
    
                    'ordre' => [
            //'required'
            ],
        
    
    
                    'isSu' => [
            //'required'
            ],
        
    
    
                    'menu_id' => [
            //'required'
            ],
        
    
    
                    'entreprise_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'icon' => ['cette donnee est obligatoire'],

    
    
        'slug' => ['cette donnee est obligatoire'],

    
    
        'url' => ['cette donnee est obligatoire'],

    
    
        'ordre' => ['cette donnee est obligatoire'],

    
    
        'isSu' => ['cette donnee est obligatoire'],

    
    
        'menu_id' => ['cette donnee est obligatoire'],

    
    
        'entreprise_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['name'])){
        
            $Menus->name = $data['name'];
        
        }



    







    

        if(!empty($data['icon'])){
        
            $Menus->icon = $data['icon'];
        
        }



    







    

        if(!empty($data['slug'])){
        
            $Menus->slug = $data['slug'];
        
        }



    







    

        if(!empty($data['url'])){
        
            $Menus->url = $data['url'];
        
        }



    







    

        if(!empty($data['ordre'])){
        
            $Menus->ordre = $data['ordre'];
        
        }



    







    

        if(!empty($data['isSu'])){
        
            $Menus->isSu = $data['isSu'];
        
        }



    







    

        if(!empty($data['menu_id'])){
        
            $Menus->menu_id = $data['menu_id'];
        
        }



    







    

        if(!empty($data['entreprise_id'])){
        
            $Menus->entreprise_id = $data['entreprise_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Menus->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Menus->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Menus->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\MenuExtras') &&
method_exists('\App\Http\Extras\MenuExtras', 'beforeSaveCreate')
){
\App\Http\Extras\MenuExtras::beforeSaveCreate($request,$Menus);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\MenuExtras') &&
method_exists('\App\Http\Extras\MenuExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\MenuExtras::canCreate($request, $Menus);
}catch (\Throwable $e){

}

}


if($canSave){
$Menus->save();
}else{
return response()->json($Menus, 200);
}

$Menus=Menu::find($Menus->id);
$newCrudData=[];

                $newCrudData['name']=$Menus->name;
                $newCrudData['icon']=$Menus->icon;
                $newCrudData['slug']=$Menus->slug;
                $newCrudData['url']=$Menus->url;
                $newCrudData['ordre']=$Menus->ordre;
                $newCrudData['isSu']=$Menus->isSu;
                $newCrudData['menu_id']=$Menus->menu_id;
                $newCrudData['entreprise_id']=$Menus->entreprise_id;
                $newCrudData['creat_by']=$Menus->creat_by;
                                $newCrudData['identifiants_sadge']=$Menus->identifiants_sadge;
    
 try{ $newCrudData['entreprise']=$Menus->entreprise->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['menu']=$Menus->menu->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Menus','entite_cle' => $Menus->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Menus->toArray();




try{

foreach ($Menus->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Menu $Menus)
{
try{
$can=\App\Helpers\Helpers::can('Editer des menus');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['name']=$Menus->name;
                $oldCrudData['icon']=$Menus->icon;
                $oldCrudData['slug']=$Menus->slug;
                $oldCrudData['url']=$Menus->url;
                $oldCrudData['ordre']=$Menus->ordre;
                $oldCrudData['isSu']=$Menus->isSu;
                $oldCrudData['menu_id']=$Menus->menu_id;
                $oldCrudData['entreprise_id']=$Menus->entreprise_id;
                $oldCrudData['creat_by']=$Menus->creat_by;
                                $oldCrudData['identifiants_sadge']=$Menus->identifiants_sadge;
    
 try{ $oldCrudData['entreprise']=$Menus->entreprise->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['menu']=$Menus->menu->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "menus"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'name',
    'icon',
    'slug',
    'url',
    'ordre',
    'isSu',
    'menu_id',
    'entreprise_id',
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
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'icon' => [
            //'required'
            ],
        
    
    
                    'slug' => [
            //'required'
            ],
        
    
    
                    'url' => [
            //'required'
            ],
        
    
    
                    'ordre' => [
            //'required'
            ],
        
    
    
                    'isSu' => [
            //'required'
            ],
        
    
    
                    'menu_id' => [
            //'required'
            ],
        
    
    
                    'entreprise_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'icon' => ['cette donnee est obligatoire'],

    
    
        'slug' => ['cette donnee est obligatoire'],

    
    
        'url' => ['cette donnee est obligatoire'],

    
    
        'ordre' => ['cette donnee est obligatoire'],

    
    
        'isSu' => ['cette donnee est obligatoire'],

    
    
        'menu_id' => ['cette donnee est obligatoire'],

    
    
        'entreprise_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("name",$data)){


        if(!empty($data['name'])){
        
            $Menus->name = $data['name'];
        
        }

        }

    







    

        if(array_key_exists("icon",$data)){


        if(!empty($data['icon'])){
        
            $Menus->icon = $data['icon'];
        
        }

        }

    







    

        if(array_key_exists("slug",$data)){


        if(!empty($data['slug'])){
        
            $Menus->slug = $data['slug'];
        
        }

        }

    







    

        if(array_key_exists("url",$data)){


        if(!empty($data['url'])){
        
            $Menus->url = $data['url'];
        
        }

        }

    







    

        if(array_key_exists("ordre",$data)){


        if(!empty($data['ordre'])){
        
            $Menus->ordre = $data['ordre'];
        
        }

        }

    







    

        if(array_key_exists("isSu",$data)){


        if(!empty($data['isSu'])){
        
            $Menus->isSu = $data['isSu'];
        
        }

        }

    







    

        if(array_key_exists("menu_id",$data)){


        if(!empty($data['menu_id'])){
        
            $Menus->menu_id = $data['menu_id'];
        
        }

        }

    







    

        if(array_key_exists("entreprise_id",$data)){


        if(!empty($data['entreprise_id'])){
        
            $Menus->entreprise_id = $data['entreprise_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Menus->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Menus->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Menus->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\MenuExtras') &&
method_exists('\App\Http\Extras\MenuExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\MenuExtras::beforeSaveUpdate($request,$Menus);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\MenuExtras') &&
method_exists('\App\Http\Extras\MenuExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\MenuExtras::canUpdate($request, $Menus);
}catch (\Throwable $e){

}

}


if($canSave){
$Menus->save();
}else{
return response()->json($Menus, 200);

}


$Menus=Menu::find($Menus->id);



$newCrudData=[];

                $newCrudData['name']=$Menus->name;
                $newCrudData['icon']=$Menus->icon;
                $newCrudData['slug']=$Menus->slug;
                $newCrudData['url']=$Menus->url;
                $newCrudData['ordre']=$Menus->ordre;
                $newCrudData['isSu']=$Menus->isSu;
                $newCrudData['menu_id']=$Menus->menu_id;
                $newCrudData['entreprise_id']=$Menus->entreprise_id;
                $newCrudData['creat_by']=$Menus->creat_by;
                                $newCrudData['identifiants_sadge']=$Menus->identifiants_sadge;
    
 try{ $newCrudData['entreprise']=$Menus->entreprise->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['menu']=$Menus->menu->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Menus','entite_cle' => $Menus->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Menus->toArray();




try{

foreach ($Menus->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Menu $Menus)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des menus');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['name']=$Menus->name;
                $newCrudData['icon']=$Menus->icon;
                $newCrudData['slug']=$Menus->slug;
                $newCrudData['url']=$Menus->url;
                $newCrudData['ordre']=$Menus->ordre;
                $newCrudData['isSu']=$Menus->isSu;
                $newCrudData['menu_id']=$Menus->menu_id;
                $newCrudData['entreprise_id']=$Menus->entreprise_id;
                $newCrudData['creat_by']=$Menus->creat_by;
                                $newCrudData['identifiants_sadge']=$Menus->identifiants_sadge;
    
 try{ $newCrudData['entreprise']=$Menus->entreprise->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['menu']=$Menus->menu->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Menus','entite_cle' => $Menus->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\MenuExtras') &&
method_exists('\App\Http\Extras\MenuExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\MenuExtras::canDelete($request, $Menus);
}catch (\Throwable $e){

}

}



if($canSave){
$Menus->delete();
}else{
return response()->json($Menus, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\MenusActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
