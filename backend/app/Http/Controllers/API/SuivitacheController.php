<?php
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
// use App\Repository\prod\SuivitachesRepository;
use App\Models\Suivitache;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;




class SuivitacheController extends Controller
{

private $SuivitachesRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\SuivitachesRepository $SuivitachesRepository
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
class_exists('\App\Http\Extras\SuivitacheExtras') &&
method_exists('\App\Http\Extras\SuivitacheExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\SuivitacheExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Suivitache::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\SuivitacheExtras') &&
method_exists('\App\Http\Extras\SuivitacheExtras', 'filterAgGridQuery')
){
\App\Http\Extras\SuivitacheExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('Suivitaches',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\SuivitacheExtras') &&
method_exists('\App\Http\Extras\SuivitacheExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\SuivitacheExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  Suivitaches reussi',
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
return response()->json(Suivitache::count());
}
$data = QueryBuilder::for(Suivitache::class)
->allowedFilters([
            AllowedFilter::exact('id'),


            AllowedFilter::exact('priorite'),


            AllowedFilter::exact('libelle'),


            AllowedFilter::exact('creat_by'),






            AllowedFilter::exact('date_demande'),


            AllowedFilter::exact('deadline'),


            AllowedFilter::exact('date_fin'),


            AllowedFilter::exact('faisabilite'),


            AllowedFilter::exact('commentaire'),


            AllowedFilter::exact('projet_id'),


            AllowedFilter::exact('client_id'),


            AllowedFilter::exact('user_id'),


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


            AllowedSort::field('priorite'),


            AllowedSort::field('libelle'),


            AllowedSort::field('creat_by'),






            AllowedSort::field('date_demande'),


            AllowedSort::field('deadline'),


            AllowedSort::field('date_fin'),


            AllowedSort::field('faisabilite'),


            AllowedSort::field('commentaire'),


            AllowedSort::field('projet_id'),


            AllowedSort::field('client_id'),


            AllowedSort::field('user_id'),


            AllowedSort::field('identifiants_sadge'),


])
->allowedIncludes([
            'horairesSuivitaches',


                'sites',



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




$data = QueryBuilder::for(Suivitache::class)
->allowedFilters([
            AllowedFilter::exact('id'),


            AllowedFilter::exact('priorite'),


            AllowedFilter::exact('libelle'),


            AllowedFilter::exact('creat_by'),






            AllowedFilter::exact('date_demande'),


            AllowedFilter::exact('deadline'),


            AllowedFilter::exact('date_fin'),


            AllowedFilter::exact('faisabilite'),


            AllowedFilter::exact('commentaire'),


            AllowedFilter::exact('projet_id'),


            AllowedFilter::exact('client_id'),


            AllowedFilter::exact('user_id'),


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


            AllowedSort::field('priorite'),


            AllowedSort::field('libelle'),


            AllowedSort::field('creat_by'),






            AllowedSort::field('date_demande'),


            AllowedSort::field('deadline'),


            AllowedSort::field('date_fin'),


            AllowedSort::field('faisabilite'),


            AllowedSort::field('commentaire'),


            AllowedSort::field('projet_id'),


            AllowedSort::field('client_id'),


            AllowedSort::field('user_id'),


            AllowedSort::field('identifiants_sadge'),


])
->allowedIncludes([
            'horairesSuivitaches',


                'sites',


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



public function create(Request $request, Suivitache $Suivitaches)
{


try{
$can=\App\Helpers\Helpers::can('Creer des Suivitaches');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "Suivitaches"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'priorite',
    'libelle',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'date_demande',
    'deadline',
    'date_fin',
    'faisabilite',
    'commentaire',
    'projet_id',
    'client_id',
    'user_id',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [


                    'priorite' => [
            //'required'
            ],



                    'libelle' => [
            //'required'
            ],



                    'creat_by' => [
            //'required'
            ],







                    'date_demande' => [
            //'required'
            ],



                    'deadline' => [
            //'required'
            ],



            'date_fin' => [
    //'required'
    ],



    'faisabilite' => [
//'required'
],



'commentaire' => [
//'required'
],



'projet_id' => [
//'required'
],



'client_id' => [
//'required'
],



'user_id' => [
//'required'
],



                    'identifiants_sadge' => [
            //'required'
            ],




], $messages = [



        'priorite' => ['cette donnee est obligatoire'],



        'libelle' => ['cette donnee est obligatoire'],



        'creat_by' => ['cette donnee est obligatoire'],







        'date_demande' => ['cette donnee est obligatoire'],



        'deadline' => ['cette donnee est obligatoire'],



        'date_fin' => ['cette donnee est obligatoire'],



        'faisabilite' => ['cette donnee est obligatoire'],



        'commentaire' => ['cette donnee est obligatoire'],



        'projet_id' => ['cette donnee est obligatoire'],



        'client_id' => ['cette donnee est obligatoire'],



        'user_id' => ['cette donnee est obligatoire'],



        'identifiants_sadge' => ['cette donnee est obligatoire'],


])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();


















        if(!empty($data['priorite'])){

            $Suivitaches->priorite = $data['priorite'];

        }













        if(!empty($data['libelle'])){

            $Suivitaches->libelle = $data['libelle'];

        }













        if(!empty($data['creat_by'])){

            $Suivitaches->creat_by = $data['creat_by'];

        }













































        if(!empty($data['date_demande'])){

            $Suivitaches->date_demande = $data['date_demande'];

        }













        if(!empty($data['deadline'])){

            $Suivitaches->deadline = $data['deadline'];

        }













        if(!empty($data['date_fin'])){

            $Suivitaches->date_fin = $data['date_fin'];

        }




        if(!empty($data['faisabilite'])){

            $Suivitaches->faisabilite = $data['faisabilite'];

        }




        if(!empty($data['commentaire'])){

            $Suivitaches->commentaire = $data['commentaire'];

        }




        if(!empty($data['projet_id'])){

            $Suivitaches->projet_id = $data['projet_id'];

        }




        if(!empty($data['client_id'])){

            $Suivitaches->client_id = $data['client_id'];

        }




        if(!empty($data['user_id'])){

            $Suivitaches->user_id = $data['user_id'];

        }













        if(!empty($data['identifiants_sadge'])){

            $Suivitaches->identifiants_sadge = $data['identifiants_sadge'];

        }














$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Suivitaches->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\SuivitacheExtras') &&
method_exists('\App\Http\Extras\SuivitacheExtras', 'beforeSaveCreate')
){
\App\Http\Extras\SuivitacheExtras::beforeSaveCreate($request,$Suivitaches);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\SuivitacheExtras') &&
method_exists('\App\Http\Extras\SuivitacheExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\SuivitacheExtras::canCreate($request, $Suivitaches);
}catch (\Throwable $e){

}

}


if($canSave){
$Suivitaches->save();
}else{
return response()->json($Suivitaches, 200);
}

$Suivitaches=Suivitache::find($Suivitaches->id);
$newCrudData=[];

                $newCrudData['priorite']=$Suivitaches->priorite;
                $newCrudData['libelle']=$Suivitaches->libelle;
                $newCrudData['creat_by']=$Suivitaches->creat_by;
                                $newCrudData['date_demande']=$Suivitaches->date_demande;
                $newCrudData['deadline']=$Suivitaches->deadline;
                $newCrudData['date_fin']=$Suivitaches->date_fin;
                $newCrudData['faisabilite']=$Suivitaches->faisabilite;
                $newCrudData['commentaire']=$Suivitaches->commentaire;
                $newCrudData['projet_id']=$Suivitaches->projet_id;
                $newCrudData['client_id']=$Suivitaches->client_id;
                $newCrudData['user_id']=$Suivitaches->user_id;
                $newCrudData['identifiants_sadge']=$Suivitaches->identifiants_sadge;


DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Suivitaches','entite_cle' => $Suivitaches->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Suivitaches->toArray();




try{

foreach ($Suivitaches->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Suivitache $Suivitaches)
{
try{
$can=\App\Helpers\Helpers::can('Editer des Suivitaches');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['priorite']=$Suivitaches->priorite;
                $oldCrudData['libelle']=$Suivitaches->libelle;
                $oldCrudData['creat_by']=$Suivitaches->creat_by;
                                $oldCrudData['date_demande']=$Suivitaches->date_demande;
                $oldCrudData['deadline']=$Suivitaches->deadline;
                $oldCrudData['date_fin']=$Suivitaches->date_fin;
                $oldCrudData['faisabilite']=$Suivitaches->faisabilite;
                $oldCrudData['commentaire']=$Suivitaches->commentaire;
                $oldCrudData['projet_id']=$Suivitaches->projet_id;
                $oldCrudData['client_id']=$Suivitaches->client_id;
                $oldCrudData['user_id']=$Suivitaches->user_id;
                $oldCrudData['identifiants_sadge']=$Suivitaches->identifiants_sadge;



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "Suivitaches"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'priorite',
    'libelle',
    'creat_by',
    'extra_attributes',
    'created_at',
    'updated_at',
    'deleted_at',
    'date_demande',
    'deadline',
    'date_fin',
    'faisabilite',
    'commentaire',
    'projet_id',
    'client_id',
    'user_id',
    'identifiants_sadge',
];
$envoyer=[];
foreach($data as $key=>$d){
$envoyer[]=$key;


}
$envoyer=array_unique($envoyer);

Validator::make($data, [


                    'priorite' => [
            //'required'
            ],



                    'libelle' => [
            //'required'
            ],



                    'creat_by' => [
            //'required'
            ],







                    'date_demande' => [
            //'required'
            ],



                    'deadline' => [
            //'required'
            ],



                    'date_fin' => [
            //'required'
            ],



            'faisabilite' => [
        //'required'
        ],



        'commentaire' => [
        //'required'
        ],



        'projet_id' => [
        //'required'
        ],



        'client_id' => [
        //'required'
        ],



        'user_id' => [
        //'required'
        ],



                    'identifiants_sadge' => [
            //'required'
            ],




], $messages = [



        'priorite' => ['cette donnee est obligatoire'],



        'libelle' => ['cette donnee est obligatoire'],



        'creat_by' => ['cette donnee est obligatoire'],







        'date_demande' => ['cette donnee est obligatoire'],



        'deadline' => ['cette donnee est obligatoire'],



        'date_fin' => ['cette donnee est obligatoire'],



        'faisabilite' => ['cette donnee est obligatoire'],



        'commentaire' => ['cette donnee est obligatoire'],



        'projet_id' => ['cette donnee est obligatoire'],



        'client_id' => ['cette donnee est obligatoire'],



        'user_id' => ['cette donnee est obligatoire'],



        'identifiants_sadge' => ['cette donnee est obligatoire'],


])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);





















        if(array_key_exists("priorite",$data)){


        if(!empty($data['priorite'])){

            $Suivitaches->priorite = $data['priorite'];

        }

        }











        if(array_key_exists("libelle",$data)){


        if(!empty($data['libelle'])){

            $Suivitaches->libelle = $data['libelle'];

        }

        }











        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){

            $Suivitaches->creat_by = $data['creat_by'];

        }

        }











































        if(array_key_exists("date_demande",$data)){


        if(!empty($data['date_demande'])){

            $Suivitaches->date_demande = $data['date_demande'];

        }

        }











        if(array_key_exists("deadline",$data)){


        if(!empty($data['deadline'])){

            $Suivitaches->deadline = $data['deadline'];

        }

        }











        if(array_key_exists("date_fin",$data)){


            if(!empty($data['date_fin'])){

                $Suivitaches->date_fin = $data['date_fin'];

            }

            }


            if(array_key_exists("faisabilite",$data)){


            if(!empty($data['faisabilite'])){

                $Suivitaches->faisabilite = $data['faisabilite'];

            }

            }


            if(array_key_exists("commentaire",$data)){


            if(!empty($data['commentaire'])){

                $Suivitaches->commentaire = $data['commentaire'];

            }

            }


            if(array_key_exists("projet_id",$data)){


            if(!empty($data['projet_id'])){

                $Suivitaches->projet_id = $data['projet_id'];

            }

            }


            if(array_key_exists("client_id",$data)){


            if(!empty($data['client_id'])){

                $Suivitaches->client_id = $data['client_id'];

            }

            }


            if(array_key_exists("user_id",$data)){


            if(!empty($data['user_id'])){

                $Suivitaches->user_id = $data['user_id'];

            }

            }











        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){

            $Suivitaches->identifiants_sadge = $data['identifiants_sadge'];

        }

        }












$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Suivitaches->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\SuivitacheExtras') &&
method_exists('\App\Http\Extras\SuivitacheExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\SuivitacheExtras::beforeSaveUpdate($request,$Suivitaches);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\SuivitacheExtras') &&
method_exists('\App\Http\Extras\SuivitacheExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\SuivitacheExtras::canUpdate($request, $Suivitaches);
}catch (\Throwable $e){

}

}


if($canSave){
$Suivitaches->save();
}else{
return response()->json($Suivitaches, 200);

}


$Suivitaches=Suivitache::find($Suivitaches->id);



$newCrudData=[];

                $newCrudData['priorite']=$Suivitaches->priorite;
                $newCrudData['libelle']=$Suivitaches->libelle;
                $newCrudData['creat_by']=$Suivitaches->creat_by;
                                $newCrudData['date_demande']=$Suivitaches->date_demande;
                $newCrudData['deadline']=$Suivitaches->deadline;
                $newCrudData['date_fin']=$Suivitaches->date_fin;
                $newCrudData['faisabilite']=$Suivitaches->faisabilite;
                $newCrudData['commentaire']=$Suivitaches->commentaire;
                $newCrudData['projet_id']=$Suivitaches->projet_id;
                $newCrudData['client_id']=$Suivitaches->client_id;
                $newCrudData['user_id']=$Suivitaches->user_id;
                $newCrudData['identifiants_sadge']=$Suivitaches->identifiants_sadge;


DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Suivitaches','entite_cle' => $Suivitaches->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Suivitaches->toArray();




try{

foreach ($Suivitaches->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Suivitache $Suivitaches)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des Suivitaches');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['priorite']=$Suivitaches->priorite;
                $newCrudData['libelle']=$Suivitaches->libelle;
                $newCrudData['creat_by']=$Suivitaches->creat_by;
                                $newCrudData['date_demande']=$Suivitaches->date_demande;
                $newCrudData['deadline']=$Suivitaches->deadline;
                $newCrudData['date_fin']=$Suivitaches->date_fin;
                $newCrudData['faisabilite']=$Suivitaches->faisabilite;
                $newCrudData['commentaire']=$Suivitaches->commentaire;
                $newCrudData['projet_id']=$Suivitaches->projet_id;
                $newCrudData['client_id']=$Suivitaches->client_id;
                $newCrudData['user_id']=$Suivitaches->user_id;
                $newCrudData['identifiants_sadge']=$Suivitaches->identifiants_sadge;


DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Suivitaches','entite_cle' => $Suivitaches->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\SuivitacheExtras') &&
method_exists('\App\Http\Extras\SuivitacheExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\SuivitacheExtras::canDelete($request, $Suivitaches);
}catch (\Throwable $e){

}

}



if($canSave){
$Suivitaches->delete();
}else{
return response()->json($Suivitaches, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\SuivitachesActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
