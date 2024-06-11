<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteOauthPersonalAccessClientExecUseCase
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

        $Oauth_personal_access_clients = \App\Models\OauthPersonalAccessClient::find($data['id']);


        $Oauth_personal_access_clients->deleted_at = now();
        $Oauth_personal_access_clients->save();
        $newCrudData = [];
        $newCrudData['client_id'] = $Oauth_personal_access_clients->client_id;
        $newCrudData['identifiants_sadge'] = $Oauth_personal_access_clients->identifiants_sadge;
        $newCrudData['creat_by'] = $Oauth_personal_access_clients->creat_by;
        try {
            $newCrudData['client'] = $Oauth_personal_access_clients->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Oauth_personal_access_clients', 'entite_cle' => $Oauth_personal_access_clients->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
