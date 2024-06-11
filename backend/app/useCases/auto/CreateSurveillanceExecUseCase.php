<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateSurveillanceExecUseCase
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

        $Surveillances = new \App\Models\Surveillance();

        if (!empty($data['action'])) {
            $Surveillances->action = $data['action'];
        }
        if (!empty($data['entite'])) {
            $Surveillances->entite = $data['entite'];
        }
        if (!empty($data['entite_cle'])) {
            $Surveillances->entite_cle = $data['entite_cle'];
        }
        if (!empty($data['ancien'])) {
            $Surveillances->ancien = $data['ancien'];
        }
        if (!empty($data['nouveau'])) {
            $Surveillances->nouveau = $data['nouveau'];
        }
        if (!empty($data['ip'])) {
            $Surveillances->ip = $data['ip'];
        }
        if (!empty($data['details'])) {
            $Surveillances->details = $data['details'];
        }
        if (!empty($data['navigateur'])) {
            $Surveillances->navigateur = $data['navigateur'];
        }
        if (!empty($data['pays'])) {
            $Surveillances->pays = $data['pays'];
        }
        if (!empty($data['ville'])) {
            $Surveillances->ville = $data['ville'];
        }
        if (!empty($data['user_id'])) {
            $Surveillances->user_id = $data['user_id'];
        }
        if (!empty($data['id_base'])) {
            $Surveillances->id_base = $data['id_base'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Surveillances->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Surveillances->creat_by = $data['creat_by'];
        }
        $Surveillances->save();
        $Surveillances = \App\Models\Surveillance::find($Surveillances->id);
        $newCrudData = [];
        $newCrudData['action'] = $Surveillances->action;
        $newCrudData['entite'] = $Surveillances->entite;
        $newCrudData['entite_cle'] = $Surveillances->entite_cle;
        $newCrudData['ancien'] = $Surveillances->ancien;
        $newCrudData['nouveau'] = $Surveillances->nouveau;
        $newCrudData['ip'] = $Surveillances->ip;
        $newCrudData['details'] = $Surveillances->details;
        $newCrudData['navigateur'] = $Surveillances->navigateur;
        $newCrudData['pays'] = $Surveillances->pays;
        $newCrudData['ville'] = $Surveillances->ville;
        $newCrudData['user_id'] = $Surveillances->user_id;
        $newCrudData['id_base'] = $Surveillances->id_base;
        $newCrudData['identifiants_sadge'] = $Surveillances->identifiants_sadge;
        $newCrudData['creat_by'] = $Surveillances->creat_by;
        try {
            $newCrudData['user'] = $Surveillances->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Surveillances', 'entite_cle' => $Surveillances->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Surveillances->toArray();
        return $data;
    }

}
