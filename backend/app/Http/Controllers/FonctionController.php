<?php

namespace App\Http\Controllers;

use App\Models\Fonction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FonctionController extends Controller
{
//    public function index()
//    {
//        return response()
//        ->json($Table = Fonction::orderBy('libelle', 'ASC')->get())
//        ->withServices($Services = Service::orderBy('libelle', 'ASC')->get())
//        ;
//    }
    public function index()
    {
        return response()->json($Table = Fonction::orderBy('libelle', 'ASC')->get()->get());
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'code' => ['required'],
            'libelle' => ['required'],
            'service_id' => ['required'],
        ], $messages = [
            'code.required' => 'Le code est obligatoire.',
            'libelle.required' => 'Le libelle est obligatoire.',
            'service_id.required' => 'Le service est obligatoire.'
        ])->validate();

        $line = Fonction::create($request->all());

        return $line;
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'code' => ['required'],
            'libelle' => ['required'],
            'service_id' => ['required'],
        ], $messages = [
            'code.required' => 'Le code est obligatoire.',
            'libelle.required' => 'Le libelle est obligatoire.',
            'service_id.required' => 'Le service est obligatoire.'
        ])->validate();

        $line = Fonction::find($id);
        $line->update($request->all());

        return $line;
    }

    public function destroy($id)
    {
        $line = Fonction::find($id);
        $line->delete();
    }
}
