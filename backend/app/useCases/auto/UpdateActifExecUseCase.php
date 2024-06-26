<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateActifExecUseCase
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

        $Actifs = \App\Models\Actif::find($data['id']);
        $oldActifs = $Actifs->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldActifs->libelle;
        $oldCrudData['code'] = $oldActifs->code;
        $oldCrudData['identifiants_sadge'] = $oldActifs->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldActifs->creat_by;


        if (!empty($data['libelle'])) {
            $Actifs->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Actifs->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Actifs->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Actifs->creat_by = $data['creat_by'];
        }
        $Actifs->save();
        $Actifs = \App\Models\Actif::find($Actifs->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Actifs->libelle;
        $newCrudData['code'] = $Actifs->code;
        $newCrudData['identifiants_sadge'] = $Actifs->identifiants_sadge;
        $newCrudData['creat_by'] = $Actifs->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Actifs', 'entite_cle' => $Actifs->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Actifs->toArray();
        return $data;
    }

}
