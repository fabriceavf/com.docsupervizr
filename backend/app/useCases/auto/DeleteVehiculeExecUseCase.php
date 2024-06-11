<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteVehiculeExecUseCase
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

        $Vehicules = \App\Models\Vehicule::find($data['id']);


        $Vehicules->deleted_at = now();
        $Vehicules->save();
        $newCrudData = [];
        $newCrudData['code'] = $Vehicules->code;
        $newCrudData['type'] = $Vehicules->type;
        $newCrudData['marque'] = $Vehicules->marque;
        $newCrudData['modele'] = $Vehicules->modele;
        $newCrudData['generation'] = $Vehicules->generation;
        $newCrudData['serie'] = $Vehicules->serie;
        $newCrudData['valeur'] = $Vehicules->valeur;
        $newCrudData['moteur'] = $Vehicules->moteur;
        $newCrudData['poids'] = $Vehicules->poids;
        $newCrudData['creat_by'] = $Vehicules->creat_by;
        $newCrudData['identifiants_sadge'] = $Vehicules->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Vehicules', 'entite_cle' => $Vehicules->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
