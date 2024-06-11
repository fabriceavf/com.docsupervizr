<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTypeinterventionExecUseCase
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

        $Typeinterventions = new \App\Models\Typeintervention();

        if (!empty($data['libelle'])) {
            $Typeinterventions->libelle = $data['libelle'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Typeinterventions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Typeinterventions->creat_by = $data['creat_by'];
        }
        $Typeinterventions->save();
        $Typeinterventions = \App\Models\Typeintervention::find($Typeinterventions->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Typeinterventions->libelle;
        $newCrudData['identifiants_sadge'] = $Typeinterventions->identifiants_sadge;
        $newCrudData['creat_by'] = $Typeinterventions->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Typeinterventions', 'entite_cle' => $Typeinterventions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typeinterventions->toArray();
        return $data;
    }

}
