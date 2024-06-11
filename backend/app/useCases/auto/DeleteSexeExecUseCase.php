<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteSexeExecUseCase
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

        $Sexes = \App\Models\Sexe::find($data['id']);


        $Sexes->deleted_at = now();
        $Sexes->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Sexes->libelle;
        $newCrudData['code'] = $Sexes->code;
        $newCrudData['identifiants_sadge'] = $Sexes->identifiants_sadge;
        $newCrudData['creat_by'] = $Sexes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Sexes', 'entite_cle' => $Sexes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
