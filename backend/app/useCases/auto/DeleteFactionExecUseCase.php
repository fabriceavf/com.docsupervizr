<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteFactionExecUseCase
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

        $Factions = \App\Models\Faction::find($data['id']);


        $Factions->deleted_at = now();
        $Factions->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Factions->libelle;
        $newCrudData['code'] = $Factions->code;
        $newCrudData['identifiants_sadge'] = $Factions->identifiants_sadge;
        $newCrudData['creat_by'] = $Factions->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Factions', 'entite_cle' => $Factions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
