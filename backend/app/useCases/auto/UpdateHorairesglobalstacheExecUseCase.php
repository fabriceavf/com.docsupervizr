<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateHorairesglobalstacheExecUseCase
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
        $oldHorairesglobalstaches = $Horairesglobalstaches->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldHorairesglobalstaches->libelle;
        $oldCrudData['horaire'] = $oldHorairesglobalstaches->horaire;


        if (!empty($data['libelle'])) {
            $Horairesglobalstaches->libelle = $data['libelle'];
        }
        if (!empty($data['horaire'])) {
            $Horairesglobalstaches->horaire = $data['horaire'];
        }
        $Horairesglobalstaches->save();
        $Horairesglobalstaches = \App\Models\Horairesglobalstache::find($Horairesglobalstaches->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Horairesglobalstaches->libelle;
        $newCrudData['horaire'] = $Horairesglobalstaches->horaire;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Horairesglobalstaches', 'entite_cle' => $Horairesglobalstaches->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Horairesglobalstaches->toArray();
        return $data;
    }

}
