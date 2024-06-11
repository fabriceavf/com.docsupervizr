<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteVariableExecUseCase
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

        $Variables = \App\Models\Variable::find($data['id']);


        $Variables->deleted_at = now();
        $Variables->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Variables->libelle;
        $newCrudData['code'] = $Variables->code;
        $newCrudData['identifiants_sadge'] = $Variables->identifiants_sadge;
        $newCrudData['creat_by'] = $Variables->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Variables', 'entite_cle' => $Variables->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
