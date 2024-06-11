<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransactionssyntheseExecUseCase
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

        $Transactionssyntheses = \App\Models\Transactionssynthese::find($data['id']);


        $Transactionssyntheses->deleted_at = now();
        $Transactionssyntheses->save();
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Transactionssyntheses->transactions_totals;
        $newCrudData['transactions_heures'] = $Transactionssyntheses->transactions_heures;
        $newCrudData['transactions_id'] = $Transactionssyntheses->transactions_id;
        $newCrudData['matricule'] = $Transactionssyntheses->matricule;
        $newCrudData['date'] = $Transactionssyntheses->date;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transactionssyntheses', 'entite_cle' => $Transactionssyntheses->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
