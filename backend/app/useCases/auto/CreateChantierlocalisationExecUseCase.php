<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateChantierlocalisationExecUseCase
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

        $Chantierlocalisations = new \App\Models\Chantierlocalisation();

        if (!empty($data['chantier_id'])) {
            $Chantierlocalisations->chantier_id = $data['chantier_id'];
        }
        if (!empty($data['latitude'])) {
            $Chantierlocalisations->latitude = $data['latitude'];
        }
        if (!empty($data['longitude'])) {
            $Chantierlocalisations->longitude = $data['longitude'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Chantierlocalisations->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Chantierlocalisations->creat_by = $data['creat_by'];
        }
        $Chantierlocalisations->save();
        $Chantierlocalisations = \App\Models\Chantierlocalisation::find($Chantierlocalisations->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Chantierlocalisations', 'entite_cle' => $Chantierlocalisations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Chantierlocalisations->toArray();
        return $data;
    }

}
