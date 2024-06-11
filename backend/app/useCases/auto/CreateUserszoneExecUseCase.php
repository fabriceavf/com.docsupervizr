<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateUserszoneExecUseCase
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

        $Userszones = new \App\Models\Userszone();

        if (!empty($data['user_id'])) {
            $Userszones->user_id = $data['user_id'];
        }
        if (!empty($data['zone_id'])) {
            $Userszones->zone_id = $data['zone_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Userszones->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Userszones->creat_by = $data['creat_by'];
        }
        $Userszones->save();
        $Userszones = \App\Models\Userszone::find($Userszones->id);
        $newCrudData = [];
        $newCrudData['user_id'] = $Userszones->user_id;
        $newCrudData['zone_id'] = $Userszones->zone_id;
        $newCrudData['identifiants_sadge'] = $Userszones->identifiants_sadge;
        $newCrudData['creat_by'] = $Userszones->creat_by;
        try {
            $newCrudData['user'] = $Userszones->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['zone'] = $Userszones->zone->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Userszones', 'entite_cle' => $Userszones->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Userszones->toArray();
        return $data;
    }

}
