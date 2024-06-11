<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTransactionsuserssynthesesvacationExecUseCase
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
        $oldTransactionsuserssynthesesvacations = $Transactionsuserssynthesesvacations->replicate();

        $oldCrudData = [];
        $oldCrudData['transactions_totals'] = $oldTransactionsuserssynthesesvacations->transactions_totals;
        $oldCrudData['matricule'] = $oldTransactionsuserssynthesesvacations->matricule;
        $oldCrudData['transactions_id'] = $oldTransactionsuserssynthesesvacations->transactions_id;
        $oldCrudData['transactions_heures'] = $oldTransactionsuserssynthesesvacations->transactions_heures;
        $oldCrudData['date'] = $oldTransactionsuserssynthesesvacations->date;


        if (!empty($data['transactions_totals'])) {
            $Transactionsuserssynthesesvacations->transactions_totals = $data['transactions_totals'];
        }
        if (!empty($data['matricule'])) {
            $Transactionsuserssynthesesvacations->matricule = $data['matricule'];
        }
        if (!empty($data['transactions_id'])) {
            $Transactionsuserssynthesesvacations->transactions_id = $data['transactions_id'];
        }
        if (!empty($data['transactions_heures'])) {
            $Transactionsuserssynthesesvacations->transactions_heures = $data['transactions_heures'];
        }
        if (!empty($data['date'])) {
            $Transactionsuserssynthesesvacations->date = $data['date'];
        }
        $Transactionsuserssynthesesvacations->save();
        $Transactionsuserssynthesesvacations = \App\Models\Transactionsuserssynthesesvacation::find($Transactionsuserssynthesesvacations->id);
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Transactionsuserssynthesesvacations->transactions_totals;
        $newCrudData['matricule'] = $Transactionsuserssynthesesvacations->matricule;
        $newCrudData['transactions_id'] = $Transactionsuserssynthesesvacations->transactions_id;
        $newCrudData['transactions_heures'] = $Transactionsuserssynthesesvacations->transactions_heures;
        $newCrudData['date'] = $Transactionsuserssynthesesvacations->date;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Transactionsuserssynthesesvacations', 'entite_cle' => $Transactionsuserssynthesesvacations->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionsuserssynthesesvacations->toArray();
        return $data;
    }

}
