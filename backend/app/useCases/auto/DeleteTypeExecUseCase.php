<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypeExecUseCase
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

        $Types = \App\Models\Type::find($data['id']);


        $Types->deleted_at = now();
        $Types->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Types->libelle;
        $newCrudData['code'] = $Types->code;
        $newCrudData['identifiants_sadge'] = $Types->identifiants_sadge;
        $newCrudData['creat_by'] = $Types->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Types', 'entite_cle' => $Types->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
