<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateChantierlocalisationExecUseCase
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
        $oldChantierlocalisations = $Chantierlocalisations->replicate();

        $oldCrudData = [];
        $oldCrudData['chantier_id'] = $oldChantierlocalisations->chantier_id;
        $oldCrudData['latitude'] = $oldChantierlocalisations->latitude;
        $oldCrudData['longitude'] = $oldChantierlocalisations->longitude;
        $oldCrudData['identifiants_sadge'] = $oldChantierlocalisations->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldChantierlocalisations->creat_by;
        try {
            $oldCrudData['chantier'] = $oldChantierlocalisations->chantier->Selectlabel;
        } catch (\Throwable $e) {
        }

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Chantierlocalisations', 'entite_cle' => $Chantierlocalisations->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Chantierlocalisations->toArray();
        return $data;
    }

}
