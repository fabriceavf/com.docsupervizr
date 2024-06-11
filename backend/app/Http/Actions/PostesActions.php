<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class PostesActions
{


    public function getCouvertureStats(Request $request)
    {


        foreach (DB::table('zones')->cursor() as $zone) {
            foreach (DB::table('postes')->where('zone_id', $zone->id)->cursor() as $poste) {
                dd($poste);
            }
            dd($zone);
        }
        $obj = new stdClass();
        $obj->connu = $data;
        $obj->inconnu = $data2;
        return $obj;


    }

}
