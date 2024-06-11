<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateHorairesglobalExecUseCase
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
        $oldHorairesglobals = $Horairesglobals->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldHorairesglobals->libelle;
        $oldCrudData['horaire'] = $oldHorairesglobals->horaire;


        if (!empty($data['libelle'])) {
            $Horairesglobals->libelle = $data['libelle'];
        }
        if (!empty($data['horaire'])) {
            $Horairesglobals->horaire = $data['horaire'];
        }
        $Horairesglobals->save();
        $Horairesglobals = \App\Models\Horairesglobal::find($Horairesglobals->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Horairesglobals->libelle;
        $newCrudData['horaire'] = $Horairesglobals->horaire;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Horairesglobals', 'entite_cle' => $Horairesglobals->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Horairesglobals->toArray();
        return $data;
    }

}
