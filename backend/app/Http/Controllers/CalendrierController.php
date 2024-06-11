<?php

namespace App\Http\Controllers;

use App\Models\Calendrier;

class CalendrierController extends Controller
{
    public function index()
    {
        return response()
            ->json($Table = Calendrier::all());
    }
}
