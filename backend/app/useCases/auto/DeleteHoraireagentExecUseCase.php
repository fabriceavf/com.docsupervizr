<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHoraireagentExecUseCase
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


        $Horaireagents->deleted_at = now();
        $Horaireagents->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Horaireagents', 'entite_cle' => $Horaireagents->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
