<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateActionsprevisionelleExecUseCase
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

        $Actionsprevisionelles = new \App\Models\Actionsprevisionelle();

        if (!empty($data['libelle'])) {
            $Actionsprevisionelles->libelle = $data['libelle'];
        }
        if (!empty($data['descriptions'])) {
            $Actionsprevisionelles->descriptions = $data['descriptions'];
        }
        if (!empty($data['debut_previsionnel'])) {
            $Actionsprevisionelles->debut_previsionnel = $data['debut_previsionnel'];
        }
        if (!empty($data['fin_previsionnel'])) {
            $Actionsprevisionelles->fin_previsionnel = $data['fin_previsionnel'];
        }
        if (!empty($data['debut_reel'])) {
            $Actionsprevisionelles->debut_reel = $data['debut_reel'];
        }
        if (!empty($data['fin_reel'])) {
            $Actionsprevisionelles->fin_reel = $data['fin_reel'];
        }
        if (!empty($data['besoin_id'])) {
            $Actionsprevisionelles->besoin_id = $data['besoin_id'];
        }
        if (!empty($data['creat_by'])) {
            $Actionsprevisionelles->creat_by = $data['creat_by'];
        }
        if (!empty($data['evaluation'])) {
            $Actionsprevisionelles->evaluation = $data['evaluation'];
        }
        if (!empty($data['valider'])) {
            $Actionsprevisionelles->valider = $data['valider'];
        }
        if (!empty($data['type'])) {
            $Actionsprevisionelles->type = $data['type'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Actionsprevisionelles->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Actionsprevisionelles->save();
        $Actionsprevisionelles = \App\Models\Actionsprevisionelle::find($Actionsprevisionelles->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Actionsprevisionelles', 'entite_cle' => $Actionsprevisionelles->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Actionsprevisionelles->toArray();
        return $data;
    }

}
