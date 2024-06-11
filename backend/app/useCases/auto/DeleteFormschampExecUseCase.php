<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteFormschampExecUseCase
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

        $Formschamps = \App\Models\Formschamp::find($data['id']);


        $Formschamps->deleted_at = now();
        $Formschamps->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Formschamps->libelle;
        $newCrudData['description'] = $Formschamps->description;
        $newCrudData['type'] = $Formschamps->type;
        $newCrudData['cle'] = $Formschamps->cle;
        $newCrudData['width'] = $Formschamps->width;
        $newCrudData['creat_by'] = $Formschamps->creat_by;
        $newCrudData['identifiants_sadge'] = $Formschamps->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Formschamps', 'entite_cle' => $Formschamps->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
