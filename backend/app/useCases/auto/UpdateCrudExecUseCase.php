<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateCrudExecUseCase
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

        $Cruds = \App\Models\Crud::find($data['id']);
        $oldCruds = $Cruds->replicate();

        $oldCrudData = [];
        $oldCrudData['action'] = $oldCruds->action;
        $oldCrudData['entite'] = $oldCruds->entite;
        $oldCrudData['entite_cle'] = $oldCruds->entite_cle;
        $oldCrudData['ancien'] = $oldCruds->ancien;
        $oldCrudData['nouveau'] = $oldCruds->nouveau;
        $oldCrudData['user_id'] = $oldCruds->user_id;
        $oldCrudData['Detail'] = $oldCruds->Detail;
        $oldCrudData['identifiants_sadge'] = $oldCruds->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldCruds->creat_by;
        try {
            $oldCrudData['user'] = $oldCruds->user->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['action'])) {
            $Cruds->action = $data['action'];
        }
        if (!empty($data['entite'])) {
            $Cruds->entite = $data['entite'];
        }
        if (!empty($data['entite_cle'])) {
            $Cruds->entite_cle = $data['entite_cle'];
        }
        if (!empty($data['ancien'])) {
            $Cruds->ancien = $data['ancien'];
        }
        if (!empty($data['nouveau'])) {
            $Cruds->nouveau = $data['nouveau'];
        }
        if (!empty($data['user_id'])) {
            $Cruds->user_id = $data['user_id'];
        }
        if (!empty($data['Detail'])) {
            $Cruds->Detail = $data['Detail'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Cruds->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Cruds->creat_by = $data['creat_by'];
        }
        $Cruds->save();
        $Cruds = \App\Models\Crud::find($Cruds->id);
        $newCrudData = [];
        $newCrudData['action'] = $Cruds->action;
        $newCrudData['entite'] = $Cruds->entite;
        $newCrudData['entite_cle'] = $Cruds->entite_cle;
        $newCrudData['ancien'] = $Cruds->ancien;
        $newCrudData['nouveau'] = $Cruds->nouveau;
        $newCrudData['user_id'] = $Cruds->user_id;
        $newCrudData['Detail'] = $Cruds->Detail;
        $newCrudData['identifiants_sadge'] = $Cruds->identifiants_sadge;
        $newCrudData['creat_by'] = $Cruds->creat_by;
        try {
            $newCrudData['user'] = $Cruds->user->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Cruds', 'entite_cle' => $Cruds->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Cruds->toArray();
        return $data;
    }

}
