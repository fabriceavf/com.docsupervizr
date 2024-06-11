<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteModelslistingExecUseCase
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

        $Modelslistings = \App\Models\Modelslisting::find($data['id']);


        $Modelslistings->deleted_at = now();
        $Modelslistings->save();
        $newCrudData = [];
        $newCrudData['Libelle'] = $Modelslistings->Libelle;
        $newCrudData['postes'] = $Modelslistings->postes;
        $newCrudData['zone_id'] = $Modelslistings->zone_id;
        $newCrudData['faction'] = $Modelslistings->faction;
        $newCrudData['user_id'] = $Modelslistings->user_id;
        $newCrudData['date_debut'] = $Modelslistings->date_debut;
        $newCrudData['min_partage'] = $Modelslistings->min_partage;
        $newCrudData['Generate'] = $Modelslistings->Generate;
        $newCrudData['etats'] = $Modelslistings->etats;
        $newCrudData['user_id_2'] = $Modelslistings->user_id_2;
        $newCrudData['user_id_3'] = $Modelslistings->user_id_3;
        $newCrudData['user_id_4'] = $Modelslistings->user_id_4;
        $newCrudData['identifiants_sadge'] = $Modelslistings->identifiants_sadge;
        $newCrudData['creat_by'] = $Modelslistings->creat_by;
        $newCrudData['typelistings'] = $Modelslistings->typelistings;
        $newCrudData['horaires'] = $Modelslistings->horaires;
        $newCrudData['directions'] = $Modelslistings->directions;
        try {
            $newCrudData['user'] = $Modelslistings->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Modelslistings->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Modelslistings', 'entite_cle' => $Modelslistings->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
