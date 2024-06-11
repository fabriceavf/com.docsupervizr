<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PermissionsActions
{


    public function addPerm(Request $request)
    {

        DB::table('model_has_permissions')->insert([
            'model_id' => $request->get('user_id'),
            'model_type' => 'user',
            'permission_id' => $request->get('permission_id')
        ]);
        try {

        } catch (Throwable $e) {

        }

    }

    public function deletePerm(Request $request)
    {

        DB::table('model_has_permissions')->where([
            'model_id' => $request->get('user_id'),
            'permission_id' => $request->get('permission_id')
        ])->delete();
        try {

        } catch (Throwable $e) {

        }

    }

}
