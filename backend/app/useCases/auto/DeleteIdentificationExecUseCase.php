<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteIdentificationExecUseCase
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


        $Identifications->deleted_at = now();
        $Identifications->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Identifications', 'entite_cle' => $Identifications->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
