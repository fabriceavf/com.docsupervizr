<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteRapportExecUseCase
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

        $Rapports = \App\Models\Rapport::find($data['id']);


        $Rapports->deleted_at = now();
        $Rapports->save();
        $newCrudData = [];
        $newCrudData['mois'] = $Rapports->mois;
        $newCrudData['poste_id'] = $Rapports->poste_id;
        $newCrudData['ville_id'] = $Rapports->ville_id;
        $newCrudData['zone_id'] = $Rapports->zone_id;
        $newCrudData['fonction_id'] = $Rapports->fonction_id;
        $newCrudData['type_id'] = $Rapports->type_id;
        $newCrudData['faction_id'] = $Rapports->faction_id;
        $newCrudData['site_id'] = $Rapports->site_id;
        $newCrudData['client_id'] = $Rapports->client_id;
        $newCrudData['day_01'] = $Rapports->day_01;
        $newCrudData['day_02'] = $Rapports->day_02;
        $newCrudData['day_03'] = $Rapports->day_03;
        $newCrudData['day_04'] = $Rapports->day_04;
        $newCrudData['day_05'] = $Rapports->day_05;
        $newCrudData['day_06'] = $Rapports->day_06;
        $newCrudData['day_07'] = $Rapports->day_07;
        $newCrudData['day_08'] = $Rapports->day_08;
        $newCrudData['day_09'] = $Rapports->day_09;
        $newCrudData['day_10'] = $Rapports->day_10;
        $newCrudData['day_11'] = $Rapports->day_11;
        $newCrudData['day_12'] = $Rapports->day_12;
        $newCrudData['day_13'] = $Rapports->day_13;
        $newCrudData['day_14'] = $Rapports->day_14;
        $newCrudData['day_15'] = $Rapports->day_15;
        $newCrudData['day_16'] = $Rapports->day_16;
        $newCrudData['day_17'] = $Rapports->day_17;
        $newCrudData['day_18'] = $Rapports->day_18;
        $newCrudData['day_19'] = $Rapports->day_19;
        $newCrudData['day_20'] = $Rapports->day_20;
        $newCrudData['day_21'] = $Rapports->day_21;
        $newCrudData['day_22'] = $Rapports->day_22;
        $newCrudData['day_23'] = $Rapports->day_23;
        $newCrudData['day_24'] = $Rapports->day_24;
        $newCrudData['day_25'] = $Rapports->day_25;
        $newCrudData['day_26'] = $Rapports->day_26;
        $newCrudData['day_27'] = $Rapports->day_27;
        $newCrudData['day_28'] = $Rapports->day_28;
        $newCrudData['day_29'] = $Rapports->day_29;
        $newCrudData['day_30'] = $Rapports->day_30;
        $newCrudData['day_31'] = $Rapports->day_31;
        $newCrudData['identifiants_sadge'] = $Rapports->identifiants_sadge;
        $newCrudData['creat_by'] = $Rapports->creat_by;
        try {
            $newCrudData['client'] = $Rapports->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['faction'] = $Rapports->faction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['fonction'] = $Rapports->fonction->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Rapports->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Rapports->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['type'] = $Rapports->type->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Rapports->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Rapports->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Rapports', 'entite_cle' => $Rapports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
