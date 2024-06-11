<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypesabscenceExecUseCase
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

        $Typesabscences = \App\Models\Typesabscence::find($data['id']);


        $Typesabscences->deleted_at = now();
        $Typesabscences->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Typesabscences->libelle;
        $newCrudData['soldable_id'] = $Typesabscences->soldable_id;
        $newCrudData['variable_id'] = $Typesabscences->variable_id;
        $newCrudData['nombrejours'] = $Typesabscences->nombrejours;
        $newCrudData['etats'] = $Typesabscences->etats;
        $newCrudData['identifiants_sadge'] = $Typesabscences->identifiants_sadge;
        $newCrudData['creat_by'] = $Typesabscences->creat_by;
        try {
            $newCrudData['soldable'] = $Typesabscences->soldable->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['variable'] = $Typesabscences->variable->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typesabscences', 'entite_cle' => $Typesabscences->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
