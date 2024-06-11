<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateHorairestypessiteExecUseCase
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

        $Horairestypessites = \App\Models\Horairestypessite::find($data['id']);
        $oldHorairestypessites = $Horairestypessites->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldHorairestypessites->libelle;
        $oldCrudData['debut'] = $oldHorairestypessites->debut;
        $oldCrudData['fin'] = $oldHorairestypessites->fin;
        $oldCrudData['typessite_id'] = $oldHorairestypessites->typessite_id;
        $oldCrudData['creat_by'] = $oldHorairestypessites->creat_by;
        try {
            $oldCrudData['typessite'] = $oldHorairestypessites->typessite->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Horairestypessites->libelle = $data['libelle'];
        }
        if (!empty($data['debut'])) {
            $Horairestypessites->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Horairestypessites->fin = $data['fin'];
        }
        if (!empty($data['typessite_id'])) {
            $Horairestypessites->typessite_id = $data['typessite_id'];
        }
        if (!empty($data['creat_by'])) {
            $Horairestypessites->creat_by = $data['creat_by'];
        }
        $Horairestypessites->save();
        $Horairestypessites = \App\Models\Horairestypessite::find($Horairestypessites->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Horairestypessites->libelle;
        $newCrudData['debut'] = $Horairestypessites->debut;
        $newCrudData['fin'] = $Horairestypessites->fin;
        $newCrudData['typessite_id'] = $Horairestypessites->typessite_id;
        $newCrudData['creat_by'] = $Horairestypessites->creat_by;
        try {
            $newCrudData['typessite'] = $Horairestypessites->typessite->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Horairestypessites', 'entite_cle' => $Horairestypessites->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Horairestypessites->toArray();
        return $data;
    }

}
