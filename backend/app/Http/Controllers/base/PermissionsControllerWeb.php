<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Repository\PermissionsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;


class PermissionsControllerWeb extends Controller
{

    private $PermissionsRepository;
    private $menu;
    private $validateField = [
        'id',
        'name',
        'guard_name',
        'created_at',
        'updated_at'
    ];
    private $validateRegles = [
        'id' => 'required',
        'name' => 'required',
        'guard_name' => 'required',
        'created_at' => 'required',
        'updated_at' => 'required'
    ];
    private $validateMessages = [
        'id.required' => 'cette donnees est requis',
        'name.required' => 'cette donnees est requis',
        'guard_name.required' => 'cette donnees est requis',
        'created_at.required' => 'cette donnees est requis',
        'updated_at.required' => 'cette donnees est requis'
    ];


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\PermissionsRepository $PermissionsRepository
     * @param int $id
     */
    public function __construct(Request $request, PermissionsRepository $PermissionsRepository)
    {
        $this->PermissionsRepository = $PermissionsRepository;

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

        $vue = view('/content/base/Permissions.permissions', ['pageConfigs' => $pageConfig, 'menu' => $this->menu]);
        return response($vue, 200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function post_index(Request $request)
    {

        $vue = view('/content/base/Permissions.post_permissions', ['editorData' => $request->All()]);
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
        //  $this->PermissionsRepository->create($validated);

        $vue = view('/content/base/Permissions.post_permissions', ['editorData' => $request->All()]);
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
        // $this->PermissionsRepository->store($validated);

        $vue = view('/content/base/Permissions.post_permissions', ['editorData' => $request->All()]);
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
        $this->PermissionsRepository->show($id);

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
        //   $this->PermissionsRepository->update($validated);
        //   dd($validated);

        $vue = view('/content/base/Permissions.post_permissions', ['editorData' => $request->All()]);
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
        // $this->PermissionsRepository->destroy($validated);

        $vue = view('/content/base/Permissions.post_permissions', ['editorData' => $request->All()]);
        return response($vue, 200);

    }


}



