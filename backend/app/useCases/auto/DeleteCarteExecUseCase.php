<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteCarteExecUseCase
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

        $Cartes = \App\Models\Carte::find($data['id']);


        $Cartes->deleted_at = now();
        $Cartes->save();
        $newCrudData = [];
        $newCrudData['code'] = $Cartes->code;
        $newCrudData['uid_mifare'] = $Cartes->uid_mifare;
        $newCrudData['solde'] = $Cartes->solde;
        $newCrudData['site_id'] = $Cartes->site_id;
        $newCrudData['etats'] = $Cartes->etats;
        $newCrudData['creat_by'] = $Cartes->creat_by;
        $newCrudData['identifiants_sadge'] = $Cartes->identifiants_sadge;
        try {
            $newCrudData['site'] = $Cartes->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Cartes', 'entite_cle' => $Cartes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
