<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateCategorieExecUseCase
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

        $Categories = \App\Models\Categorie::find($data['id']);
        $oldCategories = $Categories->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldCategories->libelle;
        $oldCrudData['code'] = $oldCategories->code;
        $oldCrudData['identifiants_sadge'] = $oldCategories->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldCategories->creat_by;


        if (!empty($data['libelle'])) {
            $Categories->libelle = $data['libelle'];
        }
        if (!empty($data['code'])) {
            $Categories->code = $data['code'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Categories->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Categories->creat_by = $data['creat_by'];
        }
        $Categories->save();
        $Categories = \App\Models\Categorie::find($Categories->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Categories->libelle;
        $newCrudData['code'] = $Categories->code;
        $newCrudData['identifiants_sadge'] = $Categories->identifiants_sadge;
        $newCrudData['creat_by'] = $Categories->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Categories', 'entite_cle' => $Categories->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Categories->toArray();
        return $data;
    }

}
