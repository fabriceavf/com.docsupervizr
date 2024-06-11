<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateSitesglobalExecUseCase
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

        $Sitesglobals = new \App\Models\Sitesglobal();

        if (!empty($data['libelle'])) {
            $Sitesglobals->libelle = $data['libelle'];
        }
        if (!empty($data['Selectlabel'])) {
            $Sitesglobals->Selectlabel = $data['Selectlabel'];
        }
        $Sitesglobals->save();
        $Sitesglobals = \App\Models\Sitesglobal::find($Sitesglobals->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Sitesglobals->libelle;
        $newCrudData['Selectlabel'] = $Sitesglobals->Selectlabel;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Sitesglobals', 'entite_cle' => $Sitesglobals->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Sitesglobals->toArray();
        return $data;
    }

}
