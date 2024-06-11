<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTransactionhistoriqueExecUseCase
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
        $oldTransactionhistoriques = $Transactionhistoriques->replicate();

        $oldCrudData = [];
        $oldCrudData['depuis'] = $oldTransactionhistoriques->depuis;
        $oldCrudData['transaction_id'] = $oldTransactionhistoriques->transaction_id;
        $oldCrudData['identifiants_sadge'] = $oldTransactionhistoriques->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldTransactionhistoriques->creat_by;
        try {
            $oldCrudData['transaction'] = $oldTransactionhistoriques->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['depuis'])) {
            $Transactionhistoriques->depuis = $data['depuis'];
        }
        if (!empty($data['transaction_id'])) {
            $Transactionhistoriques->transaction_id = $data['transaction_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Transactionhistoriques->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Transactionhistoriques->creat_by = $data['creat_by'];
        }
        $Transactionhistoriques->save();
        $Transactionhistoriques = \App\Models\Transactionhistorique::find($Transactionhistoriques->id);
        $newCrudData = [];
        $newCrudData['depuis'] = $Transactionhistoriques->depuis;
        $newCrudData['transaction_id'] = $Transactionhistoriques->transaction_id;
        $newCrudData['identifiants_sadge'] = $Transactionhistoriques->identifiants_sadge;
        $newCrudData['creat_by'] = $Transactionhistoriques->creat_by;
        try {
            $newCrudData['transaction'] = $Transactionhistoriques->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Transactionhistoriques', 'entite_cle' => $Transactionhistoriques->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionhistoriques->toArray();
        return $data;
    }

}
