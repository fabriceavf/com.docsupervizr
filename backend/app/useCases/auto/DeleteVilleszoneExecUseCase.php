<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteVilleszoneExecUseCase
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


        $Villeszones->deleted_at = now();
        $Villeszones->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Villeszones', 'entite_cle' => $Villeszones->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
