<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateInterventionuserExecUseCase
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

        $Interventionusers = \App\Models\Interventionuser::find($data['id']);
        $oldInterventionusers = $Interventionusers->replicate();

        $oldCrudData = [];
        $oldCrudData['intervention_id'] = $oldInterventionusers->intervention_id;
        $oldCrudData['user_id'] = $oldInterventionusers->user_id;
        $oldCrudData['statut'] = $oldInterventionusers->statut;
        $oldCrudData['identifiants_sadge'] = $oldInterventionusers->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldInterventionusers->creat_by;
        try {
            $oldCrudData['intervention'] = $oldInterventionusers->intervention->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldInterventionusers->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['intervention_id'])) {
            $Interventionusers->intervention_id = $data['intervention_id'];
        }
        if (!empty($data['user_id'])) {
            $Interventionusers->user_id = $data['user_id'];
        }
        if (!empty($data['statut'])) {
            $Interventionusers->statut = $data['statut'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Interventionusers->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Interventionusers->creat_by = $data['creat_by'];
        }
        $Interventionusers->save();
        $Interventionusers = \App\Models\Interventionuser::find($Interventionusers->id);
        $newCrudData = [];
        $newCrudData['intervention_id'] = $Interventionusers->intervention_id;
        $newCrudData['user_id'] = $Interventionusers->user_id;
        $newCrudData['statut'] = $Interventionusers->statut;
        $newCrudData['identifiants_sadge'] = $Interventionusers->identifiants_sadge;
        $newCrudData['creat_by'] = $Interventionusers->creat_by;
        try {
            $newCrudData['intervention'] = $Interventionusers->intervention->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Interventionusers->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Interventionusers', 'entite_cle' => $Interventionusers->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Interventionusers->toArray();
        return $data;
    }

}
