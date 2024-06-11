<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransactionExecUseCase
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


        $Transactions->deleted_at = now();
        $Transactions->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transactions', 'entite_cle' => $Transactions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
