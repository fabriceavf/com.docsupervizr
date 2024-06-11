<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateIdentificationExecUseCase
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

        $Identifications = new \App\Models\Identification();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Identifications', 'entite_cle' => $Identifications->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Identifications->toArray();
        return $data;
    }

}
