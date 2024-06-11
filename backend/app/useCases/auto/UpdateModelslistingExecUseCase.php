<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateModelslistingExecUseCase
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
        $oldModelslistings = $Modelslistings->replicate();

        $oldCrudData = [];
        $oldCrudData['Libelle'] = $oldModelslistings->Libelle;
        $oldCrudData['postes'] = $oldModelslistings->postes;
        $oldCrudData['zone_id'] = $oldModelslistings->zone_id;
        $oldCrudData['faction'] = $oldModelslistings->faction;
        $oldCrudData['user_id'] = $oldModelslistings->user_id;
        $oldCrudData['date_debut'] = $oldModelslistings->date_debut;
        $oldCrudData['min_partage'] = $oldModelslistings->min_partage;
        $oldCrudData['Generate'] = $oldModelslistings->Generate;
        $oldCrudData['etats'] = $oldModelslistings->etats;
        $oldCrudData['user_id_2'] = $oldModelslistings->user_id_2;
        $oldCrudData['user_id_3'] = $oldModelslistings->user_id_3;
        $oldCrudData['user_id_4'] = $oldModelslistings->user_id_4;
        $oldCrudData['identifiants_sadge'] = $oldModelslistings->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldModelslistings->creat_by;
        $oldCrudData['typelistings'] = $oldModelslistings->typelistings;
        $oldCrudData['horaires'] = $oldModelslistings->horaires;
        $oldCrudData['directions'] = $oldModelslistings->directions;
        try {
            $oldCrudData['user'] = $oldModelslistings->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $oldModelslistings->zone->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['Libelle'])) {
            $Modelslistings->Libelle = $data['Libelle'];
        }
        if (!empty($data['postes'])) {
            $Modelslistings->postes = $data['postes'];
        }
        if (!empty($data['zone_id'])) {
            $Modelslistings->zone_id = $data['zone_id'];
        }
        if (!empty($data['faction'])) {
            $Modelslistings->faction = $data['faction'];
        }
        if (!empty($data['user_id'])) {
            $Modelslistings->user_id = $data['user_id'];
        }
        if (!empty($data['date_debut'])) {
            $Modelslistings->date_debut = $data['date_debut'];
        }
        if (!empty($data['min_partage'])) {
            $Modelslistings->min_partage = $data['min_partage'];
        }
        if (!empty($data['Generate'])) {
            $Modelslistings->Generate = $data['Generate'];
        }
        if (!empty($data['etats'])) {
            $Modelslistings->etats = $data['etats'];
        }
        if (!empty($data['user_id_2'])) {
            $Modelslistings->user_id_2 = $data['user_id_2'];
        }
        if (!empty($data['user_id_3'])) {
            $Modelslistings->user_id_3 = $data['user_id_3'];
        }
        if (!empty($data['user_id_4'])) {
            $Modelslistings->user_id_4 = $data['user_id_4'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Modelslistings->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Modelslistings->creat_by = $data['creat_by'];
        }
        if (!empty($data['typelistings'])) {
            $Modelslistings->typelistings = $data['typelistings'];
        }
        if (!empty($data['horaires'])) {
            $Modelslistings->horaires = $data['horaires'];
        }
        if (!empty($data['directions'])) {
            $Modelslistings->directions = $data['directions'];
        }
        $Modelslistings->save();
        $Modelslistings = \App\Models\Modelslisting::find($Modelslistings->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Modelslistings', 'entite_cle' => $Modelslistings->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Modelslistings->toArray();
        return $data;
    }

}
