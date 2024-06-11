<?php

namespace App\useCases\auto;

class UpdateApprovisionementdetailValidateUseCase
{
    public static function getInput()
    {

    }

    public static function getOutput()
    {

    }

    public static function exec($data)
    {

        $agGrid = new \App\Http\AgGrid('approvisionementdetails', \App\Models\Approvisionementdetail::withoutGlobalScope(\Illuminate\Database\Eloquent\SoftDeletingScope::class));
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
