<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePointageExecUseCase
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

        $Pointages = new \App\Models\Pointage();

        if (!empty($data['pointeuse'])) {
            $Pointages->pointeuse = $data['pointeuse'];
        }
        if (!empty($data['lieu'])) {
            $Pointages->lieu = $data['lieu'];
        }
        if (!empty($data['debut_prevu'])) {
            $Pointages->debut_prevu = $data['debut_prevu'];
        }
        if (!empty($data['fin_prevu'])) {
            $Pointages->fin_prevu = $data['fin_prevu'];
        }
        if (!empty($data['faction_horaire'])) {
            $Pointages->faction_horaire = $data['faction_horaire'];
        }
        if (!empty($data['debut_reel'])) {
            $Pointages->debut_reel = $data['debut_reel'];
        }
        if (!empty($data['debut_realise'])) {
            $Pointages->debut_realise = $data['debut_realise'];
        }
        if (!empty($data['fin_realise'])) {
            $Pointages->fin_realise = $data['fin_realise'];
        }
        if (!empty($data['volume_realise'])) {
            $Pointages->volume_realise = $data['volume_realise'];
        }
        if (!empty($data['emp_code'])) {
            $Pointages->emp_code = $data['emp_code'];
        }
        if (!empty($data['motif'])) {
            $Pointages->motif = $data['motif'];
        }
        if (!empty($data['volume_prevu'])) {
            $Pointages->volume_prevu = $data['volume_prevu'];
        }
        if (!empty($data['actif'])) {
            $Pointages->actif = $data['actif'];
        }
        if (!empty($data['est_valide'])) {
            $Pointages->est_valide = $data['est_valide'];
        }
        if (!empty($data['horaire_id'])) {
            $Pointages->horaire_id = $data['horaire_id'];
        }
        if (!empty($data['programme_id'])) {
            $Pointages->programme_id = $data['programme_id'];
        }
        if (!empty($data['tolerance'])) {
            $Pointages->tolerance = $data['tolerance'];
        }
        if (!empty($data['est_attendu'])) {
            $Pointages->est_attendu = $data['est_attendu'];
        }
        if (!empty($data['etats'])) {
            $Pointages->etats = $data['etats'];
        }
        if (!empty($data['user_id'])) {
            $Pointages->user_id = $data['user_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Pointages->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Pointages->creat_by = $data['creat_by'];
        }
        $Pointages->save();
        $Pointages = \App\Models\Pointage::find($Pointages->id);
        $newCrudData = [];
        $newCrudData['pointeuse'] = $Pointages->pointeuse;
        $newCrudData['lieu'] = $Pointages->lieu;
        $newCrudData['debut_prevu'] = $Pointages->debut_prevu;
        $newCrudData['fin_prevu'] = $Pointages->fin_prevu;
        $newCrudData['faction_horaire'] = $Pointages->faction_horaire;
        $newCrudData['debut_reel'] = $Pointages->debut_reel;
        $newCrudData['debut_realise'] = $Pointages->debut_realise;
        $newCrudData['fin_realise'] = $Pointages->fin_realise;
        $newCrudData['volume_realise'] = $Pointages->volume_realise;
        $newCrudData['emp_code'] = $Pointages->emp_code;
        $newCrudData['motif'] = $Pointages->motif;
        $newCrudData['volume_prevu'] = $Pointages->volume_prevu;
        $newCrudData['actif'] = $Pointages->actif;
        $newCrudData['est_valide'] = $Pointages->est_valide;
        $newCrudData['horaire_id'] = $Pointages->horaire_id;
        $newCrudData['programme_id'] = $Pointages->programme_id;
        $newCrudData['tolerance'] = $Pointages->tolerance;
        $newCrudData['est_attendu'] = $Pointages->est_attendu;
        $newCrudData['etats'] = $Pointages->etats;
        $newCrudData['user_id'] = $Pointages->user_id;
        $newCrudData['identifiants_sadge'] = $Pointages->identifiants_sadge;
        $newCrudData['creat_by'] = $Pointages->creat_by;
        try {
            $newCrudData['horaire'] = $Pointages->horaire->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['programme'] = $Pointages->programme->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Pointages->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Pointages', 'entite_cle' => $Pointages->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Pointages->toArray();
        return $data;
    }

}
