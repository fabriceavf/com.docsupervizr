<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteInterventionimageExecUseCase
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


        $Interventionimages->deleted_at = now();
        $Interventionimages->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Interventionimages', 'entite_cle' => $Interventionimages->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
