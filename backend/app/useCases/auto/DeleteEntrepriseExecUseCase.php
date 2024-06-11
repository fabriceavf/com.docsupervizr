<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteEntrepriseExecUseCase
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

        $Entreprises = \App\Models\Entreprise::find($data['id']);


        $Entreprises->deleted_at = now();
        $Entreprises->save();
        $newCrudData = [];
        $newCrudData['nom'] = $Entreprises->nom;
        $newCrudData['menu'] = $Entreprises->menu;
        $newCrudData['host'] = $Entreprises->host;
        $newCrudData['icon'] = $Entreprises->icon;
        $newCrudData['favicon'] = $Entreprises->favicon;
        $newCrudData['status'] = $Entreprises->status;
        $newCrudData['identifiants_sadge'] = $Entreprises->identifiants_sadge;
        $newCrudData['creat_by'] = $Entreprises->creat_by;
        $newCrudData['db_host'] = $Entreprises->db_host;
        $newCrudData['db_user'] = $Entreprises->db_user;
        $newCrudData['db_pass'] = $Entreprises->db_pass;
        $newCrudData['badge_avant'] = $Entreprises->badge_avant;
        $newCrudData['badge_arriere'] = $Entreprises->badge_arriere;
        $newCrudData['modules'] = $Entreprises->modules;
        $newCrudData['filemodules'] = $Entreprises->filemodules;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Entreprises', 'entite_cle' => $Entreprises->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
