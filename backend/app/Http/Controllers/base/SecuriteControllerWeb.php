<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Repository\ContenusRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;


class SecuriteControllerWeb extends Controller
{

    private $ContenusRepository;
    private $menu;
    private $validateField = [
        'id_securite',
        'label',
        'description',
        'add_by',
        'emetteurs',
        'recepteurs',
        'key',
        'value'
    ];
    private $validateRegles = [
        'id_securite' => 'required',
        'label' => 'required',
        'description' => 'required',
        'add_by' => 'required',
        'emetteurs' => 'required',
        'recepteurs' => 'required',
        'key' => 'required',
        'value' => 'required'
    ];
    private $validateMessages = [
        'id_securite.required' => 'cette donnees est requis',
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
    public function index()
    {

        $pageConfig = [
            'mainLayoutType' => 'vertical',
            'type' => 'admin',
            'menu_type' => 'admin',
            'is_navbar' => true,
        ];
//        dd();
        $vue = view('/content/Administrations_a/Securite.securite', ['pageConfigs' => $pageConfig, 'menu' => $this->menu]);
        return response($vue, 200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function post_index(Request $request)
    {

        $vue = view('/content/Administrations_a/Securite.post_securite', ['editorData' => $request->All()]);
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

        $vue = view('/content/Administrations_a/Securite.post_securite', ['editorData' => $request->All()]);
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

        $vue = view('/content/Administrations_a/Securite.post_securite', ['editorData' => $request->All()]);
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

        $vue = view('/content/Administrations_a/Securite.post_securite', ['editorData' => $request->All()]);
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

        $vue = view('/content/Administrations_a/Securite.post_securite', ['editorData' => $request->All()]);
        return response($vue, 200);

    }


}



