<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteFormExecUseCase
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

        $Forms = \App\Models\Form::find($data['id']);


        $Forms->deleted_at = now();
        $Forms->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Forms->libelle;
        $newCrudData['description'] = $Forms->description;
        $newCrudData['childs'] = $Forms->childs;
        $newCrudData['champs'] = $Forms->champs;
        $newCrudData['creat_by'] = $Forms->creat_by;
        $newCrudData['identifiants_sadge'] = $Forms->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Forms', 'entite_cle' => $Forms->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
