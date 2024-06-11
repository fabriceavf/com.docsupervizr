<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteServiceExecUseCase
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

        $Services = \App\Models\Service::find($data['id']);


        $Services->deleted_at = now();
        $Services->save();
        $newCrudData = [];
        $newCrudData['code'] = $Services->code;
        $newCrudData['libelle'] = $Services->libelle;
        $newCrudData['direction_id'] = $Services->direction_id;
        $newCrudData['identifiants_sadge'] = $Services->identifiants_sadge;
        $newCrudData['creat_by'] = $Services->creat_by;
        try {
            $newCrudData['direction'] = $Services->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Services', 'entite_cle' => $Services->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
