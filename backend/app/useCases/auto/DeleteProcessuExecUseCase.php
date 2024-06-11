<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteProcessuExecUseCase
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

        $Processus = \App\Models\Processu::find($data['id']);


        $Processus->deleted_at = now();
        $Processus->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Processus->libelle;
        $newCrudData['description'] = $Processus->description;
        $newCrudData['valide_one'] = $Processus->valide_one;
        $newCrudData['valide_two'] = $Processus->valide_two;
        $newCrudData['work_id'] = $Processus->work_id;
        $newCrudData['identifiants_sadge'] = $Processus->identifiants_sadge;
        $newCrudData['creat_by'] = $Processus->creat_by;
        try {
            $newCrudData['work'] = $Processus->work->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Processus', 'entite_cle' => $Processus->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
