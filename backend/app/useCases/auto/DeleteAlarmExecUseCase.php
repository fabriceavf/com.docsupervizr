<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteAlarmExecUseCase
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

        $Alarms = \App\Models\Alarm::find($data['id']);


        $Alarms->deleted_at = now();
        $Alarms->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Alarms->libelle;
        $newCrudData['description'] = $Alarms->description;
        $newCrudData['type'] = $Alarms->type;
        $newCrudData['identifiants_sadge'] = $Alarms->identifiants_sadge;
        $newCrudData['creat_by'] = $Alarms->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Alarms', 'entite_cle' => $Alarms->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
