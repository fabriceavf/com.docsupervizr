<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateNationaliteExecUseCase
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

        $Nationalites = new \App\Models\Nationalite();

        if (!empty($data['libelle'])) {
            $Nationalites->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Nationalites->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Nationalites->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Nationalites->creat_by = $data['creat_by'];
        }
        $Nationalites->save();
        $Nationalites = \App\Models\Nationalite::find($Nationalites->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Nationalites->libelle;
        $newCrudData['code'] = $Nationalites->code;
        $newCrudData['identifiants_sadge'] = $Nationalites->identifiants_sadge;
        $newCrudData['creat_by'] = $Nationalites->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Nationalites', 'entite_cle' => $Nationalites->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Nationalites->toArray();
        return $data;
    }

}
