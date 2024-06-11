<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePermExecUseCase
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
        $oldPerms = $Perms->replicate();

        $oldCrudData = [];
        $oldCrudData['permission_label'] = $oldPerms->permission_label;
        $oldCrudData['permission_nom'] = $oldPerms->permission_nom;
        $oldCrudData['permission_id'] = $oldPerms->permission_id;
        $oldCrudData['user_id'] = $oldPerms->user_id;
        $oldCrudData['nom'] = $oldPerms->nom;
        $oldCrudData['prenom'] = $oldPerms->prenom;
        $oldCrudData['type'] = $oldPerms->type;
        try {
            $oldCrudData['permission'] = $oldPerms->permission->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldPerms->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['permission_label'])) {
            $Perms->permission_label = $data['permission_label'];
        }
        if (!empty($data['permission_nom'])) {
            $Perms->permission_nom = $data['permission_nom'];
        }
        if (!empty($data['permission_id'])) {
            $Perms->permission_id = $data['permission_id'];
        }
        if (!empty($data['user_id'])) {
            $Perms->user_id = $data['user_id'];
        }
        if (!empty($data['nom'])) {
            $Perms->nom = $data['nom'];
        }
        if (!empty($data['prenom'])) {
            $Perms->prenom = $data['prenom'];
        }
        if (!empty($data['type'])) {
            $Perms->type = $data['type'];
        }
        $Perms->save();
        $Perms = \App\Models\Perm::find($Perms->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Perms', 'entite_cle' => $Perms->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Perms->toArray();
        return $data;
    }

}
