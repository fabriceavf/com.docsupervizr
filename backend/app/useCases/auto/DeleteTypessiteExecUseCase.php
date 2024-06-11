<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypessiteExecUseCase
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


        $Typessites->deleted_at = now();
        $Typessites->save();
        $newCrudData = [];
        $newCrudData['code'] = $Typessites->code;
        $newCrudData['libelle'] = $Typessites->libelle;
        $newCrudData['creat_by'] = $Typessites->creat_by;
        $newCrudData['canCreate'] = $Typessites->canCreate;
        $newCrudData['canUpdate'] = $Typessites->canUpdate;
        $newCrudData['canDelete'] = $Typessites->canDelete;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typessites', 'entite_cle' => $Typessites->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
