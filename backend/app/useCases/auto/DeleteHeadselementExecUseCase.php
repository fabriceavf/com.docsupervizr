<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHeadselementExecUseCase
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

        $Headselements = \App\Models\Headselement::find($data['id']);


        $Headselements->deleted_at = now();
        $Headselements->save();
        $newCrudData = [];
        $newCrudData['cle'] = $Headselements->cle;
        $newCrudData['valeur'] = $Headselements->valeur;
        $newCrudData['entreprise_id'] = $Headselements->entreprise_id;
        $newCrudData['creat_by'] = $Headselements->creat_by;
        try {
            $newCrudData['entreprise'] = $Headselements->entreprise->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Headselements', 'entite_cle' => $Headselements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
