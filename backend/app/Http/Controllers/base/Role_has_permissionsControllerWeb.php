<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Repository\Role_has_permissionsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;


class Role_has_permissionsControllerWeb extends Controller
{

    private $Role_has_permissionsRepository;
    private $menu;
    private $validateField = [
        'permission_id',
        'role_id'
    ];
    private $validateRegles = [
        'permission_id' => 'required',
        'role_id' => 'required'
    ];
    private $validateMessages = [
        'permission_id.required' => 'cette donnees est requis',
        'role_id.required' => 'cette donnees est requis'
    ];


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\Role_has_permissionsRepository $Role_has_permissionsRepository
     * @param int $id
     */
    public function __construct(Request $request, Role_has_permissionsRepository $Role_has_permissionsRepository)
    {
        $this->Role_has_permissionsRepository = $Role_has_permissionsRepository;

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

        $vue = view('/content/base/Role_has_permissions.role_has_permissions', ['pageConfigs' => $pageConfig, 'menu' => $this->menu]);
        return response($vue, 200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function post_index(Request $request, $id)
    {

        $vue = view('/content/base/Role_has_permissions.post_role_has_permissions', ['editorData' => $request->All(), 'roles_id' => $id]);
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
        //  $this->Role_has_permissionsRepository->create($validated);

        $vue = view('/content/base/Role_has_permissions.post_role_has_permissions', ['editorData' => $request->All()]);
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
        // $this->Role_has_permissionsRepository->store($validated);

        $vue = view('/content/base/Role_has_permissions.post_role_has_permissions', ['editorData' => $request->All()]);
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
        $this->Role_has_permissionsRepository->show($id);

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
        //   $this->Role_has_permissionsRepository->update($validated);
        //   dd($validated);

        $vue = view('/content/base/Role_has_permissions.post_role_has_permissions', ['editorData' => $request->All()]);
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
        // $this->Role_has_permissionsRepository->destroy($validated);

        $vue = view('/content/base/Role_has_permissions.post_role_has_permissions', ['editorData' => $request->All()]);
        return response($vue, 200);

    }


}



