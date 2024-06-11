<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteMaterielinterventionExecUseCase
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

        $Materielinterventions = \App\Models\Materielintervention::find($data['id']);


        $Materielinterventions->deleted_at = now();
        $Materielinterventions->save();
        $newCrudData = [];
        $newCrudData['intervention_id'] = $Materielinterventions->intervention_id;
        $newCrudData['type'] = $Materielinterventions->type;
        $newCrudData['libelle'] = $Materielinterventions->libelle;
        $newCrudData['date'] = $Materielinterventions->date;
        $newCrudData['valider'] = $Materielinterventions->valider;
        $newCrudData['identifiants_sadge'] = $Materielinterventions->identifiants_sadge;
        $newCrudData['creat_by'] = $Materielinterventions->creat_by;
        try {
            $newCrudData['intervention'] = $Materielinterventions->intervention->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Materielinterventions', 'entite_cle' => $Materielinterventions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
