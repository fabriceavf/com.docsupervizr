<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateApprovisionementdetailExecUseCase
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

        $Approvisionementdetails = \App\Models\Approvisionementdetail::find($data['id']);
        $oldApprovisionementdetails = $Approvisionementdetails->replicate();

        $oldCrudData = [];
        $oldCrudData['approvisionement_id'] = $oldApprovisionementdetails->approvisionement_id;
        $oldCrudData['quantite'] = $oldApprovisionementdetails->quantite;
        $oldCrudData['identifiants_sadge'] = $oldApprovisionementdetails->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldApprovisionementdetails->creat_by;
        try {
            $oldCrudData['approvisionement'] = $oldApprovisionementdetails->approvisionement->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['approvisionement_id'])) {
            $Approvisionementdetails->approvisionement_id = $data['approvisionement_id'];
        }
        if (!empty($data['quantite'])) {
            $Approvisionementdetails->quantite = $data['quantite'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Approvisionementdetails->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Approvisionementdetails->creat_by = $data['creat_by'];
        }
        $Approvisionementdetails->save();
        $Approvisionementdetails = \App\Models\Approvisionementdetail::find($Approvisionementdetails->id);
        $newCrudData = [];
        $newCrudData['approvisionement_id'] = $Approvisionementdetails->approvisionement_id;
        $newCrudData['quantite'] = $Approvisionementdetails->quantite;
        $newCrudData['identifiants_sadge'] = $Approvisionementdetails->identifiants_sadge;
        $newCrudData['creat_by'] = $Approvisionementdetails->creat_by;
        try {
            $newCrudData['approvisionement'] = $Approvisionementdetails->approvisionement->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Approvisionementdetails', 'entite_cle' => $Approvisionementdetails->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Approvisionementdetails->toArray();
        return $data;
    }

}
