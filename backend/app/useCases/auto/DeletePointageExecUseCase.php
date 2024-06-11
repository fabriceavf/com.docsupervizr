<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePointageExecUseCase
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

        $Pointages = \App\Models\Pointage::find($data['id']);


        $Pointages->deleted_at = now();
        $Pointages->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Pointages', 'entite_cle' => $Pointages->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
