<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Repository\AuthentificationsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use View;


class AuthentificationsControllerWeb extends Controller
{

    private $AuthentificationsRepository;
    private $menu;
    private $validateField = [
        'id',
        'ip',
        'email',
        'password',
        'operations',
        'created_at',
        'updated_at'
    ];
    private $validateRegles = [
        'id' => 'required',
        'ip' => 'required',
        'email' => 'required',
        'password' => 'required',
        'operations' => 'required',
        'created_at' => 'required',
        'updated_at' => 'required'
    ];
    private $validateMessages = [
        'id.required' => 'cette donnees est requis',
        'ip.required' => 'cette donnees est requis',
        'email.required' => 'cette donnees est requis',
        'password.required' => 'cette donnees est requis',
        'operations.required' => 'cette donnees est requis',
        'created_at.required' => 'cette donnees est requis',
        'updated_at.required' => 'cette donnees est requis'
    ];


    /**
     * Return .
     * @param Request $request
     * @param App\Repository\AuthentificationsRepository $AuthentificationsRepository
     * @param int $id
     */
    public function __construct(Request $request, AuthentificationsRepository $AuthentificationsRepository)
    {
        $this->AuthentificationsRepository = $AuthentificationsRepository;
//        try{}catch (\Exception $e)

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

        $vue = view('/content/base/Authentifications.authentifications', ['pageConfigs' => $pageConfig, 'menu' => $this->menu]);
        return response($vue, 200);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function post_index(Request $request)
    {

        $vue = view('/content/base/Authentifications.post_authentifications', ['editorData' => $request->All()]);
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
        //  $this->AuthentificationsRepository->create($validated);

        $vue = view('/content/base/Authentifications.post_authentifications', ['editorData' => $request->All()]);
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
        // $this->AuthentificationsRepository->store($validated);

        $vue = view('/content/base/Authentifications.post_authentifications', ['editorData' => $request->All()]);
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
        $this->AuthentificationsRepository->show($id);

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
        //   $this->AuthentificationsRepository->update($validated);
        //   dd($validated);

        $vue = view('/content/base/Authentifications.post_authentifications', ['editorData' => $request->All()]);
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
        // $this->AuthentificationsRepository->destroy($validated);

        $vue = view('/content/base/Authentifications.post_authentifications', ['editorData' => $request->All()]);
        return response($vue, 200);

    }


}



