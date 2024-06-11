<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePermissionExecUseCase
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

        $Permissions = \App\Models\Permission::find($data['id']);
        $oldPermissions = $Permissions->replicate();

        $oldCrudData = [];
        $oldCrudData['name'] = $oldPermissions->name;
        $oldCrudData['guard_name'] = $oldPermissions->guard_name;
        $oldCrudData['type'] = $oldPermissions->type;
        $oldCrudData['nom'] = $oldPermissions->nom;
        $oldCrudData['visible'] = $oldPermissions->visible;
        $oldCrudData['groupepermission_id'] = $oldPermissions->groupepermission_id;
        $oldCrudData['identifiants_sadge'] = $oldPermissions->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldPermissions->creat_by;
        try {
            $oldCrudData['groupepermission'] = $oldPermissions->groupepermission->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['name'])) {
            $Permissions->name = $data['name'];
        }
        if (!empty($data['guard_name'])) {
            $Permissions->guard_name = $data['guard_name'];
        }
        if (!empty($data['type'])) {
            $Permissions->type = $data['type'];
        }
        if (!empty($data['nom'])) {
            $Permissions->nom = $data['nom'];
        }
        if (!empty($data['visible'])) {
            $Permissions->visible = $data['visible'];
        }
        if (!empty($data['groupepermission_id'])) {
            $Permissions->groupepermission_id = $data['groupepermission_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Permissions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Permissions->creat_by = $data['creat_by'];
        }
        $Permissions->save();
        $Permissions = \App\Models\Permission::find($Permissions->id);
        $newCrudData = [];
        $newCrudData['name'] = $Permissions->name;
        $newCrudData['guard_name'] = $Permissions->guard_name;
        $newCrudData['type'] = $Permissions->type;
        $newCrudData['nom'] = $Permissions->nom;
        $newCrudData['visible'] = $Permissions->visible;
        $newCrudData['groupepermission_id'] = $Permissions->groupepermission_id;
        $newCrudData['identifiants_sadge'] = $Permissions->identifiants_sadge;
        $newCrudData['creat_by'] = $Permissions->creat_by;
        try {
            $newCrudData['groupepermission'] = $Permissions->groupepermission->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Permissions', 'entite_cle' => $Permissions->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Permissions->toArray();
        return $data;
    }

}
