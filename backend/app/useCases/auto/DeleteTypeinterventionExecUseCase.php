<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypeinterventionExecUseCase
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

        $Typeinterventions = \App\Models\Typeintervention::find($data['id']);


        $Typeinterventions->deleted_at = now();
        $Typeinterventions->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Typeinterventions->libelle;
        $newCrudData['identifiants_sadge'] = $Typeinterventions->identifiants_sadge;
        $newCrudData['creat_by'] = $Typeinterventions->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typeinterventions', 'entite_cle' => $Typeinterventions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
