<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateRecupereExecUseCase
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

        $Recuperes = new \App\Models\Recupere();

        if (!empty($data['libelle'])) {
            $Recuperes->libelle = $data['libelle'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Recuperes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Recuperes->creat_by = $data['creat_by'];
        }
        $Recuperes->save();
        $Recuperes = \App\Models\Recupere::find($Recuperes->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Recuperes->libelle;
        $newCrudData['identifiants_sadge'] = $Recuperes->identifiants_sadge;
        $newCrudData['creat_by'] = $Recuperes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Recuperes', 'entite_cle' => $Recuperes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Recuperes->toArray();
        return $data;
    }

}
