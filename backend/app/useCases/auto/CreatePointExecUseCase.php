<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePointExecUseCase
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

        $Points = new \App\Models\Point();

        if (!empty($data['libelle'])) {
            $Points->libelle = $data['libelle'];
        }
        if (!empty($data['longitude'])) {
            $Points->longitude = $data['longitude'];
        }
        if (!empty($data['latitude'])) {
            $Points->latitude = $data['latitude'];
        }
        if (!empty($data['ville_id'])) {
            $Points->ville_id = $data['ville_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Points->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Points->creat_by = $data['creat_by'];
        }
        $Points->save();
        $Points = \App\Models\Point::find($Points->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Points', 'entite_cle' => $Points->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Points->toArray();
        return $data;
    }

}
