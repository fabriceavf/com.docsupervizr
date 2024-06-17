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
// use App\Repository\prod\TransactionsRepository;
use App\Models\Transaction;
use App\Http\AgGrid;

    use App\Models\ser;


    use App\Models\Groupe;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;



            use App\Models\Carte;
                use App\Models\Controlleursacce;
                use App\Models\Identification;
                use App\Models\Ligne;
                use App\Models\Poste;
                use App\Models\Ville;
    
class TransactionController extends Controller
{

private $TransactionsRepository;
private $menu;


/**
* Return .
* @param \Illuminate\Http\Request $request
* @param App\Repository\prod\TransactionsRepository $TransactionsRepository
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
class_exists('\App\Http\Extras\TransactionExtras') &&
method_exists('\App\Http\Extras\TransactionExtras', 'getRelationsApplyWhenUserCallMultipleData')
){
try{
$relationsWhenDataIsMutlipleHide=\App\Http\Extras\TransactionExtras::getRelationsApplyWhenUserCallMultipleData($request);
}catch (\Throwable) {
$relationsWhenDataIsMutlipleHide=[];
}
}
$query=Transaction::withoutGlobalScope(SoftDeletingScope::class);

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
class_exists('\App\Http\Extras\TransactionExtras') &&
method_exists('\App\Http\Extras\TransactionExtras', 'filterAgGridQuery')
){
\App\Http\Extras\TransactionExtras::filterAgGridQuery($request,$query);
}


$agGrid=new AgGrid('transactions',$query);
$data= $agGrid->getData($request);

if(
class_exists('\App\Http\Extras\TransactionExtras') &&
method_exists('\App\Http\Extras\TransactionExtras', 'AgGridUpdateDataBeforeReturnToUser')
){
$_d=$data['rowData'];
$_d= \App\Http\Extras\TransactionExtras::AgGridUpdateDataBeforeReturnToUser($request,$_d);
$data['rowData'] = $_d;

if ($_d->count() > $data['rowCount']) {
$data['rowCount'] = $_d->count();
}
}
try{
\Illuminate\Support\Facades\DB::table('surveillances')->insert([
'user_id' => Auth::id(),
'action' => 'Lectures des donnees api de  transactions reussi',
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
return response()->json(Transaction::count());
}
$data = QueryBuilder::for(Transaction::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('bio_id'),

    
            AllowedFilter::exact('area_alias'),

    
            AllowedFilter::exact('card_no'),

    
            AllowedFilter::exact('terminal_alias'),

    
            AllowedFilter::exact('emp_code'),

    
            AllowedFilter::exact('punch_date'),

    
            AllowedFilter::exact('punch_time'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('ville_id'),

    
    
    
    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('annuler'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('traiter'),

    
            AllowedFilter::exact('verification'),

    
            AllowedFilter::exact('rechercheetape'),

    
            AllowedFilter::exact('heure'),

    
            AllowedFilter::exact('identification_id'),

    
            AllowedFilter::exact('controlleursacce_id'),

    
            AllowedFilter::exact('carte_id'),

    
            AllowedFilter::exact('cout'),

    
            AllowedFilter::exact('ligne_id'),

    
    
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

    
            AllowedSort::field('bio_id'),

    
            AllowedSort::field('area_alias'),

    
            AllowedSort::field('card_no'),

    
            AllowedSort::field('terminal_alias'),

    
            AllowedSort::field('emp_code'),

    
            AllowedSort::field('punch_date'),

    
            AllowedSort::field('punch_time'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('ville_id'),

    
    
    
    
            AllowedSort::field('etats'),

    
            AllowedSort::field('annuler'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('traiter'),

    
            AllowedSort::field('verification'),

    
            AllowedSort::field('rechercheetape'),

    
            AllowedSort::field('heure'),

    
            AllowedSort::field('identification_id'),

    
            AllowedSort::field('controlleursacce_id'),

    
            AllowedSort::field('carte_id'),

    
            AllowedSort::field('cout'),

    
            AllowedSort::field('ligne_id'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
    
    
    
->allowedIncludes([
            'preuves',
        

                'traitements',
        

    
            'carte',
        

                'controlleursacce',
        

                'identification',
        

                'ligne',
        

                'poste',
        

                'ville',
        

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




$data = QueryBuilder::for(Transaction::class)
->allowedFilters([
            AllowedFilter::exact('id'),

    
            AllowedFilter::exact('bio_id'),

    
            AllowedFilter::exact('area_alias'),

    
            AllowedFilter::exact('card_no'),

    
            AllowedFilter::exact('terminal_alias'),

    
            AllowedFilter::exact('emp_code'),

    
            AllowedFilter::exact('punch_date'),

    
            AllowedFilter::exact('punch_time'),

    
            AllowedFilter::exact('poste_id'),

    
            AllowedFilter::exact('ville_id'),

    
    
    
    
            AllowedFilter::exact('etats'),

    
            AllowedFilter::exact('annuler'),

    
            AllowedFilter::exact('type'),

    
            AllowedFilter::exact('traiter'),

    
            AllowedFilter::exact('verification'),

    
            AllowedFilter::exact('rechercheetape'),

    
            AllowedFilter::exact('heure'),

    
            AllowedFilter::exact('identification_id'),

    
            AllowedFilter::exact('controlleursacce_id'),

    
            AllowedFilter::exact('carte_id'),

    
            AllowedFilter::exact('cout'),

    
            AllowedFilter::exact('ligne_id'),

    
    
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

    
            AllowedSort::field('bio_id'),

    
            AllowedSort::field('area_alias'),

    
            AllowedSort::field('card_no'),

    
            AllowedSort::field('terminal_alias'),

    
            AllowedSort::field('emp_code'),

    
            AllowedSort::field('punch_date'),

    
            AllowedSort::field('punch_time'),

    
            AllowedSort::field('poste_id'),

    
            AllowedSort::field('ville_id'),

    
    
    
    
            AllowedSort::field('etats'),

    
            AllowedSort::field('annuler'),

    
            AllowedSort::field('type'),

    
            AllowedSort::field('traiter'),

    
            AllowedSort::field('verification'),

    
            AllowedSort::field('rechercheetape'),

    
            AllowedSort::field('heure'),

    
            AllowedSort::field('identification_id'),

    
            AllowedSort::field('controlleursacce_id'),

    
            AllowedSort::field('carte_id'),

    
            AllowedSort::field('cout'),

    
            AllowedSort::field('ligne_id'),

    
    
            AllowedSort::field('identifiants_sadge'),

    
            AllowedSort::field('creat_by'),

    
])
    
    
    
    
    
    
->allowedIncludes([
            'preuves',
        

                'traitements',
        

                'carte',
        

                'controlleursacce',
        

                'identification',
        

                'ligne',
        

                'poste',
        

                'ville',
        

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



public function create(Request $request, Transaction $Transactions)
{


try{
$can=\App\Helpers\Helpers::can('Creer des transactions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}



$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "transactions"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'bio_id',
    'area_alias',
    'card_no',
    'terminal_alias',
    'emp_code',
    'punch_date',
    'punch_time',
    'poste_id',
    'ville_id',
    'extra_attributes',
    'created_at',
    'updated_at',
    'etats',
    'annuler',
    'type',
    'traiter',
    'verification',
    'rechercheetape',
    'heure',
    'identification_id',
    'controlleursacce_id',
    'carte_id',
    'cout',
    'ligne_id',
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
    
    
                    'bio_id' => [
            //'required'
            ],
        
    
    
                    'area_alias' => [
            //'required'
            ],
        
    
    
                    'card_no' => [
            //'required'
            ],
        
    
    
                    'terminal_alias' => [
            //'required'
            ],
        
    
    
                    'emp_code' => [
            //'required'
            ],
        
    
    
                    'punch_date' => [
            //'required'
            ],
        
    
    
                    'punch_time' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'ville_id' => [
            //'required'
            ],
        
    
    
    
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'annuler' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'traiter' => [
            //'required'
            ],
        
    
    
                    'verification' => [
            //'required'
            ],
        
    
    
                    'rechercheetape' => [
            //'required'
            ],
        
    
    
                    'heure' => [
            //'required'
            ],
        
    
    
                    'identification_id' => [
            //'required'
            ],
        
    
    
                    'controlleursacce_id' => [
            //'required'
            ],
        
    
    
                    'carte_id' => [
            //'required'
            ],
        
    
    
                    'cout' => [
            //'required'
            ],
        
    
    
                    'ligne_id' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'bio_id' => ['cette donnee est obligatoire'],

    
    
        'area_alias' => ['cette donnee est obligatoire'],

    
    
        'card_no' => ['cette donnee est obligatoire'],

    
    
        'terminal_alias' => ['cette donnee est obligatoire'],

    
    
        'emp_code' => ['cette donnee est obligatoire'],

    
    
        'punch_date' => ['cette donnee est obligatoire'],

    
    
        'punch_time' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'ville_id' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'annuler' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'traiter' => ['cette donnee est obligatoire'],

    
    
        'verification' => ['cette donnee est obligatoire'],

    
    
        'rechercheetape' => ['cette donnee est obligatoire'],

    
    
        'heure' => ['cette donnee est obligatoire'],

    
    
        'identification_id' => ['cette donnee est obligatoire'],

    
    
        'controlleursacce_id' => ['cette donnee est obligatoire'],

    
    
        'carte_id' => ['cette donnee est obligatoire'],

    
    
        'cout' => ['cette donnee est obligatoire'],

    
    
        'ligne_id' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);

$data['__headers__'] = $request->headers->all();
$data['__authId__'] = Auth::id();
$data['__ip__'] = $request->ip();
$data['creat_by']=Auth::id();








    







    

        if(!empty($data['bio_id'])){
        
            $Transactions->bio_id = $data['bio_id'];
        
        }



    







    

        if(!empty($data['area_alias'])){
        
            $Transactions->area_alias = $data['area_alias'];
        
        }



    







    

        if(!empty($data['card_no'])){
        
            $Transactions->card_no = $data['card_no'];
        
        }



    







    

        if(!empty($data['terminal_alias'])){
        
            $Transactions->terminal_alias = $data['terminal_alias'];
        
        }



    







    

        if(!empty($data['emp_code'])){
        
            $Transactions->emp_code = $data['emp_code'];
        
        }



    







    

        if(!empty($data['punch_date'])){
        
            $Transactions->punch_date = $data['punch_date'];
        
        }



    







    

        if(!empty($data['punch_time'])){
        
            $Transactions->punch_time = $data['punch_time'];
        
        }



    







    

        if(!empty($data['poste_id'])){
        
            $Transactions->poste_id = $data['poste_id'];
        
        }



    







    

        if(!empty($data['ville_id'])){
        
            $Transactions->ville_id = $data['ville_id'];
        
        }



    







    







    







    







    

        if(!empty($data['etats'])){
        
            $Transactions->etats = $data['etats'];
        
        }



    







    

        if(!empty($data['annuler'])){
        
            $Transactions->annuler = $data['annuler'];
        
        }



    







    

        if(!empty($data['type'])){
        
            $Transactions->type = $data['type'];
        
        }



    







    

        if(!empty($data['traiter'])){
        
            $Transactions->traiter = $data['traiter'];
        
        }



    







    

        if(!empty($data['verification'])){
        
            $Transactions->verification = $data['verification'];
        
        }



    







    

        if(!empty($data['rechercheetape'])){
        
            $Transactions->rechercheetape = $data['rechercheetape'];
        
        }



    







    

        if(!empty($data['heure'])){
        
            $Transactions->heure = $data['heure'];
        
        }



    







    

        if(!empty($data['identification_id'])){
        
            $Transactions->identification_id = $data['identification_id'];
        
        }



    







    

        if(!empty($data['controlleursacce_id'])){
        
            $Transactions->controlleursacce_id = $data['controlleursacce_id'];
        
        }



    







    

        if(!empty($data['carte_id'])){
        
            $Transactions->carte_id = $data['carte_id'];
        
        }



    







    

        if(!empty($data['cout'])){
        
            $Transactions->cout = $data['cout'];
        
        }



    







    

        if(!empty($data['ligne_id'])){
        
            $Transactions->ligne_id = $data['ligne_id'];
        
        }



    







    







    

        if(!empty($data['identifiants_sadge'])){
        
            $Transactions->identifiants_sadge = $data['identifiants_sadge'];
        
        }



    







    

        if(!empty($data['creat_by'])){
        
            $Transactions->creat_by = $data['creat_by'];
        
        }



    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Transactions->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}

if(
class_exists('\App\Http\Extras\TransactionExtras') &&
method_exists('\App\Http\Extras\TransactionExtras', 'beforeSaveCreate')
){
\App\Http\Extras\TransactionExtras::beforeSaveCreate($request,$Transactions);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TransactionExtras') &&
method_exists('\App\Http\Extras\TransactionExtras', 'canCreate')
) {
try{
$canSave=\App\Http\Extras\TransactionExtras::canCreate($request, $Transactions);
}catch (\Throwable $e){

}

}


if($canSave){
$Transactions->save();
}else{
return response()->json($Transactions, 200);
}

$Transactions=Transaction::find($Transactions->id);
$newCrudData=[];

                $newCrudData['bio_id']=$Transactions->bio_id;
                $newCrudData['area_alias']=$Transactions->area_alias;
                $newCrudData['card_no']=$Transactions->card_no;
                $newCrudData['terminal_alias']=$Transactions->terminal_alias;
                $newCrudData['emp_code']=$Transactions->emp_code;
                $newCrudData['punch_date']=$Transactions->punch_date;
                $newCrudData['punch_time']=$Transactions->punch_time;
                $newCrudData['poste_id']=$Transactions->poste_id;
                $newCrudData['ville_id']=$Transactions->ville_id;
                            $newCrudData['etats']=$Transactions->etats;
                $newCrudData['annuler']=$Transactions->annuler;
                $newCrudData['type']=$Transactions->type;
                $newCrudData['traiter']=$Transactions->traiter;
                $newCrudData['verification']=$Transactions->verification;
                $newCrudData['rechercheetape']=$Transactions->rechercheetape;
                $newCrudData['heure']=$Transactions->heure;
                $newCrudData['identification_id']=$Transactions->identification_id;
                $newCrudData['controlleursacce_id']=$Transactions->controlleursacce_id;
                $newCrudData['carte_id']=$Transactions->carte_id;
                $newCrudData['cout']=$Transactions->cout;
                $newCrudData['ligne_id']=$Transactions->ligne_id;
                    $newCrudData['identifiants_sadge']=$Transactions->identifiants_sadge;
                $newCrudData['creat_by']=$Transactions->creat_by;
    
 try{ $newCrudData['carte']=$Transactions->carte->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['controlleursacce']=$Transactions->controlleursacce->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['identification']=$Transactions->identification->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ligne']=$Transactions->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Transactions->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Transactions->ville->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Create", 'entite' => 'Transactions','entite_cle' => $Transactions->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);


$response = $Transactions->toArray();




try{

foreach ($Transactions->extra_attributes["extra-data"] as $key=>$dat){
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


public function update(Request $request, Transaction $Transactions)
{
try{
$can=\App\Helpers\Helpers::can('Editer des transactions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$oldCrudData=[];

                $oldCrudData['bio_id']=$Transactions->bio_id;
                $oldCrudData['area_alias']=$Transactions->area_alias;
                $oldCrudData['card_no']=$Transactions->card_no;
                $oldCrudData['terminal_alias']=$Transactions->terminal_alias;
                $oldCrudData['emp_code']=$Transactions->emp_code;
                $oldCrudData['punch_date']=$Transactions->punch_date;
                $oldCrudData['punch_time']=$Transactions->punch_time;
                $oldCrudData['poste_id']=$Transactions->poste_id;
                $oldCrudData['ville_id']=$Transactions->ville_id;
                            $oldCrudData['etats']=$Transactions->etats;
                $oldCrudData['annuler']=$Transactions->annuler;
                $oldCrudData['type']=$Transactions->type;
                $oldCrudData['traiter']=$Transactions->traiter;
                $oldCrudData['verification']=$Transactions->verification;
                $oldCrudData['rechercheetape']=$Transactions->rechercheetape;
                $oldCrudData['heure']=$Transactions->heure;
                $oldCrudData['identification_id']=$Transactions->identification_id;
                $oldCrudData['controlleursacce_id']=$Transactions->controlleursacce_id;
                $oldCrudData['carte_id']=$Transactions->carte_id;
                $oldCrudData['cout']=$Transactions->cout;
                $oldCrudData['ligne_id']=$Transactions->ligne_id;
                    $oldCrudData['identifiants_sadge']=$Transactions->identifiants_sadge;
                $oldCrudData['creat_by']=$Transactions->creat_by;
    
 try{ $oldCrudData['carte']=$Transactions->carte->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['controlleursacce']=$Transactions->controlleursacce->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['identification']=$Transactions->identification->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['ligne']=$Transactions->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['poste']=$Transactions->poste->Selectlabel; }catch(\Throwable $e){}   try{ $oldCrudData['ville']=$Transactions->ville->Selectlabel; }catch(\Throwable $e){}  

$data=$request->all();
foreach ($request->allFiles() as $key=>$file){
$path=$file->storeAs(
'storage/uploads', "transactions"."-".$key."_".time().".".$file->extension()
);
$data[$key]= $path;
}


$champsRechercher=[
    'id',
    'bio_id',
    'area_alias',
    'card_no',
    'terminal_alias',
    'emp_code',
    'punch_date',
    'punch_time',
    'poste_id',
    'ville_id',
    'extra_attributes',
    'created_at',
    'updated_at',
    'etats',
    'annuler',
    'type',
    'traiter',
    'verification',
    'rechercheetape',
    'heure',
    'identification_id',
    'controlleursacce_id',
    'carte_id',
    'cout',
    'ligne_id',
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
    
    
                    'bio_id' => [
            //'required'
            ],
        
    
    
                    'area_alias' => [
            //'required'
            ],
        
    
    
                    'card_no' => [
            //'required'
            ],
        
    
    
                    'terminal_alias' => [
            //'required'
            ],
        
    
    
                    'emp_code' => [
            //'required'
            ],
        
    
    
                    'punch_date' => [
            //'required'
            ],
        
    
    
                    'punch_time' => [
            //'required'
            ],
        
    
    
                    'poste_id' => [
            //'required'
            ],
        
    
    
                    'ville_id' => [
            //'required'
            ],
        
    
    
    
    
    
                    'etats' => [
            //'required'
            ],
        
    
    
                    'annuler' => [
            //'required'
            ],
        
    
    
                    'type' => [
            //'required'
            ],
        
    
    
                    'traiter' => [
            //'required'
            ],
        
    
    
                    'verification' => [
            //'required'
            ],
        
    
    
                    'rechercheetape' => [
            //'required'
            ],
        
    
    
                    'heure' => [
            //'required'
            ],
        
    
    
                    'identification_id' => [
            //'required'
            ],
        
    
    
                    'controlleursacce_id' => [
            //'required'
            ],
        
    
    
                    'carte_id' => [
            //'required'
            ],
        
    
    
                    'cout' => [
            //'required'
            ],
        
    
    
                    'ligne_id' => [
            //'required'
            ],
        
    
    
    
                    'identifiants_sadge' => [
            //'required'
            ],
        
    
    
                    'creat_by' => [
            //'required'
            ],
        
    


], $messages = [

    
    
        'bio_id' => ['cette donnee est obligatoire'],

    
    
        'area_alias' => ['cette donnee est obligatoire'],

    
    
        'card_no' => ['cette donnee est obligatoire'],

    
    
        'terminal_alias' => ['cette donnee est obligatoire'],

    
    
        'emp_code' => ['cette donnee est obligatoire'],

    
    
        'punch_date' => ['cette donnee est obligatoire'],

    
    
        'punch_time' => ['cette donnee est obligatoire'],

    
    
        'poste_id' => ['cette donnee est obligatoire'],

    
    
        'ville_id' => ['cette donnee est obligatoire'],

    
    
    
    
    
        'etats' => ['cette donnee est obligatoire'],

    
    
        'annuler' => ['cette donnee est obligatoire'],

    
    
        'type' => ['cette donnee est obligatoire'],

    
    
        'traiter' => ['cette donnee est obligatoire'],

    
    
        'verification' => ['cette donnee est obligatoire'],

    
    
        'rechercheetape' => ['cette donnee est obligatoire'],

    
    
        'heure' => ['cette donnee est obligatoire'],

    
    
        'identification_id' => ['cette donnee est obligatoire'],

    
    
        'controlleursacce_id' => ['cette donnee est obligatoire'],

    
    
        'carte_id' => ['cette donnee est obligatoire'],

    
    
        'cout' => ['cette donnee est obligatoire'],

    
    
        'ligne_id' => ['cette donnee est obligatoire'],

    
    
    
        'identifiants_sadge' => ['cette donnee est obligatoire'],

    
    
        'creat_by' => ['cette donnee est obligatoire'],

    
])->validate();







$extra_data=array_diff($envoyer,$champsRechercher);











    







    

        if(array_key_exists("bio_id",$data)){


        if(!empty($data['bio_id'])){
        
            $Transactions->bio_id = $data['bio_id'];
        
        }

        }

    







    

        if(array_key_exists("area_alias",$data)){


        if(!empty($data['area_alias'])){
        
            $Transactions->area_alias = $data['area_alias'];
        
        }

        }

    







    

        if(array_key_exists("card_no",$data)){


        if(!empty($data['card_no'])){
        
            $Transactions->card_no = $data['card_no'];
        
        }

        }

    







    

        if(array_key_exists("terminal_alias",$data)){


        if(!empty($data['terminal_alias'])){
        
            $Transactions->terminal_alias = $data['terminal_alias'];
        
        }

        }

    







    

        if(array_key_exists("emp_code",$data)){


        if(!empty($data['emp_code'])){
        
            $Transactions->emp_code = $data['emp_code'];
        
        }

        }

    







    

        if(array_key_exists("punch_date",$data)){


        if(!empty($data['punch_date'])){
        
            $Transactions->punch_date = $data['punch_date'];
        
        }

        }

    







    

        if(array_key_exists("punch_time",$data)){


        if(!empty($data['punch_time'])){
        
            $Transactions->punch_time = $data['punch_time'];
        
        }

        }

    







    

        if(array_key_exists("poste_id",$data)){


        if(!empty($data['poste_id'])){
        
            $Transactions->poste_id = $data['poste_id'];
        
        }

        }

    







    

        if(array_key_exists("ville_id",$data)){


        if(!empty($data['ville_id'])){
        
            $Transactions->ville_id = $data['ville_id'];
        
        }

        }

    







    







    







    







    

        if(array_key_exists("etats",$data)){


        if(!empty($data['etats'])){
        
            $Transactions->etats = $data['etats'];
        
        }

        }

    







    

        if(array_key_exists("annuler",$data)){


        if(!empty($data['annuler'])){
        
            $Transactions->annuler = $data['annuler'];
        
        }

        }

    







    

        if(array_key_exists("type",$data)){


        if(!empty($data['type'])){
        
            $Transactions->type = $data['type'];
        
        }

        }

    







    

        if(array_key_exists("traiter",$data)){


        if(!empty($data['traiter'])){
        
            $Transactions->traiter = $data['traiter'];
        
        }

        }

    







    

        if(array_key_exists("verification",$data)){


        if(!empty($data['verification'])){
        
            $Transactions->verification = $data['verification'];
        
        }

        }

    







    

        if(array_key_exists("rechercheetape",$data)){


        if(!empty($data['rechercheetape'])){
        
            $Transactions->rechercheetape = $data['rechercheetape'];
        
        }

        }

    







    

        if(array_key_exists("heure",$data)){


        if(!empty($data['heure'])){
        
            $Transactions->heure = $data['heure'];
        
        }

        }

    







    

        if(array_key_exists("identification_id",$data)){


        if(!empty($data['identification_id'])){
        
            $Transactions->identification_id = $data['identification_id'];
        
        }

        }

    







    

        if(array_key_exists("controlleursacce_id",$data)){


        if(!empty($data['controlleursacce_id'])){
        
            $Transactions->controlleursacce_id = $data['controlleursacce_id'];
        
        }

        }

    







    

        if(array_key_exists("carte_id",$data)){


        if(!empty($data['carte_id'])){
        
            $Transactions->carte_id = $data['carte_id'];
        
        }

        }

    







    

        if(array_key_exists("cout",$data)){


        if(!empty($data['cout'])){
        
            $Transactions->cout = $data['cout'];
        
        }

        }

    







    

        if(array_key_exists("ligne_id",$data)){


        if(!empty($data['ligne_id'])){
        
            $Transactions->ligne_id = $data['ligne_id'];
        
        }

        }

    







    







    

        if(array_key_exists("identifiants_sadge",$data)){


        if(!empty($data['identifiants_sadge'])){
        
            $Transactions->identifiants_sadge = $data['identifiants_sadge'];
        
        }

        }

    







    

        if(array_key_exists("creat_by",$data)){


        if(!empty($data['creat_by'])){
        
            $Transactions->creat_by = $data['creat_by'];
        
        }

        }

    










$dat=[];

foreach ($extra_data as $d) {

$dat[$d] = $data[$d];

}
try {

$Transactions->extra_attributes["extra-data"] = $dat;


} catch (\Throwable $e) {
}



if(
class_exists('\App\Http\Extras\TransactionExtras') &&
method_exists('\App\Http\Extras\TransactionExtras', 'beforeSaveUpdate')
){
\App\Http\Extras\TransactionExtras::beforeSaveUpdate($request,$Transactions);
}

$canSave=true;
if (
class_exists('\App\Http\Extras\TransactionExtras') &&
method_exists('\App\Http\Extras\TransactionExtras', 'canUpdate')
) {
try{
$canSave=\App\Http\Extras\TransactionExtras::canUpdate($request, $Transactions);
}catch (\Throwable $e){

}

}


if($canSave){
$Transactions->save();
}else{
return response()->json($Transactions, 200);

}


$Transactions=Transaction::find($Transactions->id);



$newCrudData=[];

                $newCrudData['bio_id']=$Transactions->bio_id;
                $newCrudData['area_alias']=$Transactions->area_alias;
                $newCrudData['card_no']=$Transactions->card_no;
                $newCrudData['terminal_alias']=$Transactions->terminal_alias;
                $newCrudData['emp_code']=$Transactions->emp_code;
                $newCrudData['punch_date']=$Transactions->punch_date;
                $newCrudData['punch_time']=$Transactions->punch_time;
                $newCrudData['poste_id']=$Transactions->poste_id;
                $newCrudData['ville_id']=$Transactions->ville_id;
                            $newCrudData['etats']=$Transactions->etats;
                $newCrudData['annuler']=$Transactions->annuler;
                $newCrudData['type']=$Transactions->type;
                $newCrudData['traiter']=$Transactions->traiter;
                $newCrudData['verification']=$Transactions->verification;
                $newCrudData['rechercheetape']=$Transactions->rechercheetape;
                $newCrudData['heure']=$Transactions->heure;
                $newCrudData['identification_id']=$Transactions->identification_id;
                $newCrudData['controlleursacce_id']=$Transactions->controlleursacce_id;
                $newCrudData['carte_id']=$Transactions->carte_id;
                $newCrudData['cout']=$Transactions->cout;
                $newCrudData['ligne_id']=$Transactions->ligne_id;
                    $newCrudData['identifiants_sadge']=$Transactions->identifiants_sadge;
                $newCrudData['creat_by']=$Transactions->creat_by;
    
 try{ $newCrudData['carte']=$Transactions->carte->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['controlleursacce']=$Transactions->controlleursacce->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['identification']=$Transactions->identification->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ligne']=$Transactions->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Transactions->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Transactions->ville->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Update", 'entite' => 'Transactions','entite_cle' => $Transactions->id, 'ancien' => json_encode($oldCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);

$response = $Transactions->toArray();




try{

foreach ($Transactions->extra_attributes["extra-data"] as $key=>$dat){
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
public function delete(Request $request, Transaction $Transactions)
{
try{
$can=\App\Helpers\Helpers::can('Supprimer des transactions');

if(!$can){
return response()->json([], 200);
}
}catch (\Throwable $e){}

$newCrudData=[];

                $newCrudData['bio_id']=$Transactions->bio_id;
                $newCrudData['area_alias']=$Transactions->area_alias;
                $newCrudData['card_no']=$Transactions->card_no;
                $newCrudData['terminal_alias']=$Transactions->terminal_alias;
                $newCrudData['emp_code']=$Transactions->emp_code;
                $newCrudData['punch_date']=$Transactions->punch_date;
                $newCrudData['punch_time']=$Transactions->punch_time;
                $newCrudData['poste_id']=$Transactions->poste_id;
                $newCrudData['ville_id']=$Transactions->ville_id;
                            $newCrudData['etats']=$Transactions->etats;
                $newCrudData['annuler']=$Transactions->annuler;
                $newCrudData['type']=$Transactions->type;
                $newCrudData['traiter']=$Transactions->traiter;
                $newCrudData['verification']=$Transactions->verification;
                $newCrudData['rechercheetape']=$Transactions->rechercheetape;
                $newCrudData['heure']=$Transactions->heure;
                $newCrudData['identification_id']=$Transactions->identification_id;
                $newCrudData['controlleursacce_id']=$Transactions->controlleursacce_id;
                $newCrudData['carte_id']=$Transactions->carte_id;
                $newCrudData['cout']=$Transactions->cout;
                $newCrudData['ligne_id']=$Transactions->ligne_id;
                    $newCrudData['identifiants_sadge']=$Transactions->identifiants_sadge;
                $newCrudData['creat_by']=$Transactions->creat_by;
    
 try{ $newCrudData['carte']=$Transactions->carte->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['controlleursacce']=$Transactions->controlleursacce->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['identification']=$Transactions->identification->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ligne']=$Transactions->ligne->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['poste']=$Transactions->poste->Selectlabel; }catch(\Throwable $e){}   try{ $newCrudData['ville']=$Transactions->ville->Selectlabel; }catch(\Throwable $e){}  
DB::table('surveillances')->insert(['user_id'=>Auth::id(),'action' => "Delete", 'entite' => 'Transactions','entite_cle' => $Transactions->id, 'ancien' => json_encode($newCrudData),'nouveau'=>json_encode($newCrudData),'created_at'=>now()]);



$canSave=true;
if (
class_exists('\App\Http\Extras\TransactionExtras') &&
method_exists('\App\Http\Extras\TransactionExtras', 'canDelete')
) {
try{
$canSave=\App\Http\Extras\TransactionExtras::canDelete($request, $Transactions);
}catch (\Throwable $e){

}

}



if($canSave){
$Transactions->delete();
}else{
return response()->json($Transactions, 200);

}




return response()->json([], 200);


}


public function action(Request $request){




$action=$request->get('action','aucun');
$actioner=new \App\Http\Actions\TransactionsActions();
$response=$actioner->$action($request);


return response()->json($response, 202);
}

}
