<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\base\BranchesModel;
use DataTables\Editor;
use DataTables\Editor\Field;
use DataTables\Editor\Validate;
use DataTables\Editor\ValidateOptions;
use DataTables\GetDb;
use DataTables\SSP;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


// use App\Repository\base\BranchesRepository;


ini_set('memory_limit', '8192M');
ini_set('max_execution_time', '300');

$db = GetDb::getDatabase();

class BranchesControllerWeb extends Controller
{

    private $BranchesRepository;
    private $menu;


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\base\BranchesRepository $BranchesRepository
     * @param int $id
     */
    public function __construct(Request $request)
    {
        if (!$request->has('__internalId__')) {
            $id = "Branches_" . Str::uuid()->toString() . '_unique';
            $id = Str::replace('-', '_', $id);

            $request->merge(['__internalId__' => $id]);
        }

    }


    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data(Request $request, $key, $val)
    {


        $val = explode(',', $val);
        $val = '(' . implode(',', $val) . ')';
        $val = Str::replaceFirst('(', "('", $val);
        $val = Str::replaceLast(')', "')", $val);
        $val = Str::replace(',', "','", $val);
// La securite qui empeiche darriver sur cette sans avoir une signature valide


        $columns = array(

            array('db' => 'id', 'dt' => 'id'),


            array('db' => 'parents', 'dt' => 'parents'),


            array('db' => 'family', 'dt' => 'family'),


            array('db' => 'adn', 'dt' => 'adn'),


            array('db' => 'statut', 'dt' => 'statut'),


            array('db' => 'createurs', 'dt' => 'createurs'),


        );


        $filters = ['deleted_at IS NULL'];
        $filters[] = "$key IN $val ";
        if (!is_array($this->where())) {
            $filters[] = $this->where();
        }
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::complex($request->all(), $db, 'branches', 'id', $columns, null, $filters);
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = BranchesModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();
                if (!empty($donnes->extra_attributes)) {
                    if (!empty($donnes->extra_attributes["extra-data"])) {
                        foreach ($donnes->extra_attributes["extra-data"] as $key => $dat) {
                            $don[$key] = $dat;
                        }
                    }
                }


                $don['PipelinesAvf'] = "";


                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;


//        dd($donnees);


        echo json_encode(
            $donnees
        );


    }

