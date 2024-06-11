<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTransactionsuserssyntheseExecUseCase
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

        $Transactionsuserssyntheses = \App\Models\Transactionsuserssynthese::find($data['id']);
        $oldTransactionsuserssyntheses = $Transactionsuserssyntheses->replicate();

        $oldCrudData = [];
        $oldCrudData['transactions_totals'] = $oldTransactionsuserssyntheses->transactions_totals;
        $oldCrudData['transactions_id'] = $oldTransactionsuserssyntheses->transactions_id;
        $oldCrudData['transactions_heures'] = $oldTransactionsuserssyntheses->transactions_heures;
        $oldCrudData['matricule'] = $oldTransactionsuserssyntheses->matricule;
        $oldCrudData['date'] = $oldTransactionsuserssyntheses->date;


        if (!empty($data['transactions_totals'])) {
            $Transactionsuserssyntheses->transactions_totals = $data['transactions_totals'];
        }
        if (!empty($data['transactions_id'])) {
            $Transactionsuserssyntheses->transactions_id = $data['transactions_id'];
        }
        if (!empty($data['transactions_heures'])) {
            $Transactionsuserssyntheses->transactions_heures = $data['transactions_heures'];
        }
        if (!empty($data['matricule'])) {
            $Transactionsuserssyntheses->matricule = $data['matricule'];
        }
        if (!empty($data['date'])) {
            $Transactionsuserssyntheses->date = $data['date'];
        }
        $Transactionsuserssyntheses->save();
        $Transactionsuserssyntheses = \App\Models\Transactionsuserssynthese::find($Transactionsuserssyntheses->id);
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Transactionsuserssyntheses->transactions_totals;
        $newCrudData['transactions_id'] = $Transactionsuserssyntheses->transactions_id;
        $newCrudData['transactions_heures'] = $Transactionsuserssyntheses->transactions_heures;
        $newCrudData['matricule'] = $Transactionsuserssyntheses->matricule;
        $newCrudData['date'] = $Transactionsuserssyntheses->date;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Transactionsuserssyntheses', 'entite_cle' => $Transactionsuserssyntheses->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionsuserssyntheses->toArray();
        return $data;
    }

}
