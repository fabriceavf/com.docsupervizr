<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateAgentsrapportExecUseCase
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

        $Agentsrapports = new \App\Models\Agentsrapport();

        if (!empty($data['mois'])) {
            $Agentsrapports->mois = $data['mois'];
        }
        if (!empty($data['user_id'])) {
            $Agentsrapports->user_id = $data['user_id'];
        }
        if (!empty($data['jour_abscences'])) {
            $Agentsrapports->jour_abscences = $data['jour_abscences'];
        }
        if (!empty($data['jour_presences'])) {
            $Agentsrapports->jour_presences = $data['jour_presences'];
        }
        if (!empty($data['day_01'])) {
            $Agentsrapports->day_01 = $data['day_01'];
        }
        if (!empty($data['day_02'])) {
            $Agentsrapports->day_02 = $data['day_02'];
        }
        if (!empty($data['day_03'])) {
            $Agentsrapports->day_03 = $data['day_03'];
        }
        if (!empty($data['day_04'])) {
            $Agentsrapports->day_04 = $data['day_04'];
        }
        if (!empty($data['day_05'])) {
            $Agentsrapports->day_05 = $data['day_05'];
        }
        if (!empty($data['day_06'])) {
            $Agentsrapports->day_06 = $data['day_06'];
        }
        if (!empty($data['day_07'])) {
            $Agentsrapports->day_07 = $data['day_07'];
        }
        if (!empty($data['day_08'])) {
            $Agentsrapports->day_08 = $data['day_08'];
        }
        if (!empty($data['day_09'])) {
            $Agentsrapports->day_09 = $data['day_09'];
        }
        if (!empty($data['day_10'])) {
            $Agentsrapports->day_10 = $data['day_10'];
        }
        if (!empty($data['day_11'])) {
            $Agentsrapports->day_11 = $data['day_11'];
        }
        if (!empty($data['day_12'])) {
            $Agentsrapports->day_12 = $data['day_12'];
        }
        if (!empty($data['day_13'])) {
            $Agentsrapports->day_13 = $data['day_13'];
        }
        if (!empty($data['day_14'])) {
            $Agentsrapports->day_14 = $data['day_14'];
        }
        if (!empty($data['day_15'])) {
            $Agentsrapports->day_15 = $data['day_15'];
        }
        if (!empty($data['day_16'])) {
            $Agentsrapports->day_16 = $data['day_16'];
        }
        if (!empty($data['day_17'])) {
            $Agentsrapports->day_17 = $data['day_17'];
        }
        if (!empty($data['day_18'])) {
            $Agentsrapports->day_18 = $data['day_18'];
        }
        if (!empty($data['day_19'])) {
            $Agentsrapports->day_19 = $data['day_19'];
        }
        if (!empty($data['day_20'])) {
            $Agentsrapports->day_20 = $data['day_20'];
        }
        if (!empty($data['day_21'])) {
            $Agentsrapports->day_21 = $data['day_21'];
        }
        if (!empty($data['day_22'])) {
            $Agentsrapports->day_22 = $data['day_22'];
        }
        if (!empty($data['day_23'])) {
            $Agentsrapports->day_23 = $data['day_23'];
        }
        if (!empty($data['day_24'])) {
            $Agentsrapports->day_24 = $data['day_24'];
        }
        if (!empty($data['day_25'])) {
            $Agentsrapports->day_25 = $data['day_25'];
        }
        if (!empty($data['day_26'])) {
            $Agentsrapports->day_26 = $data['day_26'];
        }
        if (!empty($data['day_27'])) {
            $Agentsrapports->day_27 = $data['day_27'];
        }
        if (!empty($data['day_28'])) {
            $Agentsrapports->day_28 = $data['day_28'];
        }
        if (!empty($data['day_29'])) {
            $Agentsrapports->day_29 = $data['day_29'];
        }
        if (!empty($data['day_30'])) {
            $Agentsrapports->day_30 = $data['day_30'];
        }
        if (!empty($data['day_31'])) {
            $Agentsrapports->day_31 = $data['day_31'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Agentsrapports->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Agentsrapports->creat_by = $data['creat_by'];
        }
        $Agentsrapports->save();
        $Agentsrapports = \App\Models\Agentsrapport::find($Agentsrapports->id);
        $newCrudData = [];
        $newCrudData['mois'] = $Agentsrapports->mois;
        $newCrudData['user_id'] = $Agentsrapports->user_id;
        $newCrudData['jour_abscences'] = $Agentsrapports->jour_abscences;
        $newCrudData['jour_presences'] = $Agentsrapports->jour_presences;
        $newCrudData['day_01'] = $Agentsrapports->day_01;
        $newCrudData['day_02'] = $Agentsrapports->day_02;
        $newCrudData['day_03'] = $Agentsrapports->day_03;
        $newCrudData['day_04'] = $Agentsrapports->day_04;
        $newCrudData['day_05'] = $Agentsrapports->day_05;
        $newCrudData['day_06'] = $Agentsrapports->day_06;
        $newCrudData['day_07'] = $Agentsrapports->day_07;
        $newCrudData['day_08'] = $Agentsrapports->day_08;
        $newCrudData['day_09'] = $Agentsrapports->day_09;
        $newCrudData['day_10'] = $Agentsrapports->day_10;
        $newCrudData['day_11'] = $Agentsrapports->day_11;
        $newCrudData['day_12'] = $Agentsrapports->day_12;
        $newCrudData['day_13'] = $Agentsrapports->day_13;
        $newCrudData['day_14'] = $Agentsrapports->day_14;
        $newCrudData['day_15'] = $Agentsrapports->day_15;
        $newCrudData['day_16'] = $Agentsrapports->day_16;
        $newCrudData['day_17'] = $Agentsrapports->day_17;
        $newCrudData['day_18'] = $Agentsrapports->day_18;
        $newCrudData['day_19'] = $Agentsrapports->day_19;
        $newCrudData['day_20'] = $Agentsrapports->day_20;
        $newCrudData['day_21'] = $Agentsrapports->day_21;
        $newCrudData['day_22'] = $Agentsrapports->day_22;
        $newCrudData['day_23'] = $Agentsrapports->day_23;
        $newCrudData['day_24'] = $Agentsrapports->day_24;
        $newCrudData['day_25'] = $Agentsrapports->day_25;
        $newCrudData['day_26'] = $Agentsrapports->day_26;
        $newCrudData['day_27'] = $Agentsrapports->day_27;
        $newCrudData['day_28'] = $Agentsrapports->day_28;
        $newCrudData['day_29'] = $Agentsrapports->day_29;
        $newCrudData['day_30'] = $Agentsrapports->day_30;
        $newCrudData['day_31'] = $Agentsrapports->day_31;
        $newCrudData['identifiants_sadge'] = $Agentsrapports->identifiants_sadge;
        $newCrudData['creat_by'] = $Agentsrapports->creat_by;
        try {
            $newCrudData['user'] = $Agentsrapports->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Agentsrapports', 'entite_cle' => $Agentsrapports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Agentsrapports->toArray();
        return $data;
    }

}
