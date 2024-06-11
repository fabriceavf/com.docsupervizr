<?php

namespace App\Http\Controllers\API;

use App\Http\Actions\VentilationsdetailsActions;
use App\Http\Controllers\Controller;
use App\Models\Groupe;
use App\Models\ser;
use App\Models\Ventilationsdetail;
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

// use App\Repository\prod\VentilationsdetailsRepository;


class VentilationsdetailController extends Controller
{

    private $VentilationsdetailsRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\VentilationsdetailsRepository $VentilationsdetailsRepository
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
        $data = QueryBuilder::for(Ventilationsdetail::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('ventilation_id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('semaine'),


                AllowedFilter::exact('dimanche'),


                AllowedFilter::exact('lundi'),


                AllowedFilter::exact('mardi'),


                AllowedFilter::exact('mercredi'),


                AllowedFilter::exact('jeudi'),


                AllowedFilter::exact('vendredi'),


                AllowedFilter::exact('samedi'),


                AllowedFilter::exact('hn'),


                AllowedFilter::exact('hs15'),


                AllowedFilter::exact('hs26'),


                AllowedFilter::exact('hs55'),


                AllowedFilter::exact('hs30'),


                AllowedFilter::exact('hs60'),


                AllowedFilter::exact('hs115'),


                AllowedFilter::exact('hs130'),


                AllowedFilter::exact('total'),


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

                'user',


                'ventilation',


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


        $data = QueryBuilder::for(Ventilationsdetail::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('ventilation_id'),


                AllowedFilter::exact('user_id'),


                AllowedFilter::exact('semaine'),


                AllowedFilter::exact('dimanche'),


                AllowedFilter::exact('lundi'),


                AllowedFilter::exact('mardi'),


                AllowedFilter::exact('mercredi'),


                AllowedFilter::exact('jeudi'),


                AllowedFilter::exact('vendredi'),


                AllowedFilter::exact('samedi'),


                AllowedFilter::exact('hn'),


                AllowedFilter::exact('hs15'),


                AllowedFilter::exact('hs26'),


                AllowedFilter::exact('hs55'),


                AllowedFilter::exact('hs30'),


                AllowedFilter::exact('hs60'),


                AllowedFilter::exact('hs115'),


                AllowedFilter::exact('hs130'),


                AllowedFilter::exact('total'),


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
                'user',


                'ventilation',


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


    public function create(Request $request, Ventilationsdetail $Ventilationsdetails)
    {


        $champsRechercher = [
            'id',
            'ventilation_id',
            'user_id',
            'semaine',
            'dimanche',
            'lundi',
            'mardi',
            'mercredi',
            'jeudi',
            'vendredi',
            'samedi',
            'hn',
            'hs15',
            'hs26',
            'hs55',
            'hs30',
            'hs60',
            'hs115',
            'hs130',
            'total',
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


            'ventilation_id' => [
                //'required'
            ],


            'semaine' => [
                //'required'
            ],


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


            'hn' => [
                //'required'
            ],


            'hs15' => [
                //'required'
            ],


            'hs26' => [
                //'required'
            ],


            'hs55' => [
                //'required'
            ],


            'hs30' => [
                //'required'
            ],


            'hs60' => [
                //'required'
            ],


            'hs115' => [
                //'required'
            ],


            'hs130' => [
                //'required'
            ],


            'total' => [
                //'required'
            ],


        ], $messages = [


            'ventilation_id' => ['cette donnee est obligatoire'],


            'semaine' => ['cette donnee est obligatoire'],


            'dimanche' => ['cette donnee est obligatoire'],


            'lundi' => ['cette donnee est obligatoire'],


            'mardi' => ['cette donnee est obligatoire'],


            'mercredi' => ['cette donnee est obligatoire'],


            'jeudi' => ['cette donnee est obligatoire'],


            'vendredi' => ['cette donnee est obligatoire'],


            'samedi' => ['cette donnee est obligatoire'],


            'hn' => ['cette donnee est obligatoire'],


            'hs15' => ['cette donnee est obligatoire'],


            'hs26' => ['cette donnee est obligatoire'],


            'hs55' => ['cette donnee est obligatoire'],


            'hs30' => ['cette donnee est obligatoire'],


            'hs60' => ['cette donnee est obligatoire'],


            'hs115' => ['cette donnee est obligatoire'],


            'hs130' => ['cette donnee est obligatoire'],


            'total' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (!empty($request->input('ventilation_id'))) {

            $Ventilationsdetails->ventilation_id = $request->input('ventilation_id');

        }


        if (!empty($request->input('user_id'))) {

            $Ventilationsdetails->user_id = $request->input('user_id');

        }


        if (!empty($request->input('semaine'))) {

            $Ventilationsdetails->semaine = $request->input('semaine');

        }


        if (!empty($request->input('dimanche'))) {

            $Ventilationsdetails->dimanche = $request->input('dimanche');

        }


        if (!empty($request->input('lundi'))) {

            $Ventilationsdetails->lundi = $request->input('lundi');

        }


        if (!empty($request->input('mardi'))) {

            $Ventilationsdetails->mardi = $request->input('mardi');

        }


        if (!empty($request->input('mercredi'))) {

            $Ventilationsdetails->mercredi = $request->input('mercredi');

        }


        if (!empty($request->input('jeudi'))) {

            $Ventilationsdetails->jeudi = $request->input('jeudi');

        }


        if (!empty($request->input('vendredi'))) {

            $Ventilationsdetails->vendredi = $request->input('vendredi');

        }


        if (!empty($request->input('samedi'))) {

            $Ventilationsdetails->samedi = $request->input('samedi');

        }


        if (!empty($request->input('hn'))) {

            $Ventilationsdetails->hn = $request->input('hn');

        }


        if (!empty($request->input('hs15'))) {

            $Ventilationsdetails->hs15 = $request->input('hs15');

        }


        if (!empty($request->input('hs26'))) {

            $Ventilationsdetails->hs26 = $request->input('hs26');

        }


        if (!empty($request->input('hs55'))) {

            $Ventilationsdetails->hs55 = $request->input('hs55');

        }


        if (!empty($request->input('hs30'))) {

            $Ventilationsdetails->hs30 = $request->input('hs30');

        }


        if (!empty($request->input('hs60'))) {

            $Ventilationsdetails->hs60 = $request->input('hs60');

        }


        if (!empty($request->input('hs115'))) {

            $Ventilationsdetails->hs115 = $request->input('hs115');

        }


        if (!empty($request->input('hs130'))) {

            $Ventilationsdetails->hs130 = $request->input('hs130');

        }


        if (!empty($request->input('total'))) {

            $Ventilationsdetails->total = $request->input('total');

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $request->all()[$d];

        }
        try {

            $Ventilationsdetails->extra_attributes["extra-data"] = $dat;


        } catch (Exception $e) {
        }

        $Ventilationsdetails->save();


        $response = $Ventilationsdetails->toArray();


        try {

            foreach ($Ventilationsdetails->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Ventilationsdetail $Ventilationsdetails)
    {


        $champsRechercher = [
            'id',
            'ventilation_id',
            'user_id',
            'semaine',
            'dimanche',
            'lundi',
            'mardi',
            'mercredi',
            'jeudi',
            'vendredi',
            'samedi',
            'hn',
            'hs15',
            'hs26',
            'hs55',
            'hs30',
            'hs60',
            'hs115',
            'hs130',
            'total',
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


            'ventilation_id' => [
                //'required'
            ],


            'semaine' => [
                //'required'
            ],


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


            'hn' => [
                //'required'
            ],


            'hs15' => [
                //'required'
            ],


            'hs26' => [
                //'required'
            ],


            'hs55' => [
                //'required'
            ],


            'hs30' => [
                //'required'
            ],


            'hs60' => [
                //'required'
            ],


            'hs115' => [
                //'required'
            ],


            'hs130' => [
                //'required'
            ],


            'total' => [
                //'required'
            ],


        ], $messages = [


            'ventilation_id' => ['cette donnee est obligatoire'],


            'semaine' => ['cette donnee est obligatoire'],


            'dimanche' => ['cette donnee est obligatoire'],


            'lundi' => ['cette donnee est obligatoire'],


            'mardi' => ['cette donnee est obligatoire'],


            'mercredi' => ['cette donnee est obligatoire'],


            'jeudi' => ['cette donnee est obligatoire'],


            'vendredi' => ['cette donnee est obligatoire'],


            'samedi' => ['cette donnee est obligatoire'],


            'hn' => ['cette donnee est obligatoire'],


            'hs15' => ['cette donnee est obligatoire'],


            'hs26' => ['cette donnee est obligatoire'],


            'hs55' => ['cette donnee est obligatoire'],


            'hs30' => ['cette donnee est obligatoire'],


            'hs60' => ['cette donnee est obligatoire'],


            'hs115' => ['cette donnee est obligatoire'],


            'hs130' => ['cette donnee est obligatoire'],


            'total' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("ventilation_id", $request->all())) {


            if (!empty($request->input('ventilation_id'))) {

                $Ventilationsdetails->ventilation_id = $request->input('ventilation_id');

            }

        }


        if (array_key_exists("user_id", $request->all())) {


            if (!empty($request->input('user_id'))) {

                $Ventilationsdetails->user_id = $request->input('user_id');

            }

        }


        if (array_key_exists("semaine", $request->all())) {


            if (!empty($request->input('semaine'))) {

                $Ventilationsdetails->semaine = $request->input('semaine');

            }

        }


        if (array_key_exists("dimanche", $request->all())) {


            if (!empty($request->input('dimanche'))) {

                $Ventilationsdetails->dimanche = $request->input('dimanche');

            }

        }


        if (array_key_exists("lundi", $request->all())) {


            if (!empty($request->input('lundi'))) {

                $Ventilationsdetails->lundi = $request->input('lundi');

            }

        }


        if (array_key_exists("mardi", $request->all())) {


            if (!empty($request->input('mardi'))) {

                $Ventilationsdetails->mardi = $request->input('mardi');

            }

        }


        if (array_key_exists("mercredi", $request->all())) {


            if (!empty($request->input('mercredi'))) {

                $Ventilationsdetails->mercredi = $request->input('mercredi');

            }

        }


        if (array_key_exists("jeudi", $request->all())) {


            if (!empty($request->input('jeudi'))) {

                $Ventilationsdetails->jeudi = $request->input('jeudi');

            }

        }


        if (array_key_exists("vendredi", $request->all())) {


            if (!empty($request->input('vendredi'))) {

                $Ventilationsdetails->vendredi = $request->input('vendredi');

            }

        }


        if (array_key_exists("samedi", $request->all())) {


            if (!empty($request->input('samedi'))) {

                $Ventilationsdetails->samedi = $request->input('samedi');

            }

        }


        if (array_key_exists("hn", $request->all())) {


            if (!empty($request->input('hn'))) {

                $Ventilationsdetails->hn = $request->input('hn');

            }

        }


        if (array_key_exists("hs15", $request->all())) {


            if (!empty($request->input('hs15'))) {

                $Ventilationsdetails->hs15 = $request->input('hs15');

            }

        }


        if (array_key_exists("hs26", $request->all())) {


            if (!empty($request->input('hs26'))) {

                $Ventilationsdetails->hs26 = $request->input('hs26');

            }

        }


        if (array_key_exists("hs55", $request->all())) {


            if (!empty($request->input('hs55'))) {

                $Ventilationsdetails->hs55 = $request->input('hs55');

            }

        }


        if (array_key_exists("hs30", $request->all())) {


            if (!empty($request->input('hs30'))) {

                $Ventilationsdetails->hs30 = $request->input('hs30');

            }

        }


        if (array_key_exists("hs60", $request->all())) {


            if (!empty($request->input('hs60'))) {

                $Ventilationsdetails->hs60 = $request->input('hs60');

            }

        }


        if (array_key_exists("hs115", $request->all())) {


            if (!empty($request->input('hs115'))) {

                $Ventilationsdetails->hs115 = $request->input('hs115');

            }

        }


        if (array_key_exists("hs130", $request->all())) {


            if (!empty($request->input('hs130'))) {

                $Ventilationsdetails->hs130 = $request->input('hs130');

            }

        }


        if (array_key_exists("total", $request->all())) {


            if (!empty($request->input('total'))) {

                $Ventilationsdetails->total = $request->input('total');

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $request->all()[$d];

        }
        try {

            $Ventilationsdetails->extra_attributes["extra-data"] = $dat;


        } catch (Exception $e) {
        }

        $Ventilationsdetails->save();


        $response = $Ventilationsdetails->toArray();


        try {

            foreach ($Ventilationsdetails->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Ventilationsdetail $Ventilationsdetails)
    {


        $Ventilationsdetails->delete();


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new VentilationsdetailsActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
