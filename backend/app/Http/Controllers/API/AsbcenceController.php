<?php

namespace App\Http\Controllers\API;

use App\Http\Actions\AsbcencesActions;
use App\Http\Controllers\Controller;
use App\Models\Asbcence;
use App\Models\Groupe;
use App\Models\ser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

// use App\Repository\prod\AsbcencesRepository;


class AsbcenceController extends Controller
{

    private $AsbcencesRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\AsbcencesRepository $AsbcencesRepository
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
        $data = QueryBuilder::for(Asbcence::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('raison'),


                AllowedFilter::exact('debut'),


                AllowedFilter::exact('fin'),


                AllowedFilter::exact('etats'),


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


                AllowedSort::field('user_id'),


                AllowedSort::field('raison'),


                AllowedSort::field('debut'),


                AllowedSort::field('fin'),


                AllowedSort::field('etats'),


            ])
            ->allowedIncludes([

                'user',


            ])
            ->get();

        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json(count($data));
        }
        if (!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"] == 1) {
            $page = Paginator::resolveCurrentPage() ?: 1;
            $perPage = isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20;
            $records = new LengthAwarePaginator(
                $data->forPage($page, $perPage), $data->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
            );
            $donnees = $records;
            $donnees = $donnees->toArray();


        } else {
            $donnees = $data;
        }


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


        $data = QueryBuilder::for(Asbcence::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('raison'),


                AllowedFilter::exact('debut'),


                AllowedFilter::exact('fin'),


                AllowedFilter::exact('etats'),


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


                AllowedSort::field('user_id'),


                AllowedSort::field('raison'),


                AllowedSort::field('debut'),


                AllowedSort::field('fin'),


                AllowedSort::field('etats'),


            ])
            ->allowedIncludes([
                'user',


            ])
            ->get();

        if (!empty($_REQUEST["count"]) && $_REQUEST["count"] == 1) {
            return response()->json(count($data));
        }
        if (!empty($_REQUEST["paginate"]) && $_REQUEST["paginate"] == 1) {
            $page = Paginator::resolveCurrentPage() ?: 1;
            $perPage = isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20;
            $records = new LengthAwarePaginator(
                $data->forPage($page, $perPage), $data->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
            );
            $donnees = $records;
            $donnees = $donnees->toArray();


        } else {
            $donnees = $data;
        }
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


    public function create(Request $request, Asbcence $Asbcences)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "asbcences" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'user_id',
            'raison',
            'debut',
            'fin',
            'etats',
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


            'raison' => [
                //'required'
            ],


            'debut' => [
                //'required'
            ],


            'fin' => [
                //'required'
            ],


            'etats' => [
                //'required'
            ],


        ], $messages = [


            'raison' => ['cette donnee est obligatoire'],


            'debut' => ['cette donnee est obligatoire'],


            'fin' => ['cette donnee est obligatoire'],


            'etats' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($data['user_id'])) {

            $Asbcences->user_id = $data['user_id'];

        }


        if (!empty($data['raison'])) {

            $Asbcences->raison = $data['raison'];

        }


        if (!empty($data['debut'])) {

            $Asbcences->debut = $data['debut'];

        }


        if (!empty($data['fin'])) {

            $Asbcences->fin = $data['fin'];

        }


        if (!empty($data['etats'])) {

            $Asbcences->etats = $data['etats'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Asbcences->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        $Asbcences->save();


        $response = $Asbcences->toArray();


        try {

            foreach ($Asbcences->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Asbcence $Asbcences)
    {


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "asbcences" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'user_id',
            'raison',
            'debut',
            'fin',
            'etats',
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


            'raison' => [
                //'required'
            ],


            'debut' => [
                //'required'
            ],


            'fin' => [
                //'required'
            ],


            'etats' => [
                //'required'
            ],


        ], $messages = [


            'raison' => ['cette donnee est obligatoire'],


            'debut' => ['cette donnee est obligatoire'],


            'fin' => ['cette donnee est obligatoire'],


            'etats' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("user_id", $data)) {


            if (!empty($data['user_id'])) {

                $Asbcences->user_id = $data['user_id'];

            }

        }


        if (array_key_exists("raison", $data)) {


            if (!empty($data['raison'])) {

                $Asbcences->raison = $data['raison'];

            }

        }


        if (array_key_exists("debut", $data)) {


            if (!empty($data['debut'])) {

                $Asbcences->debut = $data['debut'];

            }

        }


        if (array_key_exists("fin", $data)) {


            if (!empty($data['fin'])) {

                $Asbcences->fin = $data['fin'];

            }

        }


        if (array_key_exists("etats", $data)) {


            if (!empty($data['etats'])) {

                $Asbcences->etats = $data['etats'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Asbcences->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        $Asbcences->save();


        $response = $Asbcences->toArray();


        try {

            foreach ($Asbcences->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Asbcence $Asbcences)
    {


        $Asbcences->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new AsbcencesActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
