<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHorairesglobalsposteExecUseCase
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

        $Horairesglobalspostes = \App\Models\Horairesglobalsposte::find($data['id']);


        $Horairesglobalspostes->deleted_at = now();
        $Horairesglobalspostes->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Horairesglobalspostes->libelle;
        $newCrudData['horaire'] = $Horairesglobalspostes->horaire;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Horairesglobalspostes', 'entite_cle' => $Horairesglobalspostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
