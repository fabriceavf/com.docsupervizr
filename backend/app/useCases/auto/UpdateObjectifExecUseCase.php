<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateObjectifExecUseCase
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

        $Objectifs = \App\Models\Objectif::find($data['id']);
        $oldObjectifs = $Objectifs->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldObjectifs->libelle;
        $oldCrudData['debut'] = $oldObjectifs->debut;
        $oldCrudData['fin'] = $oldObjectifs->fin;
        $oldCrudData['description'] = $oldObjectifs->description;
        $oldCrudData['activite_id'] = $oldObjectifs->activite_id;
        $oldCrudData['user_id'] = $oldObjectifs->user_id;
        $oldCrudData['identifiants_sadge'] = $oldObjectifs->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldObjectifs->creat_by;
        try {
            $oldCrudData['activite'] = $oldObjectifs->activite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldObjectifs->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Objectifs->libelle = $data['libelle'];
        }
        if (!empty($data['debut'])) {
            $Objectifs->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Objectifs->fin = $data['fin'];
        }
        if (!empty($data['description'])) {
            $Objectifs->description = $data['description'];
        }
        if (!empty($data['activite_id'])) {
            $Objectifs->activite_id = $data['activite_id'];
        }
        if (!empty($data['user_id'])) {
            $Objectifs->user_id = $data['user_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Objectifs->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Objectifs->creat_by = $data['creat_by'];
        }
        $Objectifs->save();
        $Objectifs = \App\Models\Objectif::find($Objectifs->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Objectifs->libelle;
        $newCrudData['debut'] = $Objectifs->debut;
        $newCrudData['fin'] = $Objectifs->fin;
        $newCrudData['description'] = $Objectifs->description;
        $newCrudData['activite_id'] = $Objectifs->activite_id;
        $newCrudData['user_id'] = $Objectifs->user_id;
        $newCrudData['identifiants_sadge'] = $Objectifs->identifiants_sadge;
        $newCrudData['creat_by'] = $Objectifs->creat_by;
        try {
            $newCrudData['activite'] = $Objectifs->activite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Objectifs->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Objectifs', 'entite_cle' => $Objectifs->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Objectifs->toArray();
        return $data;
    }

}
