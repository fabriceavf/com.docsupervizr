<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateAttributionExecUseCase
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

        $Attributions = new \App\Models\Attribution();

        if (!empty($data['ressource_id'])) {
            $Attributions->ressource_id = $data['ressource_id'];
        }
        if (!empty($data['user_id'])) {
            $Attributions->user_id = $data['user_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Attributions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Attributions->creat_by = $data['creat_by'];
        }
        $Attributions->save();
        $Attributions = \App\Models\Attribution::find($Attributions->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Attributions', 'entite_cle' => $Attributions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Attributions->toArray();
        return $data;
    }

}
