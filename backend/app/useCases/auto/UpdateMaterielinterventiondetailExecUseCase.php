<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateMaterielinterventiondetailExecUseCase
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
        $oldMaterielinterventiondetails = $Materielinterventiondetails->replicate();

        $oldCrudData = [];
        $oldCrudData['materiel_id'] = $oldMaterielinterventiondetails->materiel_id;
        $oldCrudData['materielintervention_id'] = $oldMaterielinterventiondetails->materielintervention_id;
        $oldCrudData['quantite'] = $oldMaterielinterventiondetails->quantite;
        $oldCrudData['identifiants_sadge'] = $oldMaterielinterventiondetails->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldMaterielinterventiondetails->creat_by;
        try {
            $oldCrudData['materielintervention'] = $oldMaterielinterventiondetails->materielintervention->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['materiel'] = $oldMaterielinterventiondetails->materiel->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['materiel_id'])) {
            $Materielinterventiondetails->materiel_id = $data['materiel_id'];
        }
        if (!empty($data['materielintervention_id'])) {
            $Materielinterventiondetails->materielintervention_id = $data['materielintervention_id'];
        }
        if (!empty($data['quantite'])) {
            $Materielinterventiondetails->quantite = $data['quantite'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Materielinterventiondetails->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Materielinterventiondetails->creat_by = $data['creat_by'];
        }
        $Materielinterventiondetails->save();
        $Materielinterventiondetails = \App\Models\Materielinterventiondetail::find($Materielinterventiondetails->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Materielinterventiondetails', 'entite_cle' => $Materielinterventiondetails->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Materielinterventiondetails->toArray();
        return $data;
    }

}
