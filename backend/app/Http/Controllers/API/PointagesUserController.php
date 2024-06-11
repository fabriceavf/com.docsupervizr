<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\prod\Groupe;
use App\Models\prod\PointagesUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

// use App\Repository\prod\Pointages_usersRepository;


class PointagesUserController extends Controller
{

    private $Pointages_usersRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\Pointages_usersRepository $Pointages_usersRepository
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
        $data = QueryBuilder::for(PointagesUser::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('pointage_id'),


                AllowedFilter::exact('statut'),


                AllowedFilter::callback('not_null', function (Builder $query, $value) {
//                    dump($value);


                    if (is_array($value)) {
                        foreach ($value as $val) {
                            $query->whereNotNull($val);

                        }
                    } else {
                        $query->whereNotNull($value);
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
            ->allowedIncludes([

                'pointage',


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


        $data = QueryBuilder::for(PointagesUser::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('pointage_id'),


                AllowedFilter::exact('statut'),


                AllowedFilter::callback('not_null', function (Builder $query, $value) {
//                    dump($value);


                    if (is_array($value)) {
                        foreach ($value as $val) {
                            $query->whereNotNull($val);

                        }
                    } else {
                        $query->whereNotNull($value);
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
            ->allowedIncludes([
                'pointage',


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
        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


    public function create(Request $request, PointagesUser $Pointages_users)
    {


        $champsRechercher = [
            'id',
            'user_id',
            'pointage_id',
            'statut',
            'extra_attributes',
            'created_at',
            'updated_at',
        ];
        $envoyer = [];
        foreach ($request->all() as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($request->all(), [


            'pointage_id' => ['required'],


            'statut' => ['required'],


        ], $messages = [


            'pointage_id' => ['cette donnee est obligatoire'],


            'statut' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        $line = new PointagesUser();


        $line->user_id = $donnes['user_id'] ?? "";


        $line->pointage_id = $donnes['pointage_id'] ?? "";


        $line->statut = $donnes['statut'] ?? "";


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $request->all()[$d];

        }
        try {

            $line->extra_attributes["extra-data"] = $dat;


        } catch (Exception $e) {
        }

        $line->save();


        $response = $line->toArray();


        try {

            foreach ($line->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (Exception $e) {
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


    public function update(Request $request, PointagesUser $Pointages_users)
    {


        $champsRechercher = [
            'id',
            'user_id',
            'pointage_id',
            'statut',
            'extra_attributes',
            'created_at',
            'updated_at',
        ];
        $envoyer = [];
        foreach ($request->all() as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);

        Validator::make($request->all(), [


            'pointage_id' => ['required'],


            'statut' => ['required'],


        ], $messages = [


            'pointage_id' => ['cette donnee est obligatoire'],


            'statut' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        $line = new PointagesUser();


        if (array_key_exists("updated_at", $line)) {


            $line->user_id = $donnes['user_id'] ?? "";


            $line->pointage_id = $donnes['pointage_id'] ?? "";


            $line->statut = $donnes['statut'] ?? "";


        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $request->all()[$d];

        }
        try {

            $line->extra_attributes["extra-data"] = $dat;


        } catch (Exception $e) {
        }

        $line->save();


        $response = $line->toArray();


        try {

            foreach ($line->extra_attributes["extra-data"] as $key => $dat) {
                $response[$key] = $dat;
            }


        } catch (Exception $e) {
        }


        return response()->json($response, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, PointagesUser $Pointages_users)
    {


        $Pointages_users->delete();


        return response()->json([], 200);


    }

}
