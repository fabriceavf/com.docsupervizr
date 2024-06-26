<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateExtrasdataExecUseCase
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

        $Extrasdatas = \App\Models\Extrasdata::find($data['id']);
        $oldExtrasdatas = $Extrasdatas->replicate();

        $oldCrudData = [];
        $oldCrudData['cle'] = $oldExtrasdatas->cle;
        $oldCrudData['valeur'] = $oldExtrasdatas->valeur;
        $oldCrudData['identifiants_sadge'] = $oldExtrasdatas->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldExtrasdatas->creat_by;


        if (!empty($data['cle'])) {
            $Extrasdatas->cle = $data['cle'];
        }
        if (!empty($data['valeur'])) {
            $Extrasdatas->valeur = $data['valeur'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Extrasdatas->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Extrasdatas->creat_by = $data['creat_by'];
        }
        $Extrasdatas->save();
        $Extrasdatas = \App\Models\Extrasdata::find($Extrasdatas->id);
        $newCrudData = [];
        $newCrudData['cle'] = $Extrasdatas->cle;
        $newCrudData['valeur'] = $Extrasdatas->valeur;
        $newCrudData['identifiants_sadge'] = $Extrasdatas->identifiants_sadge;
        $newCrudData['creat_by'] = $Extrasdatas->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Extrasdatas', 'entite_cle' => $Extrasdatas->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Extrasdatas->toArray();
        return $data;
    }

}
