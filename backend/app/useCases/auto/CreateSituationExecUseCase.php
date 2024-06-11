<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateSituationExecUseCase
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

        $Situations = new \App\Models\Situation();

        if (!empty($data['libelle'])) {
            $Situations->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Situations->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Situations->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Situations->creat_by = $data['creat_by'];
        }
        $Situations->save();
        $Situations = \App\Models\Situation::find($Situations->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Situations->libelle;
        $newCrudData['code'] = $Situations->code;
        $newCrudData['identifiants_sadge'] = $Situations->identifiants_sadge;
        $newCrudData['creat_by'] = $Situations->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Situations', 'entite_cle' => $Situations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Situations->toArray();
        return $data;
    }

}
