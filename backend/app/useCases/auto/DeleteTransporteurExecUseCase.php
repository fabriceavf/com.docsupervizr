<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransporteurExecUseCase
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

        $Transporteurs = \App\Models\Transporteur::find($data['id']);


        $Transporteurs->deleted_at = now();
        $Transporteurs->save();
        $newCrudData = [];
        $newCrudData['code'] = $Transporteurs->code;
        $newCrudData['libelle'] = $Transporteurs->libelle;
        $newCrudData['creat_by'] = $Transporteurs->creat_by;
        $newCrudData['identifiants_sadge'] = $Transporteurs->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transporteurs', 'entite_cle' => $Transporteurs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
