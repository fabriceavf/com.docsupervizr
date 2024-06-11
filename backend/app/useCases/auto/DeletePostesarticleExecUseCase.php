<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePostesarticleExecUseCase
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

        $Postesarticles = \App\Models\Postesarticle::find($data['id']);


        $Postesarticles->deleted_at = now();
        $Postesarticles->save();
        $newCrudData = [];
        $newCrudData['code'] = $Postesarticles->code;
        $newCrudData['libelle'] = $Postesarticles->libelle;
        $newCrudData['creat_by'] = $Postesarticles->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Postesarticles', 'entite_cle' => $Postesarticles->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
