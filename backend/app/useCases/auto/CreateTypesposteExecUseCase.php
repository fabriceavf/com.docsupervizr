<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTypesposteExecUseCase
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

        $Typespostes = new \App\Models\Typesposte();

        if (!empty($data['code'])) {
            $Typespostes->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Typespostes->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Typespostes->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Typespostes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['canCreate'])) {
            $Typespostes->canCreate = $data['canCreate'];
        }
        if (!empty($data['canUpdate'])) {
            $Typespostes->canUpdate = $data['canUpdate'];
        }
        if (!empty($data['canDelete'])) {
            $Typespostes->canDelete = $data['canDelete'];
        }
        if (!empty($data['maxagent'])) {
            $Typespostes->maxagent = $data['maxagent'];
        }
        $Typespostes->save();
        $Typespostes = \App\Models\Typesposte::find($Typespostes->id);
        $newCrudData = [];
        $newCrudData['code'] = $Typespostes->code;
        $newCrudData['libelle'] = $Typespostes->libelle;
        $newCrudData['creat_by'] = $Typespostes->creat_by;
        $newCrudData['identifiants_sadge'] = $Typespostes->identifiants_sadge;
        $newCrudData['canCreate'] = $Typespostes->canCreate;
        $newCrudData['canUpdate'] = $Typespostes->canUpdate;
        $newCrudData['canDelete'] = $Typespostes->canDelete;
        $newCrudData['maxagent'] = $Typespostes->maxagent;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Typespostes', 'entite_cle' => $Typespostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typespostes->toArray();
        return $data;
    }

}
