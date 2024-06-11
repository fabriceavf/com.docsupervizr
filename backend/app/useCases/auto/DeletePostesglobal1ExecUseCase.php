<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePostesglobal1ExecUseCase
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

        $Postesglobals_1 = \App\Models\Postesglobal1::find($data['id']);


        $Postesglobals_1->deleted_at = now();
        $Postesglobals_1->save();
        $newCrudData = [];
        $newCrudData['COL 1'] = $Postesglobals_1->COL 1;
    $newCrudData['identifiants_sadge'] = $Postesglobals_1->identifiants_sadge;
    $newCrudData['creat_by'] = $Postesglobals_1->creat_by;
DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Postesglobals_1', 'entite_cle' => $Postesglobals_1->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
$data['__result__'] = true;
return $data;
}

}
