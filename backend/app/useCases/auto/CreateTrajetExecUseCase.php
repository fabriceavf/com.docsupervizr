<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTrajetExecUseCase
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

        $Trajets = new \App\Models\Trajet();

        if (!empty($data['ligne_id'])) {
            $Trajets->ligne_id = $data['ligne_id'];
        }
        if (!empty($data['distance'])) {
            $Trajets->distance = $data['distance'];
        }
        if (!empty($data['creat_by'])) {
            $Trajets->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Trajets->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['site_id'])) {
            $Trajets->site_id = $data['site_id'];
        }
        if (!empty($data['durees'])) {
            $Trajets->durees = $data['durees'];
        }
        if (!empty($data['ordre'])) {
            $Trajets->ordre = $data['ordre'];
        }
        $Trajets->save();
        $Trajets = \App\Models\Trajet::find($Trajets->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Trajets', 'entite_cle' => $Trajets->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Trajets->toArray();
        return $data;
    }

}
