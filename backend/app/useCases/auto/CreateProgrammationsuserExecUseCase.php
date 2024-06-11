<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateProgrammationsuserExecUseCase
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

        $Programmationsusers = new \App\Models\Programmationsuser();

        if (!empty($data['user_id'])) {
            $Programmationsusers->user_id = $data['user_id'];
        }
        if (!empty($data['programmation_id'])) {
            $Programmationsusers->programmation_id = $data['programmation_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Programmationsusers->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Programmationsusers->creat_by = $data['creat_by'];
        }
        $Programmationsusers->save();
        $Programmationsusers = \App\Models\Programmationsuser::find($Programmationsusers->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Programmationsusers', 'entite_cle' => $Programmationsusers->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Programmationsusers->toArray();
        return $data;
    }

}
