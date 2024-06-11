<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteVilleExecUseCase
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

        $Villes = \App\Models\Ville::find($data['id']);


        $Villes->deleted_at = now();
        $Villes->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Villes->libelle;
        $newCrudData['code'] = $Villes->code;
        $newCrudData['identifiants_sadge'] = $Villes->identifiants_sadge;
        $newCrudData['creat_by'] = $Villes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Villes', 'entite_cle' => $Villes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
