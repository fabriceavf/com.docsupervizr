<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateDetailExecUseCase
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

        $Details = new \App\Models\Detail();

        if (!empty($data['libelle'])) {
            $Details->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Details->description = $data['description'];
        }
        if (!empty($data['order'])) {
            $Details->order = $data['order'];
        }
        if (!empty($data['processu_id'])) {
            $Details->processu_id = $data['processu_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Details->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Details->creat_by = $data['creat_by'];
        }
        $Details->save();
        $Details = \App\Models\Detail::find($Details->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Details->libelle;
        $newCrudData['description'] = $Details->description;
        $newCrudData['order'] = $Details->order;
        $newCrudData['processu_id'] = $Details->processu_id;
        $newCrudData['identifiants_sadge'] = $Details->identifiants_sadge;
        $newCrudData['creat_by'] = $Details->creat_by;
        try {
            $newCrudData['processu'] = $Details->processu->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Details', 'entite_cle' => $Details->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Details->toArray();
        return $data;
    }

}
