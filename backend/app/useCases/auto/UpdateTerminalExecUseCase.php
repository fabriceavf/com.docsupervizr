<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTerminalExecUseCase
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

        $Terminals = \App\Models\Terminal::find($data['id']);
        $oldTerminals = $Terminals->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldTerminals->code;
        $oldCrudData['adresse_mac'] = $oldTerminals->adresse_mac;
        $oldCrudData['etat'] = $oldTerminals->etat;
        $oldCrudData['alimentation'] = $oldTerminals->alimentation;
        $oldCrudData['reseau'] = $oldTerminals->reseau;
        $oldCrudData['voiture_id'] = $oldTerminals->voiture_id;
        $oldCrudData['creat_by'] = $oldTerminals->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldTerminals->identifiants_sadge;
        try {
            $oldCrudData['voiture'] = $oldTerminals->voiture->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['code'])) {
            $Terminals->code = $data['code'];
        }
        if (!empty($data['adresse_mac'])) {
            $Terminals->adresse_mac = $data['adresse_mac'];
        }
        if (!empty($data['etat'])) {
            $Terminals->etat = $data['etat'];
        }
        if (!empty($data['alimentation'])) {
            $Terminals->alimentation = $data['alimentation'];
        }
        if (!empty($data['reseau'])) {
            $Terminals->reseau = $data['reseau'];
        }
        if (!empty($data['voiture_id'])) {
            $Terminals->voiture_id = $data['voiture_id'];
        }
        if (!empty($data['creat_by'])) {
            $Terminals->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Terminals->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Terminals->save();
        $Terminals = \App\Models\Terminal::find($Terminals->id);
        $newCrudData = [];
        $newCrudData['code'] = $Terminals->code;
        $newCrudData['adresse_mac'] = $Terminals->adresse_mac;
        $newCrudData['etat'] = $Terminals->etat;
        $newCrudData['alimentation'] = $Terminals->alimentation;
        $newCrudData['reseau'] = $Terminals->reseau;
        $newCrudData['voiture_id'] = $Terminals->voiture_id;
        $newCrudData['creat_by'] = $Terminals->creat_by;
        $newCrudData['identifiants_sadge'] = $Terminals->identifiants_sadge;
        try {
            $newCrudData['voiture'] = $Terminals->voiture->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Terminals', 'entite_cle' => $Terminals->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Terminals->toArray();
        return $data;
    }

}
