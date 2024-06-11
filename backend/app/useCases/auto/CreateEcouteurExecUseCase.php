<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateEcouteurExecUseCase
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

        $Ecouteurs = new \App\Models\Ecouteur();

        if (!empty($data['avant'])) {
            $Ecouteurs->avant = $data['avant'];
        }
        if (!empty($data['apres'])) {
            $Ecouteurs->apres = $data['apres'];
        }
        if (!empty($data['attribut'])) {
            $Ecouteurs->attribut = $data['attribut'];
        }
        if (!empty($data['agent_id'])) {
            $Ecouteurs->agent_id = $data['agent_id'];
        }
        if (!empty($data['user_id'])) {
            $Ecouteurs->user_id = $data['user_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Ecouteurs->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Ecouteurs->creat_by = $data['creat_by'];
        }
        $Ecouteurs->save();
        $Ecouteurs = \App\Models\Ecouteur::find($Ecouteurs->id);
        $newCrudData = [];
        $newCrudData['avant'] = $Ecouteurs->avant;
        $newCrudData['apres'] = $Ecouteurs->apres;
        $newCrudData['attribut'] = $Ecouteurs->attribut;
        $newCrudData['agent_id'] = $Ecouteurs->agent_id;
        $newCrudData['user_id'] = $Ecouteurs->user_id;
        $newCrudData['identifiants_sadge'] = $Ecouteurs->identifiants_sadge;
        $newCrudData['creat_by'] = $Ecouteurs->creat_by;
        try {
            $newCrudData['user'] = $Ecouteurs->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Ecouteurs', 'entite_cle' => $Ecouteurs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Ecouteurs->toArray();
        return $data;
    }

}
