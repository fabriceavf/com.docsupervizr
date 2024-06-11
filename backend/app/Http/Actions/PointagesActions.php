<?php

namespace App\Http\Actions;

use App\Http\Pointages;
use App\Http\TransactionsAnalyses;
use App\Http\TransactionsCollectes;
use App\Models\Pointage;
use App\Models\Programmationsuser;
use App\Models\Programme;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use stdClass;
use Throwable;

class PointagesActions
{


    public function getPresences(Request $request)
    {

        $programme = DB::table('programmes')
            ->join('programmationsusers', 'programmes.programmationsuser_id', 'programmationsusers.id')
            ->join('programmations', 'programmationsusers.programmation_id', 'programmations.id')
            ->select('programmations.etats')
            ->get();
        dd($programme);


    }

    public function getPointagesStats(Request $request)
    {
        Carbon::setLocale('fr');
        $data = [];
        $data2 = [];
        $actual = Carbon::now();
        $pointeuse = false;
        $client = false;
        $poste = false;
        $zone = false;
        $faction = false;
        $directions = false;

        if ($request->has('month')) {
            $actual = Carbon::parse($request->get('month') . '-01');
        }
        if ($request->has('pointeuses')) {
            $pointeuse = $request->get('pointeuses');
        }
        if ($request->has('clients')) {
            $client = $request->get('clients');
        }
        if ($request->has('postes')) {
            $poste = $request->get('postes');
        }
        if ($request->has('zones')) {
            $zone = $request->get('zones');
        }
        if ($request->has('faction')) {
            $faction = $request->get('faction');
        }
        if ($request->has('directionselectionner') && !empty($request->get('directionselectionner'))) {
            $directions = explode(',', $request->get('directionselectionner'));
        }


        $pointagesDuJourConnuQuery = DB::table('transactions')
            ->where('card_no', 'not like', '%-%')
            ->whereNull('transactions.deleted_at')
            ->select(DB::raw('count(transactions.id) as total,punch_date'))
            ->where('punch_date', 'like', $actual->format('Y-m') . '-%');

        if (is_array($directions)) {
            $pointagesDuJourConnuQuery->whereIn('direction_id', $directions);
            $allParams['pointeuse_id'] = $pointeuse;
        }

        if ($pointeuse) {
            $pointagesDuJourConnuQuery->where('pointeuse_id', $pointeuse);
            $allParams['pointeuse_id'] = $pointeuse;
        }
        if ($client) {
//                dd($client);
            $pointagesDuJourConnuQuery->where('client_id', $client);
            $allParams['client_id'] = $client;
        }
        if ($poste) {
            $pointagesDuJourConnuQuery->where('poste_id', $poste);
            $allParams['poste_id'] = $poste;
        }
        if ($zone) {
            $pointagesDuJourConnuQuery->where('zone_id', $zone);
            $allParams['zone_id'] = $zone;
        }


        $pointagesDuJourConnuQuery->groupBy('punch_date');
        $connu = clone($pointagesDuJourConnuQuery);
        $connu->whereIn('card_no', function ($q) {
            $q->select('num_badge')->from('users')->whereNotNull('typeseffectif_id');
        });


        $total = clone($pointagesDuJourConnuQuery);
        $total = $total->get();
        $connu = $connu->get();
        $pointageData = [];
        $days = $actual->daysInMonth + 1;
        for ($i = 1; $i < $days; $i++) {
            $totalConnu = 0;
            $totalInConnu = 0;
            $obj = new stdClass();
            $obj->jour = $actual->format('Y-m') . '-' . Str::padLeft($i, 2, '0');

            $allParams['debut'] = $obj->jour . " 00:00:00";
            $allParams['fin'] = $obj->jour . " 23:59:59";
            $url1 = "";
            try {
                $url1 = URL::signedRoute('JOURNALS_web_index', $allParams);
            } catch (Throwable $e) {
            }
            if (!Str::is('*127.0.0.1*', $url1)) {
                $url1 = Str::replace('http://', 'https://', $url1);
            }
            try {
                $filterElement = $connu->filter(function ($data) use ($obj) {
                    return $data->punch_date == $obj->jour;
                });
                foreach ($filterElement as $ele) {
                    $totalConnu = $ele->total;
                }
            } catch (Throwable $e) {

            }
            try {
                $filterElement = $total->filter(function ($data) use ($obj) {
                    return $data->punch_date == $obj->jour;
                });
                foreach ($filterElement as $ele) {
                    $totalInConnu = $ele->total - $totalConnu;
                }
            } catch (Throwable $e) {
            }
            $obj->pointagesConnu = $totalConnu;
            $obj->pointagesInConnu = $totalInConnu;
            $obj->url = $url1;
            $pointageData[] = $obj;
        }
        return $pointageData;


    }

