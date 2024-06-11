<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteVoitureExecUseCase
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

        $Voitures = \App\Models\Voiture::find($data['id']);


        $Voitures->deleted_at = now();
        $Voitures->save();
        $newCrudData = [];
        $newCrudData['code'] = $Voitures->code;
        $newCrudData['libelle'] = $Voitures->libelle;
        $newCrudData['plaque'] = $Voitures->plaque;
        $newCrudData['capacite'] = $Voitures->capacite;
        $newCrudData['creat_by'] = $Voitures->creat_by;
        $newCrudData['identifiants_sadge'] = $Voitures->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Voitures', 'entite_cle' => $Voitures->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
