<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteInterventionuserExecUseCase
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


        $Interventionusers->deleted_at = now();
        $Interventionusers->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Interventionusers', 'entite_cle' => $Interventionusers->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
