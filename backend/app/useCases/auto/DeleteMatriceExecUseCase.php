<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteMatriceExecUseCase
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

        $Matrices = \App\Models\Matrice::find($data['id']);


        $Matrices->deleted_at = now();
        $Matrices->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Matrices->libelle;
        $newCrudData['date_debut'] = $Matrices->date_debut;
        $newCrudData['date_fin'] = $Matrices->date_fin;
        $newCrudData['etats'] = $Matrices->etats;
        $newCrudData['identifiants_sadge'] = $Matrices->identifiants_sadge;
        $newCrudData['creat_by'] = $Matrices->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Matrices', 'entite_cle' => $Matrices->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
