<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteMaterielExecUseCase
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

        $Materiels = \App\Models\Materiel::find($data['id']);


        $Materiels->deleted_at = now();
        $Materiels->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Materiels->libelle;
        $newCrudData['reference'] = $Materiels->reference;
        $newCrudData['description'] = $Materiels->description;
        $newCrudData['quantite'] = $Materiels->quantite;
        $newCrudData['identifiants_sadge'] = $Materiels->identifiants_sadge;
        $newCrudData['creat_by'] = $Materiels->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Materiels', 'entite_cle' => $Materiels->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
