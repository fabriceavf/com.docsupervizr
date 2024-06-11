<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProjetExecUseCase
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

        $Projets = new \App\Models\Projet();

        if (!empty($data['libelle'])) {
            $Projets->libelle = $data['libelle'];
        }
        if (!empty($data['descriptions'])) {
            $Projets->descriptions = $data['descriptions'];
        }
        if (!empty($data['debut_previsionnel'])) {
            $Projets->debut_previsionnel = $data['debut_previsionnel'];
        }
        if (!empty($data['fin_previsionnel'])) {
            $Projets->fin_previsionnel = $data['fin_previsionnel'];
        }
        if (!empty($data['debut_reel'])) {
            $Projets->debut_reel = $data['debut_reel'];
        }
        if (!empty($data['fin_reel'])) {
            $Projets->fin_reel = $data['fin_reel'];
        }
        if (!empty($data['creat_by'])) {
            $Projets->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Projets->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Projets->save();
        $Projets = \App\Models\Projet::find($Projets->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Projets->libelle;
        $newCrudData['descriptions'] = $Projets->descriptions;
        $newCrudData['debut_previsionnel'] = $Projets->debut_previsionnel;
        $newCrudData['fin_previsionnel'] = $Projets->fin_previsionnel;
        $newCrudData['debut_reel'] = $Projets->debut_reel;
        $newCrudData['fin_reel'] = $Projets->fin_reel;
        $newCrudData['creat_by'] = $Projets->creat_by;
        $newCrudData['identifiants_sadge'] = $Projets->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Projets', 'entite_cle' => $Projets->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Projets->toArray();
        return $data;
    }

}
