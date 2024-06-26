<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdatePointeusestransactionExecUseCase
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
        $oldPointeusestransactions = $Pointeusestransactions->replicate();

        $oldCrudData = [];
        $oldCrudData['transactions_totals'] = $oldPointeusestransactions->transactions_totals;
        $oldCrudData['transactions_heures'] = $oldPointeusestransactions->transactions_heures;
        $oldCrudData['transactions_id'] = $oldPointeusestransactions->transactions_id;
        $oldCrudData['date'] = $oldPointeusestransactions->date;
        $oldCrudData['pointeuse'] = $oldPointeusestransactions->pointeuse;


        if (!empty($data['transactions_totals'])) {
            $Pointeusestransactions->transactions_totals = $data['transactions_totals'];
        }
        if (!empty($data['transactions_heures'])) {
            $Pointeusestransactions->transactions_heures = $data['transactions_heures'];
        }
        if (!empty($data['transactions_id'])) {
            $Pointeusestransactions->transactions_id = $data['transactions_id'];
        }
        if (!empty($data['date'])) {
            $Pointeusestransactions->date = $data['date'];
        }
        if (!empty($data['pointeuse'])) {
            $Pointeusestransactions->pointeuse = $data['pointeuse'];
        }
        $Pointeusestransactions->save();
        $Pointeusestransactions = \App\Models\Pointeusestransaction::find($Pointeusestransactions->id);
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Pointeusestransactions->transactions_totals;
        $newCrudData['transactions_heures'] = $Pointeusestransactions->transactions_heures;
        $newCrudData['transactions_id'] = $Pointeusestransactions->transactions_id;
        $newCrudData['date'] = $Pointeusestransactions->date;
        $newCrudData['pointeuse'] = $Pointeusestransactions->pointeuse;
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Update", 'entite' => 'Pointeusestransactions', 'entite_cle' => $Pointeusestransactions->id, 'ancien' => json_encode($oldCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Pointeusestransactions->toArray();
        return $data;
    }

}
