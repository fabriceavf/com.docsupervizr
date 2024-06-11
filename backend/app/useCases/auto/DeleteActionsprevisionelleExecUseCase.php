<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteActionsprevisionelleExecUseCase
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

        $Actionsprevisionelles = \App\Models\Actionsprevisionelle::find($data['id']);


        $Actionsprevisionelles->deleted_at = now();
        $Actionsprevisionelles->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Actionsprevisionelles->libelle;
        $newCrudData['descriptions'] = $Actionsprevisionelles->descriptions;
        $newCrudData['debut_previsionnel'] = $Actionsprevisionelles->debut_previsionnel;
        $newCrudData['fin_previsionnel'] = $Actionsprevisionelles->fin_previsionnel;
        $newCrudData['debut_reel'] = $Actionsprevisionelles->debut_reel;
        $newCrudData['fin_reel'] = $Actionsprevisionelles->fin_reel;
        $newCrudData['besoin_id'] = $Actionsprevisionelles->besoin_id;
        $newCrudData['creat_by'] = $Actionsprevisionelles->creat_by;
        $newCrudData['evaluation'] = $Actionsprevisionelles->evaluation;
        $newCrudData['valider'] = $Actionsprevisionelles->valider;
        $newCrudData['type'] = $Actionsprevisionelles->type;
        $newCrudData['identifiants_sadge'] = $Actionsprevisionelles->identifiants_sadge;
        try {
            $newCrudData['besoin'] = $Actionsprevisionelles->besoin->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Actionsprevisionelles', 'entite_cle' => $Actionsprevisionelles->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
