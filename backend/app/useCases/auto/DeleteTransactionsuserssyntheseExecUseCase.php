<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransactionsuserssyntheseExecUseCase
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


        $Transactionsuserssyntheses->deleted_at = now();
        $Transactionsuserssyntheses->save();
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Transactionsuserssyntheses->transactions_totals;
        $newCrudData['transactions_id'] = $Transactionsuserssyntheses->transactions_id;
        $newCrudData['transactions_heures'] = $Transactionsuserssyntheses->transactions_heures;
        $newCrudData['matricule'] = $Transactionsuserssyntheses->matricule;
        $newCrudData['date'] = $Transactionsuserssyntheses->date;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transactionsuserssyntheses', 'entite_cle' => $Transactionsuserssyntheses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
