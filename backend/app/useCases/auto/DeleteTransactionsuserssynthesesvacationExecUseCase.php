<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransactionsuserssynthesesvacationExecUseCase
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

        $Transactionsuserssynthesesvacations = \App\Models\Transactionsuserssynthesesvacation::find($data['id']);


        $Transactionsuserssynthesesvacations->deleted_at = now();
        $Transactionsuserssynthesesvacations->save();
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Transactionsuserssynthesesvacations->transactions_totals;
        $newCrudData['matricule'] = $Transactionsuserssynthesesvacations->matricule;
        $newCrudData['transactions_id'] = $Transactionsuserssynthesesvacations->transactions_id;
        $newCrudData['transactions_heures'] = $Transactionsuserssynthesesvacations->transactions_heures;
        $newCrudData['date'] = $Transactionsuserssynthesesvacations->date;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transactionsuserssynthesesvacations', 'entite_cle' => $Transactionsuserssynthesesvacations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
