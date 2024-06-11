<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTravailleurExecUseCase
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

        $Travailleurs = \App\Models\Travailleur::find($data['id']);
        $oldTravailleurs = $Travailleurs->replicate();

        $oldCrudData = [];
        $oldCrudData['horaire_id'] = $oldTravailleurs->horaire_id;
        $oldCrudData['user_id'] = $oldTravailleurs->user_id;
        $oldCrudData['lun'] = $oldTravailleurs->lun;
        $oldCrudData['mar'] = $oldTravailleurs->mar;
        $oldCrudData['mer'] = $oldTravailleurs->mer;
        $oldCrudData['jeu'] = $oldTravailleurs->jeu;
        $oldCrudData['ven'] = $oldTravailleurs->ven;
        $oldCrudData['sam'] = $oldTravailleurs->sam;
        $oldCrudData['dim'] = $oldTravailleurs->dim;
        $oldCrudData['tache_id'] = $oldTravailleurs->tache_id;
        $oldCrudData['identifiants_sadge'] = $oldTravailleurs->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldTravailleurs->creat_by;
        try {
            $oldCrudData['horaire'] = $oldTravailleurs->horaire->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['tache'] = $oldTravailleurs->tache->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldTravailleurs->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['horaire_id'])) {
            $Travailleurs->horaire_id = $data['horaire_id'];
        }
        if (!empty($data['user_id'])) {
            $Travailleurs->user_id = $data['user_id'];
        }
        if (!empty($data['lun'])) {
            $Travailleurs->lun = $data['lun'];
        }
        if (!empty($data['mar'])) {
            $Travailleurs->mar = $data['mar'];
        }
        if (!empty($data['mer'])) {
            $Travailleurs->mer = $data['mer'];
        }
        if (!empty($data['jeu'])) {
            $Travailleurs->jeu = $data['jeu'];
        }
        if (!empty($data['ven'])) {
            $Travailleurs->ven = $data['ven'];
        }
        if (!empty($data['sam'])) {
            $Travailleurs->sam = $data['sam'];
        }
        if (!empty($data['dim'])) {
            $Travailleurs->dim = $data['dim'];
        }
        if (!empty($data['tache_id'])) {
            $Travailleurs->tache_id = $data['tache_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Travailleurs->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Travailleurs->creat_by = $data['creat_by'];
        }
        $Travailleurs->save();
        $Travailleurs = \App\Models\Travailleur::find($Travailleurs->id);
        $newCrudData = [];
        $newCrudData['horaire_id'] = $Travailleurs->horaire_id;
        $newCrudData['user_id'] = $Travailleurs->user_id;
        $newCrudData['lun'] = $Travailleurs->lun;
        $newCrudData['mar'] = $Travailleurs->mar;
        $newCrudData['mer'] = $Travailleurs->mer;
        $newCrudData['jeu'] = $Travailleurs->jeu;
        $newCrudData['ven'] = $Travailleurs->ven;
        $newCrudData['sam'] = $Travailleurs->sam;
        $newCrudData['dim'] = $Travailleurs->dim;
        $newCrudData['tache_id'] = $Travailleurs->tache_id;
        $newCrudData['identifiants_sadge'] = $Travailleurs->identifiants_sadge;
        $newCrudData['creat_by'] = $Travailleurs->creat_by;
        try {
            $newCrudData['horaire'] = $Travailleurs->horaire->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['tache'] = $Travailleurs->tache->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Travailleurs->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Travailleurs', 'entite_cle' => $Travailleurs->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Travailleurs->toArray();
        return $data;
    }

}
