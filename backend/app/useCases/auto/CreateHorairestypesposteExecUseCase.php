<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateHorairestypesposteExecUseCase
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

        $Horairestypespostes = new \App\Models\Horairestypesposte();

        if (!empty($data['libelle'])) {
            $Horairestypespostes->libelle = $data['libelle'];
        }
        if (!empty($data['debut'])) {
            $Horairestypespostes->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Horairestypespostes->fin = $data['fin'];
        }
        if (!empty($data['typesposte_id'])) {
            $Horairestypespostes->typesposte_id = $data['typesposte_id'];
        }
        if (!empty($data['creat_by'])) {
            $Horairestypespostes->creat_by = $data['creat_by'];
        }
        if (!empty($data['ordre'])) {
            $Horairestypespostes->ordre = $data['ordre'];
        }
        $Horairestypespostes->save();
        $Horairestypespostes = \App\Models\Horairestypesposte::find($Horairestypespostes->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Horairestypespostes->libelle;
        $newCrudData['debut'] = $Horairestypespostes->debut;
        $newCrudData['fin'] = $Horairestypespostes->fin;
        $newCrudData['typesposte_id'] = $Horairestypespostes->typesposte_id;
        $newCrudData['creat_by'] = $Horairestypespostes->creat_by;
        $newCrudData['ordre'] = $Horairestypespostes->ordre;
        try {
            $newCrudData['typesposte'] = $Horairestypespostes->typesposte->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Horairestypespostes', 'entite_cle' => $Horairestypespostes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Horairestypespostes->toArray();
        return $data;
    }

}
