<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateGroupepermissionExecUseCase
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

        $Groupepermissions = \App\Models\Groupepermission::find($data['id']);
        $oldGroupepermissions = $Groupepermissions->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldGroupepermissions->libelle;
        $oldCrudData['creat_by'] = $oldGroupepermissions->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldGroupepermissions->identifiants_sadge;


        if (!empty($data['libelle'])) {
            $Groupepermissions->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Groupepermissions->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Groupepermissions->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Groupepermissions->save();
        $Groupepermissions = \App\Models\Groupepermission::find($Groupepermissions->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Groupepermissions->libelle;
        $newCrudData['creat_by'] = $Groupepermissions->creat_by;
        $newCrudData['identifiants_sadge'] = $Groupepermissions->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Groupepermissions', 'entite_cle' => $Groupepermissions->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Groupepermissions->toArray();
        return $data;
    }

}
