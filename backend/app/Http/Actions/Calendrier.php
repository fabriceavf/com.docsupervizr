<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;

class Calendrier
{

    public function dupliquer(Request $request)
    {
//        dd($request->all());
        return $request->all();
    }

}
