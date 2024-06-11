<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Actions\RattachementsActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\RattachementExtras;
use App\Models\Groupe;
use App\Models\Rattachement;
use App\Models\ser;
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

// use App\Repository\prod\RattachementsRepository;


class RattachementController extends Controller
{

    private $RattachementsRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\RattachementsRepository $RattachementsRepository
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
        $query = Rattachement::query();
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
            class_exists('\App\Http\Extras\RattachementExtras') &&
            method_exists('\App\Http\Extras\RattachementExtras', 'filterAgGridQuery')
        ) {
            RattachementExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('rattachements', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\RattachementExtras') &&
            method_exists('\App\Http\Extras\RattachementExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = RattachementExtras::AgGridUpdateDataBeforeReturnToUser($request, $_d);
            $data['rowData'] = $_d;

            if ($_d->count() > $data['rowCount']) {
                $data['rowCount'] = $_d->count();
            }
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
            return response()->json(Rattachement::count());
        }
        $data = QueryBuilder::for(Rattachement::class)
            ->allowedFilters([
                AllowedFilter::exact('postes id'),


                AllowedFilter::exact('CLIENTS'),


                AllowedFilter::exact('SITES'),


                AllowedFilter::exact('Jour'),


                AllowedFilter::exact('Nuit'),


                AllowedFilter::exact('Nom'),


                AllowedFilter::exact('Prenoms'),


                AllowedFilter::exact('Matricule'),


                AllowedFilter::exact('Numero Badge'),


                AllowedFilter::exact(' Jour Repos'),


                AllowedFilter::exact('Type d&#039;agent'),


                AllowedFilter::exact('Vacation'),


                AllowedFilter::exact('Superviseur  de zone'),


                AllowedFilter::exact('id'),


                AllowedFilter::exact('client_id'),


                AllowedFilter::exact('site_id'),


                AllowedFilter::exact('poste_id'),


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
                AllowedSort::field('postes id'),


                AllowedSort::field('CLIENTS'),


                AllowedSort::field('SITES'),


                AllowedSort::field('Jour'),


                AllowedSort::field('Nuit'),


                AllowedSort::field('Nom'),


                AllowedSort::field('Prenoms'),


                AllowedSort::field('Matricule'),


                AllowedSort::field('Numero Badge'),


                AllowedSort::field(' Jour Repos'),


                AllowedSort::field('Type d&#039;agent'),


                AllowedSort::field('Vacation'),


                AllowedSort::field('Superviseur  de zone'),


                AllowedSort::field('id'),


                AllowedSort::field('client_id'),


                AllowedSort::field('site_id'),


                AllowedSort::field('poste_id'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([

                'client',


                'poste',


                'site',


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


        $data = QueryBuilder::for(Rattachement::class)
            ->allowedFilters([
                AllowedFilter::exact('postes id'),


                AllowedFilter::exact('CLIENTS'),


                AllowedFilter::exact('SITES'),


                AllowedFilter::exact('Jour'),


                AllowedFilter::exact('Nuit'),


                AllowedFilter::exact('Nom'),


                AllowedFilter::exact('Prenoms'),


                AllowedFilter::exact('Matricule'),


                AllowedFilter::exact('Numero Badge'),


                AllowedFilter::exact(' Jour Repos'),


                AllowedFilter::exact('Type d&#039;agent'),


                AllowedFilter::exact('Vacation'),


                AllowedFilter::exact('Superviseur  de zone'),


                AllowedFilter::exact('id'),


                AllowedFilter::exact('client_id'),


                AllowedFilter::exact('site_id'),


                AllowedFilter::exact('poste_id'),


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
                AllowedSort::field('postes id'),


                AllowedSort::field('CLIENTS'),


                AllowedSort::field('SITES'),


                AllowedSort::field('Jour'),


                AllowedSort::field('Nuit'),


                AllowedSort::field('Nom'),


                AllowedSort::field('Prenoms'),


                AllowedSort::field('Matricule'),


                AllowedSort::field('Numero Badge'),


                AllowedSort::field(' Jour Repos'),


                AllowedSort::field('Type d&#039;agent'),


                AllowedSort::field('Vacation'),


                AllowedSort::field('Superviseur  de zone'),


                AllowedSort::field('id'),


                AllowedSort::field('client_id'),


                AllowedSort::field('site_id'),


                AllowedSort::field('poste_id'),


                AllowedSort::field('identifiants_sadge'),


                AllowedSort::field('creat_by'),


            ])
            ->allowedIncludes([
                'client',


                'poste',


                'site',


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


    public function create(Request $request, Rattachement $Rattachements)
    {


        try {
            $can = Helpers::can('Creer des rattachements');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "rattachements" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'postes id',
            'CLIENTS',
            'SITES',
            'Jour',
            'Nuit',
            'Nom',
            'Prenoms',
            'Matricule',
            'Numero Badge',
            ' Jour Repos',
            'Type d&#039;agent',
            'Vacation',
            'Superviseur  de zone',
            'id',
            'client_id',
            'site_id',
            'poste_id',
            'extra_attributes',
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

            'postes id' => [
                //'required'
            ],


            'CLIENTS' => [
                //'required'
            ],


            'SITES' => [
                //'required'
            ],


            'Jour' => [
                //'required'
            ],


            'Nuit' => [
                //'required'
            ],


            'Nom' => [
                //'required'
            ],


            'Prenoms' => [
                //'required'
            ],


            'Matricule' => [
                //'required'
            ],


            'Numero Badge' => [
                //'required'
            ],


            ' Jour Repos' => [
                //'required'
            ],


            'Type d&#039;agent' => [
                //'required'
            ],


            'Vacation' => [
                //'required'
            ],


            'Superviseur  de zone' => [
                //'required'
            ],


            'client_id' => [
                //'required'
            ],


            'site_id' => [
                //'required'
            ],


            'poste_id' => [
                //'required'
            ],


            'identifiants_sadge' => [
                //'required'
            ],


            'creat_by' => [
                //'required'
            ],


        ], $messages = [


            'postes id' => ['cette donnee est obligatoire'],


            'CLIENTS' => ['cette donnee est obligatoire'],


            'SITES' => ['cette donnee est obligatoire'],


            'Jour' => ['cette donnee est obligatoire'],


            'Nuit' => ['cette donnee est obligatoire'],


            'Nom' => ['cette donnee est obligatoire'],


            'Prenoms' => ['cette donnee est obligatoire'],


            'Matricule' => ['cette donnee est obligatoire'],


            'Numero Badge' => ['cette donnee est obligatoire'],


            ' Jour Repos' => ['cette donnee est obligatoire'],


            'Type d&#039;agent' => ['cette donnee est obligatoire'],


            'Vacation' => ['cette donnee est obligatoire'],


            'Superviseur  de zone' => ['cette donnee est obligatoire'],


            'client_id' => ['cette donnee est obligatoire'],


            'site_id' => ['cette donnee est obligatoire'],


            'poste_id' => ['cette donnee est obligatoire'],


            'identifiants_sadge' => ['cette donnee est obligatoire'],


            'creat_by' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['postes id'])) {

            $Rattachements->postes id = $data['postes id'];

        }


        if (!empty($data['CLIENTS'])) {

            $Rattachements->CLIENTS = $data['CLIENTS'];

        }


        if (!empty($data['SITES'])) {

            $Rattachements->SITES = $data['SITES'];

        }


        if (!empty($data['Jour'])) {

            $Rattachements->Jour = $data['Jour'];

        }


        if (!empty($data['Nuit'])) {

            $Rattachements->Nuit = $data['Nuit'];

        }


        if (!empty($data['Nom'])) {

            $Rattachements->Nom = $data['Nom'];

        }


        if (!empty($data['Prenoms'])) {

            $Rattachements->Prenoms = $data['Prenoms'];

        }


        if (!empty($data['Matricule'])) {

            $Rattachements->Matricule = $data['Matricule'];

        }


        if (!empty($data['Numero Badge'])) {

            $Rattachements->Numero Badge = $data['Numero Badge'];

        }


        if (!empty($data[' Jour Repos'])) {

            $Rattachements->Jour Repos = $data[' Jour Repos'];

        }


        if (!empty($data['Type d&#039;agent'])) {

            $Rattachements->Type d &#039;agent = $data['Type d&#039;agent'];

        }


        if (!empty($data['Vacation'])) {

            $Rattachements->Vacation = $data['Vacation'];

        }


        if (!empty($data['Superviseur  de zone'])) {

            $Rattachements->Superviseur  de zone = $data['Superviseur  de zone'];

        }


        if (!empty($data['client_id'])) {

            $Rattachements->client_id = $data['client_id'];

        }


        if (!empty($data['site_id'])) {

            $Rattachements->site_id = $data['site_id'];

        }


        if (!empty($data['poste_id'])) {

            $Rattachements->poste_id = $data['poste_id'];

        }


        if (!empty($data['identifiants_sadge'])) {

            $Rattachements->identifiants_sadge = $data['identifiants_sadge'];

        }


        if (!empty($data['creat_by'])) {

            $Rattachements->creat_by = $data['creat_by'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Rattachements->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\RattachementExtras') &&
            method_exists('\App\Http\Extras\RattachementExtras', 'beforeSaveCreate')
        ) {
            RattachementExtras::beforeSaveCreate($request, $Rattachements);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\RattachementExtras') &&
            method_exists('\App\Http\Extras\RattachementExtras', 'canCreate')
        ) {
            try {
                $canSave = RattachementExtras::canCreate($request, $Rattachements);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Rattachements->save();
        } else {
            return response()->json($Rattachements, 200);
        }

        $Rattachements = Rattachement::find($Rattachements->id);
        $newCrudData = [];

        $newCrudData['postes id'] = $Rattachements->postes id;
                $newCrudData['CLIENTS'] = $Rattachements->CLIENTS;
                $newCrudData['SITES'] = $Rattachements->SITES;
                $newCrudData['Jour'] = $Rattachements->Jour;
                $newCrudData['Nuit'] = $Rattachements->Nuit;
                $newCrudData['Nom'] = $Rattachements->Nom;
                $newCrudData['Prenoms'] = $Rattachements->Prenoms;
                $newCrudData['Matricule'] = $Rattachements->Matricule;
                $newCrudData['Numero Badge'] = $Rattachements->Numero Badge;
                $newCrudData[' Jour Repos'] = $Rattachements->Jour Repos;
                $newCrudData['Type d&#039;agent'] = $Rattachements->Type d &#039;agent;
    $newCrudData['Vacation'] = $Rattachements->Vacation;
                $newCrudData['Superviseur  de zone'] = $Rattachements->Superviseur  de zone;
                    $newCrudData['client_id'] = $Rattachements->client_id;
                $newCrudData['site_id'] = $Rattachements->site_id;
                $newCrudData['poste_id'] = $Rattachements->poste_id;
                        $newCrudData['identifiants_sadge'] = $Rattachements->identifiants_sadge;
                $newCrudData['creat_by'] = $Rattachements->creat_by;

 try {
     $newCrudData['client'] = $Rattachements->client->Selectlabel;
 } catch (Throwable $e) {
 }   try {
        $newCrudData['poste'] = $Rattachements->poste->Selectlabel;
    } catch (Throwable $e) {
    }   try {
        $newCrudData['site'] = $Rattachements->site->Selectlabel;
    } catch (Throwable $e) {
    }
DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Rattachements', 'entite_cle' => $Rattachements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


$response = $Rattachements->toArray();




try {

    foreach ($Rattachements->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Rattachement $Rattachements)
    {
        try {
            $can = Helpers::can('Editer des rattachements');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['postes id'] = $Rattachements->postes id;
                $oldCrudData['CLIENTS'] = $Rattachements->CLIENTS;
                $oldCrudData['SITES'] = $Rattachements->SITES;
                $oldCrudData['Jour'] = $Rattachements->Jour;
                $oldCrudData['Nuit'] = $Rattachements->Nuit;
                $oldCrudData['Nom'] = $Rattachements->Nom;
                $oldCrudData['Prenoms'] = $Rattachements->Prenoms;
                $oldCrudData['Matricule'] = $Rattachements->Matricule;
                $oldCrudData['Numero Badge'] = $Rattachements->Numero Badge;
                $oldCrudData[' Jour Repos'] = $Rattachements->Jour Repos;
                $oldCrudData['Type d&#039;agent'] = $Rattachements->Type d &#039;agent;
    $oldCrudData['Vacation'] = $Rattachements->Vacation;
                $oldCrudData['Superviseur  de zone'] = $Rattachements->Superviseur  de zone;
                    $oldCrudData['client_id'] = $Rattachements->client_id;
                $oldCrudData['site_id'] = $Rattachements->site_id;
                $oldCrudData['poste_id'] = $Rattachements->poste_id;
                        $oldCrudData['identifiants_sadge'] = $Rattachements->identifiants_sadge;
                $oldCrudData['creat_by'] = $Rattachements->creat_by;

 try {
     $oldCrudData['client'] = $Rattachements->client->Selectlabel;
 } catch (Throwable $e) {
 }   try {
        $oldCrudData['poste'] = $Rattachements->poste->Selectlabel;
    } catch (Throwable $e) {
    }   try {
        $oldCrudData['site'] = $Rattachements->site->Selectlabel;
    } catch (Throwable $e) {
    }

$data = $request->all();
foreach ($request->allFiles() as $key => $file) {
    $path = $file->storeAs(
        'storage/uploads', "rattachements" . "-" . $key . "_" . time() . "." . $file->extension()
    );
    $data[$key] = $path;
}


$champsRechercher = [
    'postes id',
    'CLIENTS',
    'SITES',
    'Jour',
    'Nuit',
    'Nom',
    'Prenoms',
    'Matricule',
    'Numero Badge',
    ' Jour Repos',
    'Type d&#039;agent',
    'Vacation',
    'Superviseur  de zone',
    'id',
    'client_id',
    'site_id',
    'poste_id',
    'extra_attributes',
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

    'postes id' => [
        //'required'
    ],


    'CLIENTS' => [
        //'required'
    ],


    'SITES' => [
        //'required'
    ],


    'Jour' => [
        //'required'
    ],


    'Nuit' => [
        //'required'
    ],


    'Nom' => [
        //'required'
    ],


    'Prenoms' => [
        //'required'
    ],


    'Matricule' => [
        //'required'
    ],


    'Numero Badge' => [
        //'required'
    ],


    ' Jour Repos' => [
        //'required'
    ],


    'Type d&#039;agent' => [
        //'required'
    ],


    'Vacation' => [
        //'required'
    ],


    'Superviseur  de zone' => [
        //'required'
    ],


    'client_id' => [
        //'required'
    ],


    'site_id' => [
        //'required'
    ],


    'poste_id' => [
        //'required'
    ],


    'identifiants_sadge' => [
        //'required'
    ],


    'creat_by' => [
        //'required'
    ],


], $messages = [


    'postes id' => ['cette donnee est obligatoire'],


    'CLIENTS' => ['cette donnee est obligatoire'],


    'SITES' => ['cette donnee est obligatoire'],


    'Jour' => ['cette donnee est obligatoire'],


    'Nuit' => ['cette donnee est obligatoire'],


    'Nom' => ['cette donnee est obligatoire'],


    'Prenoms' => ['cette donnee est obligatoire'],


    'Matricule' => ['cette donnee est obligatoire'],


    'Numero Badge' => ['cette donnee est obligatoire'],


    ' Jour Repos' => ['cette donnee est obligatoire'],


    'Type d&#039;agent' => ['cette donnee est obligatoire'],


    'Vacation' => ['cette donnee est obligatoire'],


    'Superviseur  de zone' => ['cette donnee est obligatoire'],


    'client_id' => ['cette donnee est obligatoire'],


    'site_id' => ['cette donnee est obligatoire'],


    'poste_id' => ['cette donnee est obligatoire'],


    'identifiants_sadge' => ['cette donnee est obligatoire'],


    'creat_by' => ['cette donnee est obligatoire'],


])->validate();







$extra_data = array_diff($envoyer, $champsRechercher);













        if (array_key_exists("postes id", $data)) {


            if (!empty($data['postes id'])) {

                $Rattachements->postes id = $data['postes id'];

        }

        }











        if (array_key_exists("CLIENTS", $data)) {


            if (!empty($data['CLIENTS'])) {

                $Rattachements->CLIENTS = $data['CLIENTS'];

            }

        }











        if (array_key_exists("SITES", $data)) {


            if (!empty($data['SITES'])) {

                $Rattachements->SITES = $data['SITES'];

            }

        }











        if (array_key_exists("Jour", $data)) {


            if (!empty($data['Jour'])) {

                $Rattachements->Jour = $data['Jour'];

            }

        }











        if (array_key_exists("Nuit", $data)) {


            if (!empty($data['Nuit'])) {

                $Rattachements->Nuit = $data['Nuit'];

            }

        }











        if (array_key_exists("Nom", $data)) {


            if (!empty($data['Nom'])) {

                $Rattachements->Nom = $data['Nom'];

            }

        }











        if (array_key_exists("Prenoms", $data)) {


            if (!empty($data['Prenoms'])) {

                $Rattachements->Prenoms = $data['Prenoms'];

            }

        }











        if (array_key_exists("Matricule", $data)) {


            if (!empty($data['Matricule'])) {

                $Rattachements->Matricule = $data['Matricule'];

            }

        }











        if (array_key_exists("Numero Badge", $data)) {


            if (!empty($data['Numero Badge'])) {

                $Rattachements->Numero Badge = $data['Numero Badge'];

        }

        }











        if (array_key_exists(" Jour Repos", $data)) {


            if (!empty($data[' Jour Repos'])) {

                $Rattachements->Jour Repos = $data[' Jour Repos'];

        }

        }











        if (array_key_exists("Type d&#039;agent", $data)) {


            if (!empty($data['Type d&#039;agent'])) {

                $Rattachements->Type d &#039;agent = $data['Type d&#039;agent'];

        }

        }











        if (array_key_exists("Vacation", $data)) {


            if (!empty($data['Vacation'])) {

                $Rattachements->Vacation = $data['Vacation'];

            }

        }











        if (array_key_exists("Superviseur  de zone", $data)) {


            if (!empty($data['Superviseur  de zone'])) {

                $Rattachements->Superviseur  de zone = $data['Superviseur  de zone'];

        }

        }



















        if (array_key_exists("client_id", $data)) {


            if (!empty($data['client_id'])) {

                $Rattachements->client_id = $data['client_id'];

            }

        }











        if (array_key_exists("site_id", $data)) {


            if (!empty($data['site_id'])) {

                $Rattachements->site_id = $data['site_id'];

            }

        }











        if (array_key_exists("poste_id", $data)) {


            if (!empty($data['poste_id'])) {

                $Rattachements->poste_id = $data['poste_id'];

            }

        }



























        if (array_key_exists("identifiants_sadge", $data)) {


            if (!empty($data['identifiants_sadge'])) {

                $Rattachements->identifiants_sadge = $data['identifiants_sadge'];

            }

        }











        if (array_key_exists("creat_by", $data)) {


            if (!empty($data['creat_by'])) {

                $Rattachements->creat_by = $data['creat_by'];

            }

        }












$dat = [];

foreach ($extra_data as $d) {

    $dat[$d] = $data[$d];

}
  try {

      $Rattachements->extra_attributes["extra-data"] = $dat;


  } catch (Throwable $e) {
  }



if (
    class_exists('\App\Http\Extras\RattachementExtras') &&
    method_exists('\App\Http\Extras\RattachementExtras', 'beforeSaveUpdate')
) {
    RattachementExtras::beforeSaveUpdate($request, $Rattachements);
}

$canSave = true;
if (
    class_exists('\App\Http\Extras\RattachementExtras') &&
    method_exists('\App\Http\Extras\RattachementExtras', 'canUpdate')
) {
    try {
        $canSave = RattachementExtras::canUpdate($request, $Rattachements);
    } catch (Throwable $e) {

    }

}


if ($canSave) {
    $Rattachements->save();
} else {
    return response()->json($Rattachements, 200);

}


$Rattachements = Rattachement::find($Rattachements->id);



$newCrudData = [];

            $newCrudData['postes id'] = $Rattachements->postes id;
                $newCrudData['CLIENTS'] = $Rattachements->CLIENTS;
                $newCrudData['SITES'] = $Rattachements->SITES;
                $newCrudData['Jour'] = $Rattachements->Jour;
                $newCrudData['Nuit'] = $Rattachements->Nuit;
                $newCrudData['Nom'] = $Rattachements->Nom;
                $newCrudData['Prenoms'] = $Rattachements->Prenoms;
                $newCrudData['Matricule'] = $Rattachements->Matricule;
                $newCrudData['Numero Badge'] = $Rattachements->Numero Badge;
                $newCrudData[' Jour Repos'] = $Rattachements->Jour Repos;
                $newCrudData['Type d&#039;agent'] = $Rattachements->Type d &#039;agent;
    $newCrudData['Vacation'] = $Rattachements->Vacation;
                $newCrudData['Superviseur  de zone'] = $Rattachements->Superviseur  de zone;
                    $newCrudData['client_id'] = $Rattachements->client_id;
                $newCrudData['site_id'] = $Rattachements->site_id;
                $newCrudData['poste_id'] = $Rattachements->poste_id;
                        $newCrudData['identifiants_sadge'] = $Rattachements->identifiants_sadge;
                $newCrudData['creat_by'] = $Rattachements->creat_by;

 try {
     $newCrudData['client'] = $Rattachements->client->Selectlabel;
 } catch (Throwable $e) {
 }   try {
        $newCrudData['poste'] = $Rattachements->poste->Selectlabel;
    } catch (Throwable $e) {
    }   try {
        $newCrudData['site'] = $Rattachements->site->Selectlabel;
    } catch (Throwable $e) {
    }
DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Rattachements', 'entite_cle' => $Rattachements->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

$response = $Rattachements->toArray();




try {

    foreach ($Rattachements->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Rattachement $Rattachements)
    {
        try {
            $can = Helpers::can('Supprimer des rattachements');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['postes id'] = $Rattachements->postes id;
                $newCrudData['CLIENTS'] = $Rattachements->CLIENTS;
                $newCrudData['SITES'] = $Rattachements->SITES;
                $newCrudData['Jour'] = $Rattachements->Jour;
                $newCrudData['Nuit'] = $Rattachements->Nuit;
                $newCrudData['Nom'] = $Rattachements->Nom;
                $newCrudData['Prenoms'] = $Rattachements->Prenoms;
                $newCrudData['Matricule'] = $Rattachements->Matricule;
                $newCrudData['Numero Badge'] = $Rattachements->Numero Badge;
                $newCrudData[' Jour Repos'] = $Rattachements->Jour Repos;
                $newCrudData['Type d&#039;agent'] = $Rattachements->Type d &#039;agent;
    $newCrudData['Vacation'] = $Rattachements->Vacation;
                $newCrudData['Superviseur  de zone'] = $Rattachements->Superviseur  de zone;
                    $newCrudData['client_id'] = $Rattachements->client_id;
                $newCrudData['site_id'] = $Rattachements->site_id;
                $newCrudData['poste_id'] = $Rattachements->poste_id;
                        $newCrudData['identifiants_sadge'] = $Rattachements->identifiants_sadge;
                $newCrudData['creat_by'] = $Rattachements->creat_by;

 try {
     $newCrudData['client'] = $Rattachements->client->Selectlabel;
 } catch (Throwable $e) {
 }   try {
        $newCrudData['poste'] = $Rattachements->poste->Selectlabel;
    } catch (Throwable $e) {
    }   try {
        $newCrudData['site'] = $Rattachements->site->Selectlabel;
    } catch (Throwable $e) {
    }
DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Rattachements', 'entite_cle' => $Rattachements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);



$canSave = true;
if (
    class_exists('\App\Http\Extras\RattachementExtras') &&
    method_exists('\App\Http\Extras\RattachementExtras', 'canDelete')
) {
    try {
        $canSave = RattachementExtras::canDelete($request, $Rattachements);
    } catch (Throwable $e) {

    }

}



if ($canSave) {
    $Rattachements->delete();
} else {
    return response()->json($Rattachements, 200);

}




return response()->json([], 200);


}


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new RattachementsActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
