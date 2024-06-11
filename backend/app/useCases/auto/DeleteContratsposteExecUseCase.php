<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteContratsposteExecUseCase
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

        $Contratspostes = \App\Models\Contratsposte::find($data['id']);


        $Contratspostes->deleted_at = now();
        $Contratspostes->save();
        $newCrudData = [];
        $newCrudData['contratssite_id'] = $Contratspostes->contratssite_id;
        $newCrudData['poste_id'] = $Contratspostes->poste_id;
        $newCrudData['jours'] = $Contratspostes->jours;
        $newCrudData['agentsjour'] = $Contratspostes->agentsjour;
        $newCrudData['agentsnuit'] = $Contratspostes->agentsnuit;
        $newCrudData['identifiants_sadge'] = $Contratspostes->identifiants_sadge;
        $newCrudData['creat_by'] = $Contratspostes->creat_by;
        try {
            $newCrudData['contratssite'] = $Contratspostes->contratssite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Contratspostes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Contratspostes', 'entite_cle' => $Contratspostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
