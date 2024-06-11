<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteContratssiteExecUseCase
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


        $Contratssites->deleted_at = now();
        $Contratssites->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Contratssites', 'entite_cle' => $Contratssites->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
