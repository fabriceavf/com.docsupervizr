<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTypesposteExecUseCase
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
        $oldTypespostes = $Typespostes->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldTypespostes->code;
        $oldCrudData['libelle'] = $oldTypespostes->libelle;
        $oldCrudData['creat_by'] = $oldTypespostes->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldTypespostes->identifiants_sadge;
        $oldCrudData['canCreate'] = $oldTypespostes->canCreate;
        $oldCrudData['canUpdate'] = $oldTypespostes->canUpdate;
        $oldCrudData['canDelete'] = $oldTypespostes->canDelete;
        $oldCrudData['maxagent'] = $oldTypespostes->maxagent;


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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Typespostes', 'entite_cle' => $Typespostes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typespostes->toArray();
        return $data;
    }

}
