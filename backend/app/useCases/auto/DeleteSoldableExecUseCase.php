<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteSoldableExecUseCase
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

        $Soldables = \App\Models\Soldable::find($data['id']);


        $Soldables->deleted_at = now();
        $Soldables->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Soldables->libelle;
        $newCrudData['code'] = $Soldables->code;
        $newCrudData['identifiants_sadge'] = $Soldables->identifiants_sadge;
        $newCrudData['creat_by'] = $Soldables->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Soldables', 'entite_cle' => $Soldables->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
