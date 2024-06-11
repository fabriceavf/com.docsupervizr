<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteProgrammeExecUseCase
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

        $Programmes = \App\Models\Programme::find($data['id']);


        $Programmes->deleted_at = now();
        $Programmes->save();
        $newCrudData = [];
        $newCrudData['date'] = $Programmes->date;
        $newCrudData['debut_prevu'] = $Programmes->debut_prevu;
        $newCrudData['fin_prevu'] = $Programmes->fin_prevu;
        $newCrudData['debut_reel'] = $Programmes->debut_reel;
        $newCrudData['debut_realise'] = $Programmes->debut_realise;
        $newCrudData['fin_realise'] = $Programmes->fin_realise;
        $newCrudData['volume_horaire'] = $Programmes->volume_horaire;
        $newCrudData['hs_base'] = $Programmes->hs_base;
        $newCrudData['hs_hors_faction'] = $Programmes->hs_hors_faction;
        $newCrudData['hs_in_faction'] = $Programmes->hs_in_faction;
        $newCrudData['programmationsuser_id'] = $Programmes->programmationsuser_id;
        $newCrudData['horaire_id'] = $Programmes->horaire_id;
        $newCrudData['etats'] = $Programmes->etats;
        $newCrudData['totalReel'] = $Programmes->totalReel;
        $newCrudData['totalFictif'] = $Programmes->totalFictif;
        $newCrudData['poste_id'] = $Programmes->poste_id;
        $newCrudData['remplacant'] = $Programmes->remplacant;
        $newCrudData['type'] = $Programmes->type;
        $newCrudData['week'] = $Programmes->week;
        $newCrudData['user'] = $Programmes->user;
        $newCrudData['DayStatut'] = $Programmes->DayStatut;
        $newCrudData['Remplacantuser'] = $Programmes->Remplacantuser;
        $newCrudData['PresencesDeclarer'] = $Programmes->PresencesDeclarer;
        $newCrudData['AbscencesDeclarer'] = $Programmes->AbscencesDeclarer;
        $newCrudData['EtatsDeclarer'] = $Programmes->EtatsDeclarer;
        $newCrudData['Totalpresent'] = $Programmes->Totalpresent;
        $newCrudData['J1'] = $Programmes->J1;
        $newCrudData['J2'] = $Programmes->J2;
        $newCrudData['J3'] = $Programmes->J3;
        $newCrudData['J4'] = $Programmes->J4;
        $newCrudData['J5'] = $Programmes->J5;
        $newCrudData['J6'] = $Programmes->J6;
        $newCrudData['J7'] = $Programmes->J7;
        $newCrudData['J8'] = $Programmes->J8;
        $newCrudData['J9'] = $Programmes->J9;
        $newCrudData['J10'] = $Programmes->J10;
        $newCrudData['J11'] = $Programmes->J11;
        $newCrudData['J12'] = $Programmes->J12;
        $newCrudData['J13'] = $Programmes->J13;
        $newCrudData['J14'] = $Programmes->J14;
        $newCrudData['J15'] = $Programmes->J15;
        $newCrudData['J16'] = $Programmes->J16;
        $newCrudData['J17'] = $Programmes->J17;
        $newCrudData['J18'] = $Programmes->J18;
        $newCrudData['J19'] = $Programmes->J19;
        $newCrudData['J20'] = $Programmes->J20;
        $newCrudData['J21'] = $Programmes->J21;
        $newCrudData['J22'] = $Programmes->J22;
        $newCrudData['J23'] = $Programmes->J23;
        $newCrudData['J24'] = $Programmes->J24;
        $newCrudData['J25'] = $Programmes->J25;
        $newCrudData['J26'] = $Programmes->J26;
        $newCrudData['J27'] = $Programmes->J27;
        $newCrudData['J28'] = $Programmes->J28;
        $newCrudData['J29'] = $Programmes->J29;
        $newCrudData['J30'] = $Programmes->J30;
        $newCrudData['J31'] = $Programmes->J31;
        $newCrudData['deja_annaliser'] = $Programmes->deja_annaliser;
        $newCrudData['pointages_rattacher_auto'] = $Programmes->pointages_rattacher_auto;
        $newCrudData['pointages_rattacher_manuel'] = $Programmes->pointages_rattacher_manuel;
        $newCrudData['pointages_debut_auto'] = $Programmes->pointages_debut_auto;
        $newCrudData['pointages_debut_manuel'] = $Programmes->pointages_debut_manuel;
        $newCrudData['pointages_fin_auto'] = $Programmes->pointages_fin_auto;
        $newCrudData['pointages_fin_manuel'] = $Programmes->pointages_fin_manuel;
        $newCrudData['presence_declarer_auto'] = $Programmes->presence_declarer_auto;
        $newCrudData['presence_declarer_manuel'] = $Programmes->presence_declarer_manuel;
        $newCrudData['identifiants_sadge'] = $Programmes->identifiants_sadge;
        $newCrudData['creat_by'] = $Programmes->creat_by;
        $newCrudData['programmation_id'] = $Programmes->programmation_id;
        $newCrudData['user_id'] = $Programmes->user_id;
        $newCrudData['qualification_horaire'] = $Programmes->qualification_horaire;
        $newCrudData['fin_reel'] = $Programmes->fin_reel;
        $newCrudData['typesheure_id'] = $Programmes->typesheure_id;
        try {
            $newCrudData['horaire'] = $Programmes->horaire->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Programmes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['programmation'] = $Programmes->programmation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['programmationsuser'] = $Programmes->programmationsuser->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['typesheure'] = $Programmes->typesheure->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Programmes->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Programmes', 'entite_cle' => $Programmes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
