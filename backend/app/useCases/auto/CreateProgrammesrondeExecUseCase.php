<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProgrammesrondeExecUseCase
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

        $Programmesrondes = new \App\Models\Programmesronde();

        if (!empty($data['date'])) {
            $Programmesrondes->date = $data['date'];
        }
        if (!empty($data['debut_prevu'])) {
            $Programmesrondes->debut_prevu = $data['debut_prevu'];
        }
        if (!empty($data['fin_prevu'])) {
            $Programmesrondes->fin_prevu = $data['fin_prevu'];
        }
        if (!empty($data['debut_reel'])) {
            $Programmesrondes->debut_reel = $data['debut_reel'];
        }
        if (!empty($data['debut_realise'])) {
            $Programmesrondes->debut_realise = $data['debut_realise'];
        }
        if (!empty($data['fin_realise'])) {
            $Programmesrondes->fin_realise = $data['fin_realise'];
        }
        if (!empty($data['volume_horaire'])) {
            $Programmesrondes->volume_horaire = $data['volume_horaire'];
        }
        if (!empty($data['hs_base'])) {
            $Programmesrondes->hs_base = $data['hs_base'];
        }
        if (!empty($data['hs_hors_faction'])) {
            $Programmesrondes->hs_hors_faction = $data['hs_hors_faction'];
        }
        if (!empty($data['hs_in_faction'])) {
            $Programmesrondes->hs_in_faction = $data['hs_in_faction'];
        }
        if (!empty($data['programmationsuser_id'])) {
            $Programmesrondes->programmationsuser_id = $data['programmationsuser_id'];
        }
        if (!empty($data['horaire_id'])) {
            $Programmesrondes->horaire_id = $data['horaire_id'];
        }
        if (!empty($data['etats'])) {
            $Programmesrondes->etats = $data['etats'];
        }
        if (!empty($data['totalReel'])) {
            $Programmesrondes->totalReel = $data['totalReel'];
        }
        if (!empty($data['totalFictif'])) {
            $Programmesrondes->totalFictif = $data['totalFictif'];
        }
        if (!empty($data['poste_id'])) {
            $Programmesrondes->poste_id = $data['poste_id'];
        }
        if (!empty($data['remplacant'])) {
            $Programmesrondes->remplacant = $data['remplacant'];
        }
        if (!empty($data['type'])) {
            $Programmesrondes->type = $data['type'];
        }
        if (!empty($data['week'])) {
            $Programmesrondes->week = $data['week'];
        }
        if (!empty($data['user'])) {
            $Programmesrondes->user = $data['user'];
        }
        if (!empty($data['DayStatut'])) {
            $Programmesrondes->DayStatut = $data['DayStatut'];
        }
        if (!empty($data['Remplacantuser'])) {
            $Programmesrondes->Remplacantuser = $data['Remplacantuser'];
        }
        if (!empty($data['PresencesDeclarer'])) {
            $Programmesrondes->PresencesDeclarer = $data['PresencesDeclarer'];
        }
        if (!empty($data['AbscencesDeclarer'])) {
            $Programmesrondes->AbscencesDeclarer = $data['AbscencesDeclarer'];
        }
        if (!empty($data['EtatsDeclarer'])) {
            $Programmesrondes->EtatsDeclarer = $data['EtatsDeclarer'];
        }
        if (!empty($data['Totalpresent'])) {
            $Programmesrondes->Totalpresent = $data['Totalpresent'];
        }
        if (!empty($data['J1'])) {
            $Programmesrondes->J1 = $data['J1'];
        }
        if (!empty($data['J2'])) {
            $Programmesrondes->J2 = $data['J2'];
        }
        if (!empty($data['J3'])) {
            $Programmesrondes->J3 = $data['J3'];
        }
        if (!empty($data['J4'])) {
            $Programmesrondes->J4 = $data['J4'];
        }
        if (!empty($data['J5'])) {
            $Programmesrondes->J5 = $data['J5'];
        }
        if (!empty($data['J6'])) {
            $Programmesrondes->J6 = $data['J6'];
        }
        if (!empty($data['J7'])) {
            $Programmesrondes->J7 = $data['J7'];
        }
        if (!empty($data['J8'])) {
            $Programmesrondes->J8 = $data['J8'];
        }
        if (!empty($data['J9'])) {
            $Programmesrondes->J9 = $data['J9'];
        }
        if (!empty($data['J10'])) {
            $Programmesrondes->J10 = $data['J10'];
        }
        if (!empty($data['J11'])) {
            $Programmesrondes->J11 = $data['J11'];
        }
        if (!empty($data['J12'])) {
            $Programmesrondes->J12 = $data['J12'];
        }
        if (!empty($data['J13'])) {
            $Programmesrondes->J13 = $data['J13'];
        }
        if (!empty($data['J14'])) {
            $Programmesrondes->J14 = $data['J14'];
        }
        if (!empty($data['J15'])) {
            $Programmesrondes->J15 = $data['J15'];
        }
        if (!empty($data['J16'])) {
            $Programmesrondes->J16 = $data['J16'];
        }
        if (!empty($data['J17'])) {
            $Programmesrondes->J17 = $data['J17'];
        }
        if (!empty($data['J18'])) {
            $Programmesrondes->J18 = $data['J18'];
        }
        if (!empty($data['J19'])) {
            $Programmesrondes->J19 = $data['J19'];
        }
        if (!empty($data['J20'])) {
            $Programmesrondes->J20 = $data['J20'];
        }
        if (!empty($data['J21'])) {
            $Programmesrondes->J21 = $data['J21'];
        }
        if (!empty($data['J22'])) {
            $Programmesrondes->J22 = $data['J22'];
        }
        if (!empty($data['J23'])) {
            $Programmesrondes->J23 = $data['J23'];
        }
        if (!empty($data['J24'])) {
            $Programmesrondes->J24 = $data['J24'];
        }
        if (!empty($data['J25'])) {
            $Programmesrondes->J25 = $data['J25'];
        }
        if (!empty($data['J26'])) {
            $Programmesrondes->J26 = $data['J26'];
        }
        if (!empty($data['J27'])) {
            $Programmesrondes->J27 = $data['J27'];
        }
        if (!empty($data['J28'])) {
            $Programmesrondes->J28 = $data['J28'];
        }
        if (!empty($data['J29'])) {
            $Programmesrondes->J29 = $data['J29'];
        }
        if (!empty($data['J30'])) {
            $Programmesrondes->J30 = $data['J30'];
        }
        if (!empty($data['J31'])) {
            $Programmesrondes->J31 = $data['J31'];
        }
        if (!empty($data['deja_annaliser'])) {
            $Programmesrondes->deja_annaliser = $data['deja_annaliser'];
        }
        if (!empty($data['pointages_rattacher_auto'])) {
            $Programmesrondes->pointages_rattacher_auto = $data['pointages_rattacher_auto'];
        }
        if (!empty($data['pointages_rattacher_manuel'])) {
            $Programmesrondes->pointages_rattacher_manuel = $data['pointages_rattacher_manuel'];
        }
        if (!empty($data['pointages_debut_auto'])) {
            $Programmesrondes->pointages_debut_auto = $data['pointages_debut_auto'];
        }
        if (!empty($data['pointages_debut_manuel'])) {
            $Programmesrondes->pointages_debut_manuel = $data['pointages_debut_manuel'];
        }
        if (!empty($data['pointages_fin_auto'])) {
            $Programmesrondes->pointages_fin_auto = $data['pointages_fin_auto'];
        }
        if (!empty($data['pointages_fin_manuel'])) {
            $Programmesrondes->pointages_fin_manuel = $data['pointages_fin_manuel'];
        }
        if (!empty($data['presence_declarer_auto'])) {
            $Programmesrondes->presence_declarer_auto = $data['presence_declarer_auto'];
        }
        if (!empty($data['presence_declarer_manuel'])) {
            $Programmesrondes->presence_declarer_manuel = $data['presence_declarer_manuel'];
        }
        if (!empty($data['programmationsronde_id'])) {
            $Programmesrondes->programmationsronde_id = $data['programmationsronde_id'];
        }
        if (!empty($data['user_id'])) {
            $Programmesrondes->user_id = $data['user_id'];
        }
        if (!empty($data['creat_by'])) {
            $Programmesrondes->creat_by = $data['creat_by'];
        }
        $Programmesrondes->save();
        $Programmesrondes = \App\Models\Programmesronde::find($Programmesrondes->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Programmesrondes', 'entite_cle' => $Programmesrondes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Programmesrondes->toArray();
        return $data;
    }

}
