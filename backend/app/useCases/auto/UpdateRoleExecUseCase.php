<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateRoleExecUseCase
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

        $Roles = \App\Models\Role::find($data['id']);
        $oldRoles = $Roles->replicate();

        $oldCrudData = [];
        $oldCrudData['name'] = $oldRoles->name;
        $oldCrudData['guard_name'] = $oldRoles->guard_name;
        $oldCrudData['type'] = $oldRoles->type;
        $oldCrudData['identifiants_sadge'] = $oldRoles->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldRoles->creat_by;


        if (!empty($data['name'])) {
            $Roles->name = $data['name'];
        }
        if (!empty($data['guard_name'])) {
            $Roles->guard_name = $data['guard_name'];
        }
        if (!empty($data['type'])) {
            $Roles->type = $data['type'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Roles->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Roles->creat_by = $data['creat_by'];
        }
        $Roles->save();
        $Roles = \App\Models\Role::find($Roles->id);
        $newCrudData = [];
        $newCrudData['name'] = $Roles->name;
        $newCrudData['guard_name'] = $Roles->guard_name;
        $newCrudData['type'] = $Roles->type;
        $newCrudData['identifiants_sadge'] = $Roles->identifiants_sadge;
        $newCrudData['creat_by'] = $Roles->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Roles', 'entite_cle' => $Roles->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Roles->toArray();
        return $data;
    }

}
