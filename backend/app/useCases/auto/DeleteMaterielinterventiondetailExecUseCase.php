<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteMaterielinterventiondetailExecUseCase
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

        $Materielinterventiondetails = \App\Models\Materielinterventiondetail::find($data['id']);


        $Materielinterventiondetails->deleted_at = now();
        $Materielinterventiondetails->save();
        $newCrudData = [];
        $newCrudData['materiel_id'] = $Materielinterventiondetails->materiel_id;
        $newCrudData['materielintervention_id'] = $Materielinterventiondetails->materielintervention_id;
        $newCrudData['quantite'] = $Materielinterventiondetails->quantite;
        $newCrudData['identifiants_sadge'] = $Materielinterventiondetails->identifiants_sadge;
        $newCrudData['creat_by'] = $Materielinterventiondetails->creat_by;
        try {
            $newCrudData['materielintervention'] = $Materielinterventiondetails->materielintervention->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['materiel'] = $Materielinterventiondetails->materiel->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Materielinterventiondetails', 'entite_cle' => $Materielinterventiondetails->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
