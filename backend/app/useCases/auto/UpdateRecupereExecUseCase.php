<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateRecupereExecUseCase
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

        $Recuperes = \App\Models\Recupere::find($data['id']);
        $oldRecuperes = $Recuperes->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldRecuperes->libelle;
        $oldCrudData['identifiants_sadge'] = $oldRecuperes->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldRecuperes->creat_by;


        if (!empty($data['libelle'])) {
            $Recuperes->libelle = $data['libelle'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Recuperes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Recuperes->creat_by = $data['creat_by'];
        }
        $Recuperes->save();
        $Recuperes = \App\Models\Recupere::find($Recuperes->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Recuperes->libelle;
        $newCrudData['identifiants_sadge'] = $Recuperes->identifiants_sadge;
        $newCrudData['creat_by'] = $Recuperes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Recuperes', 'entite_cle' => $Recuperes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Recuperes->toArray();
        return $data;
    }

}
