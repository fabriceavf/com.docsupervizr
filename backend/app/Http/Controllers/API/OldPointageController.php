<?php

namespace App\Http\Controllers\API;


use App\Exports\RapportExport;
use App\Exports\VentilationsExport;
use App\Http\Controllers\Controller;
use App\Models\Poste;
use App\Models\Programmation;
use App\Models\Programme;
use App\Models\Transaction;
use DateTime;
use Elibyy\TCPDF\TCPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

// use Knp\Snappy\Pdf;

class OldPointageController extends Controller
{
    public function downloads($filename)
    {
        $file = storage_path("app/storage/uploads/{
    $filename}");

        return Response::download($file);
    }

    public function download(Request $request)
    {
        $file = $request->get('file');

        // if (file_exists($file)) {

        // return Response::download($file);
        // $fileName = 'purchase_files.xls';


        // } else {
        //     return abort(404); // Fichier non trouvé

        // }

        // $rapport=[];
        // $allDate=[];
        $lien = Str::replace('\\', '/', $file);
//        $lien = URL::asset('uploads' . $filename);

        $lien = Str::replace('https', 'http', $lien);
        $lien = Str::replace('http', 'https', $lien);
        // Excel::store(new RapportExport($rapport, $allDate), $filename, 'upload');
        // dd($lien);

        return $lien;
    }

    protected function assoc_pointages()
    {
        $derniere_trans = Transaction::orderBy('punch_time', 'DESC')->limit(1)->get('punch_time');
        if (isset($derniere_trans[0]['punch_time'])) {
            $response = Http::get('http://vps-77244.fhnet.fr/zkbiotime/api/read.php?depuis=' . strtotime($derniere_trans[0]['punch_time']));
        } else $response = Http::get('http://vps-77244.fhnet.fr/zkbiotime/api/read.php');

        foreach ($response->object() as $p) {
            Transaction::create([
                "bio_id" => $p->id,
                "punch_time" => $p->punch_time,
                "area_alias" => $p->area_alias,
                "first_name" => $p->first_name,
                "last_name" => $p->last_name,
                "card_no" => $p->card_no,
                "terminal_alias" => $p->terminal_alias,
                "emp_code" => $p->emp_code,
                "punch_date" => date('Y-m-d', strtotime($p->punch_time))
            ]);
        }

        return 'Actualisation terminé';
    }

    protected function getMatrice(Request $request)
    {
        $debut = $request->get('date_debut');
        $fin = $request->get('date_fin');

        $id = "matrice_excel_" . Str::uuid()->toString() . '_unique.xlsx';
        $lien = public_path() . '/upload/' . $id;
        $lien = Str::replace('\\', '/', $lien);
        $lien = URL::asset('/upload/' . $id);
        $lien = Str::replace('https', 'http', $lien);
        $lien = Str::replace('http', 'https', $lien);
        Excel::store(new MatricesFilesExport($debut, $fin), $id, 'upload');
        return $lien;
    }

