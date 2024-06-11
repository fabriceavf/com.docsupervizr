<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateExportExecUseCase
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

        $Exports = \App\Models\Export::find($data['id']);
        $oldExports = $Exports->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldExports->code;
        $oldCrudData['libelle'] = $oldExports->libelle;
        $oldCrudData['lien'] = $oldExports->lien;
        $oldCrudData['creat_by'] = $oldExports->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldExports->identifiants_sadge;


        if (!empty($data['code'])) {
            $Exports->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Exports->libelle = $data['libelle'];
        }
        if (!empty($data['lien'])) {
            $Exports->lien = $data['lien'];
        }
        if (!empty($data['creat_by'])) {
            $Exports->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Exports->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Exports->save();
        $Exports = \App\Models\Export::find($Exports->id);
        $newCrudData = [];
        $newCrudData['code'] = $Exports->code;
        $newCrudData['libelle'] = $Exports->libelle;
        $newCrudData['lien'] = $Exports->lien;
        $newCrudData['creat_by'] = $Exports->creat_by;
        $newCrudData['identifiants_sadge'] = $Exports->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Exports', 'entite_cle' => $Exports->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Exports->toArray();
        return $data;
    }

}
