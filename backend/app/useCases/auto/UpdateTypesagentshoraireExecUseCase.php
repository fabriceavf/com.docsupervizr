<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTypesagentshoraireExecUseCase
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

        $Typesagentshoraires = \App\Models\Typesagentshoraire::find($data['id']);
        $oldTypesagentshoraires = $Typesagentshoraires->replicate();

        $oldCrudData = [];
        $oldCrudData['libelle'] = $oldTypesagentshoraires->libelle;
        $oldCrudData['creat_by'] = $oldTypesagentshoraires->creat_by;


        if (!empty($data['libelle'])) {
            $Typesagentshoraires->libelle = $data['libelle'];
        }
        if (!empty($data['creat_by'])) {
            $Typesagentshoraires->creat_by = $data['creat_by'];
        }
        $Typesagentshoraires->save();
        $Typesagentshoraires = \App\Models\Typesagentshoraire::find($Typesagentshoraires->id);
        $newCrudData = [];
        $newCrudData['libelle'] = $Typesagentshoraires->libelle;
        $newCrudData['creat_by'] = $Typesagentshoraires->creat_by;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Typesagentshoraires', 'entite_cle' => $Typesagentshoraires->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Typesagentshoraires->toArray();
        return $data;
    }

}
