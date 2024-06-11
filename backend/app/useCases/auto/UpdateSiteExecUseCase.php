<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateSiteExecUseCase
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
        $oldSites = $Sites->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldSites->libelle;
        $oldCrudData['client_id'] = $oldSites->client_id;
        $oldCrudData['zone_id'] = $oldSites->zone_id;
        $oldCrudData['pointeuse_id'] = $oldSites->pointeuse_id;
        $oldCrudData['NbrsJours'] = $oldSites->NbrsJours;
        $oldCrudData['NbrsNuits'] = $oldSites->NbrsNuits;
        $oldCrudData['type'] = $oldSites->type;
        $oldCrudData['identifiants_sadge'] = $oldSites->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldSites->creat_by;
        $oldCrudData['pastille'] = $oldSites->pastille;
        $oldCrudData['typessite_id'] = $oldSites->typessite_id;
        $oldCrudData['date_debut'] = $oldSites->date_debut;
        $oldCrudData['date_fin'] = $oldSites->date_fin;
        try {
            $oldCrudData['client'] = $oldSites->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['pointeuse'] = $oldSites->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['typessite'] = $oldSites->typessite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $oldSites->zone->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Sites->libelle = $data['libelle'];
        }
        if (!empty($data['client_id'])) {
            $Sites->client_id = $data['client_id'];
        }
        if (!empty($data['zone_id'])) {
            $Sites->zone_id = $data['zone_id'];
        }
        if (!empty($data['pointeuse_id'])) {
            $Sites->pointeuse_id = $data['pointeuse_id'];
        }
        if (!empty($data['NbrsJours'])) {
            $Sites->NbrsJours = $data['NbrsJours'];
        }
        if (!empty($data['NbrsNuits'])) {
            $Sites->NbrsNuits = $data['NbrsNuits'];
        }
        if (!empty($data['type'])) {
            $Sites->type = $data['type'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Sites->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Sites->creat_by = $data['creat_by'];
        }
        if (!empty($data['pastille'])) {
            $Sites->pastille = $data['pastille'];
        }
        if (!empty($data['typessite_id'])) {
            $Sites->typessite_id = $data['typessite_id'];
        }
        if (!empty($data['date_debut'])) {
            $Sites->date_debut = $data['date_debut'];
        }
        if (!empty($data['date_fin'])) {
            $Sites->date_fin = $data['date_fin'];
        }
        $Sites->save();
        $Sites = \App\Models\Site::find($Sites->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Sites', 'entite_cle' => $Sites->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Sites->toArray();
        return $data;
    }

}
