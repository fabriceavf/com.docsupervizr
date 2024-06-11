<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\production\ActivitesModel;
use App\Models\production\ProjetsModel;
use App\Models\production\UsersModel;
use App\Repository\production\ActivitesRepository;
use Auth;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class MiseAJourControllerWeb extends Controller
{


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\production\ActivitesRepository $ActivitesRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */


    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return Response
     */

    public function update(Request $request)
    {

        $data = [];
        $donnes = $request->only(['data.0'])['data'][0];
        $request->merge(['action' => 'create']);

        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'activites');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        );


        // le champs token
        $editor->Fields(Field::inst('token')
            ->set(false)
            ->validator(Validate::required(ValidateOptions::inst()->message("le token est requis")))
            ->validator(function ($data) {
                return $data == "123456789" ? true : "le token est incorrect";
            })

        );

        // le champs table
        $editor->Fields(Field::inst('table')
            ->set(false)
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            ->validator(function ($data) {
                return is_string($data) ? true : "Cette donnee doit etre une chaine de charactere";
            })
            ->validator(function ($data) {
                return Schema::hasTable($data) ? Schema::hasTable($data) : "Cette table nexiste pas";
            })

        );

        // le champs donnees
        $editor->Fields(Field::inst('donnees')
            ->set(false)
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            ->validator(function ($data) {
                return (is_array($data) && count($data) > 0) ? true : "Cette donnee doit etre un tableau non vide";
            })
            ->validator(function ($data) {
                return (!empty($data[0]) && is_array($data[0])) ? true : "Cette donnee doit etre un tableau contenant les tableaux";
            })
        );


        $editor->process($request->all());


        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 501);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 501);
        }


        foreach ($donnes['donnees'] as $data) {
            DB::table($donnes['table'])->upsert($data, $data);
        }
        return response()->json($donnes, 200);


    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return Response
     */

    public function getdata(Request $request)
    {

        $data = [];
        $donnes = $request->only(['data.0'])['data'][0];
        $request->merge(['action' => 'create']);

        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'activites');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        );


        // le champs token
        $editor->Fields(Field::inst('token')
            ->set(false)
            ->validator(Validate::required(ValidateOptions::inst()->message("le token est requis")))
            ->validator(function ($data) {
                return $data == "123456789" ? true : "le token est incorrect";
            })

        );

        // le champs table
        $editor->Fields(Field::inst('table')
            ->set(false)
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            ->validator(function ($data) {
                return is_string($data) ? true : "Cette donnee doit etre une chaine de charactere";
            })
            ->validator(function ($data) {
                return Schema::hasTable($data) ? Schema::hasTable($data) : "Cette table nexiste pas";
            })

        );

        // le champs donnees
        $editor->Fields(Field::inst('donnees')
            ->set(false)
            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            ->validator(function ($data) {
                return (is_array($data) && count($data) > 0) ? true : "Cette donnee doit etre un tableau non vide";
            })
            ->validator(function ($data) {
                return (!empty($data[0]) && is_array($data[0])) ? true : "Cette donnee doit etre un tableau contenant les tableaux";
            })
        );


        $editor->process($request->all());


        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 501);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 501);
        }


        foreach ($donnes['donnees'] as $data) {
            DB::table($donnes['table'])->upsert($data, $data);
        }
        return response()->json($donnes, 200);


    }


}



