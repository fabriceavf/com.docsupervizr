<?php

namespace App\useCases\auto;

class AggridCarteCanUseCase
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
            $can = \App\Helpers\Helpers::can('Editer des cartes');
        } catch (\Throwable $e) {
        }


        $data['__can__'] = $can;
        return $data;
    }


}
