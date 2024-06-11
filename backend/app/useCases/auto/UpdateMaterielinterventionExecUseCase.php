<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateMaterielinterventionExecUseCase
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
        $oldMaterielinterventions = $Materielinterventions->replicate();

        $oldCrudData = [];
        $oldCrudData['intervention_id'] = $oldMaterielinterventions->intervention_id;
        $oldCrudData['type'] = $oldMaterielinterventions->type;
        $oldCrudData['libelle'] = $oldMaterielinterventions->libelle;
        $oldCrudData['date'] = $oldMaterielinterventions->date;
        $oldCrudData['valider'] = $oldMaterielinterventions->valider;
        $oldCrudData['identifiants_sadge'] = $oldMaterielinterventions->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldMaterielinterventions->creat_by;
        try {
            $oldCrudData['intervention'] = $oldMaterielinterventions->intervention->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['intervention_id'])) {
            $Materielinterventions->intervention_id = $data['intervention_id'];
        }
        if (!empty($data['type'])) {
            $Materielinterventions->type = $data['type'];
        }
        if (!empty($data['libelle'])) {
            $Materielinterventions->libelle = $data['libelle'];
        }
        if (!empty($data['date'])) {
            $Materielinterventions->date = $data['date'];
        }
        if (!empty($data['valider'])) {
            $Materielinterventions->valider = $data['valider'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Materielinterventions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Materielinterventions->creat_by = $data['creat_by'];
        }
        $Materielinterventions->save();
        $Materielinterventions = \App\Models\Materielintervention::find($Materielinterventions->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Materielinterventions', 'entite_cle' => $Materielinterventions->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Materielinterventions->toArray();
        return $data;
    }

}
