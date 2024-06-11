<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateModelHasRoleExecUseCase
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

        $Model_has_roles = \App\Models\ModelHasRole::find($data['id']);
        $oldModel_has_roles = $Model_has_roles->replicate();

        $oldCrudData = [];
        $oldCrudData['role_id'] = $oldModel_has_roles->role_id;
        $oldCrudData['model_type'] = $oldModel_has_roles->model_type;
        $oldCrudData['identifiants_sadge'] = $oldModel_has_roles->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldModel_has_roles->creat_by;
        try {
            $oldCrudData['role'] = $oldModel_has_roles->role->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['role_id'])) {
            $Model_has_roles->role_id = $data['role_id'];
        }
        if (!empty($data['model_type'])) {
            $Model_has_roles->model_type = $data['model_type'];
        }
        if (!empty($data['model_id'])) {
            $Model_has_roles->model_id = $data['model_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Model_has_roles->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Model_has_roles->creat_by = $data['creat_by'];
        }
        $Model_has_roles->save();
        $Model_has_roles = \App\Models\ModelHasRole::find($Model_has_roles->id);
        $newCrudData = [];
        $newCrudData['role_id'] = $Model_has_roles->role_id;
        $newCrudData['model_type'] = $Model_has_roles->model_type;
        $newCrudData['identifiants_sadge'] = $Model_has_roles->identifiants_sadge;
        $newCrudData['creat_by'] = $Model_has_roles->creat_by;
        try {
            $newCrudData['role'] = $Model_has_roles->role->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Model_has_roles', 'entite_cle' => $Model_has_roles->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Model_has_roles->toArray();
        return $data;
    }

}
