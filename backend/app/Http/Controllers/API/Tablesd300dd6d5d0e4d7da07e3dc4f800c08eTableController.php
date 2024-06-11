<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Actions\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTablesActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTable;
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

// use App\Repository\prod\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTablesRepository;


class Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableController extends Controller
{

    private $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTablesRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTablesRepository $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTablesRepository
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
        $query = Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTable::query();
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
            class_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras') &&
            method_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras', 'filterAgGridQuery')
        ) {
            Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables', $query);
        $data = $agGrid->getData($request);
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
            return response()->json(Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTable::count());
        }
        $data = QueryBuilder::for(Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTable::class)
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


        $data = QueryBuilder::for(Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTable::class)
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


    public function create(Request $request, Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTable $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables)
    {


        try {
            $can = Helpers::can('Creer des Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables" . "-" . $key . "_" . time() . "." . $file->extension()
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

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->name = $data['name'];

        }


        if (!empty($data['nom'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nom = $data['nom'];

        }


        if (!empty($data['prenom'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->prenom = $data['prenom'];

        }


        if (!empty($data['matricule'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matricule = $data['matricule'];

        }


        if (!empty($data['num_badge'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_badge = $data['num_badge'];

        }


        if (!empty($data['date_naissance'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_naissance = $data['date_naissance'];

        }


        if (!empty($data['num_cnss'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnss = $data['num_cnss'];

        }


        if (!empty($data['num_cnamgs'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnamgs = $data['num_cnamgs'];

        }


        if (!empty($data['telephone1'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone1 = $data['telephone1'];

        }


        if (!empty($data['telephone2'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone2 = $data['telephone2'];

        }


        if (!empty($data['photo'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->photo = $data['photo'];

        }


        if (!empty($data['date_embauche'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_embauche = $data['date_embauche'];

        }


        if (!empty($data['download_date'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->download_date = $data['download_date'];

        }


        if (!empty($data['actif_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->actif_id = $data['actif_id'];

        }


        if (!empty($data['nationalite_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nationalite_id = $data['nationalite_id'];

        }


        if (!empty($data['contrat_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->contrat_id = $data['contrat_id'];

        }


        if (!empty($data['direction_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->direction_id = $data['direction_id'];

        }


        if (!empty($data['categorie_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->categorie_id = $data['categorie_id'];

        }


        if (!empty($data['echelon_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->echelon_id = $data['echelon_id'];

        }


        if (!empty($data['sexe_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->sexe_id = $data['sexe_id'];

        }


        if (!empty($data['matrimoniale_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matrimoniale_id = $data['matrimoniale_id'];

        }


        if (!empty($data['poste_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->poste_id = $data['poste_id'];

        }


        if (!empty($data['ville_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->ville_id = $data['ville_id'];

        }


        if (!empty($data['zone_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->zone_id = $data['zone_id'];

        }


        if (!empty($data['site_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->site_id = $data['site_id'];

        }


        if (!empty($data['situation_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->situation_id = $data['situation_id'];

        }


        if (!empty($data['balise_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->balise_id = $data['balise_id'];

        }


        if (!empty($data['fonction_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->fonction_id = $data['fonction_id'];

        }


        if (!empty($data['user_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->user_id = $data['user_id'];

        }


        if (!empty($data['email'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->email = $data['email'];

        }


        if (!empty($data['password'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->password = $data['password'];

        }


        if (!empty($data['emp_code'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->emp_code = $data['emp_code'];

        }


        if (!empty($data['nombre_enfant'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nombre_enfant = $data['nombre_enfant'];

        }


        if (!empty($data['num_dossier'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_dossier = $data['num_dossier'];

        }


        if (!empty($data['online_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->online_id = $data['online_id'];

        }


        if (!empty($data['type_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->type_id = $data['type_id'];

        }


        if (!empty($data['faction_id'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->faction_id = $data['faction_id'];

        }


        if (!empty($data['identifiants_sadge'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->identifiants_sadge = $data['identifiants_sadge'];

        }


        if (!empty($data['creat_by'])) {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->creat_by = $data['creat_by'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras') &&
            method_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras', 'beforeSaveCreate')
        ) {
            Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras::beforeSaveCreate($request, $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras') &&
            method_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras', 'canCreate')
        ) {
            try {
                $canSave = Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras::canCreate($request, $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->save();
        } else {
            return response()->json($Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables, 200);
        }

        $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables = Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTable::find($Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->id);
        $newCrudData = [];

        $newCrudData['name'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->name;
        $newCrudData['nom'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nom;
        $newCrudData['prenom'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->prenom;
        $newCrudData['matricule'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matricule;
        $newCrudData['num_badge'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_badge;
        $newCrudData['date_naissance'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_naissance;
        $newCrudData['num_cnss'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnss;
        $newCrudData['num_cnamgs'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnamgs;
        $newCrudData['telephone1'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone1;
        $newCrudData['telephone2'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone2;
        $newCrudData['photo'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->photo;
        $newCrudData['date_embauche'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_embauche;
        $newCrudData['download_date'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->download_date;
        $newCrudData['actif_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->actif_id;
        $newCrudData['nationalite_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nationalite_id;
        $newCrudData['contrat_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->contrat_id;
        $newCrudData['direction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->direction_id;
        $newCrudData['categorie_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->categorie_id;
        $newCrudData['echelon_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->echelon_id;
        $newCrudData['sexe_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->sexe_id;
        $newCrudData['matrimoniale_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matrimoniale_id;
        $newCrudData['poste_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->poste_id;
        $newCrudData['ville_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->ville_id;
        $newCrudData['zone_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->zone_id;
        $newCrudData['site_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->site_id;
        $newCrudData['situation_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->situation_id;
        $newCrudData['balise_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->balise_id;
        $newCrudData['fonction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->fonction_id;
        $newCrudData['user_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->user_id;
        $newCrudData['email'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->email;
        $newCrudData['password'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->password;
        $newCrudData['emp_code'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->emp_code;
        $newCrudData['nombre_enfant'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nombre_enfant;
        $newCrudData['num_dossier'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_dossier;
        $newCrudData['online_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->online_id;
        $newCrudData['type_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->type_id;
        $newCrudData['faction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->faction_id;
        $newCrudData['identifiants_sadge'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->identifiants_sadge;
        $newCrudData['creat_by'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->creat_by;

        try {
            $newCrudData['actif'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->balise->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->categorie->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->direction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->echelon->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->faction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->site->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->situation->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->user->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->ville->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->zone->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables', 'entite_cle' => $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->toArray();


        try {

            foreach ($Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTable $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables)
    {
        try {
            $can = Helpers::can('Editer des Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['name'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->name;
        $oldCrudData['nom'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nom;
        $oldCrudData['prenom'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->prenom;
        $oldCrudData['matricule'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matricule;
        $oldCrudData['num_badge'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_badge;
        $oldCrudData['date_naissance'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_naissance;
        $oldCrudData['num_cnss'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnss;
        $oldCrudData['num_cnamgs'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnamgs;
        $oldCrudData['telephone1'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone1;
        $oldCrudData['telephone2'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone2;
        $oldCrudData['photo'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->photo;
        $oldCrudData['date_embauche'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_embauche;
        $oldCrudData['download_date'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->download_date;
        $oldCrudData['actif_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->actif_id;
        $oldCrudData['nationalite_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nationalite_id;
        $oldCrudData['contrat_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->contrat_id;
        $oldCrudData['direction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->direction_id;
        $oldCrudData['categorie_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->categorie_id;
        $oldCrudData['echelon_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->echelon_id;
        $oldCrudData['sexe_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->sexe_id;
        $oldCrudData['matrimoniale_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matrimoniale_id;
        $oldCrudData['poste_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->poste_id;
        $oldCrudData['ville_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->ville_id;
        $oldCrudData['zone_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->zone_id;
        $oldCrudData['site_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->site_id;
        $oldCrudData['situation_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->situation_id;
        $oldCrudData['balise_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->balise_id;
        $oldCrudData['fonction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->fonction_id;
        $oldCrudData['user_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->user_id;
        $oldCrudData['email'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->email;
        $oldCrudData['password'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->password;
        $oldCrudData['emp_code'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->emp_code;
        $oldCrudData['nombre_enfant'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nombre_enfant;
        $oldCrudData['num_dossier'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_dossier;
        $oldCrudData['online_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->online_id;
        $oldCrudData['type_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->type_id;
        $oldCrudData['faction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->faction_id;
        $oldCrudData['identifiants_sadge'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->identifiants_sadge;
        $oldCrudData['creat_by'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->creat_by;

        try {
            $oldCrudData['actif'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['balise'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->balise->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['categorie'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->categorie->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['contrat'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['direction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->direction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['echelon'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->echelon->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['faction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->faction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['fonction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['matrimoniale'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['nationalite'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['online'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['poste'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['sexe'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['site'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->site->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['situation'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->situation->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['type'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->user->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['ville'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->ville->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->zone->Selectlabel;
        } catch (Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables" . "-" . $key . "_" . time() . "." . $file->extension()
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

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->name = $data['name'];

            }

        }


        if (array_key_exists("nom", $data)) {


            if (!empty($data['nom'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nom = $data['nom'];

            }

        }


        if (array_key_exists("prenom", $data)) {


            if (!empty($data['prenom'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->prenom = $data['prenom'];

            }

        }


        if (array_key_exists("matricule", $data)) {


            if (!empty($data['matricule'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matricule = $data['matricule'];

            }

        }


        if (array_key_exists("num_badge", $data)) {


            if (!empty($data['num_badge'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_badge = $data['num_badge'];

            }

        }


        if (array_key_exists("date_naissance", $data)) {


            if (!empty($data['date_naissance'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_naissance = $data['date_naissance'];

            }

        }


        if (array_key_exists("num_cnss", $data)) {


            if (!empty($data['num_cnss'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnss = $data['num_cnss'];

            }

        }


        if (array_key_exists("num_cnamgs", $data)) {


            if (!empty($data['num_cnamgs'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnamgs = $data['num_cnamgs'];

            }

        }


        if (array_key_exists("telephone1", $data)) {


            if (!empty($data['telephone1'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone1 = $data['telephone1'];

            }

        }


        if (array_key_exists("telephone2", $data)) {


            if (!empty($data['telephone2'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone2 = $data['telephone2'];

            }

        }


        if (array_key_exists("photo", $data)) {


            if (!empty($data['photo'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->photo = $data['photo'];

            }

        }


        if (array_key_exists("date_embauche", $data)) {


            if (!empty($data['date_embauche'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_embauche = $data['date_embauche'];

            }

        }


        if (array_key_exists("download_date", $data)) {


            if (!empty($data['download_date'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->download_date = $data['download_date'];

            }

        }


        if (array_key_exists("actif_id", $data)) {


            if (!empty($data['actif_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->actif_id = $data['actif_id'];

            }

        }


        if (array_key_exists("nationalite_id", $data)) {


            if (!empty($data['nationalite_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nationalite_id = $data['nationalite_id'];

            }

        }


        if (array_key_exists("contrat_id", $data)) {


            if (!empty($data['contrat_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->contrat_id = $data['contrat_id'];

            }

        }


        if (array_key_exists("direction_id", $data)) {


            if (!empty($data['direction_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->direction_id = $data['direction_id'];

            }

        }


        if (array_key_exists("categorie_id", $data)) {


            if (!empty($data['categorie_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->categorie_id = $data['categorie_id'];

            }

        }


        if (array_key_exists("echelon_id", $data)) {


            if (!empty($data['echelon_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->echelon_id = $data['echelon_id'];

            }

        }


        if (array_key_exists("sexe_id", $data)) {


            if (!empty($data['sexe_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->sexe_id = $data['sexe_id'];

            }

        }


        if (array_key_exists("matrimoniale_id", $data)) {


            if (!empty($data['matrimoniale_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matrimoniale_id = $data['matrimoniale_id'];

            }

        }


        if (array_key_exists("poste_id", $data)) {


            if (!empty($data['poste_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->poste_id = $data['poste_id'];

            }

        }


        if (array_key_exists("ville_id", $data)) {


            if (!empty($data['ville_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->ville_id = $data['ville_id'];

            }

        }


        if (array_key_exists("zone_id", $data)) {


            if (!empty($data['zone_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->zone_id = $data['zone_id'];

            }

        }


        if (array_key_exists("site_id", $data)) {


            if (!empty($data['site_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->site_id = $data['site_id'];

            }

        }


        if (array_key_exists("situation_id", $data)) {


            if (!empty($data['situation_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->situation_id = $data['situation_id'];

            }

        }


        if (array_key_exists("balise_id", $data)) {


            if (!empty($data['balise_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->balise_id = $data['balise_id'];

            }

        }


        if (array_key_exists("fonction_id", $data)) {


            if (!empty($data['fonction_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->fonction_id = $data['fonction_id'];

            }

        }


        if (array_key_exists("user_id", $data)) {


            if (!empty($data['user_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->user_id = $data['user_id'];

            }

        }


        if (array_key_exists("email", $data)) {


            if (!empty($data['email'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->email = $data['email'];

            }

        }


        if (array_key_exists("password", $data)) {


            if (!empty($data['password'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->password = $data['password'];

            }

        }


        if (array_key_exists("emp_code", $data)) {


            if (!empty($data['emp_code'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->emp_code = $data['emp_code'];

            }

        }


        if (array_key_exists("nombre_enfant", $data)) {


            if (!empty($data['nombre_enfant'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nombre_enfant = $data['nombre_enfant'];

            }

        }


        if (array_key_exists("num_dossier", $data)) {


            if (!empty($data['num_dossier'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_dossier = $data['num_dossier'];

            }

        }


        if (array_key_exists("online_id", $data)) {


            if (!empty($data['online_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->online_id = $data['online_id'];

            }

        }


        if (array_key_exists("type_id", $data)) {


            if (!empty($data['type_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->type_id = $data['type_id'];

            }

        }


        if (array_key_exists("faction_id", $data)) {


            if (!empty($data['faction_id'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->faction_id = $data['faction_id'];

            }

        }


        if (array_key_exists("identifiants_sadge", $data)) {


            if (!empty($data['identifiants_sadge'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->identifiants_sadge = $data['identifiants_sadge'];

            }

        }


        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->creat_by = $data['creat_by'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras') &&
            method_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras', 'beforeSaveUpdate')
        ) {
            Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras::beforeSaveUpdate($request, $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras') &&
            method_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras', 'canUpdate')
        ) {
            try {
                $canSave = Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras::canUpdate($request, $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->save();
        } else {
            return response()->json($Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables, 200);

        }


        $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables = Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTable::find($Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->id);


        $newCrudData = [];

        $newCrudData['name'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->name;
        $newCrudData['nom'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nom;
        $newCrudData['prenom'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->prenom;
        $newCrudData['matricule'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matricule;
        $newCrudData['num_badge'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_badge;
        $newCrudData['date_naissance'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_naissance;
        $newCrudData['num_cnss'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnss;
        $newCrudData['num_cnamgs'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnamgs;
        $newCrudData['telephone1'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone1;
        $newCrudData['telephone2'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone2;
        $newCrudData['photo'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->photo;
        $newCrudData['date_embauche'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_embauche;
        $newCrudData['download_date'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->download_date;
        $newCrudData['actif_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->actif_id;
        $newCrudData['nationalite_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nationalite_id;
        $newCrudData['contrat_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->contrat_id;
        $newCrudData['direction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->direction_id;
        $newCrudData['categorie_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->categorie_id;
        $newCrudData['echelon_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->echelon_id;
        $newCrudData['sexe_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->sexe_id;
        $newCrudData['matrimoniale_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matrimoniale_id;
        $newCrudData['poste_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->poste_id;
        $newCrudData['ville_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->ville_id;
        $newCrudData['zone_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->zone_id;
        $newCrudData['site_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->site_id;
        $newCrudData['situation_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->situation_id;
        $newCrudData['balise_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->balise_id;
        $newCrudData['fonction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->fonction_id;
        $newCrudData['user_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->user_id;
        $newCrudData['email'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->email;
        $newCrudData['password'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->password;
        $newCrudData['emp_code'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->emp_code;
        $newCrudData['nombre_enfant'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nombre_enfant;
        $newCrudData['num_dossier'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_dossier;
        $newCrudData['online_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->online_id;
        $newCrudData['type_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->type_id;
        $newCrudData['faction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->faction_id;
        $newCrudData['identifiants_sadge'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->identifiants_sadge;
        $newCrudData['creat_by'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->creat_by;

        try {
            $newCrudData['actif'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->balise->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->categorie->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->direction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->echelon->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->faction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->site->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->situation->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->user->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->ville->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->zone->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables', 'entite_cle' => $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->toArray();


        try {

            foreach ($Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTable $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables)
    {
        try {
            $can = Helpers::can('Supprimer des Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['name'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->name;
        $newCrudData['nom'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nom;
        $newCrudData['prenom'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->prenom;
        $newCrudData['matricule'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matricule;
        $newCrudData['num_badge'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_badge;
        $newCrudData['date_naissance'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_naissance;
        $newCrudData['num_cnss'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnss;
        $newCrudData['num_cnamgs'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_cnamgs;
        $newCrudData['telephone1'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone1;
        $newCrudData['telephone2'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->telephone2;
        $newCrudData['photo'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->photo;
        $newCrudData['date_embauche'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->date_embauche;
        $newCrudData['download_date'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->download_date;
        $newCrudData['actif_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->actif_id;
        $newCrudData['nationalite_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nationalite_id;
        $newCrudData['contrat_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->contrat_id;
        $newCrudData['direction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->direction_id;
        $newCrudData['categorie_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->categorie_id;
        $newCrudData['echelon_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->echelon_id;
        $newCrudData['sexe_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->sexe_id;
        $newCrudData['matrimoniale_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matrimoniale_id;
        $newCrudData['poste_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->poste_id;
        $newCrudData['ville_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->ville_id;
        $newCrudData['zone_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->zone_id;
        $newCrudData['site_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->site_id;
        $newCrudData['situation_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->situation_id;
        $newCrudData['balise_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->balise_id;
        $newCrudData['fonction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->fonction_id;
        $newCrudData['user_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->user_id;
        $newCrudData['email'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->email;
        $newCrudData['password'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->password;
        $newCrudData['emp_code'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->emp_code;
        $newCrudData['nombre_enfant'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nombre_enfant;
        $newCrudData['num_dossier'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->num_dossier;
        $newCrudData['online_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->online_id;
        $newCrudData['type_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->type_id;
        $newCrudData['faction_id'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->faction_id;
        $newCrudData['identifiants_sadge'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->identifiants_sadge;
        $newCrudData['creat_by'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->creat_by;

        try {
            $newCrudData['actif'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->balise->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->categorie->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->direction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->echelon->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->faction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->poste->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->site->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->situation->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->user->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->ville->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->zone->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables', 'entite_cle' => $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras') &&
            method_exists('\App\Http\Extras\Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras', 'canDelete')
        ) {
            try {
                $canSave = Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTableExtras::canDelete($request, $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables->delete();
        } else {
            return response()->json($Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTables, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new Tablesd300dd6d5d0e4d7da07e3dc4f800c08eTablesActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
