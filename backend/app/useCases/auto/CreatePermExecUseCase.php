<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePermExecUseCase
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

        $Perms = new \App\Models\Perm();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Perms', 'entite_cle' => $Perms->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Perms->toArray();
        return $data;
    }

}
