<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteNationaliteExecUseCase
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

        $Nationalites = \App\Models\Nationalite::find($data['id']);


        $Nationalites->deleted_at = now();
        $Nationalites->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Nationalites->libelle;
        $newCrudData['code'] = $Nationalites->code;
        $newCrudData['identifiants_sadge'] = $Nationalites->identifiants_sadge;
        $newCrudData['creat_by'] = $Nationalites->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Nationalites', 'entite_cle' => $Nationalites->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
