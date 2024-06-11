<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateMesurespreventiveExecUseCase
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

        $Mesurespreventives = \App\Models\Mesurespreventive::find($data['id']);
        $oldMesurespreventives = $Mesurespreventives->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldMesurespreventives->libelle;
        $oldCrudData['identifiants_sadge'] = $oldMesurespreventives->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldMesurespreventives->creat_by;


        if (!empty($data['libelle'])) {
            $Mesurespreventives->libelle = $data['libelle'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Mesurespreventives->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Mesurespreventives->creat_by = $data['creat_by'];
        }
        $Mesurespreventives->save();
        $Mesurespreventives = \App\Models\Mesurespreventive::find($Mesurespreventives->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Mesurespreventives->libelle;
        $newCrudData['identifiants_sadge'] = $Mesurespreventives->identifiants_sadge;
        $newCrudData['creat_by'] = $Mesurespreventives->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Mesurespreventives', 'entite_cle' => $Mesurespreventives->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Mesurespreventives->toArray();
        return $data;
    }

}
