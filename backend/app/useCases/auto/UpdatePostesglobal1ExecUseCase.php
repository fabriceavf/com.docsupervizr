<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePostesglobal1ExecUseCase
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
        $oldPostesglobals_1 = $Postesglobals_1->replicate();

        $oldCrudData = [];
        $oldCrudData['COL 1'] = $oldPostesglobals_1->COL 1;
                        $oldCrudData['identifiants_sadge'] = $oldPostesglobals_1->identifiants_sadge;
                $oldCrudData['creat_by'] = $oldPostesglobals_1->creat_by;


if (!empty($data['COL 1'])) {
    $Postesglobals_1->COL 1 = $data['COL 1'];
}
if (!empty($data['identifiants_sadge'])) {
    $Postesglobals_1->identifiants_sadge = $data['identifiants_sadge'];
}
if (!empty($data['creat_by'])) {
    $Postesglobals_1->creat_by = $data['creat_by'];
}
$Postesglobals_1->save();
$Postesglobals_1 = \App\Models\Postesglobal1::find($Postesglobals_1->id);
$newCrudData = [];
    $newCrudData['COL 1'] = $Postesglobals_1->COL 1;
    $newCrudData['identifiants_sadge'] = $Postesglobals_1->identifiants_sadge;
    $newCrudData['creat_by'] = $Postesglobals_1->creat_by;
DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Postesglobals_1', 'entite_cle' => $Postesglobals_1->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
$data['__result__'] = $Postesglobals_1->toArray();
return $data;
}

}
