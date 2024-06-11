<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypesventilationExecUseCase
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

        $Typesventilations = \App\Models\Typesventilation::find($data['id']);


        $Typesventilations->deleted_at = now();
        $Typesventilations->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Typesventilations->libelle;
        $newCrudData['creat_by'] = $Typesventilations->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typesventilations', 'entite_cle' => $Typesventilations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
