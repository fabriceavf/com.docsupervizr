<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateExtrasdataExecUseCase
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

        $Extrasdatas = new \App\Models\Extrasdata();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Extrasdatas', 'entite_cle' => $Extrasdatas->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Extrasdatas->toArray();
        return $data;
    }

}
