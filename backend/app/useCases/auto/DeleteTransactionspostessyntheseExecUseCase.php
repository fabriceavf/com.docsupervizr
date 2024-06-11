<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransactionspostessyntheseExecUseCase
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

        $Transactionspostessyntheses = \App\Models\Transactionspostessynthese::find($data['id']);


        $Transactionspostessyntheses->deleted_at = now();
        $Transactionspostessyntheses->save();
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Transactionspostessyntheses->transactions_totals;
        $newCrudData['transactions_id'] = $Transactionspostessyntheses->transactions_id;
        $newCrudData['transactions_matricule'] = $Transactionspostessyntheses->transactions_matricule;
        $newCrudData['transactions_heures'] = $Transactionspostessyntheses->transactions_heures;
        $newCrudData['date'] = $Transactionspostessyntheses->date;
        $newCrudData['poste_id'] = $Transactionspostessyntheses->poste_id;
        try {
            $newCrudData['poste'] = $Transactionspostessyntheses->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transactionspostessyntheses', 'entite_cle' => $Transactionspostessyntheses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
