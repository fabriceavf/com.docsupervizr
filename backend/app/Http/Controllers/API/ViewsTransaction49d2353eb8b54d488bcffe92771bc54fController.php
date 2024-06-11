<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\ViewsTransaction49d2353eb8b54d488bcffe92771bc54f;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

// use App\Repository\prod\ViewsTransactions49d2353eb8b54d488bcffe92771bc54fRepository;


class ViewsTransaction49d2353eb8b54d488bcffe92771bc54fController extends Controller
{

    private $ViewsTransactions49d2353eb8b54d488bcffe92771bc54fRepository;
    private $menu;


    /**
     * Return .
     * @param \Illuminate\Http\Request $request
     * @param App\Repository\prod\ViewsTransactions49d2353eb8b54d488bcffe92771bc54fRepository $ViewsTransactions49d2353eb8b54d488bcffe92771bc54fRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {


    }

    public function agGridData(Request $request)
    {
        $newFilter = $request->get('filterModel', []);
        $extras = $request->get('__extras__', []);
        if (!empty($extras['baseFilter']) && is_array($extras['baseFilter'])) {
            $oldFilter = $request->get('filterModel', []);
            $newFilter = array_merge($oldFilter, $extras['baseFilter']);
        }
        $request->merge(['filterModel' => $newFilter]);
        $query = ViewsTransaction49d2353eb8b54d488bcffe92771bc54f::query();
        if (!empty($extras['filterFields']) && is_array($extras['filterFields']) && !empty($extras['globalSearch'])) {
            $query->where(function ($q1) use ($extras) {

                foreach ($extras['filterFields'] as $key => $ex) {
                    $value = "%" . $extras['globalSearch'] . "%";
                    if ($key == 0) {

                        $q1->where($ex, "LIKE", $value);
                    } else {
                        $q1->orWhere($ex, "LIKE", $value);
                    }

                };

            });


        }
        if (
            class_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras') &&
            method_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras', 'filterAgGridQuery')
        ) {
            \App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('ViewsTransactions49d2353eb8b54d488bcffe92771bc54f', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras') &&
            method_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = \App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
            $data['rowData'] = $_d;
            $data['rowData'] = $_d;
            if ($_d->count() > $data['rowCount']) {
                $data['rowCount'] = $_d->count();
            }
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request, $key, $val)
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

        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json(ViewsTransaction49d2353eb8b54d488bcffe92771bc54f::count());
        }
        $data = QueryBuilder::for(ViewsTransaction49d2353eb8b54d488bcffe92771bc54f::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('bio_id'),


                AllowedFilter::exact('area_alias'),


                AllowedFilter::exact('first_name'),


                AllowedFilter::exact('last_name'),


                AllowedFilter::exact('card_no'),


                AllowedFilter::exact('terminal_alias'),


                AllowedFilter::exact('emp_code'),


                AllowedFilter::exact('punch_date'),


                AllowedFilter::exact('punch_time'),


                AllowedFilter::exact('nom'),


                AllowedFilter::exact('prenom'),


                AllowedFilter::exact('matricule'),


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


                AllowedFilter::exact('online_id'),


                AllowedFilter::exact('faction_id'),


                AllowedFilter::exact('site_id'),


                AllowedFilter::exact('client_id'),


                AllowedFilter::exact('etats'),


                AllowedFilter::exact('identifiants_sadge'),


                AllowedFilter::exact('creat_by'),


                AllowedFilter::exact('annuler'),


                AllowedFilter::exact('type'),


                AllowedFilter::exact('traiter'),


                AllowedFilter::exact('pointeusepostes'),


                AllowedFilter::exact('verification'),


                AllowedFilter::exact('rechercheetape'),


                AllowedFilter::exact('tache'),


                AllowedFilter::exact('poste'),


                AllowedFilter::exact('TachesPotentiels'),


                AllowedFilter::exact('PostesPotentiels'),


                AllowedFilter::exact('TotalPostes'),


                AllowedFilter::exact('TotalPostescouvert'),


                AllowedFilter::exact('TotalPostesnoncouvert'),


                AllowedFilter::exact('TotalPostessouscouvert'),


                AllowedFilter::exact('num_badge'),


                AllowedFilter::exact('date_naissance'),


                AllowedFilter::exact('num_cnss'),


                AllowedFilter::exact('num_cnamgs'),


                AllowedFilter::exact('telephone1'),


                AllowedFilter::exact('telephone2'),


                AllowedFilter::exact('photo'),


                AllowedFilter::exact('date_embauche'),


                AllowedFilter::exact('download_date'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('email'),


                AllowedFilter::exact('email_verified_at'),


                AllowedFilter::exact('password'),


                AllowedFilter::exact('nombre_enfant'),


                AllowedFilter::exact('num_dossier'),


                AllowedFilter::exact('pointeuse_id'),


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


                AllowedSort::field('bio_id'),


                AllowedSort::field('area_alias'),


                AllowedSort::field('first_name'),


                AllowedSort::field('last_name'),


                AllowedSort::field('card_no'),


                AllowedSort::field('terminal_alias'),


                AllowedSort::field('emp_code'),


                AllowedSort::field('punch_date'),


                AllowedSort::field('punch_time'),


                AllowedSort::field('nom'),


                AllowedSort::field('prenom'),


                AllowedSort::field('matricule'),


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


                AllowedSort::field('online_id'),


                AllowedSort::field('faction_id'),


                AllowedSort::field('site_id'),


                AllowedSort::field('client_id'),


                AllowedSort::field('etats'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


                AllowedSort::field('annuler'),


                AllowedSort::field('type'),


                AllowedSort::field('traiter'),


                AllowedSort::field('pointeusepostes'),


                AllowedSort::field('verification'),


                AllowedSort::field('rechercheetape'),


                AllowedSort::field('tache'),


                AllowedSort::field('poste'),


                AllowedSort::field('TachesPotentiels'),


                AllowedSort::field('PostesPotentiels'),


                AllowedSort::field('TotalPostes'),


                AllowedSort::field('TotalPostescouvert'),


                AllowedSort::field('TotalPostesnoncouvert'),


                AllowedSort::field('TotalPostessouscouvert'),


                AllowedSort::field('num_badge'),


                AllowedSort::field('date_naissance'),


                AllowedSort::field('num_cnss'),


                AllowedSort::field('num_cnamgs'),


                AllowedSort::field('telephone1'),


                AllowedSort::field('telephone2'),


                AllowedSort::field('photo'),


                AllowedSort::field('date_embauche'),


                AllowedSort::field('download_date'),


                AllowedSort::field('user_id'),


                AllowedSort::field('email'),


                AllowedSort::field('email_verified_at'),


                AllowedSort::field('password'),


                AllowedSort::field('nombre_enfant'),


                AllowedSort::field('num_dossier'),


                AllowedSort::field('pointeuse_id'),


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


                'pointeuse',


                'poste',


                'sexe',


                'site',


                'situation',


                'user',


                'ville',


                'zone',


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
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (\Throwable $e) {

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


        $data = QueryBuilder::for(ViewsTransaction49d2353eb8b54d488bcffe92771bc54f::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('bio_id'),


                AllowedFilter::exact('area_alias'),


                AllowedFilter::exact('first_name'),


                AllowedFilter::exact('last_name'),


                AllowedFilter::exact('card_no'),


                AllowedFilter::exact('terminal_alias'),


                AllowedFilter::exact('emp_code'),


                AllowedFilter::exact('punch_date'),


                AllowedFilter::exact('punch_time'),


                AllowedFilter::exact('nom'),


                AllowedFilter::exact('prenom'),


                AllowedFilter::exact('matricule'),


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


                AllowedFilter::exact('online_id'),


                AllowedFilter::exact('faction_id'),


                AllowedFilter::exact('site_id'),


                AllowedFilter::exact('client_id'),


                AllowedFilter::exact('etats'),


                AllowedFilter::exact('identifiants_sadge'),


                AllowedFilter::exact('creat_by'),


                AllowedFilter::exact('annuler'),


                AllowedFilter::exact('type'),


                AllowedFilter::exact('traiter'),


                AllowedFilter::exact('pointeusepostes'),


                AllowedFilter::exact('verification'),


                AllowedFilter::exact('rechercheetape'),


                AllowedFilter::exact('tache'),


                AllowedFilter::exact('poste'),


                AllowedFilter::exact('TachesPotentiels'),


                AllowedFilter::exact('PostesPotentiels'),


                AllowedFilter::exact('TotalPostes'),


                AllowedFilter::exact('TotalPostescouvert'),


                AllowedFilter::exact('TotalPostesnoncouvert'),


                AllowedFilter::exact('TotalPostessouscouvert'),


                AllowedFilter::exact('num_badge'),


                AllowedFilter::exact('date_naissance'),


                AllowedFilter::exact('num_cnss'),


                AllowedFilter::exact('num_cnamgs'),


                AllowedFilter::exact('telephone1'),


                AllowedFilter::exact('telephone2'),


                AllowedFilter::exact('photo'),


                AllowedFilter::exact('date_embauche'),


                AllowedFilter::exact('download_date'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('email'),


                AllowedFilter::exact('email_verified_at'),


                AllowedFilter::exact('password'),


                AllowedFilter::exact('nombre_enfant'),


                AllowedFilter::exact('num_dossier'),


                AllowedFilter::exact('pointeuse_id'),


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


                AllowedSort::field('bio_id'),


                AllowedSort::field('area_alias'),


                AllowedSort::field('first_name'),


                AllowedSort::field('last_name'),


                AllowedSort::field('card_no'),


                AllowedSort::field('terminal_alias'),


                AllowedSort::field('emp_code'),


                AllowedSort::field('punch_date'),


                AllowedSort::field('punch_time'),


                AllowedSort::field('nom'),


                AllowedSort::field('prenom'),


                AllowedSort::field('matricule'),


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


                AllowedSort::field('online_id'),


                AllowedSort::field('faction_id'),


                AllowedSort::field('site_id'),


                AllowedSort::field('client_id'),


                AllowedSort::field('etats'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


                AllowedSort::field('annuler'),


                AllowedSort::field('type'),


                AllowedSort::field('traiter'),


                AllowedSort::field('pointeusepostes'),


                AllowedSort::field('verification'),


                AllowedSort::field('rechercheetape'),


                AllowedSort::field('tache'),


                AllowedSort::field('poste'),


                AllowedSort::field('TachesPotentiels'),


                AllowedSort::field('PostesPotentiels'),


                AllowedSort::field('TotalPostes'),


                AllowedSort::field('TotalPostescouvert'),


                AllowedSort::field('TotalPostesnoncouvert'),


                AllowedSort::field('TotalPostessouscouvert'),


                AllowedSort::field('num_badge'),


                AllowedSort::field('date_naissance'),


                AllowedSort::field('num_cnss'),


                AllowedSort::field('num_cnamgs'),


                AllowedSort::field('telephone1'),


                AllowedSort::field('telephone2'),


                AllowedSort::field('photo'),


                AllowedSort::field('date_embauche'),


                AllowedSort::field('download_date'),


                AllowedSort::field('user_id'),


                AllowedSort::field('email'),


                AllowedSort::field('email_verified_at'),


                AllowedSort::field('password'),


                AllowedSort::field('nombre_enfant'),


                AllowedSort::field('num_dossier'),


                AllowedSort::field('pointeuse_id'),


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


                'pointeuse',


                'poste',


                'sexe',


                'site',


                'situation',


                'user',


                'ville',


                'zone',


            ]);

        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json($data->count());
        }

        if (!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"] == 1) {
            $data = $data->paginate(isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20);
        } else {
            $data = $data->get();
        }
        $donnees = $data->toArray();


        if (!empty($donnees['data']) && is_array($donnees['data'])) {
            $new = [];
            foreach ($donnees['data'] as $response) {
                try {

                    foreach ($response['extra_attributes']["extra-data"] as $key => $dat) {
                        $response[$key] = $dat;
                    }
                    $response['extra_attributes'] = false;
                } catch (\Throwable $e) {

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
                } catch (\Throwable $e) {

                }
            }
        }


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


    public function create(Request $request, ViewsTransaction49d2353eb8b54d488bcffe92771bc54f $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f)
    {


        try {
            $can = \App\Helpers\Helpers::can('Creer des ViewsTransactions49d2353eb8b54d488bcffe92771bc54f');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "ViewsTransactions49d2353eb8b54d488bcffe92771bc54f" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'bio_id',
            'area_alias',
            'first_name',
            'last_name',
            'card_no',
            'terminal_alias',
            'emp_code',
            'punch_date',
            'punch_time',
            'nom',
            'prenom',
            'matricule',
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
            'online_id',
            'faction_id',
            'site_id',
            'client_id',
            'created_at',
            'updated_at',
            'etats',
            'deleted_at',
            'identifiants_sadge',
            'creat_by',
            'annuler',
            'type',
            'traiter',
            'pointeusepostes',
            'verification',
            'rechercheetape',
            'tache',
            'poste',
            'TachesPotentiels',
            'PostesPotentiels',
            'TotalPostes',
            'TotalPostescouvert',
            'TotalPostesnoncouvert',
            'TotalPostessouscouvert',
            'extra_attributes',
            'num_badge',
            'date_naissance',
            'num_cnss',
            'num_cnamgs',
            'telephone1',
            'telephone2',
            'photo',
            'date_embauche',
            'download_date',
            'user_id',
            'email',
            'email_verified_at',
            'password',
            'nombre_enfant',
            'num_dossier',
            'pointeuse_id',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'bio_id' => [
                //'required'
            ],


            'area_alias' => [
                //'required'
            ],


            'first_name' => [
                //'required'
            ],


            'last_name' => [
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


            'nom' => ['required'],


            'prenom' => ['required'],


            'matricule' => [
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


            'online_id' => [
                //'required'
            ],


            'faction_id' => [
                //'required'
            ],


            'site_id' => [
                //'required'
            ],


            'client_id' => [
                //'required'
            ],


            'etats' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
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


            'pointeusepostes' => [
                //'required'
            ],


            'verification' => [
                //'required'
            ],


            'rechercheetape' => [
                //'required'
            ],


            'tache' => [
                //'required'
            ],


            'poste' => [
                //'required'
            ],


            'TachesPotentiels' => [
                //'required'
            ],


            'PostesPotentiels' => [
                //'required'
            ],


            'TotalPostes' => [
                //'required'
            ],


            'TotalPostescouvert' => [
                //'required'
            ],


            'TotalPostesnoncouvert' => [
                //'required'
            ],


            'TotalPostessouscouvert' => [
                //'required'
            ],


            'num_badge' => [
                //'required'
            ],


            'date_naissance' => [
                //'required'
            ],


            'num_cnss' => [
                //'required'
            ],


            'num_cnamgs' => [
                //'required'
            ],


            'telephone1' => [
                //'required'
            ],


            'telephone2' => [
                //'required'
            ],


            'photo' => [
                //'required'
            ],


            'date_embauche' => [
                //'required'
            ],


            'download_date' => [
                //'required'
            ],


            'email' => [
                //'required'
            ],


            'password' => [
                //'required'
            ],


            'nombre_enfant' => [
                //'required'
            ],


            'num_dossier' => [
                //'required'
            ],


            'pointeuse_id' => [
                //'required'
            ],


        ], $messages = [


            'bio_id' => ['cette donnee est obligatoire'],


            'area_alias' => ['cette donnee est obligatoire'],


            'first_name' => ['cette donnee est obligatoire'],


            'last_name' => ['cette donnee est obligatoire'],


            'card_no' => ['cette donnee est obligatoire'],


            'terminal_alias' => ['cette donnee est obligatoire'],


            'emp_code' => ['cette donnee est obligatoire'],


            'punch_date' => ['cette donnee est obligatoire'],


            'punch_time' => ['cette donnee est obligatoire'],


            'nom' => ['cette donnee est obligatoire'],


            'prenom' => ['cette donnee est obligatoire'],


            'matricule' => ['cette donnee est obligatoire'],


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


            'online_id' => ['cette donnee est obligatoire'],


            'faction_id' => ['cette donnee est obligatoire'],


            'site_id' => ['cette donnee est obligatoire'],


            'client_id' => ['cette donnee est obligatoire'],


            'etats' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


            'annuler' => ['cette donnee est obligatoire'],


            'type' => ['cette donnee est obligatoire'],


            'traiter' => ['cette donnee est obligatoire'],


            'pointeusepostes' => ['cette donnee est obligatoire'],


            'verification' => ['cette donnee est obligatoire'],


            'rechercheetape' => ['cette donnee est obligatoire'],


            'tache' => ['cette donnee est obligatoire'],


            'poste' => ['cette donnee est obligatoire'],


            'TachesPotentiels' => ['cette donnee est obligatoire'],


            'PostesPotentiels' => ['cette donnee est obligatoire'],


            'TotalPostes' => ['cette donnee est obligatoire'],


            'TotalPostescouvert' => ['cette donnee est obligatoire'],


            'TotalPostesnoncouvert' => ['cette donnee est obligatoire'],


            'TotalPostessouscouvert' => ['cette donnee est obligatoire'],


            'num_badge' => ['cette donnee est obligatoire'],


            'date_naissance' => ['cette donnee est obligatoire'],


            'num_cnss' => ['cette donnee est obligatoire'],


            'num_cnamgs' => ['cette donnee est obligatoire'],


            'telephone1' => ['cette donnee est obligatoire'],


            'telephone2' => ['cette donnee est obligatoire'],


            'photo' => ['cette donnee est obligatoire'],


            'date_embauche' => ['cette donnee est obligatoire'],


            'download_date' => ['cette donnee est obligatoire'],


            'email' => ['cette donnee est obligatoire'],


            'password' => ['cette donnee est obligatoire'],


            'nombre_enfant' => ['cette donnee est obligatoire'],


            'num_dossier' => ['cette donnee est obligatoire'],


            'pointeuse_id' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['bio_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->bio_id = $data['bio_id'];

        }


        if (!empty($data['area_alias'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->area_alias = $data['area_alias'];

        }


        if (!empty($data['first_name'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->first_name = $data['first_name'];

        }


        if (!empty($data['last_name'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->last_name = $data['last_name'];

        }


        if (!empty($data['card_no'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->card_no = $data['card_no'];

        }


        if (!empty($data['terminal_alias'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->terminal_alias = $data['terminal_alias'];

        }


        if (!empty($data['emp_code'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->emp_code = $data['emp_code'];

        }


        if (!empty($data['punch_date'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_date = $data['punch_date'];

        }


        if (!empty($data['punch_time'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_time = $data['punch_time'];

        }


        if (!empty($data['nom'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nom = $data['nom'];

        }


        if (!empty($data['prenom'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->prenom = $data['prenom'];

        }


        if (!empty($data['matricule'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matricule = $data['matricule'];

        }


        if (!empty($data['actif_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->actif_id = $data['actif_id'];

        }


        if (!empty($data['nationalite_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nationalite_id = $data['nationalite_id'];

        }


        if (!empty($data['contrat_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->contrat_id = $data['contrat_id'];

        }


        if (!empty($data['direction_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->direction_id = $data['direction_id'];

        }


        if (!empty($data['categorie_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->categorie_id = $data['categorie_id'];

        }


        if (!empty($data['echelon_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->echelon_id = $data['echelon_id'];

        }


        if (!empty($data['sexe_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->sexe_id = $data['sexe_id'];

        }


        if (!empty($data['matrimoniale_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matrimoniale_id = $data['matrimoniale_id'];

        }


        if (!empty($data['poste_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste_id = $data['poste_id'];

        }


        if (!empty($data['ville_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->ville_id = $data['ville_id'];

        }


        if (!empty($data['zone_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->zone_id = $data['zone_id'];

        }


        if (!empty($data['situation_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->situation_id = $data['situation_id'];

        }


        if (!empty($data['balise_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->balise_id = $data['balise_id'];

        }


        if (!empty($data['fonction_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->fonction_id = $data['fonction_id'];

        }


        if (!empty($data['online_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->online_id = $data['online_id'];

        }


        if (!empty($data['faction_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->faction_id = $data['faction_id'];

        }


        if (!empty($data['site_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->site_id = $data['site_id'];

        }


        if (!empty($data['client_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->client_id = $data['client_id'];

        }


        if (!empty($data['etats'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->etats = $data['etats'];

        }


        if (!empty($data['identifiants_sadge'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->identifiants_sadge = $data['identifiants_sadge'];

        }


        if (!empty($data['creat_by'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->creat_by = $data['creat_by'];

        }


        if (!empty($data['annuler'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->annuler = $data['annuler'];

        }


        if (!empty($data['type'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->type = $data['type'];

        }


        if (!empty($data['traiter'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->traiter = $data['traiter'];

        }


        if (!empty($data['pointeusepostes'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeusepostes = $data['pointeusepostes'];

        }


        if (!empty($data['verification'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->verification = $data['verification'];

        }


        if (!empty($data['rechercheetape'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->rechercheetape = $data['rechercheetape'];

        }


        if (!empty($data['tache'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->tache = $data['tache'];

        }


        if (!empty($data['poste'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste = $data['poste'];

        }


        if (!empty($data['TachesPotentiels'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TachesPotentiels = $data['TachesPotentiels'];

        }


        if (!empty($data['PostesPotentiels'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->PostesPotentiels = $data['PostesPotentiels'];

        }


        if (!empty($data['TotalPostes'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostes = $data['TotalPostes'];

        }


        if (!empty($data['TotalPostescouvert'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostescouvert = $data['TotalPostescouvert'];

        }


        if (!empty($data['TotalPostesnoncouvert'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostesnoncouvert = $data['TotalPostesnoncouvert'];

        }


        if (!empty($data['TotalPostessouscouvert'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostessouscouvert = $data['TotalPostessouscouvert'];

        }


        if (!empty($data['num_badge'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_badge = $data['num_badge'];

        }


        if (!empty($data['date_naissance'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_naissance = $data['date_naissance'];

        }


        if (!empty($data['num_cnss'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnss = $data['num_cnss'];

        }


        if (!empty($data['num_cnamgs'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnamgs = $data['num_cnamgs'];

        }


        if (!empty($data['telephone1'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone1 = $data['telephone1'];

        }


        if (!empty($data['telephone2'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone2 = $data['telephone2'];

        }


        if (!empty($data['photo'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->photo = $data['photo'];

        }


        if (!empty($data['date_embauche'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_embauche = $data['date_embauche'];

        }


        if (!empty($data['download_date'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->download_date = $data['download_date'];

        }


        if (!empty($data['user_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->user_id = $data['user_id'];

        }


        if (!empty($data['email'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->email = $data['email'];

        }


        if (!empty($data['password'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->password = $data['password'];

        }


        if (!empty($data['nombre_enfant'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nombre_enfant = $data['nombre_enfant'];

        }


        if (!empty($data['num_dossier'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_dossier = $data['num_dossier'];

        }


        if (!empty($data['pointeuse_id'])) {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeuse_id = $data['pointeuse_id'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->extra_attributes["extra-data"] = $dat;


        } catch (\Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras') &&
            method_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras', 'beforeSaveCreate')
        ) {
            \App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras::beforeSaveCreate($request, $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras') &&
            method_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras', 'canCreate')
        ) {
            try {
                $canSave = \App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras::canCreate($request, $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->save();
        } else {
            return response()->json($ViewsTransactions49d2353eb8b54d488bcffe92771bc54f, 200);
        }

        $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f = ViewsTransaction49d2353eb8b54d488bcffe92771bc54f::find($ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->id);
        $newCrudData = [];

        $newCrudData['bio_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->bio_id;
        $newCrudData['area_alias'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->area_alias;
        $newCrudData['first_name'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->first_name;
        $newCrudData['last_name'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->last_name;
        $newCrudData['card_no'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->card_no;
        $newCrudData['terminal_alias'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->terminal_alias;
        $newCrudData['emp_code'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->emp_code;
        $newCrudData['punch_date'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_date;
        $newCrudData['punch_time'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_time;
        $newCrudData['nom'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nom;
        $newCrudData['prenom'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->prenom;
        $newCrudData['matricule'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matricule;
        $newCrudData['actif_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->actif_id;
        $newCrudData['nationalite_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nationalite_id;
        $newCrudData['contrat_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->contrat_id;
        $newCrudData['direction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->direction_id;
        $newCrudData['categorie_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->categorie_id;
        $newCrudData['echelon_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->echelon_id;
        $newCrudData['sexe_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->sexe_id;
        $newCrudData['matrimoniale_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matrimoniale_id;
        $newCrudData['poste_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste_id;
        $newCrudData['ville_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->ville_id;
        $newCrudData['zone_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->zone_id;
        $newCrudData['situation_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->situation_id;
        $newCrudData['balise_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->balise_id;
        $newCrudData['fonction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->fonction_id;
        $newCrudData['online_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->online_id;
        $newCrudData['faction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->faction_id;
        $newCrudData['site_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->site_id;
        $newCrudData['client_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->client_id;
        $newCrudData['etats'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->etats;
        $newCrudData['identifiants_sadge'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->identifiants_sadge;
        $newCrudData['creat_by'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->creat_by;
        $newCrudData['annuler'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->annuler;
        $newCrudData['type'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->type;
        $newCrudData['traiter'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->traiter;
        $newCrudData['pointeusepostes'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeusepostes;
        $newCrudData['verification'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->verification;
        $newCrudData['rechercheetape'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->rechercheetape;
        $newCrudData['tache'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->tache;
        $newCrudData['poste'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste;
        $newCrudData['TachesPotentiels'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TachesPotentiels;
        $newCrudData['PostesPotentiels'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->PostesPotentiels;
        $newCrudData['TotalPostes'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostes;
        $newCrudData['TotalPostescouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostescouvert;
        $newCrudData['TotalPostesnoncouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostesnoncouvert;
        $newCrudData['TotalPostessouscouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostessouscouvert;
        $newCrudData['num_badge'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_badge;
        $newCrudData['date_naissance'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_naissance;
        $newCrudData['num_cnss'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnss;
        $newCrudData['num_cnamgs'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnamgs;
        $newCrudData['telephone1'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone1;
        $newCrudData['telephone2'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone2;
        $newCrudData['photo'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->photo;
        $newCrudData['date_embauche'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_embauche;
        $newCrudData['download_date'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->download_date;
        $newCrudData['user_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->user_id;
        $newCrudData['email'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->email;
        $newCrudData['password'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->password;
        $newCrudData['nombre_enfant'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nombre_enfant;
        $newCrudData['num_dossier'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_dossier;
        $newCrudData['pointeuse_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeuse_id;

        try {
            $newCrudData['actif'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['client'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'ViewsTransactions49d2353eb8b54d488bcffe92771bc54f', 'entite_cle' => $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->toArray();


        try {

            foreach ($ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (\Throwable $e) {
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


    public function update(Request $request, ViewsTransaction49d2353eb8b54d488bcffe92771bc54f $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f)
    {
        try {
            $can = \App\Helpers\Helpers::can('Editer des ViewsTransactions49d2353eb8b54d488bcffe92771bc54f');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['bio_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->bio_id;
        $oldCrudData['area_alias'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->area_alias;
        $oldCrudData['first_name'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->first_name;
        $oldCrudData['last_name'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->last_name;
        $oldCrudData['card_no'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->card_no;
        $oldCrudData['terminal_alias'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->terminal_alias;
        $oldCrudData['emp_code'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->emp_code;
        $oldCrudData['punch_date'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_date;
        $oldCrudData['punch_time'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_time;
        $oldCrudData['nom'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nom;
        $oldCrudData['prenom'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->prenom;
        $oldCrudData['matricule'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matricule;
        $oldCrudData['actif_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->actif_id;
        $oldCrudData['nationalite_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nationalite_id;
        $oldCrudData['contrat_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->contrat_id;
        $oldCrudData['direction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->direction_id;
        $oldCrudData['categorie_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->categorie_id;
        $oldCrudData['echelon_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->echelon_id;
        $oldCrudData['sexe_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->sexe_id;
        $oldCrudData['matrimoniale_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matrimoniale_id;
        $oldCrudData['poste_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste_id;
        $oldCrudData['ville_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->ville_id;
        $oldCrudData['zone_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->zone_id;
        $oldCrudData['situation_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->situation_id;
        $oldCrudData['balise_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->balise_id;
        $oldCrudData['fonction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->fonction_id;
        $oldCrudData['online_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->online_id;
        $oldCrudData['faction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->faction_id;
        $oldCrudData['site_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->site_id;
        $oldCrudData['client_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->client_id;
        $oldCrudData['etats'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->etats;
        $oldCrudData['identifiants_sadge'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->identifiants_sadge;
        $oldCrudData['creat_by'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->creat_by;
        $oldCrudData['annuler'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->annuler;
        $oldCrudData['type'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->type;
        $oldCrudData['traiter'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->traiter;
        $oldCrudData['pointeusepostes'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeusepostes;
        $oldCrudData['verification'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->verification;
        $oldCrudData['rechercheetape'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->rechercheetape;
        $oldCrudData['tache'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->tache;
        $oldCrudData['poste'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste;
        $oldCrudData['TachesPotentiels'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TachesPotentiels;
        $oldCrudData['PostesPotentiels'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->PostesPotentiels;
        $oldCrudData['TotalPostes'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostes;
        $oldCrudData['TotalPostescouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostescouvert;
        $oldCrudData['TotalPostesnoncouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostesnoncouvert;
        $oldCrudData['TotalPostessouscouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostessouscouvert;
        $oldCrudData['num_badge'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_badge;
        $oldCrudData['date_naissance'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_naissance;
        $oldCrudData['num_cnss'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnss;
        $oldCrudData['num_cnamgs'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnamgs;
        $oldCrudData['telephone1'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone1;
        $oldCrudData['telephone2'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone2;
        $oldCrudData['photo'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->photo;
        $oldCrudData['date_embauche'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_embauche;
        $oldCrudData['download_date'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->download_date;
        $oldCrudData['user_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->user_id;
        $oldCrudData['email'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->email;
        $oldCrudData['password'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->password;
        $oldCrudData['nombre_enfant'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nombre_enfant;
        $oldCrudData['num_dossier'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_dossier;
        $oldCrudData['pointeuse_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeuse_id;

        try {
            $oldCrudData['actif'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['balise'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['categorie'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['client'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['contrat'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['direction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['echelon'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['faction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['fonction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['matrimoniale'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['nationalite'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['online'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['pointeuse'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['poste'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['sexe'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['site'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['situation'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['ville'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->zone->Selectlabel;
        } catch (\Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "ViewsTransactions49d2353eb8b54d488bcffe92771bc54f" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'bio_id',
            'area_alias',
            'first_name',
            'last_name',
            'card_no',
            'terminal_alias',
            'emp_code',
            'punch_date',
            'punch_time',
            'nom',
            'prenom',
            'matricule',
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
            'online_id',
            'faction_id',
            'site_id',
            'client_id',
            'created_at',
            'updated_at',
            'etats',
            'deleted_at',
            'identifiants_sadge',
            'creat_by',
            'annuler',
            'type',
            'traiter',
            'pointeusepostes',
            'verification',
            'rechercheetape',
            'tache',
            'poste',
            'TachesPotentiels',
            'PostesPotentiels',
            'TotalPostes',
            'TotalPostescouvert',
            'TotalPostesnoncouvert',
            'TotalPostessouscouvert',
            'extra_attributes',
            'num_badge',
            'date_naissance',
            'num_cnss',
            'num_cnamgs',
            'telephone1',
            'telephone2',
            'photo',
            'date_embauche',
            'download_date',
            'user_id',
            'email',
            'email_verified_at',
            'password',
            'nombre_enfant',
            'num_dossier',
            'pointeuse_id',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'bio_id' => [
                //'required'
            ],


            'area_alias' => [
                //'required'
            ],


            'first_name' => [
                //'required'
            ],


            'last_name' => [
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


            'nom' => ['required'],


            'prenom' => ['required'],


            'matricule' => [
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


            'online_id' => [
                //'required'
            ],


            'faction_id' => [
                //'required'
            ],


            'site_id' => [
                //'required'
            ],


            'client_id' => [
                //'required'
            ],


            'etats' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
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


            'pointeusepostes' => [
                //'required'
            ],


            'verification' => [
                //'required'
            ],


            'rechercheetape' => [
                //'required'
            ],


            'tache' => [
                //'required'
            ],


            'poste' => [
                //'required'
            ],


            'TachesPotentiels' => [
                //'required'
            ],


            'PostesPotentiels' => [
                //'required'
            ],


            'TotalPostes' => [
                //'required'
            ],


            'TotalPostescouvert' => [
                //'required'
            ],


            'TotalPostesnoncouvert' => [
                //'required'
            ],


            'TotalPostessouscouvert' => [
                //'required'
            ],


            'num_badge' => [
                //'required'
            ],


            'date_naissance' => [
                //'required'
            ],


            'num_cnss' => [
                //'required'
            ],


            'num_cnamgs' => [
                //'required'
            ],


            'telephone1' => [
                //'required'
            ],


            'telephone2' => [
                //'required'
            ],


            'photo' => [
                //'required'
            ],


            'date_embauche' => [
                //'required'
            ],


            'download_date' => [
                //'required'
            ],


            'email' => [
                //'required'
            ],


            'password' => [
                //'required'
            ],


            'nombre_enfant' => [
                //'required'
            ],


            'num_dossier' => [
                //'required'
            ],


            'pointeuse_id' => [
                //'required'
            ],


        ], $messages = [


            'bio_id' => ['cette donnee est obligatoire'],


            'area_alias' => ['cette donnee est obligatoire'],


            'first_name' => ['cette donnee est obligatoire'],


            'last_name' => ['cette donnee est obligatoire'],


            'card_no' => ['cette donnee est obligatoire'],


            'terminal_alias' => ['cette donnee est obligatoire'],


            'emp_code' => ['cette donnee est obligatoire'],


            'punch_date' => ['cette donnee est obligatoire'],


            'punch_time' => ['cette donnee est obligatoire'],


            'nom' => ['cette donnee est obligatoire'],


            'prenom' => ['cette donnee est obligatoire'],


            'matricule' => ['cette donnee est obligatoire'],


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


            'online_id' => ['cette donnee est obligatoire'],


            'faction_id' => ['cette donnee est obligatoire'],


            'site_id' => ['cette donnee est obligatoire'],


            'client_id' => ['cette donnee est obligatoire'],


            'etats' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


            'annuler' => ['cette donnee est obligatoire'],


            'type' => ['cette donnee est obligatoire'],


            'traiter' => ['cette donnee est obligatoire'],


            'pointeusepostes' => ['cette donnee est obligatoire'],


            'verification' => ['cette donnee est obligatoire'],


            'rechercheetape' => ['cette donnee est obligatoire'],


            'tache' => ['cette donnee est obligatoire'],


            'poste' => ['cette donnee est obligatoire'],


            'TachesPotentiels' => ['cette donnee est obligatoire'],


            'PostesPotentiels' => ['cette donnee est obligatoire'],


            'TotalPostes' => ['cette donnee est obligatoire'],


            'TotalPostescouvert' => ['cette donnee est obligatoire'],


            'TotalPostesnoncouvert' => ['cette donnee est obligatoire'],


            'TotalPostessouscouvert' => ['cette donnee est obligatoire'],


            'num_badge' => ['cette donnee est obligatoire'],


            'date_naissance' => ['cette donnee est obligatoire'],


            'num_cnss' => ['cette donnee est obligatoire'],


            'num_cnamgs' => ['cette donnee est obligatoire'],


            'telephone1' => ['cette donnee est obligatoire'],


            'telephone2' => ['cette donnee est obligatoire'],


            'photo' => ['cette donnee est obligatoire'],


            'date_embauche' => ['cette donnee est obligatoire'],


            'download_date' => ['cette donnee est obligatoire'],


            'email' => ['cette donnee est obligatoire'],


            'password' => ['cette donnee est obligatoire'],


            'nombre_enfant' => ['cette donnee est obligatoire'],


            'num_dossier' => ['cette donnee est obligatoire'],


            'pointeuse_id' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("bio_id", $data)) {


            if (!empty($data['bio_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->bio_id = $data['bio_id'];

            }

        }


        if (array_key_exists("area_alias", $data)) {


            if (!empty($data['area_alias'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->area_alias = $data['area_alias'];

            }

        }


        if (array_key_exists("first_name", $data)) {


            if (!empty($data['first_name'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->first_name = $data['first_name'];

            }

        }


        if (array_key_exists("last_name", $data)) {


            if (!empty($data['last_name'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->last_name = $data['last_name'];

            }

        }


        if (array_key_exists("card_no", $data)) {


            if (!empty($data['card_no'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->card_no = $data['card_no'];

            }

        }


        if (array_key_exists("terminal_alias", $data)) {


            if (!empty($data['terminal_alias'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->terminal_alias = $data['terminal_alias'];

            }

        }


        if (array_key_exists("emp_code", $data)) {


            if (!empty($data['emp_code'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->emp_code = $data['emp_code'];

            }

        }


        if (array_key_exists("punch_date", $data)) {


            if (!empty($data['punch_date'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_date = $data['punch_date'];

            }

        }


        if (array_key_exists("punch_time", $data)) {


            if (!empty($data['punch_time'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_time = $data['punch_time'];

            }

        }


        if (array_key_exists("nom", $data)) {


            if (!empty($data['nom'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nom = $data['nom'];

            }

        }


        if (array_key_exists("prenom", $data)) {


            if (!empty($data['prenom'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->prenom = $data['prenom'];

            }

        }


        if (array_key_exists("matricule", $data)) {


            if (!empty($data['matricule'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matricule = $data['matricule'];

            }

        }


        if (array_key_exists("actif_id", $data)) {


            if (!empty($data['actif_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->actif_id = $data['actif_id'];

            }

        }


        if (array_key_exists("nationalite_id", $data)) {


            if (!empty($data['nationalite_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nationalite_id = $data['nationalite_id'];

            }

        }


        if (array_key_exists("contrat_id", $data)) {


            if (!empty($data['contrat_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->contrat_id = $data['contrat_id'];

            }

        }


        if (array_key_exists("direction_id", $data)) {


            if (!empty($data['direction_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->direction_id = $data['direction_id'];

            }

        }


        if (array_key_exists("categorie_id", $data)) {


            if (!empty($data['categorie_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->categorie_id = $data['categorie_id'];

            }

        }


        if (array_key_exists("echelon_id", $data)) {


            if (!empty($data['echelon_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->echelon_id = $data['echelon_id'];

            }

        }


        if (array_key_exists("sexe_id", $data)) {


            if (!empty($data['sexe_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->sexe_id = $data['sexe_id'];

            }

        }


        if (array_key_exists("matrimoniale_id", $data)) {


            if (!empty($data['matrimoniale_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matrimoniale_id = $data['matrimoniale_id'];

            }

        }


        if (array_key_exists("poste_id", $data)) {


            if (!empty($data['poste_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste_id = $data['poste_id'];

            }

        }


        if (array_key_exists("ville_id", $data)) {


            if (!empty($data['ville_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->ville_id = $data['ville_id'];

            }

        }


        if (array_key_exists("zone_id", $data)) {


            if (!empty($data['zone_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->zone_id = $data['zone_id'];

            }

        }


        if (array_key_exists("situation_id", $data)) {


            if (!empty($data['situation_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->situation_id = $data['situation_id'];

            }

        }


        if (array_key_exists("balise_id", $data)) {


            if (!empty($data['balise_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->balise_id = $data['balise_id'];

            }

        }


        if (array_key_exists("fonction_id", $data)) {


            if (!empty($data['fonction_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->fonction_id = $data['fonction_id'];

            }

        }


        if (array_key_exists("online_id", $data)) {


            if (!empty($data['online_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->online_id = $data['online_id'];

            }

        }


        if (array_key_exists("faction_id", $data)) {


            if (!empty($data['faction_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->faction_id = $data['faction_id'];

            }

        }


        if (array_key_exists("site_id", $data)) {


            if (!empty($data['site_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->site_id = $data['site_id'];

            }

        }


        if (array_key_exists("client_id", $data)) {


            if (!empty($data['client_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->client_id = $data['client_id'];

            }

        }


        if (array_key_exists("etats", $data)) {


            if (!empty($data['etats'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->etats = $data['etats'];

            }

        }


        if (array_key_exists("identifiants_sadge", $data)) {


            if (!empty($data['identifiants_sadge'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->identifiants_sadge = $data['identifiants_sadge'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->creat_by = $data['creat_by'];

            }

        }


        if (array_key_exists("annuler", $data)) {


            if (!empty($data['annuler'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->annuler = $data['annuler'];

            }

        }


        if (array_key_exists("type", $data)) {


            if (!empty($data['type'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->type = $data['type'];

            }

        }


        if (array_key_exists("traiter", $data)) {


            if (!empty($data['traiter'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->traiter = $data['traiter'];

            }

        }


        if (array_key_exists("pointeusepostes", $data)) {


            if (!empty($data['pointeusepostes'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeusepostes = $data['pointeusepostes'];

            }

        }


        if (array_key_exists("verification", $data)) {


            if (!empty($data['verification'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->verification = $data['verification'];

            }

        }


        if (array_key_exists("rechercheetape", $data)) {


            if (!empty($data['rechercheetape'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->rechercheetape = $data['rechercheetape'];

            }

        }


        if (array_key_exists("tache", $data)) {


            if (!empty($data['tache'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->tache = $data['tache'];

            }

        }


        if (array_key_exists("poste", $data)) {


            if (!empty($data['poste'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste = $data['poste'];

            }

        }


        if (array_key_exists("TachesPotentiels", $data)) {


            if (!empty($data['TachesPotentiels'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TachesPotentiels = $data['TachesPotentiels'];

            }

        }


        if (array_key_exists("PostesPotentiels", $data)) {


            if (!empty($data['PostesPotentiels'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->PostesPotentiels = $data['PostesPotentiels'];

            }

        }


        if (array_key_exists("TotalPostes", $data)) {


            if (!empty($data['TotalPostes'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostes = $data['TotalPostes'];

            }

        }


        if (array_key_exists("TotalPostescouvert", $data)) {


            if (!empty($data['TotalPostescouvert'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostescouvert = $data['TotalPostescouvert'];

            }

        }


        if (array_key_exists("TotalPostesnoncouvert", $data)) {


            if (!empty($data['TotalPostesnoncouvert'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostesnoncouvert = $data['TotalPostesnoncouvert'];

            }

        }


        if (array_key_exists("TotalPostessouscouvert", $data)) {


            if (!empty($data['TotalPostessouscouvert'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostessouscouvert = $data['TotalPostessouscouvert'];

            }

        }


        if (array_key_exists("num_badge", $data)) {


            if (!empty($data['num_badge'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_badge = $data['num_badge'];

            }

        }


        if (array_key_exists("date_naissance", $data)) {


            if (!empty($data['date_naissance'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_naissance = $data['date_naissance'];

            }

        }


        if (array_key_exists("num_cnss", $data)) {


            if (!empty($data['num_cnss'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnss = $data['num_cnss'];

            }

        }


        if (array_key_exists("num_cnamgs", $data)) {


            if (!empty($data['num_cnamgs'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnamgs = $data['num_cnamgs'];

            }

        }


        if (array_key_exists("telephone1", $data)) {


            if (!empty($data['telephone1'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone1 = $data['telephone1'];

            }

        }


        if (array_key_exists("telephone2", $data)) {


            if (!empty($data['telephone2'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone2 = $data['telephone2'];

            }

        }


        if (array_key_exists("photo", $data)) {


            if (!empty($data['photo'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->photo = $data['photo'];

            }

        }


        if (array_key_exists("date_embauche", $data)) {


            if (!empty($data['date_embauche'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_embauche = $data['date_embauche'];

            }

        }


        if (array_key_exists("download_date", $data)) {


            if (!empty($data['download_date'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->download_date = $data['download_date'];

            }

        }


        if (array_key_exists("user_id", $data)) {


            if (!empty($data['user_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->user_id = $data['user_id'];

            }

        }


        if (array_key_exists("email", $data)) {


            if (!empty($data['email'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->email = $data['email'];

            }

        }


        if (array_key_exists("password", $data)) {


            if (!empty($data['password'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->password = $data['password'];

            }

        }


        if (array_key_exists("nombre_enfant", $data)) {


            if (!empty($data['nombre_enfant'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nombre_enfant = $data['nombre_enfant'];

            }

        }


        if (array_key_exists("num_dossier", $data)) {


            if (!empty($data['num_dossier'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_dossier = $data['num_dossier'];

            }

        }


        if (array_key_exists("pointeuse_id", $data)) {


            if (!empty($data['pointeuse_id'])) {

                $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeuse_id = $data['pointeuse_id'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->extra_attributes["extra-data"] = $dat;


        } catch (\Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras') &&
            method_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras', 'beforeSaveUpdate')
        ) {
            \App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras::beforeSaveUpdate($request, $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras') &&
            method_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras', 'canUpdate')
        ) {
            try {
                $canSave = \App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras::canUpdate($request, $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->save();
        } else {
            return response()->json($ViewsTransactions49d2353eb8b54d488bcffe92771bc54f, 200);

        }


        $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f = ViewsTransaction49d2353eb8b54d488bcffe92771bc54f::find($ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->id);


        $newCrudData = [];

        $newCrudData['bio_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->bio_id;
        $newCrudData['area_alias'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->area_alias;
        $newCrudData['first_name'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->first_name;
        $newCrudData['last_name'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->last_name;
        $newCrudData['card_no'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->card_no;
        $newCrudData['terminal_alias'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->terminal_alias;
        $newCrudData['emp_code'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->emp_code;
        $newCrudData['punch_date'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_date;
        $newCrudData['punch_time'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_time;
        $newCrudData['nom'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nom;
        $newCrudData['prenom'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->prenom;
        $newCrudData['matricule'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matricule;
        $newCrudData['actif_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->actif_id;
        $newCrudData['nationalite_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nationalite_id;
        $newCrudData['contrat_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->contrat_id;
        $newCrudData['direction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->direction_id;
        $newCrudData['categorie_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->categorie_id;
        $newCrudData['echelon_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->echelon_id;
        $newCrudData['sexe_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->sexe_id;
        $newCrudData['matrimoniale_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matrimoniale_id;
        $newCrudData['poste_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste_id;
        $newCrudData['ville_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->ville_id;
        $newCrudData['zone_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->zone_id;
        $newCrudData['situation_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->situation_id;
        $newCrudData['balise_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->balise_id;
        $newCrudData['fonction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->fonction_id;
        $newCrudData['online_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->online_id;
        $newCrudData['faction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->faction_id;
        $newCrudData['site_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->site_id;
        $newCrudData['client_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->client_id;
        $newCrudData['etats'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->etats;
        $newCrudData['identifiants_sadge'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->identifiants_sadge;
        $newCrudData['creat_by'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->creat_by;
        $newCrudData['annuler'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->annuler;
        $newCrudData['type'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->type;
        $newCrudData['traiter'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->traiter;
        $newCrudData['pointeusepostes'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeusepostes;
        $newCrudData['verification'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->verification;
        $newCrudData['rechercheetape'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->rechercheetape;
        $newCrudData['tache'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->tache;
        $newCrudData['poste'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste;
        $newCrudData['TachesPotentiels'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TachesPotentiels;
        $newCrudData['PostesPotentiels'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->PostesPotentiels;
        $newCrudData['TotalPostes'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostes;
        $newCrudData['TotalPostescouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostescouvert;
        $newCrudData['TotalPostesnoncouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostesnoncouvert;
        $newCrudData['TotalPostessouscouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostessouscouvert;
        $newCrudData['num_badge'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_badge;
        $newCrudData['date_naissance'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_naissance;
        $newCrudData['num_cnss'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnss;
        $newCrudData['num_cnamgs'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnamgs;
        $newCrudData['telephone1'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone1;
        $newCrudData['telephone2'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone2;
        $newCrudData['photo'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->photo;
        $newCrudData['date_embauche'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_embauche;
        $newCrudData['download_date'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->download_date;
        $newCrudData['user_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->user_id;
        $newCrudData['email'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->email;
        $newCrudData['password'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->password;
        $newCrudData['nombre_enfant'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nombre_enfant;
        $newCrudData['num_dossier'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_dossier;
        $newCrudData['pointeuse_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeuse_id;

        try {
            $newCrudData['actif'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['client'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'ViewsTransactions49d2353eb8b54d488bcffe92771bc54f', 'entite_cle' => $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->toArray();


        try {

            foreach ($ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (\Throwable $e) {
        }


        return response()->json($response, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, ViewsTransaction49d2353eb8b54d488bcffe92771bc54f $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f)
    {
        try {
            $can = \App\Helpers\Helpers::can('Supprimer des ViewsTransactions49d2353eb8b54d488bcffe92771bc54f');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['bio_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->bio_id;
        $newCrudData['area_alias'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->area_alias;
        $newCrudData['first_name'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->first_name;
        $newCrudData['last_name'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->last_name;
        $newCrudData['card_no'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->card_no;
        $newCrudData['terminal_alias'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->terminal_alias;
        $newCrudData['emp_code'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->emp_code;
        $newCrudData['punch_date'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_date;
        $newCrudData['punch_time'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->punch_time;
        $newCrudData['nom'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nom;
        $newCrudData['prenom'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->prenom;
        $newCrudData['matricule'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matricule;
        $newCrudData['actif_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->actif_id;
        $newCrudData['nationalite_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nationalite_id;
        $newCrudData['contrat_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->contrat_id;
        $newCrudData['direction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->direction_id;
        $newCrudData['categorie_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->categorie_id;
        $newCrudData['echelon_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->echelon_id;
        $newCrudData['sexe_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->sexe_id;
        $newCrudData['matrimoniale_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matrimoniale_id;
        $newCrudData['poste_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste_id;
        $newCrudData['ville_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->ville_id;
        $newCrudData['zone_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->zone_id;
        $newCrudData['situation_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->situation_id;
        $newCrudData['balise_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->balise_id;
        $newCrudData['fonction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->fonction_id;
        $newCrudData['online_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->online_id;
        $newCrudData['faction_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->faction_id;
        $newCrudData['site_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->site_id;
        $newCrudData['client_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->client_id;
        $newCrudData['etats'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->etats;
        $newCrudData['identifiants_sadge'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->identifiants_sadge;
        $newCrudData['creat_by'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->creat_by;
        $newCrudData['annuler'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->annuler;
        $newCrudData['type'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->type;
        $newCrudData['traiter'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->traiter;
        $newCrudData['pointeusepostes'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeusepostes;
        $newCrudData['verification'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->verification;
        $newCrudData['rechercheetape'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->rechercheetape;
        $newCrudData['tache'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->tache;
        $newCrudData['poste'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste;
        $newCrudData['TachesPotentiels'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TachesPotentiels;
        $newCrudData['PostesPotentiels'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->PostesPotentiels;
        $newCrudData['TotalPostes'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostes;
        $newCrudData['TotalPostescouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostescouvert;
        $newCrudData['TotalPostesnoncouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostesnoncouvert;
        $newCrudData['TotalPostessouscouvert'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->TotalPostessouscouvert;
        $newCrudData['num_badge'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_badge;
        $newCrudData['date_naissance'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_naissance;
        $newCrudData['num_cnss'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnss;
        $newCrudData['num_cnamgs'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_cnamgs;
        $newCrudData['telephone1'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone1;
        $newCrudData['telephone2'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->telephone2;
        $newCrudData['photo'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->photo;
        $newCrudData['date_embauche'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->date_embauche;
        $newCrudData['download_date'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->download_date;
        $newCrudData['user_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->user_id;
        $newCrudData['email'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->email;
        $newCrudData['password'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->password;
        $newCrudData['nombre_enfant'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nombre_enfant;
        $newCrudData['num_dossier'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->num_dossier;
        $newCrudData['pointeuse_id'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeuse_id;

        try {
            $newCrudData['actif'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['client'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'ViewsTransactions49d2353eb8b54d488bcffe92771bc54f', 'entite_cle' => $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras') &&
            method_exists('\App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras', 'canDelete')
        ) {
            try {
                $canSave = \App\Http\Extras\ViewsTransaction49d2353eb8b54d488bcffe92771bc54fExtras::canDelete($request, $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $ViewsTransactions49d2353eb8b54d488bcffe92771bc54f->delete();
        } else {
            return response()->json($ViewsTransactions49d2353eb8b54d488bcffe92771bc54f, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new \App\Http\Actions\ViewsTransactions49d2353eb8b54d488bcffe92771bc54fActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
