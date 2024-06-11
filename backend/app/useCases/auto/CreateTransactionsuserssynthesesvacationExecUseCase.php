<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTransactionsuserssynthesesvacationExecUseCase
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

        $Transactionsuserssynthesesvacations = new \App\Models\Transactionsuserssynthesesvacation();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Transactionsuserssynthesesvacations', 'entite_cle' => $Transactionsuserssynthesesvacations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionsuserssynthesesvacations->toArray();
        return $data;
    }

}
