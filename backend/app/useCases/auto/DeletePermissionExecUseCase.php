<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePermissionExecUseCase
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


        $Permissions->deleted_at = now();
        $Permissions->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Permissions', 'entite_cle' => $Permissions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
