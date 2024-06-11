<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Actions\Tablescca662dcb4954de6a1c6d1ae68209760TablesActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\Tablescca662dcb4954de6a1c6d1ae68209760Table;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

// use App\Repository\prod\Tablescca662dcb4954de6a1c6d1ae68209760TablesRepository;


class Tablescca662dcb4954de6a1c6d1ae68209760TableController extends Controller
{

    private $Tablescca662dcb4954de6a1c6d1ae68209760TablesRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\Tablescca662dcb4954de6a1c6d1ae68209760TablesRepository $Tablescca662dcb4954de6a1c6d1ae68209760TablesRepository
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
        $query = Tablescca662dcb4954de6a1c6d1ae68209760Table::query();
        if (!empty($extras['filterFields']) && is_array($extras['filterFields']) && !empty($extras['globalSearch'])) {
            $query->where(function ($q1) use ($extras) {

                foreach ($extras['filterFields'] as $key => $ex) {
                    $value = "%" . $extras['globalSearch'] . "%";
                    if ($key == 0) {

                        $q1->where($ex, "LIKE", $value);
                    } else {
                        $q1->orWhere($ex, "LIKE", $value);
                    }

                }

            });


        }
        if (
            class_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras') &&
            method_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras', 'filterAgGridQuery')
        ) {
            Tablescca662dcb4954de6a1c6d1ae68209760TableExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('Tablescca662dcb4954de6a1c6d1ae68209760Tables', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras') &&
            method_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = collect($_d)->map(function ($data) use ($request) {
                return Tablescca662dcb4954de6a1c6d1ae68209760TableExtras::AgGridUpdateDataBeforeReturnToUser($request, $data);
            });
            $data['rowData'] = $_d->toArray();
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
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
            return response()->json(Tablescca662dcb4954de6a1c6d1ae68209760Table::count());
        }
        $data = QueryBuilder::for(Tablescca662dcb4954de6a1c6d1ae68209760Table::class)
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
        }


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function data1(Request $request)
    {


        $data = QueryBuilder::for(Tablescca662dcb4954de6a1c6d1ae68209760Table::class)
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
        }


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


