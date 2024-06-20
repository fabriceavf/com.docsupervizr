@php use App\Models\Poste; @endphp
@php use App\Models\Tache; @endphp
@php use App\Models\Zone; @endphp
@php use App\Models\Direction; @endphp
@php use App\Models\Typeseffectif; @endphp
@php use App\Models\Client; @endphp
@php use App\Models\Pointeuse; @endphp
@php use App\Models\Import; @endphp
@php use Illuminate\Support\Facades\Auth; @endphp
@php
    use Illuminate\Http\Request;
    use Carbon\CarbonImmutable;
    use Illuminate\Support\Carbon;
    use App\Helpers\Helpers;
    $maxjour = 0;
    $maxnuit = 0;
    $agentsAffecterPostesClientCount = 0;
    try {
        $maxjour = DB::table('postes')
            ->whereNull('postes.deleted_at')
            ->where('postes.typesposte_id', DB::table('typespostes')->where('libelle', 'Poste Clients')->pluck('id'))
            ->sum('maxjours');
        $maxnuit = DB::table('postes')
            ->whereNull('postes.deleted_at')
            ->where('postes.typesposte_id', DB::table('typespostes')->where('libelle', 'Poste Clients')->pluck('id'))
            ->sum('maxnuits');
        $agentsAffecterPostesClientCount = $maxjour + $maxnuit;
    } catch (\Throwable $th) {
        //throw $th;
    }
    // $agentsAffecterPostesClientCount = DB::table('postes')->whereNull('postes.deleted_at')->whereNull('postes.type')->sum('maxjours') + DB::table('postes')->whereNull('postes.deleted_at')->whereNull('postes.type')->sum('maxnuits');

    // $agentsAffecterPostesClientCountZone = DB::table('userszones')->join('zones', 'zones.id', 'userszones.zone_id')->join('sites', 'zones.id', 'sites.zone_id')->join('postes', 'sites.id', 'postes.site_id')->join('horaires', 'postes.id', 'horaires.parentId')->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')->where('userszones.user_id', Auth::id())->whereNull('postes.type')->whereNull('userszones.deleted_at')->whereNull('postes.deleted_at')->whereNull('horaireagents.deleted_at')->where('horaireagents.typesagents','Titulaire')->distinct('horaireagents.user_id')->pluck('horaireagents.user_id')->count();
    $agentsAffecterPostesClientCountZone = 0;
    $maxjourZone = 0;
    $maxnuitZone = 0;

    try {
        // $agentsAffecterPostesClientCountZone = DB::table('userszones')
        //     ->join('zones', 'zones.id', 'userszones.zone_id')
        //     ->join('sites', 'zones.id', 'sites.zone_id')
        //     ->join('postes', 'sites.id', 'postes.site_id')
        //     ->join('horaires', 'postes.id', 'horaires.parentId')
        //     ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
        //     ->where('userszones.user_id', Auth::id())
        //     ->where('postes.typesposte_id', DB::table('typespostes')->where('libelle', 'Poste Clients')->pluck('id'))
        //     ->whereNull('userszones.deleted_at')
        //     ->whereNull('postes.deleted_at')
        //     ->whereNull('horaireagents.deleted_at')
        //     ->where('horaireagents.typesagents', 'Titulaire')
        //     ->distinct('horaireagents.user_id')
        //     ->pluck('horaireagents.user_id')
        //     ->count();
        $maxjourZone = DB::table('postes')
            ->join('sites', 'sites.id', 'postes.site_id')
            ->join('userszones', 'userszones.zone_id', 'sites.zone_id')
            ->where('userszones.user_id', Auth::id())
            ->whereNull('userszones.deleted_at')
            ->whereNull('postes.deleted_at')
            ->where('postes.typesposte_id', DB::table('typespostes')->where('libelle', 'Poste Clients')->pluck('id'))
            ->sum('maxjours');
        $maxnuitZone = DB::table('postes')
            ->join('sites', 'sites.id', 'postes.site_id')
            ->join('userszones', 'userszones.zone_id', 'sites.zone_id')
            ->where('userszones.user_id', Auth::id())
            ->whereNull('postes.deleted_at')
            ->whereNull('userszones.deleted_at')
            ->where('postes.typesposte_id', DB::table('typespostes')->where('libelle', 'Poste Clients')->pluck('id'))
            ->sum('maxnuits');
        $agentsAffecterPostesClientCountZone = $maxjourZone + $maxnuitZone;
    } catch (\Throwable $th) {
        //throw $th;
    }
    // $agentsAffecterPostesInternesCount = DB::table('horaireagents')->join('horaires', 'horaireagents.horaire_id', 'horaires.id')->join('postes', 'horaires.parentId', 'postes.id')->where('horaires.parent', 'poste')->whereNull('horaireagents.deleted_at')->where('horaireagents.typesagents','Titulaire')->where('postes.type', 'nonimporter')->count();
    $agentsAffecterPostesInternesCount = 0;
    try {
        $agentsAffecterPostesInternesCount = DB::table('horaireagents')
            ->join('horaires', 'horaireagents.horaire_id', 'horaires.id')
            ->join('postes', 'horaires.parentId', 'postes.id')
            ->where('horaires.parent', 'poste')
            ->whereNull('horaireagents.deleted_at')
            ->where('horaireagents.typesagents', 'Titulaire')
            ->where('postes.typesposte_id', DB::table('typespostes')->where('libelle', 'Poste Internes')->pluck('id'))
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $agentsRemplacantCount = 0;
    try {
        $agentsRemplacantCount = DB::table('horaireagents')
            ->whereNull('horaireagents.deleted_at')
            ->where('horaireagents.typesagents', 'Remplacant')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $agentsRemplacantCountZone = 0;
    try {
        $agentsRemplacantCountZone = DB::table('horaireagents')
            ->where('horaireagents.typesagents', 'Remplacant')
            ->join('users', 'horaireagents.user_id', 'users.id')
            ->join('horaires', 'horaireagents.horaire_id', 'horaires.id')
            ->join('postes', 'horaires.poste_id', 'postes.id')
            ->join('sites', 'postes.site_id', 'sites.id')
            ->join('userszones', 'sites.zone_id', 'userszones.zone_id')
            ->distinct('horaireagents.user_id')
            ->where('userszones.user_id', Auth::id())
            ->whereNull('users.deleted_at')
            ->whereNull('userszones.deleted_at')
            ->whereNull('horaireagents.deleted_at')
            ->whereNull('horaires.deleted_at')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $agentsCongeCount = 0;
    try {
        $agentsCongeCount = DB::table('horaireagents')
            ->whereNull('horaireagents.deleted_at')
            ->where('horaireagents.typesagents', 'Conge')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $agentsCongeCountZone = 0;
    try {
        $agentsCongeCountZone = DB::table('horaireagents')
            ->where('horaireagents.typesagents', 'Conge')
            ->join('users', 'horaireagents.user_id', 'users.id')
            ->join('horaires', 'horaireagents.horaire_id', 'horaires.id')
            ->join('postes', 'horaires.poste_id', 'postes.id')
            ->join('sites', 'postes.site_id', 'sites.id')
            ->join('userszones', 'sites.zone_id', 'userszones.zone_id')
            ->distinct('horaireagents.user_id')
            ->where('userszones.user_id', Auth::id())
            ->whereNull('users.deleted_at')
            ->whereNull('userszones.deleted_at')
            ->whereNull('horaireagents.deleted_at')
            ->whereNull('horaires.deleted_at')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    // $agentsAffecterPostesInternesCountZone = DB::table('userszones')->join('zones', 'zones.id', 'userszones.zone_id')->join('sites', 'zones.id', 'sites.zone_id')->join('postes', 'sites.id', 'postes.site_id')->join('horaires', 'postes.id', 'horaires.parentId')->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')->where('userszones.user_id', Auth::id())->where('postes.type', 'nonimporter')->whereNull('userszones.deleted_at')->whereNull('postes.deleted_at')->whereNull('horaireagents.deleted_at')->where('horaireagents.typesagents','Titulaire')->distinct('horaireagents.user_id')->pluck('horaireagents.user_id')->count();
    $agentsAffecterPostesInternesCountZone = 0;
    try {
        $agentsAffecterPostesInternesCountZone = DB::table('userszones')
            ->join('zones', 'zones.id', 'userszones.zone_id')
            ->join('sites', 'zones.id', 'sites.zone_id')
            ->join('postes', 'sites.id', 'postes.site_id')
            ->join('horaires', 'postes.id', 'horaires.parentId')
            ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
            ->where('userszones.user_id', Auth::id())
            ->where('postes.typesposte_id', DB::table('typespostes')->where('libelle', 'Poste Internes')->pluck('id'))
            ->whereNull('userszones.deleted_at')
            ->whereNull('postes.deleted_at')
            ->whereNull('horaireagents.deleted_at')
            // ->where('horaireagents.typesagents', 'Titulaire')
            ->distinct('horaireagents.user_id')
            ->pluck('horaireagents.user_id')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    // $agentsAffecterPostesOperationsCount = DB::table('horaireagents')->join('horaires', 'horaireagents.horaire_id', 'horaires.id')->join('postes', 'horaires.parentId', 'postes.id')->where('horaires.parent', 'poste')->whereNull('horaireagents.deleted_at')->where('horaireagents.typesagents','Titulaire')->where('postes.type', 'operationnel')->count();
    $agentsAffecterPostesOperationsCount = 0;
    try {
        $agentsAffecterPostesOperationsCount = DB::table('horaireagents')
            ->join('horaires', 'horaireagents.horaire_id', 'horaires.id')
            ->join('postes', 'horaires.parentId', 'postes.id')
            ->where('horaires.parent', 'poste')
            ->whereNull('horaireagents.deleted_at')
            ->where('horaireagents.typesagents', 'Titulaire')
            ->where('postes.typesposte_id', DB::table('typespostes')->where('libelle', 'Poste Operations')->pluck('id'))
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    // $agentsAffecterPostesOperationsCountZone = DB::table('userszones')->join('zones', 'zones.id', 'userszones.zone_id')->join('sites', 'zones.id', 'sites.zone_id')->join('postes', 'sites.id', 'postes.site_id')->join('horaires', 'postes.id', 'horaires.parentId')->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')->where('userszones.user_id', Auth::id())->where('postes.type', 'operationnel')->whereNull('userszones.deleted_at')->whereNull('postes.deleted_at')->whereNull('horaireagents.deleted_at')->where('horaireagents.typesagents','Titulaire')->distinct('horaireagents.user_id')->pluck('horaireagents.user_id')->count();
    $agentsAffecterPostesOperationsCountZone = 0;
    try {
        $agentsAffecterPostesOperationsCountZone = DB::table('userszones')
            ->join('zones', 'zones.id', 'userszones.zone_id')
            ->join('sites', 'zones.id', 'sites.zone_id')
            ->join('postes', 'sites.id', 'postes.site_id')
            ->join('horaires', 'postes.id', 'horaires.parentId')
            ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
            ->where('userszones.user_id', Auth::id())
            ->where('postes.typesposte_id', DB::table('typespostes')->where('libelle', 'Poste Operations')->pluck('id'))
            ->whereNull('userszones.deleted_at')
            ->whereNull('postes.deleted_at')
            ->whereNull('horaireagents.deleted_at')
            // ->where('horaireagents.typesagents', 'Titulaire')
            ->distinct('horaireagents.user_id')
            ->pluck('horaireagents.user_id')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }

    $usersSalariesCount = 0;
    try {
        $usersSalariesCount = DB::table('users')
            ->where('typeseffectif_id', DB::table('typeseffectifs')->where('libelle', 'Salaries')->pluck('id'))
            ->whereNull('deleted_at')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $usersONECount = 0;
    try {
        $usersONECount = DB::table('users')
            ->where('typeseffectif_id', DB::table('typeseffectifs')->where('libelle', 'ONE')->pluck('id'))
            ->whereNull('deleted_at')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $usersSalariesAffectesCount = 0;
    try {
        $usersSalariesAffectesCount = DB::table('horaireagents')
            ->distinct('user_id')
            ->whereIn(
                'user_id',
                DB::table('users')
                    ->where('typeseffectif_id', DB::table('typeseffectifs')->where('libelle', 'Salaries')->pluck('id'))
                    ->whereNull('deleted_at')
                    ->pluck('id'),
            )
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $usersONEAffectesCount = 0;
    try {
        $usersONEAffectesCount = DB::table('userszones')
            ->join('zones', 'zones.id', 'userszones.zone_id')
            ->join('sites', 'zones.id', 'sites.zone_id')
            ->join('postes', 'sites.id', 'postes.site_id')
            ->join('horaires', 'postes.id', 'horaires.parentId')
            ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
            ->where('userszones.user_id', Auth::id())
            ->whereNull('userszones.deleted_at')
            ->whereNull('postes.deleted_at')
            ->whereNull('horaireagents.deleted_at')
            ->where('horaireagents.typesagents', 'Titulaire')
            ->distinct('horaireagents.user_id')
            ->whereIn(
                'horaireagents.user_id',
                DB::table('users')
                    ->where('typeseffectif_id', DB::table('typeseffectifs')->where('libelle', 'ONE')->pluck('id'))
                    ->whereNull('deleted_at')
                    ->pluck('id'),
            )
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $usersSalariesAffectesCountZone = 0;
    try {
        $usersSalariesAffectesCountZone = DB::table('userszones')
            ->join('zones', 'zones.id', 'userszones.zone_id')
            ->join('sites', 'zones.id', 'sites.zone_id')
            ->join('postes', 'sites.id', 'postes.site_id')
            ->join('horaires', 'postes.id', 'horaires.parentId')
            ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
            ->where('userszones.user_id', Auth::id())
            ->whereIn(
                'horaireagents.user_id',
                DB::table('users')
                    ->where('typeseffectif_id', DB::table('typeseffectifs')->where('libelle', 'Salaries')->pluck('id'))
                    ->whereNull('users.deleted_at')
                    ->pluck('users.id'),
            )
            ->whereNull('zones.deleted_at')
            ->whereNull('userszones.deleted_at')
            ->whereNull('sites.deleted_at')
            ->whereNull('postes.deleted_at')
            ->distinct('horaireagents.user_id')
            ->where('horaireagents.typesagents', 'Titulaire')
            ->pluck('horaireagents.user_id')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }

    $usersSalariesCountZone = 0;
    try {
        $usersSalariesCountZone = DB::table('userszones')
            ->join('zones', 'zones.id', 'userszones.zone_id')
            ->join('sites', 'zones.id', 'sites.zone_id')
            ->join('postes', 'sites.id', 'postes.site_id')
            ->join('horaires', 'postes.id', 'horaires.parentId')
            ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
            ->where('userszones.user_id', Auth::id())
            ->whereIn(
                'horaireagents.user_id',
                DB::table('users')
                    ->where('typeseffectif_id', DB::table('typeseffectifs')->where('libelle', 'Salaries')->pluck('id'))
                    ->whereNull('users.deleted_at')
                    ->pluck('users.id'),
            )
            ->whereNull('zones.deleted_at')
            ->whereNull('userszones.deleted_at')
            ->whereNull('sites.deleted_at')
            ->whereNull('postes.deleted_at')
            ->distinct('horaireagents.user_id')
            ->pluck('horaireagents.user_id')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }

    $usersONEAffectesCountZone = 0;
    try {
        $usersONEAffectesCountZone = DB::table('userszones')
            ->join('zones', 'zones.id', 'userszones.zone_id')
            ->join('sites', 'zones.id', 'sites.zone_id')
            ->join('postes', 'sites.id', 'postes.site_id')
            ->join('horaires', 'postes.id', 'horaires.parentId')
            ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
            ->where('userszones.user_id', Auth::id())
            ->whereIn(
                'horaireagents.user_id',
                DB::table('users')
                    ->where('typeseffectif_id', DB::table('typeseffectifs')->where('libelle', 'ONE')->pluck('id'))
                    ->whereNull('users.deleted_at')
                    ->pluck('users.id'),
            )
            ->whereNull('zones.deleted_at')
            ->whereNull('userszones.deleted_at')
            ->whereNull('sites.deleted_at')
            ->whereNull('postes.deleted_at')
            ->where('horaireagents.typesagents', 'Titulaire')
            ->distinct('horaireagents.user_id')
            ->pluck('horaireagents.user_id')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $usersOneCountZone = 0;
    try {
        $usersOneCountZone = DB::table('userszones')
            ->join('zones', 'zones.id', 'userszones.zone_id')
            ->join('sites', 'zones.id', 'sites.zone_id')
            ->join('postes', 'sites.id', 'postes.site_id')
            ->join('horaires', 'postes.id', 'horaires.parentId')
            ->join('horaireagents', 'horaires.id', 'horaireagents.horaire_id')
            ->where('userszones.user_id', Auth::id())
            ->whereIn(
                'horaireagents.user_id',
                DB::table('users')
                    ->where('typeseffectif_id', DB::table('typeseffectifs')->where('libelle', 'ONE')->pluck('id'))
                    ->whereNull('users.deleted_at')
                    ->pluck('users.id'),
            )
            ->whereNull('zones.deleted_at')
            ->whereNull('userszones.deleted_at')
            ->whereNull('sites.deleted_at')
            ->whereNull('postes.deleted_at')
            ->distinct('horaireagents.user_id')
            ->pluck('horaireagents.user_id')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $dateImportAgents = 0;
    try {
        $dateImportAgents = Import::where(
            'typeseffectif_id',
            DB::table('typeseffectifs')->where('libelle', 'Salaries')->pluck('id'),
        )
            ->latest('created_at')
            ->value('created_at');
    } catch (\Throwable $th) {
        //throw $th;
    }
    $dateImportAgentsOne = 0;
    try {
        $dateImportAgentsOne = Import::where(
            'typeseffectif_id',
            DB::table('typeseffectifs')->where('libelle', 'ONE')->pluck('id'),
        )
            ->latest('created_at')
            ->value('created_at');
    } catch (\Throwable $th) {
        //throw $th;
    }
    $dateImportPoste = 0;
    try {
        $dateImportPoste = Import::where(
            'typesposte_id',
            DB::table('typespostes')->where('libelle', 'Poste Clients')->pluck('id'),
        )
            ->latest('created_at')
            ->value('created_at');
    } catch (\Throwable $th) {
        //throw $th;
    }
    $postesClientCount = 0;
    try {
        $postesClientCount = Poste::whereNotIn('typesposte_id', [
            DB::table('typespostes')->where('libelle', 'Poste Internes')->pluck('id'),
            DB::table('typespostes')->where('libelle', 'Poste Operations')->pluck('id'),
        ])
            ->orWhereNull('type')
            ->whereNull('deleted_at')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $postesOperationCount = 0;
    try {
        $postesOperationCount = Poste::where(
            'postes.typesposte_id',
            DB::table('typespostes')->where('libelle', 'Poste Operations')->pluck('id'),
        )
            ->whereNull('deleted_at')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }

    $postesInterneCount = 0;
    try {
        $postesInterneCount = Poste::where(
            'postes.typesposte_id',
            DB::table('typespostes')->where('libelle', 'Poste Internes')->pluck('id'),
        )
            ->whereNull('deleted_at')
            ->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $tachesCount = 0;
    try {
        $tachesCount = Tache::count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $postesCount = 0;
    try {
        $postesCount = Poste::whereNull('deleted_at')->count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $zonesCount = 0;
    try {
        $zonesCount = Zone::count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $directionsGet = 0;
    try {
        $directionsGet = Direction::all();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $typeseffectifsGet = 0;
    try {
        // $typeseffectifsGet= Typeseffectif::all();
        $typeseffectifsGet = Typeseffectif::all()->map(function ($data) {
            if (Helpers::getAppName() == 'SGS') {
                // $data['TotalCount'] =  0;

                $data['TotalCount'] = DB::table('users')
                    ->join('horaireagents', 'horaireagents.user_id', 'users.id')
                    ->join('horaires', 'horaireagents.horaire_id', 'horaires.id')
                    ->join('postes', 'horaires.poste_id', 'postes.id')
                    ->join('sites', 'postes.site_id', 'sites.id')
                    ->join('userszones', 'sites.zone_id', 'userszones.zone_id')
                    ->distinct('horaireagents.user_id')
                    ->where('userszones.user_id', Auth::id())
                    ->where('users.typeseffectif_id', $data->id)
                    ->whereNull('userszones.deleted_at')
                    ->whereNull('users.deleted_at')
                    ->whereNull('horaireagents.deleted_at')
                    ->whereNull('horaires.deleted_at')
                    ->whereNull('postes.deleted_at')
                    ->count();

                // $data['TotalCount'] =DB::table('users')
                // ->join('villes', 'villes.id', 'users.ville_id')
                // ->join('zones', 'zones.ville_id', 'villes.id')
                // ->join('userszones', 'zones.id', 'userszones.zone_id')
                // ->distinct('users.id')
                // ->where('users.typeseffectif_id', $data->id)
                // ->where('userszones.user_id', Auth::id())
                // ->whereNull('villes.deleted_at')
                // ->whereNull('zones.deleted_at')
                // ->whereNull('userszones.deleted_at')
                // ->whereNull('users.deleted_at')
                // ->count();
                // $data['TotalAffecterCount'] = 0;
                $data['TotalAffecterCount'] = DB::table('horaireagents')
                    ->join('users', 'horaireagents.user_id', 'users.id')
                    ->join('horaires', 'horaireagents.horaire_id', 'horaires.id')
                    ->join('postes', 'horaires.poste_id', 'postes.id')
                    ->join('sites', 'postes.site_id', 'sites.id')
                    ->join('userszones', 'sites.zone_id', 'userszones.zone_id')
                    ->distinct('horaireagents.user_id')
                    // ->whereIn('horaireagents.user_id',DB::table('users')->where('typeseffectif_id', $data->id)->whereNull('users.deleted_at')->pluck('id'))
                    ->where('users.typeseffectif_id', $data->id)
                    ->where('userszones.user_id', Auth::id())
                    ->whereNull('users.deleted_at')
                    ->whereNull('userszones.deleted_at')
                    ->whereNull('horaireagents.deleted_at')
                    ->whereNull('horaires.deleted_at')
                    ->whereNull('postes.deleted_at')
                    ->count();

                $data['TotalNonAffecterCount'] = DB::table('users')
                    ->whereNotIn(
                        'id',
                        DB::table('horaireagents')->whereNull('horaireagents.deleted_at')->pluck('user_id'),
                    )
                    ->where('users.typeseffectif_id', $data->id)
                    ->whereNull('users.deleted_at')
                    ->count();

                // $data['TotalNonAffecterCount'] = DB::table('users')
                // ->whereNotIn('id', DB::table('horaireagents')->whereNull('horaireagents.deleted_at')->pluck('user_id'))
                // ->where('users.typeseffectif_id', $data->id)
                // ->whereNull('users.deleted_at')
                // ->count();

                $data['TotalNonAffecterCount'] = DB::table('users')
                    ->whereNull('deleted_at')
                    ->where('users.typeseffectif_id', $data->id)
                    ->where(function ($query) {
                        $query->whereNull('postes')->orWhere('postes', '');
                    })
                    ->count();
            } else {
                $data['TotalCount'] = DB::table('users')
                    ->where('typeseffectif_id', $data->id)
                    ->whereNull('deleted_at')
                    ->count();
                $data['TotalAffecterCount'] = DB::table('horaireagents')
                    ->distinct('user_id')
                    ->whereIn(
                        'user_id',
                        DB::table('users')
                            ->where('typeseffectif_id', $data->id)
                            ->whereNull('deleted_at')
                            ->pluck('id'),
                    )
                    ->whereNull('deleted_at')
                    ->count();
                $data['TotalNonAffecterCount'] = $data['TotalCount'] - $data['TotalAffecterCount'];
            }

            // Formater la date
            $dateImports = Import::where('typeseffectif_id', $data->id)
                ->latest('created_at')
                ->value('created_at');
            $data['DateImports'] = $dateImports ? Carbon::parse($dateImports)->format('d/m/Y') : 'date inconnue';

            return $data;
        });
        // dd($typeseffectifsGet);
    } catch (\Throwable $th) {
        //throw $th;
    }
    $clientsCount = 0;
    try {
        $clientsCount = Client::count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    $pointeusesCount = 0;
    try {
        $pointeusesCount = Pointeuse::count();
    } catch (\Throwable $th) {
        //throw $th;
    }
    // extraction des donne de pog

    $postes = 0;
    try {
        $postes = DB::table('clients')
            ->join('sites', 'clients.id', 'sites.client_id')
            ->join('zones', 'zones.id', 'sites.zone_id')
            ->join('postes', 'postes.site_id', 'sites.id')
            ->where('clients.libelle', 'like', '%' . 'total' . '%')
            ->where('zones.libelle', 'like', '%' . 'gentil' . '%')
            ->pluck('postes.id');
    } catch (\Throwable $th) {
        //throw $th;
    }
    $request = request();

    if ($request->query('date')) {
        $date = $request->query('date');
        // dd($date);
    } else {
        $date = now()->format('Y-m-d');
    }
    // Obtenez la date actuelle
    $dateActuelle = Carbon::now();

    // Obtenez la semaine actuelle au format ISO 8601
    $week = $dateActuelle->format('Y-\WW');

    // dd($week);
    if ($request->query('week')) {
        // Récupérer la semaine fournie par l'entrée de type week
    $week = $request->query('week');

    // Convertir la semaine en date de début de semaine
    $semaine = Str::lower($week);
    $semaine = Str::replace('w', '', $semaine);
    $semaine = explode('-', $semaine);
    $date = Carbon::now();
    $date->setISODate($semaine[0], $semaine[1], 1);
    $weekStart = $date->startOfWeek();
} else {
    // Si aucune semaine n'est fournie, utilisez la semaine actuelle
        $weekStart = now()->startOfWeek();
    }

    $zonesGet = \App\Models\Statszone::where('user_id', Auth::id())->get();

    $programmationsFilter = $zonesGet
        ->flatMap(function ($zone) {
            return [
                $zone->modelslistingjour1,
                $zone->modelslistingnuit1,
                $zone->modelslistingjour2,
                $zone->modelslistingnuit2,
                $zone->modelslistingjour3,
                $zone->modelslistingnuit3,
            ];
        })
        ->map(function ($data) {
            // Si la chaîne contient une virgule, séparez-la en un tableau
            // Sinon, laissez la valeur telle quelle dans un tableau
            return strpos($data, ',') !== false ? explode(',', $data) : [$data];
        })
        ->flatten()
        ->filter()
        ->map(function ($data) {
            return "listings-du-model-$data";
        });

    $days = [];
    $statsByDay = [];
    $dataWeek = [];
    $programmationsStats = [];
    $etat = 3;
    for ($i = 0; $i < 7; $i++) {
        $date = clone $weekStart;
        $date->addDays($i);
        $currentDay = $date->format('Y-m-d');
        $days[] = $currentDay;

        if ($request->query('valider') !== null) {
            $etat = $request->query('valider');
            // dd($etat);

            if ($etat === '0') {
                $programmations = \App\Models\Programmation::whereIn('type', $programmationsFilter)
                    ->where('date_debut', 'like', $days[$i] . '%')
                    ->whereNull('programmations.valider1')
                    ->whereNull('programmations.valider2')
                    ->get();
            } elseif ($etat === '1') {
                // dd($etat);
                $programmations = \App\Models\Programmation::whereIn('type', $programmationsFilter)
                    ->where('date_debut', 'like', $days[$i] . '%')
                    ->whereNotNull('programmations.valider1')
                    ->whereNull('programmations.valider2')
                    ->get();
            } else {
                $programmations = \App\Models\Programmation::whereIn('type', $programmationsFilter)
                    ->where('date_debut', 'like', $days[$i] . '%')
                    ->whereNotNull('programmations.valider1')
                    ->whereNotNull('programmations.valider2')
                    ->get();
            }
        } else {
            $programmations = \App\Models\Programmation::whereIn('type', $programmationsFilter->toArray())
                ->where('date_debut', 'like', $days[$i] . '%')
                ->get();
        }

        $programmationsId = $programmations->pluck('id');
        // $programmes = DB::table('programmes')->join('programmationsusers', 'programmes.programmationsuser_id', 'programmationsusers.id')->whereIn('programmationsusers.programmation_id', $programmationsId)->get();
        $programmes = DB::table('programmes')
            ->join('programmations', 'programmes.programmation_id', 'programmations.id')
            ->whereIn('programmations.id', $programmationsId)
            ->get();

        $programmations = $programmations->map(function ($programmation) use ($programmes) {
            $min_pointage = $programmation->min_pointage;
            if (empty($min_pointage) || $min_pointage == 0) {
                $min_pointage = 1;
            }
            $min_pointage = intval($min_pointage);

            $totals = $programmes->filter(function ($data) use ($programmation) {
                return $data->programmation_id == $programmation->id;
            });
            $present = $programmes->filter(function ($data) use ($programmation, $min_pointage) {
                $isForProgrammation = $data->programmation_id == $programmation->id;
                $present = 0;
                $presence_declarer_auto = $data->presence_declarer_auto;
                if (empty($presence_declarer_auto)) {
                    $presence_declarer_auto = '';
                }
                $presence_declarer_manuel = $data->presence_declarer_manuel;
                if (empty($presence_declarer_manuel)) {
                    $presence_declarer_manuel = '';
                }
                $presence = $presence_declarer_auto . '-' . $presence_declarer_manuel;
                if ($isForProgrammation && in_array($presence, ['oui-oui', 'non-oui', 'oui-', '-oui'])) {
                    $present++;
                }
                return $present > 0;
            });
            $programmation['present'] = $present->count();
            $programmation['abscent'] = $totals->count() - $present->count();
            return $programmation;
        });

        foreach ($programmations as $prog) {
            $cle = $prog->type;
            $programmationsStats[$cle . '_' . $i . '_present'] = $prog->present;
            $programmationsStats[$cle . '_' . $i . '_abscent'] = $prog->abscent;
        }
    }

    $zonesGet = $zonesGet->map(function ($data) use ($programmationsStats, $date, $i, $days) {
        foreach ([1, 2, 3] as $number) {
            foreach (['Jour', 'Nuit'] as $faction) {
                $stats = [];
                $modelListingKey = 'modelslisting' . strtolower($faction) . $number;
                $models = explode(',', $data[$modelListingKey]);

                foreach ([0, 1, 2, 3, 4, 5, 6] as $day) {
                    $present = collect($models)
                        ->map(function ($data) use ($day, $programmationsStats) {
                            $cle = 'listings-du-model-' . $data . '_' . $day . '_present';
                            $result = 0;
                            if (array_key_exists($cle, $programmationsStats)) {
                                $result = $programmationsStats[$cle];
                            }
                            return $result;
                        })
                        ->sum();
                    $abscent = collect($models)
                        ->map(function ($data) use ($day, $programmationsStats) {
                            $cle = 'listings-du-model-' . $data . '_' . $day . '_abscent';
                            $result = 0;
                            if (array_key_exists($cle, $programmationsStats)) {
                                $result = $programmationsStats[$cle];
                            }
                            return $result;
                        })
                        ->sum();
                    $_data_stats_day = [
                        'jour' => $days[$day],
                        'pointagesConnu' => $present,
                        'pointagesInConnu' => $abscent,
                        'url' => '',
                    ];
                    $stats[] = $_data_stats_day;
                }
                $data['option' . $faction . $number] = [
                    'autoSize' => true,
                    'axes' => [
                        [
                            'position' => 'left',
                            'type' => 'number',
                        ],
                        [
                            'label' => [
                                'rotation' => 40,
                            ],
                            'position' => 'bottom',
                            'title' => [
                                'enabled' => true,
                                'text' => '',
                                // 'text' => 'Jour de la semaine',
                            ],
                            'type' => 'category',
                        ],
                    ],
                    'data' => $stats,
                    'footnote' => [],
                    'series' => [
                        [
                            'stacked' => true,
                            'type' => 'column',
                            'xKey' => 'jour',
                            'yKey' => 'pointagesConnu',
                            'yName' => 'present',
                        ],
                        [
                            'stacked' => true,
                            'type' => 'column',
                            'xKey' => 'jour',
                            'yKey' => 'pointagesInConnu',
                            'yName' => 'abscent',
                        ],
                    ],
                    'theme' => [
                        'overrides' => [
                            'bar' => [
                                'series' => [
                                    'strokeWidth' => 0,
                                ],
                            ],
                        ],
                        'palette' => [
                            'fills' => ['#43a72c', '#d7114b', '#9BC53D', '#E55934', '#FA7921'],
                            'strokes' => ['#4086a4', '#b1a235', '#6c8a2b', '#a03e24', '#af5517'],
                        ],
                    ],
                    'title' => [
                        'fontSize' => 18,
                        'spacing' => 25,
                        'text' => $faction,
                        // 'text' => 'Statistiques des pointages',
                    ],
                ];
            }
        }

        return $data;
    });

    // dd($dataWeek);

@endphp
@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

@section('content')
    
    @vite('resources/views/content/Homes/main.js')

@endsection
