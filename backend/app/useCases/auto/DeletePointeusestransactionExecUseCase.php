<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeletePointeusestransactionExecUseCase
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

        $Pointeusestransactions = \App\Models\Pointeusestransaction::find($data['id']);


        $Pointeusestransactions->deleted_at = now();
        $Pointeusestransactions->save();
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Pointeusestransactions->transactions_totals;
        $newCrudData['transactions_heures'] = $Pointeusestransactions->transactions_heures;
        $newCrudData['transactions_id'] = $Pointeusestransactions->transactions_id;
        $newCrudData['date'] = $Pointeusestransactions->date;
        $newCrudData['pointeuse'] = $Pointeusestransactions->pointeuse;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Delete", 'entite' => 'Pointeusestransactions', 'entite_cle' => $Pointeusestransactions->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode([]), 'created_at' => now()]);
        $data['__result__'] = true;
        return $data;
    }

}
