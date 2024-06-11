<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteRoleHasPermissionExecUseCase
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

        $Role_has_permissions = \App\Models\RoleHasPermission::find($data['id']);


        $Role_has_permissions->deleted_at = now();
        $Role_has_permissions->save();
        $newCrudData = [];
        $newCrudData['permission_id'] = $Role_has_permissions->permission_id;
        $newCrudData['role_id'] = $Role_has_permissions->role_id;
        $newCrudData['identifiants_sadge'] = $Role_has_permissions->identifiants_sadge;
        $newCrudData['creat_by'] = $Role_has_permissions->creat_by;
        $newCrudData['canCreate'] = $Role_has_permissions->canCreate;
        $newCrudData['canUpdate'] = $Role_has_permissions->canUpdate;
        $newCrudData['canDelete'] = $Role_has_permissions->canDelete;
        try {
            $newCrudData['permission'] = $Role_has_permissions->permission->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['role'] = $Role_has_permissions->role->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Role_has_permissions', 'entite_cle' => $Role_has_permissions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
