<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateActionsprevisionelleExecUseCase
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

        $Actionsprevisionelles = \App\Models\Actionsprevisionelle::find($data['id']);
        $oldActionsprevisionelles = $Actionsprevisionelles->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldActionsprevisionelles->libelle;
        $oldCrudData['descriptions'] = $oldActionsprevisionelles->descriptions;
        $oldCrudData['debut_previsionnel'] = $oldActionsprevisionelles->debut_previsionnel;
        $oldCrudData['fin_previsionnel'] = $oldActionsprevisionelles->fin_previsionnel;
        $oldCrudData['debut_reel'] = $oldActionsprevisionelles->debut_reel;
        $oldCrudData['fin_reel'] = $oldActionsprevisionelles->fin_reel;
        $oldCrudData['besoin_id'] = $oldActionsprevisionelles->besoin_id;
        $oldCrudData['creat_by'] = $oldActionsprevisionelles->creat_by;
        $oldCrudData['evaluation'] = $oldActionsprevisionelles->evaluation;
        $oldCrudData['valider'] = $oldActionsprevisionelles->valider;
        $oldCrudData['type'] = $oldActionsprevisionelles->type;
        $oldCrudData['identifiants_sadge'] = $oldActionsprevisionelles->identifiants_sadge;
        try {
            $oldCrudData['besoin'] = $oldActionsprevisionelles->besoin->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Actionsprevisionelles->libelle = $data['libelle'];
        }
        if (!empty($data['descriptions'])) {
            $Actionsprevisionelles->descriptions = $data['descriptions'];
        }
        if (!empty($data['debut_previsionnel'])) {
            $Actionsprevisionelles->debut_previsionnel = $data['debut_previsionnel'];
        }
        if (!empty($data['fin_previsionnel'])) {
            $Actionsprevisionelles->fin_previsionnel = $data['fin_previsionnel'];
        }
        if (!empty($data['debut_reel'])) {
            $Actionsprevisionelles->debut_reel = $data['debut_reel'];
        }
        if (!empty($data['fin_reel'])) {
            $Actionsprevisionelles->fin_reel = $data['fin_reel'];
        }
        if (!empty($data['besoin_id'])) {
            $Actionsprevisionelles->besoin_id = $data['besoin_id'];
        }
        if (!empty($data['creat_by'])) {
            $Actionsprevisionelles->creat_by = $data['creat_by'];
        }
        if (!empty($data['evaluation'])) {
            $Actionsprevisionelles->evaluation = $data['evaluation'];
        }
        if (!empty($data['valider'])) {
            $Actionsprevisionelles->valider = $data['valider'];
        }
        if (!empty($data['type'])) {
            $Actionsprevisionelles->type = $data['type'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Actionsprevisionelles->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Actionsprevisionelles->save();
        $Actionsprevisionelles = \App\Models\Actionsprevisionelle::find($Actionsprevisionelles->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Actionsprevisionelles->libelle;
        $newCrudData['descriptions'] = $Actionsprevisionelles->descriptions;
        $newCrudData['debut_previsionnel'] = $Actionsprevisionelles->debut_previsionnel;
        $newCrudData['fin_previsionnel'] = $Actionsprevisionelles->fin_previsionnel;
        $newCrudData['debut_reel'] = $Actionsprevisionelles->debut_reel;
        $newCrudData['fin_reel'] = $Actionsprevisionelles->fin_reel;
        $newCrudData['besoin_id'] = $Actionsprevisionelles->besoin_id;
        $newCrudData['creat_by'] = $Actionsprevisionelles->creat_by;
        $newCrudData['evaluation'] = $Actionsprevisionelles->evaluation;
        $newCrudData['valider'] = $Actionsprevisionelles->valider;
        $newCrudData['type'] = $Actionsprevisionelles->type;
        $newCrudData['identifiants_sadge'] = $Actionsprevisionelles->identifiants_sadge;
        try {
            $newCrudData['besoin'] = $Actionsprevisionelles->besoin->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Actionsprevisionelles', 'entite_cle' => $Actionsprevisionelles->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Actionsprevisionelles->toArray();
        return $data;
    }

}
