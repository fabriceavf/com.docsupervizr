<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateMatrimonialeExecUseCase
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

        $Matrimoniales = \App\Models\Matrimoniale::find($data['id']);
        $oldMatrimoniales = $Matrimoniales->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldMatrimoniales->libelle;
        $oldCrudData['code'] = $oldMatrimoniales->code;
        $oldCrudData['identifiants_sadge'] = $oldMatrimoniales->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldMatrimoniales->creat_by;


        if (!empty($data['libelle'])) {
            $Matrimoniales->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Matrimoniales->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Matrimoniales->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Matrimoniales->creat_by = $data['creat_by'];
        }
        $Matrimoniales->save();
        $Matrimoniales = \App\Models\Matrimoniale::find($Matrimoniales->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Matrimoniales->libelle;
        $newCrudData['code'] = $Matrimoniales->code;
        $newCrudData['identifiants_sadge'] = $Matrimoniales->identifiants_sadge;
        $newCrudData['creat_by'] = $Matrimoniales->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Matrimoniales', 'entite_cle' => $Matrimoniales->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Matrimoniales->toArray();
        return $data;
    }

}
