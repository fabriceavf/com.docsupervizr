<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateValidationExecUseCase
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

        $Validations = new \App\Models\Validation();

        if (!empty($data['libelle'])) {
            $Validations->libelle = $data['libelle'];
        }
        if (!empty($data['users'])) {
            $Validations->users = $data['users'];
        }
        if (!empty($data['modelslisting_id'])) {
            $Validations->modelslisting_id = $data['modelslisting_id'];
        }
        if (!empty($data['creat_by'])) {
            $Validations->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Validations->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['nmbvalideurs'])) {
            $Validations->nmbvalideurs = $data['nmbvalideurs'];
        }
        $Validations->save();
        $Validations = \App\Models\Validation::find($Validations->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Validations', 'entite_cle' => $Validations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Validations->toArray();
        return $data;
    }

}
