<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTransactionssyntheseExecUseCase
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

        $Transactionssyntheses = new \App\Models\Transactionssynthese();

        if (!empty($data['transactions_totals'])) {
            $Transactionssyntheses->transactions_totals = $data['transactions_totals'];
        }
        if (!empty($data['transactions_heures'])) {
            $Transactionssyntheses->transactions_heures = $data['transactions_heures'];
        }
        if (!empty($data['transactions_id'])) {
            $Transactionssyntheses->transactions_id = $data['transactions_id'];
        }
        if (!empty($data['matricule'])) {
            $Transactionssyntheses->matricule = $data['matricule'];
        }
        if (!empty($data['date'])) {
            $Transactionssyntheses->date = $data['date'];
        }
        $Transactionssyntheses->save();
        $Transactionssyntheses = \App\Models\Transactionssynthese::find($Transactionssyntheses->id);
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Transactionssyntheses->transactions_totals;
        $newCrudData['transactions_heures'] = $Transactionssyntheses->transactions_heures;
        $newCrudData['transactions_id'] = $Transactionssyntheses->transactions_id;
        $newCrudData['matricule'] = $Transactionssyntheses->matricule;
        $newCrudData['date'] = $Transactionssyntheses->date;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Transactionssyntheses', 'entite_cle' => $Transactionssyntheses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionssyntheses->toArray();
        return $data;
    }

}
