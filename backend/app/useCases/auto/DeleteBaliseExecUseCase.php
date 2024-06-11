<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteBaliseExecUseCase
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

        $Balises = \App\Models\Balise::find($data['id']);


        $Balises->deleted_at = now();
        $Balises->save();
        $newCrudData = [];
        $newCrudData['imei'] = $Balises->imei;
        $newCrudData['identifiants_sadge'] = $Balises->identifiants_sadge;
        $newCrudData['creat_by'] = $Balises->creat_by;
        $newCrudData['libelle'] = $Balises->libelle;
        $newCrudData['ref'] = $Balises->ref;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Balises', 'entite_cle' => $Balises->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
