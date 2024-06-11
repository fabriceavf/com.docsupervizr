<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateListesjourExecUseCase
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
        $oldListesjours = $Listesjours->replicate();

        $oldCrudData = [];
        $oldCrudData['rand'] = $oldListesjours->rand;
        $oldCrudData['jour'] = $oldListesjours->jour;
        $oldCrudData['listesappel_id'] = $oldListesjours->listesappel_id;
        $oldCrudData['identifiants_sadge'] = $oldListesjours->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldListesjours->creat_by;
        try {
            $oldCrudData['listesappel'] = $oldListesjours->listesappel->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['rand'])) {
            $Listesjours->rand = $data['rand'];
        }
        if (!empty($data['jour'])) {
            $Listesjours->jour = $data['jour'];
        }
        if (!empty($data['listesappel_id'])) {
            $Listesjours->listesappel_id = $data['listesappel_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Listesjours->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Listesjours->creat_by = $data['creat_by'];
        }
        $Listesjours->save();
        $Listesjours = \App\Models\Listesjour::find($Listesjours->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Listesjours', 'entite_cle' => $Listesjours->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Listesjours->toArray();
        return $data;
    }

}