    public function getPointagesStats2(Request $request)
    {
        Carbon::setLocale('fr');
        $data = [];
        $data2 = [];
        $actual = Carbon::now();
        $pointeuse = false;
        $client = false;
        $poste = false;
        $zone = false;
        $faction = false;
        $directions = false;
        $validations = false;

        if ($request->has('month2')) {
            $actual = Carbon::parse($request->get('month2') . '-01');
        }
        if ($request->has('pointeuses')) {
            $pointeuse = $request->get('pointeuses');
        }
        if ($request->has('validation')) {
            $validations = $request->get('validation');
        }
        if ($request->has('clients')) {
            $client = $request->get('clients');
        }
        if ($request->has('postes')) {
            $poste = $request->get('postes');
        }
        if ($request->has('zones')) {
            $zone = $request->get('zones');
        }
        if ($request->has('faction')) {
            $faction = $request->get('faction');
        }
        if ($request->has('directionselectionner') && !empty($request->get('directionselectionner'))) {
            $directions = explode(',', $request->get('directionselectionner'));
        }

        $programmes = DB::table('programmes')
            // ->join('programmationsusers', 'programmes.programmationsuser_id', 'programmationsusers.id')
            ->join('programmations', 'programmes.programmation_id', 'programmations.id')
            ->join('horaires', 'programmes.horaire_id', 'horaires.id')
            ->join('postes', 'horaires.poste_id', 'postes.id')
            ->join('sites', 'postes.site_id', 'sites.id')
            ->join('zones', 'sites.zone_id', 'zones.id')
            ->whereNull('programmes.deleted_at')
            ->where('programmes.debut_prevu', 'like', $actual->format('Y-m') . '-%')
            ->select(DB::raw('count(programmes.id) as total,programmes.debut_prevu as debut_prevu'))
            ->groupBy('programmes.debut_prevu');

        // Convertir la chaîne en tableau
        $validationsArray = explode(",", $validations);
// dd($validationsArray);
// if (count($validationsArray)== '1') {
        if (count($validationsArray) == '3') {
            $programmes;
        } else {
            if (in_array('0', $validationsArray)) {
                $programmes->whereNull('programmations.valider1')
                    ->whereNull('programmations.valider2');
            }

            if (in_array('1', $validationsArray)) {
                $programmes->whereNotNull('programmations.valider1')
                    ->whereNull('programmations.valider2');
            }

            if (in_array('2', $validationsArray)) {
                $programmes->whereNotNull('programmations.valider1')
                    ->whereNotNull('programmations.valider2');
            }
// }
// if (count($validationsArray)=='2') {
            if (in_array('0', $validationsArray) && in_array('1', $validationsArray)) {
                $programmes->orwhereNull('programmations.valider2');
            }
            if (in_array('0', $validationsArray) && in_array('2', $validationsArray)) {
                $programmes->orwhereNull('programmations.valider1')
                    ->orwhereNotNull('programmations.valider2');
                // dd('error');
            }
            if (in_array('2', $validationsArray) && in_array('1', $validationsArray)) {
                $programmes->orWhereNotNull('programmations.valider1');
            }


// else{
//     dd('error');
// }
        }


        $present = clone($programmes);
        $present->whereIn(DB::raw("CONCAT(COALESCE(`programmes`.`presence_declarer_auto`,''), '-',COALESCE(`programmes`.`presence_declarer_manuel`,'') )"), ['oui-oui', 'non-oui', 'oui-', '-oui']);
        $abscent = clone($programmes);
        $abscent->whereNotIn(DB::raw("CONCAT(COALESCE(`programmes`.`presence_declarer_auto`,''), '-',COALESCE(`programmes`.`presence_declarer_manuel`,'') )"), ['oui-oui', 'non-oui', 'oui-', '-oui']);


        $present = $present->get();
        $abscent = $abscent->get();

        $pointageData = [];
        $days = $actual->daysInMonth + 1;
        for ($i = 1; $i < $days; $i++) {
            $totalConnu = 0;
            $totalInConnu = 0;
            $obj = new stdClass();
            $obj->jour = $actual->format('Y-m') . '-' . Str::padLeft($i, 2, '0');

            $allParams['debut'] = $obj->jour . " 00:00:00";
            $allParams['fin'] = $obj->jour . " 23:59:59";
            $url1 = "";
            try {
                $filterElement = $present->filter(function ($data) use ($obj) {
                    return Str::is($obj->jour . '*', $data->debut_prevu);
                });
                foreach ($filterElement as $ele) {
                    $totalConnu += $ele->total;
                }
            } catch (Throwable $e) {

            }
            try {
                $filterElement = $abscent->filter(function ($data) use ($obj) {
                    return Str::is($obj->jour . '*', $data->debut_prevu);
                });
                foreach ($filterElement as $ele) {
                    $totalInConnu += $ele->total;
                }
            } catch (Throwable $e) {
            }
            $obj->pointagesConnu = $totalConnu;
            $obj->pointagesInConnu = $totalInConnu;
            $obj->url = $url1;
            $pointageData[] = $obj;
        }
        return $pointageData;

        DB::table('horairesagents')
            ->join('horaires', 'horairesagents.horaire_id', 'horaires.id')
            ->join('postes', 'horaires.parentId', 'postes.id')
            ->whereNull('postes.type')
            ->where('horaires.parent', 'poste')
            ->whereNull('horairesagents.deleted_at')->count();


    }

