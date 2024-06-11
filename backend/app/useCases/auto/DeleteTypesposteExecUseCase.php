<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypesposteExecUseCase
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

        $Typespostes = \App\Models\Typesposte::find($data['id']);


        $Typespostes->deleted_at = now();
        $Typespostes->save();
        $newCrudData = [];
        $newCrudData['code'] = $Typespostes->code;
        $newCrudData['libelle'] = $Typespostes->libelle;
        $newCrudData['creat_by'] = $Typespostes->creat_by;
        $newCrudData['identifiants_sadge'] = $Typespostes->identifiants_sadge;
        $newCrudData['canCreate'] = $Typespostes->canCreate;
        $newCrudData['canUpdate'] = $Typespostes->canUpdate;
        $newCrudData['canDelete'] = $Typespostes->canDelete;
        $newCrudData['maxagent'] = $Typespostes->maxagent;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typespostes', 'entite_cle' => $Typespostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
