<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteListesappelExecUseCase
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

        $Listesappels = \App\Models\Listesappel::find($data['id']);


        $Listesappels->deleted_at = now();
        $Listesappels->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Listesappels->libelle;
        $newCrudData['debut'] = $Listesappels->debut;
        $newCrudData['fin'] = $Listesappels->fin;
        $newCrudData['etats'] = $Listesappels->etats;
        $newCrudData['identifiants_sadge'] = $Listesappels->identifiants_sadge;
        $newCrudData['creat_by'] = $Listesappels->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Listesappels', 'entite_cle' => $Listesappels->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
