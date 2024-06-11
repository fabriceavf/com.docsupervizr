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
// use App\Repository\prod\ListingsRepository;
use App\Models\Listing;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Actif;
                use App\Models\Balise;
                use App\Models\Categorie;
                use App\Models\Client;
                use App\Models\Contrat;
                use App\Models\Direction;
                use App\Models\Echelon;
                use App\Models\Faction;
                use App\Models\Fonction;
                use App\Models\Matrimoniale;
                use App\Models\Nationalite;
                use App\Models\Online;
                use App\Models\Poste;
                use App\Models\Sexe;
                use App\Models\Site;
                use App\Models\Situation;
                use App\Models\Type;
                use App\Models\Ville;
                use App\Models\Zone;
    
class ListingController extends Controller
{

private $ListingsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\ListingsRepository $ListingsRepository
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
class_exists('\App\Http\Extras\ListingExtras') &&
method_exists('\App\Http\Extras\ListingExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\ListingExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Listing::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\ListingExtras') &&
method_exists('\App\Http\Extras\ListingExtras', 'filterAgGridQuery')
){
\App\Http\Extras\ListingExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('listings',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\ListingExtras') &&
method_exists('\App\Http\Extras\ListingExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\ListingExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  listings reussi',
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
return response()->json(Listing::count());
}
$data = QueryBuilder::for(Listing::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('id_user'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('nom'),

    
            AllowedFilter::exact('prenom'),

    
            AllowedFilter::exact('matricule'),

    
            AllowedFilter::exact('num_badge'),

    
            AllowedFilter::exact('actif_id'),

    
            AllowedFilter::exact('nationalite_id'),

    
            AllowedFilter::exact('contrat_id'),

    
            AllowedFilter::exact('direction_id'),

    
            AllowedFilter::exact('categorie_id'),

    
            AllowedFilter::exact('echelon_id'),

    
            AllowedFilter::exact('sexe_id'),

    
            AllowedFilter::exact('matrimoniale_id'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('ville_id'),

    
            AllowedFilter::exact('zone_id'),

    
            AllowedFilter::exact('situation_id'),

    
            AllowedFilter::exact('balise_id'),

    
            AllowedFilter::exact('fonction_id'),

    
            AllowedFilter::exact('emp_code'),

    
            AllowedFilter::exact('online_id'),

    
            AllowedFilter::exact('type_id'),

    
            AllowedFilter::exact('faction_id'),

    
            AllowedFilter::exact('present'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('id_date'),

    
    
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

    
            AllowedSort::field('id_user'),

    
            AllowedSort::field('name'),

    
            AllowedSort::field('nom'),

    
            AllowedSort::field('prenom'),

    
            AllowedSort::field('matricule'),

    
            AllowedSort::field('num_badge'),

    
            AllowedSort::field('actif_id'),

    
            AllowedSort::field('nationalite_id'),

    
            AllowedSort::field('contrat_id'),

    
            AllowedSort::field('direction_id'),

    
            AllowedSort::field('categorie_id'),

    
            AllowedSort::field('echelon_id'),

    
            AllowedSort::field('sexe_id'),

    
            AllowedSort::field('matrimoniale_id'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('ville_id'),

    
            AllowedSort::field('zone_id'),

    
            AllowedSort::field('situation_id'),

    
            AllowedSort::field('balise_id'),

    
            AllowedSort::field('fonction_id'),

    
            AllowedSort::field('emp_code'),

    
            AllowedSort::field('online_id'),

    
            AllowedSort::field('type_id'),

    
            AllowedSort::field('faction_id'),

    
            AllowedSort::field('present'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('id_date'),

    
    
])
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
->allowedIncludes([

            'actif',
        

                'balise',
        

                'categorie',
        

                'client',
        

                'contrat',
        

                'direction',
        

                'echelon',
        

                'faction',
        

                'fonction',
        

                'matrimoniale',
        

                'nationalite',
        

                'online',
        

                'poste',
        

                'sexe',
        

                'site',
        

                'situation',
        

                'type',
        

                'ville',
        

                'zone',
        

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




$data = QueryBuilder::for(Listing::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('date'),

    
            AllowedFilter::exact('id_user'),

    
            AllowedFilter::exact('name'),

    
            AllowedFilter::exact('nom'),

    
            AllowedFilter::exact('prenom'),

    
            AllowedFilter::exact('matricule'),

    
            AllowedFilter::exact('num_badge'),

    
            AllowedFilter::exact('actif_id'),

    
            AllowedFilter::exact('nationalite_id'),

    
            AllowedFilter::exact('contrat_id'),

    
            AllowedFilter::exact('direction_id'),

    
            AllowedFilter::exact('categorie_id'),

    
            AllowedFilter::exact('echelon_id'),

    
            AllowedFilter::exact('sexe_id'),

    
            AllowedFilter::exact('matrimoniale_id'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('ville_id'),

    
            AllowedFilter::exact('zone_id'),

    
            AllowedFilter::exact('situation_id'),

    
            AllowedFilter::exact('balise_id'),

    
            AllowedFilter::exact('fonction_id'),

    
            AllowedFilter::exact('emp_code'),

    
            AllowedFilter::exact('online_id'),

    
            AllowedFilter::exact('type_id'),

    
            AllowedFilter::exact('faction_id'),

    
            AllowedFilter::exact('present'),

    
            AllowedFilter::exact('site_id'),

    
            AllowedFilter::exact('client_id'),

    
            AllowedFilter::exact('id_date'),

    
    
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

    
            AllowedSort::field('id_user'),

    
            AllowedSort::field('name'),

    
            AllowedSort::field('nom'),

    
            AllowedSort::field('prenom'),

    
            AllowedSort::field('matricule'),

    
            AllowedSort::field('num_badge'),

    
            AllowedSort::field('actif_id'),

    
            AllowedSort::field('nationalite_id'),

    
            AllowedSort::field('contrat_id'),

    
            AllowedSort::field('direction_id'),

    
            AllowedSort::field('categorie_id'),

    
            AllowedSort::field('echelon_id'),

    
            AllowedSort::field('sexe_id'),

    
            AllowedSort::field('matrimoniale_id'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('ville_id'),

    
            AllowedSort::field('zone_id'),

    
            AllowedSort::field('situation_id'),

    
            AllowedSort::field('balise_id'),

    
            AllowedSort::field('fonction_id'),

    
            AllowedSort::field('emp_code'),

    
            AllowedSort::field('online_id'),

    
            AllowedSort::field('type_id'),

    
            AllowedSort::field('faction_id'),

    
            AllowedSort::field('present'),

    
            AllowedSort::field('site_id'),

    
            AllowedSort::field('client_id'),

    
            AllowedSort::field('id_date'),

    
    
])
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
->allowedIncludes([
            'actif',
        

                'balise',
        

                'categorie',
        

                'client',
        

                'contrat',
        

                'direction',
        

                'echelon',
        

                'faction',
        

                'fonction',
        

                'matrimoniale',
        

                'nationalite',
        

                'online',
        

                'poste',
        

                'sexe',
        

                'site',
        

                'situation',
        

                'type',
        

                'ville',
        

                'zone',
        

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



public function create(Request $request, Listing $Listings)
{


try{
$can=\App\Helpers\Helpers::can('Creer des listings');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "listings"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'date',
    'id_user',
    'name',
    'nom',
    'prenom',
    'matricule',
    'num_badge',
    'actif_id',
    'nationalite_id',
    'contrat_id',
    'direction_id',
    'categorie_id',
    'echelon_id',
    'sexe_id',
    'matrimoniale_id',
    'poste_id',
    'ville_id',
    'zone_id',
    'situation_id',
    'balise_id',
    'fonction_id',
    'emp_code',
    'online_id',
    'type_id',
    'faction_id',
    'present',
    'site_id',
    'client_id',
    'id_date',
    'deleted_at',
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
        
    
    
                    'id_user' => [
            //'required'
            ],
        
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'nom' => ['required'],
        
    
    
                    'prenom' => ['required'],
        
    
    
                    'matricule' => [
            //'required'
            ],
        
    
    
                    'num_badge' => [
            //'required'
            ],
        
    
    
                    'actif_id' => [
            //'required'
            ],
        
    
    
                    'nationalite_id' => [
            //'required'
            ],
        
    
    
                    'contrat_id' => [
            //'required'
            ],
        
    
    
                    'direction_id' => [
            //'required'
            ],
        
    
    
                    'categorie_id' => [
            //'required'
            ],
        
    
    
                    'echelon_id' => [
            //'required'
            ],
        
    
    
                    'sexe_id' => [
            //'required'
            ],
        
    
    
                    'matrimoniale_id' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'ville_id' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
                    'situation_id' => [
            //'required'
            ],
        
    
    
                    'balise_id' => [
            //'required'
            ],
        
    
    
                    'fonction_id' => [
            //'required'
            ],
        
    
    
                    'emp_code' => [
            //'required'
            ],
        
    
    
                    'online_id' => [
            //'required'
            ],
        
    
    
                    'type_id' => [
            //'required'
            ],
        
    
    
                    'faction_id' => [
            //'required'
            ],
        
    
    
                    'present' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'id_date' => [
            //'required'
            ],
        
    
    


], $messages = [

    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'id_user' => ['cette donnee est obligatoire'],

    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'nom' => ['cette donnee est obligatoire'],

    
    
        'prenom' => ['cette donnee est obligatoire'],

    
    
        'matricule' => ['cette donnee est obligatoire'],

    
    
        'num_badge' => ['cette donnee est obligatoire'],

    
    
        'actif_id' => ['cette donnee est obligatoire'],

    
    
        'nationalite_id' => ['cette donnee est obligatoire'],

    
    
        'contrat_id' => ['cette donnee est obligatoire'],

    
    
        'direction_id' => ['cette donnee est obligatoire'],

    
    
        'categorie_id' => ['cette donnee est obligatoire'],

    
    
        'echelon_id' => ['cette donnee est obligatoire'],

    
    
        'sexe_id' => ['cette donnee est obligatoire'],

    
    
        'matrimoniale_id' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'ville_id' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
        'situation_id' => ['cette donnee est obligatoire'],

    
    
        'balise_id' => ['cette donnee est obligatoire'],

    
    
        'fonction_id' => ['cette donnee est obligatoire'],

    
    
        'emp_code' => ['cette donnee est obligatoire'],

    
    
        'online_id' => ['cette donnee est obligatoire'],

    
    
        'type_id' => ['cette donnee est obligatoire'],

    
    
        'faction_id' => ['cette donnee est obligatoire'],

    
    
        'present' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'id_date' => ['cette donnee est obligatoire'],

    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['date'])){
        
            $Listings->date = $data['date'];
        
        }



    







    

        if(!empty($data['id_user'])){
        
            $Listings->id_user = $data['id_user'];
        
        }



    







    

        if(!empty($data['name'])){
        
            $Listings->name = $data['name'];
        
        }



    







    

        if(!empty($data['nom'])){
        
            $Listings->nom = $data['nom'];
        
        }



    







    

        if(!empty($data['prenom'])){
        
            $Listings->prenom = $data['prenom'];
        
        }



    







    

        if(!empty($data['matricule'])){
        
            $Listings->matricule = $data['matricule'];
        
        }



    







    

        if(!empty($data['num_badge'])){
        
            $Listings->num_badge = $data['num_badge'];
        
        }



    







    

        if(!empty($data['actif_id'])){
        
            $Listings->actif_id = $data['actif_id'];
        
        }



    







    

        if(!empty($data['nationalite_id'])){
        
            $Listings->nationalite_id = $data['nationalite_id'];
        
        }



    







    

        if(!empty($data['contrat_id'])){
        
            $Listings->contrat_id = $data['contrat_id'];
        
        }



    







    

        if(!empty($data['direction_id'])){
        
            $Listings->direction_id = $data['direction_id'];
        
        }



    







    

        if(!empty($data['categorie_id'])){
        
            $Listings->categorie_id = $data['categorie_id'];
        
        }



    







    

        if(!empty($data['echelon_id'])){
        
            $Listings->echelon_id = $data['echelon_id'];
        
        }



    







    

        if(!empty($data['sexe_id'])){
        
            $Listings->sexe_id = $data['sexe_id'];
        
        }



    







    

        if(!empty($data['matrimoniale_id'])){
        
            $Listings->matrimoniale_id = $data['matrimoniale_id'];
        
        }



    







    

        if(!empty($data['poste_id'])){
        
            $Listings->poste_id = $data['poste_id'];
        
        }



    







    

        if(!empty($data['ville_id'])){
        
            $Listings->ville_id = $data['ville_id'];
        
        }



    







    

        if(!empty($data['zone_id'])){
        
            $Listings->zone_id = $data['zone_id'];
        
        }



    







    

        if(!empty($data['situation_id'])){
        
            $Listings->situation_id = $data['situation_id'];
        
        }



    







    

        if(!empty($data['balise_id'])){
        
            $Listings->balise_id = $data['balise_id'];
        
        }



    







    

        if(!empty($data['fonction_id'])){
        
            $Listings->fonction_id = $data['fonction_id'];
        
        }



    







    

        if(!empty($data['emp_code'])){
        
            $Listings->emp_code = $data['emp_code'];
        
        }



    







    

        if(!empty($data['online_id'])){
        
            $Listings->online_id = $data['online_id'];
        
        }



    







    

        if(!empty($data['type_id'])){
        
            $Listings->type_id = $data['type_id'];
        
        }



    







    

        if(!empty($data['faction_id'])){
        
            $Listings->faction_id = $data['faction_id'];
        
        }



    







    

        if(!empty($data['present'])){
        
            $Listings->present = $data['present'];
        
        }



    







    

        if(!empty($data['site_id'])){
        
            $Listings->site_id = $data['site_id'];
        
        }



    







    

        if(!empty($data['client_id'])){
        
            $Listings->client_id = $data['client_id'];
        
        }



    







    

        if(!empty($data['id_date'])){
        
            $Listings->id_date = $data['id_date'];
        
        }



    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Listings->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\ListingExtras') &&
method_exists('\App\Http\Extras\ListingExtras', 'beforeSaveCreate')
){
\App\Http\Extras\ListingExtras::beforeSaveCreate($request,$Listings);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ListingExtras') &&
method_exists('\App\Http\Extras\ListingExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\ListingExtras::canCreate($request, $Listings);
}catch (\Throwable $e){

}

}


if($canSave){
$Listings->save();
}else{
return response()->json($Listings, 200);
}

$Listings=Listing::find($Listings->id);
$newCrudData=[];

                $newCrudData['date']=$Listings->date;
                $newCrudData['id_user']=$Listings->id_user;
                $newCrudData['name']=$Listings->name;
                $newCrudData['nom']=$Listings->nom;
                $newCrudData['prenom']=$Listings->prenom;
                $newCrudData['matricule']=$Listings->matricule;
                $newCrudData['num_badge']=$Listings->num_badge;
                $newCrudData['actif_id']=$Listings->actif_id;
                $newCrudData['nationalite_id']=$Listings->nationalite_id;
                $newCrudData['contrat_id']=$Listings->contrat_id;
                $newCrudData['direction_id']=$Listings->direction_id;
                $newCrudData['categorie_id']=$Listings->categorie_id;
                $newCrudData['echelon_id']=$Listings->echelon_id;
                $newCrudData['sexe_id']=$Listings->sexe_id;
                $newCrudData['matrimoniale_id']=$Listings->matrimoniale_id;
                $newCrudData['poste_id']=$Listings->poste_id;
                $newCrudData['ville_id']=$Listings->ville_id;
                $newCrudData['zone_id']=$Listings->zone_id;
                $newCrudData['situation_id']=$Listings->situation_id;
                $newCrudData['balise_id']=$Listings->balise_id;
                $newCrudData['fonction_id']=$Listings->fonction_id;
                $newCrudData['emp_code']=$Listings->emp_code;
                $newCrudData['online_id']=$Listings->online_id;
                $newCrudData['type_id']=$Listings->type_id;
                $newCrudData['faction_id']=$Listings->faction_id;
                $newCrudData['present']=$Listings->present;
                $newCrudData['site_id']=$Listings->site_id;
                $newCrudData['client_id']=$Listings->client_id;
                $newCrudData['id_date']=$Listings->id_date;
        
 try{ $newCrudData['actif']=$Listings->actif->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['balise']=$Listings->balise->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['categorie']=$Listings->categorie->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['client']=$Listings->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['contrat']=$Listings->contrat->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['direction']=$Listings->direction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['echelon']=$Listings->echelon->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['faction']=$Listings->faction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['fonction']=$Listings->fonction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['matrimoniale']=$Listings->matrimoniale->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['nationalite']=$Listings->nationalite->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['online']=$Listings->online->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Listings->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['sexe']=$Listings->sexe->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Listings->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['situation']=$Listings->situation->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['type']=$Listings->type->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Listings->ville->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Listings->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Listings','entite_cle' => $Listings->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Listings->toArray();




try{

foreach ($Listings->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Listing $Listings)
{
try{
$can=\App\Helpers\Helpers::can('Editer des listings');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['date']=$Listings->date;
                $oldCrudData['id_user']=$Listings->id_user;
                $oldCrudData['name']=$Listings->name;
                $oldCrudData['nom']=$Listings->nom;
                $oldCrudData['prenom']=$Listings->prenom;
                $oldCrudData['matricule']=$Listings->matricule;
                $oldCrudData['num_badge']=$Listings->num_badge;
                $oldCrudData['actif_id']=$Listings->actif_id;
                $oldCrudData['nationalite_id']=$Listings->nationalite_id;
                $oldCrudData['contrat_id']=$Listings->contrat_id;
                $oldCrudData['direction_id']=$Listings->direction_id;
                $oldCrudData['categorie_id']=$Listings->categorie_id;
                $oldCrudData['echelon_id']=$Listings->echelon_id;
                $oldCrudData['sexe_id']=$Listings->sexe_id;
                $oldCrudData['matrimoniale_id']=$Listings->matrimoniale_id;
                $oldCrudData['poste_id']=$Listings->poste_id;
                $oldCrudData['ville_id']=$Listings->ville_id;
                $oldCrudData['zone_id']=$Listings->zone_id;
                $oldCrudData['situation_id']=$Listings->situation_id;
                $oldCrudData['balise_id']=$Listings->balise_id;
                $oldCrudData['fonction_id']=$Listings->fonction_id;
                $oldCrudData['emp_code']=$Listings->emp_code;
                $oldCrudData['online_id']=$Listings->online_id;
                $oldCrudData['type_id']=$Listings->type_id;
                $oldCrudData['faction_id']=$Listings->faction_id;
                $oldCrudData['present']=$Listings->present;
                $oldCrudData['site_id']=$Listings->site_id;
                $oldCrudData['client_id']=$Listings->client_id;
                $oldCrudData['id_date']=$Listings->id_date;
        
 try{ $oldCrudData['actif']=$Listings->actif->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['balise']=$Listings->balise->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['categorie']=$Listings->categorie->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['client']=$Listings->client->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['contrat']=$Listings->contrat->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['direction']=$Listings->direction->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['echelon']=$Listings->echelon->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['faction']=$Listings->faction->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['fonction']=$Listings->fonction->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['matrimoniale']=$Listings->matrimoniale->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['nationalite']=$Listings->nationalite->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['online']=$Listings->online->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['poste']=$Listings->poste->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['sexe']=$Listings->sexe->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['site']=$Listings->site->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['situation']=$Listings->situation->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['type']=$Listings->type->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['ville']=$Listings->ville->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['zone']=$Listings->zone->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "listings"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'date',
    'id_user',
    'name',
    'nom',
    'prenom',
    'matricule',
    'num_badge',
    'actif_id',
    'nationalite_id',
    'contrat_id',
    'direction_id',
    'categorie_id',
    'echelon_id',
    'sexe_id',
    'matrimoniale_id',
    'poste_id',
    'ville_id',
    'zone_id',
    'situation_id',
    'balise_id',
    'fonction_id',
    'emp_code',
    'online_id',
    'type_id',
    'faction_id',
    'present',
    'site_id',
    'client_id',
    'id_date',
    'deleted_at',
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
        
    
    
                    'id_user' => [
            //'required'
            ],
        
    
    
                    'name' => [
            //'required'
            ],
        
    
    
                    'nom' => ['required'],
        
    
    
                    'prenom' => ['required'],
        
    
    
                    'matricule' => [
            //'required'
            ],
        
    
    
                    'num_badge' => [
            //'required'
            ],
        
    
    
                    'actif_id' => [
            //'required'
            ],
        
    
    
                    'nationalite_id' => [
            //'required'
            ],
        
    
    
                    'contrat_id' => [
            //'required'
            ],
        
    
    
                    'direction_id' => [
            //'required'
            ],
        
    
    
                    'categorie_id' => [
            //'required'
            ],
        
    
    
                    'echelon_id' => [
            //'required'
            ],
        
    
    
                    'sexe_id' => [
            //'required'
            ],
        
    
    
                    'matrimoniale_id' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'ville_id' => [
            //'required'
            ],
        
    
    
                    'zone_id' => [
            //'required'
            ],
        
    
    
                    'situation_id' => [
            //'required'
            ],
        
    
    
                    'balise_id' => [
            //'required'
            ],
        
    
    
                    'fonction_id' => [
            //'required'
            ],
        
    
    
                    'emp_code' => [
            //'required'
            ],
        
    
    
                    'online_id' => [
            //'required'
            ],
        
    
    
                    'type_id' => [
            //'required'
            ],
        
    
    
                    'faction_id' => [
            //'required'
            ],
        
    
    
                    'present' => [
            //'required'
            ],
        
    
    
                    'site_id' => [
            //'required'
            ],
        
    
    
                    'client_id' => [
            //'required'
            ],
        
    
    
                    'id_date' => [
            //'required'
            ],
        
    
    


], $messages = [

    
    
        'date' => ['cette donnee est obligatoire'],

    
    
        'id_user' => ['cette donnee est obligatoire'],

    
    
        'name' => ['cette donnee est obligatoire'],

    
    
        'nom' => ['cette donnee est obligatoire'],

    
    
        'prenom' => ['cette donnee est obligatoire'],

    
    
        'matricule' => ['cette donnee est obligatoire'],

    
    
        'num_badge' => ['cette donnee est obligatoire'],

    
    
        'actif_id' => ['cette donnee est obligatoire'],

    
    
        'nationalite_id' => ['cette donnee est obligatoire'],

    
    
        'contrat_id' => ['cette donnee est obligatoire'],

    
    
        'direction_id' => ['cette donnee est obligatoire'],

    
    
        'categorie_id' => ['cette donnee est obligatoire'],

    
    
        'echelon_id' => ['cette donnee est obligatoire'],

    
    
        'sexe_id' => ['cette donnee est obligatoire'],

    
    
        'matrimoniale_id' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'ville_id' => ['cette donnee est obligatoire'],

    
    
        'zone_id' => ['cette donnee est obligatoire'],

    
    
        'situation_id' => ['cette donnee est obligatoire'],

    
    
        'balise_id' => ['cette donnee est obligatoire'],

    
    
        'fonction_id' => ['cette donnee est obligatoire'],

    
    
        'emp_code' => ['cette donnee est obligatoire'],

    
    
        'online_id' => ['cette donnee est obligatoire'],

    
    
        'type_id' => ['cette donnee est obligatoire'],

    
    
        'faction_id' => ['cette donnee est obligatoire'],

    
    
        'present' => ['cette donnee est obligatoire'],

    
    
        'site_id' => ['cette donnee est obligatoire'],

    
    
        'client_id' => ['cette donnee est obligatoire'],

    
    
        'id_date' => ['cette donnee est obligatoire'],

    
    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("date",$data)){


        if(!empty($data['date'])){
        
            $Listings->date = $data['date'];
        
        }

        }

    







    

        if(array_key_exists("id_user",$data)){


        if(!empty($data['id_user'])){
        
            $Listings->id_user = $data['id_user'];
        
        }

        }

    







    

        if(array_key_exists("name",$data)){


        if(!empty($data['name'])){
        
            $Listings->name = $data['name'];
        
        }

        }

    







    

        if(array_key_exists("nom",$data)){


        if(!empty($data['nom'])){
        
            $Listings->nom = $data['nom'];
        
        }

        }

    







    

        if(array_key_exists("prenom",$data)){


        if(!empty($data['prenom'])){
        
            $Listings->prenom = $data['prenom'];
        
        }

        }

    







    

        if(array_key_exists("matricule",$data)){


        if(!empty($data['matricule'])){
        
            $Listings->matricule = $data['matricule'];
        
        }

        }

    







    

        if(array_key_exists("num_badge",$data)){


        if(!empty($data['num_badge'])){
        
            $Listings->num_badge = $data['num_badge'];
        
        }

        }

    







    

        if(array_key_exists("actif_id",$data)){


        if(!empty($data['actif_id'])){
        
            $Listings->actif_id = $data['actif_id'];
        
        }

        }

    







    

        if(array_key_exists("nationalite_id",$data)){


        if(!empty($data['nationalite_id'])){
        
            $Listings->nationalite_id = $data['nationalite_id'];
        
        }

        }

    







    

        if(array_key_exists("contrat_id",$data)){


        if(!empty($data['contrat_id'])){
        
            $Listings->contrat_id = $data['contrat_id'];
        
        }

        }

    







    

        if(array_key_exists("direction_id",$data)){


        if(!empty($data['direction_id'])){
        
            $Listings->direction_id = $data['direction_id'];
        
        }

        }

    







    

        if(array_key_exists("categorie_id",$data)){


        if(!empty($data['categorie_id'])){
        
            $Listings->categorie_id = $data['categorie_id'];
        
        }

        }

    







    

        if(array_key_exists("echelon_id",$data)){


        if(!empty($data['echelon_id'])){
        
            $Listings->echelon_id = $data['echelon_id'];
        
        }

        }

    







    

        if(array_key_exists("sexe_id",$data)){


        if(!empty($data['sexe_id'])){
        
            $Listings->sexe_id = $data['sexe_id'];
        
        }

        }

    







    

        if(array_key_exists("matrimoniale_id",$data)){


        if(!empty($data['matrimoniale_id'])){
        
            $Listings->matrimoniale_id = $data['matrimoniale_id'];
        
        }

        }

    







    

        if(array_key_exists("poste_id",$data)){


        if(!empty($data['poste_id'])){
        
            $Listings->poste_id = $data['poste_id'];
        
        }

        }

    







    

        if(array_key_exists("ville_id",$data)){


        if(!empty($data['ville_id'])){
        
            $Listings->ville_id = $data['ville_id'];
        
        }

        }

    







    

        if(array_key_exists("zone_id",$data)){


        if(!empty($data['zone_id'])){
        
            $Listings->zone_id = $data['zone_id'];
        
        }

        }

    







    

        if(array_key_exists("situation_id",$data)){


        if(!empty($data['situation_id'])){
        
            $Listings->situation_id = $data['situation_id'];
        
        }

        }

    







    

        if(array_key_exists("balise_id",$data)){


        if(!empty($data['balise_id'])){
        
            $Listings->balise_id = $data['balise_id'];
        
        }

        }

    







    

        if(array_key_exists("fonction_id",$data)){


        if(!empty($data['fonction_id'])){
        
            $Listings->fonction_id = $data['fonction_id'];
        
        }

        }

    







    

        if(array_key_exists("emp_code",$data)){


        if(!empty($data['emp_code'])){
        
            $Listings->emp_code = $data['emp_code'];
        
        }

        }

    







    

        if(array_key_exists("online_id",$data)){


        if(!empty($data['online_id'])){
        
            $Listings->online_id = $data['online_id'];
        
        }

        }

    







    

        if(array_key_exists("type_id",$data)){


        if(!empty($data['type_id'])){
        
            $Listings->type_id = $data['type_id'];
        
        }

        }

    







    

        if(array_key_exists("faction_id",$data)){


        if(!empty($data['faction_id'])){
        
            $Listings->faction_id = $data['faction_id'];
        
        }

        }

    







    

        if(array_key_exists("present",$data)){


        if(!empty($data['present'])){
        
            $Listings->present = $data['present'];
        
        }

        }

    







    

        if(array_key_exists("site_id",$data)){


        if(!empty($data['site_id'])){
        
            $Listings->site_id = $data['site_id'];
        
        }

        }

    







    

        if(array_key_exists("client_id",$data)){


        if(!empty($data['client_id'])){
        
            $Listings->client_id = $data['client_id'];
        
        }

        }

    







    

        if(array_key_exists("id_date",$data)){


        if(!empty($data['id_date'])){
        
            $Listings->id_date = $data['id_date'];
        
        }

        }

    







    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Listings->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\ListingExtras') &&
method_exists('\App\Http\Extras\ListingExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\ListingExtras::beforeSaveUpdate($request,$Listings);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\ListingExtras') &&
method_exists('\App\Http\Extras\ListingExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\ListingExtras::canUpdate($request, $Listings);
}catch (\Throwable $e){

}

}


if($canSave){
$Listings->save();
}else{
return response()->json($Listings, 200);

}


$Listings=Listing::find($Listings->id);



$newCrudData=[];

                $newCrudData['date']=$Listings->date;
                $newCrudData['id_user']=$Listings->id_user;
                $newCrudData['name']=$Listings->name;
                $newCrudData['nom']=$Listings->nom;
                $newCrudData['prenom']=$Listings->prenom;
                $newCrudData['matricule']=$Listings->matricule;
                $newCrudData['num_badge']=$Listings->num_badge;
                $newCrudData['actif_id']=$Listings->actif_id;
                $newCrudData['nationalite_id']=$Listings->nationalite_id;
                $newCrudData['contrat_id']=$Listings->contrat_id;
                $newCrudData['direction_id']=$Listings->direction_id;
                $newCrudData['categorie_id']=$Listings->categorie_id;
                $newCrudData['echelon_id']=$Listings->echelon_id;
                $newCrudData['sexe_id']=$Listings->sexe_id;
                $newCrudData['matrimoniale_id']=$Listings->matrimoniale_id;
                $newCrudData['poste_id']=$Listings->poste_id;
                $newCrudData['ville_id']=$Listings->ville_id;
                $newCrudData['zone_id']=$Listings->zone_id;
                $newCrudData['situation_id']=$Listings->situation_id;
                $newCrudData['balise_id']=$Listings->balise_id;
                $newCrudData['fonction_id']=$Listings->fonction_id;
                $newCrudData['emp_code']=$Listings->emp_code;
                $newCrudData['online_id']=$Listings->online_id;
                $newCrudData['type_id']=$Listings->type_id;
                $newCrudData['faction_id']=$Listings->faction_id;
                $newCrudData['present']=$Listings->present;
                $newCrudData['site_id']=$Listings->site_id;
                $newCrudData['client_id']=$Listings->client_id;
                $newCrudData['id_date']=$Listings->id_date;
        
 try{ $newCrudData['actif']=$Listings->actif->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['balise']=$Listings->balise->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['categorie']=$Listings->categorie->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['client']=$Listings->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['contrat']=$Listings->contrat->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['direction']=$Listings->direction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['echelon']=$Listings->echelon->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['faction']=$Listings->faction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['fonction']=$Listings->fonction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['matrimoniale']=$Listings->matrimoniale->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['nationalite']=$Listings->nationalite->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['online']=$Listings->online->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Listings->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['sexe']=$Listings->sexe->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Listings->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['situation']=$Listings->situation->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['type']=$Listings->type->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Listings->ville->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Listings->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Listings','entite_cle' => $Listings->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Listings->toArray();




try{

foreach ($Listings->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Listing $Listings)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des listings');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['date']=$Listings->date;
                $newCrudData['id_user']=$Listings->id_user;
                $newCrudData['name']=$Listings->name;
                $newCrudData['nom']=$Listings->nom;
                $newCrudData['prenom']=$Listings->prenom;
                $newCrudData['matricule']=$Listings->matricule;
                $newCrudData['num_badge']=$Listings->num_badge;
                $newCrudData['actif_id']=$Listings->actif_id;
                $newCrudData['nationalite_id']=$Listings->nationalite_id;
                $newCrudData['contrat_id']=$Listings->contrat_id;
                $newCrudData['direction_id']=$Listings->direction_id;
                $newCrudData['categorie_id']=$Listings->categorie_id;
                $newCrudData['echelon_id']=$Listings->echelon_id;
                $newCrudData['sexe_id']=$Listings->sexe_id;
                $newCrudData['matrimoniale_id']=$Listings->matrimoniale_id;
                $newCrudData['poste_id']=$Listings->poste_id;
                $newCrudData['ville_id']=$Listings->ville_id;
                $newCrudData['zone_id']=$Listings->zone_id;
                $newCrudData['situation_id']=$Listings->situation_id;
                $newCrudData['balise_id']=$Listings->balise_id;
                $newCrudData['fonction_id']=$Listings->fonction_id;
                $newCrudData['emp_code']=$Listings->emp_code;
                $newCrudData['online_id']=$Listings->online_id;
                $newCrudData['type_id']=$Listings->type_id;
                $newCrudData['faction_id']=$Listings->faction_id;
                $newCrudData['present']=$Listings->present;
                $newCrudData['site_id']=$Listings->site_id;
                $newCrudData['client_id']=$Listings->client_id;
                $newCrudData['id_date']=$Listings->id_date;
        
 try{ $newCrudData['actif']=$Listings->actif->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['balise']=$Listings->balise->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['categorie']=$Listings->categorie->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['client']=$Listings->client->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['contrat']=$Listings->contrat->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['direction']=$Listings->direction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['echelon']=$Listings->echelon->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['faction']=$Listings->faction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['fonction']=$Listings->fonction->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['matrimoniale']=$Listings->matrimoniale->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['nationalite']=$Listings->nationalite->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['online']=$Listings->online->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Listings->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['sexe']=$Listings->sexe->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['site']=$Listings->site->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['situation']=$Listings->situation->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['type']=$Listings->type->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Listings->ville->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['zone']=$Listings->zone->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Listings','entite_cle' => $Listings->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\ListingExtras') &&
method_exists('\App\Http\Extras\ListingExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\ListingExtras::canDelete($request, $Listings);
}catch (\Throwable $e){

}

}



if($canSave){
$Listings->delete();
}else{
return response()->json($Listings, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\ListingsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
