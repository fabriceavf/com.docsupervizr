<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteTransactionsulterieurExecUseCase
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


        $Transactionsulterieurs->deleted_at = now();
        $Transactionsulterieurs->save();
        $newCrudData = [];
        $newCrudData['date'] = $Transactionsulterieurs->date;
        $newCrudData['transaction_id'] = $Transactionsulterieurs->transaction_id;
        $newCrudData['identifiants_sadge'] = $Transactionsulterieurs->identifiants_sadge;
        $newCrudData['creat_by'] = $Transactionsulterieurs->creat_by;
        try {
            $newCrudData['transaction'] = $Transactionsulterieurs->transaction->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Transactionsulterieurs', 'entite_cle' => $Transactionsulterieurs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
