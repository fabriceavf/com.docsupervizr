<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHistoriqueExecUseCase
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

        $Historiques = \App\Models\Historique::find($data['id']);


        $Historiques->deleted_at = now();
        $Historiques->save();
        $newCrudData = [];
        $newCrudData['type'] = $Historiques->type;
        $newCrudData['cle'] = $Historiques->cle;
        $newCrudData['valeur'] = $Historiques->valeur;
        $newCrudData['identifiants_sadge'] = $Historiques->identifiants_sadge;
        $newCrudData['creat_by'] = $Historiques->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Historiques', 'entite_cle' => $Historiques->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
