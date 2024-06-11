<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteAnalysespointeuseExecUseCase
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

        $Analysespointeuses = \App\Models\Analysespointeuse::find($data['id']);


        $Analysespointeuses->deleted_at = now();
        $Analysespointeuses->save();
        $newCrudData = [];
        $newCrudData['pointeuses'] = $Analysespointeuses->pointeuses;
        $newCrudData['semaine'] = $Analysespointeuses->semaine;
        $newCrudData['lun'] = $Analysespointeuses->lun;
        $newCrudData['mar'] = $Analysespointeuses->mar;
        $newCrudData['mer'] = $Analysespointeuses->mer;
        $newCrudData['jeu'] = $Analysespointeuses->jeu;
        $newCrudData['ven'] = $Analysespointeuses->ven;
        $newCrudData['sam'] = $Analysespointeuses->sam;
        $newCrudData['dim'] = $Analysespointeuses->dim;
        $newCrudData['identifiants_sadge'] = $Analysespointeuses->identifiants_sadge;
        $newCrudData['creat_by'] = $Analysespointeuses->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Analysespointeuses', 'entite_cle' => $Analysespointeuses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
