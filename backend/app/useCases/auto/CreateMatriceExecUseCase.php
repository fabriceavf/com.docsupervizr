<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateMatriceExecUseCase
{
    public static function getInput()
    {

    }

    public static function getOutput()
    {

    }

    public static function exec($data)
    {

        $data['__headers__'] = $request->headers->all();
        $data['__authId__'] = Auth::id();
        $data['__ip__'] = $request->ip();
        $data['creat_by'] = Auth::id();

        $Matrices = new \App\Models\Matrice();

        if (!empty($data['libelle'])) {
            $Matrices->libelle = $data['libelle'];
        }
        if (!empty($data['date_debut'])) {
            $Matrices->date_debut = $data['date_debut'];
        }
        if (!empty($data['date_fin'])) {
            $Matrices->date_fin = $data['date_fin'];
        }
        if (!empty($data['etats'])) {
            $Matrices->etats = $data['etats'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Matrices->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Matrices->creat_by = $data['creat_by'];
        }
        $Matrices->save();
        $Matrices = \App\Models\Matrice::find($Matrices->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Matrices->libelle;
        $newCrudData['date_debut'] = $Matrices->date_debut;
        $newCrudData['date_fin'] = $Matrices->date_fin;
        $newCrudData['etats'] = $Matrices->etats;
        $newCrudData['identifiants_sadge'] = $Matrices->identifiants_sadge;
        $newCrudData['creat_by'] = $Matrices->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Matrices', 'entite_cle' => $Matrices->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Matrices->toArray();
        return $data;
    }

}