    protected function getRapport(Request $request)
    {
        if (
            $request->has('users') &&
            $request->has('debut') &&
            $request->has('fin') &&
            $request->has('libelle')
        ) {
            $users = $request->get('users');
            $debut = $request->get('debut');
            $fin = $request->get('fin');
            $libelle = $request->get('libelle');
            $debut = $debut . ' ' . '00:00';
            $fin = $fin . ' ' . '23:59';
            $allDate = $this->displayDates($debut, $fin, 'Y-m-d');
            $rapport = [];
            $allUsers = DB::table('users')
                ->whereIn("id", $users)
                ->get();
            $allPointages = DB::table('transactions')->join('users', 'users.num_badge', '=', 'transactions.emp_code')
                ->whereRaw("transactions.punch_time BETWEEN '$debut' AND '$fin'")
                ->whereIn("users.id", $users)
                ->select([
                    'users.id as user_id',
                    'transactions.punch_date as date',
                ])
                ->get();
            foreach ($users as $user) {
                $userSelect = $allUsers->filter(function ($data) use ($user) {
                    return intval($data->id) == $user;
                });
                if ($userSelect->count() > 0) {
                    $agent = $userSelect->first();
                    $rap = [];
                    $rap['nom'] = $agent->nom;
                    $rap['prenom'] = $agent->prenom;
                    $rap['matricule'] = $agent->matricule;
                    $allPresent = 0;
                    $allAbscent = 0;
                    foreach ($allDate as $date) {
                        $isPresent = 0;
                        $pointagePresence = $allPointages->filter(function ($data) use ($user, $date) {
                            return intval($data->user_id) == $user && $data->date == $date;
                        });
                        if ($pointagePresence->count() > 0) {
                            $isPresent = 1;
                            $allPresent++;
                        } else {
                            $allAbscent++;
                        }

                        $rap[$date] = $isPresent;
                    }

                    $rap['allPresent'] = $allPresent;
                    $rap['allAbscent'] = $allAbscent;
                    $rapport[] = $rap;
                }
            }

            $id = "rapport_" . Str::uuid()->toString() . '_unique.xlsx';
            $lien = public_path() . '/upload/' . $id;
            $lien = Str::replace('\\', '/', $lien);
            // dd($lien);

            $lien = URL::asset('/upload/' . $id);
            $lien = Str::replace('https', 'http', $lien);
            $lien = Str::replace('http', 'https', $lien);

            Excel::store(new RapportExport($rapport, $allDate), $id, 'upload');

            return $lien;
        }
    }

    private function displayDates($date1, $date2, $format = 'd-m-Y')
    {
        $dates = array();
        $current = strtotime($date1);
        $date2 = strtotime($date2);
        $stepVal = '+1 day';
        while ($current <= $date2) {
            $dates[] = date($format, $current);
            $current = strtotime($stepVal, $current);
        }
        return $dates;
    }

    protected function getVentillations(Request $request)
    {

        if (
            $request->has('debut') &&
            $request->has('fin')
        ) {
            $debut = $request->get('debut');
            $fin = $request->get('fin');

            $debut = $debut . ' ' . '00:00';
            $fin = $fin . ' ' . '23:59';

            $ventilationsData = \App\Http\Utils::generateVentillations($debut, $fin);


            $id = "rapport_" . Str::uuid()->toString() . '_unique.xlsx';
            Excel::store(new VentilationsExport($ventilationsData), $id, 'upload');

            $lien = public_path() . '/upload/' . $id;
            $lien = Str::replace('\\', '/', $lien);
            $lien = URL::asset('/upload/' . $id);
            $lien = Str::replace('https', 'http', $lien);
            if (!Str::is('*127.0.0.1*', $lien)) {
                $lien = Str::replace('http', 'https', $lien);
            }
            return $lien;
        }
    }

    protected function imprimmeListing(Request $request)
    {


        $id = $request->get('id');
        $listing = Programmation::find($id);
        $programme = $listing->programmationsusers->pluck('programmes')->flatten();
        $horaire = $programme->pluck('horaire')->flatten();
        $poste = $horaire->pluck('parentId');
        $postes = Poste::findMany($poste);
// dd($postes);

        $sites = $postes->pluck('site')->unique('id');
        $clients = $sites->pluck('client')->unique('id');
        // dd($sites);

        $pageConfigs = ['showMenu' => false, 'pageHeader' => false];

        $timestamp = strtotime($listing->date_debut); // Remplacez ceci par la date que vous souhaitez formater
        $date = strftime('%d %B %Y', $timestamp);
        $filename = $listing->libelle . ' du ' . $date . '.pdf';
        // $filename = "listing.pdf";


        $html = view('/content/DesignListings/DesignListings', [
            'pageConfigs' => $pageConfigs,
            'data' => $listing,
            'sites' => $sites,
            'clients' => $clients,
            'postes' => $postes,
        ])->render();

        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->SetTitle('reussite');
        $pdf->AddPage('L', 'mm', 'A3');
        $pdf->writeHTML($html, true, false, true, false, "");
        header('Content-Type: application/pdf');
        $pdf->Output(public_path('/listingPdf/' . $filename), "F");

        return response()->download(public_path('/listingPdf/' . $filename));
        // return Response::download(base_path('/listingPdf/' . $filename));


    }

