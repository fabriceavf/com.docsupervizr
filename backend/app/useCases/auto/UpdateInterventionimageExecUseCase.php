<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateInterventionimageExecUseCase
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

        $Interventionimages = \App\Models\Interventionimage::find($data['id']);
        $oldInterventionimages = $Interventionimages->replicate();

        $oldCrudData = [];
        $oldCrudData['intervention_id'] = $oldInterventionimages->intervention_id;
        $oldCrudData['path'] = $oldInterventionimages->path;
        $oldCrudData['type'] = $oldInterventionimages->type;
        $oldCrudData['identifiants_sadge'] = $oldInterventionimages->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldInterventionimages->creat_by;
        try {
            $oldCrudData['intervention'] = $oldInterventionimages->intervention->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['intervention_id'])) {
            $Interventionimages->intervention_id = $data['intervention_id'];
        }
        if (!empty($data['path'])) {
            $Interventionimages->path = $data['path'];
        }
        if (!empty($data['type'])) {
            $Interventionimages->type = $data['type'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Interventionimages->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Interventionimages->creat_by = $data['creat_by'];
        }
        $Interventionimages->save();
        $Interventionimages = \App\Models\Interventionimage::find($Interventionimages->id);
        $newCrudData = [];
        $newCrudData['intervention_id'] = $Interventionimages->intervention_id;
        $newCrudData['path'] = $Interventionimages->path;
        $newCrudData['type'] = $Interventionimages->type;
        $newCrudData['identifiants_sadge'] = $Interventionimages->identifiants_sadge;
        $newCrudData['creat_by'] = $Interventionimages->creat_by;
        try {
            $newCrudData['intervention'] = $Interventionimages->intervention->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Interventionimages', 'entite_cle' => $Interventionimages->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Interventionimages->toArray();
        return $data;
    }

}
