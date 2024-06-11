<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateMaterielExecUseCase
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
        $oldMateriels = $Materiels->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldMateriels->libelle;
        $oldCrudData['reference'] = $oldMateriels->reference;
        $oldCrudData['description'] = $oldMateriels->description;
        $oldCrudData['quantite'] = $oldMateriels->quantite;
        $oldCrudData['identifiants_sadge'] = $oldMateriels->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldMateriels->creat_by;


        if (!empty($data['libelle'])) {
            $Materiels->libelle = $data['libelle'];
        }
        if (!empty($data['reference'])) {
            $Materiels->reference = $data['reference'];
        }
        if (!empty($data['description'])) {
            $Materiels->description = $data['description'];
        }
        if (!empty($data['quantite'])) {
            $Materiels->quantite = $data['quantite'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Materiels->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Materiels->creat_by = $data['creat_by'];
        }
        $Materiels->save();
        $Materiels = \App\Models\Materiel::find($Materiels->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Materiels->libelle;
        $newCrudData['reference'] = $Materiels->reference;
        $newCrudData['description'] = $Materiels->description;
        $newCrudData['quantite'] = $Materiels->quantite;
        $newCrudData['identifiants_sadge'] = $Materiels->identifiants_sadge;
        $newCrudData['creat_by'] = $Materiels->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Materiels', 'entite_cle' => $Materiels->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Materiels->toArray();
        return $data;
    }

}
