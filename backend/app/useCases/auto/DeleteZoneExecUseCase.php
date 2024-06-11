<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteZoneExecUseCase
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

        $Zones = \App\Models\Zone::find($data['id']);


        $Zones->deleted_at = now();
        $Zones->save();
        $newCrudData = [];
        $newCrudData['code'] = $Zones->code;
        $newCrudData['libelle'] = $Zones->libelle;
        $newCrudData['province_id'] = $Zones->province_id;
        $newCrudData['total_titulaires_therorique'] = $Zones->total_titulaires_therorique;
        $newCrudData['total_titulaires_reel_jour'] = $Zones->total_titulaires_reel_jour;
        $newCrudData['total_titulaires_reel_nuit'] = $Zones->total_titulaires_reel_nuit;
        $newCrudData['total_present_jour'] = $Zones->total_present_jour;
        $newCrudData['total_present_nuit'] = $Zones->total_present_nuit;
        $newCrudData['ordre'] = $Zones->ordre;
        $newCrudData['identifiants_sadge'] = $Zones->identifiants_sadge;
        $newCrudData['creat_by'] = $Zones->creat_by;
        $newCrudData['ville_id'] = $Zones->ville_id;
        try {
            $newCrudData['province'] = $Zones->province->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['ville'] = $Zones->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Zones', 'entite_cle' => $Zones->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
