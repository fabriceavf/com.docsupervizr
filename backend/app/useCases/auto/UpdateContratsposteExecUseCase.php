<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateContratsposteExecUseCase
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
        $oldContratspostes = $Contratspostes->replicate();

        $oldCrudData = [];
        $oldCrudData['contratssite_id'] = $oldContratspostes->contratssite_id;
        $oldCrudData['poste_id'] = $oldContratspostes->poste_id;
        $oldCrudData['jours'] = $oldContratspostes->jours;
        $oldCrudData['agentsjour'] = $oldContratspostes->agentsjour;
        $oldCrudData['agentsnuit'] = $oldContratspostes->agentsnuit;
        $oldCrudData['identifiants_sadge'] = $oldContratspostes->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldContratspostes->creat_by;
        try {
            $oldCrudData['contratssite'] = $oldContratspostes->contratssite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['poste'] = $oldContratspostes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['contratssite_id'])) {
            $Contratspostes->contratssite_id = $data['contratssite_id'];
        }
        if (!empty($data['poste_id'])) {
            $Contratspostes->poste_id = $data['poste_id'];
        }
        if (!empty($data['jours'])) {
            $Contratspostes->jours = $data['jours'];
        }
        if (!empty($data['agentsjour'])) {
            $Contratspostes->agentsjour = $data['agentsjour'];
        }
        if (!empty($data['agentsnuit'])) {
            $Contratspostes->agentsnuit = $data['agentsnuit'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Contratspostes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Contratspostes->creat_by = $data['creat_by'];
        }
        $Contratspostes->save();
        $Contratspostes = \App\Models\Contratsposte::find($Contratspostes->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Contratspostes', 'entite_cle' => $Contratspostes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Contratspostes->toArray();
        return $data;
    }

}
