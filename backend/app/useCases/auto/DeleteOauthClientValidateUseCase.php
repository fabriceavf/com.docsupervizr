<?php

namespace App\useCases\auto;

class DeleteOauthClientValidateUseCase
{
    public static function getInput()
    {

    }

    public static function getOutput()
    {

    }

    public static function exec($data)
    {

        $agGrid = new \App\Http\AgGrid('oauth_clients', \App\Models\OauthClient::withoutGlobalScope(\Illuminate\Database\Eloquent\SoftDeletingScope::class));
        $agGrid->setValidator('nom', function ($data, $datas) {
            return is_string($data) ? null : 'Cette donnee est requise';
        });
        $errors = $agGrid->valideData($data);
        if (count($errors) > 0) {
            $data['__validate'] = true;
        }
        return $data;
    }


}
