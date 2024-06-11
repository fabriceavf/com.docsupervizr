<?php

namespace App\Http\Actions;

use App\Http\Pointages;
use App\Http\Utils;
use App\Models\Programmation;
use App\Models\Programme;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use stdClass;
use Throwable;

class ProgrammationsActions
{

    public function __construct()
    {
        Carbon::setLocale('fr');
    }


    public function classeElement()
    {

        $interval = [
            5 => 10,
            5 => 10,
        ];
    }

    public function remplacer(Request $request)
    {
        $user_id = $request->get('user_id');
        $programation_id = $request->get('programation_id');
        $remplacant = $request->get('programation_id');

        $programation = Programmation::find($request->get('programmation_id'));


        $oldProg = Programme::where([
            'user_id' => $request->get('ancien', 0),
            'programmation_id' => $request->get('programmation_id'),
        ])->first();


//        dd($oldProg);

        if (!empty($oldProg)) {
//            dd('on enregistre');
            $newProg = $oldProg->replicate();
            $newProg->user_id = $request->get('user_id', 0);
//            $newProg->lundi = $request->get('lundi', -2);
//            $newProg->mardi = $request->get('mardi', -2);
//            $newProg->mercredi = $request->get('mercredi', -2);
//            $newProg->jeudi = $request->get('jeudi', -2);
//            $newProg->vendredi = $request->get('vendredi', -2);
//            $newProg->samedi = $request->get('samedi', -2);
//            $newProg->dimanche = $request->get('dimanche', -2);


            if (!empty($request->get('dimanche'))) {
                $oldProg->dimanche = -2;
            } else {
                $newProg->dimanche = -2;

            }
            if (!empty($request->get('lundi'))) {
                $oldProg->lundi = -2;
            } else {
                $newProg->lundi = -2;

            }
            if (!empty($request->get('mardi'))) {
                $oldProg->mardi = -2;
            } else {
                $newProg->mardi = -2;

            }
            if (!empty($request->get('mercredi'))) {
                $oldProg->mercredi = -2;
            } else {
                $newProg->mercredi = -2;

            }
            if (!empty($request->get('jeudi'))) {
                $oldProg->jeudi = -2;
            } else {
                $newProg->jeudi = -2;

            }
            if (!empty($request->get('vendredi'))) {
                $oldProg->vendredi = -2;
            } else {
                $newProg->vendredi = -2;

            }
            if (!empty($request->get('samedi'))) {
                $oldProg->samedi = -2;
            } else {
                $newProg->samedi = -2;

            }

            $newProg->save();
            $oldProg->save();

//            dd($oldProg$request->all());

        }


    }

    public function dupliquer(Request $request)
    {

        $line = Programmation::find($request->programmation_id);

        $programes = $line->programmes->map(function ($data) {
            $prog = $data->toArray();
            unset($prog['id']);
            unset($prog['created_at']);
            unset($prog['deleted_at']);
            unset($prog['programmation_id']);
            return $prog;
        });
        $newLine = $line->replicate();

        $newLine->semaine = $request->semaine;
        $newLine->user_id = $request->superviseur;
        $newLine->statut = 'En cours';
        $newLine->save();
//        dd($newLine);
//        dd($programes->toArray());
        foreach ($programes as $prog) {
            $newLine->programmes()->create($prog);
        }


        return $newLine;


    }

    public function dupliquerProgrammationsHebdo(Request $request)
    {
        $resultat = Utils::ProgrammationduplicateHebdo($request->id, $request->date_debut, $request->date_fin, $request->libelle, $request->user_id);

        return $resultat;


    }

    public function getVentilations()
    {

        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json(Programmation::count());
        }

