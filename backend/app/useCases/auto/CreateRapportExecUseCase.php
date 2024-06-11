<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateRapportExecUseCase
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

        $Rapports = new \App\Models\Rapport();

        if (!empty($data['mois'])) {
            $Rapports->mois = $data['mois'];
        }
        if (!empty($data['poste_id'])) {
            $Rapports->poste_id = $data['poste_id'];
        }
        if (!empty($data['ville_id'])) {
            $Rapports->ville_id = $data['ville_id'];
        }
        if (!empty($data['zone_id'])) {
            $Rapports->zone_id = $data['zone_id'];
        }
        if (!empty($data['fonction_id'])) {
            $Rapports->fonction_id = $data['fonction_id'];
        }
        if (!empty($data['type_id'])) {
            $Rapports->type_id = $data['type_id'];
        }
        if (!empty($data['faction_id'])) {
            $Rapports->faction_id = $data['faction_id'];
        }
        if (!empty($data['site_id'])) {
            $Rapports->site_id = $data['site_id'];
        }
        if (!empty($data['client_id'])) {
            $Rapports->client_id = $data['client_id'];
        }
        if (!empty($data['day_01'])) {
            $Rapports->day_01 = $data['day_01'];
        }
        if (!empty($data['day_02'])) {
            $Rapports->day_02 = $data['day_02'];
        }
        if (!empty($data['day_03'])) {
            $Rapports->day_03 = $data['day_03'];
        }
        if (!empty($data['day_04'])) {
            $Rapports->day_04 = $data['day_04'];
        }
        if (!empty($data['day_05'])) {
            $Rapports->day_05 = $data['day_05'];
        }
        if (!empty($data['day_06'])) {
            $Rapports->day_06 = $data['day_06'];
        }
        if (!empty($data['day_07'])) {
            $Rapports->day_07 = $data['day_07'];
        }
        if (!empty($data['day_08'])) {
            $Rapports->day_08 = $data['day_08'];
        }
        if (!empty($data['day_09'])) {
            $Rapports->day_09 = $data['day_09'];
        }
        if (!empty($data['day_10'])) {
            $Rapports->day_10 = $data['day_10'];
        }
        if (!empty($data['day_11'])) {
            $Rapports->day_11 = $data['day_11'];
        }
        if (!empty($data['day_12'])) {
            $Rapports->day_12 = $data['day_12'];
        }
        if (!empty($data['day_13'])) {
            $Rapports->day_13 = $data['day_13'];
        }
        if (!empty($data['day_14'])) {
            $Rapports->day_14 = $data['day_14'];
        }
        if (!empty($data['day_15'])) {
            $Rapports->day_15 = $data['day_15'];
        }
        if (!empty($data['day_16'])) {
            $Rapports->day_16 = $data['day_16'];
        }
        if (!empty($data['day_17'])) {
            $Rapports->day_17 = $data['day_17'];
        }
        if (!empty($data['day_18'])) {
            $Rapports->day_18 = $data['day_18'];
        }
        if (!empty($data['day_19'])) {
            $Rapports->day_19 = $data['day_19'];
        }
        if (!empty($data['day_20'])) {
            $Rapports->day_20 = $data['day_20'];
        }
        if (!empty($data['day_21'])) {
            $Rapports->day_21 = $data['day_21'];
        }
        if (!empty($data['day_22'])) {
            $Rapports->day_22 = $data['day_22'];
        }
        if (!empty($data['day_23'])) {
            $Rapports->day_23 = $data['day_23'];
        }
        if (!empty($data['day_24'])) {
            $Rapports->day_24 = $data['day_24'];
        }
        if (!empty($data['day_25'])) {
            $Rapports->day_25 = $data['day_25'];
        }
        if (!empty($data['day_26'])) {
            $Rapports->day_26 = $data['day_26'];
        }
        if (!empty($data['day_27'])) {
            $Rapports->day_27 = $data['day_27'];
        }
        if (!empty($data['day_28'])) {
            $Rapports->day_28 = $data['day_28'];
        }
        if (!empty($data['day_29'])) {
            $Rapports->day_29 = $data['day_29'];
        }
        if (!empty($data['day_30'])) {
            $Rapports->day_30 = $data['day_30'];
        }
        if (!empty($data['day_31'])) {
            $Rapports->day_31 = $data['day_31'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Rapports->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Rapports->creat_by = $data['creat_by'];
        }
        $Rapports->save();
        $Rapports = \App\Models\Rapport::find($Rapports->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Rapports', 'entite_cle' => $Rapports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Rapports->toArray();
        return $data;
    }

}
