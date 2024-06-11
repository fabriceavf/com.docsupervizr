<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreatePostesarticleExecUseCase
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

        $Postesarticles = new \App\Models\Postesarticle();

        if (!empty($data['code'])) {
            $Postesarticles->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Postesarticles->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Postesarticles->creat_by = $data['creat_by'];
        }
        $Postesarticles->save();
        $Postesarticles = \App\Models\Postesarticle::find($Postesarticles->id);
        $newCrudData = [];
        $newCrudData['code'] = $Postesarticles->code;
        $newCrudData['libelle'] = $Postesarticles->libelle;
        $newCrudData['creat_by'] = $Postesarticles->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Postesarticles', 'entite_cle' => $Postesarticles->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Postesarticles->toArray();
        return $data;
    }

}
