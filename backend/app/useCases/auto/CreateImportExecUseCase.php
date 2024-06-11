<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateImportExecUseCase
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

        $Imports = new \App\Models\Import();

        if (!empty($data['type'])) {
            $Imports->type = $data['type'];
        }
        if (!empty($data['liaisons'])) {
            $Imports->liaisons = $data['liaisons'];
        }
        if (!empty($data['identifiant'])) {
            $Imports->identifiant = $data['identifiant'];
        }
        if (!empty($data['etats'])) {
            $Imports->etats = $data['etats'];
        }
        if (!empty($data['creat_by'])) {
            $Imports->creat_by = $data['creat_by'];
        }
        if (!empty($data['file'])) {
            $Imports->file = $data['file'];
        }
        if (!empty($data['newtables'])) {
            $Imports->newtables = $data['newtables'];
        }
        if (!empty($data['create'])) {
            $Imports->create = $data['create'];
        }
        if (!empty($data['update'])) {
            $Imports->update = $data['update'];
        }
        if (!empty($data['delete'])) {
            $Imports->delete = $data['delete'];
        }
        if (!empty($data['valider'])) {
            $Imports->valider = $data['valider'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Imports->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['description'])) {
            $Imports->description = $data['description'];
        }
        if (!empty($data['typesposte_id'])) {
            $Imports->typesposte_id = $data['typesposte_id'];
        }
        if (!empty($data['typeseffectif_id'])) {
            $Imports->typeseffectif_id = $data['typeseffectif_id'];
        }
        if (!empty($data['typespointage_id'])) {
            $Imports->typespointage_id = $data['typespointage_id'];
        }
        if (!empty($data['typespointages'])) {
            $Imports->typespointages = $data['typespointages'];
        }
        $Imports->save();
        $Imports = \App\Models\Import::find($Imports->id);
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Imports', 'entite_cle' => $Imports->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Imports->toArray();
        return $data;
    }

}
