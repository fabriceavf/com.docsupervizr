<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTransporteurExecUseCase
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

        $Transporteurs = \App\Models\Transporteur::find($data['id']);
        $oldTransporteurs = $Transporteurs->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldTransporteurs->code;
        $oldCrudData['libelle'] = $oldTransporteurs->libelle;
        $oldCrudData['creat_by'] = $oldTransporteurs->creat_by;
        $oldCrudData['identifiants_sadge'] = $oldTransporteurs->identifiants_sadge;


        if (!empty($data['code'])) {
            $Transporteurs->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Transporteurs->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Transporteurs->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Transporteurs->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Transporteurs->save();
        $Transporteurs = \App\Models\Transporteur::find($Transporteurs->id);
        $newCrudData = [];
        $newCrudData['code'] = $Transporteurs->code;
        $newCrudData['libelle'] = $Transporteurs->libelle;
        $newCrudData['creat_by'] = $Transporteurs->creat_by;
        $newCrudData['identifiants_sadge'] = $Transporteurs->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Transporteurs', 'entite_cle' => $Transporteurs->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transporteurs->toArray();
        return $data;
    }

}
