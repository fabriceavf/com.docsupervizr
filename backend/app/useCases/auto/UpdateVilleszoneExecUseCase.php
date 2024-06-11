<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateVilleszoneExecUseCase
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

        $Villeszones = \App\Models\Villeszone::find($data['id']);
        $oldVilleszones = $Villeszones->replicate();

        $oldCrudData = [];
        $oldCrudData['ville_id'] = $oldVilleszones->ville_id;
        $oldCrudData['zone_id'] = $oldVilleszones->zone_id;
        $oldCrudData['creat_by'] = $oldVilleszones->creat_by;
        try {
            $oldCrudData['ville'] = $oldVilleszones->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['zone'] = $oldVilleszones->zone->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['ville_id'])) {
            $Villeszones->ville_id = $data['ville_id'];
        }
        if (!empty($data['zone_id'])) {
            $Villeszones->zone_id = $data['zone_id'];
        }
        if (!empty($data['creat_by'])) {
            $Villeszones->creat_by = $data['creat_by'];
        }
        $Villeszones->save();
        $Villeszones = \App\Models\Villeszone::find($Villeszones->id);
        $newCrudData = [];
        $newCrudData['ville_id'] = $Villeszones->ville_id;
        $newCrudData['zone_id'] = $Villeszones->zone_id;
        $newCrudData['creat_by'] = $Villeszones->creat_by;
        try {
            $newCrudData['ville'] = $Villeszones->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Villeszones->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Villeszones', 'entite_cle' => $Villeszones->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Villeszones->toArray();
        return $data;
    }

}
