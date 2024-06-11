<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteOauthClientExecUseCase
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

        $Oauth_clients = \App\Models\OauthClient::find($data['id']);


        $Oauth_clients->deleted_at = now();
        $Oauth_clients->save();
        $newCrudData = [];
        $newCrudData['user_id'] = $Oauth_clients->user_id;
        $newCrudData['name'] = $Oauth_clients->name;
        $newCrudData['secret'] = $Oauth_clients->secret;
        $newCrudData['provider'] = $Oauth_clients->provider;
        $newCrudData['redirect'] = $Oauth_clients->redirect;
        $newCrudData['personal_access_client'] = $Oauth_clients->personal_access_client;
        $newCrudData['password_client'] = $Oauth_clients->password_client;
        $newCrudData['revoked'] = $Oauth_clients->revoked;
        $newCrudData['identifiants_sadge'] = $Oauth_clients->identifiants_sadge;
        $newCrudData['creat_by'] = $Oauth_clients->creat_by;
        try {
            $newCrudData['user'] = $Oauth_clients->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Oauth_clients', 'entite_cle' => $Oauth_clients->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
