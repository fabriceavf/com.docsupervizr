<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteListingExecUseCase
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

        $Listings = \App\Models\Listing::find($data['id']);


        $Listings->deleted_at = now();
        $Listings->save();
        $newCrudData = [];
        $newCrudData['date'] = $Listings->date;
        $newCrudData['id_user'] = $Listings->id_user;
        $newCrudData['name'] = $Listings->name;
        $newCrudData['nom'] = $Listings->nom;
        $newCrudData['prenom'] = $Listings->prenom;
        $newCrudData['matricule'] = $Listings->matricule;
        $newCrudData['num_badge'] = $Listings->num_badge;
        $newCrudData['actif_id'] = $Listings->actif_id;
        $newCrudData['nationalite_id'] = $Listings->nationalite_id;
        $newCrudData['contrat_id'] = $Listings->contrat_id;
        $newCrudData['direction_id'] = $Listings->direction_id;
        $newCrudData['categorie_id'] = $Listings->categorie_id;
        $newCrudData['echelon_id'] = $Listings->echelon_id;
        $newCrudData['sexe_id'] = $Listings->sexe_id;
        $newCrudData['matrimoniale_id'] = $Listings->matrimoniale_id;
        $newCrudData['poste_id'] = $Listings->poste_id;
        $newCrudData['ville_id'] = $Listings->ville_id;
        $newCrudData['zone_id'] = $Listings->zone_id;
        $newCrudData['situation_id'] = $Listings->situation_id;
        $newCrudData['balise_id'] = $Listings->balise_id;
        $newCrudData['fonction_id'] = $Listings->fonction_id;
        $newCrudData['emp_code'] = $Listings->emp_code;
        $newCrudData['online_id'] = $Listings->online_id;
        $newCrudData['type_id'] = $Listings->type_id;
        $newCrudData['faction_id'] = $Listings->faction_id;
        $newCrudData['present'] = $Listings->present;
        $newCrudData['site_id'] = $Listings->site_id;
        $newCrudData['client_id'] = $Listings->client_id;
        $newCrudData['id_date'] = $Listings->id_date;
        try {
            $newCrudData['actif'] = $Listings->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Listings->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Listings->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['client'] = $Listings->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Listings->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Listings->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Listings->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Listings->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Listings->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Listings->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Listings->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Listings->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Listings->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Listings->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Listings->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Listings->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Listings->type->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Listings->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Listings->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Listings', 'entite_cle' => $Listings->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
