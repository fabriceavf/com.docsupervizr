<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateEchelonExecUseCase
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

        $Echelons = \App\Models\Echelon::find($data['id']);
        $oldEchelons = $Echelons->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldEchelons->libelle;
        $oldCrudData['code'] = $oldEchelons->code;
        $oldCrudData['identifiants_sadge'] = $oldEchelons->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldEchelons->creat_by;


        if (!empty($data['libelle'])) {
            $Echelons->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Echelons->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Echelons->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Echelons->creat_by = $data['creat_by'];
        }
        $Echelons->save();
        $Echelons = \App\Models\Echelon::find($Echelons->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Echelons->libelle;
        $newCrudData['code'] = $Echelons->code;
        $newCrudData['identifiants_sadge'] = $Echelons->identifiants_sadge;
        $newCrudData['creat_by'] = $Echelons->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Echelons', 'entite_cle' => $Echelons->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Echelons->toArray();
        return $data;
    }

}