    protected function imprimmeProgrammation(Request $request)
    {

        $id = $request->get('id');

        $programmation = Programmation::find($id);
        $programmations = collect($programmation);
        $user = $programmation->programmationsusers->pluck('user')->unique('id');
        $programme = $programmation->programmationsusers->pluck('programmes')->unique('date')->flatten();
        // $programmes= $programme->programmationsusers;

        $dates = $programmation->AllDatesInRange;
        $horaires = $programmation->programmationsusers->pluck('user_id')->contains(13754);
        // $horaires = $programmation->programmationsusers->pluck('user')->pluck('id')->contains(13754);

        // dump($programmation);
        // dd($horaires);


        // return response()->download(public_path($filename));
        $pageConfigs = ['showMenu' => false, 'pageHeader' => false];
        $timestamp = strtotime($programmation->date_debut); // Remplacez ceci par la date que vous souhaitez formater
        $datedebut = strftime('%d %B %Y', $timestamp);
        $timestamps = strtotime($programmation->date_fin); // Remplacez ceci par la date que vous souhaitez formater
        $datefin = strftime('%d %B %Y', $timestamps);
        $filename = 'Programmation du ' . $datedebut . ' au ' . $datefin . '.pdf';
        // $filename = "programmation.pdf";


        $html = view()->make('/content/DesignListings/DesignProgrammations', [
            'pageConfigs' => $pageConfigs,
            'datas' => $programmation,
            'programmations' => $programmations,
            'users' => $user,
            'dates' => $dates,
        ])->render();

        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->SetTitle('reussite');
        $pdf->AddPage('L', 'mm', 'A3');
        $pdf->writeHTML($html, true, false, true, false, "");
        header('Content-Type: application/pdf');
        $pdf->Output(public_path('/programmationPdf/' . $filename), "F");
        // $pdf->Output($filename);

        return response()->download(public_path('/programmationPdf/' . $filename));

    }

    protected function checkMatrice(Request $request)
    {
        $debut = $request->get('debut');
        $fin = $request->get('fin');


        $all_pointage = Collect(DB::select('select * from pointages where  (debut_prevu BETWEEN ? AND ?) AND  ', [
            $debut,
            $fin,
        ]));
    }

