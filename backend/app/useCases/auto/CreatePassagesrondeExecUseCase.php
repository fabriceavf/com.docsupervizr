<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePassagesrondeExecUseCase
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

        $Passagesrondes = new \App\Models\Passagesronde();

        if (!empty($data['heure_debut'])) {
            $Passagesrondes->heure_debut = $data['heure_debut'];
        }
        if (!empty($data['heure_fin'])) {
            $Passagesrondes->heure_fin = $data['heure_fin'];
        }
        if (!empty($data['lun'])) {
            $Passagesrondes->lun = $data['lun'];
        }
        if (!empty($data['mar'])) {
            $Passagesrondes->mar = $data['mar'];
        }
        if (!empty($data['mer'])) {
            $Passagesrondes->mer = $data['mer'];
        }
        if (!empty($data['jeu'])) {
            $Passagesrondes->jeu = $data['jeu'];
        }
        if (!empty($data['ven'])) {
            $Passagesrondes->ven = $data['ven'];
        }
        if (!empty($data['sam'])) {
            $Passagesrondes->sam = $data['sam'];
        }
        if (!empty($data['dim'])) {
            $Passagesrondes->dim = $data['dim'];
        }
        if (!empty($data['site_id'])) {
            $Passagesrondes->site_id = $data['site_id'];
        }
        if (!empty($data['creat_by'])) {
            $Passagesrondes->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Passagesrondes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['libelle'])) {
            $Passagesrondes->libelle = $data['libelle'];
        }
        $Passagesrondes->save();
        $Passagesrondes = \App\Models\Passagesronde::find($Passagesrondes->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Passagesrondes', 'entite_cle' => $Passagesrondes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Passagesrondes->toArray();
        return $data;
    }

}
