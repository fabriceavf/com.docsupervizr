<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTypeseffectifExecUseCase
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
        $oldTypeseffectifs = $Typeseffectifs->replicate();

        $oldCrudData = [];
        $oldCrudData['code'] = $oldTypeseffectifs->code;
        $oldCrudData['libelle'] = $oldTypeseffectifs->libelle;
        $oldCrudData['creat_by'] = $oldTypeseffectifs->creat_by;
        $oldCrudData['canCreate'] = $oldTypeseffectifs->canCreate;
        $oldCrudData['canUpdate'] = $oldTypeseffectifs->canUpdate;
        $oldCrudData['canDelete'] = $oldTypeseffectifs->canDelete;
        $oldCrudData['champHide'] = $oldTypeseffectifs->champHide;


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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Typeseffectifs', 'entite_cle' => $Typeseffectifs->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typeseffectifs->toArray();
        return $data;
    }

}
