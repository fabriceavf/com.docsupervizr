<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePostesagentExecUseCase
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

        $Postesagents = \App\Models\Postesagent::find($data['id']);


        $Postesagents->deleted_at = now();
        $Postesagents->save();
        $newCrudData = [];
        $newCrudData['poste_id'] = $Postesagents->poste_id;
        $newCrudData['user_id'] = $Postesagents->user_id;
        $newCrudData['faction'] = $Postesagents->faction;
        $newCrudData['lun'] = $Postesagents->lun;
        $newCrudData['mar'] = $Postesagents->mar;
        $newCrudData['mer'] = $Postesagents->mer;
        $newCrudData['jeu'] = $Postesagents->jeu;
        $newCrudData['ven'] = $Postesagents->ven;
        $newCrudData['sam'] = $Postesagents->sam;
        $newCrudData['dim'] = $Postesagents->dim;
        $newCrudData['identifiants_sadge'] = $Postesagents->identifiants_sadge;
        $newCrudData['creat_by'] = $Postesagents->creat_by;
        try {
            $newCrudData['poste'] = $Postesagents->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Postesagents->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Postesagents', 'entite_cle' => $Postesagents->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
