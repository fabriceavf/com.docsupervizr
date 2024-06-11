<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteDocumentExecUseCase
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

        $Documents = \App\Models\Document::find($data['id']);


        $Documents->deleted_at = now();
        $Documents->save();
        $newCrudData = [];
        $newCrudData['nom'] = $Documents->nom;
        $newCrudData['rubrique'] = $Documents->rubrique;
        $newCrudData['fichier'] = $Documents->fichier;
        $newCrudData['agent_id'] = $Documents->agent_id;
        $newCrudData['identifiants_sadge'] = $Documents->identifiants_sadge;
        $newCrudData['creat_by'] = $Documents->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Documents', 'entite_cle' => $Documents->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
