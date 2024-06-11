<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateContratsclientExecUseCase
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

        $Contratsclients = \App\Models\Contratsclient::find($data['id']);
        $oldContratsclients = $Contratsclients->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldContratsclients->libelle;
        $oldCrudData['description'] = $oldContratsclients->description;
        $oldCrudData['client_id'] = $oldContratsclients->client_id;
        $oldCrudData['AllSites'] = $oldContratsclients->AllSites;
        $oldCrudData['identifiants_sadge'] = $oldContratsclients->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldContratsclients->creat_by;
        try {
            $oldCrudData['client'] = $oldContratsclients->client->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['libelle'])) {
            $Contratsclients->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Contratsclients->description = $data['description'];
        }
        if (!empty($data['client_id'])) {
            $Contratsclients->client_id = $data['client_id'];
        }
        if (!empty($data['AllSites'])) {
            $Contratsclients->AllSites = $data['AllSites'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Contratsclients->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Contratsclients->creat_by = $data['creat_by'];
        }
        $Contratsclients->save();
        $Contratsclients = \App\Models\Contratsclient::find($Contratsclients->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Contratsclients->libelle;
        $newCrudData['description'] = $Contratsclients->description;
        $newCrudData['client_id'] = $Contratsclients->client_id;
        $newCrudData['AllSites'] = $Contratsclients->AllSites;
        $newCrudData['identifiants_sadge'] = $Contratsclients->identifiants_sadge;
        $newCrudData['creat_by'] = $Contratsclients->creat_by;
        try {
            $newCrudData['client'] = $Contratsclients->client->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Contratsclients', 'entite_cle' => $Contratsclients->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Contratsclients->toArray();
        return $data;
    }

}
