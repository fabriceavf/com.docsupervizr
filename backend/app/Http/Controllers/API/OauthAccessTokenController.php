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
// use App\Repository\prod\Oauth_access_tokensRepository;
use App\Models\OauthAccessToken;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Client;
        
class OauthAccessTokenController extends Controller
{

private $Oauth_access_tokensRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\Oauth_access_tokensRepository $Oauth_access_tokensRepository
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
class_exists('\App\Http\Extras\Oauth_access_tokenExtras') &&
method_exists('\App\Http\Extras\Oauth_access_tokenExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\Oauth_access_tokenExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=OauthAccessToken::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\Oauth_access_tokenExtras') &&
method_exists('\App\Http\Extras\Oauth_access_tokenExtras', 'filterAgGridQuery')
){
\App\Http\Extras\Oauth_access_tokenExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('oauth_access_tokens',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\Oauth_access_tokenExtras') &&
method_exists('\App\Http\Extras\Oauth_access_tokenExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\Oauth_access_tokenExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  oauth_access_tokens reussi',
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
return response()->json(OauthAccessToken::count());
}
$data = QueryBuilder::for(OauthAccessToken::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('scopes'),

    
            AllowedFilter::exact('revoked'),

    
    
    
            AllowedFilter::exact('expires_at'),

    
    
    
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

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('name'),

    
            AllowedSort::field('scopes'),

    
            AllowedSort::field('revoked'),

    
    
    
            AllowedSort::field('expires_at'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([

            'client',
        

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




$data = QueryBuilder::for(OauthAccessToken::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('scopes'),

    
            AllowedFilter::exact('revoked'),

    
    
    
            AllowedFilter::exact('expires_at'),

    
    
    
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

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('name'),

    
            AllowedSort::field('scopes'),

    
            AllowedSort::field('revoked'),

    
    
    
            AllowedSort::field('expires_at'),

    
    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
->allowedIncludes([
            'client',
        

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



public function create(Request $request, OauthAccessToken $Oauth_access_tokens)
{


try{
$can=\App\Helpers\Helpers::can('Creer des oauth_access_tokens');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "oauth_access_tokens"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'client_id',
    'name',
    'scopes',
    'revoked',
    'created_at',
    'updated_at',
    'expires_at',
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
    
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'scopes' => [
            //'required'
            ],
        
    
    
                    'revoked' => [
            //'required'
            ],
        
    
    
    
    
                    'expires_at' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'scopes' => ['cette donnee est obligatoire'],

    
    
        'revoked' => ['cette donnee est obligatoire'],

    
    
    
    
        'expires_at' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['user_id'])){
        
            $Oauth_access_tokens->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['client_id'])){
        
            $Oauth_access_tokens->client_id = $data['client_id'];
        
        }



    







    

        if(!empty($data['name'])){
        
            $Oauth_access_tokens->name = $data['name'];
        
        }



    







    

        if(!empty($data['scopes'])){
        
            $Oauth_access_tokens->scopes = $data['scopes'];
        
        }



    







    

        if(!empty($data['revoked'])){
        
            $Oauth_access_tokens->revoked = $data['revoked'];
        
        }



    







    







    







    

        if(!empty($data['expires_at'])){
        
            $Oauth_access_tokens->expires_at = $data['expires_at'];
        
        }



    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Oauth_access_tokens->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Oauth_access_tokens->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Oauth_access_tokens->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\Oauth_access_tokenExtras') &&
method_exists('\App\Http\Extras\Oauth_access_tokenExtras', 'beforeSaveCreate')
){
\App\Http\Extras\Oauth_access_tokenExtras::beforeSaveCreate($request,$Oauth_access_tokens);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Oauth_access_tokenExtras') &&
method_exists('\App\Http\Extras\Oauth_access_tokenExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\Oauth_access_tokenExtras::canCreate($request, $Oauth_access_tokens);
}catch (\Throwable $e){

}

}


if($canSave){
$Oauth_access_tokens->save();
}else{
return response()->json($Oauth_access_tokens, 200);
}

$Oauth_access_tokens=OauthAccessToken::find($Oauth_access_tokens->id);
$newCrudData=[];

                $newCrudData['user_id']=$Oauth_access_tokens->user_id;
                $newCrudData['client_id']=$Oauth_access_tokens->client_id;
                $newCrudData['name']=$Oauth_access_tokens->name;
                $newCrudData['scopes']=$Oauth_access_tokens->scopes;
                $newCrudData['revoked']=$Oauth_access_tokens->revoked;
                        $newCrudData['expires_at']=$Oauth_access_tokens->expires_at;
                        $newCrudData['identifiants_sadge']=$Oauth_access_tokens->identifiants_sadge;
                $newCrudData['creat_by']=$Oauth_access_tokens->creat_by;
    
 try{ $newCrudData['client']=$Oauth_access_tokens->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Oauth_access_tokens->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Oauth_access_tokens','entite_cle' => $Oauth_access_tokens->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Oauth_access_tokens->toArray();




try{

foreach ($Oauth_access_tokens->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, OauthAccessToken $Oauth_access_tokens)
{
try{
$can=\App\Helpers\Helpers::can('Editer des oauth_access_tokens');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['user_id']=$Oauth_access_tokens->user_id;
                $oldCrudData['client_id']=$Oauth_access_tokens->client_id;
                $oldCrudData['name']=$Oauth_access_tokens->name;
                $oldCrudData['scopes']=$Oauth_access_tokens->scopes;
                $oldCrudData['revoked']=$Oauth_access_tokens->revoked;
                        $oldCrudData['expires_at']=$Oauth_access_tokens->expires_at;
                        $oldCrudData['identifiants_sadge']=$Oauth_access_tokens->identifiants_sadge;
                $oldCrudData['creat_by']=$Oauth_access_tokens->creat_by;
    
 try{ $oldCrudData['client']=$Oauth_access_tokens->client->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Oauth_access_tokens->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "oauth_access_tokens"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'client_id',
    'name',
    'scopes',
    'revoked',
    'created_at',
    'updated_at',
    'expires_at',
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
    
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'scopes' => [
            //'required'
            ],
        
    
    
                    'revoked' => [
            //'required'
            ],
        
    
    
    
    
                    'expires_at' => [
            //'required'
            ],
        
    
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'scopes' => ['cette donnee est obligatoire'],

    
    
        'revoked' => ['cette donnee est obligatoire'],

    
    
    
    
        'expires_at' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Oauth_access_tokens->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("client_id",$data)){


        if(!empty($data['client_id'])){
        
            $Oauth_access_tokens->client_id = $data['client_id'];
        
        }

        }

    







    

        if(array_key_exists("name",$data)){


        if(!empty($data['name'])){
        
            $Oauth_access_tokens->name = $data['name'];
        
        }

        }

    







    

        if(array_key_exists("scopes",$data)){


        if(!empty($data['scopes'])){
        
            $Oauth_access_tokens->scopes = $data['scopes'];
        
        }

        }

    







    

        if(array_key_exists("revoked",$data)){


        if(!empty($data['revoked'])){
        
            $Oauth_access_tokens->revoked = $data['revoked'];
        
        }

        }

    







    







    







    

        if(array_key_exists("expires_at",$data)){


        if(!empty($data['expires_at'])){
        
            $Oauth_access_tokens->expires_at = $data['expires_at'];
        
        }

        }

    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Oauth_access_tokens->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Oauth_access_tokens->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Oauth_access_tokens->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\Oauth_access_tokenExtras') &&
method_exists('\App\Http\Extras\Oauth_access_tokenExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\Oauth_access_tokenExtras::beforeSaveUpdate($request,$Oauth_access_tokens);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Oauth_access_tokenExtras') &&
method_exists('\App\Http\Extras\Oauth_access_tokenExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\Oauth_access_tokenExtras::canUpdate($request, $Oauth_access_tokens);
}catch (\Throwable $e){

}

}


if($canSave){
$Oauth_access_tokens->save();
}else{
return response()->json($Oauth_access_tokens, 200);

}


$Oauth_access_tokens=OauthAccessToken::find($Oauth_access_tokens->id);



$newCrudData=[];

                $newCrudData['user_id']=$Oauth_access_tokens->user_id;
                $newCrudData['client_id']=$Oauth_access_tokens->client_id;
                $newCrudData['name']=$Oauth_access_tokens->name;
                $newCrudData['scopes']=$Oauth_access_tokens->scopes;
                $newCrudData['revoked']=$Oauth_access_tokens->revoked;
                        $newCrudData['expires_at']=$Oauth_access_tokens->expires_at;
                        $newCrudData['identifiants_sadge']=$Oauth_access_tokens->identifiants_sadge;
                $newCrudData['creat_by']=$Oauth_access_tokens->creat_by;
    
 try{ $newCrudData['client']=$Oauth_access_tokens->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Oauth_access_tokens->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Oauth_access_tokens','entite_cle' => $Oauth_access_tokens->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Oauth_access_tokens->toArray();




try{

foreach ($Oauth_access_tokens->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, OauthAccessToken $Oauth_access_tokens)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des oauth_access_tokens');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['user_id']=$Oauth_access_tokens->user_id;
                $newCrudData['client_id']=$Oauth_access_tokens->client_id;
                $newCrudData['name']=$Oauth_access_tokens->name;
                $newCrudData['scopes']=$Oauth_access_tokens->scopes;
                $newCrudData['revoked']=$Oauth_access_tokens->revoked;
                        $newCrudData['expires_at']=$Oauth_access_tokens->expires_at;
                        $newCrudData['identifiants_sadge']=$Oauth_access_tokens->identifiants_sadge;
                $newCrudData['creat_by']=$Oauth_access_tokens->creat_by;
    
 try{ $newCrudData['client']=$Oauth_access_tokens->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Oauth_access_tokens->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Oauth_access_tokens','entite_cle' => $Oauth_access_tokens->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\Oauth_access_tokenExtras') &&
method_exists('\App\Http\Extras\Oauth_access_tokenExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\Oauth_access_tokenExtras::canDelete($request, $Oauth_access_tokens);
}catch (\Throwable $e){

}

}



if($canSave){
$Oauth_access_tokens->delete();
}else{
return response()->json($Oauth_access_tokens, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\Oauth_access_tokensActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
