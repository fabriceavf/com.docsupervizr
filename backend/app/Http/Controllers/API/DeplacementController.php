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
// use App\Repository\prod\DeplacementsRepository;
use App\Models\Deplacement;
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
                use App\Models\Lignesmoyenstransport;
                use App\Models\Moyenstransport;
    
class DeplacementController extends Controller
{

private $DeplacementsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\DeplacementsRepository $DeplacementsRepository
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
class_exists('\App\Http\Extras\DeplacementExtras') &&
method_exists('\App\Http\Extras\DeplacementExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\DeplacementExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Deplacement::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\DeplacementExtras') &&
method_exists('\App\Http\Extras\DeplacementExtras', 'filterAgGridQuery')
){
\App\Http\Extras\DeplacementExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('deplacements',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\DeplacementExtras') &&
method_exists('\App\Http\Extras\DeplacementExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\DeplacementExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  deplacements reussi',
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
return response()->json(Deplacement::count());
}
$data = QueryBuilder::for(Deplacement::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('debut_prevu'),

    
            AllowedFilter::exact('fin_prevu'),

    
            AllowedFilter::exact('lignesmoyenstransport_id'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('moyenstransport_id'),

    
            AllowedFilter::exact('ligne_id'),

    
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

    
            AllowedSort::field('date'),

    
            AllowedSort::field('debut_prevu'),

    
            AllowedSort::field('fin_prevu'),

    
            AllowedSort::field('lignesmoyenstransport_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('moyenstransport_id'),

    
            AllowedSort::field('ligne_id'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
    
->allowedIncludes([
            'controlleursacces',
        

                'sitessdeplacements',
        

    
            'ligne',
        

                'lignesmoyenstransport',
        

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




$data = QueryBuilder::for(Deplacement::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('debut_prevu'),

    
            AllowedFilter::exact('fin_prevu'),

    
            AllowedFilter::exact('lignesmoyenstransport_id'),

    
            AllowedFilter::exact('creat_by'),

    
    
    
    
    
            AllowedFilter::exact('moyenstransport_id'),

    
            AllowedFilter::exact('ligne_id'),

    
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

    
            AllowedSort::field('date'),

    
            AllowedSort::field('debut_prevu'),

    
            AllowedSort::field('fin_prevu'),

    
            AllowedSort::field('lignesmoyenstransport_id'),

    
            AllowedSort::field('creat_by'),

    
    
    
    
    
            AllowedSort::field('moyenstransport_id'),

    
            AllowedSort::field('ligne_id'),

    
            AllowedSort::field('identifiants_sadge'),

    
])
    
    
    
->allowedIncludes([
            'controlleursacces',
        

                'sitessdeplacements',
        

                'ligne',
        

                'lignesmoyenstransport',
        

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



public function create(Request $request, Deplacement $Deplacements)
{


try{
$can=\App\Helpers\Helpers::can('Creer des deplacements');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "deplacements"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'date',
    'debut_prevu',
    'fin_prevu',
    'lignesmoyenstransport_id',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'moyenstransport_id',
    'ligne_id',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'date' => [
            //'required'
            ],
        
    
    
                    'debut_prevu' => [
            //'required'
            ],
        
    
    
                    'fin_prevu' => [
            //'required'
            ],
        
    
    
                    'lignesmoyenstransport_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'moyenstransport_id' => [
            //'required'
            ],
        
    
    
                    'ligne_id' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'debut_prevu' => ['cette donnee est obligatoire'],

    
    
        'fin_prevu' => ['cette donnee est obligatoire'],

    
    
        'lignesmoyenstransport_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'moyenstransport_id' => ['cette donnee est obligatoire'],

    
    
        'ligne_id' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['date'])){
        
            $Deplacements->date = $data['date'];
        
        }



    







    

        if(!empty($data['debut_prevu'])){
        
            $Deplacements->debut_prevu = $data['debut_prevu'];
        
        }



    







    

        if(!empty($data['fin_prevu'])){
        
            $Deplacements->fin_prevu = $data['fin_prevu'];
        
        }



    







    

        if(!empty($data['lignesmoyenstransport_id'])){
        
            $Deplacements->lignesmoyenstransport_id = $data['lignesmoyenstransport_id'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Deplacements->creat_by = $data['creat_by'];
        
        }



    







    







    







    







    







    

        if(!empty($data['moyenstransport_id'])){
        
            $Deplacements->moyenstransport_id = $data['moyenstransport_id'];
        
        }



    







    

        if(!empty($data['ligne_id'])){
        
            $Deplacements->ligne_id = $data['ligne_id'];
        
        }



    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Deplacements->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Deplacements->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\DeplacementExtras') &&
method_exists('\App\Http\Extras\DeplacementExtras', 'beforeSaveCreate')
){
\App\Http\Extras\DeplacementExtras::beforeSaveCreate($request,$Deplacements);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\DeplacementExtras') &&
method_exists('\App\Http\Extras\DeplacementExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\DeplacementExtras::canCreate($request, $Deplacements);
}catch (\Throwable $e){

}

}


if($canSave){
$Deplacements->save();
}else{
return response()->json($Deplacements, 200);
}

$Deplacements=Deplacement::find($Deplacements->id);
$newCrudData=[];

                $newCrudData['date']=$Deplacements->date;
                $newCrudData['debut_prevu']=$Deplacements->debut_prevu;
                $newCrudData['fin_prevu']=$Deplacements->fin_prevu;
                $newCrudData['lignesmoyenstransport_id']=$Deplacements->lignesmoyenstransport_id;
                $newCrudData['creat_by']=$Deplacements->creat_by;
                                $newCrudData['moyenstransport_id']=$Deplacements->moyenstransport_id;
                $newCrudData['ligne_id']=$Deplacements->ligne_id;
                $newCrudData['identifiants_sadge']=$Deplacements->identifiants_sadge;
    
 try{ $newCrudData['ligne']=$Deplacements->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['lignesmoyenstransport']=$Deplacements->lignesmoyenstransport->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['moyenstransport']=$Deplacements->moyenstransport->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Deplacements','entite_cle' => $Deplacements->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Deplacements->toArray();




try{

foreach ($Deplacements->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Deplacement $Deplacements)
{
try{
$can=\App\Helpers\Helpers::can('Editer des deplacements');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['date']=$Deplacements->date;
                $oldCrudData['debut_prevu']=$Deplacements->debut_prevu;
                $oldCrudData['fin_prevu']=$Deplacements->fin_prevu;
                $oldCrudData['lignesmoyenstransport_id']=$Deplacements->lignesmoyenstransport_id;
                $oldCrudData['creat_by']=$Deplacements->creat_by;
                                $oldCrudData['moyenstransport_id']=$Deplacements->moyenstransport_id;
                $oldCrudData['ligne_id']=$Deplacements->ligne_id;
                $oldCrudData['identifiants_sadge']=$Deplacements->identifiants_sadge;
    
 try{ $oldCrudData['ligne']=$Deplacements->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['lignesmoyenstransport']=$Deplacements->lignesmoyenstransport->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['moyenstransport']=$Deplacements->moyenstransport->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "deplacements"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'date',
    'debut_prevu',
    'fin_prevu',
    'lignesmoyenstransport_id',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'moyenstransport_id',
    'ligne_id',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [
    
    
                    'date' => [
            //'required'
            ],
        
    
    
                    'debut_prevu' => [
            //'required'
            ],
        
    
    
                    'fin_prevu' => [
            //'required'
            ],
        
    
    
                    'lignesmoyenstransport_id' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    
    
    
    
    
    
                    'moyenstransport_id' => [
            //'required'
            ],
        
    
    
                    'ligne_id' => [
            //'required'
            ],
        
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'debut_prevu' => ['cette donnee est obligatoire'],

    
    
        'fin_prevu' => ['cette donnee est obligatoire'],

    
    
        'lignesmoyenstransport_id' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
    
    
    
    
    
        'moyenstransport_id' => ['cette donnee est obligatoire'],

    
    
        'ligne_id' => ['cette donnee est obligatoire'],

    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("date",$data)){


        if(!empty($data['date'])){
        
            $Deplacements->date = $data['date'];
        
        }

        }

    







    

        if(array_key_exists("debut_prevu",$data)){


        if(!empty($data['debut_prevu'])){
        
            $Deplacements->debut_prevu = $data['debut_prevu'];
        
        }

        }

    







    

        if(array_key_exists("fin_prevu",$data)){


        if(!empty($data['fin_prevu'])){
        
            $Deplacements->fin_prevu = $data['fin_prevu'];
        
        }

        }

    







    

        if(array_key_exists("lignesmoyenstransport_id",$data)){


        if(!empty($data['lignesmoyenstransport_id'])){
        
            $Deplacements->lignesmoyenstransport_id = $data['lignesmoyenstransport_id'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Deplacements->creat_by = $data['creat_by'];
        
        }

        }

    







    







    







    







    







    

        if(array_key_exists("moyenstransport_id",$data)){


        if(!empty($data['moyenstransport_id'])){
        
            $Deplacements->moyenstransport_id = $data['moyenstransport_id'];
        
        }

        }

    







    

        if(array_key_exists("ligne_id",$data)){


        if(!empty($data['ligne_id'])){
        
            $Deplacements->ligne_id = $data['ligne_id'];
        
        }

        }

    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Deplacements->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Deplacements->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\DeplacementExtras') &&
method_exists('\App\Http\Extras\DeplacementExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\DeplacementExtras::beforeSaveUpdate($request,$Deplacements);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\DeplacementExtras') &&
method_exists('\App\Http\Extras\DeplacementExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\DeplacementExtras::canUpdate($request, $Deplacements);
}catch (\Throwable $e){

}

}


if($canSave){
$Deplacements->save();
}else{
return response()->json($Deplacements, 200);

}


$Deplacements=Deplacement::find($Deplacements->id);



$newCrudData=[];

                $newCrudData['date']=$Deplacements->date;
                $newCrudData['debut_prevu']=$Deplacements->debut_prevu;
                $newCrudData['fin_prevu']=$Deplacements->fin_prevu;
                $newCrudData['lignesmoyenstransport_id']=$Deplacements->lignesmoyenstransport_id;
                $newCrudData['creat_by']=$Deplacements->creat_by;
                                $newCrudData['moyenstransport_id']=$Deplacements->moyenstransport_id;
                $newCrudData['ligne_id']=$Deplacements->ligne_id;
                $newCrudData['identifiants_sadge']=$Deplacements->identifiants_sadge;
    
 try{ $newCrudData['ligne']=$Deplacements->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['lignesmoyenstransport']=$Deplacements->lignesmoyenstransport->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['moyenstransport']=$Deplacements->moyenstransport->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Deplacements','entite_cle' => $Deplacements->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Deplacements->toArray();




try{

foreach ($Deplacements->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Deplacement $Deplacements)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des deplacements');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['date']=$Deplacements->date;
                $newCrudData['debut_prevu']=$Deplacements->debut_prevu;
                $newCrudData['fin_prevu']=$Deplacements->fin_prevu;
                $newCrudData['lignesmoyenstransport_id']=$Deplacements->lignesmoyenstransport_id;
                $newCrudData['creat_by']=$Deplacements->creat_by;
                                $newCrudData['moyenstransport_id']=$Deplacements->moyenstransport_id;
                $newCrudData['ligne_id']=$Deplacements->ligne_id;
                $newCrudData['identifiants_sadge']=$Deplacements->identifiants_sadge;
    
 try{ $newCrudData['ligne']=$Deplacements->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['lignesmoyenstransport']=$Deplacements->lignesmoyenstransport->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['moyenstransport']=$Deplacements->moyenstransport->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Deplacements','entite_cle' => $Deplacements->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\DeplacementExtras') &&
method_exists('\App\Http\Extras\DeplacementExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\DeplacementExtras::canDelete($request, $Deplacements);
}catch (\Throwable $e){

}

}



if($canSave){
$Deplacements->delete();
}else{
return response()->json($Deplacements, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\DeplacementsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