    public function getPointagesStats3(Request $request)
    {
        Carbon::setLocale('fr');
        $data = [];
        $data2 = [];
        $actual = Carbon::now();
        $site = false;

        if ($request->has('month')) {
            $actual = Carbon::parse($request->get('month') . '-01');
        }

        if ($request->has('site')) {
            $site = $request->get('site');
        }

        $programmes = DB::table('programmes')
            ->join('programmations', 'programmes.programmation_id', 'programmations.id')
            ->join('horaires', 'programmes.horaire_id', 'horaires.id')
            ->join('postes', 'horaires.poste_id', 'postes.id')
            ->join('sites', 'postes.site_id', 'sites.id')
            ->whereNull('programmes.deleted_at')
            ->where('programmations.date_debut', 'like', $actual->format('Y-m') . '-%');
        if (!empty($site)) {
            $programmes = $programmes->where('sites.id', $site);
        }
        $programmes->select(DB::raw('programmations.date_debut as date,GROUP_CONCAT(programmes.programmation_id) as programmations'));
        $programmes->groupBy(['programmations.date_debut']);


        $present = clone($programmes);
        $present->whereIn(DB::raw("CONCAT(COALESCE(`programmes`.`presence_declarer_auto`,''), '-',COALESCE(`programmes`.`presence_declarer_manuel`,'') )"), ['oui-oui', 'non-oui', 'oui-', '-oui']);
        $abscent = clone($programmes);
        $abscent->whereNotIn(DB::raw("CONCAT(COALESCE(`programmes`.`presence_declarer_auto`,''), '-',COALESCE(`programmes`.`presence_declarer_manuel`,'') )"), ['oui-oui', 'non-oui', 'oui-', '-oui']);

        $present = $present->get()->pluck('programmations', 'date')->toArray();
        $abscent = $abscent->get()->pluck('programmations', 'date')->toArray();


        $pointageData = [];
        $days = $actual->daysInMonth + 1;
        for ($i = 1; $i < $days; $i++) {
            $totalConnu = 0;
            $totalInConnu = 0;
            $obj = new stdClass();
            $obj->jour = $actual->format('Y-m') . '-' . Str::padLeft($i, 2, '0');
            $_date = $obj->jour . " 00:00:00";
            $_present = [];
            $_abscent = [];
            try {
                $_present = explode(',', $present[$_date]);
                $_present = array_values(array_unique($_present));
            } catch (Throwable $e) {

            }
            try {
                $_abscent = explode(',', $abscent[$_date]);
                $_abscent = array_values(array_unique($_abscent));
            } catch (Throwable $e) {

            }

            $total = count(array_values(array_unique(array_merge($_present, $_abscent))));

            $complet = array_diff($_present, $_abscent);
            $nonDemarrer = array_diff($_abscent, $_present);

            $obj->pointagesConnu = count($complet);
            $obj->pointagesNonDemarrer = count($nonDemarrer);
            $obj->pointagesInConnu = $total - (count($complet) + count($nonDemarrer));
            $pointageData[] = $obj;
        }
        return $pointageData;


    }

