<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteModelHasPermissionExecUseCase
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

        $Model_has_permissions = \App\Models\ModelHasPermission::find($data['id']);


        $Model_has_permissions->deleted_at = now();
        $Model_has_permissions->save();
        $newCrudData = [];
        $newCrudData['permission_id'] = $Model_has_permissions->permission_id;
        $newCrudData['model_type'] = $Model_has_permissions->model_type;
        $newCrudData['identifiants_sadge'] = $Model_has_permissions->identifiants_sadge;
        $newCrudData['creat_by'] = $Model_has_permissions->creat_by;
        try {
            $newCrudData['permission'] = $Model_has_permissions->permission->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Model_has_permissions', 'entite_cle' => $Model_has_permissions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
