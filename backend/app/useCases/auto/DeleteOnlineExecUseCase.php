<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteOnlineExecUseCase
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

        $Onlines = \App\Models\Online::find($data['id']);


        $Onlines->deleted_at = now();
        $Onlines->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Onlines->libelle;
        $newCrudData['code'] = $Onlines->code;
        $newCrudData['identifiants_sadge'] = $Onlines->identifiants_sadge;
        $newCrudData['creat_by'] = $Onlines->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Onlines', 'entite_cle' => $Onlines->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
