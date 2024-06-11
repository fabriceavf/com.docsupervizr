<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateSupervirzclientExecUseCase
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

        $Supervirzclients = new \App\Models\Supervirzclient();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Supervirzclients', 'entite_cle' => $Supervirzclients->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Supervirzclients->toArray();
        return $data;
    }

}
