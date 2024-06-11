<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePreuveExecUseCase
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

        $Preuves = \App\Models\Preuve::find($data['id']);
        $oldPreuves = $Preuves->replicate();

        $oldCrudData = [];
        $oldCrudData['programme_id'] = $oldPreuves->programme_id;
        $oldCrudData['transaction_id'] = $oldPreuves->transaction_id;
        $oldCrudData['punch_time'] = $oldPreuves->punch_time;
        $oldCrudData['type'] = $oldPreuves->type;
        $oldCrudData['role'] = $oldPreuves->role;
        $oldCrudData['etats'] = $oldPreuves->etats;
        $oldCrudData['valide'] = $oldPreuves->valide;
        $oldCrudData['remarque'] = $oldPreuves->remarque;
        $oldCrudData['identifiants_sadge'] = $oldPreuves->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldPreuves->creat_by;
        try {
            $oldCrudData['programme'] = $oldPreuves->programme->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $oldCrudData['transaction'] = $oldPreuves->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['programme_id'])) {
            $Preuves->programme_id = $data['programme_id'];
        }
        if (!empty($data['transaction_id'])) {
            $Preuves->transaction_id = $data['transaction_id'];
        }
        if (!empty($data['punch_time'])) {
            $Preuves->punch_time = $data['punch_time'];
        }
        if (!empty($data['type'])) {
            $Preuves->type = $data['type'];
        }
        if (!empty($data['role'])) {
            $Preuves->role = $data['role'];
        }
        if (!empty($data['etats'])) {
            $Preuves->etats = $data['etats'];
        }
        if (!empty($data['valide'])) {
            $Preuves->valide = $data['valide'];
        }
        if (!empty($data['remarque'])) {
            $Preuves->remarque = $data['remarque'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Preuves->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Preuves->creat_by = $data['creat_by'];
        }
        $Preuves->save();
        $Preuves = \App\Models\Preuve::find($Preuves->id);
        $newCrudData = [];
        $newCrudData['programme_id'] = $Preuves->programme_id;
        $newCrudData['transaction_id'] = $Preuves->transaction_id;
        $newCrudData['punch_time'] = $Preuves->punch_time;
        $newCrudData['type'] = $Preuves->type;
        $newCrudData['role'] = $Preuves->role;
        $newCrudData['etats'] = $Preuves->etats;
        $newCrudData['valide'] = $Preuves->valide;
        $newCrudData['remarque'] = $Preuves->remarque;
        $newCrudData['identifiants_sadge'] = $Preuves->identifiants_sadge;
        $newCrudData['creat_by'] = $Preuves->creat_by;
        try {
            $newCrudData['programme'] = $Preuves->programme->Selectlabel;
        } catch (\Throwable $e) {
        }
        try {
            $newCrudData['transaction'] = $Preuves->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Preuves', 'entite_cle' => $Preuves->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Preuves->toArray();
        return $data;
    }

}
