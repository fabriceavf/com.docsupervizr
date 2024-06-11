<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateGraphiqueExecUseCase
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

        $Graphiques = new \App\Models\Graphique();

        if (!empty($data['code'])) {
            $Graphiques->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Graphiques->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Graphiques->creat_by = $data['creat_by'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Graphiques->identifiants_sadge = $data['identifiants_sadge'];
        }
        $Graphiques->save();
        $Graphiques = \App\Models\Graphique::find($Graphiques->id);
        $newCrudData = [];
        $newCrudData['code'] = $Graphiques->code;
        $newCrudData['libelle'] = $Graphiques->libelle;
        $newCrudData['creat_by'] = $Graphiques->creat_by;
        $newCrudData['identifiants_sadge'] = $Graphiques->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Graphiques', 'entite_cle' => $Graphiques->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Graphiques->toArray();
        return $data;
    }

}