    public function addPresence(Request $request)
    {
        $programmeId = $request->get('id');
        $programme = Programme::find($programmeId);
        $programmationUser = Programmationsuser::find($programme->programmationsuser_id);

        $userId = $programmationUser->user->id;
        $userMatricule = $programmationUser->user->matricule;

        DB::table('presences')->insert([
            'user_id' => $userId,
            'debut' => $programme->debut_prevu,
            'fin' => $programme->fin_prevu,
            'raison' => 'Presence rajouter par le supervizr sur les listing manuel',
            'created_at' => now()
        ]);

        TransactionsAnalyses::analysePreuves($programmeId);
        $programme = Programme::find($programmeId);
        return $programme;


    }

    public function addAbscence(Request $request)
    {

        $programmeId = $request->get('id');
        $programme = Programme::find($programmeId);
        $programmationUser = Programmationsuser::find($programme->programmationsuser_id);

        $userId = $programmationUser->user->id;
        $userMatricule = $programmationUser->user->matricule;

        DB::table('abscences')->insert([
            'user_id' => $userId,
            'debut' => $programme->debut_prevu,
            'fin' => $programme->fin_prevu,
            'raison' => 'Abscence rajouter par le supervizr sur les listing manuel',
            'created_at' => now()
        ]);

        TransactionsAnalyses::analysePreuves($programmeId);
        $programme = Programme::find($programmeId);
        return $programme;


    }

    public function getMenbres(Request $request)
    {

        $planification = DB::table("modelslistings")->find($request->get('id'));
        $params = json_decode($planification->params);
        $query = json_decode($planification->query);
        $usersConcerners = collect(DB::select($query, $params))->pluck('id')->toArray();
        return $usersConcerners;

    }

    public function getTransactions(Request $request)
    {
        TransactionsCollectes::synchroniseInBioTransactions();
    }

    public function importData(Request $request)
    {
        $type = 'import' . $request->get('type');

        Pointages::$type();


    }

