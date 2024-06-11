<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePrestationExecUseCase
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

        $Prestations = \App\Models\Prestation::find($data['id']);
        $oldPrestations = $Prestations->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldPrestations->code;
        $oldCrudData['libelle'] = $oldPrestations->libelle;
        $oldCrudData['description'] = $oldPrestations->description;
        $oldCrudData['identifiants_sadge'] = $oldPrestations->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldPrestations->creat_by;


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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Prestations', 'entite_cle' => $Prestations->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Prestations->toArray();
        return $data;
    }

}
