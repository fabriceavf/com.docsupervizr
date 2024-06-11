<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHorairesglobalstacheExecUseCase
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

        $Horairesglobalstaches = \App\Models\Horairesglobalstache::find($data['id']);


        $Horairesglobalstaches->deleted_at = now();
        $Horairesglobalstaches->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Horairesglobalstaches->libelle;
        $newCrudData['horaire'] = $Horairesglobalstaches->horaire;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Horairesglobalstaches', 'entite_cle' => $Horairesglobalstaches->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
