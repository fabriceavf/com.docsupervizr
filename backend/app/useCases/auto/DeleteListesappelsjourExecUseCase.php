<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteListesappelsjourExecUseCase
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

        $Listesappelsjours = \App\Models\Listesappelsjour::find($data['id']);


        $Listesappelsjours->deleted_at = now();
        $Listesappelsjours->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Listesappelsjours', 'entite_cle' => $Listesappelsjours->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
