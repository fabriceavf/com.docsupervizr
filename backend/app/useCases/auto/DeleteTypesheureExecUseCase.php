<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypesheureExecUseCase
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

        $Typesheures = \App\Models\Typesheure::find($data['id']);


        $Typesheures->deleted_at = now();
        $Typesheures->save();
        $newCrudData = [];
        $newCrudData['code'] = $Typesheures->code;
        $newCrudData['libelle'] = $Typesheures->libelle;
        $newCrudData['description'] = $Typesheures->description;
        $newCrudData['creat_by'] = $Typesheures->creat_by;
        $newCrudData['type'] = $Typesheures->type;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typesheures', 'entite_cle' => $Typesheures->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
