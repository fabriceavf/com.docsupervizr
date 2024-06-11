<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateLogExecUseCase
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

        $Logs = \App\Models\Log::find($data['id']);
        $oldLogs = $Logs->replicate();

        $oldCrudData = [];
        $oldCrudData['action'] = $oldLogs->action;
        $oldCrudData['ip'] = $oldLogs->ip;
        $oldCrudData['details'] = $oldLogs->details;
        $oldCrudData['navigateur'] = $oldLogs->navigateur;
        $oldCrudData['pays'] = $oldLogs->pays;
        $oldCrudData['ville'] = $oldLogs->ville;
        $oldCrudData['user_id'] = $oldLogs->user_id;
        $oldCrudData['identifiants_sadge'] = $oldLogs->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldLogs->creat_by;
        try {
            $oldCrudData['user'] = $oldLogs->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['action'])) {
            $Logs->action = $data['action'];
        }
        if (!empty($data['ip'])) {
            $Logs->ip = $data['ip'];
        }
        if (!empty($data['details'])) {
            $Logs->details = $data['details'];
        }
        if (!empty($data['navigateur'])) {
            $Logs->navigateur = $data['navigateur'];
        }
        if (!empty($data['pays'])) {
            $Logs->pays = $data['pays'];
        }
        if (!empty($data['ville'])) {
            $Logs->ville = $data['ville'];
        }
        if (!empty($data['user_id'])) {
            $Logs->user_id = $data['user_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Logs->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Logs->creat_by = $data['creat_by'];
        }
        $Logs->save();
        $Logs = \App\Models\Log::find($Logs->id);
        $newCrudData = [];
        $newCrudData['action'] = $Logs->action;
        $newCrudData['ip'] = $Logs->ip;
        $newCrudData['details'] = $Logs->details;
        $newCrudData['navigateur'] = $Logs->navigateur;
        $newCrudData['pays'] = $Logs->pays;
        $newCrudData['ville'] = $Logs->ville;
        $newCrudData['user_id'] = $Logs->user_id;
        $newCrudData['identifiants_sadge'] = $Logs->identifiants_sadge;
        $newCrudData['creat_by'] = $Logs->creat_by;
        try {
            $newCrudData['user'] = $Logs->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Logs', 'entite_cle' => $Logs->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Logs->toArray();
        return $data;
    }

}
