<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteContratsagentExecUseCase
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

        $Contratsagents = \App\Models\Contratsagent::find($data['id']);


        $Contratsagents->deleted_at = now();
        $Contratsagents->save();
        $newCrudData = [];
        $newCrudData['contratsposte_id'] = $Contratsagents->contratsposte_id;
        $newCrudData['user_id'] = $Contratsagents->user_id;
        $newCrudData['identifiants_sadge'] = $Contratsagents->identifiants_sadge;
        $newCrudData['creat_by'] = $Contratsagents->creat_by;
        try {
            $newCrudData['contratsposte'] = $Contratsagents->contratsposte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Contratsagents->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Contratsagents', 'entite_cle' => $Contratsagents->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
