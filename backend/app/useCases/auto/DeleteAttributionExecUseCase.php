<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteAttributionExecUseCase
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

        $Attributions = \App\Models\Attribution::find($data['id']);


        $Attributions->deleted_at = now();
        $Attributions->save();
        $newCrudData = [];
        $newCrudData['ressource_id'] = $Attributions->ressource_id;
        $newCrudData['user_id'] = $Attributions->user_id;
        $newCrudData['identifiants_sadge'] = $Attributions->identifiants_sadge;
        $newCrudData['creat_by'] = $Attributions->creat_by;
        try {
            $newCrudData['ressource'] = $Attributions->ressource->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Attributions->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Attributions', 'entite_cle' => $Attributions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
