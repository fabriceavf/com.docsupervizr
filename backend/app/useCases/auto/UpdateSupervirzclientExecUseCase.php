<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateSupervirzclientExecUseCase
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

        $Supervirzclients = \App\Models\Supervirzclient::find($data['id']);
        $oldSupervirzclients = $Supervirzclients->replicate();

        $oldCrudData = [];
        $oldCrudData['nom'] = $oldSupervirzclients->nom;
        $oldCrudData['domaine'] = $oldSupervirzclients->domaine;
        $oldCrudData['path'] = $oldSupervirzclients->path;
        $oldCrudData['db_connection'] = $oldSupervirzclients->db_connection;
        $oldCrudData['db_host'] = $oldSupervirzclients->db_host;
        $oldCrudData['db_port'] = $oldSupervirzclients->db_port;
        $oldCrudData['db_database'] = $oldSupervirzclients->db_database;
        $oldCrudData['db_username'] = $oldSupervirzclients->db_username;
        $oldCrudData['db_password'] = $oldSupervirzclients->db_password;
        $oldCrudData['identifiants_sadge'] = $oldSupervirzclients->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldSupervirzclients->creat_by;


        if (!empty($data['nom'])) {
            $Supervirzclients->nom = $data['nom'];
        }
        if (!empty($data['domaine'])) {
            $Supervirzclients->domaine = $data['domaine'];
        }
        if (!empty($data['path'])) {
            $Supervirzclients->path = $data['path'];
        }
        if (!empty($data['db_connection'])) {
            $Supervirzclients->db_connection = $data['db_connection'];
        }
        if (!empty($data['db_host'])) {
            $Supervirzclients->db_host = $data['db_host'];
        }
        if (!empty($data['db_port'])) {
            $Supervirzclients->db_port = $data['db_port'];
        }
        if (!empty($data['db_database'])) {
            $Supervirzclients->db_database = $data['db_database'];
        }
        if (!empty($data['db_username'])) {
            $Supervirzclients->db_username = $data['db_username'];
        }
        if (!empty($data['db_password'])) {
            $Supervirzclients->db_password = $data['db_password'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Supervirzclients->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Supervirzclients->creat_by = $data['creat_by'];
        }
        $Supervirzclients->save();
        $Supervirzclients = \App\Models\Supervirzclient::find($Supervirzclients->id);
        $newCrudData = [];
        $newCrudData['nom'] = $Supervirzclients->nom;
        $newCrudData['domaine'] = $Supervirzclients->domaine;
        $newCrudData['path'] = $Supervirzclients->path;
        $newCrudData['db_connection'] = $Supervirzclients->db_connection;
        $newCrudData['db_host'] = $Supervirzclients->db_host;
        $newCrudData['db_port'] = $Supervirzclients->db_port;
        $newCrudData['db_database'] = $Supervirzclients->db_database;
        $newCrudData['db_username'] = $Supervirzclients->db_username;
        $newCrudData['db_password'] = $Supervirzclients->db_password;
        $newCrudData['identifiants_sadge'] = $Supervirzclients->identifiants_sadge;
        $newCrudData['creat_by'] = $Supervirzclients->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Supervirzclients', 'entite_cle' => $Supervirzclients->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Supervirzclients->toArray();
        return $data;
    }

}
