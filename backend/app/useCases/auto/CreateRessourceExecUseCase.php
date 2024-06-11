<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateRessourceExecUseCase
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

        $Ressources = new \App\Models\Ressource();

        if (!empty($data['type'])) {
            $Ressources->type = $data['type'];
        }
        if (!empty($data['cle'])) {
            $Ressources->cle = $data['cle'];
        }
        if (!empty($data['valeur'])) {
            $Ressources->valeur = $data['valeur'];
        }
        if (!empty($data['activite_id'])) {
            $Ressources->activite_id = $data['activite_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Ressources->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Ressources->creat_by = $data['creat_by'];
        }
        $Ressources->save();
        $Ressources = \App\Models\Ressource::find($Ressources->id);
        $newCrudData = [];
        $newCrudData['type'] = $Ressources->type;
        $newCrudData['cle'] = $Ressources->cle;
        $newCrudData['valeur'] = $Ressources->valeur;
        $newCrudData['activite_id'] = $Ressources->activite_id;
        $newCrudData['identifiants_sadge'] = $Ressources->identifiants_sadge;
        $newCrudData['creat_by'] = $Ressources->creat_by;
        try {
            $newCrudData['activite'] = $Ressources->activite->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Ressources', 'entite_cle' => $Ressources->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Ressources->toArray();
        return $data;
    }

}
