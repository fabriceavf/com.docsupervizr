<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteContratsclientExecUseCase
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

        $Contratsclients = \App\Models\Contratsclient::find($data['id']);


        $Contratsclients->deleted_at = now();
        $Contratsclients->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Contratsclients->libelle;
        $newCrudData['description'] = $Contratsclients->description;
        $newCrudData['client_id'] = $Contratsclients->client_id;
        $newCrudData['AllSites'] = $Contratsclients->AllSites;
        $newCrudData['identifiants_sadge'] = $Contratsclients->identifiants_sadge;
        $newCrudData['creat_by'] = $Contratsclients->creat_by;
        try {
            $newCrudData['client'] = $Contratsclients->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Contratsclients', 'entite_cle' => $Contratsclients->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
