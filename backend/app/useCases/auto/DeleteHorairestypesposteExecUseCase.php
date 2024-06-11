<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHorairestypesposteExecUseCase
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

        $Horairestypespostes = \App\Models\Horairestypesposte::find($data['id']);


        $Horairestypespostes->deleted_at = now();
        $Horairestypespostes->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Horairestypespostes->libelle;
        $newCrudData['debut'] = $Horairestypespostes->debut;
        $newCrudData['fin'] = $Horairestypespostes->fin;
        $newCrudData['typesposte_id'] = $Horairestypespostes->typesposte_id;
        $newCrudData['creat_by'] = $Horairestypespostes->creat_by;
        $newCrudData['ordre'] = $Horairestypespostes->ordre;
        try {
            $newCrudData['typesposte'] = $Horairestypespostes->typesposte->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Horairestypespostes', 'entite_cle' => $Horairestypespostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
