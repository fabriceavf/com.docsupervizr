<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\Tables6b35594d8891437fb6fba75a3fe60fdbTable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

// use App\Repository\prod\Tables6b35594d8891437fb6fba75a3fe60fdbTablesRepository;


class Tables6b35594d8891437fb6fba75a3fe60fdbTableController extends Controller
{

    private $Tables6b35594d8891437fb6fba75a3fe60fdbTablesRepository;
    private $menu;


    /**
     * Return .
     * @param \Illuminate\Http\Request $request
     * @param App\Repository\prod\Tables6b35594d8891437fb6fba75a3fe60fdbTablesRepository $Tables6b35594d8891437fb6fba75a3fe60fdbTablesRepository
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
        $query = Tables6b35594d8891437fb6fba75a3fe60fdbTable::query();
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
            class_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras') &&
            method_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras', 'filterAgGridQuery')
        ) {
            \App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('Tables6b35594d8891437fb6fba75a3fe60fdbTables', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras') &&
            method_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = \App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
            $data['rowData'] = $_d;
            if ($_d->count() > $data['rowCount']) {
                $data['rowData'] = $_d;
                if ($_d->count() > $data['rowCount']) {
                    $data['rowCount'] = $_d->count();
                }
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
            return response()->json(Tables6b35594d8891437fb6fba75a3fe60fdbTable::count());
        }
        $data = QueryBuilder::for(Tables6b35594d8891437fb6fba75a3fe60fdbTable::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('name'),


                AllowedFilter::exact('nom'),


                AllowedFilter::exact('prenom'),


                AllowedFilter::exact('matricule'),


                AllowedFilter::exact('num_badge'),


                AllowedFilter::exact('date_naissance'),


                AllowedFilter::exact('num_cnss'),


                AllowedFilter::exact('num_cnamgs'),


                AllowedFilter::exact('telephone1'),


                AllowedFilter::exact('telephone2'),


                AllowedFilter::exact('photo'),


                AllowedFilter::exact('date_embauche'),


                AllowedFilter::exact('download_date'),


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


                AllowedFilter::exact('site_id'),


                AllowedFilter::exact('situation_id'),


                AllowedFilter::exact('balise_id'),


                AllowedFilter::exact('fonction_id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('email'),


                AllowedFilter::exact('email_verified_at'),


                AllowedFilter::exact('password'),


                AllowedFilter::exact('emp_code'),


                AllowedFilter::exact('nombre_enfant'),


                AllowedFilter::exact('num_dossier'),


                AllowedFilter::exact('online_id'),


                AllowedFilter::exact('type_id'),


                AllowedFilter::exact('faction_id'),


                AllowedFilter::exact('remember_token'),


                AllowedFilter::exact('identifiants_sadge'),


                AllowedFilter::exact('creat_by'),


                AllowedFilter::exact('role_id'),


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


                AllowedSort::field('name'),


                AllowedSort::field('nom'),


                AllowedSort::field('prenom'),


                AllowedSort::field('matricule'),


                AllowedSort::field('num_badge'),


                AllowedSort::field('date_naissance'),


                AllowedSort::field('num_cnss'),


                AllowedSort::field('num_cnamgs'),


                AllowedSort::field('telephone1'),


                AllowedSort::field('telephone2'),


                AllowedSort::field('photo'),


                AllowedSort::field('date_embauche'),


                AllowedSort::field('download_date'),


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


                AllowedSort::field('site_id'),


                AllowedSort::field('situation_id'),


                AllowedSort::field('balise_id'),


                AllowedSort::field('fonction_id'),


                AllowedSort::field('user_id'),


                AllowedSort::field('email'),


                AllowedSort::field('email_verified_at'),


                AllowedSort::field('password'),


                AllowedSort::field('emp_code'),


                AllowedSort::field('nombre_enfant'),


                AllowedSort::field('num_dossier'),


                AllowedSort::field('online_id'),


                AllowedSort::field('type_id'),


                AllowedSort::field('faction_id'),


                AllowedSort::field('remember_token'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


                AllowedSort::field('role_id'),


            ])
            ->allowedIncludes([

                'actif',


                'balise',


                'categorie',


                'contrat',


                'direction',


                'echelon',


                'faction',


                'fonction',


                'matrimoniale',


                'nationalite',


                'online',


                'poste',


                'role',


                'sexe',


                'site',


                'situation',


                'type',


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


        $data = QueryBuilder::for(Tables6b35594d8891437fb6fba75a3fe60fdbTable::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('name'),


                AllowedFilter::exact('nom'),


                AllowedFilter::exact('prenom'),


                AllowedFilter::exact('matricule'),


                AllowedFilter::exact('num_badge'),


                AllowedFilter::exact('date_naissance'),


                AllowedFilter::exact('num_cnss'),


                AllowedFilter::exact('num_cnamgs'),


                AllowedFilter::exact('telephone1'),


                AllowedFilter::exact('telephone2'),


                AllowedFilter::exact('photo'),


                AllowedFilter::exact('date_embauche'),


                AllowedFilter::exact('download_date'),


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


                AllowedFilter::exact('site_id'),


                AllowedFilter::exact('situation_id'),


                AllowedFilter::exact('balise_id'),


                AllowedFilter::exact('fonction_id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('email'),


                AllowedFilter::exact('email_verified_at'),


                AllowedFilter::exact('password'),


                AllowedFilter::exact('emp_code'),


                AllowedFilter::exact('nombre_enfant'),


                AllowedFilter::exact('num_dossier'),


                AllowedFilter::exact('online_id'),


                AllowedFilter::exact('type_id'),


                AllowedFilter::exact('faction_id'),


                AllowedFilter::exact('remember_token'),


                AllowedFilter::exact('identifiants_sadge'),


                AllowedFilter::exact('creat_by'),


                AllowedFilter::exact('role_id'),


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


                AllowedSort::field('name'),


                AllowedSort::field('nom'),


                AllowedSort::field('prenom'),


                AllowedSort::field('matricule'),


                AllowedSort::field('num_badge'),


                AllowedSort::field('date_naissance'),


                AllowedSort::field('num_cnss'),


                AllowedSort::field('num_cnamgs'),


                AllowedSort::field('telephone1'),


                AllowedSort::field('telephone2'),


                AllowedSort::field('photo'),


                AllowedSort::field('date_embauche'),


                AllowedSort::field('download_date'),


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


                AllowedSort::field('site_id'),


                AllowedSort::field('situation_id'),


                AllowedSort::field('balise_id'),


                AllowedSort::field('fonction_id'),


                AllowedSort::field('user_id'),


                AllowedSort::field('email'),


                AllowedSort::field('email_verified_at'),


                AllowedSort::field('password'),


                AllowedSort::field('emp_code'),


                AllowedSort::field('nombre_enfant'),


                AllowedSort::field('num_dossier'),


                AllowedSort::field('online_id'),


                AllowedSort::field('type_id'),


                AllowedSort::field('faction_id'),


                AllowedSort::field('remember_token'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


                AllowedSort::field('role_id'),


            ])
            ->allowedIncludes([
                'actif',


                'balise',


                'categorie',


                'contrat',


                'direction',


                'echelon',


                'faction',


                'fonction',


                'matrimoniale',


                'nationalite',


                'online',


                'poste',


                'role',


                'sexe',


                'site',


                'situation',


                'type',


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


    public function create(Request $request, Tables6b35594d8891437fb6fba75a3fe60fdbTable $Tables6b35594d8891437fb6fba75a3fe60fdbTables)
    {


        try {
            $can = \App\Helpers\Helpers::can('Creer des Tables6b35594d8891437fb6fba75a3fe60fdbTables');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "Tables6b35594d8891437fb6fba75a3fe60fdbTables" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'name',
            'nom',
            'prenom',
            'matricule',
            'num_badge',
            'date_naissance',
            'num_cnss',
            'num_cnamgs',
            'telephone1',
            'telephone2',
            'photo',
            'date_embauche',
            'download_date',
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
            'site_id',
            'situation_id',
            'balise_id',
            'fonction_id',
            'user_id',
            'email',
            'email_verified_at',
            'password',
            'emp_code',
            'nombre_enfant',
            'num_dossier',
            'online_id',
            'type_id',
            'faction_id',
            'remember_token',
            'created_at',
            'updated_at',
            'deleted_at',
            'identifiants_sadge',
            'creat_by',
            'extra_attributes',
            'role_id',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'name' => [
                //'required'
            ],


            'nom' => ['required'],


            'prenom' => ['required'],


            'matricule' => [
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


            'site_id' => [
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


            'email' => [
                //'required'
            ],


            'password' => [
                //'required'
            ],


            'emp_code' => [
                //'required'
            ],


            'nombre_enfant' => [
                //'required'
            ],


            'num_dossier' => [
                //'required'
            ],


            'online_id' => [
                //'required'
            ],


            'type_id' => [
                //'required'
            ],


            'faction_id' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


            'role_id' => [
                //'required'
            ],


        ], $messages = [


            'name' => ['cette donnee est obligatoire'],


            'nom' => ['cette donnee est obligatoire'],


            'prenom' => ['cette donnee est obligatoire'],


            'matricule' => ['cette donnee est obligatoire'],


            'num_badge' => ['cette donnee est obligatoire'],


            'date_naissance' => ['cette donnee est obligatoire'],


            'num_cnss' => ['cette donnee est obligatoire'],


            'num_cnamgs' => ['cette donnee est obligatoire'],


            'telephone1' => ['cette donnee est obligatoire'],


            'telephone2' => ['cette donnee est obligatoire'],


            'photo' => ['cette donnee est obligatoire'],


            'date_embauche' => ['cette donnee est obligatoire'],


            'download_date' => ['cette donnee est obligatoire'],


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


            'site_id' => ['cette donnee est obligatoire'],


            'situation_id' => ['cette donnee est obligatoire'],


            'balise_id' => ['cette donnee est obligatoire'],


            'fonction_id' => ['cette donnee est obligatoire'],


            'email' => ['cette donnee est obligatoire'],


            'password' => ['cette donnee est obligatoire'],


            'emp_code' => ['cette donnee est obligatoire'],


            'nombre_enfant' => ['cette donnee est obligatoire'],


            'num_dossier' => ['cette donnee est obligatoire'],


            'online_id' => ['cette donnee est obligatoire'],


            'type_id' => ['cette donnee est obligatoire'],


            'faction_id' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


            'role_id' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['name'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->name = $data['name'];

        }


        if (!empty($data['nom'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nom = $data['nom'];

        }


        if (!empty($data['prenom'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->prenom = $data['prenom'];

        }


        if (!empty($data['matricule'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matricule = $data['matricule'];

        }


        if (!empty($data['num_badge'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_badge = $data['num_badge'];

        }


        if (!empty($data['date_naissance'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_naissance = $data['date_naissance'];

        }


        if (!empty($data['num_cnss'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnss = $data['num_cnss'];

        }


        if (!empty($data['num_cnamgs'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnamgs = $data['num_cnamgs'];

        }


        if (!empty($data['telephone1'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone1 = $data['telephone1'];

        }


        if (!empty($data['telephone2'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone2 = $data['telephone2'];

        }


        if (!empty($data['photo'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->photo = $data['photo'];

        }


        if (!empty($data['date_embauche'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_embauche = $data['date_embauche'];

        }


        if (!empty($data['download_date'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->download_date = $data['download_date'];

        }


        if (!empty($data['actif_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->actif_id = $data['actif_id'];

        }


        if (!empty($data['nationalite_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nationalite_id = $data['nationalite_id'];

        }


        if (!empty($data['contrat_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->contrat_id = $data['contrat_id'];

        }


        if (!empty($data['direction_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->direction_id = $data['direction_id'];

        }


        if (!empty($data['categorie_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->categorie_id = $data['categorie_id'];

        }


        if (!empty($data['echelon_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->echelon_id = $data['echelon_id'];

        }


        if (!empty($data['sexe_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->sexe_id = $data['sexe_id'];

        }


        if (!empty($data['matrimoniale_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matrimoniale_id = $data['matrimoniale_id'];

        }


        if (!empty($data['poste_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->poste_id = $data['poste_id'];

        }


        if (!empty($data['ville_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->ville_id = $data['ville_id'];

        }


        if (!empty($data['zone_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->zone_id = $data['zone_id'];

        }


        if (!empty($data['site_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->site_id = $data['site_id'];

        }


        if (!empty($data['situation_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->situation_id = $data['situation_id'];

        }


        if (!empty($data['balise_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->balise_id = $data['balise_id'];

        }


        if (!empty($data['fonction_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->fonction_id = $data['fonction_id'];

        }


        if (!empty($data['user_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->user_id = $data['user_id'];

        }


        if (!empty($data['email'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->email = $data['email'];

        }


        if (!empty($data['password'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->password = $data['password'];

        }


        if (!empty($data['emp_code'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->emp_code = $data['emp_code'];

        }


        if (!empty($data['nombre_enfant'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nombre_enfant = $data['nombre_enfant'];

        }


        if (!empty($data['num_dossier'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_dossier = $data['num_dossier'];

        }


        if (!empty($data['online_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->online_id = $data['online_id'];

        }


        if (!empty($data['type_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->type_id = $data['type_id'];

        }


        if (!empty($data['faction_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->faction_id = $data['faction_id'];

        }


        if (!empty($data['identifiants_sadge'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->identifiants_sadge = $data['identifiants_sadge'];

        }


        if (!empty($data['creat_by'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->creat_by = $data['creat_by'];

        }


        if (!empty($data['role_id'])) {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->role_id = $data['role_id'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->extra_attributes["extra-data"] = $dat;


        } catch (\Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras') &&
            method_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras', 'beforeSaveCreate')
        ) {
            \App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras::beforeSaveCreate($request, $Tables6b35594d8891437fb6fba75a3fe60fdbTables);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras') &&
            method_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras', 'canCreate')
        ) {
            try {
                $canSave = \App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras::canCreate($request, $Tables6b35594d8891437fb6fba75a3fe60fdbTables);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->save();
        } else {
            return response()->json($Tables6b35594d8891437fb6fba75a3fe60fdbTables, 200);
        }

        $Tables6b35594d8891437fb6fba75a3fe60fdbTables = Tables6b35594d8891437fb6fba75a3fe60fdbTable::find($Tables6b35594d8891437fb6fba75a3fe60fdbTables->id);
        $newCrudData = [];

        $newCrudData['name'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->name;
        $newCrudData['nom'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nom;
        $newCrudData['prenom'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->prenom;
        $newCrudData['matricule'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matricule;
        $newCrudData['num_badge'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_badge;
        $newCrudData['date_naissance'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_naissance;
        $newCrudData['num_cnss'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnss;
        $newCrudData['num_cnamgs'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnamgs;
        $newCrudData['telephone1'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone1;
        $newCrudData['telephone2'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone2;
        $newCrudData['photo'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->photo;
        $newCrudData['date_embauche'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_embauche;
        $newCrudData['download_date'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->download_date;
        $newCrudData['actif_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->actif_id;
        $newCrudData['nationalite_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nationalite_id;
        $newCrudData['contrat_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->contrat_id;
        $newCrudData['direction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->direction_id;
        $newCrudData['categorie_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->categorie_id;
        $newCrudData['echelon_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->echelon_id;
        $newCrudData['sexe_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->sexe_id;
        $newCrudData['matrimoniale_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matrimoniale_id;
        $newCrudData['poste_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->poste_id;
        $newCrudData['ville_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->ville_id;
        $newCrudData['zone_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->zone_id;
        $newCrudData['site_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->site_id;
        $newCrudData['situation_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->situation_id;
        $newCrudData['balise_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->balise_id;
        $newCrudData['fonction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->fonction_id;
        $newCrudData['user_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->user_id;
        $newCrudData['email'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->email;
        $newCrudData['password'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->password;
        $newCrudData['emp_code'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->emp_code;
        $newCrudData['nombre_enfant'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nombre_enfant;
        $newCrudData['num_dossier'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_dossier;
        $newCrudData['online_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->online_id;
        $newCrudData['type_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->type_id;
        $newCrudData['faction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->faction_id;
        $newCrudData['identifiants_sadge'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->identifiants_sadge;
        $newCrudData['creat_by'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->creat_by;
        $newCrudData['role_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->role_id;

        try {
            $newCrudData['actif'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['role'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->role->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->type->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Tables6b35594d8891437fb6fba75a3fe60fdbTables', 'entite_cle' => $Tables6b35594d8891437fb6fba75a3fe60fdbTables->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->toArray();


        try {

            foreach ($Tables6b35594d8891437fb6fba75a3fe60fdbTables->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Tables6b35594d8891437fb6fba75a3fe60fdbTable $Tables6b35594d8891437fb6fba75a3fe60fdbTables)
    {
        try {
            $can = \App\Helpers\Helpers::can('Editer des Tables6b35594d8891437fb6fba75a3fe60fdbTables');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['name'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->name;
        $oldCrudData['nom'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nom;
        $oldCrudData['prenom'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->prenom;
        $oldCrudData['matricule'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matricule;
        $oldCrudData['num_badge'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_badge;
        $oldCrudData['date_naissance'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_naissance;
        $oldCrudData['num_cnss'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnss;
        $oldCrudData['num_cnamgs'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnamgs;
        $oldCrudData['telephone1'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone1;
        $oldCrudData['telephone2'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone2;
        $oldCrudData['photo'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->photo;
        $oldCrudData['date_embauche'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_embauche;
        $oldCrudData['download_date'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->download_date;
        $oldCrudData['actif_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->actif_id;
        $oldCrudData['nationalite_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nationalite_id;
        $oldCrudData['contrat_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->contrat_id;
        $oldCrudData['direction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->direction_id;
        $oldCrudData['categorie_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->categorie_id;
        $oldCrudData['echelon_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->echelon_id;
        $oldCrudData['sexe_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->sexe_id;
        $oldCrudData['matrimoniale_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matrimoniale_id;
        $oldCrudData['poste_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->poste_id;
        $oldCrudData['ville_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->ville_id;
        $oldCrudData['zone_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->zone_id;
        $oldCrudData['site_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->site_id;
        $oldCrudData['situation_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->situation_id;
        $oldCrudData['balise_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->balise_id;
        $oldCrudData['fonction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->fonction_id;
        $oldCrudData['user_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->user_id;
        $oldCrudData['email'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->email;
        $oldCrudData['password'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->password;
        $oldCrudData['emp_code'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->emp_code;
        $oldCrudData['nombre_enfant'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nombre_enfant;
        $oldCrudData['num_dossier'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_dossier;
        $oldCrudData['online_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->online_id;
        $oldCrudData['type_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->type_id;
        $oldCrudData['faction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->faction_id;
        $oldCrudData['identifiants_sadge'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->identifiants_sadge;
        $oldCrudData['creat_by'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->creat_by;
        $oldCrudData['role_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->role_id;

        try {
            $oldCrudData['actif'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['balise'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['categorie'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['contrat'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['direction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['echelon'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['faction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['fonction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['matrimoniale'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['nationalite'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['online'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['poste'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['role'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->role->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['sexe'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['site'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['situation'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['type'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->type->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['ville'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->zone->Selectlabel;
        } catch (\Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "Tables6b35594d8891437fb6fba75a3fe60fdbTables" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'name',
            'nom',
            'prenom',
            'matricule',
            'num_badge',
            'date_naissance',
            'num_cnss',
            'num_cnamgs',
            'telephone1',
            'telephone2',
            'photo',
            'date_embauche',
            'download_date',
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
            'site_id',
            'situation_id',
            'balise_id',
            'fonction_id',
            'user_id',
            'email',
            'email_verified_at',
            'password',
            'emp_code',
            'nombre_enfant',
            'num_dossier',
            'online_id',
            'type_id',
            'faction_id',
            'remember_token',
            'created_at',
            'updated_at',
            'deleted_at',
            'identifiants_sadge',
            'creat_by',
            'extra_attributes',
            'role_id',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'name' => [
                //'required'
            ],


            'nom' => ['required'],


            'prenom' => ['required'],


            'matricule' => [
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


            'site_id' => [
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


            'email' => [
                //'required'
            ],


            'password' => [
                //'required'
            ],


            'emp_code' => [
                //'required'
            ],


            'nombre_enfant' => [
                //'required'
            ],


            'num_dossier' => [
                //'required'
            ],


            'online_id' => [
                //'required'
            ],


            'type_id' => [
                //'required'
            ],


            'faction_id' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


            'role_id' => [
                //'required'
            ],


        ], $messages = [


            'name' => ['cette donnee est obligatoire'],


            'nom' => ['cette donnee est obligatoire'],


            'prenom' => ['cette donnee est obligatoire'],


            'matricule' => ['cette donnee est obligatoire'],


            'num_badge' => ['cette donnee est obligatoire'],


            'date_naissance' => ['cette donnee est obligatoire'],


            'num_cnss' => ['cette donnee est obligatoire'],


            'num_cnamgs' => ['cette donnee est obligatoire'],


            'telephone1' => ['cette donnee est obligatoire'],


            'telephone2' => ['cette donnee est obligatoire'],


            'photo' => ['cette donnee est obligatoire'],


            'date_embauche' => ['cette donnee est obligatoire'],


            'download_date' => ['cette donnee est obligatoire'],


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


            'site_id' => ['cette donnee est obligatoire'],


            'situation_id' => ['cette donnee est obligatoire'],


            'balise_id' => ['cette donnee est obligatoire'],


            'fonction_id' => ['cette donnee est obligatoire'],


            'email' => ['cette donnee est obligatoire'],


            'password' => ['cette donnee est obligatoire'],


            'emp_code' => ['cette donnee est obligatoire'],


            'nombre_enfant' => ['cette donnee est obligatoire'],


            'num_dossier' => ['cette donnee est obligatoire'],


            'online_id' => ['cette donnee est obligatoire'],


            'type_id' => ['cette donnee est obligatoire'],


            'faction_id' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


            'role_id' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("name", $data)) {


            if (!empty($data['name'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->name = $data['name'];

            }

        }


        if (array_key_exists("nom", $data)) {


            if (!empty($data['nom'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nom = $data['nom'];

            }

        }


        if (array_key_exists("prenom", $data)) {


            if (!empty($data['prenom'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->prenom = $data['prenom'];

            }

        }


        if (array_key_exists("matricule", $data)) {


            if (!empty($data['matricule'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matricule = $data['matricule'];

            }

        }


        if (array_key_exists("num_badge", $data)) {


            if (!empty($data['num_badge'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_badge = $data['num_badge'];

            }

        }


        if (array_key_exists("date_naissance", $data)) {


            if (!empty($data['date_naissance'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_naissance = $data['date_naissance'];

            }

        }


        if (array_key_exists("num_cnss", $data)) {


            if (!empty($data['num_cnss'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnss = $data['num_cnss'];

            }

        }


        if (array_key_exists("num_cnamgs", $data)) {


            if (!empty($data['num_cnamgs'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnamgs = $data['num_cnamgs'];

            }

        }


        if (array_key_exists("telephone1", $data)) {


            if (!empty($data['telephone1'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone1 = $data['telephone1'];

            }

        }


        if (array_key_exists("telephone2", $data)) {


            if (!empty($data['telephone2'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone2 = $data['telephone2'];

            }

        }


        if (array_key_exists("photo", $data)) {


            if (!empty($data['photo'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->photo = $data['photo'];

            }

        }


        if (array_key_exists("date_embauche", $data)) {


            if (!empty($data['date_embauche'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_embauche = $data['date_embauche'];

            }

        }


        if (array_key_exists("download_date", $data)) {


            if (!empty($data['download_date'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->download_date = $data['download_date'];

            }

        }


        if (array_key_exists("actif_id", $data)) {


            if (!empty($data['actif_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->actif_id = $data['actif_id'];

            }

        }


        if (array_key_exists("nationalite_id", $data)) {


            if (!empty($data['nationalite_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nationalite_id = $data['nationalite_id'];

            }

        }


        if (array_key_exists("contrat_id", $data)) {


            if (!empty($data['contrat_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->contrat_id = $data['contrat_id'];

            }

        }


        if (array_key_exists("direction_id", $data)) {


            if (!empty($data['direction_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->direction_id = $data['direction_id'];

            }

        }


        if (array_key_exists("categorie_id", $data)) {


            if (!empty($data['categorie_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->categorie_id = $data['categorie_id'];

            }

        }


        if (array_key_exists("echelon_id", $data)) {


            if (!empty($data['echelon_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->echelon_id = $data['echelon_id'];

            }

        }


        if (array_key_exists("sexe_id", $data)) {


            if (!empty($data['sexe_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->sexe_id = $data['sexe_id'];

            }

        }


        if (array_key_exists("matrimoniale_id", $data)) {


            if (!empty($data['matrimoniale_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matrimoniale_id = $data['matrimoniale_id'];

            }

        }


        if (array_key_exists("poste_id", $data)) {


            if (!empty($data['poste_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->poste_id = $data['poste_id'];

            }

        }


        if (array_key_exists("ville_id", $data)) {


            if (!empty($data['ville_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->ville_id = $data['ville_id'];

            }

        }


        if (array_key_exists("zone_id", $data)) {


            if (!empty($data['zone_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->zone_id = $data['zone_id'];

            }

        }


        if (array_key_exists("site_id", $data)) {


            if (!empty($data['site_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->site_id = $data['site_id'];

            }

        }


        if (array_key_exists("situation_id", $data)) {


            if (!empty($data['situation_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->situation_id = $data['situation_id'];

            }

        }


        if (array_key_exists("balise_id", $data)) {


            if (!empty($data['balise_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->balise_id = $data['balise_id'];

            }

        }


        if (array_key_exists("fonction_id", $data)) {


            if (!empty($data['fonction_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->fonction_id = $data['fonction_id'];

            }

        }


        if (array_key_exists("user_id", $data)) {


            if (!empty($data['user_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->user_id = $data['user_id'];

            }

        }


        if (array_key_exists("email", $data)) {


            if (!empty($data['email'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->email = $data['email'];

            }

        }


        if (array_key_exists("password", $data)) {


            if (!empty($data['password'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->password = $data['password'];

            }

        }


        if (array_key_exists("emp_code", $data)) {


            if (!empty($data['emp_code'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->emp_code = $data['emp_code'];

            }

        }


        if (array_key_exists("nombre_enfant", $data)) {


            if (!empty($data['nombre_enfant'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nombre_enfant = $data['nombre_enfant'];

            }

        }


        if (array_key_exists("num_dossier", $data)) {


            if (!empty($data['num_dossier'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_dossier = $data['num_dossier'];

            }

        }


        if (array_key_exists("online_id", $data)) {


            if (!empty($data['online_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->online_id = $data['online_id'];

            }

        }


        if (array_key_exists("type_id", $data)) {


            if (!empty($data['type_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->type_id = $data['type_id'];

            }

        }


        if (array_key_exists("faction_id", $data)) {


            if (!empty($data['faction_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->faction_id = $data['faction_id'];

            }

        }


        if (array_key_exists("identifiants_sadge", $data)) {


            if (!empty($data['identifiants_sadge'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->identifiants_sadge = $data['identifiants_sadge'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->creat_by = $data['creat_by'];

            }

        }


        if (array_key_exists("role_id", $data)) {


            if (!empty($data['role_id'])) {

                $Tables6b35594d8891437fb6fba75a3fe60fdbTables->role_id = $data['role_id'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->extra_attributes["extra-data"] = $dat;


        } catch (\Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras') &&
            method_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras', 'beforeSaveUpdate')
        ) {
            \App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras::beforeSaveUpdate($request, $Tables6b35594d8891437fb6fba75a3fe60fdbTables);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras') &&
            method_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras', 'canUpdate')
        ) {
            try {
                $canSave = \App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras::canUpdate($request, $Tables6b35594d8891437fb6fba75a3fe60fdbTables);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->save();
        } else {
            return response()->json($Tables6b35594d8891437fb6fba75a3fe60fdbTables, 200);

        }


        $Tables6b35594d8891437fb6fba75a3fe60fdbTables = Tables6b35594d8891437fb6fba75a3fe60fdbTable::find($Tables6b35594d8891437fb6fba75a3fe60fdbTables->id);


        $newCrudData = [];

        $newCrudData['name'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->name;
        $newCrudData['nom'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nom;
        $newCrudData['prenom'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->prenom;
        $newCrudData['matricule'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matricule;
        $newCrudData['num_badge'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_badge;
        $newCrudData['date_naissance'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_naissance;
        $newCrudData['num_cnss'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnss;
        $newCrudData['num_cnamgs'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnamgs;
        $newCrudData['telephone1'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone1;
        $newCrudData['telephone2'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone2;
        $newCrudData['photo'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->photo;
        $newCrudData['date_embauche'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_embauche;
        $newCrudData['download_date'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->download_date;
        $newCrudData['actif_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->actif_id;
        $newCrudData['nationalite_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nationalite_id;
        $newCrudData['contrat_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->contrat_id;
        $newCrudData['direction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->direction_id;
        $newCrudData['categorie_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->categorie_id;
        $newCrudData['echelon_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->echelon_id;
        $newCrudData['sexe_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->sexe_id;
        $newCrudData['matrimoniale_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matrimoniale_id;
        $newCrudData['poste_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->poste_id;
        $newCrudData['ville_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->ville_id;
        $newCrudData['zone_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->zone_id;
        $newCrudData['site_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->site_id;
        $newCrudData['situation_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->situation_id;
        $newCrudData['balise_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->balise_id;
        $newCrudData['fonction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->fonction_id;
        $newCrudData['user_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->user_id;
        $newCrudData['email'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->email;
        $newCrudData['password'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->password;
        $newCrudData['emp_code'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->emp_code;
        $newCrudData['nombre_enfant'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nombre_enfant;
        $newCrudData['num_dossier'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_dossier;
        $newCrudData['online_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->online_id;
        $newCrudData['type_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->type_id;
        $newCrudData['faction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->faction_id;
        $newCrudData['identifiants_sadge'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->identifiants_sadge;
        $newCrudData['creat_by'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->creat_by;
        $newCrudData['role_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->role_id;

        try {
            $newCrudData['actif'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['role'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->role->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->type->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Tables6b35594d8891437fb6fba75a3fe60fdbTables', 'entite_cle' => $Tables6b35594d8891437fb6fba75a3fe60fdbTables->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->toArray();


        try {

            foreach ($Tables6b35594d8891437fb6fba75a3fe60fdbTables->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Tables6b35594d8891437fb6fba75a3fe60fdbTable $Tables6b35594d8891437fb6fba75a3fe60fdbTables)
    {
        try {
            $can = \App\Helpers\Helpers::can('Supprimer des Tables6b35594d8891437fb6fba75a3fe60fdbTables');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (\Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['name'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->name;
        $newCrudData['nom'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nom;
        $newCrudData['prenom'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->prenom;
        $newCrudData['matricule'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matricule;
        $newCrudData['num_badge'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_badge;
        $newCrudData['date_naissance'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_naissance;
        $newCrudData['num_cnss'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnss;
        $newCrudData['num_cnamgs'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_cnamgs;
        $newCrudData['telephone1'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone1;
        $newCrudData['telephone2'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->telephone2;
        $newCrudData['photo'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->photo;
        $newCrudData['date_embauche'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->date_embauche;
        $newCrudData['download_date'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->download_date;
        $newCrudData['actif_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->actif_id;
        $newCrudData['nationalite_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nationalite_id;
        $newCrudData['contrat_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->contrat_id;
        $newCrudData['direction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->direction_id;
        $newCrudData['categorie_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->categorie_id;
        $newCrudData['echelon_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->echelon_id;
        $newCrudData['sexe_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->sexe_id;
        $newCrudData['matrimoniale_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matrimoniale_id;
        $newCrudData['poste_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->poste_id;
        $newCrudData['ville_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->ville_id;
        $newCrudData['zone_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->zone_id;
        $newCrudData['site_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->site_id;
        $newCrudData['situation_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->situation_id;
        $newCrudData['balise_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->balise_id;
        $newCrudData['fonction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->fonction_id;
        $newCrudData['user_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->user_id;
        $newCrudData['email'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->email;
        $newCrudData['password'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->password;
        $newCrudData['emp_code'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->emp_code;
        $newCrudData['nombre_enfant'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nombre_enfant;
        $newCrudData['num_dossier'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->num_dossier;
        $newCrudData['online_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->online_id;
        $newCrudData['type_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->type_id;
        $newCrudData['faction_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->faction_id;
        $newCrudData['identifiants_sadge'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->identifiants_sadge;
        $newCrudData['creat_by'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->creat_by;
        $newCrudData['role_id'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->role_id;

        try {
            $newCrudData['actif'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['role'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->role->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->type->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Tables6b35594d8891437fb6fba75a3fe60fdbTables->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Tables6b35594d8891437fb6fba75a3fe60fdbTables', 'entite_cle' => $Tables6b35594d8891437fb6fba75a3fe60fdbTables->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras') &&
            method_exists('\App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras', 'canDelete')
        ) {
            try {
                $canSave = \App\Http\Extras\Tables6b35594d8891437fb6fba75a3fe60fdbTableExtras::canDelete($request, $Tables6b35594d8891437fb6fba75a3fe60fdbTables);
            } catch (\Throwable $e) {

            }

        }


        if ($canSave) {
            $Tables6b35594d8891437fb6fba75a3fe60fdbTables->delete();
        } else {
            return response()->json($Tables6b35594d8891437fb6fba75a3fe60fdbTables, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new \App\Http\Actions\Tables6b35594d8891437fb6fba75a3fe60fdbTablesActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
