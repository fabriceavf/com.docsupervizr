<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteDetailExecUseCase
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

        $Details = \App\Models\Detail::find($data['id']);


        $Details->deleted_at = now();
        $Details->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Details->libelle;
        $newCrudData['description'] = $Details->description;
        $newCrudData['order'] = $Details->order;
        $newCrudData['processu_id'] = $Details->processu_id;
        $newCrudData['identifiants_sadge'] = $Details->identifiants_sadge;
        $newCrudData['creat_by'] = $Details->creat_by;
        try {
            $newCrudData['processu'] = $Details->processu->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Details', 'entite_cle' => $Details->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
