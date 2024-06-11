<?php

namespace App\useCases\auto;

class DeleteModelHasPermissionCanUseCase
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
            $can = \App\Helpers\Helpers::can('Editer des model_has_permissions');
        } catch (\Throwable $e) {
        }
        if (is_array($data) && array_key_exists('id', $data)) {
        } else {
            $can = false;
        }


        $data['__can__'] = $can;
        return $data;
    }


}
