<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateRoleHasPermisionExecUseCase
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

        $Role_has_permission = \App\Models\RoleHasPermision::find($data['id']);
        $oldRole_has_permission = $Role_has_permission->replicate();

        $oldCrudData = [];
        $oldCrudData['identifiants_sadge'] = $oldRole_has_permission->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldRole_has_permission->creat_by;


        if (!empty($data['identifiants_sadge'])) {
            $Role_has_permission->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Role_has_permission->creat_by = $data['creat_by'];
        }
        $Role_has_permission->save();
        $Role_has_permission = \App\Models\RoleHasPermision::find($Role_has_permission->id);
        $newCrudData = [];
        $newCrudData['identifiants_sadge'] = $Role_has_permission->identifiants_sadge;
        $newCrudData['creat_by'] = $Role_has_permission->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Role_has_permission', 'entite_cle' => $Role_has_permission->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Role_has_permission->toArray();
        return $data;
    }

}
