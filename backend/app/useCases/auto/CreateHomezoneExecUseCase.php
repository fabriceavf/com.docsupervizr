<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateHomezoneExecUseCase
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

        $Homezones = new \App\Models\Homezone();

        if (!empty($data['libelle'])) {
            $Homezones->libelle = $data['libelle'];
        }
        if (!empty($data['type'])) {
            $Homezones->type = $data['type'];
        }
        if (!empty($data['zone_id'])) {
            $Homezones->zone_id = $data['zone_id'];
        }
        if (!empty($data['modelslisting_id'])) {
            $Homezones->modelslisting_id = $data['modelslisting_id'];
        }
        if (!empty($data['creat_by'])) {
            $Homezones->creat_by = $data['creat_by'];
        }
        if (!empty($data['modelslisting'])) {
            $Homezones->modelslisting = $data['modelslisting'];
        }
        if (!empty($data['effectifsjour'])) {
            $Homezones->effectifsjour = $data['effectifsjour'];
        }
        if (!empty($data['presentsjour'])) {
            $Homezones->presentsjour = $data['presentsjour'];
        }
        if (!empty($data['effectifsnuit'])) {
            $Homezones->effectifsnuit = $data['effectifsnuit'];
        }
        if (!empty($data['presentsnuit'])) {
            $Homezones->presentsnuit = $data['presentsnuit'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Homezones->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Homezones->save();
        $Homezones = \App\Models\Homezone::find($Homezones->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Homezones->libelle;
        $newCrudData['type'] = $Homezones->type;
        $newCrudData['zone_id'] = $Homezones->zone_id;
        $newCrudData['modelslisting_id'] = $Homezones->modelslisting_id;
        $newCrudData['creat_by'] = $Homezones->creat_by;
        $newCrudData['modelslisting'] = $Homezones->modelslisting;
        $newCrudData['effectifsjour'] = $Homezones->effectifsjour;
        $newCrudData['presentsjour'] = $Homezones->presentsjour;
        $newCrudData['effectifsnuit'] = $Homezones->effectifsnuit;
        $newCrudData['presentsnuit'] = $Homezones->presentsnuit;
        $newCrudData['identifiants_sadge'] = $Homezones->identifiants_sadge;
        try {
            $newCrudData['modelslisting'] = $Homezones->modelslisting->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Homezones->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Homezones', 'entite_cle' => $Homezones->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Homezones->toArray();
        return $data;
    }

}
