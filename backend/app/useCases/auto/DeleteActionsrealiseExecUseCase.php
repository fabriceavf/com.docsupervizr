<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteActionsrealiseExecUseCase
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

        $Actionsrealises = \App\Models\Actionsrealise::find($data['id']);


        $Actionsrealises->deleted_at = now();
        $Actionsrealises->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Actionsrealises', 'entite_cle' => $Actionsrealises->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
