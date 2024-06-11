<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteFonctionExecUseCase
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

        $Fonctions = \App\Models\Fonction::find($data['id']);


        $Fonctions->deleted_at = now();
        $Fonctions->save();
        $newCrudData = [];
        $newCrudData['code'] = $Fonctions->code;
        $newCrudData['libelle'] = $Fonctions->libelle;
        $newCrudData['service_id'] = $Fonctions->service_id;
        $newCrudData['identifiants_sadge'] = $Fonctions->identifiants_sadge;
        $newCrudData['creat_by'] = $Fonctions->creat_by;
        try {
            $newCrudData['service'] = $Fonctions->service->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Fonctions', 'entite_cle' => $Fonctions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
