<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateSexeExecUseCase
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

        $Sexes = \App\Models\Sexe::find($data['id']);
        $oldSexes = $Sexes->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldSexes->libelle;
        $oldCrudData['code'] = $oldSexes->code;
        $oldCrudData['identifiants_sadge'] = $oldSexes->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldSexes->creat_by;


        if (!empty($data['libelle'])) {
            $Sexes->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Sexes->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Sexes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Sexes->creat_by = $data['creat_by'];
        }
        $Sexes->save();
        $Sexes = \App\Models\Sexe::find($Sexes->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Sexes->libelle;
        $newCrudData['code'] = $Sexes->code;
        $newCrudData['identifiants_sadge'] = $Sexes->identifiants_sadge;
        $newCrudData['creat_by'] = $Sexes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Sexes', 'entite_cle' => $Sexes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Sexes->toArray();
        return $data;
    }

}