    public function create(Request $request, Tablescca662dcb4954de6a1c6d1ae68209760Table $Tablescca662dcb4954de6a1c6d1ae68209760Tables)
    {


        try {
            $can = Helpers::can('Creer des Tablescca662dcb4954de6a1c6d1ae68209760Tables');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "Tablescca662dcb4954de6a1c6d1ae68209760Tables" . "-" . $key . "_" . time() . "." . $file->extension()
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
            'extra_attributes',
            'created_at',
            'updated_at',
            'deleted_at',
            'identifiants_sadge',
            'creat_by',
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


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['name'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->name = $data['name'];

        }


        if (!empty($data['nom'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nom = $data['nom'];

        }


        if (!empty($data['prenom'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->prenom = $data['prenom'];

        }


        if (!empty($data['matricule'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matricule = $data['matricule'];

        }


        if (!empty($data['num_badge'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_badge = $data['num_badge'];

        }


        if (!empty($data['date_naissance'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_naissance = $data['date_naissance'];

        }


        if (!empty($data['num_cnss'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnss = $data['num_cnss'];

        }


        if (!empty($data['num_cnamgs'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnamgs = $data['num_cnamgs'];

        }


        if (!empty($data['telephone1'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone1 = $data['telephone1'];

        }


        if (!empty($data['telephone2'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone2 = $data['telephone2'];

        }


        if (!empty($data['photo'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->photo = $data['photo'];

        }


        if (!empty($data['date_embauche'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_embauche = $data['date_embauche'];

        }


        if (!empty($data['download_date'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->download_date = $data['download_date'];

        }


        if (!empty($data['actif_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->actif_id = $data['actif_id'];

        }


        if (!empty($data['nationalite_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nationalite_id = $data['nationalite_id'];

        }


        if (!empty($data['contrat_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->contrat_id = $data['contrat_id'];

        }


        if (!empty($data['direction_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->direction_id = $data['direction_id'];

        }


        if (!empty($data['categorie_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->categorie_id = $data['categorie_id'];

        }


        if (!empty($data['echelon_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->echelon_id = $data['echelon_id'];

        }


        if (!empty($data['sexe_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->sexe_id = $data['sexe_id'];

        }


        if (!empty($data['matrimoniale_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matrimoniale_id = $data['matrimoniale_id'];

        }


        if (!empty($data['poste_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->poste_id = $data['poste_id'];

        }


        if (!empty($data['ville_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->ville_id = $data['ville_id'];

        }


        if (!empty($data['zone_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->zone_id = $data['zone_id'];

        }


        if (!empty($data['site_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->site_id = $data['site_id'];

        }


        if (!empty($data['situation_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->situation_id = $data['situation_id'];

        }


        if (!empty($data['balise_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->balise_id = $data['balise_id'];

        }


        if (!empty($data['fonction_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->fonction_id = $data['fonction_id'];

        }


        if (!empty($data['user_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->user_id = $data['user_id'];

        }


        if (!empty($data['email'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->email = $data['email'];

        }


        if (!empty($data['password'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->password = $data['password'];

        }


        if (!empty($data['emp_code'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->emp_code = $data['emp_code'];

        }


        if (!empty($data['nombre_enfant'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nombre_enfant = $data['nombre_enfant'];

        }


        if (!empty($data['num_dossier'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_dossier = $data['num_dossier'];

        }


        if (!empty($data['online_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->online_id = $data['online_id'];

        }


        if (!empty($data['type_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->type_id = $data['type_id'];

        }


        if (!empty($data['faction_id'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->faction_id = $data['faction_id'];

        }


        if (!empty($data['identifiants_sadge'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->identifiants_sadge = $data['identifiants_sadge'];

        }


        if (!empty($data['creat_by'])) {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->creat_by = $data['creat_by'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras') &&
            method_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras', 'beforeSaveCreate')
        ) {
            Tablescca662dcb4954de6a1c6d1ae68209760TableExtras::beforeSaveCreate($request, $Tablescca662dcb4954de6a1c6d1ae68209760Tables);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras') &&
            method_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras', 'canCreate')
        ) {
            try {
                $canSave = Tablescca662dcb4954de6a1c6d1ae68209760TableExtras::canCreate($request, $Tablescca662dcb4954de6a1c6d1ae68209760Tables);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->save();
        } else {
            return response()->json($Tablescca662dcb4954de6a1c6d1ae68209760Tables, 200);
        }

        $Tablescca662dcb4954de6a1c6d1ae68209760Tables = Tablescca662dcb4954de6a1c6d1ae68209760Table::find($Tablescca662dcb4954de6a1c6d1ae68209760Tables->id);
        $newCrudData = [];

        $newCrudData['name'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->name;
        $newCrudData['nom'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nom;
        $newCrudData['prenom'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->prenom;
        $newCrudData['matricule'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matricule;
        $newCrudData['num_badge'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_badge;
        $newCrudData['date_naissance'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_naissance;
        $newCrudData['num_cnss'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnss;
        $newCrudData['num_cnamgs'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnamgs;
        $newCrudData['telephone1'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone1;
        $newCrudData['telephone2'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone2;
        $newCrudData['photo'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->photo;
        $newCrudData['date_embauche'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_embauche;
        $newCrudData['download_date'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->download_date;
        $newCrudData['actif_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->actif_id;
        $newCrudData['nationalite_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nationalite_id;
        $newCrudData['contrat_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->contrat_id;
        $newCrudData['direction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->direction_id;
        $newCrudData['categorie_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->categorie_id;
        $newCrudData['echelon_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->echelon_id;
        $newCrudData['sexe_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->sexe_id;
        $newCrudData['matrimoniale_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matrimoniale_id;
        $newCrudData['poste_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->poste_id;
        $newCrudData['ville_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->ville_id;
        $newCrudData['zone_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->zone_id;
        $newCrudData['site_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->site_id;
        $newCrudData['situation_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->situation_id;
        $newCrudData['balise_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->balise_id;
        $newCrudData['fonction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->fonction_id;
        $newCrudData['user_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->user_id;
        $newCrudData['email'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->email;
        $newCrudData['password'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->password;
        $newCrudData['emp_code'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->emp_code;
        $newCrudData['nombre_enfant'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nombre_enfant;
        $newCrudData['num_dossier'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_dossier;
        $newCrudData['online_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->online_id;
        $newCrudData['type_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->type_id;
        $newCrudData['faction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->faction_id;
        $newCrudData['identifiants_sadge'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->identifiants_sadge;
        $newCrudData['creat_by'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->creat_by;

        try {
            $newCrudData['actif'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->balise->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->categorie->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->direction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->echelon->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->faction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->site->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->situation->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->user->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->ville->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->zone->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Tablescca662dcb4954de6a1c6d1ae68209760Tables', 'entite_cle' => $Tablescca662dcb4954de6a1c6d1ae68209760Tables->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->toArray();


        try {

            foreach ($Tablescca662dcb4954de6a1c6d1ae68209760Tables->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (Throwable $e) {
        }


        return response()->json($response, 200);


    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */


    public function update(Request $request, Tablescca662dcb4954de6a1c6d1ae68209760Table $Tablescca662dcb4954de6a1c6d1ae68209760Tables)
    {
        try {
            $can = Helpers::can('Editer des Tablescca662dcb4954de6a1c6d1ae68209760Tables');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['name'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->name;
        $oldCrudData['nom'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nom;
        $oldCrudData['prenom'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->prenom;
        $oldCrudData['matricule'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matricule;
        $oldCrudData['num_badge'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_badge;
        $oldCrudData['date_naissance'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_naissance;
        $oldCrudData['num_cnss'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnss;
        $oldCrudData['num_cnamgs'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnamgs;
        $oldCrudData['telephone1'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone1;
        $oldCrudData['telephone2'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone2;
        $oldCrudData['photo'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->photo;
        $oldCrudData['date_embauche'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_embauche;
        $oldCrudData['download_date'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->download_date;
        $oldCrudData['actif_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->actif_id;
        $oldCrudData['nationalite_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nationalite_id;
        $oldCrudData['contrat_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->contrat_id;
        $oldCrudData['direction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->direction_id;
        $oldCrudData['categorie_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->categorie_id;
        $oldCrudData['echelon_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->echelon_id;
        $oldCrudData['sexe_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->sexe_id;
        $oldCrudData['matrimoniale_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matrimoniale_id;
        $oldCrudData['poste_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->poste_id;
        $oldCrudData['ville_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->ville_id;
        $oldCrudData['zone_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->zone_id;
        $oldCrudData['site_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->site_id;
        $oldCrudData['situation_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->situation_id;
        $oldCrudData['balise_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->balise_id;
        $oldCrudData['fonction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->fonction_id;
        $oldCrudData['user_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->user_id;
        $oldCrudData['email'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->email;
        $oldCrudData['password'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->password;
        $oldCrudData['emp_code'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->emp_code;
        $oldCrudData['nombre_enfant'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nombre_enfant;
        $oldCrudData['num_dossier'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_dossier;
        $oldCrudData['online_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->online_id;
        $oldCrudData['type_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->type_id;
        $oldCrudData['faction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->faction_id;
        $oldCrudData['identifiants_sadge'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->identifiants_sadge;
        $oldCrudData['creat_by'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->creat_by;

        try {
            $oldCrudData['actif'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['balise'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->balise->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['categorie'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->categorie->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['contrat'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['direction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->direction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['echelon'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->echelon->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['faction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->faction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['fonction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['matrimoniale'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['nationalite'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['online'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['poste'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['sexe'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['site'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->site->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['situation'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->situation->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['type'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->user->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['ville'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->ville->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->zone->Selectlabel;
        } catch (Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "Tablescca662dcb4954de6a1c6d1ae68209760Tables" . "-" . $key . "_" . time() . "." . $file->extension()
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
            'extra_attributes',
            'created_at',
            'updated_at',
            'deleted_at',
            'identifiants_sadge',
            'creat_by',
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


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("name", $data)) {


            if (!empty($data['name'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->name = $data['name'];

            }

        }


        if (array_key_exists("nom", $data)) {


            if (!empty($data['nom'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nom = $data['nom'];

            }

        }


        if (array_key_exists("prenom", $data)) {


            if (!empty($data['prenom'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->prenom = $data['prenom'];

            }

        }


        if (array_key_exists("matricule", $data)) {


            if (!empty($data['matricule'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matricule = $data['matricule'];

            }

        }


        if (array_key_exists("num_badge", $data)) {


            if (!empty($data['num_badge'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_badge = $data['num_badge'];

            }

        }


        if (array_key_exists("date_naissance", $data)) {


            if (!empty($data['date_naissance'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_naissance = $data['date_naissance'];

            }

        }


        if (array_key_exists("num_cnss", $data)) {


            if (!empty($data['num_cnss'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnss = $data['num_cnss'];

            }

        }


        if (array_key_exists("num_cnamgs", $data)) {


            if (!empty($data['num_cnamgs'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnamgs = $data['num_cnamgs'];

            }

        }


        if (array_key_exists("telephone1", $data)) {


            if (!empty($data['telephone1'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone1 = $data['telephone1'];

            }

        }


        if (array_key_exists("telephone2", $data)) {


            if (!empty($data['telephone2'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone2 = $data['telephone2'];

            }

        }


        if (array_key_exists("photo", $data)) {


            if (!empty($data['photo'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->photo = $data['photo'];

            }

        }


        if (array_key_exists("date_embauche", $data)) {


            if (!empty($data['date_embauche'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_embauche = $data['date_embauche'];

            }

        }


        if (array_key_exists("download_date", $data)) {


            if (!empty($data['download_date'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->download_date = $data['download_date'];

            }

        }


        if (array_key_exists("actif_id", $data)) {


            if (!empty($data['actif_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->actif_id = $data['actif_id'];

            }

        }


        if (array_key_exists("nationalite_id", $data)) {


            if (!empty($data['nationalite_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nationalite_id = $data['nationalite_id'];

            }

        }


        if (array_key_exists("contrat_id", $data)) {


            if (!empty($data['contrat_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->contrat_id = $data['contrat_id'];

            }

        }


        if (array_key_exists("direction_id", $data)) {


            if (!empty($data['direction_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->direction_id = $data['direction_id'];

            }

        }


        if (array_key_exists("categorie_id", $data)) {


            if (!empty($data['categorie_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->categorie_id = $data['categorie_id'];

            }

        }


        if (array_key_exists("echelon_id", $data)) {


            if (!empty($data['echelon_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->echelon_id = $data['echelon_id'];

            }

        }


        if (array_key_exists("sexe_id", $data)) {


            if (!empty($data['sexe_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->sexe_id = $data['sexe_id'];

            }

        }


        if (array_key_exists("matrimoniale_id", $data)) {


            if (!empty($data['matrimoniale_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matrimoniale_id = $data['matrimoniale_id'];

            }

        }


        if (array_key_exists("poste_id", $data)) {


            if (!empty($data['poste_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->poste_id = $data['poste_id'];

            }

        }


        if (array_key_exists("ville_id", $data)) {


            if (!empty($data['ville_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->ville_id = $data['ville_id'];

            }

        }


        if (array_key_exists("zone_id", $data)) {


            if (!empty($data['zone_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->zone_id = $data['zone_id'];

            }

        }


        if (array_key_exists("site_id", $data)) {


            if (!empty($data['site_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->site_id = $data['site_id'];

            }

        }


        if (array_key_exists("situation_id", $data)) {


            if (!empty($data['situation_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->situation_id = $data['situation_id'];

            }

        }


        if (array_key_exists("balise_id", $data)) {


            if (!empty($data['balise_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->balise_id = $data['balise_id'];

            }

        }


        if (array_key_exists("fonction_id", $data)) {


            if (!empty($data['fonction_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->fonction_id = $data['fonction_id'];

            }

        }


        if (array_key_exists("user_id", $data)) {


            if (!empty($data['user_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->user_id = $data['user_id'];

            }

        }


        if (array_key_exists("email", $data)) {


            if (!empty($data['email'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->email = $data['email'];

            }

        }


        if (array_key_exists("password", $data)) {


            if (!empty($data['password'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->password = $data['password'];

            }

        }


        if (array_key_exists("emp_code", $data)) {


            if (!empty($data['emp_code'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->emp_code = $data['emp_code'];

            }

        }


        if (array_key_exists("nombre_enfant", $data)) {


            if (!empty($data['nombre_enfant'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nombre_enfant = $data['nombre_enfant'];

            }

        }


        if (array_key_exists("num_dossier", $data)) {


            if (!empty($data['num_dossier'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_dossier = $data['num_dossier'];

            }

        }


        if (array_key_exists("online_id", $data)) {


            if (!empty($data['online_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->online_id = $data['online_id'];

            }

        }


        if (array_key_exists("type_id", $data)) {


            if (!empty($data['type_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->type_id = $data['type_id'];

            }

        }


        if (array_key_exists("faction_id", $data)) {


            if (!empty($data['faction_id'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->faction_id = $data['faction_id'];

            }

        }


        if (array_key_exists("identifiants_sadge", $data)) {


            if (!empty($data['identifiants_sadge'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->identifiants_sadge = $data['identifiants_sadge'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Tablescca662dcb4954de6a1c6d1ae68209760Tables->creat_by = $data['creat_by'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras') &&
            method_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras', 'beforeSaveUpdate')
        ) {
            Tablescca662dcb4954de6a1c6d1ae68209760TableExtras::beforeSaveUpdate($request, $Tablescca662dcb4954de6a1c6d1ae68209760Tables);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras') &&
            method_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras', 'canUpdate')
        ) {
            try {
                $canSave = Tablescca662dcb4954de6a1c6d1ae68209760TableExtras::canUpdate($request, $Tablescca662dcb4954de6a1c6d1ae68209760Tables);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->save();
        } else {
            return response()->json($Tablescca662dcb4954de6a1c6d1ae68209760Tables, 200);

        }


        $Tablescca662dcb4954de6a1c6d1ae68209760Tables = Tablescca662dcb4954de6a1c6d1ae68209760Table::find($Tablescca662dcb4954de6a1c6d1ae68209760Tables->id);


        $newCrudData = [];

        $newCrudData['name'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->name;
        $newCrudData['nom'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nom;
        $newCrudData['prenom'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->prenom;
        $newCrudData['matricule'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matricule;
        $newCrudData['num_badge'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_badge;
        $newCrudData['date_naissance'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_naissance;
        $newCrudData['num_cnss'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnss;
        $newCrudData['num_cnamgs'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnamgs;
        $newCrudData['telephone1'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone1;
        $newCrudData['telephone2'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone2;
        $newCrudData['photo'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->photo;
        $newCrudData['date_embauche'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_embauche;
        $newCrudData['download_date'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->download_date;
        $newCrudData['actif_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->actif_id;
        $newCrudData['nationalite_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nationalite_id;
        $newCrudData['contrat_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->contrat_id;
        $newCrudData['direction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->direction_id;
        $newCrudData['categorie_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->categorie_id;
        $newCrudData['echelon_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->echelon_id;
        $newCrudData['sexe_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->sexe_id;
        $newCrudData['matrimoniale_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matrimoniale_id;
        $newCrudData['poste_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->poste_id;
        $newCrudData['ville_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->ville_id;
        $newCrudData['zone_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->zone_id;
        $newCrudData['site_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->site_id;
        $newCrudData['situation_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->situation_id;
        $newCrudData['balise_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->balise_id;
        $newCrudData['fonction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->fonction_id;
        $newCrudData['user_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->user_id;
        $newCrudData['email'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->email;
        $newCrudData['password'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->password;
        $newCrudData['emp_code'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->emp_code;
        $newCrudData['nombre_enfant'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nombre_enfant;
        $newCrudData['num_dossier'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_dossier;
        $newCrudData['online_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->online_id;
        $newCrudData['type_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->type_id;
        $newCrudData['faction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->faction_id;
        $newCrudData['identifiants_sadge'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->identifiants_sadge;
        $newCrudData['creat_by'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->creat_by;

        try {
            $newCrudData['actif'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->balise->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->categorie->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->direction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->echelon->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->faction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->site->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->situation->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->user->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->ville->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->zone->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Tablescca662dcb4954de6a1c6d1ae68209760Tables', 'entite_cle' => $Tablescca662dcb4954de6a1c6d1ae68209760Tables->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->toArray();


        try {

            foreach ($Tablescca662dcb4954de6a1c6d1ae68209760Tables->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (Throwable $e) {
        }


        return response()->json($response, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, Tablescca662dcb4954de6a1c6d1ae68209760Table $Tablescca662dcb4954de6a1c6d1ae68209760Tables)
    {
        try {
            $can = Helpers::can('Supprimer des Tablescca662dcb4954de6a1c6d1ae68209760Tables');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['name'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->name;
        $newCrudData['nom'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nom;
        $newCrudData['prenom'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->prenom;
        $newCrudData['matricule'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matricule;
        $newCrudData['num_badge'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_badge;
        $newCrudData['date_naissance'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_naissance;
        $newCrudData['num_cnss'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnss;
        $newCrudData['num_cnamgs'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_cnamgs;
        $newCrudData['telephone1'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone1;
        $newCrudData['telephone2'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->telephone2;
        $newCrudData['photo'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->photo;
        $newCrudData['date_embauche'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->date_embauche;
        $newCrudData['download_date'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->download_date;
        $newCrudData['actif_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->actif_id;
        $newCrudData['nationalite_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nationalite_id;
        $newCrudData['contrat_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->contrat_id;
        $newCrudData['direction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->direction_id;
        $newCrudData['categorie_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->categorie_id;
        $newCrudData['echelon_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->echelon_id;
        $newCrudData['sexe_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->sexe_id;
        $newCrudData['matrimoniale_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matrimoniale_id;
        $newCrudData['poste_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->poste_id;
        $newCrudData['ville_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->ville_id;
        $newCrudData['zone_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->zone_id;
        $newCrudData['site_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->site_id;
        $newCrudData['situation_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->situation_id;
        $newCrudData['balise_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->balise_id;
        $newCrudData['fonction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->fonction_id;
        $newCrudData['user_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->user_id;
        $newCrudData['email'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->email;
        $newCrudData['password'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->password;
        $newCrudData['emp_code'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->emp_code;
        $newCrudData['nombre_enfant'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nombre_enfant;
        $newCrudData['num_dossier'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->num_dossier;
        $newCrudData['online_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->online_id;
        $newCrudData['type_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->type_id;
        $newCrudData['faction_id'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->faction_id;
        $newCrudData['identifiants_sadge'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->identifiants_sadge;
        $newCrudData['creat_by'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->creat_by;

        try {
            $newCrudData['actif'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->balise->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->categorie->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->direction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->echelon->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->faction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->site->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->situation->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->user->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->ville->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Tablescca662dcb4954de6a1c6d1ae68209760Tables->zone->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Tablescca662dcb4954de6a1c6d1ae68209760Tables', 'entite_cle' => $Tablescca662dcb4954de6a1c6d1ae68209760Tables->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras') &&
            method_exists('\App\Http\Extras\Tablescca662dcb4954de6a1c6d1ae68209760TableExtras', 'canDelete')
        ) {
            try {
                $canSave = Tablescca662dcb4954de6a1c6d1ae68209760TableExtras::canDelete($request, $Tablescca662dcb4954de6a1c6d1ae68209760Tables);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Tablescca662dcb4954de6a1c6d1ae68209760Tables->delete();
        } else {
            return response()->json($Tablescca662dcb4954de6a1c6d1ae68209760Tables, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new Tablescca662dcb4954de6a1c6d1ae68209760TablesActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
