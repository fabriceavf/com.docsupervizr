<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateActionsrealiseExecUseCase
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

        $Actionsrealises = new \App\Models\Actionsrealise();

        if (!empty($data['libelle'])) {
            $Actionsrealises->libelle = $data['libelle'];
        }
        if (!empty($data['descriptions'])) {
            $Actionsrealises->descriptions = $data['descriptions'];
        }
        if (!empty($data['debut_previsionnel'])) {
            $Actionsrealises->debut_previsionnel = $data['debut_previsionnel'];
        }
        if (!empty($data['fin_previsionnel'])) {
            $Actionsrealises->fin_previsionnel = $data['fin_previsionnel'];
        }
        if (!empty($data['debut_reel'])) {
            $Actionsrealises->debut_reel = $data['debut_reel'];
        }
        if (!empty($data['fin_reel'])) {
            $Actionsrealises->fin_reel = $data['fin_reel'];
        }
        if (!empty($data['actionsprevisionelle_id'])) {
            $Actionsrealises->actionsprevisionelle_id = $data['actionsprevisionelle_id'];
        }
        if (!empty($data['creat_by'])) {
            $Actionsrealises->creat_by = $data['creat_by'];
        }
        if (!empty($data['evaluation'])) {
            $Actionsrealises->evaluation = $data['evaluation'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Actionsrealises->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Actionsrealises->save();
        $Actionsrealises = \App\Models\Actionsrealise::find($Actionsrealises->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Actionsrealises->libelle;
        $newCrudData['descriptions'] = $Actionsrealises->descriptions;
        $newCrudData['debut_previsionnel'] = $Actionsrealises->debut_previsionnel;
        $newCrudData['fin_previsionnel'] = $Actionsrealises->fin_previsionnel;
        $newCrudData['debut_reel'] = $Actionsrealises->debut_reel;
        $newCrudData['fin_reel'] = $Actionsrealises->fin_reel;
        $newCrudData['actionsprevisionelle_id'] = $Actionsrealises->actionsprevisionelle_id;
        $newCrudData['creat_by'] = $Actionsrealises->creat_by;
        $newCrudData['evaluation'] = $Actionsrealises->evaluation;
        $newCrudData['identifiants_sadge'] = $Actionsrealises->identifiants_sadge;
        try {
            $newCrudData['actionsprevisionelle'] = $Actionsrealises->actionsprevisionelle->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Actionsrealises', 'entite_cle' => $Actionsrealises->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Actionsrealises->toArray();
        return $data;
    }

}
