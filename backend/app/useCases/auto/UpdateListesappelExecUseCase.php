<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateListesappelExecUseCase
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

        $Listesappels = \App\Models\Listesappel::find($data['id']);
        $oldListesappels = $Listesappels->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldListesappels->libelle;
        $oldCrudData['debut'] = $oldListesappels->debut;
        $oldCrudData['fin'] = $oldListesappels->fin;
        $oldCrudData['etats'] = $oldListesappels->etats;
        $oldCrudData['identifiants_sadge'] = $oldListesappels->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldListesappels->creat_by;


        if (!empty($data['libelle'])) {
            $Listesappels->libelle = $data['libelle'];
        }
        if (!empty($data['debut'])) {
            $Listesappels->debut = $data['debut'];
        }
        if (!empty($data['fin'])) {
            $Listesappels->fin = $data['fin'];
        }
        if (!empty($data['etats'])) {
            $Listesappels->etats = $data['etats'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Listesappels->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Listesappels->creat_by = $data['creat_by'];
        }
        $Listesappels->save();
        $Listesappels = \App\Models\Listesappel::find($Listesappels->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Listesappels->libelle;
        $newCrudData['debut'] = $Listesappels->debut;
        $newCrudData['fin'] = $Listesappels->fin;
        $newCrudData['etats'] = $Listesappels->etats;
        $newCrudData['identifiants_sadge'] = $Listesappels->identifiants_sadge;
        $newCrudData['creat_by'] = $Listesappels->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Listesappels', 'entite_cle' => $Listesappels->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Listesappels->toArray();
        return $data;
    }

}
