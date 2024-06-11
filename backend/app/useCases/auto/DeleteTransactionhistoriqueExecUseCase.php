<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransactionhistoriqueExecUseCase
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

        $Transactionhistoriques = \App\Models\Transactionhistorique::find($data['id']);


        $Transactionhistoriques->deleted_at = now();
        $Transactionhistoriques->save();
        $newCrudData = [];
        $newCrudData['depuis'] = $Transactionhistoriques->depuis;
        $newCrudData['transaction_id'] = $Transactionhistoriques->transaction_id;
        $newCrudData['identifiants_sadge'] = $Transactionhistoriques->identifiants_sadge;
        $newCrudData['creat_by'] = $Transactionhistoriques->creat_by;
        try {
            $newCrudData['transaction'] = $Transactionhistoriques->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transactionhistoriques', 'entite_cle' => $Transactionhistoriques->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
