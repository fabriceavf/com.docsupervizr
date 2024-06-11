<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePassagesrondeExecUseCase
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

        $Passagesrondes = \App\Models\Passagesronde::find($data['id']);


        $Passagesrondes->deleted_at = now();
        $Passagesrondes->save();
        $newCrudData = [];
        $newCrudData['heure_debut'] = $Passagesrondes->heure_debut;
        $newCrudData['heure_fin'] = $Passagesrondes->heure_fin;
        $newCrudData['lun'] = $Passagesrondes->lun;
        $newCrudData['mar'] = $Passagesrondes->mar;
        $newCrudData['mer'] = $Passagesrondes->mer;
        $newCrudData['jeu'] = $Passagesrondes->jeu;
        $newCrudData['ven'] = $Passagesrondes->ven;
        $newCrudData['sam'] = $Passagesrondes->sam;
        $newCrudData['dim'] = $Passagesrondes->dim;
        $newCrudData['site_id'] = $Passagesrondes->site_id;
        $newCrudData['creat_by'] = $Passagesrondes->creat_by;
        $newCrudData['identifiants_sadge'] = $Passagesrondes->identifiants_sadge;
        $newCrudData['libelle'] = $Passagesrondes->libelle;
        try {
            $newCrudData['site'] = $Passagesrondes->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Passagesrondes', 'entite_cle' => $Passagesrondes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