    protected function gen_pointages()
    {

        $programmes = Programme::all();

        foreach ($programmes as $p) {

            $horaire2 = Horaire::find($p->lundi);
            $horaire3 = Horaire::find($p->mardi);
            $horaire4 = Horaire::find($p->mercredi);
            $horaire5 = Horaire::find($p->jeudi);
            $horaire6 = Horaire::find($p->vendredi);
            $horaire7 = Horaire::find($p->samedi);
            $horaire1 = Horaire::find($p->dimanche);


            $semaine = Str::lower($p->programmation->semaine);
            $semaine = explode('-', $semaine);

            $year = $semaine[0];
            $week = Str::replace('w', '', $semaine[1]);
            $allDate = [];
            $date = Carbon::now();
            $date->setISODate($year, $week);
            for ($i = 0; $i < 7; $i++) {

                if ($i == 6) {
                    $date1 = Carbon::now();


                    $date1->setISODate($year, $week);
                    $date1->subDay(1);
                    $newdate1 = clone($date1);

                    $allDate[$i] = $newdate1->format('Y-m-d');
                } else {
                    $newdate = clone($date);
                    $allDate[$i] = $newdate->format('Y-m-d');
                    $date->addDay(1);
                }
            }

            if (isset($horaire2)) {
                $debut = date("Y-m-d H:i:s", strtotime($allDate[0] . ' ' . $horaire2->debut));

                if ($horaire2->type == 'Nuit') {
                    $fin = date("Y-m-d H:i:s", strtotime($allDate[0] . ' ' . $horaire2->fin . ' +1 day'));
                } else $fin = date("Y-m-d H:i:s", strtotime($allDate[0] . ' ' . $horaire2->fin));

                $horaire2_datetime1 = new DateTime($debut);
                $horaire2_datetime2 = new DateTime($fin);
                $horaire2_interval = $horaire2_datetime1->diff($horaire2_datetime2);
                $volume_prevu2 = $horaire2_interval->format('%h');

                Pointage::create([
                    "debut_prevu" => $debut,
                    "fin_prevu" => $fin,
                    "faction_horaire" => $horaire2->type,
                    "user_id" => $p->user_id,
                    "emp_code" => $p->user->emp_code,
                    "est_attendu" => '1',
                    "tolerance" => $horaire2->tolerance,
                    "programme_id" => $p->id,
                    "volume_prevu" => $volume_prevu2
                ]);
            }

            if (isset($horaire3)) {
                $debut = date("Y-m-d H:i:s", strtotime($allDate[1] . ' ' . $horaire3->debut));
                if ($horaire3->type == 'Nuit') {
                    $fin = date("Y-m-d H:i:s", strtotime($allDate[1] . ' ' . $horaire3->fin . ' +1 day'));
                } else $fin = date("Y-m-d H:i:s", strtotime($allDate[1] . ' ' . $horaire3->fin));

                $horaire3_datetime1 = new DateTime($debut);
                $horaire3_datetime2 = new DateTime($fin);
                $horaire3_interval = $horaire3_datetime1->diff($horaire3_datetime2);
                $volume_prevu3 = $horaire3_interval->format('%h');

                Pointage::create([
                    "debut_prevu" => $debut,
                    "fin_prevu" => $fin,
                    "faction_horaire" => $horaire3->type,
                    "user_id" => $p->user_id,
                    "emp_code" => $p->user->emp_code,
                    "est_attendu" => '1',
                    "tolerance" => $horaire3->tolerance,
                    "programme_id" => $p->id,
                    "volume_prevu" => $volume_prevu3
                ]);
            }

            if (isset($horaire4)) {
                $debut = date("Y-m-d H:i:s", strtotime($allDate[2] . ' ' . $horaire4->debut));
                if ($horaire4->type == 'Nuit') {
                    $fin = date("Y-m-d H:i:s", strtotime($allDate[2] . ' ' . $horaire4->fin . ' +1 day'));
                } else $fin = date("Y-m-d H:i:s", strtotime($allDate[2] . ' ' . $horaire4->fin));

                $horaire4_datetime1 = new DateTime($debut);
                $horaire4_datetime2 = new DateTime($fin);
                $horaire4_interval = $horaire4_datetime1->diff($horaire4_datetime2);
                $volume_prevu4 = $horaire4_interval->format('%h');

                Pointage::create([
                    "debut_prevu" => $debut,
                    "fin_prevu" => $fin,
                    "faction_horaire" => $horaire4->type,
                    "user_id" => $p->user_id,
                    "emp_code" => $p->user->emp_code,
                    "est_attendu" => '1',
                    "tolerance" => $horaire4->tolerance,
                    "programme_id" => $p->id,
                    "volume_prevu" => $volume_prevu4
                ]);
            }

            if (isset($horaire5)) {
                $debut = date("Y-m-d H:i:s", strtotime($allDate[3] . ' ' . $horaire5->debut));
                if ($horaire5->type == 'Nuit') {
                    $fin = date("Y-m-d H:i:s", strtotime($allDate[3] . ' ' . $horaire5->fin . ' +1 day'));
                } else $fin = date("Y-m-d H:i:s", strtotime($allDate[3] . ' ' . $horaire5->fin));

                $horaire5_datetime1 = new DateTime($debut);
                $horaire5_datetime2 = new DateTime($fin);
                $horaire5_interval = $horaire5_datetime1->diff($horaire5_datetime2);
                $volume_prevu5 = $horaire5_interval->format('%h');

                Pointage::create([
                    "debut_prevu" => $debut,
                    "fin_prevu" => $fin,
                    "faction_horaire" => $horaire5->type,
                    "user_id" => $p->user_id,
                    "emp_code" => $p->user->emp_code,
                    "est_attendu" => '1',
                    "tolerance" => $horaire5->tolerance,
                    "programme_id" => $p->id,
                    "volume_prevu" => $volume_prevu5
                ]);
            }

            if (isset($horaire6)) {
                $debut = date("Y-m-d H:i:s", strtotime($allDate[4] . ' ' . $horaire6->debut));
                if ($horaire6->type == 'Nuit') {
                    $fin = date("Y-m-d H:i:s", strtotime($allDate[4] . ' ' . $horaire6->fin . ' +1 day'));
                } else $fin = date("Y-m-d H:i:s", strtotime($allDate[4] . ' ' . $horaire6->fin));

                $horaire6_datetime1 = new DateTime($debut);
                $horaire6_datetime2 = new DateTime($fin);
                $horaire6_interval = $horaire6_datetime1->diff($horaire6_datetime2);
                $volume_prevu6 = $horaire6_interval->format('%h');

                Pointage::create([
                    "debut_prevu" => $debut,
                    "fin_prevu" => $fin,
                    "faction_horaire" => $horaire6->type,
                    "user_id" => $p->user_id,
                    "emp_code" => $p->user->emp_code,
                    "est_attendu" => '1',
                    "tolerance" => $horaire6->tolerance,
                    "programme_id" => $p->id,
                    "volume_prevu" => $volume_prevu6
                ]);
            }

            if (isset($horaire7)) {
                $debut = date("Y-m-d H:i:s", strtotime($allDate[5] . ' ' . $horaire7->debut));
                if ($horaire7->type == 'Nuit') {
                    $fin = date("Y-m-d H:i:s", strtotime($allDate[5] . ' ' . $horaire7->fin . ' +1 day'));
                } else $fin = date("Y-m-d H:i:s", strtotime($allDate[5] . ' ' . $horaire7->fin));

                $horaire7_datetime1 = new DateTime($debut);
                $horaire7_datetime2 = new DateTime($fin);
                $horaire7_interval = $horaire7_datetime1->diff($horaire7_datetime2);
                $volume_prevu7 = $horaire7_interval->format('%h');

                Pointage::create([
                    "debut_prevu" => $debut,
                    "fin_prevu" => $fin,
                    "faction_horaire" => $horaire7->type,
                    "user_id" => $p->user_id,
                    "emp_code" => $p->user->emp_code,
                    "est_attendu" => '1',
                    "tolerance" => $horaire7->tolerance,
                    "programme_id" => $p->id,
                    "volume_prevu" => $volume_prevu7
                ]);
            }

            if (isset($horaire1)) {
                $debut = date("Y-m-d H:i:s", strtotime($allDate[6] . ' ' . $horaire1->debut));
                if ($horaire1->type == 'Nuit') {
                    $fin = date("Y-m-d H:i:s", strtotime($allDate[6] . ' ' . $horaire1->fin . ' +1 day'));
                } else $fin = date("Y-m-d H:i:s", strtotime($allDate[6] . ' ' . $horaire1->fin));

                $horaire1_datetime1 = new DateTime($debut);
                $horaire1_datetime2 = new DateTime($fin);
                $horaire1_interval = $horaire1_datetime1->diff($horaire1_datetime2);
                $volume_prevu1 = $horaire1_interval->format('%h');

                Pointage::create([
                    "debut_prevu" => $debut,
                    "fin_prevu" => $fin,
                    "faction_horaire" => $horaire1->type,
                    "user_id" => $p->user_id,
                    "emp_code" => $p->user->emp_code,
                    "est_attendu" => '1',
                    "tolerance" => $horaire1->tolerance,
                    "programme_id" => $p->id,
                    "volume_prevu" => $volume_prevu1
                ]);
            }
        }

        return 'generation des pointages terminé';
    }

