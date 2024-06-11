<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteImportExecUseCase
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

        $Imports = \App\Models\Import::find($data['id']);


        $Imports->deleted_at = now();
        $Imports->save();
        $newCrudData = [];
        $newCrudData['type'] = $Imports->type;
        $newCrudData['liaisons'] = $Imports->liaisons;
        $newCrudData['identifiant'] = $Imports->identifiant;
        $newCrudData['etats'] = $Imports->etats;
        $newCrudData['creat_by'] = $Imports->creat_by;
        $newCrudData['file'] = $Imports->file;
        $newCrudData['newtables'] = $Imports->newtables;
        $newCrudData['create'] = $Imports->create;
        $newCrudData['update'] = $Imports->update;
        $newCrudData['delete'] = $Imports->delete;
        $newCrudData['valider'] = $Imports->valider;
        $newCrudData['identifiants_sadge'] = $Imports->identifiants_sadge;
        $newCrudData['description'] = $Imports->description;
        $newCrudData['typesposte_id'] = $Imports->typesposte_id;
        $newCrudData['typeseffectif_id'] = $Imports->typeseffectif_id;
        $newCrudData['typespointage_id'] = $Imports->typespointage_id;
        $newCrudData['typespointages'] = $Imports->typespointages;
        try {
            $newCrudData['typeseffectif'] = $Imports->typeseffectif->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['typespointage'] = $Imports->typespointage->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['typesposte'] = $Imports->typesposte->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Imports', 'entite_cle' => $Imports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
