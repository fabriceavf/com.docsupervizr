<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateBaliseExecUseCase
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

        $Balises = new \App\Models\Balise();

        if (!empty($data['imei'])) {
            $Balises->imei = $data['imei'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Balises->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Balises->creat_by = $data['creat_by'];
        }
        if (!empty($data['libelle'])) {
            $Balises->libelle = $data['libelle'];
        }
        if (!empty($data['ref'])) {
            $Balises->ref = $data['ref'];
        }
        $Balises->save();
        $Balises = \App\Models\Balise::find($Balises->id);
        $newCrudData = [];
        $newCrudData['imei'] = $Balises->imei;
        $newCrudData['identifiants_sadge'] = $Balises->identifiants_sadge;
        $newCrudData['creat_by'] = $Balises->creat_by;
        $newCrudData['libelle'] = $Balises->libelle;
        $newCrudData['ref'] = $Balises->ref;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Balises', 'entite_cle' => $Balises->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Balises->toArray();
        return $data;
    }

}
