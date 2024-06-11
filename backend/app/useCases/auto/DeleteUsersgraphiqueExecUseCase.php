<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteUsersgraphiqueExecUseCase
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

        $Usersgraphiques = \App\Models\Usersgraphique::find($data['id']);


        $Usersgraphiques->deleted_at = now();
        $Usersgraphiques->save();
        $newCrudData = [];
        $newCrudData['user_id'] = $Usersgraphiques->user_id;
        $newCrudData['graphique_id'] = $Usersgraphiques->graphique_id;
        $newCrudData['creat_by'] = $Usersgraphiques->creat_by;
        $newCrudData['identifiants_sadge'] = $Usersgraphiques->identifiants_sadge;
        try {
            $newCrudData['graphique'] = $Usersgraphiques->graphique->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['user'] = $Usersgraphiques->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Usersgraphiques', 'entite_cle' => $Usersgraphiques->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
