<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypestacheExecUseCase
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

        $Typestaches = \App\Models\Typestache::find($data['id']);


        $Typestaches->deleted_at = now();
        $Typestaches->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Typestaches->libelle;
        $newCrudData['code'] = $Typestaches->code;
        $newCrudData['identifiants_sadge'] = $Typestaches->identifiants_sadge;
        $newCrudData['creat_by'] = $Typestaches->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typestaches', 'entite_cle' => $Typestaches->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
