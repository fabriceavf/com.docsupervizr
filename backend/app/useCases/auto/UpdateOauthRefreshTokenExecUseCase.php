<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateOauthRefreshTokenExecUseCase
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

        $Oauth_refresh_tokens = \App\Models\OauthRefreshToken::find($data['id']);
        $oldOauth_refresh_tokens = $Oauth_refresh_tokens->replicate();

        $oldCrudData = [];
        $oldCrudData['access_token_id'] = $oldOauth_refresh_tokens->access_token_id;
        $oldCrudData['revoked'] = $oldOauth_refresh_tokens->revoked;
        $oldCrudData['expires_at'] = $oldOauth_refresh_tokens->expires_at;
        $oldCrudData['identifiants_sadge'] = $oldOauth_refresh_tokens->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldOauth_refresh_tokens->creat_by;


        if (!empty($data['access_token_id'])) {
            $Oauth_refresh_tokens->access_token_id = $data['access_token_id'];
        }
        if (!empty($data['revoked'])) {
            $Oauth_refresh_tokens->revoked = $data['revoked'];
        }
        if (!empty($data['expires_at'])) {
            $Oauth_refresh_tokens->expires_at = $data['expires_at'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Oauth_refresh_tokens->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Oauth_refresh_tokens->creat_by = $data['creat_by'];
        }
        $Oauth_refresh_tokens->save();
        $Oauth_refresh_tokens = \App\Models\OauthRefreshToken::find($Oauth_refresh_tokens->id);
        $newCrudData = [];
        $newCrudData['access_token_id'] = $Oauth_refresh_tokens->access_token_id;
        $newCrudData['revoked'] = $Oauth_refresh_tokens->revoked;
        $newCrudData['expires_at'] = $Oauth_refresh_tokens->expires_at;
        $newCrudData['identifiants_sadge'] = $Oauth_refresh_tokens->identifiants_sadge;
        $newCrudData['creat_by'] = $Oauth_refresh_tokens->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Oauth_refresh_tokens', 'entite_cle' => $Oauth_refresh_tokens->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Oauth_refresh_tokens->toArray();
        return $data;
    }

}
