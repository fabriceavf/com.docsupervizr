<?php

namespace App\Http\Actions;

use App\Http\Pointages;
use App\Models\Pointage;
use App\Models\Ventilation;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VentilationsActions
{

    public function __construct()
    {
        Carbon::setLocale('fr');
    }


    public function classeElement()
    {

        $intervals = [
            5 => 10,
            15 => 25,
            30 => 70,
        ];
        $group = [];

        $allBorne = [];


        $array1 = range(1, rand(50, 100), rand(1, 3));
        $array2 = range(1, rand(50, 100), rand(1, 3));
        $array = array_merge($array1, $array2);
        $element = array_unique($array);
        foreach ($element as $el) {
            $find = false;
            foreach ($intervals as $key => $interval) {
                $allBorne[] = $key;
                $allBorne[] = $interval;
                $allBorne = array_unique($allBorne);
                if ($key <= $el && $el <= $interval) {
                    $find = true;
                    $group[$key][] = $el;
                }
            }
            if (!$find) {
                $group['vide'][] = $el;
            }
        }


        $nonCLasser = $group['vide'];

//        systeme de classement des enfants
        foreach ($nonCLasser as $ele) {
            $encadreur = $this->encadre($el, $allBorne);
            $fictifParent = 'aucun';
            $distanceParent = "aucun";

            foreach ($allBorne as $borne) {
                $distance = abs($borne - $ele);
                if ($distanceParent == "aucun" || $distance < $distanceParent) {
                    $distanceParent = $distance;
                    $fictifParent = $borne;
                }
            }


            foreach ($intervals as $key => $interval) {
                if ($key == $fictifParent || $fictifParent == $interval) {
//                    dd('voici le parents fictif',$fictifParent);

                    $group[$key][] = $ele;
                }
            }


        }

        dd($group, $intervals, $element, $allBorne);


    }

    public function encadre($el, $borne)
    {
        $max = $el;
        $min = 0;
//        foreach ($borne )

        dd($el, $borne);
    }

    public function ventiler(Request $request)
    {
//        return [12];
        Pointages::ventiller();
    }

    public function ventiler1(Request $request)
    {

        DB::table('pointages')->truncate();
        $requestLocal = Request::create('', 'GET');
        $point = new PointagesActions();
        $point->actualise($requestLocal);

        $pointages = Pointage::all();
        $pointagesGrouperSemaine = $pointages->groupBy(function ($item) {
//            dd($item->debut_prevu);
            return Carbon::createFromFormat('Y-m-d H:i:s', $item->debut_prevu)->format('Y-\wW');
        });


//        insertion des pointages
        foreach ($pointagesGrouperSemaine as $key => $pointageParSemaine) {
//             dd($key,$pointageParSemaine->user_id);

            foreach ($pointageParSemaine as $point) {
                $semaine = $key;
                $semaine = Str::lower($semaine);
                $semaine = explode('-', $semaine);

                $year = $semaine[0];
                $week = Str::replace('w', '', $semaine[1]);
                $allDate = [];
                $date = Carbon::now();

                $date->setISODate($year, $week);
                for ($i = 0; $i < 7; $i++) {
                    $newdate = clone($date);
                    $allDate[$i] = $newdate->format('Y-m-d');
                    $date->addDay(1);
                }

//                on creer une ventilation pour la semaine a lusers
                $userVentilation = Ventilation::firstOrCreate([
                    'user_id' => $point->user_id,
                    'semaine' => $key,
                ]);
                $volumeTotalCollecter = 0;
                $volumeTotalProgrammer = 0;
                $volumeTotalDepassement = 0;
                $type = 'Jour';
                // pour chaque jours de la semaine on enregistre le volume horaire
                foreach ($allDate as $date) {
                    $actual = clone(Carbon::parse($date));
                    $actual->setHour(12);
                    $actual->setMinute(12);

//


                    $joursDate = $actual->dayName . '_date';
                    $joursPointage = $actual->dayName . '_pointage';
                    $joursCollecter = $actual->dayName . '_collecter';
                    $joursProgrammer = $actual->dayName . '_programmer';
                    $joursDepassement = $actual->dayName . '_depassement';
                    $joursRetard = $actual->dayName . '_retard';
                    //                    on recupere les pointages de la personne en ce jours

                    $pointageDuJours = $pointages
                        ->where('user_id', $point->user_id)
                        ->filter(function ($item) use ($actual) {
                            $interDebut = clone(Carbon::parse($item->debut_prevu));
                            $interDebut->setHour(12);
                            $interDebut->setMinute(12);
//                            dd($interDebut,$actual);
                            return $interDebut->diffInDays($actual) == 0;
                        })
                        ->first();
//                    dd($pointageDuJours);
                    $ecartRealiserDansLaJournee = 0;
                    $ecartNormalDansLaJournee = 0;
                    $pointageDuJourId = 0;
                    if ($pointageDuJours) {
                        if (!empty($pointageDuJours->debut_realise) && !empty($pointageDuJours->fin_realise)) {
                            $deb = Carbon::parse($pointageDuJours->debut_realise);
                            $fin = Carbon::parse($pointageDuJours->fin_realise);
                            $ecartRealiserDansLaJournee = $fin->diffInMinutes($deb);

                            $heureDeb = intval($deb->format('H'));
                            $heureFin = intval($fin->format('H'));
                            if ($heureDeb >= $heureFin) {
                                $type = 'Nuit';

                            }

                        }


                        $deb_programmer = Carbon::parse($pointageDuJours->debut_prevu);
                        $fin_programmer = Carbon::parse($pointageDuJours->fin_prevu);
                        $ecartNormalDansLaJournee = $fin_programmer->diffInMinutes($deb_programmer);
                        $pointageDuJourId = $pointageDuJours->id;
//                       dd()
//                       dd($pointageDuJours->toArray(),$deb,$fin,$deb_programmer,$fin_programmer, $ecartNormalDansLaJournee);
                    }

                    $userVentilation->$joursPointage = $pointageDuJourId;

                    $depassement = intval($ecartRealiserDansLaJournee) - intval($ecartNormalDansLaJournee);

                    $userVentilation->$joursCollecter = $ecartRealiserDansLaJournee;
                    $userVentilation->$joursDate = $actual->format('Y-m-d');
                    $userVentilation->$joursProgrammer = $ecartNormalDansLaJournee;
                    $userVentilation->$joursDepassement = $depassement > 0 ? $depassement : 0;
                    $userVentilation->$joursRetard = $depassement > 0 ? 0 : abs($depassement);
//                   on doit determiner le volume horaire journalier normal enfin de lenregistrer
                    $volumeTotalCollecter += $ecartRealiserDansLaJournee;
                    $volumeTotalProgrammer += $ecartNormalDansLaJournee;
                    $volumeTotalDepassement += $userVentilation->$joursDepassement;


                }

                $userVentilation->total_colecter = $volumeTotalCollecter;
                $userVentilation->total_programmer = $volumeTotalProgrammer;
                $depas = intval($userVentilation->total_colecter) - intval($userVentilation->total_programmer);
                $userVentilation->total_depassement = $depas > 0 ? $depas : 0;
//                dd($point);
                try {
                    $userVentilation->programmation_id = $point->programme->programmation_id;

                } catch (Exception $e) {

                }


//                $userVentilation->total_nomal = $allVolumeProgrammer;
                $depassement = $userVentilation->total_depassement / 60;
                $hs15 = 0;
                $hs26 = 0;
                while ($depassement > 0 && $hs15 < 8) {

                    if ($depassement > 1) {
                        $hs15++;
                        $depassement--;
                    } else {
                        $hs15 += $depassement;
                        $depassement -= $depassement;
                    }

                }
                while ($depassement > 0) {
                    if ($depassement > 1) {
                        $hs26++;
                        $depassement--;
                    } else {
                        $hs26 += $depassement;
                        $depassement -= $depassement;
                    }


                }
                $userVentilation->hs15 = $hs15 * 60;
                $userVentilation->hs26 = $hs26 * 60;

//                if ($type == 'Jour') {
//                    $userVentilation->hs15 = $userVentilation->total_depassement * 1.15;
//
//                }
//                if ($type == 'Nuit') {
//                    $userVentilation->hs26 = $userVentilation->total_depassement * 1.26;
//
//                }
                $userVentilation->save();
            }


        }


        return ['cest bon'];
    }
//    public function allVentilation(Request $request)
//    {
//        $programmes = Programme::all();
//        foreach ($programmes as $p) {
//            $horaire1 = Horaire::find($p->dimanche);
//            $horaire2 = Horaire::find($p->lundi);
//            $horaire3 = Horaire::find($p->mardi);
//            $horaire4 = Horaire::find($p->mercredi);
//            $horaire5 = Horaire::find($p->jeudi);
//            $horaire6 = Horaire::find($p->vendredi);
//            $horaire7 = Horaire::find($p->samedi);
//            if (isset($horaire1)) {
////                dd($horaire1);
//                Pointage::create([
//                    "debut_prevu" => date("Y-m-d", strtotime('sunday ' . $p->programmation->semaine)) . ' ' . $horaire1->debut,
//                    "fin_prevu" => date("Y-m-d", strtotime('sunday ' . $p->programmation->semaine)) . ' ' . $horaire1->fin,
//                    "faction_horaire" => $horaire1->type,
//                    "user_id" => $p->user_id,
//                    "programme_id" => $p->id,
//                    "horaire_id" => $horaire1->id,
//                    "emp_code" => $p->user->emp_code,
//                    "est_attendu" => '1',
//                ]);
//            }
//
//            if (isset($horaire2)) {
//                Pointage::create([
//                    "debut_prevu" => date("Y-m-d", strtotime('monday ' . $p->programmation->semaine)) . ' ' . $horaire2->debut,
//                    "fin_prevu" => date("Y-m-d", strtotime('monday ' . $p->programmation->semaine)) . ' ' . $horaire2->fin,
//                    "faction_horaire" => $horaire2->type,
//                    "user_id" => $p->user_id,
//                    "programme_id" => $p->id,
//
//                    "horaire_id" => $horaire2->id,
//                    "emp_code" => $p->user->emp_code,
//                    "est_attendu" => '1',
//                ]);
//            }
//
//            if (isset($horaire3)) {
//                Pointage::create([
//                    "debut_prevu" => date("Y-m-d", strtotime('tuesday ' . $p->programmation->semaine)) . ' ' . $horaire3->debut,
//                    "fin_prevu" => date("Y-m-d", strtotime('tuesday ' . $p->programmation->semaine)) . ' ' . $horaire3->fin,
//                    "faction_horaire" => $horaire3->type,
//                    "user_id" => $p->user_id,
//                    "programme_id" => $p->id,
//
//                    "horaire_id" => $horaire3->id,
//                    "emp_code" => $p->user->emp_code,
//                    "est_attendu" => '1',
//                ]);
//            }
//
//            if (isset($horaire4)) {
//                Pointage::create([
//                    "debut_prevu" => date("Y-m-d", strtotime('wednesday ' . $p->programmation->semaine)) . ' ' . $horaire4->debut,
//                    "fin_prevu" => date("Y-m-d", strtotime('wednesday ' . $p->programmation->semaine)) . ' ' . $horaire4->fin,
//                    "faction_horaire" => $horaire4->type,
//                    "user_id" => $p->user_id,
//                    "programme_id" => $p->id,
//
//                    "horaire_id" => $horaire4->id,
//                    "emp_code" => $p->user->emp_code,
//                    "est_attendu" => '1',
//                ]);
//            }
//
//            if (isset($horaire5)) {
//                Pointage::create([
//                    "debut_prevu" => date("Y-m-d", strtotime('thursday ' . $p->programmation->semaine)) . ' ' . $horaire5->debut,
//                    "fin_prevu" => date("Y-m-d", strtotime('thursday ' . $p->programmation->semaine)) . ' ' . $horaire5->fin,
//                    "faction_horaire" => $horaire5->type,
//                    "user_id" => $p->user_id,
//                    "programme_id" => $p->id,
//
//                    "horaire_id" => $horaire5->id,
//                    "emp_code" => $p->user->emp_code,
//                    "est_attendu" => '1',
//                ]);
//            }
//
//            if (isset($horaire6)) {
//                Pointage::create([
//                    "debut_prevu" => date("Y-m-d", strtotime('friday ' . $p->programmation->semaine)) . ' ' . $horaire6->debut,
//                    "fin_prevu" => date("Y-m-d", strtotime('friday' . $p->programmation->semaine)) . ' ' . $horaire6->fin,
//                    "faction_horaire" => $horaire6->type,
//                    "user_id" => $p->user_id,
//                    "programme_id" => $p->id,
//
//                    "horaire_id" => $horaire6->id,
//                    "emp_code" => $p->user->emp_code,
//                    "est_attendu" => '1',
//                ]);
//            }
//
//            if (isset($horaire7)) {
//                Pointage::create([
//                    "debut_prevu" => date("Y-m-d", strtotime('saturday ' . $p->programmation->semaine)) . ' ' . $horaire7->debut,
//                    "fin_prevu" => date("Y-m-d", strtotime('saturday ' . $p->programmation->semaine)) . ' ' . $horaire7->fin,
//                    "faction_horaire" => $horaire7->type,
//                    "user_id" => $p->user_id,
//                    "programme_id" => $p->id,
//
//                    "horaire_id" => $horaire7->id,
//                    "emp_code" => $p->user->emp_code,
//                    "est_attendu" => '1',
//                ]);
//            }
//
//        }
//
//
//
//        return ['cest bon'];
//    }
}
