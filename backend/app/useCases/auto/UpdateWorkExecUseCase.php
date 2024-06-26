<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateWorkExecUseCase
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

        $Works = \App\Models\Work::find($data['id']);
        $oldWorks = $Works->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldWorks->libelle;
        $oldCrudData['activite_id'] = $oldWorks->activite_id;
        $oldCrudData['user_id'] = $oldWorks->user_id;
        $oldCrudData['debut'] = $oldWorks->debut;
        $oldCrudData['fin'] = $oldWorks->fin;
        $oldCrudData['groupe'] = $oldWorks->groupe;
        $oldCrudData['identifiants_sadge'] = $oldWorks->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldWorks->creat_by;
        try {
            $oldCrudData['activite'] = $oldWorks->activite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldWorks->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Works->libelle = $data['libelle'];
        }
        if (!empty($data['activite_id'])) {
            $Works->activite_id = $data['activite_id'];
        }
        if (!empty($data['user_id'])) {
            $Works->user_id = $data['user_id'];
        }
        if (!empty($data['debut'])) {
            $Works->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Works->fin = $data['fin'];
        }
        if (!empty($data['groupe'])) {
            $Works->groupe = $data['groupe'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Works->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Works->creat_by = $data['creat_by'];
        }
        $Works->save();
        $Works = \App\Models\Work::find($Works->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Works->libelle;
        $newCrudData['activite_id'] = $Works->activite_id;
        $newCrudData['user_id'] = $Works->user_id;
        $newCrudData['debut'] = $Works->debut;
        $newCrudData['fin'] = $Works->fin;
        $newCrudData['groupe'] = $Works->groupe;
        $newCrudData['identifiants_sadge'] = $Works->identifiants_sadge;
        $newCrudData['creat_by'] = $Works->creat_by;
        try {
            $newCrudData['activite'] = $Works->activite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Works->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Works', 'entite_cle' => $Works->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Works->toArray();
        return $data;
    }

}
