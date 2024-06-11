<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateContratsagentExecUseCase
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
        $oldContratsagents = $Contratsagents->replicate();

        $oldCrudData = [];
        $oldCrudData['contratsposte_id'] = $oldContratsagents->contratsposte_id;
        $oldCrudData['user_id'] = $oldContratsagents->user_id;
        $oldCrudData['identifiants_sadge'] = $oldContratsagents->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldContratsagents->creat_by;
        try {
            $oldCrudData['contratsposte'] = $oldContratsagents->contratsposte->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldContratsagents->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['contratsposte_id'])) {
            $Contratsagents->contratsposte_id = $data['contratsposte_id'];
        }
        if (!empty($data['user_id'])) {
            $Contratsagents->user_id = $data['user_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Contratsagents->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Contratsagents->creat_by = $data['creat_by'];
        }
        $Contratsagents->save();
        $Contratsagents = \App\Models\Contratsagent::find($Contratsagents->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Contratsagents', 'entite_cle' => $Contratsagents->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Contratsagents->toArray();
        return $data;
    }

}
