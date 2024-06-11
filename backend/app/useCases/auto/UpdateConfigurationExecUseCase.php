<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateConfigurationExecUseCase
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

        $Configurations = \App\Models\Configuration::find($data['id']);
        $oldConfigurations = $Configurations->replicate();

        $oldCrudData = [];
        $oldCrudData['cle'] = $oldConfigurations->cle;
        $oldCrudData['valeur'] = $oldConfigurations->valeur;
        $oldCrudData['creat_by'] = $oldConfigurations->creat_by;


        if (!empty($data['cle'])) {
            $Configurations->cle = $data['cle'];
        }
        if (!empty($data['valeur'])) {
            $Configurations->valeur = $data['valeur'];
        }
        if (!empty($data['creat_by'])) {
            $Configurations->creat_by = $data['creat_by'];
        }
        $Configurations->save();
        $Configurations = \App\Models\Configuration::find($Configurations->id);
        $newCrudData = [];
        $newCrudData['cle'] = $Configurations->cle;
        $newCrudData['valeur'] = $Configurations->valeur;
        $newCrudData['creat_by'] = $Configurations->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Configurations', 'entite_cle' => $Configurations->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Configurations->toArray();
        return $data;
    }

}