    public function getTransactions1(Request $request)
    {
////        Pointages::synchroniseTransactions();
//        Pointages::synchroniseUserData();
////        Pointages::synchronisePointeuseData();
//        Pointages::synchronisePosteData();
        $routes = collect([]);
        $liasons = collect([]);
        $liasons->push(['R' => "P"]);
        $liasons->push(['Q' => "P"]);
        $liasons->push(['P' => "O"]);
        $liasons->push(['O' => "E"]);
        $liasons->push(['E' => "A"]);
        $liasons->push(['A' => "D"]);
//        $liasons->push(['A' => "B"]);
//        dd(explode('-A-','BCF'));
        foreach ($liasons as $data) {
            foreach ($data as $k => $val) {
                $key = $k;
                $value = $val;
            }
//            dd($key,$value);


            $allItineraire1 = $routes
                ->filter(function ($data) use ($key) {
                    return count(explode('-' . $key . '-', $data)) == 2;
                })
                ->map(function ($data) use ($key, $value) {

                    $data = explode('-' . $key . '-', $data);
                    if ($data[0] != "") {
                        $dat[] = $data[0] . '-' . $key . '--' . $value . '-';
                    }
                    if ($data[1] != "") {

                        $dat[] = '-' . $value . '--' . $key . '-' . $data[1];
                    }


                    return $dat;
                });
            foreach ($allItineraire1 as $itineraire) {
                foreach ($itineraire as $iti) {
                    $newRoute = [$iti, '-' . $key . '-', '-' . $value . '-'];
                    $newRoute = implode('', $newRoute);
                    $decouverte[] = $newRoute;
                }

            }
            $allItineraire2 = $routes
                ->filter(function ($data) use ($value) {
                    return count(explode('-' . $value . '-', $data)) == 2;
                })
                ->map(function ($data) use ($key, $value) {
                    $data = explode('-' . $value . '-', $data);
                    if ($data[0] != "") {
                        $dat[0] = $data[0] . '-' . $value . '--' . $key . '-';
                    }
                    if ($data[1] != "") {
                        $dat[1] = '-' . $key . '--' . $value . '-' . $data[1];
                    }

                    return $dat;
                });


//            $routes=$routes->filter(function($data)use($key,$value){
//                return count(explode('-' . $key . '-', $data))<=1 && count(explode('-' . $value . '-', $data))<=1 ;
//            });
//            if($key=="B"){
//                dd($routes,$allItineraire1,$allItineraire2);
//            }
            if (($allItineraire1->count() + $allItineraire1->count()) == 0) {
                $newRoute = ['-' . $value . '-', '-' . $key . '-'];
                $newRoute = implode('', $newRoute);
                $routes->push($newRoute);
            } else {
                $routes = $routes->filter(function ($data) use ($key, $value) {
                    return count(explode('-' . $key . '-', $data)) <= 1 && count(explode('-' . $value . '-', $data)) <= 1;
                });
                foreach ($allItineraire1 as $itineraire) {
                    foreach ($itineraire as $iti) {
                        $routes->push($iti);
                    }
                }
                foreach ($allItineraire2 as $itineraire) {
                    foreach ($itineraire as $iti) {
                        $routes->push($iti);
                    }
                }
            }
//            if($allItineraire1->count()>1){
//                $routes=$routes->filter(function($data)use($allItineraire1){
//                    return !in_array($data,$allItineraire1->toArray());
//                });
//            }
//            if($allItineraire2->count()>1){
//                $routes=$routes->filter(function($data)use($allItineraire2){
//                    return !in_array($data,$allItineraire2->toArray());
//                });
//            }

//            foreach ($decouverte as $decou){
//
//                $routes->push($decou);
//            }

//            dd($allItineraire1);
//            $routeExistente=$routes->filter(function($data)use($key,$value){
//               return  Str::is('*-'.$key.'-*',$data) || Str::is('*-'.$value.'-*',$data);
//                });
//            if( $routeExistente->count()==0){
//                $new=[];
//                $new[]='-'.$key.'-';
//                $new[]='-'.$value.'-';
//                $routes->push(implode('',$new));
//            }else{
//                foreach ($routeExistente as $route){
//                    $itineraire=explode('-'.$key.'-',$route);
//                    $itineraire=collect($itineraire)->filter(function($d){return !empty($d);});
//                    foreach ($itineraire as $iti){
//                        $newRoute=[$iti,'-'.$key.'-','-'.$value.'-'];
//                        $newRoute=implode('',$newRoute);
//                        $routes->push($newRoute);
//                    }
//                    $itineraire=explode('-'.$value.'-',$route);
//                    $itineraire=collect($itineraire)->filter(function($d){return !empty($d);});
//                    foreach ($itineraire as $iti){
//                        $newRoute=[$iti,'-'.$value.'-','-'.$key.'-'];
//                        $newRoute=implode('',$newRoute);
//                        $routes->push($newRoute);
//                    }
//
////                    $routes=$routes->filter(function($data)use($route){return $data!=$route;});
//                }
//
//            }
        }

        dd($routes->unique());


    }

    public function spliter(Request $request)
    {

//        Pointages::findDateProgrammationStatut();

//        Pointages::ModifieProgrammationStatut();
//        Pointages::nettoyagesSingletonOrDouble();
        Pointages::recalculeAllPointagesPrevu();
        Pointages::recalculeAllPointagesRealiser();
        Pointages::ventiller();
    }

    public function TestTeleric(Request $request)
    {
        $date = now();
        $depuis = $date->getTimestamp() - 100000;
        $jour = $date->format('Ymd');
        $api_private_key = 'dbNOc2a0o5';
//        $url = 'https://gabontech.teleric.net/api/'.$path.'/?';
//        $url = "https://gabontech.teleric.net/api/intervention/depuis/$depuis/?";
        $url = "https://gabontech.teleric.net/intervention/jour/AAAAMMJJ/?";
        $parameters = [
            'time' => time(),
            'apikey' => 'm1MZ9U5XbE',
            'format' => 'json',
        ];
        $parameters['signature'] = base64_encode(hash_hmac('sha256', $url . http_build_query($parameters), $api_private_key, true));
        $response = Http::get($url . http_build_query($parameters));
        return $response->json();


    }


    public function regeneratePointages(Request $request)
    {
        Pointages::regeneratePointages();


    }


