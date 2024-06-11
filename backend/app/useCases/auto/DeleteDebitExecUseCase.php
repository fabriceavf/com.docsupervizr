<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteDebitExecUseCase
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

        $Debits = \App\Models\Debit::find($data['id']);


        $Debits->deleted_at = now();
        $Debits->save();
        $newCrudData = [];
        $newCrudData['identification_id'] = $Debits->identification_id;
        $newCrudData['montant'] = $Debits->montant;
        $newCrudData['creat_by'] = $Debits->creat_by;
        try {
            $newCrudData['identification'] = $Debits->identification->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Debits', 'entite_cle' => $Debits->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
