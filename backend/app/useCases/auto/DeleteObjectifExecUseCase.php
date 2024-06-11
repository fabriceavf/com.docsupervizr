<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteObjectifExecUseCase
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


        $Objectifs->deleted_at = now();
        $Objectifs->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Objectifs', 'entite_cle' => $Objectifs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
