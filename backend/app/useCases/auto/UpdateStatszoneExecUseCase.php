<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateStatszoneExecUseCase
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

        $Statszones = \App\Models\Statszone::find($data['id']);
        $oldStatszones = $Statszones->replicate();

        $oldCrudData = [];
        $oldCrudData['nom1'] = $oldStatszones->nom1;
        $oldCrudData['modelslistingnuit1_id'] = $oldStatszones->modelslistingnuit1_id;
        $oldCrudData['modelslistingjour1_id'] = $oldStatszones->modelslistingjour1_id;
        $oldCrudData['nom2'] = $oldStatszones->nom2;
        $oldCrudData['modelslistingnuit2_id'] = $oldStatszones->modelslistingnuit2_id;
        $oldCrudData['modelslistingjour2_id'] = $oldStatszones->modelslistingjour2_id;
        $oldCrudData['nom3'] = $oldStatszones->nom3;
        $oldCrudData['modelslistingnuit3_id'] = $oldStatszones->modelslistingnuit3_id;
        $oldCrudData['modelslistingjour3_id'] = $oldStatszones->modelslistingjour3_id;
        $oldCrudData['creat_by'] = $oldStatszones->creat_by;
        $oldCrudData['user_id'] = $oldStatszones->user_id;
        $oldCrudData['modelslistingnuit1'] = $oldStatszones->modelslistingnuit1;
        $oldCrudData['modelslistingnuit2'] = $oldStatszones->modelslistingnuit2;
        $oldCrudData['modelslistingnuit3'] = $oldStatszones->modelslistingnuit3;
        $oldCrudData['modelslistingjour1'] = $oldStatszones->modelslistingjour1;
        $oldCrudData['modelslistingjour2'] = $oldStatszones->modelslistingjour2;
        $oldCrudData['modelslistingjour3'] = $oldStatszones->modelslistingjour3;
        $oldCrudData['identifiants_sadge'] = $oldStatszones->identifiants_sadge;
        try {
            $oldCrudData['user'] = $oldStatszones->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['nom1'])) {
            $Statszones->nom1 = $data['nom1'];
        }
        if (!empty($data['modelslistingnuit1_id'])) {
            $Statszones->modelslistingnuit1_id = $data['modelslistingnuit1_id'];
        }
        if (!empty($data['modelslistingjour1_id'])) {
            $Statszones->modelslistingjour1_id = $data['modelslistingjour1_id'];
        }
        if (!empty($data['nom2'])) {
            $Statszones->nom2 = $data['nom2'];
        }
        if (!empty($data['modelslistingnuit2_id'])) {
            $Statszones->modelslistingnuit2_id = $data['modelslistingnuit2_id'];
        }
        if (!empty($data['modelslistingjour2_id'])) {
            $Statszones->modelslistingjour2_id = $data['modelslistingjour2_id'];
        }
        if (!empty($data['nom3'])) {
            $Statszones->nom3 = $data['nom3'];
        }
        if (!empty($data['modelslistingnuit3_id'])) {
            $Statszones->modelslistingnuit3_id = $data['modelslistingnuit3_id'];
        }
        if (!empty($data['modelslistingjour3_id'])) {
            $Statszones->modelslistingjour3_id = $data['modelslistingjour3_id'];
        }
        if (!empty($data['creat_by'])) {
            $Statszones->creat_by = $data['creat_by'];
        }
        if (!empty($data['user_id'])) {
            $Statszones->user_id = $data['user_id'];
        }
        if (!empty($data['modelslistingnuit1'])) {
            $Statszones->modelslistingnuit1 = $data['modelslistingnuit1'];
        }
        if (!empty($data['modelslistingnuit2'])) {
            $Statszones->modelslistingnuit2 = $data['modelslistingnuit2'];
        }
        if (!empty($data['modelslistingnuit3'])) {
            $Statszones->modelslistingnuit3 = $data['modelslistingnuit3'];
        }
        if (!empty($data['modelslistingjour1'])) {
            $Statszones->modelslistingjour1 = $data['modelslistingjour1'];
        }
        if (!empty($data['modelslistingjour2'])) {
            $Statszones->modelslistingjour2 = $data['modelslistingjour2'];
        }
        if (!empty($data['modelslistingjour3'])) {
            $Statszones->modelslistingjour3 = $data['modelslistingjour3'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Statszones->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Statszones->save();
        $Statszones = \App\Models\Statszone::find($Statszones->id);
        $newCrudData = [];
        $newCrudData['nom1'] = $Statszones->nom1;
        $newCrudData['modelslistingnuit1_id'] = $Statszones->modelslistingnuit1_id;
        $newCrudData['modelslistingjour1_id'] = $Statszones->modelslistingjour1_id;
        $newCrudData['nom2'] = $Statszones->nom2;
        $newCrudData['modelslistingnuit2_id'] = $Statszones->modelslistingnuit2_id;
        $newCrudData['modelslistingjour2_id'] = $Statszones->modelslistingjour2_id;
        $newCrudData['nom3'] = $Statszones->nom3;
        $newCrudData['modelslistingnuit3_id'] = $Statszones->modelslistingnuit3_id;
        $newCrudData['modelslistingjour3_id'] = $Statszones->modelslistingjour3_id;
        $newCrudData['creat_by'] = $Statszones->creat_by;
        $newCrudData['user_id'] = $Statszones->user_id;
        $newCrudData['modelslistingnuit1'] = $Statszones->modelslistingnuit1;
        $newCrudData['modelslistingnuit2'] = $Statszones->modelslistingnuit2;
        $newCrudData['modelslistingnuit3'] = $Statszones->modelslistingnuit3;
        $newCrudData['modelslistingjour1'] = $Statszones->modelslistingjour1;
        $newCrudData['modelslistingjour2'] = $Statszones->modelslistingjour2;
        $newCrudData['modelslistingjour3'] = $Statszones->modelslistingjour3;
        $newCrudData['identifiants_sadge'] = $Statszones->identifiants_sadge;
        try {
            $newCrudData['user'] = $Statszones->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Statszones', 'entite_cle' => $Statszones->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Statszones->toArray();
        return $data;
    }

}
