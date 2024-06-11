<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\ViewsTransaction6163ba39986346beb3710cd3a4023437;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

// use App\Repository\prod\ViewsTransactions6163ba39986346beb3710cd3a4023437Repository;


class ViewsTransaction6163ba39986346beb3710cd3a4023437Controller extends Controller
{

    private $ViewsTransactions6163ba39986346beb3710cd3a4023437Repository;
    private $menu;


    /**
     * Return .
     * @param \Illuminate\Http\Request $request
     * @param App\Repository\prod\ViewsTransactions6163ba39986346beb3710cd3a4023437Repository $ViewsTransactions6163ba39986346beb3710cd3a4023437Repository
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
        $query = ViewsTransaction6163ba39986346beb3710cd3a4023437::query();
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
            class_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras') &&
            method_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras', 'filterAgGridQuery')
        ) {
            \App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('ViewsTransactions6163ba39986346beb3710cd3a4023437', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras') &&
            method_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = \App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
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
            return response()->json(ViewsTransaction6163ba39986346beb3710cd3a4023437::count());
        }
        $data = QueryBuilder::for(ViewsTransaction6163ba39986346beb3710cd3a4023437::class)
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


        $data = QueryBuilder::for(ViewsTransaction6163ba39986346beb3710cd3a4023437::class)
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


    public function create(Request $request, ViewsTransaction6163ba39986346beb3710cd3a4023437 $ViewsTransactions6163ba39986346beb3710cd3a4023437)
    {


        try {
            $can = \App\Helpers\Helpers::can('Creer des ViewsTransactions6163ba39986346beb3710cd3a4023437');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "ViewsTransactions6163ba39986346beb3710cd3a4023437" . "-" . $key . "_" . time() . "." . $file->extension()
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

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->bio_id = $data['bio_id'];

        }


        if (!empty($data['area_alias'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->area_alias = $data['area_alias'];

        }


        if (!empty($data['first_name'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->first_name = $data['first_name'];

        }


        if (!empty($data['last_name'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->last_name = $data['last_name'];

        }


        if (!empty($data['card_no'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->card_no = $data['card_no'];

        }


        if (!empty($data['terminal_alias'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->terminal_alias = $data['terminal_alias'];

        }


        if (!empty($data['emp_code'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->emp_code = $data['emp_code'];

        }


        if (!empty($data['punch_date'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_date = $data['punch_date'];

        }


        if (!empty($data['punch_time'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_time = $data['punch_time'];

        }


        if (!empty($data['nom'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->nom = $data['nom'];

        }


        if (!empty($data['prenom'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->prenom = $data['prenom'];

        }


        if (!empty($data['matricule'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->matricule = $data['matricule'];

        }


        if (!empty($data['actif_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->actif_id = $data['actif_id'];

        }


        if (!empty($data['nationalite_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->nationalite_id = $data['nationalite_id'];

        }


        if (!empty($data['contrat_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->contrat_id = $data['contrat_id'];

        }


        if (!empty($data['direction_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->direction_id = $data['direction_id'];

        }


        if (!empty($data['categorie_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->categorie_id = $data['categorie_id'];

        }


        if (!empty($data['echelon_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->echelon_id = $data['echelon_id'];

        }


        if (!empty($data['sexe_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->sexe_id = $data['sexe_id'];

        }


        if (!empty($data['matrimoniale_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->matrimoniale_id = $data['matrimoniale_id'];

        }


        if (!empty($data['poste_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste_id = $data['poste_id'];

        }


        if (!empty($data['ville_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->ville_id = $data['ville_id'];

        }


        if (!empty($data['zone_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->zone_id = $data['zone_id'];

        }


        if (!empty($data['situation_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->situation_id = $data['situation_id'];

        }


        if (!empty($data['balise_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->balise_id = $data['balise_id'];

        }


        if (!empty($data['fonction_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->fonction_id = $data['fonction_id'];

        }


        if (!empty($data['online_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->online_id = $data['online_id'];

        }


        if (!empty($data['faction_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->faction_id = $data['faction_id'];

        }


        if (!empty($data['site_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->site_id = $data['site_id'];

        }


        if (!empty($data['client_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->client_id = $data['client_id'];

        }


        if (!empty($data['etats'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->etats = $data['etats'];

        }


        if (!empty($data['identifiants_sadge'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->identifiants_sadge = $data['identifiants_sadge'];

        }


        if (!empty($data['creat_by'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->creat_by = $data['creat_by'];

        }


        if (!empty($data['annuler'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->annuler = $data['annuler'];

        }


        if (!empty($data['type'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->type = $data['type'];

        }


        if (!empty($data['traiter'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->traiter = $data['traiter'];

        }


        if (!empty($data['pointeusepostes'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeusepostes = $data['pointeusepostes'];

        }


        if (!empty($data['verification'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->verification = $data['verification'];

        }


        if (!empty($data['rechercheetape'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->rechercheetape = $data['rechercheetape'];

        }


        if (!empty($data['tache'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->tache = $data['tache'];

        }


        if (!empty($data['poste'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste = $data['poste'];

        }


        if (!empty($data['TachesPotentiels'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->TachesPotentiels = $data['TachesPotentiels'];

        }


        if (!empty($data['PostesPotentiels'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->PostesPotentiels = $data['PostesPotentiels'];

        }


        if (!empty($data['TotalPostes'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostes = $data['TotalPostes'];

        }


        if (!empty($data['TotalPostescouvert'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostescouvert = $data['TotalPostescouvert'];

        }


        if (!empty($data['TotalPostesnoncouvert'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostesnoncouvert = $data['TotalPostesnoncouvert'];

        }


        if (!empty($data['TotalPostessouscouvert'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostessouscouvert = $data['TotalPostessouscouvert'];

        }


        if (!empty($data['num_badge'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_badge = $data['num_badge'];

        }


        if (!empty($data['date_naissance'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_naissance = $data['date_naissance'];

        }


        if (!empty($data['num_cnss'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnss = $data['num_cnss'];

        }


        if (!empty($data['num_cnamgs'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnamgs = $data['num_cnamgs'];

        }


        if (!empty($data['telephone1'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone1 = $data['telephone1'];

        }


        if (!empty($data['telephone2'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone2 = $data['telephone2'];

        }


        if (!empty($data['photo'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->photo = $data['photo'];

        }


        if (!empty($data['date_embauche'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_embauche = $data['date_embauche'];

        }


        if (!empty($data['download_date'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->download_date = $data['download_date'];

        }


        if (!empty($data['user_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->user_id = $data['user_id'];

        }


        if (!empty($data['email'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->email = $data['email'];

        }


        if (!empty($data['password'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->password = $data['password'];

        }


        if (!empty($data['nombre_enfant'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->nombre_enfant = $data['nombre_enfant'];

        }


        if (!empty($data['num_dossier'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_dossier = $data['num_dossier'];

        }


        if (!empty($data['pointeuse_id'])) {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeuse_id = $data['pointeuse_id'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->extra_attributes["extra-data"] = $dat;


        } catch (\Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras') &&
            method_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras', 'beforeSaveCreate')
        ) {
            \App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras::beforeSaveCreate($request, $ViewsTransactions6163ba39986346beb3710cd3a4023437);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras') &&
            method_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras', 'canCreate')
        ) {
            try {
                $canSave = \App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras::canCreate($request, $ViewsTransactions6163ba39986346beb3710cd3a4023437);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $ViewsTransactions6163ba39986346beb3710cd3a4023437->save();
        } else {
            return response()->json($ViewsTransactions6163ba39986346beb3710cd3a4023437, 200);
        }

        $ViewsTransactions6163ba39986346beb3710cd3a4023437 = ViewsTransaction6163ba39986346beb3710cd3a4023437::find($ViewsTransactions6163ba39986346beb3710cd3a4023437->id);
        $newCrudData = [];

        $newCrudData['bio_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->bio_id;
        $newCrudData['area_alias'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->area_alias;
        $newCrudData['first_name'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->first_name;
        $newCrudData['last_name'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->last_name;
        $newCrudData['card_no'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->card_no;
        $newCrudData['terminal_alias'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->terminal_alias;
        $newCrudData['emp_code'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->emp_code;
        $newCrudData['punch_date'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_date;
        $newCrudData['punch_time'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_time;
        $newCrudData['nom'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nom;
        $newCrudData['prenom'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->prenom;
        $newCrudData['matricule'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matricule;
        $newCrudData['actif_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->actif_id;
        $newCrudData['nationalite_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nationalite_id;
        $newCrudData['contrat_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->contrat_id;
        $newCrudData['direction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->direction_id;
        $newCrudData['categorie_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->categorie_id;
        $newCrudData['echelon_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->echelon_id;
        $newCrudData['sexe_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->sexe_id;
        $newCrudData['matrimoniale_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matrimoniale_id;
        $newCrudData['poste_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste_id;
        $newCrudData['ville_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->ville_id;
        $newCrudData['zone_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->zone_id;
        $newCrudData['situation_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->situation_id;
        $newCrudData['balise_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->balise_id;
        $newCrudData['fonction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->fonction_id;
        $newCrudData['online_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->online_id;
        $newCrudData['faction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->faction_id;
        $newCrudData['site_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->site_id;
        $newCrudData['client_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->client_id;
        $newCrudData['etats'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->etats;
        $newCrudData['identifiants_sadge'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->identifiants_sadge;
        $newCrudData['creat_by'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->creat_by;
        $newCrudData['annuler'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->annuler;
        $newCrudData['type'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->type;
        $newCrudData['traiter'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->traiter;
        $newCrudData['pointeusepostes'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeusepostes;
        $newCrudData['verification'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->verification;
        $newCrudData['rechercheetape'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->rechercheetape;
        $newCrudData['tache'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->tache;
        $newCrudData['poste'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste;
        $newCrudData['TachesPotentiels'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TachesPotentiels;
        $newCrudData['PostesPotentiels'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->PostesPotentiels;
        $newCrudData['TotalPostes'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostes;
        $newCrudData['TotalPostescouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostescouvert;
        $newCrudData['TotalPostesnoncouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostesnoncouvert;
        $newCrudData['TotalPostessouscouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostessouscouvert;
        $newCrudData['num_badge'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_badge;
        $newCrudData['date_naissance'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_naissance;
        $newCrudData['num_cnss'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnss;
        $newCrudData['num_cnamgs'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnamgs;
        $newCrudData['telephone1'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone1;
        $newCrudData['telephone2'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone2;
        $newCrudData['photo'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->photo;
        $newCrudData['date_embauche'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_embauche;
        $newCrudData['download_date'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->download_date;
        $newCrudData['user_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->user_id;
        $newCrudData['email'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->email;
        $newCrudData['password'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->password;
        $newCrudData['nombre_enfant'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nombre_enfant;
        $newCrudData['num_dossier'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_dossier;
        $newCrudData['pointeuse_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeuse_id;

        try {
            $newCrudData['actif'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['client'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'ViewsTransactions6163ba39986346beb3710cd3a4023437', 'entite_cle' => $ViewsTransactions6163ba39986346beb3710cd3a4023437->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $ViewsTransactions6163ba39986346beb3710cd3a4023437->toArray();


        try {

            foreach ($ViewsTransactions6163ba39986346beb3710cd3a4023437->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, ViewsTransaction6163ba39986346beb3710cd3a4023437 $ViewsTransactions6163ba39986346beb3710cd3a4023437)
    {
        try {
            $can = \App\Helpers\Helpers::can('Editer des ViewsTransactions6163ba39986346beb3710cd3a4023437');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['bio_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->bio_id;
        $oldCrudData['area_alias'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->area_alias;
        $oldCrudData['first_name'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->first_name;
        $oldCrudData['last_name'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->last_name;
        $oldCrudData['card_no'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->card_no;
        $oldCrudData['terminal_alias'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->terminal_alias;
        $oldCrudData['emp_code'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->emp_code;
        $oldCrudData['punch_date'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_date;
        $oldCrudData['punch_time'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_time;
        $oldCrudData['nom'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nom;
        $oldCrudData['prenom'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->prenom;
        $oldCrudData['matricule'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matricule;
        $oldCrudData['actif_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->actif_id;
        $oldCrudData['nationalite_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nationalite_id;
        $oldCrudData['contrat_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->contrat_id;
        $oldCrudData['direction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->direction_id;
        $oldCrudData['categorie_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->categorie_id;
        $oldCrudData['echelon_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->echelon_id;
        $oldCrudData['sexe_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->sexe_id;
        $oldCrudData['matrimoniale_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matrimoniale_id;
        $oldCrudData['poste_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste_id;
        $oldCrudData['ville_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->ville_id;
        $oldCrudData['zone_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->zone_id;
        $oldCrudData['situation_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->situation_id;
        $oldCrudData['balise_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->balise_id;
        $oldCrudData['fonction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->fonction_id;
        $oldCrudData['online_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->online_id;
        $oldCrudData['faction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->faction_id;
        $oldCrudData['site_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->site_id;
        $oldCrudData['client_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->client_id;
        $oldCrudData['etats'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->etats;
        $oldCrudData['identifiants_sadge'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->identifiants_sadge;
        $oldCrudData['creat_by'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->creat_by;
        $oldCrudData['annuler'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->annuler;
        $oldCrudData['type'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->type;
        $oldCrudData['traiter'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->traiter;
        $oldCrudData['pointeusepostes'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeusepostes;
        $oldCrudData['verification'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->verification;
        $oldCrudData['rechercheetape'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->rechercheetape;
        $oldCrudData['tache'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->tache;
        $oldCrudData['poste'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste;
        $oldCrudData['TachesPotentiels'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TachesPotentiels;
        $oldCrudData['PostesPotentiels'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->PostesPotentiels;
        $oldCrudData['TotalPostes'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostes;
        $oldCrudData['TotalPostescouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostescouvert;
        $oldCrudData['TotalPostesnoncouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostesnoncouvert;
        $oldCrudData['TotalPostessouscouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostessouscouvert;
        $oldCrudData['num_badge'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_badge;
        $oldCrudData['date_naissance'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_naissance;
        $oldCrudData['num_cnss'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnss;
        $oldCrudData['num_cnamgs'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnamgs;
        $oldCrudData['telephone1'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone1;
        $oldCrudData['telephone2'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone2;
        $oldCrudData['photo'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->photo;
        $oldCrudData['date_embauche'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_embauche;
        $oldCrudData['download_date'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->download_date;
        $oldCrudData['user_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->user_id;
        $oldCrudData['email'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->email;
        $oldCrudData['password'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->password;
        $oldCrudData['nombre_enfant'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nombre_enfant;
        $oldCrudData['num_dossier'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_dossier;
        $oldCrudData['pointeuse_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeuse_id;

        try {
            $oldCrudData['actif'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['balise'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['categorie'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['client'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['contrat'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['direction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['echelon'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['faction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['fonction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['matrimoniale'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['nationalite'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['online'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['pointeuse'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['poste'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['sexe'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['site'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['situation'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['ville'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->zone->Selectlabel;
        } catch (\Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "ViewsTransactions6163ba39986346beb3710cd3a4023437" . "-" . $key . "_" . time() . "." . $file->extension()
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

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->bio_id = $data['bio_id'];

            }

        }


        if (array_key_exists("area_alias", $data)) {


            if (!empty($data['area_alias'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->area_alias = $data['area_alias'];

            }

        }


        if (array_key_exists("first_name", $data)) {


            if (!empty($data['first_name'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->first_name = $data['first_name'];

            }

        }


        if (array_key_exists("last_name", $data)) {


            if (!empty($data['last_name'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->last_name = $data['last_name'];

            }

        }


        if (array_key_exists("card_no", $data)) {


            if (!empty($data['card_no'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->card_no = $data['card_no'];

            }

        }


        if (array_key_exists("terminal_alias", $data)) {


            if (!empty($data['terminal_alias'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->terminal_alias = $data['terminal_alias'];

            }

        }


        if (array_key_exists("emp_code", $data)) {


            if (!empty($data['emp_code'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->emp_code = $data['emp_code'];

            }

        }


        if (array_key_exists("punch_date", $data)) {


            if (!empty($data['punch_date'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_date = $data['punch_date'];

            }

        }


        if (array_key_exists("punch_time", $data)) {


            if (!empty($data['punch_time'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_time = $data['punch_time'];

            }

        }


        if (array_key_exists("nom", $data)) {


            if (!empty($data['nom'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->nom = $data['nom'];

            }

        }


        if (array_key_exists("prenom", $data)) {


            if (!empty($data['prenom'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->prenom = $data['prenom'];

            }

        }


        if (array_key_exists("matricule", $data)) {


            if (!empty($data['matricule'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->matricule = $data['matricule'];

            }

        }


        if (array_key_exists("actif_id", $data)) {


            if (!empty($data['actif_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->actif_id = $data['actif_id'];

            }

        }


        if (array_key_exists("nationalite_id", $data)) {


            if (!empty($data['nationalite_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->nationalite_id = $data['nationalite_id'];

            }

        }


        if (array_key_exists("contrat_id", $data)) {


            if (!empty($data['contrat_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->contrat_id = $data['contrat_id'];

            }

        }


        if (array_key_exists("direction_id", $data)) {


            if (!empty($data['direction_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->direction_id = $data['direction_id'];

            }

        }


        if (array_key_exists("categorie_id", $data)) {


            if (!empty($data['categorie_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->categorie_id = $data['categorie_id'];

            }

        }


        if (array_key_exists("echelon_id", $data)) {


            if (!empty($data['echelon_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->echelon_id = $data['echelon_id'];

            }

        }


        if (array_key_exists("sexe_id", $data)) {


            if (!empty($data['sexe_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->sexe_id = $data['sexe_id'];

            }

        }


        if (array_key_exists("matrimoniale_id", $data)) {


            if (!empty($data['matrimoniale_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->matrimoniale_id = $data['matrimoniale_id'];

            }

        }


        if (array_key_exists("poste_id", $data)) {


            if (!empty($data['poste_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste_id = $data['poste_id'];

            }

        }


        if (array_key_exists("ville_id", $data)) {


            if (!empty($data['ville_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->ville_id = $data['ville_id'];

            }

        }


        if (array_key_exists("zone_id", $data)) {


            if (!empty($data['zone_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->zone_id = $data['zone_id'];

            }

        }


        if (array_key_exists("situation_id", $data)) {


            if (!empty($data['situation_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->situation_id = $data['situation_id'];

            }

        }


        if (array_key_exists("balise_id", $data)) {


            if (!empty($data['balise_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->balise_id = $data['balise_id'];

            }

        }


        if (array_key_exists("fonction_id", $data)) {


            if (!empty($data['fonction_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->fonction_id = $data['fonction_id'];

            }

        }


        if (array_key_exists("online_id", $data)) {


            if (!empty($data['online_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->online_id = $data['online_id'];

            }

        }


        if (array_key_exists("faction_id", $data)) {


            if (!empty($data['faction_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->faction_id = $data['faction_id'];

            }

        }


        if (array_key_exists("site_id", $data)) {


            if (!empty($data['site_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->site_id = $data['site_id'];

            }

        }


        if (array_key_exists("client_id", $data)) {


            if (!empty($data['client_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->client_id = $data['client_id'];

            }

        }


        if (array_key_exists("etats", $data)) {


            if (!empty($data['etats'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->etats = $data['etats'];

            }

        }


        if (array_key_exists("identifiants_sadge", $data)) {


            if (!empty($data['identifiants_sadge'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->identifiants_sadge = $data['identifiants_sadge'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->creat_by = $data['creat_by'];

            }

        }


        if (array_key_exists("annuler", $data)) {


            if (!empty($data['annuler'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->annuler = $data['annuler'];

            }

        }


        if (array_key_exists("type", $data)) {


            if (!empty($data['type'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->type = $data['type'];

            }

        }


        if (array_key_exists("traiter", $data)) {


            if (!empty($data['traiter'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->traiter = $data['traiter'];

            }

        }


        if (array_key_exists("pointeusepostes", $data)) {


            if (!empty($data['pointeusepostes'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeusepostes = $data['pointeusepostes'];

            }

        }


        if (array_key_exists("verification", $data)) {


            if (!empty($data['verification'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->verification = $data['verification'];

            }

        }


        if (array_key_exists("rechercheetape", $data)) {


            if (!empty($data['rechercheetape'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->rechercheetape = $data['rechercheetape'];

            }

        }


        if (array_key_exists("tache", $data)) {


            if (!empty($data['tache'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->tache = $data['tache'];

            }

        }


        if (array_key_exists("poste", $data)) {


            if (!empty($data['poste'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste = $data['poste'];

            }

        }


        if (array_key_exists("TachesPotentiels", $data)) {


            if (!empty($data['TachesPotentiels'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->TachesPotentiels = $data['TachesPotentiels'];

            }

        }


        if (array_key_exists("PostesPotentiels", $data)) {


            if (!empty($data['PostesPotentiels'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->PostesPotentiels = $data['PostesPotentiels'];

            }

        }


        if (array_key_exists("TotalPostes", $data)) {


            if (!empty($data['TotalPostes'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostes = $data['TotalPostes'];

            }

        }


        if (array_key_exists("TotalPostescouvert", $data)) {


            if (!empty($data['TotalPostescouvert'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostescouvert = $data['TotalPostescouvert'];

            }

        }


        if (array_key_exists("TotalPostesnoncouvert", $data)) {


            if (!empty($data['TotalPostesnoncouvert'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostesnoncouvert = $data['TotalPostesnoncouvert'];

            }

        }


        if (array_key_exists("TotalPostessouscouvert", $data)) {


            if (!empty($data['TotalPostessouscouvert'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostessouscouvert = $data['TotalPostessouscouvert'];

            }

        }


        if (array_key_exists("num_badge", $data)) {


            if (!empty($data['num_badge'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_badge = $data['num_badge'];

            }

        }


        if (array_key_exists("date_naissance", $data)) {


            if (!empty($data['date_naissance'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_naissance = $data['date_naissance'];

            }

        }


        if (array_key_exists("num_cnss", $data)) {


            if (!empty($data['num_cnss'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnss = $data['num_cnss'];

            }

        }


        if (array_key_exists("num_cnamgs", $data)) {


            if (!empty($data['num_cnamgs'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnamgs = $data['num_cnamgs'];

            }

        }


        if (array_key_exists("telephone1", $data)) {


            if (!empty($data['telephone1'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone1 = $data['telephone1'];

            }

        }


        if (array_key_exists("telephone2", $data)) {


            if (!empty($data['telephone2'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone2 = $data['telephone2'];

            }

        }


        if (array_key_exists("photo", $data)) {


            if (!empty($data['photo'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->photo = $data['photo'];

            }

        }


        if (array_key_exists("date_embauche", $data)) {


            if (!empty($data['date_embauche'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_embauche = $data['date_embauche'];

            }

        }


        if (array_key_exists("download_date", $data)) {


            if (!empty($data['download_date'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->download_date = $data['download_date'];

            }

        }


        if (array_key_exists("user_id", $data)) {


            if (!empty($data['user_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->user_id = $data['user_id'];

            }

        }


        if (array_key_exists("email", $data)) {


            if (!empty($data['email'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->email = $data['email'];

            }

        }


        if (array_key_exists("password", $data)) {


            if (!empty($data['password'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->password = $data['password'];

            }

        }


        if (array_key_exists("nombre_enfant", $data)) {


            if (!empty($data['nombre_enfant'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->nombre_enfant = $data['nombre_enfant'];

            }

        }


        if (array_key_exists("num_dossier", $data)) {


            if (!empty($data['num_dossier'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_dossier = $data['num_dossier'];

            }

        }


        if (array_key_exists("pointeuse_id", $data)) {


            if (!empty($data['pointeuse_id'])) {

                $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeuse_id = $data['pointeuse_id'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $ViewsTransactions6163ba39986346beb3710cd3a4023437->extra_attributes["extra-data"] = $dat;


        } catch (\Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras') &&
            method_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras', 'beforeSaveUpdate')
        ) {
            \App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras::beforeSaveUpdate($request, $ViewsTransactions6163ba39986346beb3710cd3a4023437);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras') &&
            method_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras', 'canUpdate')
        ) {
            try {
                $canSave = \App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras::canUpdate($request, $ViewsTransactions6163ba39986346beb3710cd3a4023437);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $ViewsTransactions6163ba39986346beb3710cd3a4023437->save();
        } else {
            return response()->json($ViewsTransactions6163ba39986346beb3710cd3a4023437, 200);

        }


        $ViewsTransactions6163ba39986346beb3710cd3a4023437 = ViewsTransaction6163ba39986346beb3710cd3a4023437::find($ViewsTransactions6163ba39986346beb3710cd3a4023437->id);


        $newCrudData = [];

        $newCrudData['bio_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->bio_id;
        $newCrudData['area_alias'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->area_alias;
        $newCrudData['first_name'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->first_name;
        $newCrudData['last_name'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->last_name;
        $newCrudData['card_no'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->card_no;
        $newCrudData['terminal_alias'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->terminal_alias;
        $newCrudData['emp_code'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->emp_code;
        $newCrudData['punch_date'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_date;
        $newCrudData['punch_time'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_time;
        $newCrudData['nom'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nom;
        $newCrudData['prenom'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->prenom;
        $newCrudData['matricule'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matricule;
        $newCrudData['actif_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->actif_id;
        $newCrudData['nationalite_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nationalite_id;
        $newCrudData['contrat_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->contrat_id;
        $newCrudData['direction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->direction_id;
        $newCrudData['categorie_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->categorie_id;
        $newCrudData['echelon_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->echelon_id;
        $newCrudData['sexe_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->sexe_id;
        $newCrudData['matrimoniale_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matrimoniale_id;
        $newCrudData['poste_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste_id;
        $newCrudData['ville_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->ville_id;
        $newCrudData['zone_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->zone_id;
        $newCrudData['situation_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->situation_id;
        $newCrudData['balise_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->balise_id;
        $newCrudData['fonction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->fonction_id;
        $newCrudData['online_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->online_id;
        $newCrudData['faction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->faction_id;
        $newCrudData['site_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->site_id;
        $newCrudData['client_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->client_id;
        $newCrudData['etats'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->etats;
        $newCrudData['identifiants_sadge'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->identifiants_sadge;
        $newCrudData['creat_by'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->creat_by;
        $newCrudData['annuler'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->annuler;
        $newCrudData['type'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->type;
        $newCrudData['traiter'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->traiter;
        $newCrudData['pointeusepostes'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeusepostes;
        $newCrudData['verification'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->verification;
        $newCrudData['rechercheetape'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->rechercheetape;
        $newCrudData['tache'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->tache;
        $newCrudData['poste'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste;
        $newCrudData['TachesPotentiels'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TachesPotentiels;
        $newCrudData['PostesPotentiels'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->PostesPotentiels;
        $newCrudData['TotalPostes'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostes;
        $newCrudData['TotalPostescouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostescouvert;
        $newCrudData['TotalPostesnoncouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostesnoncouvert;
        $newCrudData['TotalPostessouscouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostessouscouvert;
        $newCrudData['num_badge'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_badge;
        $newCrudData['date_naissance'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_naissance;
        $newCrudData['num_cnss'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnss;
        $newCrudData['num_cnamgs'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnamgs;
        $newCrudData['telephone1'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone1;
        $newCrudData['telephone2'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone2;
        $newCrudData['photo'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->photo;
        $newCrudData['date_embauche'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_embauche;
        $newCrudData['download_date'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->download_date;
        $newCrudData['user_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->user_id;
        $newCrudData['email'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->email;
        $newCrudData['password'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->password;
        $newCrudData['nombre_enfant'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nombre_enfant;
        $newCrudData['num_dossier'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_dossier;
        $newCrudData['pointeuse_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeuse_id;

        try {
            $newCrudData['actif'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['client'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'ViewsTransactions6163ba39986346beb3710cd3a4023437', 'entite_cle' => $ViewsTransactions6163ba39986346beb3710cd3a4023437->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $ViewsTransactions6163ba39986346beb3710cd3a4023437->toArray();


        try {

            foreach ($ViewsTransactions6163ba39986346beb3710cd3a4023437->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, ViewsTransaction6163ba39986346beb3710cd3a4023437 $ViewsTransactions6163ba39986346beb3710cd3a4023437)
    {
        try {
            $can = \App\Helpers\Helpers::can('Supprimer des ViewsTransactions6163ba39986346beb3710cd3a4023437');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['bio_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->bio_id;
        $newCrudData['area_alias'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->area_alias;
        $newCrudData['first_name'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->first_name;
        $newCrudData['last_name'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->last_name;
        $newCrudData['card_no'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->card_no;
        $newCrudData['terminal_alias'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->terminal_alias;
        $newCrudData['emp_code'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->emp_code;
        $newCrudData['punch_date'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_date;
        $newCrudData['punch_time'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->punch_time;
        $newCrudData['nom'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nom;
        $newCrudData['prenom'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->prenom;
        $newCrudData['matricule'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matricule;
        $newCrudData['actif_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->actif_id;
        $newCrudData['nationalite_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nationalite_id;
        $newCrudData['contrat_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->contrat_id;
        $newCrudData['direction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->direction_id;
        $newCrudData['categorie_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->categorie_id;
        $newCrudData['echelon_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->echelon_id;
        $newCrudData['sexe_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->sexe_id;
        $newCrudData['matrimoniale_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matrimoniale_id;
        $newCrudData['poste_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste_id;
        $newCrudData['ville_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->ville_id;
        $newCrudData['zone_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->zone_id;
        $newCrudData['situation_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->situation_id;
        $newCrudData['balise_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->balise_id;
        $newCrudData['fonction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->fonction_id;
        $newCrudData['online_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->online_id;
        $newCrudData['faction_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->faction_id;
        $newCrudData['site_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->site_id;
        $newCrudData['client_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->client_id;
        $newCrudData['etats'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->etats;
        $newCrudData['identifiants_sadge'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->identifiants_sadge;
        $newCrudData['creat_by'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->creat_by;
        $newCrudData['annuler'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->annuler;
        $newCrudData['type'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->type;
        $newCrudData['traiter'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->traiter;
        $newCrudData['pointeusepostes'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeusepostes;
        $newCrudData['verification'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->verification;
        $newCrudData['rechercheetape'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->rechercheetape;
        $newCrudData['tache'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->tache;
        $newCrudData['poste'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste;
        $newCrudData['TachesPotentiels'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TachesPotentiels;
        $newCrudData['PostesPotentiels'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->PostesPotentiels;
        $newCrudData['TotalPostes'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostes;
        $newCrudData['TotalPostescouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostescouvert;
        $newCrudData['TotalPostesnoncouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostesnoncouvert;
        $newCrudData['TotalPostessouscouvert'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->TotalPostessouscouvert;
        $newCrudData['num_badge'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_badge;
        $newCrudData['date_naissance'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_naissance;
        $newCrudData['num_cnss'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnss;
        $newCrudData['num_cnamgs'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_cnamgs;
        $newCrudData['telephone1'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone1;
        $newCrudData['telephone2'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->telephone2;
        $newCrudData['photo'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->photo;
        $newCrudData['date_embauche'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->date_embauche;
        $newCrudData['download_date'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->download_date;
        $newCrudData['user_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->user_id;
        $newCrudData['email'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->email;
        $newCrudData['password'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->password;
        $newCrudData['nombre_enfant'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nombre_enfant;
        $newCrudData['num_dossier'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->num_dossier;
        $newCrudData['pointeuse_id'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeuse_id;

        try {
            $newCrudData['actif'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['client'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $ViewsTransactions6163ba39986346beb3710cd3a4023437->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'ViewsTransactions6163ba39986346beb3710cd3a4023437', 'entite_cle' => $ViewsTransactions6163ba39986346beb3710cd3a4023437->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras') &&
            method_exists('\App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras', 'canDelete')
        ) {
            try {
                $canSave = \App\Http\Extras\ViewsTransaction6163ba39986346beb3710cd3a4023437Extras::canDelete($request, $ViewsTransactions6163ba39986346beb3710cd3a4023437);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $ViewsTransactions6163ba39986346beb3710cd3a4023437->delete();
        } else {
            return response()->json($ViewsTransactions6163ba39986346beb3710cd3a4023437, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new \App\Http\Actions\ViewsTransactions6163ba39986346beb3710cd3a4023437Actions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
