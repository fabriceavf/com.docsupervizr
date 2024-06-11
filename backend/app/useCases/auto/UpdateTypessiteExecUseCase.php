<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTypessiteExecUseCase
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

        $Typessites = \App\Models\Typessite::find($data['id']);
        $oldTypessites = $Typessites->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldTypessites->code;
        $oldCrudData['libelle'] = $oldTypessites->libelle;
        $oldCrudData['creat_by'] = $oldTypessites->creat_by;
        $oldCrudData['canCreate'] = $oldTypessites->canCreate;
        $oldCrudData['canUpdate'] = $oldTypessites->canUpdate;
        $oldCrudData['canDelete'] = $oldTypessites->canDelete;


        if (!empty($data['code'])) {
            $Typessites->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Typessites->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Typessites->creat_by = $data['creat_by'];
        }
        if (!empty($data['canCreate'])) {
            $Typessites->canCreate = $data['canCreate'];
        }
        if (!empty($data['canUpdate'])) {
            $Typessites->canUpdate = $data['canUpdate'];
        }
        if (!empty($data['canDelete'])) {
            $Typessites->canDelete = $data['canDelete'];
        }
        $Typessites->save();
        $Typessites = \App\Models\Typessite::find($Typessites->id);
        $newCrudData = [];
        $newCrudData['code'] = $Typessites->code;
        $newCrudData['libelle'] = $Typessites->libelle;
        $newCrudData['creat_by'] = $Typessites->creat_by;
        $newCrudData['canCreate'] = $Typessites->canCreate;
        $newCrudData['canUpdate'] = $Typessites->canUpdate;
        $newCrudData['canDelete'] = $Typessites->canDelete;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Typessites', 'entite_cle' => $Typessites->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typessites->toArray();
        return $data;
    }

}
