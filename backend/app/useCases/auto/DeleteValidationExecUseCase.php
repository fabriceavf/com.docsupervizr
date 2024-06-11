<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteValidationExecUseCase
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

        $Validations = \App\Models\Validation::find($data['id']);


        $Validations->deleted_at = now();
        $Validations->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Validations->libelle;
        $newCrudData['users'] = $Validations->users;
        $newCrudData['modelslisting_id'] = $Validations->modelslisting_id;
        $newCrudData['creat_by'] = $Validations->creat_by;
        $newCrudData['identifiants_sadge'] = $Validations->identifiants_sadge;
        $newCrudData['nmbvalideurs'] = $Validations->nmbvalideurs;
        try {
            $newCrudData['modelslisting'] = $Validations->modelslisting->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Validations', 'entite_cle' => $Validations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
