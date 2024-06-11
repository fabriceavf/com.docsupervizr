<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteApprovisionementExecUseCase
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

        $Approvisionements = \App\Models\Approvisionement::find($data['id']);


        $Approvisionements->deleted_at = now();
        $Approvisionements->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Approvisionements->libelle;
        $newCrudData['date'] = $Approvisionements->date;
        $newCrudData['valider'] = $Approvisionements->valider;
        $newCrudData['identifiants_sadge'] = $Approvisionements->identifiants_sadge;
        $newCrudData['creat_by'] = $Approvisionements->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Approvisionements', 'entite_cle' => $Approvisionements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
