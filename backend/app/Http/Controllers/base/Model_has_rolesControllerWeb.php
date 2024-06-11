<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Repository\Model_has_rolesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;


class Model_has_rolesControllerWeb extends Controller
{

    private $Model_has_rolesRepository;
    private $menu;
    private $validateField = [
        'role_id',
        'model_type',
        'model_id'
    ];
    private $validateRegles = [
        'role_id' => 'required',
        'model_type' => 'required',
        'model_id' => 'required'
    ];
    private $validateMessages = [
        'role_id.required' => 'cette donnees est requis',
        'model_type.required' => 'cette donnees est requis',
        'model_id.required' => 'cette donnees est requis'
    ];


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\Model_has_rolesRepository $Model_has_rolesRepository
     * @param int $id
     */
    public function __construct(Request $request, Model_has_rolesRepository $Model_has_rolesRepository)
    {
        $this->Model_has_rolesRepository = $Model_has_rolesRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => true,
        ];

        $vue = view('/content/base/Model_has_roles.model_has_roles', ['pageConfigs' => $pageConfig, 'menu' => $this->menu]);
        return response($vue, 200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function post_index(Request $request)
    {

        $vue = view('/content/base/Model_has_roles.post_model_has_roles', ['editorData' => $request->All()]);
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
        //  $this->Model_has_rolesRepository->create($validated);

        $vue = view('/content/base/Model_has_roles.post_model_has_roles', ['editorData' => $request->All()]);
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
        // $this->Model_has_rolesRepository->store($validated);

        $vue = view('/content/base/Model_has_roles.post_model_has_roles', ['editorData' => $request->All()]);
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
        $this->Model_has_rolesRepository->show($id);

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
        //   $this->Model_has_rolesRepository->update($validated);
        //   dd($validated);

        $vue = view('/content/base/Model_has_roles.post_model_has_roles', ['editorData' => $request->All()]);
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
        // $this->Model_has_rolesRepository->destroy($validated);

        $vue = view('/content/base/Model_has_roles.post_model_has_roles', ['editorData' => $request->All()]);
        return response($vue, 200);

    }


}



