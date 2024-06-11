<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteInterventiondetailExecUseCase
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


        $Interventiondetails->deleted_at = now();
        $Interventiondetails->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Interventiondetails', 'entite_cle' => $Interventiondetails->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
