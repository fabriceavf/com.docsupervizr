<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteHomeExecUseCase
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

        $Homes = \App\Models\Home::find($data['id']);


        $Homes->deleted_at = now();
        $Homes->save();
        $newCrudData = [];
        $newCrudData['user'] = $Homes->user;
        $newCrudData['etat'] = $Homes->etat;
        $newCrudData['creat_by'] = $Homes->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Homes', 'entite_cle' => $Homes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
