<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteRapportposteExecUseCase
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

        $Rapportpostes = \App\Models\Rapportposte::find($data['id']);


        $Rapportpostes->deleted_at = now();
        $Rapportpostes->save();
        $newCrudData = [];
        $newCrudData['total'] = $Rapportpostes->total;
        $newCrudData['date'] = $Rapportpostes->date;
        $newCrudData['poste_id'] = $Rapportpostes->poste_id;
        $newCrudData['identifiants_sadge'] = $Rapportpostes->identifiants_sadge;
        $newCrudData['creat_by'] = $Rapportpostes->creat_by;
        try {
            $newCrudData['poste'] = $Rapportpostes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Rapportpostes', 'entite_cle' => $Rapportpostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
