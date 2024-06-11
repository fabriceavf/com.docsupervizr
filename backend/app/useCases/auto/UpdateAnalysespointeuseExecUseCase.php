<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateAnalysespointeuseExecUseCase
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
        $oldAnalysespointeuses = $Analysespointeuses->replicate();

        $oldCrudData = [];
        $oldCrudData['pointeuses'] = $oldAnalysespointeuses->pointeuses;
        $oldCrudData['semaine'] = $oldAnalysespointeuses->semaine;
        $oldCrudData['lun'] = $oldAnalysespointeuses->lun;
        $oldCrudData['mar'] = $oldAnalysespointeuses->mar;
        $oldCrudData['mer'] = $oldAnalysespointeuses->mer;
        $oldCrudData['jeu'] = $oldAnalysespointeuses->jeu;
        $oldCrudData['ven'] = $oldAnalysespointeuses->ven;
        $oldCrudData['sam'] = $oldAnalysespointeuses->sam;
        $oldCrudData['dim'] = $oldAnalysespointeuses->dim;
        $oldCrudData['identifiants_sadge'] = $oldAnalysespointeuses->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldAnalysespointeuses->creat_by;


        if (!empty($data['pointeuses'])) {
            $Analysespointeuses->pointeuses = $data['pointeuses'];
        }
        if (!empty($data['semaine'])) {
            $Analysespointeuses->semaine = $data['semaine'];
        }
        if (!empty($data['lun'])) {
            $Analysespointeuses->lun = $data['lun'];
        }
        if (!empty($data['mar'])) {
            $Analysespointeuses->mar = $data['mar'];
        }
        if (!empty($data['mer'])) {
            $Analysespointeuses->mer = $data['mer'];
        }
        if (!empty($data['jeu'])) {
            $Analysespointeuses->jeu = $data['jeu'];
        }
        if (!empty($data['ven'])) {
            $Analysespointeuses->ven = $data['ven'];
        }
        if (!empty($data['sam'])) {
            $Analysespointeuses->sam = $data['sam'];
        }
        if (!empty($data['dim'])) {
            $Analysespointeuses->dim = $data['dim'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Analysespointeuses->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Analysespointeuses->creat_by = $data['creat_by'];
        }
        $Analysespointeuses->save();
        $Analysespointeuses = \App\Models\Analysespointeuse::find($Analysespointeuses->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Analysespointeuses', 'entite_cle' => $Analysespointeuses->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Analysespointeuses->toArray();
        return $data;
    }

}
