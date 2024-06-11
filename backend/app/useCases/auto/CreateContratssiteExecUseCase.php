<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateContratssiteExecUseCase
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

        $Contratssites = new \App\Models\Contratssite();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Contratssites', 'entite_cle' => $Contratssites->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Contratssites->toArray();
        return $data;
    }

}
