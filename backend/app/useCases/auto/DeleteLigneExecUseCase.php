<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteLigneExecUseCase
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

        $Lignes = \App\Models\Ligne::find($data['id']);


        $Lignes->deleted_at = now();
        $Lignes->save();
        $newCrudData = [];
        $newCrudData['ville_id'] = $Lignes->ville_id;
        $newCrudData['code'] = $Lignes->code;
        $newCrudData['libelle'] = $Lignes->libelle;
        $newCrudData['tarifs'] = $Lignes->tarifs;
        $newCrudData['creat_by'] = $Lignes->creat_by;
        $newCrudData['identifiants_sadge'] = $Lignes->identifiants_sadge;
        try {
            $newCrudData['ville'] = $Lignes->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Lignes', 'entite_cle' => $Lignes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
