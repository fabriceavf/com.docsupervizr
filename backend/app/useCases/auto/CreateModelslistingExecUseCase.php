<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateModelslistingExecUseCase
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

        $Modelslistings = new \App\Models\Modelslisting();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Modelslistings', 'entite_cle' => $Modelslistings->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Modelslistings->toArray();
        return $data;
    }

}
