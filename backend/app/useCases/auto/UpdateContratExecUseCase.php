<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateContratExecUseCase
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

        $Contrats = \App\Models\Contrat::find($data['id']);
        $oldContrats = $Contrats->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldContrats->libelle;
        $oldCrudData['code'] = $oldContrats->code;
        $oldCrudData['typeView'] = $oldContrats->typeView;
        $oldCrudData['expiration'] = $oldContrats->expiration;
        $oldCrudData['identifiants_sadge'] = $oldContrats->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldContrats->creat_by;


        if (!empty($data['libelle'])) {
            $Contrats->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Contrats->code = $data['code'];
        }
        if (!empty($data['typeView'])) {
            $Contrats->typeView = $data['typeView'];
        }
        if (!empty($data['expiration'])) {
            $Contrats->expiration = $data['expiration'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Contrats->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Contrats->creat_by = $data['creat_by'];
        }
        $Contrats->save();
        $Contrats = \App\Models\Contrat::find($Contrats->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Contrats->libelle;
        $newCrudData['code'] = $Contrats->code;
        $newCrudData['typeView'] = $Contrats->typeView;
        $newCrudData['expiration'] = $Contrats->expiration;
        $newCrudData['identifiants_sadge'] = $Contrats->identifiants_sadge;
        $newCrudData['creat_by'] = $Contrats->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Contrats', 'entite_cle' => $Contrats->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Contrats->toArray();
        return $data;
    }

}
