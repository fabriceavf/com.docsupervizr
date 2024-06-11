<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteGroupepermissionExecUseCase
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


        $Groupepermissions->deleted_at = now();
        $Groupepermissions->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Groupepermissions->libelle;
        $newCrudData['creat_by'] = $Groupepermissions->creat_by;
        $newCrudData['identifiants_sadge'] = $Groupepermissions->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Groupepermissions', 'entite_cle' => $Groupepermissions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
