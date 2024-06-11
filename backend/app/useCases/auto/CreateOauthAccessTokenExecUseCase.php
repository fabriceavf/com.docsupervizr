<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateOauthAccessTokenExecUseCase
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

        $Oauth_access_tokens = new \App\Models\OauthAccessToken();

        if (!empty($data['user_id'])) {
            $Oauth_access_tokens->user_id = $data['user_id'];
        }
        if (!empty($data['client_id'])) {
            $Oauth_access_tokens->client_id = $data['client_id'];
        }
        if (!empty($data['name'])) {
            $Oauth_access_tokens->name = $data['name'];
        }
        if (!empty($data['scopes'])) {
            $Oauth_access_tokens->scopes = $data['scopes'];
        }
        if (!empty($data['revoked'])) {
            $Oauth_access_tokens->revoked = $data['revoked'];
        }
        if (!empty($data['expires_at'])) {
            $Oauth_access_tokens->expires_at = $data['expires_at'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Oauth_access_tokens->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Oauth_access_tokens->creat_by = $data['creat_by'];
        }
        $Oauth_access_tokens->save();
        $Oauth_access_tokens = \App\Models\OauthAccessToken::find($Oauth_access_tokens->id);
        $newCrudData = [];
        $newCrudData['user_id'] = $Oauth_access_tokens->user_id;
        $newCrudData['client_id'] = $Oauth_access_tokens->client_id;
        $newCrudData['name'] = $Oauth_access_tokens->name;
        $newCrudData['scopes'] = $Oauth_access_tokens->scopes;
        $newCrudData['revoked'] = $Oauth_access_tokens->revoked;
        $newCrudData['expires_at'] = $Oauth_access_tokens->expires_at;
        $newCrudData['identifiants_sadge'] = $Oauth_access_tokens->identifiants_sadge;
        $newCrudData['creat_by'] = $Oauth_access_tokens->creat_by;
        try {
            $newCrudData['client'] = $Oauth_access_tokens->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Oauth_access_tokens->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Oauth_access_tokens', 'entite_cle' => $Oauth_access_tokens->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Oauth_access_tokens->toArray();
        return $data;
    }

}
