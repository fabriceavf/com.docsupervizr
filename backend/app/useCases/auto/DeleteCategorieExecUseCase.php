<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteCategorieExecUseCase
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

        $Categories = \App\Models\Categorie::find($data['id']);


        $Categories->deleted_at = now();
        $Categories->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Categories->libelle;
        $newCrudData['code'] = $Categories->code;
        $newCrudData['identifiants_sadge'] = $Categories->identifiants_sadge;
        $newCrudData['creat_by'] = $Categories->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Categories', 'entite_cle' => $Categories->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
