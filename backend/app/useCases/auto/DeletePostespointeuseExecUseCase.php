<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePostespointeuseExecUseCase
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


        $Postespointeuses->deleted_at = now();
        $Postespointeuses->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Postespointeuses', 'entite_cle' => $Postespointeuses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
