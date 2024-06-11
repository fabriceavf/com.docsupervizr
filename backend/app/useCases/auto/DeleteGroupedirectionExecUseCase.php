<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteGroupedirectionExecUseCase
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

        $Groupedirections = \App\Models\Groupedirection::find($data['id']);


        $Groupedirections->deleted_at = now();
        $Groupedirections->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Groupedirections->libelle;
        $newCrudData['creat_by'] = $Groupedirections->creat_by;
        $newCrudData['identifiants_sadge'] = $Groupedirections->identifiants_sadge;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Groupedirections', 'entite_cle' => $Groupedirections->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
