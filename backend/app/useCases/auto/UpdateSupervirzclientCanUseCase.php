<?php

namespace App\useCases\auto;

class UpdateSupervirzclientCanUseCase
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
            $can = \App\Helpers\Helpers::can('Editer des supervirzclients');
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
