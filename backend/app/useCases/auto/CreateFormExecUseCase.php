<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateFormExecUseCase
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

        $Forms = new \App\Models\Form();

        if (!empty($data['libelle'])) {
            $Forms->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Forms->description = $data['description'];
        }
        if (!empty($data['childs'])) {
            $Forms->childs = $data['childs'];
        }
        if (!empty($data['champs'])) {
            $Forms->champs = $data['champs'];
        }
        if (!empty($data['creat_by'])) {
            $Forms->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Forms->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Forms->save();
        $Forms = \App\Models\Form::find($Forms->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Forms->libelle;
        $newCrudData['description'] = $Forms->description;
        $newCrudData['childs'] = $Forms->childs;
        $newCrudData['champs'] = $Forms->champs;
        $newCrudData['creat_by'] = $Forms->creat_by;
        $newCrudData['identifiants_sadge'] = $Forms->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Forms', 'entite_cle' => $Forms->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Forms->toArray();
        return $data;
    }

}
