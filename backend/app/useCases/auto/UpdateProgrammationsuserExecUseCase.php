<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateProgrammationsuserExecUseCase
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
        $oldProgrammationsusers = $Programmationsusers->replicate();

        $oldCrudData = [];
        $oldCrudData['user_id'] = $oldProgrammationsusers->user_id;
        $oldCrudData['programmation_id'] = $oldProgrammationsusers->programmation_id;
        $oldCrudData['identifiants_sadge'] = $oldProgrammationsusers->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldProgrammationsusers->creat_by;
        try {
            $oldCrudData['programmation'] = $oldProgrammationsusers->programmation->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldProgrammationsusers->user->Selectlabel;
        } catch (\Throwable $e) {
        }

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Programmationsusers', 'entite_cle' => $Programmationsusers->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Programmationsusers->toArray();
        return $data;
    }

}
