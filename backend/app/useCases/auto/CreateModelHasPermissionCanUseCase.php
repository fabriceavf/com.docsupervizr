<?php

namespace App\useCases\auto;

class CreateModelHasPermissionCanUseCase
{
    public static function getInput()
    {
    }

    public static function getOutput()
    {
    }

    public static function exec($data)
    {
        $can = true;
        try {
            $can = \App\Helpers\Helpers::can('Creer des model_has_permissions');
        } catch (\Throwable $e) {
        }
        $data['__can__'] = $can;
        return $data;
    }

}
