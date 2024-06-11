<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHorairestypessiteExecUseCase
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

        $Horairestypessites = \App\Models\Horairestypessite::find($data['id']);


        $Horairestypessites->deleted_at = now();
        $Horairestypessites->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Horairestypessites->libelle;
        $newCrudData['debut'] = $Horairestypessites->debut;
        $newCrudData['fin'] = $Horairestypessites->fin;
        $newCrudData['typessite_id'] = $Horairestypessites->typessite_id;
        $newCrudData['creat_by'] = $Horairestypessites->creat_by;
        try {
            $newCrudData['typessite'] = $Horairestypessites->typessite->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Horairestypessites', 'entite_cle' => $Horairestypessites->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
