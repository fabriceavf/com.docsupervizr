<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateZoneExecUseCase
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

        $Zones = new \App\Models\Zone();

        if (!empty($data['code'])) {
            $Zones->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Zones->libelle = $data['libelle'];
        }
        if (!empty($data['province_id'])) {
            $Zones->province_id = $data['province_id'];
        }
        if (!empty($data['total_titulaires_therorique'])) {
            $Zones->total_titulaires_therorique = $data['total_titulaires_therorique'];
        }
        if (!empty($data['total_titulaires_reel_jour'])) {
            $Zones->total_titulaires_reel_jour = $data['total_titulaires_reel_jour'];
        }
        if (!empty($data['total_titulaires_reel_nuit'])) {
            $Zones->total_titulaires_reel_nuit = $data['total_titulaires_reel_nuit'];
        }
        if (!empty($data['total_present_jour'])) {
            $Zones->total_present_jour = $data['total_present_jour'];
        }
        if (!empty($data['total_present_nuit'])) {
            $Zones->total_present_nuit = $data['total_present_nuit'];
        }
        if (!empty($data['ordre'])) {
            $Zones->ordre = $data['ordre'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Zones->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Zones->creat_by = $data['creat_by'];
        }
        if (!empty($data['ville_id'])) {
            $Zones->ville_id = $data['ville_id'];
        }
        $Zones->save();
        $Zones = \App\Models\Zone::find($Zones->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Zones', 'entite_cle' => $Zones->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Zones->toArray();
        return $data;
    }

}
