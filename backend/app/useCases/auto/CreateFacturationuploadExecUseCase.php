<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateFacturationuploadExecUseCase
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

        $Facturationuploads = new \App\Models\Facturationupload();

        if (!empty($data['libelle'])) {
            $Facturationuploads->libelle = $data['libelle'];
        }
        if (!empty($data['path'])) {
            $Facturationuploads->path = $data['path'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Facturationuploads->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Facturationuploads->creat_by = $data['creat_by'];
        }
        $Facturationuploads->save();
        $Facturationuploads = \App\Models\Facturationupload::find($Facturationuploads->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Facturationuploads->libelle;
        $newCrudData['path'] = $Facturationuploads->path;
        $newCrudData['identifiants_sadge'] = $Facturationuploads->identifiants_sadge;
        $newCrudData['creat_by'] = $Facturationuploads->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Facturationuploads', 'entite_cle' => $Facturationuploads->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Facturationuploads->toArray();
        return $data;
    }

}
