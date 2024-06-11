<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateFactionExecUseCase
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

        $Factions = new \App\Models\Faction();

        if (!empty($data['libelle'])) {
            $Factions->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Factions->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Factions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Factions->creat_by = $data['creat_by'];
        }
        $Factions->save();
        $Factions = \App\Models\Faction::find($Factions->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Factions->libelle;
        $newCrudData['code'] = $Factions->code;
        $newCrudData['identifiants_sadge'] = $Factions->identifiants_sadge;
        $newCrudData['creat_by'] = $Factions->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Factions', 'entite_cle' => $Factions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Factions->toArray();
        return $data;
    }

}
