<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTravailleurExecUseCase
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


        $Travailleurs->deleted_at = now();
        $Travailleurs->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Travailleurs', 'entite_cle' => $Travailleurs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
