<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateVentilationExecUseCase
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

        $Ventilations = new \App\Models\Ventilation();

        if (!empty($data['user_id'])) {
            $Ventilations->user_id = $data['user_id'];
        }
        if (!empty($data['semaine'])) {
            $Ventilations->semaine = $data['semaine'];
        }
        if (!empty($data['dimanche_date'])) {
            $Ventilations->dimanche_date = $data['dimanche_date'];
        }
        if (!empty($data['lundi_date'])) {
            $Ventilations->lundi_date = $data['lundi_date'];
        }
        if (!empty($data['mardi_date'])) {
            $Ventilations->mardi_date = $data['mardi_date'];
        }
        if (!empty($data['mercredi_date'])) {
            $Ventilations->mercredi_date = $data['mercredi_date'];
        }
        if (!empty($data['jeudi_date'])) {
            $Ventilations->jeudi_date = $data['jeudi_date'];
        }
        if (!empty($data['vendredi_date'])) {
            $Ventilations->vendredi_date = $data['vendredi_date'];
        }
        if (!empty($data['samedi_date'])) {
            $Ventilations->samedi_date = $data['samedi_date'];
        }
        if (!empty($data['dimanche_horaire'])) {
            $Ventilations->dimanche_horaire = $data['dimanche_horaire'];
        }
        if (!empty($data['lundi_horaire'])) {
            $Ventilations->lundi_horaire = $data['lundi_horaire'];
        }
        if (!empty($data['mardi_horaire'])) {
            $Ventilations->mardi_horaire = $data['mardi_horaire'];
        }
        if (!empty($data['mercredi_horaire'])) {
            $Ventilations->mercredi_horaire = $data['mercredi_horaire'];
        }
        if (!empty($data['jeudi_horaire'])) {
            $Ventilations->jeudi_horaire = $data['jeudi_horaire'];
        }
        if (!empty($data['vendredi_horaire'])) {
            $Ventilations->vendredi_horaire = $data['vendredi_horaire'];
        }
        if (!empty($data['samedi_horaire'])) {
            $Ventilations->samedi_horaire = $data['samedi_horaire'];
        }
        if (!empty($data['dimanche'])) {
            $Ventilations->dimanche = $data['dimanche'];
        }
        if (!empty($data['lundi'])) {
            $Ventilations->lundi = $data['lundi'];
        }
        if (!empty($data['mardi'])) {
            $Ventilations->mardi = $data['mardi'];
        }
        if (!empty($data['mercredi'])) {
            $Ventilations->mercredi = $data['mercredi'];
        }
        if (!empty($data['jeudi'])) {
            $Ventilations->jeudi = $data['jeudi'];
        }
        if (!empty($data['vendredi'])) {
            $Ventilations->vendredi = $data['vendredi'];
        }
        if (!empty($data['samedi'])) {
            $Ventilations->samedi = $data['samedi'];
        }
        if (!empty($data['dimanche_pointage'])) {
            $Ventilations->dimanche_pointage = $data['dimanche_pointage'];
        }
        if (!empty($data['lundi_pointage'])) {
            $Ventilations->lundi_pointage = $data['lundi_pointage'];
        }
        if (!empty($data['mardi_pointage'])) {
            $Ventilations->mardi_pointage = $data['mardi_pointage'];
        }
        if (!empty($data['mercredi_pointage'])) {
            $Ventilations->mercredi_pointage = $data['mercredi_pointage'];
        }
        if (!empty($data['jeudi_pointage'])) {
            $Ventilations->jeudi_pointage = $data['jeudi_pointage'];
        }
        if (!empty($data['vendredi_pointage'])) {
            $Ventilations->vendredi_pointage = $data['vendredi_pointage'];
        }
        if (!empty($data['samedi_pointage'])) {
            $Ventilations->samedi_pointage = $data['samedi_pointage'];
        }
        if (!empty($data['dimanche_collecter'])) {
            $Ventilations->dimanche_collecter = $data['dimanche_collecter'];
        }
        if (!empty($data['lundi_collecter'])) {
            $Ventilations->lundi_collecter = $data['lundi_collecter'];
        }
        if (!empty($data['mardi_collecter'])) {
            $Ventilations->mardi_collecter = $data['mardi_collecter'];
        }
        if (!empty($data['mercredi_collecter'])) {
            $Ventilations->mercredi_collecter = $data['mercredi_collecter'];
        }
        if (!empty($data['jeudi_collecter'])) {
            $Ventilations->jeudi_collecter = $data['jeudi_collecter'];
        }
        if (!empty($data['vendredi_collecter'])) {
            $Ventilations->vendredi_collecter = $data['vendredi_collecter'];
        }
        if (!empty($data['samedi_collecter'])) {
            $Ventilations->samedi_collecter = $data['samedi_collecter'];
        }
        if (!empty($data['dimanche_depassement'])) {
            $Ventilations->dimanche_depassement = $data['dimanche_depassement'];
        }
        if (!empty($data['lundi_depassement'])) {
            $Ventilations->lundi_depassement = $data['lundi_depassement'];
        }
        if (!empty($data['mardi_depassement'])) {
            $Ventilations->mardi_depassement = $data['mardi_depassement'];
        }
        if (!empty($data['mercredi_depassement'])) {
            $Ventilations->mercredi_depassement = $data['mercredi_depassement'];
        }
        if (!empty($data['jeudi_depassement'])) {
            $Ventilations->jeudi_depassement = $data['jeudi_depassement'];
        }
        if (!empty($data['vendredi_depassement'])) {
            $Ventilations->vendredi_depassement = $data['vendredi_depassement'];
        }
        if (!empty($data['samedi_depassement'])) {
            $Ventilations->samedi_depassement = $data['samedi_depassement'];
        }
        if (!empty($data['dimanche_programmer'])) {
            $Ventilations->dimanche_programmer = $data['dimanche_programmer'];
        }
        if (!empty($data['lundi_programmer'])) {
            $Ventilations->lundi_programmer = $data['lundi_programmer'];
        }
        if (!empty($data['mardi_programmer'])) {
            $Ventilations->mardi_programmer = $data['mardi_programmer'];
        }
        if (!empty($data['mercredi_programmer'])) {
            $Ventilations->mercredi_programmer = $data['mercredi_programmer'];
        }
        if (!empty($data['jeudi_programmer'])) {
            $Ventilations->jeudi_programmer = $data['jeudi_programmer'];
        }
        if (!empty($data['vendredi_programmer'])) {
            $Ventilations->vendredi_programmer = $data['vendredi_programmer'];
        }
        if (!empty($data['samedi_programmer'])) {
            $Ventilations->samedi_programmer = $data['samedi_programmer'];
        }
        if (!empty($data['dimanche_retard'])) {
            $Ventilations->dimanche_retard = $data['dimanche_retard'];
        }
        if (!empty($data['lundi_retard'])) {
            $Ventilations->lundi_retard = $data['lundi_retard'];
        }
        if (!empty($data['mardi_retard'])) {
            $Ventilations->mardi_retard = $data['mardi_retard'];
        }
        if (!empty($data['mercredi_retard'])) {
            $Ventilations->mercredi_retard = $data['mercredi_retard'];
        }
        if (!empty($data['jeudi_retard'])) {
            $Ventilations->jeudi_retard = $data['jeudi_retard'];
        }
        if (!empty($data['vendredi_retard'])) {
            $Ventilations->vendredi_retard = $data['vendredi_retard'];
        }
        if (!empty($data['samedi_retard'])) {
            $Ventilations->samedi_retard = $data['samedi_retard'];
        }
        if (!empty($data['programmation_id'])) {
            $Ventilations->programmation_id = $data['programmation_id'];
        }
        if (!empty($data['total_programmer'])) {
            $Ventilations->total_programmer = $data['total_programmer'];
        }
        if (!empty($data['total_colecter'])) {
            $Ventilations->total_colecter = $data['total_colecter'];
        }
        if (!empty($data['total_depassement'])) {
            $Ventilations->total_depassement = $data['total_depassement'];
        }
        if (!empty($data['hs15'])) {
            $Ventilations->hs15 = $data['hs15'];
        }
        if (!empty($data['hs26'])) {
            $Ventilations->hs26 = $data['hs26'];
        }
        if (!empty($data['hs55'])) {
            $Ventilations->hs55 = $data['hs55'];
        }
        if (!empty($data['hs30'])) {
            $Ventilations->hs30 = $data['hs30'];
        }
        if (!empty($data['hs60'])) {
            $Ventilations->hs60 = $data['hs60'];
        }
        if (!empty($data['hs115'])) {
            $Ventilations->hs115 = $data['hs115'];
        }
        if (!empty($data['hs130'])) {
            $Ventilations->hs130 = $data['hs130'];
        }
        if (!empty($data['total'])) {
            $Ventilations->total = $data['total'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Ventilations->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Ventilations->creat_by = $data['creat_by'];
        }
        $Ventilations->save();
        $Ventilations = \App\Models\Ventilation::find($Ventilations->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Ventilations', 'entite_cle' => $Ventilations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Ventilations->toArray();
        return $data;
    }

}
