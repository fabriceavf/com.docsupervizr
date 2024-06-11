<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteMatrimonialeExecUseCase
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

        $Matrimoniales = \App\Models\Matrimoniale::find($data['id']);


        $Matrimoniales->deleted_at = now();
        $Matrimoniales->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Matrimoniales->libelle;
        $newCrudData['code'] = $Matrimoniales->code;
        $newCrudData['identifiants_sadge'] = $Matrimoniales->identifiants_sadge;
        $newCrudData['creat_by'] = $Matrimoniales->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Matrimoniales', 'entite_cle' => $Matrimoniales->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
