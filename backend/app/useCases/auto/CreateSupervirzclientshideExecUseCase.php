<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateSupervirzclientshideExecUseCase
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

        $Supervirzclientshides = new \App\Models\Supervirzclientshide();

        if (!empty($data['libelle'])) {
            $Supervirzclientshides->libelle = $data['libelle'];
        }
        if (!empty($data['supervirzclient_id'])) {
            $Supervirzclientshides->supervirzclient_id = $data['supervirzclient_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Supervirzclientshides->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Supervirzclientshides->creat_by = $data['creat_by'];
        }
        $Supervirzclientshides->save();
        $Supervirzclientshides = \App\Models\Supervirzclientshide::find($Supervirzclientshides->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Supervirzclientshides->libelle;
        $newCrudData['supervirzclient_id'] = $Supervirzclientshides->supervirzclient_id;
        $newCrudData['identifiants_sadge'] = $Supervirzclientshides->identifiants_sadge;
        $newCrudData['creat_by'] = $Supervirzclientshides->creat_by;
        try {
            $newCrudData['supervirzclient'] = $Supervirzclientshides->supervirzclient->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Supervirzclientshides', 'entite_cle' => $Supervirzclientshides->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Supervirzclientshides->toArray();
        return $data;
    }

}
