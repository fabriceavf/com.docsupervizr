<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHorairesglobalExecUseCase
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

        $Horairesglobals = \App\Models\Horairesglobal::find($data['id']);


        $Horairesglobals->deleted_at = now();
        $Horairesglobals->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Horairesglobals->libelle;
        $newCrudData['horaire'] = $Horairesglobals->horaire;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Horairesglobals', 'entite_cle' => $Horairesglobals->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
