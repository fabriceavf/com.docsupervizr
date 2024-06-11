<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHomezoneExecUseCase
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

        $Homezones = \App\Models\Homezone::find($data['id']);


        $Homezones->deleted_at = now();
        $Homezones->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Homezones', 'entite_cle' => $Homezones->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
