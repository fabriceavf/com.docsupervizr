<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePermissionExecUseCase
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

        $Permissions = new \App\Models\Permission();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Permissions', 'entite_cle' => $Permissions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Permissions->toArray();
        return $data;
    }

}
