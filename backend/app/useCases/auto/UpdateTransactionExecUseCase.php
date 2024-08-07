<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTransactionExecUseCase
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

        $Transactions = \App\Models\Transaction::find($data['id']);
        $oldTransactions = $Transactions->replicate();

        $oldCrudData = [];
        $oldCrudData['bio_id'] = $oldTransactions->bio_id;
        $oldCrudData['area_alias'] = $oldTransactions->area_alias;
        $oldCrudData['first_name'] = $oldTransactions->first_name;
        $oldCrudData['last_name'] = $oldTransactions->last_name;
        $oldCrudData['card_no'] = $oldTransactions->card_no;
        $oldCrudData['terminal_alias'] = $oldTransactions->terminal_alias;
        $oldCrudData['emp_code'] = $oldTransactions->emp_code;
        $oldCrudData['punch_date'] = $oldTransactions->punch_date;
        $oldCrudData['punch_time'] = $oldTransactions->punch_time;
        $oldCrudData['nom'] = $oldTransactions->nom;
        $oldCrudData['prenom'] = $oldTransactions->prenom;
        $oldCrudData['matricule'] = $oldTransactions->matricule;
        $oldCrudData['echelon_id'] = $oldTransactions->echelon_id;
        $oldCrudData['sexe_id'] = $oldTransactions->sexe_id;
        $oldCrudData['matrimoniale_id'] = $oldTransactions->matrimoniale_id;
        $oldCrudData['poste_id'] = $oldTransactions->poste_id;
        $oldCrudData['ville_id'] = $oldTransactions->ville_id;
        $oldCrudData['zone_id'] = $oldTransactions->zone_id;
        $oldCrudData['situation_id'] = $oldTransactions->situation_id;
        $oldCrudData['balise_id'] = $oldTransactions->balise_id;
        $oldCrudData['fonction_id'] = $oldTransactions->fonction_id;
        $oldCrudData['online_id'] = $oldTransactions->online_id;
        $oldCrudData['faction_id'] = $oldTransactions->faction_id;
        $oldCrudData['pointeuse_id'] = $oldTransactions->pointeuse_id;
        $oldCrudData['site_id'] = $oldTransactions->site_id;
        $oldCrudData['client_id'] = $oldTransactions->client_id;
        $oldCrudData['annuler'] = $oldTransactions->annuler;
        $oldCrudData['type'] = $oldTransactions->type;
        $oldCrudData['traiter'] = $oldTransactions->traiter;
        $oldCrudData['pointeusepostes'] = $oldTransactions->pointeusepostes;
        $oldCrudData['verification'] = $oldTransactions->verification;
        $oldCrudData['rechercheetape'] = $oldTransactions->rechercheetape;
        $oldCrudData['tache'] = $oldTransactions->tache;
        $oldCrudData['poste'] = $oldTransactions->poste;
        $oldCrudData['TachesPotentiels'] = $oldTransactions->TachesPotentiels;
        $oldCrudData['PostesPotentiels'] = $oldTransactions->PostesPotentiels;
        $oldCrudData['TotalPostes'] = $oldTransactions->TotalPostes;
        $oldCrudData['TotalPostescouvert'] = $oldTransactions->TotalPostescouvert;
        $oldCrudData['TotalPostesnoncouvert'] = $oldTransactions->TotalPostesnoncouvert;
        $oldCrudData['TotalPostessouscouvert'] = $oldTransactions->TotalPostessouscouvert;
        $oldCrudData['heure'] = $oldTransactions->heure;
        $oldCrudData['identifiants_sadge'] = $oldTransactions->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldTransactions->creat_by;
        $oldCrudData['etats'] = $oldTransactions->etats;
        $oldCrudData['identification_id'] = $oldTransactions->identification_id;
        $oldCrudData['controlleursacce_id'] = $oldTransactions->controlleursacce_id;
        $oldCrudData['carte_id'] = $oldTransactions->carte_id;
        $oldCrudData['cout'] = $oldTransactions->cout;
        try {
            $oldCrudData['balise'] = $oldTransactions->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['carte'] = $oldTransactions->carte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['client'] = $oldTransactions->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['controlleursacce'] = $oldTransactions->controlleursacce->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['echelon'] = $oldTransactions->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['faction'] = $oldTransactions->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['fonction'] = $oldTransactions->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['identification'] = $oldTransactions->identification->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['matrimoniale'] = $oldTransactions->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['online'] = $oldTransactions->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['pointeuse'] = $oldTransactions->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['poste'] = $oldTransactions->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['sexe'] = $oldTransactions->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['site'] = $oldTransactions->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['situation'] = $oldTransactions->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['ville'] = $oldTransactions->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $oldTransactions->zone->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['bio_id'])) {
            $Transactions->bio_id = $data['bio_id'];
        }
        if (!empty($data['area_alias'])) {
            $Transactions->area_alias = $data['area_alias'];
        }
        if (!empty($data['first_name'])) {
            $Transactions->first_name = $data['first_name'];
        }
        if (!empty($data['last_name'])) {
            $Transactions->last_name = $data['last_name'];
        }
        if (!empty($data['card_no'])) {
            $Transactions->card_no = $data['card_no'];
        }
        if (!empty($data['terminal_alias'])) {
            $Transactions->terminal_alias = $data['terminal_alias'];
        }
        if (!empty($data['emp_code'])) {
            $Transactions->emp_code = $data['emp_code'];
        }
        if (!empty($data['punch_date'])) {
            $Transactions->punch_date = $data['punch_date'];
        }
        if (!empty($data['punch_time'])) {
            $Transactions->punch_time = $data['punch_time'];
        }
        if (!empty($data['nom'])) {
            $Transactions->nom = $data['nom'];
        }
        if (!empty($data['prenom'])) {
            $Transactions->prenom = $data['prenom'];
        }
        if (!empty($data['matricule'])) {
            $Transactions->matricule = $data['matricule'];
        }
        if (!empty($data['echelon_id'])) {
            $Transactions->echelon_id = $data['echelon_id'];
        }
        if (!empty($data['sexe_id'])) {
            $Transactions->sexe_id = $data['sexe_id'];
        }
        if (!empty($data['matrimoniale_id'])) {
            $Transactions->matrimoniale_id = $data['matrimoniale_id'];
        }
        if (!empty($data['poste_id'])) {
            $Transactions->poste_id = $data['poste_id'];
        }
        if (!empty($data['ville_id'])) {
            $Transactions->ville_id = $data['ville_id'];
        }
        if (!empty($data['zone_id'])) {
            $Transactions->zone_id = $data['zone_id'];
        }
        if (!empty($data['situation_id'])) {
            $Transactions->situation_id = $data['situation_id'];
        }
        if (!empty($data['balise_id'])) {
            $Transactions->balise_id = $data['balise_id'];
        }
        if (!empty($data['fonction_id'])) {
            $Transactions->fonction_id = $data['fonction_id'];
        }
        if (!empty($data['online_id'])) {
            $Transactions->online_id = $data['online_id'];
        }
        if (!empty($data['faction_id'])) {
            $Transactions->faction_id = $data['faction_id'];
        }
        if (!empty($data['pointeuse_id'])) {
            $Transactions->pointeuse_id = $data['pointeuse_id'];
        }
        if (!empty($data['site_id'])) {
            $Transactions->site_id = $data['site_id'];
        }
        if (!empty($data['client_id'])) {
            $Transactions->client_id = $data['client_id'];
        }
        if (!empty($data['annuler'])) {
            $Transactions->annuler = $data['annuler'];
        }
        if (!empty($data['type'])) {
            $Transactions->type = $data['type'];
        }
        if (!empty($data['traiter'])) {
            $Transactions->traiter = $data['traiter'];
        }
        if (!empty($data['pointeusepostes'])) {
            $Transactions->pointeusepostes = $data['pointeusepostes'];
        }
        if (!empty($data['verification'])) {
            $Transactions->verification = $data['verification'];
        }
        if (!empty($data['rechercheetape'])) {
            $Transactions->rechercheetape = $data['rechercheetape'];
        }
        if (!empty($data['tache'])) {
            $Transactions->tache = $data['tache'];
        }
        if (!empty($data['poste'])) {
            $Transactions->poste = $data['poste'];
        }
        if (!empty($data['TachesPotentiels'])) {
            $Transactions->TachesPotentiels = $data['TachesPotentiels'];
        }
        if (!empty($data['PostesPotentiels'])) {
            $Transactions->PostesPotentiels = $data['PostesPotentiels'];
        }
        if (!empty($data['TotalPostes'])) {
            $Transactions->TotalPostes = $data['TotalPostes'];
        }
        if (!empty($data['TotalPostescouvert'])) {
            $Transactions->TotalPostescouvert = $data['TotalPostescouvert'];
        }
        if (!empty($data['TotalPostesnoncouvert'])) {
            $Transactions->TotalPostesnoncouvert = $data['TotalPostesnoncouvert'];
        }
        if (!empty($data['TotalPostessouscouvert'])) {
            $Transactions->TotalPostessouscouvert = $data['TotalPostessouscouvert'];
        }
        if (!empty($data['heure'])) {
            $Transactions->heure = $data['heure'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Transactions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Transactions->creat_by = $data['creat_by'];
        }
        if (!empty($data['etats'])) {
            $Transactions->etats = $data['etats'];
        }
        if (!empty($data['identification_id'])) {
            $Transactions->identification_id = $data['identification_id'];
        }
        if (!empty($data['controlleursacce_id'])) {
            $Transactions->controlleursacce_id = $data['controlleursacce_id'];
        }
        if (!empty($data['carte_id'])) {
            $Transactions->carte_id = $data['carte_id'];
        }
        if (!empty($data['cout'])) {
            $Transactions->cout = $data['cout'];
        }
        $Transactions->save();
        $Transactions = \App\Models\Transaction::find($Transactions->id);
        $newCrudData = [];
        $newCrudData['bio_id'] = $Transactions->bio_id;
        $newCrudData['area_alias'] = $Transactions->area_alias;
        $newCrudData['first_name'] = $Transactions->first_name;
        $newCrudData['last_name'] = $Transactions->last_name;
        $newCrudData['card_no'] = $Transactions->card_no;
        $newCrudData['terminal_alias'] = $Transactions->terminal_alias;
        $newCrudData['emp_code'] = $Transactions->emp_code;
        $newCrudData['punch_date'] = $Transactions->punch_date;
        $newCrudData['punch_time'] = $Transactions->punch_time;
        $newCrudData['nom'] = $Transactions->nom;
        $newCrudData['prenom'] = $Transactions->prenom;
        $newCrudData['matricule'] = $Transactions->matricule;
        $newCrudData['echelon_id'] = $Transactions->echelon_id;
        $newCrudData['sexe_id'] = $Transactions->sexe_id;
        $newCrudData['matrimoniale_id'] = $Transactions->matrimoniale_id;
        $newCrudData['poste_id'] = $Transactions->poste_id;
        $newCrudData['ville_id'] = $Transactions->ville_id;
        $newCrudData['zone_id'] = $Transactions->zone_id;
        $newCrudData['situation_id'] = $Transactions->situation_id;
        $newCrudData['balise_id'] = $Transactions->balise_id;
        $newCrudData['fonction_id'] = $Transactions->fonction_id;
        $newCrudData['online_id'] = $Transactions->online_id;
        $newCrudData['faction_id'] = $Transactions->faction_id;
        $newCrudData['pointeuse_id'] = $Transactions->pointeuse_id;
        $newCrudData['site_id'] = $Transactions->site_id;
        $newCrudData['client_id'] = $Transactions->client_id;
        $newCrudData['annuler'] = $Transactions->annuler;
        $newCrudData['type'] = $Transactions->type;
        $newCrudData['traiter'] = $Transactions->traiter;
        $newCrudData['pointeusepostes'] = $Transactions->pointeusepostes;
        $newCrudData['verification'] = $Transactions->verification;
        $newCrudData['rechercheetape'] = $Transactions->rechercheetape;
        $newCrudData['tache'] = $Transactions->tache;
        $newCrudData['poste'] = $Transactions->poste;
        $newCrudData['TachesPotentiels'] = $Transactions->TachesPotentiels;
        $newCrudData['PostesPotentiels'] = $Transactions->PostesPotentiels;
        $newCrudData['TotalPostes'] = $Transactions->TotalPostes;
        $newCrudData['TotalPostescouvert'] = $Transactions->TotalPostescouvert;
        $newCrudData['TotalPostesnoncouvert'] = $Transactions->TotalPostesnoncouvert;
        $newCrudData['TotalPostessouscouvert'] = $Transactions->TotalPostessouscouvert;
        $newCrudData['heure'] = $Transactions->heure;
        $newCrudData['identifiants_sadge'] = $Transactions->identifiants_sadge;
        $newCrudData['creat_by'] = $Transactions->creat_by;
        $newCrudData['etats'] = $Transactions->etats;
        $newCrudData['identification_id'] = $Transactions->identification_id;
        $newCrudData['controlleursacce_id'] = $Transactions->controlleursacce_id;
        $newCrudData['carte_id'] = $Transactions->carte_id;
        $newCrudData['cout'] = $Transactions->cout;
        try {
            $newCrudData['balise'] = $Transactions->balise->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['carte'] = $Transactions->carte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['client'] = $Transactions->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['controlleursacce'] = $Transactions->controlleursacce->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['echelon'] = $Transactions->echelon->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Transactions->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Transactions->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['identification'] = $Transactions->identification->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['matrimoniale'] = $Transactions->matrimoniale->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['online'] = $Transactions->online->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['pointeuse'] = $Transactions->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Transactions->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['sexe'] = $Transactions->sexe->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Transactions->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['situation'] = $Transactions->situation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Transactions->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Transactions->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Transactions', 'entite_cle' => $Transactions->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactions->toArray();
        return $data;
    }

}
