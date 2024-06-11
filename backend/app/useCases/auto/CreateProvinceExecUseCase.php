<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProvinceExecUseCase
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

        $Provinces = new \App\Models\Province();

        if (!empty($data['libelle'])) {
            $Provinces->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Provinces->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Provinces->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Provinces->creat_by = $data['creat_by'];
        }
        $Provinces->save();
        $Provinces = \App\Models\Province::find($Provinces->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Provinces->libelle;
        $newCrudData['code'] = $Provinces->code;
        $newCrudData['identifiants_sadge'] = $Provinces->identifiants_sadge;
        $newCrudData['creat_by'] = $Provinces->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Provinces', 'entite_cle' => $Provinces->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Provinces->toArray();
        return $data;
    }

}
