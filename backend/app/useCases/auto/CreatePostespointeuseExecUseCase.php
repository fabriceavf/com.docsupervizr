<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePostespointeuseExecUseCase
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

        $Postespointeuses = new \App\Models\Postespointeuse();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Postespointeuses', 'entite_cle' => $Postespointeuses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Postespointeuses->toArray();
        return $data;
    }

}
