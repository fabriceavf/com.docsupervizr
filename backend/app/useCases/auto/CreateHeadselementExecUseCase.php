<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateHeadselementExecUseCase
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

        $Headselements = new \App\Models\Headselement();

        if (!empty($data['cle'])) {
            $Headselements->cle = $data['cle'];
        }
        if (!empty($data['valeur'])) {
            $Headselements->valeur = $data['valeur'];
        }
        if (!empty($data['entreprise_id'])) {
            $Headselements->entreprise_id = $data['entreprise_id'];
        }
        if (!empty($data['creat_by'])) {
            $Headselements->creat_by = $data['creat_by'];
        }
        $Headselements->save();
        $Headselements = \App\Models\Headselement::find($Headselements->id);
        $newCrudData = [];
        $newCrudData['cle'] = $Headselements->cle;
        $newCrudData['valeur'] = $Headselements->valeur;
        $newCrudData['entreprise_id'] = $Headselements->entreprise_id;
        $newCrudData['creat_by'] = $Headselements->creat_by;
        try {
            $newCrudData['entreprise'] = $Headselements->entreprise->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Headselements', 'entite_cle' => $Headselements->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Headselements->toArray();
        return $data;
    }

}
