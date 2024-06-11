<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateUserstypesposteExecUseCase
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

        $Userstypespostes = \App\Models\Userstypesposte::find($data['id']);
        $oldUserstypespostes = $Userstypespostes->replicate();

        $oldCrudData = [];
        $oldCrudData['user_id'] = $oldUserstypespostes->user_id;
        $oldCrudData['typesposte_id'] = $oldUserstypespostes->typesposte_id;
        $oldCrudData['creat_by'] = $oldUserstypespostes->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldUserstypespostes->identifiants_sadge;
        try {
            $oldCrudData['typesposte'] = $oldUserstypespostes->typesposte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldUserstypespostes->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['user_id'])) {
            $Userstypespostes->user_id = $data['user_id'];
        }
        if (!empty($data['typesposte_id'])) {
            $Userstypespostes->typesposte_id = $data['typesposte_id'];
        }
        if (!empty($data['creat_by'])) {
            $Userstypespostes->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Userstypespostes->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Userstypespostes->save();
        $Userstypespostes = \App\Models\Userstypesposte::find($Userstypespostes->id);
        $newCrudData = [];
        $newCrudData['user_id'] = $Userstypespostes->user_id;
        $newCrudData['typesposte_id'] = $Userstypespostes->typesposte_id;
        $newCrudData['creat_by'] = $Userstypespostes->creat_by;
        $newCrudData['identifiants_sadge'] = $Userstypespostes->identifiants_sadge;
        try {
            $newCrudData['typesposte'] = $Userstypespostes->typesposte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Userstypespostes->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Userstypespostes', 'entite_cle' => $Userstypespostes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Userstypespostes->toArray();
        return $data;
    }

}
