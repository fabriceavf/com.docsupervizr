<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateAlarmExecUseCase
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

        $Alarms = new \App\Models\Alarm();

        if (!empty($data['libelle'])) {
            $Alarms->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Alarms->description = $data['description'];
        }
        if (!empty($data['type'])) {
            $Alarms->type = $data['type'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Alarms->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Alarms->creat_by = $data['creat_by'];
        }
        $Alarms->save();
        $Alarms = \App\Models\Alarm::find($Alarms->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Alarms->libelle;
        $newCrudData['description'] = $Alarms->description;
        $newCrudData['type'] = $Alarms->type;
        $newCrudData['identifiants_sadge'] = $Alarms->identifiants_sadge;
        $newCrudData['creat_by'] = $Alarms->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Alarms', 'entite_cle' => $Alarms->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Alarms->toArray();
        return $data;
    }

}
