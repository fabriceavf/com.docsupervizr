<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePostesglobalExecUseCase
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

        $Postesglobals = new \App\Models\Postesglobal();

        if (!empty($data['libelle'])) {
            $Postesglobals->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Postesglobals->code = $data['code'];
        }
        if (!empty($data['site'])) {
            $Postesglobals->site = $data['site'];
        }
        if (!empty($data['zone'])) {
            $Postesglobals->zone = $data['zone'];
        }
        $Postesglobals->save();
        $Postesglobals = \App\Models\Postesglobal::find($Postesglobals->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Postesglobals->libelle;
        $newCrudData['code'] = $Postesglobals->code;
        $newCrudData['site'] = $Postesglobals->site;
        $newCrudData['zone'] = $Postesglobals->zone;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Postesglobals', 'entite_cle' => $Postesglobals->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Postesglobals->toArray();
        return $data;
    }

}
