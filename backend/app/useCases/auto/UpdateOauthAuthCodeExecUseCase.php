<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateOauthAuthCodeExecUseCase
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

        $Oauth_auth_codes = \App\Models\OauthAuthCode::find($data['id']);
        $oldOauth_auth_codes = $Oauth_auth_codes->replicate();

        $oldCrudData = [];
        $oldCrudData['user_id'] = $oldOauth_auth_codes->user_id;
        $oldCrudData['client_id'] = $oldOauth_auth_codes->client_id;
        $oldCrudData['scopes'] = $oldOauth_auth_codes->scopes;
        $oldCrudData['revoked'] = $oldOauth_auth_codes->revoked;
        $oldCrudData['expires_at'] = $oldOauth_auth_codes->expires_at;
        $oldCrudData['identifiants_sadge'] = $oldOauth_auth_codes->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldOauth_auth_codes->creat_by;
        try {
            $oldCrudData['client'] = $oldOauth_auth_codes->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['user'] = $oldOauth_auth_codes->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['user_id'])) {
            $Oauth_auth_codes->user_id = $data['user_id'];
        }
        if (!empty($data['client_id'])) {
            $Oauth_auth_codes->client_id = $data['client_id'];
        }
        if (!empty($data['scopes'])) {
            $Oauth_auth_codes->scopes = $data['scopes'];
        }
        if (!empty($data['revoked'])) {
            $Oauth_auth_codes->revoked = $data['revoked'];
        }
        if (!empty($data['expires_at'])) {
            $Oauth_auth_codes->expires_at = $data['expires_at'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Oauth_auth_codes->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Oauth_auth_codes->creat_by = $data['creat_by'];
        }
        $Oauth_auth_codes->save();
        $Oauth_auth_codes = \App\Models\OauthAuthCode::find($Oauth_auth_codes->id);
        $newCrudData = [];
        $newCrudData['user_id'] = $Oauth_auth_codes->user_id;
        $newCrudData['client_id'] = $Oauth_auth_codes->client_id;
        $newCrudData['scopes'] = $Oauth_auth_codes->scopes;
        $newCrudData['revoked'] = $Oauth_auth_codes->revoked;
        $newCrudData['expires_at'] = $Oauth_auth_codes->expires_at;
        $newCrudData['identifiants_sadge'] = $Oauth_auth_codes->identifiants_sadge;
        $newCrudData['creat_by'] = $Oauth_auth_codes->creat_by;
        try {
            $newCrudData['client'] = $Oauth_auth_codes->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Oauth_auth_codes->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Oauth_auth_codes', 'entite_cle' => $Oauth_auth_codes->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Oauth_auth_codes->toArray();
        return $data;
    }

}
