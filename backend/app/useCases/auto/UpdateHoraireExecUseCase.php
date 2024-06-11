<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateHoraireExecUseCase
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

        $Horaires = \App\Models\Horaire::find($data['id']);
        $oldHoraires = $Horaires->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldHoraires->libelle;
        $oldCrudData['debut'] = $oldHoraires->debut;
        $oldCrudData['fin'] = $oldHoraires->fin;
        $oldCrudData['tolerance'] = $oldHoraires->tolerance;
        $oldCrudData['type'] = $oldHoraires->type;
        $oldCrudData['parent'] = $oldHoraires->parent;
        $oldCrudData['parentId'] = $oldHoraires->parentId;
        $oldCrudData['vol_horaire_min'] = $oldHoraires->vol_horaire_min;
        $oldCrudData['nmb_pointage_min'] = $oldHoraires->nmb_pointage_min;
        $oldCrudData['identifiants_sadge'] = $oldHoraires->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldHoraires->creat_by;
        $oldCrudData['poste_id'] = $oldHoraires->poste_id;
        try {
            $oldCrudData['poste'] = $oldHoraires->poste->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Horaires->libelle = $data['libelle'];
        }
        if (!empty($data['debut'])) {
            $Horaires->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Horaires->fin = $data['fin'];
        }
        if (!empty($data['tolerance'])) {
            $Horaires->tolerance = $data['tolerance'];
        }
        if (!empty($data['type'])) {
            $Horaires->type = $data['type'];
        }
        if (!empty($data['parent'])) {
            $Horaires->parent = $data['parent'];
        }
        if (!empty($data['parentId'])) {
            $Horaires->parentId = $data['parentId'];
        }
        if (!empty($data['vol_horaire_min'])) {
            $Horaires->vol_horaire_min = $data['vol_horaire_min'];
        }
        if (!empty($data['nmb_pointage_min'])) {
            $Horaires->nmb_pointage_min = $data['nmb_pointage_min'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Horaires->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Horaires->creat_by = $data['creat_by'];
        }
        if (!empty($data['poste_id'])) {
            $Horaires->poste_id = $data['poste_id'];
        }
        $Horaires->save();
        $Horaires = \App\Models\Horaire::find($Horaires->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Horaires->libelle;
        $newCrudData['debut'] = $Horaires->debut;
        $newCrudData['fin'] = $Horaires->fin;
        $newCrudData['tolerance'] = $Horaires->tolerance;
        $newCrudData['type'] = $Horaires->type;
        $newCrudData['parent'] = $Horaires->parent;
        $newCrudData['parentId'] = $Horaires->parentId;
        $newCrudData['vol_horaire_min'] = $Horaires->vol_horaire_min;
        $newCrudData['nmb_pointage_min'] = $Horaires->nmb_pointage_min;
        $newCrudData['identifiants_sadge'] = $Horaires->identifiants_sadge;
        $newCrudData['creat_by'] = $Horaires->creat_by;
        $newCrudData['poste_id'] = $Horaires->poste_id;
        try {
            $newCrudData['poste'] = $Horaires->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Horaires', 'entite_cle' => $Horaires->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Horaires->toArray();
        return $data;
    }

}
