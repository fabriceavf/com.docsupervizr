<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTransactionsulterieurExecUseCase
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

        $Transactionsulterieurs = new \App\Models\Transactionsulterieur();

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
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Transactionsulterieurs', 'entite_cle' => $Transactionsulterieurs->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionsulterieurs->toArray();
        return $data;
    }

}
