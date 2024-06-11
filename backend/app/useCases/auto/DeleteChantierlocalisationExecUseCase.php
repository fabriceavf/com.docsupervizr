<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteChantierlocalisationExecUseCase
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

        $Chantierlocalisations = \App\Models\Chantierlocalisation::find($data['id']);


        $Chantierlocalisations->deleted_at = now();
        $Chantierlocalisations->save();
        $newCrudData = [];
        $newCrudData['chantier_id'] = $Chantierlocalisations->chantier_id;
        $newCrudData['latitude'] = $Chantierlocalisations->latitude;
        $newCrudData['longitude'] = $Chantierlocalisations->longitude;
        $newCrudData['identifiants_sadge'] = $Chantierlocalisations->identifiants_sadge;
        $newCrudData['creat_by'] = $Chantierlocalisations->creat_by;
        try {
            $newCrudData['chantier'] = $Chantierlocalisations->chantier->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Chantierlocalisations', 'entite_cle' => $Chantierlocalisations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
