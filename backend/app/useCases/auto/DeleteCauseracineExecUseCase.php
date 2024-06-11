<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteCauseracineExecUseCase
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

        $Causeracines = \App\Models\Causeracine::find($data['id']);


        $Causeracines->deleted_at = now();
        $Causeracines->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Causeracines->libelle;
        $newCrudData['identifiants_sadge'] = $Causeracines->identifiants_sadge;
        $newCrudData['creat_by'] = $Causeracines->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Causeracines', 'entite_cle' => $Causeracines->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
