<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteModelHasRoleExecUseCase
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


        $Model_has_roles->deleted_at = now();
        $Model_has_roles->save();
        $newCrudData = [];
        $newCrudData['role_id'] = $Model_has_roles->role_id;
        $newCrudData['model_type'] = $Model_has_roles->model_type;
        $newCrudData['identifiants_sadge'] = $Model_has_roles->identifiants_sadge;
        $newCrudData['creat_by'] = $Model_has_roles->creat_by;
        try {
            $newCrudData['role'] = $Model_has_roles->role->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Model_has_roles', 'entite_cle' => $Model_has_roles->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
