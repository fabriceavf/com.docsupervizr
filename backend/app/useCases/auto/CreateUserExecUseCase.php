<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateUserExecUseCase
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

        $Users = new \App\Models\User();

        if (!empty($data['name'])) {
            $Users->name = $data['name'];
        }
        if (!empty($data['nom'])) {
            $Users->nom = $data['nom'];
        }
        if (!empty($data['prenom'])) {
            $Users->prenom = $data['prenom'];
        }
        if (!empty($data['matricule'])) {
            $Users->matricule = $data['matricule'];
        }
        if (!empty($data['num_badge'])) {
            $Users->num_badge = $data['num_badge'];
        }
        if (!empty($data['date_naissance'])) {
            $Users->date_naissance = $data['date_naissance'];
        }
        if (!empty($data['num_cnss'])) {
            $Users->num_cnss = $data['num_cnss'];
        }
        if (!empty($data['num_cnamgs'])) {
            $Users->num_cnamgs = $data['num_cnamgs'];
        }
        if (!empty($data['telephone1'])) {
            $Users->telephone1 = $data['telephone1'];
        }
        if (!empty($data['telephone2'])) {
            $Users->telephone2 = $data['telephone2'];
        }
        if (!empty($data['photo'])) {
            $Users->photo = $data['photo'];
        }
        if (!empty($data['date_embauche'])) {
            $Users->date_embauche = $data['date_embauche'];
        }
        if (!empty($data['download_date'])) {
            $Users->download_date = $data['download_date'];
        }
        if (!empty($data['actif_id'])) {
            $Users->actif_id = $data['actif_id'];
        }
        if (!empty($data['nationalite_id'])) {
            $Users->nationalite_id = $data['nationalite_id'];
        }
        if (!empty($data['contrat_id'])) {
            $Users->contrat_id = $data['contrat_id'];
        }
        if (!empty($data['direction_id'])) {
            $Users->direction_id = $data['direction_id'];
        }
        if (!empty($data['categorie_id'])) {
            $Users->categorie_id = $data['categorie_id'];
        }
        if (!empty($data['echelon_id'])) {
            $Users->echelon_id = $data['echelon_id'];
        }
        if (!empty($data['sexe_id'])) {
            $Users->sexe_id = $data['sexe_id'];
        }
        if (!empty($data['matrimoniale_id'])) {
            $Users->matrimoniale_id = $data['matrimoniale_id'];
        }
        if (!empty($data['poste_id'])) {
            $Users->poste_id = $data['poste_id'];
        }
        if (!empty($data['ville_id'])) {
            $Users->ville_id = $data['ville_id'];
        }
        if (!empty($data['zone_id'])) {
            $Users->zone_id = $data['zone_id'];
        }
        if (!empty($data['site_id'])) {
            $Users->site_id = $data['site_id'];
        }
        if (!empty($data['situation_id'])) {
            $Users->situation_id = $data['situation_id'];
        }
        if (!empty($data['balise_id'])) {
            $Users->balise_id = $data['balise_id'];
        }
        if (!empty($data['fonction_id'])) {
            $Users->fonction_id = $data['fonction_id'];
        }
        if (!empty($data['user_id'])) {
            $Users->user_id = $data['user_id'];
        }
        if (!empty($data['email'])) {
            $Users->email = $data['email'];
        }
        if (!empty($data['password'])) {
            $Users->password = $data['password'];
        }
        if (!empty($data['emp_code'])) {
            $Users->emp_code = $data['emp_code'];
        }
        if (!empty($data['nombre_enfant'])) {
            $Users->nombre_enfant = $data['nombre_enfant'];
        }
        if (!empty($data['num_dossier'])) {
            $Users->num_dossier = $data['num_dossier'];
        }
        if (!empty($data['online_id'])) {
            $Users->online_id = $data['online_id'];
        }
        if (!empty($data['type_id'])) {
            $Users->type_id = $data['type_id'];
        }
        if (!empty($data['faction_id'])) {
            $Users->faction_id = $data['faction_id'];
        }
        if (!empty($data['role_id'])) {
            $Users->role_id = $data['role_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Users->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Users->creat_by = $data['creat_by'];
        }
        if (!empty($data['typeseffectif_id'])) {
            $Users->typeseffectif_id = $data['typeseffectif_id'];
        }
        if (!empty($data['postes'])) {
            $Users->postes = $data['postes'];
        }
        $Users->save();
        $Users = \App\Models\User::find($Users->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Users', 'entite_cle' => $Users->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Users->toArray();
        return $data;
    }

}
