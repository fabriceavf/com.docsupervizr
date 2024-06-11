<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateAlldataExecUseCase
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

        $Alldatas = \App\Models\Alldata::find($data['id']);
        $oldAlldatas = $Alldatas->replicate();

        $oldCrudData = [];
        $oldCrudData['cle'] = $oldAlldatas->cle;
        $oldCrudData['valeur'] = $oldAlldatas->valeur;
        $oldCrudData['identifiants_sadge'] = $oldAlldatas->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldAlldatas->creat_by;


        if (!empty($data['cle'])) {
            $Alldatas->cle = $data['cle'];
        }
        if (!empty($data['valeur'])) {
            $Alldatas->valeur = $data['valeur'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Alldatas->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Alldatas->creat_by = $data['creat_by'];
        }
        $Alldatas->save();
        $Alldatas = \App\Models\Alldata::find($Alldatas->id);
        $newCrudData = [];
        $newCrudData['cle'] = $Alldatas->cle;
        $newCrudData['valeur'] = $Alldatas->valeur;
        $newCrudData['identifiants_sadge'] = $Alldatas->identifiants_sadge;
        $newCrudData['creat_by'] = $Alldatas->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Alldatas', 'entite_cle' => $Alldatas->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Alldatas->toArray();
        return $data;
    }

}
