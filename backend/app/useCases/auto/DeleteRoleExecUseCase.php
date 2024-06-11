<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteRoleExecUseCase
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


        $Roles->deleted_at = now();
        $Roles->save();
        $newCrudData = [];
        $newCrudData['name'] = $Roles->name;
        $newCrudData['guard_name'] = $Roles->guard_name;
        $newCrudData['type'] = $Roles->type;
        $newCrudData['identifiants_sadge'] = $Roles->identifiants_sadge;
        $newCrudData['creat_by'] = $Roles->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Roles', 'entite_cle' => $Roles->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
