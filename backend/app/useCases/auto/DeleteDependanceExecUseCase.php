<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteDependanceExecUseCase
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

        $Dependances = \App\Models\Dependance::find($data['id']);


        $Dependances->deleted_at = now();
        $Dependances->save();
        $newCrudData = [];
        $newCrudData['badge_id'] = $Dependances->badge_id;
        $newCrudData['libelle'] = $Dependances->libelle;
        $newCrudData['version'] = $Dependances->version;
        $newCrudData['identifiants_sadge'] = $Dependances->identifiants_sadge;
        $newCrudData['creat_by'] = $Dependances->creat_by;
        try {
            $newCrudData['badge'] = $Dependances->badge->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Dependances', 'entite_cle' => $Dependances->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
