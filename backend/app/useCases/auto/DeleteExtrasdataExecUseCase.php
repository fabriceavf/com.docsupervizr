<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteExtrasdataExecUseCase
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

        $Extrasdatas = \App\Models\Extrasdata::find($data['id']);


        $Extrasdatas->deleted_at = now();
        $Extrasdatas->save();
        $newCrudData = [];
        $newCrudData['cle'] = $Extrasdatas->cle;
        $newCrudData['valeur'] = $Extrasdatas->valeur;
        $newCrudData['identifiants_sadge'] = $Extrasdatas->identifiants_sadge;
        $newCrudData['creat_by'] = $Extrasdatas->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Extrasdatas', 'entite_cle' => $Extrasdatas->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
