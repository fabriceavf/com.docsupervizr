<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTypeseffectifExecUseCase
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

        $Typeseffectifs = \App\Models\Typeseffectif::find($data['id']);


        $Typeseffectifs->deleted_at = now();
        $Typeseffectifs->save();
        $newCrudData = [];
        $newCrudData['code'] = $Typeseffectifs->code;
        $newCrudData['libelle'] = $Typeseffectifs->libelle;
        $newCrudData['creat_by'] = $Typeseffectifs->creat_by;
        $newCrudData['canCreate'] = $Typeseffectifs->canCreate;
        $newCrudData['canUpdate'] = $Typeseffectifs->canUpdate;
        $newCrudData['canDelete'] = $Typeseffectifs->canDelete;
        $newCrudData['champHide'] = $Typeseffectifs->champHide;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Typeseffectifs', 'entite_cle' => $Typeseffectifs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
