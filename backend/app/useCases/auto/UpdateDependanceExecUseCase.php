<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateDependanceExecUseCase
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

        $Dependances = \App\Models\Dependance::find($data['id']);
        $oldDependances = $Dependances->replicate();

        $oldCrudData = [];
        $oldCrudData['badge_id'] = $oldDependances->badge_id;
        $oldCrudData['libelle'] = $oldDependances->libelle;
        $oldCrudData['version'] = $oldDependances->version;
        $oldCrudData['identifiants_sadge'] = $oldDependances->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldDependances->creat_by;
        try {
            $oldCrudData['badge'] = $oldDependances->badge->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['badge_id'])) {
            $Dependances->badge_id = $data['badge_id'];
        }
        if (!empty($data['libelle'])) {
            $Dependances->libelle = $data['libelle'];
        }
        if (!empty($data['version'])) {
            $Dependances->version = $data['version'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Dependances->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Dependances->creat_by = $data['creat_by'];
        }
        $Dependances->save();
        $Dependances = \App\Models\Dependance::find($Dependances->id);
        $newCrudData = [];
        $newCrudData['badge_id'] = $Dependances->badge_id;
        $newCrudData['libelle'] = $Dependances->libelle;
        $newCrudData['version'] = $Dependances->version;
        $newCrudData['identifiants_sadge'] = $Dependances->identifiants_sadge;
        $newCrudData['creat_by'] = $Dependances->creat_by;
        try {
            $newCrudData['badge'] = $Dependances->badge->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Dependances', 'entite_cle' => $Dependances->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Dependances->toArray();
        return $data;
    }

}
