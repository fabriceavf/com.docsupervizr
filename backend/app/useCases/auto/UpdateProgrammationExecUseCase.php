<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateProgrammationExecUseCase
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

        $Programmations = \App\Models\Programmation::find($data['id']);
        $oldProgrammations = $Programmations->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldProgrammations->libelle;
        $oldCrudData['description'] = $oldProgrammations->description;
        $oldCrudData['date_debut'] = $oldProgrammations->date_debut;
        $oldCrudData['date_fin'] = $oldProgrammations->date_fin;
        $oldCrudData['default_heure_debut'] = $oldProgrammations->default_heure_debut;
        $oldCrudData['default_heure_fin'] = $oldProgrammations->default_heure_fin;
        $oldCrudData['tache_id'] = $oldProgrammations->tache_id;
        $oldCrudData['user_id'] = $oldProgrammations->user_id;
        $oldCrudData['statut'] = $oldProgrammations->statut;
        $oldCrudData['type'] = $oldProgrammations->type;
        $oldCrudData['poste_id'] = $oldProgrammations->poste_id;
        $oldCrudData['faction'] = $oldProgrammations->faction;
        $oldCrudData['etats'] = $oldProgrammations->etats;
        $oldCrudData['valider1'] = $oldProgrammations->valider1;
        $oldCrudData['valider2'] = $oldProgrammations->valider2;
        $oldCrudData['postes'] = $oldProgrammations->postes;
        $oldCrudData['Allclients'] = $oldProgrammations->Allclients;
        $oldCrudData['AllDatesInRange'] = $oldProgrammations->AllDatesInRange;
        $oldCrudData['Presents'] = $oldProgrammations->Presents;
        $oldCrudData['Abscents'] = $oldProgrammations->Abscents;
        $oldCrudData['Presentsid'] = $oldProgrammations->Presentsid;
        $oldCrudData['Abscentsid'] = $oldProgrammations->Abscentsid;
        $oldCrudData['zone_id'] = $oldProgrammations->zone_id;
        $oldCrudData['user_id_2'] = $oldProgrammations->user_id_2;
        $oldCrudData['user_id_3'] = $oldProgrammations->user_id_3;
        $oldCrudData['user_id_4'] = $oldProgrammations->user_id_4;
        $oldCrudData['min_pointage'] = $oldProgrammations->min_pointage;
        $oldCrudData['identifiants_sadge'] = $oldProgrammations->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldProgrammations->creat_by;
        $oldCrudData['valideur_1'] = $oldProgrammations->valideur_1;
        $oldCrudData['valideur_2'] = $oldProgrammations->valideur_2;
        $oldCrudData['typelistings'] = $oldProgrammations->typelistings;
        $oldCrudData['postesbaladeur'] = $oldProgrammations->postesbaladeur;
        $oldCrudData['directions'] = $oldProgrammations->directions;
        try {
            $oldCrudData['poste'] = $oldProgrammations->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['tache'] = $oldProgrammations->tache->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldProgrammations->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $oldProgrammations->zone->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Programmations->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Programmations->description = $data['description'];
        }
        if (!empty($data['date_debut'])) {
            $Programmations->date_debut = $data['date_debut'];
        }
        if (!empty($data['date_fin'])) {
            $Programmations->date_fin = $data['date_fin'];
        }
        if (!empty($data['default_heure_debut'])) {
            $Programmations->default_heure_debut = $data['default_heure_debut'];
        }
        if (!empty($data['default_heure_fin'])) {
            $Programmations->default_heure_fin = $data['default_heure_fin'];
        }
        if (!empty($data['tache_id'])) {
            $Programmations->tache_id = $data['tache_id'];
        }
        if (!empty($data['user_id'])) {
            $Programmations->user_id = $data['user_id'];
        }
        if (!empty($data['statut'])) {
            $Programmations->statut = $data['statut'];
        }
        if (!empty($data['type'])) {
            $Programmations->type = $data['type'];
        }
        if (!empty($data['poste_id'])) {
            $Programmations->poste_id = $data['poste_id'];
        }
        if (!empty($data['faction'])) {
            $Programmations->faction = $data['faction'];
        }
        if (!empty($data['etats'])) {
            $Programmations->etats = $data['etats'];
        }
        if (!empty($data['valider1'])) {
            $Programmations->valider1 = $data['valider1'];
        }
        if (!empty($data['valider2'])) {
            $Programmations->valider2 = $data['valider2'];
        }
        if (!empty($data['postes'])) {
            $Programmations->postes = $data['postes'];
        }
        if (!empty($data['Allclients'])) {
            $Programmations->Allclients = $data['Allclients'];
        }
        if (!empty($data['AllDatesInRange'])) {
            $Programmations->AllDatesInRange = $data['AllDatesInRange'];
        }
        if (!empty($data['Presents'])) {
            $Programmations->Presents = $data['Presents'];
        }
        if (!empty($data['Abscents'])) {
            $Programmations->Abscents = $data['Abscents'];
        }
        if (!empty($data['Presentsid'])) {
            $Programmations->Presentsid = $data['Presentsid'];
        }
        if (!empty($data['Abscentsid'])) {
            $Programmations->Abscentsid = $data['Abscentsid'];
        }
        if (!empty($data['zone_id'])) {
            $Programmations->zone_id = $data['zone_id'];
        }
        if (!empty($data['user_id_2'])) {
            $Programmations->user_id_2 = $data['user_id_2'];
        }
        if (!empty($data['user_id_3'])) {
            $Programmations->user_id_3 = $data['user_id_3'];
        }
        if (!empty($data['user_id_4'])) {
            $Programmations->user_id_4 = $data['user_id_4'];
        }
        if (!empty($data['min_pointage'])) {
            $Programmations->min_pointage = $data['min_pointage'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Programmations->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Programmations->creat_by = $data['creat_by'];
        }
        if (!empty($data['valideur_1'])) {
            $Programmations->valideur_1 = $data['valideur_1'];
        }
        if (!empty($data['valideur_2'])) {
            $Programmations->valideur_2 = $data['valideur_2'];
        }
        if (!empty($data['typelistings'])) {
            $Programmations->typelistings = $data['typelistings'];
        }
        if (!empty($data['postesbaladeur'])) {
            $Programmations->postesbaladeur = $data['postesbaladeur'];
        }
        if (!empty($data['directions'])) {
            $Programmations->directions = $data['directions'];
        }
        $Programmations->save();
        $Programmations = \App\Models\Programmation::find($Programmations->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Programmations->libelle;
        $newCrudData['description'] = $Programmations->description;
        $newCrudData['date_debut'] = $Programmations->date_debut;
        $newCrudData['date_fin'] = $Programmations->date_fin;
        $newCrudData['default_heure_debut'] = $Programmations->default_heure_debut;
        $newCrudData['default_heure_fin'] = $Programmations->default_heure_fin;
        $newCrudData['tache_id'] = $Programmations->tache_id;
        $newCrudData['user_id'] = $Programmations->user_id;
        $newCrudData['statut'] = $Programmations->statut;
        $newCrudData['type'] = $Programmations->type;
        $newCrudData['poste_id'] = $Programmations->poste_id;
        $newCrudData['faction'] = $Programmations->faction;
        $newCrudData['etats'] = $Programmations->etats;
        $newCrudData['valider1'] = $Programmations->valider1;
        $newCrudData['valider2'] = $Programmations->valider2;
        $newCrudData['postes'] = $Programmations->postes;
        $newCrudData['Allclients'] = $Programmations->Allclients;
        $newCrudData['AllDatesInRange'] = $Programmations->AllDatesInRange;
        $newCrudData['Presents'] = $Programmations->Presents;
        $newCrudData['Abscents'] = $Programmations->Abscents;
        $newCrudData['Presentsid'] = $Programmations->Presentsid;
        $newCrudData['Abscentsid'] = $Programmations->Abscentsid;
        $newCrudData['zone_id'] = $Programmations->zone_id;
        $newCrudData['user_id_2'] = $Programmations->user_id_2;
        $newCrudData['user_id_3'] = $Programmations->user_id_3;
        $newCrudData['user_id_4'] = $Programmations->user_id_4;
        $newCrudData['min_pointage'] = $Programmations->min_pointage;
        $newCrudData['identifiants_sadge'] = $Programmations->identifiants_sadge;
        $newCrudData['creat_by'] = $Programmations->creat_by;
        $newCrudData['valideur_1'] = $Programmations->valideur_1;
        $newCrudData['valideur_2'] = $Programmations->valideur_2;
        $newCrudData['typelistings'] = $Programmations->typelistings;
        $newCrudData['postesbaladeur'] = $Programmations->postesbaladeur;
        $newCrudData['directions'] = $Programmations->directions;
        try {
            $newCrudData['poste'] = $Programmations->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['tache'] = $Programmations->tache->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Programmations->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Programmations->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Programmations', 'entite_cle' => $Programmations->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Programmations->toArray();
        return $data;
    }

}
