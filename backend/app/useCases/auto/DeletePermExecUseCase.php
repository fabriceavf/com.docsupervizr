<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePermExecUseCase
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

        $Perms = \App\Models\Perm::find($data['id']);


        $Perms->deleted_at = now();
        $Perms->save();
        $newCrudData = [];
        $newCrudData['permission_label'] = $Perms->permission_label;
        $newCrudData['permission_nom'] = $Perms->permission_nom;
        $newCrudData['permission_id'] = $Perms->permission_id;
        $newCrudData['user_id'] = $Perms->user_id;
        $newCrudData['nom'] = $Perms->nom;
        $newCrudData['prenom'] = $Perms->prenom;
        $newCrudData['type'] = $Perms->type;
        try {
            $newCrudData['permission'] = $Perms->permission->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Perms->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Perms', 'entite_cle' => $Perms->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
