<?php

namespace App\Http\Controllers;


use App\Http\Utils;
use App\Models\Client;
use App\Models\Direction;
use App\Models\Import;
use App\Models\Pointage;
use App\Models\Pointeuse;
use App\Models\Poste;
use App\Models\Programmation;
use App\Models\Tache;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        return response()
            ->withNenrolements($nenrolements = User::where('type', 'employe')->where('actif', '0')->count())
            ->withNemployes($nemployes = User::where('type', 'employe')->where('actif', '1')->count())
            ->withNtaches($ntaches = Tache::count())
            ->withNexceptions($nexceptions = Pointage::where('volume_realise', '>', 8)->count())
            ->withNtransactions($ntransactions = Transaction::where('punch_date', date('Y-m-d'))->count())
            ->withtransactions($transactions = Transaction::where('punch_date', date('Y-m-d'))->orderby('punch_date', 'DESC')->get())
            ->withNprogrammations($nprogrammations = Programmation::where('statut', 'En cours...')->count())
            ->withProgrammations($programmations = Programmation::where('statut', 'En cours...')->latest()->get());
    }

    public function usersconnect()
    {
        return Auth::user()->role_id;
    }

    public function usersconnecttype()
    {
        // Vérifiez si l'utilisateur est authentifié avant d'accéder à ses propriétés
        if (Auth::check()) {
            return Auth::user()->type_id;
        } else {
            // Gérez le cas où l'utilisateur n'est pas authentifié
            // Vous pouvez renvoyer une valeur par défaut ou lancer une exception, selon vos besoins.
            return 'Utilisateur non authentifié';
        }
    }

    public function userscount()
    {
        return DB::table('users')->where(['type_id' => 2, 'actif_id' => 1])->whereNull('deleted_at')->count();
    }

    public function usersonecount()
    {
        return DB::table('users')->where('type_id', 3)->whereNull('deleted_at')->count();
    }

    public function usersaffectescount()
    {
        return DB::table('horaireagents')->distinct('user_id')->whereIn('user_id', DB::table('users')->whereNull('deleted_at')->pluck('id'))->count();
    }

    public function usersoneaffectescount()
    {
        return DB::table('horaireagents')->distinct('user_id')->whereIn('user_id', DB::table('users')->where('type_id', 3)->whereNull('deleted_at')->pluck('id'))->count();
    }

    public function usersaffectescountzone()
    {
        return DB::table('userszones')->join('zones', 'zones.id', 'userszones.zone_id')->join('sites', 'zones.id', 'sites.zone_id')->join('postes', 'sites.id', 'postes.site_id')->join('horaires', 'postes.id', 'horaires.parentId')->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')->where('userszones.user_id', Auth::id())->whereIn(
            'horaireagents.user_id',
            DB::table('users')->where(['type_id' => 2, 'actif_id' => 1])->whereNull('users.deleted_at')->pluck('users.id'),
        )->whereNull(['zones.deleted_at', 'userszones.deleted_at', 'sites.deleted_at', 'postes.deleted_at'])->distinct('horaireagents.user_id')->pluck('horaireagents.user_id')->count();

    }

    public function usersoneaffectescountzone()
    {
        return DB::table('userszones')->join('zones', 'zones.id', 'userszones.zone_id')->join('sites', 'zones.id', 'sites.zone_id')->join('postes', 'sites.id', 'postes.site_id')->join('horaires', 'postes.id', 'horaires.parentId')->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')->where('userszones.user_id', Auth::id())->whereIn(
            'horaireagents.user_id',
            DB::table('users')->where('users.type_id', 3)->whereNull('users.deleted_at')->pluck('users.id'),
        )->whereNull(['zones.deleted_at', 'userszones.deleted_at', 'sites.deleted_at', 'postes.deleted_at'])->distinct('horaireagents.user_id')->pluck('horaireagents.user_id')->count();

    }

    public function dateimportagents()
    {
        return Import::where('type', 'agents')->latest('created_at')->value('created_at');

    }

    public function dateimportagentsone()
    {
        return Import::where('type', 'agents-one')->latest('created_at')->value('created_at');
    }

    public function dateimportposte()
    {
        return Import::where('type', 'postes')->latest('created_at')->value('created_at');

    }

    public function postesclientcount()
    {
        return Poste::whereNotIn('type', ['nonimporter', 'operationnel'])->orWhereNull('type')->whereNull('deleted_at')->count();
    }

    public function postesoperationcount()
    {
        return Poste::where('type', 'operationnel')->whereNull('deleted_at')->count();
    }

    public function postesinternecount()
    {
        return Poste::where('type', 'nonimporter')->whereNull('deleted_at')->count();
    }

    public function tachescount()
    {
        return Tache::count();
    }

    public function postescount()
    {
        return Poste::whereNull('deleted_at')->count();
    }

    public function zonescount()
    {
        return Zone::count();
    }

    public function zonesget()
    {
        $postes = DB::table('clients')
            ->join('sites', 'clients.id', 'sites.client_id')
            ->join('zones', 'zones.id', 'sites.zone_id')
            ->join('postes', 'postes.site_id', 'sites.id')
            ->where('clients.libelle', 'like', '%' . 'total' . '%')
            ->where('zones.libelle', 'like', '%' . 'gentil' . '%')
            ->pluck('postes.id');

        $zonesGet = Zone::whereIn('id', function ($query) use ($postes) {
            return $query
                ->select('zone_id')
                ->from('userszones')
                ->whereNull('userszones.deleted_at')
                ->where('user_id', Auth::id());
        })
            ->get()
            ->map(function ($data) use ($postes) {
                $date = now()->format('Y-m-d');
                if (request()->has('date')) {
                    $date = request()->get('date');
                }

                $totalAffecterNuit = Utils::getEffectifAffecterForZone($data->id, $date, 'nuit', '');
                $totalAffecterJour = Utils::getEffectifAffecterForZone($data->id, $date, 'jour', '');

                $totalAffecterJourInterne = Utils::getEffectifAffecterForZone($data->id, $date, 'jour', 'interne');
                $totalAffecterJourClient = Utils::getEffectifAffecterForZone($data->id, $date, 'jour', 'client');
                $totalAffecterJourOperationel = Utils::getEffectifAffecterForZone($data->id, $date, 'jour', 'operationnel');

                $totalAffecterNuitClient = Utils::getEffectifAffecterForZone($data->id, $date, 'nuit', 'client');
                $totalAffecterNuitInterne = Utils::getEffectifAffecterForZone($data->id, $date, 'nuit', 'interne');
                $totalAffecterNuitOperationel = Utils::getEffectifAffecterForZone($data->id, $date, 'nuit', 'operationnel');


                $presentJourQueryClient = Utils::getPresenceForZone($data->id, $date, 'jour', 'client');
                $presentJourQueryInterne = Utils::getPresenceForZone($data->id, $date, 'jour', 'interne');
                $presentJourQueryOperationel = Utils::getPresenceForZone($data->id, $date, 'jour', 'operationnel');

                $presentNuitQueryClient = Utils::getPresenceForZone($data->id, $date, 'nuit', 'client');
                $presentNuitQueryInterne = Utils::getPresenceForZone($data->id, $date, 'nuit', 'interne');
                $presentNuitQueryOperationel = Utils::getPresenceForZone($data->id, $date, 'nuit', 'operationnel');
                //NEW METHODE
                $totaNewAffecterJourInterne = Utils::getNewEffectifAffecterForZone($data->id, $date, 'jour', 'interne')['count'];
                $totalNewAffecterJourClient = Utils::getNewEffectifAffecterForZone($data->id, $date, 'jour', 'client')['count'];
                $totalNewAffecterJourOperationel = Utils::getNewEffectifAffecterForZone($data->id, $date, 'jour', 'operationnel')['count'];
                $totalNewAffecterJourGrosClient = Utils::getNewEffectifAffecterForZone($data->id, $date, 'jour', 'GrosClient')['count'];

                $totaNewAffecterJourInternezone_label = Utils::getNewEffectifAffecterForZone($data->id, $date, 'jour', 'interne')['zone_label'];
                $totalNewAffecterJourClientzone_label = Utils::getNewEffectifAffecterForZone($data->id, $date, 'jour', 'client')['zone_label'];
                $totalNewAffecterJourOperationelzone_label = Utils::getNewEffectifAffecterForZone($data->id, $date, 'jour', 'operationnel')['zone_label'];
                $totalNewAffecterJourGrosClientzone_label = Utils::getNewEffectifAffecterForZone($data->id, $date, 'jour', 'GrosClient')['zone_label'];


                $totalNewAffecterNuitClient = Utils::getNewEffectifAffecterForZone($data->id, $date, 'nuit', 'client')['count'];
                $totalNewAffecterNuitInterne = Utils::getNewEffectifAffecterForZone($data->id, $date, 'nuit', 'interne')['count'];
                $totalNewAffecterNuitOperationel = Utils::getNewEffectifAffecterForZone($data->id, $date, 'nuit', 'operationnel')['count'];
                $totalNewAffecterNuitGrosClient = Utils::getNewEffectifAffecterForZone($data->id, $date, 'nuit', 'GrosClient')['count'];


                $presentNewJourQueryClient = Utils::getNewPresenceForZone($data->id, $date, 'jour', 'client');
                $presentNewJourQueryInterne = Utils::getNewPresenceForZone($data->id, $date, 'jour', 'interne');
                $presentNewJourQueryOperationel = Utils::getNewPresenceForZone($data->id, $date, 'jour', 'operationnel');
                $presentNewJourQueryGrosClient = Utils::getNewPresenceForZone($data->id, $date, 'jour', 'GrosClient');

                $presentNewNuitQueryClient = Utils::getNewPresenceForZone($data->id, $date, 'nuit', 'client');
                $presentNewNuitQueryInterne = Utils::getNewPresenceForZone($data->id, $date, 'nuit', 'interne');
                $presentNewNuitQueryOperationel = Utils::getNewPresenceForZone($data->id, $date, 'nuit', 'operationnel');
                $presentNewNuitQueryGrosClient = Utils::getNewPresenceForZone($data->id, $date, 'nuit', 'GrosClient');

                $newData = $data->toArray();

                $newData['NuitClient'] = $presentNuitQueryClient . ' / ' . $totalAffecterNuitClient;
                $newData['NuitInterne'] = $presentNuitQueryInterne . ' / ' . $totalAffecterNuitInterne;
                $newData['NuitOperationel'] = $presentNuitQueryOperationel . ' / ' . $totalAffecterNuitOperationel;

                $newData['JourClient'] = $presentJourQueryClient . ' / ' . $totalAffecterJourClient;
                $newData['JourInterne'] = $presentJourQueryInterne . ' / ' . $totalAffecterJourInterne;
                $newData['JourOperationel'] = $presentJourQueryOperationel . ' / ' . $totalAffecterJourOperationel;


                $newData['NuitNewClient'] = $presentNewNuitQueryClient . ' / ' . $totalNewAffecterNuitClient;
                $newData['NuitNewInterne'] = $presentNewNuitQueryInterne . ' / ' . $totalNewAffecterNuitInterne;
                $newData['NuitNewOperationel'] = $presentNewNuitQueryOperationel . ' / ' . $totalNewAffecterNuitOperationel;
                $newData['NuitNewGrosClient'] = $presentNewNuitQueryGrosClient . ' / ' . $totalNewAffecterNuitGrosClient;

                $newData['zone_labelClient'] = $totalNewAffecterJourClientzone_label;
                $newData['zone_labelInterne'] = $totaNewAffecterJourInternezone_label;
                $newData['zone_labelOperationel'] = $totalNewAffecterJourOperationelzone_label;
                $newData['zone_labelGrosClient'] = $totalNewAffecterJourGrosClientzone_label;

                $newData['JourNewClient'] = $presentNewJourQueryClient . ' / ' . $totalNewAffecterJourClient;
                $newData['JourNewInterne'] = $presentNewJourQueryInterne . ' / ' . $totaNewAffecterJourInterne;
                $newData['JourNewOperationel'] = $presentNewJourQueryOperationel . ' / ' . $totalNewAffecterJourOperationel;
                $newData['JourNewGrosClient'] = $presentNewJourQueryGrosClient . ' / ' . $totalNewAffecterJourGrosClient;

                if (!request()->has('valider') && request()->has('valider') == 1) {
                    $presentQuery = Utils::getVacation1ForZone($data->id, $date, 'nuit');
                    $stats = $presentQuery . ' / ' . $totalAffecterNuit;
                    $newData['Nuit'] = $stats;

                    $presentQuery = Utils::getVacation1ForZone($data->id, $date, 'jour');
                    $stats = $presentQuery . ' / ' . $totalAffecterJour;
                    $newData['Jour'] = $stats;
                }
                if (!request()->has('valider') && request()->has('valider') == 2) {
                    $presentQuery = Utils::getVacationForZone($data->id, $date, 'nuit');
                    $stats = $presentQuery . ' / ' . $totalAffecterNuit;
                    $newData['Nuit'] = $stats;

                    $presentQuery = Utils::getVacationForZone($data->id, $date, 'jour');
                    $stats = $presentQuery . ' / ' . $totalAffecterJour;
                    $newData['Jour'] = $stats;
                }

                return $newData;
            });
        $date = now()->format('Y-m-d');
        if (request()->has('date')) {
            $date = request()->get('date');
        }
        $postes = DB::table('clients')
            ->join('sites', 'clients.id', 'sites.client_id')
            ->join('zones', 'zones.id', 'sites.zone_id')
            ->join('postes', 'postes.site_id', 'sites.id')
            ->where('clients.libelle', 'like', '%' . 'total' . '%')
            ->where('zones.libelle', 'like', '%' . 'gentil' . '%')
            ->pluck('postes.id');
        $zoneTotal = [
            'id' => '-1',
            'code' => 'APO',
            'libelle' => 'TOTAL POG',
            'province_id' => 15,
            'created_at' => '2023-07-07T14:08:45.000000Z',
            'updated_at' => null,
            'extra_attributes' => [],
            'deleted_at' => null,
            'identifiants_sadge' => 'age.de.por',
            'creat_by' => null,
            'total_titulaires_therorique' => 235,
            'total_titulaires_reel_jour' => 35,
            'total_titulaires_reel_nuit' => 0,
            'total_present_jour' => 0,
            'total_present_nuit' => 0,
            'ordre' => null,
            'Selectvalue' => '17',
            'Selectlabel' => 'AGENCE DE PORT-GENTIL',
            'Jour' => '0 / 0',
            'Nuit' => '0 / 0',
            'province' => null,
            'NuitClient' => Utils::getPresenceForZone(17, $date, 'nuit', 'client', $postes) . ' / ' . Utils::getEffectifAffecterForZone(17, $date, 'nuit', 'client', $postes),
            'NuitInterne' => Utils::getPresenceForZone(17, $date, 'nuit', 'interne', $postes) . ' / ' . Utils::getEffectifAffecterForZone(17, $date, 'nuit', 'interne', $postes),
            'NuitOperationel' => Utils::getPresenceForZone(17, $date, 'nuit', 'operationnel', $postes) . ' / ' . Utils::getEffectifAffecterForZone(17, $date, 'nuit', 'operationnel', $postes),
            'JourClient' => Utils::getPresenceForZone(17, $date, 'jour', 'client', $postes) . ' / ' . Utils::getEffectifAffecterForZone(17, $date, 'jour', 'client', $postes),
            'JourInterne' => Utils::getPresenceForZone(17, $date, 'jour', 'interne', $postes) . ' / ' . Utils::getEffectifAffecterForZone(17, $date, 'jour', 'interne', $postes),
            'JourOperationel' => Utils::getPresenceForZone(17, $date, 'jour', 'operationnel', $postes) . ' / ' . Utils::getEffectifAffecterForZone(17, $date, 'jour', 'operationnel', $postes),
        ];
        $zonesGet->push($zoneTotal);
        return $zonesGet;
    }

    public function directionsget()
    {
        return Direction::all();
    }

    public function effectifsposteclientcount()
    {
        return DB::table('postes')
                ->whereNull('postes.deleted_at')
                ->whereNull('postes.type')
                ->sum('maxjours') +
            DB::table('postes')
                ->whereNull('postes.deleted_at')
                ->whereNull('postes.type')
                ->sum('maxnuits');
    }

    public function effectifsposteinternecount()
    {
        return DB::table('horaireagents')
            ->join('horaires', 'horaireagents.horaire_id', 'horaires.id')
            ->join('postes', 'horaires.parentId', 'postes.id')
            ->where('horaires.parent', 'poste')
            ->whereNull('horaireagents.deleted_at')
            ->where('postes.type', 'nonimporter')
            ->count();
    }

    public function effectifsposteoperationnelcount()
    {
        return DB::table('horaireagents')
            ->join('horaires', 'horaireagents.horaire_id', 'horaires.id')
            ->join('postes', 'horaires.parentId', 'postes.id')
            ->where('horaires.parent', 'poste')
            ->whereNull('horaireagents.deleted_at')
            ->where('postes.type', 'operationnel')
            ->count();
    }

    public function effectifsposteclientcountzone()
    {
        return DB::table('userszones')
            ->join('zones', 'zones.id', 'userszones.zone_id')
            ->join('sites', 'zones.id', 'sites.zone_id')
            ->join('postes', 'sites.id', 'postes.site_id')
            ->join('horaires', 'postes.id', 'horaires.parentId')
            ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
            ->where('userszones.user_id', Auth::id())
            ->whereNull('postes.type')
            ->whereNull('userszones.deleted_at')
            ->whereNull('postes.deleted_at')
            ->whereNull('horaireagents.deleted_at')
            ->pluck('horaireagents.id')
            ->count();
    }

    public function effectifsposteinternecountzone()
    {
        return DB::table('userszones')
            ->join('zones', 'zones.id', 'userszones.zone_id')
            ->join('sites', 'zones.id', 'sites.zone_id')
            ->join('postes', 'sites.id', 'postes.site_id')
            ->join('horaires', 'postes.id', 'horaires.parentId')
            ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
            ->where('userszones.user_id', Auth::id())
            ->where('postes.type', 'nonimporter')
            ->whereNull('userszones.deleted_at')
            ->whereNull('postes.deleted_at')
            ->whereNull('horaireagents.deleted_at')
            ->pluck('horaireagents.user_id')
            ->count();
    }

    public function effectifsposteoperationnelcountzone()
    {
        return DB::table('userszones')
            ->join('zones', 'zones.id', 'userszones.zone_id')
            ->join('sites', 'zones.id', 'sites.zone_id')
            ->join('postes', 'sites.id', 'postes.site_id')
            ->join('horaires', 'postes.id', 'horaires.parentId')
            ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
            ->where('userszones.user_id', Auth::id())
            ->where('postes.type', 'operationnel')
            ->whereNull('userszones.deleted_at')
            ->whereNull('postes.deleted_at')
            ->whereNull('horaireagents.deleted_at')
            ->pluck('horaireagents.user_id')
            ->count();
    }

    public function clientscount()
    {
        return Client::count();
    }

    public function pointeusescount()
    {
        return Pointeuse::count();
    }
}
