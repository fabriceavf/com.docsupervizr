<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteInterventionExecUseCase
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

        $Interventions = \App\Models\Intervention::find($data['id']);


        $Interventions->deleted_at = now();
        $Interventions->save();
        $newCrudData = [];
        $newCrudData['ref'] = $Interventions->ref;
        $newCrudData['agent'] = $Interventions->agent;
        $newCrudData['debut_prevu'] = $Interventions->debut_prevu;
        $newCrudData['debut_realise'] = $Interventions->debut_realise;
        $newCrudData['fin_prevu'] = $Interventions->fin_prevu;
        $newCrudData['fin_realise'] = $Interventions->fin_realise;
        $newCrudData['etats'] = $Interventions->etats;
        $newCrudData['site_id'] = $Interventions->site_id;
        $newCrudData['site_libelle'] = $Interventions->site_libelle;
        $newCrudData['client_id'] = $Interventions->client_id;
        $newCrudData['client_libelle'] = $Interventions->client_libelle;
        $newCrudData['identifiants_sadge'] = $Interventions->identifiants_sadge;
        $newCrudData['creat_by'] = $Interventions->creat_by;
        try {
            $newCrudData['client'] = $Interventions->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Interventions->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Interventions', 'entite_cle' => $Interventions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
