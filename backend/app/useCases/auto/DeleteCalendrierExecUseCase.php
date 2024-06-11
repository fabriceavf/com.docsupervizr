<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteCalendrierExecUseCase
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

        $Calendriers = \App\Models\Calendrier::find($data['id']);


        $Calendriers->deleted_at = now();
        $Calendriers->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Calendriers->libelle;
        $newCrudData['type'] = $Calendriers->type;
        $newCrudData['description'] = $Calendriers->description;
        $newCrudData['identifiants_sadge'] = $Calendriers->identifiants_sadge;
        $newCrudData['creat_by'] = $Calendriers->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Calendriers', 'entite_cle' => $Calendriers->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
