<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateServiceExecUseCase
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

        $Services = \App\Models\Service::find($data['id']);
        $oldServices = $Services->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldServices->code;
        $oldCrudData['libelle'] = $oldServices->libelle;
        $oldCrudData['direction_id'] = $oldServices->direction_id;
        $oldCrudData['identifiants_sadge'] = $oldServices->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldServices->creat_by;
        try {
            $oldCrudData['direction'] = $oldServices->direction->Selectlabel;
        } catch (\Throwable $e) {
        }

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Services', 'entite_cle' => $Services->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Services->toArray();
        return $data;
    }

}
