<?php

namespace App\Exports;

use App\Models\Conge;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CongesExport implements FromView
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
        $data = Conge::all();

//        dd($data);
        $view = view('content.conges', [
            'datas' => $data
        ]);
        return $view;

    }
}
