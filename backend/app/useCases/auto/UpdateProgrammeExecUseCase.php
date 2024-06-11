<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateProgrammeExecUseCase
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
        $oldProgrammes = $Programmes->replicate();

        $oldCrudData = [];
        $oldCrudData['date'] = $oldProgrammes->date;
        $oldCrudData['debut_prevu'] = $oldProgrammes->debut_prevu;
        $oldCrudData['fin_prevu'] = $oldProgrammes->fin_prevu;
        $oldCrudData['debut_reel'] = $oldProgrammes->debut_reel;
        $oldCrudData['debut_realise'] = $oldProgrammes->debut_realise;
        $oldCrudData['fin_realise'] = $oldProgrammes->fin_realise;
        $oldCrudData['volume_horaire'] = $oldProgrammes->volume_horaire;
        $oldCrudData['hs_base'] = $oldProgrammes->hs_base;
        $oldCrudData['hs_hors_faction'] = $oldProgrammes->hs_hors_faction;
        $oldCrudData['hs_in_faction'] = $oldProgrammes->hs_in_faction;
        $oldCrudData['programmationsuser_id'] = $oldProgrammes->programmationsuser_id;
        $oldCrudData['horaire_id'] = $oldProgrammes->horaire_id;
        $oldCrudData['etats'] = $oldProgrammes->etats;
        $oldCrudData['totalReel'] = $oldProgrammes->totalReel;
        $oldCrudData['totalFictif'] = $oldProgrammes->totalFictif;
        $oldCrudData['poste_id'] = $oldProgrammes->poste_id;
        $oldCrudData['remplacant'] = $oldProgrammes->remplacant;
        $oldCrudData['type'] = $oldProgrammes->type;
        $oldCrudData['week'] = $oldProgrammes->week;
        $oldCrudData['user'] = $oldProgrammes->user;
        $oldCrudData['DayStatut'] = $oldProgrammes->DayStatut;
        $oldCrudData['Remplacantuser'] = $oldProgrammes->Remplacantuser;
        $oldCrudData['PresencesDeclarer'] = $oldProgrammes->PresencesDeclarer;
        $oldCrudData['AbscencesDeclarer'] = $oldProgrammes->AbscencesDeclarer;
        $oldCrudData['EtatsDeclarer'] = $oldProgrammes->EtatsDeclarer;
        $oldCrudData['Totalpresent'] = $oldProgrammes->Totalpresent;
        $oldCrudData['J1'] = $oldProgrammes->J1;
        $oldCrudData['J2'] = $oldProgrammes->J2;
        $oldCrudData['J3'] = $oldProgrammes->J3;
        $oldCrudData['J4'] = $oldProgrammes->J4;
        $oldCrudData['J5'] = $oldProgrammes->J5;
        $oldCrudData['J6'] = $oldProgrammes->J6;
        $oldCrudData['J7'] = $oldProgrammes->J7;
        $oldCrudData['J8'] = $oldProgrammes->J8;
        $oldCrudData['J9'] = $oldProgrammes->J9;
        $oldCrudData['J10'] = $oldProgrammes->J10;
        $oldCrudData['J11'] = $oldProgrammes->J11;
        $oldCrudData['J12'] = $oldProgrammes->J12;
        $oldCrudData['J13'] = $oldProgrammes->J13;
        $oldCrudData['J14'] = $oldProgrammes->J14;
        $oldCrudData['J15'] = $oldProgrammes->J15;
        $oldCrudData['J16'] = $oldProgrammes->J16;
        $oldCrudData['J17'] = $oldProgrammes->J17;
        $oldCrudData['J18'] = $oldProgrammes->J18;
        $oldCrudData['J19'] = $oldProgrammes->J19;
        $oldCrudData['J20'] = $oldProgrammes->J20;
        $oldCrudData['J21'] = $oldProgrammes->J21;
        $oldCrudData['J22'] = $oldProgrammes->J22;
        $oldCrudData['J23'] = $oldProgrammes->J23;
        $oldCrudData['J24'] = $oldProgrammes->J24;
        $oldCrudData['J25'] = $oldProgrammes->J25;
        $oldCrudData['J26'] = $oldProgrammes->J26;
        $oldCrudData['J27'] = $oldProgrammes->J27;
        $oldCrudData['J28'] = $oldProgrammes->J28;
        $oldCrudData['J29'] = $oldProgrammes->J29;
        $oldCrudData['J30'] = $oldProgrammes->J30;
        $oldCrudData['J31'] = $oldProgrammes->J31;
        $oldCrudData['deja_annaliser'] = $oldProgrammes->deja_annaliser;
        $oldCrudData['pointages_rattacher_auto'] = $oldProgrammes->pointages_rattacher_auto;
        $oldCrudData['pointages_rattacher_manuel'] = $oldProgrammes->pointages_rattacher_manuel;
        $oldCrudData['pointages_debut_auto'] = $oldProgrammes->pointages_debut_auto;
        $oldCrudData['pointages_debut_manuel'] = $oldProgrammes->pointages_debut_manuel;
        $oldCrudData['pointages_fin_auto'] = $oldProgrammes->pointages_fin_auto;
        $oldCrudData['pointages_fin_manuel'] = $oldProgrammes->pointages_fin_manuel;
        $oldCrudData['presence_declarer_auto'] = $oldProgrammes->presence_declarer_auto;
        $oldCrudData['presence_declarer_manuel'] = $oldProgrammes->presence_declarer_manuel;
        $oldCrudData['identifiants_sadge'] = $oldProgrammes->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldProgrammes->creat_by;
        $oldCrudData['programmation_id'] = $oldProgrammes->programmation_id;
        $oldCrudData['user_id'] = $oldProgrammes->user_id;
        $oldCrudData['qualification_horaire'] = $oldProgrammes->qualification_horaire;
        $oldCrudData['fin_reel'] = $oldProgrammes->fin_reel;
        $oldCrudData['typesheure_id'] = $oldProgrammes->typesheure_id;
        try {
            $oldCrudData['horaire'] = $oldProgrammes->horaire->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['poste'] = $oldProgrammes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['programmation'] = $oldProgrammes->programmation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['programmationsuser'] = $oldProgrammes->programmationsuser->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['typesheure'] = $oldProgrammes->typesheure->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldProgrammes->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['date'])) {
            $Programmes->date = $data['date'];
        }
        if (!empty($data['debut_prevu'])) {
            $Programmes->debut_prevu = $data['debut_prevu'];
        }
        if (!empty($data['fin_prevu'])) {
            $Programmes->fin_prevu = $data['fin_prevu'];
        }
        if (!empty($data['debut_reel'])) {
            $Programmes->debut_reel = $data['debut_reel'];
        }
        if (!empty($data['debut_realise'])) {
            $Programmes->debut_realise = $data['debut_realise'];
        }
        if (!empty($data['fin_realise'])) {
            $Programmes->fin_realise = $data['fin_realise'];
        }
        if (!empty($data['volume_horaire'])) {
            $Programmes->volume_horaire = $data['volume_horaire'];
        }
        if (!empty($data['hs_base'])) {
            $Programmes->hs_base = $data['hs_base'];
        }
        if (!empty($data['hs_hors_faction'])) {
            $Programmes->hs_hors_faction = $data['hs_hors_faction'];
        }
        if (!empty($data['hs_in_faction'])) {
            $Programmes->hs_in_faction = $data['hs_in_faction'];
        }
        if (!empty($data['programmationsuser_id'])) {
            $Programmes->programmationsuser_id = $data['programmationsuser_id'];
        }
        if (!empty($data['horaire_id'])) {
            $Programmes->horaire_id = $data['horaire_id'];
        }
        if (!empty($data['etats'])) {
            $Programmes->etats = $data['etats'];
        }
        if (!empty($data['totalReel'])) {
            $Programmes->totalReel = $data['totalReel'];
        }
        if (!empty($data['totalFictif'])) {
            $Programmes->totalFictif = $data['totalFictif'];
        }
        if (!empty($data['poste_id'])) {
            $Programmes->poste_id = $data['poste_id'];
        }
        if (!empty($data['remplacant'])) {
            $Programmes->remplacant = $data['remplacant'];
        }
        if (!empty($data['type'])) {
            $Programmes->type = $data['type'];
        }
        if (!empty($data['week'])) {
            $Programmes->week = $data['week'];
        }
        if (!empty($data['user'])) {
            $Programmes->user = $data['user'];
        }
        if (!empty($data['DayStatut'])) {
            $Programmes->DayStatut = $data['DayStatut'];
        }
        if (!empty($data['Remplacantuser'])) {
            $Programmes->Remplacantuser = $data['Remplacantuser'];
        }
        if (!empty($data['PresencesDeclarer'])) {
            $Programmes->PresencesDeclarer = $data['PresencesDeclarer'];
        }
        if (!empty($data['AbscencesDeclarer'])) {
            $Programmes->AbscencesDeclarer = $data['AbscencesDeclarer'];
        }
        if (!empty($data['EtatsDeclarer'])) {
            $Programmes->EtatsDeclarer = $data['EtatsDeclarer'];
        }
        if (!empty($data['Totalpresent'])) {
            $Programmes->Totalpresent = $data['Totalpresent'];
        }
        if (!empty($data['J1'])) {
            $Programmes->J1 = $data['J1'];
        }
        if (!empty($data['J2'])) {
            $Programmes->J2 = $data['J2'];
        }
        if (!empty($data['J3'])) {
            $Programmes->J3 = $data['J3'];
        }
        if (!empty($data['J4'])) {
            $Programmes->J4 = $data['J4'];
        }
        if (!empty($data['J5'])) {
            $Programmes->J5 = $data['J5'];
        }
        if (!empty($data['J6'])) {
            $Programmes->J6 = $data['J6'];
        }
        if (!empty($data['J7'])) {
            $Programmes->J7 = $data['J7'];
        }
        if (!empty($data['J8'])) {
            $Programmes->J8 = $data['J8'];
        }
        if (!empty($data['J9'])) {
            $Programmes->J9 = $data['J9'];
        }
        if (!empty($data['J10'])) {
            $Programmes->J10 = $data['J10'];
        }
        if (!empty($data['J11'])) {
            $Programmes->J11 = $data['J11'];
        }
        if (!empty($data['J12'])) {
            $Programmes->J12 = $data['J12'];
        }
        if (!empty($data['J13'])) {
            $Programmes->J13 = $data['J13'];
        }
        if (!empty($data['J14'])) {
            $Programmes->J14 = $data['J14'];
        }
        if (!empty($data['J15'])) {
            $Programmes->J15 = $data['J15'];
        }
        if (!empty($data['J16'])) {
            $Programmes->J16 = $data['J16'];
        }
        if (!empty($data['J17'])) {
            $Programmes->J17 = $data['J17'];
        }
        if (!empty($data['J18'])) {
            $Programmes->J18 = $data['J18'];
        }
        if (!empty($data['J19'])) {
            $Programmes->J19 = $data['J19'];
        }
        if (!empty($data['J20'])) {
            $Programmes->J20 = $data['J20'];
        }
        if (!empty($data['J21'])) {
            $Programmes->J21 = $data['J21'];
        }
        if (!empty($data['J22'])) {
            $Programmes->J22 = $data['J22'];
        }
        if (!empty($data['J23'])) {
            $Programmes->J23 = $data['J23'];
        }
        if (!empty($data['J24'])) {
            $Programmes->J24 = $data['J24'];
        }
        if (!empty($data['J25'])) {
            $Programmes->J25 = $data['J25'];
        }
        if (!empty($data['J26'])) {
            $Programmes->J26 = $data['J26'];
        }
        if (!empty($data['J27'])) {
            $Programmes->J27 = $data['J27'];
        }
        if (!empty($data['J28'])) {
            $Programmes->J28 = $data['J28'];
        }
        if (!empty($data['J29'])) {
            $Programmes->J29 = $data['J29'];
        }
        if (!empty($data['J30'])) {
            $Programmes->J30 = $data['J30'];
        }
        if (!empty($data['J31'])) {
            $Programmes->J31 = $data['J31'];
        }
        if (!empty($data['deja_annaliser'])) {
            $Programmes->deja_annaliser = $data['deja_annaliser'];
        }
        if (!empty($data['pointages_rattacher_auto'])) {
            $Programmes->pointages_rattacher_auto = $data['pointages_rattacher_auto'];
        }
        if (!empty($data['pointages_rattacher_manuel'])) {
            $Programmes->pointages_rattacher_manuel = $data['pointages_rattacher_manuel'];
        }
        if (!empty($data['pointages_debut_auto'])) {
            $Programmes->pointages_debut_auto = $data['pointages_debut_auto'];
        }
        if (!empty($data['pointages_debut_manuel'])) {
            $Programmes->pointages_debut_manuel = $data['pointages_debut_manuel'];
        }
        if (!empty($data['pointages_fin_auto'])) {
            $Programmes->pointages_fin_auto = $data['pointages_fin_auto'];
        }
        if (!empty($data['pointages_fin_manuel'])) {
            $Programmes->pointages_fin_manuel = $data['pointages_fin_manuel'];
        }
        if (!empty($data['presence_declarer_auto'])) {
            $Programmes->presence_declarer_auto = $data['presence_declarer_auto'];
        }
        if (!empty($data['presence_declarer_manuel'])) {
            $Programmes->presence_declarer_manuel = $data['presence_declarer_manuel'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Programmes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Programmes->creat_by = $data['creat_by'];
        }
        if (!empty($data['programmation_id'])) {
            $Programmes->programmation_id = $data['programmation_id'];
        }
        if (!empty($data['user_id'])) {
            $Programmes->user_id = $data['user_id'];
        }
        if (!empty($data['qualification_horaire'])) {
            $Programmes->qualification_horaire = $data['qualification_horaire'];
        }
        if (!empty($data['fin_reel'])) {
            $Programmes->fin_reel = $data['fin_reel'];
        }
        if (!empty($data['typesheure_id'])) {
            $Programmes->typesheure_id = $data['typesheure_id'];
        }
        $Programmes->save();
        $Programmes = \App\Models\Programme::find($Programmes->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Programmes', 'entite_cle' => $Programmes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Programmes->toArray();
        return $data;
    }

}
