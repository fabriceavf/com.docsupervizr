<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteSiteExecUseCase
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

        $Sites = \App\Models\Site::find($data['id']);


        $Sites->deleted_at = now();
        $Sites->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Sites->libelle;
        $newCrudData['client_id'] = $Sites->client_id;
        $newCrudData['zone_id'] = $Sites->zone_id;
        $newCrudData['pointeuse_id'] = $Sites->pointeuse_id;
        $newCrudData['NbrsJours'] = $Sites->NbrsJours;
        $newCrudData['NbrsNuits'] = $Sites->NbrsNuits;
        $newCrudData['type'] = $Sites->type;
        $newCrudData['identifiants_sadge'] = $Sites->identifiants_sadge;
        $newCrudData['creat_by'] = $Sites->creat_by;
        $newCrudData['pastille'] = $Sites->pastille;
        $newCrudData['typessite_id'] = $Sites->typessite_id;
        $newCrudData['date_debut'] = $Sites->date_debut;
        $newCrudData['date_fin'] = $Sites->date_fin;
        try {
            $newCrudData['client'] = $Sites->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $Sites->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['typessite'] = $Sites->typessite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Sites->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Sites', 'entite_cle' => $Sites->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
