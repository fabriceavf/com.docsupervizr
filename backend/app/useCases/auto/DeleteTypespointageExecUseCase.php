<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypespointageExecUseCase
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

        $Typespointages = \App\Models\Typespointage::find($data['id']);


        $Typespointages->deleted_at = now();
        $Typespointages->save();
        $newCrudData = [];
        $newCrudData['code'] = $Typespointages->code;
        $newCrudData['libelle'] = $Typespointages->libelle;
        $newCrudData['creat_by'] = $Typespointages->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typespointages', 'entite_cle' => $Typespointages->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
