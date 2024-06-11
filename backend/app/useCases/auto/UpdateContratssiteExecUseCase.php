<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateContratssiteExecUseCase
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

        $Contratssites = \App\Models\Contratssite::find($data['id']);
        $oldContratssites = $Contratssites->replicate();

        $oldCrudData = [];
        $oldCrudData['contratsclient_id'] = $oldContratssites->contratsclient_id;
        $oldCrudData['site_id'] = $oldContratssites->site_id;
        $oldCrudData['prestation_id'] = $oldContratssites->prestation_id;
        $oldCrudData['agentsjour'] = $oldContratssites->agentsjour;
        $oldCrudData['agentsnuit'] = $oldContratssites->agentsnuit;
        $oldCrudData['identifiants_sadge'] = $oldContratssites->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldContratssites->creat_by;
        try {
            $oldCrudData['contratsclient'] = $oldContratssites->contratsclient->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['prestation'] = $oldContratssites->prestation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['site'] = $oldContratssites->site->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['contratsclient_id'])) {
            $Contratssites->contratsclient_id = $data['contratsclient_id'];
        }
        if (!empty($data['site_id'])) {
            $Contratssites->site_id = $data['site_id'];
        }
        if (!empty($data['prestation_id'])) {
            $Contratssites->prestation_id = $data['prestation_id'];
        }
        if (!empty($data['agentsjour'])) {
            $Contratssites->agentsjour = $data['agentsjour'];
        }
        if (!empty($data['agentsnuit'])) {
            $Contratssites->agentsnuit = $data['agentsnuit'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Contratssites->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Contratssites->creat_by = $data['creat_by'];
        }
        $Contratssites->save();
        $Contratssites = \App\Models\Contratssite::find($Contratssites->id);
        $newCrudData = [];
        $newCrudData['contratsclient_id'] = $Contratssites->contratsclient_id;
        $newCrudData['site_id'] = $Contratssites->site_id;
        $newCrudData['prestation_id'] = $Contratssites->prestation_id;
        $newCrudData['agentsjour'] = $Contratssites->agentsjour;
        $newCrudData['agentsnuit'] = $Contratssites->agentsnuit;
        $newCrudData['identifiants_sadge'] = $Contratssites->identifiants_sadge;
        $newCrudData['creat_by'] = $Contratssites->creat_by;
        try {
            $newCrudData['contratsclient'] = $Contratssites->contratsclient->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['prestation'] = $Contratssites->prestation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Contratssites->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Contratssites', 'entite_cle' => $Contratssites->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Contratssites->toArray();
        return $data;
    }

}
