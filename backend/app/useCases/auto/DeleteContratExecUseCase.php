<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteContratExecUseCase
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

        $Contrats = \App\Models\Contrat::find($data['id']);


        $Contrats->deleted_at = now();
        $Contrats->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Contrats->libelle;
        $newCrudData['code'] = $Contrats->code;
        $newCrudData['typeView'] = $Contrats->typeView;
        $newCrudData['expiration'] = $Contrats->expiration;
        $newCrudData['identifiants_sadge'] = $Contrats->identifiants_sadge;
        $newCrudData['creat_by'] = $Contrats->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Contrats', 'entite_cle' => $Contrats->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
