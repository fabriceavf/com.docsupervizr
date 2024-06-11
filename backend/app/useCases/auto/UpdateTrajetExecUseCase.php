<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTrajetExecUseCase
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
        $oldTrajets = $Trajets->replicate();

        $oldCrudData = [];
        $oldCrudData['ligne_id'] = $oldTrajets->ligne_id;
        $oldCrudData['distance'] = $oldTrajets->distance;
        $oldCrudData['creat_by'] = $oldTrajets->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldTrajets->identifiants_sadge;
        $oldCrudData['site_id'] = $oldTrajets->site_id;
        $oldCrudData['durees'] = $oldTrajets->durees;
        $oldCrudData['ordre'] = $oldTrajets->ordre;
        try {
            $oldCrudData['ligne'] = $oldTrajets->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['site'] = $oldTrajets->site->Selectlabel;
        } catch (\Throwable $e) {
        }

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Trajets', 'entite_cle' => $Trajets->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Trajets->toArray();
        return $data;
    }

}
