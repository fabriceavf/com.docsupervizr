<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteClientExecUseCase
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

        $Clients = \App\Models\Client::find($data['id']);


        $Clients->deleted_at = now();
        $Clients->save();
        $newCrudData = [];
        $newCrudData['code'] = $Clients->code;
        $newCrudData['libelle'] = $Clients->libelle;
        $newCrudData['type'] = $Clients->type;
        $newCrudData['identifiants_sadge'] = $Clients->identifiants_sadge;
        $newCrudData['creat_by'] = $Clients->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Clients', 'entite_cle' => $Clients->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
