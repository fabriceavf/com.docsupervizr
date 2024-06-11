<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteMaterielprevisionnelExecUseCase
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

        $Materielprevisionnels = \App\Models\Materielprevisionnel::find($data['id']);


        $Materielprevisionnels->deleted_at = now();
        $Materielprevisionnels->save();
        $newCrudData = [];
        $newCrudData['materiel_id'] = $Materielprevisionnels->materiel_id;
        $newCrudData['chantier_id'] = $Materielprevisionnels->chantier_id;
        $newCrudData['quantite'] = $Materielprevisionnels->quantite;
        $newCrudData['identifiants_sadge'] = $Materielprevisionnels->identifiants_sadge;
        $newCrudData['creat_by'] = $Materielprevisionnels->creat_by;
        try {
            $newCrudData['chantier'] = $Materielprevisionnels->chantier->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['materiel'] = $Materielprevisionnels->materiel->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Materielprevisionnels', 'entite_cle' => $Materielprevisionnels->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
