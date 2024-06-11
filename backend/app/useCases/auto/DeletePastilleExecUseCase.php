<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePastilleExecUseCase
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

        $Pastilles = \App\Models\Pastille::find($data['id']);


        $Pastilles->deleted_at = now();
        $Pastilles->save();
        $newCrudData = [];
        $newCrudData['code'] = $Pastilles->code;
        $newCrudData['libelle'] = $Pastilles->libelle;
        $newCrudData['site_id'] = $Pastilles->site_id;
        $newCrudData['creat_by'] = $Pastilles->creat_by;
        $newCrudData['identifiants_sadge'] = $Pastilles->identifiants_sadge;
        try {
            $newCrudData['site'] = $Pastilles->site->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Pastilles', 'entite_cle' => $Pastilles->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
