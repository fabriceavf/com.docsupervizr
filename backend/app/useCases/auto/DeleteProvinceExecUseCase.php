<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteProvinceExecUseCase
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

        $Provinces = \App\Models\Province::find($data['id']);


        $Provinces->deleted_at = now();
        $Provinces->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Provinces->libelle;
        $newCrudData['code'] = $Provinces->code;
        $newCrudData['identifiants_sadge'] = $Provinces->identifiants_sadge;
        $newCrudData['creat_by'] = $Provinces->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Provinces', 'entite_cle' => $Provinces->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
