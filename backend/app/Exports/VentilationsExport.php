<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VentilationsExport implements WithMultipleSheets
{
    private $rapport;
    private $allDate;

    public function __construct($data)
    {
        $this->data = $data;


    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new VentilationsDetailsExport($this->data->day, 'Ventilations par jour');
        $sheets[] = new VentilationsDetailsExport($this->data->week, 'Ventilations par semaine');
        $sheets[] = new VentilationsDetailsExport($this->data->month, 'Ventilations par mois');

        return $sheets;
        // TODO: Implement sheets() method.
    }
}

