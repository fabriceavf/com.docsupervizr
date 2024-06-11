<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePresenceExecUseCase
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

        $Presences = \App\Models\Presence::find($data['id']);


        $Presences->deleted_at = now();
        $Presences->save();
        $newCrudData = [];
        $newCrudData['raison'] = $Presences->raison;
        $newCrudData['debut'] = $Presences->debut;
        $newCrudData['fin'] = $Presences->fin;
        $newCrudData['user_id'] = $Presences->user_id;
        $newCrudData['etats'] = $Presences->etats;
        $newCrudData['identifiants_sadge'] = $Presences->identifiants_sadge;
        $newCrudData['creat_by'] = $Presences->creat_by;
        try {
            $newCrudData['user'] = $Presences->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Presences', 'entite_cle' => $Presences->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
