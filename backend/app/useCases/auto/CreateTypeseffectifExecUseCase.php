<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTypeseffectifExecUseCase
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

        $Typeseffectifs = new \App\Models\Typeseffectif();

        if (!empty($data['code'])) {
            $Typeseffectifs->code = $data['code'];
        }
        if (!empty($data['libelle'])) {
            $Typeseffectifs->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Typeseffectifs->creat_by = $data['creat_by'];
        }
        if (!empty($data['canCreate'])) {
            $Typeseffectifs->canCreate = $data['canCreate'];
        }
        if (!empty($data['canUpdate'])) {
            $Typeseffectifs->canUpdate = $data['canUpdate'];
        }
        if (!empty($data['canDelete'])) {
            $Typeseffectifs->canDelete = $data['canDelete'];
        }
        if (!empty($data['champHide'])) {
            $Typeseffectifs->champHide = $data['champHide'];
        }
        $Typeseffectifs->save();
        $Typeseffectifs = \App\Models\Typeseffectif::find($Typeseffectifs->id);
        $newCrudData = [];
        $newCrudData['code'] = $Typeseffectifs->code;
        $newCrudData['libelle'] = $Typeseffectifs->libelle;
        $newCrudData['creat_by'] = $Typeseffectifs->creat_by;
        $newCrudData['canCreate'] = $Typeseffectifs->canCreate;
        $newCrudData['canUpdate'] = $Typeseffectifs->canUpdate;
        $newCrudData['canDelete'] = $Typeseffectifs->canDelete;
        $newCrudData['champHide'] = $Typeseffectifs->champHide;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Typeseffectifs', 'entite_cle' => $Typeseffectifs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typeseffectifs->toArray();
        return $data;
    }

}
