<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteLogExecUseCase
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

        $Logs = \App\Models\Log::find($data['id']);


        $Logs->deleted_at = now();
        $Logs->save();
        $newCrudData = [];
        $newCrudData['action'] = $Logs->action;
        $newCrudData['ip'] = $Logs->ip;
        $newCrudData['details'] = $Logs->details;
        $newCrudData['navigateur'] = $Logs->navigateur;
        $newCrudData['pays'] = $Logs->pays;
        $newCrudData['ville'] = $Logs->ville;
        $newCrudData['user_id'] = $Logs->user_id;
        $newCrudData['identifiants_sadge'] = $Logs->identifiants_sadge;
        $newCrudData['creat_by'] = $Logs->creat_by;
        try {
            $newCrudData['user'] = $Logs->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Logs', 'entite_cle' => $Logs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
