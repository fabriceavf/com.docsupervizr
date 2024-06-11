<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTachespointeuseExecUseCase
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

        $Tachespointeuses = new \App\Models\Tachespointeuse();

        if (!empty($data['tache_id'])) {
            $Tachespointeuses->tache_id = $data['tache_id'];
        }
        if (!empty($data['pointeuse_id'])) {
            $Tachespointeuses->pointeuse_id = $data['pointeuse_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Tachespointeuses->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Tachespointeuses->creat_by = $data['creat_by'];
        }
        $Tachespointeuses->save();
        $Tachespointeuses = \App\Models\Tachespointeuse::find($Tachespointeuses->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Tachespointeuses', 'entite_cle' => $Tachespointeuses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Tachespointeuses->toArray();
        return $data;
    }

}
