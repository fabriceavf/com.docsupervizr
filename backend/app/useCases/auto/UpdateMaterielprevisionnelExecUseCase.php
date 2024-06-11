<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateMaterielprevisionnelExecUseCase
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

        $Materielprevisionnels = \App\Models\Materielprevisionnel::find($data['id']);
        $oldMaterielprevisionnels = $Materielprevisionnels->replicate();

        $oldCrudData = [];
        $oldCrudData['materiel_id'] = $oldMaterielprevisionnels->materiel_id;
        $oldCrudData['chantier_id'] = $oldMaterielprevisionnels->chantier_id;
        $oldCrudData['quantite'] = $oldMaterielprevisionnels->quantite;
        $oldCrudData['identifiants_sadge'] = $oldMaterielprevisionnels->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldMaterielprevisionnels->creat_by;
        try {
            $oldCrudData['chantier'] = $oldMaterielprevisionnels->chantier->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['materiel'] = $oldMaterielprevisionnels->materiel->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['materiel_id'])) {
            $Materielprevisionnels->materiel_id = $data['materiel_id'];
        }
        if (!empty($data['chantier_id'])) {
            $Materielprevisionnels->chantier_id = $data['chantier_id'];
        }
        if (!empty($data['quantite'])) {
            $Materielprevisionnels->quantite = $data['quantite'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Materielprevisionnels->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Materielprevisionnels->creat_by = $data['creat_by'];
        }
        $Materielprevisionnels->save();
        $Materielprevisionnels = \App\Models\Materielprevisionnel::find($Materielprevisionnels->id);
        $newCrudData = [];
        $newCrudData['materiel_id'] = $Materielprevisionnels->materiel_id;
        $newCrudData['chantier_id'] = $Materielprevisionnels->chantier_id;
        $newCrudData['quantite'] = $Materielprevisionnels->quantite;
        $newCrudData['identifiants_sadge'] = $Materielprevisionnels->identifiants_sadge;
        $newCrudData['creat_by'] = $Materielprevisionnels->creat_by;
        try {
            $newCrudData['chantier'] = $Materielprevisionnels->chantier->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['materiel'] = $Materielprevisionnels->materiel->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Materielprevisionnels', 'entite_cle' => $Materielprevisionnels->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Materielprevisionnels->toArray();
        return $data;
    }

}
