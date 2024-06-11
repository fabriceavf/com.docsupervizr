<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateVoitureExecUseCase
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

        $Voitures = new \App\Models\Voiture();

        if (!empty($data['code'])) {
            $Voitures->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Voitures->libelle = $data['libelle'];
        }
        if (!empty($data['plaque'])) {
            $Voitures->plaque = $data['plaque'];
        }
        if (!empty($data['capacite'])) {
            $Voitures->capacite = $data['capacite'];
        }
        if (!empty($data['creat_by'])) {
            $Voitures->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Voitures->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Voitures->save();
        $Voitures = \App\Models\Voiture::find($Voitures->id);
        $newCrudData = [];
        $newCrudData['code'] = $Voitures->code;
        $newCrudData['libelle'] = $Voitures->libelle;
        $newCrudData['plaque'] = $Voitures->plaque;
        $newCrudData['capacite'] = $Voitures->capacite;
        $newCrudData['creat_by'] = $Voitures->creat_by;
        $newCrudData['identifiants_sadge'] = $Voitures->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Voitures', 'entite_cle' => $Voitures->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Voitures->toArray();
        return $data;
    }

}
