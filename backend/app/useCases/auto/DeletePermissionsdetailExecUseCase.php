<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePermissionsdetailExecUseCase
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

        $Permissionsdetails = \App\Models\Permissionsdetail::find($data['id']);


        $Permissionsdetails->deleted_at = now();
        $Permissionsdetails->save();
        $newCrudData = [];
        $newCrudData['action'] = $Permissionsdetails->action;
        $newCrudData['table'] = $Permissionsdetails->table;
        $newCrudData['creat_by'] = $Permissionsdetails->creat_by;
        $newCrudData['user_id'] = $Permissionsdetails->user_id;
        $newCrudData['identifiants_sadge'] = $Permissionsdetails->identifiants_sadge;
        try {
            $newCrudData['user'] = $Permissionsdetails->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Permissionsdetails', 'entite_cle' => $Permissionsdetails->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
