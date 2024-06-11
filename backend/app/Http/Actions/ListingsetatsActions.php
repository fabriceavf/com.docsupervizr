<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ListingsetatsActions
{
    public function presence(Request $request)
    {
//        dd($request->all());
        DB::table('listingsetats')->updateOrInsert(
            [
                'user_id' => $request->get('user_id'),
                'listingsjour_id' => $request->get('date_id'),
            ],
            [
                'present' => $request->get('presence')
            ]
        );
    }

    public function deleteUser(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->get('id');
            $id = explode('-', $id);
            try {
                DB::table('listingsetats')->where([
                    'user_id' => intval($id[0]),
                    'listingsjour_id' => intval($id[1]),
                ])->delete();
            } catch (Throwable $e) {

            }


        }

//        dd($request->all());
    }

    public function addUser(Request $request)
    {

        if ($request->has('user_id') && $request->has('listingsjour_id')) {
            $user_id = $request->get('user_id');
            $listingsjour_id = $request->get('listingsjour_id');
            DB::table('listingsetats')->updateOrInsert([
                'user_id' => intval($user_id),
                'listingsjour_id' => intval($listingsjour_id),
            ]);
            try {
            } catch (Throwable $e) {

            }


        }

//        dd($request->all());
    }

}
