<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteSurveillanceExecUseCase
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

        $Surveillances = \App\Models\Surveillance::find($data['id']);


        $Surveillances->deleted_at = now();
        $Surveillances->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Surveillances', 'entite_cle' => $Surveillances->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
