<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateBesoinExecUseCase
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

        $Besoins = new \App\Models\Besoin();

        if (!empty($data['libelle'])) {
            $Besoins->libelle = $data['libelle'];
        }
        if (!empty($data['descriptions'])) {
            $Besoins->descriptions = $data['descriptions'];
        }
        if (!empty($data['debut_previsionnel'])) {
            $Besoins->debut_previsionnel = $data['debut_previsionnel'];
        }
        if (!empty($data['fin_previsionnel'])) {
            $Besoins->fin_previsionnel = $data['fin_previsionnel'];
        }
        if (!empty($data['debut_reel'])) {
            $Besoins->debut_reel = $data['debut_reel'];
        }
        if (!empty($data['fin_reel'])) {
            $Besoins->fin_reel = $data['fin_reel'];
        }
        if (!empty($data['projet_id'])) {
            $Besoins->projet_id = $data['projet_id'];
        }
        if (!empty($data['evaluation'])) {
            $Besoins->evaluation = $data['evaluation'];
        }
        if (!empty($data['creat_by'])) {
            $Besoins->creat_by = $data['creat_by'];
        }
        if (!empty($data['valider'])) {
            $Besoins->valider = $data['valider'];
        }
        if (!empty($data['Child'])) {
            $Besoins->Child = $data['Child'];
        }
        if (!empty($data['ChildPrevu'])) {
            $Besoins->ChildPrevu = $data['ChildPrevu'];
        }
        if (!empty($data['ChildImprevu'])) {
            $Besoins->ChildImprevu = $data['ChildImprevu'];
        }
        if (!empty($data['ChildReussi'])) {
            $Besoins->ChildReussi = $data['ChildReussi'];
        }
        if (!empty($data['ChildBloquer'])) {
            $Besoins->ChildBloquer = $data['ChildBloquer'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Besoins->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Besoins->save();
        $Besoins = \App\Models\Besoin::find($Besoins->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Besoins', 'entite_cle' => $Besoins->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Besoins->toArray();
        return $data;
    }

}
