<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteJobExecUseCase
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


        $Jobs->deleted_at = now();
        $Jobs->save();
        $newCrudData = [];
        $newCrudData['queue'] = $Jobs->queue;
        $newCrudData['payload'] = $Jobs->payload;
        $newCrudData['attempts'] = $Jobs->attempts;
        $newCrudData['reserved_at'] = $Jobs->reserved_at;
        $newCrudData['available_at'] = $Jobs->available_at;
        $newCrudData['identifiants_sadge'] = $Jobs->identifiants_sadge;
        $newCrudData['creat_by'] = $Jobs->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Jobs', 'entite_cle' => $Jobs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
