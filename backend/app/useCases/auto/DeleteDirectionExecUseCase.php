<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteDirectionExecUseCase
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

        $Directions = \App\Models\Direction::find($data['id']);


        $Directions->deleted_at = now();
        $Directions->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Directions->libelle;
        $newCrudData['code'] = $Directions->code;
        $newCrudData['groupedirection_id'] = $Directions->groupedirection_id;
        $newCrudData['identifiants_sadge'] = $Directions->identifiants_sadge;
        $newCrudData['creat_by'] = $Directions->creat_by;
        try {
            $newCrudData['groupedirection'] = $Directions->groupedirection->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Directions', 'entite_cle' => $Directions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
