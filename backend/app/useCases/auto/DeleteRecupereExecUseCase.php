<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteRecupereExecUseCase
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

        $Recuperes = \App\Models\Recupere::find($data['id']);


        $Recuperes->deleted_at = now();
        $Recuperes->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Recuperes->libelle;
        $newCrudData['identifiants_sadge'] = $Recuperes->identifiants_sadge;
        $newCrudData['creat_by'] = $Recuperes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Recuperes', 'entite_cle' => $Recuperes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
