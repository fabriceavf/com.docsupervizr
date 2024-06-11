<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateClientExecUseCase
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

        $Clients = \App\Models\Client::find($data['id']);
        $oldClients = $Clients->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldClients->code;
        $oldCrudData['libelle'] = $oldClients->libelle;
        $oldCrudData['type'] = $oldClients->type;
        $oldCrudData['identifiants_sadge'] = $oldClients->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldClients->creat_by;


        if (!empty($data['code'])) {
            $Clients->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Clients->libelle = $data['libelle'];
        }
        if (!empty($data['type'])) {
            $Clients->type = $data['type'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Clients->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Clients->creat_by = $data['creat_by'];
        }
        $Clients->save();
        $Clients = \App\Models\Client::find($Clients->id);
        $newCrudData = [];
        $newCrudData['code'] = $Clients->code;
        $newCrudData['libelle'] = $Clients->libelle;
        $newCrudData['type'] = $Clients->type;
        $newCrudData['identifiants_sadge'] = $Clients->identifiants_sadge;
        $newCrudData['creat_by'] = $Clients->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Clients', 'entite_cle' => $Clients->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Clients->toArray();
        return $data;
    }

}
