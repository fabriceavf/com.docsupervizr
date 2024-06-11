<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateListesappelsjourExecUseCase
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

        $Listesappelsjours = new \App\Models\Listesappelsjour();

        if (!empty($data['rand'])) {
            $Listesappelsjours->rand = $data['rand'];
        }
        if (!empty($data['jour01'])) {
            $Listesappelsjours->jour01 = $data['jour01'];
        }
        if (!empty($data['jour02'])) {
            $Listesappelsjours->jour02 = $data['jour02'];
        }
        if (!empty($data['jour03'])) {
            $Listesappelsjours->jour03 = $data['jour03'];
        }
        if (!empty($data['jour04'])) {
            $Listesappelsjours->jour04 = $data['jour04'];
        }
        if (!empty($data['jour05'])) {
            $Listesappelsjours->jour05 = $data['jour05'];
        }
        if (!empty($data['jour06'])) {
            $Listesappelsjours->jour06 = $data['jour06'];
        }
        if (!empty($data['jour07'])) {
            $Listesappelsjours->jour07 = $data['jour07'];
        }
        if (!empty($data['jour08'])) {
            $Listesappelsjours->jour08 = $data['jour08'];
        }
        if (!empty($data['jour09'])) {
            $Listesappelsjours->jour09 = $data['jour09'];
        }
        if (!empty($data['jour10'])) {
            $Listesappelsjours->jour10 = $data['jour10'];
        }
        if (!empty($data['jour11'])) {
            $Listesappelsjours->jour11 = $data['jour11'];
        }
        if (!empty($data['jour12'])) {
            $Listesappelsjours->jour12 = $data['jour12'];
        }
        if (!empty($data['jour13'])) {
            $Listesappelsjours->jour13 = $data['jour13'];
        }
        if (!empty($data['jour14'])) {
            $Listesappelsjours->jour14 = $data['jour14'];
        }
        if (!empty($data['jour15'])) {
            $Listesappelsjours->jour15 = $data['jour15'];
        }
        if (!empty($data['jour16'])) {
            $Listesappelsjours->jour16 = $data['jour16'];
        }
        if (!empty($data['jour17'])) {
            $Listesappelsjours->jour17 = $data['jour17'];
        }
        if (!empty($data['jour18'])) {
            $Listesappelsjours->jour18 = $data['jour18'];
        }
        if (!empty($data['jour19'])) {
            $Listesappelsjours->jour19 = $data['jour19'];
        }
        if (!empty($data['jour20'])) {
            $Listesappelsjours->jour20 = $data['jour20'];
        }
        if (!empty($data['jour21'])) {
            $Listesappelsjours->jour21 = $data['jour21'];
        }
        if (!empty($data['jour22'])) {
            $Listesappelsjours->jour22 = $data['jour22'];
        }
        if (!empty($data['jour23'])) {
            $Listesappelsjours->jour23 = $data['jour23'];
        }
        if (!empty($data['jour24'])) {
            $Listesappelsjours->jour24 = $data['jour24'];
        }
        if (!empty($data['jour25'])) {
            $Listesappelsjours->jour25 = $data['jour25'];
        }
        if (!empty($data['jour26'])) {
            $Listesappelsjours->jour26 = $data['jour26'];
        }
        if (!empty($data['jour27'])) {
            $Listesappelsjours->jour27 = $data['jour27'];
        }
        if (!empty($data['jour28'])) {
            $Listesappelsjours->jour28 = $data['jour28'];
        }
        if (!empty($data['jour29'])) {
            $Listesappelsjours->jour29 = $data['jour29'];
        }
        if (!empty($data['jour30'])) {
            $Listesappelsjours->jour30 = $data['jour30'];
        }
        if (!empty($data['jour31'])) {
            $Listesappelsjours->jour31 = $data['jour31'];
        }
        if (!empty($data['tache01'])) {
            $Listesappelsjours->tache01 = $data['tache01'];
        }
        if (!empty($data['tache02'])) {
            $Listesappelsjours->tache02 = $data['tache02'];
        }
        if (!empty($data['tache03'])) {
            $Listesappelsjours->tache03 = $data['tache03'];
        }
        if (!empty($data['tache04'])) {
            $Listesappelsjours->tache04 = $data['tache04'];
        }
        if (!empty($data['tache05'])) {
            $Listesappelsjours->tache05 = $data['tache05'];
        }
        if (!empty($data['tache06'])) {
            $Listesappelsjours->tache06 = $data['tache06'];
        }
        if (!empty($data['tache07'])) {
            $Listesappelsjours->tache07 = $data['tache07'];
        }
        if (!empty($data['tache08'])) {
            $Listesappelsjours->tache08 = $data['tache08'];
        }
        if (!empty($data['tache09'])) {
            $Listesappelsjours->tache09 = $data['tache09'];
        }
        if (!empty($data['tache10'])) {
            $Listesappelsjours->tache10 = $data['tache10'];
        }
        if (!empty($data['tache11'])) {
            $Listesappelsjours->tache11 = $data['tache11'];
        }
        if (!empty($data['tache12'])) {
            $Listesappelsjours->tache12 = $data['tache12'];
        }
        if (!empty($data['tache13'])) {
            $Listesappelsjours->tache13 = $data['tache13'];
        }
        if (!empty($data['tache14'])) {
            $Listesappelsjours->tache14 = $data['tache14'];
        }
        if (!empty($data['tache15'])) {
            $Listesappelsjours->tache15 = $data['tache15'];
        }
        if (!empty($data['tache16'])) {
            $Listesappelsjours->tache16 = $data['tache16'];
        }
        if (!empty($data['tache17'])) {
            $Listesappelsjours->tache17 = $data['tache17'];
        }
        if (!empty($data['tache18'])) {
            $Listesappelsjours->tache18 = $data['tache18'];
        }
        if (!empty($data['tache19'])) {
            $Listesappelsjours->tache19 = $data['tache19'];
        }
        if (!empty($data['tache20'])) {
            $Listesappelsjours->tache20 = $data['tache20'];
        }
        if (!empty($data['tache21'])) {
            $Listesappelsjours->tache21 = $data['tache21'];
        }
        if (!empty($data['tache22'])) {
            $Listesappelsjours->tache22 = $data['tache22'];
        }
        if (!empty($data['tache23'])) {
            $Listesappelsjours->tache23 = $data['tache23'];
        }
        if (!empty($data['tache24'])) {
            $Listesappelsjours->tache24 = $data['tache24'];
        }
        if (!empty($data['tache25'])) {
            $Listesappelsjours->tache25 = $data['tache25'];
        }
        if (!empty($data['tache26'])) {
            $Listesappelsjours->tache26 = $data['tache26'];
        }
        if (!empty($data['tache27'])) {
            $Listesappelsjours->tache27 = $data['tache27'];
        }
        if (!empty($data['tache28'])) {
            $Listesappelsjours->tache28 = $data['tache28'];
        }
        if (!empty($data['tache29'])) {
            $Listesappelsjours->tache29 = $data['tache29'];
        }
        if (!empty($data['tache30'])) {
            $Listesappelsjours->tache30 = $data['tache30'];
        }
        if (!empty($data['tache31'])) {
            $Listesappelsjours->tache31 = $data['tache31'];
        }
        if (!empty($data['listesappel_id'])) {
            $Listesappelsjours->listesappel_id = $data['listesappel_id'];
        }
        if (!empty($data['user_id'])) {
            $Listesappelsjours->user_id = $data['user_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Listesappelsjours->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Listesappelsjours->creat_by = $data['creat_by'];
        }
        $Listesappelsjours->save();
        $Listesappelsjours = \App\Models\Listesappelsjour::find($Listesappelsjours->id);
        $newCrudData = [];
        $newCrudData['rand'] = $Listesappelsjours->rand;
        $newCrudData['jour01'] = $Listesappelsjours->jour01;
        $newCrudData['jour02'] = $Listesappelsjours->jour02;
        $newCrudData['jour03'] = $Listesappelsjours->jour03;
        $newCrudData['jour04'] = $Listesappelsjours->jour04;
        $newCrudData['jour05'] = $Listesappelsjours->jour05;
        $newCrudData['jour06'] = $Listesappelsjours->jour06;
        $newCrudData['jour07'] = $Listesappelsjours->jour07;
        $newCrudData['jour08'] = $Listesappelsjours->jour08;
        $newCrudData['jour09'] = $Listesappelsjours->jour09;
        $newCrudData['jour10'] = $Listesappelsjours->jour10;
        $newCrudData['jour11'] = $Listesappelsjours->jour11;
        $newCrudData['jour12'] = $Listesappelsjours->jour12;
        $newCrudData['jour13'] = $Listesappelsjours->jour13;
        $newCrudData['jour14'] = $Listesappelsjours->jour14;
        $newCrudData['jour15'] = $Listesappelsjours->jour15;
        $newCrudData['jour16'] = $Listesappelsjours->jour16;
        $newCrudData['jour17'] = $Listesappelsjours->jour17;
        $newCrudData['jour18'] = $Listesappelsjours->jour18;
        $newCrudData['jour19'] = $Listesappelsjours->jour19;
        $newCrudData['jour20'] = $Listesappelsjours->jour20;
        $newCrudData['jour21'] = $Listesappelsjours->jour21;
        $newCrudData['jour22'] = $Listesappelsjours->jour22;
        $newCrudData['jour23'] = $Listesappelsjours->jour23;
        $newCrudData['jour24'] = $Listesappelsjours->jour24;
        $newCrudData['jour25'] = $Listesappelsjours->jour25;
        $newCrudData['jour26'] = $Listesappelsjours->jour26;
        $newCrudData['jour27'] = $Listesappelsjours->jour27;
        $newCrudData['jour28'] = $Listesappelsjours->jour28;
        $newCrudData['jour29'] = $Listesappelsjours->jour29;
        $newCrudData['jour30'] = $Listesappelsjours->jour30;
        $newCrudData['jour31'] = $Listesappelsjours->jour31;
        $newCrudData['tache01'] = $Listesappelsjours->tache01;
        $newCrudData['tache02'] = $Listesappelsjours->tache02;
        $newCrudData['tache03'] = $Listesappelsjours->tache03;
        $newCrudData['tache04'] = $Listesappelsjours->tache04;
        $newCrudData['tache05'] = $Listesappelsjours->tache05;
        $newCrudData['tache06'] = $Listesappelsjours->tache06;
        $newCrudData['tache07'] = $Listesappelsjours->tache07;
        $newCrudData['tache08'] = $Listesappelsjours->tache08;
        $newCrudData['tache09'] = $Listesappelsjours->tache09;
        $newCrudData['tache10'] = $Listesappelsjours->tache10;
        $newCrudData['tache11'] = $Listesappelsjours->tache11;
        $newCrudData['tache12'] = $Listesappelsjours->tache12;
        $newCrudData['tache13'] = $Listesappelsjours->tache13;
        $newCrudData['tache14'] = $Listesappelsjours->tache14;
        $newCrudData['tache15'] = $Listesappelsjours->tache15;
        $newCrudData['tache16'] = $Listesappelsjours->tache16;
        $newCrudData['tache17'] = $Listesappelsjours->tache17;
        $newCrudData['tache18'] = $Listesappelsjours->tache18;
        $newCrudData['tache19'] = $Listesappelsjours->tache19;
        $newCrudData['tache20'] = $Listesappelsjours->tache20;
        $newCrudData['tache21'] = $Listesappelsjours->tache21;
        $newCrudData['tache22'] = $Listesappelsjours->tache22;
        $newCrudData['tache23'] = $Listesappelsjours->tache23;
        $newCrudData['tache24'] = $Listesappelsjours->tache24;
        $newCrudData['tache25'] = $Listesappelsjours->tache25;
        $newCrudData['tache26'] = $Listesappelsjours->tache26;
        $newCrudData['tache27'] = $Listesappelsjours->tache27;
        $newCrudData['tache28'] = $Listesappelsjours->tache28;
        $newCrudData['tache29'] = $Listesappelsjours->tache29;
        $newCrudData['tache30'] = $Listesappelsjours->tache30;
        $newCrudData['tache31'] = $Listesappelsjours->tache31;
        $newCrudData['listesappel_id'] = $Listesappelsjours->listesappel_id;
        $newCrudData['user_id'] = $Listesappelsjours->user_id;
        $newCrudData['identifiants_sadge'] = $Listesappelsjours->identifiants_sadge;
        $newCrudData['creat_by'] = $Listesappelsjours->creat_by;
        try {
            $newCrudData['listesappel'] = $Listesappelsjours->listesappel->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Listesappelsjours->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Listesappelsjours', 'entite_cle' => $Listesappelsjours->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Listesappelsjours->toArray();
        return $data;
    }

}
