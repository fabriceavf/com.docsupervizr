<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteExportsdetailExecUseCase
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

        $Exportsdetails = \App\Models\Exportsdetail::find($data['id']);


        $Exportsdetails->deleted_at = now();
        $Exportsdetails->save();
        $newCrudData = [];
        $newCrudData['export_id'] = $Exportsdetails->export_id;
        $newCrudData['creat_by'] = $Exportsdetails->creat_by;
        $newCrudData['identifiants_sadge'] = $Exportsdetails->identifiants_sadge;
        try {
            $newCrudData['export'] = $Exportsdetails->export->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Exportsdetails', 'entite_cle' => $Exportsdetails->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
