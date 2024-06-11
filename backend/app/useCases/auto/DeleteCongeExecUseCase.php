<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteCongeExecUseCase
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

        $Conges = \App\Models\Conge::find($data['id']);


        $Conges->deleted_at = now();
        $Conges->save();
        $newCrudData = [];
        $newCrudData['user_id'] = $Conges->user_id;
        $newCrudData['raison'] = $Conges->raison;
        $newCrudData['debut'] = $Conges->debut;
        $newCrudData['fin'] = $Conges->fin;
        $newCrudData['etats'] = $Conges->etats;
        $newCrudData['identifiants_sadge'] = $Conges->identifiants_sadge;
        $newCrudData['creat_by'] = $Conges->creat_by;
        try {
            $newCrudData['user'] = $Conges->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Conges', 'entite_cle' => $Conges->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
