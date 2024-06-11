<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteAbscenceExecUseCase
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


        $Abscences->deleted_at = now();
        $Abscences->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Abscences', 'entite_cle' => $Abscences->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
