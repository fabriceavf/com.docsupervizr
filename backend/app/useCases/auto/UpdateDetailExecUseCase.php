<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateDetailExecUseCase
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

        $Details = \App\Models\Detail::find($data['id']);
        $oldDetails = $Details->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldDetails->libelle;
        $oldCrudData['description'] = $oldDetails->description;
        $oldCrudData['order'] = $oldDetails->order;
        $oldCrudData['processu_id'] = $oldDetails->processu_id;
        $oldCrudData['identifiants_sadge'] = $oldDetails->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldDetails->creat_by;
        try {
            $oldCrudData['processu'] = $oldDetails->processu->Selectlabel;
        } catch (\Throwable $e) {
        }

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Details', 'entite_cle' => $Details->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Details->toArray();
        return $data;
    }

}
