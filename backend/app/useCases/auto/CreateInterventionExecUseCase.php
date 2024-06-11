<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateInterventionExecUseCase
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

        $Interventions = new \App\Models\Intervention();

        if (!empty($data['ref'])) {
            $Interventions->ref = $data['ref'];
        }
        if (!empty($data['agent'])) {
            $Interventions->agent = $data['agent'];
        }
        if (!empty($data['debut_prevu'])) {
            $Interventions->debut_prevu = $data['debut_prevu'];
        }
        if (!empty($data['debut_realise'])) {
            $Interventions->debut_realise = $data['debut_realise'];
        }
        if (!empty($data['fin_prevu'])) {
            $Interventions->fin_prevu = $data['fin_prevu'];
        }
        if (!empty($data['fin_realise'])) {
            $Interventions->fin_realise = $data['fin_realise'];
        }
        if (!empty($data['etats'])) {
            $Interventions->etats = $data['etats'];
        }
        if (!empty($data['site_id'])) {
            $Interventions->site_id = $data['site_id'];
        }
        if (!empty($data['site_libelle'])) {
            $Interventions->site_libelle = $data['site_libelle'];
        }
        if (!empty($data['client_id'])) {
            $Interventions->client_id = $data['client_id'];
        }
        if (!empty($data['client_libelle'])) {
            $Interventions->client_libelle = $data['client_libelle'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Interventions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Interventions->creat_by = $data['creat_by'];
        }
        $Interventions->save();
        $Interventions = \App\Models\Intervention::find($Interventions->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Interventions', 'entite_cle' => $Interventions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Interventions->toArray();
        return $data;
    }

}
