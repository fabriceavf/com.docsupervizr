<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteActionExecUseCase
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

        $Actions = \App\Models\Action::find($data['id']);


        $Actions->deleted_at = now();
        $Actions->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Actions->libelle;
        $newCrudData['description'] = $Actions->description;
        $newCrudData['work_id'] = $Actions->work_id;
        $newCrudData['identifiants_sadge'] = $Actions->identifiants_sadge;
        $newCrudData['creat_by'] = $Actions->creat_by;
        try {
            $newCrudData['work'] = $Actions->work->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Actions', 'entite_cle' => $Actions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
