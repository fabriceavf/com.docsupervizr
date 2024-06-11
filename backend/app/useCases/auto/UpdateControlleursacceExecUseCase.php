<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateControlleursacceExecUseCase
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

        $Controlleursacces = \App\Models\Controlleursacce::find($data['id']);
        $oldControlleursacces = $Controlleursacces->replicate();

        $oldCrudData = [];
        $oldCrudData['pointeuse_id'] = $oldControlleursacces->pointeuse_id;
        $oldCrudData['ligne_id'] = $oldControlleursacces->ligne_id;
        $oldCrudData['deplacement_id'] = $oldControlleursacces->deplacement_id;
        $oldCrudData['site_id'] = $oldControlleursacces->site_id;
        $oldCrudData['date_debut'] = $oldControlleursacces->date_debut;
        $oldCrudData['date_fin'] = $oldControlleursacces->date_fin;
        $oldCrudData['creat_by'] = $oldControlleursacces->creat_by;
        $oldCrudData['type'] = $oldControlleursacces->type;
        try {
            $oldCrudData['deplacement'] = $oldControlleursacces->deplacement->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['ligne'] = $oldControlleursacces->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['pointeuse'] = $oldControlleursacces->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['site'] = $oldControlleursacces->site->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['pointeuse_id'])) {
            $Controlleursacces->pointeuse_id = $data['pointeuse_id'];
        }
        if (!empty($data['ligne_id'])) {
            $Controlleursacces->ligne_id = $data['ligne_id'];
        }
        if (!empty($data['deplacement_id'])) {
            $Controlleursacces->deplacement_id = $data['deplacement_id'];
        }
        if (!empty($data['site_id'])) {
            $Controlleursacces->site_id = $data['site_id'];
        }
        if (!empty($data['date_debut'])) {
            $Controlleursacces->date_debut = $data['date_debut'];
        }
        if (!empty($data['date_fin'])) {
            $Controlleursacces->date_fin = $data['date_fin'];
        }
        if (!empty($data['creat_by'])) {
            $Controlleursacces->creat_by = $data['creat_by'];
        }
        if (!empty($data['type'])) {
            $Controlleursacces->type = $data['type'];
        }
        $Controlleursacces->save();
        $Controlleursacces = \App\Models\Controlleursacce::find($Controlleursacces->id);
        $newCrudData = [];
        $newCrudData['pointeuse_id'] = $Controlleursacces->pointeuse_id;
        $newCrudData['ligne_id'] = $Controlleursacces->ligne_id;
        $newCrudData['deplacement_id'] = $Controlleursacces->deplacement_id;
        $newCrudData['site_id'] = $Controlleursacces->site_id;
        $newCrudData['date_debut'] = $Controlleursacces->date_debut;
        $newCrudData['date_fin'] = $Controlleursacces->date_fin;
        $newCrudData['creat_by'] = $Controlleursacces->creat_by;
        $newCrudData['type'] = $Controlleursacces->type;
        try {
            $newCrudData['deplacement'] = $Controlleursacces->deplacement->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ligne'] = $Controlleursacces->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $Controlleursacces->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Controlleursacces->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Controlleursacces', 'entite_cle' => $Controlleursacces->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Controlleursacces->toArray();
        return $data;
    }

}
