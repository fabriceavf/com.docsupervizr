<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePostesglobalExecUseCase
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

        $Postesglobals = \App\Models\Postesglobal::find($data['id']);


        $Postesglobals->deleted_at = now();
        $Postesglobals->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Postesglobals->libelle;
        $newCrudData['code'] = $Postesglobals->code;
        $newCrudData['site'] = $Postesglobals->site;
        $newCrudData['zone'] = $Postesglobals->zone;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Postesglobals', 'entite_cle' => $Postesglobals->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
