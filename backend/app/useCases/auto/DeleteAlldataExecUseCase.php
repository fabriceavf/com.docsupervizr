<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteAlldataExecUseCase
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

        $Alldatas = \App\Models\Alldata::find($data['id']);


        $Alldatas->deleted_at = now();
        $Alldatas->save();
        $newCrudData = [];
        $newCrudData['cle'] = $Alldatas->cle;
        $newCrudData['valeur'] = $Alldatas->valeur;
        $newCrudData['identifiants_sadge'] = $Alldatas->identifiants_sadge;
        $newCrudData['creat_by'] = $Alldatas->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Alldatas', 'entite_cle' => $Alldatas->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
