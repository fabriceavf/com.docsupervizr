<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateServiceExecUseCase
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

        $Services = new \App\Models\Service();

        if (!empty($data['code'])) {
            $Services->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Services->libelle = $data['libelle'];
        }
        if (!empty($data['direction_id'])) {
            $Services->direction_id = $data['direction_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Services->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Services->creat_by = $data['creat_by'];
        }
        $Services->save();
        $Services = \App\Models\Service::find($Services->id);
        $newCrudData = [];
        $newCrudData['code'] = $Services->code;
        $newCrudData['libelle'] = $Services->libelle;
        $newCrudData['direction_id'] = $Services->direction_id;
        $newCrudData['identifiants_sadge'] = $Services->identifiants_sadge;
        $newCrudData['creat_by'] = $Services->creat_by;
        try {
            $newCrudData['direction'] = $Services->direction->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Services', 'entite_cle' => $Services->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Services->toArray();
        return $data;
    }

}
