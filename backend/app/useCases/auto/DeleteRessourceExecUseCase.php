<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteRessourceExecUseCase
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

        $Ressources = \App\Models\Ressource::find($data['id']);


        $Ressources->deleted_at = now();
        $Ressources->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Ressources', 'entite_cle' => $Ressources->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
