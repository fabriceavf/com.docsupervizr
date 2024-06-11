<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteUserExecUseCase
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

        $Users = \App\Models\User::find($data['id']);


        $Users->deleted_at = now();
        $Users->save();
        $newCrudData = [];
        $newCrudData['name'] = $Users->name;
        $newCrudData['nom'] = $Users->nom;
        $newCrudData['prenom'] = $Users->prenom;
        $newCrudData['matricule'] = $Users->matricule;
        $newCrudData['num_badge'] = $Users->num_badge;
        $newCrudData['date_naissance'] = $Users->date_naissance;
        $newCrudData['num_cnss'] = $Users->num_cnss;
        $newCrudData['num_cnamgs'] = $Users->num_cnamgs;
        $newCrudData['telephone1'] = $Users->telephone1;
        $newCrudData['telephone2'] = $Users->telephone2;
        $newCrudData['photo'] = $Users->photo;
        $newCrudData['date_embauche'] = $Users->date_embauche;
        $newCrudData['download_date'] = $Users->download_date;
        $newCrudData['actif_id'] = $Users->actif_id;
        $newCrudData['nationalite_id'] = $Users->nationalite_id;
        $newCrudData['contrat_id'] = $Users->contrat_id;
        $newCrudData['direction_id'] = $Users->direction_id;
        $newCrudData['categorie_id'] = $Users->categorie_id;
        $newCrudData['echelon_id'] = $Users->echelon_id;
        $newCrudData['sexe_id'] = $Users->sexe_id;
        $newCrudData['matrimoniale_id'] = $Users->matrimoniale_id;
        $newCrudData['poste_id'] = $Users->poste_id;
        $newCrudData['ville_id'] = $Users->ville_id;
        $newCrudData['zone_id'] = $Users->zone_id;
        $newCrudData['site_id'] = $Users->site_id;
        $newCrudData['situation_id'] = $Users->situation_id;
        $newCrudData['balise_id'] = $Users->balise_id;
        $newCrudData['fonction_id'] = $Users->fonction_id;
        $newCrudData['user_id'] = $Users->user_id;
        $newCrudData['email'] = $Users->email;
        $newCrudData['password'] = $Users->password;
        $newCrudData['emp_code'] = $Users->emp_code;
        $newCrudData['nombre_enfant'] = $Users->nombre_enfant;
        $newCrudData['num_dossier'] = $Users->num_dossier;
        $newCrudData['online_id'] = $Users->online_id;
        $newCrudData['type_id'] = $Users->type_id;
        $newCrudData['faction_id'] = $Users->faction_id;
        $newCrudData['role_id'] = $Users->role_id;
        $newCrudData['identifiants_sadge'] = $Users->identifiants_sadge;
        $newCrudData['creat_by'] = $Users->creat_by;
        $newCrudData['typeseffectif_id'] = $Users->typeseffectif_id;
        $newCrudData['postes'] = $Users->postes;
        try {
            $newCrudData['actif'] = $Users->actif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['balise'] = $Users->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['categorie'] = $Users->categorie->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['contrat'] = $Users->contrat->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['direction'] = $Users->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Users->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Users->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Users->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Users->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['nationalite'] = $Users->nationalite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Users->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Users->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['role'] = $Users->role->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Users->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Users->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Users->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Users->type->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['typeseffectif'] = $Users->typeseffectif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Users->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Users->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Users->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Users', 'entite_cle' => $Users->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
