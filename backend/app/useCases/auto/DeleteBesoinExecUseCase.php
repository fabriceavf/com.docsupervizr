<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteBesoinExecUseCase
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

        $Besoins = \App\Models\Besoin::find($data['id']);


        $Besoins->deleted_at = now();
        $Besoins->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Besoins->libelle;
        $newCrudData['descriptions'] = $Besoins->descriptions;
        $newCrudData['debut_previsionnel'] = $Besoins->debut_previsionnel;
        $newCrudData['fin_previsionnel'] = $Besoins->fin_previsionnel;
        $newCrudData['debut_reel'] = $Besoins->debut_reel;
        $newCrudData['fin_reel'] = $Besoins->fin_reel;
        $newCrudData['projet_id'] = $Besoins->projet_id;
        $newCrudData['evaluation'] = $Besoins->evaluation;
        $newCrudData['creat_by'] = $Besoins->creat_by;
        $newCrudData['valider'] = $Besoins->valider;
        $newCrudData['Child'] = $Besoins->Child;
        $newCrudData['ChildPrevu'] = $Besoins->ChildPrevu;
        $newCrudData['ChildImprevu'] = $Besoins->ChildImprevu;
        $newCrudData['ChildReussi'] = $Besoins->ChildReussi;
        $newCrudData['ChildBloquer'] = $Besoins->ChildBloquer;
        $newCrudData['identifiants_sadge'] = $Besoins->identifiants_sadge;
        try {
            $newCrudData['projet'] = $Besoins->projet->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Besoins', 'entite_cle' => $Besoins->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
