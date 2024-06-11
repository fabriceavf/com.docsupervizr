<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateLoginExecUseCase
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

        $Logins = new \App\Models\Login();

        if (!empty($data['email'])) {
            $Logins->email = $data['email'];
        }
        if (!empty($data['password'])) {
            $Logins->password = $data['password'];
        }
        if (!empty($data['etat'])) {
            $Logins->etat = $data['etat'];
        }
        if (!empty($data['creat_by'])) {
            $Logins->creat_by = $data['creat_by'];
        }
        $Logins->save();
        $Logins = \App\Models\Login::find($Logins->id);
        $newCrudData = [];
        $newCrudData['email'] = $Logins->email;
        $newCrudData['password'] = $Logins->password;
        $newCrudData['etat'] = $Logins->etat;
        $newCrudData['creat_by'] = $Logins->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Logins', 'entite_cle' => $Logins->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Logins->toArray();
        return $data;
    }

}
