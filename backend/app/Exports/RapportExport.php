<?php

namespace App\Exports;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RapportExport implements FromView
{
    private $rapport;
    private $allDate;

    public function __construct($rapport, $allDate)
    {
        $this->rapport = $rapport;
        $this->allDate = $allDate;


    }

    /**
     * @return Application|Factory|View
     */
    public function view(): View
    {


        $view = view('content.rapports', [
            'datas' => $this->rapport,
            'allDate' => $this->allDate
        ]);
        return $view;

    }
}
