<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHoraireExecUseCase
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

        $Horaires = \App\Models\Horaire::find($data['id']);


        $Horaires->deleted_at = now();
        $Horaires->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Horaires->libelle;
        $newCrudData['debut'] = $Horaires->debut;
        $newCrudData['fin'] = $Horaires->fin;
        $newCrudData['tolerance'] = $Horaires->tolerance;
        $newCrudData['type'] = $Horaires->type;
        $newCrudData['parent'] = $Horaires->parent;
        $newCrudData['parentId'] = $Horaires->parentId;
        $newCrudData['vol_horaire_min'] = $Horaires->vol_horaire_min;
        $newCrudData['nmb_pointage_min'] = $Horaires->nmb_pointage_min;
        $newCrudData['identifiants_sadge'] = $Horaires->identifiants_sadge;
        $newCrudData['creat_by'] = $Horaires->creat_by;
        $newCrudData['poste_id'] = $Horaires->poste_id;
        try {
            $newCrudData['poste'] = $Horaires->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Horaires', 'entite_cle' => $Horaires->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
