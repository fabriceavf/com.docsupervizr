<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateRoleHasPermissionExecUseCase
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
        $oldRole_has_permissions = $Role_has_permissions->replicate();

        $oldCrudData = [];
        $oldCrudData['permission_id'] = $oldRole_has_permissions->permission_id;
        $oldCrudData['role_id'] = $oldRole_has_permissions->role_id;
        $oldCrudData['identifiants_sadge'] = $oldRole_has_permissions->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldRole_has_permissions->creat_by;
        $oldCrudData['canCreate'] = $oldRole_has_permissions->canCreate;
        $oldCrudData['canUpdate'] = $oldRole_has_permissions->canUpdate;
        $oldCrudData['canDelete'] = $oldRole_has_permissions->canDelete;
        try {
            $oldCrudData['permission'] = $oldRole_has_permissions->permission->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['role'] = $oldRole_has_permissions->role->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['permission_id'])) {
            $Role_has_permissions->permission_id = $data['permission_id'];
        }
        if (!empty($data['role_id'])) {
            $Role_has_permissions->role_id = $data['role_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Role_has_permissions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Role_has_permissions->creat_by = $data['creat_by'];
        }
        if (!empty($data['canCreate'])) {
            $Role_has_permissions->canCreate = $data['canCreate'];
        }
        if (!empty($data['canUpdate'])) {
            $Role_has_permissions->canUpdate = $data['canUpdate'];
        }
        if (!empty($data['canDelete'])) {
            $Role_has_permissions->canDelete = $data['canDelete'];
        }
        $Role_has_permissions->save();
        $Role_has_permissions = \App\Models\RoleHasPermission::find($Role_has_permissions->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Role_has_permissions', 'entite_cle' => $Role_has_permissions->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Role_has_permissions->toArray();
        return $data;
    }

}
