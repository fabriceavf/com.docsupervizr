<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateProgrammationsrondeExecUseCase
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

        $Programmationsrondes = \App\Models\Programmationsronde::find($data['id']);
        $oldProgrammationsrondes = $Programmationsrondes->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldProgrammationsrondes->libelle;
        $oldCrudData['description'] = $oldProgrammationsrondes->description;
        $oldCrudData['date_debut'] = $oldProgrammationsrondes->date_debut;
        $oldCrudData['date_fin'] = $oldProgrammationsrondes->date_fin;
        $oldCrudData['default_heure_debut'] = $oldProgrammationsrondes->default_heure_debut;
        $oldCrudData['default_heure_fin'] = $oldProgrammationsrondes->default_heure_fin;
        $oldCrudData['user_id'] = $oldProgrammationsrondes->user_id;
        $oldCrudData['statut'] = $oldProgrammationsrondes->statut;
        $oldCrudData['type'] = $oldProgrammationsrondes->type;
        $oldCrudData['postesbaladeur'] = $oldProgrammationsrondes->postesbaladeur;
        $oldCrudData['valider1'] = $oldProgrammationsrondes->valider1;
        $oldCrudData['zone_id'] = $oldProgrammationsrondes->zone_id;
        $oldCrudData['valider2'] = $oldProgrammationsrondes->valider2;
        $oldCrudData['poste_id'] = $oldProgrammationsrondes->poste_id;
        $oldCrudData['etats'] = $oldProgrammationsrondes->etats;
        $oldCrudData['postes'] = $oldProgrammationsrondes->postes;
        $oldCrudData['min_pointage'] = $oldProgrammationsrondes->min_pointage;
        $oldCrudData['Allclients'] = $oldProgrammationsrondes->Allclients;
        $oldCrudData['AllDatesInRange'] = $oldProgrammationsrondes->AllDatesInRange;
        $oldCrudData['Presents'] = $oldProgrammationsrondes->Presents;
        $oldCrudData['Abscents'] = $oldProgrammationsrondes->Abscents;
        $oldCrudData['Presentsid'] = $oldProgrammationsrondes->Presentsid;
        $oldCrudData['Abscentsid'] = $oldProgrammationsrondes->Abscentsid;
        $oldCrudData['user_id_2'] = $oldProgrammationsrondes->user_id_2;
        $oldCrudData['user_id_3'] = $oldProgrammationsrondes->user_id_3;
        $oldCrudData['user_id_4'] = $oldProgrammationsrondes->user_id_4;
        $oldCrudData['valideur_1'] = $oldProgrammationsrondes->valideur_1;
        $oldCrudData['valideur_2'] = $oldProgrammationsrondes->valideur_2;
        $oldCrudData['creat_by'] = $oldProgrammationsrondes->creat_by;
        try {
            $oldCrudData['poste'] = $oldProgrammationsrondes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldProgrammationsrondes->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $oldProgrammationsrondes->zone->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Programmationsrondes->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Programmationsrondes->description = $data['description'];
        }
        if (!empty($data['date_debut'])) {
            $Programmationsrondes->date_debut = $data['date_debut'];
        }
        if (!empty($data['date_fin'])) {
            $Programmationsrondes->date_fin = $data['date_fin'];
        }
        if (!empty($data['default_heure_debut'])) {
            $Programmationsrondes->default_heure_debut = $data['default_heure_debut'];
        }
        if (!empty($data['default_heure_fin'])) {
            $Programmationsrondes->default_heure_fin = $data['default_heure_fin'];
        }
        if (!empty($data['user_id'])) {
            $Programmationsrondes->user_id = $data['user_id'];
        }
        if (!empty($data['statut'])) {
            $Programmationsrondes->statut = $data['statut'];
        }
        if (!empty($data['type'])) {
            $Programmationsrondes->type = $data['type'];
        }
        if (!empty($data['postesbaladeur'])) {
            $Programmationsrondes->postesbaladeur = $data['postesbaladeur'];
        }
        if (!empty($data['valider1'])) {
            $Programmationsrondes->valider1 = $data['valider1'];
        }
        if (!empty($data['zone_id'])) {
            $Programmationsrondes->zone_id = $data['zone_id'];
        }
        if (!empty($data['valider2'])) {
            $Programmationsrondes->valider2 = $data['valider2'];
        }
        if (!empty($data['poste_id'])) {
            $Programmationsrondes->poste_id = $data['poste_id'];
        }
        if (!empty($data['etats'])) {
            $Programmationsrondes->etats = $data['etats'];
        }
        if (!empty($data['postes'])) {
            $Programmationsrondes->postes = $data['postes'];
        }
        if (!empty($data['min_pointage'])) {
            $Programmationsrondes->min_pointage = $data['min_pointage'];
        }
        if (!empty($data['Allclients'])) {
            $Programmationsrondes->Allclients = $data['Allclients'];
        }
        if (!empty($data['AllDatesInRange'])) {
            $Programmationsrondes->AllDatesInRange = $data['AllDatesInRange'];
        }
        if (!empty($data['Presents'])) {
            $Programmationsrondes->Presents = $data['Presents'];
        }
        if (!empty($data['Abscents'])) {
            $Programmationsrondes->Abscents = $data['Abscents'];
        }
        if (!empty($data['Presentsid'])) {
            $Programmationsrondes->Presentsid = $data['Presentsid'];
        }
        if (!empty($data['Abscentsid'])) {
            $Programmationsrondes->Abscentsid = $data['Abscentsid'];
        }
        if (!empty($data['user_id_2'])) {
            $Programmationsrondes->user_id_2 = $data['user_id_2'];
        }
        if (!empty($data['user_id_3'])) {
            $Programmationsrondes->user_id_3 = $data['user_id_3'];
        }
        if (!empty($data['user_id_4'])) {
            $Programmationsrondes->user_id_4 = $data['user_id_4'];
        }
        if (!empty($data['valideur_1'])) {
            $Programmationsrondes->valideur_1 = $data['valideur_1'];
        }
        if (!empty($data['valideur_2'])) {
            $Programmationsrondes->valideur_2 = $data['valideur_2'];
        }
        if (!empty($data['creat_by'])) {
            $Programmationsrondes->creat_by = $data['creat_by'];
        }
        $Programmationsrondes->save();
        $Programmationsrondes = \App\Models\Programmationsronde::find($Programmationsrondes->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Programmationsrondes->libelle;
        $newCrudData['description'] = $Programmationsrondes->description;
        $newCrudData['date_debut'] = $Programmationsrondes->date_debut;
        $newCrudData['date_fin'] = $Programmationsrondes->date_fin;
        $newCrudData['default_heure_debut'] = $Programmationsrondes->default_heure_debut;
        $newCrudData['default_heure_fin'] = $Programmationsrondes->default_heure_fin;
        $newCrudData['user_id'] = $Programmationsrondes->user_id;
        $newCrudData['statut'] = $Programmationsrondes->statut;
        $newCrudData['type'] = $Programmationsrondes->type;
        $newCrudData['postesbaladeur'] = $Programmationsrondes->postesbaladeur;
        $newCrudData['valider1'] = $Programmationsrondes->valider1;
        $newCrudData['zone_id'] = $Programmationsrondes->zone_id;
        $newCrudData['valider2'] = $Programmationsrondes->valider2;
        $newCrudData['poste_id'] = $Programmationsrondes->poste_id;
        $newCrudData['etats'] = $Programmationsrondes->etats;
        $newCrudData['postes'] = $Programmationsrondes->postes;
        $newCrudData['min_pointage'] = $Programmationsrondes->min_pointage;
        $newCrudData['Allclients'] = $Programmationsrondes->Allclients;
        $newCrudData['AllDatesInRange'] = $Programmationsrondes->AllDatesInRange;
        $newCrudData['Presents'] = $Programmationsrondes->Presents;
        $newCrudData['Abscents'] = $Programmationsrondes->Abscents;
        $newCrudData['Presentsid'] = $Programmationsrondes->Presentsid;
        $newCrudData['Abscentsid'] = $Programmationsrondes->Abscentsid;
        $newCrudData['user_id_2'] = $Programmationsrondes->user_id_2;
        $newCrudData['user_id_3'] = $Programmationsrondes->user_id_3;
        $newCrudData['user_id_4'] = $Programmationsrondes->user_id_4;
        $newCrudData['valideur_1'] = $Programmationsrondes->valideur_1;
        $newCrudData['valideur_2'] = $Programmationsrondes->valideur_2;
        $newCrudData['creat_by'] = $Programmationsrondes->creat_by;
        try {
            $newCrudData['poste'] = $Programmationsrondes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Programmationsrondes->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Programmationsrondes->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Programmationsrondes', 'entite_cle' => $Programmationsrondes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Programmationsrondes->toArray();
        return $data;
    }

}
