<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteSupervirzclientshideExecUseCase
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

        $Supervirzclientshides = \App\Models\Supervirzclientshide::find($data['id']);


        $Supervirzclientshides->deleted_at = now();
        $Supervirzclientshides->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Supervirzclientshides->libelle;
        $newCrudData['supervirzclient_id'] = $Supervirzclientshides->supervirzclient_id;
        $newCrudData['identifiants_sadge'] = $Supervirzclientshides->identifiants_sadge;
        $newCrudData['creat_by'] = $Supervirzclientshides->creat_by;
        try {
            $newCrudData['supervirzclient'] = $Supervirzclientshides->supervirzclient->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Supervirzclientshides', 'entite_cle' => $Supervirzclientshides->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
