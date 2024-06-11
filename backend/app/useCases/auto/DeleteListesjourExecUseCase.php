<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteListesjourExecUseCase
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

        $Listesjours = \App\Models\Listesjour::find($data['id']);


        $Listesjours->deleted_at = now();
        $Listesjours->save();
        $newCrudData = [];
        $newCrudData['rand'] = $Listesjours->rand;
        $newCrudData['jour'] = $Listesjours->jour;
        $newCrudData['listesappel_id'] = $Listesjours->listesappel_id;
        $newCrudData['identifiants_sadge'] = $Listesjours->identifiants_sadge;
        $newCrudData['creat_by'] = $Listesjours->creat_by;
        try {
            $newCrudData['listesappel'] = $Listesjours->listesappel->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Listesjours', 'entite_cle' => $Listesjours->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
