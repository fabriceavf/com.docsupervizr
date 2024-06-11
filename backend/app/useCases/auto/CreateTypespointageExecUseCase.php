<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTypespointageExecUseCase
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

        $Typespointages = new \App\Models\Typespointage();

        if (!empty($data['code'])) {
            $Typespointages->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Typespointages->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Typespointages->creat_by = $data['creat_by'];
        }
        $Typespointages->save();
        $Typespointages = \App\Models\Typespointage::find($Typespointages->id);
        $newCrudData = [];
        $newCrudData['code'] = $Typespointages->code;
        $newCrudData['libelle'] = $Typespointages->libelle;
        $newCrudData['creat_by'] = $Typespointages->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Typespointages', 'entite_cle' => $Typespointages->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typespointages->toArray();
        return $data;
    }

}
