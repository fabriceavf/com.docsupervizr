<?php

namespace App\Http\Actions;

use App\Models\Poste;
use Illuminate\Http\Request;

class PostespointeusesActions
{


    public function detach(Request $request)
    {
        //    dd($request->all());
        $poste = Poste::find($request->get('poste_id'));
        $poste->pointeuses()->detach($request->get('pointeuse_id'));
    }

}
