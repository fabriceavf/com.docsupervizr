<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteStatszoneExecUseCase
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


        $Statszones->deleted_at = now();
        $Statszones->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Statszones', 'entite_cle' => $Statszones->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
