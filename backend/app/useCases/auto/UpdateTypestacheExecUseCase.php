<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTypestacheExecUseCase
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

        $Typestaches = \App\Models\Typestache::find($data['id']);
        $oldTypestaches = $Typestaches->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldTypestaches->libelle;
        $oldCrudData['code'] = $oldTypestaches->code;
        $oldCrudData['identifiants_sadge'] = $oldTypestaches->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldTypestaches->creat_by;


        if (!empty($data['libelle'])) {
            $Typestaches->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Typestaches->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Typestaches->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Typestaches->creat_by = $data['creat_by'];
        }
        $Typestaches->save();
        $Typestaches = \App\Models\Typestache::find($Typestaches->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Typestaches->libelle;
        $newCrudData['code'] = $Typestaches->code;
        $newCrudData['identifiants_sadge'] = $Typestaches->identifiants_sadge;
        $newCrudData['creat_by'] = $Typestaches->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Typestaches', 'entite_cle' => $Typestaches->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typestaches->toArray();
        return $data;
    }

}
