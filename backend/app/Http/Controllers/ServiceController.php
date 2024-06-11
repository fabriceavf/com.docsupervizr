<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        return response()
            ->json($Table = Service::orderBy('libelle', 'ASC')->get());
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'code' => ['required'],
            'libelle' => ['required'],
        ], $messages = [
            'code.required' => 'Le code est obligatoire.',
            'libelle.required' => 'Le libelle est obligatoire.',
        ])->validate();

        $line = Service::create($request->all());

        return $line;
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'code' => ['required'],
            'libelle' => ['required'],
        ], $messages = [
            'code.required' => 'Le code est obligatoire.',
            'libelle.required' => 'Le libelle est obligatoire.',
        ])->validate();

        $line = Service::find($id);
        $line->update($request->all());

        return $line;
    }

    public function destroy($id)
    {
        $line = Service::find($id);
        $line->delete();
    }
}
