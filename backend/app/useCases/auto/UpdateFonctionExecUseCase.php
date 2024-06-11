<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateFonctionExecUseCase
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

        $Fonctions = \App\Models\Fonction::find($data['id']);
        $oldFonctions = $Fonctions->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldFonctions->code;
        $oldCrudData['libelle'] = $oldFonctions->libelle;
        $oldCrudData['service_id'] = $oldFonctions->service_id;
        $oldCrudData['identifiants_sadge'] = $oldFonctions->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldFonctions->creat_by;
        try {
            $oldCrudData['service'] = $oldFonctions->service->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['code'])) {
            $Fonctions->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Fonctions->libelle = $data['libelle'];
        }
        if (!empty($data['service_id'])) {
            $Fonctions->service_id = $data['service_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Fonctions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Fonctions->creat_by = $data['creat_by'];
        }
        $Fonctions->save();
        $Fonctions = \App\Models\Fonction::find($Fonctions->id);
        $newCrudData = [];
        $newCrudData['code'] = $Fonctions->code;
        $newCrudData['libelle'] = $Fonctions->libelle;
        $newCrudData['service_id'] = $Fonctions->service_id;
        $newCrudData['identifiants_sadge'] = $Fonctions->identifiants_sadge;
        $newCrudData['creat_by'] = $Fonctions->creat_by;
        try {
            $newCrudData['service'] = $Fonctions->service->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Fonctions', 'entite_cle' => $Fonctions->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Fonctions->toArray();
        return $data;
    }

}
