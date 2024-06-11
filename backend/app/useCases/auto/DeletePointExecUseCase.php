<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePointExecUseCase
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

        $Points = \App\Models\Point::find($data['id']);


        $Points->deleted_at = now();
        $Points->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Points->libelle;
        $newCrudData['longitude'] = $Points->longitude;
        $newCrudData['latitude'] = $Points->latitude;
        $newCrudData['ville_id'] = $Points->ville_id;
        $newCrudData['identifiants_sadge'] = $Points->identifiants_sadge;
        $newCrudData['creat_by'] = $Points->creat_by;
        try {
            $newCrudData['ville'] = $Points->ville->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Points', 'entite_cle' => $Points->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
