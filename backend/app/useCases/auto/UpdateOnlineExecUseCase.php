<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateOnlineExecUseCase
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

        $Onlines = \App\Models\Online::find($data['id']);
        $oldOnlines = $Onlines->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldOnlines->libelle;
        $oldCrudData['code'] = $oldOnlines->code;
        $oldCrudData['identifiants_sadge'] = $oldOnlines->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldOnlines->creat_by;


        if (!empty($data['libelle'])) {
            $Onlines->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Onlines->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Onlines->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Onlines->creat_by = $data['creat_by'];
        }
        $Onlines->save();
        $Onlines = \App\Models\Online::find($Onlines->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Onlines->libelle;
        $newCrudData['code'] = $Onlines->code;
        $newCrudData['identifiants_sadge'] = $Onlines->identifiants_sadge;
        $newCrudData['creat_by'] = $Onlines->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Onlines', 'entite_cle' => $Onlines->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Onlines->toArray();
        return $data;
    }

}
