<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteSwitchsuserExecUseCase
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

        $Switchsusers = \App\Models\Switchsuser::find($data['id']);


        $Switchsusers->deleted_at = now();
        $Switchsusers->save();
        $newCrudData = [];
        $newCrudData['old_type'] = $Switchsusers->old_type;
        $newCrudData['new_type'] = $Switchsusers->new_type;
        $newCrudData['action'] = $Switchsusers->action;
        $newCrudData['creat_by'] = $Switchsusers->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Switchsusers', 'entite_cle' => $Switchsusers->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
