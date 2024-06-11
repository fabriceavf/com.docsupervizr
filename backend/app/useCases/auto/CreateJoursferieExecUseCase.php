<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateJoursferieExecUseCase
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

        $Joursferies = new \App\Models\Joursferie();

        if (!empty($data['raison'])) {
            $Joursferies->raison = $data['raison'];
        }
        if (!empty($data['debut'])) {
            $Joursferies->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Joursferies->fin = $data['fin'];
        }
        if (!empty($data['etats'])) {
            $Joursferies->etats = $data['etats'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Joursferies->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Joursferies->creat_by = $data['creat_by'];
        }
        $Joursferies->save();
        $Joursferies = \App\Models\Joursferie::find($Joursferies->id);
        $newCrudData = [];
        $newCrudData['raison'] = $Joursferies->raison;
        $newCrudData['debut'] = $Joursferies->debut;
        $newCrudData['fin'] = $Joursferies->fin;
        $newCrudData['etats'] = $Joursferies->etats;
        $newCrudData['identifiants_sadge'] = $Joursferies->identifiants_sadge;
        $newCrudData['creat_by'] = $Joursferies->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Joursferies', 'entite_cle' => $Joursferies->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Joursferies->toArray();
        return $data;
    }

}