    protected function exec_pointages()
    {
        $pointages = Pointage::where('est_attendu', 1)->get();

        foreach ($pointages as $point) {

            if ($point->faction_horaire == 'Jour') {
                $date_debut_prevu = date('Y-m-d', strtotime($point->debut_prevu));

                $first_transaction = Transaction::where('emp_code', $point->emp_code)
                    ->whereBetween('punch_time', [date('Y-m-d H:i:s', strtotime($date_debut_prevu . ' 00:00:00')), date('Y-m-d H:i:s', strtotime($date_debut_prevu . ' 11:59:59'))])
                    ->orderBy('punch_time', 'ASC')
                    ->first();
                $last_transaction = Transaction::where('emp_code', $point->emp_code)
                    ->whereBetween('punch_time', [date('Y-m-d H:i:s', strtotime($date_debut_prevu . ' 12:00:00')), date('Y-m-d H:i:s', strtotime($date_debut_prevu . ' 23:59:59'))])
                    ->orderBy('punch_time', 'DESC')
                    ->first();

                if (isset($first_transaction)) {

                    $debut_collecte = date('Y-m-d H:i:s', strtotime($first_transaction->punch_time));
                    if (isset($point->tolerance) && $point->tolerance > 0) {
                        $debut_prevu_tolere = date('Y-m-d H:i:s', strtotime($point->debut_prevu . '+' . $point->tolerance . ' minutes'));
                    } else $debut_prevu_tolere = date('Y-m-d H:i:s', strtotime($point->debut_prevu));


                    if ($debut_collecte > $debut_prevu_tolere) {
                        //dd($date_debut_prevu , date('Y-m-d H:i:s', strtotime($date_debut_prevu. ' 00:00:00')), $point, $debut_collecte, $debut_prevu_tolere);
                        $point->debut_realise = $debut_collecte;
                        $point->pointeuse = $first_transaction->terminal_alias;
                        $point->lieu = $first_transaction->area_alias;
                        $point->update();

                        if (isset($last_transaction) && $last_transaction != $first_transaction) {
                            $point->fin_realise = date('Y-m-d H:i:s', strtotime($last_transaction->punch_time));

                            if ($point->update()) {
                                $datetime1 = new DateTime($point->debut_realise);
                                $datetime2 = new DateTime($point->fin_realise);
                                $interval = $datetime1->diff($datetime2);

                                $point->volume_realise = $interval->format('%h h %i m');
                                $point->update();

                                if ((round((strtotime($point->fin_realise) - strtotime($point->debut_realise)) / 3600, 1)) > intval($point->volume_prevu)) {
                                    $point->est_valide = '0';
                                    $point->est_attendu = '0';
                                    $point->update();
                                }
                            }
                        } else {
                            $point->est_valide = '0';
                            $point->update();
                        }
                    } else {
                        $point->debut_realise = date('Y-m-d H:i:s', strtotime($point->debut_prevu));
                        $point->pointeuse = $first_transaction->terminal_alias;
                        $point->lieu = $first_transaction->area_alias;
                        $point->update();

                        if (isset($last_transaction) && $last_transaction != $first_transaction) {
                            $point->fin_realise = date('Y-m-d H:i:s', strtotime($last_transaction->punch_time));

                            if ($point->update()) {
                                $datetime1 = new DateTime($point->debut_realise);
                                $datetime2 = new DateTime($point->fin_realise);
                                $interval = $datetime1->diff($datetime2);

                                $point->volume_realise = $interval->format('%h h %i m');
                                $point->update();

                                if ((round((strtotime($point->fin_realise) - strtotime($point->debut_realise)) / 3600, 1)) > intval($point->volume_prevu)) {
                                    $point->est_valide = '0';
                                    $point->est_attendu = '0';
                                    $point->update();
                                }
                            }
                        } else {
                            $point->est_valide = '0';
                            $point->update();
                        }
                    }
                } else {
                    if (isset($last_transaction->punch_time)) {
                        $point->fin_realise = date('Y-m-d H:i:s', strtotime($last_transaction->punch_time));
                        $point->pointeuse = $last_transaction->terminal_alias;
                        $point->lieu = $last_transaction->area_alias;
                        $point->update();
                    }
                }
            } else if ($point->faction_horaire == 'Nuit') {
                $date_debut_prevu = date('Y-m-d', strtotime($point->debut_prevu));
                $date_fin_prevu = date('Y-m-d', strtotime($point->fin_prevu));

                $first_transaction = Transaction::where('emp_code', $point->emp_code)
                    ->whereBetween('punch_time', [date('Y-m-d H:i:s', strtotime($date_debut_prevu . ' 12:00:00')), date('Y-m-d H:i:s', strtotime($date_debut_prevu . ' 23:59:59'))])
                    ->orderBy('punch_time', 'DESC')
                    ->first();
                $last_transaction = Transaction::where('emp_code', $point->emp_code)
                    ->whereBetween('punch_time', [date('Y-m-d H:i:s', strtotime($date_fin_prevu . ' 00:00:00')), date('Y-m-d H:i:s', strtotime($date_fin_prevu . ' 11:59:59'))])
                    ->orderBy('punch_time', 'ASC')
                    ->first();

                if (isset($first_transaction)) {

                    $debut_collecte = date('Y-m-d H:i:s', strtotime($first_transaction->punch_time));
                    if (isset($point->tolerance) && $point->tolerance > 0) {
                        $debut_prevu_tolere = date('Y-m-d H:i:s', strtotime($point->debut_prevu . '+' . $point->tolerance . ' minutes'));
                    } else $debut_prevu_tolere = date('Y-m-d H:i:s', strtotime($point->debut_prevu));

                    if ($debut_collecte > $debut_prevu_tolere) {
                        $point->debut_realise = $debut_collecte;
                        $point->pointeuse = $first_transaction->terminal_alias;
                        $point->lieu = $first_transaction->area_alias;
                        $point->update();

                        if (isset($last_transaction) && $last_transaction != $first_transaction) {
                            $point->fin_realise = date('Y-m-d H:i:s', strtotime($last_transaction->punch_time));

                            if ($point->update()) {
                                $datetime1 = new DateTime($point->debut_realise);
                                $datetime2 = new DateTime($point->fin_realise);
                                $interval = $datetime1->diff($datetime2);

                                $point->volume_realise = $interval->format('%h h %i m');
                                $point->update();

                                if ((round((strtotime($point->fin_realise) - strtotime($point->debut_realise)) / 3600, 1)) > intval($point->volume_prevu)) {
                                    $point->est_valide = '0';
                                    $point->est_attendu = '0';
                                    $point->update();
                                }
                            }
                        } else {
                            $point->est_valide = '0';
                            $point->update();
                        }
                    } else {
                        $point->debut_realise = date('Y-m-d H:i:s', strtotime($first_transaction->punch_time));
                        $point->pointeuse = $first_transaction->terminal_alias;
                        $point->lieu = $first_transaction->area_alias;
                        $point->update();

                        if (isset($last_transaction) && $last_transaction != $first_transaction) {
                            $point->fin_realise = date('Y-m-d H:i:s', strtotime($last_transaction->punch_time));

                            if ($point->update()) {
                                $datetime1 = new DateTime($point->debut_realise);
                                $datetime2 = new DateTime($point->fin_realise);
                                $interval = $datetime1->diff($datetime2);

                                $point->volume_realise = $interval->format('%h h %i m');
                                $point->update();

                                if ((round((strtotime($point->fin_realise) - strtotime($point->debut_realise)) / 3600, 1)) > intval($point->volume_prevu)) {
                                    $point->est_valide = '0';
                                    $point->est_attendu = '0';
                                    $point->update();
                                }
                            }
                        } else {
                            $point->est_valide = '0';
                            $point->update();
                        }
                    }
                } else {
                    if (isset($last_transaction->punch_time)) {
                        $point->fin_realise = date('Y-m-d H:i:s', strtotime($last_transaction->punch_time));
                        $point->pointeuse = $last_transaction->terminal_alias;
                        $point->lieu = $last_transaction->area_alias;
                        $point->update();
                    }
                }
            }
        }

        return 'Execution des pointages terminé';
    }
}
