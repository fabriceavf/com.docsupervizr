<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateSwitchsuserExecUseCase
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

        $Switchsusers = new \App\Models\Switchsuser();

        if (!empty($data['old_type'])) {
            $Switchsusers->old_type = $data['old_type'];
        }
        if (!empty($data['new_type'])) {
            $Switchsusers->new_type = $data['new_type'];
        }
        if (!empty($data['action'])) {
            $Switchsusers->action = $data['action'];
        }
        if (!empty($data['creat_by'])) {
            $Switchsusers->creat_by = $data['creat_by'];
        }
        $Switchsusers->save();
        $Switchsusers = \App\Models\Switchsuser::find($Switchsusers->id);
        $newCrudData = [];
        $newCrudData['old_type'] = $Switchsusers->old_type;
        $newCrudData['new_type'] = $Switchsusers->new_type;
        $newCrudData['action'] = $Switchsusers->action;
        $newCrudData['creat_by'] = $Switchsusers->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Switchsusers', 'entite_cle' => $Switchsusers->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Switchsusers->toArray();
        return $data;
    }

}
