<?php

namespace App\Http\Controllers\API;

namespace App\Http\Controllers\API;

use App\Helpers\Helpers;
use App\Http\Actions\AnalysespointeuseActions;
use App\Http\AgGrid;
use App\Http\Controllers\Controller;
use App\Http\Extras\AnalysespointeueExtras;
use App\Models\Analysespointeue;
use App\Models\Groupe;
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

// use App\Repository\prod\AnalysespointeuseRepository;


class AnalysespointeueController extends Controller
{

    private $AnalysespointeuseRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\AnalysespointeuseRepository $AnalysespointeuseRepository
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
        $query = Analysespointeue::query();
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
            class_exists('\App\Http\Extras\AnalysespointeueExtras') &&
            method_exists('\App\Http\Extras\AnalysespointeueExtras', 'filterAgGridQuery')
        ) {
            AnalysespointeueExtras::filterAgGridQuery($request, $query);
        }


        $agGrid = new AgGrid('analysespointeuse', $query);
        $data = $agGrid->getData($request);

        if (
            class_exists('\App\Http\Extras\AnalysespointeueExtras') &&
            method_exists('\App\Http\Extras\AnalysespointeueExtras', 'AgGridUpdateDataBeforeReturnToUser')
        ) {
            $_d = $data['rowData'];
            $_d = collect($_d)->map(function ($data) use ($request) {
                return AnalysespointeueExtras::AgGridUpdateDataBeforeReturnToUser($request, $data);
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
            return response()->json(Analysespointeue::count());
        }
        $data = QueryBuilder::for(Analysespointeue::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('pointeuses'),


                AllowedFilter::exact('semaine'),


                AllowedFilter::exact('lun'),


                AllowedFilter::exact('mar'),


                AllowedFilter::exact('mer'),


                AllowedFilter::exact('jeu'),


                AllowedFilter::exact('ven'),


                AllowedFilter::exact('sam'),


                AllowedFilter::exact('dim'),


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


                AllowedSort::field('pointeuses'),


                AllowedSort::field('semaine'),


                AllowedSort::field('lun'),


                AllowedSort::field('mar'),


                AllowedSort::field('mer'),


                AllowedSort::field('jeu'),


                AllowedSort::field('ven'),


                AllowedSort::field('sam'),


                AllowedSort::field('dim'),


            ])
            ->allowedIncludes([

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


        $data = QueryBuilder::for(Analysespointeue::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('pointeuses'),


                AllowedFilter::exact('semaine'),


                AllowedFilter::exact('lun'),


                AllowedFilter::exact('mar'),


                AllowedFilter::exact('mer'),


                AllowedFilter::exact('jeu'),


                AllowedFilter::exact('ven'),


                AllowedFilter::exact('sam'),


                AllowedFilter::exact('dim'),


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


                AllowedSort::field('pointeuses'),


                AllowedSort::field('semaine'),


                AllowedSort::field('lun'),


                AllowedSort::field('mar'),


                AllowedSort::field('mer'),


                AllowedSort::field('jeu'),


                AllowedSort::field('ven'),


                AllowedSort::field('sam'),


                AllowedSort::field('dim'),


            ])
            ->allowedIncludes([
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


    public function create(Request $request, Analysespointeue $Analysespointeuse)
    {


        try {
            $can = Helpers::can('Creer des analysespointeuse');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "analysespointeuse" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'pointeuses',
            'semaine',
            'lun',
            'mar',
            'mer',
            'jeu',
            'ven',
            'sam',
            'dim',
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


            'pointeuses' => [
                //'required'
            ],


            'semaine' => [
                //'required'
            ],


            'lun' => [
                //'required'
            ],


            'mar' => [
                //'required'
            ],


            'mer' => [
                //'required'
            ],


            'jeu' => [
                //'required'
            ],


            'ven' => [
                //'required'
            ],


            'sam' => [
                //'required'
            ],


            'dim' => [
                //'required'
            ],


        ], $messages = [


            'pointeuses' => ['cette donnee est obligatoire'],


            'semaine' => ['cette donnee est obligatoire'],


            'lun' => ['cette donnee est obligatoire'],


            'mar' => ['cette donnee est obligatoire'],


            'mer' => ['cette donnee est obligatoire'],


            'jeu' => ['cette donnee est obligatoire'],


            'ven' => ['cette donnee est obligatoire'],


            'sam' => ['cette donnee est obligatoire'],


            'dim' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);

        $data['creat_by'] = Auth::id();


        if (!empty($data['pointeuses'])) {

            $Analysespointeuse->pointeuses = $data['pointeuses'];

        }


        if (!empty($data['semaine'])) {

            $Analysespointeuse->semaine = $data['semaine'];

        }


        if (!empty($data['lun'])) {

            $Analysespointeuse->lun = $data['lun'];

        }


        if (!empty($data['mar'])) {

            $Analysespointeuse->mar = $data['mar'];

        }


        if (!empty($data['mer'])) {

            $Analysespointeuse->mer = $data['mer'];

        }


        if (!empty($data['jeu'])) {

            $Analysespointeuse->jeu = $data['jeu'];

        }


        if (!empty($data['ven'])) {

            $Analysespointeuse->ven = $data['ven'];

        }


        if (!empty($data['sam'])) {

            $Analysespointeuse->sam = $data['sam'];

        }


        if (!empty($data['dim'])) {

            $Analysespointeuse->dim = $data['dim'];

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Analysespointeuse->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }

        if (
            class_exists('\App\Http\Extras\AnalysespointeueExtras') &&
            method_exists('\App\Http\Extras\AnalysespointeueExtras', 'beforeSaveCreate')
        ) {
            AnalysespointeueExtras::beforeSaveCreate($request, $Analysespointeuse);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\AnalysespointeueExtras') &&
            method_exists('\App\Http\Extras\AnalysespointeueExtras', 'canCreate')
        ) {
            try {
                $canSave = AnalysespointeueExtras::canCreate($request, $Analysespointeuse);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Analysespointeuse->save();
        } else {
            return response()->json($Analysespointeuse, 200);
        }

        $Analysespointeuse = Analysespointeue::find($Analysespointeuse->id);
        $newCrudData = [];

        $newCrudData['pointeuses'] = $Analysespointeuse->pointeuses;
        $newCrudData['semaine'] = $Analysespointeuse->semaine;
        $newCrudData['lun'] = $Analysespointeuse->lun;
        $newCrudData['mar'] = $Analysespointeuse->mar;
        $newCrudData['mer'] = $Analysespointeuse->mer;
        $newCrudData['jeu'] = $Analysespointeuse->jeu;
        $newCrudData['ven'] = $Analysespointeuse->ven;
        $newCrudData['sam'] = $Analysespointeuse->sam;
        $newCrudData['dim'] = $Analysespointeuse->dim;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Analysespointeuse', 'entite_cle' => $Analysespointeuse->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $response = $Analysespointeuse->toArray();


        try {

            foreach ($Analysespointeuse->extra_attributes["extra-data"] as $key => $dat) {
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


    public function update(Request $request, Analysespointeue $Analysespointeuse)
    {
        try {
            $can = Helpers::can('Editer des analysespointeuse');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $oldCrudData = [];

        $oldCrudData['pointeuses'] = $Analysespointeuse->pointeuses;
        $oldCrudData['semaine'] = $Analysespointeuse->semaine;
        $oldCrudData['lun'] = $Analysespointeuse->lun;
        $oldCrudData['mar'] = $Analysespointeuse->mar;
        $oldCrudData['mer'] = $Analysespointeuse->mer;
        $oldCrudData['jeu'] = $Analysespointeuse->jeu;
        $oldCrudData['ven'] = $Analysespointeuse->ven;
        $oldCrudData['sam'] = $Analysespointeuse->sam;
        $oldCrudData['dim'] = $Analysespointeuse->dim;


        $data = $request->all();
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->storeAs(
                'storage/uploads', "analysespointeuse" . "-" . $key . "_" . time() . "." . $file->extension()
            );
            $data[$key] = $path;
        }


        $champsRechercher = [
            'id',
            'pointeuses',
            'semaine',
            'lun',
            'mar',
            'mer',
            'jeu',
            'ven',
            'sam',
            'dim',
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


            'pointeuses' => [
                //'required'
            ],


            'semaine' => [
                //'required'
            ],


            'lun' => [
                //'required'
            ],


            'mar' => [
                //'required'
            ],


            'mer' => [
                //'required'
            ],


            'jeu' => [
                //'required'
            ],


            'ven' => [
                //'required'
            ],


            'sam' => [
                //'required'
            ],


            'dim' => [
                //'required'
            ],


        ], $messages = [


            'pointeuses' => ['cette donnee est obligatoire'],


            'semaine' => ['cette donnee est obligatoire'],


            'lun' => ['cette donnee est obligatoire'],


            'mar' => ['cette donnee est obligatoire'],


            'mer' => ['cette donnee est obligatoire'],


            'jeu' => ['cette donnee est obligatoire'],


            'ven' => ['cette donnee est obligatoire'],


            'sam' => ['cette donnee est obligatoire'],


            'dim' => ['cette donnee est obligatoire'],


        ])->validate();


        $extra_data = array_diff($envoyer, $champsRechercher);


        if (array_key_exists("pointeuses", $data)) {


            if (!empty($data['pointeuses'])) {

                $Analysespointeuse->pointeuses = $data['pointeuses'];

            }

        }


        if (array_key_exists("semaine", $data)) {


            if (!empty($data['semaine'])) {

                $Analysespointeuse->semaine = $data['semaine'];

            }

        }


        if (array_key_exists("lun", $data)) {


            if (!empty($data['lun'])) {

                $Analysespointeuse->lun = $data['lun'];

            }

        }


        if (array_key_exists("mar", $data)) {


            if (!empty($data['mar'])) {

                $Analysespointeuse->mar = $data['mar'];

            }

        }


        if (array_key_exists("mer", $data)) {


            if (!empty($data['mer'])) {

                $Analysespointeuse->mer = $data['mer'];

            }

        }


        if (array_key_exists("jeu", $data)) {


            if (!empty($data['jeu'])) {

                $Analysespointeuse->jeu = $data['jeu'];

            }

        }


        if (array_key_exists("ven", $data)) {


            if (!empty($data['ven'])) {

                $Analysespointeuse->ven = $data['ven'];

            }

        }


        if (array_key_exists("sam", $data)) {


            if (!empty($data['sam'])) {

                $Analysespointeuse->sam = $data['sam'];

            }

        }


        if (array_key_exists("dim", $data)) {


            if (!empty($data['dim'])) {

                $Analysespointeuse->dim = $data['dim'];

            }

        }


        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $data[$d];

        }
        try {

            $Analysespointeuse->extra_attributes["extra-data"] = $dat;


        } catch (Throwable $e) {
        }


        if (
            class_exists('\App\Http\Extras\AnalysespointeueExtras') &&
            method_exists('\App\Http\Extras\AnalysespointeueExtras', 'beforeSaveUpdate')
        ) {
            AnalysespointeueExtras::beforeSaveUpdate($request, $Analysespointeuse);
        }

        $canSave = true;
        if (
            class_exists('\App\Http\Extras\AnalysespointeueExtras') &&
            method_exists('\App\Http\Extras\AnalysespointeueExtras', 'canUpdate')
        ) {
            try {
                $canSave = AnalysespointeueExtras::canUpdate($request, $Analysespointeuse);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Analysespointeuse->save();
        } else {
            return response()->json($Analysespointeuse, 200);

        }


        $Analysespointeuse = Analysespointeue::find($Analysespointeuse->id);


        $newCrudData = [];

        $newCrudData['pointeuses'] = $Analysespointeuse->pointeuses;
        $newCrudData['semaine'] = $Analysespointeuse->semaine;
        $newCrudData['lun'] = $Analysespointeuse->lun;
        $newCrudData['mar'] = $Analysespointeuse->mar;
        $newCrudData['mer'] = $Analysespointeuse->mer;
        $newCrudData['jeu'] = $Analysespointeuse->jeu;
        $newCrudData['ven'] = $Analysespointeuse->ven;
        $newCrudData['sam'] = $Analysespointeuse->sam;
        $newCrudData['dim'] = $Analysespointeuse->dim;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Analysespointeuse', 'entite_cle' => $Analysespointeuse->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);

        $response = $Analysespointeuse->toArray();


        try {

            foreach ($Analysespointeuse->extra_attributes["extra-data"] as $key => $dat) {
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
    public function delete(Request $request, Analysespointeue $Analysespointeuse)
    {
        try {
            $can = Helpers::can('Supprimer des analysespointeuse');

            if (!$can) {
                return response()->json([], 200);
            }
        } catch (Throwable $e) {
        }

        $newCrudData = [];

        $newCrudData['pointeuses'] = $Analysespointeuse->pointeuses;
        $newCrudData['semaine'] = $Analysespointeuse->semaine;
        $newCrudData['lun'] = $Analysespointeuse->lun;
        $newCrudData['mar'] = $Analysespointeuse->mar;
        $newCrudData['mer'] = $Analysespointeuse->mer;
        $newCrudData['jeu'] = $Analysespointeuse->jeu;
        $newCrudData['ven'] = $Analysespointeuse->ven;
        $newCrudData['sam'] = $Analysespointeuse->sam;
        $newCrudData['dim'] = $Analysespointeuse->dim;


        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Analysespointeuse', 'entite_cle' => $Analysespointeuse->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);


        $canSave = true;
        if (
            class_exists('\App\Http\Extras\AnalysespointeueExtras') &&
            method_exists('\App\Http\Extras\AnalysespointeueExtras', 'canDelete')
        ) {
            try {
                $canSave = AnalysespointeueExtras::canDelete($request, $Analysespointeuse);
            } catch (Throwable $e) {

            }

        }


        if ($canSave) {
            $Analysespointeuse->delete();
        } else {
            return response()->json($Analysespointeuse, 200);

        }


        return response()->json([], 200);


    }


    public function action(Request $request)
    {


        $action = $request->get('action', 'aucun');
        $actioner = new AnalysespointeuseActions();
        $response = $actioner->$action($request);


        return response()->json($response, 202);
    }

}
