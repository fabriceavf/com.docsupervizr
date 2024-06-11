<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateApprovisionementExecUseCase
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

        $Approvisionements = new \App\Models\Approvisionement();

        if (!empty($data['libelle'])) {
            $Approvisionements->libelle = $data['libelle'];
        }
        if (!empty($data['date'])) {
            $Approvisionements->date = $data['date'];
        }
        if (!empty($data['valider'])) {
            $Approvisionements->valider = $data['valider'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Approvisionements->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Approvisionements->creat_by = $data['creat_by'];
        }
        $Approvisionements->save();
        $Approvisionements = \App\Models\Approvisionement::find($Approvisionements->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Approvisionements->libelle;
        $newCrudData['date'] = $Approvisionements->date;
        $newCrudData['valider'] = $Approvisionements->valider;
        $newCrudData['identifiants_sadge'] = $Approvisionements->identifiants_sadge;
        $newCrudData['creat_by'] = $Approvisionements->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Approvisionements', 'entite_cle' => $Approvisionements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Approvisionements->toArray();
        return $data;
    }

}
