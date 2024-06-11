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
// use App\Repository\prod\Oauth_clientsRepository;
use App\Models\OauthClient;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



    
class OauthClientController extends Controller
{

private $Oauth_clientsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\Oauth_clientsRepository $Oauth_clientsRepository
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
class_exists('\App\Http\Extras\Oauth_clientExtras') &&
method_exists('\App\Http\Extras\Oauth_clientExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\Oauth_clientExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=OauthClient::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\Oauth_clientExtras') &&
method_exists('\App\Http\Extras\Oauth_clientExtras', 'filterAgGridQuery')
){
\App\Http\Extras\Oauth_clientExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('oauth_clients',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\Oauth_clientExtras') &&
method_exists('\App\Http\Extras\Oauth_clientExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\Oauth_clientExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  oauth_clients reussi',
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
return response()->json(OauthClient::count());
}
$data = QueryBuilder::for(OauthClient::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('secret'),

    
            AllowedFilter::exact('provider'),

    
            AllowedFilter::exact('redirect'),

    
            AllowedFilter::exact('personal_access_client'),

    
            AllowedFilter::exact('password_client'),

    
            AllowedFilter::exact('revoked'),

    
    
    
    
    
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

    
            AllowedSort::field('name'),

    
            AllowedSort::field('secret'),

    
            AllowedSort::field('provider'),

    
            AllowedSort::field('redirect'),

    
            AllowedSort::field('personal_access_client'),

    
            AllowedSort::field('password_client'),

    
            AllowedSort::field('revoked'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([

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




$data = QueryBuilder::for(OauthClient::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('secret'),

    
            AllowedFilter::exact('provider'),

    
            AllowedFilter::exact('redirect'),

    
            AllowedFilter::exact('personal_access_client'),

    
            AllowedFilter::exact('password_client'),

    
            AllowedFilter::exact('revoked'),

    
    
    
    
    
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

    
            AllowedSort::field('name'),

    
            AllowedSort::field('secret'),

    
            AllowedSort::field('provider'),

    
            AllowedSort::field('redirect'),

    
            AllowedSort::field('personal_access_client'),

    
            AllowedSort::field('password_client'),

    
            AllowedSort::field('revoked'),

    
    
    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
->allowedIncludes([
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



public function create(Request $request, OauthClient $Oauth_clients)
{


try{
$can=\App\Helpers\Helpers::can('Creer des oauth_clients');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "oauth_clients"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'name',
    'secret',
    'provider',
    'redirect',
    'personal_access_client',
    'password_client',
    'revoked',
    'created_at',
    'updated_at',
    'extra_attributes',
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
    
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'secret' => [
            //'required'
            ],
        
    
    
                    'provider' => [
            //'required'
            ],
        
    
    
                    'redirect' => [
            //'required'
            ],
        
    
    
                    'personal_access_client' => [
            //'required'
            ],
        
    
    
                    'password_client' => [
            //'required'
            ],
        
    
    
                    'revoked' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'secret' => ['cette donnee est obligatoire'],

    
    
        'provider' => ['cette donnee est obligatoire'],

    
    
        'redirect' => ['cette donnee est obligatoire'],

    
    
        'personal_access_client' => ['cette donnee est obligatoire'],

    
    
        'password_client' => ['cette donnee est obligatoire'],

    
    
        'revoked' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['user_id'])){
        
            $Oauth_clients->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['name'])){
        
            $Oauth_clients->name = $data['name'];
        
        }



    







    

        if(!empty($data['secret'])){
        
            $Oauth_clients->secret = $data['secret'];
        
        }



    







    

        if(!empty($data['provider'])){
        
            $Oauth_clients->provider = $data['provider'];
        
        }



    







    

        if(!empty($data['redirect'])){
        
            $Oauth_clients->redirect = $data['redirect'];
        
        }



    







    

        if(!empty($data['personal_access_client'])){
        
            $Oauth_clients->personal_access_client = $data['personal_access_client'];
        
        }



    







    

        if(!empty($data['password_client'])){
        
            $Oauth_clients->password_client = $data['password_client'];
        
        }



    







    

        if(!empty($data['revoked'])){
        
            $Oauth_clients->revoked = $data['revoked'];
        
        }



    







    







    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Oauth_clients->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Oauth_clients->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Oauth_clients->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\Oauth_clientExtras') &&
method_exists('\App\Http\Extras\Oauth_clientExtras', 'beforeSaveCreate')
){
\App\Http\Extras\Oauth_clientExtras::beforeSaveCreate($request,$Oauth_clients);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Oauth_clientExtras') &&
method_exists('\App\Http\Extras\Oauth_clientExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\Oauth_clientExtras::canCreate($request, $Oauth_clients);
}catch (\Throwable $e){

}

}


if($canSave){
$Oauth_clients->save();
}else{
return response()->json($Oauth_clients, 200);
}

$Oauth_clients=OauthClient::find($Oauth_clients->id);
$newCrudData=[];

                $newCrudData['user_id']=$Oauth_clients->user_id;
                $newCrudData['name']=$Oauth_clients->name;
                $newCrudData['secret']=$Oauth_clients->secret;
                $newCrudData['provider']=$Oauth_clients->provider;
                $newCrudData['redirect']=$Oauth_clients->redirect;
                $newCrudData['personal_access_client']=$Oauth_clients->personal_access_client;
                $newCrudData['password_client']=$Oauth_clients->password_client;
                $newCrudData['revoked']=$Oauth_clients->revoked;
                                $newCrudData['identifiants_sadge']=$Oauth_clients->identifiants_sadge;
                $newCrudData['creat_by']=$Oauth_clients->creat_by;
    
 try{ $newCrudData['user']=$Oauth_clients->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Oauth_clients','entite_cle' => $Oauth_clients->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Oauth_clients->toArray();




try{

foreach ($Oauth_clients->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, OauthClient $Oauth_clients)
{
try{
$can=\App\Helpers\Helpers::can('Editer des oauth_clients');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['user_id']=$Oauth_clients->user_id;
                $oldCrudData['name']=$Oauth_clients->name;
                $oldCrudData['secret']=$Oauth_clients->secret;
                $oldCrudData['provider']=$Oauth_clients->provider;
                $oldCrudData['redirect']=$Oauth_clients->redirect;
                $oldCrudData['personal_access_client']=$Oauth_clients->personal_access_client;
                $oldCrudData['password_client']=$Oauth_clients->password_client;
                $oldCrudData['revoked']=$Oauth_clients->revoked;
                                $oldCrudData['identifiants_sadge']=$Oauth_clients->identifiants_sadge;
                $oldCrudData['creat_by']=$Oauth_clients->creat_by;
    
 try{ $oldCrudData['user']=$Oauth_clients->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "oauth_clients"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'name',
    'secret',
    'provider',
    'redirect',
    'personal_access_client',
    'password_client',
    'revoked',
    'created_at',
    'updated_at',
    'extra_attributes',
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
    
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'secret' => [
            //'required'
            ],
        
    
    
                    'provider' => [
            //'required'
            ],
        
    
    
                    'redirect' => [
            //'required'
            ],
        
    
    
                    'personal_access_client' => [
            //'required'
            ],
        
    
    
                    'password_client' => [
            //'required'
            ],
        
    
    
                    'revoked' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'secret' => ['cette donnee est obligatoire'],

    
    
        'provider' => ['cette donnee est obligatoire'],

    
    
        'redirect' => ['cette donnee est obligatoire'],

    
    
        'personal_access_client' => ['cette donnee est obligatoire'],

    
    
        'password_client' => ['cette donnee est obligatoire'],

    
    
        'revoked' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Oauth_clients->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("name",$data)){


        if(!empty($data['name'])){
        
            $Oauth_clients->name = $data['name'];
        
        }

        }

    







    

        if(array_key_exists("secret",$data)){


        if(!empty($data['secret'])){
        
            $Oauth_clients->secret = $data['secret'];
        
        }

        }

    







    

        if(array_key_exists("provider",$data)){


        if(!empty($data['provider'])){
        
            $Oauth_clients->provider = $data['provider'];
        
        }

        }

    







    

        if(array_key_exists("redirect",$data)){


        if(!empty($data['redirect'])){
        
            $Oauth_clients->redirect = $data['redirect'];
        
        }

        }

    







    

        if(array_key_exists("personal_access_client",$data)){


        if(!empty($data['personal_access_client'])){
        
            $Oauth_clients->personal_access_client = $data['personal_access_client'];
        
        }

        }

    







    

        if(array_key_exists("password_client",$data)){


        if(!empty($data['password_client'])){
        
            $Oauth_clients->password_client = $data['password_client'];
        
        }

        }

    







    

        if(array_key_exists("revoked",$data)){


        if(!empty($data['revoked'])){
        
            $Oauth_clients->revoked = $data['revoked'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Oauth_clients->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Oauth_clients->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Oauth_clients->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\Oauth_clientExtras') &&
method_exists('\App\Http\Extras\Oauth_clientExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\Oauth_clientExtras::beforeSaveUpdate($request,$Oauth_clients);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Oauth_clientExtras') &&
method_exists('\App\Http\Extras\Oauth_clientExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\Oauth_clientExtras::canUpdate($request, $Oauth_clients);
}catch (\Throwable $e){

}

}


if($canSave){
$Oauth_clients->save();
}else{
return response()->json($Oauth_clients, 200);

}


$Oauth_clients=OauthClient::find($Oauth_clients->id);



$newCrudData=[];

                $newCrudData['user_id']=$Oauth_clients->user_id;
                $newCrudData['name']=$Oauth_clients->name;
                $newCrudData['secret']=$Oauth_clients->secret;
                $newCrudData['provider']=$Oauth_clients->provider;
                $newCrudData['redirect']=$Oauth_clients->redirect;
                $newCrudData['personal_access_client']=$Oauth_clients->personal_access_client;
                $newCrudData['password_client']=$Oauth_clients->password_client;
                $newCrudData['revoked']=$Oauth_clients->revoked;
                                $newCrudData['identifiants_sadge']=$Oauth_clients->identifiants_sadge;
                $newCrudData['creat_by']=$Oauth_clients->creat_by;
    
 try{ $newCrudData['user']=$Oauth_clients->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Oauth_clients','entite_cle' => $Oauth_clients->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Oauth_clients->toArray();




try{

foreach ($Oauth_clients->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, OauthClient $Oauth_clients)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des oauth_clients');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['user_id']=$Oauth_clients->user_id;
                $newCrudData['name']=$Oauth_clients->name;
                $newCrudData['secret']=$Oauth_clients->secret;
                $newCrudData['provider']=$Oauth_clients->provider;
                $newCrudData['redirect']=$Oauth_clients->redirect;
                $newCrudData['personal_access_client']=$Oauth_clients->personal_access_client;
                $newCrudData['password_client']=$Oauth_clients->password_client;
                $newCrudData['revoked']=$Oauth_clients->revoked;
                                $newCrudData['identifiants_sadge']=$Oauth_clients->identifiants_sadge;
                $newCrudData['creat_by']=$Oauth_clients->creat_by;
    
 try{ $newCrudData['user']=$Oauth_clients->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Oauth_clients','entite_cle' => $Oauth_clients->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\Oauth_clientExtras') &&
method_exists('\App\Http\Extras\Oauth_clientExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\Oauth_clientExtras::canDelete($request, $Oauth_clients);
}catch (\Throwable $e){

}

}



if($canSave){
$Oauth_clients->delete();
}else{
return response()->json($Oauth_clients, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\Oauth_clientsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
