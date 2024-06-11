<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteProgrammationExecUseCase
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


        $Programmations->deleted_at = now();
        $Programmations->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Programmations', 'entite_cle' => $Programmations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
