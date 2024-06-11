<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTerminalExecUseCase
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

        $Terminals = \App\Models\Terminal::find($data['id']);


        $Terminals->deleted_at = now();
        $Terminals->save();
        $newCrudData = [];
        $newCrudData['code'] = $Terminals->code;
        $newCrudData['adresse_mac'] = $Terminals->adresse_mac;
        $newCrudData['etat'] = $Terminals->etat;
        $newCrudData['alimentation'] = $Terminals->alimentation;
        $newCrudData['reseau'] = $Terminals->reseau;
        $newCrudData['voiture_id'] = $Terminals->voiture_id;
        $newCrudData['creat_by'] = $Terminals->creat_by;
        $newCrudData['identifiants_sadge'] = $Terminals->identifiants_sadge;
        try {
            $newCrudData['voiture'] = $Terminals->voiture->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Terminals', 'entite_cle' => $Terminals->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
