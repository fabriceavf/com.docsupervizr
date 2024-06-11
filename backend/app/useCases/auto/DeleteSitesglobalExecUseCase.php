<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteSitesglobalExecUseCase
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

        $Sitesglobals = \App\Models\Sitesglobal::find($data['id']);


        $Sitesglobals->deleted_at = now();
        $Sitesglobals->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Sitesglobals->libelle;
        $newCrudData['Selectlabel'] = $Sitesglobals->Selectlabel;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Sitesglobals', 'entite_cle' => $Sitesglobals->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
