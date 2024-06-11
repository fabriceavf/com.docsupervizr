<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteWorkExecUseCase
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

        $Works = \App\Models\Work::find($data['id']);


        $Works->deleted_at = now();
        $Works->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Works->libelle;
        $newCrudData['activite_id'] = $Works->activite_id;
        $newCrudData['user_id'] = $Works->user_id;
        $newCrudData['debut'] = $Works->debut;
        $newCrudData['fin'] = $Works->fin;
        $newCrudData['groupe'] = $Works->groupe;
        $newCrudData['identifiants_sadge'] = $Works->identifiants_sadge;
        $newCrudData['creat_by'] = $Works->creat_by;
        try {
            $newCrudData['activite'] = $Works->activite->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Works->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Works', 'entite_cle' => $Works->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
