<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTypeExecUseCase
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

        $Types = \App\Models\Type::find($data['id']);
        $oldTypes = $Types->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldTypes->libelle;
        $oldCrudData['code'] = $oldTypes->code;
        $oldCrudData['identifiants_sadge'] = $oldTypes->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldTypes->creat_by;


        if (!empty($data['libelle'])) {
            $Types->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Types->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Types->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Types->creat_by = $data['creat_by'];
        }
        $Types->save();
        $Types = \App\Models\Type::find($Types->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Types->libelle;
        $newCrudData['code'] = $Types->code;
        $newCrudData['identifiants_sadge'] = $Types->identifiants_sadge;
        $newCrudData['creat_by'] = $Types->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Types', 'entite_cle' => $Types->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Types->toArray();
        return $data;
    }

}