    public function where()
    {
        $groupes = [];
// $groupes=Auth::user()->MyGroupes->toArray();
        $where = [];
        foreach ($groupes as $groupe) {
// $where[]="recepteurs_connus LIKE '$groupe'";
// $where[]="recepteurs_connus LIKE '$groupe,%'";
// $where[]="recepteurs_connus LIKE '%,$groupe'";
// $where[]="recepteurs_connus LIKE '%,$groupe,%'";
// $where[]="emetteurs_connus LIKE '$groupe'";
// $where[]="emetteurs_connus LIKE '$groupe,%'";
// $where[]="emetteurs_connus LIKE '%,$groupe'";
// $where[]="emetteurs_connus LIKE '%,$groupe,%'";

        }
        if (count($where) > 0) {
            $where = '(' . implode(' OR ', $where) . ')';

        }


        if (Auth::user()->can("Voir les branches")) {
            $where = [];
        }
        return $where;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function dataParents(Request $request, $Branches)
    {

        $family = $request->get('family') ?? 0;
        $Branches = BranchesModel::firstOrNew([
            'id' => $Branches,

        ]);
//        dd($Branches);


        $donnees = [];
        try {
            $donnees = explode("-", $Branches->adn);
            $donnees[] = $Branches->id;
        } catch (Exception $e) {

        }

        $donnees = BranchesModel::orderBy('id')->findMany($donnees);
        $retour = [];
        foreach ($donnees as $data) {
//           $data=$data->toArray();

            foreach ($data->extra_attributes["extra-data"] as $key => $dat) {
                $data[$key] = $dat;
            }

            $retour[] = $data->toArray();
        }


        return response()->json(['data' => $retour], 200);


    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data1(Request $request)
    {


        $columns = array(


            array('db' => 'id', 'dt' => 'id'),


            array('db' => 'parents', 'dt' => 'parents'),


            array('db' => 'family', 'dt' => 'family'),


            array('db' => 'adn', 'dt' => 'adn'),


            array('db' => 'statut', 'dt' => 'statut'),


            array('db' => 'createurs', 'dt' => 'createurs'),


        );

        $filters = ['deleted_at IS NULL'];
        if (!is_array($this->where())) {
            $filters[] = $this->where();
        }
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::complex($request->all(), $db, 'branches', 'id', $columns, null, $filters);
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = BranchesModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();
                if (!empty($donnes->extra_attributes)) {
                    if (!empty($donnes->extra_attributes["extra-data"])) {
                        foreach ($donnes->extra_attributes["extra-data"] as $key => $dat) {
                            $don[$key] = $dat;
                        }
                    }
                }


                $don['PipelinesAvf'] = "";

                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;


        echo json_encode(
            $donnees
        );
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function dataselect(Request $request)
    {


        $columns = array(


            array('db' => 'id', 'dt' => 'id'),


            array('db' => 'parents', 'dt' => 'parents'),


            array('db' => 'family', 'dt' => 'family'),


            array('db' => 'adn', 'dt' => 'adn'),


            array('db' => 'statut', 'dt' => 'statut'),


            array('db' => 'createurs', 'dt' => 'createurs'),


        );

        $filters = ['deleted_at IS NULL'];
        if (!is_array($this->where())) {
            $filters[] = $this->where();
        }
        $db = GetDb::getDatabase()->database_driver;
        $resultat = SSP::complex($request->all(), $db, 'branches', 'id', $columns, null, $filters);
        $new_data = [];
        foreach ($resultat['data'] as $data) {
            $donnes = BranchesModel::find($data['id']);
            if ($donnes) {
// $donnes['PipelinesAvf']=$data->PipelinesAvf;
                $don = $donnes->toArray();

                if (!empty($donnes->extra_attributes)) {
                    if (!empty($donnes->extra_attributes["extra-data"])) {
                        foreach ($donnes->extra_attributes["extra-data"] as $key => $dat) {
                            $don[$key] = $dat;
                        }
                    }
                }
                $don['PipelinesAvf'] = "";
                try {
                    $don['CardRenderSelect'] = $donnes->CardRenderSelect ?? "";

                } catch (Exception $e) {
                }


                $new_data[] = $don;
            }
        }
        $resultat['data'] = $new_data;
        $donnees = $resultat;


        echo json_encode(
            $donnees
        );
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return  Response
     */
    public function data3(Request $request)
    {
// La securite qui empeiche darriver sur cette sans avoir une signature valide
//if (! $request->hasValidSignature()) {
//abort(401);
//}
        $request->merge(['filter' => [$key => $val]]);
        $data = QueryBuilder::for(BranchesModel::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),


                AllowedFilter::exact('parents'),


                AllowedFilter::exact('family'),


                AllowedFilter::exact('adn'),


                AllowedFilter::exact('statut'),


                AllowedFilter::exact('createurs'),


            ])
            ->get()//   ->filter(function($data){ return Gate::inspect('view',$data)->allowed(); })

        ;
        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = isset($_REQUEST["limit"]) ? max(0, intval($_REQUEST["limit"])) : 20;
        $records = new LengthAwarePaginator(
            $data->forPage($page, $perPage), $data->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
        );
        $donnees = $records;
        $donnees = $donnees->toArray();


        return response()->json($donnees, 200);


//                        return response()->json($data,200);
    }


    public function create(Request $request, BranchesModel $Branches)
    {

// La securite qui empeiche darriver sur cette sans avoir une signature valide
        if (!$request->hasValidSignature()) {
            abort(401);
        }


        $donnes = $request->only(['data.0'])['data'][0];


        $champsRechercher = [
            'id',
            'parents',
            'family',
            'adn',
            'statut',
            'extra_attributes',
            'deleted_at',
            'created_at',
            'updated_at',
            'createurs',
        ];
        $envoyer = [];
        foreach ($donnes as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);


        $extra_data = array_diff($envoyer, $champsRechercher);
        $request->merge(['action' => 'create']);

        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'branches');
        // le champs id
        $editor->Fields(Field::inst('id')
            ->set(false)
        //        ->get(false)
        // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
        // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
        );


        // le champs parents
        $editor->Fields(Field::inst('parents')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        // le champs family
        $editor->Fields(Field::inst('family')
            ->set(false)
            //        ->get(false)


            ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


        );


        $editor->process($request->all());

        $result = json_decode($editor->json(false), true);
//        dd($result);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        $Branches->parents = $donnes['parents'] ?? "";


        $Branches->family = $donnes['family'] ?? "";


        $adn = 0;
        $parents = BranchesModel::find($donnes['parents']);
        if (!empty($parents)) {
            $parentsAdn = $parents->adn;
            $parentsAdn = explode('-', $parentsAdn);
//            dd($parentsAdn);
            $parentsAdn[] = $donnes['parents'];
            $adn = implode('-', $parentsAdn);
        }

        $Branches->adn = $adn;


        $Branches->statut = $donnes['statut'] ?? "1";


        $Branches->createurs = $donnes['createurs'] ?? [];


        $Branches->parents = $donnes['parents'] ?? [];


        $Branches->family = $donnes['family'] ?? "";


//        $Branches->adn = $donnes['adn'] ?? "";


        $Branches->statut = $donnes['statut'] ?? "1";


        $Branches->etats = $donnes['Etats'] ?? "";


        $Branches->etats = $donnes['Etats'] ?? "";
        $Branches->createurs = \Auth::id();
        $Permission = Gate::inspect('create', $Branches);

        $editor = Editor::inst($db, 'branches');


        $editor->process($request->all());
        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }
        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $donnes[$d];

        }
        $Branches->extra_attributes["extra-data"] = $dat;

        $Branches->save();


        $Branches = $Branches::find($Branches->id);
        $response = $Branches->toArray();


        foreach ($Branches->extra_attributes["extra-data"] as $key => $dat) {
            $response[$key] = $dat;
        }
        $donnees['data'][] = $response;


        return response()->json($donnees, 200);


    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return  Response
     */

    public function update(Request $request, BranchesModel $Branches)
    {

        $donnes = $request->input()['data'][(is_array($Branches->id) ? $Branches->id[0] : $Branches->id)];

        $champsRechercher = [
            'id',
            'parents',
            'family',
            'adn',
            'statut',
            'extra_attributes',
            'deleted_at',
            'created_at',
            'updated_at',
            'createurs',
        ];
//        dd($donnes);
        $envoyer = [];
        foreach ($donnes as $key => $d) {
            $envoyer[] = $key;


        }
        $envoyer = array_unique($envoyer);


        $extra_data = array_diff($envoyer, $champsRechercher);
        $request->merge(['action' => 'edit']);
        $db = GetDb::getDatabase();

        $editor = Editor::inst($db, 'branches');
        if (array_key_exists("id", $donnes)) {
            // le champs id

            $editor->Fields(Field::inst('id')
                ->set(false)
            //        ->get(false)
            // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
            );


        }
        if (array_key_exists("parents", $donnes)) {


            // le champs parents
            $editor->Fields(Field::inst('parents')
                ->set(false)
                //        ->get(false)


                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );


        }
        if (array_key_exists("family", $donnes)) {


            // le champs family
            $editor->Fields(Field::inst('family')
                ->set(false)
                //        ->get(false)


                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );


        }
        if (array_key_exists("adn", $donnes)) {


            // le champs adn
            $editor->Fields(Field::inst('adn')
                ->set(false)
                //        ->get(false)


                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );


        }
        if (array_key_exists("statut", $donnes)) {


            // le champs statut
            $editor->Fields(Field::inst('statut')
                ->set(false)
                //        ->get(false)


                ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))


            );


        }
        if (array_key_exists("extra_attributes", $donnes)) {
            // le champs extra_attributes

            $editor->Fields(Field::inst('extra_attributes')
                ->set(false)
            //        ->get(false)
            // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
            );


        }
        if (array_key_exists("deleted_at", $donnes)) {
            // le champs deleted_at

            $editor->Fields(Field::inst('deleted_at')
                ->set(false)
            //        ->get(false)
            // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
            );


        }
        if (array_key_exists("created_at", $donnes)) {
            // le champs created_at

            $editor->Fields(Field::inst('created_at')
                ->set(false)
            //        ->get(false)
            // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
            );


        }
        if (array_key_exists("updated_at", $donnes)) {
            // le champs updated_at

            $editor->Fields(Field::inst('updated_at')
                ->set(false)
            //        ->get(false)
            // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
            );


        }
        if (array_key_exists("createurs", $donnes)) {
            // le champs createurs

            $editor->Fields(Field::inst('createurs')
                ->set(false)
            //        ->get(false)
            // ->validator(Validate::required(ValidateOptions::inst()->message("Ce champs est requis")))
            // ->validator(Validate::maxLen(255,ValidateOptions::inst()->message("Pas plus de 255 charactere")))
            );


        }

