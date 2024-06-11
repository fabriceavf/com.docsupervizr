<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePrestationExecUseCase
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

        $Prestations = \App\Models\Prestation::find($data['id']);


        $Prestations->deleted_at = now();
        $Prestations->save();
        $newCrudData = [];
        $newCrudData['code'] = $Prestations->code;
        $newCrudData['libelle'] = $Prestations->libelle;
        $newCrudData['description'] = $Prestations->description;
        $newCrudData['identifiants_sadge'] = $Prestations->identifiants_sadge;
        $newCrudData['creat_by'] = $Prestations->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Prestations', 'entite_cle' => $Prestations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
