<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransactionspostessynthesesvacationExecUseCase
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

        $Transactionspostessynthesesvacations = \App\Models\Transactionspostessynthesesvacation::find($data['id']);


        $Transactionspostessynthesesvacations->deleted_at = now();
        $Transactionspostessynthesesvacations->save();
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Transactionspostessynthesesvacations->transactions_totals;
        $newCrudData['poste_id'] = $Transactionspostessynthesesvacations->poste_id;
        $newCrudData['transactions_id'] = $Transactionspostessynthesesvacations->transactions_id;
        $newCrudData['transactions_heures'] = $Transactionspostessynthesesvacations->transactions_heures;
        $newCrudData['date'] = $Transactionspostessynthesesvacations->date;
        try {
            $newCrudData['poste'] = $Transactionspostessynthesesvacations->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transactionspostessynthesesvacations', 'entite_cle' => $Transactionspostessynthesesvacations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
