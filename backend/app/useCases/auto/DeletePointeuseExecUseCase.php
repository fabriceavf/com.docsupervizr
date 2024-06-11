<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePointeuseExecUseCase
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


        $Pointeuses->deleted_at = now();
        $Pointeuses->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Pointeuses', 'entite_cle' => $Pointeuses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
