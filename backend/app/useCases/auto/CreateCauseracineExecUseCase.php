<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateCauseracineExecUseCase
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

        $Causeracines = new \App\Models\Causeracine();

        if (!empty($data['libelle'])) {
            $Causeracines->libelle = $data['libelle'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Causeracines->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Causeracines->creat_by = $data['creat_by'];
        }
        $Causeracines->save();
        $Causeracines = \App\Models\Causeracine::find($Causeracines->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Causeracines->libelle;
        $newCrudData['identifiants_sadge'] = $Causeracines->identifiants_sadge;
        $newCrudData['creat_by'] = $Causeracines->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Causeracines', 'entite_cle' => $Causeracines->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Causeracines->toArray();
        return $data;
    }

}
