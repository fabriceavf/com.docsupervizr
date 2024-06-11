<?php

namespace App\useCases\auto;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTransactionspostessynthesesvacationExecUseCase
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

        $Transactionspostessynthesesvacations = new \App\Models\Transactionspostessynthesesvacation();

        if (!empty($data['transactions_totals'])) {
            $Transactionspostessynthesesvacations->transactions_totals = $data['transactions_totals'];
        }
        if (!empty($data['poste_id'])) {
            $Transactionspostessynthesesvacations->poste_id = $data['poste_id'];
        }
        if (!empty($data['transactions_id'])) {
            $Transactionspostessynthesesvacations->transactions_id = $data['transactions_id'];
        }
        if (!empty($data['transactions_heures'])) {
            $Transactionspostessynthesesvacations->transactions_heures = $data['transactions_heures'];
        }
        if (!empty($data['date'])) {
            $Transactionspostessynthesesvacations->date = $data['date'];
        }
        $Transactionspostessynthesesvacations->save();
        $Transactionspostessynthesesvacations = \App\Models\Transactionspostessynthesesvacation::find($Transactionspostessynthesesvacations->id);
        $newCrudData = [];
        $newCrudData['transactions_totals'] = $Transactionspostessynthesesvacations->transactions_totals;
        $newCrudData['poste_id'] = $Transactionspostessynthesesvacations->poste_id;
        $newCrudData['transactions_id'] = $Transactionspostessynthesesvacations->transactions_id;
        $newCrudData['transactions_heures'] = $Transactionspostessynthesesvacations->transactions_heures;
        $newCrudData['date'] = $Transactionspostessynthesesvacations->date;
        try {
            $newCrudData['poste'] = $Transactionspostessynthesesvacations->poste->Selectlabel;
        } catch (\Throwable $e) {
        }
        DB::table('cruds')->insert(['user_id' => Auth::id(), 'action' => "Create", 'entite' => 'Transactionspostessynthesesvacations', 'entite_cle' => $Transactionspostessynthesesvacations->id, 'ancien' => json_encode($newCrudData), 'nouveau' => json_encode($newCrudData), 'created_at' => now()]);
        $data['__result__'] = $Transactionspostessynthesesvacations->toArray();
        return $data;
    }

}
