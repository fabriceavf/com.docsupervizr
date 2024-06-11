<?php

namespace App\Exports;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MatricesFilesExport implements WithMultipleSheets
{
    private $debut;
    private $fin;

    public function __construct($debut, $fin)
    {
        $this->debut = $debut;
        $this->fin = $fin;


    }

    /**
     * @return Application|Factory|View
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets['matrices'] = new MatricesExport($this->debut, $this->fin);
        $sheets['matrices2'] = new CongesExport($this->debut, $this->fin);


        return $sheets;
    }

}
