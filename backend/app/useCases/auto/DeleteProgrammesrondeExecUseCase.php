<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteProgrammesrondeExecUseCase
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

        $Programmesrondes = \App\Models\Programmesronde::find($data['id']);


        $Programmesrondes->deleted_at = now();
        $Programmesrondes->save();
        $newCrudData = [];
        $newCrudData['date'] = $Programmesrondes->date;
        $newCrudData['debut_prevu'] = $Programmesrondes->debut_prevu;
        $newCrudData['fin_prevu'] = $Programmesrondes->fin_prevu;
        $newCrudData['debut_reel'] = $Programmesrondes->debut_reel;
        $newCrudData['debut_realise'] = $Programmesrondes->debut_realise;
        $newCrudData['fin_realise'] = $Programmesrondes->fin_realise;
        $newCrudData['volume_horaire'] = $Programmesrondes->volume_horaire;
        $newCrudData['hs_base'] = $Programmesrondes->hs_base;
        $newCrudData['hs_hors_faction'] = $Programmesrondes->hs_hors_faction;
        $newCrudData['hs_in_faction'] = $Programmesrondes->hs_in_faction;
        $newCrudData['programmationsuser_id'] = $Programmesrondes->programmationsuser_id;
        $newCrudData['horaire_id'] = $Programmesrondes->horaire_id;
        $newCrudData['etats'] = $Programmesrondes->etats;
        $newCrudData['totalReel'] = $Programmesrondes->totalReel;
        $newCrudData['totalFictif'] = $Programmesrondes->totalFictif;
        $newCrudData['poste_id'] = $Programmesrondes->poste_id;
        $newCrudData['remplacant'] = $Programmesrondes->remplacant;
        $newCrudData['type'] = $Programmesrondes->type;
        $newCrudData['week'] = $Programmesrondes->week;
        $newCrudData['user'] = $Programmesrondes->user;
        $newCrudData['DayStatut'] = $Programmesrondes->DayStatut;
        $newCrudData['Remplacantuser'] = $Programmesrondes->Remplacantuser;
        $newCrudData['PresencesDeclarer'] = $Programmesrondes->PresencesDeclarer;
        $newCrudData['AbscencesDeclarer'] = $Programmesrondes->AbscencesDeclarer;
        $newCrudData['EtatsDeclarer'] = $Programmesrondes->EtatsDeclarer;
        $newCrudData['Totalpresent'] = $Programmesrondes->Totalpresent;
        $newCrudData['J1'] = $Programmesrondes->J1;
        $newCrudData['J2'] = $Programmesrondes->J2;
        $newCrudData['J3'] = $Programmesrondes->J3;
        $newCrudData['J4'] = $Programmesrondes->J4;
        $newCrudData['J5'] = $Programmesrondes->J5;
        $newCrudData['J6'] = $Programmesrondes->J6;
        $newCrudData['J7'] = $Programmesrondes->J7;
        $newCrudData['J8'] = $Programmesrondes->J8;
        $newCrudData['J9'] = $Programmesrondes->J9;
        $newCrudData['J10'] = $Programmesrondes->J10;
        $newCrudData['J11'] = $Programmesrondes->J11;
        $newCrudData['J12'] = $Programmesrondes->J12;
        $newCrudData['J13'] = $Programmesrondes->J13;
        $newCrudData['J14'] = $Programmesrondes->J14;
        $newCrudData['J15'] = $Programmesrondes->J15;
        $newCrudData['J16'] = $Programmesrondes->J16;
        $newCrudData['J17'] = $Programmesrondes->J17;
        $newCrudData['J18'] = $Programmesrondes->J18;
        $newCrudData['J19'] = $Programmesrondes->J19;
        $newCrudData['J20'] = $Programmesrondes->J20;
        $newCrudData['J21'] = $Programmesrondes->J21;
        $newCrudData['J22'] = $Programmesrondes->J22;
        $newCrudData['J23'] = $Programmesrondes->J23;
        $newCrudData['J24'] = $Programmesrondes->J24;
        $newCrudData['J25'] = $Programmesrondes->J25;
        $newCrudData['J26'] = $Programmesrondes->J26;
        $newCrudData['J27'] = $Programmesrondes->J27;
        $newCrudData['J28'] = $Programmesrondes->J28;
        $newCrudData['J29'] = $Programmesrondes->J29;
        $newCrudData['J30'] = $Programmesrondes->J30;
        $newCrudData['J31'] = $Programmesrondes->J31;
        $newCrudData['deja_annaliser'] = $Programmesrondes->deja_annaliser;
        $newCrudData['pointages_rattacher_auto'] = $Programmesrondes->pointages_rattacher_auto;
        $newCrudData['pointages_rattacher_manuel'] = $Programmesrondes->pointages_rattacher_manuel;
        $newCrudData['pointages_debut_auto'] = $Programmesrondes->pointages_debut_auto;
        $newCrudData['pointages_debut_manuel'] = $Programmesrondes->pointages_debut_manuel;
        $newCrudData['pointages_fin_auto'] = $Programmesrondes->pointages_fin_auto;
        $newCrudData['pointages_fin_manuel'] = $Programmesrondes->pointages_fin_manuel;
        $newCrudData['presence_declarer_auto'] = $Programmesrondes->presence_declarer_auto;
        $newCrudData['presence_declarer_manuel'] = $Programmesrondes->presence_declarer_manuel;
        $newCrudData['programmationsronde_id'] = $Programmesrondes->programmationsronde_id;
        $newCrudData['user_id'] = $Programmesrondes->user_id;
        $newCrudData['creat_by'] = $Programmesrondes->creat_by;
        try {
            $newCrudData['horaire'] = $Programmesrondes->horaire->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Programmesrondes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['programmationsronde'] = $Programmesrondes->programmationsronde->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['programmationsuser'] = $Programmesrondes->programmationsuser->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Programmesrondes->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Programmesrondes', 'entite_cle' => $Programmesrondes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
