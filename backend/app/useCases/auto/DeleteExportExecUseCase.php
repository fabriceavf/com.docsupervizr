<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteExportExecUseCase
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


        $Exports->deleted_at = now();
        $Exports->save();
        $newCrudData = [];
        $newCrudData['code'] = $Exports->code;
        $newCrudData['libelle'] = $Exports->libelle;
        $newCrudData['lien'] = $Exports->lien;
        $newCrudData['creat_by'] = $Exports->creat_by;
        $newCrudData['identifiants_sadge'] = $Exports->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Exports', 'entite_cle' => $Exports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
