<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateModelHasPermissionExecUseCase
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

        $Model_has_permissions = new \App\Models\ModelHasPermission();

        if (!empty($data['permission_id'])) {
            $Model_has_permissions->permission_id = $data['permission_id'];
        }
        if (!empty($data['model_type'])) {
            $Model_has_permissions->model_type = $data['model_type'];
        }
        if (!empty($data['model_id'])) {
            $Model_has_permissions->model_id = $data['model_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Model_has_permissions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Model_has_permissions->creat_by = $data['creat_by'];
        }
        $Model_has_permissions->save();
        $Model_has_permissions = \App\Models\ModelHasPermission::find($Model_has_permissions->id);
        $newCrudData = [];
        $newCrudData['permission_id'] = $Model_has_permissions->permission_id;
        $newCrudData['model_type'] = $Model_has_permissions->model_type;
        $newCrudData['identifiants_sadge'] = $Model_has_permissions->identifiants_sadge;
        $newCrudData['creat_by'] = $Model_has_permissions->creat_by;
        try {
            $newCrudData['permission'] = $Model_has_permissions->permission->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Model_has_permissions', 'entite_cle' => $Model_has_permissions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Model_has_permissions->toArray();
        return $data;
    }

}
