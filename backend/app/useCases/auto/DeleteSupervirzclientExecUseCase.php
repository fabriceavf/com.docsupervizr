<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteSupervirzclientExecUseCase
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


        $Supervirzclients->deleted_at = now();
        $Supervirzclients->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Supervirzclients', 'entite_cle' => $Supervirzclients->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
