<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTachespointeuseExecUseCase
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

        $Tachespointeuses = \App\Models\Tachespointeuse::find($data['id']);


        $Tachespointeuses->deleted_at = now();
        $Tachespointeuses->save();
        $newCrudData = [];
        $newCrudData['tache_id'] = $Tachespointeuses->tache_id;
        $newCrudData['pointeuse_id'] = $Tachespointeuses->pointeuse_id;
        $newCrudData['identifiants_sadge'] = $Tachespointeuses->identifiants_sadge;
        $newCrudData['creat_by'] = $Tachespointeuses->creat_by;
        try {
            $newCrudData['pointeuse'] = $Tachespointeuses->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['tache'] = $Tachespointeuses->tache->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Tachespointeuses', 'entite_cle' => $Tachespointeuses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
