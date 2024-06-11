<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteLoginExecUseCase
{
    public static function getInput()
    {

    }

    public static function getOutput()
    {

    }

    public static function exec($data)
    {

        $data['__headers__'] = $request->headers->all();
        $data['__authId__'] = Auth::id();
        $data['__ip__'] = $request->ip();
        $data['creat_by'] = Auth::id();

        $Logins = \App\Models\Login::find($data['id']);


        $Logins->deleted_at = now();
        $Logins->save();
        $newCrudData = [];
        $newCrudData['email'] = $Logins->email;
        $newCrudData['password'] = $Logins->password;
        $newCrudData['etat'] = $Logins->etat;
        $newCrudData['creat_by'] = $Logins->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Logins', 'entite_cle' => $Logins->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
