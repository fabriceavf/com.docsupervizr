<?php

namespace App\Http\Controllers\API;

use App\Http\Actions\ProgrammesventilationsActions;
use App\Http\Controllers\Controller;
use App\Models\Groupe;
use App\Models\Programmesventilation;
use App\Models\ser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

// use App\Repository\prod\ProgrammesventilationsRepository;


class ProgrammesventilationController extends Controller
{

    private $ProgrammesventilationsRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\ProgrammesventilationsRepository $ProgrammesventilationsRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {


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
            return response()->json(Programmesventilation::count());
        }
        $data = QueryBuilder::for(Programmesventilation::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('dimanche'),


                AllowedFilter::exact('lundi'),


                AllowedFilter::exact('mardi'),


                AllowedFilter::exact('mercredi'),


                AllowedFilter::exact('jeudi'),


                AllowedFilter::exact('vendredi'),


                AllowedFilter::exact('samedi'),


                AllowedFilter::exact('statut'),


                AllowedFilter::exact('actif'),


                AllowedFilter::exact('programmation_id'),


                AllowedFilter::exact('user_id'),


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


                AllowedSort::field('dimanche'),


                AllowedSort::field('lundi'),


                AllowedSort::field('mardi'),


                AllowedSort::field('mercredi'),


                AllowedSort::field('jeudi'),


                AllowedSort::field('vendredi'),


                AllowedSort::field('samedi'),


                AllowedSort::field('statut'),


                AllowedSort::field('actif'),


                AllowedSort::field('programmation_id'),


                AllowedSort::field('user_id'),


            ])
            ->allowedIncludes([

                'programmation',


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
            return response()->json(Programmesventilation::count());
        }

        $data = QueryBuilder::for(Programmesventilation::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('dimanche'),


                AllowedFilter::exact('lundi'),


                AllowedFilter::exact('mardi'),


                AllowedFilter::exact('mercredi'),


                AllowedFilter::exact('jeudi'),


                AllowedFilter::exact('vendredi'),


                AllowedFilter::exact('samedi'),


                AllowedFilter::exact('statut'),


                AllowedFilter::exact('actif'),


                AllowedFilter::exact('programmation_id'),


                AllowedFilter::exact('user_id'),


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


                AllowedSort::field('dimanche'),


                AllowedSort::field('lundi'),


                AllowedSort::field('mardi'),


                AllowedSort::field('mercredi'),


                AllowedSort::field('jeudi'),


                AllowedSort::field('vendredi'),


                AllowedSort::field('samedi'),


                AllowedSort::field('statut'),


                AllowedSort::field('actif'),


                AllowedSort::field('programmation_id'),


                AllowedSort::field('user_id'),


            ])
            ->allowedIncludes([
                'programmation',


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


    public function create(Request $request, Programmesventilation $Programmesventilations)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "programmesventilations" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'dimanche',
            'lundi',
            'mardi',
            'mercredi',
            'jeudi',
            'vendredi',
            'samedi',
            'statut',
            'actif',
            'programmation_id',
            'user_id',
            'extra_attributes',
            'created_at',
            'updated_at',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'dimanche' => [
                //'required'
            ],


            'lundi' => [
                //'required'
            ],


            'mardi' => [
                //'required'
            ],


            'mercredi' => [
                //'required'
            ],


            'jeudi' => [
                //'required'
            ],


            'vendredi' => [
                //'required'
            ],


            'samedi' => [
                //'required'
            ],


            'statut' => [
                //'required'
            ],


            'actif' => [
                //'required'
            ],


            'programmation_id' => [
                //'required'
            ],


        ], $messages = [


            'dimanche' => ['cette donnee est obligatoire'],


            'lundi' => ['cette donnee est obligatoire'],


            'mardi' => ['cette donnee est obligatoire'],


            'mercredi' => ['cette donnee est obligatoire'],


            'jeudi' => ['cette donnee est obligatoire'],


            'vendredi' => ['cette donnee est obligatoire'],


            'samedi' => ['cette donnee est obligatoire'],


            'statut' => ['cette donnee est obligatoire'],


            'actif' => ['cette donnee est obligatoire'],


            'programmation_id' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['dimanche'])) {

            $Programmesventilations->dimanche = $data['dimanche'];

        }


        if (!empty($data['lundi'])) {

            $Programmesventilations->lundi = $data['lundi'];

        }


        if (!empty($data['mardi'])) {

            $Programmesventilations->mardi = $data['mardi'];

        }


        if (!empty($data['mercredi'])) {

            $Programmesventilations->mercredi = $data['mercredi'];

        }


        if (!empty($data['jeudi'])) {

            $Programmesventilations->jeudi = $data['jeudi'];

        }


        if (!empty($data['vendredi'])) {

            $Programmesventilations->vendredi = $data['vendredi'];

        }


        if (!empty($data['samedi'])) {

            $Programmesventilations->samedi = $data['samedi'];

        }


        if (!empty($data['statut'])) {

            $Programmesventilations->statut = $data['statut'];

        }


        if (!empty($data['actif'])) {

            $Programmesventilations->actif = $data['actif'];

        }


        if (!empty($data['programmation_id'])) {

            $Programmesventilations->programmation_id = $data['programmation_id'];

        }


        if (!empty($data['user_id'])) {

            $Programmesventilations->user_id = $data['user_id'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Programmesventilations->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        $Programmesventilations->save();


        $response = $Programmesventilations->toArray();


        try {

            foreach ($Programmesventilations->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Programmesventilation $Programmesventilations)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "programmesventilations" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'dimanche',
            'lundi',
            'mardi',
            'mercredi',
            'jeudi',
            'vendredi',
            'samedi',
            'statut',
            'actif',
            'programmation_id',
            'user_id',
            'extra_attributes',
            'created_at',
            'updated_at',
        ];
        $envoyer = [];
        foreach ($data as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($data, [


            'dimanche' => [
                //'required'
            ],


            'lundi' => [
                //'required'
            ],


            'mardi' => [
                //'required'
            ],


            'mercredi' => [
                //'required'
            ],


            'jeudi' => [
                //'required'
            ],


            'vendredi' => [
                //'required'
            ],


            'samedi' => [
                //'required'
            ],


            'statut' => [
                //'required'
            ],


            'actif' => [
                //'required'
            ],


            'programmation_id' => [
                //'required'
            ],


        ], $messages = [


            'dimanche' => ['cette donnee est obligatoire'],


            'lundi' => ['cette donnee est obligatoire'],


            'mardi' => ['cette donnee est obligatoire'],


            'mercredi' => ['cette donnee est obligatoire'],


            'jeudi' => ['cette donnee est obligatoire'],


            'vendredi' => ['cette donnee est obligatoire'],


            'samedi' => ['cette donnee est obligatoire'],


            'statut' => ['cette donnee est obligatoire'],


            'actif' => ['cette donnee est obligatoire'],


            'programmation_id' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("dimanche", $data)) {


            if (!empty($data['dimanche'])) {

                $Programmesventilations->dimanche = $data['dimanche'];

            }

        }


        if (array_key_exists("lundi", $data)) {


            if (!empty($data['lundi'])) {

                $Programmesventilations->lundi = $data['lundi'];

            }

        }


        if (array_key_exists("mardi", $data)) {


            if (!empty($data['mardi'])) {

                $Programmesventilations->mardi = $data['mardi'];

            }

        }


        if (array_key_exists("mercredi", $data)) {


            if (!empty($data['mercredi'])) {

                $Programmesventilations->mercredi = $data['mercredi'];

            }

        }


        if (array_key_exists("jeudi", $data)) {


            if (!empty($data['jeudi'])) {

                $Programmesventilations->jeudi = $data['jeudi'];

            }

        }


        if (array_key_exists("vendredi", $data)) {


            if (!empty($data['vendredi'])) {

                $Programmesventilations->vendredi = $data['vendredi'];

            }

        }


        if (array_key_exists("samedi", $data)) {


            if (!empty($data['samedi'])) {

                $Programmesventilations->samedi = $data['samedi'];

            }

        }


        if (array_key_exists("statut", $data)) {


            if (!empty($data['statut'])) {

                $Programmesventilations->statut = $data['statut'];

            }

        }


        if (array_key_exists("actif", $data)) {


            if (!empty($data['actif'])) {

                $Programmesventilations->actif = $data['actif'];

            }

        }


        if (array_key_exists("programmation_id", $data)) {


            if (!empty($data['programmation_id'])) {

                $Programmesventilations->programmation_id = $data['programmation_id'];

            }

        }


        if (array_key_exists("user_id", $data)) {


            if (!empty($data['user_id'])) {

                $Programmesventilations->user_id = $data['user_id'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Programmesventilations->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        $Programmesventilations->save();


        $response = $Programmesventilations->toArray();


        try {

            foreach ($Programmesventilations->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Programmesventilation $Programmesventilations)
    {


        $Programmesventilations->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new ProgrammesventilationsActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
