<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateAbscenceExecUseCase
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

        $Abscences = \App\Models\Abscence::find($data['id']);
        $oldAbscences = $Abscences->replicate();

        $oldCrudData = [];
        $oldCrudData['user_id'] = $oldAbscences->user_id;
        $oldCrudData['raison'] = $oldAbscences->raison;
        $oldCrudData['debut'] = $oldAbscences->debut;
        $oldCrudData['fin'] = $oldAbscences->fin;
        $oldCrudData['etats'] = $oldAbscences->etats;
        $oldCrudData['typesabscence_id'] = $oldAbscences->typesabscence_id;
        $oldCrudData['valide'] = $oldAbscences->valide;
        $oldCrudData['identifiants_sadge'] = $oldAbscences->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldAbscences->creat_by;
        try {
            $oldCrudData['typesabscence'] = $oldAbscences->typesabscence->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldAbscences->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['user_id'])) {
            $Abscences->user_id = $data['user_id'];
        }
        if (!empty($data['raison'])) {
            $Abscences->raison = $data['raison'];
        }
        if (!empty($data['debut'])) {
            $Abscences->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Abscences->fin = $data['fin'];
        }
        if (!empty($data['etats'])) {
            $Abscences->etats = $data['etats'];
        }
        if (!empty($data['typesabscence_id'])) {
            $Abscences->typesabscence_id = $data['typesabscence_id'];
        }
        if (!empty($data['valide'])) {
            $Abscences->valide = $data['valide'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Abscences->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Abscences->creat_by = $data['creat_by'];
        }
        $Abscences->save();
        $Abscences = \App\Models\Abscence::find($Abscences->id);
        $newCrudData = [];
        $newCrudData['user_id'] = $Abscences->user_id;
        $newCrudData['raison'] = $Abscences->raison;
        $newCrudData['debut'] = $Abscences->debut;
        $newCrudData['fin'] = $Abscences->fin;
        $newCrudData['etats'] = $Abscences->etats;
        $newCrudData['typesabscence_id'] = $Abscences->typesabscence_id;
        $newCrudData['valide'] = $Abscences->valide;
        $newCrudData['identifiants_sadge'] = $Abscences->identifiants_sadge;
        $newCrudData['creat_by'] = $Abscences->creat_by;
        try {
            $newCrudData['typesabscence'] = $Abscences->typesabscence->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Abscences->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Abscences', 'entite_cle' => $Abscences->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Abscences->toArray();
        return $data;
    }

}
