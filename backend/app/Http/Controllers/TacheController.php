<?php

namespace App\Http\Controllers;

use App\Models\Horaire;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TacheController extends Controller
{
    public function index()
    {
        return response()
            ->json($Table = Tache::orderBy('libelle', 'ASC')->get());
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'type' => ['required'],
            'libelle' => ['required'],
            'ville_id' => ['required'],
        ], $messages = [
            'code.required' => 'Le code est obligatoire.',
            'libelle.required' => 'Le libelle est obligatoire.',
            'ville.required' => 'La ville est obligatoire.',
        ])->validate();

        $line = Tache::create($request->all());

        return $line;
    }

    public function destroy($id)
    {
        $line = Tache::find($id);
        $line->delete();
    }

    public function get_hours($id)
    {
        $line = Tache::find($id);
        return $line->horaires;
    }

    public function store_hour(Request $request)
    {
        Validator::make($request->all(), [
            'libelle' => ['required'],
            'debut' => ['required'],
            'fin' => ['required'],
            'ecart_debut' => ['required'],
            'ecart_fin' => ['required'],
            'tache_id' => ['required'],
        ], $messages = [
            'libelle.required' => 'Le libelle est obligatoire.',
            'debut.required' => 'Le debut est obligatoire.',
            'fin.required' => 'La fin est obligatoire.',
            'ecart_debut.required' => 'L\'ecrat authorisez au debut est obligatoire.',
            'ecart_fin.required' => 'L\'ecrat authorisez a la fin est obligatoire.',
        ])->validate();

        $line = Horaire::create($request->all());

        return $line;
    }

    public function update_hour(Request $request, $id)
    {
        Validator::make($request->all(), [
            'libelle' => ['required'],
            'debut' => ['required'],
            'fin' => ['required'],
            'ecart_debut' => ['required'],
            'ecart_fin' => ['required'],
            'tache_id' => ['required'],
        ], $messages = [
            'libelle.required' => 'Le libelle est obligatoire.',
            'debut.required' => 'Le debut est obligatoire.',
            'fin.required' => 'La fin est obligatoire.',
            'ecart_debut.required' => 'L\'ecrat authorisez au debut est obligatoire.',
            'ecart_fin.required' => 'L\'ecrat authorisez a la fin est obligatoire.',
        ])->validate();

        $line = Horaire::find($id);
        $line->update($request->all());

        return $line;
    }

    public function update(Request $request, $id)
    {
//        dd('test');
        Validator::make($request->all(), [
            'type' => ['required'],
            'libelle' => ['required'],
            'ville_id' => ['required'],
        ], $messages = [
            'code.required' => 'Le code est obligatoire.',
            'libelle.required' => 'Le libelle est obligatoire.',
            'ville.required' => 'La ville est obligatoire.',
        ])->validate();

        $line = Tache::find($id);
        $line->update($request->all());

        return $line;
    }

    public function destroy_hour($id)
    {
        $line = Horaire::find($id);
        $line->delete();
    }
}
