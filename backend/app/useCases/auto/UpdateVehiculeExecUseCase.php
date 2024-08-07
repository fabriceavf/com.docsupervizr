<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateVehiculeExecUseCase
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
        $oldVehicules = $Vehicules->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldVehicules->code;
        $oldCrudData['type'] = $oldVehicules->type;
        $oldCrudData['marque'] = $oldVehicules->marque;
        $oldCrudData['modele'] = $oldVehicules->modele;
        $oldCrudData['generation'] = $oldVehicules->generation;
        $oldCrudData['serie'] = $oldVehicules->serie;
        $oldCrudData['valeur'] = $oldVehicules->valeur;
        $oldCrudData['moteur'] = $oldVehicules->moteur;
        $oldCrudData['poids'] = $oldVehicules->poids;
        $oldCrudData['creat_by'] = $oldVehicules->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldVehicules->identifiants_sadge;


        if (!empty($data['code'])) {
            $Vehicules->code = $data['code'];
        }
        if (!empty($data['type'])) {
            $Vehicules->type = $data['type'];
        }
        if (!empty($data['marque'])) {
            $Vehicules->marque = $data['marque'];
        }
        if (!empty($data['modele'])) {
            $Vehicules->modele = $data['modele'];
        }
        if (!empty($data['generation'])) {
            $Vehicules->generation = $data['generation'];
        }
        if (!empty($data['serie'])) {
            $Vehicules->serie = $data['serie'];
        }
        if (!empty($data['valeur'])) {
            $Vehicules->valeur = $data['valeur'];
        }
        if (!empty($data['moteur'])) {
            $Vehicules->moteur = $data['moteur'];
        }
        if (!empty($data['poids'])) {
            $Vehicules->poids = $data['poids'];
        }
        if (!empty($data['creat_by'])) {
            $Vehicules->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Vehicules->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Vehicules->save();
        $Vehicules = \App\Models\Vehicule::find($Vehicules->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Vehicules', 'entite_cle' => $Vehicules->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Vehicules->toArray();
        return $data;
    }

}
