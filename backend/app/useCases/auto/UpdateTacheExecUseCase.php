<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTacheExecUseCase
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

        $Taches = \App\Models\Tache::find($data['id']);
        $oldTaches = $Taches->replicate();

        $oldCrudData = [];
        $oldCrudData['typestache_id'] = $oldTaches->typestache_id;
        $oldCrudData['libelle'] = $oldTaches->libelle;
        $oldCrudData['pastille'] = $oldTaches->pastille;
        $oldCrudData['Pointeuses'] = $oldTaches->Pointeuses;
        $oldCrudData['identifiants_sadge'] = $oldTaches->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldTaches->creat_by;
        $oldCrudData['site_id'] = $oldTaches->site_id;
        $oldCrudData['ville_id'] = $oldTaches->ville_id;
        $oldCrudData['jours'] = $oldTaches->jours;
        $oldCrudData['code'] = $oldTaches->code;
        $oldCrudData['maxjours'] = $oldTaches->maxjours;
        $oldCrudData['maxnuits'] = $oldTaches->maxnuits;
        $oldCrudData['NbrsJours'] = $oldTaches->NbrsJours;
        $oldCrudData['NbrsNuits'] = $oldTaches->NbrsNuits;
        $oldCrudData['IsCouvert'] = $oldTaches->IsCouvert;
        $oldCrudData['Agentjour'] = $oldTaches->Agentjour;
        $oldCrudData['Agentnuit'] = $oldTaches->Agentnuit;
        $oldCrudData['couvertAgentjour'] = $oldTaches->couvertAgentjour;
        $oldCrudData['couvertAgentnuit'] = $oldTaches->couvertAgentnuit;
        try {
            $oldCrudData['site'] = $oldTaches->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['typestache'] = $oldTaches->typestache->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['ville'] = $oldTaches->ville->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['typestache_id'])) {
            $Taches->typestache_id = $data['typestache_id'];
        }
        if (!empty($data['libelle'])) {
            $Taches->libelle = $data['libelle'];
        }
        if (!empty($data['pastille'])) {
            $Taches->pastille = $data['pastille'];
        }
        if (!empty($data['Pointeuses'])) {
            $Taches->Pointeuses = $data['Pointeuses'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Taches->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Taches->creat_by = $data['creat_by'];
        }
        if (!empty($data['site_id'])) {
            $Taches->site_id = $data['site_id'];
        }
        if (!empty($data['ville_id'])) {
            $Taches->ville_id = $data['ville_id'];
        }
        if (!empty($data['jours'])) {
            $Taches->jours = $data['jours'];
        }
        if (!empty($data['code'])) {
            $Taches->code = $data['code'];
        }
        if (!empty($data['maxjours'])) {
            $Taches->maxjours = $data['maxjours'];
        }
        if (!empty($data['maxnuits'])) {
            $Taches->maxnuits = $data['maxnuits'];
        }
        if (!empty($data['NbrsJours'])) {
            $Taches->NbrsJours = $data['NbrsJours'];
        }
        if (!empty($data['NbrsNuits'])) {
            $Taches->NbrsNuits = $data['NbrsNuits'];
        }
        if (!empty($data['IsCouvert'])) {
            $Taches->IsCouvert = $data['IsCouvert'];
        }
        if (!empty($data['Agentjour'])) {
            $Taches->Agentjour = $data['Agentjour'];
        }
        if (!empty($data['Agentnuit'])) {
            $Taches->Agentnuit = $data['Agentnuit'];
        }
        if (!empty($data['couvertAgentjour'])) {
            $Taches->couvertAgentjour = $data['couvertAgentjour'];
        }
        if (!empty($data['couvertAgentnuit'])) {
            $Taches->couvertAgentnuit = $data['couvertAgentnuit'];
        }
        $Taches->save();
        $Taches = \App\Models\Tache::find($Taches->id);
        $newCrudData = [];
        $newCrudData['typestache_id'] = $Taches->typestache_id;
        $newCrudData['libelle'] = $Taches->libelle;
        $newCrudData['pastille'] = $Taches->pastille;
        $newCrudData['Pointeuses'] = $Taches->Pointeuses;
        $newCrudData['identifiants_sadge'] = $Taches->identifiants_sadge;
        $newCrudData['creat_by'] = $Taches->creat_by;
        $newCrudData['site_id'] = $Taches->site_id;
        $newCrudData['ville_id'] = $Taches->ville_id;
        $newCrudData['jours'] = $Taches->jours;
        $newCrudData['code'] = $Taches->code;
        $newCrudData['maxjours'] = $Taches->maxjours;
        $newCrudData['maxnuits'] = $Taches->maxnuits;
        $newCrudData['NbrsJours'] = $Taches->NbrsJours;
        $newCrudData['NbrsNuits'] = $Taches->NbrsNuits;
        $newCrudData['IsCouvert'] = $Taches->IsCouvert;
        $newCrudData['Agentjour'] = $Taches->Agentjour;
        $newCrudData['Agentnuit'] = $Taches->Agentnuit;
        $newCrudData['couvertAgentjour'] = $Taches->couvertAgentjour;
        $newCrudData['couvertAgentnuit'] = $Taches->couvertAgentnuit;
        try {
            $newCrudData['site'] = $Taches->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['typestache'] = $Taches->typestache->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Taches->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Taches', 'entite_cle' => $Taches->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Taches->toArray();
        return $data;
    }

}
