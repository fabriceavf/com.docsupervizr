<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateSoldableExecUseCase
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

        $Soldables = new \App\Models\Soldable();

        if (!empty($data['libelle'])) {
            $Soldables->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Soldables->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Soldables->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Soldables->creat_by = $data['creat_by'];
        }
        $Soldables->save();
        $Soldables = \App\Models\Soldable::find($Soldables->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Soldables->libelle;
        $newCrudData['code'] = $Soldables->code;
        $newCrudData['identifiants_sadge'] = $Soldables->identifiants_sadge;
        $newCrudData['creat_by'] = $Soldables->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Soldables', 'entite_cle' => $Soldables->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Soldables->toArray();
        return $data;
    }

}
