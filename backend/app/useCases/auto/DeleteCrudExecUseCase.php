<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteCrudExecUseCase
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


        $Cruds->deleted_at = now();
        $Cruds->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Cruds', 'entite_cle' => $Cruds->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
