<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateVilleExecUseCase
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

        $Villes = new \App\Models\Ville();

        if (!empty($data['libelle'])) {
            $Villes->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Villes->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Villes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Villes->creat_by = $data['creat_by'];
        }
        $Villes->save();
        $Villes = \App\Models\Ville::find($Villes->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Villes->libelle;
        $newCrudData['code'] = $Villes->code;
        $newCrudData['identifiants_sadge'] = $Villes->identifiants_sadge;
        $newCrudData['creat_by'] = $Villes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Villes', 'entite_cle' => $Villes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Villes->toArray();
        return $data;
    }

}
