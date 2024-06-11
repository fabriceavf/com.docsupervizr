<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteApprovisionementdetailExecUseCase
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


        $Approvisionementdetails->deleted_at = now();
        $Approvisionementdetails->save();
        $newCrudData = [];
        $newCrudData['approvisionement_id'] = $Approvisionementdetails->approvisionement_id;
        $newCrudData['quantite'] = $Approvisionementdetails->quantite;
        $newCrudData['identifiants_sadge'] = $Approvisionementdetails->identifiants_sadge;
        $newCrudData['creat_by'] = $Approvisionementdetails->creat_by;
        try {
            $newCrudData['approvisionement'] = $Approvisionementdetails->approvisionement->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Approvisionementdetails', 'entite_cle' => $Approvisionementdetails->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
