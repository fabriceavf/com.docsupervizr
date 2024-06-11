<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTrajetExecUseCase
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

        $Trajets = \App\Models\Trajet::find($data['id']);


        $Trajets->deleted_at = now();
        $Trajets->save();
        $newCrudData = [];
        $newCrudData['ligne_id'] = $Trajets->ligne_id;
        $newCrudData['distance'] = $Trajets->distance;
        $newCrudData['creat_by'] = $Trajets->creat_by;
        $newCrudData['identifiants_sadge'] = $Trajets->identifiants_sadge;
        $newCrudData['site_id'] = $Trajets->site_id;
        $newCrudData['durees'] = $Trajets->durees;
        $newCrudData['ordre'] = $Trajets->ordre;
        try {
            $newCrudData['ligne'] = $Trajets->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Trajets->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Trajets', 'entite_cle' => $Trajets->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
