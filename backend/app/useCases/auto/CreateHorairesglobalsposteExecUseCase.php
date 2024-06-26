<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateHorairesglobalsposteExecUseCase
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

        $Horairesglobalspostes = new \App\Models\Horairesglobalsposte();

        if (!empty($data['libelle'])) {
            $Horairesglobalspostes->libelle = $data['libelle'];
        }
        if (!empty($data['horaire'])) {
            $Horairesglobalspostes->horaire = $data['horaire'];
        }
        $Horairesglobalspostes->save();
        $Horairesglobalspostes = \App\Models\Horairesglobalsposte::find($Horairesglobalspostes->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Horairesglobalspostes->libelle;
        $newCrudData['horaire'] = $Horairesglobalspostes->horaire;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Horairesglobalspostes', 'entite_cle' => $Horairesglobalspostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Horairesglobalspostes->toArray();
        return $data;
    }

}
