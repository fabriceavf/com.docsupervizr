<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateOauthClientExecUseCase
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
        $oldOauth_clients = $Oauth_clients->replicate();

        $oldCrudData = [];
        $oldCrudData['user_id'] = $oldOauth_clients->user_id;
        $oldCrudData['name'] = $oldOauth_clients->name;
        $oldCrudData['secret'] = $oldOauth_clients->secret;
        $oldCrudData['provider'] = $oldOauth_clients->provider;
        $oldCrudData['redirect'] = $oldOauth_clients->redirect;
        $oldCrudData['personal_access_client'] = $oldOauth_clients->personal_access_client;
        $oldCrudData['password_client'] = $oldOauth_clients->password_client;
        $oldCrudData['revoked'] = $oldOauth_clients->revoked;
        $oldCrudData['identifiants_sadge'] = $oldOauth_clients->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldOauth_clients->creat_by;
        try {
            $oldCrudData['user'] = $oldOauth_clients->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['user_id'])) {
            $Oauth_clients->user_id = $data['user_id'];
        }
        if (!empty($data['name'])) {
            $Oauth_clients->name = $data['name'];
        }
        if (!empty($data['secret'])) {
            $Oauth_clients->secret = $data['secret'];
        }
        if (!empty($data['provider'])) {
            $Oauth_clients->provider = $data['provider'];
        }
        if (!empty($data['redirect'])) {
            $Oauth_clients->redirect = $data['redirect'];
        }
        if (!empty($data['personal_access_client'])) {
            $Oauth_clients->personal_access_client = $data['personal_access_client'];
        }
        if (!empty($data['password_client'])) {
            $Oauth_clients->password_client = $data['password_client'];
        }
        if (!empty($data['revoked'])) {
            $Oauth_clients->revoked = $data['revoked'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Oauth_clients->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Oauth_clients->creat_by = $data['creat_by'];
        }
        $Oauth_clients->save();
        $Oauth_clients = \App\Models\OauthClient::find($Oauth_clients->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Oauth_clients', 'entite_cle' => $Oauth_clients->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Oauth_clients->toArray();
        return $data;
    }

}
