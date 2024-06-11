<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateActionExecUseCase
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

        $Actions = \App\Models\Action::find($data['id']);
        $oldActions = $Actions->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldActions->libelle;
        $oldCrudData['description'] = $oldActions->description;
        $oldCrudData['work_id'] = $oldActions->work_id;
        $oldCrudData['identifiants_sadge'] = $oldActions->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldActions->creat_by;
        try {
            $oldCrudData['work'] = $oldActions->work->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Actions->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Actions->description = $data['description'];
        }
        if (!empty($data['work_id'])) {
            $Actions->work_id = $data['work_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Actions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Actions->creat_by = $data['creat_by'];
        }
        $Actions->save();
        $Actions = \App\Models\Action::find($Actions->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Actions->libelle;
        $newCrudData['description'] = $Actions->description;
        $newCrudData['work_id'] = $Actions->work_id;
        $newCrudData['identifiants_sadge'] = $Actions->identifiants_sadge;
        $newCrudData['creat_by'] = $Actions->creat_by;
        try {
            $newCrudData['work'] = $Actions->work->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Actions', 'entite_cle' => $Actions->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Actions->toArray();
        return $data;
    }

}
