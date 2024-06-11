<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteVacationsposteExecUseCase
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

        $Vacationspostes = \App\Models\Vacationsposte::find($data['id']);


        $Vacationspostes->deleted_at = now();
        $Vacationspostes->save();
        $newCrudData = [];
        $newCrudData['total'] = $Vacationspostes->total;
        $newCrudData['date'] = $Vacationspostes->date;
        $newCrudData['poste_id'] = $Vacationspostes->poste_id;
        $newCrudData['identifiants_sadge'] = $Vacationspostes->identifiants_sadge;
        $newCrudData['creat_by'] = $Vacationspostes->creat_by;
        try {
            $newCrudData['poste'] = $Vacationspostes->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Vacationspostes', 'entite_cle' => $Vacationspostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
