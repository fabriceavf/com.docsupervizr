<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteFacturationuploadExecUseCase
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

        $Facturationuploads = \App\Models\Facturationupload::find($data['id']);


        $Facturationuploads->deleted_at = now();
        $Facturationuploads->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Facturationuploads->libelle;
        $newCrudData['path'] = $Facturationuploads->path;
        $newCrudData['identifiants_sadge'] = $Facturationuploads->identifiants_sadge;
        $newCrudData['creat_by'] = $Facturationuploads->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Facturationuploads', 'entite_cle' => $Facturationuploads->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
