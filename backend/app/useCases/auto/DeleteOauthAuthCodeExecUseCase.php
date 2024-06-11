<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteOauthAuthCodeExecUseCase
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


        $Oauth_auth_codes->deleted_at = now();
        $Oauth_auth_codes->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Oauth_auth_codes', 'entite_cle' => $Oauth_auth_codes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
