<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteUserszoneExecUseCase
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

        $Userszones = \App\Models\Userszone::find($data['id']);


        $Userszones->deleted_at = now();
        $Userszones->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Userszones', 'entite_cle' => $Userszones->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
