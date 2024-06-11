<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypesagentshoraireExecUseCase
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

        $Typesagentshoraires = \App\Models\Typesagentshoraire::find($data['id']);


        $Typesagentshoraires->deleted_at = now();
        $Typesagentshoraires->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Typesagentshoraires->libelle;
        $newCrudData['creat_by'] = $Typesagentshoraires->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typesagentshoraires', 'entite_cle' => $Typesagentshoraires->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
