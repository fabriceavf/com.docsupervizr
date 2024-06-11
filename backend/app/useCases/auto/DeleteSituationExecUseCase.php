<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteSituationExecUseCase
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

        $Situations = \App\Models\Situation::find($data['id']);


        $Situations->deleted_at = now();
        $Situations->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Situations->libelle;
        $newCrudData['code'] = $Situations->code;
        $newCrudData['identifiants_sadge'] = $Situations->identifiants_sadge;
        $newCrudData['creat_by'] = $Situations->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Situations', 'entite_cle' => $Situations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
