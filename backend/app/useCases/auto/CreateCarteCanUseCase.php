<?php

namespace App\useCases\auto;

class CreateCarteCanUseCase
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
            $can = \App\Helpers\Helpers::can('Creer des cartes');
        } catch (\Throwable $e) {
        }
        $data['__can__'] = $can;
        return $data;
    }

}
