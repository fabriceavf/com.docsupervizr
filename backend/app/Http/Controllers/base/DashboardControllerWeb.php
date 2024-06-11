<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\base\FilesModel;
use App\Models\ProjetsModel;
use App\Models\User;
use App\Repository\ContenusRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;


class DashboardControllerWeb extends Controller
{

    private $ContenusRepository;
    private $menu;
    private $validateField = [
        'id_dashboard',
        'label',
        'description',
        'add_by',
        'emetteurs',
        'recepteurs',
        'key',
        'value'
    ];
    private $validateRegles = [
        'id_dashboard' => 'required',
        'label' => 'required',
        'description' => 'required',
        'add_by' => 'required',
        'emetteurs' => 'required',
        'recepteurs' => 'required',
        'key' => 'required',
        'value' => 'required'
    ];
    private $validateMessages = [
        'id_dashboard.required' => 'cette donnees est requis',
        'label.required' => 'cette donnees est requis',
        'description.required' => 'cette donnees est requis',
        'add_by.required' => 'cette donnees est requis',
        'emetteurs.required' => 'cette donnees est requis',
        'recepteurs.required' => 'cette donnees est requis',
        'key.required' => 'cette donnees est requis',
        'value.required' => 'cette donnees est requis'
    ];


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\ContenusRepository $ContenusRepository
     * @param int $id
     */
    public function __construct(Request $request, ContenusRepository $ContenusRepository)
    {
        $this->ContenusRepository = $ContenusRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $Projets = ProjetsModel::all()->map(function ($data) {
            if ($data->id_files) {
                $all_files = explode(',', $data->id_files);
                $all_files_ = [];
                foreach ($all_files as $fichiers) {
                    $all_files_[] = FilesModel::find($fichiers)->toArray();


                }

            }
            return [

                'DT_RowId' => 'row_' . $data->id,
                'group_order' => $data->row_group,
                'parents' => $data->parents,

                'id' => $data->id,
                'label' => $data->label,
                'description' => $data->description,
                'depart' => $data->depart,
                'fin' => $data->fin,
                'add_at' => User::find($data->add_at)->name . " " . User::find($data->add_at)->prenoms,
                'id_files' => $data->id_files ? $all_files_ : [],
                'types' => $data->types,
//                'extra_attributes' => $data->extra_attributes,
                'created_at' => $data->created_at,

                'updated_at' => $data->updated_at,
                'users' => $data->users()->get()->toArray(),

            ];
        })->toArray();
        $Courriers = json_decode(view('/content/Administrations_a/Courriers.post_courriers', ['editorData' => $request->All()])->render(), true);
        $Articles = json_decode(view('/content/Administrations_a/Articles.post_articles', ['editorData' => $request->All()])->render(), true);
        $Articles1 = view('/content/Administrations_a/Articles.post_articles', ['editorData' => $request->All()])->render();
        $users = json_decode(view('/content/base/Users.post_users', ['editorData' => $request->All()])->render(), true);
//        dd($users);
//        dd($Projets,$Courriers);
        View::share('AllData', [
            'projets' => $Projets,
            'articles' => $Articles,
            'articles1' => $Articles1,
            'users' => $users,
        ]);


        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => true,

        ];

        $vue = view('/content/Administrations_a/Dashboard.dashboard',
            [
                'pageConfigs' => $pageConfig,
                'menu' => $this->menu,
                'courriers' => $Courriers,
                'projets' => $Projets,
                'articles' => $Articles,
                'articles1' => $Articles1,
            ]
        );
        return response($vue, 200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function post_index(Request $request, $child = null)
    {

//        $enfant=
        if ($child) {
            $enfant = '(' . $child . ')';
            $vue = view('/content/Administrations_a/Dashboard.post_dashboard', [
                'editorData' => $request->All(),
                'selected' => $enfant
            ]);
        } else {
            $vue = view('/content/Administrations_a/Dashboard.post_dashboard', [
                'editorData' => $request->All(),
            ]);
        }

        return response($vue, 200);
    }

    /**
     * Show the form for creating a new resource.
     * Return .
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        //  je valide les donnees recu
        //   $validator = Validator::make($request->only($this->validateField), $this->validateRegles,$this->validateMessages);
        //  if ($validator->fails()) {
        //              return redirect()->back()
        //                  ->withErrors($validator)
        //                  ->withInput();
        //  }
        //   // Retrieve the validated input..
        //  $validated = $validator->validated();
        //  dd($validated);
        //  $this->ContenusRepository->create($validated);

        $vue = view('/content/Administrations_a/Dashboard.post_dashboard', ['editorData' => $request->All()]);
        return response($vue, 200);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // je valide les donnees recu
        // $validator = Validator::make($request->only($this->validateField), $this->validateRegles,$this->validateMessages);
        // if ($validator->fails()) {
        //             return redirect()->back()
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
        //  // Retrieve the validated input..
        // $validated = $validator->validated();
        // dd($validated);
        // $this->ContenusRepository->store($validated);

        $vue = view('/content/Administrations_a/Dashboard.post_dashboard', ['editorData' => $request->All()]);
        return response($vue, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
        $this->ContenusRepository->show($id);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // je valide les donnees recu

        //  $validator = Validator::make($request->only($this->validateField), $this->validateRegles,$this->validateMessages);
        //   if ($validator->fails()) {
        //               return redirect()->back()
        //                   ->withErrors($validator)
        //                   ->withInput();
        //   }
        //    // Retrieve the validated input..
        //   $validated = $validator->validated();
        //   $this->ContenusRepository->update($validated);
        //   dd($validated);

        $vue = view('/content/Administrations_a/Dashboard.post_dashboard', ['editorData' => $request->All()]);
        return response($vue, 200);

    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        //  je valide les donnees recu
        //   $validator = Validator::make($request->only($this->validateField), $this->validateRegles,$this->validateMessages);
        //  if ($validator->fails()) {
        //              return redirect()->back()
        //                  ->withErrors($validator)
        //                  ->withInput();
        //  }
        //   // Retrieve the validated input..
        //  $validated = $validator->validated();
        //  dd($validated);
        // $this->ContenusRepository->destroy($validated);

        $vue = view('/content/Administrations_a/Dashboard.post_dashboard', ['editorData' => $request->All()]);
        return response($vue, 200);

    }


}



