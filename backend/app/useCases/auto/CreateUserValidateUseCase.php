<?php

namespace App\useCases\auto;

class CreateUserValidateUseCase
{
    public static function getInput()
    {

    }

    public static function getOutput()
    {

    }

    public static function exec($data)
    {

        $agGrid = new \App\Http\AgGrid('users', \App\Models\User::withoutGlobalScope(\Illuminate\Database\Eloquent\SoftDeletingScope::class));
        $agGrid->setValidator('nom', function ($data, $datas) {
            return is_string($data) ? null : 'Cette donnee est requise';
        });
        $agGrid->setValidator('nom', function ($data, $datas) {
            return !empty($data) ? null : 'Cette donnees est requise';
        });
        $agGrid->setValidator('prenom', function ($data, $datas) {
            return !empty($data) ? null : 'Cette donnees est requise';
        });
        $errors = $agGrid->valideData($data);
        if (count($errors) > 0) {
            $data['__validate'] = true;
        }
        return $data;
    }


}