    public function checkSemaine(Request $request)
    {
        $semaine = strtolower($request->semaine);
        $semaine = explode('-', $semaine);
//            dump($semaine);
        $year = $semaine[0];
        $week = Str::replace('w', '', $semaine[1]);
        $allDate = [];
        $date = \Illuminate\Support\Carbon::now();
        Carbon::setLocale('fr');
        $date->setISODate($year, $week);
        for ($i = 0; $i < 7; $i++) {
            if ($i == 6) {
                $date1 = Carbon::now();
                $date1->setISODate($year, $week);
                $date1->subDay(1);
                $newdate1 = clone($date1);
                $allDate[$newdate1->dayName] = $newdate1->format('Y-m-d');
            } else {
                $newdate = clone($date);
                $allDate[$newdate->dayName] = $newdate->format('Y-m-d');
                $date->addDay(1);
            }
        }
        dd($allDate);
    }

    public function exceptions(Request $request)
    {
        $data = Pointage::all()->filter(function ($data) {
//            return (intVal($data->volume_realise) > 8 || is_null($data->fin_realise)) && !empty($data->debut_realise && );
            $null = 0;
            if (empty($data->debut_realise)) {
                $null++;
            }
            if (empty($data->fin_realise)) {
                $null++;
            }
            $volume_realise = 0;
            if (!empty($data->debut_realise) && !empty($data->fin_realise)) {
                $deb_realise = clone(Carbon::parse($data->debut_realise));
                $fin_realise = clone(Carbon::parse($data->fin_realise));
                $ecartRealiserDansLaJournee = $fin_realise->diffInMinutes($deb_realise);
                $volume_realise = $ecartRealiserDansLaJournee;
            }
            return (
                ($null == 1 || $volume_realise > 8 * 60 || ($null == 1 && $data->etats == 'NON_PREVU'))
                && Carbon::parse($data->fin_prevu)->isPast()
                && $data->est_valide == 0
            );
        })->sortBy('debut_prevu');

//        dd($result);
        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json(count($data));
        }
//        dd('on veut pagner');
        if (!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"] == 1) {
//            dd('on veut pagner');
            $page = Paginator::resolveCurrentPage() ?: 1;
            $perPage = isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20;
            $records = new LengthAwarePaginator(
                $data->forPage($page, $perPage), $data->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
            );
            $donnees = $records;
            $donnees = $donnees->toArray();


        } else {
            $donnees = $data;
        }


        if (!empty($donnees['data']) && is_array($donnees['data'])) {
            $new = [];
            foreach ($donnees['data'] as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
                $new[] = $response;
            }
            $donnees['data'] = $new;
        } else {

            foreach ($donnees as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
            }


            $retour = [];
            foreach ($donnees as $re) {
                $retour[] = $re->toArray();
            }
            $donnees = $retour;


        }
        return $donnees;
    }


    public function justifierAbscences(Request $request)
    {

        $debut = $request->get('debut');
        $fin = $request->get('fin');
        $soldable = $request->get('soldable');
        $programmeId = $request->get('programme_id');
        $motif = $request->get('motif');
        $typesabscenceId = $request->get('typesabscence_id');
        $programme = Programme::find($programmeId);
        $userId = $programme->programmationsuser->user->id;
        $userMatricule = $programme->programmationsuser->user->matricule;
        $heureDebut = $programme->horaire->debut;
        $heureFin = $programme->horaire->fin;

//        dd($request->all());

//        dd($typesabscenceId);
        DB::table('abscences')->updateOrInsert([
            'user_id' => $userId,
            'debut' => $debut,
            'fin' => $fin . ' 23:59:59',
            'typesabscence_id' => $typesabscenceId,
        ], [
            'raison' => $motif
        ]);

        $debut = Carbon::createFromFormat('Y-m-d', $debut);
        $fin = Carbon::createFromFormat('Y-m-d', $fin);

        TransactionsAnalyses::analysePreuves($programme->id);
        $programme = Programme::find($programmeId);
        return $programme;


    }

    public function collectRobot(Request $request)
    {

        $data = $request->all();
        DB::table('extrasdatas')->insert([
            'cle' => "teleric",
            'valeur' => json_encode($data),
            'created_at' => now(),
        ]);

        return json_encode($data);

    }

    public function collectRobot1(Request $request)
    {

        $data = $request->all();
        DB::table('extrasdatas')->insert([
            'cle' => "inbio",
            'valeur' => json_encode($data),
            'created_at' => now(),
        ]);

        return true;

    }

    public function getRapports(Request $request)
    {


    }

    private function TraiteLiaisons()
    {

    }

}
