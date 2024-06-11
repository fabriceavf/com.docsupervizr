<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteUserstypesposteExecUseCase
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


        $Userstypespostes->deleted_at = now();
        $Userstypespostes->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Userstypespostes', 'entite_cle' => $Userstypespostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