        $data = QueryBuilder::for(Programmation::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('semaine'),


                AllowedFilter::exact('superviseur'),


                AllowedFilter::exact('statut'),


                AllowedFilter::exact('actif'),


                AllowedFilter::exact('tache_id'),


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
                        $value = explode(',', $value);
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


                AllowedSort::field('semaine'),


                AllowedSort::field('superviseur'),


                AllowedSort::field('statut'),


                AllowedSort::field('actif'),


                AllowedSort::field('tache_id'),


            ])
            ->allowedIncludes([
                'programmes',


                'ventilations',


                'tache',


            ]);

        if (!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"] == 1) {
            $data = $data->paginate(isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20);
        } else {
            $data = $data->get();
        }
        $donnees = $data->toArray();


        if (!empty($donnees['data']) && is_array($donnees['data'])) {
            $new = [];
            foreach ($donnees['data'] as $response) {

                $taux = Pointages::getTaux($response);

                $response['nbrs_pointage_non_traiter'] = $taux['nonTraiter'];
                $response['nbrs_tout_pointages'] = $taux['all'];
//                dd($response);

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
//                dd($response);
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (Throwable $e) {

                }
            }
        }


        return $donnees;
    }

    public function getTaux(Request $request)
    {

        $programmation = Programmation::find($request->get('key'));
        $taux = Pointages::getTaux($programmation);
        $response = [];
        $response['nbrs_pointage_non_traiter'] = $taux['nonTraiter'];
        $response['nbrs_tout_pointages'] = $taux['all'];
        return $response;


    }

    public function addAgent(Request $request)
    {
        $data = $request->all();
        Utils::ProgrammationAddAgent($data);
    }

    public function addTitulaire(Request $request)
    {
        $data = $request->all();
        if (
            is_array($data) &&
            !empty($data['programmation_id']) &&
            !empty($data['titulaire_id']) &&
            !empty($data['periodes']) &&
            !empty($data['poste'])
        ) {
            $programmation = DB::table('programmations')->find($data['programmation_id']);
            $titulaire_id = $data['titulaire_id'];
            $periodes = $data['periodes'];
            $poste = $data['poste'];
            $date = explode(' ', $programmation->date_debut)[0];
            DB::table('programmationsusers')->updateOrInsert([
                'programmation_id' => $programmation->id,
                'user_id' => $titulaire_id,
            ]);
            $programmationsuser = DB::table("programmationsusers")->where([
                'programmation_id' => $programmation->id,
                'user_id' => $titulaire_id,
            ])->first();

            DB::table('horaires')->updateOrInsert([
                'libelle' => '00H-23H59',
                'debut' => '00:00:00',
                'fin' => '23:59:00',
                'tolerance' => '0',
                'type' => 'Jour',
                'tache_id' => 0,
            ], []);
            $horaire = DB::table('horaires')->where([
                'libelle' => '00H-23H59',
                'debut' => '00:00:00',
                'fin' => '23:59:00',
                'tolerance' => '0',
                'type' => 'Jour',
                'tache_id' => 0,
            ])->first();
            DB::table('programmes')->updateOrInsert([
                'programmationsuser_id' => $programmationsuser->id,
                'date' => $date,
                'debut_prevu' => $date . " 00:00:00",
                'fin_prevu' => $date . " 23:59:00",
                'poste_id' => $poste,
                'horaire_id' => $horaire->id,
            ]);
            $programmation = Programmation::find($programmation->id);
            return $programmation;
        }


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


        $days = $actual->daysInMonth;
        for ($i = 1; $i <= $days; $i++) {
            $jour = Str::padLeft($i, 2, '0');
            $date = $actual->year . '-' . $actual->month . '-' . $jour;
            $labelJour = Carbon::parse($date)->dayName;

            $pointagesDuJourConnuQuery = DB::table('transactions')
                ->whereNull('deleted_at')
                ->whereNotNull('num_badge')
                ->where('punch_date', $date);
            $pointagesDuJourInconnuQuery = DB::table('transactions')
                ->whereNull('deleted_at')
                ->whereNull('matricule')
                ->where(
                    'punch_date', $date);

            $allParams = ['debut' => $date . " 00:00:00", 'fin' => $date . " 23:59:59"];

            if ($pointeuse) {
                $pointagesDuJourInconnuQuery->where('pointeuse_id', $pointeuse);
                $pointagesDuJourConnuQuery->where('pointeuse_id', $pointeuse);
                $allParams['pointeuse_id'] = $pointeuse;
            }
            if ($client) {
//                dd($client);
                $pointagesDuJourInconnuQuery->where('client_id', $client);
                $pointagesDuJourConnuQuery->where('client_id', $client);
                $allParams['client_id'] = $client;
            }
            if ($poste) {
                $pointagesDuJourInconnuQuery->where('poste_id', $poste);
                $pointagesDuJourConnuQuery->where('poste_id', $poste);
                $allParams['poste_id'] = $poste;
            }
            if ($zone) {
                $pointagesDuJourInconnuQuery->where('zone_id', $zone);
                $pointagesDuJourConnuQuery->where('zone_id', $zone);
                $allParams['zone_id'] = $zone;
            }
            $allParams['type'] = 'connu';

            $url1 = "";
            try {
                $url1 = URL::signedRoute('JOURNALS_web_index', $allParams);
            } catch (Throwable $e) {
            }
            if (!Str::is('*127.0.0.1*', $url1)) {
                $url1 = Str::replace('http://', 'https://', $url1);
            }
            $allParams['type'] = 'inconnu';
            $url2 = "";
            try {
                $url2 = URL::signedRoute('JOURNALS_web_index', $allParams);
            } catch (Throwable $e) {
            }
            if (!Str::is('*127.0.0.1*', $url2)) {
                $url2 = Str::replace('http://', 'https://', $url2);
            }
            $obj = new stdClass();
            $obj->jour = $labelJour . ' ' . $i;
            $obj->days = $date;
            $obj->pointages = 0;
            $obj->url = $url1;
            $data[] = $obj;
            $obj = new stdClass();
            $obj->jour = $labelJour . ' ' . $i;
            $obj->days = $date;
            $obj->pointages = 0;
            $obj->url = $url2;
            $data2[] = $obj;


        }
        $obj = new stdClass();
        $obj->connu = $data;
        $obj->inconnu = $data2;
        return $obj;


    }

}
