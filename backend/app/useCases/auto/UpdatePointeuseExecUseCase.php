<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePointeuseExecUseCase
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

        $Pointeuses = \App\Models\Pointeuse::find($data['id']);
        $oldPointeuses = $Pointeuses->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldPointeuses->code;
        $oldCrudData['libelle'] = $oldPointeuses->libelle;
        $oldCrudData['nom_local'] = $oldPointeuses->nom_local;
        $oldCrudData['supervirzclient_id'] = $oldPointeuses->supervirzclient_id;
        $oldCrudData['code_teleric'] = $oldPointeuses->code_teleric;
        $oldCrudData['postes'] = $oldPointeuses->postes;
        $oldCrudData['Taches'] = $oldPointeuses->Taches;
        $oldCrudData['lun'] = $oldPointeuses->lun;
        $oldCrudData['mar'] = $oldPointeuses->mar;
        $oldCrudData['mer'] = $oldPointeuses->mer;
        $oldCrudData['jeu'] = $oldPointeuses->jeu;
        $oldCrudData['ven'] = $oldPointeuses->ven;
        $oldCrudData['sam'] = $oldPointeuses->sam;
        $oldCrudData['dim'] = $oldPointeuses->dim;
        $oldCrudData['site_id'] = $oldPointeuses->site_id;
        $oldCrudData['identifiants_sadge'] = $oldPointeuses->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldPointeuses->creat_by;
        try {
            $oldCrudData['site'] = $oldPointeuses->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['supervirzclient'] = $oldPointeuses->supervirzclient->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['code'])) {
            $Pointeuses->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Pointeuses->libelle = $data['libelle'];
        }
        if (!empty($data['nom_local'])) {
            $Pointeuses->nom_local = $data['nom_local'];
        }
        if (!empty($data['supervirzclient_id'])) {
            $Pointeuses->supervirzclient_id = $data['supervirzclient_id'];
        }
        if (!empty($data['code_teleric'])) {
            $Pointeuses->code_teleric = $data['code_teleric'];
        }
        if (!empty($data['postes'])) {
            $Pointeuses->postes = $data['postes'];
        }
        if (!empty($data['Taches'])) {
            $Pointeuses->Taches = $data['Taches'];
        }
        if (!empty($data['lun'])) {
            $Pointeuses->lun = $data['lun'];
        }
        if (!empty($data['mar'])) {
            $Pointeuses->mar = $data['mar'];
        }
        if (!empty($data['mer'])) {
            $Pointeuses->mer = $data['mer'];
        }
        if (!empty($data['jeu'])) {
            $Pointeuses->jeu = $data['jeu'];
        }
        if (!empty($data['ven'])) {
            $Pointeuses->ven = $data['ven'];
        }
        if (!empty($data['sam'])) {
            $Pointeuses->sam = $data['sam'];
        }
        if (!empty($data['dim'])) {
            $Pointeuses->dim = $data['dim'];
        }
        if (!empty($data['site_id'])) {
            $Pointeuses->site_id = $data['site_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Pointeuses->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Pointeuses->creat_by = $data['creat_by'];
        }
        $Pointeuses->save();
        $Pointeuses = \App\Models\Pointeuse::find($Pointeuses->id);
        $newCrudData = [];
        $newCrudData['code'] = $Pointeuses->code;
        $newCrudData['libelle'] = $Pointeuses->libelle;
        $newCrudData['nom_local'] = $Pointeuses->nom_local;
        $newCrudData['supervirzclient_id'] = $Pointeuses->supervirzclient_id;
        $newCrudData['code_teleric'] = $Pointeuses->code_teleric;
        $newCrudData['postes'] = $Pointeuses->postes;
        $newCrudData['Taches'] = $Pointeuses->Taches;
        $newCrudData['lun'] = $Pointeuses->lun;
        $newCrudData['mar'] = $Pointeuses->mar;
        $newCrudData['mer'] = $Pointeuses->mer;
        $newCrudData['jeu'] = $Pointeuses->jeu;
        $newCrudData['ven'] = $Pointeuses->ven;
        $newCrudData['sam'] = $Pointeuses->sam;
        $newCrudData['dim'] = $Pointeuses->dim;
        $newCrudData['site_id'] = $Pointeuses->site_id;
        $newCrudData['identifiants_sadge'] = $Pointeuses->identifiants_sadge;
        $newCrudData['creat_by'] = $Pointeuses->creat_by;
        try {
            $newCrudData['site'] = $Pointeuses->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['supervirzclient'] = $Pointeuses->supervirzclient->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Pointeuses', 'entite_cle' => $Pointeuses->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Pointeuses->toArray();
        return $data;
    }

}
