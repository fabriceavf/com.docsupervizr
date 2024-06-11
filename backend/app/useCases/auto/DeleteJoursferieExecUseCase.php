<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteJoursferieExecUseCase
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

        $Joursferies = \App\Models\Joursferie::find($data['id']);


        $Joursferies->deleted_at = now();
        $Joursferies->save();
        $newCrudData = [];
        $newCrudData['raison'] = $Joursferies->raison;
        $newCrudData['debut'] = $Joursferies->debut;
        $newCrudData['fin'] = $Joursferies->fin;
        $newCrudData['etats'] = $Joursferies->etats;
        $newCrudData['identifiants_sadge'] = $Joursferies->identifiants_sadge;
        $newCrudData['creat_by'] = $Joursferies->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Joursferies', 'entite_cle' => $Joursferies->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
