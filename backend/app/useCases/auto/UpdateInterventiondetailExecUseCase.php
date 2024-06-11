<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateInterventiondetailExecUseCase
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

        $Interventiondetails = \App\Models\Interventiondetail::find($data['id']);
        $oldInterventiondetails = $Interventiondetails->replicate();

        $oldCrudData = [];
        $oldCrudData['interventionuser_id'] = $oldInterventiondetails->interventionuser_id;
        $oldCrudData['jour'] = $oldInterventiondetails->jour;
        $oldCrudData['debut'] = $oldInterventiondetails->debut;
        $oldCrudData['fin'] = $oldInterventiondetails->fin;
        $oldCrudData['identifiants_sadge'] = $oldInterventiondetails->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldInterventiondetails->creat_by;
        try {
            $oldCrudData['interventionuser'] = $oldInterventiondetails->interventionuser->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['interventionuser_id'])) {
            $Interventiondetails->interventionuser_id = $data['interventionuser_id'];
        }
        if (!empty($data['jour'])) {
            $Interventiondetails->jour = $data['jour'];
        }
        if (!empty($data['debut'])) {
            $Interventiondetails->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Interventiondetails->fin = $data['fin'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Interventiondetails->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Interventiondetails->creat_by = $data['creat_by'];
        }
        $Interventiondetails->save();
        $Interventiondetails = \App\Models\Interventiondetail::find($Interventiondetails->id);
        $newCrudData = [];
        $newCrudData['interventionuser_id'] = $Interventiondetails->interventionuser_id;
        $newCrudData['jour'] = $Interventiondetails->jour;
        $newCrudData['debut'] = $Interventiondetails->debut;
        $newCrudData['fin'] = $Interventiondetails->fin;
        $newCrudData['identifiants_sadge'] = $Interventiondetails->identifiants_sadge;
        $newCrudData['creat_by'] = $Interventiondetails->creat_by;
        try {
            $newCrudData['interventionuser'] = $Interventiondetails->interventionuser->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Interventiondetails', 'entite_cle' => $Interventiondetails->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Interventiondetails->toArray();
        return $data;
    }

}
