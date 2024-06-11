<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteOauthAccessTokenExecUseCase
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

        $Oauth_access_tokens = \App\Models\OauthAccessToken::find($data['id']);


        $Oauth_access_tokens->deleted_at = now();
        $Oauth_access_tokens->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Oauth_access_tokens', 'entite_cle' => $Oauth_access_tokens->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
