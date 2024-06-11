<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateTransactionsulterieurExecUseCase
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

        $Transactionsulterieurs = \App\Models\Transactionsulterieur::find($data['id']);
        $oldTransactionsulterieurs = $Transactionsulterieurs->replicate();

        $oldCrudData = [];
        $oldCrudData['date'] = $oldTransactionsulterieurs->date;
        $oldCrudData['transaction_id'] = $oldTransactionsulterieurs->transaction_id;
        $oldCrudData['identifiants_sadge'] = $oldTransactionsulterieurs->identifiants_sadge;
        $oldCrudData['creat_by'] = $oldTransactionsulterieurs->creat_by;
        try {
            $oldCrudData['transaction'] = $oldTransactionsulterieurs->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }

        if (!empty($data['date'])) {
            $Transactionsulterieurs->date = $data['date'];
        }
        if (!empty($data['transaction_id'])) {
            $Transactionsulterieurs->transaction_id = $data['transaction_id'];
        }
        if (!empty($data['identifiants_sadge'])) {
            $Transactionsulterieurs->identifiants_sadge = $data['identifiants_sadge'];
        }
        if (!empty($data['creat_by'])) {
            $Transactionsulterieurs->creat_by = $data['creat_by'];
        }
        $Transactionsulterieurs->save();
        $Transactionsulterieurs = \App\Models\Transactionsulterieur::find($Transactionsulterieurs->id);
        $newCrudData = [];
        $newCrudData['date'] = $Transactionsulterieurs->date;
        $newCrudData['transaction_id'] = $Transactionsulterieurs->transaction_id;
        $newCrudData['identifiants_sadge'] = $Transactionsulterieurs->identifiants_sadge;
        $newCrudData['creat_by'] = $Transactionsulterieurs->creat_by;
        try {
            $newCrudData['transaction'] = $Transactionsulterieurs->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Transactionsulterieurs', 'entite_cle' => $Transactionsulterieurs->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionsulterieurs->toArray();
        return $data;
    }

}
