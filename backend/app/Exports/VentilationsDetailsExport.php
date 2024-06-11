<?php

namespace App\Exports;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class VentilationsDetailsExport implements FromCollection, WithHeadings, WithTitle
{
    private $data;
    private $type;

    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;


    }

    public function headings(): array
    {
        return array_keys($this->data->first());
    }

    /**
     * @return Application|Factory|View
     */
    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return $this->type;
    }
}
