<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteEtapeExecUseCase
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

        $Etapes = \App\Models\Etape::find($data['id']);


        $Etapes->deleted_at = now();
        $Etapes->save();
        $newCrudData = [];
        $newCrudData['libelle'] = $Etapes->libelle;
        $newCrudData['ordre'] = $Etapes->ordre;
        $newCrudData['ligne_id'] = $Etapes->ligne_id;
        $newCrudData['creat_by'] = $Etapes->creat_by;
        $newCrudData['identifiants_sadge'] = $Etapes->identifiants_sadge;
        try {
            $newCrudData['ligne'] = $Etapes->ligne->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Etapes', 'entite_cle' => $Etapes->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
