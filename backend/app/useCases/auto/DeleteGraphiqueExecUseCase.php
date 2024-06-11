<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteGraphiqueExecUseCase
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

        $Graphiques = \App\Models\Graphique::find($data['id']);


        $Graphiques->deleted_at = now();
        $Graphiques->save();
        $newCrudData = [];
        $newCrudData['code'] = $Graphiques->code;
        $newCrudData['libelle'] = $Graphiques->libelle;
        $newCrudData['creat_by'] = $Graphiques->creat_by;
        $newCrudData['identifiants_sadge'] = $Graphiques->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Graphiques', 'entite_cle' => $Graphiques->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
