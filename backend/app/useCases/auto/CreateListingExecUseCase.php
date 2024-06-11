<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateListingExecUseCase
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

        $Listings = new \App\Models\Listing();

        if (!empty($data['date'])) {
            $Listings->date = $data['date'];
        }
        if (!empty($data['id_user'])) {
            $Listings->id_user = $data['id_user'];
        }
        if (!empty($data['name'])) {
            $Listings->name = $data['name'];
        }
        if (!empty($data['nom'])) {
            $Listings->nom = $data['nom'];
        }
        if (!empty($data['prenom'])) {
            $Listings->prenom = $data['prenom'];
        }
        if (!empty($data['matricule'])) {
            $Listings->matricule = $data['matricule'];
        }
        if (!empty($data['num_badge'])) {
            $Listings->num_badge = $data['num_badge'];
        }
        if (!empty($data['actif_id'])) {
            $Listings->actif_id = $data['actif_id'];
        }
        if (!empty($data['nationalite_id'])) {
            $Listings->nationalite_id = $data['nationalite_id'];
        }
        if (!empty($data['contrat_id'])) {
            $Listings->contrat_id = $data['contrat_id'];
        }
        if (!empty($data['direction_id'])) {
            $Listings->direction_id = $data['direction_id'];
        }
        if (!empty($data['categorie_id'])) {
            $Listings->categorie_id = $data['categorie_id'];
        }
        if (!empty($data['echelon_id'])) {
            $Listings->echelon_id = $data['echelon_id'];
        }
        if (!empty($data['sexe_id'])) {
            $Listings->sexe_id = $data['sexe_id'];
        }
        if (!empty($data['matrimoniale_id'])) {
            $Listings->matrimoniale_id = $data['matrimoniale_id'];
        }
        if (!empty($data['poste_id'])) {
            $Listings->poste_id = $data['poste_id'];
        }
        if (!empty($data['ville_id'])) {
            $Listings->ville_id = $data['ville_id'];
        }
        if (!empty($data['zone_id'])) {
            $Listings->zone_id = $data['zone_id'];
        }
        if (!empty($data['situation_id'])) {
            $Listings->situation_id = $data['situation_id'];
        }
        if (!empty($data['balise_id'])) {
            $Listings->balise_id = $data['balise_id'];
        }
        if (!empty($data['fonction_id'])) {
            $Listings->fonction_id = $data['fonction_id'];
        }
        if (!empty($data['emp_code'])) {
            $Listings->emp_code = $data['emp_code'];
        }
        if (!empty($data['online_id'])) {
            $Listings->online_id = $data['online_id'];
        }
        if (!empty($data['type_id'])) {
            $Listings->type_id = $data['type_id'];
        }
        if (!empty($data['faction_id'])) {
            $Listings->faction_id = $data['faction_id'];
        }
        if (!empty($data['present'])) {
            $Listings->present = $data['present'];
        }
        if (!empty($data['site_id'])) {
            $Listings->site_id = $data['site_id'];
        }
        if (!empty($data['client_id'])) {
            $Listings->client_id = $data['client_id'];
        }
        if (!empty($data['id_date'])) {
            $Listings->id_date = $data['id_date'];
        }
        $Listings->save();
        $Listings = \App\Models\Listing::find($Listings->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Listings', 'entite_cle' => $Listings->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Listings->toArray();
        return $data;
    }

}
