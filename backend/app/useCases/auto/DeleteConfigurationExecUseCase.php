<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteConfigurationExecUseCase
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

        $Configurations = \App\Models\Configuration::find($data['id']);


        $Configurations->deleted_at = now();
        $Configurations->save();
        $newCrudData = [];
        $newCrudData['cle'] = $Configurations->cle;
        $newCrudData['valeur'] = $Configurations->valeur;
        $newCrudData['creat_by'] = $Configurations->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Configurations', 'entite_cle' => $Configurations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
