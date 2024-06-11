<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateDirectionExecUseCase
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

        $Directions = new \App\Models\Direction();

        if (!empty($data['libelle'])) {
            $Directions->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Directions->code = $data['code'];
        }
        if (!empty($data['groupedirection_id'])) {
            $Directions->groupedirection_id = $data['groupedirection_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Directions->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Directions->creat_by = $data['creat_by'];
        }
        $Directions->save();
        $Directions = \App\Models\Direction::find($Directions->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Directions', 'entite_cle' => $Directions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Directions->toArray();
        return $data;
    }

}
