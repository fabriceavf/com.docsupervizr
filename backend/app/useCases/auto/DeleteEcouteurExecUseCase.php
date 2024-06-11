<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteEcouteurExecUseCase
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

        $Ecouteurs = \App\Models\Ecouteur::find($data['id']);


        $Ecouteurs->deleted_at = now();
        $Ecouteurs->save();
        $newCrudData = [];
        $newCrudData['avant'] = $Ecouteurs->avant;
        $newCrudData['apres'] = $Ecouteurs->apres;
        $newCrudData['attribut'] = $Ecouteurs->attribut;
        $newCrudData['agent_id'] = $Ecouteurs->agent_id;
        $newCrudData['user_id'] = $Ecouteurs->user_id;
        $newCrudData['identifiants_sadge'] = $Ecouteurs->identifiants_sadge;
        $newCrudData['creat_by'] = $Ecouteurs->creat_by;
        try {
            $newCrudData['user'] = $Ecouteurs->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Ecouteurs', 'entite_cle' => $Ecouteurs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
