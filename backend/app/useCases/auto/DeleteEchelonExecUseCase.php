<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteEchelonExecUseCase
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

        $Echelons = \App\Models\Echelon::find($data['id']);


        $Echelons->deleted_at = now();
        $Echelons->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Echelons->libelle;
        $newCrudData['code'] = $Echelons->code;
        $newCrudData['identifiants_sadge'] = $Echelons->identifiants_sadge;
        $newCrudData['creat_by'] = $Echelons->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Echelons', 'entite_cle' => $Echelons->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
