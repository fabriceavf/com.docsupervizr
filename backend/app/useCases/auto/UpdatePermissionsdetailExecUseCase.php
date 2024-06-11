<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePermissionsdetailExecUseCase
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
        $oldPermissionsdetails = $Permissionsdetails->replicate();

        $oldCrudData = [];
        $oldCrudData['action'] = $oldPermissionsdetails->action;
        $oldCrudData['table'] = $oldPermissionsdetails->table;
        $oldCrudData['creat_by'] = $oldPermissionsdetails->creat_by;
        $oldCrudData['user_id'] = $oldPermissionsdetails->user_id;
        $oldCrudData['identifiants_sadge'] = $oldPermissionsdetails->identifiants_sadge;
        try {
            $oldCrudData['user'] = $oldPermissionsdetails->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['action'])) {
            $Permissionsdetails->action = $data['action'];
        }
        if (!empty($data['table'])) {
            $Permissionsdetails->table = $data['table'];
        }
        if (!empty($data['creat_by'])) {
            $Permissionsdetails->creat_by = $data['creat_by'];
        }
        if (!empty($data['user_id'])) {
            $Permissionsdetails->user_id = $data['user_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Permissionsdetails->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Permissionsdetails->save();
        $Permissionsdetails = \App\Models\Permissionsdetail::find($Permissionsdetails->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Permissionsdetails', 'entite_cle' => $Permissionsdetails->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Permissionsdetails->toArray();
        return $data;
    }

}
