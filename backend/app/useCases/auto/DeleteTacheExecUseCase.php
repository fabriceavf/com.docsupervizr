<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTacheExecUseCase
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


        $Taches->deleted_at = now();
        $Taches->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Taches', 'entite_cle' => $Taches->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
