<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteProgrammationsuserExecUseCase
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

        $Programmationsusers = \App\Models\Programmationsuser::find($data['id']);


        $Programmationsusers->deleted_at = now();
        $Programmationsusers->save();
        $newCrudData = [];
        $newCrudData['user_id'] = $Programmationsusers->user_id;
        $newCrudData['programmation_id'] = $Programmationsusers->programmation_id;
        $newCrudData['identifiants_sadge'] = $Programmationsusers->identifiants_sadge;
        $newCrudData['creat_by'] = $Programmationsusers->creat_by;
        try {
            $newCrudData['programmation'] = $Programmationsusers->programmation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Programmationsusers->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Programmationsusers', 'entite_cle' => $Programmationsusers->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
