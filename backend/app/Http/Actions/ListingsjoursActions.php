<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListingsjoursActions
{
    public function getStats(Request $request)
    {
        $abscent = 0;
        $present = 0;
        if ($request->has('id')) {
            $abscent = DB::table('listingsetats')->where([
                'listingsjour_id' => $request->get('id'),
                'present' => 'non',
            ])->count('id');
            $present = DB::table('listingsetats')->where([
                'listingsjour_id' => $request->get('id'),
                'present' => 'oui',
            ])->count('id');
        }


        $response['present'] = $present;
        $response['abscent'] = $abscent;


        return $response;
    }

}
