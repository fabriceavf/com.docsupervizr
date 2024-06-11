<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateIdentificationExecUseCase
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

        $Identifications = \App\Models\Identification::find($data['id']);
        $oldIdentifications = $Identifications->replicate();

        $oldCrudData = [];
        $oldCrudData['user_id'] = $oldIdentifications->user_id;
        $oldCrudData['carte_id'] = $oldIdentifications->carte_id;
        $oldCrudData['date_debut'] = $oldIdentifications->date_debut;
        $oldCrudData['date_fin'] = $oldIdentifications->date_fin;
        $oldCrudData['statuts'] = $oldIdentifications->statuts;
        $oldCrudData['creat_by'] = $oldIdentifications->creat_by;
        try {
            $oldCrudData['carte'] = $oldIdentifications->carte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldIdentifications->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['user_id'])) {
            $Identifications->user_id = $data['user_id'];
        }
        if (!empty($data['carte_id'])) {
            $Identifications->carte_id = $data['carte_id'];
        }
        if (!empty($data['date_debut'])) {
            $Identifications->date_debut = $data['date_debut'];
        }
        if (!empty($data['date_fin'])) {
            $Identifications->date_fin = $data['date_fin'];
        }
        if (!empty($data['statuts'])) {
            $Identifications->statuts = $data['statuts'];
        }
        if (!empty($data['creat_by'])) {
            $Identifications->creat_by = $data['creat_by'];
        }
        $Identifications->save();
        $Identifications = \App\Models\Identification::find($Identifications->id);
        $newCrudData = [];
        $newCrudData['user_id'] = $Identifications->user_id;
        $newCrudData['carte_id'] = $Identifications->carte_id;
        $newCrudData['date_debut'] = $Identifications->date_debut;
        $newCrudData['date_fin'] = $Identifications->date_fin;
        $newCrudData['statuts'] = $Identifications->statuts;
        $newCrudData['creat_by'] = $Identifications->creat_by;
        try {
            $newCrudData['carte'] = $Identifications->carte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Identifications->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Identifications', 'entite_cle' => $Identifications->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Identifications->toArray();
        return $data;
    }

}
