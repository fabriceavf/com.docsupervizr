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
// use App\Repository\prod\Oauth_auth_codesRepository;
use App\Models\OauthAuthCode;
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
        
class OauthAuthCodeController extends Controller
{

private $Oauth_auth_codesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\Oauth_auth_codesRepository $Oauth_auth_codesRepository
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
class_exists('\App\Http\Extras\Oauth_auth_codeExtras') &&
method_exists('\App\Http\Extras\Oauth_auth_codeExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\Oauth_auth_codeExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=OauthAuthCode::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\Oauth_auth_codeExtras') &&
method_exists('\App\Http\Extras\Oauth_auth_codeExtras', 'filterAgGridQuery')
){
\App\Http\Extras\Oauth_auth_codeExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('oauth_auth_codes',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\Oauth_auth_codeExtras') &&
method_exists('\App\Http\Extras\Oauth_auth_codeExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\Oauth_auth_codeExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  oauth_auth_codes reussi',
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
return response()->json(OauthAuthCode::count());
}
$data = QueryBuilder::for(OauthAuthCode::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('client_id'),

    
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




$data = QueryBuilder::for(OauthAuthCode::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('user_id'),

    
            AllowedFilter::exact('client_id'),

    
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



public function create(Request $request, OauthAuthCode $Oauth_auth_codes)
{


try{
$can=\App\Helpers\Helpers::can('Creer des oauth_auth_codes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "oauth_auth_codes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'client_id',
    'scopes',
    'revoked',
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
        
            $Oauth_auth_codes->user_id = $data['user_id'];
        
        }



    







    

        if(!empty($data['client_id'])){
        
            $Oauth_auth_codes->client_id = $data['client_id'];
        
        }



    







    

        if(!empty($data['scopes'])){
        
            $Oauth_auth_codes->scopes = $data['scopes'];
        
        }



    







    

        if(!empty($data['revoked'])){
        
            $Oauth_auth_codes->revoked = $data['revoked'];
        
        }



    







    

        if(!empty($data['expires_at'])){
        
            $Oauth_auth_codes->expires_at = $data['expires_at'];
        
        }



    







    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Oauth_auth_codes->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Oauth_auth_codes->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Oauth_auth_codes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\Oauth_auth_codeExtras') &&
method_exists('\App\Http\Extras\Oauth_auth_codeExtras', 'beforeSaveCreate')
){
\App\Http\Extras\Oauth_auth_codeExtras::beforeSaveCreate($request,$Oauth_auth_codes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Oauth_auth_codeExtras') &&
method_exists('\App\Http\Extras\Oauth_auth_codeExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\Oauth_auth_codeExtras::canCreate($request, $Oauth_auth_codes);
}catch (\Throwable $e){

}

}


if($canSave){
$Oauth_auth_codes->save();
}else{
return response()->json($Oauth_auth_codes, 200);
}

$Oauth_auth_codes=OauthAuthCode::find($Oauth_auth_codes->id);
$newCrudData=[];

                $newCrudData['user_id']=$Oauth_auth_codes->user_id;
                $newCrudData['client_id']=$Oauth_auth_codes->client_id;
                $newCrudData['scopes']=$Oauth_auth_codes->scopes;
                $newCrudData['revoked']=$Oauth_auth_codes->revoked;
                $newCrudData['expires_at']=$Oauth_auth_codes->expires_at;
                        $newCrudData['identifiants_sadge']=$Oauth_auth_codes->identifiants_sadge;
                $newCrudData['creat_by']=$Oauth_auth_codes->creat_by;
    
 try{ $newCrudData['client']=$Oauth_auth_codes->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Oauth_auth_codes->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Oauth_auth_codes','entite_cle' => $Oauth_auth_codes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Oauth_auth_codes->toArray();




try{

foreach ($Oauth_auth_codes->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, OauthAuthCode $Oauth_auth_codes)
{
try{
$can=\App\Helpers\Helpers::can('Editer des oauth_auth_codes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['user_id']=$Oauth_auth_codes->user_id;
                $oldCrudData['client_id']=$Oauth_auth_codes->client_id;
                $oldCrudData['scopes']=$Oauth_auth_codes->scopes;
                $oldCrudData['revoked']=$Oauth_auth_codes->revoked;
                $oldCrudData['expires_at']=$Oauth_auth_codes->expires_at;
                        $oldCrudData['identifiants_sadge']=$Oauth_auth_codes->identifiants_sadge;
                $oldCrudData['creat_by']=$Oauth_auth_codes->creat_by;
    
 try{ $oldCrudData['client']=$Oauth_auth_codes->client->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['user']=$Oauth_auth_codes->user->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "oauth_auth_codes"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'user_id',
    'client_id',
    'scopes',
    'revoked',
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

    
    
        'scopes' => ['cette donnee est obligatoire'],

    
    
        'revoked' => ['cette donnee est obligatoire'],

    
    
        'expires_at' => ['cette donnee est obligatoire'],

    
    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("user_id",$data)){


        if(!empty($data['user_id'])){
        
            $Oauth_auth_codes->user_id = $data['user_id'];
        
        }

        }

    







    

        if(array_key_exists("client_id",$data)){


        if(!empty($data['client_id'])){
        
            $Oauth_auth_codes->client_id = $data['client_id'];
        
        }

        }

    







    

        if(array_key_exists("scopes",$data)){


        if(!empty($data['scopes'])){
        
            $Oauth_auth_codes->scopes = $data['scopes'];
        
        }

        }

    







    

        if(array_key_exists("revoked",$data)){


        if(!empty($data['revoked'])){
        
            $Oauth_auth_codes->revoked = $data['revoked'];
        
        }

        }

    







    

        if(array_key_exists("expires_at",$data)){


        if(!empty($data['expires_at'])){
        
            $Oauth_auth_codes->expires_at = $data['expires_at'];
        
        }

        }

    







    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Oauth_auth_codes->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Oauth_auth_codes->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Oauth_auth_codes->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\Oauth_auth_codeExtras') &&
method_exists('\App\Http\Extras\Oauth_auth_codeExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\Oauth_auth_codeExtras::beforeSaveUpdate($request,$Oauth_auth_codes);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\Oauth_auth_codeExtras') &&
method_exists('\App\Http\Extras\Oauth_auth_codeExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\Oauth_auth_codeExtras::canUpdate($request, $Oauth_auth_codes);
}catch (\Throwable $e){

}

}


if($canSave){
$Oauth_auth_codes->save();
}else{
return response()->json($Oauth_auth_codes, 200);

}


$Oauth_auth_codes=OauthAuthCode::find($Oauth_auth_codes->id);



$newCrudData=[];

                $newCrudData['user_id']=$Oauth_auth_codes->user_id;
                $newCrudData['client_id']=$Oauth_auth_codes->client_id;
                $newCrudData['scopes']=$Oauth_auth_codes->scopes;
                $newCrudData['revoked']=$Oauth_auth_codes->revoked;
                $newCrudData['expires_at']=$Oauth_auth_codes->expires_at;
                        $newCrudData['identifiants_sadge']=$Oauth_auth_codes->identifiants_sadge;
                $newCrudData['creat_by']=$Oauth_auth_codes->creat_by;
    
 try{ $newCrudData['client']=$Oauth_auth_codes->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Oauth_auth_codes->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Oauth_auth_codes','entite_cle' => $Oauth_auth_codes->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Oauth_auth_codes->toArray();




try{

foreach ($Oauth_auth_codes->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, OauthAuthCode $Oauth_auth_codes)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des oauth_auth_codes');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['user_id']=$Oauth_auth_codes->user_id;
                $newCrudData['client_id']=$Oauth_auth_codes->client_id;
                $newCrudData['scopes']=$Oauth_auth_codes->scopes;
                $newCrudData['revoked']=$Oauth_auth_codes->revoked;
                $newCrudData['expires_at']=$Oauth_auth_codes->expires_at;
                        $newCrudData['identifiants_sadge']=$Oauth_auth_codes->identifiants_sadge;
                $newCrudData['creat_by']=$Oauth_auth_codes->creat_by;
    
 try{ $newCrudData['client']=$Oauth_auth_codes->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['user']=$Oauth_auth_codes->user->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Oauth_auth_codes','entite_cle' => $Oauth_auth_codes->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\Oauth_auth_codeExtras') &&
method_exists('\App\Http\Extras\Oauth_auth_codeExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\Oauth_auth_codeExtras::canDelete($request, $Oauth_auth_codes);
}catch (\Throwable $e){

}

}



if($canSave){
$Oauth_auth_codes->delete();
}else{
return response()->json($Oauth_auth_codes, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\Oauth_auth_codesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
