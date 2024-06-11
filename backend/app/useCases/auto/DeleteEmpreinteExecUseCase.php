<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteEmpreinteExecUseCase
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

        $Empreintes = \App\Models\Empreinte::find($data['id']);


        $Empreintes->deleted_at = now();
        $Empreintes->save();
        $newCrudData = [];
        $newCrudData['signature'] = $Empreintes->signature;
        $newCrudData['user_id'] = $Empreintes->user_id;
        $newCrudData['identifiants_sadge'] = $Empreintes->identifiants_sadge;
        $newCrudData['creat_by'] = $Empreintes->creat_by;
        try {
            $newCrudData['user'] = $Empreintes->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Empreintes', 'entite_cle' => $Empreintes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
