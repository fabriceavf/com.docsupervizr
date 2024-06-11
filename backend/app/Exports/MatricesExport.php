<?php

namespace App\Exports;

use App\Http\Pointages;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MatricesExport implements FromView
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
    public function view(): View
    {

        $data = Pointages::getMatrice($this->debut, $this->fin);

//        dd($data);
        $view = view('content.matrices', [
            'datas' => $data
        ]);
        return $view;

    }
}
