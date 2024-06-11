<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTypesheureExecUseCase
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

        $Typesheures = new \App\Models\Typesheure();

        if (!empty($data['code'])) {
            $Typesheures->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Typesheures->libelle = $data['libelle'];
        }
        if (!empty($data['description'])) {
            $Typesheures->description = $data['description'];
        }
        if (!empty($data['creat_by'])) {
            $Typesheures->creat_by = $data['creat_by'];
        }
        if (!empty($data['type'])) {
            $Typesheures->type = $data['type'];
        }
        $Typesheures->save();
        $Typesheures = \App\Models\Typesheure::find($Typesheures->id);
        $newCrudData = [];
        $newCrudData['code'] = $Typesheures->code;
        $newCrudData['libelle'] = $Typesheures->libelle;
        $newCrudData['description'] = $Typesheures->description;
        $newCrudData['creat_by'] = $Typesheures->creat_by;
        $newCrudData['type'] = $Typesheures->type;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Typesheures', 'entite_cle' => $Typesheures->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typesheures->toArray();
        return $data;
    }

}
