<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Http\Actions\UsersbacksActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\UsersbackExtras;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\Usersback;
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

// use App\Repository\prod\UsersbacksRepository;


class UsersbackController extends Controller
{

    private $UsersbacksRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\UsersbacksRepository $UsersbacksRepository
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
        $query = Usersback::query();
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
            class_exists('\App\Http\Extras\UsersbackExtras') &&
            method_exists('\App\Http\Extras\UsersbackExtras', 'filterAgGridQuery')
        ) {
            UsersbackExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('usersbacks', $query);
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
        $request->merge(['filter' => [$key => $val]]);

        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json(Usersback::count());
        }
        $data = QueryBuilder::for(Usersback::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('name'),


                AllowedFilter::exact('email'),


                AllowedFilter::exact('email_verified_at'),


                AllowedFilter::exact('password'),


                AllowedFilter::exact('matricule'),


                AllowedFilter::exact('emp_code'),


                AllowedFilter::exact('nom'),


                AllowedFilter::exact('prenom'),


                AllowedFilter::exact('num_badge'),


                AllowedFilter::exact('date_naissance'),


                AllowedFilter::exact('num_cnss'),


                AllowedFilter::exact('num_cnamgs'),


                AllowedFilter::exact('telephone1'),


                AllowedFilter::exact('telephone2'),


                AllowedFilter::exact('nationalite_id'),


                AllowedFilter::exact('nombre_enfant'),


                AllowedFilter::exact('photo'),


                AllowedFilter::exact('actif_id'),


                AllowedFilter::exact('online_id'),


                AllowedFilter::exact('date_embauche'),


                AllowedFilter::exact('sexe_id'),


                AllowedFilter::exact('type_id'),


                AllowedFilter::exact('contrat_id'),


                AllowedFilter::exact('matrimoniale_id'),


                AllowedFilter::exact('fonction_id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('remember_token'),


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


                AllowedSort::field('email'),


                AllowedSort::field('email_verified_at'),


                AllowedSort::field('password'),


                AllowedSort::field('matricule'),


                AllowedSort::field('emp_code'),


                AllowedSort::field('nom'),


                AllowedSort::field('prenom'),


                AllowedSort::field('num_badge'),


                AllowedSort::field('date_naissance'),


                AllowedSort::field('num_cnss'),


                AllowedSort::field('num_cnamgs'),


                AllowedSort::field('telephone1'),


                AllowedSort::field('telephone2'),


                AllowedSort::field('nationalite_id'),


                AllowedSort::field('nombre_enfant'),


                AllowedSort::field('photo'),


                AllowedSort::field('actif_id'),


                AllowedSort::field('online_id'),


                AllowedSort::field('date_embauche'),


                AllowedSort::field('sexe_id'),


                AllowedSort::field('type_id'),


                AllowedSort::field('contrat_id'),


                AllowedSort::field('matrimoniale_id'),


                AllowedSort::field('fonction_id'),


                AllowedSort::field('user_id'),


                AllowedSort::field('remember_token'),


            ])
            ->allowedIncludes([

                'actif',


                'contrat',


                'fonction',


                'matrimoniale',


                'nationalite',


                'online',


                'sexe',


                'type',


                'user',


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


        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json(Usersback::count());
        }

        $data = QueryBuilder::for(Usersback::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('name'),


                AllowedFilter::exact('email'),


                AllowedFilter::exact('email_verified_at'),


                AllowedFilter::exact('password'),


                AllowedFilter::exact('matricule'),


                AllowedFilter::exact('emp_code'),


                AllowedFilter::exact('nom'),


                AllowedFilter::exact('prenom'),


                AllowedFilter::exact('num_badge'),


                AllowedFilter::exact('date_naissance'),


                AllowedFilter::exact('num_cnss'),


                AllowedFilter::exact('num_cnamgs'),


                AllowedFilter::exact('telephone1'),


                AllowedFilter::exact('telephone2'),


                AllowedFilter::exact('nationalite_id'),


                AllowedFilter::exact('nombre_enfant'),


                AllowedFilter::exact('photo'),


                AllowedFilter::exact('actif_id'),


                AllowedFilter::exact('online_id'),


                AllowedFilter::exact('date_embauche'),


                AllowedFilter::exact('sexe_id'),


                AllowedFilter::exact('type_id'),


                AllowedFilter::exact('contrat_id'),


                AllowedFilter::exact('matrimoniale_id'),


                AllowedFilter::exact('fonction_id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('remember_token'),


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


                AllowedSort::field('email'),


                AllowedSort::field('email_verified_at'),


                AllowedSort::field('password'),


                AllowedSort::field('matricule'),


                AllowedSort::field('emp_code'),


                AllowedSort::field('nom'),


                AllowedSort::field('prenom'),


                AllowedSort::field('num_badge'),


                AllowedSort::field('date_naissance'),


                AllowedSort::field('num_cnss'),


                AllowedSort::field('num_cnamgs'),


                AllowedSort::field('telephone1'),


                AllowedSort::field('telephone2'),


                AllowedSort::field('nationalite_id'),


                AllowedSort::field('nombre_enfant'),


                AllowedSort::field('photo'),


                AllowedSort::field('actif_id'),


                AllowedSort::field('online_id'),


                AllowedSort::field('date_embauche'),


                AllowedSort::field('sexe_id'),


                AllowedSort::field('type_id'),


                AllowedSort::field('contrat_id'),


                AllowedSort::field('matrimoniale_id'),


                AllowedSort::field('fonction_id'),


                AllowedSort::field('user_id'),


                AllowedSort::field('remember_token'),


            ])
            ->allowedIncludes([
                'actif',


                'contrat',


                'fonction',


                'matrimoniale',


                'nationalite',


                'online',


                'sexe',


                'type',


                'user',


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


    public function create(Request $request, Usersback $Usersbacks)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "usersbacks" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'name',
            'email',
            'email_verified_at',
            'password',
            'matricule',
            'emp_code',
            'nom',
            'prenom',
            'num_badge',
            'date_naissance',
            'num_cnss',
            'num_cnamgs',
            'telephone1',
            'telephone2',
            'nationalite_id',
            'nombre_enfant',
            'photo',
            'actif_id',
            'online_id',
            'date_embauche',
            'sexe_id',
            'type_id',
            'contrat_id',
            'matrimoniale_id',
            'fonction_id',
            'user_id',
            'remember_token',
            'extra_attributes',
            'created_at',
            'updated_at',
            'deleted_at',
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


            'email' => [
                //'required'
            ],


            'password' => [
                //'required'
            ],


            'matricule' => [
                //'required'
            ],


            'emp_code' => [
                //'required'
            ],


            'nom' => ['required'],


            'prenom' => ['required'],


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


            'nationalite_id' => [
                //'required'
            ],


            'nombre_enfant' => [
                //'required'
            ],


            'photo' => [
                //'required'
            ],


            'actif_id' => [
                //'required'
            ],


            'online_id' => [
                //'required'
            ],


            'date_embauche' => [
                //'required'
            ],


            'sexe_id' => ['required'],


            'type_id' => [
                //'required'
            ],


            'contrat_id' => [
                //'required'
            ],


            'matrimoniale_id' => [
                //'required'
            ],


            'fonction_id' => [
                //'required'
            ],


        ], $messages = [


            'name' => ['cette donnee est obligatoire'],


            'email' => ['cette donnee est obligatoire'],


            'password' => ['cette donnee est obligatoire'],


            'matricule' => ['cette donnee est obligatoire'],


            'emp_code' => ['cette donnee est obligatoire'],


            'nom' => ['cette donnee est obligatoire'],


            'prenom' => ['cette donnee est obligatoire'],


            'num_badge' => ['cette donnee est obligatoire'],


            'date_naissance' => ['cette donnee est obligatoire'],


            'num_cnss' => ['cette donnee est obligatoire'],


            'num_cnamgs' => ['cette donnee est obligatoire'],


            'telephone1' => ['cette donnee est obligatoire'],


            'telephone2' => ['cette donnee est obligatoire'],


            'nationalite_id' => ['cette donnee est obligatoire'],


            'nombre_enfant' => ['cette donnee est obligatoire'],


            'photo' => ['cette donnee est obligatoire'],


            'actif_id' => ['cette donnee est obligatoire'],


            'online_id' => ['cette donnee est obligatoire'],


            'date_embauche' => ['cette donnee est obligatoire'],


            'sexe_id' => ['cette donnee est obligatoire'],


            'type_id' => ['cette donnee est obligatoire'],


            'contrat_id' => ['cette donnee est obligatoire'],


            'matrimoniale_id' => ['cette donnee est obligatoire'],


            'fonction_id' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['name'])) {

            $Usersbacks->name = $data['name'];

        }


        if (!empty($data['email'])) {

            $Usersbacks->email = $data['email'];

        }


        if (!empty($data['matricule'])) {

            $Usersbacks->matricule = $data['matricule'];

        }


        if (!empty($data['emp_code'])) {

            $Usersbacks->emp_code = $data['emp_code'];

        }


        if (!empty($data['nom'])) {

            $Usersbacks->nom = $data['nom'];

        }


        if (!empty($data['prenom'])) {

            $Usersbacks->prenom = $data['prenom'];

        }


        if (!empty($data['num_badge'])) {

            $Usersbacks->num_badge = $data['num_badge'];

        }


        if (!empty($data['date_naissance'])) {

            $Usersbacks->date_naissance = $data['date_naissance'];

        }


        if (!empty($data['num_cnss'])) {

            $Usersbacks->num_cnss = $data['num_cnss'];

        }


        if (!empty($data['num_cnamgs'])) {

            $Usersbacks->num_cnamgs = $data['num_cnamgs'];

        }


        if (!empty($data['telephone1'])) {

            $Usersbacks->telephone1 = $data['telephone1'];

        }


        if (!empty($data['telephone2'])) {

            $Usersbacks->telephone2 = $data['telephone2'];

        }


        if (!empty($data['nationalite_id'])) {

            $Usersbacks->nationalite_id = $data['nationalite_id'];

        }


        if (!empty($data['nombre_enfant'])) {

            $Usersbacks->nombre_enfant = $data['nombre_enfant'];

        }


        if (!empty($data['photo'])) {

            $Usersbacks->photo = $data['photo'];

        }


        if (!empty($data['actif_id'])) {

            $Usersbacks->actif_id = $data['actif_id'];

        }


        if (!empty($data['online_id'])) {

            $Usersbacks->online_id = $data['online_id'];

        }


        if (!empty($data['date_embauche'])) {

            $Usersbacks->date_embauche = $data['date_embauche'];

        }


        if (!empty($data['sexe_id'])) {

            $Usersbacks->sexe_id = $data['sexe_id'];

        }


        if (!empty($data['type_id'])) {

            $Usersbacks->type_id = $data['type_id'];

        }


        if (!empty($data['contrat_id'])) {

            $Usersbacks->contrat_id = $data['contrat_id'];

        }


        if (!empty($data['matrimoniale_id'])) {

            $Usersbacks->matrimoniale_id = $data['matrimoniale_id'];

        }


        if (!empty($data['fonction_id'])) {

            $Usersbacks->fonction_id = $data['fonction_id'];

        }


        if (!empty($data['user_id'])) {

            $Usersbacks->user_id = $data['user_id'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Usersbacks->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\UsersbackExtras') &&
            method_exists('\App\Http\Extras\UsersbackExtras', 'beforeSaveCreate')
        ) {
            UsersbackExtras::beforeSaveCreate($request, $Usersbacks);
        }


        $Usersbacks->save();
        $Usersbacks = Usersback::find($Usersbacks->id);
        $newCrudData = [];

        $newCrudData['name'] = $Usersbacks->name;
        $newCrudData['email'] = $Usersbacks->email;
        $newCrudData['password'] = $Usersbacks->password;
        $newCrudData['matricule'] = $Usersbacks->matricule;
        $newCrudData['emp_code'] = $Usersbacks->emp_code;
        $newCrudData['nom'] = $Usersbacks->nom;
        $newCrudData['prenom'] = $Usersbacks->prenom;
        $newCrudData['num_badge'] = $Usersbacks->num_badge;
        $newCrudData['date_naissance'] = $Usersbacks->date_naissance;
        $newCrudData['num_cnss'] = $Usersbacks->num_cnss;
        $newCrudData['num_cnamgs'] = $Usersbacks->num_cnamgs;
        $newCrudData['telephone1'] = $Usersbacks->telephone1;
        $newCrudData['telephone2'] = $Usersbacks->telephone2;
        $newCrudData['nombre_enfant'] = $Usersbacks->nombre_enfant;
        $newCrudData['photo'] = $Usersbacks->photo;
        $newCrudData['date_embauche'] = $Usersbacks->date_embauche;

        try {
            $newCrudData['actif'] = $Usersbacks->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Usersbacks->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Usersbacks->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Usersbacks->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Usersbacks->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Usersbacks->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Usersbacks->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Usersbacks->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Usersbacks->user->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Usersbacks', 'entite_cle' => $Usersbacks->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Usersbacks->toArray();


        try {

            foreach ($Usersbacks->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Usersback $Usersbacks)
    {


        $oldCrudData = [];

        $oldCrudData['name'] = $Usersbacks->name;
        $oldCrudData['email'] = $Usersbacks->email;
        $oldCrudData['password'] = $Usersbacks->password;
        $oldCrudData['matricule'] = $Usersbacks->matricule;
        $oldCrudData['emp_code'] = $Usersbacks->emp_code;
        $oldCrudData['nom'] = $Usersbacks->nom;
        $oldCrudData['prenom'] = $Usersbacks->prenom;
        $oldCrudData['num_badge'] = $Usersbacks->num_badge;
        $oldCrudData['date_naissance'] = $Usersbacks->date_naissance;
        $oldCrudData['num_cnss'] = $Usersbacks->num_cnss;
        $oldCrudData['num_cnamgs'] = $Usersbacks->num_cnamgs;
        $oldCrudData['telephone1'] = $Usersbacks->telephone1;
        $oldCrudData['telephone2'] = $Usersbacks->telephone2;
        $oldCrudData['nombre_enfant'] = $Usersbacks->nombre_enfant;
        $oldCrudData['photo'] = $Usersbacks->photo;
        $oldCrudData['date_embauche'] = $Usersbacks->date_embauche;

        try {
            $oldCrudData['actif'] = $Usersbacks->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['contrat'] = $Usersbacks->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['fonction'] = $Usersbacks->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['matrimoniale'] = $Usersbacks->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['nationalite'] = $Usersbacks->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['online'] = $Usersbacks->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['sexe'] = $Usersbacks->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['type'] = $Usersbacks->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $Usersbacks->user->Selectlabel;
        } catch (Throwable $e) {
        }

        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "usersbacks" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'name',
            'email',
            'email_verified_at',
            'password',
            'matricule',
            'emp_code',
            'nom',
            'prenom',
            'num_badge',
            'date_naissance',
            'num_cnss',
            'num_cnamgs',
            'telephone1',
            'telephone2',
            'nationalite_id',
            'nombre_enfant',
            'photo',
            'actif_id',
            'online_id',
            'date_embauche',
            'sexe_id',
            'type_id',
            'contrat_id',
            'matrimoniale_id',
            'fonction_id',
            'user_id',
            'remember_token',
            'extra_attributes',
            'created_at',
            'updated_at',
            'deleted_at',
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


            'email' => [
                //'required'
            ],


            'password' => [
                //'required'
            ],


            'matricule' => [
                //'required'
            ],


            'emp_code' => [
                //'required'
            ],


            'nom' => ['required'],


            'prenom' => ['required'],


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


            'nationalite_id' => [
                //'required'
            ],


            'nombre_enfant' => [
                //'required'
            ],


            'photo' => [
                //'required'
            ],


            'actif_id' => [
                //'required'
            ],


            'online_id' => [
                //'required'
            ],


            'date_embauche' => [
                //'required'
            ],


            'sexe_id' => ['required'],


            'type_id' => [
                //'required'
            ],


            'contrat_id' => [
                //'required'
            ],


            'matrimoniale_id' => [
                //'required'
            ],


            'fonction_id' => [
                //'required'
            ],


        ], $messages = [


            'name' => ['cette donnee est obligatoire'],


            'email' => ['cette donnee est obligatoire'],


            'password' => ['cette donnee est obligatoire'],


            'matricule' => ['cette donnee est obligatoire'],


            'emp_code' => ['cette donnee est obligatoire'],


            'nom' => ['cette donnee est obligatoire'],


            'prenom' => ['cette donnee est obligatoire'],


            'num_badge' => ['cette donnee est obligatoire'],


            'date_naissance' => ['cette donnee est obligatoire'],


            'num_cnss' => ['cette donnee est obligatoire'],


            'num_cnamgs' => ['cette donnee est obligatoire'],


            'telephone1' => ['cette donnee est obligatoire'],


            'telephone2' => ['cette donnee est obligatoire'],


            'nationalite_id' => ['cette donnee est obligatoire'],


            'nombre_enfant' => ['cette donnee est obligatoire'],


            'photo' => ['cette donnee est obligatoire'],


            'actif_id' => ['cette donnee est obligatoire'],


            'online_id' => ['cette donnee est obligatoire'],


            'date_embauche' => ['cette donnee est obligatoire'],


            'sexe_id' => ['cette donnee est obligatoire'],


            'type_id' => ['cette donnee est obligatoire'],


            'contrat_id' => ['cette donnee est obligatoire'],


            'matrimoniale_id' => ['cette donnee est obligatoire'],


            'fonction_id' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("name", $data)) {


            if (!empty($data['name'])) {

                $Usersbacks->name = $data['name'];

            }

        }


        if (array_key_exists("email", $data)) {


            if (!empty($data['email'])) {

                $Usersbacks->email = $data['email'];

            }

        }


        if (array_key_exists("matricule", $data)) {


            if (!empty($data['matricule'])) {

                $Usersbacks->matricule = $data['matricule'];

            }

        }


        if (array_key_exists("emp_code", $data)) {


            if (!empty($data['emp_code'])) {

                $Usersbacks->emp_code = $data['emp_code'];

            }

        }


        if (array_key_exists("nom", $data)) {


            if (!empty($data['nom'])) {

                $Usersbacks->nom = $data['nom'];

            }

        }


        if (array_key_exists("prenom", $data)) {


            if (!empty($data['prenom'])) {

                $Usersbacks->prenom = $data['prenom'];

            }

        }


        if (array_key_exists("num_badge", $data)) {


            if (!empty($data['num_badge'])) {

                $Usersbacks->num_badge = $data['num_badge'];

            }

        }


        if (array_key_exists("date_naissance", $data)) {


            if (!empty($data['date_naissance'])) {

                $Usersbacks->date_naissance = $data['date_naissance'];

            }

        }


        if (array_key_exists("num_cnss", $data)) {


            if (!empty($data['num_cnss'])) {

                $Usersbacks->num_cnss = $data['num_cnss'];

            }

        }


        if (array_key_exists("num_cnamgs", $data)) {


            if (!empty($data['num_cnamgs'])) {

                $Usersbacks->num_cnamgs = $data['num_cnamgs'];

            }

        }


        if (array_key_exists("telephone1", $data)) {


            if (!empty($data['telephone1'])) {

                $Usersbacks->telephone1 = $data['telephone1'];

            }

        }


        if (array_key_exists("telephone2", $data)) {


            if (!empty($data['telephone2'])) {

                $Usersbacks->telephone2 = $data['telephone2'];

            }

        }


        if (array_key_exists("nationalite_id", $data)) {


            if (!empty($data['nationalite_id'])) {

                $Usersbacks->nationalite_id = $data['nationalite_id'];

            }

        }


        if (array_key_exists("nombre_enfant", $data)) {


            if (!empty($data['nombre_enfant'])) {

                $Usersbacks->nombre_enfant = $data['nombre_enfant'];

            }

        }


        if (array_key_exists("photo", $data)) {


            if (!empty($data['photo'])) {

                $Usersbacks->photo = $data['photo'];

            }

        }


        if (array_key_exists("actif_id", $data)) {


            if (!empty($data['actif_id'])) {

                $Usersbacks->actif_id = $data['actif_id'];

            }

        }


        if (array_key_exists("online_id", $data)) {


            if (!empty($data['online_id'])) {

                $Usersbacks->online_id = $data['online_id'];

            }

        }


        if (array_key_exists("date_embauche", $data)) {


            if (!empty($data['date_embauche'])) {

                $Usersbacks->date_embauche = $data['date_embauche'];

            }

        }


        if (array_key_exists("sexe_id", $data)) {


            if (!empty($data['sexe_id'])) {

                $Usersbacks->sexe_id = $data['sexe_id'];

            }

        }


        if (array_key_exists("type_id", $data)) {


            if (!empty($data['type_id'])) {

                $Usersbacks->type_id = $data['type_id'];

            }

        }


        if (array_key_exists("contrat_id", $data)) {


            if (!empty($data['contrat_id'])) {

                $Usersbacks->contrat_id = $data['contrat_id'];

            }

        }


        if (array_key_exists("matrimoniale_id", $data)) {


            if (!empty($data['matrimoniale_id'])) {

                $Usersbacks->matrimoniale_id = $data['matrimoniale_id'];

            }

        }


        if (array_key_exists("fonction_id", $data)) {


            if (!empty($data['fonction_id'])) {

                $Usersbacks->fonction_id = $data['fonction_id'];

            }

        }


        if (array_key_exists("user_id", $data)) {


            if (!empty($data['user_id'])) {

                $Usersbacks->user_id = $data['user_id'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Usersbacks->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\UsersbackExtras') &&
            method_exists('\App\Http\Extras\UsersbackExtras', 'beforeSaveUpdate')
        ) {
            UsersbackExtras::beforeSaveUpdate($request, $Usersbacks);
        }

        $Usersbacks->save();
        $Usersbacks = Usersback::find($Usersbacks->id);


        $newCrudData = [];

        $newCrudData['name'] = $Usersbacks->name;
        $newCrudData['email'] = $Usersbacks->email;
        $newCrudData['password'] = $Usersbacks->password;
        $newCrudData['matricule'] = $Usersbacks->matricule;
        $newCrudData['emp_code'] = $Usersbacks->emp_code;
        $newCrudData['nom'] = $Usersbacks->nom;
        $newCrudData['prenom'] = $Usersbacks->prenom;
        $newCrudData['num_badge'] = $Usersbacks->num_badge;
        $newCrudData['date_naissance'] = $Usersbacks->date_naissance;
        $newCrudData['num_cnss'] = $Usersbacks->num_cnss;
        $newCrudData['num_cnamgs'] = $Usersbacks->num_cnamgs;
        $newCrudData['telephone1'] = $Usersbacks->telephone1;
        $newCrudData['telephone2'] = $Usersbacks->telephone2;
        $newCrudData['nombre_enfant'] = $Usersbacks->nombre_enfant;
        $newCrudData['photo'] = $Usersbacks->photo;
        $newCrudData['date_embauche'] = $Usersbacks->date_embauche;

        try {
            $newCrudData['actif'] = $Usersbacks->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Usersbacks->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Usersbacks->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Usersbacks->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Usersbacks->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Usersbacks->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Usersbacks->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Usersbacks->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Usersbacks->user->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Usersbacks', 'entite_cle' => $Usersbacks->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Usersbacks->toArray();


        try {

            foreach ($Usersbacks->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Usersback $Usersbacks)
    {


        $newCrudData = [];

        $newCrudData['name'] = $Usersbacks->name;
        $newCrudData['email'] = $Usersbacks->email;
        $newCrudData['password'] = $Usersbacks->password;
        $newCrudData['matricule'] = $Usersbacks->matricule;
        $newCrudData['emp_code'] = $Usersbacks->emp_code;
        $newCrudData['nom'] = $Usersbacks->nom;
        $newCrudData['prenom'] = $Usersbacks->prenom;
        $newCrudData['num_badge'] = $Usersbacks->num_badge;
        $newCrudData['date_naissance'] = $Usersbacks->date_naissance;
        $newCrudData['num_cnss'] = $Usersbacks->num_cnss;
        $newCrudData['num_cnamgs'] = $Usersbacks->num_cnamgs;
        $newCrudData['telephone1'] = $Usersbacks->telephone1;
        $newCrudData['telephone2'] = $Usersbacks->telephone2;
        $newCrudData['nombre_enfant'] = $Usersbacks->nombre_enfant;
        $newCrudData['photo'] = $Usersbacks->photo;
        $newCrudData['date_embauche'] = $Usersbacks->date_embauche;

        try {
            $newCrudData['actif'] = $Usersbacks->actif->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Usersbacks->contrat->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Usersbacks->fonction->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Usersbacks->matrimoniale->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Usersbacks->nationalite->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Usersbacks->online->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Usersbacks->sexe->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Usersbacks->type->Selectlabel;
        } catch (Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Usersbacks->user->Selectlabel;
        } catch (Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Usersbacks', 'entite_cle' => $Usersbacks->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $Usersbacks->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new UsersbacksActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
