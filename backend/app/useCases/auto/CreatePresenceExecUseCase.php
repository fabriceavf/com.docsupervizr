<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePresenceExecUseCase
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

        $Presences = new \App\Models\Presence();

        if (!empty($data['raison'])) {
            $Presences->raison = $data['raison'];
        }
        if (!empty($data['debut'])) {
            $Presences->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Presences->fin = $data['fin'];
        }
        if (!empty($data['user_id'])) {
            $Presences->user_id = $data['user_id'];
        }
        if (!empty($data['etats'])) {
            $Presences->etats = $data['etats'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Presences->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Presences->creat_by = $data['creat_by'];
        }
        $Presences->save();
        $Presences = \App\Models\Presence::find($Presences->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Presences', 'entite_cle' => $Presences->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Presences->toArray();
        return $data;
    }

}
