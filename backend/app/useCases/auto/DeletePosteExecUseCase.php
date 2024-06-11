<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePosteExecUseCase
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

        $Postes = \App\Models\Poste::find($data['id']);


        $Postes->deleted_at = now();
        $Postes->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Postes', 'entite_cle' => $Postes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
