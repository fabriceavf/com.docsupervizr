<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePostespointeuseExecUseCase
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

        $Postespointeuses = \App\Models\Postespointeuse::find($data['id']);
        $oldPostespointeuses = $Postespointeuses->replicate();

        $oldCrudData = [];
        $oldCrudData['poste_id'] = $oldPostespointeuses->poste_id;
        $oldCrudData['pointeuse_id'] = $oldPostespointeuses->pointeuse_id;
        $oldCrudData['identifiants_sadge'] = $oldPostespointeuses->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldPostespointeuses->creat_by;
        try {
            $oldCrudData['pointeuse'] = $oldPostespointeuses->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['poste'] = $oldPostespointeuses->poste->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['poste_id'])) {
            $Postespointeuses->poste_id = $data['poste_id'];
        }
        if (!empty($data['pointeuse_id'])) {
            $Postespointeuses->pointeuse_id = $data['pointeuse_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Postespointeuses->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Postespointeuses->creat_by = $data['creat_by'];
        }
        $Postespointeuses->save();
        $Postespointeuses = \App\Models\Postespointeuse::find($Postespointeuses->id);
        $newCrudData = [];
        $newCrudData['poste_id'] = $Postespointeuses->poste_id;
        $newCrudData['pointeuse_id'] = $Postespointeuses->pointeuse_id;
        $newCrudData['identifiants_sadge'] = $Postespointeuses->identifiants_sadge;
        $newCrudData['creat_by'] = $Postespointeuses->creat_by;
        try {
            $newCrudData['pointeuse'] = $Postespointeuses->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['poste'] = $Postespointeuses->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Postespointeuses', 'entite_cle' => $Postespointeuses->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Postespointeuses->toArray();
        return $data;
    }

}