        $editor->process($request->all());

        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }


        if (array_key_exists("id", $donnes)) {


        }


        if (array_key_exists("parents", $donnes)) {
            $Branches->parents = $donnes['parents'] ?? [];


        }


        if (array_key_exists("family", $donnes)) {


            $Branches->family = $donnes['family'] ?? "";


        }


        if (array_key_exists("adn", $donnes)) {


//            $Branches->adn = $donnes['adn'] ?? "";


        }


        if (array_key_exists("statut", $donnes)) {


            $Branches->statut = $donnes['statut'] ?? "1";


        }


        if (array_key_exists("extra_attributes", $donnes)) {


        }


        if (array_key_exists("deleted_at", $donnes)) {


        }


        if (array_key_exists("created_at", $donnes)) {


        }


        if (array_key_exists("updated_at", $donnes)) {


        }


        if (array_key_exists("createurs", $donnes)) {

        }


        $Branches->etats = $donnes['Etats'] ?? "";


        $Permission = Gate::inspect('update', $Branches);

        $editor = Editor::inst($db, 'branches');
        if (array_key_exists("id", $donnes)) {


        }

//        if (array_key_exists("parents", $donnes)) {
//
//
//            // le champs parents
//            $editor->Fields(Field::inst('parents')
//                ->set(false)
//                //        ->get(false)
//                ->validator(function ($data) use ($Permission) {
//                    $resultat = true;
//                    if (!$Permission->allowed()) {
//                        $resultat = $Permission->message();
//
//                    }
//                    return $resultat;
//                })
//
//
//            );
//
//
//        }
//
//        if (array_key_exists("family", $donnes)) {
//
//
//            // le champs family
//            $editor->Fields(Field::inst('family')
//                ->set(false)
//                //        ->get(false)
//                ->validator(function ($data) use ($Permission) {
//                    $resultat = true;
//                    if (!$Permission->allowed()) {
//                        $resultat = $Permission->message();
//
//                    }
//                    return $resultat;
//                })
//
//
//            );
//
//
//        }
//
//        if (array_key_exists("adn", $donnes)) {
//
//
//            // le champs adn
//            $editor->Fields(Field::inst('adn')
//                ->set(false)
//                //        ->get(false)
//                ->validator(function ($data) use ($Permission) {
//                    $resultat = true;
//                    if (!$Permission->allowed()) {
//                        $resultat = $Permission->message();
//
//                    }
//                    return $resultat;
//                })
//
//
//            );
//
//
//        }
//
//        if (array_key_exists("statut", $donnes)) {
//
//
//            // le champs statut
//            $editor->Fields(Field::inst('statut')
//                ->set(false)
//                //        ->get(false)
//                ->validator(function ($data) use ($Permission) {
//                    $resultat = true;
//                    if (!$Permission->allowed()) {
//                        $resultat = $Permission->message();
//
//                    }
//                    return $resultat;
//                })
//
//
//            );
//
//
//        }
//
//        if (array_key_exists("extra_attributes", $donnes)) {
//
//
//        }
//
//        if (array_key_exists("deleted_at", $donnes)) {
//
//
//        }
//
//        if (array_key_exists("created_at", $donnes)) {
//
//
//        }
//
//        if (array_key_exists("updated_at", $donnes)) {
//
//
//        }
//
//        if (array_key_exists("createurs", $donnes)) {
//
//
//        }


        $editor->process($request->all());
        $result = json_decode($editor->json(false), true);
        if (!empty($result['fieldErrors']) && count($result['fieldErrors']) > 0) {
            return response()->json($result, 200);
        }
        if (!empty($result['error'])) {
            return response()->json($result, 200);
        }
        $dat = [];

        foreach ($extra_data as $d) {

            $dat[$d] = $donnes[$d];

        }
        $Branches->extra_attributes["extra-data"] = $dat;

        $Branches->save();


        $response = $Branches
            ->toArray();

        foreach ($Branches->extra_attributes["extra-data"] as $key => $dat) {
            $response[$key] = $dat;
        }
        $donnees['data'][] = $response;


        return response()->json($donnees, 200);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return  Response
     */

    public function show(Request $request, $Branches)
    {

        $family = $request->get('family') ?? 0;
        $Branches = BranchesModel::firstOrNew([
            'id' => $Branches,
            'family' => $family
        ]);


        $donnees = [];
        try {
            $donnees = explode("-", $Branches->adn);
            $donnees[] = $Branches->id;
        } catch (Exception $e) {

        }
        $child = [];

        try {
            $child = BranchesModel::where(['parents' => $Branches->id, 'family' => $family])
                ->get('id')->map(function ($data) {
                    return $data->id;
                })->toArray();
        } catch (Exception $e) {

        }


        $donnees = array_merge($donnees, $child);
        $donnees = BranchesModel::findMany($donnees);
        $retour = [];
        foreach ($donnees as $data) {
//           $data=$data->toArray();

            foreach ($data->extra_attributes["extra-data"] as $key => $dat) {
                $data[$key] = $dat;
            }

            $retour[] = $data->toArray();
        }
//       dd($retour);


        return response()->json($donnees, 200);


    }


    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return  Response
     */
    public function delete(Request $request, BranchesModel $Branches)
    {
        $donnes = $request->input()['data'][(is_array($Branches->id) ? $Branches->id[0] : $Branches->id)];

        $Branches->createurs = \Auth::id();
        $Permission = Gate::inspect('delete', $Branches);

        if ($Permission->allowed()) {
            $Branches->delete();
        }

        $Branches->delete();
        $data = [];

        return response()->json($data, 200);


    }


}



