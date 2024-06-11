<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTypesventilationExecUseCase
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

        $Typesventilations = new \App\Models\Typesventilation();

        if (!empty($data['libelle'])) {
            $Typesventilations->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Typesventilations->creat_by = $data['creat_by'];
        }
        $Typesventilations->save();
        $Typesventilations = \App\Models\Typesventilation::find($Typesventilations->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Typesventilations->libelle;
        $newCrudData['creat_by'] = $Typesventilations->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Typesventilations', 'entite_cle' => $Typesventilations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typesventilations->toArray();
        return $data;
    }

}
