<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteChantierExecUseCase
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

        $Chantiers = \App\Models\Chantier::find($data['id']);


        $Chantiers->deleted_at = now();
        $Chantiers->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Chantiers->libelle;
        $newCrudData['couleur'] = $Chantiers->couleur;
        $newCrudData['debut_prevus'] = $Chantiers->debut_prevus;
        $newCrudData['fin_prevus'] = $Chantiers->fin_prevus;
        $newCrudData['debut_effectif'] = $Chantiers->debut_effectif;
        $newCrudData['fin_effectif'] = $Chantiers->fin_effectif;
        $newCrudData['identifiants_sadge'] = $Chantiers->identifiants_sadge;
        $newCrudData['creat_by'] = $Chantiers->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Chantiers', 'entite_cle' => $Chantiers->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
