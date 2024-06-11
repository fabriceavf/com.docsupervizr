<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteProgrammationsrondeExecUseCase
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


        $Programmationsrondes->deleted_at = now();
        $Programmationsrondes->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Programmationsrondes', 'entite_cle' => $Programmationsrondes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
