<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateJobExecUseCase
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

        $Jobs = \App\Models\Job::find($data['id']);
        $oldJobs = $Jobs->replicate();

        $oldCrudData = [];
        $oldCrudData['queue'] = $oldJobs->queue;
        $oldCrudData['payload'] = $oldJobs->payload;
        $oldCrudData['attempts'] = $oldJobs->attempts;
        $oldCrudData['reserved_at'] = $oldJobs->reserved_at;
        $oldCrudData['available_at'] = $oldJobs->available_at;
        $oldCrudData['identifiants_sadge'] = $oldJobs->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldJobs->creat_by;


        if (!empty($data['queue'])) {
            $Jobs->queue = $data['queue'];
        }
        if (!empty($data['payload'])) {
            $Jobs->payload = $data['payload'];
        }
        if (!empty($data['attempts'])) {
            $Jobs->attempts = $data['attempts'];
        }
        if (!empty($data['reserved_at'])) {
            $Jobs->reserved_at = $data['reserved_at'];
        }
        if (!empty($data['available_at'])) {
            $Jobs->available_at = $data['available_at'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Jobs->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Jobs->creat_by = $data['creat_by'];
        }
        $Jobs->save();
        $Jobs = \App\Models\Job::find($Jobs->id);
        $newCrudData = [];
        $newCrudData['queue'] = $Jobs->queue;
        $newCrudData['payload'] = $Jobs->payload;
        $newCrudData['attempts'] = $Jobs->attempts;
        $newCrudData['reserved_at'] = $Jobs->reserved_at;
        $newCrudData['available_at'] = $Jobs->available_at;
        $newCrudData['identifiants_sadge'] = $Jobs->identifiants_sadge;
        $newCrudData['creat_by'] = $Jobs->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Jobs', 'entite_cle' => $Jobs->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Jobs->toArray();
        return $data;
    }

}
