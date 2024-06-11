<?php

namespace App\Http\Controllers;

use App\Models\Programmation;
use App\Models\Programme;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProgrammationController extends Controller
{
//    public function index()
//    {
//        return response()
//        ->json($Table = Programmation::orderBy('semaine', 'DESC')->get())
//        ->withTaches($Taches = Tache::orderBy('libelle', 'ASC')->get())
//        ->withEmployes($Employes = User::where('type', 'employe')->orderBy('matricule', 'ASC')->get())
//        ;
//    }
    public function index()
    {
        return response()->json($Table = Programmation::orderBy('semaine', 'DESC')->get());
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'semaine' => ['required'],
            'superviseur' => ['required'],
            'tache_id' => ['required'],
        ], $messages = [
            'semaine.required' => 'La semaine est obligatoire.',
            'superviseur.required' => 'Le superviseur est obligatoire.',
            'tache_id.required' => 'Le tache est obligatoire.'
        ])->validate();

        $line = Programmation::create($request->all());
        $line->statut = 'En attente de validation';
        $line->save();

        return $line;
    }

    public function destroy($id)
    {
        $line = Programmation::find($id);
        $line->delete();
    }

    public function get_programmes($id)
    {
        $line = Programmation::find($id);
        return $line->programmes;
    }

    public function store_programme(Request $request)
    {
        Validator::make($request->all(), [
            'dimanche' => ['required'],
            'lundi' => ['required'],
            'mardi' => ['required'],
            'mercredi' => ['required'],
            'jeudi' => ['required'],
            'vendredi' => ['required'],
            'samedi' => ['required'],
            'programmation_id' => ['required'],
            'user_id' => ['required'],
        ], $messages = [
            'programmation_id.required' => 'La programmation_id est obligatoire.',
            'user_id.required' => 'Le user_id est obligatoire.',
        ])->validate();

        $line = Programme::create($request->all());

        return $line;
    }

    public function update_programme(Request $request, $id)
    {
        Validator::make($request->all(), [
            'dimanche' => ['required'],
            'lundi' => ['required'],
            'mardi' => ['required'],
            'mercredi' => ['required'],
            'jeudi' => ['required'],
            'vendredi' => ['required'],
            'samedi' => ['required'],
            'programmation_id' => ['required'],
            'user_id' => ['required'],
        ], $messages = [
            'programmation_id.required' => 'La programmation_id est obligatoire.',
            'user_id.required' => 'Le user_id est obligatoire.',
        ])->validate();

        $line = Programme::find($id);
        $line->update($request->all());

        return $line;
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'semaine' => ['required'],
            'superviseur' => ['required'],
            'tache_id' => ['required'],
        ], $messages = [
            'semaine.required' => 'La semaine est obligatoire.',
            'superviseur.required' => 'Le superviseur est obligatoire.',
            'tache_id.required' => 'Le tache est obligatoire.'
        ])->validate();

        $line = Programmation::find($id);
        $line->update($request->all());

        return $line;
    }

    public function destroy_programme($id)
    {
        $line = Programme::find($id);
        $line->delete();
    }

    public function valider($id)
    {

        $line = Programmation::find($id);
//
//        $semaine=Str::lower($line->semaine);
//        $semaine=explode('-',$semaine);
//
//        $year=$semaine[0];
//        $week=Str::replace('w','',$semaine[1]);
//        $allDate=[];
//        $date = Carbon::now();
//        $date->setISODate($year,$week);
//        for($i=0;$i<7;$i++){
//
//            $allDate[$i]=clone($date);
//            $date->addDay(1);
//        }
////        foreach ($allDate as $key=>$dat){
////            dump($dat->format('Y-m-d H:i:s'));
////        }
//
//        $programmes=$line->programmes;
//        $allForUsers=[];
//
//        foreach ($programmes as $prog){
//            $user=User::find($prog->user_id);
//
//            $allForDays=[];
//            foreach ($allDate as $key=>$dat){
////                on recupere les taches du programe
////                dump($dat->format('Y-m-d H:i:s'));
//                $jourActuel=$dat->locale('fr_Fr')->dayName;
//                $horaires=Horaire::find($prog[$jourActuel]);
//
////                    dd($type);
////                dump($horaires,$prog[$jourActuel]);
//                if(!empty($horaires) && !empty($user)){
//                    $type=Str::lower($horaires->type);
//                    $_debut="";
//                    $date=clone($dat);
//                    $date->setHour(0);
//                    $date->setSecond(0);
//                    $date->setMinute(0);
//                    $debut=explode(':',$horaires->debut);
//                    $marge_debut=explode(':',$horaires->ecart_debut);
//                    $date->addHour($debut[0]);
////                        $date->subMinute($marge_debut[1]);
//                    $_debut=clone($date);
////                dd($_debut->format('Y-m-d H:i:s'),$_debut->format('Y-m-d H:i:s'));
//
//                    $_fin="";
//                    $date=clone($dat);
//                    $date->setHour(0);
//                    $date->setSecond(0);
//                    $date->setMinute(0);
//                    if($type=='nuit'){
//                        $date->addDay(1);
//                    }
//                    $fin=explode(':',$horaires->fin);
//                    $marge_fin=explode(':',$horaires->ecart_fin);
//                    $date->addHour($fin[0]);
//
////                        $date->addMinute($marge_fin[1]);
//                    $_fin=clone($date);
//
//                    $pointage['pointeuse']="Non connu";
//                    $pointage['Lieu']="Non connu";
//
//
//                    $pointage['debut_prevu']=$_debut->format('Y-m-d H:i:s');
//                    $pointage['fin_prevu']=$_fin->format('Y-m-d H:i:s');
//                    $pointage['_debut_prevu']=$_debut->addMinute($marge_debut[1])->format('Y-m-d H:i:s');
//                    $pointage['_fin_prevu']=$_fin->subMinute($marge_fin[1])->format('Y-m-d H:i:s');
////                        $pointage['_prog_']=[$prog->toArray(),$line->toArray()];
//                    $pointage['faction_horaire']='Non defini';
//                    $pointage['debut_realise']=Carbon::now()->setISODate(1999,1)->format('Y-m-d H:i:s');
//                    $pointage['fin_realise']=Carbon::now()->setISODate(1999,1)->format('Y-m-d H:i:s');;
//                    $pointage['volume_realise']='Non defini';
//                    $pointage['emp_code']=$user->emp_code;
//                    $pointage['actif']=false;
//                    $pointage['est_attendu']=true;
//                    $pointage['est_valide']=false;
//                    $pointage['user_id']=$prog->user_id;
//
//                    $allForDays[$dat->locale('fr_Fr')->dayName]=$pointage;
//
//
//                }
//
//
//
//
//
//            }
//            $allForUsers[$prog->user_id]=$allForDays;
//
//
//        }
//
//
//
//
//        foreach ($allForUsers as $user=>$pointage){
//
//            foreach ($pointage as $point){
//                $_debut=$point['_debut_prevu'];
//                $_fin=$point['_fin_prevu'];
////                    $_prog=$point['_prog_'];
//                unset($point['_debut_prevu']);
//                unset($point['_fin_prevu']);
////                    unset($point['_prog_']);
//                $exist=Pointage::where([
//                    'user_id'=>$point['user_id'],
//                    'debut_prevu'=>$point['debut_prevu'],
//                    'fin_prevu'=>$point['fin_prevu'],
//                ])->first();
//                if(empty($exist)){
//                    Pointage::insert($point);
//                    $exist=Pointage::where([
//                        'user_id'=>$point['user_id'],
//                        'debut_prevu'=>$point['debut_prevu'],
//                        'fin_prevu'=>$point['fin_prevu'],
//                    ])->first();
//
//                }
//                $exist->emp_code=$point['emp_code'];
//
//
//
//                $exist->extra_attributes->programation_id=$line->id;
//                $exist->extra_attributes->debutAuthorisez=$_debut;
//                $exist->extra_attributes->finAuthorisez=$_fin;
////                    $exist->extra_attributes->programme=$_prog;
//                $exist->save();
//
//            }
//        }
//
////        dd($allForUsers);


        $line->statut = 'Valider';
        $line->save();


        DB::beginTransaction();

        try {

            DB::commit();
            // all good
        } catch (Exception $e) {
            DB::rollback();
            // something went wrong
        }

        return $line;
    }

    public function dupliquer($id)
    {
        $line = Programmation::find($id);
        $programes = $line->programmes->map(function ($data) {
            $prog = $data->toArray();
            unset($prog['id']);
            unset($prog['created_at']);
            unset($prog['deleted_at']);
            unset($prog['programmation_id']);
            return $prog;
        });
        $newLine = $line->replicate();
        $newLine->statut = 'En attente de validation';
        $newLine->save();
//        dd($programes->toArray());
        foreach ($programes as $prog) {
            $newLine->programmes()->create($prog);
        }


        return $newLine;
    }
}
