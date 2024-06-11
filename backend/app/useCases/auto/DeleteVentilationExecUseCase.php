<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteVentilationExecUseCase
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

        $Ventilations = \App\Models\Ventilation::find($data['id']);


        $Ventilations->deleted_at = now();
        $Ventilations->save();
        $newCrudData = [];
        $newCrudData['user_id'] = $Ventilations->user_id;
        $newCrudData['semaine'] = $Ventilations->semaine;
        $newCrudData['dimanche_date'] = $Ventilations->dimanche_date;
        $newCrudData['lundi_date'] = $Ventilations->lundi_date;
        $newCrudData['mardi_date'] = $Ventilations->mardi_date;
        $newCrudData['mercredi_date'] = $Ventilations->mercredi_date;
        $newCrudData['jeudi_date'] = $Ventilations->jeudi_date;
        $newCrudData['vendredi_date'] = $Ventilations->vendredi_date;
        $newCrudData['samedi_date'] = $Ventilations->samedi_date;
        $newCrudData['dimanche_horaire'] = $Ventilations->dimanche_horaire;
        $newCrudData['lundi_horaire'] = $Ventilations->lundi_horaire;
        $newCrudData['mardi_horaire'] = $Ventilations->mardi_horaire;
        $newCrudData['mercredi_horaire'] = $Ventilations->mercredi_horaire;
        $newCrudData['jeudi_horaire'] = $Ventilations->jeudi_horaire;
        $newCrudData['vendredi_horaire'] = $Ventilations->vendredi_horaire;
        $newCrudData['samedi_horaire'] = $Ventilations->samedi_horaire;
        $newCrudData['dimanche'] = $Ventilations->dimanche;
        $newCrudData['lundi'] = $Ventilations->lundi;
        $newCrudData['mardi'] = $Ventilations->mardi;
        $newCrudData['mercredi'] = $Ventilations->mercredi;
        $newCrudData['jeudi'] = $Ventilations->jeudi;
        $newCrudData['vendredi'] = $Ventilations->vendredi;
        $newCrudData['samedi'] = $Ventilations->samedi;
        $newCrudData['dimanche_pointage'] = $Ventilations->dimanche_pointage;
        $newCrudData['lundi_pointage'] = $Ventilations->lundi_pointage;
        $newCrudData['mardi_pointage'] = $Ventilations->mardi_pointage;
        $newCrudData['mercredi_pointage'] = $Ventilations->mercredi_pointage;
        $newCrudData['jeudi_pointage'] = $Ventilations->jeudi_pointage;
        $newCrudData['vendredi_pointage'] = $Ventilations->vendredi_pointage;
        $newCrudData['samedi_pointage'] = $Ventilations->samedi_pointage;
        $newCrudData['dimanche_collecter'] = $Ventilations->dimanche_collecter;
        $newCrudData['lundi_collecter'] = $Ventilations->lundi_collecter;
        $newCrudData['mardi_collecter'] = $Ventilations->mardi_collecter;
        $newCrudData['mercredi_collecter'] = $Ventilations->mercredi_collecter;
        $newCrudData['jeudi_collecter'] = $Ventilations->jeudi_collecter;
        $newCrudData['vendredi_collecter'] = $Ventilations->vendredi_collecter;
        $newCrudData['samedi_collecter'] = $Ventilations->samedi_collecter;
        $newCrudData['dimanche_depassement'] = $Ventilations->dimanche_depassement;
        $newCrudData['lundi_depassement'] = $Ventilations->lundi_depassement;
        $newCrudData['mardi_depassement'] = $Ventilations->mardi_depassement;
        $newCrudData['mercredi_depassement'] = $Ventilations->mercredi_depassement;
        $newCrudData['jeudi_depassement'] = $Ventilations->jeudi_depassement;
        $newCrudData['vendredi_depassement'] = $Ventilations->vendredi_depassement;
        $newCrudData['samedi_depassement'] = $Ventilations->samedi_depassement;
        $newCrudData['dimanche_programmer'] = $Ventilations->dimanche_programmer;
        $newCrudData['lundi_programmer'] = $Ventilations->lundi_programmer;
        $newCrudData['mardi_programmer'] = $Ventilations->mardi_programmer;
        $newCrudData['mercredi_programmer'] = $Ventilations->mercredi_programmer;
        $newCrudData['jeudi_programmer'] = $Ventilations->jeudi_programmer;
        $newCrudData['vendredi_programmer'] = $Ventilations->vendredi_programmer;
        $newCrudData['samedi_programmer'] = $Ventilations->samedi_programmer;
        $newCrudData['dimanche_retard'] = $Ventilations->dimanche_retard;
        $newCrudData['lundi_retard'] = $Ventilations->lundi_retard;
        $newCrudData['mardi_retard'] = $Ventilations->mardi_retard;
        $newCrudData['mercredi_retard'] = $Ventilations->mercredi_retard;
        $newCrudData['jeudi_retard'] = $Ventilations->jeudi_retard;
        $newCrudData['vendredi_retard'] = $Ventilations->vendredi_retard;
        $newCrudData['samedi_retard'] = $Ventilations->samedi_retard;
        $newCrudData['programmation_id'] = $Ventilations->programmation_id;
        $newCrudData['total_programmer'] = $Ventilations->total_programmer;
        $newCrudData['total_colecter'] = $Ventilations->total_colecter;
        $newCrudData['total_depassement'] = $Ventilations->total_depassement;
        $newCrudData['hs15'] = $Ventilations->hs15;
        $newCrudData['hs26'] = $Ventilations->hs26;
        $newCrudData['hs55'] = $Ventilations->hs55;
        $newCrudData['hs30'] = $Ventilations->hs30;
        $newCrudData['hs60'] = $Ventilations->hs60;
        $newCrudData['hs115'] = $Ventilations->hs115;
        $newCrudData['hs130'] = $Ventilations->hs130;
        $newCrudData['total'] = $Ventilations->total;
        $newCrudData['identifiants_sadge'] = $Ventilations->identifiants_sadge;
        $newCrudData['creat_by'] = $Ventilations->creat_by;
        try {
            $newCrudData['programmation'] = $Ventilations->programmation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Ventilations->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Ventilations', 'entite_cle' => $Ventilations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
