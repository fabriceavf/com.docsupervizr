<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateChantierExecUseCase
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

        $Chantiers = \App\Models\Chantier::find($data['id']);
        $oldChantiers = $Chantiers->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldChantiers->libelle;
        $oldCrudData['couleur'] = $oldChantiers->couleur;
        $oldCrudData['debut_prevus'] = $oldChantiers->debut_prevus;
        $oldCrudData['fin_prevus'] = $oldChantiers->fin_prevus;
        $oldCrudData['debut_effectif'] = $oldChantiers->debut_effectif;
        $oldCrudData['fin_effectif'] = $oldChantiers->fin_effectif;
        $oldCrudData['identifiants_sadge'] = $oldChantiers->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldChantiers->creat_by;


        if (!empty($data['libelle'])) {
            $Chantiers->libelle = $data['libelle'];
        }
        if (!empty($data['couleur'])) {
            $Chantiers->couleur = $data['couleur'];
        }
        if (!empty($data['debut_prevus'])) {
            $Chantiers->debut_prevus = $data['debut_prevus'];
        }
        if (!empty($data['fin_prevus'])) {
            $Chantiers->fin_prevus = $data['fin_prevus'];
        }
        if (!empty($data['debut_effectif'])) {
            $Chantiers->debut_effectif = $data['debut_effectif'];
        }
        if (!empty($data['fin_effectif'])) {
            $Chantiers->fin_effectif = $data['fin_effectif'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Chantiers->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Chantiers->creat_by = $data['creat_by'];
        }
        $Chantiers->save();
        $Chantiers = \App\Models\Chantier::find($Chantiers->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Chantiers->libelle;
        $newCrudData['couleur'] = $Chantiers->couleur;
        $newCrudData['debut_prevus'] = $Chantiers->debut_prevus;
        $newCrudData['fin_prevus'] = $Chantiers->fin_prevus;
        $newCrudData['debut_effectif'] = $Chantiers->debut_effectif;
        $newCrudData['fin_effectif'] = $Chantiers->fin_effectif;
        $newCrudData['identifiants_sadge'] = $Chantiers->identifiants_sadge;
        $newCrudData['creat_by'] = $Chantiers->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Chantiers', 'entite_cle' => $Chantiers->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Chantiers->toArray();
        return $data;
    }

}
