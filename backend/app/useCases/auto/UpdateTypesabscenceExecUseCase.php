<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTypesabscenceExecUseCase
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
        $oldTypesabscences = $Typesabscences->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldTypesabscences->libelle;
        $oldCrudData['soldable_id'] = $oldTypesabscences->soldable_id;
        $oldCrudData['variable_id'] = $oldTypesabscences->variable_id;
        $oldCrudData['nombrejours'] = $oldTypesabscences->nombrejours;
        $oldCrudData['etats'] = $oldTypesabscences->etats;
        $oldCrudData['identifiants_sadge'] = $oldTypesabscences->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldTypesabscences->creat_by;
        try {
            $oldCrudData['soldable'] = $oldTypesabscences->soldable->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['variable'] = $oldTypesabscences->variable->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Typesabscences->libelle = $data['libelle'];
        }
        if (!empty($data['soldable_id'])) {
            $Typesabscences->soldable_id = $data['soldable_id'];
        }
        if (!empty($data['variable_id'])) {
            $Typesabscences->variable_id = $data['variable_id'];
        }
        if (!empty($data['nombrejours'])) {
            $Typesabscences->nombrejours = $data['nombrejours'];
        }
        if (!empty($data['etats'])) {
            $Typesabscences->etats = $data['etats'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Typesabscences->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Typesabscences->creat_by = $data['creat_by'];
        }
        $Typesabscences->save();
        $Typesabscences = \App\Models\Typesabscence::find($Typesabscences->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Typesabscences', 'entite_cle' => $Typesabscences->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typesabscences->toArray();
        return $data;
    }

}
