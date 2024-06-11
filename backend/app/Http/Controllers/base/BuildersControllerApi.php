<?php

namespace App\Http\Controllers\prod;

use App\Http\Controllers\Controller;
use App\Models\prod\BuildersModel;
use App\Models\prod\UsersModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

// use App\Repository\prod\BuildersRepository;


$db = GetDb::getDatabase();

class BuildersControllerApi extends Controller
{

    private $BuildersRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\prod\BuildersRepository $BuildersRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {


    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data(Request $request, $key, $val)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
        $request->merge(['filter' => [$key => $val]]);
        $data = QueryBuilder::for(BuildersModel::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('statut'),


                AllowedFilter::exact('createurs'),


            ])
            ->get()
            ->filter(function ($data) {
                return Gate::inspect('view', $data)->allowed();
            });
        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20;
        $records = new LengthAwarePaginator(
            $data->forPage($page, $perPage), $data->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
        );
        $donnees = $records;
        $donnees = $donnees->toArray();


        if (empty($users)) {

            $users = UsersModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['createurs'] = $users;


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data1(Request $request)
    {


        $data = QueryBuilder::for(BuildersModel::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('statut'),


                AllowedFilter::exact('createurs'),


            ])
            ->get()
            ->filter(function ($data) {
                return Gate::inspect('view', $data)->allowed();
            });
        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20;
        $records = new LengthAwarePaginator(
            $data->forPage($page, $perPage), $data->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
        );
        $donnees = $records;
        $donnees = $donnees->toArray();


        if (empty($users)) {

            $users = UsersModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['createurs'] = $users;


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


    public function create(Request $request, BuildersModel $Builders)
    {
        $Permission = Gate::inspect('create', BuildersModel::class);

// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
        if (empty($request->only(['data.0'])['data'][0])) {
            $donnes = [
                'data' => [[]],
                'action' => 'create',
            ];
        } else {
            $donnes = [
                'data' => [$request->only(['data.0'])['data'][0]],
                'action' => 'create',
            ];

        }
        $request->merge(['action' => 'create']);


        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'builders');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs statut
        $editor->Fields(Field::inst('statut')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs extra_attributes
        $editor->Fields(Field::inst('extra_attributes')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs deleted_at
        $editor->Fields(Field::inst('deleted_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs created_at
        $editor->Fields(Field::inst('created_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs updated_at
        $editor->Fields(Field::inst('updated_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs createurs
        $editor->Fields(Field::inst('createurs')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })

        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))


        );


        $editor->process($donnes);

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Builders->statut = $donnes['statut'];


        $Builders->createurs = $donnes['createurs'];


        $Builders->save();


        $Builders = $Builders::find($Builders->id);
        $response = $Builders->toArray();
        $donnees['data'][] = $response;


        if (empty($users)) {

            $users = UsersModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['createurs'] = $users;


        return response()->json($donnees, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return  Response
     */
    public function show($id)
    {
//

        $this->BuildersRepository->show($id);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return  Response
     */

    public function update(Request $request, BuildersModel $Builders)
    {

        $Permission = Gate::inspect('update', $Builders);
        if (empty($request->only(['data.0'])['data'][0])) {
            $donnes = [
                'data' => [[]],
                'action' => 'create',
            ];
        } else {
            $donnes = [
                'data' => [$request->only(['data.0'])['data'][0]],
                'action' => 'create',
            ];

        }
        $request->merge(['action' => 'edit']);
        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'builders');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs statut
        $editor->Fields(Field::inst('statut')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs extra_attributes
        $editor->Fields(Field::inst('extra_attributes')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs deleted_at
        $editor->Fields(Field::inst('deleted_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs created_at
        $editor->Fields(Field::inst('created_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs updated_at
        $editor->Fields(Field::inst('updated_at')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs createurs
        $editor->Fields(Field::inst('createurs')
            ->set(false)
            //        ->get(false)
            ->validator(function ($data) use ($Permission) {
                $resultat = true;
                if (!$Permission->allowed()) {
                    $resultat = $Permission->message();

                }
                return $resultat;
            })


        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))


        );


        $editor->process($donnes);

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Builders->statut = $donnes['statut'];


        $Builders->createurs = $donnes['createurs'];


        $Builders->save();

        $response = $Builders
            ->toArray();
        $donnees['data'][] = $response;


        if (empty($users)) {

            $users = UsersModel::all()
                ->filter(function ($data) {
                    return Gate::inspect('view', $data)->allowed();
                })
                ->map(function ($data) {
                    return [
                        "label" => $data->selectlabel,
                        "value" => $data->selectvalue,
                    ];
                });
        }

        $donnees['options']['createurs'] = $users;


        return response()->json($donnees, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return  Response
     */
    public function delete(Request $request, BuildersModel $Builders)
    {
        if (empty($request->only(['data.0'])['data'][0])) {
            $donnes = [
                'data' => [[]],
                'action' => 'create',
            ];
        } else {
            $donnes = [
                'data' => [$request->only(['data.0'])['data'][0]],
                'action' => 'create',
            ];

        }

        $Permission = Gate::inspect('delete', $Builders);

        if ($Permission->allowed()) {
            $Builders->delete();
        }
        $data = [];

        return response()->json($data, 200);


    }


}
