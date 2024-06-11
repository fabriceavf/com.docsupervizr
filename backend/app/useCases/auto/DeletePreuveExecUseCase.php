<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePreuveExecUseCase
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


        $Preuves->deleted_at = now();
        $Preuves->save();
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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Preuves', 'entite_cle' => $Preuves->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
