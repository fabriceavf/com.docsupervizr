<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePrestationExecUseCase
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

        $Prestations = new \App\Models\Prestation();

        if (!empty($data['code'])) {
            $Prestations->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Prestations->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Prestations->description = $data['description'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Prestations->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Prestations->creat_by = $data['creat_by'];
        }
        $Prestations->save();
        $Prestations = \App\Models\Prestation::find($Prestations->id);
        $newCrudData = [];
        $newCrudData['code'] = $Prestations->code;
        $newCrudData['libelle'] = $Prestations->libelle;
        $newCrudData['description'] = $Prestations->description;
        $newCrudData['identifiants_sadge'] = $Prestations->identifiants_sadge;
        $newCrudData['creat_by'] = $Prestations->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Prestations', 'entite_cle' => $Prestations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Prestations->toArray();
        return $data;
    }

}
