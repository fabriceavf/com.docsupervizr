<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateEntrepriseExecUseCase
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

        $Entreprises = new \App\Models\Entreprise();

        if (!empty($data['nom'])) {
            $Entreprises->nom = $data['nom'];
        }
        if (!empty($data['menu'])) {
            $Entreprises->menu = $data['menu'];
        }
        if (!empty($data['host'])) {
            $Entreprises->host = $data['host'];
        }
        if (!empty($data['icon'])) {
            $Entreprises->icon = $data['icon'];
        }
        if (!empty($data['favicon'])) {
            $Entreprises->favicon = $data['favicon'];
        }
        if (!empty($data['status'])) {
            $Entreprises->status = $data['status'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Entreprises->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Entreprises->creat_by = $data['creat_by'];
        }
        if (!empty($data['db_host'])) {
            $Entreprises->db_host = $data['db_host'];
        }
        if (!empty($data['db_user'])) {
            $Entreprises->db_user = $data['db_user'];
        }
        if (!empty($data['db_pass'])) {
            $Entreprises->db_pass = $data['db_pass'];
        }
        if (!empty($data['badge_avant'])) {
            $Entreprises->badge_avant = $data['badge_avant'];
        }
        if (!empty($data['badge_arriere'])) {
            $Entreprises->badge_arriere = $data['badge_arriere'];
        }
        if (!empty($data['modules'])) {
            $Entreprises->modules = $data['modules'];
        }
        if (!empty($data['filemodules'])) {
            $Entreprises->filemodules = $data['filemodules'];
        }
        $Entreprises->save();
        $Entreprises = \App\Models\Entreprise::find($Entreprises->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Entreprises', 'entite_cle' => $Entreprises->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Entreprises->toArray();
        return $data;
    }

}
