<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateCongeExecUseCase
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

        $Conges = new \App\Models\Conge();

        if (!empty($data['user_id'])) {
            $Conges->user_id = $data['user_id'];
        }
        if (!empty($data['raison'])) {
            $Conges->raison = $data['raison'];
        }
        if (!empty($data['debut'])) {
            $Conges->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Conges->fin = $data['fin'];
        }
        if (!empty($data['etats'])) {
            $Conges->etats = $data['etats'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Conges->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Conges->creat_by = $data['creat_by'];
        }
        $Conges->save();
        $Conges = \App\Models\Conge::find($Conges->id);
        $newCrudData = [];
        $newCrudData['user_id'] = $Conges->user_id;
        $newCrudData['raison'] = $Conges->raison;
        $newCrudData['debut'] = $Conges->debut;
        $newCrudData['fin'] = $Conges->fin;
        $newCrudData['etats'] = $Conges->etats;
        $newCrudData['identifiants_sadge'] = $Conges->identifiants_sadge;
        $newCrudData['creat_by'] = $Conges->creat_by;
        try {
            $newCrudData['user'] = $Conges->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Conges', 'entite_cle' => $Conges->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Conges->toArray();
        return $data;
    }

}
