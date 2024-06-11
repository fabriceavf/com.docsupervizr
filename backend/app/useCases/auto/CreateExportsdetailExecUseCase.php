<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateExportsdetailExecUseCase
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

        $Exportsdetails = new \App\Models\Exportsdetail();

        if (!empty($data['export_id'])) {
            $Exportsdetails->export_id = $data['export_id'];
        }
        if (!empty($data['creat_by'])) {
            $Exportsdetails->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Exportsdetails->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Exportsdetails->save();
        $Exportsdetails = \App\Models\Exportsdetail::find($Exportsdetails->id);
        $newCrudData = [];
        $newCrudData['export_id'] = $Exportsdetails->export_id;
        $newCrudData['creat_by'] = $Exportsdetails->creat_by;
        $newCrudData['identifiants_sadge'] = $Exportsdetails->identifiants_sadge;
        try {
            $newCrudData['export'] = $Exportsdetails->export->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Exportsdetails', 'entite_cle' => $Exportsdetails->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Exportsdetails->toArray();
        return $data;
    }

}
