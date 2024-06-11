<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateLigneExecUseCase
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

        $Lignes = \App\Models\Ligne::find($data['id']);
        $oldLignes = $Lignes->replicate();

        $oldCrudData = [];
        $oldCrudData['ville_id'] = $oldLignes->ville_id;
        $oldCrudData['code'] = $oldLignes->code;
        $oldCrudData['libelle'] = $oldLignes->libelle;
        $oldCrudData['tarifs'] = $oldLignes->tarifs;
        $oldCrudData['creat_by'] = $oldLignes->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldLignes->identifiants_sadge;
        try {
            $oldCrudData['ville'] = $oldLignes->ville->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['ville_id'])) {
            $Lignes->ville_id = $data['ville_id'];
        }
        if (!empty($data['code'])) {
            $Lignes->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Lignes->libelle = $data['libelle'];
        }
        if (!empty($data['tarifs'])) {
            $Lignes->tarifs = $data['tarifs'];
        }
        if (!empty($data['creat_by'])) {
            $Lignes->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Lignes->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Lignes->save();
        $Lignes = \App\Models\Ligne::find($Lignes->id);
        $newCrudData = [];
        $newCrudData['ville_id'] = $Lignes->ville_id;
        $newCrudData['code'] = $Lignes->code;
        $newCrudData['libelle'] = $Lignes->libelle;
        $newCrudData['tarifs'] = $Lignes->tarifs;
        $newCrudData['creat_by'] = $Lignes->creat_by;
        $newCrudData['identifiants_sadge'] = $Lignes->identifiants_sadge;
        try {
            $newCrudData['ville'] = $Lignes->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Lignes', 'entite_cle' => $Lignes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Lignes->toArray();
        return $data;
    }

}
