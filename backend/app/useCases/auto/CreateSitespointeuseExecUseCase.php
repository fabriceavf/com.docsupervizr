<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateSitespointeuseExecUseCase
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

        $Sitespointeuses = new \App\Models\Sitespointeuse();

        if (!empty($data['site_id'])) {
            $Sitespointeuses->site_id = $data['site_id'];
        }
        if (!empty($data['pointeuse_id'])) {
            $Sitespointeuses->pointeuse_id = $data['pointeuse_id'];
        }
        if (!empty($data['retirer'])) {
            $Sitespointeuses->retirer = $data['retirer'];
        }
        if (!empty($data['creat_by'])) {
            $Sitespointeuses->creat_by = $data['creat_by'];
        }
        if (!empty($data['debut'])) {
            $Sitespointeuses->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Sitespointeuses->fin = $data['fin'];
        }
        $Sitespointeuses->save();
        $Sitespointeuses = \App\Models\Sitespointeuse::find($Sitespointeuses->id);
        $newCrudData = [];
        $newCrudData['site_id'] = $Sitespointeuses->site_id;
        $newCrudData['pointeuse_id'] = $Sitespointeuses->pointeuse_id;
        $newCrudData['retirer'] = $Sitespointeuses->retirer;
        $newCrudData['creat_by'] = $Sitespointeuses->creat_by;
        $newCrudData['debut'] = $Sitespointeuses->debut;
        $newCrudData['fin'] = $Sitespointeuses->fin;
        try {
            $newCrudData['pointeuse'] = $Sitespointeuses->pointeuse->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['site'] = $Sitespointeuses->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Sitespointeuses', 'entite_cle' => $Sitespointeuses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Sitespointeuses->toArray();
        return $data;
    }

}
