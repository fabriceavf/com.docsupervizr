<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteMesurespreventiveExecUseCase
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

        $Mesurespreventives = \App\Models\Mesurespreventive::find($data['id']);


        $Mesurespreventives->deleted_at = now();
        $Mesurespreventives->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Mesurespreventives->libelle;
        $newCrudData['identifiants_sadge'] = $Mesurespreventives->identifiants_sadge;
        $newCrudData['creat_by'] = $Mesurespreventives->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Mesurespreventives', 'entite_cle' => $Mesurespreventives->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
