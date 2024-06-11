<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteActifExecUseCase
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

        $Actifs = \App\Models\Actif::find($data['id']);


        $Actifs->deleted_at = now();
        $Actifs->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Actifs->libelle;
        $newCrudData['code'] = $Actifs->code;
        $newCrudData['identifiants_sadge'] = $Actifs->identifiants_sadge;
        $newCrudData['creat_by'] = $Actifs->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Actifs', 'entite_cle' => $Actifs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
