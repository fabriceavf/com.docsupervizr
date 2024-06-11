<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteProjetExecUseCase
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

        $Projets = \App\Models\Projet::find($data['id']);


        $Projets->deleted_at = now();
        $Projets->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Projets->libelle;
        $newCrudData['descriptions'] = $Projets->descriptions;
        $newCrudData['debut_previsionnel'] = $Projets->debut_previsionnel;
        $newCrudData['fin_previsionnel'] = $Projets->fin_previsionnel;
        $newCrudData['debut_reel'] = $Projets->debut_reel;
        $newCrudData['fin_reel'] = $Projets->fin_reel;
        $newCrudData['creat_by'] = $Projets->creat_by;
        $newCrudData['identifiants_sadge'] = $Projets->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Projets', 'entite_cle' => $Projets->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
