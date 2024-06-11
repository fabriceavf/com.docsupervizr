<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePosteExecUseCase
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

        $Postes = new \App\Models\Poste();

        if (!empty($data['code'])) {
            $Postes->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Postes->libelle = $data['libelle'];
        }
        if (!empty($data['nature'])) {
            $Postes->nature = $data['nature'];
        }
        if (!empty($data['coordonnees'])) {
            $Postes->coordonnees = $data['coordonnees'];
        }
        if (!empty($data['site_id'])) {
            $Postes->site_id = $data['site_id'];
        }
        if (!empty($data['jours'])) {
            $Postes->jours = $data['jours'];
        }
        if (!empty($data['contratsclient_id'])) {
            $Postes->contratsclient_id = $data['contratsclient_id'];
        }
        if (!empty($data['maxjours'])) {
            $Postes->maxjours = $data['maxjours'];
        }
        if (!empty($data['maxnuits'])) {
            $Postes->maxnuits = $data['maxnuits'];
        }
        if (!empty($data['NbrsJours'])) {
            $Postes->NbrsJours = $data['NbrsJours'];
        }
        if (!empty($data['NbrsNuits'])) {
            $Postes->NbrsNuits = $data['NbrsNuits'];
        }
        if (!empty($data['IsCouvert'])) {
            $Postes->IsCouvert = $data['IsCouvert'];
        }
        if (!empty($data['pointeuses'])) {
            $Postes->pointeuses = $data['pointeuses'];
        }
        if (!empty($data['Agentjour'])) {
            $Postes->Agentjour = $data['Agentjour'];
        }
        if (!empty($data['Agentnuit'])) {
            $Postes->Agentnuit = $data['Agentnuit'];
        }
        if (!empty($data['couvertAgentjour'])) {
            $Postes->couvertAgentjour = $data['couvertAgentjour'];
        }
        if (!empty($data['couvertAgentnuit'])) {
            $Postes->couvertAgentnuit = $data['couvertAgentnuit'];
        }
        if (!empty($data['type'])) {
            $Postes->type = $data['type'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Postes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Postes->creat_by = $data['creat_by'];
        }
        if (!empty($data['typeagents'])) {
            $Postes->typeagents = $data['typeagents'];
        }
        if (!empty($data['typesposte_id'])) {
            $Postes->typesposte_id = $data['typesposte_id'];
        }
        if (!empty($data['postesarticle_id'])) {
            $Postes->postesarticle_id = $data['postesarticle_id'];
        }
        $Postes->save();
        $Postes = \App\Models\Poste::find($Postes->id);
        $newCrudData = [];
        $newCrudData['code'] = $Postes->code;
        $newCrudData['libelle'] = $Postes->libelle;
        $newCrudData['nature'] = $Postes->nature;
        $newCrudData['coordonnees'] = $Postes->coordonnees;
        $newCrudData['site_id'] = $Postes->site_id;
        $newCrudData['jours'] = $Postes->jours;
        $newCrudData['contratsclient_id'] = $Postes->contratsclient_id;
        $newCrudData['maxjours'] = $Postes->maxjours;
        $newCrudData['maxnuits'] = $Postes->maxnuits;
        $newCrudData['NbrsJours'] = $Postes->NbrsJours;
        $newCrudData['NbrsNuits'] = $Postes->NbrsNuits;
        $newCrudData['IsCouvert'] = $Postes->IsCouvert;
        $newCrudData['pointeuses'] = $Postes->pointeuses;
        $newCrudData['Agentjour'] = $Postes->Agentjour;
        $newCrudData['Agentnuit'] = $Postes->Agentnuit;
        $newCrudData['couvertAgentjour'] = $Postes->couvertAgentjour;
        $newCrudData['couvertAgentnuit'] = $Postes->couvertAgentnuit;
        $newCrudData['type'] = $Postes->type;
        $newCrudData['identifiants_sadge'] = $Postes->identifiants_sadge;
        $newCrudData['creat_by'] = $Postes->creat_by;
        $newCrudData['typeagents'] = $Postes->typeagents;
        $newCrudData['typesposte_id'] = $Postes->typesposte_id;
        $newCrudData['postesarticle_id'] = $Postes->postesarticle_id;
        try {
            $newCrudData['contratsclient'] = $Postes->contratsclient->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['postesarticle'] = $Postes->postesarticle->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Postes->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['typesposte'] = $Postes->typesposte->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Postes', 'entite_cle' => $Postes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Postes->toArray();
        return $data;
    }

}
