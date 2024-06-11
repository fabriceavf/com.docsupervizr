<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateVariableExecUseCase
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

        $Variables = \App\Models\Variable::find($data['id']);
        $oldVariables = $Variables->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldVariables->libelle;
        $oldCrudData['code'] = $oldVariables->code;
        $oldCrudData['identifiants_sadge'] = $oldVariables->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldVariables->creat_by;


        if (!empty($data['libelle'])) {
            $Variables->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Variables->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Variables->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Variables->creat_by = $data['creat_by'];
        }
        $Variables->save();
        $Variables = \App\Models\Variable::find($Variables->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Variables->libelle;
        $newCrudData['code'] = $Variables->code;
        $newCrudData['identifiants_sadge'] = $Variables->identifiants_sadge;
        $newCrudData['creat_by'] = $Variables->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Variables', 'entite_cle' => $Variables->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Variables->toArray();
        return $data;
    }

}
