<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateHoraireagentExecUseCase
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

        $Horaireagents = \App\Models\Horaireagent::find($data['id']);
        $oldHoraireagents = $Horaireagents->replicate();

        $oldCrudData = [];
        $oldCrudData['horaire_id'] = $oldHoraireagents->horaire_id;
        $oldCrudData['user_id'] = $oldHoraireagents->user_id;
        $oldCrudData['lun'] = $oldHoraireagents->lun;
        $oldCrudData['mar'] = $oldHoraireagents->mar;
        $oldCrudData['mer'] = $oldHoraireagents->mer;
        $oldCrudData['jeu'] = $oldHoraireagents->jeu;
        $oldCrudData['ven'] = $oldHoraireagents->ven;
        $oldCrudData['sam'] = $oldHoraireagents->sam;
        $oldCrudData['dim'] = $oldHoraireagents->dim;
        $oldCrudData['identifiants_sadge'] = $oldHoraireagents->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldHoraireagents->creat_by;
        $oldCrudData['typesagents'] = $oldHoraireagents->typesagents;
        try {
            $oldCrudData['horaire'] = $oldHoraireagents->horaire->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldHoraireagents->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['horaire_id'])) {
            $Horaireagents->horaire_id = $data['horaire_id'];
        }
        if (!empty($data['user_id'])) {
            $Horaireagents->user_id = $data['user_id'];
        }
        if (!empty($data['lun'])) {
            $Horaireagents->lun = $data['lun'];
        }
        if (!empty($data['mar'])) {
            $Horaireagents->mar = $data['mar'];
        }
        if (!empty($data['mer'])) {
            $Horaireagents->mer = $data['mer'];
        }
        if (!empty($data['jeu'])) {
            $Horaireagents->jeu = $data['jeu'];
        }
        if (!empty($data['ven'])) {
            $Horaireagents->ven = $data['ven'];
        }
        if (!empty($data['sam'])) {
            $Horaireagents->sam = $data['sam'];
        }
        if (!empty($data['dim'])) {
            $Horaireagents->dim = $data['dim'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Horaireagents->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Horaireagents->creat_by = $data['creat_by'];
        }
        if (!empty($data['typesagents'])) {
            $Horaireagents->typesagents = $data['typesagents'];
        }
        $Horaireagents->save();
        $Horaireagents = \App\Models\Horaireagent::find($Horaireagents->id);
        $newCrudData = [];
        $newCrudData['horaire_id'] = $Horaireagents->horaire_id;
        $newCrudData['user_id'] = $Horaireagents->user_id;
        $newCrudData['lun'] = $Horaireagents->lun;
        $newCrudData['mar'] = $Horaireagents->mar;
        $newCrudData['mer'] = $Horaireagents->mer;
        $newCrudData['jeu'] = $Horaireagents->jeu;
        $newCrudData['ven'] = $Horaireagents->ven;
        $newCrudData['sam'] = $Horaireagents->sam;
        $newCrudData['dim'] = $Horaireagents->dim;
        $newCrudData['identifiants_sadge'] = $Horaireagents->identifiants_sadge;
        $newCrudData['creat_by'] = $Horaireagents->creat_by;
        $newCrudData['typesagents'] = $Horaireagents->typesagents;
        try {
            $newCrudData['horaire'] = $Horaireagents->horaire->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Horaireagents->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Horaireagents', 'entite_cle' => $Horaireagents->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Horaireagents->toArray();
        return $data;
    }

}
